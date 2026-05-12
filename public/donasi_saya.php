<?php
    session_start();

    // Guard: kalau belum login, redirect ke home dengan error
    if (!isset($_SESSION['user_id'])) {
        header("Location: home.html?error=login_dulu");
        exit;
    }

    $user_id  = $_SESSION['user_id'];
    $userName = $_SESSION['name'] ?? 'User';

    require_once __DIR__ . "/../services/db_connection.php";
    $db  = new Connection;
    $res = $db->getDonasiByUser($user_id);

    // Helper format tanggal Indonesia
    $bulan_id = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    // Hitung ringkasan
    $total_donasi   = 0;
    $total_nominal  = 0;
    $count_verified = 0;
    $count_pending  = 0;
    $count_rejected = 0;
    $donasi_arr     = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $donasi_arr[] = $row;
        $total_donasi++;
        $total_nominal += (float) $row['amount'];
        if ($row['status'] === 'verified')  $count_verified++;
        if ($row['status'] === 'pending')   $count_pending++;
        if ($row['status'] === 'rejected')  $count_rejected++;
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/donasi_saya.css?v=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Donasi Saya - PaxPatron</title>
</head>
<body>
    <!-- header -->
    <header class="site-header" id="site-header">
        <div class="inner-header" id="inner-header">
            <!-- logo -->
            <a href="home.html" class="logo" id="logo-link">
                <div class="logo-icon" id="logo-icon">
                    <span>PP</span>
                </div>
                <span class="logo-text" id="logo-text">PaxPatron</span>
            </a>
            <!-- navbar -->
            <nav class="navbar" id="top">
                <a href="home.html" id="nav-home">Beranda</a>
                <a href="donasi_saya.php" class="active" id="nav-donasi">Donasi Saya</a>
            </nav>
            <div class="header-right">
                <span class="profile-name">Halo, <?php echo htmlspecialchars($userName); ?></span>
                <div class="profile-picture" id="profile-picture">
                    <button class="profile-toggle" id="profile-toggle" type="button" aria-haspopup="true" aria-expanded="false">
                        <img class="avatar" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAWjipIcx9P_d5QCPMxAjv2rssXV8CO11Cz6sxyTQL1yY_ycQ0-ehgBxmElZs13-fpF0DxSdz-9c7ceVoHOAomqriYrNz4PYA3YNq5eS6cSkLg5Mm1R665UPTvFsxN5HO26SI-o0kPT_FXrMO7lQTIoUSR-cVVu0gdk6RDKerIyP_TctBAgo2l7Dfd5tYBCLVWxUt2Y6hfFR3BpY27ewaTW_ywC1db4TgNom-zTp88TxUU7vkLfZVyYWvrKc7PDNgerRaHxLZLHRxc" width="40px" alt="User avatar" id="user-avatar"/>
                    </button>
                    <div class="profile-menu" id="profile-menu">
                        <a href="home.html" id="profile-menu-home">Beranda</a>
                        <a href="../services/logout_service.php?logout=true" id="logout-link">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- main -->
    <main id="main-content">
        <!-- breadcrumb -->
        <div class="bread-crumb" id="breadcrumb">
            <a href="home.html" class="breadcrumb-link">Home</a>
            <span class="breadcrumb-sep">›</span>
            <span class="breadcrumb-current">Donasi Saya</span>
        </div>

        <div class="page-title-section">
            <h1 id="page-title">Riwayat Donasi Saya</h1>
            <p class="page-subtitle">Semua donasi yang pernah kamu berikan, di satu tempat.</p>
        </div>

        <!-- summary cards -->
        <div class="summary-grid" id="summary-grid">
            <div class="summary-card summary-total">
                <span class="material-icons summary-icon">volunteer_activism</span>
                <div class="summary-info">
                    <span class="summary-value"><?php echo $total_donasi; ?></span>
                    <span class="summary-label">Total Donasi</span>
                </div>
            </div>
            <div class="summary-card summary-nominal">
                <span class="material-icons summary-icon">payments</span>
                <div class="summary-info">
                    <span class="summary-value">Rp <?php echo number_format($total_nominal, 0, ',', '.'); ?></span>
                    <span class="summary-label">Total Nominal</span>
                </div>
            </div>
            <div class="summary-card summary-verified">
                <span class="material-icons summary-icon">check_circle</span>
                <div class="summary-info">
                    <span class="summary-value"><?php echo $count_verified; ?></span>
                    <span class="summary-label">Terverifikasi</span>
                </div>
            </div>
            <div class="summary-card summary-pending">
                <span class="material-icons summary-icon">hourglass_top</span>
                <div class="summary-info">
                    <span class="summary-value"><?php echo $count_pending; ?></span>
                    <span class="summary-label">Menunggu</span>
                </div>
            </div>
            <div class="summary-card summary-rejected">
                <span class="material-icons summary-icon">cancel</span>
                <div class="summary-info">
                    <span class="summary-value"><?php echo $count_rejected; ?></span>
                    <span class="summary-label">Ditolak</span>
                </div>
            </div>
        </div>

        <!-- filter tabs -->
        <div class="filter-tabs" id="filter-tabs">
            <button class="tab-btn active" data-filter="all" onclick="filterDonasi('all', this)">
                Semua <span class="tab-count"><?php echo $total_donasi; ?></span>
            </button>
            <button class="tab-btn" data-filter="verified" onclick="filterDonasi('verified', this)">
                Terverifikasi <span class="tab-count"><?php echo $count_verified; ?></span>
            </button>
            <button class="tab-btn" data-filter="pending" onclick="filterDonasi('pending', this)">
                Menunggu <span class="tab-count"><?php echo $count_pending; ?></span>
            </button>
            <button class="tab-btn" data-filter="rejected" onclick="filterDonasi('rejected', this)">
                Ditolak <span class="tab-count"><?php echo $count_rejected; ?></span>
            </button>
        </div>

        <!-- donation list -->
        <div class="donasi-list" id="donasi-list">
            <?php if (count($donasi_arr) > 0): ?>
                <?php foreach ($donasi_arr as $d):
                    $ts = strtotime($d['created_at']);
                    $tgl_fmt = date('j', $ts) . ' ' . $bulan_id[(int)date('n', $ts) - 1] . ' ' . date('Y', $ts);
                    $jam_fmt = date('H:i', $ts);
                    $amount_fmt = 'Rp ' . number_format((float)$d['amount'], 0, ',', '.');
                    $status = htmlspecialchars($d['status']);
                    $nama_kampanye = htmlspecialchars($d['nama_kampanye']);
                    $jenis_kampanye = htmlspecialchars($d['jenis_kampanye']);
                    $penyelenggara = htmlspecialchars($d['nama_penyelenggara']);
                    $path_gambar = htmlspecialchars('upload/' . $d['path_gambar']);
                    $pesan = htmlspecialchars($d['pesan'] ?? '');
                    $metode = htmlspecialchars($d['metode_bayar']);
                    $kampanye_id = (int) $d['kampanye_id'];

                    // Status label & class
                    $status_label = ['pending' => 'Menunggu Verifikasi', 'verified' => 'Terverifikasi', 'rejected' => 'Ditolak'][$status] ?? $status;
                    $status_class = 'status-' . $status;
                ?>
                <div class="donasi-card" data-status="<?php echo $status; ?>">
                    <div class="donasi-card-left">
                        <div class="donasi-img-wrapper">
                            <img src="<?php echo $path_gambar; ?>" alt="<?php echo $nama_kampanye; ?>" class="donasi-img" onerror="this.src='upload/example-detail.png'">
                        </div>
                        <div class="donasi-info">
                            <a href="detail.html?id=<?php echo $kampanye_id; ?>" class="donasi-kampanye-name"><?php echo $nama_kampanye; ?></a>
                            <span class="donasi-category"><?php echo $jenis_kampanye; ?></span>
                            <span class="donasi-organizer">oleh <?php echo $penyelenggara; ?></span>
                            <?php if ($pesan): ?>
                                <p class="donasi-pesan">"<?php echo $pesan; ?>"</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="donasi-card-right">
                        <span class="donasi-amount"><?php echo $amount_fmt; ?></span>
                        <span class="donasi-metode"><?php echo $metode; ?></span>
                        <span class="status-badge <?php echo $status_class; ?>"><?php echo $status_label; ?></span>
                        <span class="donasi-date">
                            <span class="material-icons date-icon">calendar_today</span>
                            <?php echo $tgl_fmt; ?> • <?php echo $jam_fmt; ?>
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state-box">
                    <span class="material-icons empty-icon">sentiment_dissatisfied</span>
                    <h3>Belum ada donasi</h3>
                    <p>Kamu belum pernah berdonasi. Yuk mulai berbagi kebaikan!</p>
                    <a href="home.html" class="btn-explore">Jelajahi Kampanye</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- footer -->
    <footer id="contact_us">
        <div class="footer-container" id="footer-container">
            <div class="footer-content" id="footer-content">
                <div class="footer-info" id="footer-info">
                    <h3 id="footer-contact-title">Hubungi Kami</h3>
                    <ul class="contact-list" id="contact-list">
                        <li>
                            <span class="material-icons">mail</span>
                            <a href="mailto:#" id="email-link">
                                <ul>
                                    <li>71241119@students.ukdw.ac.id</li>
                                    <li>71241078@students.ukdw.ac.id</li>
                                </ul>
                            </a>
                        </li>
                        <li>
                            <span class="material-icons">location_on</span>
                            <span>Yogyakarta, Indonesia</span>
                        </li>
                    </ul>
                </div>

                <div class="footer-social" id="footer-social">
                    <h3 id="footer-social-title">Media Sosial</h3>
                    <div class="social-icons" id="social-icons">
                        <a href="https://www.instagram.com/gwkiyaco/?hl=en" title="Instagram" id="social-instagram"><img src="assets/instagram.png" alt="Instagram" width="24"></a>
                        <a href="https://x.com/archlinuxmemes/status/1051963941566308352" title="Twitter" id="social-twitter"><img src="assets/twitter.png" alt="Twitter" width="24"></a>
                        <a href="www.linkedin.com/in/antonius-kiya-255945290" title="LinkedIn" id="social-linkedin"><img src="assets/linkedin.png" alt="LinkedIn" width="24"></a>
                    </div>
                </div>
            </div>

            <span class="horizontal-line" id="footer-divider"></span>

            <div class="copyright" id="copyright">
                <p id="copyright-text">&copy; 2026 Copyright PaxPatron Non-Profit Company. Kiya-Kevin</p>
            </div>
        </div>
    </footer>

    <script>
        // Toggle profile menu
        const profileToggle = document.getElementById('profile-toggle');
        const profilePicture = document.getElementById('profile-picture');
        if (profileToggle) {
            profileToggle.addEventListener('click', () => {
                profilePicture.classList.toggle('open');
            });
            document.addEventListener('click', (e) => {
                if (!profilePicture.contains(e.target)) {
                    profilePicture.classList.remove('open');
                }
            });
        }

        // Filter donasi by status
        function filterDonasi(status, btn) {
            const cards = document.querySelectorAll('.donasi-card');
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = '';
                    // Re-trigger animation
                    card.style.animation = 'none';
                    card.offsetHeight; // force reflow
                    card.style.animation = '';
                } else {
                    card.style.display = 'none';
                }
            });

            // Update active tab
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
    </script>
</body>
</html>
