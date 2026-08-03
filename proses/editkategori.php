<?php
session_start();
require_once "koneksi.php";
require_once "helper.php";

if (!isset($_POST['update'])) {
    header("Location: ../index.php?page=datakategori");
    exit;
}

$id = (int) $_POST['id'];
$nama = trim($_POST['nama_kategori']);

// ==========================
// Validasi
// ==========================

if (empty($nama)) {
    echo "<script>
            alert('Nama kategori tidak boleh kosong.');
            window.history.back();
          </script>";
    exit;
}

// ==========================
// Cek Duplikat
// ==========================

$cek = mysqli_query($koneksi, "
    SELECT id
    FROM kategori
    WHERE nama_kategori='$nama'
    AND id != '$id'
");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>
            alert('Nama kategori sudah digunakan.');
            window.history.back();
          </script>";
    exit;
}

// ==========================
// Update Data
// ==========================

$update = mysqli_query($koneksi, "
    UPDATE kategori
    SET nama_kategori='$nama'
    WHERE id='$id'
");

// ==========================
// Redirect & Catat Log
// ==========================

if ($update) {

    // Catat aktivitas ke dalam Monitor Log
    catat_log($koneksi, "Memperbarui data kategori menjadi: " . $nama);

    echo "<script>
            alert('Kategori berhasil diperbarui.');
            window.location='../index.php?page=datakategori';
          </script>";

} else {

    echo "<script>
            alert('Kategori gagal diperbarui.');
            window.history.back();
          </script>";

}