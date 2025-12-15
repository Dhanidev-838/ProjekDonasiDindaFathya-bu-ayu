<?php
session_start();
include "config.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>HutanKita</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #000;
        }

        /* ================= NAVBAR ================= */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 18px 30px;
            background: rgba(242,242,242,0.9);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        nav .menu a {
            margin-right: 18px; /* lebih rapet */
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }

        nav .menu a:last-child {
            margin-right: 0;
        }

        /* ================= VIDEO ================= */
        video {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            filter: none; /* PASTI TANPA BLUR */
        }

        /* ================= HERO ================= */
        .hero {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        .hero h1 {
            font-size: 36px;
            max-width: 720px;
            line-height: 1.4;
        }

        .hero button {
            margin-top: 28px;
            padding: 12px 34px;
            background: #f6a5c0;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            color: #000;
        }

        .hero button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<!-- ================= NAVBAR ================= -->
<nav>
    <div class="logo">
        <strong>HutanKita</strong>
    </div>

    <div class="menu">
        <a href="index.php">Home</a>
        <a href="donasi.php">Donasi</a>
        <a href="donasikita.php">DonasiKita</a>
        <a href="about.php">About Us</a>

        <?php if (isset($_SESSION['id_user'])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>

<!-- ================= VIDEO ================= -->
<video autoplay muted loop playsinline>
    <source src="Hutankita.mp4" type="video/mp4">
</video>

<!-- ================= HERO ================= -->
<div class="hero">
    <h1>“Tumbuhkan hal kecil hingga membuat langkah yang besar”</h1>

    <?php if (isset($_SESSION['id_user'])): ?>
        <a href="donasi.php">
            <button>Donasi Sekarang</button>
        </a>
    <?php else: ?>
        <a href="login.php">
            <button>Donasi Sekarang</button>
        </a>
    <?php endif; ?>
</div>

</body>
</html>
