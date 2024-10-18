<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Criteria::all();
        $totalBobot = $data->where('is_include', true)->sum('bobot');
        return view('pages.kriteria.index', [
            'title' => 'kriteria',
            'menu' => 'data',
            'data' => $data,
            'totalBobot' => $totalBobot,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kriteria.create', [
            'title' => 'kriteria',
            'menu' => 'data',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Criteria::create($data);

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
        $item = Criteria::find(decrypt($id));
        return view('pages.kriteria.edit', [
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
        $item = Criteria::find(decrypt($id));
        $data = $request->all();
        if ($item->atribut == 'konstanta') {
            $data = [
                'tipe' => $request->tipe ?? '',
                'bobot' => $request->bobot ?? 0,
            ];
        }

        $item->update($data);

        return redirect()->route('spk/destinasi/kriteria.index')->with('success', 'Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Criteria::find(decrypt($id));
        $item->delete();

        return back()->with('success', 'Berhasil Dihapus');
    }

    public function activated(Request $request, string $id)
    {
        $item = Criteria::find(decrypt($id));
        if ($item->atribut == 'konstanta') {
            if ($item->is_include == true) {
                $item->update([
                    'is_include' => false,
                ]);
            }else{
                $item->update([
                    'is_include' => true,
                ]);
            }
        }

        return back()->with('success', 'Berhasil Diperbarui');
    }
}
