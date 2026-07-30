<?php
include 'koneksi.php';
$id = $_GET['id'] ?? 0;

$t = mysqli_fetch_assoc(mysqli_query($koneksi, 
  "SELECT * FROM transaksi WHERE id_transaksi = '$id'"
));
if (!$t) {
  echo "<div class='alert alert-danger'>❌ Transaksi tidak ditemukan.</div>";
  exit;
}

$detail = mysqli_query($koneksi, "
  SELECT d.jumlah, d.subtotal, b.nama_barang 
  FROM detail_transaksi d 
  JOIN barang b ON d.id_barang = b.id 
  WHERE d.id_transaksi = '$id'
");
?>

<style>
@media print {
  body {
    font-family: sans-serif;
    font-size: 13px;
    margin: 20px;
  }
  .no-print {
    display: none !important;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  th, td {
    padding: 6px;
    border: 1px solid #ccc;
  }
}
</style>

<div id="printArea" class="p-3">
  <h5 class="text-center mb-2">🛒 Swalayan TriMart</h5>
  <hr>
  <h6>Struk Transaksi #<?= $id ?></h6>
  <p>
    <strong>Kasir:</strong> <?= $t['kasir'] ?><br>
    <strong>Tanggal:</strong> <?= $t['tanggal'] ?>
  </p>

  <table class="table table-sm table-bordered mb-3">
    <thead class="table-light">
      <tr><th>Barang</th><th>Jumlah</th><th>Subtotal</th></tr>
    </thead>
    <tbody>
      <?php while($d = mysqli_fetch_assoc($detail)) { ?>
      <tr>
        <td><?= $d['nama_barang'] ?></td>
        <td><?= $d['jumlah'] ?></td>
        <td>Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <h6 class="text-end">Total: Rp <?= number_format($t['total_harga'], 0, ',', '.') ?></h6>
</div>

<!-- Tombol cetak (tidak tercetak) -->
<div class="no-print text-end mt-3">
  <button onclick="printStruk()" class="btn btn-success btn-sm">🖨️ Cetak Struk</button>
</div>

<script>
function printStruk() {
  const isi = document.getElementById('printArea').innerHTML;
  const win = window.open('', '', 'width=600,height=700');
  win.document.write(`
    <html>
      <head>
        <title>Struk Transaksi</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <style>
          body { font-family: sans-serif; font-size: 13px; margin: 20px; }
          table { width: 100%; border-collapse: collapse; }
          th, td { padding: 6px; border: 1px solid #ccc; }
        </style>
      </head>
      <body>${isi}</body>
    </html>
  `);
  win.document.close();
  win.focus();
  win.print();
  win.onafterprint = () => win.close();
}
</script>