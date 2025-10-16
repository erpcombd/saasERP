<?php
session_start();
ob_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Purchase Order';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='do_no';

create_combobox('quote_no');
//create_combobox('dealer_code');



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
	window.open('<?=$target_url?>?quote_no='+theUrl);
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
          <td width="320" align="right" style="background-color:#FF9966;"><strong> Date: </strong></td>
          <td width="203" style="background-color:#FF9966;"><input type="text" name="fdate" id="fdate" value="<?=$_POST['fdate']?>" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/></td>
          <td width="58" style="background-color:#FF9966;" align="center"><strong> TO </strong></td>
          <td width="243" style="background-color:#FF9966;"><input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate']?>" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/></td>
          <td width="344" rowspan="5" style="background-color:#FF9966;" align="center"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
          </strong></td>
        </tr>
        <tr>
          <td align="right" style="background-color:#FF9966;"><strong> QUOTE No: </strong></td>
          <td colspan="3" style="background-color:#FF9966;">
		<select name="quote_no" id="quote_no" style="width:200px;" >

        <option value=""></option>

		<? foreign_relation('purchase_quotation_master','invoice_no','view_invoice_no',$_POST['quote_no'],'1 group by invoice_no');?>

      </select>
		  </td>
        </tr>
      <?php /*?><tr>
        <td width="266" align="right" style="background-color:#FF9966;"><strong>Challan No:</strong></td>
        <td colspan="3" style="background-color:#FF9966;">
		
	
	<input type="text" name="invoice_no" id="invoice_no" value="<?=$_POST['invoice_no']?>" style="width:150px; font-weight:bold; font-size:12px; height:30px; color:#090"/>		</td>
      </tr><?php */?>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="13%"><strong>QUOTE</strong><strong> </strong>No </th>
  <th width="18%"><strong>QUOTE</strong><strong> </strong>Date </th>
  <th width="21%">REQ. No </th>
  <th width="23%"><strong>Vendor Name </strong></th>
  <th width="25%">Entry By </th>
  </tr>


<? 

if(isset($_POST['submitit'])){





if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.invoice_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['dealer_code']!='') 
$con .= ' and dealer_code in ('.$_POST['dealer_code'].') ';

if($_POST['invoice_no']!='') 
$con .= ' and m.invoice_no in ('.$_POST['invoice_no'].') ';


 	if($_POST['quote_no']!='')
	$quote_no_con=" and m.invoice_no='".$_POST['quote_no']."'";



 		//$sql = "select lc_no, lc_no as lc_number  from lc_bank_entry where 1 group by lc_no ";
//		 $query = db_query($sql);
//		 while($info=mysqli_fetch_object($query)){
//  		 $lc_number[$info->lc_no]=$info->lc_number;
//		}



   $res="select  m.* from  purchase_quotation_master m, purchase_quotation_details d where m.invoice_no=d.invoice_no and  m.status!='MANUAL'  ".$con.$quote_no_con." group by m.invoice_no order by m.invoice_date, m.invoice_no";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>

<? //if($lc_number[$data->id]==0) { } ?>

<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->view_invoice_no;?></td>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?= date("d-m-Y",strtotime($data->invoice_date));?></td>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->view_req_no;?></td>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('vendor','vendor_name','vendor_id="'.$data->vendor_id.'"');?></td>
<td onClick="custom(<?=$data->invoice_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');?></td>
</tr>


<? } } ?>


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