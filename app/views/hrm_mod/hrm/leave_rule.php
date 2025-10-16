<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Leave Rule';			// Page Name and Page Title
$page="leave_rule.php";		// PHP File Name
$input_page="leave_rule_input.php";
$root='hrm';

$table='hrm_lv_in';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='PBI_ID';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];
do_datatable('grp');
?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show(' ', '<?=SERVER_ROOT?>app/views/hrm_mod/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>




<form  action="" method="post" enctype="multipart/form-data">
        <? include('../common/title_bar.php');?>
        <? include('../common/report_bar.php');?>
        <div class="container-fluid pt-5 p-0 ">
           
			
			  <? 	echo $res='select a.id, a.PBI_ID as Employee_ID, a.CL as Casual_Leave,a.MED as Sick_Leave, a.ANU as Annual_Leave, a.MTR as Maternity_Leave,
            a.ML as Marriage_Leave, a.PL as Paternity_Leave, a.HL as Hajj_Leave, a.effective_year
            
            from hrm_lv_in a where a.PBI_ID='.$_SESSION['employee_selected'];
            echo link_report1($res,$link);?>
			

        </div>



    </form>




<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>