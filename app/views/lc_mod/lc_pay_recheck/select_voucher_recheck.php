<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='L/C Journal Re-Check';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique_master='do_no';

create_combobox('lc_no');
create_combobox('dealer_code');

$table_detail='sales_return_detail';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';

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
		$do_no=$_POST['do_no'];

		$_POST[$unique_master]=$$unique_master;
		$_POST['send_to_depot_at']=date('Y-m-d H:i:s');
		$_POST['do_date']=date('Y-m-d');
		$_POST['status']="CHECKED";
		
		
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
				unset($_POST);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


$table='sale_do_master';
$show='dealer_code';
$id='do_no';
$text_field_id='do_no';

$target_url = 'lc_payment_recheck.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?payment_no='+theUrl);
}
</script>


<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 280px;
    height: 38px;
    border-radius: 0px !important;
}



</style>

<div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>L/C No:</strong></td>
        <td colspan="3" bgcolor="#FF9966">
		<select name="lc_no" id="lc_no" style="width:280px;">
		
		<option></option>

        <? //foreign_relation('lc_number_setup','id','lc_number',$_POST['lc_no'],'1');?>
		
		 <? foreign_relation('lc_bank_entry','lc_no','bank_lc_no',$_POST['lc_no'],'1'); ?>
    </select>		</td>
        <td rowspan="5" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
      
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval:</strong></td>
        <td  bgcolor="#FF9966"><strong>

          <input type="text" name="fdate" id="fdate" value="<?=$_POST['fdate']?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate']?>" />
        </strong></td>
      </tr>
      
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="17%">L/C No </th>
  <th width="10%">Payment No </th>
  <th width="14%">Payment Date</th>
  <th width="20%">Payment Type </th>
  <!--<th>Zone</th>-->
<th width="19%">Payment Amt </th>
  </tr>


<? 

if(isset($_POST['submitit'])){

if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and p.payment_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


		
		
		if($_POST['lc_no']!='')
 		$lc_no_con=" and l.id='".$_POST['lc_no']."'";


     $res="select l.id, l.lc_number, p.payment_no, p.payment_date, p.bill_type, sum(p.pay_amt_in) as payment_amt
	
	from lc_number_setup l, lc_bill_payment p, lc_purchase_master m
	where  l.id=p.lc_no and l.id=m.lc_no and p.pay_amt_in>0 ".$lc_no_con.$con."  group by p.payment_no order by  m.po_date, l.id ";
$query = db_query($res);

//$two_weeks = time() - 14*24*60*60;
while($data = mysqli_fetch_object($query))
{

?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->payment_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->lc_number;?></td>
<td onClick="custom(<?=$data->payment_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->payment_no;?></td>
<td onClick="custom(<?=$data->payment_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?php echo date('d-m-Y',strtotime($data->payment_date));?></td>
<td onClick="custom(<?=$data->payment_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('lc_bill_type','bill_type','id='.$data->bill_type);?></td>
<td onClick="custom(<?=$data->payment_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=number_format($data->payment_amt,2);?></td>
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