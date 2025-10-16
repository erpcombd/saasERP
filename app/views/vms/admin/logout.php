<?php
session_start();
include '../config/db.php';
include '../config/function.php';

unset($_SESSION['username']);
unset($_SESSION['admin_login']);



redirect('index.php');
die();
?>