@extends('admin.layout.main')

@section('title', 'Ganti Password')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-key mr-1"></i> Form Ganti Password</h3>
                </div>
                <form action="{{ route('admin.ganti-password') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="password_sekarang">Password Saat Ini</label>
                            <input type="password" class="form-control @error('password_sekarang') is-invalid @enderror"
                                id="password_sekarang" name="password_sekarang" placeholder="Masukkan password lama" required>
                            @error('password_sekarang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_baru">Password Baru</label>
                            <input type="password" class="form-control @error('password_baru') is-invalid @enderror"
                                id="password_baru" name="password_baru" placeholder="Minimal 6 karakter" required>
                            @error('password_baru')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control @error('konfirmasi_password') is-invalid @enderror"
                                id="konfirmasi_password" name="konfirmasi_password" placeholder="Ulangi password baru" required>
                            @error('konfirmasi_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer bg-light">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-lock mr-1"></i> Perbarui Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
