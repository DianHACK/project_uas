<?php
// Ambil isi keranjang
$keranjang = mysqli_query($koneksi, 
  "SELECT k.id, b.nama_barang, b.harga, k.jumlah 
   FROM keranjang k 
   JOIN barang b ON k.id_barang = b.id");

$total = 0;
?>

<div class="container py-5">
  <h3 class="mb-4">🛒 Isi Keranjang</h3>
  <table class="table table-bordered table-hover">
    <thead class="">
      <tr>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_array($keranjang)) { 
        $subtotal = $row['harga'] * $row['jumlah'];
        $total += $subtotal;
      ?>
      <tr>
        <td><?= $row['nama_barang'] ?></td>
        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
        <td><?= $row['jumlah'] ?></td>
        <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr class="table-secondary">
        <th colspan="3" class="text-end">Total Bayar:</th>
        <th>Rp <?= number_format($total, 0, ',', '.') ?></th>
      </tr>
    </tfoot>
  </table>
        
  <form method="POST" action="proses/penjualan/payment.php">
    <button type="submit" class="btn btn-success">💳 Bayar Sekarang</button>
  </form>
</div>