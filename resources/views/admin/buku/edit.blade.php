@extends('admin.layout.main')

@section('title', 'Edit Buku')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-xl overflow-hidden mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-3 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-edit text-warning mr-2"></i>Edit Informasi Buku
                        </h4>
                        <p class="text-muted small mb-0">Perbarui rincian katalog buku pustaka: <strong>{{ $buku->judul_buku }}</strong></p>
                    </div>
                    <span class="badge badge-warning px-3 py-2 text-dark font-weight-bold" style="border-radius: 8px;">
                        ID: #{{ $buku->id }}
                    </span>
                </div>

                <form action="{{ route('admin.master.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body px-4 pt-3">
                        <div class="row">
                            <!-- Left Column: Book Details -->
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="judul_buku" class="font-weight-semibold text-dark">Judul Buku <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0"><i class="fas fa-book text-muted"></i></span>
                                        </div>
                                        <input type="text" class="form-control border-left-0 @error('judul_buku') is-invalid @enderror" id="judul_buku" name="judul_buku"
                                            value="{{ old('judul_buku', $buku->judul_buku) }}" required placeholder="Masukkan judul buku lengkap">
                                    </div>
                                    @error('judul_buku') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="id_kategori" class="font-weight-semibold text-dark">Kategori Buku <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-folder text-muted"></i></span>
                                            </div>
                                            <select class="form-control select2 border-left-0 @error('id_kategori') is-invalid @enderror" id="id_kategori" name="id_kategori" required>
                                                @foreach($kategori as $k)
                                                    <option value="{{ $k->id }}" {{ old('id_kategori', $buku->id_kategori) == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
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
                                            <input type="text" class="form-control border-left-0 @error('isbn') is-invalid @enderror" id="isbn" name="isbn"
                                                value="{{ old('isbn', $buku->isbn) }}" required placeholder="Contoh: 978-602-xxx">
                                        </div>
                                        @error('isbn') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="pengarang" class="font-weight-semibold text-dark">Pengarang <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-pen-nib text-muted"></i></span>
                                            </div>
                                            <input type="text" class="form-control border-left-0 @error('pengarang') is-invalid @enderror" id="pengarang" name="pengarang"
                                                value="{{ old('pengarang', $buku->pengarang) }}" required placeholder="Nama penulis / pengarang">
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
                                                value="{{ old('penerbit', $buku->penerbit) }}" required placeholder="Nama penerbit buku">
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
                                                value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required min="1900" max="{{ date('Y') + 1 }}">
                                        </div>
                                        @error('tahun_terbit') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="stok" class="font-weight-semibold text-dark">Stok Tersedia <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-boxes text-muted"></i></span>
                                            </div>
                                            <input type="number" class="form-control border-left-0 @error('stok') is-invalid @enderror" id="stok" name="stok"
                                                value="{{ old('stok', $buku->stok) }}" min="0" required>
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
                                <label class="font-weight-semibold text-dark d-block">Cover Buku Saat Ini</label>
                                <div class="book-showcase-stage mb-3 flex-column" style="min-height: 230px; padding: 18px 15px;">
                                    <div class="book-cover-3d mb-2" style="max-height: 190px;">
                                        <img id="coverPreview"
                                            src="{{ asset('storage/' . ($buku->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                            alt="Cover {{ $buku->judul_buku }}"
                                            onerror="this.onerror=null; this.src='{{ asset('storage/cover-buku/book-default-cover.jpg') }}';">
                                    </div>
                                    <div class="small text-muted font-weight-semibold" id="previewLabel">
                                        <i class="fas fa-image mr-1"></i>Cover saat ini
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label for="image" class="font-weight-semibold text-dark small">Ganti File Cover</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewBookCover(this)">
                                        <label class="custom-file-label text-truncate" for="image">Pilih gambar baru...</label>
                                    </div>
                                    <small class="form-text text-muted">Kosongkan jika cover tidak diubah. Maks. 1MB (JPG/PNG).</small>
                                    @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light px-4 py-3 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.master.buku.index') }}" class="btn btn-outline-secondary font-weight-semibold" style="border-radius: 8px;">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                        </a>
                        <button type="submit" class="btn btn-warning px-4 font-weight-bold text-dark shadow-sm" style="border-radius: 8px;">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
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
            document.getElementById('coverPreview').src = e.target.result;
            document.getElementById('previewLabel').innerHTML = '<span class="text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i>Cover Baru Dipilih</span>';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
