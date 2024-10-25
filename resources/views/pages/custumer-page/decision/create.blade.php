@extends('layouts.auth-v2.main')

@section('content')

<div class="card">
    <div class="card-header border-bottom mb-4">
        <h4>Temukan Rekomendasi Objek Wisata Sesuai Keinginan Anda</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('spk/destinasi/rekomendasi.store') }}" method="POST">
            @csrf
            <div class="row mb-4">
                <div class="col-md-7 me-1 border p-4">
                    <h5>Detail Pengguna</h5>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Masukkan nama lengkap anda" name="name" aria-describedby="floatingInputHelp" value="{{ old('name') }}" required/>
                        <label for="floatingInput">Nama</label>
                    </div>
                    @if ($isIncludeJarak)
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="maps-lokasi" placeholder="Masukkan titik lokasi keberangkatan anda" name="lokasi_user" value="{{ old('lokasi_user') }}" required/>
                            <label for="map" class="form-label">Lokasi User</label>
                            <div id="map" style="width: 100%; height: 300px;"></div>
                        </div>
                    @endif
                </div>
                <div class="col-md-4 border p-4">
                    <div class="mb-3">
                        <h5 class="mb-0">Filter Pencarian</h5>
                        <small class="fst-italic">
                            Filter membantu pengguna agar dapat memilih rekomendasi wisata berdasarkan keinginan atau kemauannya
                        </small>
                    </div>
                    @foreach ($data as $index => $item)
                        <div class="mb-3">
                            <input type="hidden" name="kriteria_id[]" value="{{ $item->id ?? 'error' }}">
                            <label class="form-label" for="{{ $item->name ?? '' }}">{{ $item->name ?? 'unknown' }}</label>
                            <select class="form-select" id="{{ $item->name ?? '' }}" aria-label="Default select example" name="sub_criteria_id[]">
                              <option value="All" selected>--- Tanpa Filter ---</option>
                              @foreach ($item->subCriterias as $sub)
                                <option value="{{ $sub->id }}" {{ old('sub_criteria_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name ?? '-' }}</option>
                              @endforeach
                            </select>
                          </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center">
                <a href="{{ route('spk/destinasi/home.index') }}" class="btn btn-md btn-danger me-2"><i class="bx bx-x"></i> Batal</a>
                <button type="submit" class="btn btn-md btn-primary"><i class='bx bx-sync'></i> Proses</button>
            </div>
        </form>
    </div>
</div>
    
@endsection