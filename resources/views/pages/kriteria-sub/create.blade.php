@extends('layouts.auth-v1.main')

@section('content')
<div class="card">
    <div class="card-header mb-4 border-bottom">
        <h4 class="m-0 p-0">Tambah Sub Kriteria <span class="text-primary">{{ $item->name ?? '-' }}</span></h4>
    </div>
    <div class="card-body">
        <form action="{{ route('spk/destinasi/sub/kriteria.store', encrypt($item->id)) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="nama-sub-kriteria" class="form-label">Nama Sub Kriteria</label>
                        <input type="text" class="form-control form-control-md" id="nama-sub-kriteria" name="name" placeholder="Nama" value="{{ old('name') }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="bobot-kriteria" class="form-label">Bobot (Nilai)</label>
                        <input type="number" class="form-control form-control-md" id="bobot-kriteria" name="bobot" placeholder="Bobot" value="{{ old('bobot') }}" required />
                    </div>
                </div>
                <div class="col-md-12 mt-4 border-top">
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('spk/destinasi/kriteria.index') }}" class="btn btn-md btn-danger me-2"><i class="bx bx-left-arrow"></i> Kembali</a>
                        <button type="submit" class="btn btn-md btn-success"><i class="bx bx-file"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection