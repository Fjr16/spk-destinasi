<?php

namespace App\Http\Controllers;

use App\Helpers\AnalyticalHierarchyProcess;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\CriteriaComparison;
use App\Models\CriteriaWeight;
use App\Models\TravelCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    private function normalisasiBobotSubCriteria($criteria, $currentSubCriteriaBobot){
        $totSubBobot = $criteria->subCriterias->sum('bobot');
        return ($currentSubCriteriaBobot ?? 0) / ($totSubBobot ?? 0);
    }

    private function getValueNormalJarak($valueMentahJarak, $criteriaJarak){
        if ($valueMentahJarak === null || $valueMentahJarak === '' || $valueMentahJarak < 0) {
            return null;
        }

        $jarakTerjauh = null;
        foreach($criteriaJarak->subCriterias as $sub){
            $minValue = $sub->min_value;
            $maxValue = $sub->max_value;

            // Simpan subcriteria dengan rentang max_value paling besar
            if (!$jarakTerjauh || $maxValue > $jarakTerjauh->max_value) {
                $jarakTerjauh = $sub;
            }

            if ($valueMentahJarak >= $minValue && $valueMentahJarak <= $maxValue) {
                return $this->normalisasiBobotSubCriteria($criteriaJarak, $sub->bobot);
            }
        }

        return $this->normalisasiBobotSubCriteria($criteriaJarak, $jarakTerjauh->bobot ?? 0);
    }

    private function checkIsExistWeight($user_id, $session_id)
    {
        $comparisonQuery = CriteriaComparison::query();
        $bobotQuery = CriteriaWeight::query();

        if ($user_id) {
            $comparisonQuery->where('user_id', $user_id);
            $bobotQuery->where('user_id', $user_id);
        } else {
            $comparisonQuery->where('session_id', $session_id);
            $bobotQuery->where('session_id', $session_id);
        }

        $comparison = $comparisonQuery->exists();
        $bobot = $bobotQuery->exists();

        return [
            'status' => $comparison && $bobot,
            'message' => $comparison && $bobot
                ? 'success'
                : 'Data preferensi anda tidak ditemukan, mohon isi preferensi terlebih dahulu',
        ];
    }

    private function buildViewMatriks($dataComparison, $kriterias, $param = 'default') {
        $matriks = [];
        foreach ($kriterias as $row) {
            foreach ($kriterias as $col) {
                // Cek jika ada data langsung
                $item = $dataComparison->first(function ($d) use ($row, $col) {
                    return $d->criteriaFirst->name === $row && $d->criteriaSecond->name === $col;
                });

                 // Cek jika data terbalik (kebalikan)
                $reverse = $dataComparison->first(function ($d) use ($row, $col) {
                    return $d->criteriaFirst->name === $col && $d->criteriaSecond->name === $row;
                });

                if ($item) {
                    $matriks[$row][$col] = $param == 'default' ? $item->nilai : $item->nilai_normalisasi;
                } elseif ($reverse) {
                    $matriks[$row][$col] = $param == 'default' ? $reverse->nilai : $reverse->nilai_normalisasi; // pembanding kebalikan
                }else {
                    $matrix[$row][$col] = ($row === $col) ? 1 : '-'; // default jika tidak ada dan bukan diagonal
                }
            }
        }
        return $matriks;
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
        // \Log::info("start rekomendasi", ['time' => now()]);

        
        $authId = Auth::user()->id ?? null;
        $sess_id = session()->getId();
        $res = $this->checkIsExistWeight($authId, $sess_id);
        if (!$res['status']) {
            return redirect()->route('preferensi.rekomendasi')->with('error', $res['message']);
        }

        $cacheLockKey = 'proses_perhitungan_user_or_session_id_' . ($authId ?? $sess_id);

        try {
            Cache::lock($cacheLockKey, 6)->block(4, function() use ($request, $authId, $sess_id){
    
                DB::beginTransaction();
                $data = $request->all();
    
                // cast to int before filter alternatif data
                $dataAwalAlternatif = Alternative::where('status', 'accepted')->get();
                $isIncludeJarak = Criteria::where('name', 'Jarak Tempuh')->where('is_include', true)->exists();
    
                if ($isIncludeJarak) {
                    $request->validate([
                        'lokasi_user' => 'required',
                    ]);
                }
    
                $criteriaFilter = collect($data['kriteria_id'])
                ->map(function ($criId, $index) use ($data) {
                    return [
                        'criteria_id' => (int) $criId,
                        'sub_criteria_id' => $data['sub_criteria_id'][$index] ?? null,
                    ];
                })
                ->filter(function ($pair) {
                    return $pair['sub_criteria_id'] !== 'All' && $pair['sub_criteria_id'] !== null;
                })
                ->map(function($pair){
                    $pair['sub_criteria_id'] = (int) $pair['sub_criteria_id'];
                    return $pair;
                })
                ->values();
    
                $dataAlternatif = $dataAwalAlternatif;
                $altQuery = Alternative::query();
                $altQuery->where('status', 'accepted');
                if ($request->travel_category_id) {
                    $altQuery->where('travel_category_id', $request->travel_category_id);
                }
                
                if ($criteriaFilter->isNotEmpty()) {
                    $first = $criteriaFilter->first();
    
                    $altQuery->whereHas('performanceRatings', function ($query) use ($first){
                        $query->where('criteria_id', $first['criteria_id'])
                            ->where('sub_criteria_id', $first['sub_criteria_id']);
                    })->with('performanceRatings');
    
                    $filteredAlternatives = $altQuery->get();
    
                    $criteriaFilter->skip(1)->each(function ($filter) use (&$filteredAlternatives){
                        $filteredAlternatives = $filteredAlternatives->filter(function ($item) use ($filter) {
                            return $item->performanceRatings->contains(function ($pr) use ($filter){
                                return $pr->criteria_id === $filter['criteria_id'] &&
                                        $pr->sub_criteria_id === $filter['sub_criteria_id'];
                            });
                        });
                    });
    
                    $dataAlternatif = $filteredAlternatives;
                }else{
                    $dataAlternatif = $altQuery->get();
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
                $arrReal = [];
                foreach ($dataAlternatif as $key => $alt) {
                    if ($isIncludeJarak && $request->lokasi_user) {
                        // lokasi wisata
                        $lokasiWisata = explode(',', $alt->maps_lokasi);
                        $latWisata = $lokasiWisata[0] ?? 0;
                        $lonWisata = $lokasiWisata[1] ?? 0;
    
                        if (!$latWisata || !$lonWisata) {
                            return back()->with('success', 'Terjadi Kesalahan Saat menghitung jarak, mohon periksa data lokasi objek wisata, pastikan dengan format = latitude, longitude');
                        }
    
                        $criteriaJarakTempuh = Criteria::where('name', 'Jarak Tempuh')->first();
                    }
    
                    $arrToPush = [];
                    $nilaiReal = [];
                    foreach ($alt->performanceRatings as $index => $pr) {
                        if ($isIncludeJarak && $request->lokasi_user && $index === 0) {
                            // filterisasi jarak tempuh
                            $operatorJarak = $request->operator_jarak;
                            $valueJarak = $request->value_jarak;
                            $jarak = $this->haversine($lokasiPengguna[0], $lokasiPengguna[1], $latWisata, $lonWisata);
                            $bobotNormalisasiJarak = $this->getValueNormalJarak($jarak,$criteriaJarakTempuh);
                            if ($valueJarak) {
                                if ($operatorJarak === '=') {
                                    if ($jarak == $valueJarak) {
                                        $arrToPush[strtolower(str_replace(' ', '', $criteriaJarakTempuh->id))] = $bobotNormalisasiJarak;
                                        $nilaiReal[strtolower(str_replace(' ', '', $criteriaJarakTempuh->id))] = $jarak;
                                    }else{
                                        continue;
                                    }
                                }elseif($operatorJarak === '>') {
                                    if ($jarak > $valueJarak) {
                                        $arrToPush[strtolower(str_replace(' ', '', $criteriaJarakTempuh->id))] = $bobotNormalisasiJarak;
                                        $nilaiReal[strtolower(str_replace(' ', '', $criteriaJarakTempuh->id))] = $jarak;
                                    }else{
                                        continue;
                                    }
                                }elseif($operatorJarak === '<') {
                                    if ($jarak < $valueJarak) {
                                        $arrToPush[strtolower(str_replace(' ', '', $criteriaJarakTempuh->id))] = $bobotNormalisasiJarak;
                                        $nilaiReal[strtolower(str_replace(' ', '', $criteriaJarakTempuh->id))] = $jarak;
                                    }else{
                                        continue;
                                    }
                                }
                            }else{
                                $arrToPush[strtolower(str_replace(' ', '', $criteriaJarakTempuh->id))] = $bobotNormalisasiJarak;
                                $nilaiReal[strtolower(str_replace(' ', '', $criteriaJarakTempuh->id))] = $jarak;
                            }
    
                        }
                        $arrToPush[strtolower(str_replace(' ', '', $pr->criteria->id))] = $this->normalisasiBobotSubCriteria($pr->criteria, $pr->subCriteria->bobot);
                        $nilaiReal[strtolower(str_replace(' ', '', $pr->criteria->id))] = $pr->subCriteria->bobot;
                    }
                    $collToPush = collect($arrToPush);
                    if (!$collToPush->isEmpty()) {
                        $collToPush->put('alternative_id', $alt->id);
                        $arrA[$key] = $collToPush;
                    }
                    $nilaiRealPush = collect($nilaiReal);
                    if (!$nilaiRealPush->isEmpty()) {
                        $nilaiRealPush->put('alternative_id', $alt->id);
                        $arrReal[$key] = $nilaiRealPush;
                    }
                }
                $arrA = collect($arrA);
                if ($arrA->isEmpty()) {
                    DB::rollBack();
                    return back()->with('error', 'Maaf, Tidak Ada Alternatif Yang Sesuai dengan Kriteria Anda');
                }
    
                $ahp = new AnalyticalHierarchyProcess;
                $dataPerbandinganCriteria = $ahp->getBobotCriteriaOfUser($sess_id, $authId);
    
                // menghitung skor akhir destinasi wisata / alternatif
                $result = [];
                foreach ($arrA as $key => $item) {
                    $wisata = Alternative::where('id', $item['alternative_id'])->first();
    
                    $listSkorAlternatifCn = [];
                    foreach ($dataPerbandinganCriteria as $comp) {
                        $bobotKriteria = $comp->bobot;
                        $nilaiAlternatifCn = $item[$comp->criteria_id];
                        $listSkorAlternatifCn[] = $bobotKriteria * $nilaiAlternatifCn;
                    }
    
                    $result[$key]['skor_akhir'] = array_sum($listSkorAlternatifCn);
                    $result[$key]['wisata'] = $wisata;
                }
    
                $finalData = collect($result)->sortByDesc('skor_akhir')
                                                    ->values()
                                                    ->take(5)
                                                    ->map(function($item, $index){
                                                        $item['ranking'] = $index+1;
                                                        return $item;
                });

                // return $finalData;
    
                // ket: $arrReal = nilai normal alternatif terhadap kriteria yang belum dinormalisasi, masih menggunakan data real
                // ket: $arrA = nilai normal alternatif terhadap kriteria menggunakan normalisasi nilai subkriteria
                // ket: $dataPerbandinganCriteria = data matriks perbandingan kriteria yang telah dinormalisasi tepatnya di key bobot
                // ket: $result = Nilai alternatif setelah dinormalisasi dikali dengan nilai bobot  yang telah dinormalisasi operasi, rumus= sigma(bobot_kriteria_normalisasi*nilai_alternatif_normalisasi)
                // ket: $finalData = Data nilai akhir alternatif yang dirangking, dan diambil top 5 nya
    
                $cacheKey = 'finalData_' . session()->getId();
                $cacheKey2 = 'nilai_normalisasi_alternatif_' . session()->getId();
                if (Auth::check()) {
                    $cacheKey = 'finalData_' . Auth::user()->id;
                    $cacheKey2 = 'nilai_normalisasi_alternatif_' . Auth::user()->id;
                }
                Cache::put($cacheKey, $finalData, now()->addMinutes(20));
                Cache::put($cacheKey2, $arrA, now()->addMinutes(20));
    
                DB::commit();
            });
            
            
            // \Log::info("end rekomendasi", ['time' => now()]);
            return redirect()->route('spk/destinasi/rekomendasi.result');
        } catch (\Throwable $e) {
            // \Log::info("end rekomendasi", ['time' => now()]);
            DB::rollBack();
            return back()->with('error', 'Terjadi Kesalahan: ' . $e->getMessage());
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
    public function rekomendasiResult()
    {
        $data = Cache::get('finalData_'. session()->getId());
        $dataAlternatifNormal = Cache::get('nilai_normalisasi_alternatif_'. session()->getId());
        if (Auth::check()) {
            $dataAlternatifNormal = Cache::get('nilai_normalisasi_alternatif_'. Auth::user()->id);
            $data = Cache::get('finalData_'. Auth::user()->id);
        }

        if (!$data || !$dataAlternatifNormal) {
            return redirect()->route('spk/destinasi/rekomendasi.create');
        }

        $dataComparison = Auth::check() 
        ? CriteriaComparison::where('user_id', Auth::user()->id)->get()
        : CriteriaComparison::where('session_id', session()->getId())->get();
        $kriterias = $dataComparison->pluck('criteriaFirst.name')
                    ->merge($dataComparison->pluck('criteriaSecond.name'))
                    ->unique()
                    ->values();

        $matriks = $this->buildViewMatriks($dataComparison, $kriterias);
        $matriksNormalisasi = $this->buildViewMatriks($dataComparison, $kriterias, 'normalisasi');

        $criteriaTotals = CriteriaWeight::with('criteria')
        ->whereIn('criteria_id', function ($query){
            $query->select('criteria_id_first')
                ->from('criteria_comparisons');
            if (Auth::check()) {
                $query->where('user_id', Auth::user()->id);
            }else{
                $query->where('session_id', session()->getId());
            }
        })->get()
        ->keyBy(fn ($item) => $item->criteria->name);

        $mappedAlternatif = $dataAlternatifNormal->map(function ($item) {
            $alt = Alternative::find($item['alternative_id']);
            $result = ['Nama Alternatif' => $alt->name];
            
            foreach ($item as $key => $value) {
                if ($key !== 'alternative_id') {
                    $criteria = Criteria::find($key);
                    $result[$criteria->name] = $value;
                }
            }
            return $result;
        });

        return view('pages.custumer-page.decision.show', [
            'title' => 'Rekomendasi',
            'menu' => 'Rekomendasi',
            'data' => $data,
            'dataComparison' => $dataComparison,
            'kriterias' => $kriterias,
            'matriks' => $matriks,
            'matriksNormalisasi' => $matriksNormalisasi,
            'criteriaTotals' => $criteriaTotals,
            'mappedAlternatif' => $mappedAlternatif,
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
