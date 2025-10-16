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

$warehouse_id = $data[1];

if($item_all->f_price>0){ $rate=$item_all->f_price; }else{ $rate=$item_all->cost_price; }

}

?>

<input name="unit_name" type="text" class="input3" id="unit_name" style="width: 46% !important;float: left;" value="<?=$item_all->unit_name?>" readonly required onfocus="focuson('rate')"/>

<input name="rate" type="text" class="input3" id="rate"  maxlength="100" style="width: 53% !important;float: right;" onchange="count()" 

value="<?=$rate?>"  required/>