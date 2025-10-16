<?php

session_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');



 $str = $_POST['data'];

$data=explode('##',$str);

$item=explode('#>',$data[0]);

$item_id=$item[2];

$warehouse_id = $_SESSION['user']['depot'];

  $warehouse_from = $data[1];

$stock = warehouse_product_stock($item_id ,$warehouse_from);



$last_p = find_all_field('production_floor_receive_detail','','item_id="'.$item[2].'" and warehouse_from = "'.$warehouse_from.'" order by id desc');

$item_all= find_all_field('item_info','','item_id="'.$item[2].'"');

?>

<input name="unit_name" type="text" class="input3" style="max-width:174px;float:left;" onfocus="focuson('total_unit')" value="<?=$item_all->unit_name?>"/>      

<input name="stock" type="text" class="input3" style="max-width:164px;float:left;" onfocus="focuson('total_unit')" readonly="readonly" value="<?=$stock?>"/>       

