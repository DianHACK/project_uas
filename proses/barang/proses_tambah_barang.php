<?php
include '../koneksi.php';

if (isset($_POST['submit'])) {
    $nama_barang   = htmlspecialchars($_POST['nama_barang']);
    $id_kategori   = $_POST['id_kategori'];
    $harga         = $_POST['harga'];
    $stok          = $_POST['stok'];
    $id_rak        = $_POST['id_rak'];
    $expired_date  = $_POST['expired_date'];

    // Upload Gambar
    $gambar_name = '';
    if ($_FILES['gambar']['name'] != '') {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array(strtolower($ext), $allowed_ext)) {
            echo "<script>alert('Format gambar tidak didukung!'); window.history.back();</script>";
            exit;
        }

        $gambar_name = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], '../gambar/' . $gambar_name);
    }

    // Simpan ke database
    $query = $koneksi->query("INSERT INTO barang 
        (nama_barang, id_kategori, harga, stok, id_rak, expired_date, gambar)
        VALUES (
            '$nama_barang',
            '$id_kategori',
            '$harga',
            '$stok',
            '$id_rak',
            '$expired_date',
            '$gambar_name'
        )");

    if ($query) {
        echo "<script>alert('Data berhasil ditambahkan'); window.location='../../index.php?page=databarang';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data'); window.history.back();</script>";
    }
}
?>
