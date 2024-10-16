@extends('layouts.auth-v1.main')

@section('content')
    <div class="card">
        <div class="card-header mb-4 border-bottom">
            <h4 class="m-0 p-0">Tambah Alternatif Wisata</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('spk/destinasi/alternative.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama-wisata" class="form-label">Nama Wisata</label>
                            <input type="text" class="form-control form-control-md" id="nama-wisata" name="name" placeholder="Nama Wisata" value="{{ old('name') }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="alamat-wisata" class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control form-control-md" id="alamat-wisata" cols="10" rows="3" placeholder="Alamat lokasi wisata">{{ old('alamat') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="maps-lokasi" class="form-label">Maps Lokasi</label>
                            <input type="text" class="form-control form-control-md" id="maps-lokasi" name="maps_lokasi" placeholder="Titik Tepat Lokasi Wisata Berada" value="{{ old('maps_lokasi') }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="harga-wisata" class="form-label">Harga</label>
                            <input type="number" class="form-control form-control-md" id="harga-wisata" name="harga" placeholder="Tarif Wisata" value="{{ old('harga') }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="rating-wisata" class="form-label">Rating</label>
                            <input type="number" class="form-control form-control-md" id="rating-wisata" name="rating" placeholder="Rating atau Peringkat Wisata" value="{{ old('rating') }}" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kategori-wisata" class="form-label">Kategori</label>
                            <input type="text" class="form-control form-control-md" id="kategori-wisata" name="kategori" placeholder="kategori" value="{{ old('kategori') }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="jumlah-fasilitas" class="form-label">Jumlah Fasilitas</label>
                            <input type="number" class="form-control form-control-md" id="jumlah-fasilitas" name="jumlah_fasilitas" placeholder="Jumlah Fasilitas Pada Wisata" value="{{ old('jumlah_fasilitas') }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi-wisata" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control form-control-md" id="deskripsi-wisata" cols="30" rows="7" placeholder="Deskripsi tentang objek wisata">{{ old('deskripsi') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="foto-wisata" class="form-label">Foto</label>
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