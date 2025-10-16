<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Create Sales Order";
$page = "so.php";


require_once '../assets/template/inc.header.php';


// do_calander('#do_date');
// do_calander('#delivery_date');
// do_calander('#customer_po_date');
$tr_type = "Show";
//create_combobox('dealer_code_combo');

$now = date('Y-m-d H:s:i');
//if($_GET['cbm_no']>0)
//$cbm_no =$_SESSION['cbm_no'] = $_GET['cbm_no'];
//
//$cdm_data = find_all_field('raw_input_sheet','','cbm_no='.$cbm_no);

do_calander('#est_date');

$page = 'so.php';

$table_master = 'sale_do_master';

$unique_master = 'do_no';

$table_detail = 'sale_do_details';

$unique_detail = 'id';

$table_chalan = 'sale_do_chalan';

$unique_chalan = 'id';


if ($_REQUEST['old_do_no'] > 0)

	$$unique_master = $_REQUEST['old_do_no'];

elseif (isset($_GET['del'])) {
	$$unique_master = find_a_field('sale_do_details', 'do_no', 'id=' . $_GET['del']);
	$del = $_GET['del'];
} else

	$$unique_master = $_REQUEST[$unique_master];
if (prevent_multi_submit()) {





	if (isset($_POST['new'])) {

		if ($_POST['dealer_code_combo'] > 0) {
			$_POST['dealer_code'] = $_POST['dealer_code_combo'];
		}

		$job_date = $_POST['do_date'];

		$YR = date('Y', strtotime($job_date));

		$yer = date('y', strtotime($job_date));
		$month = date('m', strtotime($job_date));

		$job_cy_id = find_a_field('sale_do_master', 'max(job_id)', 'year="' . $YR . '"') + 1;

		$cy_id = sprintf("%06d", $job_cy_id);

		$job_no_generate = 'SO' . $yer . '' . $month . '' . $cy_id;

		$_POST['job_no'] = $job_no_generate;
		$_POST['job_id'] = $job_cy_id;
		$_POST['year'] = $YR;






		$crud   = new crud($table_master);



		$_POST['entry_at'] = date('Y-m-d H:i:s');



		$_POST['entry_by'] = $_SESSION['user']['username'];
		//$merchandizer_exp=explode('->',$_POST['merchandizer']);
		//$_POST['merchandizer_code']=$merchandizer_exp[0];


		if ($_POST['flag'] < 1) {
			$_POST['do_no'] = find_a_field($table_master, 'max(do_no)', '1') + 1;
			$$unique_master = $crud->insert();
			$tr_type = "Initiate";
			$type = 1;
			$msg = 'Sales Return Initialized. (Sales Return No-' . $$unique_master . ')';
			echo '<script>location.reload();</script>';
		} else {


			unset($_POST['job_no']);
			unset($_POST['job_id']);
			unset($_POST['year']);



			$crud->update($unique_master);



			$type = 1;



			$msg = 'Successfully Updated.';
		}
	}





	if (isset($_POST['add']) && ($_POST[$unique_master] > 0)) {



		$table		= $table_detail;

		if ($_POST['sub_group_id'] != 0) {
			$_SESSION['sub_group'] = $_POST['sub_group_id'];
			$_SESSION['dealer_code'] = $_POST['dealer_code'];
			$_SESSION['group_for'] = $_POST['group_for'];
		}

		$crud      	= new crud($table);

		$_POST['remarks'] = $_POST['remarks11'];
		$_POST['entry_at'] = date('Y-m-d H:i:s');
		$_POST['entry_by'] = $_SESSION['user']['username'];;


		if ($_REQUEST['init_bag_unit'] < 1) {

			$_POST['init_bag_unit'] = $_REQUEST['bag_unit'];
			$_POST['init_dist_unit'] = $_REQUEST['total_unit'];
			$_POST['init_total_unit'] = $_REQUEST['total_unit'];
			$_POST['init_total_amt'] = $_REQUEST['total_amt'];
		}




		$tr_type = "Add";

		$xid = $crud->insert();


		$do_date = $_POST['do_date'];

		$dealer_type = find_a_field('dealer_info', 'dealer_type', 'dealer_code="' . $_POST['dealer_code'] . '"');

		$dealer_type_id = find_a_field('dealer_info', 'dealer_type', 'dealer_code="' . $_POST['dealer_code'] . '"');

		// echo "<script>alert('zzzzzzzzzzzzz')<script>";
		$dealer_type = find_a_field('dealer_type', 'dealer_type', 'id="' . $dealer_type_id . '"');


		// echo "Ddddddddddddddddddddddd";
		$sss = "select * from sale_gift_offer where item_id='" . $_POST['item_id'] . "' and start_date<='" . $do_date . "' and end_date>='" . $do_date . "' and dealer_type='" . $dealer_type . "' ";

		// and (region_id=0 or region_id='".$dealer->region_id."') and (zone_id=0 or zone_id='".$dealer->zone_id."') and (area_id=0 or area_id='".$dealer->area_id."')
		$qqq = mysqli_query($conn, $sss);

		while ($gift = mysqli_fetch_object($qqq)) {


			if ($gift->item_qty > 0) {
				$gift_item = find_all_field('item_info', '', 'item_id="' . $gift->gift_id . '"');
				$_POST['item_id'] = $gift->gift_id;
				$_POST['gift_id'] = $gift->id;
				$_POST['dp_price'] = $gift_item->d_price;
				$_POST['fp_price'] = $gift_item->f_price;


				$_POST['unit_price'] = '0.00';
				$_POST['total_amt'] = '0.00';
				$_POST['dist_unit'] = $_POST['total_unit'] = (((int)($_POST['dist_unit'] / $gift->item_qty)) * ($gift->gift_qty));

				//$_POST['dist_unit'] = ($_POST['total_unit']%$gift_item->pack_size);
				$_POST['pkt_unit'] = (int)($_POST['total_unit'] / $gift_item->pack_size);
				$_POST['pkt_size'] = $gift_item->pack_size;
				$_POST['t_price'] = '0.00';
				// if($_POST['dist_unit']>0){

				$crud->insert();


				// }



			}
		}
	}
} else {

	$type = 0;

	$msg = 'Data Re-Submit Error!';
}

