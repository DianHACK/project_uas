<?php
// Mulai session
session_start();

// Hapus semua variabel session
$_SESSION = array();

// Hancurkan session
session_destroy();

// Arahkan kembali ke halaman form login
header("Location: form-login.php");
exit();
?>