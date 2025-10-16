<?php
error_reporting(0);

date_default_timezone_set('Asia/Dhaka');

$servername = "localhost";

// $username = "clouderp_clouduser23";
// $password = "cloudpass224423";
// $dbname = "clouderp_nfr_masterdb";


$username = "mepgroup_uall";
$password = "Hs5V%*)wwwNI";
$dbname = "mepgroup_demodb";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



define("DEVELOPER", "ERP.COM.BD");
?>