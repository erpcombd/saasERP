<?php

 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
 

// ::::: Edit This Section ::::: 
$title='Daily Task Entry';			// Page Name and Page Title
$page="task_entry.php";		// PHP File Name
$input_page="task_entry_input.php";
$root='communication';

$table='crm_comunication';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='c_reason';				// For a New or Edit Data a must have data field
// ::::: End Edit Section :::::



$crud      =new crud($table);

$$unique = $_GET[$unique];

?>
<script type="text/javascript"> function DoNav(lk){

	return GB_show('ggg', '../../crm_mod/pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}</script>

<form action="" method="post">
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
		  
		  <? $access = find_a_field('crm_roll_assign','comm_create','PBI_ID="'.$_SESSION['srrr'].'"') ;  ?>
		  
		  
    <? include('../common/report_bar.php');?>
	
	
	
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
		  
		 
		  
          <? 	  $res='select c.id,c.contact_person,cc.organization, c.overcome as service,c.c_time as contact_time, c.c_date as contact_date,c_reason from crm_comunication c,crm_customer_info cc where 1 and cc.dealer_code=c.customer_name and c.entry_by="'.$_SESSION['employee_selected'].'" order by c.id desc ';
											//echo $crud->link_report($res,$link);?>
											<table id="example" class="display nowrap table" style="width:100%">
        <thead style="background: #1ABB9C;">
            <tr><th>Feedback</th><th>Contact Person</th><th>Organization</th><th>Contact Time</th><th>Contact Date</th>
			<? 
			
			$access = find_a_field('crm_roll_assign','comm_edit','PBI_ID="'.$_SESSION['srrr'].'"') ; 
			
			
			?>
			
			<th>Action</th>
		
			
			</tr>
        </thead>
        <tbody>
           <?
		$query = db_query($res);
		while($rows = mysqli_fetch_object($query)){
		?>
		<tr>
		
		<td><?=$rows->service?></td>
		<td><?=$rows->contact_person?></td>
		<td><?=$rows->organization?></td>
		<td><?=$rows->contact_time?></td>
		<td><?=$rows->contact_date?></td>
		<td>
		
		
		
		 <button type="button" class="btn btn-warning btn-xs" onclick="DoNav(<?=$rows->id?>);"><i class="fa fa-edit"></i></button>
	
		<? $file_exist =  file_exists('../../../../crm_com_file/'.$rows->com_id.'.pdf'); if($file_exist==1){ ?><a href="../../../../crm_com_file/<?=$rows->com_id?>.pdf" target="_blank"><button type="button" class="btn btn-xs btn-success"><i class="fa fa-eye" aria-hidden="true"></i></button></a><? } ?>
		</td>
		</tr>

		<? } ?>

        </tbody>
        <tfoot>
            <tr><th>Feedback</th><th>Contact Person</th><th>Customer</th><th>Contact Time</th><th>Contact Date</th><th>Action</th></tr>
        </tfoot>
    </table>
											
											
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