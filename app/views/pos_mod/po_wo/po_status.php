<?php
require_once "../../../assets/template/layout.top.php";
$title='Purchase Work Order Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'UNCHECKED';
$target_url = '../po_wo/wo_print_view.php';

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
    <td align="right" bgcolor="#249CF2" style="color: black;"><strong>Date :</strong></td>
    <td width="1" bgcolor="#249CF2"><strong>
      <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01')?>" />
    </strong></td>
    <td align="center" bgcolor="#249CF2" style="color: black;"><strong> -to- </strong></td>
    <td width="1" bgcolor="#249CF2"><strong>
      <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d')?>" />
    </strong></td>
    <td rowspan="4" bgcolor="#249CF2"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#249CF2" style="color: black;"><strong>Concern Name : </strong></td>
    <td colspan="3" bgcolor="#249CF2"><strong>
      <select name="group_for" id="group_for" style="width:200px;">
        <option value="">ALL</option>
		<? foreign_relation('user_group','id','group_name',$_POST['group_for']);?>
      </select>
    </strong></td>
  </tr>
  
  <tr>
    <td align="right" bgcolor="#249cf2" style="color: black;"><strong><?=$title?> : </strong></td>
    <td colspan="3" bgcolor="#249cf2"><strong>
<select name="status" id="status" style="width:200px;">
<option><?=$_POST['status']?></option>
<option>UNCHECKED</option>
<option>CHECKED</option>
<option>ALL</option>
</select>
    </strong></td>
    </tr>
</table>

</form>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['status'])){
if($_POST['status']!=''&&$_POST['status']!='ALL')
$con .= 'and a.status="'.$_POST['status'].'"';

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['group_for']!='')
$group_con .= 'and a.group_for = "'.$_POST['group_for'].'"';

if($_POST['warehouse_id']!='')
$con .= 'and b.warehouse_id = "'.$_POST['warehouse_id'].'"';

 $res='select  a.po_no,a.po_no as WO_No, DATE_FORMAT(a.po_date, "%d-%m-%Y") as WO_date,  v.vendor_name as Party_name, u.group_name as concern,  c.fname as "entry_by", a.entry_at,a.status from purchase_master a,user_activity_management c, vendor v, user_group u where a.status in ("UNCHECKED WO", "WO CHECKED", "WO COMPLETED") and u.id=a.group_for and a.entry_by=c.user_id and a.vendor_id=v.vendor_id '.$con.' group by a.po_no desc';
echo link_report($res,'po_print_view.php');

}
?>
</div></td>
</tr>
</table>

<?
require_once "../../../assets/template/layout.bottom.php";
?>