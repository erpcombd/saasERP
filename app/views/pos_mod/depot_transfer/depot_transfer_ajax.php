<?php

session_start();

require_once "../../../assets/support/inc.all.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');



$str = $_POST['data'];

$data=explode('##',$str);

$item=explode('#>',$data[0]);

$item_id=$item[2];



$item_all= find_all_field('item_info','','item_id="'.$item[2].'"');
$in_stock_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_all->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" ');
$in_stock = (int)($in_stock_pcs / $item_all->pack_size);

$item_price = find_a_field('journal_item','final_price','item_id="'.$item_all->item_id.'" and tr_from in ("Purchase","Opening") order by ji_date desc ');

?>

<table style="width:100%;" border="1">
	 <tr>
<td width="33%"><input name="total_unit2" id="total_unit2" type="text" class="input3" style="width:98%;" onfocus="focuson('total_pkt')" value="<?=$item_all->unit_name?>"/>    

<input name="pkt_size" id="pkt_size" type="hidden" value="<?=$item_all->pack_size?>"/></td>
<td width="33%"><input name="old_production_date" type="text" class="input3" id="stock2"  maxlength="100" style="width:98%;" value="<?=$in_stock_pcs?>"/></td>
<td width="33%"><input name="unit_price" id="unit_price" type="text" class="input3" id="unit_price"  maxlength="100" style="width:98%;" value="<?=$item_price; ?>"/></td>
</tr></table>