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
            --font-serif: var(--font-family);
            --wood-dark: #1b1008;
            --wood-mid: #2c1a10;
            --wood-light: #3d2517;
            --primary: #8b4513; /* Saddle Mahogany */
            --primary-hover: #70360d;
            --primary-light: #f7ede2;
            --accent-gold: #c59b27; /* Antique Gilded Gold */
            --accent-gold-bright: #d4af37;
            --accent: #2d6a4f; /* Archival Banker's Green */
            --dark-surface: #1b1008;
            --dark-elevated: #28170d;
            --body-bg: #f7f4ec; /* Warm Linen Parchment */
            --card-border: #e8e2d4;
            --text-main: #241a14; /* Deep Fountain Ink */
            --text-muted: #746454; /* Antique Sepia */
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-xl: 18px;
            --shadow-subtle: 0 1px 3px 0 rgba(44, 26, 16, 0.05), 0 1px 2px -1px rgba(44, 26, 16, 0.05);
            --shadow-card: 0 4px 10px -2px rgba(44, 26, 16, 0.06), 0 2px 4px -2px rgba(44, 26, 16, 0.04);
            --shadow-hover: 0 16px 24px -6px rgba(44, 26, 16, 0.12), 0 6px 10px -4px rgba(44, 26, 16, 0.06);
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

        h1, h2, h3, h4, h5, h6, .font-serif, .display-4, .brand-text {
            font-family: var(--font-family) !important;
            letter-spacing: -0.02em;
        }

        /* Classic Library Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #ede7db;
        }
        ::-webkit-scrollbar-thumb {
            background: #c9beab;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #ab9e89;
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
            border-color: #6d330c;
            color: #ffffff;
            box-shadow: 0 2px 4px rgba(139, 69, 19, 0.25);
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--primary-hover);
            border-color: #552707;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(139, 69, 19, 0.35);
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
            background-color: #2d6a4f;
            border-color: #1b4332;
            color: #ffffff;
            box-shadow: 0 2px 4px rgba(45, 106, 79, 0.25);
        }
        .btn-success:hover {
            background-color: #1b4332;
            border-color: #0f281e;
            color: #ffffff;
            transform: translateY(-1px);
        }
        .badge-primary {
            background-color: var(--primary) !important;
            color: #ffffff;
        }
        .badge-info {
            background-color: #385170 !important;
            color: #ffffff;
        }
        .badge-warning {
            background-color: #d4af37 !important;
            color: #1b1008;
            font-weight: 700;
        }
        .badge-success {
            background-color: #2d6a4f !important;
            color: #ffffff;
        }

        /* Card Enhancements */
        .card {
            border-radius: var(--radius-md);
            border: 1px solid var(--card-border) !important;
            box-shadow: var(--shadow-card);
            overflow: hidden;
            transition: all 0.25s ease;
        }
        .bg-light {
            background-color: #fbf9f4 !important;
        }

        .book-card {
            border-radius: var(--radius-md);
            border: 1px solid var(--card-border);
            background: #ffffff;
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.25s ease;
        }
        .book-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-hover);
            border-color: #cfc5b4;
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
            background: radial-gradient(circle at 50% 30%, #fffefc 0%, #f7f2e8 55%, #ece2d2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px 20px 22px 20px;
            overflow: hidden;
            border-top-left-radius: inherit;
            border-top-right-radius: inherit;
            border-bottom: 1px solid var(--card-border);
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
            background-color: #dfd7ca;
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
            background: radial-gradient(circle at 50% 35%, #fffefc 0%, #f7f2e8 55%, #ece2d2 100%);
            border-radius: 16px;
            border: 1px solid var(--card-border);
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
            background-color: #dfd7ca;
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
            padding: 0.35em 0.8em;
            letter-spacing: 0.02em;
        }
        .badge-primary {
            background-color: #f7ede2 !important;
            color: #8b4513 !important;
            border: 1px solid rgba(139, 69, 19, 0.25) !important;
        }
        .badge-success {
            background-color: #eaf4ed !important;
            color: #2d6a4f !important;
            border: 1px solid rgba(45, 106, 79, 0.25) !important;
        }
        .badge-warning {
            background-color: #fdf8eb !important;
            color: #997300 !important;
            border: 1px solid rgba(197, 155, 39, 0.35) !important;
        }
        .badge-danger {
            background-color: #fbf0f2 !important;
            color: #991b1b !important;
            border: 1px solid rgba(153, 27, 27, 0.25) !important;
        }
        .badge-info {
            background-color: #edf2f7 !important;
            color: #385170 !important;
            border: 1px solid rgba(56, 81, 112, 0.25) !important;
        }
        .badge-secondary {
            background-color: #f1ede6 !important;
            color: #635649 !important;
            border: 1px solid #ddd5c7 !important;
        }

        /* Tables */
        .table thead th {
            background-color: #fcf9f2 !important;
            border-top: none;
            border-bottom: 2px solid #e8e2d4 !important;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #635649;
            font-weight: 700;
            padding: 0.75rem 1rem;
        }
        .table tbody td {
            vertical-align: middle;
            border-color: #efe8dc;
            color: var(--text-main);
            font-size: 0.92rem;
            padding: 0.75rem 1rem;
        }
        .table-hover tbody tr:hover {
            background-color: #fcfaf5 !important;
        }

        /* Forms */
        .form-control {
            border-radius: var(--radius-sm);
            border-color: #dcd3c3;
            background-color: #ffffff;
            color: var(--text-main);
            padding: 0.6rem 0.9rem;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.15) !important;
            color: var(--text-main);
            background-color: #ffffff;
        }

        /* Pagination Polish */
        .pagination {
            gap: 6px;
            margin-bottom: 0;
        }
        .page-item .page-link {
            border-radius: 10px !important;
            border: 1px solid #e8e2d4;
            color: var(--text-main);
            background-color: #ffffff;
            font-weight: 600;
            padding: 0.5rem 0.9rem;
            font-size: 0.88rem;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(44, 26, 16, 0.04);
        }
        .page-item .page-link:hover {
            background-color: #f7ede2;
            color: var(--primary);
            border-color: #dcd3c3;
            transform: translateY(-1px);
        }
        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover)) !important;
            border-color: var(--primary) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(139, 69, 19, 0.35) !important;
        }
        .page-item.disabled .page-link {
            color: #94a3b8;
            background-color: #f8f5ee;
            border-color: #e8e2d4;
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
            background: #f8f5ee;
        }
        ::-webkit-scrollbar-thumb {
            background: #d8cfc0;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #b5a995;
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
