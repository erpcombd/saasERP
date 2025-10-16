<?php
session_start();

if(!isset($_SESSION['username']) && $_SESSION['username']!="YES"){

	 session_destroy();
	 header("location:index.php");
	
	die("You are not allowed to access this page!");
}


if(isset($_REQUEST['action']) && $_REQUEST['action']=='logout'){
	// echo "YES";
	session_destroy();
	header("location:index.php");
}
?>