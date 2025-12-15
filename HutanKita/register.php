<?php
session_start();
include "config.php";

// =======================
// PROSES REGISTER
// =======================
if (isset($_POST['register'])) {

    $nama     = htmlspecialchars($_POST['nama']);
    $email    = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    // validasi password
    if ($password !== $confirm) {
        $error = "Password tidak sama";
    } else {

        // cek email
        $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Email sudah terdaftar";
        } else {

            // hash password
            $hash = password_hash($password, PASSWORD_DEFAULT);

            mysqli_query($conn, "
                INSERT INTO users (nama, email, password)
                VALUES ('$nama', '$email', '$hash')
            ");

            $success = "Register berhasil. Silakan login.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register | HutanKita</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f2f2f2; /* abu */
        }

        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #fff;
            padding: 30px;
            width: 360px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #000;
        }

        input {
            width: 94%;
            padding: 10px;
            margin-top: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            color: #000;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background: #f6a5c0; /* pink soft */
            border: none;
            border-radius: 8px;
            font-weight: bold;
            color: #000;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        .msg {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            background: #f6a5c0;
            color: #000;
            text-align: center;
        }

        .link {
            text-align: center;
            margin-top: 15px;
        }

        .link a {
            color: #000;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">
<div class="card">

    <h2>Register</h2>

    <?php if (isset($error)): ?>
        <div class="msg"><?= $error ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="msg"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm" placeholder="Konfirmasi Password" required>

        <button type="submit" name="register">Register</button>
    </form>

    <div class="link">
        <a href="login.php">Sudah punya akun? Login</a>
    </div>

</div>
</div>

</body>
</html>
