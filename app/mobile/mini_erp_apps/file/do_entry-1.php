<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Add Items";
$page = 'do_entry.php';

require_once '../assets/template/inc.header.php';


$table_master = 'ss_do_master';
$unique_master = 'do_no';
$table_detail = 'ss_do_details';
$unique_detail = 'id';

if ($_GET['order_id'] > 0) {
	$$unique_master = $_SESSION['order_id'] = $order_id = $_GET['order_id'];
} else if ($_GET['do_no'] > 0) {
	$$unique_master = $_SESSION['order_id'] = $order_id = $_GET['do_no'];
} else {
	$$unique_master = $_SESSION['order_id'];
}

$group_for 	    = $_SESSION['user']['company_id'] = 1;
$user_id	    = $_SESSION['user']['user_id'];
$username	    = $_SESSION['user']['username'];
$pg	            = $_SESSION['user']['product_group'];
$region_id	    = $_SESSION['user']['region_id'];
$zone_id	    = $_SESSION['user']['zone_id'];
$area_id	    = $_SESSION['user']['area_id'];

$dayName = date('l');
$sql_r = 'select * from ss_schedule where PBI_ID="' . $_SESSION['user']['username'] . '" and day_name="' . $dayName . '"';
$query_r = db_query($sql_r);
$row_r = mysqli_fetch_object($query_r);


//if($_GET['pal']==2) { unset($$unique); unset($_SESSION['do_no2']); $type=1;}

$dealer_code = $_SESSION['user']['warehouse_id'];
//do_calander('#est_date');


$dealer = find_all_field('ss_shop', '', 'dealer_code=' . $dealer_code);


//if($order_id >0){$$unique_master = $order_id;}
////if($_REQUEST['old_do_no']>0) $$unique_master=$_REQUEST['old_do_no'];
//elseif(isset($_GET['del'])) {$$unique_master=find_a_field('ss_do_details','do_no','id='.$_GET['del']); $del = $_GET['del'];}
//else
//$$unique_master=$_REQUEST[$unique_master];
if (isset($_GET['del'])) {
	$del = $_GET['del'];
}
$do_status = find_a_field('ss_do_master', 'status', 'do_no="' . $$unique_master . '"');







if (isset($_POST['delete'])) {

	if ($do_status == 'MANUAL') {

		$crud   = new crud($table_master);
		$condition = $unique_master . "=" . $$unique_master;
		$crud->delete($condition);

		$crud   = new crud($table_detail);
		$crud->delete_all($condition);

		unset($$unique_master);
		unset($_POST[$unique_master]);
		$type = 1;
		$msg = 'Successfully Deleted.';
	}
}


