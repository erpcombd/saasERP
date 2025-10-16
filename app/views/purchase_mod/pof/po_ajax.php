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
 $warehouse_id = $data[1];
$stock = (warehouse_product_stock($item[1] ,$warehouse_id));

$ctn_stock = $stock/$item_all->pack_size;
?>
<table>
<tr>
<td>
<input name="stk" type="text" class="input3" id="stk" style="width:80px;" readonly="readonly" required="required" value="<?=$ctn_stock?>"/>
</td>
<td>
<input name="unit_name" type="text" class="input3" id="unit_name" style="width:80px;" value="<?=$item_all->unit_name?>" readonly required/>
<input name="pkt_size" type="hidden" class="input3" id="pkt_size" style="width:80px;" onchange="count()" value="<?=$item_all->pack_size?>" readonly required/>
</td>
<td>
<input name="ctn_rate" type="text" class="input3" id="ctn_rate"  maxlength="100" style="width:80px;" onchange="count()" value="<?=$item_all->cost_crt_price?>"  required/>
<input name="rate" type="hidden" class="input3" id="rate"  maxlength="100" style="width:80px;" onchange="count()" value="<?=$item_all->cost_price?>"  required/>
</td>
</tr>
</table>