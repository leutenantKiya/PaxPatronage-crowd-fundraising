<?php
session_start();

// check in logged in first la
if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit;
}
// if yes to home.html
readfile(__DIR__.'home.html');
?>