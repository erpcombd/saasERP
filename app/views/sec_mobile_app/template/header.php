<? //$cid1 = explode('.', $_SERVER['HTTP_HOST'])[0];?>

<?
$u_id  =  $_SESSION['user']['id'];

/*if($_SESSION['user']['id'] >0){  }else{ echo '<script>location.href="logout.php";</script>'; }*/
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$PBI_ID.'"');
?>

<?php 
/*ob_start();
include_once('../authentication/connection.php'); 
include_once('../authentication/auth.php'); */
//ini_set('display_errors', 1);
/*ob_start();
if($page_name == "invoice_create"){
$blink_class="active";
}*/
?>


<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>Secondary Sales</title>
<link rel="stylesheet" type="text/css" href="../styles/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../styles/style.css?version=0.0.0.2">



<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../fonts/css/fontawesome-all.min.css">    
<link rel="manifest" href="_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
<link rel="apple-touch-icon" sizes="180x180" href="../app/icons/icon-192x192.png">
</head>
    
<body class="theme-light" data-highlight="highlight-red" data-gradient="body-default">
    
<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>
    
<div id="page">
    
    <div class="header header-fixed header-logo-center">
        <a href="../main/home.php" class="header-title">CRM Mobile</a>
        <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
        <a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-lightbulb"></i></a>
    </div>
    
    <div id="footer-bar" class="footer-bar-1">
        <a href="../main/home.php"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="../info_maker/task_manage.php"><i class="fa fa-star"></i><span>Post Mode</span></a>
		
		   <a data-menu="menu-sidebar-left-3" href="#" class="active-nav"><i class="fa fa-bars"></i><span>Menu</span></a>
					
					
		
		
		
        <a href="../main/lead_list.php"><i class="fa fa-search"></i><span>Leads</span></a>
        <a href="#" data-menu="menu-settings"><i class="fa fa-cog"></i><span>Settings</span></a>
    </div>
	
	
	
	
	
	
	
	
	
	<!--
	

<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
-->



<link rel="stylesheet" type="text/css" href="../styles/select2.min.css">
<script type="text/javascript" src="../styles/jquery-3.4.1.min.js"></script>

<?php 
	//include_once('main_layout_menu.php'); 
?>