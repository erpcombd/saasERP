<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Leave Input Management';			// Page Name and Page Title
$page="leave.php";		// PHP File Name
$input_page="leave_input.php";
$root='hrm';

$table='leave_detail';		// Database Table Name Mainly related to this page
$unique='LEAVE_D_ID';			// Primary Key of this Database table
$shown='LEAVE_YEAR';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];

?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>

<form action="" method="post" enctype="multipart/form-data">
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
          <? 	$res='select '.$unique.',LEAVE_YEAR as Year, LEAVE_CL_AVAIL as CL_Avail, LEAVE_CL_DUE as CL_Due, LEAVE_ML_AVAIL as ML_Avail, LEAVE_MATERNITY as Matel_L, LEAVE_PATERNITY as Pater_L, LEAVE_TRANSFER as Trans_L, LEAVE_LWP as LWP_L from '.$table.' where PBI_ID='.$_SESSION['employee_selected'];
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
require_once SERVER_CORE."routing/layout.bottom.php";
?>