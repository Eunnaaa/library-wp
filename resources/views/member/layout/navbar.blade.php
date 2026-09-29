<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm" style="background: rgba(15, 23, 42, 0.96); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.08); z-index: 1030;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center font-weight-bold" href="{{ url('/') }}" style="letter-spacing: -0.02em;">
            <div class="rounded-circle d-flex align-items-center justify-content-center mr-2 shadow-sm" style="width: 36px; height: 36px; background: linear-gradient(135deg, #2563eb, #38bdf8);">
                <i class="fas fa-book-reader text-white" style="font-size: 1.1rem;"></i>
            </div>
            <span class="text-white" style="font-size: 1.15rem;">E-Library</span>
            <span class="badge badge-primary ml-1 px-2 py-1" style="background: #2563eb; color: #ffffff; font-size: 0.72rem; letter-spacing: 0.06em;">UNM</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarsExample"
            aria-controls="navbarsExample" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fas fa-bars text-light"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample">
            <ul class="navbar-nav mr-auto pl-lg-3">
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link text-light font-weight-500 px-3 {{ request()->is('/') ? 'text-primary font-weight-bold' : 'opacity-80' }}" href="{{ url('/') }}">
                        <i class="fas fa-compass mr-1 text-primary"></i> Jelajah Katalog
                    </a>
                </li>
                @auth
                    @if(Auth::user()->role_id == 2)
                        <li class="nav-item {{ request()->is('member/data-booking*') ? 'active' : '' }}">
                            <a class="nav-link text-light font-weight-500 px-3 {{ request()->is('member/data-booking*') ? 'text-primary font-weight-bold' : 'opacity-80' }}" href="{{ route('member.dataBooking') }}">
                                <i class="fas fa-receipt mr-1 text-warning"></i> Bukti Booking
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ml-auto align-items-center mt-3 mt-lg-0">
                @auth
                    @if(Auth::user()->role_id == 2)
                        @php
                            $cartCount = \App\Models\Temp::where('id_user', Auth::id())->count();
                        @endphp
                        <li class="nav-item mr-lg-3 mb-2 mb-lg-0 w-100 w-lg-auto">
                            <a class="btn btn-sm d-flex align-items-center justify-content-center" href="{{ route('member.dataKeranjang') }}"
                                style="background: rgba(255, 255, 255, 0.08); color: #f8fafc; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 9999px; padding: 0.4rem 1rem;">
                                <i class="fas fa-shopping-basket mr-2 text-info"></i>
                                <span>Keranjang</span>
                                @if($cartCount > 0)
                                    <span class="badge badge-danger ml-2 px-2 py-1" style="border-radius: 9999px; font-size: 0.72rem; animation: pulse 2s infinite;">{{ $cartCount }}</span>
                                @else
                                    <span class="badge badge-secondary ml-2 px-2 py-1" style="border-radius: 9999px; font-size: 0.72rem;">0</span>
                                @endif
                            </a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center py-1 px-2 rounded" href="#" id="navbarDropdownMenuLink"
                            role="button" data-toggle="dropdown" aria-expanded="false" style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.1);">
                            <img src="{{ asset('storage/' . (Auth::user()->image ?? 'profil-pic/default.jpg')) }}"
                                class="rounded-circle border mr-2" height="30" width="30" style="object-fit: cover; border-color: rgba(255,255,255,0.3) !important;" alt="Avatar">
                            <div class="text-left mr-1 d-none d-sm-inline-block" style="line-height: 1.2;">
                                <span class="d-block text-white font-weight-bold" style="font-size: 0.85rem;">{{ Str::limit(Auth::user()->nama, 18) }}</span>
                                <small class="text-muted text-capitalize" style="font-size: 0.7rem;">{{ Auth::user()->role_id == 1 ? 'Administrator' : 'Anggota' }}</small>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 mt-2 p-2" aria-labelledby="navbarDropdownMenuLink" style="border-radius: 12px; min-width: 210px; background: #ffffff;">
                            <div class="px-3 py-2 border-bottom mb-2 bg-light rounded">
                                <small class="text-muted d-block">Masuk sebagai:</small>
                                <strong class="text-dark d-block text-truncate">{{ Auth::user()->nama }}</strong>
                                <small class="text-primary font-weight-bold">{{ Auth::user()->email }}</small>
                            </div>
                            @if(Auth::user()->role_id == 1)
                                <a class="dropdown-item rounded py-2" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt mr-2 text-primary"></i> Panel Admin
                                </a>
                            @else
                                <a class="dropdown-item rounded py-2" href="{{ route('member.profil') }}">
                                    <i class="fas fa-user-circle mr-2 text-primary"></i> Profil Saya
                                </a>
                                <a class="dropdown-item rounded py-2" href="{{ route('member.ganti-password') }}">
                                    <i class="fas fa-key mr-2 text-warning"></i> Ganti Password
                                </a>
                            @endif
                            <div class="dropdown-divider my-2"></div>
                            <a class="dropdown-item rounded py-2 text-danger" href="{{ route('logout') }}">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                            </a>
                        </div>
                    </li>
                @else
                    <li class="nav-item mr-2 mb-2 mb-lg-0">
                        <a class="btn btn-sm btn-outline-light px-3" href="{{ route('login') }}" style="border-radius: 9999px;">
                            <i class="fas fa-sign-in-alt mr-1"></i> Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sm btn-primary px-3 shadow-sm" href="{{ route('register') }}" style="border-radius: 9999px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none;">
                            <i class="fas fa-user-plus mr-1"></i> Daftar Anggota
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
