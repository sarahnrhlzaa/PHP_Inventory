<?php require_once '../../includes/header.php'; 

// Ambil data transactions
$transactions = callAPI('GET', '/transactions');

// Ambil mapping data untuk convert ID ke Nama
$equipments = callAPI('GET', '/equipments');
$equipMap = [];
if(isset($equipments['data'])) {
    foreach($equipments['data'] as $eq) {
        $equipMap[$eq['id']] = [
            'name' => $eq['equipmentName'],
            'category' => $eq['categoryId']
        ];
    }
}

$users = callAPI('GET', '/users');
$userMap = [];
if(isset($users['data'])) {
    foreach($users['data'] as $usr) {
        $userMap[$usr['id']] = [
            'name' => $usr['name'],
            'role' => $usr['role']
        ];
    }
}

$students = callAPI('GET', '/students');
$studentMap = [];
if(isset($students['data'])) {
    foreach($students['data'] as $std) {
        $studentMap[$std['id']] = [
            'name' => $std['name'],
            'nim' => $std['nim']
        ];
    }
}
?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h3>Transaction History</h3>
        <div>
            <input type="text" id="searchInput" placeholder="🔍 Search equipment or student..." 
                   style="padding:8px 12px; border:1px solid #ddd; border-radius:5px; margin-right:10px;"
                   onkeyup="searchTable()">
            <a href="add.php" class="btn btn-success">+ New Transaction</a>
        </div>
    </div>
    
    <div style="overflow-x:auto; margin-top:15px;">
        <table id="transactionTable">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Equipment</th>
                    <th>Quantity</th>
                    <th>Handled By</th>
                    <th>Used By (Student)</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($transactions['data'])): 
                    // Reverse untuk tampilkan transaksi terbaru dulu
                    $reversedTrx = array_reverse($transactions['data']);
                    foreach($reversedTrx as $trx): 
                        // Get names from mapping
                        $equipmentName = isset($equipMap[$trx['equipmentId']]) ? $equipMap[$trx['equipmentId']]['name'] : $trx['equipmentId'];
                        $categoryName = isset($equipMap[$trx['equipmentId']]) ? $equipMap[$trx['equipmentId']]['category'] : '-';
                        $handlerName = isset($userMap[$trx['handledBy']]) ? $userMap[$trx['handledBy']]['name'] : $trx['handledBy'];
                        $handlerRole = isset($userMap[$trx['handledBy']]) ? $userMap[$trx['handledBy']]['role'] : '-';
                        
                        $studentName = '-';
                        $studentNim = '-';
                        if($trx['usedBy']) {
                            $studentName = isset($studentMap[$trx['usedBy']]) ? $studentMap[$trx['usedBy']]['name'] : $trx['usedBy'];
                            $studentNim = isset($studentMap[$trx['usedBy']]) ? $studentMap[$trx['usedBy']]['nim'] : '-';
                        }
                ?>
                <tr>
                    <td style="font-family:monospace; color:#666; font-size:0.9rem;">
                        <?= $trx['id'] ?>
                    </td>
                    <td>
                        <?php if($trx['transactionType'] == 'OUT'): ?>
                            <span class="badge-status bg-danger" style="min-width:50px;">
                                <i class="fas fa-arrow-up"></i> OUT
                            </span>
                        <?php else: ?>
                            <span class="badge-status bg-success" style="min-width:50px;">
                                <i class="fas fa-arrow-down"></i> IN
                            </span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:0.9rem;">
                        <?= date('d M Y', strtotime($trx['transactionDate'])) ?>
                        <br>
                        <small style="color:#999;"><?= date('H:i', strtotime($trx['transactionDate'])) ?></small>
                    </td>
                    <td style="font-weight:600; color:#333;">
                        <?= htmlspecialchars($equipmentName) ?>
                        <br>
                        <small style="color:#999; font-weight:normal;">
                            <?= $categoryName ?> • ID: <?= $trx['equipmentId'] ?>
                        </small>
                    </td>
                    <td style="text-align:center; font-weight:600; font-size:1.1rem;">
                        <?= $trx['quantity'] ?>
                    </td>
                    <td style="color:#555;">
                        <strong><?= htmlspecialchars($handlerName) ?></strong>
                        <br>
                        <small style="color:#999;">
                            <span style="background:#f0f0f0; padding:2px 6px; border-radius:3px; font-size:0.75rem;">
                                <?= $handlerRole ?>
                            </span>
                        </small>
                    </td>
                    <td>
                        <?php if($trx['usedBy']): ?>
                            <strong style="color:#333;"><?= htmlspecialchars($studentName) ?></strong>
                            <br>
                            <small style="color:#999;">NIM: <?= $studentNim ?></small>
                        <?php else: ?>
                            <span style="color:#999;">-</span>
                        <?php endif; ?>
                    </td>
                    <td style="max-width:200px; font-size:0.9rem; color:#666;">
                        <?= htmlspecialchars($trx['note'] ?? '-') ?>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="8" style="text-align:center; padding:30px; color:#999;">
                        No transaction history found.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function searchTable() {
    var input, filter, table, tr, td1, td4, td7, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("transactionTable");
    tr = table.getElementsByTagName("tr");
    
    for (i = 1; i < tr.length; i++) { // Start from 1 to skip header
        td4 = tr[i].getElementsByTagName("td")[3]; // Equipment column
        td7 = tr[i].getElementsByTagName("td")[6]; // Student column
        
        if (td4 || td7) {
            txtValue = (td4 ? td4.textContent : '') + ' ' + (td7 ? td7.textContent : '');
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>

<?php require_once '../../includes/footer.php'; ?>