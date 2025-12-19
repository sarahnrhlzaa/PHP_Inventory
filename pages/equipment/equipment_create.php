<?php
// pages/equipment/create.php

require_once __DIR__ . '/../../api/ApiService.php';

$error = '';
$categories = [];

// Get categories for dropdown
$categoriesResponse = CategoryService::getAll();
if ($categoriesResponse['status'] == 200) {
    $categories = extractData($categoriesResponse);
    if (!is_array($categories)) $categories = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'id' => $_POST['id'],
        'equipmentName' => $_POST['equipmentName'],
        'categoryId' => $_POST['categoryId'],
        'totalQuantity' => (int)$_POST['totalQuantity'],
        'availableQuantity' => (int)$_POST['availableQuantity'],
        'conditionStatus' => $_POST['conditionStatus'],
        'location' => $_POST['location'],
        'purchaseDate' => $_POST['purchaseDate'],
        'purchasePrice' => (float)$_POST['purchasePrice']
    ];
    
    $response = EquipmentService::create($data);
    
    if ($response['status'] == 201) {
        header("Location: index.php?success=Data berhasil ditambahkan");
        exit();
    } else {
        $error = $response['data']['message'] ?? 'Gagal menambahkan data';
    }
}
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-box-seam"></i> Tambah Alat Laboratorium
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">ID <span class="text-danger">*</span></label>
                                    <input type="text" name="id" class="form-control" 
                                           placeholder="EQP001" required>
                                    <small class="text-muted">Format: EQP001, EQP002, dst</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select name="categoryId" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat['id'] ?>">
                                                <?= htmlspecialchars($cat['categoryName']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Alat <span class="text-danger">*</span></label>
                            <input type="text" name="equipmentName" class="form-control" 
                                   placeholder="Mikroskop Binokuler" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Total Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="totalQuantity" class="form-control" 
                                           min="0" value="0" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Quantity Tersedia <span class="text-danger">*</span></label>
                                    <input type="number" name="availableQuantity" class="form-control" 
                                           min="0" value="0" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                                    <select name="conditionStatus" class="form-select" required>
                                        <option value="BAIK">Baik</option>
                                        <option value="RUSAK_RINGAN">Rusak Ringan</option>
                                        <option value="RUSAK_BERAT">Rusak Berat</option>
                                        <option value="DALAM_PERBAIKAN">Dalam Perbaikan</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="location" class="form-control" 
                                           placeholder="Lab Biologi Lt.2">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pembelian</label>
                                    <input type="date" name="purchaseDate" class="form-control">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Harga Pembelian</label>
                                    <input type="number" name="purchasePrice" class="form-control" 
                                           min="0" step="0.01" placeholder="15000000">
                                </div>
                            </div>
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