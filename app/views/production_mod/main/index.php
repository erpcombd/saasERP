<?php 
session_start();
ob_start();
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
require_once "../../../assets/support/inc.login.php";
$module_name="Production Costing Solution";

error_reporting(E_ALL);
ini_set('display_errors', '1');

if(isset($_POST['ibssignin']))
{
	$passward 	= $_POST['pass'];
	$uid  		= $_POST['uid'];
	$cid  		= $_POST['cid'];
if(check_for_login($cid,$uid,$passward,1)){
//header("Location:home.php");
	header("Location:../../../login/pages/main/home.php");
}
}else session_destroy();



if(isset($_POST['ibssignin']))
{
$msg="Invalid Login Information!!!";
$type=0;
}

?>
<?php 

include '../../../assets/template/login_interface.php';
?>