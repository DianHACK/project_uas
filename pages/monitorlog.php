<?php
// Query untuk mengambil data log aktivitas terbaru
$queryLog = mysqli_query($koneksi, "
    SELECT * 
    FROM log_aktivitas 
    ORDER BY tanggal DESC
    LIMIT 50
");

$totalLog = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM log_aktivitas"));
?>

<div class="container-fluid px-4 py-4">

    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1 fs-4">
                Monitor Log Aktivitas
            </h2>
            <p class="text-muted small mb-0">
                Pantau seluruh catatan aktivitas dan riwayat sistem SmartMart secara *real-time*.
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="index.php?page=home" class="btn btn-outline-secondary btn-sm px-3 rounded-pill shadow-xs d-inline-flex align-items-center gap-1">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Statistik Card -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-primary-subtle text-primary mb-2 fw-semibold px-2.5 py-1 rounded-2 small">Sistem Audit</span>
                            <h6 class="text-muted mb-1 fs-7">Total Catatan Log</h6>
                            <h2 class="fw-bold text-dark mb-0 fs-2">
                                <?= number_format($totalLog['total'], 0, ',', '.'); ?>
                            </h2>
                        </div>
                        <div class="rounded-3 bg-primary-subtle p-3 text-primary d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                            <i class="ti ti-history fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Tabel Log -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white py-3 px-4 border-bottom-0 pt-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark fs-5">Log Aktivitas Terbaru</h5>
                <p class="text-muted small mb-0">Menampilkan 50 aktivitas terakhir dalam sistem</p>
            </div>
        </div>
        <div class="card-body p-0 pt-2">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase fs-8 text-muted">
                        <tr>
                            <th class="ps-4 py-3" width="70">No</th>
                            <th class="py-3" width="180">User / Kasir</th>
                            <th class="py-3">Aktivitas Sistem</th>
                            <th class="text-end pe-4 py-3" width="220">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($queryLog) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($queryLog)) {
                        ?>
                                <tr>
                                    <td class="ps-4 text-muted fw-medium"><?= $no++; ?></td>
                                    <td>
                                        <span class="badge bg-light text-dark fw-semibold px-3 py-1.5 rounded-pill border">
                                            <i class="ti ti-user me-1 text-primary"></i> <?= htmlspecialchars($row['username']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark fs-7">
                                            <?= htmlspecialchars($row['aktivitas']); ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4 text-muted small">
                                        <i class="ti ti-clock me-1"></i> <?= date('d M Y, H:i:s', strtotime($row['tanggal'])); ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2">
                                        <i class="ti ti-file-analytics fs-1"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Belum Ada Log Aktivitas</h6>
                                    <p class="text-muted small mb-0">Catatan aktivitas akan muncul otomatis saat sistem digunakan.</p>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>