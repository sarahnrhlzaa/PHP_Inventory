<?php
// pages/students/edit.php

require_once __DIR__ . '/../../api/ApiService.php';

$error = '';
$student = null;

// Get student ID
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Get student data
$response = StudentService::getById($id);
if ($response['status'] == 200) {
    $student = extractData($response);
} else {
    header("Location: index.php?error=Data tidak ditemukan");
    exit();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'nim' => $_POST['nim'],
        'name' => $_POST['name'],
        'studyProgram' => $_POST['studyProgram'],
        'phone' => $_POST['phone']
    ];
    
    $updateResponse = StudentService::update($id, $data);
    
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
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil"></i> Edit Data Mahasiswa
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
                                   value="<?= htmlspecialchars($student['id']) ?>" disabled>
                            <small class="text-muted">ID tidak dapat diubah</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim" class="form-control" 
                                   value="<?= htmlspecialchars($student['nim']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?= htmlspecialchars($student['name']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                            <input type="text" name="studyProgram" class="form-control" 
                                   value="<?= htmlspecialchars($student['studyProgram']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control" 
                                   value="<?= htmlspecialchars($student['phone'] ?? '') ?>">
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