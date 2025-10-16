<?php
session_start();
ob_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Unfinished Entry';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='do_no';




$table_details='sale_do_details';


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

$target_url = 'invoice_entry.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?request_no='+theUrl);
}
</script><div class="form-container_large">




<style>



div.form-container_large input {
    width: 250px;
    height: 38px;
    border-radius: 0px !important;
}



</style>



  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
        <tr>
          <td width="320" align="right" bgcolor="#FF9966"><strong> Date </strong></td>
          <td width="203" bgcolor="#FF9966"><input type="text" name="fdate" id="fdate" value="<?=$_POST['fdate']?>" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/></td>
          <td width="58" bgcolor="#FF9966" align="center"><strong> TO </strong></td>
          <td width="239" bgcolor="#FF9966"><input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate']?>" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/></td>
          <td width="348" rowspan="4" bgcolor="#FF9966" align="center"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
          </strong></td>
        </tr>

    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="13%">RFQ No </th>
  <th width="18%">RFQ Date </th>
  <th width="22%"><strong>Requisition Name </strong></th>
  <th width="20%">Status</th>
  <th width="27%">Entry By </th>
  </tr>


<? 

if(isset($_POST['submitit'])){

}



if($_POST['fdate']!=''&&$_POST['tdate']!=''){ $con .= ' and m.invoice_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}

if($_POST['dealer_code']!=''){ 
$con .= ' and dealer_code in ('.$_POST['dealer_code'].') ';
}
if($_POST['invoice_no']!=''){ 
$con .= ' and m.invoice_no in ('.$_POST['invoice_no'].') ';
}





   $res="select  m.* from  purchase_rfq_master m where m.status='MANUAL' ".$con." order by m.invoice_date, m.invoice_no";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>

<? //if($lc_number[$data->id]==0) { } ?>

<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->view_invoice_no;?></td>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?= date("d-m-Y",strtotime($data->invoice_date));?></td>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?= $data->view_req_no;?></td>
<td onclick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->status;?></td>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');?></td>
</tr>


<? }  ?>


</tbody></table>
</div></td>
</tr>
</table>
</div>

<?php
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>