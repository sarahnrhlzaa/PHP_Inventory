<?php
// pages/users/edit.php

require_once __DIR__ . '/../../api/ApiService.php';

$error = '';
$user = null;

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Get user data
$response = UserService::getById($id);
if ($response['status'] == 200) {
    $user = extractData($response);
} else {
    header("Location: index.php?error=Data tidak ditemukan");
    exit();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'role' => $_POST['role']
    ];
    
    // Only update password if provided
    if (!empty($_POST['password'])) {
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }
    
    $updateResponse = UserService::update($id, $data);
    
    if ($updateResponse['status'] == 200) {
        header("Location: index.php?success=User berhasil diperbarui");
        exit();
    } else {
        $error = $updateResponse['data']['message'] ?? 'Gagal memperbarui user';
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
                        <i class="bi bi-pencil"></i> Edit User
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
                                   value="<?= htmlspecialchars($user['id']) ?>" disabled>
                            <small class="text-muted">ID tidak dapat diubah</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select" required>
                                <option value="ADMIN" <?= $user['role'] == 'ADMIN' ? 'selected' : '' ?>>Admin</option>
                                <option value="PETUGAS" <?= $user['role'] == 'PETUGAS' ? 'selected' : '' ?>>Petugas</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" 
                                   value="<?= htmlspecialchars($user['name']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" 
                                   value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" 
                                   placeholder="Kosongkan jika tidak ingin mengubah password" minlength="6">
                            <small class="text-muted">Minimal 6 karakter</small>
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