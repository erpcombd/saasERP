<?

session_start ();



require_once "../../../controllers/core/inc.login.php";


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_AUTH."db_con_live_static.php";





$_GET['module_id']=23;

if($_POST['qr_input']>0)

{

	$qr_input 	= $_POST['qr_input'];

	$qr_code = $_SESSION['user']['qr_code'];

	if($qr_code==$qr_input)

	{

	    $sql = "update user_activity_management set qr_code='0' where id=".$_SESSION['user']['id'] ;

	    db_query($sql);

	    $_SESSION['Authorized']	='Yes';

	    $_SESSION['mhafuz']    ='Active';

	    header("Location:home.php");

	  

	}

	else

	{

	session_destroy();

	header("Location:index.php");

	}

}

require_once "../../../controllers/routing/login_interface_otp.php";
?>