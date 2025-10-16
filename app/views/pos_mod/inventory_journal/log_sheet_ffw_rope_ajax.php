			<?

session_start();



require_once "../../../assets/support/inc.all.php";

$p_date = $_REQUEST['p_date'];

$group_for = $_REQUEST['group_for'];

$log_shift = $_REQUEST['log_shift'];

//echo $log_no = (date('ymd',strtotime($p_date)).sprintf('%02d', $group_for ).sprintf('%02d', $log_shift);

$log_no = (date('ymd',strtotime($p_date))*10000)+$group_for+$log_shift;

$machine_id = $_REQUEST['machine_id'];


$supervisor = $_REQUEST['supervisor'];

$PBI_ID = $_REQUEST['PBI_ID'];

$wastage = $_REQUEST['wastage'];

$item_id = $_REQUEST['item_id'];

$nd_item_id = $_REQUEST['nd_item_id'];

$production = $_REQUEST['production'];

$nd_production = $_REQUEST['nd_production'];

$machine_wastage = $_REQUEST['machine_wastage'];

$remarks = $_REQUEST['remarks'];

$flag = $_REQUEST['flag'];

$entry_by = $_REQUEST['entry_by']=$_SESSION['user']['id'];

$entry_at = $_REQUEST['entry_at']=date('Y-m-d H:i:s');





if($_REQUEST['flag']!=0)
{


 $log_uptade = "DELETE from production_log_sheet_ffw_rope where log_no='".$log_no."' and log_date = '".$p_date."' and  log_shift='".$log_shift ."' and  machine_id='".$machine_id ."' ";

mysql_query($log_uptade);

}

  $sql_1 = "INSERT INTO production_log_sheet_ffw_rope ( `log_no`, `log_date`, `group_for`, `log_shift`, `supervisor`, `machine_id`, machine_line, `PBI_ID`, `item_id`, `production`,`nd_item_id`, `nd_production`, `wastage`, `machine_wastage`,  `remarks`, `status`, `entry_by`, `entry_at`) VALUES

('".$log_no."','".$p_date."','".$group_for."', '".$log_shift."',  '".$supervisor."', '".$machine_id."', 'A', '".$PBI_ID."', '".$item_id."', '".$production."', '".$nd_item_id."', '".$nd_production."', '".$wastage."', '".$machine_wastage."','".$remarks."', 'MANUAL', '".$entry_by."', '".$entry_at."')";
mysql_query($sql_1);


if($nd_item_id>0)
{


 $sql = "INSERT INTO production_log_sheet_ffw_rope ( `log_no`, `log_date`, `group_for`, `log_shift`, `supervisor`, `machine_id`,  machine_line, `PBI_ID`, `item_id`, `production`,`wastage`,  `remarks`, `status`, `entry_by`, `entry_at`) VALUES

('".$log_no."','".$p_date."','".$group_for."', '".$log_shift."',  '".$supervisor."', '".$machine_id."', 'B', '".$PBI_ID."', '".$nd_item_id."', '".$nd_production."', '".$wastage."', '".$remarks."', 'MANUAL', '".$entry_by."', '".$entry_at."')";

}

mysql_query($sql);

echo 'Success!';

?>