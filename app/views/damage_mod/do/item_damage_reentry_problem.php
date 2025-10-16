<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$sql = 'select ';

$title='New Item Return';

$page_for = 'Return';
do_calander('#or_date');
do_calander('#party_sent_date');

$table_master='warehouse_damage_receive';
$table_details='warehouse_damage_receive_detail';
$unique='or_no';

if($_REQUEST['or_no']>0){$or_no = $_SESSION[$unique] = 	$_REQUEST['or_no'];}
elseif($_SESSION[$unique]>0){$or_no = 	$_REQUEST['or_no'] = $_SESSION[$unique];}
if(prevent_multi_submit()){
if(isset($_POST['new']))
{

		$crud   = new crud($table_master);
		$found = find_a_field($table_master,'count(1)','manual_or_no='.$_POST['manual_or_no'].' and or_date = "'.$_POST['or_date'].'"');
		if(!isset($_SESSION[$unique])) {
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		
		
		
		if($found==0){
		$$unique=$_SESSION[$unique]=$crud->insert();
		unset($$unique);
		$type=1;
		$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';
		}
		else
		{
		$type=0;
		$msg=' Double Entry';
		}
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


if(isset($_POST['confirmm']))
{
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
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
		$iii	=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$iii[1];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$xid = $crud->insert();
}
}
else
{
		$type=0;
		$msg='Data Re-entry Problem.';
}
if($_GET['del']>0)
{
		$crud   = new crud($table_details);
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		
		$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$_GET['del']."'";
		db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
		
}
if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=@each($data))
		{ $$key=$value;}
		
}

if($$unique>0) $btn_name='Update DR Information'; else $btn_name='Initiate DR Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
if($vendor_id>0) $dealer=$vendor_id; else $vendor_id=$dealer;
$vendor = find_all_field('dealer_info','dealer_name_e','dealer_code='.$dealer);

//auto_complete_from_db('item_info','finish_goods_code','concat(item_name,"#>",item_id)','product_nature="Salable" and sales_item_type like "%'.$vendor->product_group.'%"','item_id');

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
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td valign="top"><fieldset>
    <? $field='or_no';?>
      <div>
        <label for="<?=$field?>">DR  No: </label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>
    <? $field='or_date'; if($or_date=='') $or_date =date(''); ?>
      <div>
        <label for="<?=$field?>">DR Date:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
    <? $field='manual_or_no';?>
      <div>
        <label for="<?=$field?>">Serial NO:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>

        <input  name="warehouse_id" type="hidden" id="warehouse_id" value="100"  required/>

        <input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
    </fieldset></td>
    <td>
			<fieldset>
			
    <? $field='or_subject';?>
      <div>
        <label for="<?=$field?>">Note:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
      <div></div>
      <? $field='vendor_name'; ?>
      <div>
        <label for="<?=$field?>">Vendor Name  :</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$vendor->dealer_name_e.'('.$vendor->product_group.')';?>" required="required"/>
        <input  name="vendor_id" type="hidden" id="vendor_id" value="<?=($vendor_id>0)?$vendor_id:$dealer;?>" required="required"/>
      </div>
<div>
<? $field='approved_by';?>
<div>
<label for="<?=$field?>">Received By :</label>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
</div>
</div>
<div>
<? $field='party_sent_date';?>
<div>
<label for="<?=$field?>">Party Send At:</label>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
</div>
</div>
			</fieldset>	</td>
  </tr>

  <tr>
    <td colspan="2">
	<?
	$FIJ = find_a_field('journal','count(1)','tr_no='.$$unique.' and tr_from = "DamageReturn"');
	if($FIJ>0)
	{
	?>
	<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#FF0000"><div align="center">RE-ENTRY BLOCKED BY ACCOUNTS </div></td>
      </tr>
    </table>
	<?
	}
	else{
	?>
	<div class="buttonrow" style="margin-left:240px;">
      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
    </div>
	<? }?>
	</td>
    </tr>
