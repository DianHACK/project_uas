<?php

require_once "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $kode_barang  = mysqli_real_escape_string($koneksi, trim($_POST['kode_barang']));
    $nama_barang  = mysqli_real_escape_string($koneksi, trim($_POST['nama_barang']));
    $id_kategori  = (int) $_POST['id_kategori'];
    $id_rak       = (int) $_POST['id_rak'];
    $harga        = (int) $_POST['harga'];
    $stok         = (int) $_POST['stok'];
    $expired_date = $_POST['expired_date'];

    // Validasi input kosong
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

    // Validasi kode barang tidak boleh sama
    $cek = mysqli_query($koneksi, "
        SELECT id
        FROM barang
        WHERE kode_barang='$kode_barang'
    ");

    if (mysqli_num_rows($cek) > 0) {

        echo "<script>
                alert('Kode barang sudah digunakan!');
                window.history.back();
              </script>";
        exit;
    }

    // Validasi harga
    if ($harga <= 0) {

        echo "<script>
                alert('Harga harus lebih dari 0!');
                window.history.back();
              </script>";
        exit;
    }

    // Validasi stok
    if ($stok < 0) {

        echo "<script>
                alert('Stok tidak boleh negatif!');
                window.history.back();
              </script>";
        exit;
    }

    $gambar = "";

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {

        $namaFile = $_FILES['gambar']['name'];
        $tmpFile  = $_FILES['gambar']['tmp_name'];
        $ukuran   = $_FILES['gambar']['size'];

        $extensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png'];

        // Validasi format gambar
        if (!in_array($extensi, $allowed)) {

            echo "<script>
                    alert('Format gambar harus JPG, JPEG atau PNG!');
                    window.history.back();
                  </script>";
            exit;
        }

        // Validasi ukuran gambar maksimal 2MB
        if ($ukuran > 2 * 1024 * 1024) {

            echo "<script>
                    alert('Ukuran gambar maksimal 2 MB!');
                    window.history.back();
                  </script>";
            exit;
        }

        $namaBaru = time() . "_" . mt_rand(1000, 9999) . "." . $extensi;

        if (move_uploaded_file(
            $tmpFile,
            "../assets/images/barang/" . $namaBaru
        )) {

            $gambar = $namaBaru;
        } else {

            echo "<script>
                    alert('Gagal mengupload gambar!');
                    window.history.back();
                  </script>";
            exit;
        }
    }

    $query = "INSERT INTO barang
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
    )";

    $simpan = mysqli_query($koneksi, $query);

    if ($simpan) {

        echo "<script>
                alert('Barang berhasil ditambahkan.');
                window.location='../index.php?page=databarang';
              </script>";
    } else {

        echo "<script>
                alert('Gagal menambahkan barang!');
                window.history.back();
              </script>";
    }
}
