@extends('admin.layout.main')

@section('title', 'Proses Transaksi Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-xl overflow-hidden mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                    <div>
                        <h4 class="font-weight-bold text-dark mb-1">
                            <i class="fas fa-clipboard-check text-primary mr-2"></i>Verifikasi & Proses Peminjaman
                        </h4>
                        <p class="text-muted small mb-0">Konfirmasi serah terima fisik buku dari reservasi anggota perpustakaan</p>
                    </div>
                    <div class="mt-2 mt-md-0">
                        <a href="{{ route('admin.transaksi.booking.index') }}" class="btn btn-outline-secondary btn-sm px-3">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Booking
                        </a>
                    </div>
                </div>

                <div class="card-body px-4 pt-3">
                    <form action="{{ route('admin.transaksi.peminjaman.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_booking" value="{{ $data_booking[0]->id_booking }}">

                        <!-- Alert Instruction -->
                        <div class="alert alert-info border-0 rounded-lg shadow-sm d-flex align-items-center mb-4" style="background-color: #eff6ff; color: #1e40af; border-left: 4px solid #3b82f6 !important;">
                            <i class="fas fa-info-circle fa-2x mr-3 text-primary"></i>
                            <div>
                                <strong class="d-block mb-1">Instruksi Petugas:</strong>
                                Periksa fisik buku yang diambil anggota. Tentukan tarif denda harian dan durasi peminjaman untuk masing-masing buku, lalu klik <strong>"Konfirmasi & Proses Pinjam"</strong>.
                            </div>
                        </div>

                        <!-- Reservation Details Bar -->
                        <div class="p-3 bg-light rounded-xl border mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-3 col-6 mb-2 mb-md-0">
                                    <span class="text-muted small font-weight-bold d-block text-uppercase">No. Reservasi</span>
                                    <strong class="text-primary font-weight-bold" style="font-size: 1.1rem;">
                                        {{ $data_booking[0]->id_booking }}
                                    </strong>
                                </div>
                                <div class="col-md-3 col-6 mb-2 mb-md-0 border-left-md pl-md-3">
                                    <span class="text-muted small font-weight-bold d-block text-uppercase">Nama Anggota</span>
                                    <strong class="text-dark">{{ $data_booking[0]->anggota->nama ?? '-' }}</strong>
                                    <small class="text-muted d-block">{{ $data_booking[0]->anggota->email ?? '' }}</small>
                                </div>
                                <div class="col-md-3 col-6 border-left-md pl-md-3">
                                    <span class="text-muted small font-weight-bold d-block text-uppercase">Waktu Booking</span>
                                    <span class="text-dark font-weight-semibold">
                                        {{ date('d-m-Y H:i', strtotime($data_booking[0]->tgl_booking)) }} WIB
                                    </span>
                                </div>
                                <div class="col-md-3 col-6 border-left-md pl-md-3">
                                    <span class="text-muted small font-weight-bold d-block text-uppercase">Batas Akhir Ambil</span>
                                    <span class="badge badge-warning px-2 py-1 font-weight-bold" style="border-radius: 6px;">
                                        <i class="fas fa-clock mr-1"></i>{{ date('d-m-Y H:i', strtotime($data_booking[0]->batas_ambil)) }} WIB
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Table of Items -->
                        <div class="mb-3">
                            <h5 class="font-weight-bold text-dark mb-3">
                                <i class="fas fa-books text-primary mr-1"></i> Rincian Buku yang Akan Dipinjam:
                            </h5>
                            <div class="table-responsive">
                                <table id="data-booking" class="table table-hover align-middle border rounded-lg overflow-hidden">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">#</th>
                                            <th style="width: 70px;">Cover</th>
                                            <th>Informasi Buku</th>
                                            <th>Pengarang & Penerbit</th>
                                            <th class="text-center">Tahun</th>
                                            <th style="width: 170px;">Tarif Denda/Hari <span class="text-danger">*</span></th>
                                            <th style="width: 150px;">Durasi Pinjam <span class="text-danger">*</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_booking as $booking)
                                            @foreach ($booking->booking_detail as $detail)
                                                <tr>
                                                    <td class="text-center align-middle font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                                    <td class="align-middle">
                                                        <img src="{{ asset('storage/' . ($detail->buku->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                                            class="rounded shadow-sm" width="54" height="74" style="object-fit: cover;" alt="Cover Buku">
                                                    </td>
                                                    <td class="align-middle">
                                                        <h6 class="font-weight-bold text-dark mb-1">{{ $detail->buku->judul_buku ?? 'Buku Dihapus' }}</h6>
                                                        <span class="badge badge-primary px-2 py-1" style="font-size: 0.75rem; border-radius: 4px;">
                                                            {{ $detail->buku->kategori->nama_kategori ?? '-' }}
                                                        </span>
                                                        <small class="text-muted d-block mt-1">ISBN: {{ $detail->buku->isbn ?? '-' }}</small>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="text-dark font-weight-semibold">{{ $detail->buku->pengarang ?? '-' }}</span>
                                                        <small class="text-muted d-block">{{ $detail->buku->penerbit ?? '-' }}</small>
                                                    </td>
                                                    <td class="text-center align-middle">{{ $detail->buku->tahun_terbit ?? '-' }}</td>
                                                    <td class="align-middle">
                                                        <div class="input-group input-group-sm">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bg-light font-weight-semibold">Rp</span>
                                                            </div>
                                                            <input type="number" class="form-control" name="denda[]" value="1000" min="0" step="500" required>
                                                        </div>
                                                        <small class="text-muted">Per hari keterlambatan</small>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" class="form-control text-center font-weight-bold" name="lama[]" value="7" min="1" max="30" required>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text bg-light">Hari</span>
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">Maksimal 30 hari</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Action buttons -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('admin.transaksi.booking.index') }}" class="btn btn-outline-secondary font-weight-semibold">
                                <i class="fas fa-arrow-left mr-1"></i> Batal & Kembali
                            </a>
                            <button type="submit" class="btn btn-success px-4 py-2 font-weight-bold shadow-sm" style="border-radius: 8px;">
                                <i class="fas fa-check-circle mr-2"></i>Konfirmasi & Proses Pinjam
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
