<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>E-Library UNM | Registrasi Anggota</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #2563eb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }
        .register-card {
            width: 100%;
            max-width: 480px;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }
        .brand-badge {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #2563eb, #38bdf8);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px auto;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }
        .form-control {
            border-radius: 10px;
            height: 46px;
            font-size: 0.95rem;
            border: 1px solid #cbd5e1;
        }
        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .input-group-text {
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            color: #64748b;
        }
        .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
            height: 46px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.25);
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
    </style>
</head>

<body>
    <div class="register-card p-4 p-sm-5">
        <div class="text-center mb-4">
            <div class="brand-badge">
                <i class="fas fa-user-plus text-white fa-lg"></i>
            </div>
            <h4 class="font-weight-bold text-dark mb-1">Daftar Akun Anggota Baru</h4>
            <p class="text-muted small mb-0">Perpustakaan Universitas Nusa Mandiri</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group mb-3">
                <label for="nama" class="small font-weight-bold text-muted text-uppercase">Nama Lengkap</label>
                <div class="input-group">
                    <input type="text" class="form-control border-right-0 @error('nama') is-invalid @enderror"
                        placeholder="Contoh: Budi Santoso" name="nama" value="{{ old('nama') }}" required autofocus>
                    <div class="input-group-append">
                        <span class="input-group-text border-left-0"><i class="fas fa-user"></i></span>
                    </div>
                </div>
                @error('nama')
                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="email" class="small font-weight-bold text-muted text-uppercase">Alamat Email</label>
                <div class="input-group">
                    <input type="email" class="form-control border-right-0 @error('email') is-invalid @enderror"
                        placeholder="nama@email.com" name="email" value="{{ old('email') }}" required>
                    <div class="input-group-append">
                        <span class="input-group-text border-left-0"><i class="fas fa-envelope"></i></span>
                    </div>
                </div>
                @error('email')
                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="alamat" class="small font-weight-bold text-muted text-uppercase">Alamat Domisili</label>
                <div class="input-group">
                    <textarea class="form-control border-right-0 @error('alamat') is-invalid @enderror"
                        placeholder="Alamat lengkap tempat tinggal" name="alamat" rows="2" required>{{ old('alamat') }}</textarea>
                    <div class="input-group-append">
                        <span class="input-group-text border-left-0"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                </div>
                @error('alamat')
                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                @enderror
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <label for="password" class="small font-weight-bold text-muted text-uppercase">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control border-right-0 @error('password') is-invalid @enderror"
                                placeholder="Min 6 karakter" name="password" required>
                            <div class="input-group-append">
                                <span class="input-group-text border-left-0"><i class="fas fa-lock"></i></span>
                            </div>
                        </div>
                        @error('password')
                            <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group mb-4">
                        <label for="password_confirmation" class="small font-weight-bold text-muted text-uppercase">Ulangi</label>
                        <div class="input-group">
                            <input type="password" class="form-control border-right-0"
                                placeholder="Ulangi password" name="password_confirmation" required>
                            <div class="input-group-append">
                                <span class="input-group-text border-left-0"><i class="fas fa-lock"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block mb-3 font-weight-bold">
                <i class="fas fa-user-plus mr-1"></i> Daftar Sebagai Anggota
            </button>
        </form>

        <div class="text-center pt-3 border-top">
            <p class="small text-muted mb-2">Sudah memiliki akun terdaftar?</p>
            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm btn-block font-weight-bold py-2" style="border-radius: 10px;">
                <i class="fas fa-sign-in-alt mr-1"></i> Masuk ke Akun Saya
            </a>
            <a href="{{ url('/') }}" class="small text-secondary font-weight-bold d-inline-block mt-3">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Katalog Buku
            </a>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
        };

        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
    </script>
</body>
</html>
