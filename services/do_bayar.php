<?php
    // Post -> Redirect to donation form -> GET success                    

    session_start();
    // print_r($_POST);
    // print_r($_SESSION);

    if(!isset($_SESSION['user_id'])){
        header("Location: /login.html?error=login_dulu");
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        header("Location: ../public/home.html?error=metode_salah&message=kok_lu_bisa_get_jir!");
        exit;
    }

    if(!isset($_POST['kampanye_id'])){
        header("Location: ../public/home.html?error=data_salah");
        exit;
    }

    $kampanye_id = (int) $_POST['kampanye_id'];

    // Validasi amount — hapus titik pemisah ribuan sebelum convert ke angka
    $raw_amount = str_replace('.', '', $_POST['amount'] ?? '0');
    $raw_amount = str_replace(',', '.', $raw_amount); // jaga-jaga desimal
    $amount = (double) $raw_amount;

    if($amount < 10_000){
        header("Location: ../public/donation-form.html?info=donasi_terlalu_kecil&kampanye_id=$kampanye_id");
        exit;
    }

    // Validasi file bukti transfer
    if (!isset($_FILES['bukti_transfer']) || $_FILES['bukti_transfer']['error'] !== UPLOAD_ERR_OK) {
        header("Location: ../public/donation-form.html?error=upload_gagal&kampanye_id=$kampanye_id");
        exit;
    }

    // --- Upload bukti transfer (format sama seperti tambah_kampanye_service) ---
    $curDate = date("Y-m-d_H-i-s");
    $filename = $_FILES['bukti_transfer']['name'];
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $full_file_name = "bukti_" . $_SESSION['user_id'] . "_" . $kampanye_id . "_" . $curDate . "." . $extension;
    $targetDir = __DIR__ . "/../public/upload/bukti/";
    $targetFilePath = $targetDir . $full_file_name;
    $path_bukti = "bukti/" . $full_file_name;

    // Buat folder jika belum ada
    if(!is_dir($targetDir)){
        mkdir($targetDir, 0755, true);
    }

    if (!move_uploaded_file($_FILES['bukti_transfer']['tmp_name'], $targetFilePath)) {
        header("Location: ../public/donation-form.html?error=upload_gagal&kampanye_id=$kampanye_id");
        exit;
    }

    // --- Simpan ke database ---
    require_once 'db_connection.php';
    $db = new Connection;

    $user_id = $_SESSION['user_id'];
    $name_hidden = isset($_POST['sembunyi']) ? 1 : 0;
    $metode_bayar = $_POST['payment-method'] ?? 'bank';
    $pesan = $_POST['pesan'] ?? '';

    $result = $db->tambahDonasi(
        $kampanye_id,
        $user_id,
        $name_hidden,
        $amount,
        $metode_bayar,
        $pesan,
        $path_bukti
    );

    if($result > 0){
        // PRG: Redirect ke donation-form dengan success
        header("Location: ../public/donation-form.html?kampanye_id=$kampanye_id&success=donasi_berhasil&amount=$amount");
        exit;
    } else {
        header("Location: ../public/donation-form.html?error=donasi_gagal&kampanye_id=$kampanye_id");
        exit;
    }
?>