if (isset($_POST['confirm'])) {

	if ($do_status == 'MANUAL') {

		$_POST[$unique_master] = $$unique_master;
		$_POST['checked_at']  = date('Y-m-d H:i:s');
		$_POST['checked_by']  = $_SESSION['user']['username'];
		$_POST['status']    = 'CHECKED';
		$_POST['depot_id'] = $_SESSION['user']['warehouse_id'];

		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);

		unset($$unique_master);
		unset($_POST[$unique_master]);
		unset($_POST);
		$type = 1;
		$msg = 'Successfully Instructed to Depot.';

?><script>
			window.location.href = "../main/home.php"
		</script><?
				} else {
					?><script>
			window.location.href = "../main/home.php"
		</script><?
				}
			}


			//if(isset($_POST['new'])){
			//	// $_POST['latitude']=$_POST['latitude_do'];
			//	// $_POST['longitude']=$_POST['longitude_do'];
			//
			//		$crud   = new crud($table_master);
			//		$dealer = find_all_field('ss_shop','','dealer_code='.$_POST['dealer_code']);
			//		$_POST['status']='MANUAL';
			//		//$_POST['do_date']=date('Y-m-d');
			//		$_POST['entry_at']=date('Y-m-d H:s:i');
			//		$_POST['entry_by']= $username;
			//		if($_POST['shop_status']=='Get Order') { $_POST['memo']=1; }else{$_POST['memo']=0; }
			//
			//		if($_POST['flag']==0){
			//		$_POST['do_no'] = find_a_field($table_master,'max(do_no)','1')+1;
			//		$$unique_master=$crud->insert();
			//		unset($$unique);
			//		$type=1;
			//		$msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';
			//		}
			//		else {
			//		$crud->update($unique_master);
			//		$type=1;
			//		$msg='Successfully Updated.';
			//		}
			//}



			if (isset($_POST['addItems']) && $_POST[$unique_master] > 0 && $_POST['randcheck'] == $_SESSION['user']['rand']) {
				$table		= $table_detail;
				$crud      	= new crud($table);

				foreach ($_POST['item_ids'] as $itemID) {
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
								} //
								//		unset($_POST['gift_id']);
								//		unset($_POST['gift_on_order']);
								//		unset($_POST['gift_on_item']);
							}
						} // end if item id >0
					}
				}
			}



			if ($del > 0) {

				//$main_del = find_a_field($table_detail,'gift_on_order','id = '.$del);
				$crud   = new crud($table_detail);
				if ($del > 0) {
					$condition = $unique_detail . "=" . $del;
					$crud->delete_all($condition);

					//$condition="gift_on_order=".$del;		
					//$crud->delete_all($condition);

					if ($main_del > 0) {
						$condition = $unique_detail . "=" . $main_del;
						$crud->delete_all($condition);
						$condition = "gift_on_order=" . $main_del;
						$crud->delete_all($condition);
					}
				}
				$type = 1;
				$msg = 'Successfully Deleted.';
			}


			if ($$unique_master > 0) {
				$condition = $unique_master . "=" . $$unique_master;
				$data = db_fetch_object($table_master, $condition);
				foreach ($data as $key => $value) {
					$$key = $value;
				}
			}



			$dealer = find_all_field('ss_shop', '', 'dealer_code=' . $dealer_code);

			auto_complete_from_db('item_info', 'concat(finish_goods_code,"#>",item_name)', 'finish_goods_code', 'product_nature="Salable" and status="Active" order by finish_goods_code', 'item');
					?>



<script language="javascript">
	function count() {

		if (document.getElementById('pkt_unit').value != '') {
			var pkt_unit = ((document.getElementById('pkt_unit').value) * 1);
			var dist_unit = ((document.getElementById('dist_unit').value) * 1);
			var pkt_size = ((document.getElementById('pkt_size').value) * 1);
			//var total_unit = (pkt_unit*pkt_size)+dist_unit;
			var total_unit = pkt_unit;

			var unit_price = ((document.getElementById('unit_price').value) * 1);
			var total_amt = (total_unit * unit_price);
			document.getElementById('total_unit').value = total_unit;
			document.getElementById('total_amt').value = total_amt.toFixed(2);
			var do_total = ((document.getElementById('do_total').value) * 1);
			var do_ordering = total_amt + do_total;
			document.getElementById('do_ordering').value = do_ordering.toFixed(2);
		} else
			document.getElementById('pkt_unit').focus();
	}
</script>



<script language="javascript">
	function focuson(id) {
		if (document.getElementById('item').value == '')
			document.getElementById('item').focus();
		else
			document.getElementById(id).focus();
	}

	window.onload = function() {
		if (document.getElementById("flag").value == '0')
			document.getElementById("rcv_amt").focus();
		else
			document.getElementById("item_id").focus();
	}
</script>

