<?php
//
//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Apply For Outside Duty';

$table_master='cons_budget_master';

$unique_master='budg_id	';

$table_detail='cons_budget_details';

$unique_detail='id';

$table_chalan='';

$unique_chalan='id';

$$unique_master=$_POST[$unique_master];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		$crud   = new crud($table_chalan);
		$crud->delete_all($condition);
		unset($$unique_master);
		unset($_POST[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}

if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['status']='PROCESSING';
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		unset($$unique_master);
		unset($_POST[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}
auto_complete_from_db('cons_project','project_name','id','1','project');
?>
	<script type="text/javascript"> function DoNav(lk){
		return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
		}</script>
	

	<div class="oe_view_manager oe_view_manager_current">
			
		<? include('../../common/title_bar.php');?>
			<div class="oe_view_manager_body">

					<div class="oe_view_manager_view_form">
                    <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

			<div class="oe_form_container"><div class="oe_form">
			  <div class="">
		<? include('../../common/report_bar.php');?>
	<div class="oe_form_sheetbg">
			<div class="oe_form_sheet oe_form_sheet_width">
	
			  <div  class="oe_view_manager_view_list">
              <div  class="oe_list oe_view">
			  <form action="od_request_input.php" method="post" name="codz" id="codz">

<table border="0" align="center" style="width:100%;height:100%">
  <tr>

    <td align="center" bgcolor="#FF9966" style="padding:3%;color:white;font-size:16px;"><strong>Select OD Type: </strong></td>

    <td bgcolor="#FF9966" style="padding-top:3%">
	<strong>
	<select name="project" id="project" required >
	<option>Select OD Type</option>
	<option>Market Visit</option>
	<option>Client Visit</option>
	<option>Project Visit</option>
	
                   </select>
    </strong>
	</td>
<tr>
<td bgcolor="#FF9966" style="width:200px;"></td>
 <td  bgcolor="#FF9966" style="padding-top:1%;padding-bottom:2%;">
 <strong><input type="submit" name="submitit" id="submitit" value="Apply" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/></strong></td>
</tr>
  </tr>

</table>

</form>
			  </div>
              </div>
			  </div>
		</div>
		
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>

	<?
	//
	//
	require_once SERVER_CORE."routing/layout.bottom.php";
	?></p>