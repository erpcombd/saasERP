<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Production Requisition List';
do_calander('#fdate');
do_calander('#tdate');
$table_master='production_requisition_master';
$unique_master='do_no';

$table_detail='sale_do_details';
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
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d H:i:s');
		//$_POST['do_date']=date('Y-m-d');
		$_POST['status']='CHECKED';
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


$table='production_requisition_master';
$show='dealer_code';
$id='do_no';
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
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" value="<?=$_POST['fdate']?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate"  value="<?=$_POST['tdate'];?>" class="form-control" />
        </strong></td>
        <td bgcolor="#FF9966" align="center"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-bg-submit"/>
        </strong></td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
	<th>No</th>
  <th>Date</th>
  <th>Status</th>
  </tr>


<? 



if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


if($_POST['product_status']) $con2 .= ' and m.status="'.$_POST['product_status'].'" != "M"';
if($_POST['product_group']=='ABCD') $con .= ' and d.product_group != "M"';
elseif($_POST['product_group']!='') $con .= ' and d.product_group = "'.$_POST['product_group'].'"';

//$res="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e,'(',team_name,')') as dealer_name, a.AREA_NAME, concat(m.payment_by) as Payment_Details,m.rcv_amt, m.mr_no from 
//production_requisition_master m,dealer_info d, area a
//where m.status in ('PROCESSING') and d.area_code=a.AREA_CODE  and m.dealer_code=d.dealer_code ".$con." and d.dealer_type='Distributor' order by m.do_date,d.dealer_name_e";




 $res="select * from production_requisition_master m
	where 1 ".$con2.$con." and m.status like 'Checked' order by m.req_no desc";
$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td onClick="custom(<?=$data->req_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->req_no;?></td>
<td onClick="custom(<?=$data->req_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->req_date;?></td>
<td onClick="custom(<?=$data->req_no;?>);" <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->status;?></td>
</tr>
<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
}

?>


</tbody></table>
</div></td>
</tr>
</table>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>