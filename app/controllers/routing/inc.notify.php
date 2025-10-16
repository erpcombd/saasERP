<?
$_SESSION['notify'][178]=find_a_field('sale_do_master','count(do_no)','status="MANUAL" and depot_id="'.$_SESSION['user']['depot'].'"');
$_SESSION['notify'][658]=find_a_field('sale_do_master','count(do_no)','status="PROCESSING" and depot_id="'.$_SESSION['user']['depot'].'"');
$_SESSION['notify'][599]=find_a_field('sale_do_master','count(do_no)','status="CHECKED" and depot_id="'.$_SESSION['user']['depot'].'"');
//$_SESSION['notify'][181]=find_a_field('warehouse_other_receive','count(or_no)','status="MANUAL"');
//$_SESSION['notify'][182]=find_a_field('warehouse_other_receive','count(or_no)','status="UNCHECKED"');
//$_SESSION['notify'][185]=find_a_field('requisition_fg_master','count(req_no)','status="MANUAL" and warehouse_id="'.$_SESSION['user']['depot'].'"');

$_SESSION['notify'][644]=find_a_field('requisition_master','count(req_no)','status="UNCHECKED" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$_SESSION['notify'][127]=find_a_field('purchase_master','count(po_no)','status="UNCHECKED" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$_SESSION['notify'][125]=find_a_field('purchase_master','count(po_no)','status="MANUAL" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$_SESSION['notify'][641]=find_a_field('requisition_master','count(req_no)','status="MANUAL" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$_SESSION['notify'][702]=find_a_field('requisition_master','count(req_no)','status="CHECKED" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$_SESSION['notify'][1701]=find_a_field('production_issue_master m,production_issue_detail d', 'count(DISTINCT m.pi_no)', 'm.status="MANUAL" and m.pi_no=d.pi_no ');
$_SESSION['notify'][855]=find_a_field('warehouse_transfer_issue m,warehouse_transfer_issue_detail d', 'count(DISTINCT m.pi_no)', 'm.status="UNSEND" and m.pi_no=d.pi_no and m.issue_type="Transfer" and m.warehouse_from="'.$_SESSION['user']['depot'].'" ');

$_SESSION['notify'][856]=find_a_field('warehouse_transfer_issue m,warehouse_transfer_issue_detail d', 'count(DISTINCT m.pi_no)', 'm.status="SEND" and m.pi_no=d.pi_no and m.issue_type="Transfer" and m.warehouse_to="'.$_SESSION['user']['depot'].'" ');

$_SESSION['notify'][637]=find_a_field('warehouse_transfer_issue', 'count(DISTINCT pi_no)', 'status="MANUAL" and issue_type="Transfer" and warehouse_from="'.$_SESSION['user']['depot'].'" ');

$_SESSION['notify'][1716]=find_a_field('production_issue_master', 'count(pi_no)', 'status="CHECKED" ');
$_SESSION['notify'][1717]=find_a_field(' production_received_master', 'count(pi_no)', 'status="CHECKED" ');

$_SESSION['notify'][131]=find_a_field('purchase_master','count(po_no)','status="CHECKED" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$_SESSION['notify'][593]=find_a_field('sale_return_master','count(sr_no)','status="MANUAL" and depot_id="'.$_SESSION['user']['depot'].'"');
$_SESSION['notify'][781]=find_a_field('sale_return_master','count(sr_no)','status="UNCHECKED" and depot_id="'.$_SESSION['user']['depot'].'"');
$_SESSION['notify'][1704]=find_a_field('warehouse_other_issue','count(oi_no)','status="MANUAL" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$_SESSION['notify'][1705]=find_a_field('warehouse_other_issue','count(oi_no)','status="UNCHECKED" and warehouse_id="'.$_SESSION['user']['depot'].'"');

?>