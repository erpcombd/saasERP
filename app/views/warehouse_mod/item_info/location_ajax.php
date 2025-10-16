<?
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
db_query('delete from item_location_info where item_id="'.$_REQUEST['item_id'].'" and warehouse_id="'.$_REQUEST['warehouse_id'].'"');
$crud = new crud('item_location_info');
$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['item_id'] = $_REQUEST['item_id'];
$_POST['warehouse_id'] = $_REQUEST['warehouse_id'];
$_POST['room_no'] = $_REQUEST['room_no'];
$_POST['rak_no'] = $_REQUEST['rak_no'];
$_POST['shelf_no'] = $_REQUEST['shelf_no'];
$crud->insert();
echo 'Saved!';
?>