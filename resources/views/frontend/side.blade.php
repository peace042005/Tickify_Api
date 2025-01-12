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
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="mingcute:home-3-line"></iconify-icon>
                    </span>
                    <span class="nav-text"> Dashboard </span>
                    <span class="badge bg-primary badge-pill text-end">03</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="index.html#sidebarAuthentication" data-bs-toggle="collapse"
                    role="button" aria-expanded="false" aria-controls="sidebarAuthentication">
                    <span class="nav-icon">
                        <iconify-icon icon="mingcute:user-3-line"></iconify-icon>
                    </span>
                    <span class="nav-text"> Authentication </span>
                </a>
                <div class="collapse" id="sidebarAuthentication">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="auth-signin.html">Sign In</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="auth-signup.html">Sign Up</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="auth-password.html">Reset Password</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="auth-lock-screen.html">Lock Screen</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="index.html#sidebarError" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarError">
                    <span class="nav-icon">
                        <iconify-icon icon="mingcute:bug-line"></iconify-icon>
                    </span>
                    <span class="nav-text"> Error Pages</span>
                </a>
                <div class="collapse" id="sidebarError">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="pages-404.html">Pages 404</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="pages-404-alt.html">Pages 404 Alt</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-title">UI Kit...</li>

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
