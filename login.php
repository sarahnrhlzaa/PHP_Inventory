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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
        /* Reset Body agar full screen & rata tengah */
        body {
            background: linear-gradient(135deg, var(--dark-color) 0%, #2948ff 100%);
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Poppins', sans-serif; /* Pastikan font terbawa */
        }

        /* Hiasan Lingkaran Background */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            z-index: -1;
        }

        .c1 { 
            width: 300px; 
            height: 300px; 
            top: -50px; 
            left: -50px; 
        }

        .c2 { 
            width: 400px; 
            height: 400px; 
            bottom: -100px; 
            right: -100px; 
        }

        .login-card {
            background: white;
            width: 90%;          /* Supaya responsif di HP */
            max-width: 400px;    /* Lebar maksimal di PC */
            padding: 40px 30px;  /* Padding atas-bawah 40, kiri-kanan 30 */
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            text-align: center;
            position: relative;
            z-index: 10;
            box-sizing: border-box; /* PENTING: Agar padding ga bikin lebar jebol */
        }

        .login-header h2 {
            margin: 0;
            color: var(--dark-color);
            font-weight: 700;
            font-size: 1.8rem;
        }

        .login-header p {
            color: #64748b;
            margin: 10px 0 25px 0;
            font-size: 0.9rem;
        }

        .form-group { 
            text-align: left; 
            margin-bottom: 20px; 
            width: 100%; /* Pastikan lebar 100% */
        }
        
        .form-group label { 
            font-size: 0.85rem; 
            color: #555; 
            font-weight: 600; 
            margin-bottom: 8px; 
            display: block; 
        }
        
        .input-group {
            position: relative;
            width: 100%; /* Pastikan container input full width */
        }
        
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            z-index: 2; /* Ikon di atas input */
        }
        
        /* FIX UTAMA DI SINI */
        .input-group input {
            width: 100%;           /* Lebar penuh */
            padding-left: 45px;    /* Ruang buat ikon */
            padding-right: 15px;   /* Ruang kanan */
            height: 48px;          /* Tinggi tetap */
            border-radius: 8px;
            border: 2px solid #eee;
            transition: 0.3s;
            box-sizing: border-box; /* Agar padding masuk dalam hitungan lebar */
            font-size: 0.95rem;
        }
        
        .input-group input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .btn-login {
            width: 100%;
            height: 50px;       /* Sedikit lebih tinggi biar gagah */
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
            box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
        }
        
        .btn-login:hover {
            background: #2948ff;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(67, 97, 238, 0.3);
        }

        .student-link {
            display: block;
            margin-top: 25px;
            color: #64748b;
            font-size: 0.85rem;
            text-decoration: none;
            transition: 0.3s;
        }
        .student-link:hover { color: var(--primary-color); text-decoration: underline; }

        .alert-error {
            background: #fee2e2;
            color: #ef4444;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: center;
        }
    </style>
</head>
<body>

    <div class="circle c1"></div>
    <div class="circle c2"></div>

    <div class="login-card">
        <div class="login-header">
            <div style="font-size: 3rem; color: var(--primary-color); margin-bottom: 10px;">
                <i class="fas fa-cube"></i>
            </div>
            <h2>Welcome Back!</h2>
            <p>Please login to access the inventory.</p>
        </div>

        <?php if($error): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="admin@lab.ac.id" required>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-login">LOGIN</button>
        </form>

        <a href="public_search.php" class="student-link">
            Are you a Student? <b>Check Stock Here</b>
        </a>
    </div>

</body>
</html>