<?php
include '../koneksi.php';

$id_barang = $_POST['id_barang'];
$jumlah = $_POST['jumlah'];
$tanggal = date("Y-m-d");

// Ambil harga barang
$q = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id = '$id_barang'");
$data = mysqli_fetch_array($q);
$harga = $data['harga'];
$subtotal = $harga * $jumlah;

// Simpan ke tabel transaksi
mysqli_query($koneksi, "INSERT INTO transaksi (tanggal, total_harga, kasir) VALUES ('$tanggal', '$subtotal', 'kasir1')");
$id_transaksi = mysqli_insert_id($koneksi);

// Simpan ke detail_transaksi
mysqli_query($koneksi, "INSERT INTO detail_transaksi (id_transaksi, id_barang, jumlah, subtotal) VALUES ('$id_transaksi', '$id_barang', '$jumlah', '$subtotal')");

// Update stok
mysqli_query($koneksi, "UPDATE barang SET stok = stok - '$jumlah' WHERE id = '$id_barang'");

header("Location: ../../index.php?page=penjualan");
?>