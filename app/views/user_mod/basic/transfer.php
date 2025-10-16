<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Transfer Management';			// Page Name and Page Title
$page="transfer.php";		// PHP File Name
$input_page="transfer_input.php";
$root='hrm';

$table='transfer_detail';		// Database Table Name Mainly related to this page
$unique='TRANSFER_D_ID';			// Primary Key of this Database table
$shown='TRANSFER_ORDER_NO';				// For a New or Edit Data a must have data field

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
          <? 	$res='select '.$unique.',a.TRANSFER_ORDER_NO as Order_no,a.TRANSFER_AFFECT_DATE as Order_date, a.TRANSFER_PRESENT_DEPT as Dept, (select region_name from region where region_id=a.TRANSFER_PRESENT_REGION) as region ,a.TRANSFER_PRESENT_BRANCH as Branch, a.TRANSFER_PRESENT_ZONE as zone, a.TRANSFER_PRESENT_AREA as Area, a.TRANSFER_PRESENT_DOMAIN as Domain, a.TRANSFER_PRESENT_PROJECT as project from '.$table.' a where a.PBI_ID='.$_SESSION['employee_selected'].'  order by a.TRANSFER_AFFECT_DATE desc';
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
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>