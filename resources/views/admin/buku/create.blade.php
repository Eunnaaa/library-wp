@extends('admin.layout.main')

@section('title', 'Tambah Buku Baru')

@section('content')
<div class="container-fluid pb-4">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-11">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title font-weight-bold mb-0 text-dark">
                        <i class="fas fa-book-medical mr-2 text-primary"></i> Form Tambah Koleksi Buku Baru
                    </h5>
                    <a href="{{ route('admin.master.buku.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold" style="border-radius: 8px;">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </a>
                </div>

                <form action="{{ route('admin.master.buku.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-8 form-group mb-3">
                                <label for="judul_buku" class="font-weight-bold text-muted small text-uppercase">Judul Lengkap Buku <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('judul_buku') is-invalid @enderror" id="judul_buku" name="judul_buku"
                                    value="{{ old('judul_buku') }}" placeholder="Contoh: Pemrograman Web dengan Laravel 11" required>
                                @error('judul_buku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="id_kategori" class="font-weight-bold text-muted small text-uppercase">Kategori Koleksi <span class="text-danger">*</span></label>
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
                            <div class="col-md-6 form-group mb-3">
                                <label for="pengarang" class="font-weight-bold text-muted small text-uppercase">Nama Pengarang / Penulis <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white"><i class="fas fa-user-edit text-muted"></i></span>
                                    </div>
                                    <input type="text" class="form-control @error('pengarang') is-invalid @enderror" id="pengarang" name="pengarang"
                                        value="{{ old('pengarang') }}" placeholder="Nama pengarang buku" required>
                                </div>
                                @error('pengarang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="penerbit" class="font-weight-bold text-muted small text-uppercase">Penerbit <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white"><i class="fas fa-building text-muted"></i></span>
                                    </div>
                                    <input type="text" class="form-control @error('penerbit') is-invalid @enderror" id="penerbit" name="penerbit"
                                        value="{{ old('penerbit') }}" placeholder="Nama penerbit buku" required>
                                </div>
                                @error('penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="tahun_terbit" class="font-weight-bold text-muted small text-uppercase">Tahun Terbit <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('tahun_terbit') is-invalid @enderror" id="tahun_terbit" name="tahun_terbit"
                                    value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                                @error('tahun_terbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="isbn" class="font-weight-bold text-muted small text-uppercase">Nomor ISBN <span class="text-danger">*</span></label>
                                <input type="text" class="form-control font-monospace @error('isbn') is-invalid @enderror" id="isbn" name="isbn"
                                    value="{{ old('isbn') }}" placeholder="Contoh: 978-602-xxxx-xx-x" required>
                                @error('isbn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="stok" class="font-weight-bold text-muted small text-uppercase">Stok Fisik Tersedia <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok"
                                    value="{{ old('stok', 1) }}" min="0" required>
                                @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label for="image" class="font-weight-bold text-muted small text-uppercase">Gambar Sampul / Cover Buku (Opsional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                <label class="custom-file-label" for="image">Pilih berkas cover...</label>
                            </div>
                            <small class="text-muted d-block mt-1">Format gambar diperbolehkan: JPG, JPEG, PNG (Ukuran maksimal 1MB).</small>
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="card-footer bg-light border-top d-flex justify-content-between align-items-center py-3 px-4">
                        <a href="{{ route('admin.master.buku.index') }}" class="btn btn-outline-secondary font-weight-bold" style="border-radius: 8px;">
                            <i class="fas fa-times mr-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm" style="border-radius: 8px;">
                            <i class="fas fa-save mr-1"></i> Simpan Buku Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

