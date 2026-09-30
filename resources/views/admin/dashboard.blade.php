@extends('admin.layout.main')

@section('title', 'Dashboard Administrator')

@section('content')
<div class="container-fluid">
    <!-- Welcome Header Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm text-white" style="border-radius: 16px; background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #2563eb 100%); overflow: hidden;">
                <div class="card-body p-4 position-relative">
                    <div class="row align-items-center">
                        <div class="col-lg-8 mb-3 mb-lg-0">
                            <span class="badge badge-pill px-3 py-1 font-weight-bold mb-2" style="background: rgba(255, 255, 255, 0.15); color: #93c5fd; border: 1px solid rgba(255, 255, 255, 0.2);">
                                <i class="fas fa-shield-alt mr-1"></i> Panel Kontrol Perpustakaan
                            </span>
                            <h3 class="font-weight-bold text-white mb-1">Selamat Datang, {{ Auth::user()->nama }}!</h3>
                            <p class="text-white-50 mb-0" style="font-size: 0.95rem;">
                                Hari ini adalah <strong>{{ date('l, d F Y') }}</strong>. Kelola sirkulasi buku, verifikasi pesanan booking, dan pantau anggota perpustakaan UNM dengan mudah.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-right">
                            <a href="{{ route('admin.master.buku.create') }}" class="btn btn-light btn-sm font-weight-bold mr-2 shadow-sm" style="border-radius: 8px;">
                                <i class="fas fa-plus text-primary mr-1"></i> Tambah Buku
                            </a>
                            <a href="{{ route('admin.transaksi.booking.index') }}" class="btn btn-warning btn-sm font-weight-bold shadow-sm" style="border-radius: 8px; color: #78350f;">
                                <i class="fas fa-receipt mr-1"></i> Verifikasi Booking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Main KPI Cards -->
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; border-left: 4px solid #0284c7 !important;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-sm" style="width: 52px; height: 52px; background: #e0f2fe; color: #0284c7; flex-shrink: 0;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <div>
                        <small class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.72rem; letter-spacing: 0.05em;">Total Anggota</small>
                        <h4 class="font-weight-bold text-dark mb-0">{{ $total_anggota }}</h4>
                        <small class="text-success"><i class="fas fa-check-circle mr-1"></i>Civitas Terdaftar</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; border-left: 4px solid #10b981 !important;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-sm" style="width: 52px; height: 52px; background: #d1fae5; color: #059669; flex-shrink: 0;">
                        <i class="fas fa-book fa-lg"></i>
                    </div>
                    <div>
                        <small class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.72rem; letter-spacing: 0.05em;">Judul Koleksi</small>
                        <h4 class="font-weight-bold text-dark mb-0">{{ $total_judul }}</h4>
                        <small class="text-muted"><i class="fas fa-bookmark mr-1 text-primary"></i>Buku Berbeda</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; border-left: 4px solid #f59e0b !important;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-sm" style="width: 52px; height: 52px; background: #fef3c7; color: #d97706; flex-shrink: 0;">
                        <i class="fas fa-layer-group fa-lg"></i>
                    </div>
                    <div>
                        <small class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.72rem; letter-spacing: 0.05em;">Total Eksemplar Fisik</small>
                        <h4 class="font-weight-bold text-dark mb-0">{{ $total_buku }}</h4>
                        <small class="text-muted"><i class="fas fa-cubes mr-1 text-warning"></i>Total Stok Buku</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; border-left: 4px solid #ef4444 !important;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-sm" style="width: 52px; height: 52px; background: #fee2e2; color: #dc2626; flex-shrink: 0;">
                        <i class="fas fa-tags fa-lg"></i>
                    </div>
                    <div>
                        <small class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.72rem; letter-spacing: 0.05em;">Kategori Buku</small>
                        <h4 class="font-weight-bold text-dark mb-0">{{ $total_kategori }}</h4>
                        <small class="text-muted"><i class="fas fa-list-ul mr-1 text-danger"></i>Klasifikasi Ilmu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2 Transaction Overview Cards -->
    <div class="row mb-4">
        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
            <div class="card border-0 text-white shadow-sm" style="border-radius: 14px; background: linear-gradient(135deg, #1e40af, #3b82f6);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="text-white-50 small font-weight-bold text-uppercase">Antrean Sirkulasi</span>
                            <h3 class="font-weight-bold text-white mb-0">{{ $total_booking }} Transaksi Booking</h3>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(255, 255, 255, 0.2);">
                            <i class="fas fa-receipt fa-lg"></i>
                        </div>
                    </div>
                    <p class="text-white-50 small mb-3">Pesanan buku dari anggota yang menunggu pengambilan atau konfirmasi staf.</p>
                    <a href="{{ route('admin.transaksi.booking.index') }}" class="btn btn-sm btn-light font-weight-bold text-primary" style="border-radius: 8px;">
                        <i class="fas fa-arrow-right mr-1"></i> Buka Antrean Booking
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card border-0 text-white shadow-sm" style="border-radius: 14px; background: linear-gradient(135deg, #065f46, #10b981);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="text-white-50 small font-weight-bold text-uppercase">Sirkulasi Berjalan</span>
                            <h3 class="font-weight-bold text-white mb-0">{{ $total_pinjam }} Transaksi Pinjam</h3>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(255, 255, 255, 0.2);">
                            <i class="fas fa-handshake fa-lg"></i>
                        </div>
                    </div>
                    <p class="text-white-50 small mb-3">Total buku yang telah diserahkan dan tercatat dalam sirkulasi peminjaman aktif.</p>
                    <a href="{{ route('admin.transaksi.peminjaman.index') }}" class="btn btn-sm btn-light font-weight-bold text-success" style="border-radius: 8px;">
                        <i class="fas fa-arrow-right mr-1"></i> Kelola Peminjaman
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics & Capacity Section -->
    <div class="row mb-4">
        <!-- Physical Stock Availability Breakdown -->
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="font-weight-bold mb-0 text-dark">
                        <i class="fas fa-boxes text-info mr-2"></i> Analisis Ketersediaan Fisik Buku
                    </h6>
                    <span class="badge badge-light border font-weight-bold text-muted">
                        Total {{ $total_buku + $total_dipinjam + $total_dibooking }} Eksemplar
                    </span>
                </div>
                <div class="card-body p-4">
                    @php
                        $grandTotal = max(1, $total_buku + $total_dipinjam + $total_dibooking);
                        $persenTersedia = round(($total_buku / $grandTotal) * 100);
                        $persenDipinjam = round(($total_dipinjam / $grandTotal) * 100);
                        $persenDibooking = round(($total_dibooking / $grandTotal) * 100);
                    @endphp

                    <!-- Segmented Progress Bar -->
                    <div class="progress mb-4" style="height: 14px; border-radius: 10px; background: #e2e8f0; overflow: hidden;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $persenTersedia }}%" title="Tersedia: {{ $total_buku }}"></div>
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $persenDipinjam }}%" title="Dipinjam: {{ $total_dipinjam }}"></div>
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $persenDibooking }}%" title="Dibooking: {{ $total_dibooking }}"></div>
                    </div>

                    <div class="row text-center">
                        <div class="col-4">
                            <div class="p-2 rounded bg-light border">
                                <span class="d-block small text-muted font-weight-bold text-uppercase" style="font-size: 0.68rem;">Tersedia di Rak</span>
                                <h5 class="font-weight-bold text-success mb-0">{{ $total_buku }}</h5>
                                <small class="text-muted font-weight-bold">{{ $persenTersedia }}%</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded bg-light border">
                                <span class="d-block small text-muted font-weight-bold text-uppercase" style="font-size: 0.68rem;">Sedang Dipinjam</span>
                                <h5 class="font-weight-bold text-warning mb-0">{{ $total_dipinjam }}</h5>
                                <small class="text-muted font-weight-bold">{{ $persenDipinjam }}%</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2 rounded bg-light border">
                                <span class="d-block small text-muted font-weight-bold text-uppercase" style="font-size: 0.68rem;">Antrean Booking</span>
                                <h5 class="font-weight-bold text-primary mb-0">{{ $total_dibooking }}</h5>
                                <small class="text-muted font-weight-bold">{{ $persenDibooking }}%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Categories Breakdown -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="font-weight-bold mb-0 text-dark">
                        <i class="fas fa-chart-bar text-primary mr-2"></i> Top Klasifikasi Kategori Buku
                    </h6>
                    <a href="{{ route('admin.master.kategori.index') }}" class="small font-weight-bold text-primary">
                        Lihat Semua <i class="fas fa-chevron-right ml-1"></i>
                    </a>
                </div>
                <div class="card-body p-4">
                    @forelse($kategori_stats as $ks)
                        @php
                            $maxJudul = max(1, $total_judul);
                            $pctKat = round(($ks->buku_count / $maxJudul) * 100);
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1 small">
                                <strong class="text-dark">{{ $ks->nama_kategori }}</strong>
                                <span class="font-weight-bold text-muted">{{ $ks->buku_count }} Judul ({{ $pctKat }}%)</span>
                            </div>
                            <div class="progress" style="height: 8px; border-radius: 6px; background: #f1f5f9;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $pctKat }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small text-center my-3">Belum ada data kategori buku.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Tables -->
    <div class="row">
        <!-- Recent Bookings Table -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="font-weight-bold mb-0 text-dark">
                        <i class="fas fa-receipt text-primary mr-2"></i> Reservasi Booking Terbaru
                    </h6>
                    <a href="{{ route('admin.transaksi.booking.index') }}" class="btn btn-outline-primary btn-sm font-weight-bold">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th>ID Booking</th>
                                    <th>Nama Anggota</th>
                                    <th>Tgl Booking</th>
                                    <th>Batas Ambil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_bookings as $b)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.transaksi.booking.show', $b->id) }}" class="font-weight-bold text-primary">
                                            {{ $b->id_booking }}
                                        </a>
                                    </td>
                                    <td class="font-weight-500 text-dark">{{ $b->anggota->nama ?? '-' }}</td>
                                    <td class="small text-muted">{{ date('d M Y, H:i', strtotime($b->tgl_booking)) }}</td>
                                    <td><span class="badge badge-warning font-weight-bold">{{ date('d M Y', strtotime($b->batas_ambil)) }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4 small">
                                        <i class="fas fa-check-circle fa-2x text-muted mb-2 d-block"></i>
                                        Tidak ada pesanan booking terbaru.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Books Table -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 14px;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="font-weight-bold mb-0 text-dark">
                        <i class="fas fa-book text-success mr-2"></i> Koleksi Buku Baru Masuk
                    </h6>
                    <a href="{{ route('admin.master.buku.index') }}" class="btn btn-outline-success btn-sm font-weight-bold">
                        Kelola Buku <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th>Judul Buku</th>
                                    <th>Kategori</th>
                                    <th>Pengarang</th>
                                    <th class="text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_buku as $bk)
                                <tr>
                                    <td>
                                        <strong class="text-dark d-block text-truncate" style="max-width: 180px;">{{ $bk->judul_buku }}</strong>
                                        <small class="text-muted">ISBN: {{ $bk->isbn }}</small>
                                    </td>
                                    <td><span class="badge badge-info">{{ $bk->kategori->nama_kategori ?? '-' }}</span></td>
                                    <td class="small text-muted text-truncate" style="max-width: 130px;">{{ $bk->pengarang }}</td>
                                    <td class="text-center">
                                        @if($bk->stok > 0)
                                            <span class="badge badge-success font-weight-bold">{{ $bk->stok }} eks</span>
                                        @else
                                            <span class="badge badge-danger font-weight-bold">0</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4 small">
                                        Belum ada koleksi buku terdaftar.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

