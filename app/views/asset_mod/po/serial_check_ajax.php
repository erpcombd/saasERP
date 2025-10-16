<?php



//




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



@ini_set('error_reporting', E_ALL);



@ini_set('display_errors', 'Off');

$po_no = $_REQUEST['po_no'];

$item_id = $_REQUEST['item_id'];

$total_po_qty = find_a_field('purchase_invoice','sum(qty)','po_no="'.$po_no.'" and item_id="'.$item_id.'"');

$total_rcvd_qty = find_a_field('purchase_receive_asset','sum(qty)','po_no="'.$po_no.'" and item_id="'.$item_id.'"');

$rest_qty = $total_po_qty-$total_rcvd_qty;

$check = find_a_field('journal_item','sum(item_in)','serial_no="'.$_REQUEST['serial_no'].'"');

if($check>0){

$po_no = find_a_field('purchase_receive_asset','po_no','serial_no="'.$_REQUEST['serial_no'].'"');

$msg = '<span style="color:red;font-weight:bold;">Duplicate. PO No : '.$po_no.'</span>';

}else{

$msg = '';

}



$data['msg']= $msg;

$data['pos']= $po_no;

$data['po_qty']= $total_po_qty;

$data['rcv_qty']= (int)$total_rcvd_qty;

$data['rest_qty']= (int)$rest_qty;

echo json_encode($data);

?>