<style>
	/* Make select2 dropdown scrollable */
	/* Force scrollable dropdown for select2 */
	.select2-container .select2-results__options {
		max-height: 200px !important;
		/* Force max height */
		overflow-y: auto !important;
		/* Enable scrolling */
		-webkit-overflow-scrolling: touch !important;
		/* Smooth scrolling on mobile */
		scroll-behavior: smooth !important;
		/* Ensure smooth scrolling */
	}
	
	body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

       

        .sidebar {
            width: 300px !important;
            margin-right: 20px !important;
        }

        

        .do_entry_card {
           position: relative;
        }
		.card-body{
			position: sticky !important;
            top: 20px !important;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px !important;
            padding: 15px !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
			position: -webkit-sticky !important;
		}
     

      



	/* Make sure the dropdown is fully visible on mobile */
	@media only screen and (max-width: 600px) {
		.select2-container .select2-dropdown {
			position: relative !important;
			/* Ensure proper positioning */
			width: 100% !important;
			/* Ensure the dropdown is wide enough */
		}
	}
	


	/*
.table-scroll {
    overflow-x: auto; 
    position: relative;
    white-space: nowrap; 
}

.table-scroll th:nth-child(1),
.table-scroll td:nth-child(1) {
    position: -webkit-sticky;
    position: sticky;
	background-color:#e7dbdb;
    left: 0;
    z-index: 2;
    width: 120px; 
    box-shadow: 1px 0 0 rgba(0, 0, 0, 0.1);
}

thead th:nth-child(1) {
    z-index: 3; 
}*/
</style>



