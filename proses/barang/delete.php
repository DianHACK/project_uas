<?php
include '../koneksi.php';
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $koneksi->query("DELETE FROM barang WHERE id = $id");
}
header("location: ../../index.php?page=databarang");
?>