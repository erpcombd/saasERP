<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Purchased Product Receive (PR)';

do_calander('#rec_date');

$table_master='purchase_master';
$table_details='purchase_receive';
$unique='po_no';

if($_SESSION[$unique]>0)
$$unique=$_SESSION[$unique];

if($_REQUEST[$unique]>0){
$$unique=$_REQUEST[$unique];
$_SESSION[$unique]=$$unique;}
else
$$unique = $_SESSION[$unique];



if(isset($_POST['confirmm']))
{
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$_POST['status']='COMPLETED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Completed All Purchase Order.';
}

if(isset($_POST['delete']))
{
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$_POST['status']='CANCELED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		

		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Canceled Remainning All Purchase Order.';
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$crud   = new crud($table_details);
		$inserted_id=$crud->insert();
$warehouse_ledger=find_a_field('warehouse','ledger_id',"warehouse_id=".$_POST['warehouse_id']);
$vendor_ledger=find_a_field('vendor','ledger_id',"vendor_id=".$_POST['vendor_id']);
journal_item_control($_POST['item_id'] ,$_POST['warehouse_id'],$_POST['rec_date'],$_POST['qty'],'0','Purchase',$inserted_id,$_POST['rate']);
auto_insert_purchase($_POST['rec_date'],$vendor_ledger,$warehouse_ledger,$_POST['order_no'],$_POST['amount'],$_POST['po_no'],$inserted_id,$_POST['rate']);
}

if($_GET['del']>0)
{
		$crud   = new crud($table_details);
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		
		$sql = "delete from journal_item where tr_from = 'Purchase' and tr_no = '".$_GET['del']."'";
		db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
		
}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update PO Information'; else $btn_name='Initiate PO Information';
if($$unique<1)
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
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
    
    <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
      <div>
        <label for="<?=$field?>">Warehouse:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required"/>
      </div>
      <? $field='po_details';?>
      <div>
        <label for="<?=$field?>">Note:</label>
        <textarea name="<?=$field?>" id="<?=$field?>"><?=$$field?></textarea>
      </div>
    </fieldset></td>
    <td>
			<fieldset>
			
    <? $field='po_subject';?>
      <div>
        <label for="<?=$field?>">Subject:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
      <div></div>
      <? $field='vendor_id'; $table='vendor';$get_field='vendor_id';$show_field='vendor_name';?>
      <div>
        <label for="<?=$field?>">Vendor:</label>
                <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required"/>
      </div>
              <? $field='delivery_within';?>
        <div>
          <label for="<?=$field?>">Delivery Within:</label>
          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
        </div>
      <div>
<? $field='entry_by'; $table='user_activity_management';$get_field='user_id';$show_field='fname';?>
        <div>
<label for="<?=$field?>">Entry By:</label>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required"/>
        </div>
        <? $field='checked_by';?>
        <div>
          <label for="<?=$field?>">Approved By:</label>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required"/>
        </div>

      </div>
			</fieldset>	</td>
  </tr>

</table>
</form>
<? if($$unique>0){?>
<table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#CCFF99">Created By:</td>
    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;
      <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>
    <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="po_print_view.php?po_no=<?=$po_no?>" target="_blank"><img src="../../images/print.png" width="26" height="26" /></a></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#CCFF99">Created On:</td>
    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;
      <?=$entry_at?></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td>
<div class="tabledesign2">
<? 
$res='select a.id,concat(b.item_name," :: ",b.item_description) as item_name,a.unit_name,a.qty as PO_Qty ,(select sum(qty) from purchase_receive where a.id=order_no) as PR_Qty,(select a.qty-sum(qty) from purchase_receive where a.id=order_no) as Due_Qty from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$po_no;
echo link_report($res,'',5,0);
?>
</div>
</td>
    </tr>
  </table>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Date</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>QC By</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>
                        <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="RECEIVE" tabindex="12" style="font-weight:bold; color:#F00"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC">
  <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
  <input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$_POST['vendor_id']?>"/>
<select name="item_id" id="item_id" style="width:300px;" required onchange="getData2('po_ajax.php', 'po',this.value,'');">
<option></option>
<?
$sql="select c.id,a.item_name from item_info a,purchase_invoice c where c.item_id=a.item_id and c.po_no=".$po_no;

advance_foreign_relation($sql,$value='');
?>
</select>
</td>
<td align="center" bgcolor="#CCCCCC"><input name="rec_date" type="text" class="input3" id="rec_date" value="<?=date('Y-m-d')?>"  maxlength="100" style="width:70px;"  readonly="readonly" required="required"/></td>
<td align="center" bgcolor="#CCCCCC"><input name="qc_by" type="text" id="qc_by" value="<?=$_POST['qc_by']?>" style="width:150px;" />
</td>
<td align="center" bgcolor="#CCCCCC">
  <span id="po">
  <input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:50px;"  readonly required/>
  </span>
</td>
<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:60px;" onchange="count()" required/>
  <input name="amount" type="hidden" class="input3" id="amount" style="width:90px;" readonly="readonly" required="required"/></td>
</tr>
    </table>
					  <br /><br /><br /><br />



    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><div class="tabledesign2">
                            <? 
$res='select a.id as pr_no,a.id as pr_no, a.rec_date,b.item_name,a.qc_by,a.qty as PR_Qty ,a.unit_name,"X" from purchase_receive a,item_info b where b.item_id=a.item_id and a.po_no='.$po_no;
echo link_report_add_auto($res,'',5,0);
?>          </div></td>
                        </tr>
    </table>
</form>
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
      <td align="center">

      <input name="delete"  type="submit" class="btn1" value="CANCEL REMAINNING PR" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

      </td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn1" value="COMPLETE All PR" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />

      </td>
    </tr>
  </table>
</form>
<? }?>
</div>
<script>$("#codz").validate();$("#cloud").validate();</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>