<!-- start of Page Content-->
<div class="page-content header-clear-medium">




	<div class="card card-style m-0">
		<? if ($$unique_master > 0) { ?>
			<form action="?<?= $unique_master ?>=<?= $$unique_master ?>" method="post" name="codz2" id="codz2">
				<?php $rand = rand();
				$_SESSION['user']['rand'] = $rand; ?>
				<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
				<input type="hidden" name="<?= $unique_master ?>" value="<?= $$unique_master; ?>" />
				<input name="do_date" type="hidden" id="do_date" value="<?= $do_date; ?>" readonly="readonly" />
				<input name="group_for" type="hidden" id="group_for" value="<?= $dealer->product_group; ?>" readonly="readonly" />
				<input name="dealer_code" type="hidden" id="dealer_code" value="<?= $dealer->dealer_code; ?>" />
				<input name="depot_id" type="hidden" id="depot_id" value="<?= $dealer->depot; ?>" />
				<input name="flag" id="flag" type="hidden" value="1" />
				<input name="group_for" type="hidden" id="group_for" value="<?= $dealer->product_group; ?>" readonly="readonly" />

				<div class="content">
					<!-- Card Section with custom border size -->

					<div class="sidebar">
					<div class="do_entry_card mt-2 custom-card-border"> <!-- Added custom-card-border class -->
						<div class="card-body">
							<!-- DO Number -->
							<div class="text-center">
								<button class="btn btn-outline-primary btn-sm"> DO NO : <?= $$unique_master; ?> </button>
							</div>
							<div class="d-flex justify-content-between align-items-center">

								<!-- Shop Details -->
								<div class="mb-2">
									<p class="mb-1 text-dark"><strong>Shop:</strong> <?= find1("select shop_name from ss_shop where dealer_code='" . $dealer_code . "' "); ?></p>
									<p class="mb-0 text text-dark"><strong style="color:green">Order Date:</strong> <?= $do_date; ?></p>
								</div>

								<!-- Amount -->
								<div class="text-end">
									<h4 class="mb-0">
										<?php $total_amt_data = find1("select sum(total_amt) from ss_do_details where do_no='" . $$unique_master . "'");
										if ($total_amt_data > 0) {
											echo $total_amt_data;
										} else { ?>
											<span id="total_item_amt">0</span>
										<? } ?>


									</h4>
								</div>
							</div>


						</div>
					</div>
					</div>
					
				</div>





				<div class="content">

					<div class="row m-0 p-0 pb-3">
						<div class="col-6 pe-1 p-0">
							<!--<label for="form5" class="color-highlight">Category</label>-->
							<select name="category_id" id="category_id" onchange="FetchItemSubcategory(this.value)" class="form-select form-control">

								<option value="">Category</option>
								<?php optionlist("select id,category_name from item_category where 1 order by category_name"); ?>
								<?php //optionlist("select c.id,concat(g.group_name,'>>',c.category_name) as name from item_category c, product_group g where g.id=c.group_id order by c.group_id,c.category_name"); 
								?>
							</select>
						</div>



						<div class="col-6 ps-1 p-0">
							<!--						<label for="form5" class="color-highlight">SubCategory</label>-->
							<select name="subcategory_id" id="subcategory_id" onchange="FetchAllItemList(this.value)" class="form-select form-control">
								<option value="">SubCategory</option>
								<?php
								if ($_SESSION['category_id'] > 0) {
									$cat_group = " and category_id='" . $_SESSION['category_id'] . "' ";
								}
								optionlist("select id,subcategory_name from item_subcategory where 1 " . $cat_group . " order by subcategory_name"); ?>
							</select>
						</div>

					</div>



					<div class="" style="zoom: 78%;">
						<div id="allitem"> </div>
					</div>



					<?php /*?><div id="item_dekhao" class="alert alert-success" role="alert"></div><?php */ ?>
					<?php /*?><table class="table table-borderless text-center rounded-sm shadow-l" style="overflow: hidden; width: 100%">
						<thead>
							<tr class="bg-night-light">
								<th scope="col" class="color-white">TP</th>
								<th scope="col" class="color-white">&nbsp;&nbsp;%&nbsp;&nbsp;</th>
								<th scope="col" class="color-white">Rate</th>
								<th scope="col" class="color-white">Pcs</th>
								<th scope="col" class="color-white"><input name="add" type="submit" id="add" value="+" onClick="count()" class="update" /></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<input name="do_date" type="hidden" id="do_date" value="<?=$do_date;?>" readonly="readonly"/>
								<input name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>" readonly="readonly"/>
								<input name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly="readonly"/>
								<input name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer->dealer_code;?>"/>
								<input name="depot_id" type="hidden" id="depot_id" value="<?=$dealer->depot;?>"/>
								<input name="flag" id="flag" type="hidden" value="1" />
								<input name="group_for" type="hidden" id="group_for" value="<?=$dealer->product_group;?>" readonly="readonly"/>
							
								<td><input name="unit_price2" type="number" step="0.01" id="unit_price2" value="<?=$item_all->t_price?>" readonly style="width: 100%;"/> </td>
								<td>
								<input type="hidden" id="nsp_per2"  value="<?=$item_all->nsp_per?>" style="width: 100%;" />
    							<input name="nsp_per" type="number" min="0" max="0" step="0.01"  id="nsp_per" onChange="update_nsp_amt()" value="<?=$item_all->nsp_per?>" style="width: 100%;"/>
								 </td>
								<td>
									<input name="unit_price" type="number" step="0.01 " style="width: 100%;" id="unit_price" value="<?=$item_all->t_price?>" readonly="readonly" style="width: 100%;"/>
									<input name="pkt_size" type="hidden" id="pkt_size" value="<?=$item_all->pack_size?>" readonly="readonly" style="width: 100%;"/>
								 </td>
								 
								<td>
									<input name="pkt_unit" type="number"  id="pkt_unit" onKeyUp="count()" required="required" style="width: 100%;"/>
									<input name="total_unit" type="hidden"  id="total_unit" readonly="readonly"/>
									<input name="total_amt" type="hidden" id="total_amt" readonly="readonly"/>
								 </td>
								 
								<td> </td>
							</tr>
						</tbody>
					</table><?php */ ?>







					<div class=" pt-3" style="zoom: 78%;">

						<table class="table table-borderless text-center table-scroll">
							<thead>
								<tr class="bg-night-light1">
									<th scope="col" class="color-white"> Item</th>
									<th scope="col" class="color-white"> Unit</th>
									<th scope="col" class="color-white"> Stock</th>
									<th scope="col" class="color-white"> TP</th>
									<th scope="col" class="color-white"> Offer%</th>
									<th scope="col" class="color-white"> NSP</th>
									<th scope="col" class="color-white"> Qty</th>
									<th scope="col" class="color-white"> Amt</th>
									<th scope="col" class="color-white"> </th>
								</tr>
							</thead>
							<tbody>

								<? $res = 'select a.id,b.finish_goods_code,b.item_name,b.unit_name, a.t_price as tp,a.nsp_per,a.stock,a.unit_price as rate,a.pkt_unit as pcs,a.total_amt as amt from ss_do_details a,item_info b where b.item_id=a.item_id and a.do_no=' . $$unique_master . ' order by a.id';

								//echo link_report_add_del_auto($res,'',6,7);

								$query = mysqli_query($conn, $res);
								$sl = 1;
								while ($data = mysqli_fetch_object($query)) {
								?>
									<tr>
										<td colspan="9" align="left" class="sr-td-t1">
											<strong><?= $data->item_name ?></strong> <?= $data->finish_goods_code ?>

										</td>
									</tr>
									<tr class="sr-td-b1">
										<td></td>
										<td><?= $data->unit_name ?></td>
										<td><?= $data->stock ?></td>
										<td><?= floatval($data->tp); ?></td>
										<td><?= floatval($data->nsp_per); ?></td>
										<td><?= floatval($data->rate); ?></td>
										<td class="text_br"><?= $data->pcs;
															$gqty += $data->pcs; ?></td>
										<td class="text_br"><?= floatval($data->amt);
															$gamt += $data->amt; ?></td>
										<td><a href="?del=<?= $data->id ?>" style=" color: red; ">&nbsp;<i class="fa-solid fa-trash"></i>&nbsp;</a></td>
									</tr>
								<? } ?>
								<tr class="sr-td-b1">
									<td colspan='6' align="left"><span style='text-align:right;'> Total: </span></td>
									<td colspan='1' class="text_br"><?= $gqty; ?></td>
									<td colspan='1' class="text_br"><?= $gamt; ?></td>
									<td colspan='1'></td>
								</tr>
							</tbody>
						</table>
					</div>

				</div>
			</form>












			<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
				<div class="content mt-0 mb-0">
					<input name="do_no" type="hidden" id="do_no" value="<?= $$unique_master ?>" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-red-dark bg-red-light w-100" />
					<div class="row">
						<? $check_item = find1("select count(*) from ss_do_details where do_no='" . $$unique_master . "'");
						if ($shop_status == 'Get Order' && $check_item > 0) { ?>
							<div class="col-6">

								<!--							<input name="delete" type="submit" value="DELETE DO" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-red-dark bg-red-light w-100" />-->
								<!-- <input type="button" value="Preview" class=" b-n btn btn-danger btn-3d btn-block  text-light w-100 py-3" /> -->
								<a href="do_preview.php?order_id=<?= $$unique_master; ?>"><input type="button" value="Preview" class=" b-n btn btn-danger btn-3d btn-block  text-light w-100 py-3" /></a>


							</div>
							<div class="col-6">
								<input name="confirm" type="submit" value="Confirm" class=" b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" />
							</div>

						<? } elseif ($shop_status != 'Get Order') { ?>
							<div class="col-6">
								<input type="button" value="Preview" class=" b-n btn btn-danger btn-3d btn-block  text-light w-100 py-3" />


							</div>

							<div class="col-6">

								<input name="confirm" type="submit" value="Confirm" class=" b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" />

							</div>
						<? } ?>
					</div>

					<!--					<input type="hidden" name="latitude" id="latitude"  value="" readonly="">
					<input type="hidden" name="longitude" id="longitude"  value="" readonly=""> -->

					<input type="hidden" name="latitude" id="latitude_do" value="" readonly="">
					<input type="hidden" name="longitude" id="longitude_do" value="" readonly="">
				</div>
			</form>

		<? } ?>
	</div>





