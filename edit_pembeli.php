<?php
include 'config.php';
session_start();

// Proteksi Login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
// Pastikan ID aman
$id = mysqli_real_escape_string($conn, $id);
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pembeli WHERE id_pembeli=$id"));

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_pembeli']);
    $telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    mysqli_query($conn, "UPDATE pembeli SET nama_pembeli='$nama', no_telp='$telp', alamat='$alamat' WHERE id_pembeli=$id");
    header("Location: data_pembeli.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bubble Edit - Pembeli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Fredoka', sans-serif; 
            /* Background Animasi Gradasi */
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            margin: 0;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .bubble-form { 
            background: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(10px);
            padding: 40px; 
            border-radius: 40px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.2); 
            width: 100%; 
            max-width: 450px; 
            border: 8px solid #ffffff;
            transform: scale(1);
            transition: 0.3s;
        }

        .bubble-form:hover {
            transform: translateY(-5px);
        }

        h3 { 
            color: #e73c7e; 
            font-weight: 700; 
            text-shadow: 2px 2px #f0f0f0;
            letter-spacing: 1px;
        }

        .form-label {
            margin-left: 15px;
            font-weight: 700;
            color: #555;
            font-size: 0.9rem;
        }

        /* Input Bergelembung */
        .form-control { 
            border-radius: 30px; 
            margin-bottom: 20px; 
            padding: 15px 25px;
            border: 3px solid #f0f0f0;
            background: #f9f9f9;
            transition: 0.3s;
            color: #333;
            font-weight: 500;
        }

        .form-control:focus { 
            border-color: #23a6d5; 
            background: white;
            box-shadow: 0 0 15px rgba(35, 166, 213, 0.3);
            transform: scale(1.02);
        }

        textarea.form-control {
            border-radius: 20px;
        }

        /* Tombol Pelangi */
        .btn-update { 
            background: linear-gradient(to right, #ff416c, #ff4b2b);
            color: white; 
            border-radius: 30px; 
            width: 100%; 
            font-weight: 700; 
            border: none; 
            padding: 15px; 
            font-size: 1.1rem;
            box-shadow: 0 10px 20px rgba(255, 65, 108, 0.4);
            transition: 0.4s;
            text-transform: uppercase;
        }

        .btn-update:hover { 
            background: linear-gradient(to right, #23a6d5, #23d5ab);
            box-shadow: 0 10px 20px rgba(35, 166, 213, 0.4);
            transform: scale(1.05);
            color: white;
        }

        .btn-cancel {
            text-decoration: none;
            color: #888;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-cancel:hover {
            color: #e73c7e;
        }
    </style>
</head>
<body>
    <div class="bubble-form">
        <h3 class="text-center mb-4">✨ EDIT PASSENGER ✨</h3>
        <form method="POST">
            <div class="mb-1">
                <label class="form-label text-uppercase">Nama Lengkap</label>
                <input type="text" name="nama_pembeli" class="form-control" placeholder="Masukkan Nama..." value="<?= $data['nama_pembeli']; ?>" required>
            </div>
            
            <div class="mb-1">
                <label class="form-label text-uppercase">No. Telepon</label>
                <input type="text" name="no_telp" class="form-control" placeholder="08xxxxxx" value="<?= $data['no_telp']; ?>" required>
            </div>

            <div class="mb-1">
                <label class="form-label text-uppercase">Alamat Tinggal</label>
                <textarea name="alamat" class="form-control" placeholder="Alamat lengkap..." rows="3" required><?= $data['alamat']; ?></textarea>
            </div>

            <button type="submit" name="update" class="btn btn-update mt-2">Update Data Sekarang!</button>
            
            <div class="text-center mt-3">
                <a href="data_pembeli.php" class="btn-cancel">✖ Batal & Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>