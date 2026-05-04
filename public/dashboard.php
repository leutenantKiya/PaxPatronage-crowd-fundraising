<?php
// echo "Halo donatur";
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.html?error=invalid_session");
    exit;
}
print_r($_SESSION);
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
</body>
</html>