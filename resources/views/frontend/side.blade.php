<div class="app-sidebar">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        <a href="index.html" class="logo-dark">
            <img src="{{ asset('assets/images/logo-sm.png') }}" class="logo-sm" alt="logo sm">
            <img src="{{ asset('assets/images/logo-dark.png') }}" class="logo-lg" alt="logo dark">
        </a>

        <a href="index.html" class="logo-light">
            <img src="{{ asset('assets/images/logo-sm.png') }}" class="logo-sm" alt="logo sm">
            <img src="{{ asset('assets/images/logo-light.png') }}" class="logo-lg" alt="logo light">
        </a>
    </div>

    <div class="scrollbar" data-simplebar>

        <ul class="navbar-nav" id="navbar-nav">

            <li class="menu-title">Menu...</li>

            <li class="nav-item">
                <a class="nav-link
                {{ Request::routeIs('dashboard.*') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="mingcute:home-3-line"></iconify-icon>
                    </span>
                    <span class="nav-text"> Dashboard </span>
                    <!-- <span class="badge bg-primary badge-pill text-end">03</span> -->
                </a>
            </li>

            <li class="nav-item">
                <a class=" nav-link
                    {{ Request::routeIs('roles.*') ? 'active' : '' }} "
                    href="{{ route('roles.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="mdi:user-check"></iconify-icon>
                    </span>
                    <span class="nav-text"> Roles </span>
                </a>
            </li>

            <li class="nav-item">
                <a class=" nav-link
                    {{ Request::routeIs('evenements.*') ? 'active' : '' }} "
                    href="{{ route('evenements.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="mdi:calendar-check"></iconify-icon>
                    </span>
                    <span class="nav-text"> Événements </span>
                </a>
            </li>

            <li class="nav-item">
                <a class=" nav-link
                    {{ Request::routeIs('utilisateurs.*') ? 'active' : '' }} "
                    href="{{ route('utilisateurs.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="mdi:user"></iconify-icon>
                    </span>
                    <span class="nav-text"> Utilisateurs </span>
                </a>
            </li>
        </ul>
    </div>
</div>


<div class="animated-stars">
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
</div>
