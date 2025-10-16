<?php
//
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='PO Bill Status';
do_calander('#fdate');
do_calander('#tdate');
$table_master='pi_master';
$unique_master='id';

create_combobox('pi_id');
create_combobox('do_no');
create_combobox('dealer_code');

$table_detail='pi_details';
$unique_detail='id';



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


$table='po_bill_master';
$show='dealer_code';
$id='id';
$text_field_id='id';

$target_url = 'po_bill_print_view.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?bill_id='+theUrl);
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
        <td align="right" bgcolor="#FF9966"><strong>Date Interval:</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
		<input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01')?>" />
        </strong></td>
        <td bgcolor="#FF9966"><center>
          <strong> -to- </strong>
        </center></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d')?>" />
        </strong></td>
        <td rowspan="4" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
      
      <tr>

    <td align="right" bgcolor="#FF9966"><strong>Purchase Manager: </strong></td>

    <td colspan="3" bgcolor="#FF9966"><strong>

      <select name="purchase_manager" id="purchase_manager" style="width:200px;">

        <option value=""></option>

		<? foreign_relation('purchase_manager','id','purchase_manager',$_POST['purchase_manager'],' 1 ');?>
      </select>

    </strong></td>
  </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
  <th width="13%">PO Bill </th>
  <th width="11%">Bill Top Sheet </th>
  <th width="14%">Bill Date </th>
  <th width="28%">Purchase Manager</th>
  <!--<th>Zone</th>-->
<th width="16%">Entry By </th>
  <th width="18%">Status</th>
</tr>


<? 

if(isset($_POST['submitit'])){


if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.bill_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



if($_POST['group_for']!='')

$con .= 'and b.group_for = "'.$_POST['group_for'].'"';



if($_POST['purchase_manager']!='')

$con .= 'and a.purchase_manager = "'.$_POST['purchase_manager'].'"';


    $res="select  a.bill_id, a.bill_no, a.bill_date,  d.purchase_manager,  c.fname as entry_by, a.status 
  from po_bill_master a, po_bill_details b, user_activity_management c, purchase_manager d
  where  a.bill_id=b.bill_id and a.entry_by=c.user_id and a.purchase_manager=d.id  ".$con." group by a.bill_id order by a.bill_date, a.bill_id";
$query = db_query($res);

//$two_weeks = time() - 14*24*60*60;
while($data = mysqli_fetch_object($query))
{

?>
<tr <?=($data->RCV_AMT>0)?'style="background-color:#FFCCFF"':'';?>>
<td>
<a href="po_bill_print_view.php?bill_id=<?=$data->bill_id;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data->bill_no;?></a></td>
<td>&nbsp;<a href="po_bill_top_shit_print_view.php?bill_id=<?=$data->bill_id;?>" target="_blank" style=" color:#000000; font-size:14px; font-weight:700;"> <?=$data->bill_no;?></a></td>
<td><?php echo date('d-m-Y',strtotime($data->bill_date));?></td>
<td>&nbsp;<?=$data->purchase_manager;?></td>
<td>&nbsp;
  <?=$data->entry_by;?></td>
<td>&nbsp;<?=$data->status;?></td>
</tr>
<?
$total_send_amt = $total_send_amt + $data->SEND_AMT;
$total_rcv_amt = $total_rcv_amt + $data->RCV_AMT;
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