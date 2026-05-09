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
    if (!isset($_POST['id_donasi']) || !ctype_digit($_POST['id_donasi'])
        || !isset($_POST['action']) || !in_array($_POST['action'], ['accept', 'reject'], true)) {
        header("Location: ../public/detailKampanye.php?error=verifikasi_gagal");
        exit;
    }

    require_once 'db_connection.php';
    $db = new Connection;
    $id_donasi  = (int) $_POST['id_donasi'];
    $owner_id   = (int) $_SESSION['user_id'];
    $action     = $_POST['action'];

    if ($action === 'accept') {
        if ($db->verifikasiDonasi($id_donasi, $owner_id)) {
            header("Location: ../public/detailKampanye.php?success=verifikasi_berhasil");
            exit;
        }
        header("Location: ../public/detailKampanye.php?error=verifikasi_gagal");
        exit;
    }

    // action === 'reject'
    if ($db->tolakDonasi($id_donasi, $owner_id)) {
        header("Location: ../public/detailKampanye.php?info=reject_berhasil");
        exit;
    }
    header("Location: ../public/detailKampanye.php?error=verifikasi_gagal");
    exit;
?>
