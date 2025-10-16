<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Competitive Sourcing';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='do_no';





$table_details='sale_do_details';


$unique=$_POST[$unique];


if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		//$_POST['do_date']=date('Y-m-d');
		$_POST['status']='COMPLETED';
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
		
		
		
		
		
		
		
		unset($unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


$table='lc_number_setup';
$lc_no='id';
$text_field_id='id';

$target_url = 'quotation_cs_create.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?req_no='+theUrl);
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
    <table style="width:80%; margin:0 auto; border-collapse:collapse; text-align:center;">
        <tr>
            <td style="width:320px; text-align:right; background-color:#FF9966;">
                <strong>Date:</strong>
            </td>
            <td style="width:203px; background-color:#FF9966;">
                <input type="text" name="fdate" id="fdate" 
                       value="<?= $_POST['fdate'] ?? '' ?>" 
                       style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090;" />
            </td>
            <td style="width:58px; text-align:center; background-color:#FF9966;">
                <strong>TO</strong>
            </td>
            <td style="width:243px; background-color:#FF9966;">
                <input type="text" name="tdate" id="tdate" 
                       value="<?= $_POST['tdate'] ?? '' ?>" 
                       style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090;" />
            </td>
            <td style="width:344px; text-align:center; background-color:#FF9966;" rowspan="5">
                <strong>
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" 
                           style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090;" />
                </strong>
            </td>
        </tr>
        <tr>
            <td style="text-align:right; background-color:#FF9966;">
                <strong>REQ. No:</strong>
            </td>
            <td colspan="3" style="background-color:#FF9966;">
                <input type="text" list="req" name="req_no" id="req_no" 
                       value="<?= $_POST['req_no'] ?? '' ?>" />
                <datalist id="req">
                    <option value=""></option>
                    <? foreign_relation('requisition_master','req_no','req_no',$_POST['req_no'],'1 and status="CHECKED"'); ?>
                </datalist>
            </td>
        </tr>
    </table>
</form>

  <table style="width:100%; border-collapse:collapse; border:0; padding:0; margin:0;">
<tr>
<td><div class="tabledesign2">
<table id="grp" style="width:100%; border-collapse:collapse; padding:0; margin:0;"><tbody>
<tr>
    <th style="width:14%;"><strong>REQ</strong> No</th>
    <th style="width:19%;"><strong>REQ Date</strong></th>
    <th style="width:23%;"><strong>Warehouse</strong></th>
    <th style="width:24%;">Entry By</th>
</tr>



<? 

if(isset($_POST['submitit'])){} 





if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and r.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['dealer_code']!='') 
$con .= ' and dealer_code in ('.$_POST['dealer_code'].') ';

if($_POST['invoice_no']!='') 
$con .= ' and m.invoice_no in ('.$_POST['invoice_no'].') ';


 	if($_POST['req_no']!='')
	$req_no_con=" and r.req_no='".$_POST['req_no']."'";






    $res="select  r.* from   requisition_master r, purchase_quotation_master q where r.req_no=q.req_no and  q.status!='MANUAL'  ".$con.$req_no_con." group by r.req_no order by r.req_date, r.req_no";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>

<? //if($lc_number[$data->id]==0) { } ?>

<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->req_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->req_no;?></td>
<td onClick="custom(<?=$data->req_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?= date("d-M-Y",strtotime($data->req_date));?></td>
<td onClick="custom(<?=$data->req_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('warehouse','warehouse_name','warehouse_id="'.$data->warehouse_id.'"');?></td>
<td onClick="custom(<?=$data->req_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');?></td>
</tr>


<? } ?>


</tbody></table>
</div></td>
</tr>
</table>
</div>

<?
 
require_once SERVER_CORE."routing/layout.bottom.php";
?>