<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';
//var_dump($_SESSION);
$title = "Sales Return Invoice";
$page = "return_sales_invoice.php";


require_once '../assets/template/inc.header.php';


$group_for 	    = $_SESSION['user']['company_id'] = 1;
$user_id	    = $_SESSION['user']['id'];
$username	    = $_SESSION['user']['username'];
$pg	            = $_SESSION['user']['product_group'];
$region_id	    = $_SESSION['user']['region_id'];
$zone_id	    = $_SESSION['user']['zone_id'];
$area_id	    = $_SESSION['user']['area_id'];

$page_for           = 'Sales Return';
$table_master       = 'ss_receive_master';
$table_details      = 'ss_receive_details_new';
$unique = 'or_no';




if ($_GET['challan'] > 0) {
		$_SESSION['or_no2'] = $_GET['challan'];
}

if ($_GET['pal'] == 2) {
	unset($$unique);
	unset($_SESSION['or_no2']);
}

if ($_GET['or_no'] > 0) $_SESSION['or_no2'] = $_GET['or_no'];




/*?>if(isset($_POST['new'])){
		$crud   = new crud($table_master);
		if(!isset($_SESSION['or_no2'])) {
		$_POST['entry_by']	=$_SESSION['user']['username'];
		$_POST['entry_at']	=date('Y-m-d H:i:s');
		$_POST['edit_by']	=$_SESSION['user']['username'];
		$_POST['edit_at']	=date('Y-m-d H:i:s');
		$_POST['warehouse_id']=$_SESSION['user']['warehouse_id'];
		$_POST['vendor_name']	=find1('select shop_name from ss_shop where dealer_code="'.$_POST['vendor_id'].'"');
		$$unique=$_SESSION['or_no2']=$crud->insert();
		//unset($$unique);
		$type=1;
		$msg=$title.'  No Created. (No :-'.$_SESSION['or_no2'].')';	
		?><script>window.location.href = "return_sales.php?or_no=<?=$$unique;?>";</script><?
		} else {
		    
		$_POST['edit_by']	=$_SESSION['user']['username'];
		$_POST['edit_at']	=date('Y-m-d H:i:s');
		$_POST['or_no']		=$_SESSION['or_no2'];
		$_POST['vendor_name']	=find1('select shop_name from ss_shop where dealer_code="'.$_POST['vendor_id'].'"');
		
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		}
} // end new<?php */

//// This code of old v
//if (isset($_POST['addItems'])) {
//
//	$table		= $table_details;
//	$crud      	= new crud($table);
//
//	foreach ($_POST['item_ids'] as $itemID) {
//		$_POST['or_no'] = $_SESSION['or_no2'];
//		$_POST['item_id'] = $itemID;
//		$_POST['vendor_id'] = $_SESSION['vendor_id'];
//		$_POST['unit_name'] = $_POST['unit_name_' . $itemID];
//		$_POST['rate'] = $_POST['unit_price_' . $itemID];
//		$_POST['qty'] = $_POST['qty_' . $itemID];
//		$_POST['amount'] = $_POST['amount_' . $itemID];
//		$_POST['receive_type'] = 'Sales Return';
//		if ($_POST['qty'] > 0) {
//			$crud->insert();
//		}
//	}
//}
//


			if (isset($_POST['addItems']) && $_POST[$unique] > 0) {
				$table		= $table_details;
				$crud      	= new crud($table);

				foreach ($_POST['item_ids'] as $itemID) {
//					$_POST['or_no'] = $_SESSION['or_no2'];
//					$_POST['item_id'] = $itemID;
					$_POST['pkt_unit'] = $_POST['pkt_unit_' . $itemID];
					$_POST['unit_price'] = $_POST['unit_price_' . $itemID];
					$_POST['nsp_per'] = $_POST['nsp_per_' . $itemID];
					$_POST['stock'] = $_POST['stock_' . $itemID];
					$_POST['item_id'] = $itemID;

					if ($_POST['pkt_unit'] > 0) { // && $_POST['stock']>0

						$_POST['total_unit'] = $_POST['pkt_unit'];
						$_POST['total_amt'] = ($_POST['total_unit'] * $_POST['unit_price']);
						$item_info = find_all_field('item_info', '*', 'item_id =' . $_POST['item_id']);

						$_POST['t_price'] = $item_info->t_price;
						$_POST['total_tp'] = ($_POST['t_price'] * $_POST['total_unit']);
						$_POST['dp_price'] = $item_info->t_price;
						$_POST['fp_price'] = $item_info->f_price;

						$_POST['entry_by'] = $_SESSION['user']['username'];
						$_POST['depot_id'] = $_SESSION['user']['warehouse_id'];
						$_POST['gift_on_order'] = $crud->insert();
						//$do_date = date('Y-m-d');
						$_POST['gift_on_item'] = $_POST['item_id'];
						$total_unit = $_POST['total_unit'];

						$_SESSION['category_id'] = $_POST['category_id'];
						$_SESSION['subcategory_id'] = $_POST['subcategory_id'];

						$sss = "select * from ss_gift_offer where item_id='" . $_POST['item_id'] . "' 
and ((max_qty>='" . $total_unit . "' and  min_qty<='" . $total_unit . "') or (max_qty=0 and  min_qty=0)) and start_date<='" . $do_date . "' and end_date>='" . $do_date . "'  ";
						$qqq = mysqli_query($conn, $sss);

						while ($gift = mysqli_fetch_object($qqq)) {

							if ($gift->item_qty > 0) {
								$_POST['gift_id'] = $gift->id;
								$gift_item = find_all_field('item_info', '', 'item_id="' . $gift->gift_id . '"');
								$_POST['item_id'] = $gift->gift_id;

								$_POST['dp_price'] = $gift_item->t_price;
								$_POST['fp_price'] = $gift_item->f_price;

								if ($gift->gift_id == 1096000100010239) {
									$_POST['unit_price'] = (-1) * ($gift->gift_qty);
									$_POST['total_amt']  = (((int)($total_unit / $gift->item_qty)) * ($_POST['unit_price']));
									$_POST['total_unit'] = (((int)($total_unit / $gift->item_qty)));

									$_POST['dist_unit'] = $_POST['total_unit'];
									$_POST['pkt_unit']  = '0.00';
									$_POST['pkt_size']  = '1.00';
									$_POST['t_price']   = '-1.00';
									$_POST['entry_by'] = $username;
									$crud->insert();
								} elseif ($gift->gift_id == 1096000100010312) {
									$_POST['unit_price'] = (-1) * ($gift->gift_qty);
									$_POST['total_amt']  = (((int)($total_unit / $gift->item_qty)) * ($_POST['unit_price']));
									$_POST['total_unit'] = (((int)($total_unit / $gift->item_qty)));

									$_POST['dist_unit'] = $_POST['total_unit'];
									$_POST['pkt_unit']  = '0.00';
									$_POST['pkt_size']  = '1.00';
									$_POST['t_price']   = '-1.00';
									$_POST['entry_by'] = $username;
									$crud->insert();
								} else {
									$_POST['unit_price'] = '0.00';
									$_POST['total_amt'] = '0.00';
									$_POST['total_unit'] = (((int)($total_unit / $gift->item_qty)) * ($gift->gift_qty));

									$_POST['dist_unit'] = ($_POST['total_unit'] % $gift_item->pack_size);
									$_POST['pkt_unit'] = (int)($_POST['total_unit'] / $gift_item->pack_size);
									$_POST['pkt_size'] = $gift_item->pack_size;
									$_POST['t_price'] = '0.00';
									if ($_POST['unit_price'] == 0 && $_POST['total_unit'] == 0) {
										echo '';
									} else
										$_POST['entry_by'] = $username;
									$crud->insert();
								}
								//		unset($_POST['gift_id']);
								//		unset($_POST['gift_on_order']);
								//		unset($_POST['gift_on_item']);
							}
						} // end if item id >0
					}
				}
				
			}




