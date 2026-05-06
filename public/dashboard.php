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
    <header class="site-header" id="site-header">
        <!-- header container -->
        <div class="inner-header" id="inner-header">
            <!-- logo -->
            <a href="home.html" class="logo" id="logo-link">
                <div class="logo-icon" id="logo-icon">
                    <span class="material-symbols-outlined">PP</span>
                </div>
        
            </a>
            <!-- navbar -->
            <nav id="main-nav">
                <a href="#profile" id="nav-about">Profile</a>
                <button class="logout-btn" id="logout-btn">
                    <a href="../services/logout_service.php?logout=true" id="nav-logout">Logout</a>
                </button>
            </nav>
        </div>
    </header>
    <main>
        <button class="btn-tambah"><a href="tambahKampanye.php">Tambah Kampanye</a></button>
        <form action="" method="post">
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
                                echo "<tr>";
                                echo "<td>".$no."</td>";
                                echo "<td>".$row["nama_kampanye"]."</td>";
                                echo "<td>".$row["jenis_kampanye"]."</td>";
                                echo "<td>".$row["dana_terkumpul"]."</td>";
                                echo "<td>".$row["target_kampanye"]."</td>";
                                echo "<td>".$row["tanggal_dimulai"]."</td>";
                                echo "<td>".$row["tanggal_berakhir"]."</td>";
                                echo "<td><img src='".$root_path.$row["path_gambar"]."' alt='Banner Kampanye' width='100'></td>";
                                echo "<td><button class='edit-btn'>Edit</button>
                                <button class='delete-btn'>Hapus</button></td>";
                                echo "<td><button class='detail-btn'>Detail</button></td>";
                                echo "</tr>";
                                $no++;
                            }
                        }else{
                            echo "<tr><td colspan='8'>Belum ada kampanye yang dibuat.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </form>
    </main>
</body>
</html>