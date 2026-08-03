<?php

require_once "../proses/koneksi.php";
session_start();

$id_user = $_SESSION['login'];

$totalItem = 0;
$totalBelanja = 0;

$query = mysqli_query($koneksi,"
SELECT
    keranjang.id,
    keranjang.jumlah,
    barang.id AS id_barang,
    barang.kode_barang,
    barang.nama_barang,
    barang.harga,
    barang.stok,
    (barang.harga * keranjang.jumlah) AS subtotal
FROM keranjang
JOIN barang
ON barang.id = keranjang.id_barang
WHERE keranjang.id_user='$id_user'
ORDER BY keranjang.id DESC
");

?>

<div class="card shadow-sm border-0">

    <div class="card-header bg-success text-white">

        <div class="d-flex justify-content-between">

            <h5 class="mb-0">

                <i class="ti ti-shopping-cart"></i>

                Keranjang Belanja

            </h5>

            <span class="badge bg-light text-success">

                <?= mysqli_num_rows($query) ?> Item

            </span>

        </div>

    </div>

    <div class="card-body p-0">

<?php

if(mysqli_num_rows($query)>0){

?>

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-light">

<tr>

<th>No</th>

<th>Barang</th>

<th>Harga</th>

<th>Qty</th>

<th>Subtotal</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($r=mysqli_fetch_assoc($query)):

$totalItem += $r['jumlah'];
$totalBelanja += $r['subtotal'];

?>

<tr>

<td><?= $no++ ?></td>

<td>

<strong><?= $r['nama_barang'] ?></strong>

<br>

<small class="text-muted">

<?= $r['kode_barang'] ?>

</small>

</td>

<td>

Rp<?= number_format($r['harga'],0,",",".") ?>

</td>

<td>

<div class="btn-group">

<button
class="btn btn-outline-danger btnMinus"
data-id="<?= $r['id'] ?>">

-

</button>

<input
type="text"
value="<?= $r['jumlah'] ?>"
class="form-control text-center"
style="width:60px"
readonly>

<button
class="btn btn-outline-success btnPlus"
data-id="<?= $r['id'] ?>">

+

</button>

</div>

</td>

<td>

<strong class="text-success">

Rp<?= number_format($r['subtotal'],0,",",".") ?>

</strong>

</td>

<td>

<button
class="btn btn-danger btnHapus"
data-id="<?= $r['id'] ?>">

<i class="ti ti-trash"></i>

</button>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php

}else{

?>

<div class="text-center py-5">

<i class="ti ti-shopping-cart-off display-3 text-secondary"></i>

<h5 class="mt-3">

Keranjang Masih Kosong

</h5>

<p class="text-muted">

Silakan pilih barang terlebih dahulu.

</p>

</div>

<?php } ?>

</div>

<div class="card-footer bg-light">

<div class="row">

<div class="col-md-6">

<h6>Total Item</h6>

<h3 class="text-primary">

<?= $totalItem ?>

</h3>

</div>

<div class="col-md-6 text-end">

<h6>Total Belanja</h6>

<h3 class="text-success">

Rp<?= number_format($totalBelanja,0,",",".") ?>

</h3>

</div>

</div>

</div>

</div>