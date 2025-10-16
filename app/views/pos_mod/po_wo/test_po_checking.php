<?php
require_once "../../../assets/template/layout.top.php";

$title='Approving Work Order';

//do_calander('#po_date');
do_calander('#quotation_date');

$table_master='purchase_master';
$table_details='purchase_invoice';
$unique='po_no';


if(isset($_POST['new']))
{
		$crud   = new crud($table_master);

		if(!isset($_SESSION[$unique])) {
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$$unique=$_SESSION[$unique]=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Requisition No Created. (PO No :-'.$_SESSION[$unique].')';
		}
		else {
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		}
}
if($_GET['po_no']>0)
$$unique=$_SESSION[$unique]=$_GET['po_no'];
else
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
		$_POST['checked_by']=$_SESSION['user']['id'];
		$_POST['checked_at']=date('Y-m-d H:i:s');
		$_POST['status']='WO CHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded to Relevant Department.';
		
		
?>
<script language="javascript">
window.location.href = "select_unapproved_po.php";
</script>
<?
		
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
		$crud   = new crud($table_details);
		$item = explode('#>',$_POST['item_id']);
		$item_id = $item[2];
		
		$_POST['item_id'] = $item_id;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$crud->insert();
		unset($item_id);
}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update PO Information'; else $btn_name='Initiate PO Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1 and sub_group_id in (1000010000,1100010000) ','item_id');
?>
<script language="javascript">
function count()
{
var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);
document.getElementById('amount').value = num.toFixed(2);	
}




function PIcalculation(id){
var wo_qty = document.getElementById('qty#'+id).value*1;
var wo_rate = document.getElementById('unit_price#'+id).value*1;
//var pi_rate = document.getElementById('unit_price#'+id).value*1;
var amount = document.getElementById('amount#'+id).value= (wo_qty*wo_rate);
//var amount = document.getElementById('amount#'+id).value= (pi_qty*pi_rate);
}



function update_edit(id)

{
var qty = (document.getElementById("qty#"+id).value);
//var unit_price   = (document.getElementById("unit_price#"+id).value);
//var amount = (document.getElementById("amount#"+id).value)*1;
var unit_price  = (document.getElementById("unit_price#"+id).value);
var amount = (document.getElementById("amount#"+id).value)*1;
var info = qty+"<@>"+unit_price+"<@>"+amount;
getData2('wo_edit_ajax.php', 'ppp',id,info);
}






</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz" >
  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td valign="top"><fieldset>
        <? $field='po_no';?>
        <div>
          <label for="<?=$field?>">WO  No: </label>
          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
        </div>
        <? $field='po_date';?>
        <div>
          <label for="<?=$field?>">WO Date:</label>
          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required="required" readonly=""/>
        </div>
		 <? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>
      <div>
        <label for="<?=$field?>">Concern:</label>
        <select id="<?=$field?>" name="<?=$field?>" required   onchange="getData2('ajax_vendor.php', 'vendor_space', this.value,  this.value)">
        <option></option>
        <? foreign_relation($table,$get_field,$show_field,$$field);?>
        </select>
      </div>
	  
	  <? $field='wo_del_date';?>
          <div>
            <label for="<?=$field?>">Delivery Date:</label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="" />
          </div>
		  
      

<div>
<? $field='tax';?>
<label for="<?=$field?>">VAT:</label>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly=""/>
</div>

		<div>
            <? $field='tax_ait';?>
            <label for="<?=$field?>">Tax/AIT:</label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly=""/>
          </div>
      </fieldset></td>
      <td><fieldset>
	        <? $field='po_subject';?>
      <div>
        <label for="<?=$field?>">Subject:</label>
        <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
      </div>
	  
	  <? $field='po_details';?>
          <div>
            <label for="<?=$field?>">Remarks:</label>
            <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
          </div>
		  
        <div></div>
        <? $field='vendor_id2'; $table='vendor'; $get_field='vendor_id2'; $show_field='vendor_name'; ?>

      <div>

        <label for="<?=$field?>">Party :</label>

		<span id="vendor_space">
		
	
<input name="<?=$field?>" type="text" id="<?=$field?>" value="<?php if($vendor_id>0){ 

$vendor = find_all_field('vendor','','vendor_id='.$vendor_id);

echo $vendor->vendor_name; }?>" readonly="readonly" />
<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor->vendor_id?>"/>	  	


		</span> 

      </div>
	  
	   <? $field='payment_terms';?>
            <div>
              <label for="<?=$field?>">Payment Terms:</label>
              <select name="payment_terms" required id="payment_terms"  style="width:204px">

                <?  foreign_relation('payment_terms','terms_id','payment_terms',$payment_terms, 'terms_id='.$payment_terms);?>
              </select>
            </div>
	  
        <div>
          <? $field='quotation_no';?>
          <div>
            <label for="<?=$field?>">Quotation No:</label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
          </div>
		  
		  <div>
            <label>Qoutation (*PDF) </label>
            <input name="qoutationDoc" type="file" id="qoutationDoc" style="height:19px;"/>
          </div>
         
         
        </div>
      </fieldset></td>
    </tr>
    <!--<tr>
      <td colspan="2"><div class="buttonrow" style="margin-left:240px;">
        <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
      </div></td>
    </tr>-->
  </table>
