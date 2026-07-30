<?php
include 'koneksi.php';

// Ambil parameter filter
$dari = $_GET['dari'] ?? '';
$sampai = $_GET['sampai'] ?? '';

$query = "SELECT * FROM transaksi";
if ($dari && $sampai) {
  $query .= " WHERE tanggal BETWEEN '$dari' AND '$sampai'";
}
$query .= " ORDER BY tanggal DESC";

$transaksi = mysqli_query($koneksi, $query);

// Header swalayan
echo "<h4 class='mb-4'>🧾 Laporan Transaksi Swalayan</h4>";
echo "<p><strong>Periode:</strong> " . date('d M Y', strtotime($dari)) . " - " . date('d M Y', strtotime($sampai)) . "</p>";

while($t = mysqli_fetch_assoc($transaksi)) {
  $id = $t['id_transaksi'];
  $detail = mysqli_query($koneksi, "
    SELECT d.jumlah, d.subtotal, b.nama_barang 
    FROM detail_transaksi d 
    JOIN barang b ON d.id_barang = b.id 
    WHERE d.id_transaksi = '$id'
  ");

  echo "<div class='border p-3 mb-4'>";
  echo "<h6>Transaksi #{$id}</h6>";
  echo "<p><strong>Tanggal:</strong> {$t['tanggal']} &nbsp; | &nbsp; <strong>Kasir:</strong> {$t['kasir']}</p>";

  echo "<table class='table table-sm table-bordered mb-2'>";
  echo "<thead class='table-light'><tr><th>Barang</th><th>Jumlah</th><th>Subtotal</th></tr></thead><tbody>";
  while($d = mysqli_fetch_assoc($detail)) {
    echo "<tr>
      <td>{$d['nama_barang']}</td>
      <td>{$d['jumlah']}</td>
      <td>Rp " . number_format($d['subtotal'], 0, ',', '.') . "</td>
    </tr>";
  }
  echo "</tbody></table>";

  echo "<p class='text-end fw-bold mb-0'>Total: Rp " . number_format($t['total_harga'], 0, ',', '.') . "</p>";
  echo "</div>";
}

// Cetak tombol cetak ulang kalau diperlukan
echo "<div class='no-print mt-3 text-end'><button onclick='window.print()' class='btn btn-primary'>🖨️ Cetak Sekarang</button></div>";