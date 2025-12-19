<?php
// pages/students/index.php

require_once __DIR__ . '/../../api/ApiService.php';

// Handle search
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
$students = [];

if (!empty($searchKeyword)) {
    $response = StudentService::search($searchKeyword);
} else {
    $response = StudentService::getAll();
}

if ($response['status'] == 200) {
    $students = extractData($response);
    if (!is_array($students)) $students = [];
}

// Handle delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $deleteResponse = StudentService::delete($_GET['id']);
    if ($deleteResponse['status'] == 200) {
        header("Location: index.php?success=Data berhasil dihapus");
        exit();
    } else {
        $error = $deleteResponse['data']['message'] ?? 'Gagal menghapus data';
    }
}
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Daftar Mahasiswa</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= htmlspecialchars($_GET['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <!-- Search & Add Button -->
    <div class="row mb-3">
        <div class="col-md-8">
            <form method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" 
                       placeholder="Cari nama mahasiswa..." 
                       value="<?= htmlspecialchars($searchKeyword) ?>">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-search"></i> Cari
                </button>
                <?php if (!empty($searchKeyword)): ?>
                    <a href="index.php" class="btn btn-secondary">Reset</a>
                <?php endif; ?>
            </form>
        </div>
        <div class="col-md-4 text-end">
            <a href="create.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Tambah Mahasiswa
            </a>
        </div>
    </div>
    
    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>Telepon</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($students)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?= htmlspecialchars($student['id']) ?></td>
                                    <td><?= htmlspecialchars($student['nim']) ?></td>
                                    <td><?= htmlspecialchars($student['name']) ?></td>
                                    <td><?= htmlspecialchars($student['studyProgram']) ?></td>
                                    <td><?= htmlspecialchars($student['phone'] ?? '-') ?></td>
                                    <td>
                                        <a href="edit.php?id=<?= $student['id'] ?>" 
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="index.php?action=delete&id=<?= $student['id'] ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Yakin ingin menghapus mahasiswa <?= htmlspecialchars($student['name']) ?>?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../includes/footer.php'; ?>