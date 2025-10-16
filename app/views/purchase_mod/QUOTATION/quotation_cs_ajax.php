<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$order_no = $_REQUEST['order_no'];
$item_id = $_REQUEST['item_id'];
$rate = $_REQUEST['rate'];
$flag = $_REQUEST['flag'];
$prev_rate=$_REQUEST['prev_rate'];
$status="CHECKED";

$invoice_no = find_a_field('purchase_quotation_details','invoice_no','id="'.$order_no.'"');

$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d H:i:s');

 
if($rate!=$prev_rate){
  $up_sql_log='insert into quotation_rate_log set  item_id="'.$item_id.'",quotation_no="'.$invoice_no.'",change_by="'.$entry_by.'", change_at="'.$entry_at.'",rate="'.$prev_rate.'",change_rate="'.$rate.'"';
db_query($up_sql_log);
}

$up_sql='update purchase_quotation_details set  app_status="'.$flag.'",  approve_by="'.$entry_by.'", approve_at="'.$entry_at.'",unit_price="'.$rate.'" where id='.$order_no;
db_query($up_sql);
$check_return_status=find_a_field('purchase_quotation_details','count(id)','return_status=1 and invoice_no="'.$invoice_no.'"');

if($check_return_status<1){
$msup_sql='update  purchase_quotation_master set  status="'.$status.'",  approve_by="'.$entry_by.'", approve_at="'.$entry_at.'" where invoice_no='.$invoice_no;
db_query($msup_sql);
}
else{
$msup_sql='update  purchase_quotation_master set     approve_by="'.$entry_by.'", approve_at="'.$entry_at.'" where invoice_no='.$invoice_no;
db_query($msup_sql);
}



echo 'Success!';


?>