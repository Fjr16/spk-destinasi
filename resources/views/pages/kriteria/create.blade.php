@extends('layouts.auth-v1.main')

@section('content')
<div class="card">
    <div class="card-header mb-4 border-bottom">
        <h4 class="m-0 p-0">Tambah Kriteria</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('spk/destinasi/kriteria.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label koder="nama-kriteria" class="form-label">Kode Kriteria</label>
                        <input type="text" class="form-control form-control-md" id="kode-kriteria" name="kode" placeholder="Kode" value="{{ old('kode') }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="nama-kriteria" class="form-label">Nama Kriteria</label>
                        <input type="text" class="form-control form-control-md" id="nama-kriteria" name="name" placeholder="Nama" value="{{ old('name') }}" required />
                    </div>
                    <div class="mb-3">
                        <label for="tipe-kriteria" class="form-label">Tipe Kriteria</label>
                        <select class="form-select form-control" id="tipe-kriteria" aria-label="Default select example" name="tipe">
                          <option selected disabled>-- Pilih Tipe Kriteria --</option>
                          <option value="cost" {{ old('tipe') == 'cost' ? 'selected' : '' }}>Cost</option>
                          <option value="benefit" {{ old('tipe') == 'benefit' ? 'selected' : '' }}>Benefit</option>
                        </select>
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