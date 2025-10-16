<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$order_no = $_REQUEST['order_no'];
$item_id = $_REQUEST['item_id'];

 

$status="APPROVED";
 

$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');


$up_sql='update  import_quotation_details set  app_status="'.$status.'",  approve_by="'.$entry_by.'", approve_at="'.$entry_at.'" where id='.$order_no;
db_query($up_sql);

 



echo 'Success!';


?>