<?php
//
require "../../support/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$item=explode('-',$data[0]);

 $req_no=$data[1];

$item_id = $item[0];
if($item_id>0){
//$stock = warehouse_product_stock($item_id ,$data[1]);
//$in_stock_pcs = find_a_field('journal_item','sum(item_in)-sum(item_ex)','item_id="'.$item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
//
//$in_stock = (int)($in_stock_pcs);

$rq_data = find_all_field('spare_parts_requisition_master','','req_no='.$req_no);

 $po_sql="SELECT sum(b.qty) as po_qty, sum(b.amount) as po_value FROM purchase_sp_master a, purchase_sp_invoice b  
WHERE a.po_no=b.po_no and a.po_date<='".$rq_data->req_date."' and a.status!='MANUAL' and b.item_id='".$item_id."'";
$po_data = find_all_field_sql($po_sql);



 $so_sql="SELECT sum(b.qty) as so_qty, sum(b.amount) as so_value FROM spare_parts_requisition_master a, spare_parts_requisition_order b  
WHERE a.req_no=b.req_no and a.req_date<='".$rq_data->req_date."' and b.item_id='".$item_id."'";
$so_data = find_all_field_sql($so_sql);


$avg_price = ($po_data->po_value/$po_data->po_qty);

$item_stock = ($po_data->po_qty-$so_data->so_qty);

$item_all= find_all_field('item_info','','item_id="'.$item_id.'"');



}





?>
  





<table>
							<tr>
								<td>

<input name="unit_name" type="text" class="input3" id="unit_name" style="width:80px;" value="<?=$item_all->unit_name?>" onfocus="focuson('qty_ctn')" readonly/>

<input name="item_special" type="hidden" class="input3" id="item_special" style="width:70px; height:20px;" value="<?=$item_all->item_special?>" readonly/>

								</td>
								
								<td>
								<input name="stock" type="text" class="input3" id="stock" style="width:80px;" value="<?=$item_stock?>" onfocus="focuson('qty_ctn')" readonly/>
								</td>
								
								<td>
								<input name="unit_price" type="text" class="input3" id="unit_price" style="width:80px;" value="<?=$avg_price?>"   required/>
								</td>
								
								
							</tr>
						</table>