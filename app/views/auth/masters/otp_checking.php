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
require_once "../../../controllers/config/db_con_live.php";
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
		
		
		$given_otp = $_POST['qr_input'];
		$qry = mysqli_query($conn,"select qr_code from user_activity_management where user_id=".$_SESSION['user']['id']);
		$data = mysqli_fetch_object($qry);
		if($data->qr_code===$given_otp){

			$_SESSION["cid_log"] = "1"; //???????
			// Regenerate CSRF token after successful login
			$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
			
			// this code for session expaired Redirect to saved URL if cookie is set
			if (isset($_COOKIE['redirect_url_setcookie'])) {
				$redirect = $_COOKIE['redirect_url_setcookie'];
				// Clear the cookie
				setcookie("redirect_url_setcookie", "", time() - 3600, "/");
				// go the the url link
				header("Location: $redirect");
			} else {
				//header("Location:index_varify.php");
				if (empty($_SESSION['redirect_after_login'])) {
				    $_SESSION['Authorized']	='Yes';
				    $_SESSION['mhafuz'] = 'Active';
					header("Location: ../../../views/auth/masters/home.php");
				} else {
					$redirect = $_SESSION['redirect_after_login'];
					unset($_SESSION['redirect_after_login']); // Clean up
					header("Location: $redirect");
				}
				exit;
			
			}
			
			exit;
	  
		}else {
				$msg="Invalid Login Information!!!";
				// Generate a new CSRF token after a failed login attempt
				$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
		}
    }
}

require_once "../../../controllers/routing/login_interface_otp.php";
//require_once "../../../controllers/routing/login_interface.php";
//require_once "../../../controllers/routing/login_interface_robi.php";