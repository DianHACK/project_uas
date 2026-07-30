<?php

require_once "koneksi.php";

if (!isset($_GET['id'])) {

    header("Location: ../index.php?page=datakategori");
    exit;

}

$id = (int) $_GET['id'];

$cek = mysqli_query($koneksi, "
    SELECT id
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

$hapus = mysqli_query($koneksi, "
    DELETE FROM kategori
    WHERE id='$id'
");

if ($hapus) {

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