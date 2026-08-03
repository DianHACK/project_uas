<?php
session_start();

// Panggil file koneksi database
require_once "proses/koneksi.php";

// Catat log aktivitas sebelum sesi dihancurkan
$username_log = $_SESSION['username'] ?? 'Administrator';
$aktivitas_log = "Melakukan logout dari sistem";

mysqli_query($koneksi, "INSERT INTO log_aktivitas (username, aktivitas) VALUES ('$username_log', '$aktivitas_log')");

// Hapus semua session
session_unset();
session_destroy();

// Redirect kembali ke halaman login
header("Location: form-login.php");
exit();
?>