<? 
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
session_start();
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once "../../../controllers/core/inc.login.php";
include 'pass_var.php';

	
if($_SESSION['mmsg']!=''){
	unset($_SESSION['pass_changer_user_id']);
    unset($_SESSION['pass_changer_email']);
	}

$cid='robi';
unset($_SESSION['pass_changer_user_id']);
unset($_SESSION['pass_changer_email']);

if(isset($_POST['ibssignin']))
{



  $passward 	= auth_encode($_POST['pass']);
  $uid  		= $_POST['uid'];
  $cid  		= 'saaserp';

	if(check_for_login_vendor($cid,$uid,$passward,1)){
		$_SESSION["user_type"] = "vendor";
        echo 'Supplier';
    $sql="SELECT * FROM vendor WHERE email='$uid' and ".$pvalue."='$passward'";
	$qry = db_query($sql);
	$item = mysqli_fetch_object($qry);
	
	if ($item->pass_change=='YES') {
		header("Location:../../vendor_mod/eProcuremen_vendor_portal/vendor_entry.php");

	}else{
		header("Location:update_pass.php");
	}
	
	exit;

	}else {
		// echo "password not match";
		session_destroy();
		$msg="Invalid Login Information!!!";
	}
}

require_once "../../../controllers/routing/login_interface.php";
?>
