<?php
session_start();
require "../../support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$item=explode('#>',$data[0]);
$item_id=$item[2];
$warehouse_id = $_SESSION['user']['depot'];
$warehouse_from = $data[1];
$stock = warehouse_product_stock($item_id ,$warehouse_id);

$last_p = find_all_field('production_receive_detail','','item_id="'.$item[2].'" and warehouse_from = "'.$warehouse_from.'" order by id desc');
$item_all= find_all_field('item_info','','item_id="'.$item[2].'"');
?>
<input name="total_unit2" type="text" class="input3" style="width:50px;" onfocus="focuson('total_pkt')" value="<?=$item_all->unit_name?>"/>      
<input name="total_unit3" type="text" class="input3" style="width:60px;" onfocus="focuson('total_pkt')" value="<?=$stock?>"/>       
<input name="total_unit4" type="text" class="input3" style="width:60px;" onfocus="focuson('total_pkt')" value="<?=$last_p->total_unit?>"/>      
<input name="total_unit5" type="text" class="input3" style="width:85px;" onfocus="focuson('total_pkt')" value="<?=$last_p->pr_date?>"/>

<input name="pkt_size" id="pkt_size" type="hidden" value="<?=$item_all->pack_size?>"/>