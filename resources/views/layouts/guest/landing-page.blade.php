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

        .hero-section {
            background: url('/assets/img/bg-old.jpg') no-repeat center;
            background-size: cover;
            width: 100%;
            height: 100vh;
        }
        .hero-section::before {
            background-color: rgba(0, 0, 0, 0.6);
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }
        .hero-section .container {
            height: 100vh;
            z-index: 1;
            position: relative;
        }

        .hero-section h1 {
            font-size: 1.5em;
        }
        .hero-section h2 {
            font-size: 1.2em;
        }
    </style>
    @stack('page-css')
  </head>
  <body>
    {{-- nav start --}}
    {{-- <nav class="navbar navbar-expand-lg fixed-top"> --}}
    <nav class="navbar navbar-expand-lg {{ Route::is('landing.page') ? 'fixed-top' : '' }}">
        <div class="container">
            <a class="navbar-brand me-auto" href="{{ route('landing.page') }}">Logo</a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Logo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 {{ Route::is('landing.page') ? 'active' : '' }}" aria-current="page" href="{{ route('landing.page') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 {{ Route::is('destinasi/wisata.index') ? 'active' : '' }}" href="{{ route('destinasi/wisata.index') }}">Destinasi Wisata</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 {{ Route::is('spk/destinasi/rekomendasi.*') ? 'active' : '' }}" href="{{ route('spk/destinasi/rekomendasi.create') }}">Rekomendasi</a>
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
        <div class="container d-flex align-items-center justify-content-center fs-1 text-white flex-column">
            <h1>Sistem Pendukung Keputusan</h1>
            <h2>Pemilihan Destinasi Wisata</h2>
        </div>
    </div>
    @endif
    {{-- hero end --}}

    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

    {{-- js Leaflet untuk maps --}}
    <script src="{{ asset('/assets/vendor/leaflet/leaflet.js') }}"></script>
    {{-- Leaflet --}}
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
                .bindPopup(`Koordinat lokasi LatLng(${loc[0]}, ${loc[1]})`).
                openPopup();
            }
        });      

        function onMapClick(e) {
            if (tempMarker) {
                map.removeLayer(tempMarker)
            }
            tempMarker = L.marker(e.latlng)
                .addTo(map);
    
            var currentLatLang = e.latlng.lat + ', ' + e.latlng.lng;
    
            $('#maps-lokasi').val(currentLatLang);
        }
    
        map.on('click', onMapClick);
    </script>
  </body>
</html>