<?php
session_start();
require_once "koneksi.php";
require_once "helper.php";

if (!isset($_GET['id'])) {
    header("Location: ../index.php?page=datakategori");
    exit;
}

$id = (int) $_GET['id'];

// Ambil data kategori termasuk namanya untuk dicatat ke log
$cek = mysqli_query($koneksi, "
    SELECT nama_kategori
    FROM kategori
    WHERE id='$id'
");

if (mysqli_num_rows($cek) == 0) {
    echo "<script>
            alert('Data kategori tidak ditemukan.');
            window.location='../index.php?page=datakategori';
          </script>";
    exit;
}

$data = mysqli_fetch_assoc($cek);
$nama_kategori = $data['nama_kategori'];

$hapus = mysqli_query($koneksi, "
    DELETE FROM kategori
    WHERE id='$id'
");

if ($hapus) {

    // Catat aktivitas ke dalam Monitor Log
    catat_log($koneksi, "Menghapus kategori: " . $nama_kategori);

    echo "<script>
            alert('Kategori berhasil dihapus.');
            window.location='../index.php?page=datakategori';
          </script>";

} else {

    echo "<script>
            alert('Kategori gagal dihapus.');
            window.location='../index.php?page=datakategori';
          </script>";

}