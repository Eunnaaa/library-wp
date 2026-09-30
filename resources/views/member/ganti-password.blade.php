@extends('member.layout.main')

@section('title', 'Ganti Password Akun')

@section('content')
<div class="container pt-4 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-2 bg-warning-light" style="width: 36px; height: 36px; background: #fef3c7;">
                        <i class="fas fa-lock text-warning"></i>
                    </div>
                    <div>
                        <h5 class="card-title font-weight-bold mb-0 text-dark">Pengaturan Keamanan Password</h5>
                        <small class="text-muted d-block">Perbarui kata sandi akun Anda secara berkala demi keamanan.</small>
                    </div>
                </div>

                <form action="{{ url('member/ganti-password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body p-4">
                        <div class="alert alert-light border small mb-4 text-secondary rounded-lg">
                            <i class="fas fa-shield-alt text-primary mr-1"></i> Gunakan minimal 6 karakter dengan kombinasi huruf dan angka agar kata sandi kuat.
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_sekarang" class="font-weight-bold text-muted small text-uppercase">Password Saat Ini <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fas fa-key text-muted"></i></span>
                                </div>
                                <input type="password" class="form-control border-right-0 @error('password_sekarang') is-invalid @enderror"
                                    id="password_sekarang" name="password_sekarang" placeholder="Masukkan password lama Anda" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary border border-left-0 bg-white text-muted px-2" type="button" onclick="togglePassword('password_sekarang', this)" title="Lihat password" style="border-color: #cbd5e1 !important;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password_sekarang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_baru" class="font-weight-bold text-muted small text-uppercase">Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fas fa-lock text-primary"></i></span>
                                </div>
                                <input type="password" class="form-control border-right-0 @error('password_baru') is-invalid @enderror"
                                    id="password_baru" name="password_baru" placeholder="Minimal 6 karakter" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary border border-left-0 bg-white text-muted px-2" type="button" onclick="togglePassword('password_baru', this)" title="Lihat password" style="border-color: #cbd5e1 !important;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password_baru') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label for="konfirmasi_password" class="font-weight-bold text-muted small text-uppercase">Ulangi Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fas fa-check-double text-success"></i></span>
                                </div>
                                <input type="password" class="form-control border-right-0 @error('konfirmasi_password') is-invalid @enderror"
                                    id="konfirmasi_password" name="konfirmasi_password" placeholder="Ulangi password baru yang sama" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary border border-left-0 bg-white text-muted px-2" type="button" onclick="togglePassword('konfirmasi_password', this)" title="Lihat password" style="border-color: #cbd5e1 !important;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('konfirmasi_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-top text-right py-3 px-4 d-flex justify-content-between align-items-center">
                        <a href="{{ route('member.profil') }}" class="btn btn-outline-secondary btn-sm font-weight-bold" style="border-radius: 8px;">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Profil
                        </a>
                        <button type="submit" class="btn btn-warning px-4 font-weight-bold shadow-sm" style="border-radius: 8px; color: #78350f;">
                            <i class="fas fa-save mr-1"></i> Perbarui Password
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
    function togglePassword(inputId, btn) {
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

