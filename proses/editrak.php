<?php

require_once "koneksi.php";

if (!isset($_POST['id']) || !isset($_POST['nama_rak'])) {
    header("Location: ../index.php?page=datarak");
    exit();
}

$id = (int) $_POST['id'];
$nama_rak = trim(mysqli_real_escape_string($koneksi, $_POST['nama_rak']));

if ($nama_rak == "") {
    echo "<script>
            alert('Nama rak tidak boleh kosong.');
            window.location='../index.php?page=editrak&id=$id';
          </script>";
    exit();
}

$cek = mysqli_query($koneksi, "
    SELECT id
    FROM rak
    WHERE nama_rak='$nama_rak'
    AND id != '$id'
");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>
            alert('Nama rak sudah digunakan.');
            window.location='../index.php?page=editrak&id=$id';
          </script>";
    exit();
}

$update = mysqli_query($koneksi, "
    UPDATE rak
    SET nama_rak='$nama_rak'
    WHERE id='$id'
");

if ($update) {
    echo "<script>
            alert('Data rak berhasil diperbarui.');
            window.location='../index.php?page=datarak';
          </script>";
} else {
    echo "<script>
            alert('Data rak gagal diperbarui.');
            window.location='../index.php?page=editrak&id=$id';
          </script>";
}
