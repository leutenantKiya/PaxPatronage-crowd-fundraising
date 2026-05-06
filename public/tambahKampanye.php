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
            <a href="home.html" class="logo" id="logo-link">
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

            <label for="target_dana">Target Dana:</label>
            <input type="number" id="target_dana" name="target_dana" required>

            <label for="tanggal_dimulai">Tanggal Dimulai:</label>
            <input type="date" id="tanggal_dimulai" name="tanggal_dimulai" required>

            <label for="tanggal_berakhir">Tanggal Berakhir:</label>
            <input type="date" id="tanggal_berakhir" name="tanggal_berakhir" required>

            <label for="deskripsi">Deskripsi:</label>
            <textarea rows="4" id="deskripsi" name="deskripsi" required></textarea>

            <label for="foto">Foto Banner:</label>
            <input type="file" id="foto" name="foto" accept=".jpg, .png, .pdf" required>

            <div class="form-actions">
                <button type="submit" class="btn-tambah"><span class="btn-text">Submit</span></button>
            </div>
        </form>
    </main>
</body>
</html>
