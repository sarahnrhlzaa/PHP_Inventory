<?php
// index.php
require_once __DIR__ . '/api/ApiService.php';

// Get summary data
$studentsResponse = StudentService::getAll();
$equipmentsResponse = EquipmentService::getAll();
$activeBorrowingsResponse = TransactionService::getActiveBorrowings();

$totalStudents = 0;
$totalEquipments = 0;
$totalActiveBorrowings = 0;

if ($studentsResponse['status'] == 200) {
    $students = extractData($studentsResponse);
    $totalStudents = is_array($students) ? count($students) : 0;
}

if ($equipmentsResponse['status'] == 200) {
    $equipments = extractData($equipmentsResponse);
    $totalEquipments = is_array($equipments) ? count($equipments) : 0;
}

if ($activeBorrowingsResponse['status'] == 200) {
    $borrowings = extractData($activeBorrowingsResponse);
    $totalActiveBorrowings = is_array($borrowings) ? count($borrowings) : 0;
}
?>

<?php include __DIR__ . '/includes/header.php'; ?>

<div class="container-fluid mt-4">
    <h1 class="h2 mb-4">Dashboard</h1>
    
    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Mahasiswa</h6>
                            <h2 class="mb-0"><?= $totalStudents ?></h2>
                        </div>
                        <i class="bi bi-people" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="/PHP_Inventory/pages/students/index.php" class="text-white text-decoration-none">
                        Lihat detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Alat</h6>
                            <h2 class="mb-0"><?= $totalEquipments ?></h2>
                        </div>
                        <i class="bi bi-box" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="/inventory-frontend/pages/equipment/index.php" class="text-white text-decoration-none">
                        Lihat detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Peminjaman Aktif</h6>
                            <h2 class="mb-0"><?= $totalActiveBorrowings ?></h2>
                        </div>
                        <i class="bi bi-box-arrow-right" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="/inventory-frontend/pages/transactions/transactions_borrowing.php" class="text-white text-decoration-none">
                        Lihat detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Transaksi</h6>
                            <h2 class="mb-0"><i class="bi bi-arrow-left-right"></i></h2>
                        </div>
                        <i class="bi bi-graph-up" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="/inventory-frontend/pages/transactions/index.php" class="text-white text-decoration-none">
                        Lihat detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="/inventory-frontend/pages/students/create.php" class="btn btn-primary w-100">
                                <i class="bi bi-person-plus"></i> Tambah Mahasiswa
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="/inventory-frontend/pages/equipment/create.php" class="btn btn-success w-100">
                                <i class="bi bi-box-seam"></i> Tambah Alat
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="/inventory-frontend/pages/transactions/borrow.php" class="btn btn-warning w-100">
                                <i class="bi bi-box-arrow-right"></i> Peminjaman Baru
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="/inventory-frontend/pages/transactions/return.php" class="btn btn-info w-100">
                                <i class="bi bi-box-arrow-in-left"></i> Pengembalian
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>