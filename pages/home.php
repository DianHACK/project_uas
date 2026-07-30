<div class="container-fluid">

    <!-- Welcome Banner -->
    <div class="card overflow-hidden bg-primary text-white border-0 shadow-sm mb-4">
        <div class="card-body p-5">

            <span class="badge bg-white text-primary mb-3">
                Dashboard Swalayan
            </span>

            <h2 class="fw-bold mb-3">
                Selamat Datang, <?= ucwords($_SESSION['username']); ?> 👋
            </h2>

            <p class="fs-4 mb-0">
                Kelola data kategori, rak, stok barang, serta transaksi
                penjualan dengan mudah melalui dashboard ini.
            </p>

        </div>
    </div>

    <!-- Menu Cepat -->
    <div class="row">

        <div class="col-lg-3 col-md-6 mb-4">
            <a href="index.php?page=datakategori" class="text-decoration-none">
                <div class="card border-start border-primary border-4 shadow-sm h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="rounded bg-primary-subtle p-3 me-3">
                                <i class="ti ti-category text-primary fs-7"></i>
                            </div>

                            <div>

                                <small class="text-muted">
                                    Kelola Menu
                                </small>

                                <h5 class="mb-0">
                                    Kategori
                                </h5>

                            </div>

                        </div>

                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <a href="index.php?page=datarak" class="text-decoration-none">
                <div class="card border-start border-success border-4 shadow-sm h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="rounded bg-success-subtle p-3 me-3">
                                <i class="ti ti-building-warehouse text-success fs-7"></i>
                            </div>

                            <div>

                                <small class="text-muted">
                                    Penyimpanan
                                </small>

                                <h5 class="mb-0">
                                    Rak Swalayan
                                </h5>

                            </div>

                        </div>

                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <a href="index.php?page=databarang" class="text-decoration-none">
                <div class="card border-start border-warning border-4 shadow-sm h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="rounded bg-warning-subtle p-3 me-3">
                                <i class="ti ti-package text-warning fs-7"></i>
                            </div>

                            <div>

                                <small class="text-muted">
                                    Inventaris
                                </small>

                                <h5 class="mb-0">
                                    Data Barang
                                </h5>

                            </div>

                        </div>

                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <a href="index.php?page=penjualan" class="text-decoration-none">
                <div class="card border-start border-danger border-4 shadow-sm h-100">
                    <div class="card-body">

                        <div class="d-flex align-items-center">

                            <div class="rounded bg-danger-subtle p-3 me-3">
                                <i class="ti ti-shopping-cart text-danger fs-7"></i>
                            </div>

                            <div>

                                <small class="text-muted">
                                    Penjualan
                                </small>

                                <h5 class="mb-0">
                                    Data Transaksi
                                </h5>

                            </div>

                        </div>

                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- Informasi -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h5 class="fw-bold mb-3">
                Tentang Sistem
            </h5>

            <p class="text-muted mb-0">
                Sistem Informasi Swalayan ini dibuat untuk membantu proses
                pengelolaan data kategori, rak, barang, transaksi penjualan,
                serta laporan penjualan secara cepat, mudah, dan terstruktur.
            </p>

        </div>
    </div>

</div>