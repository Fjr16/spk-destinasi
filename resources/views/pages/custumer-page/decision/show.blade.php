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
        top: 0; right: 0; bottom: 0; left: 0;
    }

    .content-wrapper { padding-bottom: 30px; position: relative; z-index: 1; }

    .overlay-card {
        background-color: rgba(75,75,75,0.4);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.2);
        color: white;
        box-shadow: 0 8px 32px rgba(31,38,135,0.37);
    }

    .highlight-card img {
        width: 100%;
        height: 340px;
        object-fit: cover;
        border-radius: 20px;
    }
    .carousel-item img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 10px;
    }

    .list-card img {
        width: 140px;
        height: 100px;
        object-fit: cover;
        border-radius: 12px;
    }

    .badge-rank {
        font-size: 1rem;
        padding: 6px 14px;
    }
</style>
@endpush

@section('content')
<div class="container content-wrapper">
    <h2 class="page-title text-center mb-5">TOP 5 Rekomendasi Wisata</h2>

    <div class="card overlay-card p-5">

        {{-- ========================= --}}
        {{-- REKOMENDASI PERINGKAT 1 --}}
        {{-- ========================= --}}
        @php
            $top = $data[0]['wisata'];
            // $images = json_decode($top->foto ?? '[]', true);
            $images[] = $top->foto;
        @endphp

        <div class="highlight-card mb-5">
            <h3 class="fw-bold text-warning text-uppercase">{{ $top->name }}</h3>

            {{-- FOTO UTAMA --}}
            <a href="{{ asset('/storage/' . $images[0] ?? 'default.jpg') }}" target="_blank">
                <img src="{{ asset('/storage/' . $images[0] ?? 'default.jpg') }}" class="mb-3">
            </a>

            <h5 class="mt-2">Skor AHP:
                <span class="text-warning fw-bold">{{ $data[0]['skor_akhir'] }}</span>
            </h5>

            <span class="badge bg-warning text-dark badge-rank">Peringkat 1</span>

            {{-- SLIDE FOTO --}}
            @if(count($images) > 1)
            <div id="carouselTop" class="carousel slide mt-4" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($images as $i => $img)
                    <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                        <img src="{{ asset($img) }}">
                    </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselTop" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselTop" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('spk/destinasi/wisata.show', encrypt($top->id)) }}"
                   class="btn btn-lg btn-primary px-4">
                    Detail Wisata
                </a>
            </div>
        </div>

        <hr class="border-light mb-4">

        {{-- ========================= --}}
        {{-- LIST REKOMENDASI PERINGKAT 2 - 5 --}}
        {{-- ========================= --}}
        <h4 class="mb-3 text-white">Rekomendasi Lainnya</h4>

        @foreach ($data->skip(1) as $index => $item)
            @php
                $w = $item['wisata'];
                // $img = json_decode($w->images ?? '[]', true);
            @endphp

            <div class="card list-card mb-3 p-3 shadow-sm">
                <div class="d-flex align-items-center">

                    {{-- FOTO --}}
                    <a href="{{ asset('storage/' . $w->foto ?? 'default.jpg') }}" target="_blank">
                        <img src="{{ asset('storage/' . $w->foto ?? 'default.jpg') }}" class="me-3">
                    </a>

                    <div class="flex-grow-1">
                        <h5 class="mb-1 text-dark text-capitalize">{{ $w->name }}</h5>
                        <small class="text-muted">Skor: {{ $item['skor_akhir'] }}</small>
                        <br>
                        <span class="badge bg-primary badge-rank mt-2">Peringkat {{ $item['ranking'] }}</span>
                    </div>

                    <div>
                        <a href="{{ route('spk/destinasi/wisata.show', encrypt($w->id)) }}"
                           class="btn btn-outline-primary btn-sm rounded-pill px-3">
                           Lihat
                        </a>
                    </div>
                </div>
            </div>

        @endforeach

    </div>
</div>
@endsection
