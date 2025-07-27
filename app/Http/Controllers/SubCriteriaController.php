<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $this->authorize('admin');
        $item = Criteria::find(decrypt($id));
        return view('pages.kriteria-sub.create', [
            'title' => 'kriteria',
            'menu' => 'data',
            'item' => $item,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $this->authorize('admin');

        $data = $request->all();
        $item = Criteria::find(decrypt($id));

        if ($item->jenis == 'kuantitatif') {
            $validators = Validator::make($request->all(), [
                'min_value' => 'required',
                'max_value' => 'required',
            ]);
            if ($validators->fails()) {
                return back()->with('error', $validators->errors()->first())->withInput();
            }
            $res = $this->validasiMinMaxValue($data['min_value'], $data['max_value'], $item, null);
            if (!$res['status']) {
                return back()->with('error', $res['message'])->withInput();
            }
        }

        $data['criteria_id'] = $item->id;
        SubCriteria::create($data);
        
        return redirect()->route('spk/destinasi/kriteria.index')->with('success', 'Berhasil Ditambahkan');
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
        $this->authorize('admin');

        $item = SubCriteria::find(decrypt($id));
        return view('pages.kriteria-sub.edit', [
            'title' => 'kriteria',
            'menu' => 'data',
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('admin');

        $data = $request->all();
        $item = SubCriteria::find(decrypt($id));

        if ($item->criteria->jenis == 'kuantitatif') {
            $validators = Validator::make($request->all(), [
                'min_value' => 'required',
                'max_value' => 'required',
            ]);
            if ($validators->fails()) {
                return back()->with('error', $validators->errors()->first())->withInput();
            }
            $res = $this->validasiMinMaxValue($data['min_value'], $data['max_value'], $item->criteria, $item->id);
            if (!$res['status']) {
                return back()->with('error', $res['message'])->withInput();
            }
        }
        
        $item->update($data);
        
        return redirect()->route('spk/destinasi/kriteria.index')->with('success', 'Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('admin');

        $item = SubCriteria::find(decrypt($id));
        $item->delete();
        
        return redirect()->route('spk/destinasi/kriteria.index')->with('success', 'Berhasil Dihapus');
    }


    private function validasiMinMaxValue($minValue, $maxValue, $criteria, $idEdited){
        
        if($minValue > $maxValue){
            return [
                'status' => false,
                'message' => 'data tidak valid, nilai minimum lebih besar dari nilai maksimum'
            ];
        }
        foreach ($criteria->subCriterias as $key => $sub) {
            if ($idEdited && $idEdited == $sub->id) {
                continue;
            }
            $isOverlap = !($maxValue < $sub->min_value || $minValue > $sub->max_value);
            if ($isOverlap) {
                return [
                    'status' => false,
                    'message' => 'rentang nilai beririsan dengan sub kriteria ' . $sub->label
                ];
            }
        }

        return [
            'status' => true,
            'message' => 'success'
        ];
    }
}
