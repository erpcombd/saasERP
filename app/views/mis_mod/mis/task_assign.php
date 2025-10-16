<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Start Edit Section ::::: 
$title='Task Information';			// Page Name and Page Title
$page="task_assign.php";			// PHP File Name
$input_page="task_assign_input.php";
$root='mis';

$table='mis_task';					// Database Table Name Mainly related to this page
$unique='id';						// Primary Key of this Database table
$shown='task_details';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::



$crud      =new crud($table);
$target_url = 'task_assign_input.php';
$$unique = $_GET[$unique];
?>
<script language="javascript">
function DoNav(theUrl)
{
	window.location.assign('<?=$target_url?>?<?=$unique?>='+theUrl);
}
</script>

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
    <? include('../../common/report_bar_a.php');?>
<div class="oe_form_sheetbg">
        <h1 style="color:green; text-align:center">Pending Task List</h1>
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
          <? 	 
		  $res='
		  select 
			  a.id, 
			  a.id as ticket_no, 
			  c.warehouse_name as location, 
			  d.module_name as module, 
			  e.task_type, 
			  b.priority, 
			  a.task_details as details,
			  a.task_status as remarks
		  from 
			  mis_task a, 
			  mis_task_priority b,
			  warehouse c, 
			  mis_module_info d,
			  mis_task_type e 
		  
		  where 
			  b.id=a.task_priority and 
			  d.id=a.module and 
			  c.warehouse_id=a.location and
			  e.id=a.task_type and
			  a.task_status="Pending" order by a.id desc
			 ';
		  
				echo $crud->link_report($res,$link);?>
          </div></div>
          </div>
    </div>
	
	
	<div class="oe_form_sheetbg">
	<h1 style="color:green; text-align:center">Processing Task List</h1>
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
          <? 	 
		  $res='
		  select 
			  a.id, 
			  a.id as ticket_no, 
			  c.warehouse_name as location, 
			  d.module_name as module, 
			  e.task_type, 
			  b.priority, 
			  a.task_details as details,
			  a.task_status as remarks,
			  a.solve_date as assign_date,
			  f.fname as solve_by	  
		  from 
			  mis_task a, 
			  mis_task_priority b,
			  warehouse c, 
			  mis_module_info d,
			  mis_task_type e,
			  user_activity_management f 
		  
		  where 
			  b.id=a.task_priority and 
			  d.id=a.module and 
			  c.warehouse_id=a.location and
			  a.solved_by=f.user_id and
			  e.id=a.task_type and
			  a.task_status="Processing" order by a.id desc limit 0,6 
			 ';
		  
				echo $crud->link_report($res,$link);?>
          </div></div>
          </div>
    </div>
	
	
	
	
	<div class="oe_form_sheetbg">
	<h1 style="color:green; text-align:center">Done Task List</h1>
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
          <? 	 
		  $res='
		  select 
			  a.id, 
			  a.id as ticket_no, 
			  c.warehouse_name as location, 
			  d.module_name as module, 
			  e.task_type, 
			  b.priority, 
			  a.task_details as details,
			  a.task_status as remarks	  
		  from 
			  mis_task a, 
			  mis_task_priority b,
			  warehouse c, 
			  mis_module_info d,
			  mis_task_type e 
		  
		  where 
			  b.id=a.task_priority and 
			  d.id=a.module and 
			  c.warehouse_id=a.location and
			  e.id=a.task_type and
			  a.task_status="Complete" order by a.id desc limit 0,6
			 ';
		  
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