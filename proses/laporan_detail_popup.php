<?php
include 'koneksi.php';
$id = $_GET['id'] ?? 0;

$detail = mysqli_query($koneksi, "
  SELECT d.jumlah, d.subtotal, b.nama_barang 
  FROM detail_transaksi d 
  JOIN barang b ON d.id_barang = b.id 
  WHERE d.id_transaksi = '$id'
");

if (mysqli_num_rows($detail) === 0) {
  echo "<div class='alert alert-warning text-center'>❌ Detail transaksi tidak ditemukan.<br>Coba pastikan transaksi sudah punya isi atau barangnya valid.</div>";
  exit;
}

echo "<table class='table table-sm table-bordered'>";
echo "<thead class='table-light'><tr><th>Barang</th><th>Jumlah</th><th>Subtotal</th></tr></thead><tbody>";

while($d = mysqli_fetch_assoc($detail)) {
  echo "<tr>
    <td>{$d['nama_barang']}</td>
    <td>{$d['jumlah']}</td>
    <td>Rp " . number_format($d['subtotal'], 0, ',', '.') . "</td>
  </tr>";
}

echo "</tbody></table>";