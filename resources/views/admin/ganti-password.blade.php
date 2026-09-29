@extends('admin.layout.main')

@section('title', 'Ganti Password')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card border-0 shadow-sm rounded-xl overflow-hidden mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="font-weight-bold text-dark mb-1">
                            <i class="fas fa-shield-alt text-warning mr-2"></i>Ganti Password Administrator
                        </h4>
                        <p class="text-muted small mb-0">Tingkatkan keamanan akun Anda secara berkala</p>
                    </div>
                </div>

                <form action="{{ route('admin.ganti-password') }}" method="POST">
                    @csrf
                    <div class="card-body px-4 pt-3">
                        <div class="alert alert-warning border-0 rounded-lg shadow-sm mb-4 small" style="background-color: #fefce8; color: #854d0e; border-left: 4px solid #f59e0b !important;">
                            <i class="fas fa-info-circle mr-1"></i>
                            Gunakan kombinasi password yang kuat dengan minimal 6 karakter, mengandung huruf besar, huruf kecil, dan angka.
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_sekarang" class="font-weight-semibold text-dark">Password Saat Ini <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-key text-muted"></i></span>
                                </div>
                                <input type="password" class="form-control border-left-0 @error('password_sekarang') is-invalid @enderror"
                                    id="password_sekarang" name="password_sekarang" placeholder="Masukkan password yang saat ini aktif" required>
                            </div>
                            @error('password_sekarang')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_baru" class="font-weight-semibold text-dark">Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-lock text-muted"></i></span>
                                </div>
                                <input type="password" class="form-control border-left-0 @error('password_baru') is-invalid @enderror"
                                    id="password_baru" name="password_baru" placeholder="Minimal 6 karakter" required>
                            </div>
                            @error('password_baru')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="konfirmasi_password" class="font-weight-semibold text-dark">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fas fa-lock-open text-muted"></i></span>
                                </div>
                                <input type="password" class="form-control border-left-0 @error('konfirmasi_password') is-invalid @enderror"
                                    id="konfirmasi_password" name="konfirmasi_password" placeholder="Ketik ulang password baru Anda" required>
                            </div>
                            @error('konfirmasi_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer bg-light px-4 py-3 border-0 d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.profil') }}" class="btn btn-outline-secondary font-weight-semibold">
                            <i class="fas fa-arrow-left mr-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-warning px-4 py-2 font-weight-bold text-dark shadow-sm" style="border-radius: 8px;">
                            <i class="fas fa-save mr-1"></i> Perbarui Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
