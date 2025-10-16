<?php
//
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='LC Realization';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique='do_no';

create_combobox('do_no');
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


$table='sale_do_master';
$do_no='do_no';
$text_field_id='do_no';

$target_url = '../commercial/lc_realization.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?lc_no='+theUrl);
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
        <td width="153" align="right" bgcolor="#FF9966"><strong>Customer Name:</strong></td>
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
      <?php /*?><tr>
        <td align="right" bgcolor="#FF9966"><strong>LC No: </strong></td>
        <td bgcolor="#FF9966">
		<select name="do_no" id="do_no" style="width:250px;">
		
		<option></option>

        <? foreign_relation('sale_do_master','do_no','job_no',$_POST['do_no'],'1');?>
    </select>
		
		</td>
      </tr><?php */?>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="15%">S/L</th>
  <th width="19%"> Date </th>
  <th width="17%">LC No </th>
  <th width="32%">Customer Name </th>
  <th width="17%">Status</th>
  </tr>


<? 

if(isset($_POST['submitit'])){

}

//if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['dealer_code']!='') 
$con .= ' and a.dealer_code in ('.$_POST['dealer_code'].') ';

if($_POST['do_no']!='') 
$con .= ' and m.do_no in ('.$_POST['do_no'].') ';



 		$sql = "select lc_no, lc_no as lc_no  from lc_realization where 1 group by lc_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $lc_no[$info->lc_no]=$info->lc_no;
		
		
		}



    $res="select a.* from lc_master a, maturity_receive b where b.status='CHECKED' and a.lc_no=b.lc_no  ".$con." group by b.lc_no  order by a.lc_no";


$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>

<? if($lc_no[$data->lc_no]==0) {?>

<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
  <td onClick="custom(<?=$data->lc_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->lc_no_view;?></td>
<td onClick="custom(<?=$data->lc_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?php echo date('d-m-Y',strtotime($data->lc_date));?></td>
<td onClick="custom(<?=$data->lc_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->export_lc_no;?></td>
<td onClick="custom(<?=$data->lc_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?= find_a_field('dealer_info','dealer_name_e','dealer_code="'.$data->dealer_code.'"');?></td>
<td onClick="custom(<?=$data->lc_no;?>);" <?=(++$z%2)?'':'class="alt"';?>><?=$data->status;?></td>
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