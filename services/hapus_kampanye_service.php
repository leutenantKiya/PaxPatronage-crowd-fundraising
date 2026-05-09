<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../public/login.html?error=login ulang");
        exit;
    }
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        header("Location: ../public/dashboard.php");
        exit;
    }
    if (!isset($_POST['kampanye_id']) || !ctype_digit($_POST['kampanye_id'])) {
        header("Location: ../public/dashboard.php?error=hapus_kampanye_gagal");
        exit;
    }

    require_once 'db_connection.php';
    $db = new Connection;
    $kampanye_id = (int) $_POST['kampanye_id'];
    $kampanye = $db->getKampanye($kampanye_id);
    $res = mysqli_fetch_assoc($kampanye);
    if($res['dana_terkumpul'] != null && $res['dana_terkumpul'] >= 100000){
        header("Location: ../public/dashboard.php?error=hapus_kampanye_ditolak");
        exit;
    }
    if ($db->hapusKampanye($kampanye_id, $_SESSION['user_id'])) {
        header("Location: ../public/dashboard.php?success=hapus_kampanye_berhasil");
        exit;
    }

    header("Location: ../public/dashboard.php?error=hapus_kampanye_ditolak");
    exit;
?>
