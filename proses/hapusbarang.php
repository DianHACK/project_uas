<?php

require_once "koneksi.php";

if (isset($_GET['id'])) {

    $id = (int) $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT gambar FROM barang WHERE id='$id'");

    if (mysqli_num_rows($query) > 0) {

        $barang = mysqli_fetch_assoc($query);

        if (!empty($barang['gambar'])) {

            $file = "../assets/images/barang/" . $barang['gambar'];

            if (file_exists($file)) {

                unlink($file);
            }
        }

        $hapus = mysqli_query($koneksi, "DELETE FROM barang WHERE id='$id'");

        if ($hapus) {

            echo "<script>

                    alert('Barang berhasil dihapus');

                    window.location='../index.php?page=databarang';

                  </script>";
        } else {

            echo "<script>

                    alert('Gagal menghapus barang');

                    window.location='../index.php?page=databarang';

                  </script>";
        }
    } else {

        echo "<script>

                alert('Data tidak ditemukan');

                window.location='../index.php?page=databarang';

              </script>";
    }
} else {

    header("Location: ../index.php?page=databarang");
}
