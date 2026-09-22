@extends('member.layout.main')

@section('title', 'Ganti Password')

@section('content')
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title font-weight-bold mb-0"><i class="fas fa-lock mr-2 text-warning"></i> Form Ganti Password</h5>
                </div>
                <form action="{{ url('member/ganti-password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="password_sekarang">Password Saat Ini <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password_sekarang') is-invalid @enderror"
                                id="password_sekarang" name="password_sekarang" placeholder="Masukkan password lama Anda" required>
                            @error('password_sekarang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_baru">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password_baru') is-invalid @enderror"
                                id="password_baru" name="password_baru" placeholder="Minimal 6 karakter" required>
                            @error('password_baru') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="konfirmasi_password">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('konfirmasi_password') is-invalid @enderror"
                                id="konfirmasi_password" name="konfirmasi_password" placeholder="Ulangi password baru" required>
                            @error('konfirmasi_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="card-footer bg-light text-right">
                        <button type="submit" class="btn btn-warning font-weight-bold"><i class="fas fa-key mr-1"></i> Perbarui Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
