
<?php

session_start();
//

require_once "../../../controllers/routing/default_values.php";
// require_once(SERVER_CORE.core/init.php);
require_once(SERVER_CORE . "core/init.php");
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Shift  Schedule Setup';			// Page Name and Page Title
$page="schedule_type.php";		// PHP File Name
$input_page="schedule_type_input.php";
$root='setup';

$table='hrm_schedule_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='schedule_name';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];
do_datatable('grp');
?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../../hrm_mod/pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>








    <form  action="" method="post" enctype="multipart/form-data">
      
        <? include('../common/report_bar.php');?>
        <div class="container-fluid pt-5 p-0 ">
		<?
            //		   $res='select '.$unique.','.$unique.', '.$shown.',
            //		  (
            //    CASE
            //        WHEN off_day = "1" THEN "Monday"
            //        WHEN off_day = "2" THEN "Tuesday"
            //        WHEN off_day = "3" THEN "Wednesday"
            //        WHEN off_day = "4" THEN "Thursday"
            //        WHEN off_day = "5" THEN "Friday"
            //        WHEN off_day = "6" THEN "Saturday"
            //        WHEN off_day = "7" THEN "Sunday"
            //        ELSE 1
            //    END) as off_day,office_start_time,office_end_time,status,tolerance_time from '.$table;

            $res='select s.id,s.id, s.schedule_name as Shift_name,s.office_start_time,s.office_end_time,s.min_in,s.max_out,s.sch_type,s.status,u.group_name from hrm_schedule_info s, user_group u 
			where u.id=s.group_for
			';
            echo link_report1($res,$link);?>

        </div>

    </form>



<?php/*>
<form action="" method="post">
<div class="oe_view_manager oe_view_manager_current">
        
    <? //include('../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form">
                    <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
    <? include('../common/report_bar.php');?>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list">
              <div  class="oe_list oe_view">
           <? 
//		   $res='select '.$unique.','.$unique.', '.$shown.',
//		  (
//    CASE 
//        WHEN off_day = "1" THEN "Monday"
//        WHEN off_day = "2" THEN "Tuesday"
//        WHEN off_day = "3" THEN "Wednesday"
//        WHEN off_day = "4" THEN "Thursday"
//        WHEN off_day = "5" THEN "Friday"
//        WHEN off_day = "6" THEN "Saturday"
//        WHEN off_day = "7" THEN "Sunday"
//        ELSE 1
//    END) as off_day,office_start_time,office_end_time,status,tolerance_time from '.$table;
		  $res='select s.id,s.id, s.schedule_name,
		  
    s.office_start_time,s.office_end_time,s.min_in,s.max_out,s.status,u.group_name from hrm_schedule_info s, user_group u ';
											echo $crud->link_report($res,$link);?>
          </div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
    </div>
</form>

<*/?>




<?

$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";

?>
