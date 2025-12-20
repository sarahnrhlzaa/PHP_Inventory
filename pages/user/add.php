<?php 
require_once '../../includes/header.php'; 

// 1. Proteksi Halaman (Hanya Admin)
if($_SESSION['role'] !== 'ADMIN') {
    echo "<script>alert('Access Denied!'); window.location='../dashboard.php';</script>";
    exit;
}

// 2. Handle Form Submit

// 2. Handle Form Submit
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    // === BAGIAN AJAIBNYA DI SINI ===
    // Ambil password yang diketik admin
    $passwordBiasa = $_POST['password']; 
    
    // Ubah jadi kode Hash secara otomatis
    $passwordHash = password_hash($passwordBiasa, PASSWORD_BCRYPT);

    $data = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $passwordHash, // Kirim password yang sudah di-hash
        'role' => $_POST['role']
    ];

    // Panggil API POST /users
    $resp = callAPI('POST', '/users', $data);

    if(isset($resp['success']) && $resp['success']) {
        echo "<script>alert('User successfully added!'); window.location='index.php';</script>";
    } else {
        // Tampilkan pesan error dari backend (misal: ID format salah, email duplikat)
        $msg = $resp['message'] ?? 'Failed to save user data.';
        echo "<script>alert('Error: " . $msg . "');</script>";
    }
}
?>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3>Add New User</h3>
        <a href="index.php" class="btn btn-danger">Back</a>
    </div>

    <form method="POST">
        <div class="form-group">
            <label>Role / Position</label>
            <select name="role" id="roleSelect" class="form-control" onchange="updateIdPlaceholder()" required>
                <option value="PETUGAS">PETUGAS (Staff Lab)</option>
                <option value="ADMIN">ADMIN (Administrator)</option>
            </select>
        </div>

        <div class="form-group">
            <label>ID User</label>
            <input type="text" name="id" id="idInput" class="form-control" placeholder="Contoh: EMP001" required>
            <small style="color: #666;">
                *Petugas harus diawali <b>EMP</b> (cth: EMP001), Admin diawali <b>ADM</b> (cth: ADM001)
            </small>
        </div>

        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
            <small style="color: #666;">*Password will be encrypted automatically before saving.</small>
        </div>

        <button type="submit" class="btn btn-primary">Save User</button>
    </form>
</div>

<script>
function updateIdPlaceholder() {
    const role = document.getElementById('roleSelect').value;
    const idInput = document.getElementById('idInput');
    
    if(role === 'ADMIN') {
        idInput.placeholder = 'Contoh: ADM001';
    } else {
        idInput.placeholder = 'Contoh: EMP001';
    }
}
</script>

<?php require_once '../../includes/footer.php'; ?>