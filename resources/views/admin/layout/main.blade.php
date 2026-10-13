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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

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
            --font-serif: var(--font-family);
            --wood-dark: #1b1008;
            --wood-mid: #2c1a10;
            --primary: #8b4513; /* Saddle Mahogany */
            --primary-hover: #70360d;
            --accent-gold: #c59b27;
            --accent-gold-bright: #d4af37;
            --body-bg: #f8f5ee; /* Warm Linen Parchment */
            --card-border: #e8e2d4;
            --text-main: #241a14;
            --text-muted: #746454;
        }

        body, .main-sidebar, .content-wrapper, .navbar, .card, .table, .form-control {
            font-family: var(--font-family) !important;
            color: var(--text-main);
        }

        h1, h2, h3, h4, h5, h6, .font-serif, .brand-text {
            font-family: var(--font-family) !important;
            letter-spacing: -0.02em;
        }

        .content-wrapper {
            background-color: var(--body-bg) !important;
        }

        /* Main Sidebar & Boundary Line */
        body:not(.sidebar-collapse) .main-sidebar,
        body:not(.sidebar-collapse) .main-sidebar .brand-link,
        body:not(.sidebar-collapse) .sidebar,
        body:not(.sidebar-collapse) .sidebar-user-panel {
            width: 250px !important;
        }

        .main-sidebar {
            background-color: #1a1008 !important;
            border-right: 1px solid rgba(197, 155, 39, 0.25) !important;
            box-shadow: 4px 0 20px rgba(27, 16, 8, 0.35) !important;
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
            border-bottom: 1px solid rgba(197, 155, 39, 0.25) !important;
            background: #120a05 !important;
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
            border-top: 1px solid rgba(197, 155, 39, 0.25) !important;
            background: #120a05 !important;
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
            background: var(--accent-gold);
            color: var(--wood-dark);
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
            background-color: rgba(197, 155, 39, 0.12) !important;
            color: #ffffff !important;
        }
        .nav-sidebar .nav-link:hover .nav-icon {
            color: #d4af37 !important;
        }

        /* Parent Menu Open / Expanded */
        .nav-sidebar > .nav-item.menu-open > .nav-link:not(.active),
        .nav-sidebar > .nav-item.menu-is-opening > .nav-link:not(.active) {
            background-color: rgba(255, 255, 255, 0.04) !important;
            color: #f5eedf !important;
        }
        .nav-sidebar > .nav-item.menu-open > .nav-link:not(.active) .nav-icon {
            color: #c59b27 !important;
        }

        /* Top-Level Single Active (e.g. Dashboard) */
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active,
        .nav-sidebar > .nav-item > .nav-link.active {
            background: linear-gradient(135deg, #8b4513, #a0522d) !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            border: 1px solid #c59b27 !important;
            box-shadow: 0 4px 12px rgba(139, 69, 19, 0.45) !important;
        }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active .nav-icon,
        .nav-sidebar > .nav-item > .nav-link.active .nav-icon {
            color: #ffd700 !important;
        }

        /* Submenu (Treeview) Container & Indentation */
        .nav-treeview {
            width: 100% !important;
            box-sizing: border-box !important;
            background: rgba(0, 0, 0, 0.3) !important;
            border-radius: 8px !important;
            padding: 4px !important;
            margin: 4px 0 6px 0 !important;
            border-left: 2px solid rgba(197, 155, 39, 0.5) !important;
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
            color: #c4b5a3 !important;
            border-radius: 6px !important;
        }
        .nav-treeview .nav-link .nav-icon {
            font-size: 0.78rem !important;
            margin-right: 8px !important;
            color: #a89a88 !important;
        }

        /* Submenu Hover */
        .nav-treeview .nav-link:hover {
            background-color: rgba(197, 155, 39, 0.15) !important;
            color: #ffffff !important;
        }
        .nav-treeview .nav-link:hover .nav-icon {
            color: #ffd700 !important;
        }

        /* Submenu ACTIVE State: Classic Gilded Accent */
        .sidebar-dark-primary .nav-sidebar .nav-treeview > .nav-item > .nav-link.active,
        .sidebar-dark-primary .nav-sidebar .nav-treeview > .nav-item > .nav-link.active:hover,
        .nav-treeview .nav-link.active,
        .nav-treeview .nav-link.active:hover {
            background-color: rgba(197, 155, 39, 0.22) !important;
            color: #fce8a6 !important;
            font-weight: 600 !important;
            border-left: 3px solid #c59b27 !important;
            box-shadow: 0 2px 8px rgba(197, 155, 39, 0.25) !important;
        }
        .sidebar-dark-primary .nav-sidebar .nav-treeview > .nav-item > .nav-link.active .nav-icon,
        .nav-treeview .nav-link.active .nav-icon {
            color: #ffd700 !important;
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
            border: 1px solid var(--card-border) !important;
            font-size: 0.85rem !important;
            background-color: #ffffff !important;
        }
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 8px !important;
            padding: 6px 12px !important;
            border: 1px solid var(--card-border) !important;
            font-size: 0.85rem !important;
            margin-left: 8px !important;
        }
        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.15) !important;
            outline: none !important;
        }
        .dataTables_wrapper .dataTables_info {
            font-size: 0.85rem !important;
            color: var(--text-muted) !important;
            padding-top: 12px !important;
        }
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 8px !important;
        }
        .dataTables_wrapper .pagination .page-item .page-link {
            border-radius: 8px !important;
            margin: 0 2px !important;
            border: 1px solid var(--card-border) !important;
            color: var(--text-main) !important;
            font-size: 0.85rem !important;
            padding: 6px 12px !important;
            transition: all 0.15s ease !important;
            background-color: #ffffff !important;
        }
        .dataTables_wrapper .pagination .page-item.active .page-link {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 4px rgba(139, 69, 19, 0.25) !important;
        }
        .dataTables_wrapper .pagination .page-item.disabled .page-link {
            color: #a3998b !important;
            background-color: #fbf9f4 !important;
            border-color: var(--card-border) !important;
        }

        .card {
            border-radius: 14px;
            border: 1px solid var(--card-border) !important;
            box-shadow: 0 1px 3px rgba(44, 26, 16, 0.05);
            background-color: #ffffff;
        }
        .card-header {
            border-top-left-radius: 14px !important;
            border-top-right-radius: 14px !important;
            border-bottom: 1px solid var(--card-border) !important;
            background-color: #ffffff;
        }
        .card-footer {
            border-bottom-left-radius: 14px !important;
            border-bottom-right-radius: 14px !important;
            border-top: 1px solid var(--card-border) !important;
            background-color: #fdfbf7;
        }
        .bg-light {
            background-color: #fbf9f4 !important;
        }
        .border-bottom {
            border-bottom-color: var(--card-border) !important;
        }
        .border-top {
            border-top-color: var(--card-border) !important;
        }

        .info-box {
            border-radius: 14px;
            border: 1px solid var(--card-border);
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(44, 26, 16, 0.04);
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.2s ease;
        }
        .info-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(44, 26, 16, 0.08);
        }
        .info-box-icon {
            border-radius: 10px;
        }

        .table thead th {
            background-color: #fcf9f2 !important;
            border-top: none;
            border-bottom: 2px solid var(--card-border) !important;
            font-size: 0.78rem;
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
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
        }
        .table-hover tbody tr:hover {
            background-color: #fcfaf5 !important;
        }

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

        .btn {
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.01em;
        }
        .btn-sm {
            padding: 0.35rem 0.85rem;
            font-size: 0.85rem;
            border-radius: 7px;
        }
        .btn-primary {
            background-color: var(--primary) !important;
            border-color: #70360d !important;
            color: #ffffff !important;
            box-shadow: 0 2px 4px rgba(139, 69, 19, 0.25) !important;
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--primary-hover) !important;
            border-color: #552707 !important;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(139, 69, 19, 0.35) !important;
        }
        .btn-outline-primary {
            color: var(--primary) !important;
            border-color: var(--primary) !important;
            background-color: transparent !important;
        }
        .btn-outline-primary:hover, .btn-outline-primary:focus {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #ffffff !important;
            transform: translateY(-1px);
        }
        .btn-success {
            background-color: #2d6a4f !important;
            border-color: #1b4332 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 4px rgba(45, 106, 79, 0.25) !important;
        }
        .btn-success:hover, .btn-success:focus {
            background-color: #1b4332 !important;
            border-color: #0f281e !important;
            color: #ffffff !important;
            transform: translateY(-1px);
        }
        .btn-outline-success {
            color: #2d6a4f !important;
            border-color: #2d6a4f !important;
            background-color: transparent !important;
        }
        .btn-outline-success:hover {
            background-color: #2d6a4f !important;
            color: #ffffff !important;
            transform: translateY(-1px);
        }
        .btn-warning {
            background: linear-gradient(135deg, #c59b27, #d4af37) !important;
            border-color: #b38820 !important;
            color: #1b1008 !important;
            font-weight: 700 !important;
        }
        .btn-warning:hover {
            background: linear-gradient(135deg, #b38820, #c59b27) !important;
            color: #1b1008 !important;
        }

        .form-control, .custom-select {
            border-radius: 8px !important;
            border-color: #dcd3c3 !important;
            color: var(--text-main) !important;
            background-color: #ffffff !important;
        }
        .form-control:focus, .custom-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.15) !important;
        }
        .input-group-text {
            border-color: #dcd3c3 !important;
            background-color: #fcf9f2 !important;
            color: #635649 !important;
        }
        .select2-container--bootstrap4 .select2-selection {
            border-color: #dcd3c3 !important;
            border-radius: 8px !important;
        }
        .select2-container--bootstrap4 .select2-selection:focus,
        .select2-container--bootstrap4.select2-container--focus .select2-selection {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.15) !important;
        }
        .select2-container--bootstrap4 .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary) !important;
            color: #ffffff !important;
        }

        .booking {
            height: 200px;
            object-fit: cover;
        }

        /* 3D Realistic Physical Book & Thumbnail System */
        .book-stage {
            position: relative;
            background: radial-gradient(circle at 50% 30%, #fffefc 0%, #f7f2e8 55%, #ece2d2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px 20px;
            overflow: hidden;
            border-radius: 12px;
            border: 1px solid var(--card-border);
        }

        .book-cover-3d {
            position: relative;
            display: inline-block;
            aspect-ratio: 1 / 1.45;
            border-radius: 2px 7px 7px 2px;
            overflow: hidden;
            background-color: #dfd7ca;
            box-shadow:
                -3px 0 5px rgba(0, 0, 0, 0.18),
                0 10px 20px -4px rgba(15, 23, 42, 0.28),
                0 4px 6px -2px rgba(15, 23, 42, 0.12),
                inset 1px 0 2px rgba(255, 255, 255, 0.4);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease;
            transform-origin: center bottom;
            z-index: 1;
        }

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

        .book-cover-3d img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

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

        /* Custom Scrollbar */
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
