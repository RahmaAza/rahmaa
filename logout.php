<?php
session_start();
session_unset();
session_destroy(); // Menghapus semua data login

// Melempar kembali ke halaman login
header("Location: index.php");
exit();
?>