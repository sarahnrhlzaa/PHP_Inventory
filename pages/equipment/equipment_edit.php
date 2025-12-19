<?php
// pages/equipment/edit.php

require_once __DIR__ . '/../../api/ApiService.php';

$error = '';
$equipment = null;
$categories = [];

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Get equipment data
$response = EquipmentService::getById($id);
if ($response['status'] == 200) {
    $equipment = extractData($response);
} else {
    header("Location: index.php?error=Data tidak ditemukan");
    exit();
}

// Get categories
$categoriesResponse = CategoryService::getAll();
if ($categoriesResponse['status'] == 200) {
    $categories = extractData($categoriesResponse);
    if (!is_array($categories)) $categories = [];
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'equipmentName' => $_POST['equipmentName'],
        'categoryId' => $_POST['categoryId'],
        'totalQuantity' => (int)$_POST['totalQuantity'],
        'availableQuantity' => (int)$_POST['availableQuantity'],
        'conditionStatus' => $_POST['conditionStatus'],
        'location' => $_POST['location'],
        'purchaseDate' => $_POST['purchaseDate'],
        'purchasePrice' => (float)$_POST['purchasePrice']
    ];
    
    $updateResponse = EquipmentService::update($id, $data);
    
    if ($updateResponse['status'] == 200) {
        header("Location: index.php?success=Data berhasil diperbarui");
        exit();
    } else {
        $error = $updateResponse['data']['message'] ?? 'Gagal memperbarui data';
    }
}
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil"></i> Edit Alat Laboratorium
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
                                    <label class="form-label">ID</label>
                                    <input type="text" class="form-control" 
                                           value="<?= htmlspecialchars($equipment['id']) ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select name="categoryId" class="form-select" required>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat['id'] ?>"
                                                <?= $equipment['categoryId'] == $cat['id'] ? 'selected' : '' ?>>
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
                                   value="<?= htmlspecialchars($equipment['equipmentName']) ?>" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Total Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="totalQuantity" class="form-control" 
                                           value="<?= $equipment['totalQuantity'] ?>" min="0" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Quantity Tersedia <span class="text-danger">*</span></label>
                                    <input type="number" name="availableQuantity" class="form-control" 
                                           value="<?= $equipment['availableQuantity'] ?>" min="0" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                                    <select name="conditionStatus" class="form-select" required>
                                        <option value="BAIK" <?= $equipment['conditionStatus'] == 'BAIK' ? 'selected' : '' ?>>Baik</option>
                                        <option value="RUSAK_RINGAN" <?= $equipment['conditionStatus'] == 'RUSAK_RINGAN' ? 'selected' : '' ?>>Rusak Ringan</option>
                                        <option value="RUSAK_BERAT" <?= $equipment['conditionStatus'] == 'RUSAK_BERAT' ? 'selected' : '' ?>>Rusak Berat</option>
                                        <option value="DALAM_PERBAIKAN" <?= $equipment['conditionStatus'] == 'DALAM_PERBAIKAN' ? 'selected' : '' ?>>Dalam Perbaikan</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="location" class="form-control" 
                                           value="<?= htmlspecialchars($equipment['location'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pembelian</label>
                                    <input type="date" name="purchaseDate" class="form-control"
                                           value="<?= $equipment['purchaseDate'] ?? '' ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Harga Pembelian</label>
                                    <input type="number" name="purchasePrice" class="form-control" 
                                           value="<?= $equipment['purchasePrice'] ?? '' ?>" min="0" step="0.01">
                                </div>
                            </div>
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