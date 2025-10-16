<?php
session_start();
require "../../../warehouse_mod/support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_GET['data'];
$data=explode('##',$str);
$item=explode('#>',$data[0]);
 $item_id = $str;
if($item_id>0){
//$stock = warehouse_product_stock($item_id ,$data[1]);
$stock= find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$item_id.'" and warehouse_id=136');

$last_p = find_all_field('purchase_receive','','item_id="'.$item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" order by id desc');
$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');
$last_issue = find_all_field('warehouse_other_issue_detail','qty','item_id='.$item_id.' and issued_to='.$_SESSION['employee_selected']);
}

$data[0] = $stock;
$data[1] = $item_all->unit_name;
$data[2] = $last_issue->qty;
$data[3] = $last_issue->oi_date;
echo json_encode($data);
?> 
