<?php

$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
$queryRak = mysqli_query($koneksi, "SELECT * FROM rak ORDER BY nama_rak ASC");

?>

<div class="container-fluid px-4 py-3">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>

            <h2 class="fw-bold text-dark mb-1">
                Tambah Barang
            </h2>

            <p class="text-muted mb-0">
                Tambahkan data barang baru ke dalam sistem SmartMart.
            </p>

        </div>

        <a href="index.php?page=databarang" class="btn btn-secondary">

            <i class="ti ti-arrow-left"></i>
            Kembali

        </a>

    </div>

    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-body">

            <form action="#" method="post" enctype="multipart/form-data">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Kode Barang
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="kode_barang"
                            placeholder="Masukkan kode barang">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Nama Barang
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="nama_barang"
                            placeholder="Masukkan nama barang">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Kategori
                        </label>

                        <select
                            name="id_kategori"
                            class="form-select">

                            <option value="">
                                -- Pilih Kategori --
                            </option>

                            <?php while ($kategori = mysqli_fetch_assoc($queryKategori)) { ?>

                                <option value="<?= $kategori['id']; ?>">

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
                            class="form-select">

                            <option value="">
                                -- Pilih Rak --
                            </option>

                            <?php while ($rak = mysqli_fetch_assoc($queryRak)) { ?>

                                <option value="<?= $rak['id']; ?>">

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
                            placeholder="Masukkan harga barang">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Stok
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            name="stok"
                            placeholder="Masukkan jumlah stok">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Expired Date
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            name="expired_date">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Gambar Barang
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            name="gambar">

                    </div>

                </div>

                <hr>

                <button
                    type="submit"
                    class="btn btn-primary">

                    <i class="ti ti-device-floppy"></i>
                    Simpan

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