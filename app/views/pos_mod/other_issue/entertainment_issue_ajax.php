<?php
session_start();
require_once "../../../assets/support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$item=explode('#>',$data[0]);
$item_id = $item[1];
if($item_id>0){
$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');
$warehouse_id = $data[1];
$stock = (int)(warehouse_product_stock($item_id ,$warehouse_id));}
?>
<table style="width:100%;" border="1">
	 <tr>

<td width="33%"><input name="stk" type="text" class="input3" id="stk" style="width:98%;" readonly="readonly" required="required" value="<?=$stock?>" onfocus="focuson('rate')"/></td>
<td width="33%"><input name="unit_name" type="text" class="input3" id="unit_name" style="width:98%;" value="<?=$item_all->unit_name?>" readonly required onfocus="focuson('rate')"/></td>
<td width="33%"><input name="rate" type="text" class="input3" id="rate"  maxlength="100" style="width:98%;" onchange="count()" value="<?=$item_all->cost_price?>"   required readonly=""/></td>
</tr>
</table>