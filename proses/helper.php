<?php

function totalData($koneksi, $table)
{
    $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM $table");
    $data = mysqli_fetch_assoc($query);

    return $data['total'];
}