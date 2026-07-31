<?php

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
ORDER BY barang.id DESC
");

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

        </div>

        <a href="index.php?page=tambahbarang" class="btn btn-primary">

            <i class="ti ti-plus"></i>
            Tambah Barang

        </a>

    </div>

    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-body">

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

                        if (mysqli_num_rows($query) > 0) {

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

                                        <?php if ($row['stok'] > 10) { ?>

                                            <span class="badge bg-success">
                                                <?= $row['stok']; ?>
                                            </span>

                                        <?php } elseif ($row['stok'] > 0) { ?>

                                            <span class="badge bg-warning text-dark">
                                                <?= $row['stok']; ?>
                                            </span>

                                        <?php } else { ?>

                                            <span class="badge bg-danger">
                                                Habis
                                            </span>

                                        <?php } ?>

                                    </td>

                                    <td class="text-center">

                                        <?php
                                        $expired = strtotime($row['expired_date']);
                                        $today = strtotime(date('Y-m-d'));

                                        if ($expired < $today) {
                                            echo '<span class="badge bg-danger">' . date('d-m-Y', $expired) . '</span>';
                                        } else {
                                            echo '<span class="badge bg-info">' . date('d-m-Y', $expired) . '</span>';
                                        }
                                        ?>

                                    </td>

                                    <td class="text-center">

                                        <?php if (!empty($row['gambar'])) { ?>

                                            <img
                                                src="assets/images/barang/<?= htmlspecialchars($row['gambar']); ?>"
                                                width="60"
                                                height="60"
                                                class="rounded border"
                                                style="object-fit:cover;">

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
                                            title="Edit">

                                            <i class="ti ti-edit"></i>

                                        </a>

                                        <a
                                            href="proses/hapusbarang.php?id=<?= $row['id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            title="Hapus"
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

                                <td colspan="10" class="text-center py-4">

                                    <div class="text-muted">

                                        Belum ada data barang.

                                    </div>

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>