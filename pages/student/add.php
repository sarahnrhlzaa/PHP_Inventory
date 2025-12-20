<?php 
require_once '../../includes/header.php'; 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = [
        'id' => $_POST['id'],
        'nim' => $_POST['nim'],
        'name' => $_POST['name'],
        'studyProgram' => $_POST['studyProgram'],
        'phone' => $_POST['phone']
    ];

    // Panggil API POST /students
    $resp = callAPI('POST', '/students', $data);

    if(isset($resp['success']) && $resp['success']) {
        echo "<script>alert('Student successfully added!'); window.location='index.php';</script>";
    } else {
        $msg = $resp['message'] ?? 'Failed to add student.';
        echo "<script>alert('Error: " . $msg . "');</script>";
    }
}
?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3>Add Student</h3>
        <a href="index.php" class="btn btn-danger">Back</a>
    </div>

    <form method="POST">
        <div class="form-group">
            <label>System ID</label>
            <input type="text" name="id" class="form-control" placeholder="Contoh: STD001" required>
        </div>
        <div class="form-group">
            <label>NIM</label>
            <input type="text" name="nim" class="form-control" placeholder="Nomor Induk Mahasiswa" required>
        </div>
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Study Program</label>
            <input type="text" name="studyProgram" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" class="form-control" placeholder="08..." required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<?php require_once '../../includes/footer.php'; ?>