</div>
<!-- End of Page Content-->



<?php
require_once '../assets/template/inc.footer.php';

//selected_two("#dealer_code");
selected_two("#category_id", "Catagory");
selected_two("#subcategory_id", "Sub Catagory");
selected_two("#item_id");
?>

<script>
	function getLocation() {

		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
		} else {
			x.innerHTML = "Geolocation is not supported by this browser.";
		}
	}

	function showPosition(position) {

		var lat = position.coords.latitude;
		var long = position.coords.longitude;
		document.getElementById("latitude_do").value = lat;
		document.getElementById("longitude_do").value = long;
		document.getElementById("latitude").value = lat;
		document.getElementById("longitude").value = long;
	}
</script>

<script>
	window.onload = function() {
		getLocation();
	};
</script>

<script>
	//function update_nsp_amt(){
	//
	//
	//var tp_id = document.getElementById("unit_price2").value;
	//var nsp_per_id = document.getElementById("nsp_per").value; 
	//
	//
	//var final_amt =  tp_id-((nsp_per_id/100)*tp_id);
	//
	//jQuery('#unit_price').val(final_amt);
	//    
	//}    

	function getData() {

		var id = document.getElementById("item_id").value;

		jQuery.ajax({
			url: 'do_ajax.php',
			type: 'post',
			data: 'id=' + id,
			success: function(result) {
				var json_data = jQuery.parseJSON(result);

				//jQuery('#item_name').val(json_data.item_name);
				$("#item_dekhao").text(json_data.item_name);
				jQuery('#unit_price2').val(json_data.price);
				jQuery('#unit_name').val(json_data.unit);
				jQuery('#pkt_size').val(json_data.pkt_size);
				jQuery('#nsp_per').val(json_data.nsp_per);
				jQuery('#nsp_per2').val(json_data.nsp_per);
				jQuery('#unit_price').val(json_data.nsp_amt);
				jQuery('#nsp_per').attr('max', json_data.nsp_per);

			}

		})

	}
