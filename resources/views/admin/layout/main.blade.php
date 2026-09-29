<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-Library UNM | @yield('title')</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <style>
        :root {
            --font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
        }

        body, .main-sidebar, .content-wrapper, .navbar, .card, .table, .form-control {
            font-family: var(--font-family) !important;
        }

        .content-wrapper {
            background-color: #f8fafc;
        }

        /* Main Sidebar & Boundary Line */
        body:not(.sidebar-collapse) .main-sidebar,
        body:not(.sidebar-collapse) .main-sidebar .brand-link,
        body:not(.sidebar-collapse) .sidebar,
        body:not(.sidebar-collapse) .sidebar-user-panel {
            width: 250px !important;
        }

        .main-sidebar {
            background-color: #0f172a !important;
            border-right: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15) !important;
            display: flex !important;
            flex-direction: column !important;
            height: 100vh !important;
            position: fixed !important;
            top: 0 !important;
            bottom: 0 !important;
            left: 0 !important;
            box-sizing: border-box !important;
            overflow: hidden !important;
            z-index: 1038 !important;
        }
        .main-sidebar .brand-link {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            background: #090e17 !important;
            padding: 14px !important;
            box-sizing: border-box !important;
            flex-shrink: 0 !important;
        }

        /* Sidebar Inner Spacing - 100% Symmetrical Menu Container */
        .sidebar {
            padding-left: 14px !important;
            padding-right: 14px !important;
            padding-top: 4px !important;
            padding-bottom: 14px !important;
            box-sizing: border-box !important;
            flex: 1 1 auto !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            scrollbar-width: none !important; /* Firefox */
            -ms-overflow-style: none !important; /* IE/Edge */
        }
        .sidebar::-webkit-scrollbar {
            display: none !important; /* Chrome, Safari */
            width: 0 !important;
            height: 0 !important;
        }

        /* User Panel Docked at Bottom of Sidebar - Perfectly Balanced */
        .sidebar-user-panel {
            flex-shrink: 0 !important;
            margin-top: auto !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
            background: #090e17 !important;
            padding: 10px 14px !important;
            box-sizing: border-box !important;
        }
        .sidebar-user-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 10px;
            padding: 8px 10px;
            width: 100%;
            box-sizing: border-box;
            transition: background 0.15s ease, border-color 0.15s ease;
        }
        .sidebar-user-card:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(255, 255, 255, 0.12);
        }
        .btn-profile-cog {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.06);
            color: #94a3b8;
            font-size: 0.8rem;
            transition: all 0.15s ease;
            text-decoration: none !important;
            flex-shrink: 0;
        }
        .btn-profile-cog:hover {
            background: #2563eb;
            color: #ffffff;
        }

        body.sidebar-collapse .main-sidebar {
            width: 4.6rem !important;
        }
        body.sidebar-collapse .main-sidebar .brand-link {
            width: 4.6rem !important;
            padding: 14px 10px !important;
        }
        body.sidebar-collapse .sidebar {
            width: 4.6rem !important;
            padding-left: 8px !important;
            padding-right: 8px !important;
        }
        body.sidebar-collapse .sidebar-user-panel {
            width: 4.6rem !important;
            padding: 10px 6px !important;
        }
        body.sidebar-collapse .sidebar-user-card {
            padding: 4px;
            display: flex;
            justify-content: center;
        }
        body.sidebar-collapse .sidebar-user-panel .info,
        body.sidebar-collapse .sidebar-user-panel .btn-profile-cog {
            display: none !important;
        }

        /* Nav Sidebar & Links - Strict Equal Width & Margins */
        .nav-sidebar {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            box-sizing: border-box !important;
            list-style: none !important;
        }
        .nav-sidebar .nav-header {
            padding: 16px 6px 6px 6px !important;
            margin: 0 !important;
            color: #64748b !important;
            font-size: 0.68rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.08em !important;
            text-transform: uppercase !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        .nav-sidebar .nav-item {
            width: 100% !important;
            margin: 0 0 3px 0 !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }
        .nav-sidebar .nav-link {
            color: #94a3b8 !important;
            border-radius: 8px !important;
            padding: 9px 12px !important;
            font-size: 0.88rem !important;
            font-weight: 500 !important;
            width: 100% !important;
            box-sizing: border-box !important;
            margin: 0 !important;
            transition: all 0.15s ease-in-out !important;
            display: flex !important;
            align-items: center !important;
        }
        .nav-sidebar .nav-link .nav-icon {
            color: #64748b !important;
            font-size: 0.95rem !important;
            margin-right: 10px !important;
            transition: color 0.15s ease !important;
        }

        /* Comfortable Soft Hover on Sidebar Links */
        .nav-sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.07) !important;
            color: #ffffff !important;
        }
        .nav-sidebar .nav-link:hover .nav-icon {
            color: #60a5fa !important;
        }

        /* Parent Menu Open / Expanded */
        .nav-sidebar > .nav-item.menu-open > .nav-link:not(.active),
        .nav-sidebar > .nav-item.menu-is-opening > .nav-link:not(.active) {
            background-color: rgba(255, 255, 255, 0.04) !important;
            color: #e2e8f0 !important;
        }
        .nav-sidebar > .nav-item.menu-open > .nav-link:not(.active) .nav-icon {
            color: #94a3b8 !important;
        }

        /* Top-Level Single Active (e.g. Dashboard) */
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active,
        .nav-sidebar > .nav-item > .nav-link.active {
            background-color: #2563eb !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35) !important;
        }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active .nav-icon,
        .nav-sidebar > .nav-item > .nav-link.active .nav-icon {
            color: #ffffff !important;
        }

        /* Submenu (Treeview) Container & Indentation */
        .nav-treeview {
            width: 100% !important;
            box-sizing: border-box !important;
            background: rgba(0, 0, 0, 0.25) !important;
            border-radius: 8px !important;
            padding: 4px !important;
            margin: 4px 0 6px 0 !important;
            border-left: 2px solid rgba(59, 130, 246, 0.35) !important;
        }
        .nav-treeview .nav-item {
            width: 100% !important;
            margin-bottom: 2px !important;
            box-sizing: border-box !important;
        }
        .nav-treeview .nav-link {
            width: 100% !important;
            box-sizing: border-box !important;
            padding: 7px 10px !important;
            font-size: 0.84rem !important;
            color: #94a3b8 !important;
            border-radius: 6px !important;
        }
        .nav-treeview .nav-link .nav-icon {
            font-size: 0.78rem !important;
            margin-right: 8px !important;
            color: #64748b !important;
        }

        /* Submenu Hover */
        .nav-treeview .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
        }
        .nav-treeview .nav-link:hover .nav-icon {
            color: #93c5fd !important;
        }

        /* Submenu ACTIVE State: Sleek Blue Accent, NEVER blinding white! */
        .sidebar-dark-primary .nav-sidebar .nav-treeview > .nav-item > .nav-link.active,
        .sidebar-dark-primary .nav-sidebar .nav-treeview > .nav-item > .nav-link.active:hover,
        .nav-treeview .nav-link.active,
        .nav-treeview .nav-link.active:hover {
            background-color: #2563eb !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.35) !important;
        }
        .sidebar-dark-primary .nav-sidebar .nav-treeview > .nav-item > .nav-link.active .nav-icon,
        .nav-treeview .nav-link.active .nav-icon {
            color: #ffffff !important;
        }

        /* Fix Bootstrap/AdminLTE ::after Clearfix Breaking Flex Alignment */
        .card-header::after {
            display: none !important;
        }
        .card-header.d-flex {
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
        }

        /* DataTables Controls & Pagination Styling */
        .dataTables_wrapper .dataTables_length select {
            border-radius: 8px !important;
            padding: 4px 10px !important;
            border: 1px solid #cbd5e1 !important;
            font-size: 0.85rem !important;
            background-color: #ffffff !important;
        }
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 8px !important;
            padding: 6px 12px !important;
            border: 1px solid #cbd5e1 !important;
            font-size: 0.85rem !important;
            margin-left: 8px !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
            outline: none !important;
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 0.85rem !important;
            color: #64748b !important;
            padding-top: 12px !important;
        }
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 8px !important;
        }
        .dataTables_wrapper .pagination .page-item .page-link {
            border-radius: 8px !important;
            margin: 0 2px !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            font-size: 0.85rem !important;
            padding: 6px 12px !important;
            transition: all 0.15s ease !important;
        }
        .dataTables_wrapper .pagination .page-item.active .page-link {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.25) !important;
        }
        .dataTables_wrapper .pagination .page-item.disabled .page-link {
            color: #94a3b8 !important;
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
        }

        .card {
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .card-header {
            border-top-left-radius: 14px !important;
            border-top-right-radius: 14px !important;
        }

        .info-box {
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.2s ease;
        }
        .info-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -5px rgba(0,0,0,0.1);
        }
        .info-box-icon {
            border-radius: 10px;
        }

        .table thead th {
            border-top: none;
            border-bottom: 2px solid #e2e8f0;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            font-weight: 700;
        }
        .table tbody td {
            vertical-align: middle;
            border-color: #f1f5f9;
            font-size: 0.9rem;
        }

        .badge {
            font-weight: 600;
            border-radius: 9999px;
            padding: 0.35em 0.75em;
        }

        .btn {
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.85rem;
        }

        .booking {
            height: 200px;
            object-fit: cover;
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            @include('admin.layout.navbar')
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            @include('admin.layout.sidebar')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                @include('admin.layout.header')
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                @yield('content')
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            @include('admin.layout.footer')
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

    <!-- bs-custom-file-input -->
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    @stack('scripts')

    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
        });

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
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

        $(function() {
            if ($('.select2').length > 0) {
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            }
        });

        const APP_URL = {!! json_encode(url('/')) !!};
    </script>
</body>
</html>
