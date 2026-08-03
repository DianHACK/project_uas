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
            <h4 class="fw-bold text-dark mb-1">
                Monitor Log Aktivitas
            </h4>
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
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-primary-subtle text-primary mb-1 fw-semibold px-2 py-0.5 rounded-2" style="font-size: 11px;">Sistem Audit</span>
                            <div class="text-muted small mb-0">Total Catatan Log</div>
                            <h4 class="fw-bold text-dark mb-0">
                                <?= number_format($totalLog['total'], 0, ',', '.'); ?>
                            </h4>
                        </div>
                        <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="ti ti-history fs-5"></i>
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
                <h6 class="mb-0 fw-bold text-dark">Log Aktivitas Terbaru</h6>
                <p class="text-muted small mb-0">Menampilkan 50 aktivitas terakhir dalam sistem</p>
            </div>
        </div>
        <div class="card-body p-0 pt-2">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light text-uppercase text-muted" style="font-size: 11px;">
                        <tr>
                            <th class="ps-4 py-2" width="60">No</th>
                            <th class="py-2" width="160">User / Kasir</th>
                            <th class="py-2">Aktivitas Sistem</th>
                            <th class="text-end pe-4 py-2" width="190">Waktu</th>
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
                                        <span class="badge bg-light text-dark fw-semibold px-2.5 py-1 rounded-pill border" style="font-size: 11px;">
                                            <i class="ti ti-user me-1 text-primary"></i> <?= htmlspecialchars($row['username']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark">
                                            <?= htmlspecialchars($row['aktivitas']); ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4 text-muted" style="font-size: 12px;">
                                        <i class="ti ti-clock me-1"></i> <?= date('d M Y, H:i:s', strtotime($row['tanggal'])); ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div class="text-muted opacity-50 mb-1">
                                        <i class="ti ti-file-analytics fs-2"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1 small">Belum Ada Log Aktivitas</h6>
                                    <p class="text-muted mb-0" style="font-size: 11px;">Catatan aktivitas akan muncul otomatis saat sistem digunakan.</p>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>