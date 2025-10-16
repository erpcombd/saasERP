<?php
session_start();
ob_start();
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Assign Lead Contact Person';			// Page Name and Page Title
$page="assign_c_p.php";		// PHP File Name
$input_page="assign_c_p_input.php";
$root='assign_contact_person';


if(isset($_POST['insert'])){




}

$table='crm_assign_cp';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='lead_no';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud      =new crud($table);

echo $$unique = $_GET[$unique];
?>
<script type="text/javascript"> function DoNav(lk){

	return GB_show('ggg', '../pages/<?=$root?>/assign_c_p_input.php?<?=$unique?>='+lk,600,940)
	}</script>

<form action="" method="post">
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
        <div class="">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
          <? 	  $res='select '.$unique.','.$unique.', c.lead_no, p.project_desc,a.PBI_NAME  from '.$table.' c , crm_lead_master m, crm_project p, personnel_basic_info a where c.lead_no=m.lead_no and m.project_id=p.project_id and c.c_person=a.PBI_ID';

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
require_once SERVER_CORE."routing/layout.bottom.php";
?>