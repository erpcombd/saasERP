<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$order_no = $_REQUEST['order_no'];
$item_id = $_REQUEST['item_id'];

$flag = $_REQUEST['flag'];

$status="CHECKED";

$invoice_no = find_a_field('purchase_quotation_details','invoice_no','id="'.$order_no.'"');

$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');


$up_sql='update purchase_quotation_details set  app_status="'.$flag.'",  approve_by="'.$entry_by.'", approve_at="'.$entry_at.'" where id='.$order_no;
db_query($up_sql);

$msup_sql='update  purchase_quotation_master set  status="'.$status.'",  approve_by="'.$entry_by.'", approve_at="'.$entry_at.'" where invoice_no='.$invoice_no;
db_query($msup_sql);



echo 'Success!';


?>