<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";

$title='Draft Tools Maintenance List';
do_calander('#fdate');
do_calander('#tdate');
$table_master='tool_maintenance';
$unique_master='expense_no';

$table_detail='tool_maintenance_detail';
$unique_detail='id';

$table_chalan='tool_maintenance_detail';
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
		$_POST['entry_at']=date('Y-m-d h:s:i');
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


$table='sale_do_master';
$show='dealer_code';
$id='do_no';
$text_field_id='old_do_no';

$target_url = '../tools/fuel_expense_checking.php';


?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?expense_no='+theUrl);
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
        <td width="100" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<? if($_POST['fdate']=='') echo date('Y-m-01');else echo $_POST['fdate']?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="100" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<? if($_POST['tdate']=='') echo date('Y-m-d');else echo $_POST['tdate']?>" />
        </strong></td>
        <td rowspan="2" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
      <!--<tr>
        <td align="right" bgcolor="#FF9966">Branch : </td>
        <td colspan="3" bgcolor="#FF9966"><label>
          <select name="warehouse_id" id="warehouse_id">
		  <option></option>
		  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'])?>
          </select>
        </label></td>
      </tr>-->
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody>
<tr>
<th>Expense No.</th>
<th>Expense Date</th>
<th>Status</th>
<th>Entry By</th>
<th>Entry At</th>

 
  
  </tr>


<? 



if($_POST['fdate']!=''&&$_POST['tdate']!='') $con .= ' and c.expense_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


//if($_POST['warehouse_id']>0) $con .= ' and c.warehouse_to = '.$_POST['warehouse_id'].'';

//$res="select m.do_no,m.do_date,concat(d.dealer_code,'- ',d.dealer_name_e,'(',team_name,')') as dealer_name, a.AREA_NAME, concat(m.payment_by) as Payment_Details,m.rcv_amt, m.mr_no from 
//sale_do_master m,dealer_info d, area a
//where m.status in ('PROCESSING') and d.area_code=a.AREA_CODE  and m.dealer_code=d.dealer_code ".$con." and d.dealer_type='Distributor' order by m.do_date,d.dealer_name_e";




 $res="select c.* from tool_maintenance_detail c where c.status='UNCHECKED' ".$con." group by expense_no";
$query = db_query($res);
while($data = mysqli_fetch_object($query))
{
?>
<tr onClick="custom(<?=$data->expense_no;?>)" <?=($data->expense_no>0)?'style="background-color:#FFCCFF"':'';?>>
<td <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->expense_no;?></td>
<td  <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->expense_date;?></td>
<td  <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->status;?></td>
<td  <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"');?></td>
<td  <?=(++$z%2)?'':'class="alt"';?>>&nbsp;<?=$data->entry_at;?></td>


</tr>
<?

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