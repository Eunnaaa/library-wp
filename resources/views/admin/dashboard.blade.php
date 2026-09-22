@extends('admin.layout.main')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="alert alert-light border shadow-sm">
                <h5><i class="icon fas fa-info-circle text-primary"></i> Selamat Datang, <strong>{{ Auth::user()->nama }}</strong>!</h5>
                Anda login sebagai <strong>Administrator Perpustakaan (E-Library)</strong>.
            </div>
        </div>
    </div>

    <!-- Info boxes -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Anggota</span>
                    <span class="info-box-number">{{ $total_anggota }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-book"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Judul Buku</span>
                    <span class="info-box-number">{{ $total_judul }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-bookmark"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Stok Buku</span>
                    <span class="info-box-number">{{ $total_buku }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow-sm">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Kategori Buku</span>
                    <span class="info-box-number">{{ $total_kategori }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="info-box bg-gradient-primary shadow-sm">
                <span class="info-box-icon"><i class="fas fa-receipt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Transaksi Booking</span>
                    <span class="info-box-number">{{ $total_booking }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description text-white-50">Menunggu konfirmasi peminjaman</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="info-box bg-gradient-success shadow-sm">
                <span class="info-box-icon"><i class="fas fa-handshake"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Peminjaman Buku</span>
                    <span class="info-box-number">{{ $total_pinjam }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description text-white-50">Telah tercatat di sistem</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Tables -->
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-receipt mr-1"></i> Booking Terbaru</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.transaksi.booking.index') }}" class="btn btn-tool btn-sm"><i class="fas fa-arrow-right"></i> Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>ID Booking</th>
                                <th>Anggota</th>
                                <th>Tgl Booking</th>
                                <th>Batas Ambil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_bookings as $b)
                            <tr>
                                <td><a href="{{ route('admin.transaksi.booking.show', $b->id) }}"><strong>{{ $b->id_booking }}</strong></a></td>
                                <td>{{ $b->anggota->nama ?? '-' }}</td>
                                <td>{{ date('d-m-Y', strtotime($b->tgl_booking)) }}</td>
                                <td><span class="badge badge-warning">{{ date('d-m-Y', strtotime($b->batas_ambil)) }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Belum ada data booking terbaru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-success card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-book mr-1"></i> Buku Terbaru</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.master.buku.index') }}" class="btn btn-tool btn-sm"><i class="fas fa-arrow-right"></i> Kelola Buku</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Pengarang</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_buku as $bk)
                            <tr>
                                <td><strong>{{ Str::limit($bk->judul_buku, 25) }}</strong></td>
                                <td><span class="badge badge-info">{{ $bk->kategori->nama_kategori ?? '-' }}</span></td>
                                <td>{{ $bk->pengarang }}</td>
                                <td><span class="badge badge-success">{{ $bk->stok }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Belum ada data buku.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
