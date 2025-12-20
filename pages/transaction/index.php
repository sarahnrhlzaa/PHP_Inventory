<?php require_once '../../includes/header.php'; 
$trx = callAPI('GET', '/transactions');
?>
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h3>Transaction History</h3>
        <a href="add.php" class="btn btn-primary">+ New Transaction</a>
    </div>
    <table>
        <thead><tr><th>ID</th><th>Type</th><th>Equipment</th><th>Borrower</th><th>Date</th></tr></thead>
        <tbody>
            <?php if(isset($trx['data'])): ?>
            <?php foreach(array_reverse($trx['data']) as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><span class="badge-role" style="background:<?= $row['transactionType']=='IN'?'#2ecc71':'#e74c3c'?>; color:white;"><?= $row['transactionType'] ?></span></td>
                <td><?= $row['equipmentId'] ?></td>
                <td><?= $row['usedBy'] ?? '-' ?></td>
                <td><?= date('d M Y H:i', strtotime($row['transactionDate'])) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../includes/footer.php'; ?>