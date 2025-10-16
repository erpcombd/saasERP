<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$order_no = $_REQUEST['order_no'];
$item_id = $_REQUEST['item_id'];
$rate = $_REQUEST['rate'];
$flag = $_REQUEST['flag'];
$prev_rate=$_REQUEST['prev_rate'];
$return_note=$_REQUEST['return_note'];
$status="RETURN";

$invoice_no = find_a_field('purchase_quotation_details','invoice_no','id="'.$order_no.'"');

$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');

 
 

$up_sql='update purchase_quotation_details set  return_status="1",  return_by="'.$entry_by.'", return_at="'.$entry_at.'",return_note="'.$return_note.'"  where id='.$order_no;
db_query($up_sql);

  $msup_sql='update  purchase_quotation_master set  status="'.$status.'",  return_by="'.$entry_by.'", return_at="'.$entry_at.'" where invoice_no='.$invoice_no;
db_query($msup_sql);



echo 'Return To Revise';


?>