<?php

$queryKategori = mysqli_query($koneksi, "
    SELECT *
    FROM kategori
    ORDER BY id DESC
");

?>
<div class="container-fluid px-4 py-3">

    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>

            <h2 class="fw-bold text-dark mb-1">
                Data Kategori
            </h2>

            <p class="text-muted mb-0">
                Kelola seluruh kategori barang SmartMart.
            </p>

        </div>

        <a href="#" class="btn btn-primary">

            <i class="ti ti-plus"></i>

            Tambah Kategori

        </a>

    </div>

    <!-- Card -->

    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-header bg-white py-3 border-bottom">

            <h5 class="mb-0 fw-bold">

                Daftar Kategori

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th width="70">No</th>

                            <th>Nama Kategori</th>

                            <th width="200">Aksi</th>

                        </tr>

                    </thead>
<tbody>

<?php

if(mysqli_num_rows($queryKategori) > 0){

    $no = 1;

    while($kategori = mysqli_fetch_assoc($queryKategori)){

?>

<tr>

    <td><?= $no++; ?></td>

    <td>

        <?= htmlspecialchars($kategori['nama_kategori']); ?>

    </td>

    <td>

        <button class="btn btn-warning btn-sm" disabled>

            <i class="ti ti-edit"></i>

        </button>

        <button class="btn btn-danger btn-sm" disabled>

            <i class="ti ti-trash"></i>

        </button>

    </td>

</tr>

<?php

    }

}else{

?>

<tr>

    <td colspan="3" class="text-center text-muted py-5">

        Belum ada data kategori.

    </td>

</tr>

<?php } ?>

</tbody>

                </table>

            </div>

        </div>

    </div>

</div>