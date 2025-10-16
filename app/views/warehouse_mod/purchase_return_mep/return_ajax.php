<?php


// $tst = 'omar';

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$pr_id=$_POST['pr_id'];
$pr_no=$_POST['pr_no'];
$depot_id=$_POST['depot_id'];




  
  
  $invo_all= find_all_field('purchase_receive','','id="'.$pr_id.'"');
  $item_all= find_all_field('item_info','','item_id="'.$invo_all->item_id.'"');

 $pr_sql='SELECT  * FROM purchase_return_master WHERE pr_no="'.$pr_no.'" ';
 $pr_data = find_all_field_sql($pr_sql);
 
 $warehouse=$depot_id;
 
 
  $stock_in_pcs = find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$invo_all->item_id.'" and warehouse_id="'.$warehouse.'"');
  $stock_in_ctn = $stock_in_pcs/$item_all->pack_size;
 
//$price_sql='SELECT  * FROM sales_price_warehouse WHERE item_id="'.$item_id.'" and warehouse_id="'.$do_data->depot_id.'" ';
//$price_data = find_all_field_sql($price_sql);


$data =[
		'item_name' => $item_all->item_name,
		'pcs_stock' => $stock_in_pcs,
		'pqty' => $invo_all->qty,
		'unit_price' => number_format($invo_all->rate,2,".",""),
];


echo json_encode($data);






?>








