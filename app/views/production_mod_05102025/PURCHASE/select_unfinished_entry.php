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
    <table style="width:80%" border="0" class="text-center"><th></th>
        <tr>
          <td style="width:320px" style="background-color:#FF9966; text-align: right"><strong> Date </strong></td>
          <td style="width:203px" style="background-color:#FF9966;"><input type="text" name="fdate" id="fdate" value="<?=$_POST['fdate']?>" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/></td>
          <td style="width:58px" style="background-color:#FF9966;" class="text-center"><strong> TO </strong></td>
          <td style="width:239px" style="background-color:#FF9966;"><input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate']?>" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/></td>
          <td style="width:348px" rowspan="4" style="background-color:#FF9966;" class="text-center"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
          </strong></td>
        </tr>
      
    </table>
  </form>
  <table class="w-100" border="0"><th></th>
<tr>
<td><div class="tabledesign2">
<table style="width:100%" id="grp"><tbody>
<tr>
  <th style="width:9%"><strong>PO No</strong> </th>
  <th style="width:13%"><strong>PO  Date </strong></th>
  <th style="width:15%"><strong>QUOTE </strong>No </th>
  <th style="width:29%"><strong>Vendor Name </strong></th>
  <th style="width:21%">Entry By </th>
  </tr>


<? 

if(isset($_POST['submitit'])){
// empty condition
}



if($_POST['fdate']!=''&&$_POST['tdate']!=''){ $con .= ' and m.invoice_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}

if($_POST['dealer_code']!=''){ 
$con .= ' and dealer_code in ('.$_POST['dealer_code'].') ';
}
if($_POST['invoice_no']!=''){ 
$con .= ' and m.invoice_no in ('.$_POST['invoice_no'].') ';
}


 		



   $res="select  m.* from  purchase_foreign_master m where m.status='MANUAL' ".$con." order by m.invoice_date, m.invoice_no";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>



<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'';?>><?=$data->view_invoice_no;?></td>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'';?>>&nbsp;<?= date("d-m-Y",strtotime($data->invoice_date));?></td>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'';?>><?=$data->view_quote_no;?></td>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'';?>>&nbsp;<?= find_a_field('vendor','vendor_name','vendor_id="'.$data->vendor_id.'"');?></td>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'';?>><?= find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');?></td>
</tr>


<? }  ?>


</tbody></table>
</div></td>
</tr>
</table>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>