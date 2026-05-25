<?php
    require_once 'session_check.php';
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        header("Location: ../public/login.html");
        exit;
    }
    $email = trim($_POST['uname'] ?? '');
    $password = $_POST['pword'] ?? '';
    $user_type = isset($_POST['user_type']) ? (int) $_POST['user_type'] : null;

    if ($email === '' || $password === '' || $user_type === null) {
        header("Location: ../public/login.html?error=kosong");
        exit;
    }

    require_once 'db_connection.php';
    $db = new Connection;
    $conn = $db->getConnection();

    // print_r($_POST);
    // prepare queue nya -> no script dari antek antek async
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    // cek user
    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        // verif pass
        if ((int) $user['user_type'] !== $user_type){
            $tipe_user = $user_type === 0 ? "Penyelenggara" : "Donatur";
            $msg = "Location: ../public/login.html?error=lu_bukan_".$tipe_user;
            header($msg);
            exit;
        }
        if($user["pass"] == $password){
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_type'] = (int) $user['user_type'];
            $_SESSION['phone'] = $user["phone"];
            $_SESSION['name'] = $user["name"];
            $_SESSION['last_activity'] = time();
            $page = $user_type === 0 ? "dashboard.php" : "home.html";
            $msg = "Location: ../public/".$page."?success=login_berhasil&message=Selamat_Datang_".urlencode($_SESSION['name']);
            header($msg);
            exit;
        }else{
            // wrong pass
            header("Location: ../public/login.html?error=password");
            exit;
        }
    }else{
        // no user found
        header("Location: ../public/login.html?error=user_ga_ada_wok");
        exit;
    }
?>