<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Sales Return Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'sale_return_master';
$unique = 'v_no';
$status = 'UNCHECKED';
$target_url = '../direct_sales/sales_return_print_view.php';

?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
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
    <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01')?>" />
    </strong></td>
    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d')?>" />
    </strong></td>
    <td rowspan="4" bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966">Warehouse : </td>
    <td colspan="3" bgcolor="#FF9966"><strong>
      <select name="warehouse_id" id="warehouse_id" style="width:200px;">
        <option value="">ALL</option>
		<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],' use_type in ("WH") ');?>
      </select>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966">Company Name : </td>
    <td colspan="3" bgcolor="#FF9966"><strong>
      <select name="group_for" id="group_for" style="width:200px;">
	  <option></option>
        	<? foreign_relation('user_group','id','group_name',$_POST['group_for'],' 1 ');?>
      </select>
    </strong></td>
  </tr>
  
</table>

</form>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['submitit'])){


if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.sr_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['group_for']!='')
$con .= 'and a.group_for = "'.$_POST['group_for'].'"';

if($_POST['warehouse_id']!='')
$con .= 'and a.depot_id = "'.$_POST['warehouse_id'].'"'; 

  $res='select  a.sr_no,a.sr_no as SR_NO, DATE_FORMAT(a.sr_date, "%d-%m-%Y") as SR_Date, d.dealer_name_e as Customer_Name, u.group_name as company, b.warehouse_name as warehouse, a.received_status, c.fname as "Entry", a.entry_at from sale_return_master a, warehouse b,user_activity_management c, dealer_info d, user_group u where a.depot_id=b.warehouse_id and a.entry_by=c.user_id and a.dealer_code=d.dealer_code and u.id=a.group_for '.$con.' order by a.sr_no desc';
echo link_report($res,'po_print_view.php');

}
?>
</div></td>
</tr>
</table>

<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>