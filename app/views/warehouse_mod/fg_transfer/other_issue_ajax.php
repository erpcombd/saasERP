<?php





session_start();





require "../../support/inc.all.php";





@ini_set('error_reporting', E_ALL);





@ini_set('display_errors', 'Off');











 $str = $_POST['data'];





$data=explode('##',$str);





$item=explode('#>',$data[0]);





$item_id = $item[1];





if($item_id>0){





$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');


$issue_price= find_a_field('journal_item','final_price','item_id="'.$item_id.'" and tr_from in ("Production Receive","Purchase","Local Purchase") and final_price>0 order by final_price desc limit 1');


$warehouse_id = $data[1];





$stock = (int)(warehouse_product_stock($item_id ,$warehouse_id));}



?>

<input name="stk" type="text" class="input3" id="stk" style="width:50px;" readonly="readonly" required="required" value="<?=$stock?>" />

<input name="unit_name" type="text" class="input3" id="unit_name" style="width:50px;" value="<?=$item_all->unit_name?>" readonly required />

<input name="rate" type="hidden" class="input3" id="rate"  style="width:55px;"  value="<? if ($item_all->brand_category !=  'NON FG'){ echo $item_all->s_price;} else {echo $item_all->cost_price;}?>" onchange="count()" readonly="readonly"/>

<input name="pkt_size" type="hidden" class="input3" id="pkt_size"  style="width:55px;"  value="<?=$item_all->pack_size?>" onchange="count()" readonly="readonly"/>