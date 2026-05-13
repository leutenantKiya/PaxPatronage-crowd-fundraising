<?php
session_start();

// check in logged in first la
if(!isset($_SESSION['user_id'])){
    header("Location: home.html");
    exit;
}
// if yes to home.html
header("Location: home.html");
exit;
?>