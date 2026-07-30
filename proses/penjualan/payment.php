<?php
include '../koneksi.php';
$tanggal = date('Y-m-d');
$kasir = 'admin'; // bisa diganti dengan $_SESSION jika sudah login

// Ambil isi keranjang
$keranjang = mysqli_query($koneksi, "SELECT * FROM keranjang");

// Hitung total
$total = 0;
while($row = mysqli_fetch_array($keranjang)) {
  $id_barang = $row['id_barang'];
  $jumlah    = $row['jumlah'];
  $harga     = mysqli_fetch_array(mysqli_query($koneksi, 
                "SELECT harga FROM barang WHERE id = '$id_barang'"))['harga'];
  $subtotal  = $harga * $jumlah;
  $total    += $subtotal;
}

// Simpan transaksi
mysqli_query($koneksi, 
  "INSERT INTO transaksi (tanggal, total_harga, kasir) VALUES ('$tanggal', '$total', '$kasir')");
$id_transaksi = mysqli_insert_id($koneksi);

// Simpan detail transaksi dan kurangi stok barang
mysqli_data_seek($keranjang, 0); // ulangi dari awal data keranjang
while($row = mysqli_fetch_array($keranjang)) {
  $id_barang = $row['id_barang'];
  $jumlah    = $row['jumlah'];
  $harga     = mysqli_fetch_array(mysqli_query($koneksi, 
                "SELECT harga FROM barang WHERE id = '$id_barang'"))['harga'];
  $subtotal  = $harga * $jumlah;

  mysqli_query($koneksi, 
    "INSERT INTO detail_transaksi (id_transaksi, id_barang, jumlah, subtotal) 
     VALUES ('$id_transaksi', '$id_barang', '$jumlah', '$subtotal')");

  mysqli_query($koneksi, 
    "UPDATE barang SET stok = stok - '$jumlah' WHERE id = '$id_barang'");
}

// Kosongkan keranjang
mysqli_query($koneksi, "DELETE FROM keranjang");

// Redirect ke halaman utama atau bisa ke halaman struk nanti
echo "<script>
  alert('Pembayaran Berhasil!');
  window.location.href='../../index.php?page=penjualan';
</script>";