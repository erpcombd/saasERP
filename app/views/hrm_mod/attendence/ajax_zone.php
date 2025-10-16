<?php
session_start();
require "../../config/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);
?>

<select required name="PBI_ZONE" id="PBI_ZONE" >
<? foreign_relation('zon', 'ZONE_CODE', 'ZONE_NAME',$_POST['PBI_ZONE'],' 1 and REGION_ID="'.$data[0].'"')?>
</select>
