<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Increment Type Information';			// Page Name and Page Title
$page="increment_type.php";		// PHP File Name
$input_page="increment_type_input.php";
$root='setup';
$link="increment_type_input.php";

$table='increment_type';		// Database Table Name Mainly related to this page
$unique='TYPE_CODE';			// Primary Key of this Database table
$shown='INCREMENT_TYPE';				// For a New or Edit Data a must have data field

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
         
				<? echo $res='select '.$unique.','.$unique.', '.$shown.' from '.$table;
											//echo link_report1($res,$link);?>
            
        </div>

    </form>





<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>