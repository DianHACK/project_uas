<?php

require_once "koneksi.php";

if (isset($_POST)) {

    $kode_barang  = mysqli_real_escape_string($koneksi, $_POST['kode_barang']);
    $nama_barang  = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $id_kategori  = $_POST['id_kategori'];
    $id_rak       = $_POST['id_rak'];
    $harga        = $_POST['harga'];
    $stok         = $_POST['stok'];
    $expired_date = $_POST['expired_date'];

    // Validasi
    if (
        empty($kode_barang) ||
        empty($nama_barang) ||
        empty($id_kategori) ||
        empty($id_rak) ||
        empty($harga) ||
        empty($stok) ||
        empty($expired_date)
    ) {

        echo "<script>
                alert('Semua data wajib diisi!');
                window.history.back();
              </script>";
        exit;
    }

    // Upload Gambar
    $gambar = "";

    if (!empty($_FILES['gambar']['name'])) {

        $namaFile = $_FILES['gambar']['name'];
        $tmp      = $_FILES['gambar']['tmp_name'];

        $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        $namaBaru = time() . "_" . rand(1000,9999) . "." . $ext;

        move_uploaded_file(
            $tmp,
            "../assets/images/barang/" . $namaBaru
        );

        $gambar = $namaBaru;
    }

    // Simpan Database
    $simpan = mysqli_query($koneksi, "

        INSERT INTO barang
        (
            kode_barang,
            nama_barang,
            id_kategori,
            id_rak,
            harga,
            stok,
            gambar,
            expired_date
        )

        VALUES

        (
            '$kode_barang',
            '$nama_barang',
            '$id_kategori',
            '$id_rak',
            '$harga',
            '$stok',
            '$gambar',
            '$expired_date'
        )

    ");

    if ($simpan) {

        echo "<script>

            alert('Barang berhasil ditambahkan');

            window.location='../index.php?page=databarang';

        </script>";

    } else {

        echo "<script>

            alert('Gagal menambahkan barang');

            window.history.back();

        </script>";

    }

}