<?php
// pages/categories/create.php

require_once __DIR__ . '/../../api/ApiService.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'id' => $_POST['id'],
        'categoryName' => $_POST['categoryName'],
        'description' => $_POST['description']
    ];
    
    $response = CategoryService::create($data);
    
    if ($response['status'] == 201) {
        header("Location: index.php?success=Kategori berhasil ditambahkan");
        exit();
    } else {
        $error = $response['data']['message'] ?? 'Gagal menambahkan kategori';
    }
}
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-tags"></i> Tambah Kategori Baru
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
                            <label class="form-label">ID <span class="text-danger">*</span></label>
                            <input type="text" name="id" class="form-control" 
                                   placeholder="CAT001" required>
                            <small class="text-muted">Format: CAT001, CAT002, dst</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="categoryName" class="form-control" 
                                   placeholder="Alat Ukur" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3"
                                      placeholder="Deskripsi kategori..."></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>