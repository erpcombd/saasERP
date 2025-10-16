<? session_start();
ob_start();
require_once "../../../controllers/routing/default_values.php";

require_once "../../../controllers/core/inc.login.php";
$cid='saaserp';



if(isset($_POST['ibssignin']))
{

	//$passward 	= auth_encode($_POST['pass']);
	$passward 	= md5($_POST['pass']);
	$cid  		= $_POST['cid'];
	$uid  		= $_POST['uid'];
	

	if(check_for_login($cid,$uid,$passward,1)){
  	//header("Location:index_varify.php");

echo "<script>
    sessionStorage.setItem('username', '" . $_POST['uid'] . "');
    sessionStorage.setItem('password', '" . $_POST['pass'] . "');
    window.location.href = '../main/home.php';
</script>";



	header("Location:../../../views/auth/masters/home.php");

	exit;

	}else {
		session_destroy();
		$msg="Invalid Login Information!!!";
	}
}



require_once "../../../controllers/routing/login_interface.php";
?>