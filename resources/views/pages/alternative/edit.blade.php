@extends('layouts.auth-v1.main')

@section('content')
<div class="card">
    <div class="card-header mb-4 border-bottom">
        <h4 class="m-0 p-0">Edit Alternatif Wisata</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('spk/destinasi/alternative.update', encrypt($item->id)) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama-wisata" class="form-label">Nama Wisata</label>
                        <input type="text" class="form-control form-control-md" id="nama-wisata" name="name" placeholder="Nama Wisata" value="{{ old('name', $item->name ?? '') }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="alamat-wisata" class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control form-control-md" id="alamat-wisata" cols="10" rows="3" placeholder="Alamat lokasi wisata">{{ old('alamat', $item->alamat ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="maps-lokasi" class="form-label">Maps Lokasi</label>
                        <input type="text" class="form-control form-control-md" id="maps-lokasi" name="maps_lokasi" placeholder="Titik Tepat Lokasi Wisata Berada" value="{{ old('maps_lokasi', $item->maps_lokasi ?? '') }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="harga-wisata" class="form-label">Harga</label>
                        <input type="number" class="form-control form-control-md" id="harga-wisata" name="harga" placeholder="Tarif Wisata" value="{{ old('harga', $item->harga ?? '') }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="rating-wisata" class="form-label">Rating</label>
                        <input type="number" class="form-control form-control-md" id="rating-wisata" name="rating" placeholder="Rating atau Peringkat Wisata" value="{{ old('rating', $item->rating ?? '') }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="fasilitas" class="form-label">Jumlah Fasilitas</label>
                        <textarea name="fasilitas" class="form-control form-control-md" id="fasilitas" cols="30" rows="7" placeholder="Fasilitas Yang Disediakan Pada Objek Wisata" required>{{ old('fasilitas', $item->fasilitas ?? '') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kategori-wisata" class="form-label">Kategori</label>
                        <select class="form-select form-control" id="kategori-wisata" aria-label="Default select example" name="travel_category_id" required>
                          <option selected disabled>-- Pilih Kategori --</option>
                          @foreach ($data as $cat)
                            <option value="{{ $cat->id }}" {{ old('travel_category_id', $item->travel_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name ?? '-' }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi-wisata" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control form-control-md" id="deskripsi-wisata" cols="30" rows="10" placeholder="Deskripsi tentang objek wisata">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="current-foto" class="form-label">Foto Sekarang</label>
                        <p>
                            <a href="{{ Storage::url($item->foto) }}" id="current-foto" ><img src="{{ Storage::url($item->foto) }}" alt="" class="img-fluid" width="300" height="300"></a>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="foto-wisata" class="form-label">Ubah Foto</label>
                        <input type="file" class="form-control form-control-md" id="foto-wisata" name="foto"/>
                        @error('foto')
                        <div class="small text-danger fst-italic">
                           * {{ $message ?? '' }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 mt-4 border-top">
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('spk/destinasi/alternative.index') }}" class="btn btn-md btn-danger me-2"><i class="bx bx-left-arrow"></i> Kembali</a>
                        <button type="submit" class="btn btn-md btn-success"><i class="bx bx-file"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection