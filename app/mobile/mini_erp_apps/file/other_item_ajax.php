<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

 $warehouse_id	=$_SESSION['user']['warehouse_id'];
 $sub_item= $_POST['subcategory_id'];
 //$opening_date=date('Y-m-d');
?>
 
 


					<table class="table table-borderless text-center rounded-sm shadow-l table-scroll">
						<thead>
							<tr class="bg-night-light">
								<th scope="col" class="color-white"> Item </th>
<!--								<th scope="col" class="color-white"> Unit</th>-->
<!--								<th scope="col" class="color-white"> Stock</th>
								<th scope="col" class="color-white"> TP</th>
								<th scope="col" class="color-white"> NSP</th>
								<th scope="col" class="color-white"> Offer %</th>-->
								<th scope="col" class="color-white">Replace Qty</th>
<!--								<th scope="col" class="color-white"> Amt</th>-->
							</tr>
						</thead>
						<tbody>  
 
 <?
 $sql='select i.finish_goods_code, i.item_id,i.item_name,i.unit_name,i.t_price,i.pack_size,i.nsp_per from item_info i where  i.subcategory_id="'.$sub_item.'"';

  $query=mysqli_query($conn,$sql); 
  while($data=mysqli_fetch_object($query)){
?>

<input name="item_ids[]" id="item_ids[]" type="hidden" value="<?=$data->item_id?>"/>
<input name="item_id_<?=$data->item_id?>" type="text" step="0.01" id="item_id_<?=$data->item_id?>" value="<?=$data->item_name?>" readonly style="display: none;"/>
<input name="unit_name_<?=$data->item_id?>" type="text"  id="unit_name_<?=$data->item_id?>"  value="<?=$data->unit_name?>" style="display: none;"/>

<?php /*?><? $qty= find_a_field('ss_journal_item','sum(item_in-item_ex)',' warehouse_id="'.$warehouse_id.'" and ji_date>="'.$opening_date.'" and item_id="'.$data->item_id.'" ') ?><?php */?>
								<?
								$opening_date = find1("select max(ji_date) from ss_journal_item where tr_from='Opening' and warehouse_id='".$warehouse_id."' ");
										if($opening_date=='') {
											$opening_date='2021-08-01';
										}
								
								$sql_in="select item_id, sum(total_unit) as qty 
										from sale_do_chalan 
										where chalan_date>='".$opening_date."' and dealer_code='".$warehouse_id."' and item_id='".$data->item_id."'";
										$query1 = mysqli_query($conn,$sql_in);
										$info1=mysqli_fetch_object($query1);
										$item_in=$info1->qty;
										
										
								 $sql2="select item_id,sum(item_in-item_ex) as qty
										from ss_journal_item
										where warehouse_id='".$warehouse_id."' and ji_date>='".$opening_date."' and item_id='".$data->item_id."' ";
										$query2 = mysqli_query($conn,$sql2);
										$info2=mysqli_fetch_object($query2);
										$stk = $info2->qty;
								?>
<input name="stock_<?=$data->item_id?>" class="form-control input3" type="text"  id="stock"  value="<?=($stk+$item_in);?> "  style="display: none;" readonly  />
<input name="unit_price2_<?=$data->item_id?>" type="number" step="0.01" id="unit_price2_<?=$data->item_id?>" value="<?=$data->t_price?>" readonly style="display: none;"/>
<?php $nsp_amt_cus =  $data->t_price*(1-($data->nsp_per/100)); ?>
<input name="unit_price_<?=$data->item_id?>" type="number" step="0.01" class="form-control input3" id="unit_price_<?=$data->item_id?>" value="<?=$nsp_amt_cus?>" readonly style="display: none;"/>
<input name="pkt_size_<?=$data->item_id?>" type="hidden" class="form-control input3" id="pkt_size_<?=$data->item_id?>" value="<?=$item_all->pack_size?>" readonly style="display: none;"/>




					
 <tr>
 <td colspan="8" align="left" class="sr-td-t">
	 <strong><?=$data->item_name?></strong> <?=$data->finish_goods_code?>

 </td> 
 </tr>
<tr  class="sr-td-b">	
								<td> </td>
<!--								<td> <?=$data->unit_name?> </td>
								<td> <?=($stk+$item_in);?> </td>-->
<!--								<td> <?=$data->t_price?> </td>
								<td> <?=$nsp_amt_cus?> </td>-->
<!--								<td> 
								<input type="hidden" id="nsp_per2"  value="<?=$item_all->nsp_per?>" style="display: none;" />
<input name="nsp_per_<?=$data->item_id?>" type="number" max="<?=number_format($data->nsp_per, 2)?>"  id="nsp_per_<?=$data->item_id?>" onChange="update_nsp_amt(<?=$data->item_id?>)" value="<?=number_format($data->nsp_per, 2)?>" />
								</td>-->
								 
															 
								<td>
									<input name="pkt_unit_<?=$data->item_id?>"  type="number"  id="pkt_unit_<?=$data->item_id?>" onKeyUp="update_nsp_amt(<?=$data->item_id?>)" />
									<input name="total_unit" type="hidden"  id="total_unit" readonly="readonly"/>
									<input name="total_amt" type="hidden" id="total_amt" readonly="readonly"/>
								</td>
								 <?php //$final_total_amt_cal =  $data->pkt_unit*$nsp_amt_cus; ?>	
<!--								<td >
									<input name="total_amt_<?=$data->item_id?>" value="<?=$final_total_amt_cal?>" type="text"  id="total_amt_<?=$data->item_id?>" />
									
								 </td>-->
								 
							</tr>				

<? } ?>
						</tbody>
				</table>
			<center><input name="addItems" type="submit" value="Add Item" class=" b-n btn btn-success"  style="width: 33% !important;" /></center>
