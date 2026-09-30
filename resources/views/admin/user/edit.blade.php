@extends('admin.layout.main')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-xl overflow-hidden mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-3 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-user-edit text-warning mr-2"></i>Edit Informasi Pengguna
                        </h4>
                        <p class="text-muted small mb-0">Perbarui profil dan status akun: <strong>{{ $user->nama }}</strong></p>
                    </div>
                    <span class="badge badge-secondary px-3 py-2 font-weight-bold" style="border-radius: 8px;">
                        ID: #{{ $user->id }}
                    </span>
                </div>

                <form action="{{ route('admin.master.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body px-4 pt-3">
                        <div class="row">
                            <!-- Left Column: Form Fields -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="nama" class="font-weight-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0"><i class="fas fa-user text-muted"></i></span>
                                            </div>
                                            <input type="text" class="form-control border-left-0 @error('nama') is-invalid @enderror" id="nama" name="nama"
                                                value="{{ old('nama', $user->nama) }}" required>
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
                                                value="{{ old('email', $user->email) }}" required>
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
                                        <textarea class="form-control border-left-0 @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2" required>{{ old('alamat', $user->alamat) }}</textarea>
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
                                                <option value="2" {{ old('role_id', $user->role_id) == 2 ? 'selected' : '' }}>Anggota / Member</option>
                                                <option value="1" {{ old('role_id', $user->role_id) == 1 ? 'selected' : '' }}>Administrator</option>
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
                                                <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                                <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                                            </select>
                                        </div>
                                        @error('is_active') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password" class="font-weight-semibold text-dark">Ganti Password (Opsional)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0"><i class="fas fa-lock text-muted"></i></span>
                                        </div>
                                        <input type="password" class="form-control border-left-0 border-right-0 @error('password') is-invalid @enderror" id="password" name="password"
                                            placeholder="Kosongkan bila tidak ingin mengubah password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary border border-left-0 bg-light text-muted px-2" type="button" onclick="toggleUserPassword('password', this)" title="Lihat password" style="border-color: #cbd5e1 !important;">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Right Column: Avatar Preview & Upload -->
                            <div class="col-md-4">
                                <label class="font-weight-semibold text-dark d-block text-center">Foto Profil</label>
                                <div class="text-center p-3 bg-light rounded-xl border mb-3" style="border-radius: 12px;">
                                    <img id="avatarPreview"
                                        src="{{ asset('storage/' . ($user->image ?? 'profil-pic/default.jpg')) }}"
                                        alt="Foto {{ $user->nama }}"
                                        class="rounded-circle shadow-sm border border-white"
                                        style="width: 120px; height: 120px; object-fit: cover; border-width: 4px !important;"
                                        onerror="this.onerror=null; this.src='{{ asset('assets/dist/img/default-150x150.png') }}';">
                                    <div class="small text-muted mt-2" id="avatarLabel">
                                        <i class="fas fa-user-circle mr-1"></i>Foto saat ini
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label for="image" class="font-weight-semibold text-dark small">Ganti Foto Profil</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewUserAvatar(this)">
                                        <label class="custom-file-label text-truncate" for="image">Pilih foto...</label>
                                    </div>
                                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin diubah.</small>
                                    @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light px-4 py-3 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.master.user.index') }}" class="btn btn-outline-secondary font-weight-semibold" style="border-radius: 8px;">
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
function previewUserAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
            document.getElementById('avatarLabel').innerHTML = '<span class="text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i>Foto Baru Dipilih</span>';
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
