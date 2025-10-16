<?
session_start();
require_once "../../../assets/support/inc.all.php";

$entry_by       = $_SESSION['user']['id'];

$item_id        =$_REQUEST['id']; 
$warehouse_id   =$_REQUEST['warehouse_id']; 
$lock           =$_REQUEST['lock']; 





$arr = array('result' => $result);
echo json_encode($arr);
?>