<?php
session_start();
require_once "koneksi.php";

if (isset($_POST['tambah_keranjang'])) {
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    
    // Ambil ID user yang sedang login dari tabel login/user
    $username = $_SESSION['username'];
    $user_query = mysqli_query($koneksi, "SELECT id FROM login WHERE username = '$username'");
    $user_data = mysqli_fetch_assoc($user_query);
    $id_user = $user_data['id'] ?? 1;

    // Cek stok barang
    $barang_query = mysqli_query($koneksi, "SELECT stok FROM barang WHERE id = '$id_barang'");
    $barang_data = mysqli_fetch_assoc($barang_query);
    
    if ($jumlah > $barang_data['stok']) {
        $_SESSION['failed'] = "Stok barang tidak mencukupi!";
        header("Location: ../index.php?page=penjualan");
        exit();
    }

    // Cek apakah barang sudah ada di keranjang user ini
    $cek_keranjang = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_barang = '$id_barang' AND id_user = '$id_user'");
    
    if (mysqli_num_rows($cek_keranjang) > 0) {
        $row = mysqli_fetch_assoc($cek_keranjang);
        $new_jumlah = $row['jumlah'] + $jumlah;
        
        // Update jumlah jika sudah ada
        mysqli_query($koneksi, "UPDATE keranjang SET jumlah = '$new_jumlah' WHERE id_barang = '$id_barang' AND id_user = '$id_user'");
    } else {
        // Insert baru jika belum ada
        mysqli_query($koneksi, "INSERT INTO keranjang (id_barang, jumlah, id_user) VALUES ('$id_barang', '$jumlah', '$id_user')");
    }

    header("Location: ../index.php?page=penjualan");
    exit();
}
?>