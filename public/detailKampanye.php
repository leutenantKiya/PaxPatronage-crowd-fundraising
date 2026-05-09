<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../public/login.html?error=login ulang");
        exit;
    }
    // Sumber kampanye_id: dari POST (klik Detail di dashboard) atau dari session (refresh halaman)
    if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
        if (!isset($_POST['kampanye_id']) || !ctype_digit($_POST['kampanye_id'])) {
            header("Location: ../public/dashboard.php?error=lihat_kampanye_gagal");
            exit;
        }
        $kampanye_id = (int) $_POST['kampanye_id'];
        $_SESSION['kampanye_id'] = $kampanye_id;
    } else {
        if (!isset($_SESSION['kampanye_id'])) {
            header("Location: ../public/dashboard.php");
            exit;
        }
        $kampanye_id = (int) $_SESSION['kampanye_id'];
    }
    $user_id = (int) $_SESSION['user_id'];
    require_once __DIR__ . "/../services/db_connection.php";
    $db = new Connection;

    // Ownership check
    $kampanye_res = $db->getKampanyeByIdAndUser($kampanye_id, $user_id);
    $kampanye = mysqli_fetch_assoc($kampanye_res);
    if (!$kampanye) {
        header("Location: ../public/dashboard.php?error=lihat_kampanye_gagal");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kampanye - <?php echo htmlspecialchars($kampanye['nama_kampanye']); ?></title>
    <link rel="stylesheet" href="style/dashboard.css">
</head>
<body>
    <?php
        $successMessage = [
            "verifikasi_berhasil" => "Donasi berhasil diverifikasi. Dana terkumpul sudah ditambahkan.",
        ][$_GET["success"] ?? ""] ?? "";
        $infoMessage = [
            "reject_berhasil" => "Donasi ditolak.",
        ][$_GET["info"] ?? ""] ?? "";
        $errorMessage = [
            "verifikasi_gagal" => "Aksi verifikasi gagal (donasi mungkin sudah diproses).",
        ][$_GET["error"] ?? ""] ?? "";
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

        <div class="form-header">
            <h1>Detail Kampanye</h1>
            <a href="dashboard.php" class="btn-back">&larr; Kembali ke Dashboard</a>
        </div>

        <!-- Ringkasan kampanye -->
        <section class="kampanye-summary">
            <h2><?php echo htmlspecialchars($kampanye['nama_kampanye']); ?></h2>
            <p><strong>Jenis:</strong> <?php echo htmlspecialchars($kampanye['jenis_kampanye']); ?></p>
            <p><strong>Target:</strong> Rp <?php echo number_format((float) $kampanye['target_kampanye'], 0, ',', '.'); ?></p>
            <p><strong>Dana Terkumpul:</strong> Rp <?php echo number_format((float) ($kampanye['dana_terkumpul'] ?? 0), 0, ',', '.'); ?></p>
            <p><strong>Periode:</strong> <?php echo htmlspecialchars($kampanye['tanggal_dimulai']); ?> &mdash; <?php echo htmlspecialchars($kampanye['tanggal_berakhir']); ?></p>
        </section>

        <!-- ==== Tabel atas: PENDING (antrian verifikasi, FIFO) ==== -->
        <?php $pending = $db->getDonasiPendingByKampanye($kampanye_id, $user_id); ?>
        <h3 class="section-heading">
            Donasi Menunggu Verifikasi
            <span class="count-pill"><?php echo mysqli_num_rows($pending); ?></span>
        </h3>
        <table class="kampanye-table" border="1">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Donatur</td>
                    <td>Jumlah Donasi</td>
                    <td>Metode Bayar</td>
                    <td>Bukti Donasi</td>
                    <td>Tanggal</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (mysqli_num_rows($pending) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($pending)) {
                            $id_donasi      = (int) $row['id_donasi'];
                            $nama_donatur   = htmlspecialchars($row['nama_donatur'] ?? 'Anonim');
                            $amount         = (float) $row['amount'];
                            $metode_bayar   = htmlspecialchars($row['metode_bayar']);
                            $bukti          = htmlspecialchars($row['bukti']);
                            $created_at     = htmlspecialchars($row['created_at']);

                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . $nama_donatur . "</td>";
                            echo "<td>Rp " . number_format($amount, 0, ',', '.') . "</td>";
                            echo "<td>" . $metode_bayar . "</td>";
                            echo "<td><a class='bukti-link' href='" . $bukti . "' target='_blank'>Lihat Bukti</a></td>";
                            echo "<td>" . $created_at . "</td>";
                            echo "<td class='action-cell'>";
                                echo "<form action='../services/verifikasi_donasi_service.php' method='post' style='display:inline'>";
                                    echo "<input type='hidden' name='id_donasi' value='" . $id_donasi . "'>";
                                    echo "<input type='hidden' name='action' value='accept'>";
                                    echo "<button type='submit' class='edit-btn' onclick=\"return confirm('Verifikasi donasi ini? Dana terkumpul akan bertambah.');\">Accept</button>";
                                echo "</form>";
                                echo "<form action='../services/verifikasi_donasi_service.php' method='post' style='display:inline'>";
                                    echo "<input type='hidden' name='id_donasi' value='" . $id_donasi . "'>";
                                    echo "<input type='hidden' name='action' value='reject'>";
                                    echo "<button type='submit' class='delete-btn' onclick=\"return confirm('Tolak donasi ini?');\">Reject</button>";
                                echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='7'>Tidak ada donasi yang menunggu verifikasi.</td></tr>";
                    }
                ?>
            </tbody>
        </table>

        <!-- ==== Tabel bawah: VERIFIED (showcase donatur, terbaru di atas) ==== -->
        <?php $verified = $db->getDonasiVerifiedByKampanye($kampanye_id, $user_id); ?>
        <h3 class="section-heading">
            Donatur Terverifikasi
            <span class="count-pill"><?php echo mysqli_num_rows($verified); ?></span>
        </h3>
        <table class="kampanye-table" border="1">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Donatur</td>
                    <td>Jumlah Donasi</td>
                    <td>Metode Bayar</td>
                    <td>Pesan</td>
                    <td>Tanggal</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (mysqli_num_rows($verified) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($verified)) {
                            $nama_donatur = htmlspecialchars($row['nama_donatur'] ?? 'Anonim');
                            $amount       = (float) $row['amount'];
                            $metode_bayar = htmlspecialchars($row['metode_bayar']);
                            $pesan        = htmlspecialchars($row['pesan'] ?? '-');
                            $created_at   = htmlspecialchars($row['created_at']);

                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . $nama_donatur . "</td>";
                            echo "<td>Rp " . number_format($amount, 0, ',', '.') . "</td>";
                            echo "<td>" . $metode_bayar . "</td>";
                            echo "<td>" . ($pesan === '' ? '-' : $pesan) . "</td>";
                            echo "<td>" . $created_at . "</td>";
                            echo "<td><span class='status-badge status-verified'>verified</span></td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='7'>Belum ada donasi terverifikasi.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
