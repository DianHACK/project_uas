<?php

require_once "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id            = (int) $_POST['id'];
    $kode_barang   = mysqli_real_escape_string($koneksi, trim($_POST['kode_barang']));
    $nama_barang   = mysqli_real_escape_string($koneksi, trim($_POST['nama_barang']));
    $id_kategori   = (int) $_POST['id_kategori'];
    $id_rak        = (int) $_POST['id_rak'];
    $harga         = (int) $_POST['harga'];
    $stok          = (int) $_POST['stok'];
    $expired_date  = $_POST['expired_date'];
    $gambar_lama   = $_POST['gambar_lama'];

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

    $gambar = $gambar_lama;

    // Upload gambar baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {

        $namaFile = $_FILES['gambar']['name'];
        $tmpFile  = $_FILES['gambar']['tmp_name'];

        $extensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png'];

        if (!in_array($extensi, $allowed)) {

            echo "<script>
                    alert('Format gambar harus JPG, JPEG atau PNG!');
                    window.history.back();
                  </script>";
            exit;
        }

        $namaBaru = time() . "_" . mt_rand(1000, 9999) . "." . $extensi;

        move_uploaded_file(
            $tmpFile,
            "../assets/images/barang/" . $namaBaru
        );

        if (!empty($gambar_lama)) {

            $path = "../assets/images/barang/" . $gambar_lama;

            if (file_exists($path)) {

                unlink($path);
            }
        }

        $gambar = $namaBaru;
    }

    $update = mysqli_query($koneksi, "

        UPDATE barang SET

            kode_barang   = '$kode_barang',
            nama_barang   = '$nama_barang',
            id_kategori   = '$id_kategori',
            id_rak        = '$id_rak',
            harga         = '$harga',
            stok          = '$stok',
            gambar        = '$gambar',
            expired_date  = '$expired_date'

        WHERE id = '$id'

    ");

    if ($update) {

        echo "<script>

            alert('Barang berhasil diperbarui');

            window.location='../index.php?page=databarang';

        </script>";
    } else {

        echo "<script>

            alert('Gagal memperbarui barang');

            window.history.back();

        </script>";
    }
}
