<?php

function totalData($koneksi, $table)
{
    $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM $table");
    $data = mysqli_fetch_assoc($query);

    return $data['total'];
}
// Fungsi global untuk mencatat log aktivitas
function catat_log($koneksi, $aktivitas) {
    $username = $_SESSION['username'] ?? 'Administrator';
    // Mencegah SQL Injection sederhana pada string aktivitas
    $aktivitas_aman = mysqli_real_escape_string($koneksi, $aktivitas);
    
    mysqli_query($koneksi, "INSERT INTO log_aktivitas (username, aktivitas) VALUES ('$username', '$aktivitas_aman')");
}