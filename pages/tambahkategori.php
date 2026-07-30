<div class="container-fluid px-4 py-3">

    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>

            <h2 class="fw-bold text-dark mb-1">
                Tambah Kategori
            </h2>

            <p class="text-muted mb-0">
                Tambahkan kategori barang baru ke dalam sistem SmartMart.
            </p>

        </div>

        <a href="index.php?page=datakategori" class="btn btn-secondary">

            <i class="ti ti-arrow-left"></i>

            Kembali

        </a>

    </div>

    <!-- Card Form -->

    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-header bg-white py-3">

            <h5 class="mb-0 fw-bold">

                Form Tambah Kategori

            </h5>

        </div>

        <div class="card-body">

            <form action="proses/tambahkategori.php" method="POST">

                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Nama Kategori

                    </label>

                    <input
                        type="text"
                        name="nama_kategori"
                        class="form-control"
                        placeholder="Masukkan nama kategori..."
                        autocomplete="off"
                        maxlength="100"
                        required>

                    <small class="text-muted">

                        Contoh: Minuman, Makanan, Snack, Peralatan Rumah Tangga.

                    </small>

                </div>

                <hr>

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        name="simpan"
                        class="btn btn-primary">

                        <i class="ti ti-device-floppy"></i>

                        Simpan

                    </button>

                    <a
                        href="index.php?page=datakategori"
                        class="btn btn-light border">

                        <i class="ti ti-x"></i>

                        Batal

                    </a>

                </div>

            </form>

        </div>

    </div>

    <!-- Informasi -->

    <div class="card shadow-sm border-0 mt-4">

        <div class="card-header bg-white">

            <h6 class="mb-0 fw-bold">

                💡 Informasi

            </h6>

        </div>

        <div class="card-body">

            <ul class="mb-0 text-muted">

                <li>Nama kategori tidak boleh kosong.</li>

                <li>Nama kategori tidak boleh sama dengan kategori yang sudah ada.</li>

                <li>Gunakan nama kategori yang singkat dan mudah dipahami.</li>

            </ul>

        </div>

    </div>

</div>