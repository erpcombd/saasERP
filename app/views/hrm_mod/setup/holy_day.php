<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
		  $title='Calendar';			// Page Name and Page Title
$page="holy_day.php";		// PHP File Name
$input_page="holy_day_input.php";
$root='setup';
$link="holy_day_input.php";

$table='salary_holy_day';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='holy_day';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::
 $start_date=date('Y-01-01');
 $till_date=date('Y-12-31');

$crud      =new crud($table);

$$unique = $_GET[$unique];
do_datatable('grp');
?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show(' ', '<?=SERVER_ROOT?>app/views/hrm_mod/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>


 <form action="" method="post" enctype="multipart/form-data">
    <?php include('../common/report_bar.php'); ?>
    <div class="container-fluid pt-5 p-0 ">
        <?php
$res = 'SELECT h.' . $unique . ', h.holy_day, h.reason AS event_name, j.job_location_name FROM ' . $table . ' h, job_location_type j WHERE j.id=h.job_loc_id and h.holy_day between "'.$start_date.'" and "'.$till_date.'" ';

echo link_report1($res, $link);
?>

    </div>
</form>




<?php /*?><form action="" method="post">
<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
    <? include('../common/report_bar.php');?>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
          <? 	 $res='select '.$unique.', holy_day,reason from '.$table.' order by holy_day desc';
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
</form><?php */?>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>