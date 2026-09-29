<!-- Left navbar links -->
<ul class="navbar-nav align-items-center">
    <li class="nav-item">
        <a class="nav-link text-secondary" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block ml-2">
        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-primary btn-sm px-3">
            <i class="fas fa-external-link-alt mr-1"></i> Buka Web Publik
        </a>
    </li>
</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto align-items-center">
    <!-- Profile Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center py-1 px-2 rounded" href="#"
            id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false" style="background: #f8fafc; border: 1px solid #e2e8f0;">
            <img src="{{ asset('storage/' . (Auth::user()->image ?? 'profil-pic/default.jpg')) }}"
                class="rounded-circle mr-2 border" height="30" width="30" alt="Avatar" loading="lazy" style="object-fit: cover;" />
            <span class="font-weight-bold text-dark small mr-1">{{ Auth::user()->nama }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-2 p-2" style="border-radius: 12px; min-width: 200px;">
            <div class="px-3 py-2 border-bottom mb-2 bg-light rounded">
                <small class="text-muted d-block">Login Administrator:</small>
                <strong class="text-dark small d-block text-truncate">{{ Auth::user()->nama }}</strong>
            </div>
            <a class="dropdown-item rounded py-2 small" href="{{ route('admin.profil') }}"><i class="fas fa-user-circle mr-2 text-primary"></i> Profil Saya</a>
            <a class="dropdown-item rounded py-2 small" href="{{ route('admin.ganti-password') }}"><i class="fas fa-key mr-2 text-warning"></i> Ganti Password</a>
            <div class="dropdown-divider my-1"></div>
            <a class="dropdown-item rounded py-2 small text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
        </div>
    </li>
</ul>

