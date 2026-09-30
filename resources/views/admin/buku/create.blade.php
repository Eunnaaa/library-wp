@extends('admin.layout.main')

@section('title', 'Tambah Koleksi Buku Baru')

@section('content')
<div class="container-fluid pb-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-xl overflow-hidden mb-4" style="border-radius: 14px;">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="font-weight-bold mb-0 text-dark">
                            <i class="fas fa-book-medical mr-2 text-primary"></i> Form Tambah Koleksi Buku Baru
                        </h5>
                        <p class="text-muted small mb-0">Lengkapi data bibliografi buku dan unggah cover untuk katalog perpustakaan</p>
                    </div>
                    <a href="{{ route('admin.master.buku.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold" style="border-radius: 8px;">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </a>
                </div>

                <form action="{{ route('admin.master.buku.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body px-4 pt-4">
                        <div class="row">
                            <!-- Left Column: Book Details -->
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="judul_buku" class="font-weight-semibold text-dark">Judul Lengkap Buku <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0"><i class="fas fa-book text-muted"></i></span>
                                        </div>
                                        <input type="text" class="form-control border-left-0 @error('judul_buku') is-invalid @enderror" id="judul_buku" name="judul_buku"
                                            value="{{ old('judul_buku') }}" placeholder="Contoh: Pemrograman Web dengan Laravel 11" required autofocus>
                                    </div>
                                    @error('judul_buku') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="id_kategori" class="font-weight-semibold text-dark">Kategori Koleksi <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-folder text-muted"></i></span>
                                            </div>
                                            <select class="form-control select2 border-left-0 @error('id_kategori') is-invalid @enderror" id="id_kategori" name="id_kategori" required>
                                                <option value="">-- Pilih Kategori --</option>
                                                @foreach($kategori as $k)
                                                    <option value="{{ $k->id }}" {{ old('id_kategori') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('id_kategori') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="isbn" class="font-weight-semibold text-dark">Nomor ISBN <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-barcode text-muted"></i></span>
                                            </div>
                                            <input type="text" class="form-control border-left-0 font-monospace @error('isbn') is-invalid @enderror" id="isbn" name="isbn"
                                                value="{{ old('isbn') }}" placeholder="Contoh: 978-602-xxxx-xx-x" required>
                                        </div>
                                        @error('isbn') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="pengarang" class="font-weight-semibold text-dark">Nama Pengarang / Penulis <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-pen-nib text-muted"></i></span>
                                            </div>
                                            <input type="text" class="form-control border-left-0 @error('pengarang') is-invalid @enderror" id="pengarang" name="pengarang"
                                                value="{{ old('pengarang') }}" placeholder="Nama pengarang buku" required>
                                        </div>
                                        @error('pengarang') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="penerbit" class="font-weight-semibold text-dark">Penerbit <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-building text-muted"></i></span>
                                            </div>
                                            <input type="text" class="form-control border-left-0 @error('penerbit') is-invalid @enderror" id="penerbit" name="penerbit"
                                                value="{{ old('penerbit') }}" placeholder="Nama penerbit buku" required>
                                        </div>
                                        @error('penerbit') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="tahun_terbit" class="font-weight-semibold text-dark">Tahun Terbit <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-calendar-alt text-muted"></i></span>
                                            </div>
                                            <input type="number" class="form-control border-left-0 @error('tahun_terbit') is-invalid @enderror" id="tahun_terbit" name="tahun_terbit"
                                                value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                                        </div>
                                        @error('tahun_terbit') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="stok" class="font-weight-semibold text-dark">Stok Fisik Tersedia <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-boxes text-muted"></i></span>
                                            </div>
                                            <input type="number" class="form-control border-left-0 @error('stok') is-invalid @enderror" id="stok" name="stok"
                                                value="{{ old('stok', 1) }}" min="0" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-light">Eks.</span>
                                            </div>
                                        </div>
                                        @error('stok') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Cover Preview & Upload -->
                            <div class="col-md-4">
                                <label class="font-weight-semibold text-dark d-block">Pratinjau Cover Buku</label>
                                <div class="book-showcase-stage mb-3 flex-column" style="min-height: 230px; padding: 18px 15px;">
                                    <div class="book-cover-3d mb-2" style="max-height: 190px;">
                                        <img id="coverPreview"
                                            src="{{ asset('storage/cover-buku/book-default-cover.jpg') }}"
                                            alt="Cover Pratinjau"
                                            onerror="this.onerror=null; this.src='{{ asset('storage/cover-buku/book-default-cover.jpg') }}';">
                                    </div>
                                    <div class="small text-muted font-weight-semibold" id="previewLabel">
                                        <i class="fas fa-image mr-1"></i>Cover Default Perpustakaan
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label for="image" class="font-weight-semibold text-dark small">Pilih Berkas Cover (Opsional)</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewBookCover(this)">
                                        <label class="custom-file-label text-truncate" for="image">Pilih berkas cover...</label>
                                    </div>
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG (Maksimal 1MB).</small>
                                    @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light px-4 py-3 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.master.buku.index') }}" class="btn btn-outline-secondary font-weight-semibold" style="border-radius: 8px;">
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

@push('scripts')
<script>
    function previewBookCover(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#coverPreview').attr('src', e.target.result);
                $('#previewLabel').html('<span class="text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i>Cover Baru Dipilih</span>');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
