<?php
// =========================================================================
// TIMEZONE & GREETING SETUP
// =========================================================================
date_default_timezone_set('Asia/Jakarta');

$jam = date('H');

if ($jam >= 5 && $jam < 11) {
    $salam = "Selamat Pagi";
} elseif ($jam >= 11 && $jam < 15) {
    $salam = "Selamat Siang";
} elseif ($jam >= 15 && $jam < 18) {
    $salam = "Selamat Sore";
} else {
    $salam = "Selamat Malam";
}

// =========================================================================
// FORMAT TANGGAL INDONESIA
// =========================================================================
$hari = [
    'Sunday'    => 'Minggu',
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu'
];

$bulan = [
    'January'   => 'Januari',
    'February'  => 'Februari',
    'March'     => 'Maret',
    'April'     => 'April',
    'May'       => 'Mei',
    'June'      => 'Juni',
    'July'      => 'Juli',
    'August'    => 'Agustus',
    'September' => 'September',
    'October'   => 'Oktober',
    'November'  => 'November',
    'December'  => 'Desember'
];

$tanggalIndonesia =
    $hari[date('l')] . ", " .
    date('d') . " " .
    $bulan[date('F')] . " " .
    date('Y');

// =========================================================================
// DASHBOARD STATISTICS & INVENTORY INFO
// =========================================================================
$qBarang = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang");
$barang = mysqli_fetch_assoc($qBarang);

$qKategori = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kategori");
$kategori = mysqli_fetch_assoc($qKategori);

$qRak = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM rak");
$rak = mysqli_fetch_assoc($qRak);

$qTransaksi = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM transaksi");
$transaksi = mysqli_fetch_assoc($qTransaksi);

