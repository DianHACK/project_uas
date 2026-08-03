<?php
session_start();
require_once "koneksi.php";
require_once "helper.php";

if (isset($_GET['id'])) {

    $id = (int) $_GET['id'];

    // Ambil nama_barang dan gambar sebelum data dihapus
    $query = mysqli_query($koneksi, "SELECT nama_barang, gambar FROM barang WHERE id='$id'");

    if (mysqli_num_rows($query) > 0) {

        $barang = mysqli_fetch_assoc($query);
        $nama_barang = $barang['nama_barang'];

        if (!empty($barang['gambar'])) {

            $file = "../assets/images/barang/" . $barang['gambar'];

            if (file_exists($file)) {

                unlink($file);
            }
        }

        $hapus = mysqli_query($koneksi, "DELETE FROM barang WHERE id='$id'");

        if ($hapus) {

            // Catat aktivitas ke dalam Monitor Log
            catat_log($koneksi, "Menghapus barang: " . $nama_barang);

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