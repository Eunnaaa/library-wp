@extends('admin.layout.main')

@section('title', 'Detail Buku')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-outline card-info shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-book-open mr-1"></i> Informasi Lengkap Buku</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="{{ asset('storage/' . ($buku->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                class="img-fluid rounded shadow-sm mb-3" style="max-height: 280px; object-fit: cover;" alt="Cover">
                            <h5><span class="badge badge-info">{{ $buku->kategori->nama_kategori ?? '-' }}</span></h5>
                        </div>
                        <div class="col-md-8">
                            <h3>{{ $buku->judul_buku }}</h3>
                            <table class="table table-sm table-striped mt-3">
                                <tr>
                                    <th style="width: 35%;">Nomor ISBN</th>
                                    <td>{{ $buku->isbn }}</td>
                                </tr>
                                <tr>
                                    <th>Pengarang</th>
                                    <td>{{ $buku->pengarang }}</td>
                                </tr>
                                <tr>
                                    <th>Penerbit</th>
                                    <td>{{ $buku->penerbit }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun Terbit</th>
                                    <td>{{ $buku->tahun_terbit }}</td>
                                </tr>
                                <tr>
                                    <th>Stok Tersedia</th>
                                    <td><span class="badge badge-success">{{ $buku->stok }} Eksemplar</span></td>
                                </tr>
                                <tr>
                                    <th>Sedang Dipinjam</th>
                                    <td><span class="badge badge-warning">{{ $buku->dipinjam }} Eksemplar</span></td>
                                </tr>
                                <tr>
                                    <th>Sedang Dibooking</th>
                                    <td><span class="badge badge-secondary">{{ $buku->dibooking }} Eksemplar</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-between">
                    <a href="{{ route('admin.master.buku.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                    <a href="{{ route('admin.master.buku.edit', $buku->id) }}" class="btn btn-warning"><i class="fas fa-edit mr-1"></i> Edit Buku</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
