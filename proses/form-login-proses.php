<?php
session_start();
require_once "koneksi.php";

// Ambil data dari inputan form
$username = mysqli_real_escape_string($koneksi, $_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validasi jika kosong
if (empty($username) || empty($password)) {
    $_SESSION['failed'] = "Username dan Password wajib diisi!";
    header("Location: ../form-login.php");
    exit();
}

// Cek database
$query = mysqli_query($koneksi, "SELECT * FROM login WHERE username = '$username'");

if ($query && mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);

    // Verifikasi password yang di-hash di database
    if (password_verify($password, $data['password'])) {
        
        // Set session login agar lolos dari penjagaan index.php
        $_SESSION['login'] = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['login_time'] = time(); // Untuk auto logout 30 menit
        
        // Redirect ke dashboard utama
        header("Location: ../index.php");
        exit();

    } else {
        $_SESSION['failed'] = "Password yang Anda masukkan salah!";
        header("Location: ../form-login.php");
        exit();
    }
} else {
    $_SESSION['failed'] = "Username tidak terdaftar di database!";
    header("Location: ../form-login.php");
    exit();
}
?>