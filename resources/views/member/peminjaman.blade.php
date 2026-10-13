@extends('member.layout.main')

@section('title', 'Peminjaman Buku Saya')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Breadcrumb & Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom" style="border-color: #e8e2d4 !important;">
        <div class="mb-3 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1 small">
                    <li class="breadcrumb-item"><a href="{{ route('member.index') }}" class="text-muted"><i class="fas fa-home mr-1"></i>Katalog</a></li>
                    <li class="breadcrumb-item active text-dark font-weight-semibold" aria-current="page">Peminjaman Saya</li>
                </ol>
            </nav>
            <h2 class="font-weight-bold text-dark mb-1" style="color: #241a14 !important; letter-spacing: -0.02em;">
                <i class="fas fa-book-reader mr-2" style="color: #8b4513;"></i> Sirkulasi Peminjaman Saya
            </h2>
            <p class="text-muted small mb-0">Pantau masa pinjam buku aktif, batas waktu pengembalian, dan riwayat sirkulasi koleksi Anda</p>
        </div>
        <div class="d-flex align-items-center">
            <a href="{{ route('member.index') }}" class="btn btn-outline-primary btn-sm px-3 py-2 font-weight-bold mr-2 shadow-sm" style="border-radius: 8px;">
                <i class="fas fa-search mr-1"></i> Pinjam Buku Baru
            </a>
            <a href="{{ route('member.dataBooking') }}" class="btn btn-primary btn-sm px-3 py-2 font-weight-bold shadow-sm" style="border-radius: 8px;">
                <i class="fas fa-receipt mr-1"></i> Bukti Reservasi
            </a>
        </div>
    </div>

    <!-- Summary Metric Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 14px; border: 1px solid #e8e2d4 !important; background: #ffffff;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-sm flex-shrink-0" style="width: 52px; height: 52px; background: rgba(139, 69, 19, 0.12); color: #8b4513; border: 1px solid rgba(139, 69, 19, 0.25);">
                        <i class="fas fa-book-open fa-lg"></i>
                    </div>
                    <div>
                        <span class="d-block text-muted small font-weight-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.04em;">Buku Sedang Dipinjam</span>
                        <h3 class="font-weight-bold text-dark mb-0">{{ $totalAktif }} <small class="text-muted" style="font-size: 0.9rem;">Buku</small></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 14px; border: 1px solid #e8e2d4 !important; background: #ffffff;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-sm flex-shrink-0" style="width: 52px; height: 52px; background: {{ $totalTerlambat > 0 ? 'rgba(220, 53, 69, 0.12)' : 'rgba(197, 155, 39, 0.15)' }}; color: {{ $totalTerlambat > 0 ? '#dc3545' : '#c59b27' }}; border: 1px solid {{ $totalTerlambat > 0 ? 'rgba(220, 53, 69, 0.3)' : 'rgba(197, 155, 39, 0.3)' }};">
                        <i class="fas {{ $totalTerlambat > 0 ? 'fa-exclamation-triangle' : 'fa-calendar-alt' }} fa-lg"></i>
                    </div>
                    <div>
                        <span class="d-block text-muted small font-weight-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.04em;">Jatuh Tempo Terdekat</span>
                        @if($jatuhTempoTerdekat)
                            <h5 class="font-weight-bold {{ $totalTerlambat > 0 ? 'text-danger' : 'text-dark' }} mb-0" style="font-size: 1.05rem;">
                                {{ $jatuhTempoTerdekat->translatedFormat('d M Y') }}
                            </h5>
                            @if($totalTerlambat > 0)
                                <small class="text-danger font-weight-bold"><i class="fas fa-bell mr-1"></i>{{ $totalTerlambat }} Buku Terlambat</small>
                            @else
                                <small class="text-success font-weight-bold"><i class="fas fa-check mr-1"></i>Dalam Masa Pinjam</small>
                            @endif
                        @else
                            <h5 class="font-weight-bold text-dark mb-0" style="font-size: 1.05rem;">Tidak Ada</h5>
                            <small class="text-muted">Bebas pinjaman aktif</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 14px; border: 1px solid #e8e2d4 !important; background: #ffffff;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-sm flex-shrink-0" style="width: 52px; height: 52px; background: rgba(45, 106, 79, 0.12); color: #2d6a4f; border: 1px solid rgba(45, 106, 79, 0.25);">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                    <div>
                        <span class="d-block text-muted small font-weight-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.04em;">Riwayat Selesai</span>
                        <h3 class="font-weight-bold text-dark mb-0">{{ $totalSelesai }} <small class="text-muted" style="font-size: 0.9rem;">Buku</small></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 14px; border: 1px solid #e8e2d4 !important; background: #ffffff;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 shadow-sm flex-shrink-0" style="width: 52px; height: 52px; background: rgba(212, 175, 55, 0.15); color: #8b4513; border: 1px solid rgba(212, 175, 55, 0.35);">
                        <i class="fas fa-coins fa-lg"></i>
                    </div>
                    <div>
                        <span class="d-block text-muted small font-weight-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.04em;">Total Denda Riwayat</span>
                        <h5 class="font-weight-bold {{ $totalDendaUser > 0 ? 'text-danger' : 'text-success' }} mb-0" style="font-size: 1.05rem;">
                            Rp {{ number_format($totalDendaUser, 0, ',', '.') }}
                        </h5>
                        <small class="text-muted">{{ $totalDendaUser > 0 ? 'Tercatat denda' : 'Bebas denda' }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px; border: 1px solid #e8e2d4 !important; overflow: hidden;">
        <div class="card-header bg-white pt-3 pb-0 px-4 border-bottom" style="border-color: #e8e2d4 !important;">
            <ul class="nav nav-tabs card-header-tabs border-0" id="pinjamTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active font-weight-bold px-4 py-3" id="aktif-tab" data-toggle="tab" href="#aktif" role="tab" aria-controls="aktif" aria-selected="true" style="color: #241a14; border-radius: 10px 10px 0 0;">
                        <i class="fas fa-book-reader mr-2" style="color: #8b4513;"></i> Sedang Dipinjam
                        <span class="badge badge-pill badge-primary ml-2 px-2 py-1">{{ $totalAktif }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold px-4 py-3 text-muted" id="riwayat-tab" data-toggle="tab" href="#riwayat" role="tab" aria-controls="riwayat" aria-selected="false" style="border-radius: 10px 10px 0 0;">
                        <i class="fas fa-history mr-2" style="color: #c59b27;"></i> Riwayat Pengembalian
                        <span class="badge badge-pill badge-secondary ml-2 px-2 py-1">{{ $totalSelesai }}</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body p-4 bg-white">
            <div class="tab-content" id="pinjamTabContent">
                <!-- TAB 1: BUKU SEDANG DIPINJAM (AKTIF) -->
                <div class="tab-pane fade show active" id="aktif" role="tabpanel" aria-labelledby="aktif-tab">
                    @if($pinjamAktif->isEmpty())
                        <div class="text-center py-5 px-3 rounded-xl my-3" style="background: #fdfbf7; border: 1px dashed #e8e2d4; border-radius: 16px;">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; background: rgba(197, 155, 39, 0.15); border: 1px solid rgba(197, 155, 39, 0.3);">
                                <i class="fas fa-book-reader fa-2x" style="color: #c59b27;"></i>
                            </div>
                            <h4 class="font-weight-bold text-dark mb-2">Tidak Ada Buku yang Sedang Dipinjam</h4>
                            <p class="text-muted mx-auto mb-4" style="max-width: 540px; font-size: 0.95rem; line-height: 1.6;">
                                Saat ini Anda tidak memiliki tanggungan peminjaman buku fisik aktif. Jelajahi katalog buku untuk melakukan reservasi literatur yang Anda butuhkan.
                            </p>
                            <a href="{{ route('member.index') }}" class="btn btn-primary px-4 py-2 font-weight-bold shadow-sm" style="border-radius: 10px;">
                                <i class="fas fa-search mr-2"></i> Jelajahi Katalog Buku
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning border-0 rounded-lg shadow-sm mb-4 small" style="background-color: #fdf8eb; color: #854d0e; border: 1px solid #fae8a4; border-left: 4px solid #c59b27 !important;">
                            <i class="fas fa-info-circle mr-1"></i>
                            Harap kembalikan fisik buku sebelum atau tepat pada tanggal jatuh tempo ke loket sirkulasi perpustakaan UNM untuk menghindari tarif denda keterlambatan (Rp 1.000 / hari per buku).
                        </div>

                        <div class="row">
                            @foreach($pinjamAktif as $item)
                                @php
                                    $tglPinjam = \Carbon\Carbon::parse($item->pinjam->tgl_pinjam);
                                    $tglKembali = \Carbon\Carbon::parse($item->tgl_kembali);
                                    $now = \Carbon\Carbon::now();
                                    $isTerlambat = $now->isAfter($tglKembali);
                                    $isToday = $now->isSameDay($tglKembali);
                                    $sisaHari = (int) ceil($now->diffInDays($tglKembali, false));
                                    $hariTerlambat = (int) abs($sisaHari);
                                    $estimasiDenda = $isTerlambat ? ($hariTerlambat * (float) $item->denda) : 0;
                                @endphp

                                <div class="col-lg-6 mb-4">
                                    <div class="card h-100 shadow-sm border" style="border-radius: 14px; border-color: {{ $isTerlambat ? '#fca5a5' : '#e8e2d4' }} !important; background: #ffffff;">
                                        <div class="card-body p-3 p-md-4">
                                            <div class="d-flex align-items-start">
                                                <!-- Cover Thumbnail -->
                                                <div class="book-cover-thumb book-cover-thumb-md mr-3 flex-shrink-0 shadow-sm" style="width: 74px; height: 108px;">
                                                    <img src="{{ asset('storage/' . ($item->buku->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                                        alt="{{ $item->buku->judul_buku ?? 'Buku' }}"
                                                        onerror="this.onerror=null; this.src='{{ asset('storage/cover-buku/book-default-cover.jpg') }}';">
                                                </div>

                                                <!-- Book Information -->
                                                <div class="flex-grow-1 min-w-0 pr-2">
                                                    <div class="d-flex flex-wrap align-items-center mb-1">
                                                        <span class="badge badge-info px-2 py-1 mr-2 font-weight-bold" style="font-size: 0.72rem; border-radius: 6px;">
                                                            {{ $item->buku->kategori->nama_kategori ?? 'Koleksi Umum' }}
                                                        </span>
                                                        <code class="small text-muted font-weight-bold" style="background: #f8f5ee; padding: 2px 6px; border-radius: 4px; border: 1px solid #e8e2d4;">
                                                            {{ $item->no_pinjam }}
                                                        </code>
                                                    </div>

                                                    <h5 class="font-weight-bold text-dark mb-1" style="line-height: 1.35; font-size: 1.05rem;" title="{{ $item->buku->judul_buku }}">
                                                        {{ $item->buku->judul_buku ?? 'Judul Buku Tidak Ditemukan' }}
                                                    </h5>

                                                    <div class="text-muted small mb-2 d-flex flex-wrap align-items-center">
                                                        <span class="mr-3"><i class="fas fa-feather-alt mr-1" style="color: #8b4513;"></i>{{ $item->buku->pengarang ?? '-' }}</span>
                                                        <span><i class="fas fa-university mr-1" style="color: #746454;"></i>{{ $item->buku->penerbit ?? '-' }} ({{ $item->buku->tahun_terbit ?? '-' }})</span>
                                                    </div>

                                                    <div class="p-2 rounded mt-2 small" style="background: #fbf9f4; border: 1px solid #ebd9c0;">
                                                        <div class="d-flex justify-content-between py-1 border-bottom" style="border-color: #ebd9c0 !important;">
                                                            <span class="text-muted"><i class="fas fa-calendar-alt text-primary mr-1"></i> Tanggal Pinjam:</span>
                                                            <strong class="text-dark">{{ $tglPinjam->translatedFormat('d M Y') }}</strong>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-1 border-bottom" style="border-color: #ebd9c0 !important;">
                                                            <span class="text-muted"><i class="fas fa-hourglass-half text-warning mr-1"></i> Batas Waktu Kembali:</span>
                                                            <strong class="{{ $isTerlambat ? 'text-danger font-weight-bold' : 'text-dark' }}">
                                                                {{ $tglKembali->translatedFormat('d M Y') }}
                                                            </strong>
                                                        </div>
                                                        <div class="d-flex justify-content-between py-1">
                                                            <span class="text-muted"><i class="fas fa-user-tie text-secondary mr-1"></i> Petugas Loket:</span>
                                                            <span class="text-muted font-weight-semibold">{{ $item->pinjam->petugas_pinjam->nama ?? 'Staf Perpustakaan' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Due Date Status Banner -->
                                            <div class="mt-3 pt-3 border-top" style="border-color: #efe8dc !important;">
                                                @if($isTerlambat)
                                                    <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background: #fef2f2; border: 1px solid #fecaca;">
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge badge-danger px-2 py-1 mr-2 font-weight-bold" style="border-radius: 6px;">
                                                                <i class="fas fa-exclamation-triangle mr-1"></i> Terlambat {{ $hariTerlambat }} Hari
                                                            </span>
                                                            <span class="small text-danger font-weight-bold">Estimasi Denda: Rp {{ number_format($estimasiDenda, 0, ',', '.') }}</span>
                                                        </div>
                                                        <small class="text-danger font-weight-bold">Segera Kembalikan</small>
                                                    </div>
                                                @elseif($isToday)
                                                    <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background: #fefce8; border: 1px solid #fef08a;">
                                                        <span class="badge badge-warning px-2 py-1 font-weight-bold text-dark" style="border-radius: 6px;">
                                                            <i class="fas fa-clock mr-1"></i> Jatuh Tempo Hari Ini
                                                        </span>
                                                        <small class="text-dark font-weight-semibold">Batas pengembalian hari ini</small>
                                                    </div>
                                                @else
                                                    <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background: #f0fdf4; border: 1px solid #bbf7d0;">
                                                        <span class="badge badge-success px-2 py-1 font-weight-bold" style="border-radius: 6px;">
                                                            <i class="fas fa-check-circle mr-1"></i> Masa Pinjam Aktif
                                                        </span>
                                                        <small class="text-success font-weight-bold">Sisa waktu {{ $sisaHari }} hari lagi</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- TAB 2: RIWAYAT PENGEMBALIAN (SELESAI) -->
                <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="riwayat-tab">
                    @if($riwayatKembali->isEmpty())
                        <div class="text-center py-5 px-3 rounded-xl my-3" style="background: #fdfbf7; border: 1px dashed #e8e2d4; border-radius: 16px;">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; background: rgba(197, 155, 39, 0.15); border: 1px solid rgba(197, 155, 39, 0.3);">
                                <i class="fas fa-history fa-2x" style="color: #c59b27;"></i>
                            </div>
                            <h4 class="font-weight-bold text-dark mb-2">Belum Ada Riwayat Pengembalian</h4>
                            <p class="text-muted mx-auto mb-0" style="max-width: 500px; font-size: 0.95rem;">
                                Riwayat transaksi peminjaman buku yang telah selesai dikembalikan ke loket sirkulasi akan otomatis tercatat di sini.
                            </p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;" class="text-center">No</th>
                                        <th>Buku & Koleksi</th>
                                        <th>No. Pinjam</th>
                                        <th>Tgl Pinjam</th>
                                        <th>Tgl Dikembalikan</th>
                                        <th>Denda</th>
                                        <th>Petugas Penerima</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatKembali as $idx => $r)
                                        <tr>
                                            <td class="text-center font-weight-bold text-muted">
                                                {{ $riwayatKembali->firstItem() + $idx }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="book-cover-thumb book-cover-thumb-sm mr-2 flex-shrink-0" style="width: 38px; height: 54px;">
                                                        <img src="{{ asset('storage/' . ($r->buku->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                                            alt="{{ $r->buku->judul_buku ?? 'Buku' }}"
                                                            onerror="this.onerror=null; this.src='{{ asset('storage/cover-buku/book-default-cover.jpg') }}';">
                                                    </div>
                                                    <div>
                                                        <strong class="text-dark d-block text-truncate" style="max-width: 280px;" title="{{ $r->buku->judul_buku }}">
                                                            {{ $r->buku->judul_buku ?? 'Judul Tidak Ditemukan' }}
                                                        </strong>
                                                        <small class="text-muted">{{ $r->buku->pengarang ?? '-' }} &bull; {{ $r->buku->kategori->nama_kategori ?? 'Umum' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <code class="small text-muted font-weight-bold">{{ $r->no_pinjam }}</code>
                                            </td>
                                            <td>
                                                <span class="small text-dark font-weight-semibold">
                                                    {{ \Carbon\Carbon::parse($r->pinjam->tgl_pinjam)->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="small text-dark font-weight-semibold">
                                                    {{ $r->tgl_pengembalian ? \Carbon\Carbon::parse($r->tgl_pengembalian)->translatedFormat('d M Y') : '-' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($r->total_denda > 0)
                                                    <span class="badge badge-danger font-weight-bold px-2 py-1">
                                                        Rp {{ number_format($r->total_denda, 0, ',', '.') }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-success font-weight-bold px-2 py-1">
                                                        Bebas Denda
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="small text-muted">{{ $r->petugas_kembali->nama ?? 'Petugas Loket' }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-success px-2 py-1 font-weight-bold" style="border-radius: 6px;">
                                                    <i class="fas fa-check mr-1"></i> Selesai
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top" style="border-color: #efe8dc !important;">
                            <small class="text-muted">
                                Menampilkan {{ $riwayatKembali->firstItem() }} - {{ $riwayatKembali->lastItem() }} dari {{ $riwayatKembali->total() }} riwayat buku
                            </small>
                            <div>
                                {{ $riwayatKembali->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Circulation Guidelines Card -->
    <div class="card shadow-sm border-0" style="border-radius: 14px; background: #fdfbf7; border: 1px solid #e8e2d4 !important;">
        <div class="card-body p-4">
            <h5 class="font-weight-bold text-dark mb-3">
                <i class="fas fa-info-circle mr-2" style="color: #c59b27;"></i> Tata Tertib Pengembalian Koleksi Perpustakaan UNM
            </h5>
            <div class="row small text-muted">
                <div class="col-md-4 mb-2 mb-md-0">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-building text-primary mr-2 mt-1"></i>
                        <div>
                            <strong class="text-dark d-block">Loket Sirkulasi</strong>
                            Pengembalian buku dilakukan langsung ke loket sirkulasi perpustakaan pada jam operasional kerja kampus.
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-calculator text-warning mr-2 mt-1"></i>
                        <div>
                            <strong class="text-dark d-block">Tarif Denda Keterlambatan</strong>
                            Denda keterlambatan berlaku Rp 1.000 / hari per buku yang disetorkan langsung saat pengembalian fisik.
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-heart text-success mr-2 mt-1"></i>
                        <div>
                            <strong class="text-dark d-block">Kondisi Fisik Buku</strong>
                            Pastikan buku dikembalikan dalam kondisi rapi tanpa coretan atau robekan demi menjaga fasilitas bersama.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
