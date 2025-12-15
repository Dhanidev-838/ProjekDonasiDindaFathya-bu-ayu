<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tentang Kita | HutanKita</title>

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
            z-index: 10;
        }

        nav a {
            margin-right: 18px;
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }

        nav a:last-child { margin-right: 0; }

        /* CONTAINER */
        .container {
            padding: 30px 40px;
            max-width: 1100px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        /* HERO IMAGE */
        .hero-img {
            width: 100%;
            height: 320px;
            background: #ddd;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 50px;
        }

        .hero-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* CONTENT */
        .content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .card h3 {
            margin-top: 0;
            margin-bottom: 12px;
        }

        .card p {
            line-height: 1.6;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
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

<!-- CONTENT -->
<div class="container">
    <h2>Tentang HutanKita</h2>

    <!-- IMAGE -->
    <div class="hero-img">
        <img src="HutanKita1.jpg" alt="Tentang HutanKita">
    </div>

    <!-- PENJELASAN -->
    <div class="content">
        <div class="card">
            <h3>Apa itu HutanKita?</h3>
            <p>
                HutanKita adalah website donasi berbasis web yang dibuat untuk publik
                dengan tujuan transparansi dan kepedulian terhadap lingkungan, khususnya
                dalam mendukung kegiatan pelestarian hutan dan alam, website ini sudah
                memiliki izin dari pemerintah langsung.
            </p>
        </div>

        <div class="card">
            <h3>Tujuan Website</h3>
            <p>
                Website ini bertujuan sebagai media pembelajaran untuk semua relawan
                yang ingin berkontrubusi dalam pelestarian hutan. selain itu, website ini
                juga berfungsi sebagai wadah untuk mengumpulkan donasi yang nantinya akan
                disalurkan kepada wilayh yang membutuhkan hutan yang subur.
            </p>
        </div>

        <div class="card">
            <h3>Transparansi & Pengembangan</h3>
            <p>
                Seluruh data donasi yang masuk dapat dilihat pada halaman DonasiKita
                sebagai bentuk transparansi. Website ini masih terus dikembangkan
                untuk meningkatkan fitur, keamanan, dan kenyamanan pengguna.
            </p>
        </div>
    </div>
</div>

</body>
</html>
