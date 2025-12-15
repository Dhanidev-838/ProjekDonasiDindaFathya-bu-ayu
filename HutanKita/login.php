<?php
session_start();
include "config.php";

// =======================
// PROSES LOGIN
// =======================
if (isset($_POST['login'])) {

    $email    = $_POST['email'];
    $password = $_POST['password'];

    // ambil user berdasarkan email
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user  = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        // simpan session
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['email']   = $user['email'];

        header("Location: index.php");
        exit;
    } else {
        $error = "Email atau password salah";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | HutanKita</title>

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

    <h2>Login</h2>

    <?php if (isset($error)): ?>
        <div class="msg"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>

    <div class="link">
        <a href="register.php">Belum punya akun? Register</a>
    </div>

</div>
</div>

</body>
</html>
