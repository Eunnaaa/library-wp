<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm py-3" style="background: #1b1008; border-bottom: 2px solid #c59b27; box-shadow: 0 4px 20px rgba(27, 16, 8, 0.45); z-index: 1030; min-height: 72px;">
    <div class="container-fluid px-3 px-md-4 px-lg-5">
        <a class="navbar-brand d-flex align-items-center mr-lg-4" href="{{ url('/') }}" style="letter-spacing: -0.01em;">
            <div class="rounded-circle d-flex align-items-center justify-content-center mr-2 shadow-sm" style="width: 38px; height: 38px; background: linear-gradient(135deg, #c59b27, #e9c46a); border: 1px solid #d4af37;">
                <i class="fas fa-book-reader" style="color: #1b1008; font-size: 1.1rem;"></i>
            </div>
            <span class="text-white font-weight-bold" style="font-size: 1.28rem; letter-spacing: -0.02em;">E-Library</span>
            <span class="badge ml-2 px-2 py-1 font-weight-bold" style="background: rgba(197, 155, 39, 0.2); color: #e9c46a; border: 1px solid #c59b27; font-size: 0.72rem; letter-spacing: 0.08em;">UNM</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarsExample"
            aria-controls="navbarsExample" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fas fa-bars text-light"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample">
            <ul class="navbar-nav mr-auto pl-lg-2" style="gap: 8px;">
                @auth
                    @if(Auth::user()->role_id == 2)
                        <li class="nav-item {{ request()->is('member/data-booking*') ? 'active' : '' }}">
                            <a class="nav-link px-3 py-2 {{ request()->is('member/data-booking*') ? 'text-warning font-weight-bold' : 'text-light opacity-90' }}" href="{{ route('member.dataBooking') }}">
                                <i class="fas fa-receipt mr-1 text-warning"></i> Bukti Booking
                            </a>
                        </li>
                        <li class="nav-item {{ request()->is('member/peminjaman*') ? 'active' : '' }}">
                            <a class="nav-link px-3 py-2 {{ request()->is('member/peminjaman*') ? 'text-warning font-weight-bold' : 'text-light opacity-90' }}" href="{{ route('member.peminjaman') }}">
                                <i class="fas fa-book-reader mr-1" style="color: #e9c46a;"></i> Peminjaman Saya
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ml-auto align-items-center mt-3 mt-lg-0" style="gap: 12px;">
                @auth
                    @if(Auth::user()->role_id == 2)
                        @php
                            $cartCount = \App\Models\Temp::where('id_user', Auth::id())->count();
                        @endphp
                        <li class="nav-item mb-2 mb-lg-0 w-100 w-lg-auto">
                            <a class="btn d-flex align-items-center justify-content-center" href="{{ route('member.dataKeranjang') }}"
                                style="background: rgba(197, 155, 39, 0.15); color: #f7f4ec; border: 1px solid rgba(197, 155, 39, 0.4); border-radius: 9999px; padding: 0.45rem 1.25rem; font-size: 0.88rem;">
                                <i class="fas fa-shopping-basket mr-2" style="color: #e9c46a;"></i>
                                <span class="font-weight-semibold">Keranjang</span>
                                @if($cartCount > 0)
                                    <span class="badge ml-2 px-2 py-1 font-weight-bold" style="background: #8b4513; color: #fff; border-radius: 9999px; font-size: 0.72rem;">{{ $cartCount }}</span>
                                @else
                                    <span class="badge badge-secondary ml-2 px-2 py-1" style="border-radius: 9999px; font-size: 0.72rem;">0</span>
                                @endif
                            </a>
                        </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center px-3 py-2 rounded" href="#" id="navbarDropdownMenuLink"
                            role="button" data-toggle="dropdown" aria-expanded="false" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(197, 155, 39, 0.3);">
                            <img src="{{ asset('storage/' . (Auth::user()->image ?? 'profil-pic/default.jpg')) }}"
                                class="rounded-circle border mr-2" height="32" width="32" style="object-fit: cover; border-color: #c59b27 !important;" alt="Avatar"
                                onerror="this.onerror=null; this.src='{{ asset('assets/dist/img/default-150x150.png') }}';">
                            <div class="text-left mr-1 d-none d-sm-inline-block" style="line-height: 1.2;">
                                <span class="d-block text-white font-weight-bold" style="font-size: 0.85rem;">{{ Str::limit(Auth::user()->nama, 18) }}</span>
                                <small class="text-capitalize" style="font-size: 0.7rem; color: #d4af37;">{{ Auth::user()->role_id == 1 ? 'Administrator' : 'Anggota' }}</small>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 mt-2 p-2" aria-labelledby="navbarDropdownMenuLink" style="border-radius: 12px; min-width: 210px; background: #ffffff; border: 1px solid #e8e2d4 !important;">
                            <div class="px-3 py-2 border-bottom mb-2 bg-light rounded">
                                <small class="text-muted d-block">Masuk sebagai:</small>
                                <strong class="text-dark d-block text-truncate">{{ Auth::user()->nama }}</strong>
                                <small class="font-weight-bold" style="color: #8b4513;">{{ Auth::user()->email }}</small>
                            </div>
                            @if(Auth::user()->role_id == 1)
                                <a class="dropdown-item rounded py-2" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt mr-2" style="color: #8b4513;"></i> Panel Admin
                                </a>
                            @else
                                <a class="dropdown-item rounded py-2" href="{{ route('member.peminjaman') }}">
                                    <i class="fas fa-book-reader mr-2" style="color: #8b4513;"></i> Peminjaman Saya
                                </a>
                                <a class="dropdown-item rounded py-2" href="{{ route('member.profil') }}">
                                    <i class="fas fa-user-circle mr-2" style="color: #8b4513;"></i> Profil Saya
                                </a>
                                <a class="dropdown-item rounded py-2" href="{{ route('member.ganti-password') }}">
                                    <i class="fas fa-shield-alt mr-2" style="color: #8b4513;"></i> Ganti Password
                                </a>
                            @endif
                            <div class="dropdown-divider my-2"></div>
                            <form id="member-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a class="dropdown-item rounded py-2 text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('member-logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                            </a>
                        </div>
                    </li>
                @else
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="btn btn-outline-light font-weight-bold" href="{{ route('login') }}" style="border-radius: 9999px; border-color: rgba(212, 175, 55, 0.6); color: #f7f4ec; padding: 0.45rem 1.25rem; font-size: 0.88rem;">
                            <i class="fas fa-sign-in-alt mr-1"></i> Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn shadow-sm font-weight-bold text-white" href="{{ route('register') }}" style="border-radius: 9999px; background: linear-gradient(135deg, #8b4513, #a0522d); border: 1px solid #c59b27; padding: 0.45rem 1.35rem; font-size: 0.88rem;">
                            <i class="fas fa-user-plus mr-1"></i> Daftar Anggota
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