if ($del > 0) {
	$tr_type = "Remove";
	$main_del = find_a_field($table_detail, 'gift_on_order', 'id = ' . $del);

	$crud   = new crud($table_detail);



	if ($del > 0) {
		$tr_type = "Remove";
		$condition = $unique_detail . "=" . $del;

		$crud->delete_all($condition);

		$condition = "gift_on_order=" . $del;

		$crud->delete_all($condition);

		if ($main_del > 0) {
			$condition = $unique_detail . "=" . $main_del;
			$crud->delete_all($condition);
			$condition = "gift_on_order=" . $main_del;
			$crud->delete_all($condition);
		}
	}
	$sql1 = "delete from journal_item where tr_from = 'Sales' and tr_no = '" . $del . "'";
	mysqli_query($conn, $sql1);
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


$dealer = find_all_field('dealer_info', '', 'dealer_code=' . $dealer_code);
//auto_complete_from_db('dealer_info','item_name','concat(item_name,"#>",finish_goods_code)','','vai_cutomer');
//echo "Sarwar";
//auto_complete_from_db('area','area_name','area_code','','district');
//auto_complete_from_db('customer_info','customer_name_e ','customer_code',' dealer_code='.$dealer_code,'via_customer1');
$tr_from = "Sales";

?>

<script language="javascript">
	function count() {
		if (document.getElementById('unit_price').value != '') {

			//var vat = ((document.getElementById('vat').value)*1);
			var unit_price = ((document.getElementById('unit_price').value) * 1);
			var dist_unit = ((document.getElementById('dist_unit').value) * 1);
			var total_unit = (document.getElementById('total_unit').value) = dist_unit;
			var total_amt = (document.getElementById('total_amt').value) = total_unit * unit_price;
		}
	}
</script>






<!-- start of Page Content-->
<div class="page-content header-clear-medium">

	<div class="card card-style">
		<form action="<?= $page ?>" method="post" name="codz2" id="codz2">
			<div class="content">
				<div class="row mb-0">
					<div class="col-6">
						<label for="form4">Order No</label>

						<input name="do_no" type="text" id="do_no" value="<? if ($$unique_master > 0) echo $$unique_master;
																			else echo (find_a_field($table_master, 'max(' . $unique_master . ')', '1') + 1); ?>" readonly class="form-control validate-text" placeholder="Order No" />
						<input name="group_for" type="hidden" id="group_for" required readonly="" value="<?= $_SESSION['user']['group'] ?>" />
					</div>
					<div class="col-6">
						<? if ($do_date == "") { ?>
							<!-- <div class="input-style-new input-style-always-active has-borders no-icon mb-4"> -->
							<label for="form6">Order Date</label>

							<input name="do_date" type="date" id="do_date" value="<?= ($do_date != '') ? $do_date : date('Y-m-d') ?>" required class="form-control validate-text" placeholder="Order Date" />
							<!-- <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
						<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
					</div> -->
						<? } ?>
						<? if ($do_date != "") { ?>
							<!-- <div class="input-style-new input-style-always-active has-borders no-icon mb-4"> -->
							<label for="form6">Order Date</label>

							<input name="do_date" type="hidden" id="do_date" value="<?= $do_date; ?>" required class="form-control validate-text" placeholder="Order Date" />
							<input name="do_date2" type="date" id="do_date2" value="<?= $do_date; ?>" required class="form-control validate-text" placeholder="Order Date" />
							<!-- <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
						<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i> -->
							<!-- </div> -->
						<? } ?>
					</div>
				</div>
				<!-- <div class="input-style input-style-always-active has-borders no-icon validate-field mb-4">					 -->



				<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div> -->


				<!-- <div class="input-style input-style-always-active has-borders no-icon mb-4"> -->
				<label for="form5">Warehouse</label>

				<select id="depot_id" name="depot_id">
					<? foreign_relation('warehouse', 'warehouse_id', 'warehouse_name', $depot_id, 'use_type like "wh"'); ?>
				</select>
				<!-- <span><i class="fa fa-chevron-down"></i></span>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<i class="fa fa-check disabled invalid color-red-dark"></i>
						<em></em>
					</div> -->
				<!-- <div class="input-style input-style-always-active has-borders no-icon validate-field mb-4"> -->
				<label for="form4">Remarks</label>

				<textarea name="remarks" id="remarks" placeholder="Remarks" value="<?= $remarks; ?>"></textarea>
				<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div> -->
				<div class="row mb-0">
					<div class="col-6">
						<label for="form4">Discount (%)</label>

						<input name="discount" type="text" id="discount" value="<?= $discount; ?>" class="form-control validate-text" placeholder="Discount(%)" />
					</div>
					<div class="col-6">

						<label for="form4">VAT (%)</label>

						<input name="vat" type="text" id="vat" value="<?= $vat; ?>" class="form-control validate-text" placeholder="VAT" />
						<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div> -->
					</div>
				</div>
				<!-- <div class="input-style input-style-always-active has-borders no-icon validate-field mb-4"> -->

				<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div> -->

				<!-- <div class="input-style input-style-always-active has-borders no-icon validate-field mb-4"> -->
				<div class="row mb-0">
					<div class="col-6">
						<label for="form4">Customer</label>

						<? if ($dealer_code < 1) { ?>
							<select name="dealer_code_combo" id="dealer_code_combo" class="form-control validate-text" placeholder="Customer" required>
								<option></option>
								<? foreign_relation('dealer_info d,dealer_type t', 'd.dealer_code', 'concat(d.dealer_name_e,". #",t.dealer_type)', $dealer_code_combo, 'd.dealer_type=t.id and d.status="ACTIVE"'); ?>
							</select>

						<? } ?>
					</div>
					<div class="col-6">
						<? if ($dealer_code > 0) { ?>
							<select id="dealer_code" name="dealer_code" class="form-control validate-text" placeholder="Customer" required>
								<? foreign_relation('dealer_info', 'dealer_code', 'dealer_name_e', $dealer_code, 'dealer_code="' . $dealer_code . '"'); ?>
							</select>
						<? } ?>
						<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						
					</div> -->

						<!-- <div class="input-style input-style-always-active has-borders no-icon validate-field mb-4"> -->
						<label for="form4">Rcv Amt</label>

						<input name="rcv_amt" type="text" id="rcv_amt" value="<?= $rcv_amt; ?>" class="form-control validate-text" placeholder="Rcv Amt" />
					</div>
				</div>

				<div class="row mb-0">
					<div class="col-6">
						<label for="form4">Payment By: </label>

						<select id="payment_by" name="payment_by">
							<option><?= $payment_by; ?></option>
							<option value="Bank">Bank</option>
							<option value="Cash">Cash</option>
						</select>
					</div>
					<div class="col-6">
						<label for="form4">Party Bank</label>

						<select id="bank" name="bank">
							<option></option>
							<? foreign_relation('bank', ' distinct(BANK_NAME)', 'BANK_NAME', $bank, '1 order by BANK_NAME'); ?>
						</select>
					</div>
				</div>

				<? if ($job_no != "") { ?>
					<!-- <div class="input-style input-style-always-active has-borders no-icon validate-field mb-4"> -->
					<label for="form4">Job No</label>

					<input name="job_no_duplicate" type="text" id="job_no_duplicate" value="<?= $job_no ?>" readonly="" tabindex="105" class="form-control validate-text" placeholder="Job No" />
					<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div> -->
				<? } ?>

				<!-- <div class="input-style-new input-style-always-active  has-borders  no-icon validate-field mb-4"> -->




				<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div> -->


				<!-- <div class="input-style input-style-always-active has-borders no-icon validate-field mb-4"> -->

				<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div> -->


				<!-- <div class="input-style-new input-style-always-active  has-borders no-icon validate-field mb-4"> -->

				<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						
					</div> -->


				<!-- <div class="input-style input-style-always-active has-borders no-icon validate-field mb-4"> -->
				<div class="row mb-0">
					<div class="col-6">
						<label for="form4">Our Bank</label>

						<select id="receive_acc_head" name="receive_acc_head">
							<option></option>
							<? foreign_relation('accounts_ledger', 'ledger_id', 'ledger_name', $receive_acc_head, ' ledger_group_id="126002" order by ledger_name'); ?>
						</select>
					</div>
					<div class="col-6">
						<label for="form4">Branch</label>

						<input name="branch" type="text" id="branch" value="<?= $branch; ?>" class="form-control validate-text" placeholder="Branch" />
					</div>
				</div>

				<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						
					</div> -->

				<!-- <div class="input-style input-style-always-active has-borders no-icon validate-field mb-4"> -->

				<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div>
					 -->



				<div class="row d-flex justify-content-center mt-3">
					<div class="col-6">
						<? if ($$unique_master > 0) { ?>
							<input name="new" type="submit" value="Update Sales Order" class="btn btn-3d btn-m btn-full mb-0 b-n rounded-xs font-900 shadow-s btn-success w-100" />
							<input name="flag" id="flag" type="hidden" value="1" />
						<? } else { ?>

							<input name="new" type="submit" value="Initiate Sales Order" class="btn btn-3d btn-m b-n btn-full mb-0 rounded-xs  font-900 shadow-s btn-primary w-100" />
							<input name="flag" id="flag" type="hidden" value="0" />

						<? } ?>

					</div>
				</div>
			</div>
		</form>

		<? if ($$unique_master > 0) { ?>
			<form action="<?= $page ?>" method="post" name="codz2" id="codz2">
				<input type="hidden" id="<?= $unique_master ?>" name="<?= $unique_master ?>" value="<?= $$unique_master ?>" />
				<input type="hidden" id="do_date" name="do_date" value="<?= $do_date ?>" />
				<input type="hidden" id="group_for" name="group_for" value="<?= $group_for ?>" />
				<input type="hidden" id="depot_id" name="depot_id" value="<?= $depot_id ?>" />
				<input type="hidden" id="dealer_code" name="dealer_code" value="<?= $dealer_code ?>" />
				<input name="do_date" type="hidden" id="do_date" value="<?= $do_date; ?>" />
				<input name="job_no" type="hidden" id="job_no" value="<?= $job_no; ?>" />
				<div class="content">

					<div class="input-style-new input-style-always-active  has-borders has-icon validate-field mb-4">
						<select name="item_id" id="item_id" onchange="callthegetdata(this.value)" autocomplete="off" autofocus>

							<?php
							//if($_SESSION['subcategory_id']>0){	
							optionlist('select item_id,concat(finish_goods_code,"#",item_name) from item_info where   status="Active" order by item_name');
							// } subcategory_id="'.$_SESSION['subcategory_id'].'"
							?>
						</select>

						<label for="form1" class="color-highlight">Item Code:</label>
						<i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em></em>
					</div>

					<span id="so_data_found">
						<div class="input-style input-style-always-active has-borders has-icon validate-field mb-4">
							<input name="item_name" type="text" readonly="" autocomplete="off" value="" id="item_name" class="form-control validate-name" placeholder="Description" />
							<label for="form1" class="color-highlight">Description</label>
							<i class="fa fa-times disabled invalid color-red-dark"></i>
							<i class="fa fa-check disabled valid color-green-dark"></i>
							<em></em>
						</div>


						<div class="input-style input-style-always-active has-borders has-icon validate-field mb-4">
							<input name="pcs_stock" type="text" readonly="" autocomplete="off" value="" class="form-control validate-name" placeholder="Unit" />
							<label for="form1" class="color-highlight">Unit</label>
							<i class="fa fa-times disabled invalid color-red-dark"></i>
							<i class="fa fa-check disabled valid color-green-dark"></i>
							<em></em>
						</div>


						<div class="input-style input-style-always-active has-borders has-icon validate-field mb-4">
							<input name="ctn_price" type="text" id="ctn_price" readonly="" required value="<?= $do_data->ctn_price; ?>" class="form-control validate-name" placeholder="Stock" />
							<label for="form1" class="color-highlight">Stock</label>
							<i class="fa fa-times disabled invalid color-red-dark"></i>
							<i class="fa fa-check disabled valid color-green-dark"></i>
							<em></em>
						</div>

						<div class="input-style input-style-always-active has-borders has-icon validate-field mb-4">
							<input name="pcs_price" type="text" id="pcs_price" readonly="" required="required" value="<?= $do_data->pcs_price; ?>" class="form-control validate-name" placeholder="Price" />
							<label for="form1" class="color-highlight">Price</label>
							<i class="fa fa-times disabled invalid color-red-dark"></i>
							<i class="fa fa-check disabled valid color-green-dark"></i>
							<em>(required)</em>
						</div>
					</span>

					<div class="input-style input-style-always-active has-borders has-icon validate-field mb-4">
						<input name="dist_unit" type="text" id="dist_unit" value="" onkeyup="count()" class="form-control validate-name" placeholder="Qty" />
						<label for="form1" class="color-highlight">Qty</label>
						<i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em></em>
					</div>


					<div class="input-style input-style-always-active has-borders has-icon validate-field mb-4">
						<input name="total_unit" type="hidden" id="total_unit" readonly class="form-control validate-name" placeholder="Amount" />
						<input name="total_amt" type="text" id="total_amt" readonly class="form-control validate-name" placeholder="Amount" />
						<label for="form1" class="color-highlight">Amount</label>
						<i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em></em>
					</div>


					<div class="row d-flex justify-content-center">
						<div class="col-6">
							<input name="add" type="submit" id="add" value="ADD" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light w-100" />
						</div>

					</div>
				</div>


				<? if ($$unique_master > 0) { ?>
					<!--Data multi Table design start-->
					<div class="container pt-5">
						<?
						$res = 'select a.id,b.item_name,a.item_id,a.unit_name, a.unit_price, a.total_unit, a.total_amt as Net_sale, a.discount, a.vat_amt, a.total_amt_with_vat from
			   sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no=' . $$unique_master . ' order by a.id';
						?>

						<div class="content">
							<table class="table table-borderless text-center rounded-sm shadow-l" style="overflow: hidden; width:100%">
								<thead>
									<tr class="bg-night-light">
										<th scope="col" class="color-white">SL</th>
										<th scope="col" class="color-white">Item Code</th>
										<th scope="col" class="color-white">Description</th>
										<th scope="col" class="color-white">Unit</th>
										<th scope="col" class="color-white">Price</th>
										<th scope="col" class="color-white">Qty</th>
										<th scope="col" class="color-white">Amount</th>
										<th scope="col" class="color-white">Action</th>
									</tr>
								</thead>

								<tbody class="tbody1">

									<?

									$i = 1;

									$query = mysqli_query($conn, $res);

									while ($data = mysqli_fetch_object($query)) { ?>

										<tr>

											<td><?= $i++; ?></td>
											<td><?= $data->item_id; ?></td>
											<td><?= $data->item_name; ?></td>
											<td><?= $data->unit_name; ?></td>
											<td><?= $data->unit_price; ?></td>
											<td><?= $data->total_unit;
												$tot_pcs += $data->total_unit; ?></td>
											<td>
												<?= $data->Net_sale;
												$tot_Net_sale += $data->Net_sale; ?>
												<? $data->vat_amt;
												$tot_vat_amt += $data->vat_amt; ?>
												<? $data->total_amt_with_vat;
												$tot_total_amt_with_vat += $data->total_amt_with_vat; ?>
											</td>
											<td><a href="?del=<?= $data->id ?>">X</a></td>
										</tr>

									<? } ?>



									<tr>
										<td colspan="4"><strong>Total:</strong></td>
										<td>&nbsp;</td>
										<td><strong><?= number_format($tot_pcs, 2); ?></strong></td>
										<td><strong><?= number_format($tot_Net_sale, 2); ?></strong></td>
										<td>&nbsp;</td>
									</tr>

								</tbody>
							</table>
						</div>
					<? } ?>
			</form>


			<!--button design start-->
			<form action="select_dealer_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
				<div class="container">

					<div class="n-form-btn-class" align="center">
						<input name="delete" type="submit" class="btn1 btn1-bg-cancel" value="DELETE SO" />
						<input name="do_no2" type="hidden" id="do_no2" value="<?= $$unique_master ?>" />
						<input name="do_date" type="hidden" id="do_date" value="<?= $do_date ?>" />
						<input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM SO" />
					</div>

				</div>
			</form>

		<? } ?>

	</div>


</div>
<!-- End of Page Content-->

<?php
require_once '../assets/template/inc.footer.php';
selected_two("#dealer_code_combo");
selected_two("#dealer_code");
selected_two("#bank");
selected_two("#item_id");
selected_two("#");
?>


<script>
	function callthegetdata(itemid) {
		//alert(itemid);
		getData2('sales_invoice_ajax.php', 'so_data_found', itemid, document.getElementById('do_no').value);
	}
</script>
<script src="../assets/support/paging.js"></script>