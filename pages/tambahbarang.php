<?php
include 'proses/koneksi.php';

$id_barang = isset($_GET['id']) ? $_GET['id'] : null;
$edit = false;

// Default value
$nama_barang = $harga = $stok = $expired_date = $gambar = $id_kategori = $id_rak = '';

if ($id_barang) {
    $edit = true;
    $result = $koneksi->query("SELECT * FROM barang WHERE id = '$id_barang'");
    $row = $result->fetch_assoc();

    $nama_barang   = $row['nama_barang'];
    $harga         = $row['harga'];
    $stok          = $row['stok'];
    $expired_date  = $row['expired_date'];
    $gambar        = $row['gambar'];
    $id_kategori   = $row['id_kategori'];
    $id_rak        = $row['id_rak'];
}
?>

<div class="container-fluid">
    <h4><b>Barang > <?= $edit ? 'Edit' : 'Tambah' ?> Barang</b></h4>
    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="fw-bolder text-white"><?= $edit ? 'Edit' : 'Tambah' ?> Barang</h4>
        </div>
        <div class="card-body">
            <form action="proses/barang/<?= $edit ? 'proses_edit_barang.php' : 'proses_tambah_barang.php' ?>" method="post" enctype="multipart/form-data">
                <?php if ($edit): ?>
                    <input type="hidden" name="id" value="<?= $id_barang ?>">
                <?php endif; ?>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col">
                            <div>
                                <label class="mb-2 fw-bolder">Nama Barang</label>
                                <input class="form-control form-control-lg" type="text" name="nama_barang" value="<?= $nama_barang ?>" required>
                            </div>
                            <div class="mt-4">
                                <label class="mb-2 fw-bolder">Nama Kategori</label>
                                <select name="id_kategori" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php
                                    $kategori = $koneksi->query("SELECT * FROM kategori");
                                    while($row = $kategori->fetch_assoc()): ?>
                                        <option value="<?= $row['id'] ?>" <?= ($row['id'] == $id_kategori) ? 'selected' : '' ?>>
                                            <?= $row['nama_kategori'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mt-4">
                                <label class="mb-2 fw-bolder">Harga Barang</label>
                                <input class="form-control form-control-lg" type="number" name="harga" value="<?= $harga ?>" required>
                            </div>
                            <div class="mt-4">
                                <label class="mb-2 fw-bolder">Stock Barang</label>
                                <input class="form-control form-control-lg" type="number" name="stok" value="<?= $stok ?>" required>
                            </div>
                        </div>

                        <div class="col">
                            <div>
                                <label class="mb-2 fw-bolder">Nama Rak</label>
                                <select name="id_rak" class="form-select" required>
                                    <option value="">-- Pilih Rak --</option>
                                    <?php
                                    $rak = $koneksi->query("SELECT * FROM rak");
                                    while($row = $rak->fetch_assoc()): ?>
                                        <option value="<?= $row['id'] ?>" <?= ($row['id'] == $id_rak) ? 'selected' : '' ?>>
                                            <?= $row['nama_rak'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mt-4">
                                <label class="mb-2 fw-bolder">Gambar Barang</label>
                                <div class="input-group">
                                    <input class="form-control" type="file" name="gambar">
                                    <label class="input-group-text">Upload</label>
                                </div>
                                <?php if ($edit && $gambar != ''): ?>
                                    <p class="mt-2">Gambar saat ini: <img src="proses/gambar/<?= $gambar ?>" width="80"></p>
                                <?php endif; ?>
                            </div>
                            <div class="mt-4">
                                <label class="mb-2 fw-bolder">Expired Date</label>
                                <input class="form-control" type="date" name="expired_date" value="<?= $expired_date ?>" required>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary mb-2" name="submit">Simpan</button>
                                <a href="index.php?page=databarang" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer bg-primary"></div>
    </div>
</div>
