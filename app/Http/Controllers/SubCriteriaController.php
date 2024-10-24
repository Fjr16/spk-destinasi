<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Http\Request;

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
}
