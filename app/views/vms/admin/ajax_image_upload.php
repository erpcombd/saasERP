<?php
session_start ();
//include ("../config/access_admin.php");
//include ("../config/db.php");
//include '../config/function.php';


// new filename
$filename = $_SESSION['filename'];

    // Image upload
    $url = '';
    if( move_uploaded_file($_FILES['webcam']['tmp_name'],'visitor_image/'.$filename) ){
    	$url = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/visitor_image/' . $filename;
    }
    // Return image url
    echo $url;
    
?>