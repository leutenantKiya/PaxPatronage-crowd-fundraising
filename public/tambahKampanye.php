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
    <title>Document</title>
</head>
<body>
    <h1>Tambah Kampanye</h1>
    <form action="../services/tambah_kampanye_service.php" method="post">
        <label for="nama_kampanye">Nama Kampanye:</label><br>
        <input type="text" id="nama_kampanye" name="nama_kampanye" required><br><br>

        <label for="jenis_kampanye">Jenis Kampanye:</label><br>
        <input type="text" id="jenis_kampanye" name="jenis_kampanye" required><br><br>

        <label for="target_dana">Target Dana:</label><br>
        <input type="number" id="target_dana" name="target_dana" required><br><br>

        <label for="tanggal_dimulai">Tanggal Dimulai:</label><br>
        <input type="date" id="tanggal_dimulai" name="tanggal_dimulai" required><br><br>

        <label for="tanggal_berakhir">Tanggal Berakhir:</label><br>
        <input type="date" id="tanggal_berakhir" name="tanggal_berakhir" required><br><br>
        
        <label for="deskripsi">Deskripsi:</label><br>
        <textarea rows="4" cols="50" id="deskripsi" name="deskripsi" required></textarea><br><br>

        <label for="foto">Foto Banner:</label><br>
        <input type="file" id="foto" name="foto" accept=".jpg, .png, .pdf" required><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>