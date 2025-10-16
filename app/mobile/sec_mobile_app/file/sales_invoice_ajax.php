<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$str = $_POST['data'];
$data=explode('##',$str);


$item_id=$data[0];
$do_no=$data[1];
    
//  $item_all= find_all_field('item_info','','item_id="'.$item_id.'"');
  $sql100 = 'select * from item_info where  item_id="'.$item_id.'"';
 $query100 = mysqli_query($conn,$sql100);
 $item_all = mysqli_fetch_object($query100);
//  echo  $row100->item_id;
//  echo  $row100->unit_name;

// ini_set('display_errors','1');
// ini_set('display_startup_errors','1');
// error_reporting(E_ALL);


$do_sql='SELECT  * FROM sale_do_master WHERE do_no="'.$do_no.'" ';
$query100 = mysqli_query($conn,$sql100);
$do_data = mysqli_fetch_object($query100);
//  $do_data = find_all_field_sql($do_sql);
 $dealer_type = find_a_field('dealer_info','dealer_type','dealer_code="'.$do_data->dealer_code.'"');
 
 $dealer_price = find_a_field('sales_price_dealer','set_price','item_id="'.$item_id.'" and dealer_code="'.$do_data->dealer_code.'"');
 $dealer_type_price = find_a_field('sales_price_dealer_type','set_price','item_id="'.$item_id.'" and dealer_type="'.$dealer_type.'"');
 
 if($dealer_price>0){
 $item_sales_price = $dealer_price;
 }elseif($dealer_type_price>0){
 $item_sales_price = $dealer_type_price;
 }else{
 $item_sales_price=$item_all->d_price;
 }
 
 //$stock_in_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_id.'" and warehouse_id="'.$do_data->depot_id.'" ');
  $stock_in_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_id.'" and warehouse_id=1');
  $stock_in_ctn = $stock_in_pcs/$item_all->pack_size;
 
//$price_sql='SELECT  * FROM sales_price_warehouse WHERE item_id="'.$item_id.'" and warehouse_id="'.$do_data->depot_id.'" ';
//$price_data = find_all_field_sql($price_sql);

?>

					<div class="row mb-0">
				   <div class="col-6">
				   				<label for="form1">Description</label>
							<input name="pkt_size" type="hidden" id="pkt_size" value="<?=$item_all->pack_size?>" readonly="readonly" class="form-control validate-text" />
							 <input name="item_name" type="text"  value="<?=$item_all->item_name;?>" id="item_name"  readonly="" class="form-control validate-text" placeholder="Description"/> 					
					</div>

					<div class="col-6">
					<label for="form1">Unit</label>
					<input name="unit_name" type="text" value="<?=$item_all->unit_name;?>" id="unit_name" class="form-control validate-text" placeholder="Unit"/>						
					</div>

				
					
					
					<div class="col-6">
					<label for="form1">Stock</label>
					<input name="pcs_stock" type="text" value="<?=(int)$stock_in_pcs;?>" id="pcs_stock" class="form-control validate-text" placeholder="Stock"/>					
					</div>
					
				
					
					<div class="col-6">
					<label for="form1">Price</label>
					<input name="unit_price" type="text"  id="unit_price" onkeyup="count()" required="required"  value="<?=$item_sales_price?>" class="form-control validate-text" placeholder="Price"/>
					</div>

</div>




