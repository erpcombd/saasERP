<?php


// $tst = 'omar';

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

$str = $_POST['data'];

$data=explode('##',$str);

$fg_code=$data[0];

$warehouse=$data[1];
   
$item_all= find_all_field('item_info','','item_id="'.$fg_code.'"');

$final_stock=find_a_field('journal_item','sum(item_in-item_ex)','item_id='.$item_all->item_id.' and warehouse_id='.$warehouse.'');

$final_price=find_a_field('journal_item','final_price','item_id='.$item_all->item_id.' and tr_from in ("Purchase","Production Receive","Opening","Opening Adjustment","InterPurchase","Other Receive","Conversion Receive") order by id desc');



?>


	 
 
<input type="text" name="unit_name" id="unit_name"  value="<?=$item_all->unit_name;?>" />
<input type="text" name="stock" id="stock" value="<?=$final_stock?>"  />
<input name="unit_price" type="text" id="unit_price" value="<?=$final_price?>" onkeyup="TRcalculationpo(<?=$data->id?>)" style="width:80px; height:30px;"   />




