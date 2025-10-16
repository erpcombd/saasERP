<?php
error_reporting(E_ALL);
session_start();

include '../config/db.php';
include '../config/function.php';

$out_date = date("Y-m-d");
$out_time = date("Y-m-d H:i:s");

$visitor_id = $_REQUEST['visitor_id'];

$sql = 'UPDATE visitor_table 
SET visitor_out_date = "'.$out_date.'", visitor_out_time = "'.$out_time.'" , visitor_status= "Out"
WHERE visitor_id ="'.$visitor_id.'" ';



mysqli_query($conn, $sql);

echo 'Done';

?>