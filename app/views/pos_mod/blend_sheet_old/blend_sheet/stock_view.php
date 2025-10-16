<?php
session_start();
require_once "../../../assets/support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$garden=explode('#>',$data[0]);
$garden_id = $garden[1];
$item=explode('#>',$data[1]);
$item_id = $item[1];
$stock = (int)(warehouse_product_stock_black_tea($item_id ,'5',$garden_id));
?>
<input  name="stock" type="text" class="input3" id="stock"  maxlength="100" style="width:50px;" value="<?=$stock?>" required="required"/>