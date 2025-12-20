<?php
require_once 'includes/api_helper.php';
$equipments = callAPI('GET', '/equipments');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Catalog - Inventory Lab</title>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f0f2f5;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        /* HERO SECTION (Bagian Atas Biru) */
        .hero-header {
            background: linear-gradient(135deg, var(--dark-color) 0%, var(--primary-color) 100%);
            height: 350px;
            padding: 0 5%;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: white;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            box-shadow: 0 10px 30px rgba(67, 97, 238, 0.3);
        }

        .navbar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 25px;
            background: transparent; /* Override navbar bawaan style.css */
            box-shadow: none;
        }

        .brand-logo {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-login-outline {
            border: 2px solid rgba(255,255,255,0.8);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
        }
        .btn-login-outline:hover {
            background: white;
            color: var(--primary-color);
        }

        .hero-content {
            margin-top: 40px;
            max-width: 700px;
        }
        .hero-content h1 { font-size: 2.5rem; margin-bottom: 10px; }
        .hero-content p { font-size: 1rem; opacity: 0.9; font-weight: 300; }

        /* SEARCH BAR KEREN */
        .search-container {
            position: relative;
            margin-top: 30px;
            width: 100%;
            max-width: 500px;
        }
        .search-input {
            width: 100%;
            padding: 15px 25px;
            padding-left: 55px;
            border-radius: 50px;
            border: none;
            font-size: 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            outline: none;
        }
        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        /* CONTAINER KARTU UTAMA */
        .catalog-container {
            margin: -60px auto 50px auto; /* Naik ke atas menutupi header */
            width: 90%;
            max-width: 1100px;
            position: relative;
            z-index: 10;
        }

        .catalog-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            padding: 30px;
            border: 1px solid #eef2f6;
        }

        .catalog-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 25px;
            border-left: 5px solid var(--warning-color);
            padding-left: 15px;
        }

        /* TABEL MODIFIKASI */
        table { margin-top: 0; }
        table thead th { 
            background: #f8faff; 
            color: var(--primary-color);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            border-bottom: 2px solid #eef2f6;
        }
        table tbody tr { transition: 0.2s; }
        table tbody tr:hover { background: #fafbff; transform: scale(1.01); }
        
        /* Ubah warna stok agar lebih jelas */
        .stock-badge {
            font-weight: 700;
            font-size: 0.95rem;
        }
        .stock-available { color: var(--success-color); }
        .stock-empty { color: var(--danger-color); }
        .stock-low { color: var(--warning-color); }

    </style>
</head>
<body>

    <div class="hero-header">
        <div class="navbar">
            <div class="brand-logo">
                <i class="fas fa-flask"></i> Inventory Laboratorium
            </div>
            <a href="login.php" class="btn-login-outline">
                Login Admin <i class="fas fa-sign-in-alt"></i>
            </a>
        </div>

        <div class="hero-content">
            <h1>Cari Alat Laboratorium?</h1>
            <p>Cek ketersediaan alat dan bahan praktikum secara real-time di sini sebelum mengajukan peminjaman.</p>
            
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" id="searchInput" placeholder="Ketik nama alat (contoh: Mikroskop)..." onkeyup="filterTable()">
            </div>
        </div>
    </div>

    <div class="catalog-container">
        <div class="catalog-card">
            <h3 class="catalog-title">Daftar Ketersediaan Alat</h3>
            
            <div style="overflow-x: auto;">
                <table id="catalogTable">
                    <thead>
                        <tr>
                            <th>Nama Alat</th>
                            <th>Kategori</th>
                            <th style="text-align:center;">Stok Tersedia</th>
                            <th>Lokasi</th>
                            <th style="text-align:center;">Status Fisik</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($equipments && isset($equipments['data'])): ?>
                        <?php foreach($equipments['data'] as $row): ?>
                        <tr>
                            <td style="font-weight: 600; color: #333;">
                                <?= $row['equipmentName'] ?>
                            </td>
                            <td>
                                <span style="background:#f1f5f9; padding:4px 10px; border-radius:4px; font-size:0.8rem; color:#666;">
                                    <?= $row['categoryId'] ?>
                                </span>
                            </td>
                            <td style="text-align:center;">
                                <?php 
                                    $qty = $row['availableQuantity'];
                                    if($qty > 5) {
                                        echo "<span class='stock-badge stock-available'>$qty Unit</span>";
                                    } elseif($qty > 0) {
                                        echo "<span class='stock-badge stock-low'>$qty Unit (Low)</span>";
                                    } else {
                                        echo "<span class='badge-status bg-danger' style='min-width:80px;'>HABIS</span>";
                                    }
                                ?>
                            </td>
                            <td style="color: #666;"><i class="fas fa-map-marker-alt" style="color:#aaa; margin-right:5px;"></i> <?= $row['location'] ?></td>
                            <td style="text-align:center;">
                                <?php 
                                    $status = $row['conditionStatus'];
                                    if($status == 'BAIK') {
                                        echo "<span class='badge-status bg-success'>BAIK</span>";
                                    } elseif($status == 'RUSAK_RINGAN') {
                                        echo "<span class='badge-status bg-warning'>RUSAK RINGAN</span>";
                                    } else {
                                        echo "<span class='badge-status bg-danger'>RUSAK BERAT</span>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr><td colspan="5" style="text-align:center;">Gagal mengambil data server.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div style="text-align:center; margin-top:30px; color:#888; font-size:0.9rem;">
            &copy; 2025 Inventory Laboratorium System. Universitas Indonesia.
        </div>
    </div>

    <script>
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("catalogTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0]; // Kolom Nama Alat
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    }
    </script>

</body>
</html>