<?php
// Filter tanggal jika digunakan
$tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : '';
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : '';

$where = "";
if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
    $where = "WHERE DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
}

// Query data transaksi berdasarkan filter
$query = mysqli_query($koneksi, "SELECT * FROM transaksi $where ORDER BY id DESC");

// Hitung total pendapatan dan total transaksi
$query_sum = mysqli_query($koneksi, "SELECT COUNT(*) as total_transaksi, SUM(total_harga) as total_pendapatan FROM transaksi $where");
$data_sum = mysqli_fetch_assoc($query_sum);
$total_transaksi = $data_sum['total_transaksi'] ?? 0;
$total_pendapatan = $data_sum['total_pendapatan'] ?? 0;
?>

<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">Laporan Penjualan</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php?page=home">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Penjualan</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Ringkasan / Kartu Statistik Laporan -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="text-white-50 mb-1">Total Pendapatan</h6>
                    <h3 class="fw-bold mb-0">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="text-white-50 mb-1">Total Transaksi Berhasil</h6>
                    <h3 class="fw-bold mb-0"><?= number_format($total_transaksi, 0, ',', '.'); ?> Transaksi</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Tabel Laporan -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-3">Filter & Data Laporan</h5>
            
            <!-- Form Filter Berdasarkan Tanggal -->
            <form method="GET" action="index.php" class="row g-3 mb-4">
                <input type="hidden" name="page" value="laporan">
                <div class="col-md-4">
                    <label class="form-label fs-3">Dari Tanggal</label>
                    <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai; ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fs-3">Sampai Tanggal</label>
                    <input type="date" name="tgl_selesai" class="form-control" value="<?= $tgl_selesai; ?>" required>
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="fa fa-filter me-1"></i> Filter
                    </button>
                    <a href="index.php?page=laporan" class="btn btn-secondary">
                        <i class="fa fa-refresh"></i> Reset
                    </a>
                </div>
            </form>

            <!-- Tombol Cetak Laporan Keseluruhan -->
            <div class="mb-3 text-end">
                <a href="cetaklaporan.php?tgl_mulai=<?= $tgl_mulai; ?>&tgl_selesai=<?= $tgl_selesai; ?>" target="_blank" class="btn btn-warning">
                    <i class="fa fa-print me-1"></i> Cetak Laporan PDF / Print
                </a>
            </div>

            <!-- Tabel Data Laporan -->
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Invoice</th>
                            <th>Tanggal & Waktu</th>
                            <th>Kasir</th>
                            <th>Metode</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($query) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><span class="fw-bold text-primary"><?= $row['no_invoice']; ?></span></td>
                            <td><?= $row['tanggal']; ?></td>
                            <td><?= $row['kasir']; ?></td>
                            <td><span class="badge bg-success-subtle text-success"><?= $row['metode_pembayaran']; ?></span></td>
                            <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                            <td>
                                <a href="nota.php?id=<?= $row['id']; ?>" target="_blank" class="btn btn-info btn-sm text-white">
                                    <i class="fa fa-eye"></i> Lihat Nota
                                </a>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center text-muted py-4'>Tidak ada data transaksi pada rentang tanggal tersebut.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>