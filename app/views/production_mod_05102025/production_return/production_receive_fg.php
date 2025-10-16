<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Production Line Issue';

//	$sql = 'select pr_no from production_floor_receive_master';
//	$query = db_query($sql);
//	while($data=mysqli_fetch_object($query))
//	{auto_insert_recipe_pr_id($data->pr_no);}
	
do_calander('#pr_date');
$page = 'production_receive_fg.php';
if($_POST['line_id']>0) 
$line_id = $_SESSION['line_id']=$_POST['line_id'];
elseif($_SESSION['line_id']>0) 
$line_id = $_POST['line_id']=$_SESSION['line_id'];


$table_master='production_floor_receive_master';
$unique_master='pr_no';

$table_detail='production_floor_receive_detail';
$unique_detail='id';

if($_REQUEST['old_pr_no']>0)
$$unique_master=$_REQUEST['old_pr_no'];
else
$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){
if(isset($_POST['new']))
{
		$crud   = new crud($table_master);
		$$unique_master=$_POST[$unique_master];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['warehouse_to']=$line_id;
		if($_POST['flag']<1){
		$crud->insert();
		
		$type=1;
		$msg='Product Issued. (PI No-'.$$unique_master.')';
		}
		else {
		$crud->update($unique_master);
		$type=1;
		$msg='Successfully Updated.';
		}
}

if(isset($_POST['confirm'])&&($_POST[$unique_master]>0))
{
		$sql = 'select * from item_info where item_id in (select fg_item_id from production_line_fg where line_id="'.$line_id.'")';
		$query = db_query($sql);
		while($data = mysqli_fetch_object($query)){
		if($_POST['total_unit_'.$data->item_id]>0){	
		$total_amt = $_POST['total_unit_'.$data->item_id]*$data->cost_price;
		
		$do = "INSERT INTO production_floor_receive_detail 
		(pr_no, pr_date, item_id, warehouse_from, warehouse_to, total_unit, unit_price, total_amt) VALUES 
('".$_POST['pr_no']."', '".$_POST['pr_date']."', '".$data->item_id."', '0', '".$line_id."', '".$_POST['total_unit_'.$data->item_id]."', '".$data->cost_price."', '".$total_amt."')";
		db_query($do);

$xid = db_insert_id();
journal_item_control($data->item_id ,$line_id,$_POST['pr_date'],$_POST['total_unit_'.$data->item_id],'0','Production',$xid,'0','0',$_POST['pr_no']);

		}}

echo '<script type="text/javascript">parent.parent.document.location.href = "select_production_line_fg.php?sucess=1";</script>';
		
}

}
else
{
	$type=0;
	$msg='Data Re-Submit Error!';
}

//if(isset($_POST['new']))
//{
//$$unique_master=$_POST[$unique_master]; 
//
//		$crud   = new crud($unique_master);
//		$condition=$unique_master."=".$$unique_master;		
//		$crud->delete_all($condition);
//		db_query($sql);
//		$type=1;
//		$msg='Successfully Deleted.';
//		echo '<script type="text/javascript">parent.parent.document.location.href = "select_production_line_fg.php?sucess=1";</script>';
//}

if($$unique_master>0)
{
		$condition=$unique_master."=".$$unique_master;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=@each($data))
		{ $$key=$value;}
		
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
<div class="form-container_large">
<form action="<?=$page?>" method="post" name="codz2" id="codz2">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset style="width:240px;">
    <div>
      <label style="width:75px;">PR No : </label>

      <input style="width:155px;"  name="pr_no" type="text" id="pr_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>
    </div>
    <div>
      <label style="width:75px;">Carried by : </label>
      <label>
      <input name="carried_by" type="text" id="carried_by" value="<?=$carried_by?>"  style="width:155px;"/>
      </label>
      <label style="width:75px;">Product For : </label>
      <label>
      <select name="production_for"  style="width:155px;">
      <option <?=($production_for=='Local')?'Selected':'';?> value="Local">Local</option>
      <option <?=($production_for=='Export')?'Selected':'';?> value="Export">Export</option>
      </select>
      </label>
