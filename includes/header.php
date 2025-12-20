<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: /PHP_Inventory/login.php");
    exit;
}

require_once __DIR__ . '/api_helper.php';
$base_url = "/PHP_Inventory"; // Sesuaikan dengan nama folder di htdocs
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Inventory</title>
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Inventory Laboratorium System</h3>
                <small>Universitas Indonesia</small><br>
                    <?php if ($_SESSION['role'] === 'ADMIN'): ?>
                        <span class="badge-role"><?= $_SESSION['role'] ?></span>
                    <?php else: ?>
                        <span class="badge-role" style="background: #DCDCDC; color: black;"><?= $_SESSION['role'] ?></span>
                    <?php endif; ?>
            </div>
            <ul class="list-unstyled components">
                <li><a href="<?= $base_url ?>/pages/dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="<?= $base_url ?>/pages/transaction/index.php"><i class="fas fa-exchange-alt"></i> Transaction</a></li>
                <li><a href="<?= $base_url ?>/pages/equipment/index.php"><i class="fas fa-microscope"></i> Equipment</a></li>
                <li><a href="<?= $base_url ?>/pages/condition_log/index.php"><i class="fas fa-file-medical-alt"></i> Condition Log</a></li>
                <li><a href="<?= $base_url ?>/pages/student/index.php"><i class="fas fa-user-graduate"></i> Student</a></li>
                <li><a href="<?= $base_url ?>/pages/category/index.php"><i class="fas fa-tags"></i> Category</a></li>

                <?php if($_SESSION['role'] === 'ADMIN'): ?>
                <li>
                    <a href="<?= $base_url ?>/pages/user/index.php" style="background: #c0392b;">
                        <i class="fas fa-users-cog"></i> User Management
                    </a>
                </li>
                <?php endif; ?>

                <li><a href="<?= $base_url ?>/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <div id="content">
            <nav class="navbar">
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="page-title">Inventory System</span>
            </nav>
            <div class="main-content">
            