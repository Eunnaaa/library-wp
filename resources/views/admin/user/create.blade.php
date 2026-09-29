@extends('admin.layout.main')

@section('title', 'Tambah User')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-xl overflow-hidden mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-3 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-user-plus text-primary mr-2"></i>Tambah Pengguna Baru
                        </h4>
                        <p class="text-muted small mb-0">Daftarkan akun administrator atau anggota perpustakaan baru</p>
                    </div>
                </div>

                <form action="{{ route('admin.master.user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body px-4 pt-3">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="nama" class="font-weight-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0"><i class="fas fa-user text-muted"></i></span>
                                    </div>
                                    <input type="text" class="form-control border-left-0 @error('nama') is-invalid @enderror" id="nama" name="nama"
                                        value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
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
                                        value="{{ old('email') }}" placeholder="contoh: user@mail.com" required>
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
                                    placeholder="Masukkan alamat domisili lengkap" required>{{ old('alamat') }}</textarea>
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
                                        <option value="2" {{ old('role_id') == '2' ? 'selected' : '' }}>Anggota / Member</option>
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
                                <input type="password" class="form-control border-left-0 @error('password') is-invalid @enderror" id="password" name="password"
                                    placeholder="Minimal 6 karakter" required>
                            </div>
                            @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="image" class="font-weight-semibold text-dark">Foto Profil (Opsional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                <label class="custom-file-label" for="image">Pilih file foto...</label>
                            </div>
                            <small class="form-text text-muted">Format yang didukung: JPG, PNG. Maksimal 2MB.</small>
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="card-footer bg-light px-4 py-3 border-0 d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.master.user.index') }}" class="btn btn-outline-secondary font-weight-semibold">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm">
                            <i class="fas fa-save mr-1"></i> Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
