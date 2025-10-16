<? 
session_start();
ob_start();
//$config = require_once "../../../../app/controllers/config/db_master_config.php";
$mcon = mysqli_connect('localhost', 'erpengine_clouderpuser', 'clouderppassword224424', 'erpengine_clouderpdb', '3306');

$ssqlq="SELECT * from company_info where cid='".$_GET['cid']."'";
$ssql=@mysqli_query($mcon,$ssqlq);
$sproj=@mysqli_fetch_object($ssql);
if($sproj->status!='BLACK'){
require_once "../../../controllers/routing/default_values.php";
require_once "../../../controllers/core/inc.login.php";
require_once "../../../controllers/mailer/phpmail.php";
//require_once(SERVER_ENGINE.'configure/db_connect.php');
}

// Generate CSRF token (if not set)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$msg = ""; // Default message variable

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check CSRF token validity
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $msg = "Security check failed. Please try again.";
	}else{
		
		$cid = htmlspecialchars(trim($_REQUEST['cid']));
		$uid = htmlspecialchars(trim($_POST['uid']));
		$password = trim($_POST['pass']);
		// Hash password using a stronger method
		//$hashed_password = hash('sha256', $password); 
		//$hashed_password 	= auth_encode($password);
		$hashed_password 	= md5($password);
	
		if(check_for_login($cid,$uid,$hashed_password,1)){
			
			
			
			$_SESSION["cid_log"] = "1"; //???????
			// Regenerate CSRF token after successful login
			$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
			if($sproj->sms_otp=='ON' || $sproj->mail_otp=='ON'){
			$otp = random_int(100000, 999999);
			$_SESSION['mhafuz'] = 'Inactive';
			mailer('bimolerp@gmail.com', 'One Time Password', $otp);
			db_query("update user_activity_management set qr_code='$otp' where user_id=".$_SESSION['user']['id']);
			header("Location: ../../../views/auth/masters/otp_checking.php");
			}else{
			
			header("Location: ../../../views/auth/masters/home.php");
			}
				
		}else {
				$msg="Invalid Login Information!!!";
				// Generate a new CSRF token after a failed login attempt
				$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
		}
    }
}

require_once "../../../controllers/routing/login_interface_user.php";
//require_once "../../../controllers/routing/login_interface.php";
//require_once "../../../controllers/routing/login_interface_robi.php";