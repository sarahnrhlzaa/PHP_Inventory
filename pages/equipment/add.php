<?php require_once '../../includes/header.php'; 
$cats = callAPI('GET', '/categories');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = [
        'id' => $_POST['id'],
        'equipmentName' => $_POST['name'],
        'categoryId' => $_POST['cat'],
        'totalQuantity' => (int)$_POST['qty'],
        'availableQuantity' => (int)$_POST['qty'],
        'conditionStatus' => 'BAIK',
        'location' => $_POST['loc']
    ];
    $resp = callAPI('POST', '/equipments', $data);
    if(isset($resp['success']) && $resp['success']) echo "<script>alert('Success');window.location='index.php';</script>";
}
?>
<div class="card">
    <h3>Add Equipment</h3>
    <form method="POST">
        <div class="form-group"><label>ID</label><input type="text" name="id" class="form-control" required></div>
        <div class="form-group"><label>Name</label><input type="text" name="name" class="form-control" required></div>
        <div class="form-group">
            <label>Category</label>
            <select name="cat" class="form-control">
                <?php foreach($cats['data'] as $c): ?><option value="<?=$c['id']?>"><?=$c['categoryName']?></option><?php endforeach; ?>
            </select>
        </div>
        <div class="form-group"><label>Total Qty</label><input type="number" name="qty" class="form-control" required></div>
        <div class="form-group"><label>Location</label><input type="text" name="loc" class="form-control" required></div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
<?php require_once '../../includes/footer.php'; ?>