<?

session_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$order_no = $_REQUEST['order_no'];
$item_id = $_REQUEST['item_id'];
$batch_qty = $_REQUEST['batch_qty'];
$actual_qty = $_REQUEST['actual_qty'];

$final_unit=$actual_qty/$batch_qty;

$flag = $_REQUEST['flag'];



$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');




 $up_sql='update batch_by_product set  batch_actual_qty="'.$actual_qty.'", final_unit="'.$final_unit.'",final_qty="'.$actual_qty.'" , edit_by="'.$entry_by.'", entry_at="'.$entry_at.'" where id='.$order_no;
db_query($up_sql);



echo 'Success!';



?>