<?php
session_start();
ob_start();
require "../../config/inc.all.php";

// ::::: Edit This Section ::::: 
$title='Cycle/Motor Cycle input form';			// Page Name and Page Title
$page="motor_cycle.php";		// PHP File Name
$input_page="motor_cycle_input.php";
$root='hrm';

$table='motor_cycle_detail';		// Database Table Name Mainly related to this page
$unique='MOTOR_CYCLE_D_CODE';			// Primary Key of this Database table
$shown='MC_RECEIVED_DATE';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];

?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>

<form action="" method="post" enctype="multipart/form-data">
<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../../common/title_bar.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
    <? include('../../common/report_bar.php');?>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
          <? 	$res='select '.$unique.',MC_RECEIVED_DATE as Date, MC_COMPANY as Company_Name, MC_MODEL as Model, MC_CC as CC, MC_TOTAL_PRICE as Total_Price from '.$table.' where PBI_ID='.$_SESSION['employee_selected'];
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
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>