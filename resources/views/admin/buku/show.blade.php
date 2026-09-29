@extends('admin.layout.main')

@section('title', 'Detail Buku')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-xl overflow-hidden mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-book-open text-primary mr-2"></i>Rincian Informasi Buku
                        </h4>
                        <p class="text-muted small mb-0">Informasi detail katalog dan ketersediaan stok fisik buku</p>
                    </div>
                    <span class="badge badge-primary px-3 py-2 font-weight-bold" style="border-radius: 8px;">
                        ID: #{{ $buku->id }}
                    </span>
                </div>

                <div class="card-body px-4 pt-3">
                    <div class="row">
                        <!-- Book Cover & Category -->
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <div class="p-3 bg-light rounded-xl border mb-3">
                                <img src="{{ asset('storage/' . ($buku->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                    class="img-fluid rounded shadow-sm"
                                    style="max-height: 280px; width: auto; object-fit: cover;"
                                    alt="Cover {{ $buku->judul_buku }}">
                            </div>
                            <span class="badge badge-primary px-3 py-2 font-weight-bold" style="border-radius: 6px; font-size: 0.85rem;">
                                <i class="fas fa-folder mr-1"></i>{{ $buku->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </div>

                        <!-- Book Metadata & Availability -->
                        <div class="col-md-8">
                            <h3 class="font-weight-bold text-dark mb-2">{{ $buku->judul_buku }}</h3>
                            <p class="text-muted mb-4">
                                <i class="fas fa-pen-nib mr-1 text-primary"></i> {{ $buku->pengarang }} &bull; 
                                <i class="fas fa-building mr-1 text-primary"></i> {{ $buku->penerbit }} ({{ $buku->tahun_terbit }})
                            </p>

                            <!-- Availability Badges / Metrics -->
                            <div class="row mb-4">
                                <div class="col-4">
                                    <div class="p-3 rounded-lg border text-center bg-light">
                                        <span class="text-muted small font-weight-bold d-block text-uppercase">Tersedia</span>
                                        <span class="h4 font-weight-bold text-success mb-0">{{ $buku->stok }}</span>
                                        <small class="text-muted d-block">Eksemplar</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 rounded-lg border text-center bg-light">
                                        <span class="text-muted small font-weight-bold d-block text-uppercase">Dipinjam</span>
                                        <span class="h4 font-weight-bold text-warning mb-0">{{ $buku->dipinjam }}</span>
                                        <small class="text-muted d-block">Eksemplar</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 rounded-lg border text-center bg-light">
                                        <span class="text-muted small font-weight-bold d-block text-uppercase">Dibooking</span>
                                        <span class="h4 font-weight-bold text-secondary mb-0">{{ $buku->dibooking }}</span>
                                        <small class="text-muted d-block">Eksemplar</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Specification Table -->
                            <div class="table-responsive">
                                <table class="table table-sm border rounded-lg overflow-hidden">
                                    <tbody>
                                        <tr>
                                            <th class="bg-light text-muted font-weight-semibold pl-3" style="width: 35%; border-top: 0;">Nomor ISBN</th>
                                            <td class="font-weight-bold" style="border-top: 0;">{{ $buku->isbn }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light text-muted font-weight-semibold pl-3">Pengarang</th>
                                            <td>{{ $buku->pengarang }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light text-muted font-weight-semibold pl-3">Penerbit</th>
                                            <td>{{ $buku->penerbit }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light text-muted font-weight-semibold pl-3">Tahun Terbit</th>
                                            <td>{{ $buku->tahun_terbit }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light text-muted font-weight-semibold pl-3">Total Eksemplar</th>
                                            <td><strong>{{ $buku->stok + $buku->dipinjam + $buku->dibooking }}</strong> Eksemplar Terdaftar</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light text-muted font-weight-semibold pl-3">Ditambahkan Pada</th>
                                            <td>{{ $buku->created_at ? $buku->created_at->format('d F Y, H:i') . ' WIB' : '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light px-4 py-3 border-0 d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.master.buku.index') }}" class="btn btn-outline-secondary font-weight-semibold">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </a>
                    <a href="{{ route('admin.master.buku.edit', $buku->id) }}" class="btn btn-warning px-4 font-weight-bold text-dark shadow-sm">
                        <i class="fas fa-edit mr-1"></i> Edit Data Buku
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
