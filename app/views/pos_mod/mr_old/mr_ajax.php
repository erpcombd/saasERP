<?php

session_start();

require_once "../../../assets/support/inc.all.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');



$str = $_POST['data'];

$data=explode('##',$str);

$item=explode('#>',$data[0]);

$item_id = $item[2];

if($item_id>0){

$stock = (int)warehouse_product_stock($item_id ,$data[1]);

$last_p = find_all_field('purchase_invoice','','item_id="'.$item_id.'" order by id desc');

$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');}

?>

<input name="qoh" type="text" class="input3" id="qoh" style="width:110px;float:left;" value="<?=$stock?>"  />  

<input name="last_p_qty" type="text" class="input3" id="last_p_qty" style="width:110px;float:left;" value="<?=$last_p->qty?>" onfocus="focuson('qty')" />  

<input name="last_p_date" type="text" class="input3" id="last_p_date"  style="width:110px;float:left;" value="<?=$last_p->po_date?>" onfocus="focuson('qty')" />  

<input name="unit_name" type="text" class="input3" id="unit_name"  maxlength="100" style="width:110px;float:left;" value="<?=$item_all->unit_name?>" onfocus="focuson('qty')" />