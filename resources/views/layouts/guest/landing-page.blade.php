<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPK | Home Page</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    {{-- css Leaflet untuk maps --}}
    <link rel="stylesheet" href="{{ asset('/assets/vendor/leaflet/leaflet.css') }}">
    {{-- Leaflet --}}

    <!-- Page CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    {{-- css --}}
    <style>
        .navbar {
            background-color: #fff;
            /* untuk membuat navbar transparan */
            /* background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px); */

            height: 80px;
            margin: 20px;
            border-radius: 16px;
            padding: 0.5rem;
        }
        .navbar-brand {
            font-weight: 500;
            color: #009970;
            font-size: 24px;
            transition: 0.3s color;
        }
        .login-button {
            background-color: #009970;
            color: #fff;
            font-size: 14px;
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            transition: 0.3s background-color;
        }
        .login-button:hover {
            background-color: #00b383;
        }
        .logout-button {
            background-color: #f70808;
            color: #fff;
            font-size: 14px;
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            transition: 0.3s background-color;
        }
        .logout-button:hover {
            background-color: #b30000;
        }
        .navbar-toggler {
            border: none;
            font-size: 1.25rem;
        }
        .navbar-toggler:focus, .btn-close:focus {
            box-shadow: none;
            outline: none;
        }

        .nav-link {
            color: #666777;
            font-weight: 500;
            position: relative;
        }
        .nav-link:hover, .nav-link:active {
            color: #000;
        }

        @media(min-width:991px){
            .nav-link::before{
                content: "";
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 0;
                height: 2px;
                background-color: #009970;
                visibility: hidden;
                transition: 0.3s ease-in-out;
            }
            .nav-link:hover::before, .nav-link.active::before {
                width: 100%;
                visibility: visible;
            }
        }
    </style>
    <style>
         /* ========================= */
    /*        HERO SECTION       */
    /* ========================= */
    .hero-section {
        position: relative;
        /* background: url('/assets/img/bg-new.jpeg') no-repeat center center; */
        background: url('/assets/img/bg-new.jpeg') no-repeat center center;
        background-size: cover;
        width: 100%;
        min-height: 100vh;
        color: #ffffff;
    }
    .hero-section::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at top left, rgba(0,153,112,0.35), transparent 60%),
            rgba(0,0,0,0.72);
        z-index: 0;
    }
    .hero-section .container {
        position: relative;
        z-index: 1;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .hero-eyebrow {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: .18em;
        color: #a7f3d0;
        margin-bottom: .75rem;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
    }
    .hero-eyebrow span {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: #22c55e;
    }

    .hero-title {
        font-size: clamp(2rem, 3vw, 2.8rem);
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: .5rem;
    }
    .hero-title span.highlight {
        color: #facc15;
    }

    .hero-tagline {
        font-size: 0.98rem;
        max-width: 520px;
        color: #e5e7eb;
        opacity: .9;
        margin-bottom: 1.5rem;
    }

    .hero-cta {
        display: flex;
        flex-wrap: wrap;
        gap: .75rem;
        margin-bottom: 1.25rem;
    }

    .hero-cta .btn-main {
        border-radius: 999px;
        padding: .55rem 1.5rem;
        font-weight: 500;
        font-size: .95rem;
    }
    .hero-cta .btn-outline {
        border-radius: 999px;
        padding: .55rem 1.4rem;
        font-size: .9rem;
    }

    .hero-pills {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
        font-size: 0.8rem;
    }
    .hero-pill {
        border-radius: 999px;
        padding: .25rem .75rem;
        background: rgba(15,23,42,0.7);
        border: 1px solid rgba(148,163,184,0.6);
        color: #e5e7eb;
    }

    /* Kartu promo di sisi kanan */
    .hero-highlight-card {
        background: rgba(15,23,42,0.92);
        border-radius: 18px;
        padding: 1rem 1.1rem;
        border: 1px solid rgba(148,163,184,0.55);
        box-shadow: 0 16px 40px rgba(0,0,0,0.65);
    }
    .hero-highlight-title {
        font-size: .9rem;
        font-weight: 600;
        margin-bottom: .25rem;
    }
    .hero-highlight-text {
        font-size: .78rem;
        color: #cbd5e1;
        margin-bottom: .6rem;
    }
    .hero-highlight-badges {
        display: flex;
        flex-wrap: wrap;
        gap: .35rem;
        font-size: .78rem;
    }
    .hero-highlight-badge {
        border-radius: 999px;
        padding: .2rem .6rem;
        background: rgba(34,197,94,0.15);
        border: 1px solid rgba(74,222,128,0.4);
    }

    @media (max-width: 767.98px) {
        .navbar {
            margin: 10px;
        }
        .hero-section .container {
            justify-content: center;
            text-align: center;
        }
        .hero-tagline {
            margin-left: auto;
            margin-right: auto;
        }
        .hero-cta {
            justify-content: center;
        }
        .hero-highlight-card {
            margin-top: 1.5rem;
        }
    }
    </style>
    @stack('page-css')
  </head>
  <body>
    {{-- nav start --}}
    {{-- <nav class="navbar navbar-expand-lg fixed-top"> --}}
    <nav class="navbar navbar-expand-lg {{ Route::is('landing.page') ? 'fixed-top' : '' }}">
        <div class="container">
            <a class="navbar-brand me-auto" href="{{ route('landing.page') }}">SPK AHP</a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Logo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 {{ Route::is('landing.page') ? 'active' : '' }}" aria-current="page" href="{{ route('landing.page') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 {{ Route::is('spk/destinasi/wisata.*') ? 'active' : '' }}" href="{{ route('spk/destinasi/wisata.index') }}">Destinasi Wisata</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 {{ Route::is('preferensi.*') ? 'active' : '' }}" href="{{ route('preferensi.rekomendasi') }}">Preferensi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 {{ Route::is('spk/destinasi/rekomendasi.*') ? 'active' : '' }}" href="{{ route('spk/destinasi/rekomendasi.create') }}">Rekomendasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 {{ Route::is('spk/destinasi/panduan.*') ? 'active' : '' }}" href="{{ route('spk/destinasi/panduan.index') }}">Panduan Aplikasi</a>
                        </li>
                    </ul>
                </div>
            </div>
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button" style="border: none">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="login-button">Login</a>
            @endauth
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    {{-- nav end --}}
    {{-- hero start --}}
    @if (Route::is('landing.page'))
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center w-100">
                {{-- Kolom kiri: promo utama --}}
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="hero-eyebrow">
                        <span></span> SPK Destinasi Wisata Berbasis AHP
                    </div>
                    <h1 class="hero-title">
                        Temukan <span class="highlight">Destinasi Wisata Terbaik</span><br>
                        Sesuai Preferensi Anda.
                    </h1>
                    <p class="hero-tagline">
                        Aplikasi ini membantu Anda memilih destinasi wisata secara objektif dan terukur,
                        dengan mempertimbangkan berbagai kriteria seperti harga, fasilitas, aksesibilitas,
                        dan kenyamanan. Rekomendasi yang dihasilkan <strong>akurasi tinggi</strong> dan mudah dipahami.
                    </p>

                    <div class="hero-cta">
                        <a href="{{ route('preferensi.rekomendasi') }}" class="btn btn-success btn-main">
                            Atur Preferensi Sekarang
                        </a>
                        <a href="{{ route('spk/destinasi/wisata.index') }}" class="btn btn-outline-light btn-outline">
                            Lihat Daftar Destinasi
                        </a>
                    </div>

                    <div class="hero-pills">
                        <span class="hero-pill">✅ Perhitungan AHP otomatis</span>
                        <span class="hero-pill">✅ Rekomendasi berbasis kriteria</span>
                        <span class="hero-pill">✅ Tampilan sederhana & mudah dipakai</span>
                    </div>
                </div>

                {{-- Kolom kanan: kartu highlight promosi --}}
                <div class="col-lg-5">
                    <div class="hero-highlight-card">
                        <div class="hero-highlight-title">
                            Kenapa menggunakan aplikasi ini?
                        </div>
                        <p class="hero-highlight-text">
                            Anda tidak perlu lagi bingung memilih tempat liburan. Cukup tentukan
                            apa yang Anda prioritaskan, dan sistem akan mengurutkan destinasi wisata
                            terbaik untuk Anda secara otomatis.
                        </p>
                        <div class="hero-highlight-badges mb-2">
                            <span class="hero-highlight-badge">⚙️ Berbasis Metode AHP</span>
                            <span class="hero-highlight-badge">📊 Transparan & Terukur</span>
                            <span class="hero-highlight-badge">🧭 Cocok untuk perencanaan perjalanan</span>
                        </div>
                        <small class="text-secondary d-block mt-1">
                            Mulai dari sekarang, proses memilih destinasi wisata menjadi
                            lebih <strong>terarah, cepat,</strong> dan <strong>nyaman</strong>.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- hero end --}}

    <div class="content">
        @yield('content')
    </div>

    <script src="{{ asset('/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

    {{-- js Leaflet untuk maps --}}
    <script src="{{ asset('/assets/vendor/leaflet/leaflet.js') }}"></script>
    {{-- Leaflet --}}

    {{-- notyf --}}
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        // untuk leaflet map
        let map = L.map('map').setView([-0.9483107301737814, 100.37339582797605], 13);

        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var tempMarker;

        $(document).ready(function(){
            // handle old location
            var loc = $('#maps-lokasi').val();
            loc = loc.split(", ");
            if (loc) {
                L.marker([loc[0], loc[1]])
                .addTo(map)
                .bindPopup(`
                    Koordinat lokasi LatLng(${loc[0]}, ${loc[1]}) <br>
                    <a href="https://www.google.com/maps?q=${loc[0]},${loc[1]}" 
                        target="_blank" 
                        class="btn btn-primary btn-sm text-white">
                            Buka di Google Maps
                    </a>
                    `).
                openPopup();
            }
        });

        function onMapClick(e) {
             // Cek jika input readonly
            if ($('#maps-lokasi').prop('readonly')) {
                return; // hentikan fungsi jika readonly
            }
            if (tempMarker) {
                map.removeLayer(tempMarker)
            }
            tempMarker = L.marker(e.latlng)
                .addTo(map);

            var currentLatLang = e.latlng.lat + ', ' + e.latlng.lng;

            $('#maps-lokasi').val(currentLatLang);
            // $('#link-maps').attr('href', 'https://www.google.com/maps?q='+currentLatLang);
        }

        map.on('click', onMapClick);
    </script>
    <script>
        const notyf = new Notyf({
                duration: 3000,
                dismissible:true,
                position:{
                x:'right',
                y:'top',
            }
        });
        const notif = new Notyf({
                duration: 3000,
                dismissible:true,
                position:{
                x:'right',
                y:'top',
            }
        });

        @if (session('success'))
            notyf.success("{{ session('success') }}");
        @endif

        @if (session('error') || session('errors'))
            notyf.error("{{ session('error') ?? session('errors') }}");
        @endif
    </script>
    @stack('scripts')
  </body>
</html>