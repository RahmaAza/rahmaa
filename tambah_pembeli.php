<?php
include 'config.php';
session_start();

// Proteksi Login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_pembeli']);
    $telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $query = "INSERT INTO pembeli (nama_pembeli, no_telp, alamat) VALUES ('$nama', '$telp', '$alamat')";
    if (mysqli_query($conn, $query)) {
        header("Location: data_pembeli.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✨ Tambah Pembeli Bubble ✨</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Fredoka', sans-serif;
            /* Background Animasi Gradasi */
            background: linear-gradient(-45deg, #23a6d5, #23d5ab, #ee7752, #e73c7e);
            background-size: 400% 400%;
            animation: gradientAnim 10s ease infinite;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh;
            margin: 0;
        }

        @keyframes gradientAnim {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .bubble-form {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 45px;
            border-radius: 50px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
            border: 10px solid #ffffff;
            transition: 0.3s ease;
        }

        .bubble-form:hover {
            transform: scale(1.02);
        }

        h3 {
            color: #23a6d5;
            font-weight: 700;
            text-shadow: 2px 2px #f0f0f0;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 700;
            color: #666;
            margin-left: 15px;
            font-size: 0.85rem;
        }

        /* Input Bergelembung Bulat */
        .form-control {
            border-radius: 30px;
            padding: 15px 25px;
            border: 3px solid #f1f2f6;
            background: #fdfdfd;
            transition: 0.3s;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #e73c7e;
            box-shadow: 0 0 15px rgba(231, 60, 126, 0.2);
            background: white;
        }

        textarea.form-control {
            border-radius: 25px;
        }

        /* Tombol Simpan Berwarna */
        .btn-save {
            background: linear-gradient(45deg, #e73c7e, #ee7752);
            color: white;
            border-radius: 30px;
            width: 100%;
            font-weight: 700;
            border: none;
            padding: 15px;
            font-size: 1.1rem;
            box-shadow: 0 10px 20px rgba(231, 60, 126, 0.3);
            transition: 0.4s;
            margin-top: 10px;
        }

        .btn-save:hover {
            background: linear-gradient(45deg, #23a6d5, #23d5ab);
            box-shadow: 0 10px 20px rgba(35, 166, 213, 0.3);
            transform: translateY(-3px);
            color: white;
        }

        .btn-cancel {
            text-decoration: none;
            color: #aaa;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-cancel:hover {
            color: #ff4b2b;
        }
    </style>
</head>
<body>
    <div class="bubble-form text-center">
        <h3>🚀 NEW PASSENGER</h3>
        <form method="POST">
            <div class="text-start mb-1">
                <label class="form-label">NAMA LENGKAP</label>
                <input type="text" name="nama_pembeli" class="form-control mb-3" placeholder="Masukkan Nama..." required>
            </div>

            <div class="text-start mb-1">
                <label class="form-label">NOMOR TELEPON</label>
                <input type="text" name="no_telp" class="form-control mb-3" placeholder="08xxxxxxxxx" required>
            </div>

            <div class="text-start mb-1">
                <label class="form-label">ALAMAT LENGKAP</label>
                <textarea name="alamat" class="form-control mb-3" placeholder="Masukkan Alamat Rumah..." rows="3" required></textarea>
            </div>

            <button type="submit" name="simpan" class="btn-save">DAFTARKAN PEMBELI</button>
            
            <a href="data_pembeli.php" class="btn-cancel d-inline-block mt-3">
                ✖ Batalkan Registrasi
            </a>
        </form>
    </div>
</body>
</html>