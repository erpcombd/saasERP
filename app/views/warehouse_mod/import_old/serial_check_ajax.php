<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');
$or_no = $_REQUEST['or_no'];
$item_id = $_REQUEST['item_id'];
$total_import_qty = find_a_field('warehouse_other_receive_detail','sum(qty)','or_no="'.$or_no.'" and item_id="'.$item_id.'"');
$total_rcvd_qty = find_a_field('lc_import','sum(qty)','import_no="'.$or_no.'" and item_id="'.$item_id.'"');
$rest_qty = $total_import_qty-$total_rcvd_qty;
$check = find_a_field('lc_import','sum(qty)','serial_no="'.$_REQUEST['serial_no'].'"');
if($check>0){
$or_no = find_a_field('lc_import','import_no','serial_no="'.$_REQUEST['serial_no'].'"');
$msg = '<span style="color:red;font-weight:bold;">Duplicate. Import No : '.$or_no.'</span>';
}else{
$msg = '';
}

$data['msg']= $msg;
$data['pos']= $or_no;
$data['po_qty']= $total_import_qty;
$data['rcv_qty']= (int)$total_rcvd_qty;
$data['rest_qty']= (int)$rest_qty;
echo json_encode($data);
?>



