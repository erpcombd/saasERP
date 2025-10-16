<?php
session_start();
require_once "../../../assets/support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$item=explode('#>',$data[0]);
$item_all= find_all_field('item_info','','item_id="'.$item[1].'"');
$warehouse_id = $data[1];
$stock = (int)(warehouse_product_stock($item[1] ,$warehouse_id));
?>
<input name="stk" type="text" class="input3" id="stk" style="width:100px;" readonly="readonly" required="required" value="<?=$stock?>"/>
<input name="unit_name" type="text" class="input3" id="unit_name" style="width:80px;" value="<?=$item_all->unit_name?>" readonly required/>
<input name="rate" type="text" class="input3" id="rate"  maxlength="100" style="width:80px;" onchange="count()" value="<?=$item_all->cost_price?>"  required/>