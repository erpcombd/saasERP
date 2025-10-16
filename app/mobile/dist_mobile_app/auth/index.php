<?
ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
ob_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/inc.login.php";
$cid = 'saaserp';



if (isset($_POST['ibssignin'])) {

	//$passward 	= auth_encode($_POST['pass']);
	//$passward 	= md5($_POST['pass']);
	$passward 	= $_POST['pass'];
	$cid  		= $_POST['cid'];
	$uid  		= $_POST['uid'];


	if (check_for_login_dealer($cid, $uid, $passward, 1)) {
		//header("Location:index_varify.php");
		header("Location:../main/home.php");
		exit;
	} else {
		session_destroy();
		$msg = "Invalid Login Information!!!";
	}
}


require_once SERVER_CORE . "routing/login_interface_nfr.php";
