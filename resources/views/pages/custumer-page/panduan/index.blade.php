@extends('layouts.guest.landing-page')

@push('page-css')
<style>
    /* ====== GLOBAL BACKGROUND ====== */
    body {
        background: url('/assets/img/bg-new.jpeg') no-repeat center center fixed;
        background-size: cover;
        color: #f9fafb;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }
    body::before {
        content: "";
        position: fixed;
        inset: 0;
        background: radial-gradient(circle at top, rgba(255,255,255,0.08), transparent 55%),
                    rgba(0,0,0,0.78);
        z-index: 0;
    }

    .content-wrapper {
        padding: 40px 0 40px;
        position: relative;
        z-index: 1;
    }

    /* ====== PAGE TITLE / HERO ====== */
    .guide-hero {
        text-align: center;
        margin-bottom: 32px;
    }

    .guide-title {
        font-size: 2.1rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: #e5e7eb;
        text-shadow: 0 4px 18px rgba(0,0,0,0.7);
        margin-bottom: .5rem;
    }

    .guide-subtitle {
        max-width: 580px;
        margin: 0 auto;
        font-size: .98rem;
        color: #cbd5f5;
        opacity: .9;
    }

    .guide-title-underline {
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg,#38bdf8,#facc15);
        border-radius: 999px;
        margin: 18px auto 0;
    }

    /* ====== MAIN CARD (GLASS) ====== */
    .overlay-card {
        background: linear-gradient(135deg, rgba(31,41,55,0.96), rgba(15,23,42,0.96));
        border-radius: 22px;
        border: 1px solid rgba(148,163,184,0.5);
        box-shadow: 0 18px 45px rgba(0,0,0,0.7);
        padding: 24px 26px;
        color: #e5e7eb;
    }

    /* ====== HEADER DI DALAM CARD ====== */
    .guide-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        background: rgba(15,118,110,0.18);
        border-radius: 999px;
        border: 1px solid rgba(45,212,191,0.35);
        color: #a5f3fc;
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .12em;
        margin-bottom: 18px;
    }

    .guide-badge i {
        font-size: 1rem;
    }

    /* ====== STEP GRID ====== */
    .guide-steps {
        display: grid;
        grid-template-columns: repeat(2,minmax(0,1fr));
        gap: 18px;
    }

    @media (max-width: 768px) {
        .guide-steps {
            grid-template-columns: 1fr;
        }
    }

    .guide-step-card {
        position: relative;
        border-radius: 18px;
        padding: 16px 16px 14px 16px;
        background: radial-gradient(circle at top left, rgba(59,130,246,0.25), transparent 55%),
                    rgba(15,23,42,0.95);
        border: 1px solid rgba(148,163,184,0.4);
        box-shadow: 0 12px 30px rgba(0,0,0,0.6);
        display: flex;
        gap: 12px;
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }

    .guide-step-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 40px rgba(0,0,0,0.75);
        border-color: rgba(248,250,252,0.6);
    }

    .step-number {
        min-width: 38px;
        height: 38px;
        border-radius: 999px;
        background: linear-gradient(135deg,#f97316,#facc15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #111827;
        font-size: .95rem;
        box-shadow: 0 6px 15px rgba(251,191,36,0.7);
    }

    .step-content-title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 600;
        color: #f9fafb;
    }

    .step-content-text {
        margin: 4px 0 0 0;
        font-size: .92rem;
        color: #cbd5e1;
    }

    /* ====== EXTRA SECTION (TIPS) ====== */
    .guide-extra {
        margin-top: 26px;
        padding-top: 18px;
        border-top: 1px dashed rgba(148,163,184,0.45);
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 14px;
        font-size: .9rem;
    }

    .guide-extra-col-title {
        font-weight: 600;
        margin-bottom: 4px;
        color: #e5e7eb;
    }

    .guide-extra-list {
        padding-left: 1.1rem;
        margin: 0;
        color: #cbd5e1;
    }

    .guide-extra-list li + li {
        margin-top: 2px;
    }

    .guide-extra-highlight {
        background: rgba(56,189,248,0.2);
        border-radius: 14px;
        padding: 10px 13px;
        border: 1px solid rgba(56,189,248,0.5);
        color: #e0f2fe;
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <div class="container">

        {{-- HERO TITLE --}}
        <div class="guide-hero">
            <div class="guide-title">Panduan Penggunaan Aplikasi</div>
            <p class="guide-subtitle">
                Pelajari langkah demi langkah bagaimana menggunakan Sistem Pendukung Keputusan
                (SPK) Destinasi Wisata untuk menemukan tujuan liburan terbaik sesuai preferensi Anda.
            </p>
            <div class="guide-title-underline"></div>
        </div>

        {{-- MAIN GUIDE CARD --}}
        <div class="overlay-card">

            <span class="guide-badge">
                <i class="bx bx-compass"></i> Quick Start Guide
            </span>

            <div class="mb-3">
                <h5 class="mb-1">Alur Singkat Penggunaan</h5>
                <small class="text-muted">
                    Ikuti urutan menu berikut untuk mendapatkan rekomendasi destinasi wisata yang paling sesuai.
                </small>
            </div>

            {{-- STEP GRID --}}
            <div class="guide-steps">
                {{-- 1. Beranda --}}
                <div class="guide-step-card">
                    <div class="step-number">1</div>
                    <div>
                        <p class="step-content-title">Beranda</p>
                        <p class="step-content-text">
                            Halaman utama aplikasi yang menyajikan gambaran umum tentang sistem.
                            Dari sini, Anda dapat mengakses semua menu penting untuk memulai proses pencarian destinasi wisata.
                        </p>
                    </div>
                </div>

                {{-- 2. Destinasi Wisata --}}
                <div class="guide-step-card">
                    <div class="step-number">2</div>
                    <div>
                        <p class="step-content-title">Destinasi Wisata</p>
                        <p class="step-content-text">
                            Menampilkan daftar destinasi wisata beserta foto, lokasi, deskripsi, dan fasilitas.
                            Gunakan halaman ini untuk mengenal setiap destinasi sebelum menentukan pilihan.
                        </p>
                    </div>
                </div>

                {{-- 3. Preferensi --}}
                <div class="guide-step-card">
                    <div class="step-number">3</div>
                    <div>
                        <p class="step-content-title">Preferensi</p>
                        <p class="step-content-text">
                            Atur prioritas kriteria seperti harga, aksesibilitas, fasilitas, dan kenyamanan.
                            Nilai preferensi inilah yang akan digunakan sistem dalam perhitungan AHP.
                        </p>
                    </div>
                </div>

                {{-- 4. Rekomendasi --}}
                <div class="guide-step-card">
                    <div class="step-number">4</div>
                    <div>
                        <p class="step-content-title">Rekomendasi</p>
                        <p class="step-content-text">
                            Sistem menampilkan urutan destinasi wisata dari skor tertinggi hingga terendah.
                            Anda bisa melihat detail skor AHP serta memilih destinasi yang paling cocok.
                        </p>
                    </div>
                </div>

                {{-- 5. Panduan Aplikasi --}}
                <div class="guide-step-card">
                    <div class="step-number">5</div>
                    <div>
                        <p class="step-content-title">Panduan Aplikasi</p>
                        <p class="step-content-text">
                            Halaman ini menjadi referensi jika Anda lupa alur penggunaan, sekaligus menjelaskan
                            fungsi setiap menu dan tips mendapatkan rekomendasi yang lebih tepat sasaran.
                        </p>
                    </div>
                </div>

                {{-- 6. (Opsional) Tentang Metode --}}
                <div class="guide-step-card">
                    <div class="step-number">6</div>
                    <div>
                        <p class="step-content-title">Login / Logout</p>
                        <p class="step-content-text">
                            Menu untuk masuk atau keluar dari akun pengguna. Dengan login,
                            preferensi dan riwayat rekomendasi Anda dapat disimpan untuk penggunaan di masa mendatang.
                        </p>
                    </div>
                </div>
            </div>

            {{-- EXTRA SECTION: TIPS & INFO --}}
            <div class="guide-extra mt-3">
                <div>
                    <div class="guide-extra-col-title">Tips Menggunakan Aplikasi</div>
                    <ul class="guide-extra-list">
                        <li>Isi preferensi dengan jujur sesuai kebutuhan perjalanan Anda.</li>
                        <li>Bandingkan beberapa destinasi sebelum memutuskan.</li>
                        <li>Cek detail lokasi dan fasilitas sebelum berangkat.</li>
                    </ul>
                </div>

                <div class="guide-extra-highlight">
                    <strong>Catatan:</strong><br>
                    Rekomendasi yang ditampilkan merupakan hasil perhitungan otomatis berdasarkan
                    kriteria dan bobot yang Anda tetapkan. Anda tetap bebas memilih destinasi mana pun
                    yang dirasa paling menarik.
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
