<?php
session_start();
include "config.php";

// ================= PROTEKSI LOGIN =================
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id = (int) ($_GET['id'] ?? 0);
$id_user = $_SESSION['id_user'];

// ================= AMBIL DATA DONASI (OWNER ONLY) =================
$stmt = $conn->prepare("
    SELECT nama_donatur, email_donatur, nominal, metode_pembayaran, pesan
    FROM donasi
    WHERE id_donasi = ? AND id_user = ?
");
$stmt->bind_param("ii", $id, $id_user);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    header("Location: donasikita.php");
    exit;
}

// ================= UPDATE DATA =================
if (isset($_POST['update'])) {

    $nominal = (int) $_POST['nominal'];
    $metode  = $_POST['metode'];
    $pesan   = trim($_POST['pesan']);

    if ($nominal < 5000) {
        $error = "Minimal donasi Rp 5.000";
    } else {
        $stmt = $conn->prepare("
            UPDATE donasi 
            SET nominal = ?, metode_pembayaran = ?, pesan = ?
            WHERE id_donasi = ? AND id_user = ?
        ");
        $stmt->bind_param("issii", $nominal, $metode, $pesan, $id, $id_user);
        $stmt->execute();

        header("Location: donasikita.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Donasi | HutanKita</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            color: #000;
        }

        /* NAVBAR */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 18px 30px;
            background: rgba(242,242,242,0.95);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            margin-right: 18px;
            font-weight: bold;
            text-decoration: none;
            color: #000;
        }

        nav a:last-child { margin-right: 0; }

        /* CONTAINER */
        .container {
            min-height: 80vh;
            padding-top: 120px;
            display: flex;
            justify-content: center;
        }

        /* CARD */
        .card {
            background: #fff;
            padding: 30px;
            width: 420px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #f6a5c0;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        .msg {
            background: #f6a5c0;
            padding: 10px;
            margin-bottom: 15px;
            text-align: center;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <strong>HutanKita</strong>
    <div>
        <a href="index.php">Home</a>
        <a href="donasikita.php">DonasiKita</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<!-- CONTENT -->
<div class="container">
    <div class="card">

        <h2>Edit Donasi</h2>

        <?php if (isset($error)): ?>
            <div class="msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" value="<?= htmlspecialchars($data['nama_donatur']) ?>" disabled>
            <input type="email" value="<?= htmlspecialchars($data['email_donatur']) ?>" disabled>

            <input type="number" name="nominal" value="<?= $data['nominal'] ?>" required>

            <select name="metode" required>
                <option value="ShopeePay" <?= $data['metode_pembayaran']=='ShopeePay'?'selected':'' ?>>ShopeePay</option>
                <option value="GoPay" <?= $data['metode_pembayaran']=='GoPay'?'selected':'' ?>>GoPay</option>
                <option value="OVO" <?= $data['metode_pembayaran']=='OVO'?'selected':'' ?>>OVO</option>
                <option value="DANA" <?= $data['metode_pembayaran']=='DANA'?'selected':'' ?>>DANA</option>
            </select>

            <textarea name="pesan" placeholder="Pesan / komentar"><?= htmlspecialchars($data['pesan']) ?></textarea>

            <button type="submit" name="update">Update Donasi</button>
        </form>

    </div>
</div>

</body>
</html>
