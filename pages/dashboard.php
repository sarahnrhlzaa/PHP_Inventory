<?php 
require_once '../includes/header.php'; 
$eq = callAPI('GET', '/equipments');
$trx = callAPI('GET', '/transactions');
$std = callAPI('GET', '/students');
?>

<div class="greeting">
    <h2>Hello, <?= $_SESSION['user_name'] ?>!</h2><br>
</div>

<div class="card">
    <h2>Dashboard</h2>
    <div style="display:flex; gap:20px; margin-top:20px;">
        <div class="card" style="flex:1; background:#e3f2fd; border:1px solid #2196f3;">
            <h3>Total Equipment</h3>
            <h1><?= isset($eq['data']) ? count($eq['data']) : 0 ?></h1>
        </div>
        <div class="card" style="flex:1; background:#e8f5e9; border:1px solid #4caf50;">
            <h3>Transactions</h3>
            <h1><?= isset($trx['data']) ? count($trx['data']) : 0 ?></h1>
        </div>
        <div class="card" style="flex:1; background:#fff3e0; border:1px solid #ff9800;">
            <h3>Students</h3>
            <h1><?= isset($std['data']) ? count($std['data']) : 0 ?></h1>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>