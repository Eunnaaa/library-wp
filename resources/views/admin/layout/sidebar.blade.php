<!-- Brand Logo -->
<a href="{{ route('admin.dashboard') }}" class="brand-link d-flex align-items-center">
    <div class="rounded-circle d-flex align-items-center justify-content-center mr-2 shadow-sm" style="width: 36px; height: 36px; background: linear-gradient(135deg, #2563eb, #38bdf8); flex-shrink: 0;">
        <i class="fas fa-book-reader text-white" style="font-size: 0.95rem;"></i>
    </div>
    <div style="line-height: 1.25;">
        <span class="brand-text font-weight-bold text-white d-block" style="font-size: 1.05rem; letter-spacing: -0.02em;">E-Library</span>
        <small class="text-primary font-weight-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.08em;">Universitas Nusa Mandiri</small>
    </div>
</a>

<!-- Sidebar Navigation -->
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-3 pb-3">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header text-uppercase text-muted font-weight-bold">Dashboard</li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>Ringkasan Dashboard</p>
                </a>
            </li>

            <li class="nav-header text-uppercase text-muted font-weight-bold mt-2">Manajemen Data Master</li>
            <!-- Data Master -->
            <li class="nav-item has-treeview {{ request()->is('admin/master/*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('admin/master/*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open nav-icon"></i>
                    <p>
                        Data Master
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.master.kategori.index') }}"
                            class="nav-link {{ request()->is('admin/master/kategori*') ? 'active' : '' }}">
                            <i class="fas fa-tags nav-icon"></i>
                            <p>Kategori Buku</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.master.buku.index') }}"
                            class="nav-link {{ request()->is('admin/master/buku*') ? 'active' : '' }}">
                            <i class="fas fa-book nav-icon"></i>
                            <p>Koleksi Buku</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.master.user.index') }}"
                            class="nav-link {{ request()->is('admin/master/user*') ? 'active' : '' }}">
                            <i class="fas fa-users-cog nav-icon"></i>
                            <p>Data User & Anggota</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-header text-uppercase text-muted font-weight-bold mt-2">Sirkulasi & Transaksi</li>
            <!-- Data Transaksi -->
            <li class="nav-item has-treeview {{ request()->is('admin/transaksi/*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->is('admin/transaksi/*') ? 'active' : '' }}">
                    <i class="fas fa-exchange-alt nav-icon"></i>
                    <p>
                        Data Transaksi
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.transaksi.booking.index') }}"
                            class="nav-link {{ request()->is('admin/transaksi/booking*') ? 'active' : '' }}">
                            <i class="fas fa-receipt nav-icon"></i>
                            <p>Daftar Booking</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.transaksi.peminjaman.index') }}"
                            class="nav-link {{ request()->is('admin/transaksi/peminjaman') || request()->is('admin/transaksi/peminjaman/*') && !request()->is('admin/transaksi/pengembalian') ? 'active' : '' }}">
                            <i class="fas fa-book-reader nav-icon"></i>
                            <p>Peminjaman Aktif</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.transaksi.peminjaman.pengembalian') }}"
                            class="nav-link {{ request()->is('admin/transaksi/pengembalian') ? 'active' : '' }}">
                            <i class="fas fa-undo-alt nav-icon"></i>
                            <p>Pengembalian & Denda</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-header text-uppercase text-muted font-weight-bold mt-2">Pintasan Cepat</li>
            <li class="nav-item">
                <a href="{{ url('/') }}" target="_blank" class="nav-link">
                    <i class="nav-icon fas fa-globe text-info"></i>
                    <p>Katalog Pengunjung <i class="fas fa-external-link-alt right small"></i></p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

<!-- User Profile Docked at Bottom of Sidebar -->
<div class="sidebar-user-panel mt-auto">
    <div class="sidebar-user-card d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center" style="overflow: hidden; min-width: 0;">
            <div class="image mr-2 position-relative flex-shrink-0">
                <img src="{{ asset('storage/' . (Auth::user()->image ?? 'profil-pic/default.jpg')) }}"
                    class="img-circle elevation-1 border" style="width: 36px; height: 36px; object-fit: cover; border-color: rgba(255,255,255,0.2) !important;" alt="User Image">
                <span class="badge badge-success position-absolute" style="bottom: 0px; right: 0px; width: 9px; height: 9px; padding: 0; border-radius: 50%; border: 2px solid #090e17;"></span>
            </div>
            <div class="info" style="overflow: hidden; line-height: 1.25; min-width: 0;">
                <a href="{{ route('admin.profil') }}" class="d-block text-white font-weight-bold text-truncate" style="font-size: 0.82rem;" title="{{ Auth::user()->nama }}">
                    {{ Auth::user()->nama }}
                </a>
                <span class="badge badge-success px-2 py-0 mt-1 d-inline-block" style="font-size: 0.65rem; border-radius: 9999px;">
                    <i class="fas fa-circle mr-1" style="font-size: 0.45rem;"></i> Administrator
                </span>
            </div>
        </div>
        <div class="ml-2 flex-shrink-0">
            <a href="{{ route('admin.profil') }}" class="btn-profile-cog" title="Kelola Profil">
                <i class="fas fa-cog"></i>
            </a>
        </div>
    </div>
</div>
