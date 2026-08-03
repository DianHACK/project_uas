<?php
$where = "";

if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
    $keyword = mysqli_real_escape_string($koneksi, $_GET['keyword']);
    $where = "WHERE
                barang.kode_barang LIKE '%$keyword%'
                OR barang.nama_barang LIKE '%$keyword%'";
}

$query = mysqli_query($koneksi, "
SELECT
    barang.*,
    kategori.nama_kategori,
    rak.nama_rak
FROM barang
LEFT JOIN kategori
    ON barang.id_kategori = kategori.id
LEFT JOIN rak
    ON barang.id_rak = rak.id
$where
ORDER BY barang.id DESC
");

$total_barang = mysqli_num_rows($query);
?>

<div class="container-fluid px-4 py-3">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                Data Barang
            </h2>
            <p class="text-muted mb-0">
                Kelola seluruh data barang SmartMart.
            </p>
            <div class="mt-2">
                <span class="badge bg-primary">
                    Total Barang : <?= $total_barang; ?>
                </span>
            </div>
        </div>

        <a href="index.php?page=tambahbarang" class="btn btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Barang
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">

            <form method="GET" class="row g-3 mb-4">
                <input type="hidden" name="page" value="databarang">

                <div class="col-md-6">
                    <input
                        type="text"
                        name="keyword"
                        class="form-control"
                        placeholder="Cari kode barang atau nama barang..."
                        value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-search"></i>
                        Cari
                    </button>

                    <a href="index.php?page=databarang" class="btn btn-secondary">
                        <i class="ti ti-refresh"></i>
                        Reset
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th width="50">No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Rak</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Expired</th>
                            <th>Gambar</th>
                            <th width="140">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($total_barang > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                                <tr>
                                    <td class="text-center">
                                        <?= $no++; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['kode_barang']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_barang']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_kategori']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama_rak']); ?>
                                    </td>

                                    <td>
                                        Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                                    </td>

                                    <td class="text-center">
                                        <?php
                                        if ($row['stok'] == 0) {
                                            echo '<span class="badge bg-danger">Habis</span>';
                                        } elseif ($row['stok'] <= 10) {
                                            echo '<span class="badge bg-warning text-dark">Menipis (' . $row['stok'] . ')</span>';
                                        } else {
                                            echo '<span class="badge bg-success">Aman (' . $row['stok'] . ')</span>';
                                        }
                                        ?>
                                    </td>

                                    <td class="text-center">
                                        <?php
                                        $today = strtotime(date('Y-m-d'));
                                        $expired = strtotime($row['expired_date']);
                                        $selisih = ($expired - $today) / 86400;

                                        if ($expired < $today) {
                                            echo '<span class="badge bg-danger">
                                                    Expired<br>' .
                                                    date('d-m-Y', $expired) .
                                                  '</span>';
                                        } elseif ($selisih <= 30) {
                                            echo '<span class="badge bg-warning text-dark">
                                                    Hampir Expired<br>' .
                                                    date('d-m-Y', $expired) .
                                                  '</span>';
                                        } else {
                                            echo '<span class="badge bg-success">' .
                                                    date('d-m-Y', $expired) .
                                                  '</span>';
                                        }
                                        ?>
                                    </td>

                                    <td class="text-center">
                                        <?php if (!empty($row['gambar'])) { ?>
                                            <a href="assets/images/barang/<?= htmlspecialchars($row['gambar']); ?>" target="_blank">
                                                <img
                                                    src="assets/images/barang/<?= htmlspecialchars($row['gambar']); ?>"
                                                    width="60"
                                                    height="60"
                                                    class="rounded border shadow-sm"
                                                    style="object-fit:cover;">
                                            </a>
                                        <?php } else { ?>
                                            <span class="text-muted">
                                                Tidak ada gambar
                                            </span>
                                        <?php } ?>
                                    </td>

                                    <td class="text-center">
                                        <a
                                            href="index.php?page=editbarang&id=<?= $row['id']; ?>"
                                            class="btn btn-warning btn-sm"
                                            data-bs-toggle="tooltip"
                                            title="Edit Barang">
                                            <i class="ti ti-edit"></i>
                                        </a>

                                        <a
                                            href="proses/hapusbarang.php?id=<?= $row['id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            data-bs-toggle="tooltip"
                                            title="Hapus Barang"
                                            onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php 
                            }
                        } else { 
                        ?>
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <i class="ti ti-package-off" style="font-size:60px;"></i>
                                    <h5 class="mt-3">
                                        Data barang tidak ditemukan
                                    </h5>
                                    <p class="text-muted">
                                        Silakan tambahkan data barang baru.
                                    </p>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<script>
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) {
        new bootstrap.Tooltip(el);
    });
</script>