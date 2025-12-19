<?php
// pages/transactions/return.php

require_once __DIR__ . '/../../api/ApiService.php';

$error = '';
$success = '';
$equipments = [];
$students = [];
$users = [];

// Get data for dropdowns
$equipmentsResponse = EquipmentService::getAll();
if ($equipmentsResponse['status'] == 200) {
    $equipments = extractData($equipmentsResponse);
    if (!is_array($equipments)) $equipments = [];
}

$studentsResponse = StudentService::getAll();
if ($studentsResponse['status'] == 200) {
    $students = extractData($studentsResponse);
    if (!is_array($students)) $students = [];
}

$usersResponse = UserService::getAll();
if ($usersResponse['status'] == 200) {
    $users = extractData($usersResponse);
    if (!is_array($users)) $users = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'id' => $_POST['id'],
        'equipmentId' => $_POST['equipmentId'],
        'transactionType' => 'IN',
        'quantity' => (int)$_POST['quantity'],
        'transactionDate' => date('Y-m-d\TH:i:s'),
        'handledBy' => $_POST['handledBy'],
        'usedBy' => $_POST['usedBy'],
        'note' => $_POST['note']
    ];
    
    $response = TransactionService::create($data);
    
    if ($response['status'] == 201) {
        $success = 'Pengembalian berhasil dicatat!';
    } else {
        $error = $response['data']['message'] ?? 'Gagal mencatat pengembalian';
    }
}
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-box-arrow-in-left"></i> Pengembalian Alat
                    </h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= htmlspecialchars($success) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">ID Transaksi <span class="text-danger">*</span></label>
                            <input type="text" name="id" class="form-control" 
                                   placeholder="TRX<?= date('Ymd') ?>001" required>
                            <small class="text-muted">Format: TRX20250119001</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Alat <span class="text-danger">*</span></label>
                            <select name="equipmentId" class="form-select" required>
                                <option value="">-- Pilih Alat --</option>
                                <?php foreach ($equipments as $eq): ?>
                                    <option value="<?= $eq['id'] ?>">
                                        <?= htmlspecialchars($eq['equipmentName']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control" 
                                   min="1" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Mahasiswa <span class="text-danger">*</span></label>
                            <select name="usedBy" class="form-select" required>
                                <option value="">-- Pilih Mahasiswa --</option>
                                <?php foreach ($students as $student): ?>
                                    <option value="<?= $student['id'] ?>">
                                        <?= htmlspecialchars($student['nim']) ?> - <?= htmlspecialchars($student['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Ditangani Oleh <span class="text-danger">*</span></label>
                            <select name="handledBy" class="form-select" required>
                                <option value="">-- Pilih Petugas --</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>">
                                        <?= htmlspecialchars($user['name']) ?> (<?= $user['role'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="note" class="form-control" rows="3"
                                      placeholder="Kondisi alat saat dikembalikan..."></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-info text-white">
                                <i class="bi bi-save"></i> Proses Pengembalian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>