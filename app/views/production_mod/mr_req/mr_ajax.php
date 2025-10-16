<?php


session_start();


require "../../support/inc.all.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');





$str = $_POST['data'];


$data=explode('##',$str);


$item=explode('#>',$data[0]);


$item_id = $item[2];


if($item_id>0){


 $stock = warehouse_product_stock($item_id ,$data[1]);
$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');

$stock_qty = find_a_field('journal_item','(sum(item_in)-sum(item_ex)) as stock_qty','item_id="'.$item_id.'" and warehouse_id="12"');

 $s_journal =  find_a_field('journal_item','SUM(item_in)','item_id="'.$item_id.'" and tr_from="Purchase"');

$s_req =  find_a_field('requisition_order','SUM(qty)','item_id="'.$item_id.'"');

$s_pqty = ($s_req-$s_journal);


}


?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><input name="qoh" type="text" class="input3" id="qoh" style="width:60px;" value="<?=(int)$stock?>" onfocus="focuson('qty')" readonly/> </td>
    <td><input name="cwhqty" type="text" class="input3" id="cwhqty" style="width:60px;" value="<?=(int)$stock_qty?>" onfocus="focuson('qty')" readonly/> </td>
    <td><input name="prpqty" type="text" class="input3" id="prpqty" style="width:60px;" value="<?=(int)$s_pqty?>" onfocus="focuson('qty')" readonly/> </td>
    <td>
<input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:30px;" value="<?=$item_all->unit_name?>" onfocus="focuson('qty')" readonly/></td>
  </tr>
</table>

 

