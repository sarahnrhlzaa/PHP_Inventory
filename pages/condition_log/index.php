<?php require_once '../../includes/header.php'; 
$logs = callAPI('GET', '/condition-logs');
?>
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h3>Condition Log (Quality Control)</h3>
        <a href="add.php" class="btn btn-danger">+ Report Damage</a>
    </div>
    <table>
        <thead><tr><th>ID</th><th>Equipment</th><th>Previous</th><th>Current</th><th>Staff</th><th>Note</th></tr></thead>
        <tbody>
            <?php if(isset($logs['data'])): foreach(array_reverse($logs['data']) as $l): ?>
            <tr>
                <td><?= $l['id'] ?></td>
                <td><?= $l['equipmentId'] ?></td>
                <td><?= $l['previousCondition'] ?></td>
                <td style="color:red;font-weight:bold"><?= $l['currentCondition'] ?></td>
                <td><?= $l['checkedBy'] ?></td>
                <td><?= $l['note'] ?></td>
            </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../includes/footer.php'; ?>