<?php
session_start();
require_once "../../../assets/support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);

?>
<select name="zone_id" id="zone_id" onchange="getData2('ajax_area.php', 'area',this.value,this.value);">
<option></option>
<? foreign_relation('zon','ZONE_CODE','ZONE_NAME','',"REGION_ID='".$data[0]."'");?>
</select>