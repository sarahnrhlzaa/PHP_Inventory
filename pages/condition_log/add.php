<?php require_once '../../includes/header.php'; 
$equips = callAPI('GET', '/equipments');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = [
        'id' => 'LOG' . date('Ymd') . rand(100, 999),
        'equipmentId' => $_POST['equipmentId'],
        'previousCondition' => $_POST['prev'],
        'currentCondition' => $_POST['curr'],
        'checkedBy' => $_SESSION['user_id'],
        'note' => $_POST['note']
    ];
    $resp = callAPI('POST', '/condition-logs', $data);
    if(isset($resp['status']) && $resp['status']) {
        echo "<script>alert('Log saved. Don't forget to update equipment status!');window.history.replaceState(null, null, 'index.php');</script>";
    }
}
?>
<div class="card">
    <h3>Report Condition Change</h3>
    <form method="POST">
        <div class="form-group"><label>Equipment</label>
            <select name="equipmentId" class="form-control">
                <?php foreach($equips['data'] as $e): ?>
                <option value="<?= $e['id'] ?>"><?= $e['equipmentName'] ?> (Status: <?= $e['conditionStatus'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group"><label>Previous Condition</label>
            <select name="prev" class="form-control">
                <option value="BAIK">BAIK</option>
                <option value="RUSAK_RINGAN">RUSAK RINGAN</option>
                <option value="RUSAK_BERAT">RUSAK BERAT</option>
                <option value="DALAM_PERBAIKAN">DALAM PERBAIKAN</option>
            </select>
        </div>
        <div class="form-group"><label>Current Condition</label>
            <select name="curr" class="form-control">
                <option value="RUSAK_RINGAN">RUSAK RINGAN</option>
                <option value="RUSAK_BERAT">RUSAK BERAT</option>
                <option value="DALAM_PERBAIKAN">DALAM PERBAIKAN</option>
                <option value="BAIK">BAIK (Sudah Diperbaiki)</option>
            </select>
        </div>
        <div class="form-group"><label>Damage Note</label><textarea name="note" class="form-control"></textarea></div>
        <button class="btn btn-danger">Save Log</button>
    </form>
</div>
<?php require_once '../../includes/footer.php'; ?>