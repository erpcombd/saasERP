<?php
session_start();
ob_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Unfinished MR List';

$table = 'requisition_master_stationary';
$unique = 'req_no';
$status = 'MANUAL';
$target_url = '../mr/mr_create.php';

$emp=find_all_field('personnel_basic_info','PBI_ORG','PBI_ID='.$_SESSION['employee_selected']);

if($_POST[$unique]>0)
{
$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url);
}

?><div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
  <tr>
    <td width="26%">&nbsp;</td>
    <td width="52%">&nbsp;</td>
    <td width="22%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" ><label  style="padding: 5px;width:160px;margin-left: 112px;"><strong><?=$title?>:</strong> </label></td>
    <td ><strong>
      <select name="<?=$unique?>" id="<?=$unique?>" style="width: 280px;">
		<? foreign_relation('requisition_master_stationary','req_no','req_no',$req_no,' entry_by ='.$_SESSION['employee_selected'].' and req_from="HRM" and (status="'.$status.'" or status="") ');?>
      </select>
    </strong></td>
    <td ><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:170px; font-weight:bold; font-size:12px; height:30px;margin-left: 50px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>