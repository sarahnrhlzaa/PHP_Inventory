<?php
// pages/users/create.php

require_once __DIR__ . '/../../api/ApiService.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'role' => $_POST['role']
    ];
    
    $response = UserService::create($data);
    
    if ($response['status'] == 201) {
        header("Location: index.php?success=User berhasil ditambahkan");
        exit();
    } else {
        $error = $response['data']['message'] ?? 'Gagal menambahkan user';
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
                        <i class="bi bi-person-plus"></i> Tambah User Baru
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
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select" required id="roleSelect">
                                <option value="">-- Pilih Role --</option>
                                <option value="ADMIN">Admin</option>
                                <option value="PETUGAS">Petugas</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">ID <span class="text-danger">*</span></label>
                            <input type="text" name="id" class="form-control" 
                                   placeholder="ADM001 atau EMP001" required id="idInput">
                            <small class="text-muted" id="idHelp">
                                Admin: ADM001, ADM002, dst | Petugas: EMP001, EMP002, dst
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" 
                                   placeholder="Nama lengkap" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" 
                                   placeholder="email@example.com" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" 
                                   placeholder="Minimal 6 karakter" minlength="6" required>
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

<script>
document.getElementById('roleSelect').addEventListener('change', function() {
    const role = this.value;
    const idInput = document.getElementById('idInput');
    const idHelp = document.getElementById('idHelp');
    
    if (role === 'ADMIN') {
        idInput.placeholder = 'ADM001';
        idHelp.innerHTML = '<strong>Admin harus dimulai dengan "ADM"</strong> (contoh: ADM001, ADM002)';
    } else if (role === 'PETUGAS') {
        idInput.placeholder = 'EMP001';
        idHelp.innerHTML = '<strong>Petugas harus dimulai dengan "EMP"</strong> (contoh: EMP001, EMP002)';
    }
});
</script>

<?php include __DIR__ . '/../../includes/footer.php'; ?>