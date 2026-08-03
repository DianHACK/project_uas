<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "proses/koneksi.php";
require_once "proses/helper.php";

// ==============================
// CEK LOGIN
// ==============================
if (!isset($_SESSION['login'])) {
    header("Location: form-login.php");
    exit();
}

// ==============================
// AUTO LOGOUT (30 MENIT)
// ==============================
$timeout = 1800;

if (isset($_SESSION['login_time'])) {
    if ((time() - $_SESSION['login_time']) > $timeout) {
        session_unset();
        session_destroy();

        header("Location: form-login.php");
        exit();
    }
    $_SESSION['login_time'] = time();
}

// ==============================
// DAFTAR HALAMAN
// ==============================
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
    'datapenjualan',
    'keranjang',

    // Laporan
    'laporan',

    // Monitor Log (Baru)
    'monitorlog'
];

// ==============================
// PAGE
// ==============================
$page = $_GET['page'] ?? 'home';

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