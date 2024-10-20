<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\PerformanceRating;
use App\Models\SubCriteria;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerformanceRatingController extends Controller
{

    private function normalisasiBobot($kriteria, $bobot) {
        $totalBobot = $kriteria->subCriterias->sum('bobot');
        $hasil = $bobot/$totalBobot;
        return $hasil;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $isJarakInclude = Criteria::where('name', 'Jarak Tempuh')->where('is_include', true)->exists();
        $alts = Alternative::doesntHave('performanceRatings')->get();
        $criterias = Criteria::whereNot('name', 'Jarak Tempuh')->get();
        $data = Alternative::all();
        return view('pages.penilaian.index', [
            'title' => 'penilaian',
            'menu' => 'data',
            'alts' => $alts,
            'criterias' => $criterias,
            'data' => $data,
            'isJarakInclude' => $isJarakInclude,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'alternative_id' => 'required',
                'penilaian.*' => 'array|required',
                'penilaian.*.criteria_id' => 'required|integer',
                'penilaian.*.sub_criteria_id' => 'integer|required',
            ]);
            foreach ($request['penilaian'] as $key => $r) {
                $cri = Criteria::findOrFail($r['criteria_id']);
                $subCriteria = SubCriteria::findOrFail($r['sub_criteria_id']);
                $bobotNor = $this->normalisasiBobot($cri, $subCriteria->bobot);

                $data = [
                    'alternative_id' => $request->alternative_id,
                    'criteria_id' => $r['criteria_id'],
                    'sub_criteria_id' => $r['sub_criteria_id'],
                    'nilai' => $subCriteria->bobot,
                    'normalisasi' => $bobotNor,
                ];

                PerformanceRating::create($data);
            }

            DB::commit();
            return redirect()->route('spk/destinasi/penilaian.index')->with('success', 'Berhasil Ditambahkan');
            
        } catch (\Illuminate\Validation\ValidationException $ve) {
            DB::rollBack();
            return redirect()->route('spk/destinasi/penilaian.index')->with('errors', 'Pastikan Semua Data Telah Terisi');
        } catch (ModelNotFoundException $mn) {
            DB::rollBack();
            return redirect()->route('spk/destinasi/penilaian.index')->with('error', $mn->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Alternative::find(decrypt($id));
        $criterias = Criteria::whereNot('name', 'Jarak Tempuh')->get();
        return view('pages.penilaian.edit', [
            'title' => 'penilaian',
            'menu' => 'data',
            'item' => $item,
            'criterias' => $criterias,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $item = Alternative::find(decrypt($id));
            $this->validate($request, [
                'penilaian.*' => 'array|required',
                'penilaian.*.criteria_id' => 'required|integer',
                'penilaian.*.sub_criteria_id' => 'integer|required',
            ]);
            foreach ($request['penilaian'] as $key => $r) {
                $cri = Criteria::findOrFail($r['criteria_id']);
                $subCriteria = SubCriteria::findOrFail($r['sub_criteria_id']);
                $bobotNor = $this->normalisasiBobot($cri, $subCriteria->bobot);

                $data = [
                    'criteria_id' => $r['criteria_id'],
                    'sub_criteria_id' => $r['sub_criteria_id'],
                    'nilai' => $subCriteria->bobot,
                    'normalisasi' => $bobotNor,
                ];

                PerformanceRating::where('alternative_id', $item->id)->where('criteria_id', $r['criteria_id'])->first()
                ->update($data);
            }

            DB::commit();
            return redirect()->route('spk/destinasi/penilaian.index')->with('success', 'Berhasil Ditambahkan');
            
        } catch (\Illuminate\Validation\ValidationException $ve) {
            DB::rollBack();
            return redirect()->route('spk/destinasi/penilaian.index')->with('error', 'Pastikan Semua Data Telah Terisi');
        } catch (ModelNotFoundException $mn) {
            DB::rollBack();
            return redirect()->route('spk/destinasi/penilaian.index')->with('error', $mn->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Alternative::find(decrypt($id));
        if (!$item->performanceRatings->isEmpty()) {
            $item->performanceRatings()->delete();
        }

        return back()->with('success', 'Berhasil Mengapus Data Penilaian');
    }
}
