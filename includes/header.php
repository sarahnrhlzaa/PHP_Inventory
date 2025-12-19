<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #212529;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #495057;
        }
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/inventory-frontend/">
                <i class="bi bi-box-seam"></i> Inventory Lab
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text text-light">
                            <i class="bi bi-person-circle"></i> Admin
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="/inventory-frontend/index.php">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/inventory-frontend/pages/students/index.php">
                                <i class="bi bi-people"></i> Mahasiswa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/inventory-frontend/pages/equipment/index.php">
                                <i class="bi bi-box"></i> Alat Laboratorium
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/inventory-frontend/pages/categories/index.php">
                                <i class="bi bi-tags"></i> Kategori
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/inventory-frontend/pages/transactions/index.php">
                                <i class="bi bi-arrow-left-right"></i> Transaksi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/inventory-frontend/pages/transactions/borrowing.php">
                                <i class="bi bi-box-arrow-right"></i> Peminjaman Aktif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/inventory-frontend/pages/users/index.php">
                                <i class="bi bi-person-gear"></i> User
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto px-md-4">