<?php
include 'config.php';
session_start();

// Proteksi Session
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// --- LOGIKA PENGAMBILAN DATA RIIL (DINAMIS) ---
$tgl_sekarang = date('Y-m-d');
$query_today = mysqli_query($conn, "SELECT COUNT(*) AS total FROM transaksi WHERE DATE(tgl_transaksi) = '$tgl_sekarang'");
$data_today = mysqli_fetch_assoc($query_today);
$jumlah_transaksi = $data_today['total'] ?? 0; 

$query_mobil = mysqli_query($conn, "SELECT COUNT(*) AS total FROM mobil");
$data_mobil = mysqli_fetch_assoc($query_mobil);
$total_mobil = $data_mobil['total'] ?? 0;

$query_pembeli = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pembeli");
$data_pembeli = mysqli_fetch_assoc($query_pembeli);
$total_pembeli = $data_pembeli['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sidebar - Car Sales Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --color-1: #f06;
            --color-2: #3cf;
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(45deg, var(--color-1), var(--color-2), var(--color-1));
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            margin: 0;
            display: flex;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* SIDEBAR STYLE */
        .sidebar {
            width: var(--sidebar-width);
            height: calc(100vh - 40px);
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 40px;
            margin: 20px;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            transition: 0.3s;
            z-index: 1000;
        }

        .sidebar-brand {
            font-weight: 700;
            color: white;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-pills .nav-link {
            color: white !important;
            border-radius: 25px;
            margin-bottom: 10px;
            padding: 12px 20px;
            transition: 0.3s;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-pills .nav-link:hover, 
        .nav-pills .nav-link.active {
            background: rgba(255, 255, 255, 0.25);
            transform: translateX(10px);
        }

        /* MAIN CONTENT STYLE */
        .main-content {
            margin-left: calc(var(--sidebar-width) + 40px);
            padding: 40px;
            width: 100%;
        }

        /* BLOB CARDS */
        .blob-card {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            transition: 0.5s ease;
            text-align: center;
        }

        .blob-1 { border-radius: 60% 40% 70% 30% / 50% 60% 40% 50%; }
        .blob-2 { border-radius: 40% 60% 30% 70% / 60% 50% 50% 40%; }
        .blob-3 { border-radius: 70% 30% 50% 50% / 30% 70% 40% 60%; }
        .blob-main { border-radius: 50px; }

        .blob-card:hover { transform: translateY(-10px); }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(45deg, var(--color-1), var(--color-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .user-profile {
            margin-top: auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 30px;
            text-align: center;
        }

        .btn-logout {
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            color: white; border: none; border-radius: 20px;
            width: 100%; margin-top: 10px; padding: 8px;
            font-weight: 600; font-size: 0.8rem;
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-120%); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="sidebar shadow">
    <div class="sidebar-brand">
        <i class="bi bi-car-front-fill"></i> CS PRO
    </div>
    
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link active">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="jenis_mobil.php" class="nav-link">
                <i class="bi bi-truck"></i> Jenis Mobil
            </a>
        </li>
        <li class="nav-item">
            <a href="data_pembeli.php" class="nav-link">
                <i class="bi bi-people-fill"></i> Data Pembeli
            </a>
        </li>
        <li class="nav-item">
            <a href="data_transaksi.php" class="nav-link">
                <i class="bi bi-receipt"></i> Data Transaksi
            </a>
        </li>
        <li class="nav-item">
            <a href="transaksi.php" class="nav-link">
                <i class="bi bi-plus-circle-fill"></i> Transaksi Baru
            </a>
        </li>
    </ul>

    <div class="user-profile mt-auto">
        <small class="text-white d-block mb-1">Signed in as:</small>
        <strong class="text-white"><?= ucfirst($username); ?></strong>
        <a href="logout.php" class="btn btn-logout">
            <i class="bi bi-box-arrow-right me-2"></i> KELUAR
        </a>
    </div>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col-12 text-center text-md-start">
                <h1 class="text-white fw-bold display-5">Panel Utama Penjualan</h1>
                <p class="text-white opacity-75">Real-time business performance analytics.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-xl-4 col-md-6">
                <div class="card blob-card blob-1 p-5 h-100 d-flex flex-column justify-content-center">
                    <h6 class="text-uppercase fw-bold text-secondary">Transaksi Hari Ini</h6>
                    <div class="stat-number my-2"><?= $jumlah_transaksi; ?></div>
                    <p class="text-secondary small m-0">Unit terjual per <strong><?= date('d M Y'); ?></strong></p>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card blob-card blob-2 p-5 h-100 d-flex flex-column justify-content-center">
                    <h6 class="text-uppercase fw-bold text-secondary">Koleksi Katalog</h6>
                    <div class="stat-number my-2"><?= $total_mobil; ?></div>
                    <p class="text-secondary small m-0">Tipe mobil tersedia</p>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card blob-card blob-3 p-5 h-100 d-flex flex-column justify-content-center">
                    <h6 class="text-uppercase fw-bold text-secondary">Database Pelanggan</h6>
                    <div class="stat-number my-2"><?= $total_pembeli; ?></div>
                    <p class="text-secondary small m-0">Total pelanggan setia</p>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="card blob-card blob-main p-5 text-start border-0">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h2 class="fw-bold mb-3">Selamat Datang, <?= ucfirst($username); ?>! 👋</h2>
                            <p class="text-muted mb-4">Sistem backend Anda sekarang menggunakan navigasi sidebar untuk akses yang lebih cepat. Semua data di atas diambil langsung dari database SQL Anda secara otomatis setiap kali ada transaksi baru.</p>
                            <div class="d-flex gap-2">
                                <a href="transaksi.php" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                                    <i class="bi bi-cart-plus me-2"></i> Buat Pesanan
                                </a>
                                <a href="data_transaksi.php" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                    Lihat Riwayat
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block text-center">
                            <div style="font-size: 10rem; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));">🏎️</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>