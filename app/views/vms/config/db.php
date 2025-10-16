<?php
date_default_timezone_set('Asia/Dhaka');
$servername = "localhost";
$username = "ezzyerp_clouduser23";
$password = "cloudpass224423";
$dbname = "ezzyerp_saas_masterdb";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

mysqli_query($conn, "SET SESSION sql_mode = 'TRADITIONAL'");
?>