<?php
session_start();
require_once "koneksi.php";

// ====================================
// VALIDASI LOGIN
// ====================================

if (!isset($_SESSION['login'])) {
    exit("Session login tidak ditemukan");
}

$id_user = $_SESSION['login'];

$id_keranjang = isset($_POST['id']) ? intval($_POST['id']) : 0;
$aksi = isset($_POST['aksi']) ? $_POST['aksi'] : '';

if ($id_keranjang <= 0 || empty($aksi)) {
    exit("Data tidak valid");
}

// ====================================
// AMBIL DATA KERANJANG
// ====================================

$query = mysqli_query($koneksi, "
SELECT
    keranjang.*,
    barang.stok
FROM keranjang
JOIN barang
ON barang.id = keranjang.id_barang
WHERE
    keranjang.id='$id_keranjang'
AND
    keranjang.id_user='$id_user'
");

if (mysqli_num_rows($query) == 0) {
    exit("Data tidak ditemukan");
}

$data = mysqli_fetch_assoc($query);

$jumlah = (int)$data['jumlah'];
$stok   = (int)$data['stok'];

// ====================================
// TOMBOL PLUS
// ====================================

if ($aksi == "plus") {

    if ($jumlah >= $stok) {
        exit("Stok habis");
    }

    $jumlah++;

    mysqli_query($koneksi, "
        UPDATE keranjang
        SET jumlah='$jumlah'
        WHERE id='$id_keranjang'
    ");

    echo "berhasil";
    exit();
}

// ====================================
// TOMBOL MINUS
// ====================================

if ($aksi == "minus") {

    $jumlah--;

    if ($jumlah <= 0) {

        mysqli_query($koneksi, "
            DELETE FROM keranjang
            WHERE id='$id_keranjang'
        ");

        echo "berhasil";
        exit();

    }

    mysqli_query($koneksi, "
        UPDATE keranjang
        SET jumlah='$jumlah'
        WHERE id='$id_keranjang'
    ");

    echo "berhasil";
    exit();
}

echo "Aksi tidak dikenal";