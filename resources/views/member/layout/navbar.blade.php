<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="{{ url('/') }}">
            <i class="fas fa-book-reader text-primary mr-1"></i> E-Library <b>UNM</b>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample"
            aria-controls="navbarsExample" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/') }}"><i class="fas fa-book mr-1"></i> Katalog Buku</a>
                </li>
                @auth
                    @if(Auth::user()->role_id == 2)
                        <li class="nav-item {{ request()->is('member/data-booking*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('member.dataBooking', Auth::id()) }}">
                                <i class="fas fa-receipt mr-1"></i> Data Booking
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ml-auto align-items-center">
                @auth
                    @if(Auth::user()->role_id == 2)
                        @php
                            $cartCount = \App\Models\Temp::where('id_user', Auth::id())->count();
                        @endphp
                        <li class="nav-item mr-3">
                            <a class="btn btn-outline-info btn-sm position-relative" href="{{ route('member.dataKeranjang', Auth::id()) }}">
                                <i class="fas fa-shopping-basket"></i> Keranjang
                                <span class="badge badge-danger badge-pill">{{ $cartCount }}</span>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuLink"
                            role="button" data-toggle="dropdown" aria-expanded="false">
                            <span class="mr-2">{{ Auth::user()->nama }}</span>
                            <img src="{{ asset('storage/' . (Auth::user()->image ?? 'profil-pic/default.jpg')) }}"
                                class="rounded-circle" height="32" width="32" style="object-fit: cover;" alt="Avatar">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            @if(Auth::user()->role_id == 1)
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt mr-2 text-primary"></i> Dashboard Admin</a>
                            @else
                                <a class="dropdown-item" href="{{ route('member.profil') }}"><i class="fas fa-user mr-2 text-primary"></i> Profil Saya</a>
                                <a class="dropdown-item" href="{{ route('member.ganti-password') }}"><i class="fas fa-key mr-2 text-warning"></i> Ganti Password</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm mr-2" href="{{ route('login') }}"><i class="fas fa-sign-in-alt mr-1"></i> Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm" href="{{ route('register') }}"><i class="fas fa-user-plus mr-1"></i> Daftar</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
