<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    $timeout = 1800;
    // Cek timeout hanya kalau user sudah login (ada user_id di session)
    // Halaman publik (home.html) tetap bisa diakses tanpa login
    if(isset($_SESSION['user_id']) && isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)){
        session_unset();
        session_destroy();
        header("Location: /PaxPatronage/PaxPatronage-crowd-fundraising/public/login.html?error=session_timeout");
        exit;
    }
    if(isset($_SESSION['user_id'])){
        $_SESSION['last_activity'] = time();
    }
?>