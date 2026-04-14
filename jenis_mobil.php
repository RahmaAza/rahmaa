<?php
include 'config.php';
session_start();

// Proteksi: Jika belum login, lempar ke login.php
if (!isset($_SESSION['username'])) { 
    header("Location: login.php"); 
    exit(); 
}

// --- LOGIKA CRUD ---

// 1. TAMBAH DATA
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_mobil']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga_mobil']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun_keluar']);
    $tipe = mysqli_real_escape_string($conn, $_POST['jenis_tipe']);

    $query_tambah = "INSERT INTO mobil (nama_mobil, harga_mobil, tahun_keluar, jenis_tipe) VALUES ('$nama', '$harga', '$tahun', '$tipe')";
    mysqli_query($conn, $query_tambah);
    header("Location: jenis_mobil.php");
    exit();
}

// 2. HAPUS DATA
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM mobil WHERE id_mobil=$id");
    header("Location: jenis_mobil.php");
    exit();
}

// 3. AMBIL DATA UNTUK TABEL
$result = mysqli_query($conn, "SELECT * FROM mobil ORDER BY id_mobil DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Mobil - Car Sales Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bubble-pink: #ff007f;
            --bubble-blue: #00d4ff;
            --bubble-purple: #7000ff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            color: #fff;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Navbar Bubble */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            margin: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 10px 30px;
        }

        /* Container Gelembung Utama */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 40px;
            padding: 30px;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            color: #333;
        }

        /* Input & Button Bubble */
        .bubble-input {
            border-radius: 30px;
            padding: 12px 20px;
            border: 2px solid #f0f0f0;
            margin-bottom: 15px;
            background: #fdfdfd;
            transition: 0.3s;
        }

        .bubble-input:focus {
            border-color: var(--bubble-blue);
            box-shadow: 0 0 15px rgba(0, 212, 255, 0.3);
            transform: scale(1.02);
        }

        .btn-bubble {
            border-radius: 30px;
            padding: 12px;
            font-weight: 700;
            background: linear-gradient(to right, var(--bubble-pink), var(--bubble-purple));
            border: none;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.4s;
        }

        .btn-bubble:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 20px rgba(255, 0, 127, 0.4);
            color: #fff;
        }

        /* Styling Baris Tabel Menjadi Gelembung */
        .table thead {
            border: none;
        }

        .table thead th {
            border: none;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        tbody tr {
            background: #fff;
            margin-bottom: 10px;
            display: table-row; /* Menjaga struktur tabel */
            transition: 0.3s;
        }

        /* Efek Rounded Row */
        tbody tr td:first-child { border-top-left-radius: 25px; border-bottom-left-radius: 25px; }
        tbody tr td:last-child { border-top-right-radius: 25px; border-bottom-right-radius: 25px; }

        .table-bubble-row {
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-color: transparent;
        }

        .table-bubble-row:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            background: #f8f9ff !important;
        }

        .badge-tipe {
            background: #e3f2fd;
            color: #1976d2;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
        }

        .price-tag {
            background: linear-gradient(45deg, #23a6d5, #23d5ab);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
        }

        .btn-action {
            border-radius: 20px;
            font-size: 0.8rem;
            margin: 2px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold italic" href="#">✨ CAR SALES PRO</a>
        <div class="ms-auto">
            <a href="dashboard.php" class="btn btn-light btn-sm rounded-pill px-4 fw-bold text-primary">← Dashboard</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="row g-4">
        
        <div class="col-md-4">
            <div class="glass-card shadow-lg">
                <h4 class="fw-bold mb-4 text-center" style="color: var(--bubble-purple);">Tambah Unit Baru</h4>
                <form method="POST" action="">
                    <label class="small fw-bold ms-2 mb-1">Nama Unit</label>
                    <input type="text" name="nama_mobil" class="form-control bubble-input" placeholder="Contoh: Honda Civic" required>
                    
                    <label class="small fw-bold ms-2 mb-1">Harga (Rp)</label>
                    <input type="number" name="harga_mobil" class="form-control bubble-input" placeholder="250000000" required>
                    
                    <label class="small fw-bold ms-2 mb-1">Tahun Rilis</label>
                    <input type="number" name="tahun_keluar" class="form-control bubble-input" placeholder="2024" required>
                    
                    <label class="small fw-bold ms-2 mb-1">Tipe Mobil</label>
                    <select name="jenis_tipe" class="form-select bubble-input">
                        <option value="Sedan">Sedan</option>
                        <option value="SUV">SUV</option>
                        <option value="MPV">MPV</option>
                        <option value="Electric">Electric</option>
                        <option value="Sport">Sport</option>
                    </select>
                    
                    <button type="submit" name="tambah" class="btn btn-bubble w-100 mt-3 shadow">🚀 Simpan Katalog</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="glass-card shadow-lg">
                <h4 class="fw-bold mb-4 text-center" style="color: var(--bubble-blue);">Daftar Inventaris</h4>
                <div class="table-responsive">
                    <table class="table align-middle" style="border-collapse: separate; border-spacing: 0 15px;">
                        <thead>
                            <tr class="text-center">
                                <th>Informasi Mobil</th>
                                <th>Tahun</th>
                                <th>Harga OTR</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr class="table-bubble-row">
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark"><?= $row['nama_mobil']; ?></div>
                                        <span class="badge badge-tipe mt-1"><?= $row['jenis_tipe'] ?? 'General'; ?></span>
                                    </td>
                                    <td class="text-center fw-bold text-muted"><?= $row['tahun_keluar'] ?? '-'; ?></td>
                                    <td class="text-center">
                                        <div class="price-tag">Rp <?= number_format($row['harga_mobil'], 0, ',', '.'); ?></div>
                                    </td>
                                    <td class="text-center pe-4">
                                        <a href="edit_mobil.php?id=<?= $row['id_mobil']; ?>" class="btn btn-sm btn-warning btn-action text-white">Edit</a>
                                        <a href="jenis_mobil.php?hapus=<?= $row['id_mobil']; ?>" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Hapus unit ini?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="80" class="mb-3 opacity-50">
                                        <p class="text-muted italic">Katalog masih kosong...</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>