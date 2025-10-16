<?php
session_start();
ob_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Requisition Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'requisition_master_stationary';
$unique = 'req_no';
$status = 'UNCHECKED';
$target_url = '../mr/mr_print_view.php';

?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);
}
</script>
<style>
.tabledesign2 {
    width: 100%;
    padding: 0;
    margin: 0px auto 1px auto;
    background-color: #ffffff;
    border-left: 1px solid #417216;
    text-align: left;
}
.tabledesign2 th {
    font: bold 11px Verdana, Arial, Helvetica, sans-serif;
    background-color: #cbde72;
    color: #000;
    border-right: 1px solid #417216;
    border-bottom: 1px solid #417216;
    border-top: 1px solid #417216;
    text-align: left;
    padding: 3px 3px 3px 12px;
}
.tabledesign2 td {
    border-right: 1px solid #417216;
    border-bottom: 1px solid #417216;
    padding: 3px 3px 3px 3px;
    color: #000;
    text-align: left;
}
</style>
<div class="form-container_large" style="margin-bottom:10px;">
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
      <input type="date" name="fdate" id="fdate" style="width:80px;" value="<?=$_POST['fdate']?>" autocomplete="off"/>
    </strong></td>
    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="date" name="tdate" id="tdate" style="width:80px;" value="<?=$_POST['tdate']?>" autocomplete="off" />
    </strong></td>
    <td rowspan="2" bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>
    <td colspan="3" bgcolor="#FF9966"><strong>
<select name="status" id="status" style="width:200px;">
<option><?=$_POST['status']?></option>
<option>UNCHECKED-BOQ</option>
<option>UNCHECKED</option>
<option>CHECKED</option>
<option>ALL</option>
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
if($_POST['status']!=''&&$_POST['status']!='ALL')
$con .= 'and a.status="'.$_POST['status'].'"';

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

 $res='select a.req_no,a.req_no, a.req_date, a.req_for, b.group_name as Organization, a.req_note as note, a.need_by, c.user_name as entry_by, a.entry_at,a.status from requisition_master_stationary a,user_group b,hrm_user_access c where  a.warehouse_id=b.id and a.entry_by=c.emp_id 
'.$con.' 
 and entry_by = '.$_SESSION['employee_selected'].'
 and a.req_from="HRM" order by a.req_no';
echo link_report($res,'mr_print_view.php');

echo '<br>';
// checked list
 $res='select a.req_no,a.req_no, a.req_date, a.req_for, b.group_name as Organization, a.req_note as note, a.need_by, c.user_name as entry_by, a.entry_at,a.status from requisition_master_stationary a,user_group b,hrm_user_access c where  a.warehouse_id=b.id and a.entry_by=c.emp_id 
'.$con.' 
 and checked_by = '.$_SESSION['employee_selected'].'
 and a.req_from="HRM" order by a.req_no';
echo link_report($res,'mr_print_view.php');
?>
</div></td>
</tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>