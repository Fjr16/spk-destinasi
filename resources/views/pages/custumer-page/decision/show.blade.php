@extends('layouts.guest.landing-page')

@push('page-css')
<style>
    /* ====== GLOBAL ====== */
    body {
        background: url('/assets/img/bg-old.jpg') no-repeat center center fixed;
        background-size: cover;
        color: #f9fafb;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    body::before {
        content: "";
        position: fixed;
        inset: 0;
        background: radial-gradient(circle at top, rgba(255,255,255,0.08), transparent 55%),
                    rgba(0,0,0,0.72);
        z-index: 0;
    }

    .content-wrapper {
        padding: 40px 0 30px;
        position: relative;
        z-index: 1;
    }

    .page-title {
        letter-spacing: .06em;
        text-transform: uppercase;
        font-weight: 700;
        font-size: 1.4rem;
        color: #e5e7eb;
    }

    /* ====== CARD UTAMA OVERLAY ====== */
    .overlay-card {
        background: linear-gradient(135deg, rgba(31,41,55,0.92), rgba(17,24,39,0.92));
        backdrop-filter: blur(16px);
        border-radius: 22px;
        border: 1px solid rgba(148,163,184,0.45);
        color: #e5e7eb;
        box-shadow: 0 20px 45px rgba(0,0,0,0.65);
    }

    .highlight-card {
        text-align: center;
    }

    /* ====== HERO IMAGE MODERN ====== */
    .hero-image-container {
        position: relative;
        width: 100%;
        height: 340px;                 /* tinggi bisa kamu adjust */
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 16px 40px rgba(0,0,0,0.55);
        background: #020617;
        margin-bottom: 24px;
    }

    .hero-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s ease, filter .5s ease;
        filter: brightness(0.9) contrast(1.03);
    }

    .hero-image-container:hover img {
        transform: scale(1.04);
        filter: brightness(1) contrast(1.05);
    }

    .hero-gradient-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(to top, rgba(0,0,0,0.75) 0%, transparent 45%),
            radial-gradient(circle at top left, rgba(15,23,42,0.75), transparent 55%);
        pointer-events: none;
    }

    /* ====== STRIP THUMBNAIL ====== */
    .thumb-strip {
        display: flex;
        flex-wrap: nowrap;
        gap: 14px;
        overflow-x: auto;
        padding: 10px 2px 4px;
        margin-top: 0.75rem;
        justify-content: center;
    }

    .thumb-strip::-webkit-scrollbar {
        height: 6px;
    }
    .thumb-strip::-webkit-scrollbar-track {
        background: transparent;
    }
    .thumb-strip::-webkit-scrollbar-thumb {
        background: rgba(148,163,184,0.5);
        border-radius: 999px;
    }

    .thumb-item {
        flex: 0 0 180px;
        border: none;
        background: transparent;
        padding: 0;
        cursor: pointer;
    }

    .thumb-item img {
        width: 100%;
        height: 110px;
        object-fit: cover;
        border-radius: 18px;
        opacity: .7;
        transition: transform .2s ease, opacity .2s ease, box-shadow .2s ease, filter .2s ease;
        filter: saturate(0.95);
    }

    .thumb-item img:hover {
        opacity: 1;
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(0,0,0,.6);
        filter: saturate(1.05);
    }

    .badge-rank {
        font-size: .9rem;
        padding: 6px 14px;
        border-radius: 999px;
        letter-spacing: .04em;
    }

    /* ====== LIST REKOMENDASI LAINNYA ====== */
    .list-card {
        border-radius: 16px;
        border: 1px solid rgba(148,163,184,0.35);
        background: radial-gradient(circle at top left, rgba(30,64,175,0.35), transparent 55%),
                    rgba(15,23,42,0.96);
        color: #e5e7eb;
    }

    .list-card img {
        width: 140px;
        height: 100px;
        object-fit: cover;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.55);
    }

    .list-card h5 {
        margin-bottom: .2rem;
    }

    .list-card .badge-rank {
        font-size: .8rem;
    }

    .btn-primary,
    .btn-outline-primary {
        border-radius: 999px;
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
            $images = [];
            if ($top->foto) {
                $images[] = $top->foto;
            }
            $images = array_merge($images, $top->alternativeImages->pluck('img_path')->toArray());
        @endphp

        <div class="highlight-card mb-5">
            <h3 class="fw-bold text-warning text-uppercase">{{ $top->name }}</h3>

            {{-- HERO IMAGE --}}
            @if(!empty($images))
                @php $heroSrc = asset('storage/'.$images[0]); @endphp
                <a href="{{ $heroSrc }}" target="_blank" id="hero-link">
                    <div class="hero-image-container">
                        <img src="{{ $heroSrc }}" id="hero-img" alt="Foto Wisata">
                        <div class="hero-gradient-overlay"></div>
                    </div>
                </a>
            @endif

            {{-- <h5 class="mt-2 text-center">Skor AHP:
                <span class="text-warning fw-bold">{{ $data[0]['skor_akhir'] }}</span>
            </h5> --}}
            <h5 class="mt-2 mb-1">
                Skor AHP:
                <span class="text-warning fw-bold">{{ $data[0]['skor_akhir'] }}</span>
            </h5>

            <span class="badge bg-warning text-dark badge-rank">Peringkat 1</span>

            {{-- STRIP GAMBAR KECIL (tanpa teks) --}}
            @if(count($images) > 0)
                <div class="thumb-strip">
                    @foreach ($images as $img)
                        @php $src = asset('storage/'.$img); @endphp
                        <button type="button"
                                class="thumb-item"
                                onclick="changeHeroImage('{{ $src }}')">
                            <img src="{{ $src }}" alt="Foto wisata">
                        </button>
                    @endforeach
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('spk/destinasi/wisata.show', encrypt($top->id)) }}"
                   class="btn btn-lg btn-primary px-4">
                    Lihat Selengkapnya...
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
            @endphp

            <div class="card list-card mb-3 p-3 shadow-sm">
                <div class="d-flex align-items-center">

                    {{-- FOTO --}}
                    <a href="{{ asset('storage/' . $w->foto ?? 'default.jpg') }}" target="_blank">
                        <img src="{{ asset('storage/' . $w->foto ?? 'default.jpg') }}" class="me-3">
                    </a>

                    <div class="flex-grow-1">
                        <h5 class="mb-1 text-capitalize">{{ $w->name }}</h5>
                        <small class="fw-bold">Skor: 
                            <span class="text-warning">{{ $item['skor_akhir'] }}</span>
                        </small>
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
@push('scripts')
<script>
    function changeHeroImage(src) {
        const heroImg  = document.getElementById('hero-img');
        const heroLink = document.getElementById('hero-link');

        if (heroImg)  heroImg.src  = src;
        if (heroLink) heroLink.href = src;
    }
</script>
@endpush
