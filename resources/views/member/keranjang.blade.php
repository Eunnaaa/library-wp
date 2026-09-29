@extends('member.layout.main')

@section('title', 'Keranjang Reservasi Buku')

@section('content')
<div class="container pt-4 pb-5">
    <!-- Breadcrumb & Step Navigation -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; background: #ffffff;">
        <div class="card-body py-3 px-4">
            <div class="row align-items-center">
                <div class="col-md-6 mb-2 mb-md-0">
                    <h5 class="font-weight-bold text-dark mb-0">
                        <i class="fas fa-shopping-basket text-primary mr-2"></i> Keranjang Peminjaman Buku
                    </h5>
                    <small class="text-muted">Periksa kembali daftar buku yang akan Anda booking sebelum konfirmasi akhir.</small>
                </div>
                <div class="col-md-6 text-md-right">
                    <div class="d-inline-flex align-items-center small">
                        <span class="badge badge-success px-3 py-2 mr-2"><i class="fas fa-check mr-1"></i> 1. Pilih Buku</span>
                        <i class="fas fa-arrow-right text-muted mr-2"></i>
                        <span class="badge badge-primary px-3 py-2 mr-2">2. Review Keranjang</span>
                        <i class="fas fa-arrow-right text-muted mr-2"></i>
                        <span class="badge badge-secondary px-3 py-2 opacity-50">3. Ambil di Kampus</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!$temp->isEmpty())
        <div class="row">
            <!-- Left: Table of books -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <span class="font-weight-bold text-dark">Daftar Buku Dipesan ({{ $temp->count() }} item)</span>
                        <a href="{{ route('member.index') }}" class="btn btn-outline-primary btn-sm font-weight-bold">
                            <i class="fas fa-plus mr-1"></i> Tambah Buku Lain
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px;">#</th>
                                        <th style="width: 90px;">Cover</th>
                                        <th>Detail Buku</th>
                                        <th class="text-center" style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($temp as $item)
                                        <tr>
                                            <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="rounded border p-1 bg-light shadow-sm" style="width: 70px; height: 95px; overflow: hidden;">
                                                    <img src="{{ asset('storage/' . ($item->buku->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                                        class="w-100 h-100" style="object-fit: cover;" alt="Cover Buku">
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-info mb-1">{{ $item->buku->kategori->nama_kategori ?? 'Umum' }}</span>
                                                <h6 class="font-weight-bold text-dark mb-1" style="line-height: 1.3;">
                                                    {{ $item->buku->judul_buku ?? 'Buku Tidak Ditemukan' }}
                                                </h6>
                                                <div class="text-muted small">
                                                    <span><i class="fas fa-user-edit mr-1 text-primary opacity-75"></i> {{ $item->buku->pengarang ?? '-' }}</span> &bull;
                                                    <span><i class="fas fa-building mr-1 text-secondary opacity-75"></i> {{ $item->buku->penerbit ?? '-' }} ({{ $item->buku->tahun_terbit ?? '-' }})</span>
                                                </div>
                                                <div class="small text-secondary mt-1">
                                                    <span>ISBN: <code>{{ $item->buku->isbn ?? '-' }}</code></span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('member.hapusKeranjang', ['buku' => $item->id_buku]) }}" method="POST"
                                                    onsubmit="return confirm('Hapus buku ini dari keranjang?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1" title="Hapus dari keranjang">
                                                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; position: sticky; top: 85px;">
                    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #1e293b, #0f172a);">
                        <h6 class="font-weight-bold mb-0"><i class="fas fa-receipt text-warning mr-2"></i> Ringkasan Reservasi</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <span class="text-muted">Total Buku Dipesan:</span>
                            <span class="font-weight-bold h5 mb-0 text-primary">{{ $temp->count() }} / 3 Buku</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <span class="text-muted">Batas Pengambilan:</span>
                            <span class="badge badge-warning px-2 py-1 font-weight-bold">1 x 24 Jam</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <span class="text-muted">Biaya Peminjaman:</span>
                            <span class="badge badge-success px-2 py-1 font-weight-bold">Gratis (Civitas UNM)</span>
                        </div>

                        <div class="alert alert-warning border-0 small mt-3 mb-4 p-3" style="background: #fffbeb; color: #92400e; border-radius: 10px;">
                            <i class="fas fa-info-circle mr-1"></i>
                            Setelah tombol <strong>Konfirmasi Booking</strong> ditekan, sistem akan mengunci stok buku dan menerbitkan <strong>Bukti Reservasi (PDF)</strong> untuk dibawa ke perpustakaan kampus.
                        </div>

                        <form action="{{ route('member.simpanBooking') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                            <button type="submit" class="btn btn-success btn-block py-2 font-weight-bold shadow-sm" style="border-radius: 10px; font-size: 1rem;">
                                <i class="fas fa-check-circle mr-2"></i> Konfirmasi Booking Sekarang
                            </button>
                        </form>

                        <a href="{{ route('member.index') }}" class="btn btn-outline-secondary btn-block btn-sm mt-2" style="border-radius: 10px;">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali Pilih Buku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="card border-0 shadow-sm py-5 text-center my-4" style="border-radius: 16px;">
            <div class="card-body py-5">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; background: #eff6ff;">
                    <i class="fas fa-shopping-basket fa-3x text-primary"></i>
                </div>
                <h4 class="font-weight-bold text-dark mb-2">Keranjang Reservasi Anda Masih Kosong</h4>
                <p class="text-muted mx-auto mb-4" style="max-width: 480px;">
                    Anda belum memilih buku apapun untuk dipinjam. Buka katalog buku perpustakaan kami dan klik tombol booking pada buku pilihan Anda.
                </p>
                <a href="{{ route('member.index') }}" class="btn btn-primary px-4 py-2 font-weight-bold shadow-sm" style="border-radius: 10px;">
                    <i class="fas fa-book-open mr-2"></i> Jelajahi Koleksi Buku
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

