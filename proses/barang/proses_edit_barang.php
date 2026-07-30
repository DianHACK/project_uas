<?php
include '../koneksi.php';

if (isset($_POST['submit'])) {
    $id            = $_POST['id'];
    $nama_barang   = htmlspecialchars($_POST['nama_barang']);
    $id_kategori   = $_POST['id_kategori'];
    $harga         = $_POST['harga'];
    $stok          = $_POST['stok'];
    $id_rak        = $_POST['id_rak'];
    $expired_date  = $_POST['expired_date'];

    // Ambil data lama untuk ambil nama gambar
    $data_lama = $koneksi->query("SELECT gambar FROM barang WHERE id = '$id'");
    $row = $data_lama->fetch_assoc();
    $gambar_lama = $row['gambar'];

    // Cek apakah ada gambar baru
    if ($_FILES['gambar']['name'] != '') {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array(strtolower($ext), $allowed_ext)) {
            echo "<script>alert('Format gambar tidak didukung!'); window.history.back();</script>";
            exit;
        }

        $gambar_baru = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], '../gambar/' . $gambar_baru);

        // Hapus gambar lama jika ada
        if (!empty($gambar_lama) && file_exists("../gambar/$gambar_lama")) {
            unlink("../gambar/$gambar_lama");
        }

        $gambar_final = $gambar_baru;
    } else {
        $gambar_final = $gambar_lama;
    }

    // Update data
    $query = $koneksi->query("UPDATE barang SET
        nama_barang = '$nama_barang',
        id_kategori = '$id_kategori',
        harga       = '$harga',
        stok        = '$stok',
        id_rak      = '$id_rak',
        expired_date = '$expired_date',
        gambar      = '$gambar_final'
        WHERE id = '$id'
    ");

    if ($query) {
        echo "<script>alert('Data berhasil diperbarui'); window.location='../../index.php?page=databarang';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data'); window.history.back();</script>";
    }
}
?>
