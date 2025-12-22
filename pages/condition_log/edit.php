<?php require_once '../../includes/header.php'; 

$id = $_GET['id'] ?? null;
if(!$id) {
    echo "<script>alert('ID not found'); window.location='index.php';</script>";
    exit;
}

// Ambil data log yang mau di-edit
$log = callAPI('GET', '/condition-logs/'.$id);
$logData = $log['data'] ?? null;

if(!$logData) {
    echo "<script>alert('Log not found'); window.location='index.php';</script>";
    exit;
}

// Ambil list equipment
$equipments = callAPI('GET', '/equipments');

// Ambil list users
$users = callAPI('GET', '/users');

// Handle UPDATE
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updateData = [
        'equipmentId' => $_POST['equipmentId'],
        'previousCondition' => $_POST['prev'],
        'currentCondition' => $_POST['curr'],
        'checkDate' => $_POST['checkDate'],
        'checkedBy' => $_POST['checkedBy'],
        'note' => $_POST['note']
    ];
    
    $resp = callAPI('PUT', '/condition-logs/'.$id, $updateData);
    
    if(isset($resp['status']) && ($resp['status'] == 200 || $resp['status'] == 201)) {
        echo "<script>alert('Log updated successfully!'); window.location='index.php';</script>";
        exit;
    } else {
        $error = $resp['data']['message'] ?? 'Failed to update log';
        echo "<script>alert('Error: $error');</script>";
    }
}
?>

<div class="card">
    <h3>Edit Condition Log: <?= $logData['id'] ?></h3>
    
    <form method="POST">
        <div class="form-group">
            <label>Equipment</label>
            <select name="equipmentId" class="form-control" required>
                <?php if(isset($equipments['data'])): 
                    foreach($equipments['data'] as $e): ?>
                    <option value="<?= $e['id'] ?>" <?= $e['id'] == $logData['equipmentId'] ? 'selected' : '' ?>>
                        <?= $e['equipmentName'] ?> (<?= $e['conditionStatus'] ?>)
                    </option>
                <?php endforeach; endif; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Previous Condition</label>
            <select name="prev" class="form-control" required>
                <option value="BAIK" <?= $logData['previousCondition'] == 'BAIK' ? 'selected' : '' ?>>BAIK</option>
                <option value="RUSAK_RINGAN" <?= $logData['previousCondition'] == 'RUSAK_RINGAN' ? 'selected' : '' ?>>RUSAK RINGAN</option>
                <option value="RUSAK_BERAT" <?= $logData['previousCondition'] == 'RUSAK_BERAT' ? 'selected' : '' ?>>RUSAK BERAT</option>
                <option value="DALAM_PERBAIKAN" <?= $logData['previousCondition'] == 'DALAM_PERBAIKAN' ? 'selected' : '' ?>>DALAM PERBAIKAN</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Current Condition</label>
            <select name="curr" class="form-control" required>
                <option value="BAIK" <?= $logData['currentCondition'] == 'BAIK' ? 'selected' : '' ?>>BAIK</option>
                <option value="RUSAK_RINGAN" <?= $logData['currentCondition'] == 'RUSAK_RINGAN' ? 'selected' : '' ?>>RUSAK RINGAN</option>
                <option value="RUSAK_BERAT" <?= $logData['currentCondition'] == 'RUSAK_BERAT' ? 'selected' : '' ?>>RUSAK BERAT</option>
                <option value="DALAM_PERBAIKAN" <?= $logData['currentCondition'] == 'DALAM_PERBAIKAN' ? 'selected' : '' ?>>DALAM PERBAIKAN</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Check Date</label>
            <input type="datetime-local" name="checkDate" class="form-control" 
                   value="<?= date('Y-m-d\TH:i', strtotime($logData['checkDate'])) ?>" required>
        </div>
        
        <div class="form-group">
            <label>Checked By</label>
            <select name="checkedBy" class="form-control" required>
                <?php if(isset($users['data'])): 
                    foreach($users['data'] as $u): ?>
                    <option value="<?= $u['id'] ?>" <?= $u['id'] == $logData['checkedBy'] ? 'selected' : '' ?>>
                        <?= $u['name'] ?> (<?= $u['role'] ?>)
                    </option>
                <?php endforeach; endif; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Note</label>
            <textarea name="note" class="form-control" rows="3"><?= htmlspecialchars($logData['note']) ?></textarea>
        </div>
        
        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Log
            </button>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
</div>

<?php require_once '../../includes/footer.php'; ?>