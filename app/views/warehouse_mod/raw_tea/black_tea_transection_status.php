<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Black Tea Transection Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';
$target_url = '../raw_tea/black_tea_transection_sheet.php';

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
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Warehouse : </strong></td>
        <td colspan="3" bgcolor="#FF9966"><strong>
          <select name="line_id" id="line_id" style="width:220px;" required="required">
           
            <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['line_id'],'warehouse_id="5" order by warehouse_name');?>
          </select>
        </strong></td>
        <td bgcolor="#FF9966">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=isset($_POST['fdate'])?$_POST['fdate']:date('Y-m-01');?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=isset($_POST['tdate'])?$_POST['tdate']:date('Y-m-d');?>" />
        </strong></td>
        <td bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['submitit'])){


if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= ' and a.sale_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['line_id']!='')
$con .= ' and c.master_warehouse_id = "'.$_POST['line_id'].'" ';



  $res='select  a.sale_no, a.sale_no as TR_NO,a.sale_date as Date, c.warehouse_name as Stock,  u.fname as entry_by,a.entry_at
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