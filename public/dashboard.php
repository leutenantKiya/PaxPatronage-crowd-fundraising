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
            "hapus_kampanye_berhasil" => "Kampanye berhasil dihapus."
        ][$_GET["success"] ?? ""] ?? "";
        $errorMessage = [
            "hapus_kampanye_gagal" => "Kampanye gagal dihapus.",
            "hapus_kampanye_ditolak" => "Kampanye tidak dapat dihapus karena dana terkumpul sudah minimal Rp 10.000."
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
                <a href="#profile" id="nav-about">Profile</a>
                <a href="../services/logout_service.php?logout=true" class="login-btn" id="nav-logout">Logout</a>
            </nav>
        </div>
    </header>
    <main>
        <?php if ($successMessage): ?>
            <div class="alert success-alert"><?php echo htmlspecialchars($successMessage); ?></div>
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
                            echo "<td class='action-cell'><button class='edit-btn' type='button'>Edit</button>";
                            if ($dana_terkumpul >= 10000) {
                                echo "<button class='delete-btn delete-btn-disabled' type='button' disabled>Tidak bisa hapus</button>";
                            } else {
                                echo "<form class='delete-form' action='../services/hapus_kampanye_service.php' method='post' onsubmit=\"return confirm('Yakin ingin menghapus kampanye ini?');\">";
                                echo "<input type='hidden' name='kampanye_id' value='".$kampanye_id."'>";
                                echo "<button class='delete-btn' type='submit'>Hapus</button>";
                                echo "</form>";
                            }
                            echo "</td>";
                            echo "<td><button class='detail-btn' type='button'>Detail</button></td>";
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