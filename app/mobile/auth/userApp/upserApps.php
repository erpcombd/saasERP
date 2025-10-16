<? 
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once "../../../controllers/core/inc.login.php";
$cid='saaserp';
//$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
//$cid = explode('.', filter_var($_SERVER['HTTP_HOST'], FILTER_SANITIZE_STRING))[0];

// Generate CSRF token (if not set)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$msg = ""; // Default message variable

if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
        // Check CSRF token validity
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) 
        {
            $msg = "Security check failed. Please try again.";
        }
        else{
        
    // Sanitize user input
    $cid = htmlspecialchars(trim($_POST['cid']));
    $uid = htmlspecialchars(trim($_POST['uid']));
    $password = trim($_POST['pass']);
    
    // Hash password using a stronger method
    //$hashed_password = hash('sha256', $password); 
	//$hashed_password 	= auth_encode($password);
	$hashed_password 	= md5($password);
        
        	if(check_for_login($cid,$uid,$hashed_password,1)){
  //header("Location:index_varify.php");
          
echo "<script>
    sessionStorage.setItem('username', '" . $_POST['uid'] . "');
    sessionStorage.setItem('password', '" . $_POST['pass'] . "');
    
</script>";

// die();
        
echo "<script>
    window.location.href = '../../../mobile/EmployeePortal/main/home.php';
</script>";

        
    //echo "<script></script>";
        
        
        //header("Location:https://saaserp.erpengine.cloud/app/mobile/auth/userApp/upserApps.php");
        
        exit;
        
        }else {
        	session_destroy();
        	$msg="Invalid Login Information!!!";
        }
    }
}



require_once "../../../controllers/routing/login_interface.php";
?>