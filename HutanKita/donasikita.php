<?php
session_start();
include "config.php";

/* ================= AMBIL DATA DONASI ================= */
$query = mysqli_query($conn, "
    SELECT id_donasi, id_user, nama_donatur, nominal,
           metode_pembayaran, pesan, created_at
    FROM donasi
    ORDER BY created_at DESC
");

/* ================= TOTAL DONASI ================= */
$total = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT SUM(nominal) AS total FROM donasi")
)['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DonasiKita | HutanKita</title>

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 18px 30px;
            background: rgba(242,242,242,0.95);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }
        nav a {
            margin-right: 18px;
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }
        .container {
            padding: 120px 30px 40px;
            max-width: 1200px;
            margin: auto;
        }
        h2 { text-align: center; }
        .total {
            text-align: center;
            font-weight: bold;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        th { background: #f6a5c0; }
        button {
            padding: 6px 12px;
            background: #f6a5c0;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }
        .danger { background: #e57373; }

        /* POPUP */
        .popup {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            justify-content: center;
            align-items: center;
            z-index: 99;
        }
        .popup-content {
            background: #fff;
            padding: 25px;
            width: 360px;
            border-radius: 12px;
            text-align: center;
        }
        img { max-width: 100%; }
    </style>

    <script>
        function showPesan(pesan) {
            document.getElementById("isiPesan").innerText = pesan || "Tidak ada pesan";
            document.getElementById("popupPesan").style.display = "flex";
        }
        function closePesan() {
            document.getElementById("popupPesan").style.display = "none";
        }
        function showQR(nama, qr) {
            document.getElementById("judulQR").innerText = "QR " + nama;
            document.getElementById("imgQR").src = qr;
            document.getElementById("popupQR").style.display = "flex";
        }
        function closeQR() {
            document.getElementById("popupQR").style.display = "none";
        }
    </script>
</head>
<body>

<nav>
    <strong>HutanKita</strong>
    <div>
        <a href="index.php">Home</a>
        <a href="donasi.php">Donasi</a>
        <a href="donasikita.php">DonasiKita</a>
        <a href="about.php">About Us</a>
        <?php if (isset($_SESSION['id_user'])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
</nav>

<div class="container">
    <h2>DonasiKita</h2>

    <div class="total">
        Total Donasi: Rp <?= number_format($total ?? 0, 0, ',', '.') ?>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Donatur</th>
            <th>Nominal</th>
            <th>Metode</th>
            <th>Pesan</th>
            <th>Aksi</th>
        </tr>

        <?php $no = 1; while ($d = mysqli_fetch_assoc($query)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($d['nama_donatur']) ?></td>
            <td>Rp <?= number_format($d['nominal'], 0, ',', '.') ?></td>

            <td>
                <?php
                    $qrPath = "qr/" . $d['metode_pembayaran'] . ".png";
                    if (file_exists($qrPath)):
                ?>
                    <button onclick="showQR(
                        '<?= htmlspecialchars($d['metode_pembayaran']) ?>',
                        '<?= $qrPath ?>'
                    )">
                        <?= htmlspecialchars($d['metode_pembayaran']) ?>
                    </button>
                <?php else: ?>
                    <?= htmlspecialchars($d['metode_pembayaran']) ?>
                <?php endif; ?>
            </td>

            <td>
                <button onclick="showPesan('<?= htmlspecialchars($d['pesan']) ?>')">
                    Lihat
                </button>
            </td>

            <td>
                <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == $d['id_user']): ?>
                    <a href="edit_donasi.php?id=<?= $d['id_donasi'] ?>">
                        <button>Edit</button>
                    </a>
                    <a href="hapus_donasi.php?id=<?= $d['id_donasi'] ?>"
                       onclick="return confirm('Yakin hapus donasi ini?')">
                        <button class="danger">Hapus</button>
                    </a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- POPUP PESAN -->
<div class="popup" id="popupPesan">
    <div class="popup-content">
        <h3>Pesan Donatur</h3>
        <p id="isiPesan"></p>
        <button onclick="closePesan()">Tutup</button>
    </div>
</div>

<!-- POPUP QR -->
<div class="popup" id="popupQR">
    <div class="popup-content">
        <h3 id="judulQR"></h3>
        <img id="imgQR" alt="QR Code">
        <br><br>
        <button onclick="closeQR()">Tutup</button>
    </div>
</div>

</body>
</html>
