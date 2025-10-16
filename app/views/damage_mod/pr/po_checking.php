<?php
session_start();
ob_start();
require "../../support/inc.all.php";

$title='Approving Purchase Order';

do_calander('#po_date');
do_calander('#quotation_date');

$table_master='purchase_master';
$table_details='purchase_invoice';
$unique='po_no';


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
		$msg='Requisition No Created. (PO No :-'.$_SESSION[$unique].')';
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
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='CHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded to Relevant Department.';
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
		$crud   = new crud($table_details);
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
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
if($$unique>0) $btn_name='Update PO Information'; else $btn_name='Initiate PO Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

?>
<script language="javascript">
function count()
{
var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);
document.getElementById('amount').value = num.toFixed(2);	
}
</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td valign="top"><fieldset>
        <? $field='po_no';?>
        <div>
          <label for="<?=$field?>">PO  No: </label>
          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
        </div>
        <? $field='po_date';?>
        <div>
          <label for="<?=$field?>">PO Date:</label>
          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required="required"/>
        </div>
        <? $field='req_no';?>
        <div>
          <label for="<?=$field?>">Req No:</label>
          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required="required"/>
        </div>
        <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
        <div>
          <label for="<?=$field?>">Warehouse:</label>
          <select id="<?=$field?>" name="<?=$field?>" required="required">
            <option></option>
            <? foreign_relation($table,$get_field,$show_field,$$field);?>
          </select>
        </div>
        <? $field='po_details';?>
        <div>
          <label for="<?=$field?>">Note:</label>
          <textarea name="<?=$field?>" id="<?=$field?>"><?=$$field?>
  </textarea>
        </div>
      </fieldset></td>
      <td><fieldset>
        <? $field='po_subject';?>
        <div>
          <label for="<?=$field?>">Subject:</label>
          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required="required"/>
        </div>
        <div></div>
        <? $field='vendor_id'; $table='vendor';$get_field='vendor_id';$show_field='vendor_name';?>
        <div>
          <label for="<?=$field?>">Vendor:</label>
          <select id="<?=$field?>" name="<?=$field?>" required="required">
            <option></option>
            <? foreign_relation($table,$get_field,$show_field,$$field);?>
          </select>
        </div>
        <div>
          <? $field='quotation_no';?>
          <div>
            <label for="<?=$field?>">Quotation No:</label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
          </div>
          <? $field='quotation_date';?>
          <div>
            <label for="<?=$field?>">Quotation Date:</label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
          </div>
          <? $field='delivery_within';?>
          <div>
            <label for="<?=$field?>">Delivery Within:</label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required="required"/>
          </div>
        </div>
      </fieldset></td>
    </tr>
    <tr>
      <td colspan="2"><div class="buttonrow" style="margin-left:240px;">
        <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
      </div></td>
    </tr>
  </table>
</form>


<? if($_SESSION[$unique]>0){?>
<table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>
    </tr>
  <tr>
    <td align="right" bgcolor="#CCFF99">Created By:</td>
    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>
    <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="po_print_view.php?po_no=<?=$po_no?>" target="_blank"><img src="../../images/print.png" width="26" height="26" /></a></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#CCFF99">Created On:</td>
    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=$entry_at?></td>
    </tr>
</table>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
    <tr>
      <td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
      <td align="center" bgcolor="#0099FF"><strong>Cost Price</strong></td>
      <td align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
      <td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>
      <td align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
      <td  rowspan="2" align="center" bgcolor="#FF0000"><div class="button">
        <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>
      </div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#CCCCCC"><input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
        <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
        <input  name="po_date" type="hidden" id="po_date" value="<?=$po_date?>"/>
        <input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>
        <select name="item_id" id="item_id" style="width:320px;" required="required" onchange="getData2('po_ajax.php', 'po',this.value,'');">
          <option></option>
          <? foreign_relation('item_info','item_id','concat(item_name," :: ",item_description)',$item_id);?>
        </select></td>
      <td colspan="2" align="center" bgcolor="#CCCCCC"><span id="po">
        <input name="rate" type="text" class="input3" id="rate" style="width:120px;" onchange="count()" readonly="readonly" required="required"/>
        <input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:50px;"  readonly="readonly" required="required"/>
      </span></td>
      <td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:60px;" onchange="count()" required="required"/></td>
      <td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:90px;" readonly="readonly" required="required"/></td>
    </tr>
  </table>
  <br /><br /><br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<div class="tabledesign2">
<? 
$res='select a.id,concat(b.item_name," :: ",b.item_description) as item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$po_no;
echo link_report_del($res);
?>
</div>
</td>
</tr>
</table>
</form>
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
      <td align="center">

      <input name="delete"  type="submit" class="btn1" value="DELETE AND CANCEL PO" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

      </td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD PO" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />

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