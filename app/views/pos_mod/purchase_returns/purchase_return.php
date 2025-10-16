<?php
require_once "../../../assets/template/layout.top.php";

$title='New Purchase Return';
$page = "purchase_return.php";
$ajax_page = "purchase_return_ajax.php";
$page_for = 'Purchase Return';
do_calander('#oi_date','-200','0');

$table_master='warehouse_other_issue';
$table_details='warehouse_other_issue_detail';
$unique='oi_no';


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
		$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';
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
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='UNCHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		
		$type=1;
		$msg='Successfully Forwarded.';
		$sql = "select * from warehouse_other_issue_detail where oi_no =".$$unique;
		$query = mysql_query($sql);
		while($data = mysql_fetch_object($query))
		{
		journal_item_control($data->item_id ,$_SESSION['user']['depot'],$data->oi_date,0,$data->qty,$page_for,$data->id,$data->rate,'',$$unique);
		$amount = $amount + ($data->qty*$data->rate);
		}
		$oi = find_all_field('warehouse_other_issue','issued_to','oi_no='.$$unique);
		$issued_to = $oi->issued_to;
		$vendor = find_all_field('vendor','ledger_id',"vendor_id=".$issued_to);
		$vendor_ledger = $vendor->ledger_id;
		
		$jv=next_journal_sec_voucher_id();
		$sales_ledger = find_a_field('warehouse','ledger_id','warehouse_id='.$_SESSION['user']['depot']);
		auto_insert_purchase_return_secoundary($jv,strtotime($oi->oi_date),$vendor_ledger,$sales_ledger,$$unique,$amount,$$unique,$oi->requisition_from);
		unset($$unique);
		unset($_SESSION[$unique]);
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
		$crud   = new crud($table_details);
		$iii=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$iii[1];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$xid = $crud->insert();
		
}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update OI Information'; else $btn_name='Initiate OI Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);


$depot_type = find_a_field('warehouse','use_type','warehouse_id="'.$_SESSION['user']['depot'].'"');
if($issued_to>0)
{
$query = 'select concat(i.item_name,"#>",i.item_id),i.item_id from purchase_invoice p, item_info i where p.item_id=i.item_id and vendor_id='.$issued_to;
auto_complete_from_db_sql($query,'item_id');
}
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
        <label for="<?=$field?>">PR  No: </label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>
	<? $field='oi_date'; if($oi_date=='') $oi_date =''; ?>
      <div>
        <label for="<?=$field?>">PR Date:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
    <? $field='requisition_from';?>
      <div>
        <label for="<?=$field?>">Serial No:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>

        <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>

        <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>
    </fieldset></td>
    <td>
			<fieldset>
			
    <? $field='oi_subject';?>
      <div>
        <label for="<?=$field?>">Reason:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
      <div></div>
      <? $field='issued_to'; ?>
      <div>
        <label for="<?=$field?>">Party Name :</label>
        <select id="issued_to" name="issued_to" required>
        <option></option>
<? 
$table='vendor';$get_field='vendor_id';$show_field='vendor_name';
foreign_relation($table,$get_field,$show_field,$$field,"group_for='".$_SESSION['user']['group']."' order by vendor_name");
?>
</select>
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
<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:320px;" required onblur="getData2('<?=$ajax_page?>', 'po',this.value,'<?=$issued_to?>');"/></td>
<td colspan="2" align="center" bgcolor="#CCCCCC">
<span id="po">

<input name="unit" type="text" class="input3" id="unit" style="width:70px;" readonly="readonly"/>
<input name="price" type="text" class="input3" id="price" style="width:70px;"  readonly="readonly"/>
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
echo link_report_add_del_auto($res,'',4,6);
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

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD RD" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />

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