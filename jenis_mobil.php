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
        /* Dasar & Background Animasi */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(45deg, #f06, #3cf, #f06);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            color: #333;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Navbar Gelembung Panjang */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            border-radius: 60px;
            margin: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 10px 30px;
        }

        /* --- EFEK GELEMBUNG (BLOB) UTAMA --- */
        .blob-card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            /* Border radius organik untuk efek gelembung */
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            transition: all 0.5s ease-in-out;
            /* Animasi gelembung bergerak pelan */
            animation: morph 10s ease-in-out infinite;
        }

        @keyframes morph {
            0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
            33% { border-radius: 50% 50% 30% 70% / 50% 60% 40% 50%; }
            66% { border-radius: 70% 30% 50% 50% / 30% 70% 40% 60%; }
            100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
        }

        .blob-card:hover {
            transform: scale(1.02);
            background: #ffffff;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        /* Input & Button Bulat (Bubble Style) */
        .bubble-input {
            border-radius: 50px;
            padding: 12px 20px;
            border: 2px solid #eee;
            margin-bottom: 15px;
            transition: 0.3s;
        }

        .bubble-input:focus {
            border-color: #3cf;
            box-shadow: 0 0 10px rgba(51, 204, 255, 0.2);
            outline: none;
        }

        .btn-bubble {
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
            background: linear-gradient(to right, #f06, #3cf);
            border: none;
            color: white;
            transition: 0.3s;
        }

        .btn-bubble:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 0, 102, 0.3);
        }

        .table-responsive {
            border-radius: 20px;
        }

        .badge-price {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container-fluid text-center">
        <a class="navbar-brand fw-bold" href="dashboard.php">CAR SALES PRO</a>
        <div class="ms-auto">
            <a href="dashboard.php" class="btn btn-light btn-sm rounded-pill px-4 fw-bold">← Dashboard</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="row g-5">
        
        <div class="col-md-4">
            <div class="card blob-card shadow">
                <h4 class="fw-bold mb-4 text-center">Tambah Unit</h4>
                <form method="POST" action="">
                    <input type="text" name="nama_mobil" class="form-control bubble-input" placeholder="Nama Mobil" required>
                    <input type="number" name="harga_mobil" class="form-control bubble-input" placeholder="Harga (Contoh: 250000000)" required>
                    <input type="number" name="tahun_keluar" class="form-control bubble-input" placeholder="Tahun Keluar" required>
                    <select name="jenis_tipe" class="form-select bubble-input">
                        <option value="Sedan">Sedan</option>
                        <option value="SUV">SUV</option>
                        <option value="MPV">MPV</option>
                        <option value="Electric">Electric</option>
                    </select>
                    <button type="submit" name="tambah" class="btn btn-bubble w-100 mt-2">Simpan ke Katalog</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card blob-card shadow">
                <h4 class="fw-bold mb-4 text-center">Daftar Inventaris</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Unit Mobil</th>
                                <th>Tahun</th>
                                <th>Harga OTR</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold"><?= $row['nama_mobil']; ?></span><br>
                                        <small class="badge bg-info text-dark rounded-pill" style="font-size: 10px;"><?= $row['jenis_tipe']; ?></small>
                                    </td>
                                    <td><?= $row['tahun_keluar']; ?></td>
                                    <td><span class="badge-price">Rp <?= number_format($row['harga_mobil'], 0, ',', '.'); ?></span></td>
                                    <td class="text-center">
                                        <a href="edit_mobil.php?id=<?= $row['id_mobil']; ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3">Edit</a>
                                        <a href="jenis_mobil.php?hapus=<?= $row['id_mobil']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Hapus unit ini?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada unit tersedia.</td>
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