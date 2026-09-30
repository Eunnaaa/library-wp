<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-Library UNM | @yield('title')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <style>
        :root {
            --font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            --accent: #0284c7;
            --dark-surface: #0f172a;
            --dark-elevated: #1e293b;
            --body-bg: #f8fafc;
            --card-border: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --shadow-subtle: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
            --shadow-card: 0 4px 6px -1px rgba(0, 0, 0, 0.06), 0 2px 4px -2px rgba(0, 0, 0, 0.04);
            --shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
        }

        html {
            scroll-behavior: smooth;
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: var(--font-family);
            background-color: var(--body-bg);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }

        /* Modern Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content-area {
            flex: 1 0 auto;
        }

        /* Buttons Enhancement */
        .btn {
            font-weight: 600;
            border-radius: var(--radius-sm);
            padding: 0.5rem 1.15rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.01em;
        }
        .btn-sm {
            padding: 0.35rem 0.85rem;
            font-size: 0.85rem;
            border-radius: 6px;
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        }
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }
        .btn-outline-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
            transform: translateY(-1px);
        }
        .btn-success {
            background-color: #10b981;
            border-color: #10b981;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
        }
        .btn-success:hover {
            background-color: #059669;
            border-color: #059669;
            transform: translateY(-1px);
        }

        /* Card Enhancements */
        .card {
            border-radius: var(--radius-md);
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            transition: all 0.25s ease;
        }

        .book-card {
            border-radius: var(--radius-md);
            border: 1px solid #e2e8f0;
            background: #ffffff;
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.25s ease;
        }
        .book-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-hover);
            border-color: #cbd5e1;
        }
        .book-card .card-title {
            float: none !important;
            display: block;
            width: 100%;
        }

        .card-img-book-wrapper,
        .book-stage {
            position: relative;
            height: 255px;
            background: radial-gradient(circle at 50% 30%, #ffffff 0%, #f8fafc 55%, #e2e8f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px 20px 22px 20px;
            overflow: hidden;
            border-top-left-radius: inherit;
            border-top-right-radius: inherit;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Ambient ground shadow beneath book */
        .card-img-book-wrapper::after,
        .book-stage::after {
            content: '';
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 105px;
            height: 10px;
            background: radial-gradient(ellipse at center, rgba(15, 23, 42, 0.22) 0%, rgba(15, 23, 42, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .book-card:hover .card-img-book-wrapper::after,
        .book-card:hover .book-stage::after {
            width: 130px;
            height: 12px;
            opacity: 0.55;
            bottom: 6px;
            transform: translateX(-50%) scale(1.08);
        }

        /* 3D Realistic Physical Book */
        .book-cover-3d {
            position: relative;
            display: inline-block;
            height: 100%;
            max-height: 215px;
            aspect-ratio: 1 / 1.45;
            border-radius: 2px 7px 7px 2px;
            overflow: hidden;
            background-color: #cbd5e1;
            /* Multi-layered shadows: Spine curvature, deep elevation, contact shadow, internal highlight */
            box-shadow:
                -3px 0 5px rgba(0, 0, 0, 0.18),
                0 10px 20px -4px rgba(15, 23, 42, 0.28),
                0 4px 6px -2px rgba(15, 23, 42, 0.12),
                inset 1px 0 2px rgba(255, 255, 255, 0.4);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease;
            transform-origin: center bottom;
            z-index: 1;
        }

        /* Spine crease and book binding illusion */
        .book-cover-3d::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 100%;
            pointer-events: none;
            z-index: 2;
            background: linear-gradient(
                to right,
                rgba(0, 0, 0, 0.24) 0%,
                rgba(255, 255, 255, 0.28) 3%,
                rgba(0, 0, 0, 0.16) 6%,
                rgba(0, 0, 0, 0.05) 8%,
                transparent 14%
            );
        }

        /* Subtle right page edge */
        .book-cover-3d::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 3px;
            pointer-events: none;
            z-index: 2;
            background: linear-gradient(to left, rgba(0, 0, 0, 0.12), transparent);
        }

        .book-cover-3d img,
        .card-img-book {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .book-card:hover .book-cover-3d {
            transform: translateY(-8px) scale(1.03) rotate(-1deg);
            box-shadow:
                -4px 0 7px rgba(0, 0, 0, 0.24),
                0 18px 28px -6px rgba(15, 23, 42, 0.35),
                0 6px 12px -2px rgba(15, 23, 42, 0.18),
                inset 1px 0 2px rgba(255, 255, 255, 0.5);
        }

        /* Showcase Stage for Modal and Details */
        .book-showcase-stage {
            position: relative;
            background: radial-gradient(circle at 50% 35%, #ffffff 0%, #f8fafc 55%, #e2e8f0 100%);
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 24px 20px 28px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 290px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.03);
        }

        .book-showcase-stage::after {
            content: '';
            position: absolute;
            bottom: 14px;
            left: 50%;
            transform: translateX(-50%);
            width: 140px;
            height: 12px;
            background: radial-gradient(ellipse at center, rgba(15, 23, 42, 0.24) 0%, rgba(15, 23, 42, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .book-showcase-stage .book-cover-3d {
            max-height: 250px;
            box-shadow:
                -4px 0 6px rgba(0, 0, 0, 0.2),
                0 14px 25px -5px rgba(15, 23, 42, 0.3),
                0 6px 10px -2px rgba(15, 23, 42, 0.12),
                inset 1px 0 2px rgba(255, 255, 255, 0.4);
        }

        .book-showcase-stage .book-cover-3d:hover {
            transform: translateY(-6px) scale(1.02) rotate(-0.5deg);
        }

        /* 3D Book Thumbnail for Lists & Tables */
        .book-cover-thumb {
            position: relative;
            display: inline-block;
            aspect-ratio: 1 / 1.45;
            border-radius: 2px 4px 4px 2px;
            overflow: hidden;
            background-color: #cbd5e1;
            box-shadow:
                -1px 0 3px rgba(0, 0, 0, 0.18),
                0 4px 8px -2px rgba(15, 23, 42, 0.2);
            vertical-align: middle;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            flex-shrink: 0;
        }

        .book-cover-thumb::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 100%;
            pointer-events: none;
            z-index: 2;
            background: linear-gradient(
                to right,
                rgba(0, 0, 0, 0.2) 0%,
                rgba(255, 255, 255, 0.28) 4%,
                rgba(0, 0, 0, 0.12) 8%,
                transparent 16%
            );
        }

        .book-cover-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .book-cover-thumb:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow:
                -2px 0 4px rgba(0, 0, 0, 0.22),
                0 8px 14px -3px rgba(15, 23, 42, 0.28);
        }

        .book-cover-thumb-sm {
            width: 44px;
            height: 64px;
        }

        .book-cover-thumb-md {
            width: 58px;
            height: 84px;
        }

        /* Badges */
        .badge {
            font-weight: 600;
            border-radius: 9999px;
            padding: 0.35em 0.75em;
            letter-spacing: 0.02em;
        }
        .badge-primary {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .badge-info {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        /* Tables */
        .table thead th {
            border-top: none;
            border-bottom: 2px solid #e2e8f0;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            font-weight: 700;
        }
        .table tbody td {
            vertical-align: middle;
            border-color: #f1f5f9;
            color: #334155;
            font-size: 0.92rem;
        }

        /* Forms */
        .form-control {
            border-radius: var(--radius-sm);
            border-color: #cbd5e1;
            padding: 0.6rem 0.9rem;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        /* Pagination Polish */
        .pagination {
            gap: 6px;
            margin-bottom: 0;
        }
        .page-item .page-link {
            border-radius: 10px !important;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-weight: 600;
            padding: 0.5rem 0.9rem;
            font-size: 0.88rem;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }
        .page-item .page-link:hover {
            background-color: #f1f5f9;
            color: var(--primary);
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }
        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover)) !important;
            border-color: var(--primary) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35);
        }
        .page-item.disabled .page-link {
            color: #94a3b8;
            background-color: #f8fafc;
            border-color: #e2e8f0;
        }

        /* Accessibility focus ring */
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 2px !important;
        }

        /* Toastr Custom Styling */
        #toast-container > div {
            border-radius: 14px !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
            opacity: 0.98 !important;
            font-family: var(--font-family) !important;
            font-size: 0.9rem !important;
            padding: 16px 16px 16px 50px !important;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @stack('styles')
</head>

<body>
    @include('member.layout.navbar')

    <div class="content-area mb-5">
        @yield('content')
    </div>

    <!-- Back to Top Button -->
    <button id="btn-back-to-top" class="btn btn-primary rounded-circle shadow-lg"
        style="position: fixed; bottom: 25px; right: 25px; width: 44px; height: 44px; display: none; z-index: 1040; align-items: center; justify-content: center; padding: 0; border: 2px solid rgba(255, 255, 255, 0.4);"
        title="Kembali ke atas">
        <i class="fas fa-chevron-up"></i>
    </button>

    @include('member.layout.footer')

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();

            // Back to top floating button
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('#btn-back-to-top').fadeIn(200).css('display', 'flex');
                } else {
                    $('#btn-back-to-top').fadeOut(200);
                }
            });

            $('#btn-back-to-top').click(function() {
                $('html, body').animate({scrollTop: 0}, 400);
                return false;
            });

            // Keyboard shortcut '/' to focus catalog search
            $(document).keydown(function(e) {
                if (e.key === '/' && !$(e.target).is('input, textarea, select')) {
                    var $search = $('#catalog-search-input');
                    if ($search.length) {
                        e.preventDefault();
                        $search.focus().select();
                    }
                }
            });
        });

        const APP_URL = {!! json_encode(url('/')) !!};

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

        @if (Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif
    </script>

    @stack('scripts')
</body>
</html>
