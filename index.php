<?php
require_once "proses/koneksi.php";
require_once "proses/helper.php";

session_start();

// Tampilkan error saat development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek Login
if (!isset($_SESSION['login'])) {
    header("Location: form-login.php");
    exit();
}

// Daftar halaman yang diizinkan
$halaman = [
    // Dashboard
    'home',

    // Barang
    'databarang',
    'tambahbarang',
    'editbarang',

    // Kategori
    'datakategori',
    'tambahkategori',
    'editkategori',

    // Rak
    'datarak',
    'tambahrak',
    'editrak',

    // Transaksi
    'penjualan',
    'keranjang',

    // Laporan
    'laporan'
];

// Halaman default
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Validasi halaman
if (!in_array($page, $halaman)) {
    $page = 'home';
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<?php include "komponen/head.php"; ?>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <img src="./assets/images/logos/favicon.png" alt="Loader" class="lds-ripple img-fluid">
    </div>

    <div id="main-wrapper">

        <!-- Sidebar -->
        <aside class="left-sidebar with-vertical">
            <?php include "komponen/sidebar.php"; ?>
        </aside>

        <!-- Content -->
        <div class="page-wrapper">

            <div class="body-wrapper">

                <!-- Navbar -->
                <?php include "komponen/navbar.php"; ?>

                <!-- Isi Halaman -->
                <?php include "pages/" . $page . ".php"; ?>

            </div>

            <!-- Footer -->
            <?php include "komponen/footer.php"; ?>

        </div>

    </div>

    <!-- Sidebar Overlay -->
    <div class="dark-transparent sidebartoggler"></div>

    <!-- Javascript -->
    <?php include "komponen/script.php"; ?>

</body>

</html>