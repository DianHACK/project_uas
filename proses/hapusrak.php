<?php

require_once "koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: ../index.php?page=datarak");
    exit();
}

$id = (int) $_GET['id'];

// Cek apakah rak ada
$cekRak = mysqli_query($koneksi, "
    SELECT *
    FROM rak
    WHERE id='$id'
");

if (mysqli_num_rows($cekRak) == 0) {

    echo "<script>
        alert('Data rak tidak ditemukan.');
        window.location='../index.php?page=datarak';
    </script>";

    exit();
}

// Cek apakah rak masih digunakan oleh barang
$cekBarang = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total
    FROM barang
    WHERE id_rak='$id'
");

$dataBarang = mysqli_fetch_assoc($cekBarang);

if ($dataBarang['total'] > 0) {

    echo "<script>
        alert('Rak tidak dapat dihapus karena masih digunakan oleh data barang.');
        window.location='../index.php?page=datarak';
    </script>";

    exit();
}

// Hapus rak
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
