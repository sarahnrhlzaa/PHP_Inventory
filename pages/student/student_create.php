<?php
// pages/students/create.php

require_once __DIR__ . '/../../api/ApiService.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'id' => $_POST['id'],
        'nim' => $_POST['nim'],
        'name' => $_POST['name'],
        'studyProgram' => $_POST['studyProgram'],
        'phone' => $_POST['phone']
    ];
    
    $response = StudentService::create($data);
    
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
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-person-plus"></i> Tambah Mahasiswa Baru
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
                                   placeholder="STD001" required>
                            <small class="text-muted">Format: STD001, STD002, dst</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim" class="form-control" 
                                   placeholder="2021110001" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" 
                                   placeholder="Nama lengkap mahasiswa" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                            <input type="text" name="studyProgram" class="form-control" 
                                   placeholder="Teknik Kimia, Biologi, dll" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control" 
                                   placeholder="081234567890">
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
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