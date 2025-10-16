<?php
//
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='LC Receive';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='do_no';

create_combobox('pi_no');
create_combobox('dealer_code');

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


$table='pi_master';
$do_no='id';
$text_field_id='id';

$target_url = '../commercial/lc_receive.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?pi_no='+theUrl);
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
        <td width="153">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td width="141">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Customer Name:</strong></td>
        <td bgcolor="#FF9966">
		<select name="dealer_code" id="dealer_code" style="width:250px;">
		
		<option></option>

        <?
		
		foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 order by dealer_code');

		?>
    </select>		</td>
        <td rowspan="3" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>PI No: </strong></td>
        <td bgcolor="#FF9966">
		<select name="pi_no" id="pi_no" style="width:250px;">
		
		<option></option>

        <? foreign_relation('pi_master','id','pi_no',$_POST['pi_no'],'1');?>
    </select>
		
		</td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="10%">PI No </th>
  <th width="11%">PI Date </th>
  <th width="31%">Customer</th>
  <th width="16%">PI Type </th>
  <th width="10%">PI Value </th>
  <th width="22%">Entry By </th>
</tr>


<? 

if(isset($_POST['submitit'])){

}

//if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['dealer_code']!='') 
$con .= ' and m.dealer_code in ('.$_POST['dealer_code'].') ';

if($_POST['pi_no']!='') 
$con .= ' and m.id in ('.$_POST['pi_no'].') ';



 		$sql = "select pi_id, count(pi_no) as pi_no  from commercial_lc_receive where1 group by pi_id ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $pi_no[$info->pi_id]=$info->pi_no;
		
		
		}



   $res="select m.id as pi_no, m.id as pi_no, m.pi_no as grne_pi_no, m.view_pi_no, m.dealer_group, m.dealer_code, m.pi_date, m.pi_type, sum(d.total_unit) as pi_qty, sum(d.total_amt) as pi_amt, m.entry_by from pi_master m, pi_details d where m.id=d.pi_id  and m.pi_type=1 ".$con." group by m.id order by m.pi_date, m.id ";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>

<? if($pi_no[$data->pi_no]==0) { ?>

<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
  <td onClick="custom(<?=$data->pi_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->grne_pi_no;?></td>
<td onClick="custom(<?=$data->pi_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?php echo date('d-m-Y',strtotime($data->pi_date));?></td>
<td onClick="custom(<?=$data->pi_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$data->dealer_code.'"');?>
<?php /*?><?=$data->wo_qty?>||  <?=$ch_qty[$data->do_no]; ?><?php */?></td>
<td onClick="custom(<?=$data->pi_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('pi_type','pi_type','id="'.$data->pi_type.'"');?></td>
<td onClick="custom(<?=$data->pi_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->pi_amt;?></td>
<td onClick="custom(<?=$data->pi_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');?></td>
</tr>


<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;

} }
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