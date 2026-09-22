@extends('member.layout.main')

@section('title', 'Katalog Buku Perpustakaan')

@section('content')
<div class="bg-dark text-white py-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #1f2937 0%, #111827 100%);">
    <div class="container text-center">
        <h1 class="display-4 font-weight-bold mb-2"><i class="fas fa-book-reader text-primary mr-2"></i> Katalog E-Library UNM</h1>
        <p class="lead mb-4 text-light">Temukan, pesan, dan pinjam berbagai koleksi buku terbaik dengan mudah dan cepat secara online.</p>

        <!-- Form Pencarian & Filter -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('member.index') }}" method="GET" class="card card-body p-2 border-0 shadow">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control form-control-lg border-0"
                            placeholder="Cari judul buku, penulis, atau penerbit..." value="{{ request('keyword') }}">
                        <select name="kategori" class="form-control form-control-lg border-0 border-left" style="max-width: 200px;">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4" type="submit"><i class="fas fa-search"></i> Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<main role="main" class="container">
    @if(request('keyword') || request('kategori'))
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-muted">Hasil pencarian untuk: <strong>"{{ request('keyword') ?? 'Kategori Terpilih' }}"</strong></h5>
            <a href="{{ route('member.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-times mr-1"></i> Reset Filter</a>
        </div>
    @endif

    <div class="row">
        @forelse ($buku as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                <div class="card book-card border-0 shadow-sm w-100">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . ($item->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                            class="card-img-top card-img-book" alt="{{ $item->judul_buku }}">
                        <span class="badge badge-primary position-absolute" style="top: 10px; right: 10px; font-size: 0.8rem;">
                            {{ $item->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                    </div>
                    <div class="card-body d-flex flex-column text-center p-3">
                        <h6 class="card-title font-weight-bold text-dark mb-1" title="{{ $item->judul_buku }}">
                            {{ Str::limit($item->judul_buku, 40) }}
                        </h6>
                        <small class="text-muted mb-1">{{ $item->pengarang }}</small>
                        <small class="text-secondary mb-2">{{ $item->penerbit }} ({{ $item->tahun_terbit }})</small>

                        <div class="mt-auto pt-2 border-top">
                            @if($item->stok > 0)
                                <span class="badge badge-success px-2 py-1 mb-2">Tersedia {{ $item->stok }} eks</span>
                            @else
                                <span class="badge badge-danger px-2 py-1 mb-2">Stok Habis</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0 pb-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="detailBuku('{{ $item->id }}')">
                            <i class="fas fa-info-circle mr-1"></i> Detail
                        </button>

                        @if ($item->stok > 0)
                            <form action="{{ route('member.tambahKeranjang') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-cart-plus mr-1"></i> Booking
                                </button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-secondary disabled" disabled>Habis</button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted">
                    <i class="fas fa-book-open fa-4x mb-3 text-secondary"></i>
                    <h4>Tidak ada buku yang ditemukan</h4>
                    <p>Silakan coba kata kunci lain atau lihat kategori yang berbeda.</p>
                    <a href="{{ route('member.index') }}" class="btn btn-primary mt-2">Lihat Semua Koleksi Buku</a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $buku->links('pagination::bootstrap-4') }}
    </div>
</main>

<!-- Modal Detail Buku -->
<div class="modal fade" id="detailBukuModal" tabindex="-1" role="dialog" aria-labelledby="detailBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold" id="detailBukuModalLabel"><i class="fas fa-book-open text-primary mr-2"></i> Detail Informasi Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-lg-4 text-center mb-3 mb-lg-0">
                        <img src="" class="img-fluid rounded shadow-sm" alt="Cover Buku" style="max-height: 250px; object-fit: cover;" id="gambar">
                    </div>
                    <div class="col-lg-8">
                        <h4 id="judul_buku" class="font-weight-bold text-primary mb-3"></h4>
                        <table class="table table-sm table-striped">
                            <tr>
                                <th style="width: 35%;">Kategori</th>
                                <td id="kategori"></td>
                            </tr>
                            <tr>
                                <th>Pengarang</th>
                                <td id="pengarang"></td>
                            </tr>
                            <tr>
                                <th>Penerbit</th>
                                <td id="penerbit"></td>
                            </tr>
                            <tr>
                                <th>Tahun Terbit</th>
                                <td id="tahun_terbit"></td>
                            </tr>
                            <tr>
                                <th>Nomor ISBN</th>
                                <td id="isbn"></td>
                            </tr>
                            <tr>
                                <th>Stok Tersedia</th>
                                <td id="stok"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form id="formTambahKeranjangModal" action="{{ route('member.tambahKeranjang') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="id" id="modalBookId" value="">
                    <button type="submit" class="btn btn-success" id="btnTambahKeranjangModal">
                        <i class="fas fa-cart-plus mr-1"></i> Tambah ke Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function detailBuku(id) {
        $.ajax({
            url: APP_URL + '/detail-buku/' + id,
            dataType: 'json',
            type: 'GET',
            error: function() {
                toastr.error('Gagal mengambil data buku.');
            },
            success: function(data) {
                var imageSrc = data.image ? (APP_URL + '/storage/' + data.image) : (APP_URL + '/storage/cover-buku/book-default-cover.jpg');
                $('#gambar').attr('src', imageSrc);
                $('#judul_buku').html(data.judul_buku);
                $('#kategori').html(data.kategori ? data.kategori.nama_kategori : '-');
                $('#pengarang').html(data.pengarang);
                $('#penerbit').html(data.penerbit);
                $('#tahun_terbit').html(data.tahun_terbit);
                $('#isbn').html(data.isbn);
                $('#stok').html('<span class="badge badge-success">' + data.stok + ' Eksemplar</span>');

                $('#modalBookId').val(data.id);

                if (data.stok > 0) {
                    $('#btnTambahKeranjangModal').removeClass('d-none');
                } else {
                    $('#btnTambahKeranjangModal').addClass('d-none');
                }

                $('#detailBukuModal').modal('show');
            }
        });
    }
</script>
@endpush
