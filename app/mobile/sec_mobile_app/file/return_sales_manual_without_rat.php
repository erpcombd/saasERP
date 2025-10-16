<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';
//var_dump($_SESSION);
$title = "Sales Return";
$page = "return_sales.php";


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
$table_details      = 'ss_receive_details';
$unique = 'or_no';


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

if (isset($_POST['addItems'])) {

	$table		= $table_details;
	$crud      	= new crud($table);

	foreach ($_POST['item_ids'] as $itemID) {
		$_POST['or_no'] = $_SESSION['or_no2'];
		$_POST['item_id'] = $itemID;
		$_POST['vendor_id'] = $_SESSION['vendor_id'];
		$_POST['unit_name'] = $_POST['unit_name_' . $itemID];
		$_POST['rate'] = $_POST['unit_price_' . $itemID];
		$_POST['qty'] = $_POST['qty_' . $itemID];
		$_POST['amount'] = $_POST['amount_' . $itemID];
		$_POST['receive_type'] = 'Sales Return';
		if ($_POST['qty'] > 0) {
			$crud->insert();
		}
	}
}













$$unique = $_SESSION['or_no2'];

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
		window.location.href = 'return_sales.php?pal=2';
	</script><?php
			}

			if (isset($_POST['hold'])) {
				unset($$unique);
				unset($_SESSION['or_no2']);
				$type = 1;
				$msg = 'Successfully Holded.';
				?><script>
		window.location.href = 'return_sales.php?pal=2';
	</script><?php
			}


			if (isset($_POST['confirmm'])) {
				// unset($_POST);
				$_POST[$unique] = $$unique;
				$_POST['entry_by'] = $_SESSION['user']['username'];
				$_POST['entry_at'] = date('Y-m-d H:i:s');
				$_POST['status'] = 'CHECKED';
				$crud   = new crud($table_master);
				$crud->update($unique);

				// bin card entry		
				$sql = 'select a.id,a.item_id,a.qty,a.or_date,a.rate,a.or_no
				from ss_receive_details a
				where a.or_no=' . $$unique . ' order by a.id';

				$query = mysqli_query($conn, $sql);
				while ($data = mysqli_fetch_object($query)) {

					journal_item_ss($data->item_id, $_SESSION['user']['warehouse_id'], $data->or_date, $data->qty, 0, $page_for, $data->id, $data->rate, '', $data->or_no);
				}
				// end bin card hit			
				unset($$unique);
				unset($_SESSION['or_no2']);
				$type = 1;
				$msg = 'Successfully Forwarded.';
				?>
	<script>
		window.location.href = 'return_sales.php?pal=2';
	</script>

<?php
			} // End confirm


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


			if ($_GET['del'] > 0) {

				$crud   = new crud($table_details);
				$condition = "id=" . $_GET['del'];
				$crud->delete_all($condition);
				$type = 1;
				$msg = 'Successfully Deleted.';
			}


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






