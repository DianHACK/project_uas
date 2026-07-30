<?php
include '../koneksi.php';

$nama_kategori = $_POST['nama_kategori'];

// Cek duplikat
$cek = mysqli_query($koneksi, "SELECT * FROM kategori WHERE nama_kategori = '$nama_kategori'");
if (mysqli_num_rows($cek) > 0) {
    header("Location: ../../index.php?page=tambahkategori&error=duplikat");
    exit;
}

mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')");
header("Location: ../../index.php?page=tambahkategori");