</table>
</form>
<? if($_SESSION[$unique]>0){?>
<label>

</label>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
<? if($FIJ==0){?>
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>DR Type  </strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Un</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Pr</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Pcs</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC">
<input  name="vendor_id2" type="hidden" id="vendor_id2" value="<?=($vendor_id>0)?$vendor_id:$dealer;?>" required="required"/>
<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
<input  name="or_date" type="hidden" id="or_date" value="<?=$or_date?>"/>
<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>
<input  name="vendor_name" type="hidden" id="vendor_name" value="<?=$vendor_name?>"/>
<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:290px;" required onblur="getData2('item_return_ajax.php', 'po',this.value+'#$#<?=$vendor_id?>',document.getElementById('warehouse_id').value);"/></td>
<td colspan="3" align="center" bgcolor="#CCCCCC">

<select name="receive_type" style="width:120px;" required>
<option></option>
<? foreign_relation('damage_cause','id','damage_cause',$receive_type);?>
</select><span id="po">
<input name="unit" type="text" class="input3" id="unit" style="width:30px;" readonly="readonly"/>
<input name="price" type="text" class="input3" id="price" style="width:35px;"  readonly="readonly"/>
</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:60px;" onchange="count()" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:90px;" readonly="readonly" required/></td>
      </tr>
    </table>
<? }?>
					  <br /><br /><br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td>
<div class="tabledesign2">
<? 
$res='select a.id,b.finish_goods_code,b.item_name,d.damage_cause,a.rate as unit_price,
a.qty,
a.unit_name as unit,a.amount,d.payable  from warehouse_damage_receive_detail a,item_info b,damage_cause d where a.receive_type=d.id and b.item_id=a.item_id and a.or_no='.$or_no.' order by a.id desc';
?>
<table width="100%" cellspacing="0" cellpadding="0" id="grp">
<tbody>
<tr>
<th>S/L</th><th>Code</th><th>Item Name</th><th>Damage Cause</th><th>Unit Price</th><th>Qty</th>
<th>P-Qty</th>
<th>Unit</th><th>Amount</th>
<th>C</th>
<? if($FIJ==0){?><th>X</th><? }?>
</tr>
<? 
$query = db_query($res);
while($data=mysqli_fetch_object($query)){

$color1 = '#FFCCCC';
$color2 = '#ECFADE';
$code = $data->finish_goods_code;
$t = $t + $data->qty;
if($code_old==$code)
{
	if($data->payable=='Yes') {$total_pay = $total_pay + $data->qty;$tp = $tp + $data->qty;}
}
else
{
	$total_pay=0;
	if($data->payable=='Yes') {$total_pay = $total_pay + $data->qty;$tp = $tp + $data->qty;}
	if($color!=$color1) $color = $color1;
	else $color = $color2;
	
}


?>
<tr bgcolor="<?=$color?>">
<td><?=++$dd;?></td><td>&nbsp;<?=$data->finish_goods_code;?></td><td>&nbsp;<?=$data->item_name?></td><td>&nbsp;<?=$data->damage_cause?></td><td>&nbsp;<?=$data->unit_price?></td><td><font style="font-weight:bold; color:<?=($data->payable=='Yes')?'#FF3300':'#00CC00';?>;"><div align="right"><?=(int)$data->qty?></div></font></td>
<td align="right"><div align="right"><b>
  <?=(int)$total_pay?>
</b></div></td>
<td>&nbsp;<?=$data->unit?></td><td><div align="right"><?=$data->amount?></div></td>
<td><input type="checkbox" value="1" name="checkbox" style="width:1px" /></td>
<? if($FIJ==0){?><td><a href="?del=<?=$data->id;?>">&nbsp;X&nbsp;</a></td><? }?>
</tr>
<? $total = $total + $data->amount;$code_old=$code;}?>
<tr><td colspan="5"><span style="text-align:right;"> Total: </span></td>
  <td>
    <div align="right">
      <?=$t?>
      </div></td>
  <td>
    <div align="right">
      <?=$tp?>
      </div></td>
  <td>&nbsp;</td>
  <td align="right"><?=number_format($total,2)?></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table>
</div>
</td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>
</form>
<? if($FIJ==0){?>
<form action="select_dealer_damage_reentry.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
      <td align="center">
	  <? if(find($res)==0){?>
	  <input name="delete" id="delete"  type="submit" class="btn1" value="CANCEL REMAINNING DR" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />
	  <? }?>
	  </td>
      <td align="center"><input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/><input name="confirmm" id="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD DR" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" /></td>
    </tr>
  </table>
</form>
<? }}?>

</div>
<script>$("#codz").validate();$("#cloud").validate();</script>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>