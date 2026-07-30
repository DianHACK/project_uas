<?php
include '../koneksi.php';
$id_barang = $_POST['id_barang'];
$jumlah    = $_POST['jumlah'];

// Tambah ke keranjang
mysqli_query($koneksi, 
  "INSERT INTO keranjang (id_barang, jumlah) VALUES ('$id_barang', '$jumlah')");

header("Location: ../../index.php?page=penjualan");