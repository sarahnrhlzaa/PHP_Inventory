<?php require_once '../../includes/header.php'; 
$id = $_GET['id'];
$equip = callAPI('GET', '/equipments/'.$id);
$cats = callAPI('GET', '/categories');
$d = $equip['data'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = [
        'equipmentName' => $_POST['name'],
        'categoryId' => $_POST['cat'],
        'totalQuantity' => (int)$_POST['qty'],
        'availableQuantity' => (int)$_POST['avail'],
        'conditionStatus' => $_POST['status'],
        'location' => $_POST['loc']
    ];
    $resp = callAPI('PUT', '/equipments/'.$id, $data);
    if(isset($resp['success']) && $resp['success']) echo "<script>alert('Updated');window.location='index.php';</script>";
}
?>
<div class="card">
    <h3>Edit Equipment: <?= $d['equipmentName'] ?></h3>
    <form method="POST">
        <div class="form-group"><label>Name</label><input type="text" name="name" value="<?=$d['equipmentName']?>" class="form-control"></div>
        <div class="form-group"><label>Total Qty</label><input type="number" name="qty" value="<?=$d['totalQuantity']?>" class="form-control"></div>
        <div class="form-group"><label>Avail Qty</label><input type="number" name="avail" value="<?=$d['availableQuantity']?>" class="form-control"></div>
        <div class="form-group"><label>Category</label>
            <select name="cat" class="form-control">
                <?php foreach($cats['data'] as $c): ?>
                <option value="<?=$c['id']?>" <?= $c['id']==$d['categoryId']?'selected':''?>><?=$c['categoryName']?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group"><label>Status</label>
            <select name="status" class="form-control">
                <option value="BAIK" <?= $d['conditionStatus']=='BAIK'?'selected':''?>>BAIK</option>
                <option value="RUSAK_RINGAN" <?= $d['conditionStatus']=='RUSAK_RINGAN'?'selected':''?>>RUSAK RINGAN</option>
                <option value="RUSAK_BERAT" <?= $d['conditionStatus']=='RUSAK_BERAT'?'selected':''?>>RUSAK BERAT</option>
                <option value="DALAM_PERBAIKAN" <?= $d['conditionStatus']=='DALAM_PERBAIKAN'?'selected':''?>>DALAM PERBAIKAN</option>
            </select>
        </div>
        <div class="form-group"><label>Location</label><input type="text" name="loc" value="<?=$d['location']?>" class="form-control"></div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
<?php require_once '../../includes/footer.php'; ?>