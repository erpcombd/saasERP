<?php
session_start();
//

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";
$str = $_POST['data'];
$data=explode('##',$str);
$rp2_date = $_REQUEST['sdate'];
$tdate = $_REQUEST['tdate'];
$PBI_ID = $_REQUEST['PBI_ID'];
$type = $_REQUEST['type'];
$rp2_date = date ("Y-m-d", strtotime("+1 day", strtotime($rp2_date)));
?>

<table>
<tr>
<? while (strtotime($rp2_date) <= strtotime($tdate)){ ?>
 <td>
<select name="s_<?=$PBI_ID?>_<?=$rp2_date?>" id="s_<?=$PBI_ID?>_<?=$rp2_date?>" style="width:100%; font-size:12px">
<? foreign_relation('hrm_schedule_info','id','schedule_name',$type);?></select></td>
<?  $rp2_date = date ("Y-m-d", strtotime("+1 day", strtotime($rp2_date)));} ?>

</tr></table>