</div>
    </fieldset></td>
    <td>
			<fieldset style="width:220px;">
			  <div>
			    <label style="width:105px;">Issue Date : </label>
			    <input style="width:105px;"  name="pr_date" type="text" id="pr_date" value="<?=($pr_date=='')?'':$pr_date;?>" required/>
		      </div>
			  <div>
			    <label style="width:105px;">Batch NO: </label>
			    <input name="remarks" type="text" id="remarks" style="width:105px;" value="<?=$remarks?>" tabindex="105" required />
		      </div>
		</fieldset>	</td>
    <td><fieldset style="width:240px;">
      <div>
        <label style="width:75px;">PL Name : </label>
        <input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$line_id?>" />
        <input name="warehouse_from3" type="text" id="warehouse_from3" style="width:155px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>" />
      </div>
      
            <div>
        <label style="width:75px;">Rec From : </label>
        <input name="warehouse_to" type="text" id="warehouse_to"  value="<?=$warehouse_to?>" style="width:155px;" />
      </div>
    </fieldset></td>
  </tr>
  <tr>
    <td colspan="3"><div class="buttonrow" style="margin-left:240px;">
    <? if($$unique_master>0) {?>
<input name="new" type="submit" class="btn1" value="Update Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="1" />
<? }else{?>
<input name="new" type="submit" class="btn1" value="Initiate Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />
<input name="flag" id="flag" type="hidden" value="0" />
<? }?>
    </div></td>
    </tr>
</table>
</form>
<form action="select_production_line_fg.php?sucess=1" method="post" name="codz2" id="codz2" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>
<input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>"/>
<input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
<input  name="pr_date" type="hidden" id="pr_date" value="<?=$pr_date?>"/>

<? if($$unique_master>0){?>
<table  width="80%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
    <td width="10%" align="center" bgcolor="#0099FF"><strong>FG Code </strong></td>
    <td width="60%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
    <td width="10%" align="center" bgcolor="#0099FF"><span style="font-weight: bold">Unit</span></td>
    <td width="10%" align="center" bgcolor="#0099FF"><span style="font-weight: bold">Stock</span></td>
    <td width="10%" align="center" bgcolor="#0099FF"><strong> Qty</strong></td>
    </tr>
<? 
$sql = 'select * from item_info where item_id in (select fg_item_id from production_line_fg where line_id="'.$line_id.'") order by item_name';
$query = db_query($sql);
while($data = mysqli_fetch_object($query)){
?>
  <tr>
    <td  bgcolor="#CCCCCC"><div align="left">
      <?=$data->finish_goods_code?></div></td>
    <td  bgcolor="#CCCCCC"><div align="left">
        <?=$data->item_name?>
    </div></td>
    <td align="center" bgcolor="#CCCCCC"><?=$data->unit_name?></td>
    <td align="center" bgcolor="#CCCCCC"><?=number_format(warehouse_product_stock($data->item_id ,$line_id),2);?></td>
    <td align="center" bgcolor="#CCCCCC"><input name="total_unit_<?=$data->item_id?>" type="text" class="input3" id="total_unit_<?=$data->item_id?>"  maxlength="100" style="width:67px;" required="required" value="0"/></td>
    </tr>
<? }?>
</table>
<br />
<br />

<? 

$res='select a.id,b.item_id as item_code,b.item_name,b.unit_name,a.total_unit,"X" from production_floor_issue_detail a,item_info b where b.item_id=a.item_id and a.pr_no='.$$unique_master.' order by b.item_name';
?>


<table width="100%" border="0">
  <tr>
      <td align="center"><input  name="pr_no" type="hidden" id="pr_no" value="<?=$$unique_master?>"/>
        <span style="text-align:right">
        <input name="del" type="submit" class="btn1" value="DELETE" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#FF3333; float:right" />
        </span>
		</td>
      <td align="right" style="text-align:right">
      <input name="confirm" type="submit" class="btn1" value="CONFIRM AND ISSUE" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />
      </td>
      
    </tr>
</table>


<? }?>
</form>
</div>
<script>$("#cz").validate();$("#cloud").validate();</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>