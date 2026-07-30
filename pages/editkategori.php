<?php

if (!isset($_GET['id'])) {

    header("Location: index.php?page=datakategori");
    exit;

}

$id = (int)$_GET['id'];

$query = mysqli_query($koneksi, "
    SELECT *
    FROM kategori
    WHERE id='$id'
");

if(mysqli_num_rows($query) == 0){

    header("Location: index.php?page=datakategori");
    exit;

}

$data = mysqli_fetch_assoc($query);

?>

<div class="container-fluid px-4 py-3">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>

            <h2 class="fw-bold text-dark mb-1">

                Edit Kategori

            </h2>

            <p class="text-muted mb-0">

                Perbarui data kategori barang.

            </p>

        </div>

        <a href="index.php?page=datakategori"
            class="btn btn-secondary">

            <i class="ti ti-arrow-left"></i>

            Kembali

        </a>

    </div>

    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-header bg-white py-3">

            <h5 class="mb-0 fw-bold">

                Form Edit Kategori

            </h5>

        </div>

        <div class="card-body">

            <form action="#" method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?= $data['id']; ?>">

                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Nama Kategori

                    </label>

                    <input
                        type="text"
                        name="nama_kategori"
                        class="form-control"
                        value="<?= htmlspecialchars($data['nama_kategori']); ?>"
                        required>

                </div>

                <button
                    type="submit"
                    class="btn btn-warning">

                    <i class="ti ti-edit"></i>

                    Update

                </button>

                <a
                    href="index.php?page=datakategori"
                    class="btn btn-light border">

                    Batal

                </a>

            </form>

        </div>

    </div>

</div>