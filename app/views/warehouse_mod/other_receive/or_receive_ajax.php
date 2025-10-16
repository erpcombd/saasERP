<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$item=explode('#>',$data[0]);
$item_all= find_all_field('item_info','','item_id="'.$item[1].'"');
$journal_item_rate = find_a_field('journal_item','final_price','item_id="'.$item[1].'" and warehouse_id="'.$_SESSION['user']['depot'].'" and tr_from in (Opening)');
$warehouse_id = $data[1];
$stock = (int)(warehouse_product_stock($item[1] ,$warehouse_id));
?>


<input name="stk" type="text" class="form-control" id="stk"  readonly="readonly" required="required" value="<?=$stock?>" onfocus="focuson('rate')" style=" width: 36% !important; "/>
<input name="unit_name" type="text" class="form-control" id="unit_name"  value="<?=$item_all->unit_name?>" readonly required onfocus="focuson('rate')" style=" width: 30% !important; margin: 0px 7px !important; "/>
<input name="rate" type="text" class="form-control" id="rate"  onchange="count()" value="<?=$item_all->cost_price?>"   required style=" width: 34% !important; "/>