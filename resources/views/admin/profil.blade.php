@extends('admin.layout.main')

@section('title', 'Profil Administrator')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Profile Summary Card -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm rounded-xl overflow-hidden text-center p-4" style="border: 1px solid #e8e2d4 !important;">
                <div class="position-relative d-inline-block mx-auto mb-3">
                    <img id="adminAvatarPreview"
                        class="rounded-circle shadow-sm"
                        src="{{ asset('storage/' . ($user->image ?? 'profil-pic/default.jpg')) }}"
                        alt="Foto Profil {{ $user->nama }}"
                        style="width: 130px; height: 130px; object-fit: cover; border: 4px solid #d4af37 !important;"
                        onerror="this.onerror=null; this.src='{{ asset('assets/dist/img/default-150x150.png') }}';">
                    <span class="badge badge-success position-absolute" style="bottom: 5px; right: 5px; border-radius: 50%; padding: 6px; border: 2px solid white;">
                        <i class="fas fa-check" style="font-size: 10px;"></i>
                    </span>
                </div>

                <h4 class="font-weight-bold text-dark mb-1">{{ $user->nama }}</h4>
                <p class="text-muted small mb-3">{{ $user->email }}</p>

                <div class="mb-4">
                    <span class="badge badge-primary px-3 py-2 font-weight-bold" style="border-radius: 6px; font-size: 0.8rem;">
                        <i class="fas fa-shield-alt mr-1"></i>Administrator E-Library
                    </span>
                </div>

                <div class="pt-3 text-left" style="border-top: 1px solid #e8e2d4 !important;">
                    <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid #e8e2d4 !important;">
                        <span class="text-muted small"><i class="fas fa-toggle-on text-success mr-2"></i>Status Akun</span>
                        <span class="badge badge-success px-2 py-1">Aktif</span>
                    </div>
                    <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid #e8e2d4 !important;">
                        <span class="text-muted small"><i class="fas fa-calendar-alt text-primary mr-2"></i>Terdaftar Sejak</span>
                        <strong class="small text-dark">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted small"><i class="fas fa-lock text-warning mr-2"></i>Keamanan</span>
                        <a href="{{ route('admin.ganti-password') }}" class="small text-primary font-weight-bold">
                            Ganti Password &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm rounded-xl overflow-hidden mb-4" style="border: 1px solid #e8e2d4 !important;">
                <div class="card-header bg-white pt-4 pb-3 px-4" style="border-bottom: 1px solid #e8e2d4 !important;">
                    <h4 class="font-weight-bold text-dark mb-1">
                        <i class="fas fa-user-edit text-primary mr-2"></i>Perbarui Profil Administrator
                    </h4>
                    <p class="text-muted small mb-0">Ubah informasi biodata akun dan unggah foto profil terbaru</p>
                </div>

                <form action="{{ url('admin/profil') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body px-4 pt-3">
                        <div class="form-group mb-3">
                            <label for="email" class="font-weight-semibold text-dark">Alamat Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0" style="border-color: #e8e2d4;"><i class="fas fa-envelope text-muted"></i></span>
                                </div>
                                <input type="email" class="form-control border-left-0 bg-light" id="email" value="{{ $user->email }}" readonly style="border-color: #e8e2d4;">
                            </div>
                            <small class="form-text text-muted">Email administrator terikat secara permanen dan tidak dapat diubah.</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama" class="font-weight-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0" style="border-color: #e8e2d4;"><i class="fas fa-user text-muted"></i></span>
                                </div>
                                <input type="text" class="form-control border-left-0 @error('nama') is-invalid @enderror" id="nama" name="nama"
                                    value="{{ old('nama', $user->nama) }}" required placeholder="Nama lengkap" style="border-color: #e8e2d4;">
                            </div>
                            @error('nama')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat" class="font-weight-semibold text-dark">Alamat Domisili <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0" style="border-color: #e8e2d4;"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                </div>
                                <textarea class="form-control border-left-0 @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required placeholder="Alamat kantor / tempat tinggal" style="border-color: #e8e2d4;">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>
                            @error('alamat')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="image" class="font-weight-semibold text-dark">Ganti Foto Profil</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewAdminAvatar(this)">
                                <label class="custom-file-label text-truncate" for="image" style="border-color: #e8e2d4;">Pilih berkas foto...</label>
                            </div>
                            <small class="form-text text-muted">Mendukung format JPG atau PNG (Maksimal 1MB). Kosongkan jika tetap menggunakan foto saat ini.</small>
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer px-4 py-3 d-flex justify-content-end" style="background: #fdfbf7; border-top: 1px solid #e8e2d4 !important;">
                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold shadow-sm" style="border-radius: 8px;">
                            <i class="fas fa-save mr-2"></i>Simpan Perbarui Profil
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
function previewAdminAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('adminAvatarPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
