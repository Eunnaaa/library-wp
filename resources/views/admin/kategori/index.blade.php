@extends('admin.layout.main')

@section('title', 'Kategori Buku')

@section('content')
<div class="container-fluid">
    <!-- KPI Summary Row -->
    <div class="row mb-3">
        <div class="col-sm-6 col-lg-3 mb-2">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #2563eb !important;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 44px; height: 44px; background: #eff6ff; color: #2563eb;">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div>
                        <small class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.7rem;">Total Kategori</small>
                        <h4 class="font-weight-bold text-dark mb-0">{{ $kategori->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-2">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-left: 4px solid #10b981 !important;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 44px; height: 44px; background: #d1fae5; color: #059669;">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <small class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.7rem;">Koleksi Terkategori</small>
                        <h4 class="font-weight-bold text-dark mb-0">{{ $kategori->sum('buku_count') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-sm-row justify-content-between align-items-sm-center w-100">
                    <div class="mb-2 mb-sm-0">
                        <h5 class="font-weight-bold mb-0 text-dark">
                            <i class="fas fa-tags mr-2 text-primary"></i> Data Master Kategori Buku
                        </h5>
                    </div>
                    <div class="d-flex align-items-center ml-sm-auto">
                        <div class="input-group input-group-sm mr-2" style="max-width: 220px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-search text-muted"></i></span>
                            </div>
                            <input type="text" id="filter-kategori" class="form-control border-left-0" placeholder="Cari kategori...">
                        </div>
                        <button type="button" class="btn btn-primary btn-sm font-weight-bold shadow-sm px-3 py-2 flex-shrink-0" data-toggle="modal" data-target="#modalTambah" style="border-radius: 8px;">
                            <i class="fas fa-plus mr-1"></i> Tambah Kategori
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="tabel-kategori">
                            <thead>
                                <tr class="bg-light text-center">
                                    <th style="width: 60px;">#</th>
                                    <th class="text-left">Nama Kategori</th>
                                    <th style="width: 180px;">Jumlah Koleksi Buku</th>
                                    <th style="width: 160px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kategori as $k)
                                <tr>
                                    <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center mr-2 bg-light text-primary" style="width: 32px; height: 32px;">
                                                <i class="fas fa-tag"></i>
                                            </div>
                                            <strong class="text-dark">{{ $k->nama_kategori }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="badge badge-info font-weight-bold">{{ $k->buku_count ?? 0 }} Judul Buku</span></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-warning btn-edit p-1 px-2"
                                            data-id="{{ $k->id }}" data-nama="{{ $k->nama_kategori }}" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.master.kategori.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2" title="Hapus"><i class="fas fa-trash"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <i class="fas fa-tags fa-3x text-muted mb-2 d-block"></i>
                                        Belum ada data kategori buku.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <form action="{{ route('admin.master.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-white py-3 border-bottom">
                    <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-plus-circle text-primary mr-2"></i> Tambah Kategori Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="form-group mb-0">
                        <label for="nama_kategori" class="font-weight-bold text-muted small text-uppercase">Nama Kategori <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white"><i class="fas fa-tag text-muted"></i></span>
                            </div>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Contoh: Pemrograman Web" required>
                        </div>
                        <small class="text-muted mt-1 d-block">Masukkan nama klasifikasi buku perpustakaan.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-3 px-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm"><i class="fas fa-save mr-1"></i> Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-white py-3 border-bottom">
                    <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-edit text-warning mr-2"></i> Edit Kategori Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <div class="form-group mb-0">
                        <label for="edit_nama_kategori" class="font-weight-bold text-muted small text-uppercase">Nama Kategori <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white"><i class="fas fa-tag text-muted"></i></span>
                            </div>
                            <input type="text" class="form-control" id="edit_nama_kategori" name="nama_kategori" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top py-3 px-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning px-4 font-weight-bold shadow-sm" style="color: #78350f;"><i class="fas fa-save mr-1"></i> Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        var nama = $(this).data('nama');

        $('#edit_nama_kategori').val(nama);
        $('#formEdit').attr('action', '{{ url("admin/master/kategori") }}/' + id);
        $('#modalEdit').modal('show');
    });

    $('#filter-kategori').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#tabel-kategori tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
</script>
@endpush
@endsection
