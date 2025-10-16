<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$report_id=$_REQUEST['page_id']; 
$user_id=$_REQUEST['user_id']; 
$access=$_REQUEST['access']; 

db_delete('user_report_access'," 1 and user_id='".$user_id."' and report_id='".$report_id."'");
$sql = "INSERT INTO user_report_access (`user_id`, `report_id`,`access`) VALUES ('$user_id', '$report_id','$access')";
db_query($sql);
echo 'Done';
?>