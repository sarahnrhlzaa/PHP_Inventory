<?php
session_start();
require_once 'includes/api_helper.php';

if (isset($_SESSION['user_id'])) {
    header("Location: pages/dashboard.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Panggil API get user by email
    $response = callAPI('GET', '/users/email/' . $email);

    if (isset($response['success']) && $response['success'] && isset($response['data'])) {
        $user = $response['data'];
        // 2. Verifikasi Hash Password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            header("Location: pages/dashboard.php");
            exit;
        } else {
            $error = "Your password is incorrect!";
        }
    } else {
        $error = "No email found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Inventory</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="background:#1a252f; display:flex; align-items:center; justify-content:center; height:100vh;">
    <div class="card" style="width: 350px;">
        <h2 style="text-align:center;">Login</h2>
        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <?php if($error): ?><p style="color:red; text-align:center;"><?= $error ?></p><?php endif; ?>
            <button type="submit" class="btn btn-primary" style="width:100%;">Login</button>
        </form>
        <br>
        <a href="public_search.php" style="display:block; text-align:center;">Check Stock (Student)</a>
    </div>
</body>
</html>