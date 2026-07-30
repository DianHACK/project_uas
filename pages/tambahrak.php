<div class="container-fluid px-4 py-3">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>

            <h2 class="fw-bold text-dark mb-1">

                Tambah Rak

            </h2>

            <p class="text-muted mb-0">

                Tambahkan data rak baru ke SmartMart.

            </p>

        </div>

        <a href="index.php?page=datarak"
            class="btn btn-secondary">

            <i class="ti ti-arrow-left"></i>

            Kembali

        </a>

    </div>

    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-body">

            <form action="proses/tambahrak.php"
                method="POST">

                <div class="mb-3">

                    <label class="form-label fw-semibold">

                        Nama Rak

                    </label>

                    <input
                        type="text"
                        name="nama_rak"
                        class="form-control"
                        placeholder="Contoh : Rak Minuman"
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

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>