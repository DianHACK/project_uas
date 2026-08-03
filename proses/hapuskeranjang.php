<?php
session_start();
require_once "koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM keranjang WHERE id = '$id'");
}

header("Location: ../index.php?page=penjualan");
exit();
?>