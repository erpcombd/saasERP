<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Daily Progress Entry';			// Page Name and Page Title
$page="daily_task.php";		// PHP File Name
$input_page="daily_task_input.php";
$root='attendence';
$link ="daily_task_input.php";

$table='daily_progress';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='task';				// For a New or Edit Data a must have data field

do_datatable('grp');
// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];

?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show(' ', '<?SERVER_ROOT?>app/views/hrm_mod/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>







<form  action="" method="post" enctype="multipart/form-data">
        <? include('../common/title_bar.php');?>
        <? include('../common/report_bar.php');?>
        <div class="container-fluid pt-5 p-0 ">

           <? $res='select p.id,proj.PROJECT_NAME,m.module_name,f.feature_name,p.task,p.request_by,p.request_date,p.status from daily_progress p left join user_module_manage m on m.id=p.module_id left join user_feature_manage f on f.id=p.feature_id left join project proj on proj.PROJECT_ID=p.project where p.entry_by="'.$_SESSION['employee_selected'].'"';
			echo link_report1($res,$link);?>

        </div>

    </form>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>