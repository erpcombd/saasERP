<?php
//
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Spare Parts Sales';


create_combobox('machine_id');

do_calander('#req_date');
do_calander('#need_by','"'.$req_date =date('Y-m-d').'"','60');

$table_master='spare_parts_requisition_master';
$table_details='spare_parts_requisition_order';
$unique='req_no';

if($_GET['mhafuz']>0)
unset($_SESSION[$unique]);

if(isset($_POST['new']))
{
		$crud   = new crud($table_master);
		
		if(!isset($_SESSION[$unique])) {
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$$unique=$_SESSION[$unique]=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Requisition No Created. (Req No :-'.$_SESSION[$unique].')';
		}
		else {
		$_POST['edit_by']=$_SESSION['user']['id'];
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
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['status']='CHECKED';
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
		$iii=explode('-',$_POST['item_id']);
		$_POST['item_id']=$iii[0];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:s:i');
		$crud->insert();
}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update Information'; else $btn_name='Initiate Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

auto_complete_from_db('item_info','concat(item_id," - ",item_name)','concat(item_id," - ",item_name)','1 and product_type="Spare Parts"','item_id');

?>
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





function count()

{

var stock=((document.getElementById('stock').value)*1);

var service_charge=((document.getElementById('service_charge').value)*1);
var unit_price=((document.getElementById('unit_price').value)*1);
var qty=((document.getElementById('qty').value)*1);

var amount=(document.getElementById('amount').value)=(unit_price*qty);

var service_amt=(document.getElementById('service_amt').value)=(amount*service_charge)/100;

var total_amt=(document.getElementById('total_amt').value)=(amount+service_amt);




 if(qty>stock)
  {
alert('Can not issue more than stock.');
document.getElementById('qty').value='';
document.getElementById('amount').value='';
document.getElementById('service_amt').value='';
document.getElementById('total_amt').value='';
  } 


}




function update_edit(id)

{
var qty = (document.getElementById("qty#"+id).value);
//var unit_price   = (document.getElementById("unit_price#"+id).value);
//var amount = (document.getElementById("amount#"+id).value)*1;
//var unit_price  = (document.getElementById("unit_price#"+id).value);
//var amount = (document.getElementById("amount#"+id).value)*1;
//var info = qty+"<@>"+unit_price+"<@>"+amount;
var info = qty;
getData2('req_edit_ajax.php', 'ppp',id,info);
}


window.onload = function() {  document.getElementById("item_id").focus();};

</script>


<style>

.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}


div.form-container_large input {
    width: 150px;
    height: 38px;
    border-radius: 0px !important;
}


</style>


