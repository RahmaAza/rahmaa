<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) { 
    header("Location: login.php"); 
    exit(); 
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM mobil WHERE id_mobil=$id");
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        echo "Data tidak ditemukan!";
        exit();
    }
} else {
    header("Location: jenis_mobil.php");
    exit();
}

if (isset($_POST['update'])) {
    $id = $_POST['id_mobil'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama_mobil']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga_mobil']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun_keluar']);
    $tipe = mysqli_real_escape_string($conn, $_POST['jenis_tipe']);

    $query_update = "UPDATE mobil SET 
                    nama_mobil='$nama', 
                    harga_mobil='$harga', 
                    tahun_keluar='$tahun', 
                    jenis_tipe='$tipe' 
                    WHERE id_mobil=$id";

    if (mysqli_query($conn, $query_update)) {
        header("Location: jenis_mobil.php");
        exit();
    } else {
        $error = "Gagal mengupdate data!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Unit - Colorful Bubble</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #6c5ce7;
            --secondary-bg: #a29bfe;
            --accent-color: #fd79a8;
            --bubble-color: #fab1a0;
        }

        body {
            font-family: 'Fredoka', sans-serif;
            background: linear-gradient(45deg, #6c5ce7, #00cec9, #fab1a0, #fd79a8);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow-x: hidden;
            position: relative;
        }

        /* Animasi Background Bergerak */
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Gelembung Dekoratif di Belakang */
        .bg-bubbles {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
        }
        .bg-bubbles li {
            position: absolute;
            list-style: none;
            display: block;
            width: 40px; height: 40px;
            background-color: rgba(255, 255, 255, 0.15);
            bottom: -160px;
            border-radius: 50%;
            animation: bubbleMove 25s infinite linear;
        }
        @keyframes bubbleMove {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; }
            100% { transform: translateY(-1000px) rotate(720deg); opacity: 0; }
        }

        .edit-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            z-index: 1;
        }

        /* Kartu Utama Bergelembung & Melayang */
        .bubble-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            border-radius: 50px;
            padding: 40px;
            box-shadow: 0 25px 45px rgba(0,0,0,0.2);
            border: 2px solid rgba(255,255,255,0.3);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        h2 { 
            color: white; 
            text-align: center; 
            font-weight: 700; 
            margin-bottom: 25px; 
            text-shadow: 3px 3px 0px rgba(0,0,0,0.1);
        }

        /* Input dengan desain membulat/bergelembung */
        .form-label { color: white; font-weight: 600; margin-left: 15px; }

        .form-control, .form-select {
            border-radius: 30px;
            border: 3px solid transparent;
            padding: 12px 20px;
            margin-bottom: 15px;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 20px rgba(253, 121, 168, 0.4);
            transform: scale(1.02);
        }

        .btn-update {
            background: linear-gradient(to right, #fd79a8, #e84393);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 15px;
            width: 100%;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 20px rgba(232, 67, 147, 0.4);
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-update:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 25px rgba(232, 67, 147, 0.6);
            color: white;
        }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-back:hover { color: #fab1a0; transform: translateX(-5px); }
    </style>
</head>
<body>

<ul class="bg-bubbles">
    <li style="left: 10%; width: 80px; height: 80px; animation-delay: 0s;"></li>
    <li style="left: 20%; width: 30px; height: 30px; animation-delay: 2s; animation-duration: 17s;"></li>
    <li style="left: 25%; width: 50px; height: 50px; animation-delay: 4s;"></li>
    <li style="left: 40%; width: 60px; height: 60px; animation-delay: 0s; animation-duration: 22s;"></li>
    <li style="left: 70%; width: 90px; height: 90px; animation-delay: 7s;"></li>
    <li style="left: 80%; width: 40px; height: 40px; animation-delay: 1s; animation-duration: 13s;"></li>
</ul>

<div class="edit-container">
    <div class="bubble-card">
        <h2>✨ Edit Unit Mobil ✨</h2>
        
        <form method="POST" action="">
            <input type="hidden" name="id_mobil" value="<?= $data['id_mobil']; ?>">

            <label class="form-label">Nama Mobil</label>
            <input type="text" name="nama_mobil" class="form-control" value="<?= $data['nama_mobil']; ?>" required>

            <label class="form-label">Harga OTR (Rp)</label>
            <input type="number" name="harga_mobil" class="form-control" value="<?= $data['harga_mobil']; ?>" required>

            <label class="form-label">Tahun Keluar</label>
            <input type="number" name="tahun_keluar" class="form-control" value="<?= $data['tahun_keluar']; ?>" required>

            <label class="form-label">Tipe Kendaraan</label>
            <select name="jenis_tipe" class="form-select">
                <option value="Sedan" <?= $data['jenis_tipe'] == 'Sedan' ? 'selected' : ''; ?>>Sedan</option>
                <option value="SUV" <?= $data['jenis_tipe'] == 'SUV' ? 'selected' : ''; ?>>SUV</option>
                <option value="MPV" <?= $data['jenis_tipe'] == 'MPV' ? 'selected' : ''; ?>>MPV</option>
                <option value="Electric" <?= $data['jenis_tipe'] == 'Electric' ? 'selected' : ''; ?>>Electric</option>
            </select>

            <button type="submit" name="update" class="btn btn-update">Simpan Perubahan</button>
        </form>

        <a href="jenis_mobil.php" class="btn-back">← Kembali ke List</a>
    </div>
</div>

</body>
</html>