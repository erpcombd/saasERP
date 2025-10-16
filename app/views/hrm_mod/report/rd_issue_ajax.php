<?php
session_start();
require "../../config/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$PBI_ID = $data[0];
$info= $data[1];

$infos=explode('#>',$info);
$mobile = $infos[0];
$sim = $infos[1];
$sql = 'update personnel_basic_info set PBI_MOBILE="'.$mobile.'",PBI_INTERNET="'.$sim.'" where PBI_ID='.$PBI_ID;
db_query($sql);
echo 'Updated!';
?>