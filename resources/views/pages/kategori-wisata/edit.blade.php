@extends('layouts.auth-v1.main')

@section('content')
<div class="card">
    <div class="card-header mb-4 border-bottom">
        <h4 class="m-0 p-0">Edit Alternatif Wisata</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('spk/destinasi/kategori/wisata.update', encrypt($item->id)) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="mb-3">
                    <label for="nama-kategori-wisata" class="form-label">Nama Kategori Wisata</label>
                    <input type="text" class="form-control form-control-md" id="nama-kategori-wisata" name="name" placeholder="Nama Kategori Wisata" value="{{ old('name', $item->name ?? '') }}" required />
                </div>
                <div class="col-md-12 mt-4 border-top">
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('spk/destinasi/kategori/wisata.index') }}" class="btn btn-md btn-danger me-2"><i class="bx bx-left-arrow"></i> Kembali</a>
                        <button type="submit" class="btn btn-md btn-success"><i class="bx bx-file"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection