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
   $do_no=$data[1];
  
  
 $item_all= find_all_field('item_info','','item_id="'.$fg_code.'"');
 
 $final_stock=find_a_field('journal_item','sum(item_in-item_ex)','item_id='.$item_all->item_id.' and warehouse_id='.$warehouse.'');

 //$do_sql='SELECT  * FROM sale_do_master WHERE do_no="'.$do_no.'" ';
 //$do_data = find_all_field_sql($do_sql);
 
 //$stock_in_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_id.'" and warehouse_id="'.$do_data->depot_id.'" ');
  //$stock_in_ctn = $stock_in_pcs/$item_all->pack_size;
 
//$price_sql='SELECT  * FROM sales_price_warehouse WHERE item_id="'.$item_id.'" and warehouse_id="'.$do_data->depot_id.'" ';
//$price_data = find_all_field_sql($price_sql);

?>


	 
	 
	 <input name="item_id" type="hidden" class="input3"  value="<?=$item_all->item_id;?>" id="item_id" style="width:90%; height:30px;"  readonly="" />
	 <input type="hidden" name="stock" id="stock" value="<?=$final_stock?>"  />
	 
	 <input name="item_name" type="text" class="input3"  value="<?=$item_all->item_name;?>" id="item_name" style="width:80%; height:30px;"  readonly="" />
	 <input name="unit_name" type="hidden" class="input3"  value="<?=$item_all->unit_name;?>" id="unit_name" style="width:90%; height:30px;" />
	 



