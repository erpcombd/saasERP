<?php
 
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='L/C Shipment Entry';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='do_no';

 
$table_details='sale_do_details';
//$unique_chalan='id';

$$unique=$_POST[$unique];
 
if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
	 
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


$table='lc_number_setup';
$lc_no='id';
$text_field_id='id';

$target_url = '../lc/lc_bank_payment.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?pay_id='+theUrl);
}
</script><div class="form-container_large">




<style>
 

div.form-container_large input {
    width: 250px;
    height: 38px;
    border-radius: 0px !important;
}



</style>



   
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="5%">ID</th>
  <th width="19%">PI NO </th>
  <th width="16%"> Bank L/C No </th>
  <th width="21%"><strong>L/C  Number  </strong></th>
  <th width="12%">L/C Type </th>
  <th width="19%">Company</th>
  <th width="8%">Status</th>
</tr>


<? 

if(isset($_POST['submitit'])){

}

if($_POST['dealer_code']!='') 
$con .= ' and dealer_code in ('.$_POST['dealer_code'].') ';

if($_POST['batch_no']!='') 
$con .= ' and batch_no in ('.$_POST['batch_no'].') ';



// 		echo  $sql = "select lc_no, sum(pay_amt_usd) as pay_amt_usd  from lc_bank_payment where 1 group by lc_no ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $pay_amt_usd[$info->lc_no]=$info->pay_amt_usd;
//		}



   $res="select * from lc_bank_entry where status='CHECKED'  order by id";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>

<? //if($pay_amt_usd[$data->lc_no]<$data->lc_value) {  ?>

<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->id;?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->pi_no;?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->bank_lc_no;?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->lc_number;?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('lc_type','lc_type','id="'.$data->lc_type.'"');?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('user_group','group_name','id="'.$data->group_for.'"');?></td>
<td onClick="custom(<?=$data->id;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->status;?></td>
</tr>


<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;

//}
 } ?>


</tbody></table>
</div></td>
</tr>
</table>
</div>

<?
 
require_once SERVER_CORE."routing/layout.bottom.php";
?>