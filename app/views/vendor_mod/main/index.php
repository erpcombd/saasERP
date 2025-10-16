<?php 
session_start();
ob_start();

require_once "../../../assets/support/inc.login.php";
$_GET['module_id']=24;
$module_name="Purchase Management ";
if(isset($_POST['ibssignin']))
{
	$passward 	= md5($_POST['pass']);
	$uid  		= $_POST['uid'];
	$cid  		= $_POST['cid'];
if(check_for_login($cid,$uid,$passward,1)){
//header("Location:home.php");
 
  $sql="SELECT * FROM user_activity_management WHERE username='$uid' and password='$passward'";
	$qry = db_query($sql);
	$item = mysqli_fetch_object($qry);
	$item->pass_change; 
	if ($item->pass_change=='YES') {
		// header("Location:../../../login/pages/main/home.php");

	}else{
		
		header("Location:../../../vendor_mod/pages/main/change_password.php");

	}
   
	
}
}else session_destroy();



if(isset($_POST['ibssignin']))
{
$msg="Invalid Login Information!!!";
$type=0;
}

?>
<?php 

include '../../../assets/template/login_interface1.php';
?>