$$unique = $_SESSION['or_no2'];
$so_status = find_a_field('ss_receive_master', 'status', 'do_no="' . $$unique . '"');

if (isset($_POST['delete'])) {

	$crud   = new crud($table_master);
	$condition = $unique . "=" . $$unique;
	$crud->delete($condition);
	$crud   = new crud($table_details);
	$condition = $unique . "=" . $$unique;
	$crud->delete_all($condition);
	unset($$unique);
	unset($_SESSION['or_no2']);
	$type = 1;
	$msg = 'Successfully Deleted.';
?><script>
		window.location.href = 'return_sales_manual.php?pal=2';
	</script><?php
			}

			if (isset($_POST['hold'])) {
				unset($$unique);
				unset($_SESSION['or_no2']);
				$type = 1;
				$msg = 'Successfully Holded.';
				?><script>
		window.location.href = 'return_sales_manual.php?pal=2';
	</script><?php
			}


if (isset($_POST['confirmm'])) {

	if ($so_status == 'MANUAL') {

		$_POST[$unique] = $$unique;
		$_POST['checked_at']  = date('Y-m-d H:i:s');
		$_POST['checked_by']  = $_SESSION['user']['username'];
		$_POST['status']    = 'CHECKED';
		$_POST['depot_id'] = $_SESSION['user']['warehouse_id'];

		$crud   = new crud($table_master);
		$crud->update($unique);
		$crud   = new crud($table_details);
		$crud->update($unique);

		unset($$unique);
		unset($_POST[$unique]);
		unset($_POST);
		$type = 1;
		$msg = 'Successfully Forwarded.';

?><script>
			window.location.href = "return_list.php"
		</script><?
				} else {
					?><script>
			window.location.href = "return_list.php"
		</script><?
				}
			}


			if (isset($_POST['add']) && ($_POST[$unique] > 0)) {

				$crud   = new crud($table_details);

				$_POST['unit_name'] = $_POST['unit'];
				$_POST['rate']          = $_POST['price'];
				$_POST['warehouse_id']  = $_SESSION['user']['warehouse_id'];

				$_SESSION['category_id'] = $_POST['category_id'];
				$_SESSION['subcategory_id'] = $_POST['subcategory_id'];

				if ($_POST['item_id'] > 0) {
					if ($_POST['rate'] > 0) {
						unset($_POST['id']);
						$xid = $crud->insert();
					}
				}
			} // end add



			if ($$unique > 0) {
				$condition = $unique . "=" . $$unique;
				$data = db_fetch_object($table_master, $condition);
				foreach ($data as $key => $value) {
					$$key = $value;
				}
			}


			if ($$unique > 0) $btn_name = 'Update';
			else $btn_name = 'Start';
			if ($_SESSION['or_no2'] < 1)
				$$unique = db_last_insert_id($table_master, $unique);
?>
<script language="javascript">
	function focuson(id) {
		if (document.getElementById('id').value == '')
			document.getElementById('id').focus();
		else
			document.getElementById(id).focus();
	}

	window.onload = function() {
		if (document.getElementById("warehouse_id").value > 0)
			document.getElementById("id").focus();
		else
			document.getElementById("req_date").focus();
	}
</script>

<script language="javascript">
	function count() {
		var num = ((document.getElementById('qty').value) * 1) * ((document.getElementById('price').value) * 1);
		document.getElementById('amount').value = num.toFixed(2);
	}
</script>

<style>
/*.header{ display:none !important;}*/
</style>




