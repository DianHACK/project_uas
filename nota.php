<?php
session_start();
require_once "proses/koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_transaksi = $_GET['id'];
$transaksi_query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id = '$id_transaksi'");
$t = mysqli_fetch_assoc($transaksi_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Struk - <?= $t['no_invoice']; ?></title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            width: 300px;
            margin: 20px auto;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        .line { border-bottom: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; font-size: 13px; border-collapse: collapse; }
        th, td { padding: 4px 0; }
        @media print {
            body { width: 100%; margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="text-center">
        <h3 style="margin-bottom: 5px;">SMARTMART</h3>
        <p style="margin: 0; font-size: 12px;">Sistem Informasi Penjualan Barang</p>
        <p style="margin: 0; font-size: 11px;">Jl. Raya Swalayan No. 123</p>
    </div>

    <div class="line"></div>

    <div>
        <small>No Invoice : <?= $t['no_invoice']; ?></small><br>
        <small>Tanggal    : <?= $t['tanggal']; ?></small><br>
        <small>Kasir      : <?= $t['kasir']; ?></small>
    </div>

    <div class="line"></div>

    <table>
        <?php
        $detail = mysqli_query($koneksi, "SELECT detail_transaksi.*, barang.nama_barang FROM detail_transaksi JOIN barang ON detail_transaksi.id_barang = barang.id WHERE detail_transaksi.id_transaksi = '$id_transaksi'");
        while ($d = mysqli_fetch_assoc($detail)) {
        ?>
        <tr>
            <td colspan="2"><?= $d['nama_barang']; ?></td>
        </tr>
        <tr>
            <td><?= $d['jumlah']; ?> x <?= number_format($d['harga'], 0, ',', '.'); ?></td>
            <td class="text-end">Rp <?= number_format($d['subtotal'], 0, ',', '.'); ?></td>
        </tr>
        <?php } ?>
    </table>

    <div class="line"></div>

    <table>
        <tr>
            <td class="fw-bold">Total Harga</td>
            <td class="text-end fw-bold">Rp <?= number_format($t['total_harga'], 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td>Metode (<?= $t['metode_pembayaran']; ?>)</td>
            <td class="text-end">Rp <?= number_format($t['uang_bayar'], 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td>Kembalian</td>
            <td class="text-end">Rp <?= number_format($t['kembalian'], 0, ',', '.'); ?></td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="text-center" style="font-size: 12px;">
        <p>*** TERIMA KASIH TELAH BERBELANJA ***</p>
        <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
    </div>

    <div class="text-center no-print" style="margin-top: 20px;">
        <button onclick="window.print()" style="padding: 8px 15px; cursor: pointer;">Cetak Ulang</button>
        <a href="index.php?page=penjualan" style="display:inline-block; margin-top:10px; text-decoration:none; color:blue;">Kembali ke Kasir</a>
    </div>

</body>
</html>