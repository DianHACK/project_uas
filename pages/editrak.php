<?php

if (!isset($_GET['id'])) {

    header("Location: index.php?page=datarak");
    exit;

}

$id = (int) $_GET['id'];

$query = mysqli_query($koneksi, "
    SELECT *
    FROM rak
    WHERE id='$id'
");

if (mysqli_num_rows($query) == 0) {

    echo "<script>

            alert('Data rak tidak ditemukan.');

            window.location='index.php?page=datarak';

          </script>";

    exit;

}

$rak = mysqli_fetch_assoc($query);

?>

<div class="container-fluid px-4 py-3">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>

            <h2 class="fw-bold text-dark mb-1">

                Edit Rak

            </h2>

            <p class="text-muted mb-0">

                Ubah data rak SmartMart.

            </p>

        </div>

        <a
            href="index.php?page=datarak"
            class="btn btn-secondary">

            <i class="ti ti-arrow-left"></i>

            Kembali

        </a>

    </div>

    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-body">

            <form
                action="proses/editrak.php"
                method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?= $rak['id']; ?>">

                <div class="mb-3">

                    <label class="form-label fw-semibold">

                        Nama Rak

                    </label>

                    <input
                        type="text"
                        name="nama_rak"
                        class="form-control"
                        value="<?= htmlspecialchars($rak['nama_rak']); ?>"
                        required>

                </div>

                <div class="d-flex justify-content-end">

                    <button
                        type="reset"
                        class="btn btn-light me-2">

                        Reset

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="ti ti-device-floppy"></i>

                        Update

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>