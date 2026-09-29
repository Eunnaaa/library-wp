@extends('member.layout.main')

@section('title', 'Katalog Buku Perpustakaan')

@section('content')
<div class="position-relative text-white py-5 mb-5 shadow-sm" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #2563eb 100%); overflow: hidden;">
    <!-- Ambient glowing accents -->
    <div class="position-absolute" style="top: -100px; right: -100px; width: 350px; height: 350px; background: radial-gradient(circle, rgba(56, 189, 248, 0.25) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; pointer-events: none;"></div>
    <div class="position-absolute" style="bottom: -120px; left: -80px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, rgba(0,0,0,0) 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="container position-relative text-center py-2">
        <div class="d-inline-flex align-items-center mb-3 px-3 py-1 rounded-pill" style="background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.2);">
            <i class="fas fa-university text-warning mr-2"></i>
            <span class="small font-weight-bold letter-spacing-1 text-uppercase text-white-50">Perpustakaan Digital Universitas Nusa Mandiri</span>
        </div>

        <h1 class="display-4 font-weight-bold mb-3 text-white" style="letter-spacing: -0.03em;">
            <i class="fas fa-book-reader text-primary mr-2"></i> Katalog E-Library UNM
        </h1>
        <p class="lead mb-4 mx-auto text-light opacity-90" style="max-width: 680px; font-size: 1.15rem; line-height: 1.6;">
            Akses ribuan literatur akademik, buku teks informatika, dan referensi riset ilmiah secara praktis dengan reservasi peminjaman online 24 jam.
        </p>

        <!-- Search Bar with Floating Container -->
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-11">
                <form action="{{ route('member.index') }}" method="GET" class="card p-2 border-0 shadow-lg" style="border-radius: 16px; background: #ffffff;">
                    <div class="input-group">
                        <div class="input-group-prepend d-none d-sm-flex align-items-center pl-3 pr-2 text-muted">
                            <i class="fas fa-search text-primary"></i>
                        </div>
                        <input type="text" name="keyword" class="form-control form-control-lg border-0 shadow-none"
                            placeholder="Cari judul buku, nama pengarang, atau penerbit..." value="{{ request('keyword') }}"
                            style="font-size: 1rem; color: #1e293b;">

                        <select name="kategori" class="form-control form-control-lg border-0 border-left shadow-none text-secondary" style="max-width: 200px; font-size: 0.95rem;">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>

                        <div class="input-group-append">
                            <button class="btn btn-primary px-4 py-2 font-weight-bold d-flex align-items-center" type="submit" style="border-radius: 12px; margin: 2px;">
                                <i class="fas fa-search mr-2"></i> <span>Temukan</span>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Quick Category Filter Pills -->
                <div class="d-flex flex-wrap justify-content-center align-items-center mt-3 small">
                    <span class="text-white-50 mr-2 mb-2 font-weight-bold">Kategori Populer:</span>
                    <a href="{{ route('member.index') }}" class="badge badge-pill {{ !request('kategori') ? 'badge-light text-primary font-weight-bold' : 'badge-dark text-white' }} px-3 py-2 mr-2 mb-2" style="font-size: 0.82rem; text-decoration: none;">
                        Semua
                    </a>
                    @foreach($kategori->take(6) as $k)
                        <a href="{{ route('member.index', ['kategori' => $k->id]) }}" class="badge badge-pill {{ request('kategori') == $k->id ? 'badge-light text-primary font-weight-bold' : 'badge-dark text-white' }} px-3 py-2 mr-2 mb-2" style="font-size: 0.82rem; text-decoration: none; background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.2);">
                            {{ $k->nama_kategori }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<main role="main" class="container">
    @if(request('keyword') || request('kategori'))
        <div class="alert alert-light border d-flex justify-content-between align-items-center mb-4 py-2 px-3 shadow-sm rounded-lg">
            <div class="d-flex align-items-center">
                <i class="fas fa-filter text-primary mr-2"></i>
                <span class="text-secondary">
                    Menampilkan hasil pencarian untuk:
                    @if(request('keyword')) <strong>"{{ request('keyword') }}"</strong> @endif
                    @if(request('kategori'))
                        @php
                            $selectedKat = $kategori->firstWhere('id', request('kategori'));
                        @endphp
                        <span class="badge badge-info ml-1">Kategori: {{ $selectedKat ? $selectedKat->nama_kategori : request('kategori') }}</span>
                    @endif
                </span>
            </div>
            <a href="{{ route('member.index') }}" class="btn btn-sm btn-outline-secondary font-weight-bold">
                <i class="fas fa-times mr-1"></i> Reset Pencarian
            </a>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h4 class="font-weight-bold text-dark mb-1">Koleksi Buku Terkini</h4>
            <p class="text-muted small mb-0">Jelajahi dan lakukan pemesanan buku untuk dipinjam di perpustakaan</p>
        </div>
        <span class="badge badge-primary px-3 py-2 font-weight-bold" style="font-size: 0.85rem;">
            <i class="fas fa-book mr-1"></i> Total: {{ $buku->total() }} Koleksi
        </span>
    </div>

    <div class="row">
        @forelse ($buku as $item)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4 d-flex align-items-stretch">
                <div class="card book-card border-0 w-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="card-img-book-wrapper position-relative">
                            <img src="{{ asset('storage/' . ($item->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                class="card-img-book" alt="{{ $item->judul_buku }}">
                            <div class="position-absolute" style="top: 10px; right: 10px;">
                                <span class="badge badge-pill shadow-sm" style="background: rgba(15, 23, 42, 0.85); color: #38bdf8; font-size: 0.72rem; padding: 0.4em 0.8em; backdrop-filter: blur(4px);">
                                    {{ $item->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-3 text-left">
                            <h6 class="card-title font-weight-bold text-dark mb-1" style="font-size: 0.98rem; line-height: 1.4; min-height: 2.8rem;" title="{{ $item->judul_buku }}">
                                {{ Str::limit($item->judul_buku, 45) }}
                            </h6>
                            <div class="text-muted small mb-1 d-flex align-items-center">
                                <i class="fas fa-user-edit mr-2 text-primary opacity-75" style="font-size: 0.75rem;"></i>
                                <span class="text-truncate">{{ $item->pengarang }}</span>
                            </div>
                            <div class="text-muted small mb-2 d-flex align-items-center">
                                <i class="fas fa-building mr-2 text-secondary opacity-75" style="font-size: 0.75rem;"></i>
                                <span class="text-truncate">{{ $item->penerbit }} &bull; {{ $item->tahun_terbit }}</span>
                            </div>

                            <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                                <small class="text-muted font-weight-bold">Status:</small>
                                @if($item->stok > 0)
                                    <span class="badge badge-success px-2 py-1">
                                        <i class="fas fa-check-circle mr-1"></i> Tersedia {{ $item->stok }} eks
                                    </span>
                                @else
                                    <span class="badge badge-danger px-2 py-1">
                                        <i class="fas fa-times-circle mr-1"></i> Habis
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                        <div class="row no-gutters">
                            <div class="col-5 pr-1">
                                <button type="button" class="btn btn-outline-primary btn-sm btn-block font-weight-bold" onclick="detailBuku('{{ $item->id }}')">
                                    <i class="fas fa-info-circle mr-1"></i> Detail
                                </button>
                            </div>
                            <div class="col-7 pl-1">
                                @if ($item->stok > 0)
                                    <form action="{{ route('member.tambahKeranjang') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-primary btn-sm btn-block font-weight-bold shadow-sm">
                                            <i class="fas fa-cart-plus mr-1"></i> Booking
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm btn-block disabled font-weight-bold" disabled>
                                        <i class="fas fa-ban mr-1"></i> Kosong
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 my-4">
                <div class="card card-body border-0 shadow-sm py-5 px-4 mx-auto" style="max-width: 500px; border-radius: 16px;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px; background: #f1f5f9;">
                        <i class="fas fa-book-open fa-2x text-muted"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark">Tidak ada buku yang ditemukan</h5>
                    <p class="text-muted small mb-3">Silakan gunakan kata kunci pencarian yang lain atau jelajahi semua kategori buku.</p>
                    <a href="{{ route('member.index') }}" class="btn btn-primary btn-sm px-4 mx-auto">
                        <i class="fas fa-sync mr-1"></i> Tampilkan Semua Koleksi
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4 mb-4">
        {{ $buku->links('pagination::bootstrap-4') }}
    </div>
</main>

<!-- Modal Detail Buku -->
<div class="modal fade" id="detailBukuModal" tabindex="-1" role="dialog" aria-labelledby="detailBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e293b, #0f172a);">
                <h5 class="modal-title font-weight-bold" id="detailBukuModalLabel">
                    <i class="fas fa-book-open text-primary mr-2"></i> Informasi Detail Koleksi Buku
                </h5>
                <button type="button" class="close text-white opacity-90" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-center mb-4 mb-lg-0">
                        <div class="p-2 border rounded-lg bg-light shadow-sm d-inline-block">
                            <img src="" class="img-fluid rounded" alt="Cover Buku" style="max-height: 260px; object-fit: cover;" id="gambar">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <h4 id="judul_buku" class="font-weight-bold text-dark mb-3" style="line-height: 1.3;"></h4>
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    <tr class="border-bottom">
                                        <th class="text-muted font-weight-500 py-2" style="width: 35%;">Kategori</th>
                                        <td id="kategori" class="font-weight-bold text-primary py-2"></td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="text-muted font-weight-500 py-2">Nama Pengarang</th>
                                        <td id="pengarang" class="text-dark font-weight-bold py-2"></td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="text-muted font-weight-500 py-2">Penerbit</th>
                                        <td id="penerbit" class="text-dark py-2"></td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="text-muted font-weight-500 py-2">Tahun Terbit</th>
                                        <td id="tahun_terbit" class="text-dark py-2"></td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="text-muted font-weight-500 py-2">Nomor ISBN</th>
                                        <td id="isbn" class="text-secondary font-monospace py-2"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted font-weight-500 py-2">Ketersediaan Fisik</th>
                                        <td id="stok" class="py-2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary btn-sm px-4" data-dismiss="modal">Tutup</button>
                <form id="formTambahKeranjangModal" action="{{ route('member.tambahKeranjang') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="id" id="modalBookId" value="">
                    <button type="submit" class="btn btn-primary btn-sm px-4 font-weight-bold shadow-sm" id="btnTambahKeranjangModal">
                        <i class="fas fa-cart-plus mr-1"></i> Masukkan ke Keranjang Booking
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

                $('#modalBookId').val(data.id);

                if (data.stok > 0) {
                    $('#stok').html('<span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> Tersedia ' + data.stok + ' Eksemplar</span>');
                    $('#btnTambahKeranjangModal').removeClass('d-none');
                } else {
                    $('#stok').html('<span class="badge badge-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i> Stok Habis</span>');
                    $('#btnTambahKeranjangModal').addClass('d-none');
                }

                $('#detailBukuModal').modal('show');
            }
        });
    }
</script>
@endpush
