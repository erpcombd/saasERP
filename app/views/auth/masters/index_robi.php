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
//$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
//$cid = explode('.', filter_var($_SERVER['HTTP_HOST'], FILTER_SANITIZE_STRING))[0];
$_SESSION["cid_log"] = "2";

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
		// Sanitize user input
		if($sproj->is_transfer=='YES'){
		$cid = htmlspecialchars(trim($proj->transfer_cid));
		}elseif($sproj->is_transfer=='NO'){
		$cid = htmlspecialchars(trim($_POST['cid']));
		}else{
		$cid = htmlspecialchars(trim($_POST['cid']));
		}
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
						if($cid == 'nasirgroup'){
						  header("Location:https://nasirgrouperp.ezzy-erp.com/app/views/auth/masters/home.php");
						 }else{
							header("Location: ../../../views/auth/masters/home.php");
						}
					
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

require_once "../../../controllers/routing/login_interface_robi.php";
//require_once "../../../controllers/routing/login_interface.php";
//require_once "../../../controllers/routing/login_interface_robi.php";