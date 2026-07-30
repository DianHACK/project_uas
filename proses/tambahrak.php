<?php

require_once "koneksi.php";

if (!isset($_POST['nama_rak'])) {

    header("Location: ../index.php?page=tambahrak");
    exit;

}

$nama_rak = trim(mysqli_real_escape_string($koneksi, $_POST['nama_rak']));

if ($nama_rak == "") {

    echo "<script>

            alert('Nama rak tidak boleh kosong.');

            window.location='../index.php?page=tambahrak';

          </script>";

    exit;

}

$cek = mysqli_query($koneksi, "
    SELECT id
    FROM rak
    WHERE nama_rak='$nama_rak'
");

if (mysqli_num_rows($cek) > 0) {

    echo "<script>

            alert('Nama rak sudah digunakan.');

            window.location='../index.php?page=tambahrak';

          </script>";

    exit;

}

$simpan = mysqli_query($koneksi, "
    INSERT INTO rak
    (
        nama_rak,
        created_at
    )
    VALUES
    (
        '$nama_rak',
        NOW()
    )
");

if ($simpan) {

    echo "<script>

            alert('Data rak berhasil ditambahkan.');

            window.location='../index.php?page=datarak';

          </script>";

} else {

    echo "<script>

            alert('Data rak gagal disimpan.');

            window.location='../index.php?page=tambahrak';

          </script>";

}