<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }

// --- FUNGSI DELETE (Hapus) ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM transaksi WHERE id_transaksi='$id'");
    header("Location: data_transaksi.php");
    exit();
}

// Ambil Data dengan JOIN
$query = "SELECT transaksi.*, mobil.nama_mobil, pembeli.nama_pembeli 
          FROM transaksi 
          JOIN mobil ON transaksi.id_mobil = mobil.id_mobil 
          JOIN pembeli ON transaksi.id_pembeli = pembeli.id_pembeli 
          ORDER BY transaksi.id_transaksi DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bubble CRUD System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Fredoka', sans-serif;
            background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
            min-height: 100vh; padding: 40px 20px;
        }
        .data-card {
            background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(15px);
            border: 6px solid white; border-radius: 50px; padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        h2 { color: white; text-shadow: 2px 2px #9171e0; font-weight: 700; }
        
        /* Gaya Tabel Gelembung */
        .table { border-collapse: separate; border-spacing: 0 15px; background: transparent; }
        .table tbody tr { background: white; transition: 0.3s; }
        .table tbody td { border: none; padding: 15px; font-weight: 600; color: #555; }
        .table tbody tr td:first-child { border-radius: 30px 0 0 30px; }
        .table tbody tr td:last-child { border-radius: 0 30px 30px 0; }

        /* Tombol Aksi */
        .btn-action {
            border-radius: 20px; padding: 5px 15px; font-size: 0.8rem;
            text-decoration: none; font-weight: bold; color: white; transition: 0.3s;
        }
        .btn-edit { background: #fdcb6e; margin-right: 5px; }
        .btn-delete { background: #ff7675; }
        .btn-action:hover { opacity: 0.8; color: white; transform: scale(1.1); }
        
        .btn-add {
            background: white; color: #6c5ce7; border-radius: 30px;
            padding: 10px 25px; font-weight: 700; text-decoration: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📊 DATA TRANSAKSI</h2>
        <a href="transaksi.php" class="btn-add">➕ Tambah Baru</a>
    </div>

    <div class="data-card">
        <div class="table-responsive">
            <table class="table align-middle text-center">
                <thead>
                    <tr style="color: #6c5ce7;">
                        <th>TANGGAL</th>
                        <th>PEMBELI</th>
                        <th>MOBIL</th>
                        <th>TOTAL</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($row['tgl_transaksi'])); ?></td>
                        <td><span class="text-primary"><?= $row['nama_pembeli']; ?></span></td>
                        <td><?= $row['nama_mobil']; ?></td>
                        <td><b style="color: #2d3436;">Rp<?= number_format($row['total_bayar']); ?></b></td>
                        <td>
                            <a href="edit_transaksi.php?id=<?= $row['id_transaksi']; ?>" class="btn-action btn-edit">EDIT ✏️</a>
                            <a href="data_transaksi.php?hapus=<?= $row['id_transaksi']; ?>" 
                               class="btn-action btn-delete" 
                               onclick="return confirm('Hapus transaksi ini? 🥺')">HAPUS 🗑️</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>