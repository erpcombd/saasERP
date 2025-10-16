<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

 $warehouse_id	=$_SESSION['user']['warehouse_id'];
 $sub_item= $_POST['subcategory_id'];
 $opening_date=date('Y-m-d');
?>
 
 


					<table class="table table-borderless text-center rounded-sm shadow-l table-scroll">
						<thead>
							<tr class="bg-night-light">
								<th scope="col" class="color-white"> Item </th>
								<th scope="col" class="color-white"> Rate </th>
								<th scope="col" class="color-white">Replace Qty</th>
								<th scope="col" class="color-white"> Amt</th>
							</tr>
						</thead>
						<tbody>  
 <?
 $sql='select i.finish_goods_code, i.item_id,i.item_name,i.unit_name,i.t_price,i.pack_size,i.nsp_per,i.nsp_price from item_info i where  i.subcategory_id="'.$sub_item.'"';
  $query=mysqli_query($conn,$sql); 
  while($data=mysqli_fetch_object($query)){
?>
<input name="item_ids[]" id="item_ids[]" type="hidden" value="<?=$data->item_id?>"/>			
 <tr>
 <td colspan="8" align="left" class="sr-td-t">
	 <strong><?=$data->item_name?></strong> <?=$data->finish_goods_code?>
 </td> 
 </tr>
<tr  class="sr-td-b">	
								<td> <input name="item_id_<?=$data->item_id?>" type="hidden" class="input3" id="item_id_<?=$data->item_id?>" value="<?=$data->item_id?>"  autocomplete="off" ></td>
								<td> <input name="rate_<?=$data->item_id?>" type="text" class="input3" id="rate_<?=$data->item_id?>" value="<?=$data->nsp_price;?>" onKeyUp="update_qty_amt(<?=$data->item_id?>)" autocomplete="off" ></td>							
								<td>
									<input name="unit_name_<?=$data->item_id?>" type="hidden"  id="unit_name_<?=$data->item_id?>"  value="<?=$data->unit_name?>"/>
									<input name="qty_<?=$data->item_id?>"  type="number"  id="qty_<?=$data->item_id?>" onKeyUp="update_qty_amt(<?=$data->item_id?>)" />
								</td>
								<td>
									<input name="amount_<?=$data->item_id?>" type="text" class="input3" id="amount_<?=$data->item_id?>" onchange="count()" autocomplete="off" >
									<input name="total_unit" type="hidden"  id="total_unit" readonly="readonly"/>
									<input name="total_amt" type="hidden" id="total_amt" readonly="readonly"/></td>
							</tr>	
<? } ?>
						</tbody>
				</table>
			<center><input name="addItems" type="submit" value="Add Item" class=" b-n btn btn-success"  style="width: 33% !important;" /></center>
