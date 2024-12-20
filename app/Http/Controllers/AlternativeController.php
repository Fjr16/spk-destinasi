<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\TravelCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlternativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Alternative::all();
        return view('pages.alternative.index', [
            'title' => 'alternative',
            'menu' => 'data',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = TravelCategory::all();
        return view('pages.alternative.create', [
            'title' => 'alternative',
            'menu' => 'data',
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'maps_lokasi' => 'required',
        ]);
        $data = $request->all();

        $path = null;
        if ($request->file('foto')) {
            $path = $request->foto->store('imgUpload', 'public');
        }

        $data['foto'] = $path;
        Alternative::create($data);

        return redirect()->route('spk/destinasi/alternative.index')->with('success', 'Berhasil Ditambahkan');
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
        $data = TravelCategory::all();
        $item = Alternative::find(decrypt($id));
        return view('pages.alternative.edit', [
            'title' => 'alternative',
            'menu' => 'data',
            'item' => $item,
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('admin');
        $request->validate([
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'maps_lokasi' => 'required',
        ]);
        
        $item = Alternative::find(decrypt($id));
        $data = $request->except('foto');
        if ($request->file('foto')) {
            // Hapus foto sebelumnya
            Storage::delete('public/' . $item->foto);
            // Simpan foto terbaru
            $data['foto'] = $request->foto->store('imgUpload', 'public');
        }

        $item->update($data);

        return redirect()->route('spk/destinasi/alternative.index')->with('success', 'Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('admin');
        $item = Alternative::find(decrypt($id));

        Storage::delete('public/' . $item->foto);
        $item->delete();

        return back()->with('success', 'Berhasil Dihapus');
    }

    public function confirm(Request $request, $id){
        $this->authorize('admin');

        $request->validate([
            'status' => 'in:accepted,denied,waiting',
        ]);

        $item = Alternative::find(decrypt($id));
        $item->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Berhasil Memperbarui status');
    }
}
