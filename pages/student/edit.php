<?php 
require_once '../../includes/header.php'; 

// Cek ID di URL
if(!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
// Ambil data detail mahasiswa dari API GET /students/{id}
$studentData = callAPI('GET', '/students/' . $id);
$s = $studentData['data'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = [
        'nim' => $_POST['nim'],
        'name' => $_POST['name'],
        'studyProgram' => $_POST['studyProgram'],
        'phone' => $_POST['phone']
    ];

    // Panggil API PUT /students/{id}
    $resp = callAPI('PUT', '/students/' . $id, $data);

    if(isset($resp['success']) && $resp['success']) {
        echo "<script>alert('Student successfully updated!'); window.location='index.php';</script>";
    } else {
        $msg = $resp['message'] ?? 'Failed to update student data.';
        echo "<script>alert('Error: " . $msg . "');</script>";
    }
}
?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3>Edit Student: <?= $s['name'] ?></h3>
        <a href="index.php" class="btn btn-danger">Back</a>
    </div>

    <form method="POST">
        <div class="form-group">
            <label>System ID</label>
            <input type="text" value="<?= $s['id'] ?>" class="form-control" disabled style="background:#eee;">
        </div>
        <div class="form-group">
            <label>NIM</label>
            <input type="text" name="nim" value="<?= $s['nim'] ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="<?= $s['name'] ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Study Program</label>
            <input type="text" name="studyProgram" value="<?= $s['studyProgram'] ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" value="<?= $s['phone'] ?>" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Data</button>
    </form>
</div>

<?php require_once '../../includes/footer.php'; ?>