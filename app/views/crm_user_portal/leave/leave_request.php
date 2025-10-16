<?php
@//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Leave Application';			// Page Name and Page Title
$page="leave_request.php";		// PHP File Name
$input_page="leave_input.php";
$root='leave';

$table='hrm_leave';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='leave_type';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

$$unique = $_GET[$unique];
$res='select a.'.$unique.',leave_type as Leave_Type, date_format(leave_from_date,"%d-%m-%Y") as Form_Date,date_format(leave_to_date,"%d-%m-%Y") as To_date,date_format(leave_join_date,"%d-%m-%Y") as Join_date, CONCAT(b.emptitle," ",b.first_name) as Responsible_By ,leave_status as Leave_Status from '.$table.' a,hrm_personal_information b where a.PBI_ID='.$_SESSION['employee_selected'].' and a.leave_responsibility_name = b.PBI_ID';
$count = @mysqli_num_rows(@db_query($res));
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
    <? if($count==0){include('../../common/report_bar.php');}?>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
          <? 	
		       //  echo $res;
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