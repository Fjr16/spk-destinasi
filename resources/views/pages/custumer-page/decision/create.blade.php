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
                        {{-- <div id="floatingInputHelp" class="form-text">We'll never share your details with anyone else.</div> --}}
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Masukkan titik lokasi keberangkatan anda" name="lokasi_user" aria-describedby="floatingInputHelp" value="{{ old('lokasi_user') }}" required/>
                        <label for="floatingInput">Lokasi Keberangkatan</label>
                    </div>
                </div>
                <div class="col-md-4 border p-4">
                    <div class="mb-3">
                        <h5 class="mb-0">Tingkat Kepentingan / Bobot (%)</h5>
                        <small class="fst-italic">
                            * Total Tingkat Kepentingan atau bobot harus sama dengan 100 %
                        </small>
                    </div>
                    @foreach ($data as $index => $item)         
                        <div class="mb-3">
                            <label class="form-label" for="{{ $item->name ?? '' }}">{{ $item->name ?? 'unknown' }}</label>
                            <div class="input-group">
                                <input type="hidden" name="kriteria_id[]" value="{{ $item->id ?? 'error' }}">
                                <input type="number" class="form-control" min="0" max="100" placeholder="0-100" aria-describedby="basic-addon1" id="{{ $item->name ?? '' }}" name="bobot[]" value="{{ old('bobot[]', 20) }}" required/>
                                <span class="input-group-text" id="basic-addon1">%</span>
                            </div>
                        </div>
                    @endforeach
                    <div class="border-top">
                        <div class="input-group mt-2">
                            <input type="number" class="form-control bg-dark text-white" placeholder="Total Kepentingan" aria-describedby="basic-addon1" id="total_bobot" value="100" readonly />
                            <span class="input-group-text bg-dark text-white" id="basic-addon1">%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center">
                <a href="" class="btn btn-md btn-danger me-2"><i class="bx bx-x"></i> Batal</a>
                <button type="submit" class="btn btn-md btn-primary"><i class='bx bx-sync'></i> Proses</button>
            </div>
        </form>
    </div>
</div>
    
@endsection