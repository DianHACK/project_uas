<?php
include 'proses/koneksi.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;
$edit = false;
$nama_kategori = '';

if ($id) {
    $edit = true;
    $query = $koneksi->query("SELECT * FROM kategori WHERE id = '$id'");
    $data = $query->fetch_assoc();
    $nama_kategori = $data['nama_kategori'];
}
?>

<div class="container-fluid" style="margin-bottom: 55vh">
    <h4><b>Master > <?= $edit ? 'Edit' : 'Tambah' ?> Kategori</b></h4>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'duplikat'): ?>
        <div class="alert alert-danger">Nama Kategori sudah ada, silakan gunakan nama lain.</div>
    <?php endif; ?>

    <form method="post" action="proses/kategori/<?= $edit ? 'edit.php' : 'tambah.php' ?>">
        <?php if ($edit): ?>
            <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" name="nama_kategori" value="<?= $nama_kategori ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php?page=datakategori" class="btn btn-secondary">Kembali</a>
    </form>
</div>
