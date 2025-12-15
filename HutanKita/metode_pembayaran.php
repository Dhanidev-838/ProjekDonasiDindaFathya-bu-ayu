<?php
session_start();
include "config.php";

// PROTEKSI LOGIN
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// TAMBAH METODE PEMBAYARAN
if (isset($_POST['tambah'])) {
    $nama = trim($_POST['nama_metode']);

    if (!empty($_FILES['qr']['name'])) {
        $ext = pathinfo($_FILES['qr']['name'], PATHINFO_EXTENSION);
        $namaFile = time() . "_" . strtolower(str_replace(' ', '_', $nama)) . "." . $ext;

        move_uploaded_file(
            $_FILES['qr']['tmp_name'],
            "qr/" . $namaFile
        );

        mysqli_query($conn, "
            INSERT INTO metode_pembayaran (nama_metode, qr_code)
            VALUES ('$nama', '$namaFile')
        ");
    }
}

// HAPUS METODE
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];

    // ambil nama file buat hapus gambar
    $q = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT qr_code FROM metode_pembayaran WHERE id_metode=$id")
    );

    if ($q && file_exists("qr/" . $q['qr_code'])) {
        unlink("qr/" . $q['qr_code']);
    }

    mysqli_query($conn, "DELETE FROM metode_pembayaran WHERE id_metode=$id");
}

// AMBIL DATA
$data = mysqli_query($conn, "SELECT * FROM metode_pembayaran ORDER BY id_metode DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Metode Pembayaran</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; padding: 30px; }
        form, table { background: #fff; padding: 20px; border-radius: 12px; }
        input, button { padding: 10px; margin-top: 10px; width: 100%; }
        button { background: #f6a5c0; border: none; font-weight: bold; cursor: pointer; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; }
        img { border: 1px solid #ccc; padding: 5px; }
    </style>
</head>
<body>

<h2>Metode Pembayaran</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="nama_metode" placeholder="Nama Metode (ShopeePay, Dana, dll)" required>
    <input type="file" name="qr" accept="image/*" required>
    <button name="tambah">Tambah Metode</button>
</form>

<table>
    <tr>
        <th>Nama Metode</th>
        <th>QR Code</th>
        <th>Aksi</th>
    </tr>

    <?php while ($m = mysqli_fetch_assoc($data)): ?>
    <tr>
        <td><?= htmlspecialchars($m['nama_metode']) ?></td>
        <td>
            <img src="qr/<?= htmlspecialchars($m['qr_code']) ?>" width="120">
        </td>
        <td>
            <a href="?hapus=<?= $m['id_metode'] ?>"
               onclick="return confirm('Hapus metode ini?')">
                Hapus
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
