<?php
// echo "Halo donatur";
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.html?error=invalid_session");
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
    <title>dashboard - <?php echo htmlspecialchars($_SESSION['name'])?></title>
    <link rel="stylesheet" href="<?php echo "../public/style/dashboard.css"?>">
</head>
<body>
    <?php
        $successMessage = [
            "hapus_kampanye_berhasil" => "Kampanye berhasil dihapus.",
            "update_kampanye_berhasil" => "Kampanye berhasil diperbarui."
        ][$_GET["success"] ?? ""] ?? "";
        $infoMessage = [
            "update_kampanye_tidak_berubah" => "Tidak ada perubahan pada data kampanye."
        ][$_GET["info"] ?? ""] ?? "";
        $errorMessage = [
            "hapus_kampanye_gagal" => "Kampanye gagal dihapus.",
            "hapus_kampanye_ditolak" => "Kampanye tidak dapat dihapus karena dana terkumpul sudah minimal Rp 10.000.",
            "update_kampanye_gagal" => "Kampanye gagal diperbarui.",
            "upload_gagal" => "Upload gambar gagal.",
            "tanggal_tidak_valid" => "Tanggal dimulai tidak boleh lebih besar dari tanggal berakhir."
        ][$_GET["error"] ?? ""] ?? "";
    ?>
    <header class="site-header" id="site-header">
        <!-- header container -->
        <div class="inner-header" id="inner-header">
            <!-- logo -->
            <a href="dashboard.php" class="logo" id="logo-link">
                <div class="logo-icon" id="logo-icon">
                    <span class="material-symbols-outlined">PP</span>
                </div>
                <span class="logo-text" id="logo-text">PaxPatron</span>
            </a>
            <!-- navbar -->
            <nav id="main-nav">
                <!-- <a href="#profile" id="nav-about">Profile</a> -->
                <a href="../services/logout_service.php?logout=true" class="login-btn" id="nav-logout">Logout</a>
            </nav>
        </div>
    </header>
    <main>
        <?php if ($successMessage): ?>
            <div class="alert success-alert"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>
        <?php if ($infoMessage): ?>
            <div class="alert info-alert"><?php echo htmlspecialchars($infoMessage); ?></div>
        <?php endif; ?>
        <?php if ($errorMessage): ?>
            <div class="alert error-alert"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>
        <button class="btn-tambah"><a href="tambahKampanye.php">Tambah Kampanye</a></button>
        <table class="kampanye-table" border="1">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Kampanya</td>
                    <td>Jenis Kampanye</td>
                    <td>Dana Terkumpul</td>
                    <td>Target Terkumpul</td>
                    <td>Tanggal Dimulai</td>
                    <td>Tanggal Berakhir</td>
                    <td>Banner Kampanye</td>
                    <td>Edit | Hapus</td>
                    <td>Detail</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $db = new Connection;
                    $result = $db->getKampanye($user_id);
                    if(mysqli_num_rows($result) > 0){
                        $no = 1;
                        $root_path = "upload/";
                        while($row = mysqli_fetch_assoc($result)){
                            $kampanye_id = (int) $row["id"];
                            $dana_terkumpul = (float) ($row["dana_terkumpul"] ?? 0);
                            $target_kampanye = (float) $row["target_kampanye"];
                            $nama_kampanye = htmlspecialchars($row["nama_kampanye"]);
                            $jenis_kampanye = htmlspecialchars($row["jenis_kampanye"]);
                            $tanggal_dimulai = htmlspecialchars($row["tanggal_dimulai"]);
                            $tanggal_berakhir = htmlspecialchars($row["tanggal_berakhir"]);
                            $path_gambar = htmlspecialchars($root_path.$row["path_gambar"]);

                            echo "<tr>";
                            echo "<td>".$no."</td>";
                            echo "<td>".$nama_kampanye."</td>";
                            echo "<td>".$jenis_kampanye."</td>";
                            echo "<td>Rp ".number_format($dana_terkumpul, 0, ',', '.')."</td>";
                            echo "<td>Rp ".number_format($target_kampanye, 0, ',', '.')."</td>";
                            echo "<td>".$tanggal_dimulai."</td>";
                            echo "<td>".$tanggal_berakhir."</td>";
                            echo "<td><img src='".$path_gambar."' alt='Banner Kampanye' width='100'></td>";
                            // Kolom Edit | Hapus: SEMUA form harus berada di dalam <td> (HTML valid).
                            echo "<td class='action-cell'>";
                                echo "<form class='delete-form' action='editKampanye.php' method='post'>";
                                    echo "<input type='hidden' name='nama_kampanye' value='".$nama_kampanye."'>";
                                    echo "<input type='hidden' name='kampanye_id' value='".$kampanye_id."'>";
                                    echo "<button type='submit' class='edit-btn'>Edit</button>";
                                echo "</form>";
                                if ($dana_terkumpul >= 10000) {
                                    echo "<button class='delete-btn delete-btn-disabled' type='button' disabled title='Tidak bisa dihapus karena dana terkumpul sudah minimal Rp 10.000'>Hapus</button>";
                                } else {
                                    echo "<form class='delete-form' action='../services/hapus_kampanye_service.php' method='post' onsubmit=\"return confirm('Yakin ingin menghapus kampanye ini?');\">";
                                        echo "<input type='hidden' name='kampanye_id' value='".$kampanye_id."'>";
                                        echo "<button class='delete-btn' type='submit'>Hapus</button>";
                                    echo "</form>";
                                }
                            echo "</td>";
                            // Kolom Detail
                            echo "<td>";
                                echo "<form class='delete-form' action='../public/detailKampanye.php' method='post'>";
                                    echo "<input type='hidden' name='kampanye_id' value='".$kampanye_id."'>";
                                    echo "<button class='detail-btn' type='submit'>Detail</button>";
                                echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                            $no++;
                        }
                    }else{
                        echo "<tr><td colspan='10'>Belum ada kampanye yang dibuat.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>