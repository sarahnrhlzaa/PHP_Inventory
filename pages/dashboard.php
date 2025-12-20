<?php 
require_once '../includes/header.php'; 
$eq = callAPI('GET', '/equipments');
$trx = callAPI('GET', '/transactions');
$std = callAPI('GET', '/students');
?>

<style>
    /* Style untuk Banner Selamat Datang */
    .welcome-banner {
        background: linear-gradient(135deg, var(--primary-color), #3a86ff); /* Gradient Biru Keren */
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 20px -10px rgba(67, 97, 238, 0.5); /* Bayangan Biru Halus */
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .welcome-text h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    .welcome-text p {
        margin: 5px 0 0 0;
        opacity: 0.9;
        font-size: 1rem;
        font-weight: 400;
    }

    /* Hiasan Icon di Kanan Transparan */
    .welcome-icon {
        font-size: 5rem;
        opacity: 0.15;
        position: absolute;
        right: 20px;
        bottom: -10px;
        transform: rotate(-10deg);
    }

    /* Custom Style untuk Dashboard Card */
    .dash-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        border: 1px solid #edf2f7;
        transition: transform 0.2s;
    }
    .dash-card:hover { transform: translateY(-5px); }
    
    .dash-body {
        padding: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .dash-info h4 { margin: 0; font-size: 0.9rem; color: #64748b; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }
    .dash-info h1 { margin: 5px 0 0 0; font-size: 2.5rem; font-weight: 700; color: #333; }
    
    .dash-icon {
        width: 60px; height: 60px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem;
    }

    /* Warna Spesifik per Kartu */
    .card-blue .dash-icon { background: rgba(67, 97, 238, 0.1); color: #4361ee; }
    .card-blue .dash-footer { background: #4361ee; }

    .card-green .dash-icon { background: rgba(46, 196, 182, 0.1); color: #2ec4b6; }
    .card-green .dash-footer { background: #2ec4b6; }

    .card-orange .dash-icon { background: rgba(255, 159, 28, 0.1); color: #ff9f1c; }
    .card-orange .dash-footer { background: #ff9f1c; }

    .dash-footer {
        padding: 12px;
        text-align: center;
        color: white;
        font-weight: 500;
        font-size: 0.85rem;
        display: flex; justify-content: center; align-items: center; gap: 8px;
    }
    .dash-footer:hover { filter: brightness(90%); }
</style>

<div class="welcome-banner">
    <div class="welcome-text">
        <h1>Hello, <?= $_SESSION['user_name'] ?>! 👋</h1>
        <p>Welcome back to the Inventory System. Have a productive day!</p>
    </div>
    <div class="welcome-icon">
        <i class="fas fa-microscope"></i>
    </div>
</div>

<h3 style="margin-bottom: 20px; color: var(--text-dark); font-weight: 600; padding-left: 5px; border-left: 5px solid var(--warning-color); line-height: 1;">
    &nbsp;Dashboard Overview
</h3>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
    
    <div class="dash-card card-blue">
        <div class="dash-body">
            <div class="dash-info">
                <h4>Total Equipment</h4>
                <h1><?= isset($eq['data']) ? count($eq['data']) : 0 ?></h1>
            </div>
            <div class="dash-icon"><i class="fas fa-microscope"></i></div>
        </div>
        <a href="equipment/index.php" class="dash-footer">
            View Details <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="dash-card card-green">
        <div class="dash-body">
            <div class="dash-info">
                <h4>Transactions</h4>
                <h1><?= isset($trx['data']) ? count($trx['data']) : 0 ?></h1>
            </div>
            <div class="dash-icon"><i class="fas fa-exchange-alt"></i></div>
        </div>
        <a href="transaction/index.php" class="dash-footer">
            View History <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="dash-card card-orange">
        <div class="dash-body">
            <div class="dash-info">
                <h4>Active Students</h4>
                <h1><?= isset($std['data']) ? count($std['data']) : 0 ?></h1>
            </div>
            <div class="dash-icon"><i class="fas fa-user-graduate"></i></div>
        </div>
        <a href="student/index.php" class="dash-footer">
            Manage Students <i class="fas fa-arrow-right"></i>
        </a>
    </div>

</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 25px; margin-top: 25px;">
    
    <div class="card" style="margin-bottom: 0;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; border-bottom:1px solid #eee; padding-bottom:10px;">
            <h4 style="margin:0; color:var(--dark-color); font-weight:600;">Recent Activity</h4>
            <a href="transaction/index.php" style="font-size:0.85rem; color:var(--primary-color);">View All</a>
        </div>
        
        <table style="margin-top:0;">
            <thead>
                <tr>
                    <th style="padding:10px; font-size:0.85rem;">Status</th>
                    <th style="padding:10px; font-size:0.85rem;">Item</th>
                    <th style="padding:10px; font-size:0.85rem;">User</th>
                    <th style="padding:10px; font-size:0.85rem;">Time</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Ambil 5 transaksi terakhir
                $recentTrx = isset($trx['data']) ? array_slice(array_reverse($trx['data']), 0, 5) : [];
                if(count($recentTrx) > 0):
                    foreach($recentTrx as $row): 
                ?>
                <tr>
                    <td style="padding:10px;">
                        <?php if($row['transactionType'] == 'IN'): ?>
                            <span class="badge-status bg-success" style="min-width:50px; padding:4px 10px; font-size:0.7em;">IN</span>
                        <?php else: ?>
                            <span class="badge-status bg-danger" style="min-width:50px; padding:4px 10px; font-size:0.7em;">OUT</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding:10px; font-size:0.9rem; font-weight:500; color:#555;">
                        <?= $row['equipmentId'] ?>
                    </td>
                    <td style="padding:10px; font-size:0.9rem; color:#666;">
                        <?= $row['usedBy'] ?? 'Admin' ?>
                    </td>
                    <td style="padding:10px; font-size:0.8rem; color:#999;">
                        <?= date('H:i', strtotime($row['transactionDate'])) ?>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="4" style="text-align:center; padding:20px; color:#999;">No recent activity.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="card" style="margin-bottom: 0;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; border-bottom:1px solid #eee; padding-bottom:10px;">
            <h4 style="margin:0; color:var(--danger-color); font-weight:600;">Needs Attention ⚠️</h4>
            <a href="equipment/index.php" style="font-size:0.85rem; color:var(--text-muted);">Check Inventory</a>
        </div>

        <div style="display:flex; flex-direction:column; gap:10px;">
            <?php 
            $alertCount = 0;
            if(isset($eq['data'])):
                foreach($eq['data'] as $item):
                    // Logic: Tampilkan jika Stok < 2 ATAU Kondisi Tidak Baik
                    if($item['availableQuantity'] < 2 || $item['conditionStatus'] != 'BAIK'):
                        $alertCount++;
                        if($alertCount > 5) break; // Batasi max 5 alert biar ga kepanjangan
            ?>
            
            <div style="display:flex; align-items:center; justify-content:space-between; padding:10px; background:#fff5f5; border-radius:8px; border-left:4px solid var(--danger-color);">
                <div>
                    <div style="font-weight:600; color:#333; font-size:0.9rem;"><?= $item['equipmentName'] ?></div>
                    <div style="font-size:0.8rem; color:#777;">ID: <?= $item['id'] ?></div>
                </div>
                
                <div style="text-align:right;">
                    <?php if($item['conditionStatus'] != 'BAIK'): ?>
                        <span style="font-size:0.75rem; color:var(--danger-color); font-weight:bold;">
                            <?= str_replace('_', ' ', $item['conditionStatus']) ?>
                        </span>
                    <?php elseif($item['availableQuantity'] == 0): ?>
                        <span style="font-size:0.75rem; color:var(--danger-color); font-weight:bold;">OUT OF STOCK</span>
                    <?php else: ?>
                        <span style="font-size:0.75rem; color:var(--warning-color); font-weight:bold;">Low Stock: <?= $item['availableQuantity'] ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <?php 
                    endif;
                endforeach;
            endif;
            
            if($alertCount == 0):
            ?>
            <div style="text-align:center; padding:30px; color:#2ecc71;">
                <i class="fas fa-check-circle" style="font-size:2rem; margin-bottom:10px;"></i><br>
                All equipment is safe & stocked!
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php require_once '../includes/footer.php'; ?>