<!-- start of Page Content-->
<div class="page-content header-clear-medium">

	<div class="card card-style m-0">
		<?php
		//echo 'or_no2='.$_SESSION['or_no2'];
		if ($_SESSION['or_no2'] > 0) {

			$sr_no = $_SESSION['or_no2'];
			$so_return = find_all_field('ss_do_chalan',' ', 'chalan_no="'.$sr_no.'"');
			$_SESSION['vendor_id'] = $so_return->dealer_code;
			$vendor_name=find_a_field('ss_shop', 'shop_name', 'dealer_code="' .$so_return->dealer_code . '"');

		?>

			<form action="?<?= $unique ?>=<?= $$unique ?>" method="post" name="cloud" id="cloud">
				<input type="hidden" name="<?=$unique; ?>" value="<?=$$unique; ?>" />
				<input name="vendor_id" type="hidden" id="vendor_id" value="<?=$so_return->dealer_code; ?>" />
				<input name="vendor_name" type="hidden" id="vendor_name" value="<? //=$so_return->vendor_name; ?>" />
				<input name="or_date" type="hidden" id="or_date" value="<?=$so_return->or_date; ?>" />
				<input name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['warehouse_id']; ?>" />



				<div class="content mt-0">
					<!-- Card Section with custom border size -->
					<div class="do_entry_card mt-2 custom-card-border"> <!-- Added custom-card-border class -->
						<div class="card-body">
							<!-- DO Number -->
							<div class="text-center">
								<button type="button" class="btn btn-outline-primary btn-sm"> SALES RETURN NO : <?=$sr_no; ?> </button>
							</div>
							<div class="d-flex justify-content-between align-items-center">

								<!-- Shop Details -->
								<div class="mb-2">
									<p class="mb-1 text-dark"><strong>Party Name:</strong> <?=$vendor_name; ?></p>
									<p class="mb-0 text text-dark"><strong style="color:green">Return Date:</strong> <?=date("Y-m-d"); ?></p>
								</div>

								<!-- Amount -->
								<div class="text-end">
									<h4 class="mb-0"> <span id="total_item_amt">0</span>

									</h4>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="content">
				
					<div class="" style="zoom: 78%;">
					<table class="table table-borderless text-center rounded-sm shadow-l table-scroll">
						<thead>
							<tr class="bg-night-light">
								<th scope="col" class="color-white"> Item </th>
								<th scope="col" class="color-white"> Unit</th>
								<th scope="col" class="color-white"> Stock</th>
								<th scope="col" class="color-white"> TP</th>
								<th scope="col" class="color-white"> NSP</th>
								<th scope="col" class="color-white"> Offer %</th>
								<th scope="col" class="color-white"> Challan Qty</th>
								<th scope="col" class="color-white"> Qty</th>
								<th scope="col" class="color-white"> Amt</th>
							</tr>
						</thead>
						<tbody>  
 
 <?
  //$sql='select i.finish_goods_code, i.item_id,i.item_name,i.unit_name,i.t_price,i.pack_size,i.nsp_per from item_info i where  i.subcategory_id="'.$sub_item.'"';
   $sql='SELECT i.item_name,i.finish_goods_code, c.* FROM ss_do_chalan c, item_info i WHERE chalan_no = "'.$sr_no.'" and c.item_id=i.item_id;';
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
 <td colspan="9" align="left" class="sr-td-t">
	 <strong><?=$data->item_name?></strong> <?=$data->finish_goods_code?>

 </td> 
 </tr>
<tr  class="sr-td-b">	
								<td> </td>
								<td> <?=$data->unit_name?> </td>
								<td> <?=($stk+$item_in);?> </td>
								<td> <?=$data->t_price?> </td>
								<td> <?=$nsp_amt_cus?> </td>
								<td> 
								<input type="hidden" id="nsp_per2"  value="<?=$item_all->nsp_per?>" style="display: none;" />
<input name="nsp_per_<?=$data->item_id?>" type="number" max="<?=number_format($data->nsp_per, 2)?>"  id="nsp_per_<?=$data->item_id?>" onChange="update_nsp_amt(<?=$data->item_id?>)" value="<?=number_format($data->nsp_per, 2)?>" readonly style=" border: 0px solid #f8f9fa !important; background: #f8f9fa; "/>
								</td>
								
								<td> <?=$data->total_unit;?></td>
								 
															 
								<td>
									<input name="pkt_unit_<?=$data->item_id?>"  type="number"  id="pkt_unit_<?=$data->item_id?>" onKeyUp="update_nsp_amt(<?=$data->item_id?>)" />
									<input name="total_unit" type="hidden"  id="total_unit" readonly="readonly"/>
									<input name="total_amt" type="hidden" id="total_amt" readonly="readonly"/>
								</td>
								 <?php $final_total_amt_cal =  $data->pkt_unit*$nsp_amt_cus; ?>	
								<td>
									<input name="total_amt_<?=$data->item_id?>" value="<?=$data->total_amt;?><? //=$final_total_amt_cal?>" type="text"  id="total_amt_<?=$data->item_id?>" readonly style=" border: 0px solid #f8f9fa !important;!i;!; background: #f8f9fa; "/>
								 </td>
							</tr>
<? } ?>
						</tbody>
				</table>
			<!--<center><input name="addItems" type="submit" value="Add Item" class=" b-n btn btn-success"  style="width: 33% !important;" /></center>-->
			<div class="content">
					<div class="row">
						<div class="col-6">
							<button name="delete" type="submit" value="Delete" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-danger w-100">Delete</button>
						</div>
