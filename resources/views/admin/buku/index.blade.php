@extends('admin.layout.main')

@section('title', 'Data Buku')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center w-100">
                    <h5 class="font-weight-bold mb-0 text-dark">
                        <i class="fas fa-book mr-2 text-primary"></i> Daftar Master Koleksi Buku
                    </h5>
                    <div class="ml-auto">
                        <a href="{{ route('admin.master.buku.create') }}" class="btn btn-primary btn-sm font-weight-bold shadow-sm px-3 py-2" style="border-radius: 8px;">
                            <i class="fas fa-plus mr-1"></i> Tambah Buku Baru
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="bg-light text-center">
                                    <th style="width: 50px;">#</th>
                                    <th style="width: 70px;">Cover</th>
                                    <th class="text-left">Judul & ISBN</th>
                                    <th>Kategori</th>
                                    <th class="text-left">Pengarang / Penerbit</th>
                                    <th style="width: 70px;">Tahun</th>
                                    <th style="width: 70px;">Stok</th>
                                    <th style="width: 70px;">Dipinjam</th>
                                    <th style="width: 70px;">Dibooking</th>
                                    <th style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($buku as $b)
                                <tr>
                                    <td class="text-center font-weight-bold text-muted">{{ $loop->iteration + ($buku->currentPage() - 1) * $buku->perPage() }}</td>
                                    <td class="text-center">
                                        <div class="rounded border p-1 bg-light shadow-sm d-inline-block" style="width: 48px; height: 65px; overflow: hidden;">
                                            <img src="{{ asset('storage/' . ($b->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                                class="w-100 h-100" style="object-fit: cover;" alt="Cover">
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-dark d-block" style="font-size: 0.95rem;">{{ $b->judul_buku }}</strong>
                                        <small class="text-muted">ISBN: <code>{{ $b->isbn }}</code></small>
                                    </td>
                                    <td class="text-center"><span class="badge badge-info">{{ $b->kategori->nama_kategori ?? '-' }}</span></td>
                                    <td class="small">
                                        <div class="font-weight-bold text-dark">{{ $b->pengarang }}</div>
                                        <div class="text-muted">{{ $b->penerbit }}</div>
                                    </td>
                                    <td class="text-center font-weight-bold text-secondary">{{ $b->tahun_terbit }}</td>
                                    <td class="text-center">
                                        @if($b->stok > 0)
                                            <span class="badge badge-success font-weight-bold">{{ $b->stok }}</span>
                                        @else
                                            <span class="badge badge-danger font-weight-bold">0</span>
                                        @endif
                                    </td>
                                    <td class="text-center"><span class="badge badge-warning font-weight-bold">{{ $b->dipinjam }}</span></td>
                                    <td class="text-center"><span class="badge badge-secondary font-weight-bold">{{ $b->dibooking }}</span></td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.master.buku.destroy', $b->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                            <a href="{{ route('admin.master.buku.show', $b->id) }}" class="btn btn-sm btn-outline-info p-1 px-2" title="Detail"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.master.buku.edit', $b->id) }}" class="btn btn-sm btn-outline-warning p-1 px-2" title="Edit"><i class="fas fa-edit"></i></a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-5">
                                        <i class="fas fa-book-open fa-3x text-muted mb-2 d-block"></i>
                                        Belum ada koleksi buku di perpustakaan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 border-top d-flex justify-content-end">
                        {{ $buku->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

