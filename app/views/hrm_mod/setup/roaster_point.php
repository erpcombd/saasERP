<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Shift Schedule Point';			// Page Name and Page Title
$page="roaster_point.php";		// PHP File Name
$input_page="roaster_point_input.php";
$root='setup';
$link="roaster_point_input.php";

$table='hrm_roster_point';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='point_short_name';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];
do_datatable('grp');
?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '<?=SERVER_ROOT?>app/views/hrm_mod/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>




    <form  action="" method="post" enctype="multipart/form-data">
      
        <? include('../common/report_bar.php');?>
        <div class="container-fluid pt-5 p-0 ">
				 <? 	$res='select a.id,a.id, a.point_short_name, b.LOCATION_NAME,u.group_name,a.latitude_point,a.longitude_point
				 from hrm_roster_point a, office_location b, user_group u where u.id=b.GROUP_ID and a.job_location=b.ID';
											echo link_report1($res,$link);?>
            

        </div>

    </form>





<?php /*?><form action="?" method="post">
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
          <? 	$res='select a.id,a.id, a.point_short_name, b.LOCATION_NAME,u.group_name from hrm_roster_point a, office_location b, user_group u where u.id=b.GROUP_ID and a.job_location=b.ID';
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