<?php
session_start();
require "../../config/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);
?>
<select name="TRANSFER_PRESENT_ZONE" id="TRANSFER_PRESENT_ZONE" onchange="getData2('ajax_transfer_area.php', 'area',this.value,this.value);">
<? foreign_relation('zon','ZONE_CODE','ZONE_NAME','',"REGION_ID='".$data[0]."'");?>
</select>