</script>


<script type="text/javascript">
	function FetchItemCategory(id) {
		$('#category_id').html('');
		$('#subcategory_id').html('');
		$.ajax({
			type: 'post',
			url: 'get_data.php',
			data: {
				item_group: id
			},
			success: function(data) {
				$('#category_id').html(data);
			}

		})
	}

	function FetchItemSubcategory(id) {
		$('#subcategory_id').html('');
		$('#item_id').html('');
		$.ajax({
			type: 'post',
			url: 'get_data.php',
			data: {
				category_id: id
			},
			success: function(data) {
				$('#subcategory_id').html(data);
			}

		})
	}


	function FetchItem(id) {
		$('#item_id').html('');
		$.ajax({
			type: 'post',
			url: 'get_data.php',
			data: {
				subcategory_id: id
			},
			success: function(data) {
				$('#item_id').html(data);
			}

		})
	}


	function FetchShopList(id) {
		$('#dealer_code').html('');
		$.ajax({
			type: 'post',
			url: 'get_data.php',
			data: {
				route_id: id
			},
			success: function(data) {
				$('#dealer_code').html(data);
			}

		})
	}

	$(document).ready(function() {
		$('#dealer_code').select2({
			placeholder: "Select", // Placeholder text
			allowClear: true, // Allow clearing the selection
			dropdownAutoWidth: true, // Auto width for dropdown
			width: '100%' // Full width for the dropdown
		});
	});


	// do item show ajax function

	//$(document).ready(function() {
	//
	//		$("#subcategory_id").change(function() {
	//
	//			var group = $(this).val();
	//
	//			var warehouse = $('#ac_dealer_code').val();
	//
	//			var dealer = $('#dealer_code').val();
	//
	//			$.ajax({
	//
	//				url: "do_item_ajax.php",
	//
	//				type: "POST",
	//
	//				data: {
	//					group: group,
	//					warehouse: warehouse,
	//					dealer: dealer
	//				},
	//
	//				success: function(data) {
	//
	//					$("#allitem").html(data);
	//
	//				}
	//
	//			});
	//
	//		});

	function FetchAllItemList(id) {
		//$('#subcategory_id').html('');

		$.ajax({
			type: 'post',
			url: 'do_item_ajax.php',
			data: {
				subcategory_id: id
			},
			success: function(data) {
				$('#allitem').html(data);
			}

		})
	}

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

	//for table column sticky

	document.addEventListener('DOMContentLoaded', function() {
		const tableScroll = document.querySelector('.table-scroll');
		const stickyColumns = document.querySelectorAll('.sticky-column');

		tableScroll.addEventListener('scroll', function() {
			stickyColumns.forEach((column) => {
				column.style.transform = `translateX(${tableScroll.scrollLeft}px)`;
			});
		});
	});
</script>