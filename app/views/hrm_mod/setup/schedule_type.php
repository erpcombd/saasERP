<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section ::::: 
$title='Shift  Schedule Setup';			// Page Name and Page Title
$page="schedule_type.php";		// PHP File Name
$input_page="schedule_type_input.php";
$root='setup';
$link="schedule_type_input.php";

$table='hrm_schedule_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='schedule_name';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud    = new crud($table);

$$unique = $_GET[$unique];
do_datatable('grp');
?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show(' ', '<?=SERVER_ROOT?>app/views/hrm_mod/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>


    <form  action="" method="post" enctype="multipart/form-data">
      
        <? include('../common/report_bar.php');?>
        <div class="container-fluid pt-5 p-0 ">
		<?
            $res='select s.id,s.id, s.schedule_name as Shift_name,s.office_start_time as Shift_Time,s.office_end_time as Shift_End_Time, 
			s.office_mid_time as Break_start ,s.sch_type as Shift_Type,s.status,u.group_name from hrm_schedule_info s, user_group u 
			where u.id=s.group_for
			';
            echo link_report1($res,$link);?>

        </div>

    </form>


<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
