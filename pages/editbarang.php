<?php

if (!isset($_GET['id'])) {

    echo "
    <script>
        alert('Data barang tidak ditemukan!');
        window.location='index.php?page=databarang';
    </script>";
    exit;
}

$id = intval($_GET['id']);

$queryBarang = mysqli_query($koneksi, "SELECT * FROM barang WHERE id='$id'");

if (mysqli_num_rows($queryBarang) == 0) {

    echo "
    <script>
        alert('Data barang tidak ditemukan!');
        window.location='index.php?page=databarang';
    </script>";
    exit;
}

$barang = mysqli_fetch_assoc($queryBarang);

$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
$queryRak = mysqli_query($koneksi, "SELECT * FROM rak ORDER BY nama_rak ASC");

?>

<div class="container-fluid px-4 py-3">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>

            <h2 class="fw-bold text-dark mb-1">
                Edit Barang
            </h2>

            <p class="text-muted mb-0">
                Perbarui informasi barang SmartMart.
            </p>

        </div>

        <a href="index.php?page=databarang" class="btn btn-secondary">

            <i class="ti ti-arrow-left"></i>
            Kembali

        </a>

    </div>

    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-body">

            <form action="proses/editbarang.php"
                method="POST"
                enctype="multipart/form-data"
                autocomplete="off">

                <input
                    type="hidden"
                    name="id"
                    value="<?= $barang['id']; ?>">

                <input
                    type="hidden"
                    name="gambar_lama"
                    value="<?= $barang['gambar']; ?>">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Kode Barang
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="kode_barang"
                            value="<?= htmlspecialchars($barang['kode_barang']); ?>"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Nama Barang
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="nama_barang"
                            value="<?= htmlspecialchars($barang['nama_barang']); ?>"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Kategori
                        </label>

                        <select
                            name="id_kategori"
                            class="form-select"
                            required>

                            <option value="">
                                -- Pilih Kategori --
                            </option>

                            <?php while ($kategori = mysqli_fetch_assoc($queryKategori)) { ?>

                                <option
                                    value="<?= $kategori['id']; ?>"
                                    <?= ($kategori['id'] == $barang['id_kategori']) ? 'selected' : ''; ?>>

                                    <?= $kategori['nama_kategori']; ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Rak
                        </label>

                        <select
                            name="id_rak"
                            class="form-select"
                            required>

                            <option value="">
                                -- Pilih Rak --
                            </option>

                            <?php while ($rak = mysqli_fetch_assoc($queryRak)) { ?>

                                <option
                                    value="<?= $rak['id']; ?>"
                                    <?= ($rak['id'] == $barang['id_rak']) ? 'selected' : ''; ?>>

                                    <?= $rak['nama_rak']; ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Harga
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            name="harga"
                            value="<?= $barang['harga']; ?>"
                            min="0"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Stok
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            name="stok"
                            value="<?= $barang['stok']; ?>"
                            min="0"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Expired Date
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            name="expired_date"
                            value="<?= $barang['expired_date']; ?>"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Gambar Lama
                        </label>

                        <br>

                        <?php if (!empty($barang['gambar'])) { ?>

                            <img
                                src="assets/images/barang/<?= $barang['gambar']; ?>"
                                width="120"
                                class="img-thumbnail mb-2">

                        <?php } else { ?>

                            <div class="text-muted mb-2">
                                Tidak ada gambar
                            </div>

                        <?php } ?>

                        <input
                            type="file"
                            class="form-control"
                            name="gambar"
                            accept=".jpg,.jpeg,.png">

                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti gambar.
                        </small>

                    </div>

                </div>

                <hr>

                <button
                    type="submit"
                    class="btn btn-success">

                    <i class="ti ti-device-floppy"></i>
                    Update

                </button>

                <button
                    type="reset"
                    class="btn btn-warning">

                    <i class="ti ti-refresh"></i>
                    Reset

                </button>

                <a
                    href="index.php?page=databarang"
                    class="btn btn-secondary">

                    <i class="ti ti-arrow-left"></i>
                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>