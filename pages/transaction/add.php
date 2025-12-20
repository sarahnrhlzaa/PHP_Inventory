<?php require_once '../../includes/header.php'; 
$equips = callAPI('GET', '/equipments');
$students = callAPI('GET', '/students');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = [
        'id' => 'TRX'.date('ymdHis'),
        'equipmentId' => $_POST['equipmentId'],
        'transactionType' => $_POST['type'],
        'quantity' => (int)$_POST['qty'],
        'handledBy' => $_SESSION['user_id'],
        'usedBy' => $_POST['studentId'],
        'note' => $_POST['note']
    ];
    $resp = callAPI('POST', '/transactions', $data);
    if(isset($resp['success']) && $resp['success']) echo "<script>alert('Success!');window.location='index.php';</script>";
    else echo "<script>alert('Failed: ".($resp['message']??'Error')."');</script>";
}
?>
<div class="card">
    <h3>Input Transaction</h3>
    <form method="POST">
        <div class="form-group">
            <label>Type</label>
            <select name="type" class="form-control">
                <option value="OUT">OUT (Borrowing)</option>
                <option value="IN">IN (Returning)</option>
            </select>
        </div>
        <div class="form-group">
            <label>Equipment</label>
            <select name="equipmentId" class="form-control">
                <?php foreach($equips['data'] as $e): ?>
                <option value="<?= $e['id'] ?>"><?= $e['equipmentName'] ?> (Stock: <?=$e['availableQuantity']?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Students</label>
            <select name="studentId" class="form-control">
                <?php foreach($students['data'] as $s): ?>
                <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group"><label>Quantity</label><input type="number" name="qty" class="form-control" value="1"></div>
        <div class="form-group"><label>Notes</label><textarea name="note" class="form-control"></textarea></div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
<?php require_once '../../includes/footer.php'; ?>