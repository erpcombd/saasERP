<?php
session_start();
ob_start();
require "../../../warehouse_mod/support/inc.all.php";


$emp=find_all_field('personnel_basic_info','PBI_ORG','PBI_ID='.$_SESSION['employee_selected']);


$title='New Material Requisition Create';


do_calander('#need_by');

$table_master='requisition_master_stationary';
$table_details='requisition_order_stationary'; 
$unique='req_no';

//if($_GET['mhafuz']>0)
//unset($_SESSION[$unique]);

if(isset($_POST['new']))
{ 
		
		$crud   = new crud($table_master);

		if(!isset($_SESSION[$unique])) {
		$_POST['req_from']='HRM';
		$_POST['status']='MANUAL';
		$_POST['incharge_id'] = $emp->incharge_id;
		$_POST['dept_head_id'] = $emp->head_id;
		$_POST['entry_by']=$_SESSION['employee_selected'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['employee_selected'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$$unique=$_SESSION[$unique]=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Requisition No Created. (Req No : '.$_SESSION[$unique].')';
		}
		else {
		$_POST['edit_by']=$_SESSION['employee_selected'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		}
}

$$unique=$_SESSION[$unique];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$$unique;		
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Deleted.';
}

if($_GET['del']>0)
{
		$crud   = new crud($table_details);
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_POST['confirmm']))
{
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['employee_selected'];
		$_POST['entry_at']=date('Y-m-d h:s:i');

if($_SESSION['user']['group']==5){ 
$_POST['status']='UNCHECKED-BOQ'; 
}else{ 
	if($_SESSION['user']['depot']==71){$_POST['status']='PRE-CHECKED'; }else{$_POST['status']='UNCHECKED';}
}



		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded for Approval.';
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
		$crud   = new crud($table_details);
		$iii=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$iii[2];
		$_POST['entry_by']=$_SESSION['employee_selected'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['employee_selected'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$crud->insert();
}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update Requsition Information'; else $btn_name='Initiate Requsition Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
// auto_complete_from_db('item_info','item_name','item_id','1','item_id');
auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_description,"#>",item_id)', '1 order by item_id asc', 'item_id');


?>

<style>
fieldset {
    display: block;
    margin-inline-start: 2px;
    margin-inline-end: 2px;
    padding-block-start: 0.35em;
    padding-inline-start: 0.75em;
    padding-inline-end: 0.75em;
    padding-block-end: 0.625em;
    min-inline-size: min-content;
    border-width: 2px;
    border-style: groove;
    border-color: rgb(192, 192, 192);
    border-image: initial;
}
.tabledesign2 {
    width: 100%;
    padding: 0;
    margin: 0px auto 1px auto;
    background-color: #ffffff;
    border-left: 1px solid #417216;
    text-align: left;
}
.tabledesign2 th {
    font: bold 11px Verdana, Arial, Helvetica, sans-serif;
    background-color: #cbde72;
    color: #000;
    border-right: 1px solid #417216;
    border-bottom: 1px solid #417216;
    border-top: 1px solid #417216;
    text-align: left;
    padding: 3px 3px 3px 12px;
}
.tabledesign2 td {
    border-right: 1px solid #417216;
    border-bottom: 1px solid #417216;
    padding: 3px 3px 3px 3px;
    color: #000;
    text-align: left;
}
</style>
<script language="javascript">
function focuson(id) {
  if(document.getElementById('item_id').value=='')
  document.getElementById('item_id').focus();
  else
  document.getElementById(id).focus();
}
window.onload = function() {
if(document.getElementById("warehouse_id").value>0)
  document.getElementById("item_id").focus();
  else
  document.getElementById("req_date").focus();
}
</script>
<div class="form-container_large" style="padding: 2%;">
<form action="mr_create.php" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset>
    <? $field='req_no';?>
      <div>
        <label for="<?=$field?>">Requisition No: </label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>
    <? $field='req_date'; if($req_date=='') $req_date =date('Y-m-d');?>
      <div>
        <label for="<?=$field?>">Requisition Date:</label>
        <input  name="<?=$field?>" type="date" id="<?=$field?>" value="<?=$$field?>" />
      </div>
    <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
      <div>
        <label for="<?=$field?>">Organization: </label>
		<select name="warehouse_id"  id="warehouse_id" required>
			<option></option>
			<? foreign_relation('user_group','id','group_name',$warehouse_id,'1');?>
		</select>
		<!--<input name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field('user_group','group_name','id='.$emp->PBI_ORG)?>" readonly="" />-->
      </div>
    </fieldset></td>
    <td>
			<fieldset>
			
    <? $field='req_for';?>
      <div>
        <label for="<?=$field?>">Requisition By:</label>

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$emp->PBI_NAME?>" readonly/>

      </div>
    <? $field='need_by';?>
      <div>
        <label for="<?=$field?>">Required  (Date):</label>
        <input  name="<?=$field?>" type="date" id="<?=$field?>" value="<?=$$field?>" autocomplete="off"/>
      </div>
    <? $field='req_note';?>
      <div>
        <label for="<?=$field?>">Additional Note:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>
	      
			</fieldset>	</td>
  </tr>
  <tr>
    <td colspan="2"><div class="buttonrow" style="margin: 10px 390px;">
      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
    </div></td>
    </tr>
</table>
</form>
<? if($_SESSION[$unique]>0){?>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud" style="margin-top: 17px; padding: 10px;">
<table  width="100%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                       
                        <td align="center" bgcolor="#0099FF"><strong>Stk Qty</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Req Qty</strong></td>
						 <td align="center" bgcolor="#0099FF"><strong>Remraks</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
                        <td align="center" bgcolor="#CCCCCC"><input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
                            <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
                            <input  name="req_date" type="hidden" id="req_date" value="<?=$req_date?>"/>
							<input  name="last_p_qty" type="hidden" id="last_p_qty" value=""/>
							<input  name="last_p_date" type="hidden" id="last_p_date" value=""/>
                            <input  name="item_id" list="items" type="text" id="item_id" value="<?=$item_id?>" style="width:300px;" required="required" onblur="getAjaxData(this.value)"/>
							
							<datalist id="items">
								<? foreign_relation('item_info','concat(item_name,"#>",item_description,"#>",item_id)','item_name',$item_id,'sub_group_id in (1096000200010000, 1096000700010000) order by item_id asc');?>
							</datalist>
							
							</td>
  <script>
    function getAjaxData(item_id){
        
        var item_id = item_id.split('#>#>');
        
        var warehouse_id = document.getElementById('warehouse_id').value;
        var req_date = document.getElementById('req_date').value;
        var data = item_id[1];
      
        $.ajax({
            type: "POST",
            url: "mr_ajax.php?data="+data,
            success: function(data){
                var data = JSON.parse(data);
                document.getElementById('qoh').value = data[0];
                document.getElementById('unit_name').value = data[1];
				document.getElementById('last_p_qty').value = data[2];
				document.getElementById('last_p_date').value = data[3];
            }
        });
    }
  </script>            
                        
                        <td  align="center" bgcolor="#CCCCCC">
						<span id="mr">
<input name="qoh" type="text" class="input3" id="qoh" style="width:106px;" onfocus="focuson('qty')" readonly="readonly"/>
  </td>
<td  align="center" bgcolor="#CCCCCC">
<input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:80px;" onfocus="focuson('qty')" readonly="readonly"/>
</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"   style="width:60px;" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="item_for" id="item_for" type="text"  style="width:80px;" /></td>
      </tr>
    </table>
<br /><br /><br /><br />
<? 
$res='select a.id,concat(b.item_name," :: ",b.item_description) as item_name,a.qoh as stock_qty,a.last_p_qty as last_pur_qty,a.last_p_date as last_pur_date,a.qty,a.item_for as remarks,"x" 
from requisition_order_stationary a,item_info b where b.item_id=a.item_id and a.req_no='.$req_no;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
//$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';
echo link_report_del($res);
		?>

      </div></td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>
</form>
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
      <td align="center">

      <input name="delete"  type="submit" class="btn1" value="DELETE AND CANCEL REQUSITION" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

      </td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD REQUSITION" style="width:280px; font-weight:bold; font-size:12px; height:30px; color:#090" />

      </td>
    </tr>
  </table>
</form>
<? }?>
</div>
<script>$("#codz").validate();$("#cloud").validate();</script>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>



