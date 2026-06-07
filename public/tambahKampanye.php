<?php
    require_once __DIR__ . "/../services/session_check.php";
    if(!isset($_SESSION['user_id'])){
        header("Location: login.html?error=login ulang");
        exit;
    }
    $user_id = $_SESSION['user_id'];
    require_once __DIR__ . "/../services/db_connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kampanye</title>
    <link rel="stylesheet" href="style/dashboard.css">
</head>
<body>
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
        <div class="form-header">
            <h1>Tambah Kampanye</h1>
            <a href="dashboard.php" class="btn-back">&larr; Kembali ke Dashboard</a>
        </div>
        <form action="../services/tambah_kampanye_service.php" method="post" enctype="multipart/form-data" class="kampanye-form">
            <label for="nama_kampanye">Nama Kampanye:</label>
            <input type="text" id="nama_kampanye" name="nama_kampanye" required>

            <label for="jenis_kampanye">Jenis Kampanye:</label>
            <!-- <input type="text" id="jenis_kampanye" name="jenis_kampanye" required> -->
            <select id="jenis_kampanye" name="jenis_kampanye" required>
                <option value="Pendidikan">Pendidikan</option>
                <option value="Kesehatan">Kesehatan</option>
                <option value="Bencana Alam">Bencana Alam</option>
                <option value="Lingkungan">Lingkungan</option>
                <option value="Kemanusiaan">Kemanusiaan</option>
                <option value="Infrastruktur">Infrastruktur</option>
                <option value="Sosial">Sosial</option>
                <option value="Hewan">Hewan</option>
            </select>

            <label for="target_dana">Target Dana:</label>
            <input type="number" id="target_dana" name="target_dana" required>

            <label for="tanggal_dimulai">Tanggal Dimulai:</label>
            <input type="date" id="tanggal_dimulai" name="tanggal_dimulai" required>

            <label for="tanggal_berakhir">Tanggal Berakhir:</label>
            <input type="date" id="tanggal_berakhir" name="tanggal_berakhir" required>

            <label for="deskripsi">Deskripsi:</label>
            <textarea style="resize: none;" rows="4" id="deskripsi" name="deskripsi" required></textarea>

            <label for="rincian">Rincian:</label>
            <textarea style="resize: none;" placeholder="Pisahin pakai Enter" rows="6" id="rincian" name="rincian" required></textarea>

            <label for="alamat_jalan">Alamat Lengkap (Jalan, RT/RW, dll):</label>
            <input type="text" id="alamat_jalan" name="alamat_jalan" placeholder="Contoh: Jl. Dr. Wahidin Sudirohusodo No. 5-25" required>

            <!-- <select id="filter-kota" class="filter-select" disabled>
                <option value="">-- Pilih Kota --</option>
            </select> -->
            
            <label for="filter-provinsi">Provinsi:</label>
            <select id="filter-provinsi" name="filter" class="filter-select" required onchange="updateCities()">
                <option value="">-- Pilih Provinsi --</option>
                <option value="aceh">Aceh</option>
                <option value="sumatera-utara">Sumatera Utara</option>
                <option value="sumatera-barat">Sumatera Barat</option>
                <option value="riau">Riau</option>
                <option value="jambi">Jambi</option>
                <option value="sumatera-selatan">Sumatera Selatan</option>
                <option value="bengkulu">Bengkulu</option>
                <option value="lampung">Lampung</option>
                <option value="kep-bangka-belitung">Kep. Bangka Belitung</option>
                <option value="kep-riau">Kep. Riau</option>
                <option value="dki-jakarta">DKI Jakarta</option>
                <option value="jawa-barat">Jawa Barat</option>
                <option value="jawa-tengah">Jawa Tengah</option>
                <option value="di-yogyakarta">DI Yogyakarta</option>
                <option value="jawa-timur">Jawa Timur</option>
                <option value="banten">Banten</option>
                <option value="bali">Bali</option>
                <option value="nusa-tenggara-barat">Nusa Tenggara Barat</option>
                <option value="nusa-tenggara-timur">Nusa Tenggara Timur</option>
                <option value="kalimantan-barat">Kalimantan Barat</option>
                <option value="kalimantan-tengah">Kalimantan Tengah</option>
                <option value="kalimantan-selatan">Kalimantan Selatan</option>
                <option value="kalimantan-timur">Kalimantan Timur</option>
                <option value="kalimantan-utara">Kalimantan Utara</option>
                <option value="sulawesi-utara">Sulawesi Utara</option>
                <option value="sulawesi-tengah">Sulawesi Tengah</option>
                <option value="sulawesi-selatan">Sulawesi Selatan</option>
                <option value="sulawesi-tenggara">Sulawesi Tenggara</option>
                <option value="gorontalo">Gorontalo</option>
                <option value="sulawesi-barat">Sulawesi Barat</option>
                <option value="maluku">Maluku</option>
                <option value="maluku-utara">Maluku Utara</option>
                <option value="papua">Papua</option>
                <option value="papua-barat">Papua Barat</option>
                <option value="papua-selatan">Papua Selatan</option>
                <option value="papua-tengah">Papua Tengah</option>
                <option value="papua-pegunungan">Papua Pegunungan</option>
                <option value="papua-barat-daya">Papua Barat Daya</option>
            </select>
            <label for="filter-kota">Kota / Kabupaten:</label>
            <select id="filter-kota" name="kota" class="filter-select" disabled required>
                <option value="">-- Pilih Kota --</option>
            </select>
            
            <label for="nama_bank">Nama Bank:</label>
            <select id="nama_bank" name="nama_bank" required>
                <option value="">-- Pilih Bank --</option>
                <option value="BCA">BCA</option>
                <option value="BNI">BNI</option>
                <option value="BRI">BRI</option>
                <option value="Bank Mandiri">Bank Mandiri</option>
                <option value="CIMB Niaga">CIMB Niaga</option>
                <option value="Bank Danamon">Bank Danamon</option>
                <option value="Bank Permata">Bank Permata</option>
                <option value="BSI">BSI (Bank Syariah Indonesia)</option>
                <option value="Bank Mega">Bank Mega</option>
                <option value="BTPN">BTPN</option>
                <option value="Bank Jago">Bank Jago</option>
                <option value="Sea Bank">Sea Bank</option>
            </select>

            <label for="nomor_rekening">Nomor Rekening:</label>
            <input type="text" id="nomor_rekening" name="nomor_rekening" placeholder="Contoh: 1234567890" required>

            <label for="foto">Foto Banner:</label>
            <input type="file" id="foto" name="foto" accept=".jpg, .png, .pdf" required>

            <div class="form-actions">
                <button type="submit" class="btn-tambah"><span class="btn-text">Submit</span></button>
            </div>
        </form>
    </main>
    <script src="js/filter.js?v=2.8"></script>
    <script src="js/script.js?v=2.5"></script>
</body>
</html>
