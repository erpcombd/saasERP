<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";

$title = "home";
$menu = 'home';
$page = "home.php";

require_once '../assets/template/inc.header.php';
?>

<div class="page-content header-clear-small">
	<div class="content">
	    
	</div>
</div>
<!-- End of Page Content-->

<? require_once '../assets/template/inc.footer.php'; ?>