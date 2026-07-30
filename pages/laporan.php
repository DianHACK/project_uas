<?php
include 'proses/koneksi.php';

$dari = $_GET['dari'] ?? '';
$sampai = $_GET['sampai'] ?? '';

$query = "SELECT * FROM transaksi";
if ($dari && $sampai) {
  $query .= " WHERE tanggal BETWEEN '$dari' AND '$sampai'";
}
$query .= " ORDER BY tanggal DESC";

$transaksi = mysqli_query($koneksi, $query);
?>

<style>
@media print {
  .modal,
  .modal-backdrop,
  .modal-content,
  .no-print {
    display: none !important;
  }
  body {
    overflow: visible !important;
  }
}
</style>

<div class="container py-4">
  <h3 class="mb-4">📊 Laporan Transaksi</h3>

  <!-- 🔍 Filter Form -->
  <form method="GET" action="index.php" class="row g-3 mb-4">
    <input type="hidden" name="page" value="laporan">
    <div class="col-md-3">
      <input type="date" name="dari" class="form-control" value="<?= $dari ?>" required>
    </div>
    <div class="col-md-3">
      <input type="date" name="sampai" class="form-control" value="<?= $sampai ?>" required>
    </div>
    <div class="col-md-3 d-flex align-items-end">
      <button type="submit" class="btn btn-primary">🔍 Filter</button>
    </div>
    <div class="col-md-3 d-flex align-items-end justify-content-end">
      <button type="button" class="btn btn-success" onclick="openModalCetak()">🖨️ Cetak Semua</button>
    </div>
  </form>

  <!-- 📋 Tabel Transaksi -->
  <table class="table table-bordered table-hover">
    <thead class="table-info">
      <tr>
        <th>ID</th>
        <th>Tanggal</th>
        <th>Total</th>
        <th>Detail</th>
        <th>Cetak</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($transaksi)) { ?>
      <tr>
        <td><?= $row['id_transaksi'] ?></td>
        <td><?= $row['tanggal'] ?></td>
        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
        <td>
          <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail" onclick="loadDetail(<?= $row['id_transaksi'] ?>)">Detail</button>
        </td>
        <td>
          <button class="btn btn-success btn-sm" onclick="cetakStrukLangsung(<?= $row['id_transaksi'] ?>)">🖨️ Cetak</button>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<!-- 🧾 Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Detail Transaksi</h5></div>
      <div class="modal-body" id="detailContent">Loading...</div>
    </div>
  </div>
</div>

<!-- 🖨️ Modal Cetak Per Transaksi -->
<div class="modal fade" id="modalCetak" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Struk Transaksi</h5></div>
      <div class="modal-body" id="cetakContent">Loading...</div>
    </div>
  </div>
</div>

<!-- 🖨️ Modal Cetak Semua -->
<div class="modal fade" id="modalCetakSemua" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header no-print">
        <h5 class="modal-title">Cetak Semua Transaksi</h5>
        <button type="button" class="btn btn-success" onclick="cetakSemuaDanTutup()">🖨️ Cetak</button>
      </div>
      <div class="modal-body" id="semuaContent">Loading...</div>
    </div>
  </div>
</div>

<script>
  function cetakStrukLangsung(id) {
  fetch(`proses/laporan_cetak_popup.php?id=${id}`)
    .then(res => res.text())
    .then(html => {
      const style = `
        <style>
          body { font-family: sans-serif; font-size: 13px; margin: 20px; }
          table { width: 100%; border-collapse: collapse; }
          th, td { padding: 6px; border: 1px solid #ccc; }
        </style>
      `;
      const win = window.open('', '', 'width=600,height=700');
      win.document.write(`<html><head><title>Struk Transaksi</title>${style}</head><body>${html}</body></html>`);
      win.document.close();
      win.focus();
      win.print();
      win.onafterprint = () => win.close();
    });
}
function loadDetail(id) {
  fetch("proses/laporan_detail_popup.php?id=" + id)
    .then(res => res.text()).then(data => {
      document.getElementById("detailContent").innerHTML = data;
    });
}

function loadCetak(id) {
  fetch("proses/laporan_cetak_popup.php?id=" + id)
    .then(res => res.text()).then(data => {
      document.getElementById("cetakContent").innerHTML = data;
    });
}

function openModalCetak() {
  const dari = document.querySelector('[name="dari"]').value;
  const sampai = document.querySelector('[name="sampai"]').value;
  fetch(`proses/laporan_cetak_semua.php?dari=${dari}&sampai=${sampai}`)
    .then(res => res.text()).then(html => {
      document.getElementById("semuaContent").innerHTML = html;
      let modal = new bootstrap.Modal(document.getElementById('modalCetakSemua'));
      modal.show();
    });
}

function cetakSemuaDanTutup() {
  setTimeout(() => {
    var myModal = bootstrap.Modal.getInstance(document.getElementById('modalCetakSemua'));
    myModal.hide();
    window.print();
  }, 100);
}
</script>