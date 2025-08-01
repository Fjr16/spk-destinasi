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
                        <label for="nama-sub-kriteria" class="form-label">Label</label>
                        <input type="text" class="form-control form-control-md" id="nama-sub-kriteria" name="label" placeholder="Label sub kriteria" value="{{ old('label') }}" required />
                    </div>
                    @if ($item->jenis == 'kuantitatif')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="min_value" class="form-label">Dari</label>
                            <input type="number" step="any" min="0" class="form-control form-control-md" id="min_value" name="min_value" placeholder="nilai minimum" value="{{ old('min_value') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*g, '$1')" />
                        </div>
                        <div class="col-md-6">
                            <label for="max_value" class="form-label">Hingga</label>
                            <input type="number" step="any" min="0" class="form-control form-control-md" id="max_value" name="max_value" placeholder="nilai maksimum" value="{{ old('max_value') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*g, '$1')"/>
                        </div>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="bobot-kriteria" class="form-label">Bobot</label>
                        <input type="number" class="form-control form-control-md" id="bobot-kriteria" name="bobot" placeholder="Bobot" value="{{ old('bobot') }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
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