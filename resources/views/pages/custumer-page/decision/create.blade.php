@extends('layouts.guest.landing-page')

@push('page-css')
    <style>
      body {
        background: url('/assets/img/bg-old.jpg') no-repeat center center fixed;
        background-size: cover;
        color: white;
      }
      body::before {
          background-color: rgba(0, 0, 0, 0.6);
          content: "";
          position: fixed;
          top: 0;
          right: 0;
          bottom: 0;
          left: 0;
      }

      .content-wrapper {
        /* padding-top: 120px; */
        padding-bottom: 30px;
        position: relative;
        z-index: 1;
      }

      .card {
        background-color: rgba(255, 255, 255, 0.9);
        border: none;
      }

      .card-title, .card-text {
        color: #333;
      }
      
      .page-title {
        color: #ffffff;
        text-align: center;
        margin-bottom: 40px;
        font-size: 2.5rem;
        font-weight: 700;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
        letter-spacing: 1px;
        animation: fadeInDown 1s ease;
        position: relative;
      }

      .page-title::after {
        content: '';
        width: 80px;
        height: 4px;
        background-color: #ffffff;
        display: block;
        margin: 15px auto 0;
        border-radius: 10px;
      }

      @keyframes fadeInDown {
        from {
          opacity: 0;
          transform: translateY(-20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .card-img-top {
          height: 250px; /* atur sesuai kebutuhan, misal 250px */
          object-fit: cover;
          border-top-left-radius: 0.75rem;
          border-top-right-radius: 0.75rem;
      }

    .card.overlay-card {
        /* background-color: rgba(255, 255, 255, 0.15); transparan putih */
        background-color: rgba(75, 75, 75, 0.4);
        backdrop-filter: blur(10px);                /* blur latar belakang */
        -webkit-backdrop-filter: blur(10px);        /* support Safari */
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    }
    .overlay-card label,
    .overlay-card h5,
    .overlay-card .form-control,
    .overlay-card .form-control::placeholder,
    .overlay-card select {
        color: white;
    }
    .overlay-card .form-control,
    .overlay-card .form-select {
        background-color: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
    }
    
    
    </style>
@endpush
@section('content')

<div class="container content-wrapper">
    <h2 class="page-title">Let's Find Your Destination !</h2>
    <div class="card overlay-card">
        <div class="card-body p-5">
            <form action="{{ route('spk/destinasi/rekomendasi.store') }}" method="POST">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-7 me-1">
                        <h5>Detail Pengguna</h5>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Masukkan nama lengkap anda" name="name" aria-describedby="floatingInputHelp" value="{{ old('name') }}" required/>
                        </div>
                        @if ($isIncludeJarak)
                            <div class="mb-3">
                                <input type="hidden" class="form-control" id="maps-lokasi" placeholder="Masukkan titik lokasi keberangkatan anda" name="lokasi_user" value="{{ old('lokasi_user') }}" required/>
                                <label for="map" class="form-label">Lokasi User</label>
                                <div id="map" style="width: 100%; height: 300px; border-radius:4px;"></div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <h5 class="mb-0">Filter Pencarian</h5>
                            <small class="fst-italic">
                                Filter membantu pengguna agar dapat memilih rekomendasi wisata berdasarkan keinginan atau kemauannya
                            </small>
                        </div>
                        {{-- travel category filter --}}
                        <div class="mb-3">
                            <label class="form-label" for="kategori-wisata">Kategori Wisata</label>
                            <select class="form-control bg-dark" id="kategori-wisata" name="travel_category_id">
                                <option value="" selected>--- Tanpa Filter ---</option>
                                @foreach ($travelCategory as $tc)
                                    <option value="{{ $tc->id }}">{{ $tc->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        @foreach ($data as $index => $item)
                        @if ($item->name === 'Jarak Tempuh')
                        <label class="form-label" for="{{ $item->name ?? '' }}">{{ $item->name ?? 'unknown' }}</label>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <select class="form-control" id="operator-jarak" name="operator_jarak" style="background-color:#333;">
                                    <option value="=">=</option>
                                    <option value=">">></option>
                                    <option value="<"><</option>
                                </select>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="number" class="form-control bg-dark" placeholder="Filter Jarak Tempuh" aria-describedby="basic-addon13" name="value_jarak" style=""/>
                                    <span class="input-group-text bg-dark text-white" id="basic-addon13">Km</span>
                                  </div>
                            </div>
                        </div>
                        @else
                            <div class="mb-3">
                                <input type="hidden" name="kriteria_id[]" value="{{ $item->id ?? 'error' }}">
                                <label class="form-label" for="{{ $item->name ?? '' }}">{{ $item->name ?? 'unknown' }}</label>
                                <select class="form-select bg-dark" id="{{ $item->name ?? '' }}" aria-label="Default select example" name="sub_criteria_id[]">
                                <option value="All" selected>--- Tanpa Filter ---</option>
                                @foreach ($item->subCriterias as $sub)
                                    <option value="{{ $sub->id }}" {{ old('sub_criteria_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name ?? '-' }}</option>
                                @endforeach
                                </select>
                            </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-md-12 d-flex justify-content-center">
                    <a href="{{ route('landing.page') }}" class="btn btn-md btn-danger me-2"><i class="bx bx-x"></i> Batal</a>
                    <button type="submit" class="btn btn-md btn-primary"><i class='bx bx-sync'></i> Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>
    
@endsection