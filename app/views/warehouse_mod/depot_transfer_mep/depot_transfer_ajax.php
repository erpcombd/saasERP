<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$item_id =$_POST['id'];


$info = find_all_field('item_info','','item_id="'.$item_id.'"');

$price  = find_a_field('journal_item','final_price','1 and tr_from in ("Purchase","Production Receive","Opening")  and  item_id='.$item_id.' order by id desc');


//$price = $info->cost_price;

if($price==0){

$price = $info->cost_price;
	if($price==0){
	$price ='';
	}
}

$unit = $info->unit_name;

//$stock_opening_date=find_a_field('warehouse','stock_date',' warehouse_id="'.$_SESSION['user']['depot'].'"  ');
//if($stock_opening_date!='0000-00-00'){
    //$stock_date_con=' and ji_date>="'.$stock_opening_date.'"';
//}

//$ss="select sum(item_in)-sum(item_ex) as stock from journal_item where item_id='".$item_id."' ".$stock_date_con." and warehouse_id='".$_SESSION['user']['depot']."' "; 
$stock = find_a_field('journal_item','sum(item_in)-sum(item_ex) as stock','  item_id="'.$item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" ');


$arr = array('price' => $price, 'unit' => $unit, 'item_name' => $info->item_name, 'stock' => $stock);

echo json_encode($arr);

?>