<div class="form-container_large">
<form action="mr_create.php" method="post" name="codz" id="codz" >
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset>
    <? $field='req_no';?>
      <div>
        <label for="<?=$field?>" style="width:30%;">SO No: </label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:60%;" readonly=""/>
		
		<input  name="service_charge" type="hidden" id="service_charge" value="<?=find_a_field('spare_parts_service_charge','service_charge','id=1');?>" style="width:60%;" readonly=""/>
		 
		<input name="store_req_no" type="hidden" id="store_req_no" 
		value="<? if($store_req_no>0) echo $store_req_no; else echo (find_a_field($table_master,'max(store_req_no)','1 and warehouse_id="'.$_SESSION['user']['depot'].'"')+1);?>" readonly/>
		
      </div>
    <? $field='req_date'; if($req_date=='') $req_date =date('Y-m-d');?>
      <div>
        <label for="<?=$field?>" style="width:30%;">SO  Date:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly="" style="width:60%;"/>
      </div>
	  
	  
	  <? $field='req_note'; ?>
      <div>
        <label for="<?=$field?>" style="width:30%;">Remarks:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:60%;" />
		<input  name="group_for_to" type="hidden" id="group_for_to" value="1" required/>
      </div>
    
	  
	  
	  
	  
    </fieldset></td>
    <td>
			<fieldset>
			

	  
	  
	  
	  
	     <? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>
	  
      <div> 
        <label for="<?=$field?>" style="width:30%;">Company:</label>
		
		<? if($group_for<1) { ?>
		
		

<select  name="group_for" id="group_for" required style="width:60%;">

	<option></option>

	
		
      <? foreign_relation('user_group','id','group_name',$group_for,'1 order by id');?>
		 </select>


		
		
		<? }?>
		
		
		<? if($group_for>0) { ?>
			<input  name="group_for2" type="text" id="group_for2"  readonly=""
			value="<?=find_a_field('user_group','group_name','id='.$group_for)?>" style="width:60%;" required/>
			
			<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" required/>
		
		<? }?>
	  
	  
   </div>
   
   
	 
   	  
	 <? $field='warehouse_to'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
	  
      <div> 
        <label for="<?=$field?>" style="width:30%;">From:</label>
		
		<? if($warehouse_to<1) { ?>
		
<select  name="warehouse_to" id="warehouse_to" required style="width:60%;">
		
      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_to,'warehouse_id = 33 order by warehouse_id');?>
		 </select>	
		
		<? }?>
		
		
		<? if($warehouse_to>0) { ?>
			<input  name="warehouse_to2" type="text" id="warehouse_to2"  readonly="" style="width:60%;"
			value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_to)?>" required/>
			
			<input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>" required/>
		
		<? }?>
	  
   </div>
	
	 
	  
	  
	  
	  
      <div> 
        <label for="<?=$field?>" style="width:30%;">Location:</label>
		
		<? if($warehouse_id<1) { ?>
		
		

<select  name="warehouse_id" id="warehouse_id" required style="width:60%;">

	<option></option>

	
		
      <? foreign_relation('spare_parts_sales_location','warehouse_id','warehouse_name',$warehouse_id,'1 order by warehouse_id');?>
		 </select>


		
		
		<? }?>
		
		
		<? if($warehouse_id>0) { ?>
			<input  name="warehouse_id2" type="text" id="warehouse_id2"  readonly=""
			value="<?=find_a_field('spare_parts_sales_location','warehouse_name','warehouse_id='.$warehouse_id)?>" required style="width:60%;"/>
			
			<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>" required/>
		
		<? }?>
	  
	  
   </div>
   
   
   
     
	
	      
			</fieldset>	</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><div class="buttonrow" style="">
      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
    </div></td>
    </tr>
