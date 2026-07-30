<?php
include 'proses/koneksi.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;
$edit = false;
$nama_rak = '';

if ($id) {
    $edit = true;
    $query = $koneksi->query("SELECT * FROM rak WHERE id = '$id'");
    $data = $query->fetch_assoc();
    $nama_rak = $data['nama_rak'];
}
?>

<div class="container-fluid" style="margin-bottom: 55vh">
    <h4><b>Master > <?= $edit ? 'Edit' : 'Tambah' ?> Rak</b></h4>
    <?php if (isset($_GET['error']) && $_GET['error'] == 'duplikat'): ?>
    <div class="alert alert-danger">Nama Rak sudah ada, silakan gunakan nama lain.</div>
<?php endif; ?>

    <form method="post" action="proses/rak/<?= $edit ? 'edit.php' : 'tambah.php' ?>">
        <?php if ($edit): ?>
            <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Nama Rak</label>
            <input type="text" class="form-control" name="nama_rak" value="<?= $nama_rak ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php?page=datarak" class="btn btn-secondary">Kembali</a>
    </form>
</div>

