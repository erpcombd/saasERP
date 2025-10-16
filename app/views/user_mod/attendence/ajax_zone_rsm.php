<?php
//
require "../../config/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);
?>

<select name="zone" id="zone" >
<? foreign_relation('zon', 'ZONE_CODE', 'ZONE_NAME',$_POST['zone'],' 1 and REGION_ID="'.$data[0].'"')?>
</select>