</table>
</form>
<? if($_SESSION[$unique]>0){?>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                          <tr>
                            <td colspan="6" align="center" bgcolor="#0099FF">
							<a href="mr_print_view.php?req_no=<?=$$unique?>" target="_blank" style="padding:5px 30px; background: #B0C4DE; color:#000000; font-size:12px; font-weight:700;">Preview</a>
							</td>
                            <td colspan="2" align="center"  bgcolor="#FF0000"><div class="button">
                                <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
                              </div></td>
                          </tr>
                      <tr>
                        <td width="50%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                            <td width="10%" align="center" bgcolor="#0099FF"><strong>Unit Name </strong></td>
                            <td width="10%" align="center" bgcolor="#0099FF"><strong>Stock</strong></td>
                            <td width="10%" align="center" bgcolor="#0099FF"><strong>Price</strong></td>
                            <td width="15%" align="center" bgcolor="#0099FF"><strong>Qty</strong></td>
                            <td width="15%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                            <td width="15%" align="center" bgcolor="#0099FF"><strong>Machine</strong></td>
                            <td width="15%" align="center" bgcolor="#0099FF"><strong>Remarks</strong></td>
      </tr>
                      <tr>
                        <td align="center" bgcolor="#CCCCCC">
<input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
<input  name="group_for_to" type="hidden" id="group_for_to" value="<?=$group_for_to?>"/>
<input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
<input  name="req_date" type="hidden" id="req_date" value="<?=$req_date?>"/>
<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>"/>
<input  name="service_charge" type="hidden" id="service_charge" value="<?=$service_charge?>"/>
<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:350px;" required="required" onblur="getData2('mr_ajax.php', 'mr', this.value, document.getElementById('req_no').value);"/></td>
                        <td colspan="3" align="center" bgcolor="#CCCCCC">
						  <span id="mr">
						
						<table>
							<tr>
							
							<td>

<input name="unit_name" type="text" class="input3" id="unit_name"  style="width:80px; " onfocus="focuson('qty_ctn')" readonly="readonly"/>								</td>
							
								<td>

<input name="stock" type="text" class="input3" id="stock"  style="width:80px; " onfocus="focuson('qty_ctn')" readonly="readonly"/>								</td>


<td>

<input name="avg_price" type="text" class="input3" id="avg_price"  style="width:80px; "   readonly="readonly"/>								</td>
							</tr>
						</table>
                          </span></td>
                        <td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" onkeyup="count()" style="width:80px;" required/></td>
                        <td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount"  maxlength="100"  onkeyup="count()"  style="width:80px;" required/>
						<input  name="service_charge" type="hidden" id="service_charge" value="<?=$service_charge?>" style="width:80px;" onkeyup="count()" />
						<input name="service_amt" type="hidden" class="input3" id="service_amt"  maxlength="100" style="width:80px;" onkeyup="count()"  required/>
						<input name="total_amt" type="hidden" class="input3" id="total_amt"  maxlength="100" style="width:80px;"  onkeyup="count()" required/>
						</td>
                        <td align="center" bgcolor="#CCCCCC">
							<select  name="machine_id" id="machine_id"  style="width:90px;">
						<option></option>
     					 <? foreign_relation('machine_info','machine_id','machine_short_name',$machine_id,'group_for="'.$group_for.'"');?>
					 </select>						</td>
                        <td align="center" bgcolor="#CCCCCC"><input name="remarks" type="text" class="input3" id="remarks"  maxlength="100" style="width:120px;" /></td>
      </tr>
    </table>
<br />
  
  
  
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">&nbsp;
      <tr>
	  <br />
   
        <td><div class="tabledesign2">
          <table id="grp" width="100%" cellspacing="0" cellpadding="0"><tbody>
            
			
            <tr>
			<th width="8%">SL</th>
			<th width="34%">Item Name</th>
			<th width="7%">Unit</th>
			<th width="10%">Machine</th>
			<th width="15%">Quantity</th>
			<th width="18%">Remarks</th>
			<th width="8%">Delete</th>
			</tr>
            
            

<?
$s=0;
  $res='select a.id,   concat(b.item_name) as item_name,  a.machine_id, b.unit_name,  a.qty as qty , a.remarks,"x" from spare_parts_requisition_order a,item_info b 
  where b.item_id=a.item_id and a.req_no="'.$req_no.'" order by a.id desc';

$query=db_query($res);

while($data=mysqli_fetch_object($query)){
?>
<tr>
<td style="text-align:center;"><?=++$s?></td>
<td>&nbsp;<?=$data->item_name?></td>
<td><?=$data->unit_name?></td>
<td>&nbsp;<?=find_a_field('machine_info','machine_short_name','machine_id='.$data->machine_id)?></td>
<td><?=$data->qty?></td>

<td><?=$data->remarks?></td>
<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$data->id?>">&nbsp;X&nbsp;</a></td>
</tr>
<? }?>







</table>
          </div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
</form>
<br />

<form action="" method="post" name="cz" id="cz" >
  <table width="100%" border="0">
    <tr>
      <td align="center">

      <input name="delete"  type="submit" class="btn1" value="DELETE AND CANCEL" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

      </td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD" style="width:300px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" />

      </td>
    </tr>
  </table>
</form>
<? }?>
</div>
<script>$("#codz").validate();$("#cloud").validate();</script>
<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>