$qStokInfo = mysqli_query($koneksi, "
    SELECT 
        SUM(stok) as total_stok,
        COUNT(*) as total_barang
    FROM barang
");
$stokInfo = mysqli_fetch_assoc($qStokInfo);

// =========================================================================
// LOW STOCK ITEMS (BARANG HAMPIR HABIS)
// =========================================================================
$qStok = mysqli_query($koneksi, "
    SELECT nama_barang, stok
    FROM barang
    WHERE stok <= 5
    ORDER BY stok ASC
    LIMIT 5
");

// =========================================================================
// LATEST TRANSACTIONS (TRANSAKSI TERAKHIR)
// =========================================================================
$qLastTransaksi = mysqli_query($koneksi, "
    SELECT *
    FROM transaksi
    ORDER BY tanggal DESC
    LIMIT 5
");
?>

<style>
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.08)!important;
    }
    .quick-action-btn {
        transition: all 0.2s ease-in-out;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .quick-action-btn:hover {
        transform: translateY(-2px);
    }
</style>

<!-- WADAH UTAMA KONTEN -->
<div class="container-fluid px-4 py-4">

    <!-- ===================================================================== -->
    <!-- WELCOME BANNER -->
    <!-- ===================================================================== -->
    <div class="card overflow-hidden border-0 shadow-sm mb-4 rounded-4" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
        <div class="card-body p-4 p-md-4 position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8 text-white">
                    <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 mb-3 fw-semibold rounded-pill backdrop-blur">
                        <i class="ti ti-layout-dashboard me-1"></i> Dashboard SmartMart
                    </span>
                    <h2 class="fw-bold mb-2 text-white">
                        <?= $salam ?>, <?= ucwords($_SESSION['username']); ?> 👋
                    </h2>
                    <p class="fs-6 mb-4 text-white-50" style="max-width: 600px;">
                        Selamat datang kembali di Sistem Informasi SmartMart. Kelola kategori, rak, barang, transaksi, dan laporan dengan lebih cepat dan terintegrasi.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-white text-dark px-3 py-2 rounded-pill shadow-sm fw-medium">
                            <i class="ti ti-calendar me-1 text-primary"></i> <?= $tanggalIndonesia; ?>
                        </span>
                        <span class="badge bg-dark bg-opacity-25 text-white px-3 py-2 rounded-pill fw-medium">
                            <i class="ti ti-clock me-1 text-warning"></i> <span id="jamDigital">00:00:00</span>
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <div class="text-white opacity-10">
                        <i class="ti ti-shopping-cart" style="font-size: 130px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- STATISTIK CARDS -->
    <!-- ===================================================================== -->
    <div class="row g-3 mb-4">
        <!-- Kategori -->
        <div class="col-xl-3 col-md-6">
            <a href="index.php?page=datakategori" class="text-decoration-none">
                <div class="card hover-card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-primary-subtle text-primary mb-2 fw-semibold px-2 py-1 rounded-2">Master Data</span>
                                <h6 class="text-muted mb-1 fs-7">Kategori Barang</h6>
                                <h3 class="fw-bold text-dark mb-0"><?= number_format($kategori['total'], 0, ',', '.'); ?></h3>
                            </div>
                            <div class="rounded-3 bg-primary-subtle p-3 text-primary d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                <i class="ti ti-category fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Rak -->
        <div class="col-xl-3 col-md-6">
            <a href="index.php?page=datarak" class="text-decoration-none">
                <div class="card hover-card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-success-subtle text-success mb-2 fw-semibold px-2 py-1 rounded-2">Penyimpanan</span>
                                <h6 class="text-muted mb-1 fs-7">Rak Penyimpanan</h6>
                                <h3 class="fw-bold text-dark mb-0"><?= number_format($rak['total'], 0, ',', '.'); ?></h3>
                            </div>
                            <div class="rounded-3 bg-success-subtle p-3 text-success d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                <i class="ti ti-building-warehouse fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Barang -->
        <div class="col-xl-3 col-md-6">
            <a href="index.php?page=databarang" class="text-decoration-none">
                <div class="card hover-card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-warning-subtle text-warning mb-2 fw-semibold px-2 py-1 rounded-2">Inventaris</span>
                                <h6 class="text-muted mb-1 fs-7">Total Barang</h6>
                                <h3 class="fw-bold text-dark mb-0"><?= number_format($stokInfo['total_barang'] ?? 0, 0, ',', '.'); ?></h3>
                            </div>
                            <div class="rounded-3 bg-warning-subtle p-3 text-warning d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                <i class="ti ti-package fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Transaksi -->
        <div class="col-xl-3 col-md-6">
            <a href="index.php?page=penjualan" class="text-decoration-none">
                <div class="card hover-card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-danger-subtle text-danger mb-2 fw-semibold px-2 py-1 rounded-2">Penjualan</span>
                                <h6 class="text-muted mb-1 fs-7">Total Transaksi</h6>
                                <h3 class="fw-bold text-dark mb-0"><?= number_format($transaksi['total'], 0, ',', '.'); ?></h3>
                            </div>
                            <div class="rounded-3 bg-danger-subtle p-3 text-danger d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                <i class="ti ti-shopping-cart fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- QUICK ACTION -->
    <!-- ===================================================================== -->
    <div class="card shadow-sm border-0 mb-4 rounded-4">
        <div class="card-header bg-white py-3 px-4 border-bottom-0 pt-4">
            <h5 class="mb-0 fw-bold text-dark fs-5">
                ⚡ Quick Action
            </h5>
            <p class="text-muted small mb-0">Akses cepat menu operasional utama SmartMart</p>
        </div>
        <div class="card-body px-4 pb-4 pt-2">
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <a href="index.php?page=tambahkategori" class="btn btn-light quick-action-btn w-100 p-3 rounded-3 text-start border-0 bg-light-subtle d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-primary text-white p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="ti ti-category fs-5"></i>
                        </div>
                        <div>
                            <span class="fw-semibold d-block text-dark fs-7">Tambah Kategori</span>
                            <small class="text-muted" style="font-size: 11px;">Input kategori baru</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="index.php?page=tambahrak" class="btn btn-light quick-action-btn w-100 p-3 rounded-3 text-start border-0 bg-light-subtle d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-success text-white p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="ti ti-building-warehouse fs-5"></i>
                        </div>
                        <div>
                            <span class="fw-semibold d-block text-dark fs-7">Tambah Rak</span>
                            <small class="text-muted" style="font-size: 11px;">Lokasi penyimpanan</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="index.php?page=tambahbarang" class="btn btn-light quick-action-btn w-100 p-3 rounded-3 text-start border-0 bg-light-subtle d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-warning text-dark p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="ti ti-package fs-5"></i>
                        </div>
                        <div>
                            <span class="fw-semibold d-block text-dark fs-7">Tambah Barang</span>
                            <small class="text-muted" style="font-size: 11px;">Stok & produk baru</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="index.php?page=penjualan" class="btn btn-light quick-action-btn w-100 p-3 rounded-3 text-start border-0 bg-light-subtle d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-danger text-white p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="ti ti-shopping-cart fs-5"></i>
                        </div>
                        <div>
                            <span class="fw-semibold d-block text-dark fs-7">POS Kasir</span>
                            <small class="text-muted" style="font-size: 11px;">Proses penjualan</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- RINGKASAN & STATUS SISTEM -->
    <!-- ===================================================================== -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-white py-3 px-4 border-bottom-0 pt-4">
                    <h5 class="mb-0 fw-bold text-dark fs-5">📊 Ringkasan Dashboard & Persediaan</h5>
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small fw-medium">Total Jenis Barang</span>
                            <strong class="text-dark small"><?= number_format($stokInfo['total_barang'] ?? 0, 0, ',', '.'); ?> Item</strong>
                        </div>
                        <div class="progress bg-light" style="height: 8px;">
                            <div class="progress-bar bg-warning rounded-pill" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small fw-medium">Total Seluruh Stok Fisik</span>
                            <strong class="text-dark small"><?= number_format($stokInfo['total_stok'] ?? 0, 0, ',', '.'); ?> pcs</strong>
                        </div>
                        <div class="progress bg-light" style="height: 8px;">
                            <div class="progress-bar bg-success rounded-pill" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small fw-medium">Total Kategori Aktif</span>
                            <strong class="text-dark small"><?= $kategori['total']; ?> Kategori</strong>
                        </div>
                        <div class="progress bg-light" style="height: 8px;">
                            <div class="progress-bar bg-primary rounded-pill" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small fw-medium">Akumulasi Transaksi Penjualan</span>
                            <strong class="text-dark small"><?= $transaksi['total']; ?> Transaksi</strong>
                        </div>
                        <div class="progress bg-light" style="height: 8px;">
                            <div class="progress-bar bg-danger rounded-pill" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100 rounded-4">
                <div class="card-header bg-white py-3 px-4 border-bottom-0 pt-4">
                    <h5 class="mb-0 fw-bold text-dark fs-5">🚀 Status Sistem</h5>
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span class="text-muted small">Database Connection</span>
                            <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Online</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span class="text-muted small">Session Login</span>
                            <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Aktif</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span class="text-muted small">Dashboard Engine</span>
                            <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Berjalan</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span class="text-muted small">Sistem Versi</span>
                            <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill">v1.0.0</span>
                        </li>
                    </ul>

                    <!-- Aktivitas Sistem -->
                    <div class="p-3 bg-light rounded-3 border-0">
                        <h6 class="fw-bold text-dark fs-7 mb-2">Aktivitas Hari Ini</h6>
                        <ul class="list-unstyled mb-0 small text-muted">
                            <li class="mb-1 d-flex align-items-center gap-2"><i class="ti ti-check text-success"></i> Login berhasil diverifikasi</li>
                            <li class="mb-1 d-flex align-items-center gap-2"><i class="ti ti-check text-success"></i> Dashboard aktif & stabil</li>
                            <li class="mb-1 d-flex align-items-center gap-2"><i class="ti ti-check text-success"></i> Database terkoneksi</li>
                            <li class="d-flex align-items-center gap-2"><i class="ti ti-check text-success"></i> Sistem berjalan normal</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- BARANG HAMPIR HABIS -->
    <!-- ===================================================================== -->
    <div class="card shadow-sm border-0 mb-4 rounded-4">
        <div class="card-header bg-white py-3 px-4 border-bottom-0 pt-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark fs-5">⚠️ Barang Hampir Habis</h5>
                <p class="text-muted small mb-0">Daftar produk dengan stok menipis (≤ 5 pcs)</p>
            </div>
            <a href="index.php?page=databarang" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
            <?php if (mysqli_num_rows($qStok) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase fs-8 text-muted">
                            <tr>
                                <th class="ps-4 py-3">Nama Barang</th>
                                <th class="text-end pe-4 py-3">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($qStok)): ?>
                                <tr>
                                    <td class="ps-4 fw-semibold text-dark"><?= htmlspecialchars($row['nama_barang']); ?></td>
                                    <td class="text-end pe-4">
                                        <span class="badge bg-danger-subtle text-danger px-3 py-1 rounded-pill fw-semibold"><?= $row['stok']; ?> pcs</span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="text-muted opacity-50 mb-2">
                        <i class="ti ti-packages fs-1"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Semua Stok Aman</h6>
                    <p class="text-muted small mb-0">Tidak ada barang dengan stok di bawah atau sama dengan 5.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- TRANSAKSI TERAKHIR -->
    <!-- ===================================================================== -->
    <div class="card shadow-sm border-0 mb-4 rounded-4">
        <div class="card-header bg-white py-3 px-4 border-bottom-0 pt-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark fs-5">🛒 Transaksi Terakhir</h5>
                <p class="text-muted small mb-0">Riwayat 5 transaksi penjualan kasir terbaru</p>
            </div>
            <a href="index.php?page=datapenjualan" class="btn btn-sm btn-outline-primary rounded-pill px-3">Riwayat Lengkap</a>
        </div>
        <div class="card-body p-0">
            <?php if (mysqli_num_rows($qLastTransaksi) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase fs-8 text-muted">
                            <tr>
                                <th class="ps-4 py-3">No Invoice / ID</th>
                                <th class="py-3">Waktu Transaksi</th>
                                <th class="text-end pe-4 py-3">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($qLastTransaksi)): ?>
                                <tr>
                                    <td class="ps-4 fw-semibold text-primary">
                                        <?= htmlspecialchars($row['no_invoice'] ?? '#' . ($row['id'] ?? $row['id_transaksi'] ?? '-')); ?>
                                    </td>
                                    <td class="text-muted small"><?= $row['tanggal'] ?? '-'; ?></td>
                                    <td class="text-end pe-4 fw-bold text-success">
                                        Rp <?= number_format($row['total_harga'] ?? 0, 0, ',', '.'); ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="text-muted opacity-50 mb-2">
                        <i class="ti ti-receipt-off fs-1"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Belum Ada Transaksi</h6>
                    <p class="text-muted small mb-0">Data transaksi akan muncul setelah kasir melakukan penjualan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- TIPS PENGGUNAAN -->
    <!-- ===================================================================== -->
    <div class="card shadow-sm border-0 mb-4 rounded-4">
        <div class="card-header bg-white py-3 px-4 border-bottom-0 pt-4">
            <h5 class="mb-0 fw-bold text-dark fs-5">
                💡 Tips Penggunaan Sistem
            </h5>
        </div>
        <div class="card-body px-4 pb-4 pt-2">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 d-flex align-items-start gap-3 h-100">
                        <div class="text-primary fs-4"><i class="ti ti-circle-number-1"></i></div>
                        <div>
                            <strong class="d-block text-dark mb-1">Master Data Pertama</strong>
                            <span class="text-muted small">Pastikan kategori dan rak barang telah dibuat sebelum menginputkan data barang baru.</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 d-flex align-items-start gap-3 h-100">
                        <div class="text-primary fs-4"><i class="ti ti-circle-number-2"></i></div>
                        <div>
                            <strong class="d-block text-dark mb-1">Monitoring Stok & Kedaluwarsa</strong>
                            <span class="text-muted small">Periksa tingkat persediaan barang secara berkala untuk menghindari kehabisan stok.</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 d-flex align-items-start gap-3 h-100">
                        <div class="text-primary fs-4"><i class="ti ti-circle-number-3"></i></div>
                        <div>
                            <strong class="d-block text-dark mb-1">Transaksi Kasir (POS)</strong>
                            <span class="text-muted small">Lakukan seluruh aktivitas penjualan langsung melalui menu POS Kasir yang interaktif.</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 d-flex align-items-start gap-3 h-100">
                        <div class="text-primary fs-4"><i class="ti ti-circle-number-4"></i></div>
                        <div>
                            <strong class="d-block text-dark mb-1">Pelaporan Omzet</strong>
                            <span class="text-muted small">Cetak atau tinjau laporan penjualan secara berkala setelah shift atau transaksi harian selesai.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- FOOTER DASHBOARD -->
    <!-- ===================================================================== -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body text-center py-4">
            <h5 class="fw-bold text-primary mb-1">
                SmartMart Inventory System
            </h5>
            <p class="mb-2 text-muted small">
                Sistem Informasi Inventaris & Kasir Berbasis Web Modern
            </p>
            <div class="d-inline-block bg-light px-3 py-1 rounded-pill text-muted small">
                Version 1.0.0 &bull; Developed by Kelompok DevOps
            </div>
        </div>
    </div>

</div>

<!-- Script Jam Digital Real-time -->
<script>
function updateJam() {
    const now = new Date();
    const jam = String(now.getHours()).padStart(2, '0');
    const menit = String(now.getMinutes()).padStart(2, '0');
    const detik = String(now.getSeconds()).padStart(2, '0');
    const el = document.getElementById('jamDigital');
    if(el) {
        el.innerText = `${jam}:${menit}:${detik}`;
    }
}
setInterval(updateJam, 1000);
updateJam();
</script>