<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Perpustakaan'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        main {
            flex: 1;
            padding: 2rem 0;
        }

        /* Navbar Styling */
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        /* Dashboard Header */
        .dashboard-header {
            margin-bottom: 2rem;
            padding: 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            color: white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .dashboard-header h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Table Styling */
        .table {
            font-size: 0.95rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .table tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
            border-left-color: #0d6efd;
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .table thead {
            background-color: #f8f9fa !important;
            border-bottom: 3px solid #0d6efd;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.08) !important;
        }

        /* Badge Styling */
        .badge {
            font-weight: 600;
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .badge:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12) !important;
            transform: translateY(-2px);
        }

        .card-header {
            border-radius: 12px 12px 0 0;
            font-weight: 600;
        }

        /* Button Styling */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            border: none;
            color: white;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #fd7e14 0%, #f76707 100%);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #bb2d3b 100%);
            border: none;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #bb2d3b 0%, #a02622 100%);
        }

        /* Search Input */
        .input-group-lg .form-control,
        .input-group-lg .btn {
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border-radius: 8px;
        }

        .form-control {
            border: 2px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        /* Pagination Styling */
        .pagination {
            gap: 4px;
        }

        .page-link {
            border-radius: 8px;
            border: 2px solid #dee2e6;
            color: #0d6efd;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 0 2px;
        }

        .page-link:hover {
            background-color: #f8f9fa;
            border-color: #0d6efd;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }

        .pagination .active .page-link {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            border-color: #0a58ca;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 12px;
            border-left: 4px solid;
            animation: slideIn 0.3s ease-out;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1e7dd 0%, #f0f9f7 100%);
            border-left-color: #198754;
            color: #0f5132;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #fef5f6 100%);
            border-left-color: #dc3545;
            color: #842029;
        }

        .alert-info {
            background: linear-gradient(135deg, #cfe2ff 0%, #f8f9fa 100%);
            border-left-color: #0d6efd;
            color: #084298;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #fffbf0 100%);
            border-left-color: #ffc107;
            color: #664d03;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Statistik Cards */
        .stat-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-card .card-body {
            position: relative;
            z-index: 1;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .stat-card i {
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.1));
        }

        /* Card Header */
        .card-header {
            border-bottom: 3px solid rgba(255, 255, 255, 0.2);
            padding: 1.25rem;
        }

        /* Menu Buttons */
        .menu-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            border: 2px solid #dee2e6;
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        .menu-btn:not(:disabled):hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: #0d6efd;
            background: linear-gradient(135deg, #f9f9f9, #f0f0f0);
        }

        .menu-btn:not(:disabled):active {
            transform: translateY(-2px);
        }

        .menu-btn i {
            transition: transform 0.3s ease;
        }

        .menu-btn:not(:disabled):hover i {
            transform: scale(1.1);
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #2c3e50 0%, #3d566e 100%);
            border-top: 3px solid #667eea;
            margin-top: 3rem;
            padding: 2rem 0;
            font-size: 0.9rem;
        }

        /* Responsive Typography */
        @media (max-width: 768px) {
            .dashboard-header h1 {
                font-size: 1.75rem;
            }

            .stat-card h2 {
                font-size: 1.75rem !important;
            }

            main {
                padding: 1rem 0;
            }
        }
    </style>
</head>
<body>
    <?php
    // Deteksi base path aplikasi secara dinamis
    $script_name = isset($_SERVER['SCRIPT_NAME']) ? str_replace('\\', '/', $_SERVER['SCRIPT_NAME']) : '';
    $script_dir = dirname($script_name);
    
    // Cari folder root perpustakaan
    $base_path = '';
    if (strpos($script_dir, '/perpustakaan') !== false) {
        $base_path = '/perpustakaan';
    }
    
    // URL untuk Home, Data Buku, dan Data Anggota
    $home_url = $base_path . '/';
    $data_buku_url = $base_path . '/modules/buku/index.php';
    $data_anggota_url = $base_path . '/modules/anggota/index.php';
    
    // Deteksi halaman aktif
    $current_path = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '';
    $is_home = (strpos($current_path, $base_path . '/index.php') !== false || $current_path === $base_path . '/modules/buku/home.php');
    $is_data_menu = (strpos($current_path, $base_path . '/modules/buku') !== false || strpos($current_path, $base_path . '/modules/anggota') !== false);
    $is_buku = (strpos($current_path, $base_path . '/modules/buku') !== false);
    $is_anggota = (strpos($current_path, $base_path . '/modules/anggota') !== false);
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $home_url; ?>">
                <i class="bi bi-book"></i> Sistem Perpustakaan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $is_home ? 'active fw-semibold' : ''; ?>" href="<?php echo $home_url; ?>" <?php echo $is_home ? 'aria-current="page"' : ''; ?>>
                            <i class="bi bi-house"></i> Home
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo $is_data_menu ? 'active fw-semibold' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-database"></i> Data
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item <?php echo $is_buku ? 'active fw-semibold' : ''; ?>" href="<?php echo $data_buku_url; ?>">
                                    <i class="bi bi-book me-2"></i>Data Buku
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo $is_anggota ? 'active fw-semibold' : ''; ?>" href="<?php echo $data_anggota_url; ?>">
                                    <i class="bi bi-people me-2"></i>Data Anggota
                                </a>
                            </li>
                            <li>
                                <span class="dropdown-item disabled text-muted" title="Fitur masih dalam pengembangan" style="cursor:not-allowed;">
                                    <i class="bi bi-tags me-2"></i>Kategori Buku
                                    <span class="badge bg-warning-subtle text-dark ms-2">Segera</span>
                                </span>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <main class="py-4">