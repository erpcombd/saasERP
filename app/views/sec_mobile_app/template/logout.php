<?php 
session_start();
include_once('../function/connection.php'); 

//ini_set('display_errors', 1);

/*ob_start();
if($page_name == "invoice_create"){
$blink_class="active";
}*/



// Log out and destroy the session
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy all session data
    header("Location: ../login.php"); // Redirect to the login page after logging out
    exit(); // Stop executing the current script
}


?>