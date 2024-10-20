<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">
            </span>
            <span class="app-brand-text menu-text fw-bolder fs-4 ms-2 mt-1">SPK Destinasi</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">

        {{-- Main --}}
        {{-- <li class="menu-header small text-uppercase">
            <span class="menu-header-text text-secondary">Main</span>
        </li> --}}
        <!-- Dashboard -->
        <li class="menu-item {{ $title === 'Dashboard' ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        {{-- <li class="menu-header small text-uppercase">
            <span class="menu-header-text text-white">Master</span>
        </li> --}}
        <li class="menu-item {{ $menu == 'data' ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                {{-- <i class="menu-icon tf-icons bx bxs-cog"></i> --}}
                <i class='menu-icon tf-icons bx bx-box'></i>
                <div>Data</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $title == 'alternative' ? 'active' : '' }}">
                    <a href="{{ route('spk/destinasi/alternative.index') }}" class="menu-link">
                        <div>Alternatif Wisata (A)</div>
                    </a>
                </li>
                <li class="menu-item {{ $title == 'kriteria' ? 'active' : '' }}">
                    <a href="{{ route('spk/destinasi/kriteria.index') }}" class="menu-link">
                        <div>Kriteria (C)</div>
                    </a>
                </li>
                <li class="menu-item {{ $title == 'penilaian' ? 'active' : '' }}">
                    <a href="{{ route('spk/destinasi/penilaian.index') }}" class="menu-link">
                        <div>Penilaian (R)</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ $title === 'Kategori Wisata' ? 'active' : '' }}">
            <a href="{{ route('spk/destinasi/kategori/wisata.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div>Kategori Wisata</div>
            </a>
        </li>
        
    </ul>
</aside>
