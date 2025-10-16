<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Employee Level Information';			// Page Name and Page Title
$page="level_type.php";		// PHP File Name
$input_page="level_type_input.php";
$root='setup';
$link="level_type_input.php";

$table='hrm_level';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='level_name';				// For a New or Edit Data a must have data field
do_datatable('grp');
// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];

?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('  ', '<?=SERVER_ROOT?>app/views/hrm_mod/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>


<form  action="" method="post">
        <? include('../common/report_bar.php');?>
        <div class="container-fluid pt-5 p-0 ">
		
		
		<? 	// $res='select '.$unique.','.$shown.' as level_name from '.$table;
	 	$res='select l.id,l.level_name as level_name,c.class_name from hrm_level l,hrm_class c where l.class_id=c.id';
											echo link_report1($res,$link);?>
		
		
        </div>

    </form>








<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>