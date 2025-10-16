<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Delivery Order Chalan Status';
do_calander('#fdate');
do_calander('#tdate');
do_calander('#req_date');
$table_master='production_requisition_master';
$unique_master='req_no';

$table_detail='production_requisition_order';
$unique_detail='id';

$$unique_master=$_POST[$unique_master];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		$crud   = new crud($table_chalan);
		$crud->delete_all($condition);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_POST['confirm']))
{

		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['entry_by'] = $_SESSION['user']['id'];
		$_POST['warehouse_id'] = $_SESSION['user']['depot'];

		$_POST['status']='CHECKED';
		$crud   = new crud($table_master);
		$xid = $crud->insert();
		
	if($_POST['fdate']!=''&&$_POST['tdate']!=''){ $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';	}
		
	$res="select m.do_no,m.do_date,d.item_id, i.item_name, m.status, i.finish_goods_code , sum(d.total_unit) as qty from 
	sale_do_master m,sale_do_details d, item_info i
	where m.do_no=d.do_no and i.item_id=d.item_id ".$con2.$con." and m.status like 'Checked' group by d.item_id order by m.do_no desc";
	$query = db_query($res);
	while($data = mysqli_fetch_object($query))
	{
		$crud = new crud($table_detail);
		
		$_POST['req_no']= $xid;
		$_POST['item_id'] = $data->item_id;
		$_POST['qoh'] = $data->qty;
		$_POST['qty'] = $_POST['prod_qty_'.$data->item_id];
		$_POST['unit_name'] = $_POST['unit_name_'.$data->item_id];
		
		$crud->insert();
	}	
		
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}



$text_field_id='old_do_no';

$target_url = '../do/do_view.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?do_no='+theUrl);
}
</script>
<div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table style="width:80%; margin:auto" border="0" ><th></th>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style="background-color:#FF9966; text-align:right"><strong>Date Interval :</strong></td>
        <td style="background-color:#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" value="<?=$_POST['fdate']?>" />
        </strong></td>
        <td style="background-color:#FF9966; text-align:center"><strong> -to- </strong></td>
        <td style="background-color:#FF9966"><strong>
          <input type="text" name="tdate" id="tdate"  value="<?=$_POST['tdate'];?>" class="form-control" />
        </strong></td>
        <td style="background-color:#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-bg-submit"/>
        </strong></td>
      </tr>
    </table>
  </form>
  <table style="width:100%" border="0" ><th></th>
<tr>
<td>
<form action="" method="post">
<table style="width:100%" id="grp"><th></th>
	<tr>
		<td>Req No: <input type="text" name="req_no" value=""  /></td>
		<td>Date : <input type="text" name="req_date" id="req_date" value="<?=date('Y-m-d')?>"  />
		
		<input type="hidden" name="fdate" id="fdate" value="<?=$_POST['fdate']?>" />
		 <input type="hidden" name="tdate" id="tdate"  value="<?=$_POST['tdate'];?>" class="form-control" />
		</td>
	</tr>

</table>

<div class="tabledesign2">
<table style="width:100%" id="grp"><tbody>
<tr>
	<th>Order No</th>
  	<th>Code</th>
  	<th>Product Name</th>
	<th>Order Qty</th>
	<th>Stock</th>
	<th>Production Qty</th>
 </tr>
<? 



if($_POST['fdate']!=''&&$_POST['tdate']!=''){ $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}


if($_POST['product_status']){ $con2 .= ' and m.status="'.$_POST['product_status'].'" != "M"';}
if($_POST['product_group']=='ABCD'){ $con .= ' and d.product_group != "M"';}
elseif($_POST['product_group']!=''){ $con .= ' and d.product_group = "'.$_POST['product_group'].'"';}



 $res="select m.do_no,m.do_date,d.item_id, i.item_name, i.unit_name, m.status, i.finish_goods_code , sum(d.total_unit) as qty from 
sale_do_master m,sale_do_details d, item_info i
where m.do_no=d.do_no and i.item_id=d.item_id ".$con2.$con." and m.status like 'Checked' group by d.item_id order by m.do_no desc";
$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td <?=(++$z%2)?'':'';?>>&nbsp;<?=$data->do_no;?></td>
<td <?=(++$z%2)?'':'';?>>&nbsp;<?=$data->finished_goods_code;?></td>
<td <?=(++$z%2)?'':'';?>>&nbsp;<?=$data->item_name;?></td>
<td style="text-align:center" <?=(++$z%2)?'':'';?>>&nbsp;<?=$data->qty;?></td>
<td <?=(++$z%2)?'':'';?>>&nbsp;<?=find_a_field('journal_item','sum(item_in-item_ex)','item_id='.$data->item_id.' and warehouse_id='.$_SESSION['user']['depot']);?></td>
<td <?=(++$z%2)?'':'';?>>
	<input type="text" name="prod_qty_<?=$data->item_id;?>" value=""  />	
	<input type="hidden" name="unit_name_<?=$data->item_id;?>" value="<?=$data->unit_name;?>"  />
</td>
</tr>
<?


}

?>



</tbody></table>
</div>
<div class="text-center mt-3">
	<input type="submit" class="btn1 btn1-bg-submit text-center" value="Confirm"  name="confirm" />
</div>
</td>
</tr>
</table>
</div>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>