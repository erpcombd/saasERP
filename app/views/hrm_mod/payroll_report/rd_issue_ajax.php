<?php
session_start();
require "../../config/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$mobile_no= $data[1];
$PBI_ID = $data[0];

$sql = 'update personnel_basic_info set PBI_MOBILE="'.$mobile_no.'" where PBI_ID='.$PBI_ID;
db_query($sql);
echo 'Updated!';
?>