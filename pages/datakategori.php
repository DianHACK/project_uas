<?php

$keyword = "";

if (isset($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']);
}

if ($keyword != "") {

    $queryKategori = mysqli_query($koneksi, "
        SELECT *
        FROM kategori
        WHERE nama_kategori LIKE '%$keyword%'
        ORDER BY id DESC
    ");

} else {

    $queryKategori = mysqli_query($koneksi, "
        SELECT *
        FROM kategori
        ORDER BY id DESC
    ");

}

?>

<div class="container-fluid px-4 py-3">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>

            <h2 class="fw-bold text-dark mb-1">
                Data Kategori
            </h2>

            <p class="text-muted mb-0">
                Kelola seluruh kategori barang SmartMart.
            </p>

        </div>

        <a href="index.php?page=tambahkategori" class="btn btn-primary">

            <i class="ti ti-plus"></i>

            Tambah Kategori

        </a>

    </div>

    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-header bg-white py-3">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <h5 class="mb-0 fw-bold">

                        Daftar Kategori

                    </h5>

                </div>

                <div class="col-md-6">

                    <form method="GET">

                        <input
                            type="hidden"
                            name="page"
                            value="datakategori">

                        <div class="input-group">

                            <input
                                type="text"
                                name="keyword"
                                class="form-control"
                                placeholder="Cari kategori..."
                                value="<?= htmlspecialchars($keyword); ?>">

                            <button
                                class="btn btn-primary"
                                type="submit">

                                <i class="ti ti-search"></i>

                            </button>

                            <?php if ($keyword != "") { ?>

                                <a href="index.php?page=datakategori"
                                    class="btn btn-secondary">

                                    Reset

                                </a>

                            <?php } ?>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="70">No</th>
                            <th>Nama Kategori</th>
                            <th width="220">Tanggal Dibuat</th>
                            <th width="170">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        if (mysqli_num_rows($queryKategori) > 0) {

                            $no = 1;

                            while ($kategori = mysqli_fetch_assoc($queryKategori)) {

                        ?>

                                <tr>

                                    <td><?= $no++; ?></td>

                                    <td><?= htmlspecialchars($kategori['nama_kategori']); ?></td>

                                    <td><?= date('d M Y H:i', strtotime($kategori['created_at'])); ?></td>

                                    <td>

                                        <a href="index.php?page=editkategori&id=<?= $kategori['id']; ?>"
                                            class="btn btn-warning btn-sm">

                                            <i class="ti ti-edit"></i>

                                        </a>

                                        <a href="proses/hapuskategori.php?id=<?= $kategori['id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus kategori ini?')">

                                            <i class="ti ti-trash"></i>

                                        </a>

                                    </td>

                                </tr>

                        <?php

                            }

                        } else {

                        ?>

                            <tr>

                                <td colspan="4" class="text-center py-5">

                                    <i class="ti ti-search-off fs-1 text-secondary"></i>

                                    <h5 class="mt-3">

                                        Data Tidak Ditemukan

                                    </h5>

                                    <p class="text-muted">

                                        Tidak ada kategori yang sesuai dengan pencarian.

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