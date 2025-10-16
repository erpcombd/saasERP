<?php
@session_start();

if(!isset($_SESSION['username']) || $_SESSION['admin_login']!="YES"){

	 session_destroy();
	 
// setcookie('admin_login', 'yes', time() - 3600);
// setcookie('user_id', $row['id'], time() - 3600);
// setcookie('username', $row['username'], time() - 3600);
// setcookie('company_id', $row['company_id'], time() - 3600);
// setcookie('warehouse_id', $row['warehouse_id'], time() - 3600);
// setcookie('level', $row['role'], time() - 3600);	 
	 
	  
	 header("location:index.php");
	
	die("You are not allowed to access this page!");
}




if(isset($_REQUEST['action']) && $_REQUEST['action']=='logout'){
	// echo "YES";
	session_destroy();
	
// setcookie('admin_login', 'yes', time() - 3600);
// setcookie('user_id', $row['id'], time() - 3600);
// setcookie('username', $row['username'], time() - 3600);
// setcookie('company_id', $row['company_id'], time() - 3600);
// setcookie('warehouse_id', $row['warehouse_id'], time() - 3600);
// setcookie('level', $row['role'], time() - 3600);


	header("location:index.php");
}
?>