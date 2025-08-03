<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/dashboard" class="app-brand-link">
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
            <a href="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        {{-- <li class="menu-header small text-muted">
            <span class="menu-header-text text-uppercase">Master Data</span>
        </li> --}}

        @canany(['admin', 'pengelola'])
        <li class="menu-item {{ $title === 'alternative' ? 'active' : '' }}">
            <a href="{{ route('spk/destinasi/alternative.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-map-pin"></i>
                <div data-i18n="Analytics">Destinasi Wisata</div>
            </a>
        </li>
        @endcanany
        @can('admin')            
        <li class="menu-item {{ $title === 'kriteria' ? 'active' : '' }}">
            <a href="{{ route('spk/destinasi/kriteria.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-check"></i>
                <div data-i18n="Analytics">Kriteria AHP</div>
            </a>
        </li>
        @endcan

        {{-- <li class="menu-item {{ $menu == 'data' ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bx-box'></i>
                <div>Data AHP</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $title == 'alternative' ? 'active' : '' }}">
                    <a href="{{ route('spk/destinasi/alternative.index') }}" class="menu-link">
                        <div>Alternatif Wisata</div>
                    </a>
                </li>
                @can('admin')
                <li class="menu-item {{ $title == 'kriteria' ? 'active' : '' }}">
                    <a href="{{ route('spk/destinasi/kriteria.index') }}" class="menu-link">
                        <div>Kriteria</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li> --}}

        @can('admin')      
            <li class="menu-item {{ $title === 'Kategori Wisata' ? 'active' : '' }}">
                <a href="{{ route('spk/destinasi/kategori/wisata.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-category"></i>
                    <div>Kategori Wisata</div>
                </a>
            </li>
            <li class="menu-item {{ $title === 'Management User' ? 'active' : '' }}">
                <a href="{{ route('spk/destinasi/user.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div>Manajemen user</div>
                </a>
            </li>
        @endcan
        
    </ul>
</aside>
