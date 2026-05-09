<?php
    session_start();
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
            <input type="text" id="jenis_kampanye" name="jenis_kampanye" required>
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

            <label for="alamat_jalan">Alamat Lengkap (Jalan, RT/RW, dll):</label>
            <input type="text" id="alamat_jalan" name="alamat_jalan" placeholder="Contoh: Jl. Dr. Wahidin Sudirohusodo No. 5-25" required>

            <label for="kota">Kota / Kabupaten:</label>
            <input type="text" id="kota" name="kota" placeholder="Contoh: Yogyakarta" required>

            <label for="provinsi">Provinsi:</label>
            <select id="provinsi" name="provinsi" required>
                <option value="">-- Pilih Provinsi --</option>
                <option value="Aceh">Aceh</option>
                <option value="Sumatera Utara">Sumatera Utara</option>
                <option value="Sumatera Barat">Sumatera Barat</option>
                <option value="Riau">Riau</option>
                <option value="Jambi">Jambi</option>
                <option value="Sumatera Selatan">Sumatera Selatan</option>
                <option value="Bengkulu">Bengkulu</option>
                <option value="Lampung">Lampung</option>
                <option value="Kep. Bangka Belitung">Kep. Bangka Belitung</option>
                <option value="Kep. Riau">Kep. Riau</option>
                <option value="DKI Jakarta">DKI Jakarta</option>
                <option value="Jawa Barat">Jawa Barat</option>
                <option value="Jawa Tengah">Jawa Tengah</option>
                <option value="DI Yogyakarta">DI Yogyakarta</option>
                <option value="Jawa Timur">Jawa Timur</option>
                <option value="Banten">Banten</option>
                <option value="Bali">Bali</option>
                <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                <option value="Kalimantan Barat">Kalimantan Barat</option>
                <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                <option value="Kalimantan Timur">Kalimantan Timur</option>
                <option value="Kalimantan Utara">Kalimantan Utara</option>
                <option value="Sulawesi Utara">Sulawesi Utara</option>
                <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                <option value="Gorontalo">Gorontalo</option>
                <option value="Sulawesi Barat">Sulawesi Barat</option>
                <option value="Maluku">Maluku</option>
                <option value="Maluku Utara">Maluku Utara</option>
                <option value="Papua">Papua</option>
                <option value="Papua Barat">Papua Barat</option>
                <option value="Papua Selatan">Papua Selatan</option>
                <option value="Papua Tengah">Papua Tengah</option>
                <option value="Papua Pegunungan">Papua Pegunungan</option>
                <option value="Papua Barat Daya">Papua Barat Daya</option>
            </select>

            <label for="foto">Foto Banner:</label>
            <input type="file" id="foto" name="foto" accept=".jpg, .png, .pdf" required>

            <div class="form-actions">
                <button type="submit" class="btn-tambah"><span class="btn-text">Submit</span></button>
            </div>
        </form>
    </main>
</body>
</html>
