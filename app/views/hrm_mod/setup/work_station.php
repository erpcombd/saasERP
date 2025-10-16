<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Work Station Setup';			// Page Name and Page Title
$page="work_station.php";		// PHP File Name
$input_page="work_station_input.php";
$root='setup';
$link="work_station_input.php";

$table='hrm_workstation';		// Database Table Name Mainly related to this page
$unique='station_id';			// Primary Key of this Database table
$shown='work_station_name';				// For a New or Edit Data a must have data field
do_datatable('grp');
// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];

?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show(' ', '<?=SERVER_ROOT?>app/views/hrm_mod/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>


<form  action="" method="post">
        <? include('../common/report_bar.php');?>
        <div class="container-fluid pt-5 p-0 ">
		
		
		<? 	 $res='select '.$unique.','.$shown.' as work_station_name from '.$table;
											echo link_report1($res,$link);?>
		
		
        </div>

    </form>








<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>