<? 
session_start();
ob_start();
//$config = require_once "../../../../app/controllers/config/db_master_config.php";
$mcon = mysqli_connect('localhost', 'erpengine_clouderpuser', 'clouderppassword224424', 'erpengine_clouderpdb', '3306');

$ssqlq="SELECT * from company_info where id=10112";
$ssql=@mysqli_query($mcon,$ssqlq);
$sproj=@mysqli_fetch_object($ssql);
if($sproj->status!='BLACK'){
require_once "../../../controllers/routing/default_values.php";
require_once "../../../controllers/core/inc.login.php";
}
$cid='';
$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
$cid = explode('.', filter_var($_SERVER['HTTP_HOST'], FILTER_SANITIZE_STRING))[0];
if($cid!=''){
        if($sproj->is_transfer=='YES'){
		$cid = htmlspecialchars(trim($proj->transfer_cid));
		}elseif($sproj->is_transfer=='NO'){
		$cid = htmlspecialchars(trim($cid));
		}else{
		$cid = htmlspecialchars(trim($cid));
		}
header('Location:user_checking.php?cid='.$cid.'');
}



if ($_SERVER["REQUEST_METHOD"] === "POST") {
		
		if($sproj->is_transfer=='YES'){
		$cid = htmlspecialchars(trim($proj->transfer_cid));
		}elseif($sproj->is_transfer=='NO'){
		$cid = htmlspecialchars(trim($_POST['cid']));
		}else{
		$cid = htmlspecialchars(trim($_POST['cid']));
		}
		
		header('Location:user_checking.php?cid='.$cid.'');
	
}

require_once "../../../controllers/routing/login_interface_cid.php";
//require_once "../../../controllers/routing/login_interface.php";
//require_once "../../../controllers/routing/login_interface_robi.php";