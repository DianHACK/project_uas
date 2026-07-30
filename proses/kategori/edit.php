<?php
include '../koneksi.php';

$id = $_POST['id'];
$nama_kategori = $_POST['nama_kategori'];

// Cek duplikat (kecuali ID yg sedang diedit)
$cek = mysqli_query($koneksi, "SELECT * FROM kategori WHERE nama_kategori = '$nama_kategori' AND id != '$id'");
if (mysqli_num_rows($cek) > 0) {
    header("Location: ../../index.php?page=tambahkategori&id=$id&error=duplikat");
    exit;
}

mysqli_query($koneksi, "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id = '$id'");
header("Location: ../../index.php?page=datakategori");
