@extends('admin.layout.main')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="container-fluid pb-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-xl overflow-hidden mb-4" style="border-radius: 14px;">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="font-weight-bold mb-0 text-dark">
                            <i class="fas fa-user-plus text-primary mr-2"></i> Tambah Pengguna Baru
                        </h5>
                        <p class="text-muted small mb-0">Daftarkan akun administrator sistem atau anggota civitas perpustakaan UNM</p>
                    </div>
                    <a href="{{ route('admin.master.user.index') }}" class="btn btn-outline-secondary btn-sm font-weight-semibold" style="border-radius: 8px;">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </a>
                </div>

                <form action="{{ route('admin.master.user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body px-4 pt-4">
                        <div class="row">
                            <!-- Left: Form Fields -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="nama" class="font-weight-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-user text-muted"></i></span>
                                            </div>
                                            <input type="text" class="form-control border-left-0 @error('nama') is-invalid @enderror" id="nama" name="nama"
                                                value="{{ old('nama') }}" placeholder="Contoh: Ahmad Faisal" required autofocus>
                                        </div>
                                        @error('nama') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="email" class="font-weight-semibold text-dark">Alamat Email <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-envelope text-muted"></i></span>
                                            </div>
                                            <input type="email" class="form-control border-left-0 @error('email') is-invalid @enderror" id="email" name="email"
                                                value="{{ old('email') }}" placeholder="contoh: user@nusamandiri.ac.id" required>
                                        </div>
                                        @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="alamat" class="font-weight-semibold text-dark">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                        </div>
                                        <textarea class="form-control border-left-0 @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2"
                                            placeholder="Alamat domisili lengkap..." required>{{ old('alamat') }}</textarea>
                                    </div>
                                    @error('alamat') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="role_id" class="font-weight-semibold text-dark">Peran / Role <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-user-tag text-muted"></i></span>
                                            </div>
                                            <select class="form-control border-left-0 @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                                                <option value="2" {{ old('role_id', '2') == '2' ? 'selected' : '' }}>Anggota / Member</option>
                                                <option value="1" {{ old('role_id') == '1' ? 'selected' : '' }}>Administrator</option>
                                            </select>
                                        </div>
                                        @error('role_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="is_active" class="font-weight-semibold text-dark">Status Akun <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-toggle-on text-muted"></i></span>
                                            </div>
                                            <select class="form-control border-left-0 @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                        @error('is_active') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password" class="font-weight-semibold text-dark">Password Akun <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0"><i class="fas fa-lock text-muted"></i></span>
                                        </div>
                                        <input type="password" class="form-control border-left-0 border-right-0 @error('password') is-invalid @enderror" id="password" name="password"
                                            placeholder="Minimal 6 karakter" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary border border-left-0 bg-light text-muted px-2" type="button" onclick="toggleUserPassword('password', this)" title="Lihat password" style="border-color: #cbd5e1 !important;">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Right: Avatar Preview & Upload -->
                            <div class="col-md-4">
                                <label class="font-weight-semibold text-dark d-block">Pratinjau Foto Profil</label>
                                <div class="text-center p-3 bg-light rounded-xl border mb-3" style="border-radius: 12px;">
                                    <img id="avatarPreview"
                                        src="{{ asset('storage/profil-pic/default.jpg') }}"
                                        alt="Avatar Default"
                                        class="rounded-circle shadow-sm border border-white"
                                        style="width: 120px; height: 120px; object-fit: cover; border-width: 4px !important;"
                                        onerror="this.onerror=null; this.src='{{ asset('assets/dist/img/default-150x150.png') }}';">
                                    <div class="small text-muted mt-2" id="avatarLabel">
                                        <i class="fas fa-image mr-1"></i>Foto Default
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label for="image" class="font-weight-semibold text-dark small">Pilih Berkas Foto</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewUserAvatar(this)">
                                        <label class="custom-file-label text-truncate" for="image">Pilih file foto...</label>
                                    </div>
                                    <small class="form-text text-muted">Format: JPG, PNG. Maksimal 1MB.</small>
                                    @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light px-4 py-3 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.master.user.index') }}" class="btn btn-outline-secondary font-weight-semibold" style="border-radius: 8px;">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm" style="border-radius: 8px;">
                            <i class="fas fa-save mr-1"></i> Simpan Pengguna
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
    function previewUserAvatar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#avatarPreview').attr('src', e.target.result);
                $('#avatarLabel').html('<span class="text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i>Foto Baru Dipilih</span>');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function toggleUserPassword(inputId, btn) {
        var input = document.getElementById(inputId);
        var icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
