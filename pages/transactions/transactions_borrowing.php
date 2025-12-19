<?php
// pages/transactions/borrowing.php

require_once __DIR__ . '/../../api/ApiService.php';

$borrowings = [];

$response = TransactionService::getActiveBorrowings();
if ($response['status'] == 200) {
    $borrowings = extractData($response);
    if (!is_array($borrowings)) $borrowings = [];
}
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>

<div class="container-fluid mt-4">
    <h2 class="mb-4">Peminjaman Aktif</h2>
    
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Menampilkan daftar peminjaman yang belum dikembalikan
    </div>
    
    <div class="mb-3">
        <a href="return.php" class="btn btn-info">
            <i class="bi bi-box-arrow-in-left"></i> Proses Pengembalian
        </a>
        <a href="index.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
    
    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-warning">
                        <tr>
                            <th>ID</th>
                            <th>Tanggal Pinjam</th>
                            <th>Equipment</th>
                            <th>Quantity</th>
                            <th>Mahasiswa</th>
                            <th>Petugas</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($borrowings)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-success">
                                    <i class="bi bi-check-circle"></i> Tidak ada peminjaman aktif
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($borrowings as $borrow): ?>
                                <tr>
                                    <td><?= htmlspecialchars($borrow['id']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($borrow['transactionDate'])) ?></td>
                                    <td><?= htmlspecialchars($borrow['equipmentId']) ?></td>
                                    <td><span class="badge bg-warning"><?= $borrow['quantity'] ?></span></td>
                                    <td><?= htmlspecialchars($borrow['usedBy']) ?></td>
                                    <td><?= htmlspecialchars($borrow['handledBy']) ?></td>
                                    <td><?= htmlspecialchars($borrow['note'] ?? '-') ?></td>
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