<?php

namespace App\Http\Controllers;

use App\Models\TravelCategory;
use Illuminate\Http\Request;

class TravelCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TravelCategory::all();
        return view('pages.kategori-wisata.index', [
            'title' => 'Kategori Wisata',
            'menu' => 'Kategori Wisata',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kategori-wisata.create', [
            'title' => 'Kategori Wisata',
            'menu' => 'Kategori Wisata',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        TravelCategory::create($data);

        return redirect()->route('spk/destinasi/kategori/wisata.index')->with('success', 'Berhasil Diperbarui');
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
        $item = TravelCategory::find(decrypt($id));
        return view('pages.kategori-wisata.edit', [
            'title' => 'Kategori Wisata',
            'menu' => 'Kategori Wisata',
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $item = TravelCategory::find(decrypt($id));
        $item->update($data);

        return redirect()->route('spk/destinasi/kategori/wisata.index')->with('success', 'Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = TravelCategory::find(decrypt($id));
        $item->delete();

        return back()->with('success', 'Berhasil Dihapus');
    }
}
