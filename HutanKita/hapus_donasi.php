<?php
session_start();
include "config.php";

// ================= PROTEKSI LOGIN =================
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id = (int) $_GET['id'];
$id_user = $_SESSION['id_user'];

// ================= DELETE (OWNER ONLY) =================
$stmt = $conn->prepare("
    DELETE FROM donasi 
    WHERE id_donasi = ? AND id_user = ?
");
$stmt->bind_param("ii", $id, $id_user);
$stmt->execute();

$stmt->close();

// balik ke halaman donasi kita
header("Location: donasikita.php");
exit;
