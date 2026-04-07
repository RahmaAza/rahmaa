<?php
include 'config.php';
session_start();

$error = "";
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // Menggunakan MD5 sesuai permintaan

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Bubble - Car Sales Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(45deg, #f06, #3cf, #f06);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* --- EFEK KARTU GELEMBUNG (BLOB) --- */
        .login-blob {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            backdrop-filter: blur(15px);
            /* Bentuk gelembung organik */
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            padding: 60px 50px;
            transition: all 0.5s ease;
            animation: morph 12s ease-in-out infinite;
            max-width: 450px;
            width: 100%;
        }

        @keyframes morph {
            0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
            33% { border-radius: 50% 50% 30% 70% / 50% 60% 40% 50%; }
            66% { border-radius: 70% 30% 50% 50% / 30% 70% 40% 60%; }
            100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
        }

        .login-blob:hover {
            transform: scale(1.02);
            background: rgba(255, 255, 255, 1);
        }

        /* Input & Button Gaya Bubble */
        .form-control {
            border-radius: 50px;
            padding: 12px 20px;
            border: 2px solid #eee;
            background: rgba(255, 255, 255, 0.8);
            transition: 0.3s;
        }

        .form-control:focus {
            box-shadow: 0 0 15px rgba(51, 204, 255, 0.3);
            border-color: #3cf;
            outline: none;
        }

        .btn-custom {
            background: linear-gradient(to right, #f06, #3cf);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 700;
            letter-spacing: 1px;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 0, 102, 0.3);
            color: white;
        }

        .form-label {
            font-weight: 600;
            margin-left: 15px;
            color: #555;
        }

        .logo-bubble {
            font-size: 3rem;
            margin-bottom: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-blob text-center shadow-lg">
        <div class="mb-4">
            <span class="logo-bubble">🚗</span>
            <h3 class="fw-bold text-dark">Welcome Back</h3>
            <p class="text-muted small">Car Sales Management System</p>
        </div>
        
        <?php if($error): ?>
            <div class="alert alert-danger text-center py-2" style="border-radius: 50px; font-size: 0.85rem;">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="text-start">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <div class="d-grid">
                <button type="submit" name="login" class="btn btn-custom">MASUK SEKARANG</button>
            </div>
        </form>
        
        <div class="mt-4">
            <small class="text-muted">Lupa password? Hubungi Admin</small>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>