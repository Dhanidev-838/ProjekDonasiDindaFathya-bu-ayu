<?php
// =========================
// CONFIG DATABASE HUTANKITA
// =========================

$host = "localhost";
$user = "root";
$pass = "";
$db   = "hutankita";

$conn = mysqli_connect($host, $user, $pass, $db);

// cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// set charset (biar aman utf-8)
mysqli_set_charset($conn, "utf8");
