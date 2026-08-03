<?php
session_start();
require_once "koneksi.php";

if (isset($_POST['proses_bayar'])) {
    $total_harga = $_POST['total_harga'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $uang_bayar = $_POST['uang_bayar'];
    $kembalian = $uang_bayar - $total_harga;
    
    $username = $_SESSION['username'];
    $user_query = mysqli_query($koneksi, "SELECT id FROM login WHERE username = '$username'");
    $user_data = mysqli_fetch_assoc($user_query);
    $id_user = $user_data['id'] ?? 1;

    // Validasi nominal uang bayar
    if ($uang_bayar < $total_harga) {
        $_SESSION['failed'] = "Uang bayar kurang dari total belanja!";
        header("Location: ../index.php?page=penjualan");
        exit();
    }

    // Generate No Invoice otomatis (Contoh: INV-20260803-0001)
    $tanggal_inv = date('Ymd');
    $cek_inv = mysqli_query($koneksi, "SELECT max(no_invoice) as maxKode FROM transaksi WHERE no_invoice LIKE 'INV-$tanggal_inv-%'");
    $data_inv = mysqli_fetch_assoc($cek_inv);
    $kodeBarang = $data_inv['maxKode'];
    $noUrut = (int) substr($kodeBarang, 13, 4);
    $noUrut++;
    $no_invoice = "INV-" . $tanggal_inv . "-" . sprintf("%04s", $noUrut);

    $tanggal = date('Y-m-d H:i:s');
    $kasir = $username;

    // 1. Simpan ke tabel transaksi utama
    $query_transaksi = mysqli_query($koneksi, "INSERT INTO transaksi (no_invoice, tanggal, total_harga, kasir, metode_pembayaran, uang_bayar, kembalian) VALUES ('$no_invoice', '$tanggal', '$total_harga', '$kasir', '$metode_pembayaran', '$uang_bayar', '$kembalian')");

    if ($query_transaksi) {
        $id_transaksi = mysqli_insert_id($koneksi);

        // Ambil isi keranjang user
        $query_cart = mysqli_query($koneksi, "SELECT keranjang.*, barang.harga FROM keranjang JOIN barang ON keranjang.id_barang = barang.id WHERE keranjang.id_user = '$id_user'");

        while ($cart = mysqli_fetch_assoc($query_cart)) {
            $id_barang = $cart['id_barang'];
            $jumlah = $cart['jumlah'];
            $harga = $cart['harga'];
            $subtotal = $jumlah * $harga;

            // 2. Simpan ke detail_transaksi
            mysqli_query($koneksi, "INSERT INTO detail_transaksi (id_transaksi, id_barang, jumlah, harga, subtotal) VALUES ('$id_transaksi', '$id_barang', '$jumlah', '$harga', '$subtotal')");

            // 3. Kurangi stok barang
            mysqli_query($koneksi, "UPDATE barang SET stok = stok - $jumlah WHERE id = '$id_barang'");
        }

        // 4. Kosongkan keranjang belanja user
        mysqli_query($koneksi, "DELETE FROM keranjang WHERE id_user = '$id_user'");

        // 5. Arahkan ke nota pembayaran (buka tab baru / langsung cetak)
        header("Location: ../nota.php?id=" . $id_transaksi);
        exit();
    } else {
        $_SESSION['failed'] = "Gagal memproses transaksi!";
        header("Location: ../index.php?page=penjualan");
        exit();
    }
}
?>