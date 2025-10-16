<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

$str = $_POST['data'];

$data=explode('##',$str);

?>

<select name="area_id" id="area_id">

<option></option>

<? foreign_relation('area','AREA_CODE','AREA_NAME','',"ZONE_ID='".$data[0]."'");?>

</select>