<!--						<div class="col-4 p-1">
							<button name="hold" type="submit" value="Hold" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-primary  w-100">Hold</button>
						</div>-->
						<div class="col-6">
							<button name="confirmm" type="submit" value="Confirm" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-success  w-100">Confirm</button>
						</div>
					</div>
				</div>
				
					</div>
				</div>
			</form>
		<? } ?>
	</div>


</div>
<!-- End of Page Content-->

<?php
require_once '../assets/template/inc.footer.php';
//selected_two("#vendor_id");
selected_two("#category_id", "Category");
selected_two("#subcategory_id", "Sub Category");
selected_two("#item_id");
?>

<script>
	$(document).ready(function() {
		$('#vendor_id').select2({
			placeholder: "Select", // Placeholder text
			allowClear: true, // Allow clearing the selection
			dropdownAutoWidth: true, // Auto width for dropdown
			width: '100%' // Full width for the dropdown
		});
	});


</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script>
	jQuery('.party_list').chosen();
	jQuery('.item_list').chosen();
</script>

<script type="text/javascript">

	//ajax item js (in this js comment are using of increment and decrement data) 
	var previousValues = {}; //This is the total item increse value set
	function update_nsp_amt(id) {

		var net_totalss = 0; //This is the totel defule vlue set

		var tp_amt = document.getElementById("unit_price2_" + id).value * 1;
		var nsp_per_amt = document.getElementById("nsp_per_" + id).value * 1;
		var total_amt = document.getElementById("pkt_unit_" + id).value * 1;

		//var final_amt =  tp_amt-((nsp_per_amt/100)*tp_amt);
		var final_amt = (tp_amt * (1 - (nsp_per_amt / 100))).toFixed(2); //this code for 0.00
		var final_total_amt = (total_amt * final_amt);


		document.getElementById("unit_price_" + id).value = final_amt;
		document.getElementById("total_amt_" + id).value = final_total_amt;

		var previousTotal = previousValues[id] || 0; //this is the set previous value with id
		net_totalss = parseFloat(document.getElementById("total_item_amt").innerText); // this code is set float data in id
		net_totalss = net_totalss - previousTotal + final_total_amt; // this is conduction 
		document.getElementById("total_item_amt").innerText = net_totalss.toFixed(2); // this code is print the data
		previousValues[id] = final_total_amt; // return the data in id 

	}


	//ajax item js (in this js comment are using of increment and decrement data) 
	function update_item_amt(id) {
		//var pkt_size = document.getElementById("pkt_size_" + id).value * 1;
		//var total_qty = (pkt_size * unit_price);
		var unit_price = document.getElementById("unit_price_" + id).value * 1;
		var qty = document.getElementById("qty_" + id).value * 1;
		document.getElementById("amount_" + id).value = qty * unit_price;

	}
</script>