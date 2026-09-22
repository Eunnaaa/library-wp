@extends('admin.layout.main')

@section('title', 'Tambah Buku')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-book-medical mr-1"></i> Form Tambah Buku Baru</h3>
                </div>
                <form action="{{ route('admin.master.buku.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label for="judul_buku">Judul Buku <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('judul_buku') is-invalid @enderror" id="judul_buku" name="judul_buku"
                                    value="{{ old('judul_buku') }}" placeholder="Masukkan judul buku" required>
                                @error('judul_buku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="id_kategori">Kategori Buku <span class="text-danger">*</span></label>
                                <select class="form-control select2 @error('id_kategori') is-invalid @enderror" id="id_kategori" name="id_kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id }}" {{ old('id_kategori') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('id_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="pengarang">Pengarang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('pengarang') is-invalid @enderror" id="pengarang" name="pengarang"
                                    value="{{ old('pengarang') }}" placeholder="Nama pengarang" required>
                                @error('pengarang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="penerbit">Penerbit <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('penerbit') is-invalid @enderror" id="penerbit" name="penerbit"
                                    value="{{ old('penerbit') }}" placeholder="Nama penerbit" required>
                                @error('penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="tahun_terbit">Tahun Terbit <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('tahun_terbit') is-invalid @enderror" id="tahun_terbit" name="tahun_terbit"
                                    value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                                @error('tahun_terbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="isbn">Nomor ISBN <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn"
                                    value="{{ old('isbn') }}" placeholder="Contoh: 978-602-xxxx-xx-x" required>
                                @error('isbn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="stok">Stok Buku (Eksemplar) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok"
                                    value="{{ old('stok', 1) }}" min="0" required>
                                @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image">Cover Buku (Opsional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                <label class="custom-file-label" for="image">Pilih file gambar cover...</label>
                            </div>
                            <small class="text-muted">Format: jpg, jpeg, png (Maks. 1MB).</small>
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('admin.master.buku.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan Buku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
