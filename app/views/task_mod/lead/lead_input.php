<?php
session_start();

 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Lead Information';			// Page Name and Page Title
$page="lead.php";		// PHP File Name
$input_page="lead_input.php";
$root='lead';

$table='crm_lead_master';		// Database Table Name Mainly related to this page
$unique='lead_no';			// Primary Key of this Database table
$shown='lead_no';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::


$crud=new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		


$now				= time();
$_POST['entry_by'] = $_SESSION['employee_selected'];

$service_array = $_POST['service_id'];
$amount_array = $_POST['amount'];

$crud->insert();
$type=1;
$_POST['lead_no'] = find_a_field('crm_lead_master','max(lead_no)',' 1 ');

for($i=0;$i<count($_POST['service_id']);$i++){

if($service_array[$i]>0){

$insert = 'insert into crm_lead_service_detail set lead_no="'.$_POST['lead_no'].'",service_id="'.$service_array[$i].'",amount="'.$amount_array[$i].'",entry_by="'.$_SESSION['srrr'].'"';
db_query($insert);
}


}






$msg='New Entry Successfully Inserted.';

if(isset($_POST['insert']))
{

echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
}
unset($_POST);
unset($$unique);


}


//for Modify..................................

if(isset($_POST['update']))
{



$delete = 'delete from crm_lead_service_detail where lead_no="'.$_POST['lead_no'].'"';
db_query($delete);

$service_array = $_POST['service_id'];
$amount_array = $_POST['amount'];
for($i=0;$i<count($_POST['service_id']);$i++){

if($service_array[$i]>0){

 $insert = 'insert into crm_lead_service_detail set lead_no="'.$_POST['lead_no'].'",service_id="'.$service_array[$i].'",amount="'.$amount_array[$i].'",entry_by="'.$_SESSION['srrr'].'"';
db_query($insert);
}


}

$_POST['update_at'] = date("Y-m-d h:i:s");
$_POST['update_by'] = $_SESSION['employee_selected'];
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
			echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/'.$page.'";</script>';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
		$type=1;
		$msg='Successfully Deleted.';
}
}

if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}
//if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
<html style="height: 100%;"><head>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">
        <link href="../../../assets/css/css.css" rel="stylesheet">
		<link rel="stylesheet" href="bootstrap-select.min.css">
		<link rel="stylesheet" href="bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		
		<style>
		
		.inner .open{
		
		height: 200px !important;
		}
		
		.bootstrap-select>.dropdown-toggle{
		
		border-radius: 0px; width: 200px;
		}
		</style>
		
		</head>
