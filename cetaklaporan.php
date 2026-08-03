<?php
session_start();
require_once "proses/koneksi.php";

$tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';

$where = "";
if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
    $where = "WHERE DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
}

$query = mysqli_query($koneksi, "SELECT * FROM transaksi $where ORDER BY id DESC");

// Hitung total
$query_sum = mysqli_query($koneksi, "SELECT COUNT(*) as total_transaksi, SUM(total_harga) as total_pendapatan FROM transaksi $where");
$data_sum = mysqli_fetch_assoc($query_sum);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Penjualan SmartMart</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; margin: 20px; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .text-end { text-align: right; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="text-center">
        <h2>LAPORAN PENJUALAN SMARTMART</h2>
        <p style="margin: 2px 0;">Sistem Informasi Manajemen Supermarket</p>
        <?php if (!empty($tgl_mulai) && !empty($tgl_selesai)) { ?>
            <p>Periode: <?= date('d-m-Y', strtotime($tgl_mulai)); ?> s/d <?= date('d-m-Y', strtotime($tgl_selesai)); ?></p>
        <?php } else { ?>
            <p>Seluruh Riwayat Transaksi</p>
        <?php } ?>
    </div>

    <hr style="margin: 20px 0; border: 1px solid #ccc;">

    <div style="margin-bottom: 15px;">
        <strong>Total Transaksi: </strong> <?= $data_sum['total_transaksi'] ?? 0; ?> Transaksi<br>
        <strong>Total Pendapatan: </strong> Rp <?= number_format($data_sum['total_pendapatan'] ?? 0, 0, ',', '.'); ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Invoice</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Metode</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($query) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['no_invoice']; ?></td>
                <td><?= $row['tanggal']; ?></td>
                <td><?= $row['kasir']; ?></td>
                <td><?= $row['metode_pembayaran']; ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
            </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Tidak ada data transaksi.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="no-print text-center" style="margin-top: 25px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Cetak Ulang</button>
        <a href="index.php?page=laporan" style="margin-left: 10px; text-decoration: none; color: blue;">Kembali ke Dashboard</a>
    </div>

</body>
</html>