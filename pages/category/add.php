<?php 
require_once '../../includes/header.php'; 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = [
        'id' => $_POST['id'],
        'categoryName' => $_POST['categoryName'],
        'description' => $_POST['description']
    ];

    // Panggil API POST /categories
    $resp = callAPI('POST', '/categories', $data);

    if(isset($resp['success']) && $resp['success']) {
        echo "<script>alert('Category successfully added!'); window.location='index.php';</script>";
    } else {
        $msg = $resp['message'] ?? 'Failed to save data.';
        echo "<script>alert('Error: " . $msg . "');</script>";
    }
}
?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3>Add New Category</h3>
        <a href="index.php" class="btn btn-danger">Back</a>
    </div>

    <form method="POST">
        <div class="form-group">
            <label>ID Category</label>
            <input type="text" name="id" class="form-control" placeholder="Contoh: CAT001" required>
        </div>
        <div class="form-group">
            <label>Category Name</label>
            <input type="text" name="categoryName" class="form-control" placeholder="Contoh: Alat Gelas" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" placeholder="Penjelasan singkat kategori..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<?php require_once '../../includes/footer.php'; ?>