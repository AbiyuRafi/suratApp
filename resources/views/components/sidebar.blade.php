<div class="container">
    <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: #003049">
        <a class="navbar-brand ps-3" href="/home"><b>Pengelolaan Surat</b></a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false"> {{ Auth::user()->name }} <i
                            class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </form>
    </nav>
    <div class="layoutSidenav" id="layoutSidenav">
        @yield('content')
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="background-color: #003049">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="/home">
                            <div class="sb-nav-link-icon"><i class='bx bxs-dashboard'></i></div>
                            Dashboard
                        </a>
                        @if (Auth::check())
                            @if (Auth::user()->role == 'staff')
                                <div class="sb-sidenav-menu-heading">List Data</div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#collapseLayouts" aria-expanded="false"
                                    aria-controls="collapseLayouts">
                                    <div class="sb-nav-link-icon"><i class='bx bxs-user'></i></div>
                                    Data User
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                                    data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <ul>
                                            <li>
                                                <a class="nav-link" href="{{ route('staff.index') }}">Data Staff</a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="{{ route('guru.indexGuru') }}">Data Guru</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSurat" aria-expanded="false" aria-controls="collapseSurat">
                                    <div class="sb-nav-link-icon"><i class='bx bxs-envelope'></i></div>
                                    Data Surat
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseSurat" aria-labelledby="headingSurat"
                                    data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <ul>
                                            <li>
                                                <a class="nav-link" href="{{ route('klasifikasi.index') }}">Data
                                                    Klasifikasi
                                                    Surat</a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="{{ route('letters.index') }}">Data Surat</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            @else
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSurat" aria-expanded="false" aria-controls="collapseSurat">
                                    <div class="sb-nav-link-icon"><i class='bx bxs-envelope'></i></div>
                                    Data Surat
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="collapseSurat" aria-labelledby="headingSurat"
                                    data-bs-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <ul>
                                            <li>
                                                <a class="nav-link" href="{{ route('user.index') }}">Data Surat Masuk</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

            </nav>
        </div>
    </div>
