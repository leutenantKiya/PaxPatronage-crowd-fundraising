<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../public/login.html?error=login ulang");
        exit;
    }
    if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
        if (!isset($_POST['kampanye_id']) || !ctype_digit($_POST['kampanye_id'])) {
            header("Location: ../public/dashboard.php?error=hapus_kampanye_gagal");
            exit;
        }
        $kampanye_id = (int) $_POST['kampanye_id'];
        $_SESSION['curr_id'] = $kampanye_id;
    }else{
        if(!isset($_SESSION['curr_id'])){
            header("Location: ../public/dashboard.php");
            exit;
        }
        $kampanye_id = (int) $_SESSION['curr_id'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kampanye</title>
    <link rel="stylesheet" href="style/dashboard.css">
</head>
<body>
    <?php
    $infoMessage = [
            "update_kampanye_tidak_berubah" => "Minimal Diubah dl mas."
        ][$_GET["info"] ?? ""] ?? "";
    ?>
    <header class="site-header" id="site-header">
        <div class="inner-header" id="inner-header">
            <a href="dashboard.php" class="logo" id="logo-link">
                <div class="logo-icon" id="logo-icon">
                    <span class="material-symbols-outlined">PP</span>
                </div>
                <span class="logo-text" id="logo-text">PaxPatron</span>
            </a>
            <nav id="main-nav">
                <a href="dashboard.php" id="nav-dashboard">Dashboard</a>
                <a href="../services/logout_service.php?logout=true" class="login-btn" id="nav-logout">Logout</a>
            </nav>
        </div>
    </header>
    <main>
        <?php if($infoMessage): ?>
            <div class="alert info-alert"><?php echo htmlspecialchars($infoMessage);?></div>
        <?php endif; ?>
        <div class="form-header">
            <h1>Edit Kampanye</h1>
            <a href="dashboard.php" class="btn-back">&larr; Kembali ke Dashboard</a>
        </div>
        <?php
            require_once __DIR__ . "/../services/db_connection.php";
            $db = new Connection;
            // print_r($db);
            $res = $db->getKampanyeById($kampanye_id);
            // print_r (mysqli_fetch_assoc($res));
            // print_r($_POST);
            // print_r($res);
            // print_r($_POST);
            if(mysqli_num_rows($res) > 0){
                $root_path = "upload/";
                $row = mysqli_fetch_assoc($res);
                // $kampanye_id = $row["id"];
                $target_kampanye = htmlspecialchars($row['target_kampanye']);
                $deskripsi = htmlspecialchars($row["deskripsi"]);
                $rincian = htmlspecialchars($row["rincian"] ?? '');
                $nama_kampanye = htmlspecialchars($row["nama_kampanye"]);
                $jenis_kampanye = htmlspecialchars($row["jenis_kampanye"]);
                $tanggal_dimulai = date('Y-m-d', strtotime($row["tanggal_dimulai"]));
                $tanggal_berakhir = date('Y-m-d', strtotime($row["tanggal_berakhir"]));
                $path_gambar = htmlspecialchars($root_path.$row["path_gambar"]);
                $alamat_jalan = htmlspecialchars($row["alamat_jalan"] ?? '');
                $kota = htmlspecialchars($row["kota"] ?? '');
                $provinsi_db = $row["provinsi"] ?? '';
            }

            // List provinsi (sama dengan tambahKampanye.php) — pre-select yang match dengan DB
            $provinsi_list = ['Aceh','Sumatera Utara','Sumatera Barat','Riau','Jambi','Sumatera Selatan','Bengkulu','Lampung',
                'Kep. Bangka Belitung','Kep. Riau','DKI Jakarta','Jawa Barat','Jawa Tengah','DI Yogyakarta','Jawa Timur','Banten',
                'Bali','Nusa Tenggara Barat','Nusa Tenggara Timur','Kalimantan Barat','Kalimantan Tengah','Kalimantan Selatan',
                'Kalimantan Timur','Kalimantan Utara','Sulawesi Utara','Sulawesi Tengah','Sulawesi Selatan','Sulawesi Tenggara',
                'Gorontalo','Sulawesi Barat','Maluku','Maluku Utara','Papua','Papua Barat','Papua Selatan','Papua Tengah',
                'Papua Pegunungan','Papua Barat Daya'];

            echo '<form action="../services/update_kampanye_service.php" method="post" enctype="multipart/form-data" class="kampanye-form">';
            echo '<input type="hidden" name="kampanye_id" value="'.$kampanye_id.'">';
            echo '<label for="nama_kampanye">Nama Kampanye:</label>';
            echo '<input type="text" id="nama_kampanye" value="'.$nama_kampanye.'" name="nama_kampanye" required>';
            
            echo '<label for="jenis_kampanye">Jenis Kampanye:</label>';
            echo '<input type="text" id="jenis_kampanye" value="'.$jenis_kampanye.'" name="jenis_kampanye" required>';

            echo '<label for="target_dana">Target Dana:</label>';
            echo '<input type="number" id="target_dana" value="'.$target_kampanye.'" name="target_dana" required>';

            echo '<label for="tanggal_dimulai">Tanggal Dimulai:</label>';
            echo '<input type="date" id="tanggal_dimulai" value="'.$tanggal_dimulai.'" name="tanggal_dimulai" required>';

            echo '<label for="tanggal_berakhir">Tanggal Berakhir:</label>';
            echo '<input type="date" id="tanggal_berakhir" value="'.$tanggal_berakhir.'" name="tanggal_berakhir" required>';

            echo '<label for="deskripsi">Deskripsi:</label>';
            echo '<textarea style="resize: none;" rows="4" id="deskripsi" name="deskripsi" required>'.$deskripsi.'</textarea>';

            echo '<label for="rincian">Rincian:</label>';
            echo '<textarea style="resize: none;" rows="6" id="rincian" name="rincian" required>'.$rincian.'</textarea>';

            echo '<label for="alamat_jalan">Alamat Lengkap (Jalan, RT/RW, dll):</label>';
            echo '<input type="text" id="alamat_jalan" name="alamat_jalan" value="'.$alamat_jalan.'" required>';

            echo '<label for="kota">Kota / Kabupaten:</label>';
            echo '<input type="text" id="kota" name="kota" value="'.$kota.'" required>';

            echo '<label for="provinsi">Provinsi:</label>';
            echo '<select id="provinsi" name="provinsi" required>';
            echo '<option value="">-- Pilih Provinsi --</option>';
            foreach ($provinsi_list as $prov) {
                $selected = ($prov === $provinsi_db) ? ' selected' : '';
                echo '<option value="'.htmlspecialchars($prov).'"'.$selected.'>'.htmlspecialchars($prov).'</option>';
            }
            echo '</select>';

            // Ambil rekening kampanye yang sudah ada
            $rek_res = $db->getRekeningByKampanye($kampanye_id);
            $rek_data = mysqli_fetch_assoc($rek_res);
            $nama_bank_db = $rek_data['nama_bank'] ?? '';
            $nomor_rekening_db = htmlspecialchars($rek_data['nomor_rekening'] ?? '');

            $bank_list = ['BCA','BNI','BRI','Bank Mandiri','CIMB Niaga','Bank Danamon','Bank Permata','BSI','Bank Mega','BTPN','Bank Jago','Sea Bank'];
            $bank_labels = ['BCA'=>'BCA','BNI'=>'BNI','BRI'=>'BRI','Bank Mandiri'=>'Bank Mandiri','CIMB Niaga'=>'CIMB Niaga',
                'Bank Danamon'=>'Bank Danamon','Bank Permata'=>'Bank Permata','BSI'=>'BSI (Bank Syariah Indonesia)',
                'Bank Mega'=>'Bank Mega','BTPN'=>'BTPN','Bank Jago'=>'Bank Jago','Sea Bank'=>'Sea Bank'];

            echo '<label for="nama_bank">Nama Bank:</label>';
            echo '<select id="nama_bank" name="nama_bank" required>';
            echo '<option value="">-- Pilih Bank --</option>';
            foreach ($bank_list as $bank) {
                $selected = ($bank === $nama_bank_db) ? ' selected' : '';
                $label = $bank_labels[$bank] ?? $bank;
                echo '<option value="'.htmlspecialchars($bank).'"'.$selected.'>'.htmlspecialchars($label).'</option>';
            }
            echo '</select>';

            echo '<label for="nomor_rekening">Nomor Rekening:</label>';
            echo '<input type="text" id="nomor_rekening" name="nomor_rekening" value="'.$nomor_rekening_db.'" placeholder="Contoh: 1234567890" required>';

            echo '<img src="'.$path_gambar.'?v='.time().'" alt="'.$row["path_gambar"].'" width="300">';
            echo '<label for="foto">Foto Banner:</label>';
            echo '<input type="file" id="foto" name="foto" accept=".jpg, .png, .pdf">';

            echo '<div class="form-actions">
                    <button type="submit" class="btn-tambah"><span class="btn-text">Submit</span></button>
                </div>';
            echo '</form>';
        ?>
    </main>
</body>
</html>