<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Sales Entry Report';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';
$target_url = '../sales/sales_view_acc.php';

if($_REQUEST[$unique]>0)
{
$_SESSION[$unique] = $_REQUEST[$unique];
header('location:'.$target_url);
}

?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
</script>
<div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table  style="width:80%;margin:0 auto; border:0; text-align:center;">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td  style="background-color:#FF9966; text-align:right;"><strong>Select House </strong>:</td>
        <td colspan="3" style="background-color:#FF9966;"><strong>
          <select name="line_id" id="line_id" style="width:220px;" required="required">
            <option></option>
            <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['line_id'],'use_type="SD" order by warehouse_name');?>
          </select>
        </strong></td>
        <td style="background-color:#FF9966;">&nbsp;</td>
      </tr>
      <tr>
        <td  style="background-color:#FF9966;text-align:right;"><strong>Date Interval :</strong></td>
        <td  style="width:30%; background-color:#FF9966;"><strong>
          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=isset($_POST['fdate']) ? $_POST['fdate']:date('Y-m-01');?>" />
        </strong></td>
        <td  style="background-color:#FF9966;text-align:center;"><strong> -to- </strong></td>
        <td  style="width:30% background-color:#FF9966;"><strong>
          <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />
        </strong></td>
        <td style="background-color:#FF9966;"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
    </table>
  </form>
  <table  style="width:100%; border:0; border-collapse:collapse; border-spacing:0; padding:0;">
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['submitit'])){


if($_POST['fdate']!=''&&$_POST['tdate']!=''){
$con .= ' and a.sale_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}

if($_POST['line_id']!=''){
$con .= ' and c.master_warehouse_id = "'.$_POST['line_id'].'" ';}

 $res='select a.sale_no, a.sale_no as sale_no,a.sale_date as sale_date, c.warehouse_name as SE_Name, sum(a.today_sale_amt) as Amount,  u.fname as entry_by,a.entry_at
from item_sale_issue a, warehouse c, user_activity_management u
where a.se_id=c.warehouse_id and a.entry_by=u.user_id '.$con.' group by a.sale_no order by a.sale_date asc';


echo link_report($res,'sales_view_acc.php');

}
?>
</div></td>
</tr>
</table>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>