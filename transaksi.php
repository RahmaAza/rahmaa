<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }

// Proses Input Data
if (isset($_POST['proses'])) {
    $id_m = mysqli_real_escape_string($conn, $_POST['id_mobil']);
    $id_p = mysqli_real_escape_string($conn, $_POST['id_pembeli']);
    $tgl  = $_POST['tgl_transaksi'];

    // Ambil harga mobil
    $res_h = mysqli_query($conn, "SELECT harga_mobil FROM mobil WHERE id_mobil='$id_m'");
    $data_h = mysqli_fetch_assoc($res_h);
    $total = $data_h['harga_mobil'];

    // Perhatikan: nama kolom harus sama dengan di SQL tadi (id_pembeli)
    $query = "INSERT INTO transaksi (id_mobil, id_pembeli, tgl_transaksi, total_bayar) 
              VALUES ('$id_m', '$id_p', '$tgl', '$total')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Transaksi Berhasil! ✨'); window.location='data_transaksi.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Ambil List Data
$mobil_list = mysqli_query($conn, "SELECT * FROM mobil");
$pembeli_list = mysqli_query($conn, "SELECT * FROM pembeli");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bubble Transaction Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Fredoka', sans-serif;
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 99%, #fad0c4 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animasi Gelembung Latar Belakang */
        .bg-bubbles {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;
        }
        .bg-bubbles li {
            position: absolute; list-style: none; display: block;
            width: 40px; height: 40px; background-color: rgba(255, 255, 255, 0.15);
            bottom: -160px; border-radius: 50%;
            animation: square 20s infinite transition; transition-timing-function: linear;
        }
        @keyframes square {
            0% { transform: translateY(0); }
            100% { transform: translateY(-1000px) rotate(600deg); }
        }

        .bubble-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(15px);
            border: 5px solid white;
            border-radius: 40px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%; max-width: 450px;
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .form-control, .form-select {
            border-radius: 30px;
            border: 3px solid #fff;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            color: #ff6b6b;
            margin-bottom: 15px;
        }

        .btn-submit {
            background: linear-gradient(45deg, #ff6b6b, #ff9f43);
            border: none; border-radius: 30px; padding: 15px;
            font-weight: bold; color: white; width: 100%;
            font-size: 1.1rem; box-shadow: 0 10px 20px rgba(255, 107, 107, 0.3);
            transition: 0.3s;
        }

        .btn-submit:hover { transform: scale(1.05); color: white; }
    </style>
</head>
<body>

    <ul class="bg-bubbles">
        <li style="left: 10%; width: 80px; height: 80px; animation-delay: 0s;"></li>
        <li style="left: 20%; width: 40px; height: 40px; animation-delay: 2s; animation-duration: 17s;"></li>
        <li style="left: 70%; width: 100px; height: 100px; animation-delay: 4s;"></li>
        <li style="left: 90%; width: 60px; height: 60px; animation-delay: 1s;"></li>
    </ul>

    <div class="bubble-card">
        <h2 class="text-center mb-4" style="color: #fff; text-shadow: 2px 2px #ff6b6b;">🍬 TRANSACTION</h2>
        
        <form method="POST">
            <div class="mb-2 ms-3"><small class="text-white fw-bold">PILIH MOBIL</small></div>
            <select name="id_mobil" class="form-select" required>
                <?php while($m = mysqli_fetch_assoc($mobil_list)): ?>
                    <option value="<?= $m['id_mobil']; ?>"><?= $m['nama_mobil']; ?> (Rp<?= number_format($m['harga_mobil']); ?>)</option>
                <?php endwhile; ?>
            </select>

            <div class="mb-2 ms-3"><small class="text-white fw-bold">NAMA PEMBELI</small></div>
            <select name="id_pembeli" class="form-select" required>
                <?php while($p = mysqli_fetch_assoc($pembeli_list)): ?>
                    <option value="<?= $p['id_pembeli']; ?>"><?= $p['nama_pembeli']; ?></option>
                <?php endwhile; ?>
            </select>

            <div class="mb-2 ms-3"><small class="text-white fw-bold">TANGGAL TRANSAKSI</small></div>
            <input type="date" name="tgl_transaksi" class="form-control" value="<?= date('Y-m-d'); ?>" required>

            <button type="submit" name="proses" class="btn btn-submit mt-3">KIRIM TRANSAKSI 🚀</button>
            <a href="data_transaksi.php" class="d-block text-center mt-3 text-white text-decoration-none small">Kembali ke Data</a>
        </form>
    </div>

</body>
</html>