<?php
session_start();
include "config/access_admin.php";
include "config/db.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');



$str = $_POST['data'];
$data=explode('##',$str);
?>
<select name="area_id">
<option></option>
<? foreign_relation('area','AREA_CODE','AREA_NAME','',"ZONE_ID='".$data[0]."'");?>
</select>