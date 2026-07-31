<?php

require_once "koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: ../index.php?page=datarak");
    exit();
}

$id = (int) $_GET['id'];

// Cek apakah data rak ada
$cek = mysqli_query($koneksi, "
    SELECT *
    FROM rak
    WHERE id='$id'
");

if (mysqli_num_rows($cek) == 0) {

    echo "<script>
        alert('Data rak tidak ditemukan.');
        window.location='../index.php?page=datarak';
    </script>";

    exit();
}

// Hapus data
$hapus = mysqli_query($koneksi, "
    DELETE FROM rak
    WHERE id='$id'
");

if ($hapus) {

    echo "<script>
        alert('Data rak berhasil dihapus.');
        window.location='../index.php?page=datarak';
    </script>";
} else {

    echo "<script>
        alert('Data rak gagal dihapus.');
        window.location='../index.php?page=datarak';
    </script>";
}
