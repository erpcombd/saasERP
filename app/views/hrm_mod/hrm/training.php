<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Training Entry Management';			// Page Name and Page Title
$page="training.php";		// PHP File Name
$input_page="training_input.php";
$root='hrm';
$link="training_input.php";

$table='training_detail';		// Database Table Name Mainly related to this page
$unique='TRAINING_D_ID';			// Primary Key of this Database table
$shown='TRAINING_NAME';				// For a New or Edit Data a must have data field

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
				<?  
        if($_SESSION['employee_selected']>0)	 $employee_selected=$_SESSION['employee_selected'];
        else $employee_selected=0;
        
        $res='select '.$unique.',TRAINING_NAME as Training_Name, TRAINING_SPONSOR_ORGANIZATION as Sponsor_Organization,TRAINING_LENGTH as Training_Length from '.$table.' where PBI_ID='.$employee_selected .'';
			echo link_report1($res,$link);?>
          

        </div>

    </form>




<?php /*?>
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
          <? 	$res='select '.$unique.',TRAINING_NAME as Training_Name, TRAINING_SPONSOR_ORGANIZATION as Sponsor_Organization,TRAINING_LENGTH from '.$table.' where PBI_ID='.$_SESSION['employee_selected'];
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