<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../public/login.html?error=login ulang");
        exit;
    }
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        header("Location: ../public/tambahKampanye.php");
        exit;
    }
    print_r($_FILES);
    if (!isset($_FILES['foto']['name'])) {
        header("Location: ../public/tambahKampanye.php?error=upload_gagal");
        exit;
    }
    require_once 'db_connection.php';
    print_r($_POST);
    $db = new Connection;
    print_r (mysqli_num_rows($db->getKampanye(1)));
?>