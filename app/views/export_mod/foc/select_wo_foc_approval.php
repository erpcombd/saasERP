<?php
//
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='FOC Approval';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_foc_master';
$unique='foc_no';

create_combobox('foc_no');

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
		$_POST['entry_at']=date('Y-m-d H:s:i');
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


$table='sale_foc_master';
$do_no='foc_no';
$text_field_id='foc_no';

$target_url = 'foc_order_print_view.php';



if(isset($_POST['approved'])){

		$_POST['checked_at']=date('Y-m-d H:i:s');;

		$_POST['checked_by']=$_SESSION['user']['id'];


	 $sql = "update sale_foc_master set status='CHECKED', checked_by='".$_POST['checked_by']."', checked_at='".$_POST['checked_at']."' where foc_no=".$_POST['foc_no']."";
	db_query($sql);

	$type=1;

	$msg='Work Order Is Been Hold.';

}



?>

<style>

/*.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
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

<div class="form-container_large">

<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
</script>

  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td width="153">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td width="141">&nbsp;</td>
      </tr>
      <tr>
        
        <td rowspan="3" bgcolor="#FF9966">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Job No: </strong></td>
        <td bgcolor="#FF9966">
		<select name="foc_no" id="foc_no" style="width:250px;">
		
		<option></option>

        <?
		
		foreign_relation('sale_foc_master','foc_no','job_no',$_POST['foc_no'],'1');

		?>
    </select>		</td>
        <td bgcolor="#FF9966"><strong>
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
  <th width="9%">FOC No </th>
  <th width="13%">FOC Date </th>
  <th width="11%">Job No </th>
  <th width="20%">Customer</th>
  <th width="16%">Buyer </th>
  <th width="17%">Merchandiser</th>
  <th width="14%">Action</th>
</tr>


<? 

if(isset($_POST['submitit'])){

}

//if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['dealer_code']!='') 
$con .= ' and m.dealer_code in ('.$_POST['dealer_code'].') ';

if($_POST['foc_no']!='') 
$con .= ' and m.foc_no in ('.$_POST['foc_no'].') ';



  $res="select m.foc_no, m.foc_no, m.foc_date,  m.job_no, m.dealer_code, m.do_date,   m.buyer_code, m.merchandizer_code, m.status from sale_foc_master m, sale_foc_details d where m.do_no=d.do_no and m.status='UNCHECKED'  ".$con." group by m.foc_no order by m.foc_date, m.foc_no ";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
  <td onClick="custom(<?=$data->foc_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->foc_no;?></td>
<td onClick="custom(<?=$data->foc_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?php echo date('d-m-Y',strtotime($data->foc_date));?></td>
<td onClick="custom(<?=$data->foc_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->job_no;?></td>
<td onClick="custom(<?=$data->foc_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$data->dealer_code.'"');?></td>
<td onClick="custom(<?=$data->foc_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('buyer_info','buyer_name','buyer_code="'.$data->buyer_code.'"');?></td>
<td onClick="custom(<?=$data->foc_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('merchandizer_info','merchandizer_name','merchandizer_code="'.$data->merchandizer_code.'"');?></td>
<td>

<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
      <input  name="foc_no" type="hidden" id="foc_no" value="<?=$data->foc_no;?>"/>
      <input name="approved" type="submit" value="Approve" style="font-weight:bold; font-size:12px; width:120px; height:30px; color:red;" />

	</form>

</td>
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
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>