@extends('member.layout.main')

@section('title', 'Keranjang Reservasi Buku')

@section('content')
<div class="container pt-4 pb-5">
    <!-- Breadcrumb & Step Navigation Wizard -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; background: #ffffff; border: 1px solid #e8e2d4 !important;">
        <div class="card-body py-3 px-3 px-md-4">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-3 mb-lg-0">
                    <h5 class="font-weight-bold text-dark mb-1" style="letter-spacing: -0.02em;">
                        <i class="fas fa-shopping-basket text-primary mr-2"></i> Keranjang Peminjaman Buku
                    </h5>
                    <small class="text-muted">Periksa kembali daftar buku pilihan Anda sebelum memfinalisasi reservasi.</small>
                </div>
                <div class="col-lg-7 text-lg-right">
                    <div class="d-inline-flex flex-wrap align-items-center justify-content-start justify-content-lg-end" style="gap: 8px;">
                        <span class="badge badge-success px-3 py-2 font-weight-bold shadow-sm d-inline-flex align-items-center" style="border-radius: 9999px;">
                            <i class="fas fa-check mr-1"></i> 1. Pilih Koleksi
                        </span>
                        <i class="fas fa-chevron-right text-muted small mx-1 d-none d-sm-inline"></i>
                        <span class="badge badge-warning px-3 py-2 font-weight-bold shadow-sm d-inline-flex align-items-center" style="border-radius: 9999px; border: 1px solid rgba(197, 155, 39, 0.4);">
                            <i class="fas fa-edit mr-1"></i> 2. Tinjau Keranjang
                        </span>
                        <i class="fas fa-chevron-right text-muted small mx-1 d-none d-sm-inline"></i>
                        <span class="badge badge-secondary px-3 py-2 text-muted d-inline-flex align-items-center" style="border-radius: 9999px; background: #f1ede6; border: 1px solid #e8e2d4;">
                            <i class="fas fa-university mr-1"></i> 3. Ambil di Kampus
                        </span>
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
                    <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                        <div class="mb-2 mb-sm-0">
                            <span class="font-weight-bold text-dark" style="font-size: 1.05rem;">
                                <i class="fas fa-book-open text-primary mr-2"></i>Daftar Buku Dipesan ({{ $temp->count() }} item)
                            </span>
                        </div>
                        <div>
                            <a href="{{ route('member.index') }}" class="btn btn-outline-primary btn-sm font-weight-bold shadow-sm px-3 py-2 text-nowrap" style="border-radius: 8px;">
                                <i class="fas fa-plus mr-1"></i> Tambah Buku Lain
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px;">#</th>
                                        <th style="width: 90px;">Cover</th>
                                        <th>Detail Buku</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($temp as $item)
                                        <tr>
                                            <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="book-cover-thumb book-cover-thumb-md">
                                                    <img src="{{ asset('storage/' . ($item->buku?->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                                        alt="Cover Buku"
                                                        onerror="this.onerror=null; this.src='{{ asset('storage/cover-buku/book-default-cover.jpg') }}';">
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-info mb-1">{{ $item->buku?->kategori?->nama_kategori ?? 'Umum' }}</span>
                                                <h6 class="font-weight-bold text-dark mb-1" style="line-height: 1.3;">
                                                    {{ $item->buku?->judul_buku ?? 'Buku Tidak Ditemukan' }}
                                                </h6>
                                                <div class="text-muted small">
                                                    <span><i class="fas fa-user-edit mr-1 text-primary opacity-75"></i> {{ $item->buku?->pengarang ?? '-' }}</span> &bull;
                                                    <span><i class="fas fa-building mr-1 text-secondary opacity-75"></i> {{ $item->buku?->penerbit ?? '-' }} ({{ $item->buku?->tahun_terbit ?? '-' }})</span>
                                                </div>
                                                <div class="small text-secondary mt-1">
                                                    <span>ISBN: <code>{{ $item->buku?->isbn ?? '-' }}</code></span>
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
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px; position: sticky; top: 85px; overflow: hidden; border: 1px solid #e8e2d4 !important;">
                    <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #1b1008, #2c1a10); border-bottom: 2px solid #c59b27;">
                        <h6 class="font-weight-bold mb-0" style="color: #fdfbf7; letter-spacing: -0.01em;"><i class="fas fa-receipt mr-2" style="color: #e9c46a;"></i> Ringkasan Reservasi</h6>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $totalPinjamCount = $totalPinjam ?? 0;
                            $totalBookingCount = $totalBooking ?? 0;
                            $keranjangCount = $temp->count();
                            $totalUsed = $totalPinjamCount + $keranjangCount;
                            $exceedLimit = $totalUsed > 3;
                        @endphp
                        <div class="mb-3 pb-2 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-muted">Total Alokasi Buku:</span>
                                <span class="font-weight-bold {{ $totalUsed > 3 ? 'text-danger' : 'text-primary' }}">{{ $totalUsed }} / 3 Buku</span>
                            </div>
                            <div class="progress" style="height: 6px; border-radius: 4px; background: #ece5d8;">
                                <div class="progress-bar {{ $totalUsed > 3 ? 'bg-danger' : 'bg-primary' }}" style="width: {{ min(100, ($totalUsed / 3) * 100) }}%"></div>
                            </div>
                            <div class="mt-2 small text-muted">
                                <div class="d-flex justify-content-between">
                                    <span>&bull; Buku di keranjang ini:</span>
                                    <span class="font-weight-bold text-dark">{{ $keranjangCount }} buku</span>
                                </div>
                                @if($totalPinjamCount > 0)
                                    <div class="d-flex justify-content-between text-warning">
                                        <span>&bull; Sedang dipinjam aktif:</span>
                                        <span class="font-weight-bold">{{ $totalPinjamCount }} buku</span>
                                    </div>
                                @endif
                                @if($totalBookingCount > 0)
                                    <div class="d-flex justify-content-between text-info">
                                        <span>&bull; Booking belum diambil:</span>
                                        <span class="font-weight-bold">{{ $totalBookingCount }} buku</span>
                                    </div>
                                @endif
                            </div>
                            @if($exceedLimit)
                                <small class="text-danger font-weight-bold mt-2 d-block">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Total pinjaman & keranjang melebihi batas 3 buku! Hapus buku dari keranjang.
                                </small>
                            @else
                                <small class="text-success font-weight-bold mt-2 d-block">
                                    <i class="fas fa-check-circle mr-1"></i> Sisa kuota peminjaman: {{ max(0, 3 - $totalUsed) }} buku
                                </small>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <span class="text-muted">Batas Pengambilan:</span>
                            <span class="badge badge-warning px-2 py-1 font-weight-bold">1 x 24 Jam</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <span class="text-muted">Biaya Peminjaman:</span>
                            <span class="badge badge-success px-2 py-1 font-weight-bold">Gratis (Civitas UNM)</span>
                        </div>

                        <div class="alert alert-warning border-0 small mt-3 mb-3 p-3" style="background: #fffbeb; color: #92400e; border-radius: 10px;">
                            <i class="fas fa-info-circle mr-1"></i>
                            Setelah tombol <strong>Konfirmasi Booking</strong> ditekan, sistem akan mengunci stok buku dan menerbitkan <strong>Bukti Reservasi (PDF)</strong> untuk dibawa ke perpustakaan kampus.
                        </div>

                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="check-syarat" checked required>
                            <label class="custom-control-label small text-muted" for="check-syarat">
                                Saya bersedia mengambil buku di perpustakaan UNM dalam batas 1x24 jam.
                            </label>
                        </div>

                        <form action="{{ route('member.simpanBooking') }}" method="POST" id="form-booking">
                            @csrf
                            <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                            <button type="submit" class="btn btn-success btn-block py-2 font-weight-bold shadow-sm" id="btn-booking" style="border-radius: 10px; font-size: 1rem;" {{ $exceedLimit ? 'disabled' : '' }}>
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
        <div class="card shadow-sm py-5 text-center my-4" style="border-radius: 16px; border: 1px solid #e8e2d4 !important; background: #ffffff;">
            <div class="card-body py-5">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; background: #fdf4eb; border: 1px solid rgba(139, 69, 19, 0.15);">
                    <i class="fas fa-shopping-basket fa-3x" style="color: #8b4513;"></i>
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

@push('scripts')
<script>
    $('#form-booking').on('submit', function() {
        $('#btn-booking').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Memproses Reservasi...');
    });
</script>
@endpush

