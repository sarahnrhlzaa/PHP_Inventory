<?php require_once '../../includes/header.php'; 
$data = callAPI('GET', '/equipments');
?>
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h3>Equipment List</h3>
        <a href="add.php" class="btn btn-primary">+ Add Equipment</a>
    </div>
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Stock</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
            <?php if(isset($data['data'])): foreach($data['data'] as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td style="font-weight: bold;"><?= $row['equipmentName'] ?></td>
                <td><?= $row['categoryId'] ?></td>
                <td><?= $row['availableQuantity'] ?> / <?= $row['totalQuantity'] ?></td>
                <td><?= $row['conditionStatus'] ?></td>
                <td><a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">Edit</a></td>
            </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../includes/footer.php'; ?>