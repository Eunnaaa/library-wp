<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>E-Library UNM | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at 50% 15%, rgba(197, 155, 39, 0.18) 0%, transparent 55%),
                        linear-gradient(135deg, #1b1008 0%, #2c1a10 50%, #150d06 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            border-radius: 20px;
            background: #fdfbf7;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 20px rgba(197, 155, 39, 0.12);
            border: 1px solid rgba(197, 155, 39, 0.35);
            overflow: hidden;
        }
        .brand-badge {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #c59b27, #e9c46a);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px auto;
            box-shadow: 0 8px 16px rgba(197, 155, 39, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.35);
            color: #1b1008;
        }
        .form-control {
            border-radius: 10px;
            height: 48px;
            font-size: 0.95rem;
            border: 1px solid #dcd3c3;
            background-color: #ffffff;
            color: #241a14;
        }
        .form-control:focus {
            border-color: #8b4513;
            box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.15);
        }
        .input-group-text {
            border-radius: 10px;
            border: 1px solid #dcd3c3;
            background-color: #f7f3ea;
            color: #746454;
        }
        .btn-primary {
            background-color: #8b4513;
            border-color: #8b4513;
            height: 46px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 4px 10px rgba(139, 69, 19, 0.3);
        }
        .btn-primary:hover {
            background-color: #70360d;
            border-color: #70360d;
        }
        .btn-outline-primary {
            color: #8b4513;
            border-color: #8b4513;
        }
        .btn-outline-primary:hover {
            background-color: #8b4513;
            border-color: #8b4513;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="login-card p-4 p-sm-5">
        <div class="text-center mb-4">
            <div class="brand-badge">
                <i class="fas fa-book-reader fa-2x"></i>
            </div>
            <h4 class="font-weight-bold text-dark mb-1" style="letter-spacing: -0.02em;">E-Library UNM</h4>
            <p class="text-muted small mb-0">Athenaeum Perpustakaan Universitas Nusa Mandiri</p>
        </div>

        <!-- 1-Click Demo Login Shortcut -->
        <div class="p-2 mb-3 rounded-lg" style="background: #f7f2e7; border: 1px dashed #c59b27; border-radius: 12px;">
            <div class="d-flex justify-content-between align-items-center mb-1 px-1">
                <small class="font-weight-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.05em; color: #8b4513;">
                    <i class="fas fa-feather-alt mr-1"></i> Demo Login Cepat (1-Klik):
                </small>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-xs font-weight-bold mr-1 flex-fill py-1" style="background: #2c1a10; color: #e9c46a; border: 1px solid #3d2517;" onclick="fillLogin('admin@gmail.com', 'admin123')">
                    <i class="fas fa-shield-alt mr-1"></i> Admin
                </button>
                <button type="button" class="btn btn-xs font-weight-bold flex-fill py-1" style="background: #2d6a4f; color: #ffffff; border: 1px solid #2d6a4f;" onclick="fillLogin('gary@gmail.com', '12345678')">
                    <i class="fas fa-book-reader mr-1"></i> Anggota (Gary)
                </button>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group mb-3">
                <label for="email" class="small font-weight-bold text-muted text-uppercase">Email</label>
                <div class="input-group">
                    <input type="email" class="form-control border-right-0 @error('email') is-invalid @enderror"
                        placeholder="nama@email.com" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    <div class="input-group-append">
                        <span class="input-group-text border-left-0"><i class="fas fa-envelope"></i></span>
                    </div>
                </div>
                @error('email')
                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password" class="small font-weight-bold text-muted text-uppercase">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control border-right-0 @error('password') is-invalid @enderror"
                        placeholder="••••••••" id="password" name="password" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary border border-left-0 bg-light text-muted px-3" type="button" onclick="togglePassword('password', this)" title="Lihat password" style="border-radius: 0 10px 10px 0; border-color: #e8e2d4 !important;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                @error('password')
                    <small class="text-danger font-weight-bold mt-1 d-block">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember" class="small text-muted font-weight-normal mb-0">
                        Ingat sesi saya
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block mb-3 font-weight-bold shadow-sm" style="border-radius: 10px;">
                <i class="fas fa-sign-in-alt mr-1"></i> Masuk ke Akun
            </button>
        </form>

        <div class="text-center pt-3 border-top">
            <p class="small text-muted mb-2">Belum memiliki akun anggota perpustakaan?</p>
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm btn-block font-weight-bold py-2" style="border-radius: 10px;">
                <i class="fas fa-user-plus mr-1"></i> Daftar Anggota Baru
            </a>
            <a href="{{ url('/') }}" class="small font-weight-bold d-inline-block mt-3" style="color: #8b4513;">
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

        function fillLogin(email, password) {
            $('#email').val(email);
            $('#password').val(password);
            toastr.info('Kredensial ' + email + ' dimasukkan!');
        }

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