<!-- start of Page Content-->
<div class="page-content header-clear-medium">

	<div class="card card-style m-0">
		<?php
		//echo 'or_no2='.$_SESSION['or_no2'];
		if ($_SESSION['or_no2'] > 0) {

			$sr_no = $_SESSION['or_no2'];
			$so_return = find_all_field('ss_receive_master', '', 'or_no="' . $sr_no . '"');
			$_SESSION['vendor_id'] = $so_return->vendor_id;
		?>

			<form action="?<?= $unique ?>=<?= $$unique ?>" method="post" name="cloud" id="cloud">
				<input name="vendor_id" type="hidden" id="vendor_id" value="<?= $so_return->vendor_name; ?>" />
				<input name="vendor_name" type="hidden" id="vendor_name" value="<?= $so_return->vendor_name; ?>" />
				<input name="or_date" type="hidden" id="or_date" value="<?= $so_return->or_date; ?>" />
				<input name="warehouse_id" type="hidden" id="warehouse_id" value="<?= $_SESSION['user']['warehouse_id']; ?>" />



				<div class="content mt-0">
					<!-- Card Section with custom border size -->
					<div class="do_entry_card mt-2 custom-card-border"> <!-- Added custom-card-border class -->
						<div class="card-body">
							<!-- DO Number -->
							<div class="text-center">
								<button class="btn btn-outline-primary btn-sm"> SALES RETURN NO : <?= $sr_no; ?> </button>
							</div>
							<div class="d-flex justify-content-between align-items-center">

								<!-- Shop Details -->
								<div class="mb-2">
									<p class="mb-1 text-dark"><strong>Party Name:</strong> <?= $so_return->vendor_name; ?></p>
									<p class="mb-0 text text-dark"><strong style="color:green">Return Date:</strong> <?= $so_return->or_date; ?></p>
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
					<div class="row m-0 p-0 pb-3">
						<div class="col-6 pe-1 p-0">
							<select name="category_id" id="category_id" onchange="FetchItemSubcategory(this.value)">
								<option value="">Category</option>
								<?php optionlist("select id,category_name from item_category where 1 order by category_name"); ?>
							</select>
						</div>

						<div class="col-6 ps-1 p-0">

							<!--						<select name="subcategory_id" id="subcategory_id" onchange="FetchItem(this.value)">-->
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


					<?php /*?>						<label for="form5" >Item</label>
						<select name="item_id" id="item_id"  onChange="getData()">
									<option></option>
							<?php 
        if($_SESSION['subcategory_id']>0){	
        	optionlist('select item_id,concat(finish_goods_code,"#",item_name) from item_info where 1 and status_sec=1 and subcategory_id="'.$_SESSION['subcategory_id'].'" and status="Active" order by item_name');
        }
        	?>
						</select><?php */ ?>


				</div>
				<?php /*?><div class="content">
				  <table class="table table-borderless text-center table-scroll mt-2" style="overflow: hidden; width:100%">
						<thead>
							<tr class="bg-night-light1">
								<th scope="col" class="color-white">Rate</th>
								<th scope="col" class="color-white">Qty</th>
								<th scope="col" class="color-white">Amount</th>
								<th scope="col" class="color-white">Action</th>
							</tr>
						</thead>
						<tbody>
							<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
							<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
							<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
							<input  name="or_date" type="hidden" id="or_date" value="<?=$or_date?>"/>
							<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>
							<input  name="vendor_name" type="hidden" id="vendor_name" value="<?=$vendor_name?>"/>
							<tr>
				<td><input name="price" type="text" id="price" onChange="count()" autocomplete="off" style="width: 100%;"/> </td>
				<td><input name="qty" type="number" id="qty"  maxlength="100" onChange="count()" required autocomplete="off" style="width: 100%;"/> </td>
				<td><input name="amount" type="text" id="amount" readonly="readonly" required style="width: 100%;"/></td>
				<td> <button name="add" type="submit" id="add" style="width: 100%;" class="btn btn-3d btn-m btn-full mb-0 rounded-xs btn-success font-900 shadow-s ">Add</button> </td>
							</tr>
						</tbody>
					</table>
			</div><?php */
				?>
				<div class="content">
					<?
					$res = 'select a.id,
					i.item_name,
					a.rate,
					a.qty ,
					a.amount,"x" 
					from ss_receive_details a,
					item_info i 
					where i.item_id=a.item_id 
					and a.or_no=' . $sr_no . ' 
					and a.vendor_id= ' . $_SESSION['vendor_id'] . '
					order by a.id desc';

					echo link_report_add_del_auto1($res, '', 4, 5);
					?>
				</div>

			</form>



			<form action="" method="post" name="cz" id="cz">
				<div class="content">
					<div class="row">
						<div class="col-4">
							<button name="delete" type="submit" value="Delete" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-danger w-100">Delete</button>
						</div>
						<div class="col-4 p-1">
							<button name="hold" type="submit" value="Hold" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-primary  w-100">Hold</button>
						</div>
						<div class="col-4 p-1">
							<button name="confirmm" type="submit" value="Confirm" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-success  w-100">Confirm</button>
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


	function getData() {

		var id = document.getElementById("item_id").value;
		var vendor_id = document.getElementById("vendor_id").value;

		jQuery.ajax({
			url: 'ajax_return_price.php',
			type: 'post',
			data: {
				id: id,
				vendor_id: vendor_id
			},
			success: function(result) {
				var json_data = jQuery.parseJSON(result);

				jQuery('#unit').val(json_data.unit);
				jQuery('#price').val(json_data.price);

			}

		})
		$("#qty").focus();
	}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script>
	jQuery('.party_list').chosen();
	jQuery('.item_list').chosen();
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


	function FetchAllItemList(id) {
		$.ajax({
			type: 'post',
			url: 'return_item_ajax.php',
			data: {
				subcategory_id: id
			},
			success: function(data) {
				$('#allitem').html(data);
			}

		})
	}



	//ajax item js (in this js comment are using of increment and decrement data) 
	function update_item_amt(id) {
		//var pkt_size = document.getElementById("pkt_size_" + id).value * 1;
		var unit_price = document.getElementById("unit_price_" + id).value * 1;
		var qty = document.getElementById("qty_" + id).value * 1;

		//var total_qty = (pkt_size * unit_price);

		document.getElementById("amount_" + id).value = qty * unit_price;

	}
</script>