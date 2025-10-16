<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Damage Entry";
$page = "damage_entry.php";
//var_dump($_SESSION);



require_once '../assets/template/inc.header.php';
//$user_id		=$_SESSION['user_id'];
$user_id		= $_SESSION['user']['username'];
$emp_code =  $user_id;
$product_group	= $_SESSION['user']['product_group'];


$page = "ss_issue_master";


$page_for           = 'Damage';
$table_master       = 'ss_issue_master';
$table_details      = 'ss_issue_details';
$unique = 'oi_no';


if ($_GET['pal'] == 2) {
	unset($$unique);
	unset($_SESSION['oi_no2']);
}

if ($_GET['oi_no'] > 0) $_SESSION['oi_no2'] = $_GET['oi_no'];




if (isset($_POST['new'])) {

	$crud   = new crud($table_master);

	if (!isset($_SESSION['oi_no2'])) {
		$_POST['entry_by']	= $_SESSION['username'];
		$_POST['entry_at']	= date('Y-m-d H:i:s');
		$_POST['edit_by']	= $_SESSION['username'];
		$_POST['edit_at']	= date('Y-m-d H:i:s');
		$_POST['warehouse_id'] = $_SESSION['warehouse_id'];
		$_POST['vendor_name']	= find1('select shop_name from ss_shop where dealer_code="' . $_POST['vendor_id'] . '"');


		$$unique = $_SESSION['oi_no2'] = $crud->insert();
		//unset($$unique);
		$type = 1;
		$msg = $title . '  No Created. (No :-' . $_SESSION['oi_no2'] . ')';
?><script>
			window.location.href = "damage_entry.php?oi_no=<?= $$unique; ?>";
		</script><?


				} else {

					$_POST['edit_by']	= $_SESSION['username'];
					$_POST['edit_at']	= date('Y-m-d H:i:s');
					$_POST['oi_no']		= $_SESSION['oi_no2'];
					$_POST['vendor_name']	= find1('select shop_name from ss_shop where dealer_code="' . $_POST['vendor_id'] . '"');

					$crud->update($unique);
					$type = 1;
					$msg = 'Successfully Updated.';
				}
			} // end new

			$$unique = $_SESSION['oi_no2'];




			if (isset($_POST['delete'])) {

				$crud   = new crud($table_master);
				$condition = $unique . "=" . $$unique;
				$crud->delete($condition);
				$crud   = new crud($table_details);
				$condition = $unique . "=" . $$unique;
				$crud->delete_all($condition);
				unset($$unique);
				unset($_SESSION['oi_no2']);
				$type = 1;
				$msg = 'Successfully Deleted.';
					?><script>
		window.location.href = 'damage_entry.php?pal=2';
	</script><?php
			}

			if (isset($_POST['hold'])) {
				unset($$unique);
				unset($_SESSION['oi_no2']);
				$type = 1;
				$msg = 'Successfully Holded.';
				?><script>
		window.location.href = 'damage_entry.php?pal=2';
	</script><?php
			}





			if (isset($_POST['confirmm'])) {
				unset($_POST);
				$_POST[$unique] = $$unique;
				$_POST['entry_by'] = $_SESSION['username'];
				$_POST['entry_at'] = date('Y-m-d H:i:s');
				$_POST['status'] = 'CHECKED';
				$crud   = new crud($table_master);
				$crud->update($unique);

				// bin card entry		
				$sql = 'select a.id,a.item_id,a.qty,a.oi_date,a.rate,a.oi_no
		from ss_issue_details a
		where a.oi_no=' . $$unique . ' order by a.id';

				$query = mysqli_query($conn, $sql);
				while ($data = mysqli_fetch_object($query)) {

					journal_item_ss($data->item_id, $_SESSION['warehouse_id'], $data->oi_date, 0, $data->qty, $page_for, $data->id, $data->rate, '', $data->oi_no);
				} // end bin card hit			



				unset($$unique);
				unset($_SESSION['oi_no2']);
				$type = 1;
				$msg = 'Successfully Forwarded.';

				?><script>
		window.location.href = 'damage_entry.php?pal=2';
	</script><?php
			} // End confirm






			if (isset($_POST['add']) && ($_POST[$unique] > 0)) {

				$crud   = new crud($table_details);

				$_POST['unit_name'] = $_POST['unit'];
				$_POST['rate']          = $_POST['price'];
				$_POST['warehouse_id']  = $_SESSION['warehouse_id'];

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

			if ($_SESSION['oi_no2'] < 1)
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

	<div class="card card-style">
		<form action="" method="post" name="codz" id="codz">
			<div class="content">

				<!-- <div class="input-style input-style-always-active has-borders no-icon validate-field mb-4"> -->
				<? $field = 'oi_no'; ?>
				<label for="<?= $field ?>">NO</label>

				<input class="form-control validate-text" name="<?= $field ?>" type="text" id="<?= $field ?>" value="<?= $$field ?>" disabled="disabled" placeholder="NO" />
				<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em></em>
					</div> -->

				<!-- <div class="input-style-new input-style-always-active has-borders no-icon validate-field mb-4"> -->

				<? $field = 'oi_date';
				if ($oi_date == '') $oi_date = date('Y-m-d'); ?>
				<label for="form4">Date</label>

				<input class="form-control validate-text" type="date" name="<?= $field ?>" id="<?= $field ?>" value="<?= $$field ?>" required <? if ($oi_date != '') { ?> readonly="readonly" <? } ?> placeholder="date" />

				<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div> -->

				<!-- <div class="input-style-new input-style-always-active has-borders no-icon mb-4"> -->
				<? $field = 'vendor_id'; ?>
				<label for="<?= $field ?>">Party</label>

				<? $field = 'vendor_id'; ?>
				<select name="<?= $field ?>" id="<?= $field ?>" required />
				<option value="<?= $$field ?>"><?= find1("select concat(dealer_code,'-',shop_name) from ss_shop where dealer_code='" . $$field . "' "); ?></option>
				<?php optionlist('select dealer_code,shop_name from ss_shop where status="1" and emp_code="' . $emp_code . '" order by shop_name'); ?>
				</select>
				<!-- <span><i class="fa fa-chevron-down"></i></span>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<i class="fa fa-check disabled invalid color-red-dark"></i>
						<em></em>
					</div> -->
				<input name="issue_type" type="hidden" id="issue_type" value="<?= $page_for ?>" required="required" />

				<div class="row d-flex justify-content-center mt-3">
					<div class="col-6">
						<input name="new" type="submit" class="btn btn-3d btn-m btn-full mb-3 rounded-xs  font-900 b-n btn-success w-100" value="<?= $btn_name ?>" required="required" />
					</div>
				</div>
			</div>

		</form>
	</div>






	<?php
	//echo 'oi_no2='.$_SESSION['oi_no2'];
	if ($_SESSION['oi_no2'] > 0) { ?>
		<div class="card card-style">
			<form action="?<?= $unique ?>=<?= $$unique ?>" method="post" name="cloud" id="cloud" class="pt-3">
				<div class="content">
					<!-- <div class="input-style-new input-style-always-active has-borders no-icon validate-field mb-4"> -->
					<label for="item_id">Item</label>

					<select name="item_id" id="item_id" onChange="getData()" autocomplete="off" class="form-control">
						<option></option>
						<?php
						optionlist('select item_id,concat(finish_goods_code," #",item_name) as item_name from item_info 
								where d_price>0 and sales_item_type="' . $product_group . '" and status="Active"
								order by item_brand,brand_category,brand_category_type,item_name');
						?>
					</select>
					<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em></em>
					</div> -->




					<table class="table table-borderless text-center table-scroll mt-2" style="overflow: hidden; width:100%">
						<thead>
							<tr class="bg-night-light1">
								<th scope="col" class="color-white">Rate</th>
								<th scope="col" class="color-white">Qty</th>
								<th scope="col" class="color-white">Amount</th>
								<th scope="col" class="color-white">status</th>
							</tr>
						</thead>
						<tbody>
							<input name="issue_type" type="hidden" id="issue_type" value="<?= $page_for ?>" required="required" />
							<input name="<?= $unique ?>" type="hidden" id="<?= $unique ?>" value="<?= $$unique ?>" />
							<input name="warehouse_id" type="hidden" id="warehouse_id" value="<?= $warehouse_id ?>" />
							<input name="oi_date" type="hidden" id="oi_date" value="<?= $oi_date ?>" />
							<input name="vendor_id" type="hidden" id="vendor_id" value="<?= $vendor_id ?>" />
							<input name="vendor_name" type="hidden" id="vendor_name" value="<?= $vendor_name ?>" />
							<tr>
								<td><input name="price" type="text" class="input3" id="price" onChange="count()" autocomplete="off" readonly="readonly" style="width: 100%;" /></td>
								<td><input name="qty" type="number" class="input3" id="qty" maxlength="100" onChange="count()" required autocomplete="off" style="width: 100%;" /></td>
								<td><input name="amount" type="text" class="input3" id="amount" readonly="readonly" required style="width: 100%;" /></td>
								<td><button name="add" type="submit" id="add" style="width: 100%;" class="btn btn-success">ADD</button></td>
							</tr>
						</tbody>
					</table>

				</div>
				<div class="content">
					<?
					$res = 'select a.id,i.item_name,a.rate,a.qty,a.amount,"x" 
						from ss_issue_details a, item_info i 
						where i.item_id=a.item_id and a.oi_no=' . $oi_no . ' order by a.id desc';
					echo link_report_add_del_auto1($res, '', 4, 5);
					?>
				</div>
			</form>

		</div>

		<form action="" method="post" name="cz" id="cz">
			<div class="content">
				<div class="row">
					<div class="col-4">
						<button name="delete" type="submit" value="delete" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-danger w-100">Delete</button>
					</div>
					<div class="col-4">
						<button name="hold" type="submit" value="hold" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-primary w-100">Hold</button>
					</div>
					<div class="col-4">
						<button name="confirmm" type="submit" value="CONFIRM" class="btn btn-3d btn-m btn-full mb-0 rounded-xs font-900 shadow-s btn-success w-100">CONFIRM</button>
					</div>
				</div>
			</div>
		</form>
	<? } ?>
</div>
<!-- End of Page Content-->



<?php
require_once '../assets/template/inc.footer.php';
selected_two("#vendor_id");
selected_two("#item_id");
?>


<script>
	function getData() {

		var id = document.getElementById("item_id").value;

		jQuery.ajax({
			url: 'ajax_json_price.php',
			type: 'post',
			data: 'id=' + id,
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