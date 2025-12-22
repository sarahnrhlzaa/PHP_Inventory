<?php require_once '../../includes/header.php'; 

// Ambil data condition logs
$logs = callAPI('GET', '/condition-logs');

// Ambil semua equipment untuk mapping ID ke Nama
$equipments = callAPI('GET', '/equipments');
$equipMap = [];
if(isset($equipments['data'])) {
    foreach($equipments['data'] as $eq) {
        $equipMap[$eq['id']] = $eq['equipmentName'];
    }
}

// Ambil semua users untuk mapping ID ke Nama
$users = callAPI('GET', '/users');
$userMap = [];
if(isset($users['data'])) {
    foreach($users['data'] as $usr) {
        $userMap[$usr['id']] = $usr['name'];
    }
}
?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h3>Condition Log (Quality Control)</h3>
        <div>
            <input type="text" id="searchInput" placeholder="🔍 Search equipment..." 
                   style="padding:8px 12px; border:1px solid #ddd; border-radius:5px; margin-right:10px;"
                   onkeyup="searchTable()">
            <a href="add.php" class="btn btn-danger">+ Report Damage</a>
        </div>
    </div>
    
    <div style="overflow-x:auto;">
        <table id="logTable">
            <thead>
                <tr>
                    <th>Log ID</th>
                    <th>Equipment Name</th>
                    <th>Condition Before</th>
                    <th>Condition After</th>
                    <th>Check Date</th>
                    <th>Checked By</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($logs['data'])): 
                    // Reverse untuk tampilkan yang terbaru dulu
                    $reversedLogs = array_reverse($logs['data']);
                    foreach($reversedLogs as $l): 
                        // Ambil nama dari mapping
                        $equipmentName = isset($equipMap[$l['equipmentId']]) ? $equipMap[$l['equipmentId']] : $l['equipmentId'];
                        $checkerName = isset($userMap[$l['checkedBy']]) ? $userMap[$l['checkedBy']] : $l['checkedBy'];
                ?>
                <tr>
                    <td style="font-family:monospace; color:#666;"><?= $l['id'] ?></td>
                    <td style="font-weight:600; color:#333;">
                        <?= htmlspecialchars($equipmentName) ?>
                        <br><small style="color:#999; font-weight:normal;">ID: <?= $l['equipmentId'] ?></small>
                    </td>
                    <td>
                        <span class="badge-status 
                            <?= $l['previousCondition'] == 'BAIK' ? 'bg-success' : 
                                ($l['previousCondition'] == 'RUSAK_RINGAN' ? 'bg-warning' : 'bg-danger') ?>">
                            <?= str_replace('_', ' ', $l['previousCondition']) ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge-status 
                            <?= $l['currentCondition'] == 'BAIK' ? 'bg-success' : 
                                ($l['currentCondition'] == 'RUSAK_RINGAN' ? 'bg-warning' : 'bg-danger') ?>">
                            <?= str_replace('_', ' ', $l['currentCondition']) ?>
                        </span>
                    </td>
                    <td><?= date('d M Y H:i', strtotime($l['checkDate'])) ?></td>
                    <td style="color:#555;">
                        <strong><?= htmlspecialchars($checkerName) ?></strong>
                        <br><small style="color:#999;">ID: <?= $l['checkedBy'] ?></small>
                    </td>
                    <td><?= htmlspecialchars($l['note']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $l['id'] ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="8" style="text-align:center; padding:30px; color:#999;">
                        No condition logs found.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("logTable");
    tr = table.getElementsByTagName("tr");
    
    for (i = 1; i < tr.length; i++) { // Start from 1 to skip header
        td = tr[i].getElementsByTagName("td")[1]; // Equipment Name column
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

<?php require_once '../../includes/footer.php'; ?>