<?php
include '../koneksi.php';

$nama_rak = $_POST['nama_rak'];

// Cek apakah sudah ada nama rak yang sama
$cek = mysqli_query($koneksi, "SELECT * FROM rak WHERE nama_rak = '$nama_rak'");
if (mysqli_num_rows($cek) > 0) {
    // Redirect kembali ke form dengan pesan error
    header("Location: ../../index.php?page=tambahrak&error=duplikat");
    exit;
}

// Lanjut simpan
$query = "INSERT INTO rak (nama_rak) VALUES ('$nama_rak')";
mysqli_query($koneksi, $query);

header("Location: ../../index.php?page=datarak");
