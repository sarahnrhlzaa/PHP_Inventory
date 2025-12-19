<?php
// pages/categories/edit.php

require_once __DIR__ . '/../../api/ApiService.php';

$error = '';
$category = null;

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Get category data
$response = CategoryService::getById($id);
if ($response['status'] == 200) {
    $category = extractData($response);
} else {
    header("Location: index.php?error=Data tidak ditemukan");
    exit();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'categoryName' => $_POST['categoryName'],
        'description' => $_POST['description']
    ];
    
    $updateResponse = CategoryService::update($id, $data);
    
    if ($updateResponse['status'] == 200) {
        header("Location: index.php?success=Kategori berhasil diperbarui");
        exit();
    } else {
        $error = $updateResponse['data']['message'] ?? 'Gagal memperbarui kategori';
    }
}
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil"></i> Edit Kategori
                    </h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">ID</label>
                            <input type="text" class="form-control" 
                                   value="<?= htmlspecialchars($category['id']) ?>" disabled>
                            <small class="text-muted">ID tidak dapat diubah</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="categoryName" class="form-control" 
                                   value="<?= htmlspecialchars($category['categoryName']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>