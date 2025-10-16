<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$item=explode('#>',$data[0]);
$item_id = $item[1];
if($item_id>0){
$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');
// $purchase_price=find_a_field('journal_item','final_price','item_id="'.$item_all->item_id.'" and tr_from in("Purchase","Production Receive") limit 1');
$p_price=find_a_field('journal_item','item_price','item_id="'.$item_all->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" and tr_from like "Purchase" order by ji_date desc ');
 /*$psql= 'select item_price from journal_item where item_id="'.$item_all->item_id.'" and tr_from in("Purchase","Production Receive") order by id desc limit 1';
$pquery=db_query($psql);
while($p_data=mysqli_fetch_object($pquery)){
 	$p_price=number_format($p_data->item_price,2);
}*/
$warehouse_id = $data[1];
}
?>
<input name="unit_name" type="text" class="input3" id="unit_name2" style="width:122px;float:left;" value="<?=$item_all->unit_name?>" readonly required onfocus="focuson('rate')"/>
<input name="rate" type="text" class="input3" id="rate2"  maxlength="100" style="width:112px;float:left;" onchange="count2()" value="<?=$p_price?>"   />