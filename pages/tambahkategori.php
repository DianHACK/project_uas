<div class="container-fluid px-4 py-4">

    <!-- Header Section -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1 fs-4">
                Tambah Kategori
            </h2>
            <p class="text-muted small mb-0">
                Tambahkan kategori barang baru ke dalam sistem SmartMart.
            </p>
        </div>
        <a href="index.php?page=datakategori" class="btn btn-outline-secondary btn-sm px-3 rounded-pill shadow-xs d-inline-flex align-items-center gap-1">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
    </div>

    <!-- Card Form -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-white py-3 px-4 border-bottom-0 pt-4">
            <h5 class="mb-0 fw-bold text-dark fs-5">
                Form Tambah Kategori
            </h5>
        </div>
        <div class="card-body px-4 pb-4 pt-2">
            <form action="proses/tambahkategori.php" method="POST" id="formKategori">

                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary fs-7">
                        Nama Kategori
                    </label>
                    <input
                        type="text"
                        name="nama_kategori"
                        id="nama_kategori"
                        class="form-control form-control-lg rounded-3 fs-6"
                        placeholder="Contoh: Minuman, Makanan, Snack..."
                        autocomplete="off"
                        maxlength="100"
                        required>
                    <div class="invalid-feedback">
                        Nama kategori tidak boleh kosong!
                    </div>
                    <small class="text-muted mt-1 d-block" style="font-size: 12px;">
                        Gunakan nama kategori yang singkat, padat, dan mudah dipahami.
                    </small>
                </div>

                <div class="d-flex align-items-center gap-2 pt-2">
                    <button
                        type="submit"
                        name="simpan"
                        class="btn btn-primary px-4 py-2.5 rounded-3 fw-semibold shadow-xs d-inline-flex align-items-center gap-2">
                        <i class="ti ti-device-floppy fs-5"></i>
                        Simpan Kategori
                    </button>

                    <a
                        href="index.php?page=datakategori"
                        class="btn btn-light border px-4 py-2.5 rounded-3 fw-semibold text-secondary d-inline-flex align-items-center gap-2">
                        <i class="ti ti-x fs-5"></i>
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

    <!-- Informasi Card -->
    <div class="card shadow-sm border-0 rounded-4 bg-light-subtle">
        <div class="card-header bg-white py-3 px-4 border-bottom-0 pt-4 rounded-top-4">
            <h6 class="mb-0 fw-bold text-dark fs-6 d-flex align-items-center gap-2">
                <i class="ti ti-info-circle text-primary fs-5"></i> Informasi Penting
            </h6>
        </div>
        <div class="card-body px-4 pb-4 pt-2">
            <ul class="mb-0 text-muted small ps-3">
                <li class="mb-1.5">Nama kategori wajib diisi dan tidak boleh dikosongkan.</li>
                <li class="mb-1.5">Sistem akan menolak otomatis jika nama kategori sudah terdaftar sebelumnya (duplikat).</li>
                <li>Gunakan penamaan standar untuk memudahkan pengelompokan laporan inventaris.</li>
            </ul>
        </div>
    </div>

</div>

<!-- Validasi Sederhana Sisi Klien -->
<script>
document.getElementById('formKategori').addEventListener('submit', function(e) {
    let inputKategori = document.getElementById('nama_kategori');
    if (inputKategori.value.trim() === '') {
        inputKategori.classList.add('is-invalid');
        e.preventDefault();
    } else {
        inputKategori.classList.remove('is-invalid');
    }
});
</script>