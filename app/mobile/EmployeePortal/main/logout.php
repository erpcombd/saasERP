<?php
session_start();

unset($_SESSION["uid"]);
unset($_SESSION["pass"]);

$domain = explode('.', $_SERVER['HTTP_HOST'])[1];
setcookie('clouderp','',time()- (10 * 365 * 24 * 60 * 60));

session_destroy();
header("Location:../index.php");

?>