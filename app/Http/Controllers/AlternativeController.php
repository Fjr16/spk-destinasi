<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\PerformanceRating;
use App\Models\TravelCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $criterias = Criteria::where('is_include', true)
                    ->where('atribut', 'dinamis')
                    ->with('subCriterias')
                    ->get(); 
        return view('pages.alternative.create', [
            'title' => 'alternative',
            'menu' => 'data',
            'data' => $data,
            'criterias' => $criterias,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'harga' => 'required',
            'waktu_operasional' => 'required',
            'alamat' => 'required',
            'aksesibilitas' => 'required',
            'travel_category_id' => 'required|exist:travel_categories, id',
            'fasilitas' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'maps_lokasi' => 'required',
            'criteria_id' => 'required|array', 
            'criteria_id.*' => 'required|exist:criterias, id',
            'sub_criteria_id' => 'required|array', 
            'sub_criteria_id.*' => 'required|exist:sub_criterias, id', 
        ],[
            'criteria_id.required' => 'Form Penilaian alternatif wisata wajib diisi',
            'criteria_id.*.exists' => 'kriteria penilaian tidak ditemukan',
            'sub_criteria_id.required' => 'Form Penilaian alternatif wisata wajib diisi',
            'sub_criteria_id.*.required' => 'Form Penilaian alternatif wisata wajib diisi',
            'sub_criteria_id.*.exists' => 'Pilihan tidak ditemukan pada penilaian alternatif wisata',
        ]);
        $data = $request->all();

        $path = null;
        if ($request->file('foto')) {
            $path = $request->foto->store('imgUpload', 'public');
        }
        
        try {
            DB::beginTransaction();
            $data['foto'] = $path;
            $item = Alternative::create($data);

            foreach ($data['criteria_id'] as $key => $criId) {
                $instance = new PerformanceRating;
                $instance->alternative_id = $item->id;
                $instance->criteria_id = $criId;
                $instance->sub_criteria_id = $data['sub_criteria_id'][$key];
                $instance->save();
            }
    
            DB::commit();
            return redirect()->route('spk/destinasi/alternative.index')->with('success', 'Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Terjadi Kesalahan: '. $th->getMessage())->withInput();
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
        $this->authorize('admin');
        $data = TravelCategory::all();
        $item = Alternative::find(decrypt($id));
        $pRating = [];
        if ($item->performanceRatings->isNotEmpty()) {
            foreach ($item->performanceRatings as $pr) {
                $pRating[$item->id . '-' .$pr->criteria_id] = $pr->sub_criteria_id;
            }
        } 
        $criterias = Criteria::where('is_include', true)
            ->where('atribut', 'dinamis')
            ->with('subCriterias')
            ->get(); 
        return view('pages.alternative.edit', [
            'title' => 'alternative',
            'menu' => 'data',
            'item' => $item,
            'data' => $data,
            'criterias' => $criterias,
            'pRating' => $pRating,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('admin');
        $validators = Validator::make($request->all(), [
            'name' => 'required',
            'harga' => 'required',
            'waktu_operasional' => 'required',
            'alamat' => 'required',
            'aksesibilitas' => 'required',
            'travel_category_id' => 'required|exists:travel_categories,id',
            'fasilitas' => 'required',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'maps_lokasi' => 'required',
            'criteria_id' => 'required|array', 
            'criteria_id.*' => 'required|exists:criterias,id',
            'sub_criteria_id' => 'required|array', 
            'sub_criteria_id.*' => 'required|exists:sub_criterias,id', 
        ],[
            'criteria_id.required' => 'Form Penilaian alternatif wisata wajib diisi',
            'criteria_id.*.exists' => 'kriteria penilaian tidak ditemukan',
            'sub_criteria_id.required' => 'Form Penilaian alternatif wisata wajib diisi',
            'sub_criteria_id.*.required' => 'Form Penilaian alternatif wisata wajib diisi',
            'sub_criteria_id.*.exists' => 'Pilihan tidak ditemukan pada penilaian alternatif wisata',
        ]);
        if ($validators->fails()) {
            return back()->with('error', 'Gagal Validasi: '. $validators->errors()->first())->withInput();
        }
        
        
        try {
            DB::beginTransaction();

            $item = Alternative::find(decrypt($id));
            $data = $request->except('foto');
            if ($request->file('foto')) {
                // Hapus foto sebelumnya
                Storage::delete('public/' . $item->foto);
                // Simpan foto terbaru
                $data['foto'] = $request->foto->store('imgUpload', 'public');
            }
            $item->update($data);

            foreach ($data['criteria_id'] as $key => $criId) {
                $check = PerformanceRating::where('alternative_id', $item->id)
                        ->where('criteria_id', $criId)
                        ->first();
                $instance = $check ? $check : new PerformanceRating;
                $instance->alternative_id = $item->id;
                $instance->criteria_id = $criId;
                $instance->sub_criteria_id = $data['sub_criteria_id'][$key];
                $instance->save();
            }
    
            DB::commit();
            return redirect()->route('spk/destinasi/alternative.index')->with('success', 'Berhasil Diperbarui');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Terjadi Kesalahan: '. $th->getMessage())->withInput();
        }


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
