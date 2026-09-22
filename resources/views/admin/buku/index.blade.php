@extends('admin.layout.main')

@section('title', 'Data Buku')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-book mr-1"></i> Daftar Master Buku</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.master.buku.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah Buku Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 40px;">#</th>
                                    <th style="width: 70px;">Cover</th>
                                    <th>Judul Buku</th>
                                    <th>Kategori</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th style="width: 70px;">Tahun</th>
                                    <th style="width: 70px;">Stok</th>
                                    <th style="width: 70px;">Dipinjam</th>
                                    <th style="width: 70px;">Dibooking</th>
                                    <th style="width: 130px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($buku as $b)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration + ($buku->currentPage() - 1) * $buku->perPage() }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . ($b->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                            width="50" height="70" class="img-thumbnail" style="object-fit: cover;" alt="Cover">
                                    </td>
                                    <td><strong>{{ $b->judul_buku }}</strong><br><small class="text-muted">ISBN: {{ $b->isbn }}</small></td>
                                    <td><span class="badge badge-info">{{ $b->kategori->nama_kategori ?? '-' }}</span></td>
                                    <td>{{ $b->pengarang }}</td>
                                    <td>{{ $b->penerbit }}</td>
                                    <td class="text-center">{{ $b->tahun_terbit }}</td>
                                    <td class="text-center"><span class="badge badge-success">{{ $b->stok }}</span></td>
                                    <td class="text-center"><span class="badge badge-warning">{{ $b->dipinjam }}</span></td>
                                    <td class="text-center"><span class="badge badge-secondary">{{ $b->dibooking }}</span></td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.master.buku.destroy', $b->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                            <a href="{{ route('admin.master.buku.show', $b->id) }}" class="btn btn-xs btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.master.buku.edit', $b->id) }}" class="btn btn-xs btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted py-3">Belum ada koleksi buku di perpustakaan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 float-right">
                        {{ $buku->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
