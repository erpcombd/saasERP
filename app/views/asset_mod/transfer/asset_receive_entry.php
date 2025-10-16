<?php

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$title='Receive Information';

//do_calander('#pr_date','-15','0');
$page = 'production_receive.php';


$table_master='asset_transfer_master';
$unique_master='pi_no';

$table_detail='asset_transfer_details';
$unique_detail='id';
if($_GET['tr_no']>0){
$$unique_master = $_SESSION[$unique_master] = $_GET['tr_no'];
}

if(isset($_POST['confirm']))
{
 $res='select a.id,a.item_id,b.unit_name,a.pi_no,a.pi_date,a.serial_no,a.warehouse_to,a.warehouse_from,b.product_type, a.total_unit as total_qty, a.unit_price, a.total_amt from asset_transfer_details a,item_info b where a.status!="COMPLETE" and b.item_id=a.item_id and a.pi_no='.$_SESSION[$unique_master].' order by a.id';
  $qry = db_query($res);
  while($data = mysqli_fetch_object($qry)){
  $checked = $_POST['check_'.$data->id];
  if($checked=='checked'){

$journal_item_sql = 'insert into journal_asset_item (`ji_date`,`item_id`,`warehouse_id`,`serial_no`,`item_in`,`item_price`,`final_price`,`tr_from`,`tr_no`,`sr_no`,`entry_by`,`entry_at`,`primary_id`,`group_for`) value("'.$data->pi_date.'","'.$data->item_id.'","'.$_SESSION['user']['depot'].'","'.$data->serial_no.'","'.$data->total_qty.'","'.$data->unit_price.'","'.$data->unit_price.'","Transfered","'.$data->id.'","'.$data->pi_no.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d h:i:s').'","'.$data->id.'","'.$_SESSION['user']['group'].'")';
db_query($journal_item_sql);


$update_journal_item = 'update journal_asset_item set tr_from="Transfered" where sr_no="'.$_SESSION[$unique_master].'" and item_id="'.$data->item_id.'" and primary_id="'.$data->id.'"';
db_query($update_journal_item);

  $update = 'update asset_transfer_details set status="COMPLETE" where id="'.$data->id.'"';
  db_query($update);
  
  }
  }
  
  $issue_check = find_a_field('asset_transfer_details','pi_no','pi_no="'.$_SESSION[$unique_master].'" and status in ("MANUAL","","SEND")');
  if($issue_check==0 || $issue_check==''){
  $m_update = 'update asset_transfer_master set status="RECEIVED" where pi_no="'.$_SESSION[$unique_master].'"';
  db_query($m_update);
  }
  
  unset($_SESSION[$unique_master]);
  unset($$unique_master);
  header('location:asset_receive.php');
}



if($$unique_master>0)
{
		$condition=$unique_master."=".$$unique_master;
		$data=db_fetch_object($table_master,$condition);

        foreach($data as $key =>$value)

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
<form action="" method="post" name="codz2" id="codz2">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset style="width:240px;">
    <div>
      <label style="width:75px;">Transfer No: </label>

      <input style="width:155px;"  name="pi_no" type="text" id="pi_no" value="<?=$$unique_master?>" readonly/>
	  <input type="hidden" name="issue_no" id="issue_no" value="<?=$_POST['issue_no']?>" />
    </div>
    <div>
      <label style="width:75px;">Received by:</label>
          <select style="width:155px;" id="received_by" name="received_by" readonly="readonly">
            
                <? foreign_relation('user_activity_management','user_id','fname',$received_by,'user_id="'.$_SESSION['user']['id'].'"');?>
              </option>
          </select>
      </div>
    </fieldset></td>
    <td>
			<fieldset style="width:220px;">
			  <div>
			    <label style="width:105px;">Receive Date : </label>
			    <input style="width:105px;"  name="pr_date" type="text" id="pr_date" value="<?=date('Y-m-d')?>" readonly/>
		      </div>
			  <div>
			    <label style="width:105px;">Note: </label>
			    <input name="remarks" type="text" id="remarks" style="width:105px;" value="<?=$remarks?>" tabindex="105" />
		      </div>
		</fieldset>	</td>
    <td><fieldset style="width:240px;">
      <div>
        <label style="width:75px;">Send From: </label>
        <input name="warehouse_to" type="hidden" id="warehouse_to"  value="<?=$warehouse_from?>" />
		<input name="receive_type" type="hidden" id="receive_type"  value="Sample Receive" />
		
        <input name="warehouse_from3" type="text" id="warehouse_from3" style="width:155px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_from)?>" readonly="readonly" />
      </div>
      
            <div>
        <label style="width:75px;">Received: </label>
        <input name="warehouse_from" type="hidden" id="warehouse_from"  value="<?=$warehouse_to?>" />
        <input name="warehouse_from4" type="text" id="warehouse_from4" style="width:155px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_to)?>" readonly="readonly" />
      </div>
    </fieldset></td>
  </tr>
  
</table>
</form>
<form action="" method="post" name="codz2" id="codz2" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<? if($$unique_master>0){?>
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
  <tr>
    <td align="center" bgcolor="#0099FF" style="width:100px"><strong>Select</strong></td>
	<td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
    <td align="center" bgcolor="#0099FF"><span style="font-weight: bold">Serial No</span></td>
    <td align="center" bgcolor="#0099FF"><span style="font-weight: bold">Qty </span></td>
    
    
  <?
  echo $res='select a.id,b.finish_goods_code as FG_code,b.item_name,b.unit_name,a.serial_no, a.total_unit as total_qty, a.unit_price, a.total_amt, "X" from asset_transfer_details a,item_info b where b.item_id=a.item_id and a.status in ("SEND") and a.pi_no='.$_SESSION[$unique_master].' order by a.id';
  $qry = db_query($res);
  while($data = mysqli_fetch_object($qry)){

?>
     <tr>
	 <td align="center" bgcolor="#ccc"><input type="checkbox" name="check_<?=$data->id?>" id="check_<?=$data->id?>" value="checked" /></td>
    <td align="center" bgcolor="#ccc"><strong><?=$data->item_name?>
	<input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>
    <input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>"/>
    <input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
      <input  name="pr_date" type="hidden" id="pr_date" value="<?=$pr_date?>"/>
	
	</strong></td>
    <td align="center" bgcolor="#ccc"><span style="font-weight: bold"><?=$data->serial_no?></span></td>
    <td align="center" bgcolor="#ccc"><span style="font-weight: bold"><?=$data->total_qty?></span></td>
   
  </tr>
  <? } ?>
  
</table>
<br /><br /><br /><br />


<table width="100%" border="0">
  <tr>
      <td align="center"><input  name="<?=$unique_master?>" type="hidden" id="<?=$unique_master?>" value="<?=$$unique_master?>"/>
    <input  name="warehouse_from" type="hidden" id="warehouse_from" value="<?=$warehouse_from?>"/>
    <input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
      <input  name="pr_date" type="hidden" id="pr_date" value="<?=$pr_date?>"/><input  name="pr_no" type="hidden" id="pr_no" value="<?=$$unique_master?>"/></td><td align="right" style="text-align:right">
      <input name="confirm" type="submit" class="btn1" value="CONFIRM AND RECEIVE" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090; float:right" />
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
