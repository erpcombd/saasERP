<?php
//
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='PO Bill Re-Check';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='do_no';

create_combobox('bill_no');
create_combobox('purchase_manager');

$table_details='sale_do_details';
//$unique_chalan='id';

$$unique=$_POST[$unique];

//if(isset($_POST['delete']))
//{
//		$crud   = new crud($table_master);
//		$condition=$unique_master."=".$$unique_master;		
//		$crud->delete($condition);
//		$crud   = new crud($table_detail);
//		$crud->delete_all($condition);
//		$crud   = new crud($table_chalan);
//		$crud->delete_all($condition);
//		unset($$unique_master);
//		unset($_SESSION[$unique_master]);
//		$type=1;
//		$msg='Successfully Deleted.';
//}
if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		//$_POST['do_date']=date('Y-m-d');
		$_POST['status']='COMPLETED';
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
		
		
		
		
		
		
		
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


$table='sale_do_master';
$do_no='do_no';
$text_field_id='do_no';

$target_url = '../po_bill/po_bill_recheck.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?bill_id='+theUrl);
}
</script><div class="form-container_large">




<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 250px;
    height: 38px;
    border-radius: 0px !important;
}



</style>



  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
        <tr>
          <td align="right" bgcolor="#FF9966"><strong>Purchase Manager:</strong></td>
          <td colspan="3" bgcolor="#FF9966">
		  
	<select name="purchase_manager" id="purchase_manager" style="width:250px;" >
		
		<option></option>

        <? foreign_relation('purchase_manager','id','purchase_manager',$_POST['purchase_manager'],'1 order by id'); ?>
    </select>		  </td>
          <td width="363" rowspan="5" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
          </strong></td>
        </tr>
      <tr>
        <td width="296" align="right" bgcolor="#FF9966"><strong>Bill No:</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		<select name="bill_no" id="bill_no" style="width:250px;">
		
		<option></option>

        <? foreign_relation('po_bill_master','bill_id','bill_no',$_POST['bill_no'],'status in ("MANUAL","CHECKED") order by bill_no'); ?>
    </select>		</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>
        <td width="151" bgcolor="#FF9966"><input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01')?>" /></td>
        <td width="73" bgcolor="#FF9966" align="center"><strong> -to- </strong></td>
        <td width="285" bgcolor="#FF9966"><input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d')?>" /></td>
      </tr>
      
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td>&nbsp;</td>
  </tr>
  
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="15%">Bill No </th>
  <th width="19%"> Bill Date </th>
  <th width="35%">Purchase Manager</th>
  <th width="12%">Status</th>
  <th width="19%">Entry By </th>
</tr>


<? 

if(isset($_POST['submitit'])){


if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and a.bill_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


if($_POST['bill_no']!='') 
$con .= ' and a.bill_id in ('.$_POST['bill_no'].') ';

if($_POST['purchase_manager']!='') 
$con .= ' and a.purchase_manager in ('.$_POST['purchase_manager'].') ';


     $res="select a.* from po_bill_master a, po_bill_details b where a.bill_id=b.bill_id and a.status!='COMPLETED'  ".$con."  group by a.bill_id order by a.bill_date,a.bill_id";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>

<?php /*?><? if($revise_request[$data->do_no]>0) { } ?><?php */?>

<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->bill_id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->bill_no;?></td>
<td onClick="custom(<?=$data->bill_id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?php echo date('d-m-Y',strtotime($data->bill_date));?></td>
<td onClick="custom(<?=$data->bill_id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=find_a_field('purchase_manager','purchase_manager','id='.$data->purchase_manager);?></td>
<td onClick="custom(<?=$data->bill_id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->status;?></td>
<td onClick="custom(<?=$data->bill_id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
</tr>


<?
}

}
?>


</tbody></table>
</div></td>
</tr>
</table>
</div>

<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>