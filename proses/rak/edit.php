<?php
include '../koneksi.php';

$id = $_POST['id'];
$nama_rak = $_POST['nama_rak'];

// Cek apakah nama rak sudah dipakai di ID lain
$cek = mysqli_query($koneksi, "SELECT * FROM rak WHERE nama_rak = '$nama_rak' AND id != '$id'");
if (mysqli_num_rows($cek) > 0) {
    header("Location: ../../index.php?page=tambahrak&id=$id&error=duplikat");
    exit;
}

$query = "UPDATE rak SET nama_rak='$nama_rak' WHERE id='$id'";
mysqli_query($koneksi, $query);

header("Location: ../../index.php?page=tambahrak");
