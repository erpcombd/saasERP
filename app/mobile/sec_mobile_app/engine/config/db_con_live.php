<?php
@session_start();
date_default_timezone_set('Asia/Dhaka');

$host		= 'localhost';
$port		= '3306';
$user 		= $_SESSION['db_user'];
$pass 		= $_SESSION['db_pass'];
$db 	 	= $_SESSION['db_name'];
global $conn;

$conn = mysqli_connect($host,$user,$pass,$db,$port);
if(!$conn) {    die("Database connection failed: M" . mysqli_connect_error()); }

?>
  
