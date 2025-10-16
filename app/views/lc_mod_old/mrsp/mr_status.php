<?php
//
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Spare Parts Sales Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'spare_parts_requisition_master';
$unique = 'req_no';
$status = 'UNCHECKED';
$target_url = '../mrsp/mr_print_view.php';

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
    <td rowspan="2" bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Company: </strong></td>
    <td colspan="3" bgcolor="#FF9966"><strong>
<select name="group_for" id="group_for" style="width:200px;">

        <option value=""></option>

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

if($_POST['status']!=''&&$_POST['status']!='ALL')
$con .= 'and a.status="'.$_POST['status'].'"';

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


if($_POST['group_for']!='')

$con .= 'and a.group_for = "'.$_POST['group_for'].'"';


 $res='select  	a.req_no,a.req_no as Requisition_no, DATE_FORMAT(a.req_date, "%d-%m-%Y") as Requisition_date,  b.warehouse_name as Warehouse_name,    a.status,  c.fname as entry_by,  a.entry_at from spare_parts_requisition_master a,warehouse b,user_activity_management c where 
a.warehouse_id=b.warehouse_id  and a.entry_by=c.user_id '.$con.' and a.status in ("UNCHECKED","CHECKED", "COMPLETED") group by a.req_no order by a.req_no desc';
echo link_report($res,'mr_print_view.php');

}

?>
</div></td>
</tr>
</table>

<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>