</form>


<? if($_SESSION[$unique]>0){?>
<table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td colspan="3" align="center" bgcolor="#78B8DB" style="color:#FFFFFF;"><strong>Entry Information</strong></td>
    </tr>
  <tr>
    <td align="right" bgcolor="#78B8DB">Created By:</td>
    <td align="left" bgcolor="#78B8DB">&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>
    <td rowspan="2" align="center" bgcolor="#78B8DB"><a href="wo_print_view.php?po_no=<?=$po_no?>" target="_blank"><img src="../../images/print.png" width="26" height="26" /></a></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#78B8DB">Created On:</td>
    <td align="left" bgcolor="#78B8DB">&nbsp;&nbsp;<?=$entry_at?></td>
    </tr>
</table>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Stock</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Price</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC">
<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
<input  name="po_date" type="hidden" id="po_date" value="<?=$po_date?>"/>
<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>
<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>"/>
<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:320px;" required onblur="getData2('po_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>
<td colspan="3" align="center" bgcolor="#CCCCCC">
<span id="po">
<input name="stk" type="text" class="input3" id="stk" style="width:100px;" readonly="readonly"/>
<input name="unit" type="text" class="input3" id="unit" style="width:80px;" readonly="readonly"/>
<input name="price" type="text" class="input3" id="price" style="width:80px;"  readonly="readonly"/>
</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:90px;" onchange="count()" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:100px;" readonly="readonly" required/></td>
      </tr>
    </table>
  <br /><br /><br /><br />





<table width="100%" border="0" cellspacing="0" cellpadding="0">&nbsp;
      <tr>
	  <br />
   
        <td><div class="tabledesign2">
          <table id="grp" width="100%" cellspacing="0" cellpadding="0"><tbody>
            
			
            <tr>
			<th width="8%" rowspan="2">S/L</th>
			<th width="31%" rowspan="2">Item Name</th>
			<th width="7%" rowspan="2">Unit  </th>
			<th width="12%" rowspan="2">Quantity</th>
			<th colspan="2" ><center>
			  Price in BDT 
			</center> </th>
			<th width="7%" rowspan="2">Action</th>
      		<th width="8%" rowspan="2">Delete</th>
			</tr>
            <tr>
              <th width="13%">Price</th>
              <th width="14%">Amount</th>
              </tr>
            

<?
$s=0;
 $res='select a.id,concat(b.item_name) as item_name, a.stk,a.rate as unit_price,a.qty ,a.unit_name,a.amount, "x" from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$po_no;

$query=mysql_query($res);

while($po_item=mysql_fetch_object($query)){
?>
<tr>
<td style="text-align:center;"><?=++$s?></td>
<td>&nbsp;<?=$po_item->item_name?></td>
<td>&nbsp;<?=$po_item->unit_name?></td>
<td><input type="text" name="<?='qty#'.$po_item->id?>" id="<?='qty#'.$po_item->id?>" value="<?=$po_item->qty?>" style="width:90px" onchange="PIcalculation(<?=$po_item->id?>)" /></td>

<td><input type="text" name="<?='unit_price#'.$wo_item->id?>" id="<?='unit_price#'.$po_item->id?>" value="<?=$po_item->unit_price?>"  onchange="PIcalculation(<?=$po_item->id?>)"  style="width:80px"/></td>
<td><input type="text" name="<?='amount#'.$po_item->id?>" id="<?='amount#'.$po_item->id?>" value="<?=$po_item->amount?>" style="width:100px"  readonly=""/></td>

<td><span id="ppp"><input name="<?='edit#'.$po_item->id?>" type="button" id="Edit" value="Edit" style="width:50px; height:22px; color:#000; font-weight:700 " onclick="update_edit(<?=$po_item->id?>);" /></span></td>
<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$po_item->id?>">&nbsp;X&nbsp;</a></td>
</tr>
<? }?>







</table>
          </div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
	
	<br /> <br />

</form>
<form action="" method="post" name="cz" id="cz" >
  <table width="100%" border="0">
    <tr>
      <td align="center">

      <input name="delete"  type="submit" class="btn1" value="DELETE AND CANCEL WO" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

      </td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD WO" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />

      </td>
    </tr>
  </table>
</form>
<? }?>
</div>
<script>$("#codz").validate();$("#cloud").validate();</script>
<?
require_once "../../../assets/template/layout.bottom.php";
?>