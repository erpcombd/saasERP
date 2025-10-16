<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$item_id =$_POST['id'];

$info = find_all_field('item_info','','item_id="'.$item_id.'"');

$unit = $info->unit_name;

$depot_id = $_SESSION['user']['depot'];
$stock = (int)find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_id.'" and warehouse_id="'.$depot_id.'" ');

$item_name = $info->finish_goods_code.' '.$info->item_name;


$arr = array('unit' => $unit, 'item_name' => $item_name, 'pack_size' => $info->pack_size, 'stock' => $stock);

echo json_encode($arr);

?>




