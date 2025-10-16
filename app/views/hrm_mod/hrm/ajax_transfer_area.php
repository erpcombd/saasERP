<?php
session_start();
require "../../config/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);

?>
<select name="TRANSFER_PRESENT_AREA" id="TRANSFER_PRESENT_AREA">
<? foreign_relation('area','AREA_CODE','AREA_NAME','',"ZONE_ID='".$data[0]."'");?>
</select>