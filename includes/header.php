<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: /PHP_Inventory/login.php");
    exit;
}

require_once __DIR__ . '/api_helper.php';
$base_url = "/PHP_Inventory"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Inventory System</title>
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    
    <div class="wrapper">
        
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Inventory Laboratorium</h3>
                <small style="opacity: 0.7;">Universitas Indonesia</small>
                <br>
                <?php if ($_SESSION['role'] === 'ADMIN'): ?>
                    <span class="badge-role" style="background: var(--danger-color); color: white;">
                        <?= $_SESSION['role'] ?>
                    </span>
                <?php else: ?>
                    <span class="badge-role" style="background: rgba(255,255,255,0.2); color: white;">
                        <?= $_SESSION['role'] ?>
                    </span>
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
                <li style="margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.1); padding-top:10px;">
                    <span style="padding-left:20px; font-size:0.8rem; color:#6c757d; text-transform:uppercase;">Admin Area</span>
                    <a href="<?= $base_url ?>/pages/user/index.php" style="color: #ff8787;">
                        <i class="fas fa-users-cog"></i> User Management
                    </a>
                </li>
                <?php endif; ?>
                
                <li style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                    <a href="<?= $base_url ?>/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </nav>

        <div id="content">
            <nav class="navbar">
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-bars"></i>
                </button>
                <span style="font-weight: 600; font-size: 1.1rem; color: var(--dark-color);">
                    Inventory System
                </span>
            </nav>
            <div class="main-content">
            