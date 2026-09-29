@extends('admin.layout.main')

@section('title', 'Kategori Buku')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center w-100">
                    <h5 class="font-weight-bold mb-0 text-dark">
                        <i class="fas fa-tags mr-2 text-primary"></i> Data Master Kategori Buku
                    </h5>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-primary btn-sm font-weight-bold shadow-sm px-3 py-2" data-toggle="modal" data-target="#modalTambah" style="border-radius: 8px;">
                            <i class="fas fa-plus mr-1"></i> Tambah Kategori Baru
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
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
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.master.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus-circle mr-1"></i> Tambah Kategori Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Contoh: Pemrograman Web" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit mr-1"></i> Edit Kategori Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_kategori" name="nama_kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Perbarui</button>
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
</script>
@endpush
@endsection
