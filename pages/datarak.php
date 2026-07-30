<?php

$queryRak = mysqli_query($koneksi, "
    SELECT *
    FROM rak
    ORDER BY id DESC
");

$totalRak = mysqli_num_rows($queryRak);

?>

<div class="container-fluid px-4 py-3">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>

            <h2 class="fw-bold text-dark mb-1">
                Data Rak
            </h2>

            <p class="text-muted mb-0">
                Kelola seluruh data rak penyimpanan barang SmartMart.
            </p>

        </div>

        <a href="index.php?page=tambahrak"
            class="btn btn-primary">

            <i class="ti ti-plus"></i>

            Tambah Rak

        </a>

    </div>

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h6 class="text-muted">

                        Total Rak

                    </h6>

                    <h2 class="fw-bold text-primary">

                        <?= $totalRak; ?>

                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-header bg-white">

            <h5 class="fw-bold mb-0">

                Daftar Rak

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="60">

                                No

                            </th>

                            <th>

                                Nama Rak

                            </th>

                            <th width="220">

                                Tanggal Dibuat

                            </th>

                            <th width="170">

                                Aksi

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        if ($totalRak > 0) {

                            $no = 1;

                            mysqli_data_seek($queryRak, 0);

                            while ($rak = mysqli_fetch_assoc($queryRak)) {

                        ?>

                                <tr>

                                    <td>

                                        <?= $no++; ?>

                                    </td>

                                    <td>

                                        <span class="fw-semibold">

                                            <?= htmlspecialchars($rak['nama_rak']); ?>

                                        </span>

                                    </td>

                                    <td>

                                        <?= date('d M Y H:i', strtotime($rak['created_at'])); ?>

                                    </td>

                                    <td>

                                        <a
                                            href="index.php?page=editrak&id=<?= $rak['id']; ?>"
                                            class="btn btn-warning btn-sm">

                                            <i class="ti ti-edit"></i>

                                        </a>

                                        <a href="#"
                                            class="btn btn-danger btn-sm">

                                            <i class="ti ti-trash"></i>

                                        </a>

                                    </td>

                                </tr>

                        <?php

                            }

                        } else {

                        ?>

                            <tr>

                                <td colspan="4"
                                    class="text-center py-5">

                                    <i class="ti ti-database-off fs-1 text-secondary"></i>

                                    <h5 class="mt-3">

                                        Belum Ada Data Rak

                                    </h5>

                                    <p class="text-muted">

                                        Silakan tambahkan data rak terlebih dahulu.

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