<?php
    require_once 'session_check.php';
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../public/login.html?error=login ulang");
        exit;
    }
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        header("Location: ../public/tambahKampanye.php");
        exit;
    }
    if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
        header("Location: ../public/tambahKampanye.php?error=upload_gagal");
        exit;
    }
    $beginDate = new DateTime($_POST['tanggal_dimulai']);
    $endDate = new DateTime($_POST['tanggal_berakhir']);
    $curDate = date("Y-m-d_H-i-s");
    
    // echo $curDate;
    if ($beginDate > $endDate) {
        header("Location: ../public/tambahKampanye.php?error=time_traveler_jir");
        exit;
    }

    // prepare conn
    require_once 'db_connection.php';
    // print_r($_POST);
    $db = new Connection;
    
    // get foto
    $filename = $_FILES['foto']['name'];
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $full_file_name = "kampanye_".$_SESSION['user_id']."_".$curDate.".".$extension;
    $targetDir = __DIR__ . "/../public/upload/img-kampanye/";
    $targetFilePath = $targetDir . $full_file_name;
    $path_gambar = "img-kampanye/" . $full_file_name;

    // https://zolin.digital/how-to/how-to-check-if-a-folder-exists-in-php-wordpress/ -> check if folder/path exist
    if(!is_dir($targetDir) && !mkdir($targetDir, 0755, true)){
        mkdir($targetDir, 0755, true); //recursive -> folder bisa dibuat meskipun folder induknya belum ada
    }

    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $targetFilePath)) {
        header("Location: ../public/tambahKampanye.php?error=upload_gagal");
        exit;
    }

    // Validasi 3 field address baru wajib diisi
    foreach (['alamat_jalan', 'kota', 'provinsi'] as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            header("Location: ../public/tambahKampanye.php?error=tambah_kampanye_gagal");
            exit;
        }
    }

    if (!isset($_POST['rincian']) || trim($_POST['rincian']) === '') {
        header("Location: ../public/tambahKampanye.php?error=tambah_kampanye_gagal");
        exit;
    }

    // Validasi rekening bank
    foreach (['nama_bank', 'nomor_rekening'] as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            header("Location: ../public/tambahKampanye.php?error=rekening_wajib_diisi");
            exit;
        }
    }

    if($db->tambahKampanye(
        $_POST['nama_kampanye'], 
        $_POST['jenis_kampanye'], 
        $_POST['target_dana'], 
        $_POST['tanggal_dimulai'], 
        $_POST['tanggal_berakhir'], 
        $_POST['deskripsi'], 
        $path_gambar, 
        $_SESSION['user_id'],
        trim($_POST['alamat_jalan']),
        trim($_POST['kota']),
        trim($_POST['provinsi']),
        trim($_POST['rincian'])
    )){
        // Simpan rekening kampanye
        $conn = $db->getConnection();
        $new_kampanye_id = mysqli_insert_id($conn);
        $db->tambahRekening(
            $new_kampanye_id,
            trim($_POST['nama_bank']),
            trim($_POST['nomor_rekening'])
        );

        header("Location: ../public/dashboard.php?success=tambah_kampanye_berhasil");
        exit;
    } else {
        header("Location: ../public/tambahKampanye.php?error=tambah_kampanye_gagal");
        exit;
    }
    
    // format foto ->kampanye_user id_curDate
?>