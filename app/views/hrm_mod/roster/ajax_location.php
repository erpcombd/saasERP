<?php
session_start();
require "../../config/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$str = $_POST['data'];
$data=explode('##',$str);
?>

<select name="job_location" id="job_location" >
<? foreign_relation('office_location', 'ID', 'LOCATION_NAME',$_POST['job_location'],' 1 and GROUP_ID="'.$data[0].'" and ID not in(1,16,87)')?>
</select>