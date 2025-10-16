<?php

session_start();
session_unset();
session_destroy();



$domain = explode('.', $_SERVER['HTTP_HOST'])[1];

setcookie('cloudhrm_e_app','',time()- (10 * 365 * 24 * 60 * 60));


session_destroy();

header("Location:https://cloudmvc.clouderp.com.bd/app/views/auth/userApp/upserApps.php?flag=1");

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<meta charset="utf-8">

		<meta name="viewport" content="width=device-width,initial-scale=1">

		<title>Logout</title>

		<link rel="stylesheet" href="themes/Bootstrap.css">

		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile.structure-1.4.0.min.css" />

		<link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />

		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>

		<script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>



</head>



<body>







<script>

setTimeout(function() {

  window.location.href = "index.php";

}, 2);

</script>





</body>

</html>



