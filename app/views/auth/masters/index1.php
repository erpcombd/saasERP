<? 
session_start();
ob_start();
require_once "../../../controllers/routing/default_values.php";
require_once "../../../controllers/core/inc.login.php";
$cid='';
//$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
//$cid = explode('.', filter_var($_SERVER['HTTP_HOST'], FILTER_SANITIZE_STRING))[0];

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
    $cid = htmlspecialchars(trim($_POST['cid']));
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
        
        //header("Location:index_varify.php");
    	if (empty($_SESSION['redirect_after_login'])) {
    header("Location: ../../../views/auth/masters/home.php");
} else {
    $redirect = $_SESSION['redirect_after_login'];
    unset($_SESSION['redirect_after_login']); // Clean up
    header("Location: $redirect");
}
    	exit;
    
    	}else {
    		$msg="Invalid Login Information!!!";
    		// Generate a new CSRF token after a failed login attempt
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    	}
    }
}

//require_once "../../../controllers/routing/login_interface_new.php";
require_once "../../../controllers/routing/login_interface.php";