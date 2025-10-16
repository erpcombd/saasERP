<?php
require_once "../../../assets/template/layout.top.php";

$title='Export Sales';
$page = "export_sales.php";
$ajax_page = "export_sales_ajax.php";
$page_for = 'Export';
do_calander('#oi_date','-10','0');

$table_master='warehouse_other_issue';
$table_details='warehouse_other_issue_detail';
$unique='oi_no';


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
		$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';
		}
		else {
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
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
		
		$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$_GET['del']."'";
		mysql_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
		
}
if(isset($_POST['confirmm']))
{
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='UNCHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded.';
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
		$crud   = new crud($table_details);
		$iii=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$iii[1];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$xid = $crud->insert();
		journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['oi_date'],0,$_POST['qty'],$page_for,$xid,$_POST['rate'],'',$$unique);
}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update ES Information'; else $btn_name='Initiate ES Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
auto_complete_from_db('item_info','finish_goods_code','concat(item_name,"#>",item_id)','product_nature="Salable"','item_id');
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
</script>
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
    <? $field='oi_no';?>
      <div>
        <label for="<?=$field?>">ES  No: </label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>
	<? $field='oi_date'; if($oi_date=='') $oi_date =date('Y-m-d'); ?>
      <div>
        <label for="<?=$field?>">ES Date:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
    <? $field='requisition_from';?>
      <div>
        <label for="<?=$field?>">Export Place :</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>

        <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>

        <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>
    </fieldset></td>
    <td>
			<fieldset>
			
    <? $field='oi_subject';?>
      <div>
        <label for="<?=$field?>">Note:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
      <div></div>
      <? $field='issued_to'; ?>
      <div>
        <label for="<?=$field?>">Export to   :</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required="required"/>
      </div>
      <div>
        <? $field='approved_by';?>
<div>
          <label for="<?=$field?>">Approved By :</label>
          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
        </div>
      </div>
			</fieldset>	</td>
  </tr>
  <tr>
    <td colspan="2"><div class="buttonrow" style="margin-left:240px;">
      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
    </div></td>
    </tr>
</table>
</form>
<? if($_SESSION[$unique]>0){?>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
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
  <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>
  <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
<input  name="oi_date" type="hidden" id="oi_date" value="<?=$oi_date?>"/>
<input  name="issued_to" type="hidden" id="issued_to" value="<?=$issued_to?>"/>
<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:320px;" required onblur="getData2('<?=$ajax_page?>', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>
<td colspan="3" align="center" bgcolor="#CCCCCC">
<span id="po">
<input name="stk" type="text" class="input3" id="stk" style="width:50px;" readonly="readonly"/>
<input name="unit" type="text" class="input3" id="unit" style="width:50px;" readonly="readonly"/>
<input name="price" type="text" class="input3" id="price" style="width:50px;"  readonly="readonly"/>
</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:60px;" onchange="count()" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:90px;" readonly="readonly" required/></td>
      </tr>
    </table>
					  <br /><br /><br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td>
<div class="tabledesign2">
<? 
$res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_issue_detail a,item_info b where b.item_id=a.item_id and a.oi_no='.$oi_no;
echo link_report_add_del_auto($res,'',1,5);
?>
</div>
</td>
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
      <td align="center">&nbsp;</td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD ES" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />

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