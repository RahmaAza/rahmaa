<?php
include 'config.php';
session_start();

// Proteksi Session
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Ambil ID dari URL
if (!isset($_GET['id'])) {
    header("Location: data_transaksi.php");
    exit();
}

$id = $_GET['id'];

// Ambil data transaksi lama
$query = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi = '$id'");
$data = mysqli_fetch_assoc($query);

// Jika tombol update ditekan
if (isset($_POST['update'])) {
    $id_pembeli = $_POST['id_pembeli'];
    $id_mobil   = $_POST['id_mobil'];
    $tgl        = $_POST['tgl_transaksi'];
    $total      = $_POST['total_bayar'];

    $update = mysqli_query($conn, "UPDATE transaksi SET 
              id_pembeli='$id_pembeli', 
              id_mobil='$id_mobil', 
              tgl_transaksi='$tgl', 
              total_bayar='$total' 
              WHERE id_transaksi='$id'");

    if ($update) {
        echo "<script>alert('Data Berhasil Diperbarui! ✨'); window.location='data_transaksi.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data 🥺');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mission - CS PRO</title>
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

        /* SIDEBAR COPY DARI DASHBOARD */
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
        }

        .sidebar-brand { font-weight: 700; color: white; font-size: 1.5rem; text-align: center; margin-bottom: 40px; }

        .nav-pills .nav-link {
            color: white !important;
            border-radius: 25px;
            margin-bottom: 10px;
            padding: 12px 20px;
            transition: 0.3s;
        }

        .nav-pills .nav-link:hover { background: rgba(255, 255, 255, 0.25); transform: translateX(10px); }

        /* EDIT FORM BUBBLE STYLE */
        .main-content {
            margin-left: calc(var(--sidebar-width) + 40px);
            padding: 40px;
            width: 100%;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
            border: none;
        }

        .form-label {
            font-weight: 600;
            color: #555;
            margin-left: 15px;
        }

        .bubble-input {
            background: #f8f9fa;
            border: 2px solid transparent;
            border-radius: 30px;
            padding: 12px 25px;
            transition: 0.3s;
            font-weight: 500;
        }

        .bubble-input:focus {
            background: white;
            border-color: var(--color-2);
            box-shadow: 0 10px 20px rgba(51, 204, 255, 0.2);
            outline: none;
        }

        .btn-update {
            background: linear-gradient(45deg, var(--color-1), var(--color-2));
            color: white;
            border: none;
            border-radius: 30px;
            padding: 12px 40px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(255, 0, 102, 0.3);
        }

        .btn-update:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(255, 0, 102, 0.5);
            color: white;
        }

        .btn-back {
            background: #eee;
            color: #777;
            border-radius: 30px;
            padding: 12px 25px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-back:hover { background: #ddd; color: #333; }
    </style>
</head>
<body>

<div class="sidebar shadow">
    <div class="sidebar-brand">CS PRO</div>
    <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="bi bi-grid-1x2-fill me-2"></i> Dashboard</a></li>
        <li class="nav-item"><a href="data_transaksi.php" class="nav-link active"><i class="bi bi-receipt me-2"></i> Data Transaksi</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-4 text-white">
                    <h2 class="fw-bold">✏️ Edit Data Transaksi</h2>
                    <p>Sesuaikan informasi penjualan di bawah ini</p>
                </div>

                <div class="card glass-card">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Pilih Pembeli</label>
                                <select name="id_pembeli" class="form-select bubble-input">
                                    <?php
                                    $pembeli = mysqli_query($conn, "SELECT * FROM pembeli");
                                    while($p = mysqli_fetch_assoc($pembeli)){
                                        $selected = ($p['id_pembeli'] == $data['id_pembeli']) ? "selected" : "";
                                        echo "<option value='".$p['id_pembeli']."' $selected>".$p['nama_pembeli']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Unit Mobil</label>
                                <select name="id_mobil" class="form-select bubble-input">
                                    <?php
                                    $mobil = mysqli_query($conn, "SELECT * FROM mobil");
                                    while($m = mysqli_fetch_assoc($mobil)){
                                        $selected = ($m['id_mobil'] == $data['id_mobil']) ? "selected" : "";
                                        echo "<option value='".$m['id_mobil']."' $selected>".$m['nama_mobil']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Tanggal Transaksi</label>
                                <input type="date" name="tgl_transaksi" class="form-control bubble-input" value="<?= $data['tgl_transaksi']; ?>">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label">Total Pembayaran (Rp)</label>
                                <input type="number" name="total_bayar" class="form-control bubble-input" value="<?= $data['total_bayar']; ?>">
                            </div>
                        </div>

                        <div class="text-center mt-4 d-flex justify-content-center gap-3">
                            <a href="data_transaksi.php" class="btn-back">Batal</a>
                            <button type="submit" name="update" class="btn-update">Simpan Perubahan ✨</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>