<body>
        <!--[if lte IE 8]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
        <script>CFInstall.check({mode: "overlay"});</script>
        <![endif]-->
       <form action="" method="post"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none; z-index: 1002; position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */ left: 16px; top: 21px;" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">
          <? include('../../common/title_bar_popup.php');?>
      <div style="display: block; max-height: 464px; overflow-y: auto; width: auto; min-height: 82px; height: auto;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">

            <div style="width:100%" class="oe_popup_form">
              <div class="oe_formview oe_view oe_form_editable" style="opacity: 1;">
                <div class="oe_form_buttons"></div>
                <div class="oe_form_sidebar" style="display: none;"></div>
                <div class="oe_form_container">
                  <div class="oe_form">
                    <div class="">
                      <? include('../../common/input_bar.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table width="261" height="396" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                
                <tr class="oe_form_group_row">
   <td width="18%" height="33" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Lead No :</td>
                  <td  width="82" colspan="3" class="oe_form_group_cell oe_form_group_cell_label">
                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                  <input  type="text" id="type" value="<?=$$unique?>" readonly="" style="height: 30px;" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Title</td>
                  <td height="33" colspan="3" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label"><input type="text" value="<?=$lead_title?>" name="lead_title" style="width: 93%; height: 30px;"></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td height="33" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp; Description</td>
                  <td height="33" colspan="3" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label"><textarea style="width: 93%; height: 70px;" name="descript" id="descript"><?=$descript?></textarea></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Location</td>
                  <td height="33" colspan="3" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">
				  <textarea style="width: 93%; height: 40px;" name="address" id="address"><?=$address?></textarea>				  </td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td height="33" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Remarks</td>
                  <td height="33" colspan="3" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label"><textarea type="text" name="remarks" id="remarks" style="width: 93%; height: 70px"><?=$remarks?></textarea>                  </td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Lead  Type </td>
                  <td bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">
				  
				  <select name="lead_type" id="lead_type"  style="height: 30px; width: 200px;">
				  
				  <option value=""></option>
				  <? foreign_relation('crm_type_of_lead','id','type',$lead_type,' 1 ')?>
				  </select>				  </td>
                  <td bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">Customer</td>
                  <td height="33" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">
				  
				  <select name="project_id" id="project_id"  style="height: 30px; width: 200px;"  class="selectpicker" data-live-search="true">
				  
				  <option></option>
				  <? foreign_relation('crm_project','PROJECT_ID','PROJECT_DESC',$project_id,' 1 ')?>
				  </select>				  </td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Status </td>
                  <td bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">
				  
				  <select name="lead_status" id="lead_status"  style="height: 30px; width: 200px;">
				  
				  <option></option>
				  <? foreign_relation('crm_lead_status','id','status',$lead_status,' 1 ')?>
				  </select>				  </td>
                  <td height="33" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Value</td>
                  <td bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label"><input type="number" value="<?=$lead_value?>" name="lead_value"  style="height: 30px;">                  </td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Sales Person </td>
                  <td height="33" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">
				  
				  <?
				   $selects = 'select p.*,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as PBI_DEPARTMENT ,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as PBI_DESIGNATION  from personnel_basic_info p where p.PBI_ID="'.$PBI_ID.'"';
				   $querys = db_query($selects);
				   $rows = mysqli_fetch_object($querys);
				   
				  
				  ?>
				  
				  <select name="PBI_ID" id="PBI_ID"  style="height: 30px;"  class="selectpicker" data-live-search="true">
                      <option value="<?=$PBI_ID?>"><?=$rows->PBI_NAME?> | <?=$rows->PBI_DEPARTMENT?> | <?=$rows->PBI_DESIGNATION?></option>
					  <option value="">&emsp;</option>
					  <?
					  $select = 'select p.*,(select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as PBI_DEPARTMENT ,(select DESG_DESC from designation where DESG_ID=p.PBI_DESIGNATION) as PBI_DESIGNATION  from personnel_basic_info p, crm_roll_assign r where p.PBI_ID=r.PBI_ID and r.access="1"';
					  $query = db_query($select);
					  while($row = mysqli_fetch_object($query)){
					  ?>
					  <option value="<?=$row->PBI_ID?>"><?=$row->PBI_NAME?> | <?=$row->PBI_DEPARTMENT?> | <?=$row->PBI_DESIGNATION?></option>
					  <? } ?>
                      <? //foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$PBI_ID,' 1 ')?>
                    </select>                  </td>
                  <td height="33" bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td bgcolor="#E8E8E8"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                </tr>
                
                
                <tr class="oe_form_group_row">
                  <td height="33"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td height="33"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td height="33"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td height="33"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                </tr>
				<tr>
				<td>&nbsp;</td>
				<td style="background:#CCCCCC;padding: 5px; text-align:center">Select Service  <? if($lead_status==3){ ?> & Value <? } ?></td>
				</tr>
                <tr class="oe_form_group_row">
                  
				  
				<td>&nbsp;</td>
				  <td height="33"   class="oe_form_group_cell oe_form_group_cell_label" bgcolor="#F0F0F0" style=" color: #000000; padding-top: 8px">
				  
				  <?
				  $select1 = 'select * from crm_lead_service_detail where lead_no="'.$$unique.'"';
				  $query1 = db_query($select1);
				  while($row1 = mysqli_fetch_object($query1) ){
				  
				  ?>
				  
				  
				  
				   <select name="service_id[]" id="service_id"  style="height: 30px;" class="selectpicker" data-live-search="true">
					<option value="<?=$row1->service_id?>"><?=find_a_field('crm_service','service_name','service_id="'.$row1->service_id.'"')?></option>
					<option value="">&emsp;</option>
					  <? 
					  $selects = ' select service_id , service_name,amount from crm_service where 1';
					  $query = db_query($selects);
					  while($rowss = mysqli_fetch_object($query)){
					  ?>
					  
					  <option value="<?=$rowss->service_id?>"><?=$rowss->service_name?></option>
					  <? } ?>
                    </select>
				   <? if($lead_status==3){ ?>
				  
				  <input type="text" style="height: 35px;" name="amount[]" placeholder="Value" value="<?=$row1->amount?>" >
				  <? } ?>
				  
				  <br><br>
				  
				  <? } ?>
				  
                    <select name="service_id[]" id="service_id"  style="height: 30px;" class="selectpicker" data-live-search="true">
					<option value="">&emsp;</option>
					  <? 
					  $selects = ' select service_id , service_name from crm_service where 1';
					  $query = db_query($selects);
					  while($rowss = mysqli_fetch_object($query)){
					  ?>
					  
					  <option value="<?=$rowss->service_id?>"><?=$rowss->service_name?></option>
					  <? } ?>
                    </select>
					 <? if($lead_status==3){ ?>
				  <input type="text" style="height: 35px;" name="amount[]" placeholder="Value" value="<?=$amount?>" >
					<? } ?>
					<br><br>
					<select name="service_id[]" id="service_id"  style="height: 30px;" class="selectpicker" data-live-search="true">
					<option value="">&emsp;</option>
					  <? 
					  $selects = ' select service_id , service_name from crm_service where 1';
					  $query = db_query($selects);
					  while($rowss = mysqli_fetch_object($query)){
					  ?>
					  
					  <option value="<?=$rowss->service_id?>"><?=$rowss->service_name?></option>
					  <? } ?>
                    </select>
					 <? if($lead_status==3){ ?>
				  <input type="text" style="height: 35px;" name="amount[]" placeholder="Value" value="<?=$amount?>" >
					<? } ?>
					<br><br>
					<select name="service_id[]" id="service_id"  style="height: 30px;" class="selectpicker" data-live-search="true">
					<option value="">&emsp;</option>
					  <? 
					  $selects = ' select service_id , service_name from crm_service where 1';
					  $query = db_query($selects);
					  while($rowss = mysqli_fetch_object($query)){
					  ?>
					  
					  <option value="<?=$rowss->service_id?>"><?=$rowss->service_name?></option>
					  <? } ?>
                    </select>
					 <? if($lead_status==3){ ?>
				  <input type="text" style="height: 35px;" name="amount[]" placeholder="Value" value="<?=$amount?>" >
					<? } ?>
					<br><br>
					<select name="service_id[]" id="service_id"  style="height: 30px;" class="selectpicker" data-live-search="true">
					<option value="">&emsp;</option>
					  <? 
					  $selects = ' select service_id , service_name from crm_service where 1';
					  $query = db_query($selects);
					  while($rowss = mysqli_fetch_object($query)){
					  ?>
					  
					  <option value="<?=$rowss->service_id?>"><?=$rowss->service_name?></option>
					  <? } ?>
                    </select>
					 <? if($lead_status==3){ ?>
				  <input type="text" style="height: 35px;" name="amount[]" placeholder="Value" value="<?=$amount?>" >
				  <? } ?>
					<br><br>
					<select name="service_id[]" id="service_id"  style="height: 30px;" class="selectpicker" data-live-search="true">
					<option value="">&emsp;</option>
					  <? 
					  $selects = ' select service_id , service_name from crm_service where 1';
					  $query = db_query($selects);
					  while($rowss = mysqli_fetch_object($query)){
					  ?>
					  
					  <option value="<?=$rowss->service_id?>"><?=$rowss->service_name?></option>
					  <? } ?>
                    </select> 
					 <? if($lead_status==3){ ?>
				  <input type="text" style="height: 35px;" name="amount[]" placeholder="Value" value="<?=$amount?>" >
				  <? } ?>
				                   </td>
				  
				  
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td height="33" colspan="2"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td height="33"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td height="33" colspan="4" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  </tr>
                </tbody></table>
              <p>&nbsp;</p></td>
            </tr></tbody></table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="ui-resizable-handle ui-resizable-n" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-e" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-s" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-w" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se ui-icon-grip-diagonal-se" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-sw" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-ne" style="z-index: 1000;"></div>
          <div class="ui-resizable-handle ui-resizable-nw" style="z-index: 1000;"></div>
          <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">

          </div>
        </div>
</form>
</body>


<script src="jquery.min.js"></script>
<script src="bootstraps.min.js"></script>
<script src="bootstrap-select.min.js"></script>

</html>
