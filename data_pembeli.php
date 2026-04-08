<?php
include 'config.php';
session_start();

// Proteksi Login
if (!isset($_SESSION['username'])) { 
    header("Location: login.php"); 
    exit(); 
}

// Ambil data pembeli dari database
$query = "SELECT * FROM pembeli ORDER BY id_pembeli DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembeli - Colorful Bubble</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #6c5ce7;
            --accent-color: #00ecbc;
            --card-glass: rgba(255, 255, 255, 0.2);
        }

        body {
            font-family: 'Fredoka', sans-serif;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
            padding: 40px 0;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Gelembung Animasi */
        .bg-bubbles {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            margin: 0; padding: 0;
        }
        .bg-bubbles li {
            position: absolute;
            list-style: none;
            background-color: rgba(255, 255, 255, 0.2);
            bottom: -160px;
            border-radius: 50%;
            animation: bubbleMove 20s infinite linear;
        }

        @keyframes bubbleMove {
            0% { transform: translateY(0) scale(1); opacity: 0.5; }
            100% { transform: translateY(-1200px) scale(1.5); opacity: 0; }
        }

        .container { z-index: 1; }

        /* Kartu Utama Bergelembung */
        .data-card {
            background: var(--card-glass);
            backdrop-filter: blur(15px);
            border-radius: 50px;
            padding: 40px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 45px rgba(0,0,0,0.2);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        h2 { 
            color: white; 
            font-weight: 700; 
            text-align: center; 
            margin-bottom: 30px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.2);
        }

        /* Table Styling */
        .table-container {
            background: white;
            border-radius: 30px;
            padding: 20px;
            box-shadow: inset 0 5px 15px rgba(0,0,0,0.1);
        }

        .table { margin-bottom: 0; }
        .table thead th {
            background-color: #6c5ce7;
            color: white;
            border: none;
            padding: 15px;
            text-align: center;
        }
        .table thead th:first-child { border-radius: 20px 0 0 20px; }
        .table thead th:last-child { border-radius: 0 20px 20px 0; }

        .table tbody td {
            vertical-align: middle;
            text-align: center;
            padding: 15px;
            border-bottom: 1px solid #f1f2f6;
        }

        /* Button Styling */
        .btn-add {
            background: #2ed573;
            color: white;
            border-radius: 30px;
            padding: 10px 25px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
            margin-bottom: 20px;
            display: inline-block;
            text-decoration: none;
        }
        .btn-add:hover {
            background: #26af5f;
            transform: scale(1.1);
            color: white;
        }

        .btn-action {
            border-radius: 20px;
            font-size: 0.8rem;
            padding: 5px 15px;
        }

        .btn-logout {
            color: white;
            text-decoration: none;
            float: right;
            font-weight: 600;
            background: rgba(255,0,0,0.4);
            padding: 5px 15px;
            border-radius: 20px;
        }
    </style>
</head>
<body>

<ul class="bg-bubbles">
    <li style="left: 5%; width: 80px; height: 80px; animation-delay: 0s;"></li>
    <li style="left: 15%; width: 40px; height: 40px; animation-delay: 2s; animation-duration: 12s;"></li>
    <li style="left: 30%; width: 100px; height: 100px; animation-delay: 4s;"></li>
    <li style="left: 50%; width: 60px; height: 60px; animation-delay: 0s; animation-duration: 18s;"></li>
    <li style="left: 75%; width: 90px; height: 90px; animation-delay: 5s;"></li>
    <li style="left: 90%; width: 30px; height: 30px; animation-delay: 8s; animation-duration: 15s;"></li>
</ul>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="data-card">
                <a href="logout.php" class="btn-logout">Keluar</a>
                <h2>📋 Data Pembeli Car Sales</h2>
                
                <div class="d-flex justify-content-between align-items-center">
                    <a href="tambah_pembeli.php" class="btn-add">➕ Tambah Pembeli Baru</a>
                    <a href="jenis_mobil.php" style="color: white; text-decoration: none; font-weight: 600;">Lihat Unit Mobil →</a>
                </div>

                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Pembeli</th>
                                    <th>No. Telepon</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><strong>#<?= $row['id_pembeli']; ?></strong></td>
                                    <td><?= $row['nama_pembeli']; ?></td>
                                    <td><?= $row['no_telp']; ?></td>
                                    <td><?= $row['alamat']; ?></td>
                                    <td>
                                        <a href="edit_pembeli.php?id=<?= $row['id_pembeli']; ?>" class="btn btn-warning btn-action">Edit</a>
                                        <a href="hapus_pembeli.php?id=<?= $row['id_pembeli']; ?>" class="btn btn-danger btn-action" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>