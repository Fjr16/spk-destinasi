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
        <li class="menu-item {{ $title === 'Dashbo' ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        {{-- <li class="menu-header small text-uppercase">
            <span class="menu-header-text text-white">Master</span>
        </li> --}}
        <li class="menu-item {{ $menu == 'Setting' ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-cog"></i>
                <div>Master</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $title == 'Kategori Pasien' ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <div>Menu 1</div>
                    </a>
                </li>
                <li class="menu-item {{ $title == 'Pekerjaan' ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <div>Menu 2</div>
                    </a>
                </li>
                <li class="menu-item {{ $title == 'Unit' ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <div>Menu 3</div>
                    </a>
                </li>
                <li class="menu-item {{ $title == 'Specialist' ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <div>Menu 4</div>
                    </a>
                </li>
            </ul>
        </li>
        
    </ul>
</aside>
