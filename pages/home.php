<?php

date_default_timezone_set('Asia/Jakarta');

/*
|--------------------------------------------------------------------------
| Sapaan Otomatis
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Format Tanggal Indonesia
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

// Total Barang
$qBarang = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang");
$barang = mysqli_fetch_assoc($qBarang);

// Total Kategori
$qKategori = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kategori");
$kategori = mysqli_fetch_assoc($qKategori);

// Total Rak
$qRak = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM rak");
$rak = mysqli_fetch_assoc($qRak);

// Total Transaksi
$qTransaksi = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM transaksi");
$transaksi = mysqli_fetch_assoc($qTransaksi);

/*
|--------------------------------------------------------------------------
| Barang Hampir Habis
|--------------------------------------------------------------------------
*/

$qStok = mysqli_query($koneksi, "
    SELECT nama_barang, stok
    FROM barang
    WHERE stok <= 5
    ORDER BY stok ASC
    LIMIT 5
");

/*
|--------------------------------------------------------------------------
| Transaksi Terakhir
|--------------------------------------------------------------------------
*/

$qLastTransaksi = mysqli_query($koneksi, "
    SELECT *
    FROM transaksi
    ORDER BY tanggal DESC
    LIMIT 5
");

?>

<!-- WADAH UTAMA KONTEN (Pembatas Agar Tidak Ketimbun Sidebar) -->
<div class="container-fluid px-4 py-3">

    <!-- Welcome Banner -->
    <div class="card overflow-hidden bg-primary text-white border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <span class="badge bg-white text-primary px-3 py-2 mb-3 fw-bold rounded-pill shadow-sm">
                        <i class="ti ti-layout-dashboard"></i> Dashboard SmartMart
                    </span>
                    <h2 class="fw-bold mb-3 text-white">
                        <?= $salam ?>, <?= ucwords($_SESSION['username']); ?> 👋
                    </h2>
                    <p class="fs-6 mb-3 opacity-75">
                        Selamat datang di Sistem Informasi SmartMart. Kelola kategori, rak, barang, transaksi, dan laporan dengan lebih cepat melalui dashboard ini.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                            <i class="ti ti-calendar me-1"></i> <?= $tanggalIndonesia; ?>
                        </span>
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                            <i class="ti ti-clock me-1"></i> <span id="jamDigital"></span>
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-center d-none d-md-block">
                    <i class="ti ti-shopping-cart text-white opacity-25" style="font-size: 110px;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <!-- Kategori -->
        <div class="col-xl-3 col-md-6">
            <a href="index.php?page=datakategori" class="text-decoration-none">
                <div class="card dashboard-card border-start border-primary border-4 shadow-sm h-100 rounded-3">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-primary-subtle text-primary mb-2 fw-semibold">Master Data</span>
                                <h6 class="text-muted mb-1">Kategori</h6>
                                <h3 class="fw-bold text-primary mb-0"><?= $kategori['total']; ?></h3>
                                <small class="text-muted fs-7">Total Kategori</small>
                            </div>
                            <div class="rounded-circle bg-primary-subtle p-3 text-primary">
                                <i class="ti ti-category fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Rak -->
        <div class="col-xl-3 col-md-6">
            <a href="index.php?page=datarak" class="text-decoration-none">
                <div class="card dashboard-card border-start border-success border-4 shadow-sm h-100 rounded-3">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-success-subtle text-success mb-2 fw-semibold">Penyimpanan</span>
                                <h6 class="text-muted mb-1">Rak</h6>
                                <h3 class="fw-bold text-success mb-0"><?= $rak['total']; ?></h3>
                                <small class="text-muted fs-7">Total Rak</small>
                            </div>
                            <div class="rounded-circle bg-success-subtle p-3 text-success">
                                <i class="ti ti-building-warehouse fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Barang -->
        <div class="col-xl-3 col-md-6">
            <a href="index.php?page=databarang" class="text-decoration-none">
                <div class="card dashboard-card border-start border-warning border-4 shadow-sm h-100 rounded-3">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-warning-subtle text-warning mb-2 fw-semibold">Inventaris</span>
                                <h6 class="text-muted mb-1">Barang</h6>
                                <h3 class="fw-bold text-warning mb-0"><?= $barang['total']; ?></h3>
                                <small class="text-muted fs-7">Total Barang</small>
                            </div>
                            <div class="rounded-circle bg-warning-subtle p-3 text-warning">
                                <i class="ti ti-package fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Transaksi -->
        <div class="col-xl-3 col-md-6">
            <a href="index.php?page=penjualan" class="text-decoration-none">
                <div class="card dashboard-card border-start border-danger border-4 shadow-sm h-100 rounded-3">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-danger-subtle text-danger mb-2 fw-semibold">Penjualan</span>
                                <h6 class="text-muted mb-1">Transaksi</h6>
                                <h3 class="fw-bold text-danger mb-0"><?= $transaksi['total']; ?></h3>
                                <small class="text-muted fs-7">Total Transaksi</small>
                            </div>
                            <div class="rounded-circle bg-danger-subtle p-3 text-danger">
                                <i class="ti ti-shopping-cart fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Ringkasan Dashboard & Status Sistem -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark fs-6">📊 Ringkasan Dashboard</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Total Barang</span>
                            <strong class="text-dark small"><?= $barang['total']; ?></strong>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-warning rounded-pill" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Total Kategori</span>
                            <strong class="text-dark small"><?= $kategori['total']; ?></strong>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary rounded-pill" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Total Rak</span>
                            <strong class="text-dark small"><?= $rak['total']; ?></strong>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success rounded-pill" style="width: 100%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Total Transaksi</span>
                            <strong class="text-dark small"><?= $transaksi['total']; ?></strong>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-danger rounded-pill" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100 rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark fs-6">🚀 Status Sistem</h5>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span class="text-muted small">Database</span>
                            <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Online</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span class="text-muted small">Login</span>
                            <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Aktif</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span class="text-muted small">Dashboard</span>
                            <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill">Berjalan</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <span class="text-muted small">Versi</span>
                            <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill">1.0.0</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>