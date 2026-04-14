<?php
include 'config.php';
session_start();

// Proteksi Session
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Query untuk mengambil jumlah transaksi HARI INI (Asumsi tabel 'transaksi' dan kolom 'tgl_transaksi' ada)
$tgl_sekarang = date('Y-m-d');
// KONEKSI DB DINONAKTIFKAN UNTUK DEMO CODE, AKTIFKAN JIKA DB SUDAH SIAP
// $query_today = "SELECT COUNT(*) AS total FROM transaksi WHERE DATE(tgl_transaksi) = '$tgl_sekarang'";
// $result_today = mysqli_query($conn, $query_today);
// $data_today = mysqli_fetch_assoc($result_today);
// $jumlah_transaksi = $data_today['total'] ?? 0; 
$jumlah_transaksi = 12; // DATA DUMMY UNTUK DEMO TAMPILAN
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Gelembung - Car Sales Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-1: #f06; /* Pink/Red dari Login */
            --color-2: #3cf; /* Blue dari Login */
            --color-3: #f06; /* Kembali ke Pink */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(45deg, var(--color-1), var(--color-2), var(--color-3));
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            overflow-x: hidden;
            color: #333;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Navigasi Bergelembung */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border-radius: 50px; /* Gelembung Panjang */
            margin: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 10px 20px;
        }
        
        .navbar-brand { font-weight: 700; color: white !important; text-transform: uppercase; letter-spacing: 1px; }
        .nav-link { color: white !important; font-weight: 400; transition: 0.3s; padding: 10px 20px !important; border-radius: 30px; }
        .nav-link:hover, .nav-link.active { background: rgba(255, 255, 255, 0.2); color: #fff !important; }

        /* Tombol Logout Bergelembung */
        .btn-logout {
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            color: white;
            border-radius: 50px;
            border: none;
            padding: 8px 25px;
            font-weight: 600;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(255, 75, 43, 0.3);
        }
        .btn-logout:hover { transform: scale(1.05); color: white; box-shadow: 0 6px 20px rgba(255, 75, 43, 0.5); }

        /* KARTU GELEMBUNG UTAMA (The Blobs) */
        .blob-card {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            transition: 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        /* Bentuk Gelembung Tidak Beraturan untuk Kartu Utama */
        .blob-1 { border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%; }
        .blob-2 { border-radius: 40% 60% 30% 70% / 60% 50% 50% 40%; }
        .blob-3 { border-radius: 70% 30% 50% 50% / 30% 70% 40% 60%; }
        .blob-main { border-radius: 30px 100px 30px 100px; } /* Bentuk unik untuk konten besar */

        .blob-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        /* Efek Denyut Gelembung (Optional, matikan jika terlalu mengganggu) */
        @keyframes blobPulse {
            0% { border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%; }
            50% { border-radius: 50% 50% 50% 50% / 50% 50% 50% 50%; }
            100% { border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%; }
        }
        /* Terapkan hanya pada kartu statistik kecil */
        .col-md-4 .blob-card {
            animation: blobPulse 8s linear infinite;
        }

        .stat-number {
            font-size: 4rem;
            font-weight: 700;
            background: linear-gradient(45deg, var(--color-1), var(--color-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }

        .card-title-custom { font-size: 1rem; font-weight: 600; text-transform: uppercase; color: #666; letter-spacing: 1px; }
        .welcome-text { color: white; text-shadow: 2px 2px 5px rgba(0,0,0,0.2); font-weight: 700; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom" style="position: relative; z-index: 1000;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">CAR SALES PRO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto align-items-center">
                <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="jenis_mobil.php">Jenis Mobil</a></li>
                <li class="nav-item"><a class="nav-link" href="data_pembeli.php">Data Pembeli</a></li>
                <li class="nav-item"><a class="nav-link" href="transaksi.php">Transaksi</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 fw-light">Halo, <strong><?= ucfirst($username); ?></strong></span>
                <a href="logout.php" class="btn btn-logout btn-sm px-4 shadow-sm" style="position: relative; z-index: 1001;">Keluar</a>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="welcome-text display-4">Panel Utama Penjualan</h1>
            <p class="text-white fs-5">Pantau performa bisnis Anda hari ini .</p>
        </div>
    </div>

    <div class="row justify-content-center g-4">
        <div class="col-md-4">
            <div class="card blob-card blob-1 p-5 text-center h-100 d-flex flex-column justify-content-center">
                <h6 class="card-title-custom mb-3">Transaksi Hari Ini</h6>
                <div class="stat-number my-2">
                    <?= $jumlah_transaksi; ?>
                </div>
                <p class="text-secondary small mt-2">Unit mobil terjual pada<br><strong><?= date('d M Y'); ?></strong></p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card blob-card blob-2 p-5 text-center h-100 d-flex flex-column justify-content-center">
                <h6 class="card-title-custom mb-3">Jenis Mobil</h6>
                <div class="stat-number my-2">12</div>
                <p class="text-secondary small mt-2">Tipe mobil tersedia<br>di katalog</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card blob-card blob-3 p-5 text-center h-100 d-flex flex-column justify-content-center">
                <h6 class="card-title-custom mb-3">Pelanggan</h6>
                <div class="stat-number my-2">450</div>
                <p class="text-secondary small mt-2">Pembeli terdaftar<br>dalam sistem</p>
            </div>
        </div>

        <div class="col-12 mt-5 mb-5">
            <div class="card blob-card blob-main p-5">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="fw-bold">Selamat Bekerja, <?= ucfirst($username); ?>!</h3>
                        <p class="text-muted">Ini adalah dashboard manajemen penjualan mobil Anda. Gunakan menu di atas untuk mengelola data mobil, pembeli, dan mencatat transaksi baru. Desain bergelembung ini dibuat untuk memberikan pengalaman pengguna yang lebih segar dan menyenangkan.</p>
                        <div class="alert alert-info border-0 rounded-pill bg-light text-info shadow-sm">
                            <strong>Saran Keamanan:</strong> Ingatlah untuk selalu menekan tombol 'Keluar' setelah selesai menggunakan aplikasi.
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="stat-number text-opacity-25" style="font-size: 10rem;">🚗</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>