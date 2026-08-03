<?php
session_start();
require_once "koneksi.php";
require_once "helper.php";

if (!isset($_POST['simpan'])) {
    header("Location: ../index.php?page=datakategori");
    exit;
}

$nama = trim($_POST['nama_kategori']);

// ==========================
// Validasi Input
// ==========================

if (empty($nama)) {
    echo "<script>
            alert('Nama kategori tidak boleh kosong!');
            window.history.back();
          </script>";
    exit;
}

// ==========================
// Cek Data Duplikat
// ==========================

$cek = mysqli_query($koneksi, "
    SELECT id
    FROM kategori
    WHERE nama_kategori = '$nama'
");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>
            alert('Kategori sudah tersedia!');
            window.history.back();
          </script>";
    exit;
}

// ==========================
// Simpan Data
// ==========================

$simpan = mysqli_query($koneksi, "
    INSERT INTO kategori
    (
        nama_kategori,
        created_at
    )
    VALUES
    (
        '$nama',
        NOW()
    )
");

// ==========================
// Redirect & Catat Log
// ==========================

if ($simpan) {

    // Catat aktivitas ke dalam Monitor Log
    catat_log($koneksi, "Menambahkan kategori baru: " . $nama);

    echo "<script>
            alert('Kategori berhasil ditambahkan.');
            window.location='../index.php?page=datakategori';
          </script>";

} else {

    echo "<script>
            alert('Kategori gagal ditambahkan.');
            window.history.back();
          </script>";

}