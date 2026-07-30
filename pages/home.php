<?php

// ==========================
// Dashboard Statistics
// ==========================

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

// Barang Hampir Habis
$qStok = mysqli_query($koneksi, "
    SELECT nama_barang, stok
    FROM barang
    WHERE stok <= 5
    ORDER BY stok ASC
    LIMIT 5
");
?>

<div class="container-fluid">

    <!-- Welcome Banner -->
    <div class="card overflow-hidden bg-primary text-white border-0 shadow-sm mb-4">
        <div class="card-body p-5">

            <span class="badge bg-white text-primary mb-3">
                Dashboard SmartMart
            </span>

            <h2 class="fw-bold mb-3">
                Selamat Datang, <?= ucwords($_SESSION['username']); ?> 👋
            </h2>

            <p class="fs-4 mb-0">
                Kelola kategori, rak, barang, transaksi dan laporan melalui dashboard ini.
            </p>

            <small class="mt-3 d-block opacity-75">
                <?= date('l, d F Y'); ?>
            </small>

        </div>
    </div>

    <!-- Menu Dashboard -->
    <div class="row">

        <!-- Kategori -->
        <div class="col-lg-3 col-md-6 mb-4">

            <a href="index.php?page=datakategori" class="text-decoration-none">

                <div class="card border-start border-primary border-4 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <small class="text-muted">
                                    Kelola Menu
                                </small>

                                <h5 class="mt-2 mb-2">
                                    Kategori
                                </h5>

                                <h3 class="fw-bold text-primary">
                                    <?= $kategori['total']; ?>
                                </h3>

                                <small class="text-muted">
                                    Total Data
                                </small>

                            </div>

                            <div class="rounded-circle bg-primary-subtle p-3">
                                <i class="ti ti-category text-primary fs-5"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </a>

        </div>

        <!-- Rak -->
        <div class="col-lg-3 col-md-6 mb-4">

            <a href="index.php?page=datarak" class="text-decoration-none">

                <div class="card border-start border-success border-4 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <small class="text-muted">
                                    Penyimpanan
                                </small>

                                <h5 class="mt-2 mb-2">
                                    Rak
                                </h5>

                                <h3 class="fw-bold text-success">
                                    <?= $rak['total']; ?>
                                </h3>

                                <small class="text-muted">
                                    Total Data
                                </small>

                            </div>

                            <div class="rounded-circle bg-success-subtle p-3">
                                <i class="ti ti-building-warehouse text-success fs-5"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </a>

        </div>

        <!-- Barang -->
        <div class="col-lg-3 col-md-6 mb-4">

            <a href="index.php?page=databarang" class="text-decoration-none">

                <div class="card border-start border-warning border-4 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <small class="text-muted">
                                    Inventaris
                                </small>

                                <h5 class="mt-2 mb-2">
                                    Barang
                                </h5>

                                <h3 class="fw-bold text-warning">
                                    <?= $barang['total']; ?>
                                </h3>

                                <small class="text-muted">
                                    Total Data
                                </small>

                            </div>

                            <div class="rounded-circle bg-warning-subtle p-3">
                                <i class="ti ti-package text-warning fs-5"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </a>

        </div>

        <!-- Transaksi -->
        <div class="col-lg-3 col-md-6 mb-4">

            <a href="index.php?page=penjualan" class="text-decoration-none">

                <div class="card border-start border-danger border-4 shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <small class="text-muted">
                                    Penjualan
                                </small>

                                <h5 class="mt-2 mb-2">
                                    Transaksi
                                </h5>

                                <h3 class="fw-bold text-danger">
                                    <?= $transaksi['total']; ?>
                                </h3>

                                <small class="text-muted">
                                    Total Data
                                </small>

                            </div>

                            <div class="rounded-circle bg-danger-subtle p-3">
                                <i class="ti ti-shopping-cart text-danger fs-5"></i>
                            </div>

                        </div>

                    </div>

                </div>

            </a>

        </div>

    </div>

    <!-- Informasi Sistem -->
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <h5 class="mb-0">
                Informasi Sistem
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4">

                    <h6>👤 Login Sebagai</h6>

                    <p><?= ucwords($_SESSION['username']); ?></p>

                </div>

                <div class="col-md-4">

                    <h6>📅 Tanggal</h6>

                    <p><?= date('d F Y'); ?></p>

                </div>

                <div class="col-md-4">

                    <h6>💻 Versi Sistem</h6>

                    <p>Version 1.0.0</p>

                </div>

            </div>

        </div>

    </div>

    <!-- Barang Hampir Habis -->
<div class="card shadow-sm border-0 mt-4">

    <div class="card-header bg-white">

        <h5 class="mb-0 text-danger">
            ⚠ Barang Hampir Habis
        </h5>

    </div>

    <div class="card-body">

        <?php if(mysqli_num_rows($qStok) > 0){ ?>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>Nama Barang</th>

                            <th width="120">Stok</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php while($stok = mysqli_fetch_assoc($qStok)){ ?>

                            <tr>

                                <td><?= $stok['nama_barang']; ?></td>

                                <td>

                                    <span class="badge bg-danger">

                                        <?= $stok['stok']; ?>

                                    </span>

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        <?php } else { ?>

            <div class="alert alert-success mb-0">

                Semua stok barang masih aman.

            </div>

        <?php } ?>

    </div>

</div>

</div>