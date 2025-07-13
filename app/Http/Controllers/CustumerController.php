<?php

namespace App\Http\Controllers;

use App\Helpers\AnalyticalHierarchyProcess;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\CriteriaComparison;
use App\Models\CriteriaWeight;
use App\Models\History;
use App\Models\HistoryAlternatifValue;
use App\Models\HistoryWeightNormalization;
use App\Models\SubCriteria;
use App\Models\TravelCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CustumerController extends Controller
{

    // startn private function
    // menghitung jarak menggunakan haversine formula
    private function haversine($lat1, $lon1, $lat2, $lon2){
        $radiusBumi = 6371; //radius bumi dalam km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        $jarak = $radiusBumi * $c; //jarak dalam km
        return $jarak;
    }

    // normalisasi cost
    private function cost($Xmin, $Xij){
        $Rij = $Xmin/$Xij;
        return $Rij;
    }

    // normalisasi benefit
    private function benefit($Xij, $Xmax){
        $Rij = $Xij/$Xmax;
        return $Rij;
    }
    // end private  function

    /**
     * Display a listing of the resource.
     */
    public function Wisataindex()
    {
        $data = Alternative::where('status', 'accepted')->get();
        return view('pages.custumer-page.wisata.index', [
            'title' => 'Home',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function rekomendasiCreate()
    {
        $data = Criteria::where('is_include', true)->get();
        $isIncludeJarak = Criteria::where('name', 'Jarak Tempuh')->where('is_include', true)->exists();
        $travelCategory = TravelCategory::all();
        return view('pages.custumer-page.decision.create', [
            'title' => 'Rekomendasi',
            'data' => $data,
            'isIncludeJarak' => $isIncludeJarak,
            'travelCategory' => $travelCategory,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function rekomendasiStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            // cast to int before filter alternatif data
            $dataAwalAlternatif = Alternative::where('status', 'accepted')->get();
            $dataCriteria = Criteria::where('is_include', true)->get();
            $isIncludeJarak = Criteria::where('name', 'Jarak Tempuh')->where('is_include', true)->exists();

            if ($isIncludeJarak) {
                $request->validate([
                    'lokasi_user' => 'required',
                ]);
            }

            // filterisasi alternatif
            $criteriaId=[];
            $subCriteriaId=[];
            foreach ($data['kriteria_id'] as $key => $criId) {
                if ($data['sub_criteria_id'][$key] == 'All') {
                    continue;
                }
                $criteriaId[] = (int) $criId;
                $subCriteriaId[] = (int) ($data['sub_criteria_id'][$key]);
            }

            $dataAlternatif = $dataAwalAlternatif;
            if (!empty($criteriaId) && !empty($subCriteriaId)) {
                if ($request->travel_category_id) {
                    # code...
                    $dataAfterFilter1 = Alternative::where('travel_category_id', $request->travel_category_id)->whereHas('performanceRatings', function ($query) use ($criteriaId, $subCriteriaId) {
                       $query->where('criteria_id', $criteriaId[0])->where('sub_criteria_id', $subCriteriaId[0]);
                    })->with('performanceRatings')->get();
                }else{
                    // filter alternatif data
                    $dataAfterFilter1 = Alternative::whereHas('performanceRatings', function ($query) use ($criteriaId, $subCriteriaId) {
                       $query->where('criteria_id', $criteriaId[0])->where('sub_criteria_id', $subCriteriaId[0]);
                    })->with('performanceRatings')->get();
                }
                $dataAltAfterFilter = $dataAfterFilter1;
                foreach ($criteriaId as $key => $criId) {
                    if ($key == 0) {
                        continue;
                    }
                    $dataAltAfterFilter =  $dataAltAfterFilter->filter(function ($item) use ($criId, $subCriteriaId, $key) {
                        $checkIfExist = $item->performanceRatings->first(function ($pr) use ($criId, $subCriteriaId, $key){
                            return $pr->criteria_id === $criId && $pr->sub_criteria_id === $subCriteriaId[$key];
                        });

                        if ($checkIfExist) {
                            return $item;
                        }
                    });
                }
                $dataAlternatif = $dataAltAfterFilter;
            }
            // end filter alternatif data

            if ($dataAlternatif->isEmpty()) {
                DB::rollBack();
                return back()->with('error', 'Maaf, Tidak Ada Alternatif Yang Sesuai dengan Kriteria Anda');
            }

            if ($isIncludeJarak && $request->lokasi_user) {
                // menghitung jarak pengguna dan objek wisata
                // latlon lokasi pengguna
                $lokasiPengguna = explode(',', $request->lokasi_user);
                $latPengguna = $lokasiPengguna[0] ?? 0;
                $lonPengguna = $lokasiPengguna[1] ?? 0;
                if (!$latPengguna || !$lonPengguna) {
                    return back()->with('success', 'format lokasi keberangkatan tidak valid, format = latitude, longitude');
                }
            }

            $arrA=[];
            foreach ($dataAlternatif as $key => $alt) {
                if ($isIncludeJarak && $request->lokasi_user) {
                    // lokasi wisata
                    $lokasiWisata = explode(',', $alt->maps_lokasi);
                    $latWisata = $lokasiWisata[0] ?? 0;
                    $lonWisata = $lokasiWisata[1] ?? 0;

                    if (!$latWisata || !$lonWisata) {
                        return back()->with('success', 'Terjadi Kesalahan Saat mengghitung jarak, mohon periksa data lokasi objek wisata, pastikan dengan format = latitude, longitude');
                    }

                    $criteriaJarakTempuh = Criteria::where('name', 'Jarak Tempuh')->first();
                }

                $arrToPush = [];
                foreach ($alt->performanceRatings as $index => $pr) {
                    if ($isIncludeJarak && $request->lokasi_user && $index === 0) {
                        // filterisasi jarak tempuh
                        $operatorJarak = $request->operator_jarak;
                        $valueJarak = $request->value_jarak;
                        $jarak = $this->haversine($lokasiPengguna[0], $lokasiPengguna[1], $latWisata, $lonWisata);
                        if ($valueJarak) {
                            if ($operatorJarak === '=') {
                                if ($jarak == $valueJarak) {
                                    $arrToPush[strtolower(str_replace(' ', '', $criteriaJarakTempuh->name))] = $jarak;
                                }else{
                                    continue;
                                }
                            }elseif($operatorJarak === '>') {
                                if ($jarak > $valueJarak) {
                                    $arrToPush[strtolower(str_replace(' ', '', $criteriaJarakTempuh->name))] = $jarak;
                                }else{
                                    continue;
                                }
                            }elseif($operatorJarak === '<') {
                                if ($jarak < $valueJarak) {
                                    $arrToPush[strtolower(str_replace(' ', '', $criteriaJarakTempuh->name))] = $jarak;
                                }else{
                                    continue;
                                }
                            }
                        }else{
                            $arrToPush[strtolower(str_replace(' ', '', $criteriaJarakTempuh->name))] = $jarak;
                        }

                    }
                    $arrToPush[strtolower(str_replace(' ', '', $pr->criteria->name))] = $pr->nilai;
                }
                $collToPush = collect($arrToPush);
                if (!$collToPush->isEmpty()) {
                    $collToPush->put('alternative_id', $alt->id);
                    $arrA[$key] = $collToPush;
                }
            }
            $arrA = collect($arrA);
            if ($arrA->isEmpty()) {
                DB::rollBack();
                return back()->with('error', 'Maaf, Tidak Ada Alternatif Yang Sesuai dengan Kriteria Anda');
            }

            // normalisasi Bobot kriteria dan mendapatkan nilai minimal dan maksimal untuk pembagi
            $arrBobot = [];
            $totalBobot = $dataCriteria->sum('bobot');
            foreach ($dataCriteria as $index => $criteria) {
                // mendapatkan nilai pembagi
                $nameToVariabel = strtolower(str_replace(' ', '', $criteria->name));
                $pembagi = 0;
                if ($criteria->tipe == 'cost') {
                    $pembagi = $arrA->min($nameToVariabel);
                }else{
                    $pembagi = $arrA->max($nameToVariabel);
                }
                // end mendapatkan nilai pembagi

                $normalisasiBobot = $criteria->bobot / $totalBobot;
                $arrBobot[] = [
                    'criteria_id' => $criteria->id,
                    'bobot_normalisasi' => $normalisasiBobot,
                    'kriteria' => $nameToVariabel,
                    'pembagi' => $pembagi,
                ];
            }

            // normalisasi data penilaian untuk setiap alternatif
            $arrAn = [];
            foreach ($arrA as $inA => $a) {
                $arrAn[$inA]['alternative_id'] = $a['alternative_id'];
                foreach ($arrBobot as $inB => $b) {
                    $itemCriteria = Criteria::find($b['criteria_id']);
                    if ($itemCriteria->tipe == 'cost') {
                        $arrAn[$inA][$b['kriteria']] = $this->cost($b['pembagi'], $a[$b['kriteria']]);;
                    }else{
                        $arrAn[$inA][$b['kriteria']] = $this->benefit($a[$b['kriteria']], $b['pembagi']);;
                    }
                }
            }
            // dd($arrAn);

            // menghitung nilai prefrensi
            $v=[];
            foreach ($arrAn as $key => $alt) {
                $v[$key]['alternative_id'] = $alt['alternative_id'];
                foreach ($arrBobot as $index => $w) {
                    $v[$key][$w['kriteria']] = $alt[$w['kriteria']] * $w['bobot_normalisasi'];
                }
            }

            $vij = [];
            foreach ($v as $key => $pref) {
                $vij[$key]['alternative_id'] = $pref['alternative_id'];
                $vij[$key]['total'] = 0;
                foreach ($arrBobot as $index => $w) {
                    $vij[$key]['total'] += $pref[$w['kriteria']];
                }
            }

            // ket: $arrBobot = Normalisasi Bobot dan nilai pembagi
            // ket: $arrA = Nilai alternatif berdasarkan kriteria sebelum dinormalisasi
            // ket: $arrAn = Nilai alternatif berdasarkan kriteria setelah dinormalisasi
            // ket: $v = Nilai alternatif setelah dinormalisasi dikali dengan nilai bobot  yang telah dinormalisasi
            // ket: $vij = Jumlah atau total dari semua nilai v yang didapatkan berdasarkan kriteria yang ada

            $itemHis = History::create([
                'user_id' => 1,
                'name' => $request->name  ?? '',
                'lokasi' => $request->lokasi_user ?? '',
            ]);
            foreach ($arrBobot as $kw => $w) {
                HistoryWeightNormalization::create([
                    'history_id' =>  $itemHis->id,
                    'criteria_id' =>  $w['criteria_id'],
                    'bobot_normalisasi' =>  $w['bobot_normalisasi'],
                    'kriteria' =>  $w['kriteria'],
                    'pembagi' =>  $w['pembagi'],
                ]);


                foreach ($arrA as $ka => $a) {
                    HistoryAlternatifValue::create([
                        'history_id' =>  $itemHis->id,
                        'alternative_id' =>  $a['alternative_id'],
                        'criteria_id' =>  $w['criteria_id'],
                        'name' =>  $w['kriteria'],
                        'nilai_awal' =>  $a[$w['kriteria']],
                        'nilai_normalisasi' =>  $arrAn[$ka][$w['kriteria']],
                        'nilai_preferensi' =>  $v[$ka][$w['kriteria']],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('spk/destinasi/rekomendasi.riwayat', encrypt($itemHis->id));
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        } catch (ValidationException $ve){
            DB::rollBack();
            return back()->with('errors',$ve->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function wisataShow(string $id)
    {
        $item  = Alternative::find(decrypt($id));
        return view('pages.custumer-page.wisata.show', [
            'title' => 'Home',
            'item' => $item,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function lastHistory(string $id)
    {
        $item = History::find(decrypt($id));
        $criterias = Criteria::where('is_include', true)->get();
        $alts = Alternative::where('status', 'accepted')->get();
        return view('pages.custumer-page.decision.show', [
            'title' => 'Rekomendasi',
            'menu' => 'Rekomendasi',
            'item' => $item,
            'criterias' => $criterias,
            'alts' => $alts,
        ]);
    }

    public function preferensiIndex()
    {
        $ahp = new AnalyticalHierarchyProcess;
        $dataComparison = $ahp->generateQuestions();

        if(empty($dataComparison['matriks_auto_fill']) && empty($dataComparison['matriks_manual_fill'])){
            return response()->json([
                'status' => false,
                'message' => 'Data Master Kriteria Not Found, Hubungi admin untuk mengisi data',
            ]);
        }

        $dataOptions = $ahp->getSkalaSaaty();
        return view('pages.custumer-page.preferensi.index', [
            'title' => 'Preferensi Pencarian',
            'dataComparison' => $dataComparison,
            'dataOptions' => $dataOptions,
        ]);
    }

    public function preferensiStore(Request $r){
        $ahp = new AnalyticalHierarchyProcess;
        $dataOptions = $ahp->getSkalaSaaty();
        $nilaiExist = collect($dataOptions)->pluck('nilai')->toArray();

        $validators = Validator::make($r->matriks_manual_fill, [
            '*.criteria_id_first' => 'required|exists:criterias,id',
            '*.criteria_id_second' => 'required|exists:criterias,id',
            '*.nilai' => ['required', Rule::in($nilaiExist)],
        ]);

        if($validators->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal: ' . $validators->errors()->first(),
            ]);
        }

        $dataMatriksManual = $r->matriks_manual_fill;
        $dataMatriksAuto = $r->matriks_auto_fill;

        $finalMatriksAutoFill = $this->autoFillMatriks($dataMatriksAuto, $dataMatriksManual);

        $flattenMatriks = array_merge($finalMatriksAutoFill,$dataMatriksManual);
        usort($flattenMatriks, function($a, $b){
            return $a['criteria_id_first'] <=> $b['criteria_id_first'];
        });

        // get total nilai berdasarkan criteria_id_second
        $groupByCriteriaSecond = collect($flattenMatriks)->groupBy('criteria_id_second');
        $dataTotal = [];
        foreach ($groupByCriteriaSecond as $criteriaIdSecond => $data) {
            $dataTotal[$criteriaIdSecond] = [
                'criteria_id' => $criteriaIdSecond,
                'total' => $data->sum('nilai'),
            ];
        }

        //normalisasi nilai matriks perbandingan
        $finalMatriks = [];
        foreach($flattenMatriks as $item){
            $criteriaSecond = $item['criteria_id_second'];
            $nilai = $item['nilai'];

            $total = $dataTotal[$criteriaSecond]['total'];

            $finalMatriks[] = [
                'criteria_id_first' => $item['criteria_id_first'],
                'criteria_id_second' => $criteriaSecond,
                'nilai' => $nilai,
                'nilai_normalisasi' => round($nilai/$total, 2),
            ];
        }

        // get bobot berdasarkan criteria_id_first
        $groupByCriteriaFirst = collect($finalMatriks)->groupBy('criteria_id_first');
        foreach ($groupByCriteriaFirst as $criteriaIdFirst => $data) {
            $length = $data->count();
            $totalNilaiNormal = $data->sum('nilai_normalisasi');
            $avg = $totalNilaiNormal/$length;
            if (isset($dataTotal[$criteriaIdFirst])) {
                $dataTotal[$criteriaIdFirst]['bobot'] = round($avg, 2);
            }
        }

        try {
            DB::beginTransaction();

            $userId = Auth::user()->id ?? null;
            $sessionId = session()->getId();

            CriteriaComparison::where(function($query) use ($userId, $sessionId){
                if ($userId) {
                    $query->where('user_id', $userId);
                }else{
                    $query->where('session_id', $sessionId);
                }
            })->delete();
            
            CriteriaWeight::where(function($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                }else{
                    $q->where('session_id', $sessionId);
                }
            })->delete();

            // store final matriks pada tabel criteria_comparison
            foreach($finalMatriks as $item){
                $criteriaComparison = new CriteriaComparison();
                if(Auth::check()){
                    $criteriaComparison->user_id = $userId;
                    $criteriaComparison->session_id = null;
                }else{
                    $criteriaComparison->user_id = null;
                    $criteriaComparison->session_id = $sessionId;
                }
                $criteriaComparison->criteria_id_first = $item['criteria_id_first'];
                $criteriaComparison->criteria_id_second = $item['criteria_id_second'];
                $criteriaComparison->nilai = $item['nilai'] ?? 0;
                $criteriaComparison->nilai_normalisasi = $item['nilai_normalisasi'] ?? 0;

                $criteriaComparison->save();
            }

            // store bobot criteria pada tabel criteria_weights
            foreach ($dataTotal as $key => $item) {
                $criteriaW = new CriteriaWeight();
                if (Auth::check()) {
                    $criteriaW->user_id = $userId;
                    $criteriaW->session_id = null;
                }else{
                    $criteriaW->user_id = null;
                    $criteriaW->session_id = $sessionId;
                }
                $criteriaW->criteria_id = $item['criteria_id'];
                $criteriaW->total = $item['total'];
                $criteriaW->bobot = $item['bobot'];

                $criteriaW->save();
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Sukses simpan preferensi'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi Kesalahan: ' . substr($th->getMessage(), 0, 95) . ' ...',
                'errors' => $th->getMessage()
            ]);
        }
    }

    private function autoFillMatriks($matriksAuto, $matriksManual){
        //mapping
        $map = [];
        foreach($matriksManual as $item){
            $key = $item['criteria_id_first'] . '-' . $item['criteria_id_second'];
            $map[$key] = (float) $item['nilai'] ?? 0;
        }

        //autofillmatriks
        foreach($matriksAuto as &$item){
            $first = $item['criteria_id_first'];
            $second = $item['criteria_id_second'];

            if (!is_null($item['nilai'])) {
                continue;
            }

            $reverseKey = $second . '-' . $first;
            if(isset($map[$reverseKey])){
                $item['nilai'] = round(1/$map[$reverseKey], 2);
            }
        }
        return $matriksAuto;
    }
}
