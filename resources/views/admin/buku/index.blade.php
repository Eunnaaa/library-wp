@extends('admin.layout.main')

@section('title', 'Data Master Koleksi Buku')

@section('content')
<div class="container-fluid pb-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <!-- Header with Title & Action Button -->
                <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                    <div class="mb-2 mb-md-0">
                        <h5 class="font-weight-bold mb-1 text-dark">
                            <i class="fas fa-book mr-2 text-primary"></i> Master Koleksi Buku Perpustakaan
                        </h5>
                        <p class="text-muted small mb-0">Kelola katalog literatur pustaka, ketersediaan stok fisik, dan klasifikasi keilmuan</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.master.buku.create') }}" class="btn btn-primary btn-sm font-weight-bold shadow-sm px-3 py-2" style="border-radius: 8px;">
                            <i class="fas fa-plus mr-1"></i> Tambah Buku Baru
                        </a>
                    </div>
                </div>

                <!-- Filter & Search Bar -->
                <div class="p-3 bg-light border-bottom">
                    <form action="{{ route('admin.master.buku.index') }}" method="GET" class="row align-items-end">
                        <div class="col-lg-5 col-md-6 mb-2 mb-lg-0">
                            <label class="small text-muted font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-search mr-1 text-primary"></i> Cari Buku
                            </label>
                            <input type="text" name="keyword" class="form-control form-control-sm bg-white"
                                placeholder="Cari judul, pengarang, penerbit, atau ISBN..." value="{{ request('keyword') }}" style="border-radius: 8px;">
                        </div>

                        <div class="col-lg-3 col-md-4 mb-2 mb-lg-0">
                            <label class="small text-muted font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-tag mr-1 text-primary"></i> Kategori
                            </label>
                            <select name="kategori" class="form-control form-control-sm bg-white" style="border-radius: 8px;">
                                <option value="">Semua Kategori</option>
                                @if(isset($kategori))
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-12 d-flex">
                            <button type="submit" class="btn btn-primary btn-sm font-weight-bold px-3 mr-2 shadow-sm" style="border-radius: 8px;">
                                <i class="fas fa-filter mr-1"></i> Saring
                            </button>
                            <a href="{{ route('admin.master.buku.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 shadow-sm" style="border-radius: 8px;">
                                <i class="fas fa-redo-alt mr-1"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Active Filter Notification -->
                @if(request('keyword') || request('kategori'))
                    <div class="px-3 py-2 bg-white border-bottom small text-secondary d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-info-circle text-primary mr-1"></i>
                            Menampilkan hasil saringan:
                            @if(request('keyword')) <strong>"{{ request('keyword') }}"</strong> @endif
                            @if(request('kategori') && isset($kategori))
                                @php $selectedKat = $kategori->firstWhere('id', request('kategori')); @endphp
                                <span class="badge badge-info ml-1">Kategori: {{ $selectedKat ? $selectedKat->nama_kategori : request('kategori') }}</span>
                            @endif
                            <span class="text-muted">({{ $buku->total() }} buku ditemukan)</span>
                        </div>
                        <a href="{{ route('admin.master.buku.index') }}" class="text-danger small font-weight-bold">Hapus Filter &times;</a>
                    </div>
                @endif

                <!-- Table Content -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="bg-light text-center">
                                    <th style="width: 50px;">#</th>
                                    <th style="width: 70px;">Cover</th>
                                    <th class="text-left">Judul & ISBN</th>
                                    <th>Kategori</th>
                                    <th class="text-left">Pengarang & Penerbit</th>
                                    <th style="width: 70px;">Tahun</th>
                                    <th style="width: 80px;">Tersedia</th>
                                    <th style="width: 80px;">Dipinjam</th>
                                    <th style="width: 80px;">Dibooking</th>
                                    <th style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($buku as $b)
                                <tr>
                                    <td class="text-center font-weight-bold text-muted">{{ $loop->iteration + ($buku->currentPage() - 1) * $buku->perPage() }}</td>
                                    <td class="text-center">
                                        <div class="book-cover-thumb book-cover-thumb-sm">
                                            <img src="{{ asset('storage/' . ($b->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                                alt="Cover {{ $b->judul_buku }}"
                                                onerror="this.onerror=null; this.src='{{ asset('storage/cover-buku/book-default-cover.jpg') }}';">
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.master.buku.show', $b->id) }}" class="font-weight-bold text-dark d-block hover-primary" style="font-size: 0.95rem; line-height: 1.3;">
                                            {{ $b->judul_buku }}
                                        </a>
                                        <small class="text-muted">ISBN: <code>{{ $b->isbn }}</code></small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info font-weight-semibold">{{ $b->kategori->nama_kategori ?? '-' }}</span>
                                    </td>
                                    <td class="small">
                                        <div class="font-weight-bold text-dark"><i class="fas fa-pen-nib mr-1 text-primary opacity-75"></i> {{ $b->pengarang }}</div>
                                        <div class="text-muted"><i class="fas fa-building mr-1 text-secondary opacity-75"></i> {{ $b->penerbit }}</div>
                                    </td>
                                    <td class="text-center font-weight-bold text-secondary">{{ $b->tahun_terbit }}</td>
                                    <td class="text-center">
                                        @if($b->stok > 0)
                                            <span class="badge badge-success px-2 py-1 font-weight-bold">{{ $b->stok }} Eks</span>
                                        @else
                                            <span class="badge badge-danger px-2 py-1 font-weight-bold">Habis</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-warning px-2 py-1 font-weight-bold">{{ $b->dipinjam }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-secondary px-2 py-1 font-weight-bold">{{ $b->dibooking }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.master.buku.show', $b->id) }}" class="btn btn-sm btn-outline-info p-1 px-2" title="Detail Informasi" data-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.master.buku.edit', $b->id) }}" class="btn btn-sm btn-outline-warning p-1 px-2" title="Edit Buku" data-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.master.buku.destroy', $b->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2" title="Hapus Koleksi" data-toggle="tooltip" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-5">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px; background: #eff6ff;">
                                            <i class="fas fa-book-open fa-2x text-primary"></i>
                                        </div>
                                        <h6 class="font-weight-bold text-dark">Tidak Ada Koleksi Buku yang Sesuai</h6>
                                        <p class="small text-muted mb-3">Coba gunakan kata kunci pencarian yang lain atau reset filter kategori.</p>
                                        <a href="{{ route('admin.master.buku.index') }}" class="btn btn-sm btn-outline-primary font-weight-bold px-3">
                                            <i class="fas fa-sync mr-1"></i> Tampilkan Seluruh Koleksi
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 border-top d-flex flex-column flex-sm-row justify-content-between align-items-center">
                        <small class="text-muted mb-2 mb-sm-0">
                            Menampilkan <strong>{{ $buku->firstItem() ?? 0 }}</strong> - <strong>{{ $buku->lastItem() ?? 0 }}</strong> dari <strong>{{ $buku->total() }}</strong> buku
                        </small>
                        <div>
                            {{ $buku->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
