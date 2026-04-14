<?php
include 'config.php';
session_start();

// Proteksi Login: Hanya pilot yang berwenang yang bisa akses
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Cek apakah ada ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    // Amankan ID dengan mysqli_real_escape_string
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Eksekusi perintah hapus
    $query = "DELETE FROM pembeli WHERE id_pembeli = '$id'";
    
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, balik ke manifest dengan sinyal sukses
        header("Location: data_pembeli.php?pesan=hapus_sukses");
        exit();
    } else {
        // Jika gagal karena masalah teknis database
        echo "<script>
                alert('Gagal menghapus data! Pastikan data tidak terikat dengan transaksi lain.');
                window.location.href='data_pembeli.php';
              </script>";
    }
} else {
    // Jika mencoba akses langsung tanpa ID, tendang balik ke manifest
    header("Location: data_pembeli.php");
    exit();
}
?>