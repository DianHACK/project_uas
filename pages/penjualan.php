<?php
// Ambil ID user yang sedang login
$username = $_SESSION['username'];
$user_query = mysqli_query($koneksi, "SELECT id FROM login WHERE username = '$username'");
$user_data = mysqli_fetch_assoc($user_query);
$id_user = $user_data['id'] ?? 1;
?>

<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Transaksi Penjualan (POS Kasir)</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php?page=home">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- KOLOM KIRI: KATALOG BARANG (Grid Card dengan Gambar) -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-3">Katalog Barang</h5>
                    
                    <!-- Search Bar -->
                    <div class="mb-3">
                        <input type="text" id="cariBarang" class="form-control" placeholder="Cari nama barang...">
                    </div>

                    <div class="row" id="daftarBarang">
                        <?php
                        $barang = mysqli_query($koneksi, "SELECT barang.*, kategori.nama_kategori FROM barang LEFT JOIN kategori ON barang.id_kategori = kategori.id WHERE barang.stok > 0");
                        if (mysqli_num_rows($barang) > 0) {
                            while ($b = mysqli_fetch_assoc($barang)) {
                        ?>
                        <div class="col-md-6 mb-3 item-barang">
                            <div class="card border h-100 shadow-none">
                                <div class="card-body p-3 d-flex flex-column justify-content-between">
                                    <div>
                                        <!-- Tampilkan Gambar Barang sesuai path databarang.php -->
                                        <div class="text-center mb-2 bg-light rounded overflow-hidden" style="height: 120px;">
                                            <?php if (!empty($b['gambar'])) { ?>
                                                <img src="assets/images/barang/<?= htmlspecialchars($b['gambar']); ?>" alt="<?= htmlspecialchars($b['nama_barang']); ?>" style="width: 100%; height: 120px; object-fit: cover;">
                                            <?php } else { ?>
                                                <div class="d-flex align-items-center justify-content-center h-100 text-muted fs-2">
                                                    <i class="fa fa-image fa-2x"></i>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-semibold text-dark mb-0 nama-item text-truncate" style="max-width: 130px;" title="<?= htmlspecialchars($b['nama_barang']); ?>"><?= htmlspecialchars($b['nama_barang']); ?></h6>
                                            <span class="badge bg-primary-subtle text-primary fs-2">Stok: <?= $b['stok']; ?></span>
                                        </div>
                                        <p class="text-muted mb-1 fs-2">Kategori: <?= htmlspecialchars($b['nama_kategori'] ?? '-'); ?></p>
                                        <h5 class="fw-bold text-success mb-3">Rp <?= number_format($b['harga'], 0, ',', '.'); ?></h5>
                                    </div>
                                    
                                    <!-- Form untuk langsung menambahkan ke keranjang -->
                                    <form action="proses/tambahkeranjang.php" method="POST" class="d-flex gap-2">
                                        <input type="hidden" name="id_barang" value="<?= $b['id']; ?>">
                                        <input type="number" name="jumlah" value="1" min="1" max="<?= $b['stok']; ?>" class="form-control form-control-sm text-center" style="width: 60px;" required>
                                        <button type="submit" name="tambah_keranjang" class="btn btn-primary btn-sm flex-grow-1">
                                            <i class="fa fa-cart-plus me-1"></i> Pilih
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php 
                            }
                        } else {
                            echo "<div class='col-12 text-center text-muted py-4'>Tidak ada barang yang tersedia atau stok habis.</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: DAFTAR KERANJANG & PEMBAYARAN -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-3">Keranjang Belanja</h5>
                    <div class="table-responsive mb-3" style="max-height: 250px; overflow-y: auto;">
                        <table class="table table-bordered text-nowrap align-middle fs-2">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th><i class="fa fa-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_belanja = 0;
                                $query_cart = mysqli_query($koneksi, "SELECT keranjang.*, barang.nama_barang, barang.harga FROM keranjang JOIN barang ON keranjang.id_barang = barang.id WHERE keranjang.id_user = '$id_user'");
                                
                                if (mysqli_num_rows($query_cart) > 0) {
                                    while ($row = mysqli_fetch_assoc($query_cart)) {
                                        $subtotal = $row['harga'] * $row['jumlah'];
                                        $total_belanja += $subtotal;
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nama_barang']); ?></td>
                                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                    <td><?= $row['jumlah']; ?></td>
                                    <td>Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                                    <td>
                                        <a href="proses/hapuskeranjang.php?id=<?= $row['id']; ?>" class="text-danger">
                                            <i class="fa fa-times-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center text-muted'>Keranjang kosong</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Total & Form Checkout -->
                    <form action="proses/prosespenjualan.php" method="POST">
                        <div class="bg-light p-3 rounded mb-3 text-end">
                            <span class="text-muted fs-3">Total Pembayaran:</span>
                            <h3 class="fw-bold text-primary mb-0">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></h3>
                            <input type="hidden" name="total_harga" value="<?= $total_belanja; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-3">Metode Pembayaran</label>
                            <select name="metode_pembayaran" class="form-control form-control-sm" required>
                                <option value="Tunai">Tunai</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fs-3">Uang Bayar (Rp)</label>
                            <input type="number" name="uang_bayar" class="form-control form-control-sm" required min="<?= $total_belanja; ?>" placeholder="Masukkan jumlah uang...">
                        </div>

                        <button type="submit" name="proses_bayar" class="btn btn-success w-100 py-2 fs-3" <?= ($total_belanja == 0) ? 'disabled' : ''; ?>>
                            <i class="fa fa-check-circle me-2"></i> Bayar & Cetak Nota
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pencarian -->
<script>
document.getElementById('cariBarang').addEventListener('keyup', function() {
    let keyword = this.value.toLowerCase();
    let items = document.querySelectorAll('.item-barang');

    items.forEach(function(item) {
        let namaBarang = item.querySelector('.nama-item').textContent.toLowerCase();
        if (namaBarang.includes(keyword)) {
            item.style.display = "";
        } else {
            item.style.display = "none";
        }
    });
});
</script>