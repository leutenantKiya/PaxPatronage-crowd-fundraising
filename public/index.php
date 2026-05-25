<?php
require_once __DIR__ . "/../services/session_check.php";

// check in logged in first la
if(!isset($_SESSION['user_id'])){
    header("Location: home.html");
    exit;
}
// if yes to home.html
header("Location: home.html");
exit;
?>