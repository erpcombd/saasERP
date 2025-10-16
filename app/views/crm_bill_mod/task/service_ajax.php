<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');



$str = $_POST['data'];

$data=explode('##',$str);

$item=explode('#>',$data[0]);
 $req_no= $data[2];

 $req_qty= find_a_field('requisition_order','qty','req_no="'.$req_no.'" and item_id="'.$item[1].'"');

$item_all= find_all_field('item_info','','item_id="'.$item[1].'"');
$warehouse_id = $data[1];

//$stock = (int)(warehouse_product_stock($item[1] ,$warehouse_id));
$item_in = find_a_field('journal_item','sum(item_in)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$item_ex = find_a_field('journal_item','sum(item_ex)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" and tr_from not in ("SampleReturn")');
$stock = $item_in-$item_ex;
if($stock<0){
 $new_stock = 0;
}else{
$new_stock = $stock;
}

?>
<table width="100%" border="1">
<tr>
<td width="25%"><input name="stk" type="text" class="input3" id="stk" style="width:98%" readonly="readonly" required="required" value="<?=$new_stock?>"/></td>

<td width="25%"><input name="unit_name" type="text" class="input3" id="unit_name" style="width:98%" value="<?=$item_all->unit_name?>" readonly required/></td>

<td width="25%"><input name="rate" type="text" class="input3" id="rate"  maxlength="100" style="width:98%"  onchange="count()" value="<?=$item_all->cost_price?>"  required/></td>
<!--<td width="25%"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:98%" onchange="count()" required/>
<input type="hidden" name="req_id" id="req_id" value="<?=$item[2]?>"/></td>-->
</tr>
</table>
