<?php

$query = mysqli_query($koneksi, "SELECT * FROM barang");
$cek_keranjang = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM keranjang");
$jumlah = mysqli_fetch_array($cek_keranjang)['total'];
?>

<div class="container py-4">
  <!-- Header + Keranjang & Search -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3>🛍️ Penjualan Produk</h3>
    <div class="d-flex align-items-center gap-3">
      <input type="text" id="searchInput" class="form-control" placeholder="🔎 Cari barang..." style="width: 250px;">
      <a href="index.php?page=keranjang" class="btn btn-outline-dark position-relative">
        🛒
        <?php if($jumlah > 0): ?>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?= $jumlah ?>
          </span>
        <?php endif ?>
      </a>
    </div>
  </div>
  <!-- Grid Produk -->
  <div class="row" id="produkGrid">
    <?php while($data = mysqli_fetch_array($query)) { ?>
      <div class="col-md-3 mb-4 item" data-nama="<?= strtolower($data['nama_barang']) ?>">
        <div class="card h-100 shadow-sm">
          <img src="proses/gambar/<?= $data['gambar'] ?>" class="card-img-top" style="height: 250px; object-fit: cover;">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= $data['nama_barang'] ?></h5>
            <p class="card-text text-success fw-bold">Rp <?= number_format($data['harga'], 0, ',', '.') ?></p>
            <p class="card-text">Stok: <?= $data['stok'] ?></p>
            <form method="POST" action="proses/penjualan/keranjang_tambah.php" class="mt-auto">
              <input type="hidden" name="id_barang" value="<?= $data['id'] ?>">
              <input type="number" name="jumlah" min="1" class="form-control mb-2" required>
              <button type="submit" class="btn btn-warning w-100">🛒 Tambah ke Keranjang</button>
            </form>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<!-- 🔧 Script Search Real-Time -->
<script>
  const searchInput = document.getElementById('searchInput');
  const items = document.querySelectorAll('.item');

  searchInput.addEventListener('input', function() {
    const keyword = this.value.toLowerCase();
    items.forEach(item => {
      const nama = item.getAttribute('data-nama');
      item.style.display = nama.includes(keyword) ? 'block' : 'none';
    });
  });
</script>