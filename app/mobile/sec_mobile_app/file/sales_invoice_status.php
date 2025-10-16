<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Sales Order Status";
$page = "sales_invoice_status.php";


require_once '../assets/template/inc.header.php';

// do_calander('#fdate');
// do_calander('#tdate');
$table_master = 'sale_do_master';
$unique_master = 'do_no';
$tr_type = "Show";

echo $master_id = find_a_field('user_activity_management', 'master_user', 'user_id=' . $_SESSION['user']['id']);

//create_combobox('do_no');
// create_combobox('dealer_code');

$table_detail = 'sales_return_detail';
$unique_detail = 'id';

$table_chalan = 'sale_do_chalan';
$unique_chalan = 'id';

$$unique_master = $_POST[$unique_master];

if (isset($_POST['delete'])) {
	$crud   = new crud($table_master);
	$condition = $unique_master . "=" . $$unique_master;
	$crud->delete($condition);
	$crud   = new crud($table_detail);
	$crud->delete_all($condition);
	$crud   = new crud($table_chalan);
	$crud->delete_all($condition);
	unset($$unique_master);
	unset($_SESSION[$unique_master]);
	$type = 1;
	$msg = 'Successfully Deleted.';
}
if (isset($_POST['confirm'])) {
	$do_no = $_POST['do_no'];

	$_POST[$unique_master] = $$unique_master;
	$_POST['send_to_depot_at'] = date('Y-m-d H:i:s');
	$_POST['do_date'] = date('Y-m-d');
	$_POST['status'] = "CHECKED";


	$crud   = new crud($table_master);
	$crud->update($unique_master);
	$crud   = new crud($table_detail);
	$crud->update($unique_master);
	$crud   = new crud($table_chalan);
	$crud->update($unique_master);
	unset($_POST);
	unset($$unique_master);
	unset($_SESSION[$unique_master]);
	$type = 1;
	$msg = 'Successfully Instructed to Depot.';
}


$table = 'sale_do_master';
$show = 'dealer_code';
$id = 'do_no';
$text_field_id = 'do_no';

$target_url = 'sales_order_print_view.php';

$tr_from = "Sales";

?>


<!-- start of Page Content-->
<div class="page-content header-clear-medium">
	<form action="" method="post" name="codz" id="codz">
		<div class="card card-style">


			<div class="content">


				<!-- <div class="input-style-new input-style-always-active has-borders no-icon validate-field mb-4">						 -->
				<label for="fdate">Date Form</label>

				<input type="date" name="fdate" id="fdate" value="<?= $_POST['fdate'] ? $_POST['fdate'] : date('Y-m-01') ?>" autocomplete="off" class="form-control validate-text" />
				<!-- <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
							<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
					</div> -->


				<!-- <div class="input-style-new input-style-always-active has-borders no-icon validate-field mb-4">					 -->
				<label for="tdate">To Date:</label>

				<input type="date" name="tdate" id="tdate" value="<?= $_POST['tdate'] ? $_POST['tdate'] : date('Y-m-d') ?>" autocomplete="off" class="form-control validate-text" />
				<!-- <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
						<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
					</div> -->


				<div class="d-flex justify-content-center row mt-3">
					<div class="col-6">
						<input class="btn btn-3d btn-m btn-full mb-3 rounded-xs b-n font-900 shadow-s btn-success w-100"
							type="submit" name="submitit" id="submitit" value="View Detail" />
					</div>
				</div>
			</div>
	</form>
</div>


<div class="content">
	<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;">
		<thead>
			<tr class="bg-night-light1">
				<th scope="col" class="color-white">SO No</th>
				<th scope="col" class="color-white">SO Date </th>
				<th scope="col" class="color-white">Customer Name</th>
				<th scope="col" class="color-white">Warehouse Name</th>
				<th scope="col" class="color-white">Entry By</th>
				<th scope="col" class="color-white">Status</th>

			</tr>
		</thead>
		<tbody>
			<?

			if (isset($_POST['submitit'])) {

				if ($_POST['fdate'] != '' && $_POST['tdate'] != '') $con .= ' and m.do_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '"';

				if ($_POST['dealer_code'] != '')
					$dealer_con = " and m.dealer_code='" . $_POST['dealer_code'] . "'";

				if ($_POST['warehouse_id'] != '')
					$con .= ' and m.depot_id in (' . $_POST['warehouse_id'] . ') ';




				$res = "select m.do_no, m.do_no, m.do_date, m.dealer_code, m.job_no, m.sales_type, m.depot_id,  d.dealer_name_e, m.entry_by, m.status from 
					sale_do_master m,  dealer_info d where m.dealer_code=d.dealer_code " . $con . $dealer_con . " order by m.do_no desc";

				// $query = mysqli_query($conn,$res);
				$query = mysqli_query($conn, $res);

				// Check if the query was successful
				if ($query != '')

					//$two_weeks = time() - 14*24*60*60;
					while ($data = mysqli_fetch_object($query)) {
			?>
					<tr>

						<td><?= $data->do_no ?></td>
						<td><?= $data->do_date ?></td>
						<td style="text-align:left"><?= $data->dealer_name_e ?></td>
						<td style="text-align:left"><?= find_a_field('warehouse', 'warehouse_name', 'warehouse_id=' . $data->depot_id); ?></td>
						<td><?= find_a_field('user_activity_management', 'fname', 'user_id=' . $data->entry_by); ?></td>
						<td><?= $data->status ?></td>
						<!-- 							
							<td>
							<button type="button" onClick="custom(<?= $data->do_no; ?>);" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button>
							
						
							</td> -->


					</tr>
				<?
					}

				?>


			<?

			}
			?>
		</tbody>
	</table>
</div>


</div>
<!-- End of Page Content-->


<?php
require_once '../assets/template/inc.footer.php';
?>
<script language="javascript">
	window.onload = function() {
		document.getElementById("dealer").focus();
	}
</script>
<script language="javascript">
	function custom(theUrl) {
		window.open('<?= $target_url ?>?v_no=' + theUrl);
	}
</script>