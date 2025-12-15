<?php
session_start();

// hapus semua session
session_unset();
session_destroy();

// kembali ke home
header("Location: index.php");
exit;
