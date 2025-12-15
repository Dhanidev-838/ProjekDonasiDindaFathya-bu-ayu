<?php
session_start();
include "config.php";

/* ================= PROTEKSI LOGIN ================= */
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

/* ================= AMBIL METODE PEMBAYARAN ================= */
$metode_query = mysqli_query(
    $conn,
    "SELECT nama_metode FROM metode_pembayaran ORDER BY nama_metode ASC"
);

/* ================= PROSES DONASI ================= */
if (isset($_POST['donasi'])) {

    $id_user = $_SESSION['id_user'];
    $nama    = trim($_POST['nama']);
    $email   = trim($_POST['email']);
    $nominal = (int) $_POST['nominal'];
    $metode  = $_POST['metode'];
    $pesan   = trim($_POST['pesan']);

    /* validasi */
    $cek_metode = mysqli_query(
        $conn,
        "SELECT 1 FROM metode_pembayaran WHERE nama_metode='$metode'"
    );

    if ($nominal < 5000) {
        $error = "Minimal donasi Rp 5.000";
    }
    elseif (mysqli_num_rows($cek_metode) == 0) {
        $error = "Metode pembayaran tidak valid";
    }
    else {

        $stmt = $conn->prepare("
            INSERT INTO donasi
            (id_user, nama_donatur, email_donatur, nominal, metode_pembayaran, pesan)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ississ",
            $id_user,
            $nama,
            $email,
            $nominal,
            $metode,
            $pesan
        );

        if ($stmt->execute()) {
            $success = "Donasi berhasil dicatat. Terima kasih 🙏";
        } else {
            $error = "Gagal menyimpan donasi.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Donasi | HutanKita</title>

<style>
*{box-sizing:border-box}
body{
    margin:0;
    font-family:Arial,sans-serif;
    background:#f2f2f2;
}
nav{
    position:fixed;
    top:0;
    width:100%;
    padding:18px 30px;
    background:#f2f2f2;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
nav a{
    margin-right:18px;
    text-decoration:none;
    font-weight:bold;
    color:#000;
}
.container{
    padding-top:120px;
    display:flex;
    justify-content:center;
}
.card{
    background:#fff;
    padding:30px;
    width:420px;
    border-radius:14px;
    box-shadow:0 10px 25px rgba(0,0,0,.1);
}
input,select,textarea,button{
    width:100%;
    padding:10px;
    margin-top:12px;
    border-radius:8px;
}
button{
    background:#f6a5c0;
    border:none;
    font-weight:bold;
    cursor:pointer;
}
.msg{
    padding:10px;
    margin-bottom:15px;
    border-radius:8px;
    text-align:center;
    background:#f6a5c0;
}
</style>
</head>

<body>

<nav>
<strong>HutanKita</strong>
<div>
    <a href="index.php">Home</a>
    <a href="donasi.php">Donasi</a>
    <a href="donasikita.php">DonasiKita</a>
    <a href="about.php">About Us</a>
    <a href="logout.php">Logout</a>
</div>
</nav>

<div class="container">
<div class="card">

<h2>Form Donasi</h2>

<?php if (isset($error)): ?>
<div class="msg"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (isset($success)): ?>
<div class="msg"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="POST">
    <input type="text" name="nama" placeholder="Nama Donatur" required>
    <input type="email" name="email" placeholder="Email Donatur" required>
    <input type="number" name="nominal" placeholder="Nominal (min Rp 5.000)" required>

    <select name="metode" required>
        <option value="">-- Pilih Metode Pembayaran --</option>
        <?php while ($m = mysqli_fetch_assoc($metode_query)): ?>
            <option value="<?= htmlspecialchars($m['nama_metode']) ?>">
                <?= htmlspecialchars($m['nama_metode']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <textarea name="pesan" placeholder="Pesan (opsional)"></textarea>

    <button type="submit" name="donasi">Donasi Sekarang</button>
</form>

</div>
</div>

</body>
</html>
