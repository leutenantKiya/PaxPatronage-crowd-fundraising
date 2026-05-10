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
        header("Location: ../public/dashboard.php?error=update_kampanye_gagal");
        exit;
    }

    $requiredFields = ['nama_kampanye', 'jenis_kampanye', 'target_dana', 'tanggal_dimulai', 'tanggal_berakhir', 'deskripsi', 'alamat_jalan', 'kota', 'provinsi', 'nama_bank', 'nomor_rekening'];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            header("Location: ../public/dashboard.php?error=update_kampanye_gagal");
            exit;
        }
    }

    $kampanye_id = (int) $_POST['kampanye_id'];
    $nama_kampanye = trim($_POST['nama_kampanye']);
    $jenis_kampanye = trim($_POST['jenis_kampanye']);
    $target_dana = trim($_POST['target_dana']);
    $tanggal_dimulai = trim($_POST['tanggal_dimulai']);
    $tanggal_berakhir = trim($_POST['tanggal_berakhir']);
    $deskripsi = trim($_POST['deskripsi']);
    $alamat_jalan = trim($_POST['alamat_jalan']);
    $kota = trim($_POST['kota']);
    $provinsi = trim($_POST['provinsi']);
    $nama_bank = trim($_POST['nama_bank']);
    $nomor_rekening = trim($_POST['nomor_rekening']);

    if (!is_numeric($target_dana)) {
        header("Location: ../public/dashboard.php?error=update_kampanye_gagal");
        exit;
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_dimulai) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_berakhir)) {
        header("Location: ../public/dashboard.php?error=tanggal_tidak_valid");
        exit;
    }

    $beginDate = new DateTime($tanggal_dimulai);
    $endDate = new DateTime($tanggal_berakhir);
    if ($beginDate > $endDate) {
        header("Location: ../public/dashboard.php?error=tanggal_tidak_valid");
        exit;
    }

    require_once 'db_connection.php';
    $db = new Connection;
    $result = $db->getKampanyeByIdAndUser($kampanye_id, $_SESSION['user_id']);
    if (mysqli_num_rows($result) === 0) {
        header("Location: ../public/dashboard.php?error=update_kampanye_gagal");
        exit;
    }

    $kampanye = mysqli_fetch_assoc($result);
    $fotoDiubah = isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE;
    $targetSama = number_format((float) $target_dana, 2, '.', '') === number_format((float) $kampanye['target_kampanye'], 2, '.', '');
    $tanggalMulaiSama = $tanggal_dimulai === date('Y-m-d', strtotime($kampanye['tanggal_dimulai']));
    $tanggalBerakhirSama = $tanggal_berakhir === date('Y-m-d', strtotime($kampanye['tanggal_berakhir']));

    $path_gambar = $kampanye['path_gambar'];
    if ($fotoDiubah) {
        if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            header("Location: ../public/dashboard.php?error=upload_gagal");
            exit;
        }

        $filename = $_FILES['foto']['name'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
        if (!in_array($extension, $allowedExtensions, true)) {
            header("Location: ../public/dashboard.php?error=upload_gagal");
            exit;
        }

        $curDate = date("Y-m-d_H-i-s");
        $full_file_name = "kampanye_".$_SESSION['user_id']."_".$curDate.".".$extension;
        $targetDir = __DIR__ . "/../public/upload/img-kampanye/";
        $targetFilePath = $targetDir . $full_file_name;
        $path_gambar = "img-kampanye/" . $full_file_name;

        if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true)) {
            header("Location: ../public/dashboard.php?error=update_ga_berubah");
            exit;
        }

        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $targetFilePath)) {
            header("Location: ../public/dashboard.php?error=update_ga_berubah");
            exit;
        }
    }

    $affectedRows = $db->updateKampanye(
        $kampanye_id,
        $nama_kampanye,
        $jenis_kampanye,
        $target_dana,
        $tanggal_dimulai,
        $tanggal_berakhir,
        $deskripsi,
        $path_gambar,
        $_SESSION['user_id'],
        $alamat_jalan,
        $kota,
        $provinsi
    );

    // Update rekening kampanye (selalu update, bahkan jika kampanye data sama)
    $db->updateRekening($kampanye_id, $nama_bank, $nomor_rekening);

    if ($affectedRows > 0) {
        header("Location: ../public/dashboard.php?success=update_kampanye_berhasil");
        unset($_SESSION['curr_id']);
        exit;
    }

    // Meskipun kampanye tidak berubah, rekening mungkin berubah
    // Cek apakah rekening yang baru saja di-update memang berubah
    header("Location: ../public/dashboard.php?success=update_kampanye_berhasil");
    unset($_SESSION['curr_id']);
    exit;
?>
