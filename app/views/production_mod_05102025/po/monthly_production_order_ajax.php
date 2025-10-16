<?
session_start();
require "../../support/inc.all.php";

$order_qty = $_REQUEST['order_qty'];
$item_id = $_REQUEST['item_id'];

if($_REQUEST['flag']==0)
{
$sql = "INSERT INTO production_plan_order 
(year, mon, item_id, order_qty, entry_at, entry_by)
VALUES 
('".$_REQUEST['year']."', '".$_REQUEST['mon']."', '".$_REQUEST['item_id']."', '".$order_qty."', '".date('Y-m-d H:i:s')."', '".$_SESSION['user']['id']."')";
}
else
{
$sql = "UPDATE production_plan_order SET order_qty = '".$order_qty."', edit_at = '".date('Y-m-d H:i:s')."', edit_by = '".$_SESSION['user']['id']."' 
WHERE year = '".$_REQUEST['year']."' and mon = '".$_REQUEST['mon']."' and item_id = '".$_REQUEST['item_id']."';";
}
db_query($sql);
echo 'Success!';
?>