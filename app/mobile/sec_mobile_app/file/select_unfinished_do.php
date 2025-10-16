<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = 'Unfinished Sales Order';
$page = "select_unfinished_do.php";

//var_dump($_SESSION);
require_once '../assets/template/inc.header.php';


//do_calander('#fdate');
//
//do_calander('#tdate');

$table_master = 'sale_do_master';

$unique_master = 'do_no';



$table_detail = 'sale_do_details';

$unique_detail = 'id';



$table_chalan = 'sale_do_chalan';

$unique_chalan = 'id';



$$unique_master = $_SESSION[$unique_master];



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

	unset($_POST);

	$_POST[$unique_master] = $$unique_master;

	$_POST['entry_at'] = date('Y-m-d H:i:s');

	$_POST['status'] = 'PROCESSING';

	$crud   = new crud($table_master);

	$crud->update($unique_master);

	$crud   = new crud($table_detail);

	$crud->update($unique_master);

	$crud   = new crud($table_chalan);

	$crud->update($unique_master);

	unset($$unique_master);

	unset($_SESSION[$unique_master]);

	$type = 1;

	$msg = 'Successfully Instructed to Depot.';
}





$table = 'sale_do_master';

$show = 'dealer_code';

$id = 'do_no';

$con = 'status="MANUAL"';



?>



<!-- start of Page Content-->
<div class="page-content header-clear-medium">
	<form action="" method="post" name="codz" id="codz">
		<div class="card card-style">


			<div class="content">


				<!-- <div class="input-style-new input-style-always-active has-borders no-icon validate-field mb-4">						 -->
				<label for="fdate">From Date:</label>

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
						<input class="btn btn-3d btn-m btn-full mb-3 b-n rounded-xs  font-900 shadow-s btn-success w-100"
							type="submit" name="submitit" id="submitit" value="VIEW DETAIL" />
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
				<th scope="col" class="color-white">SO Date</th>
				<th scope="col" class="color-white">Customer</th>
				<th scope="col" class="color-white">Action</th>

			</tr>
		</thead>
		<tbody>
			<?
			if ($_POST['fdate'] != '') {
				$con = ' and a.do_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '"';
			} else {
				$con = ' and a.do_date between "' . date('Y-m-o1') . '"
and "' . date('Y-m-d') . '"';
			}

			$res = 'select a.do_no,a.entry_by,a.do_date,a.dealer_code,d.dealer_name_e,u.fname

  from sale_do_master a,dealer_info d,ss_user u

  where a.dealer_code=d.dealer_code and a.entry_by=u.username  and a.status="MANUAL" and a.depot_id="' . $_SESSION['user']['warehouse_id'] . '" ' . $con . ' order by a.do_no desc';


			$query = mysqli_query($conn, $res);
			while ($data = mysqli_fetch_object($query)) {
			?>
				<tr>
					<td class="text-center"><?= $data->do_no ?></td>
					<td class="text-center"><?php echo date('d-m-Y', strtotime($data->do_date)); ?></td>
					<td class="text-left"><?= $data->dealer_name_e ?></td>
					<td class="text-center">
						<a href="so.php?old_do_no=<?= $data->do_no ?>">
							<input type="button" value="Complete DO" class="b-n btn btn-success btn-3d btn-block text-light w-100 py-3" />
						</a>
					</td>
				</tr>

			<?php } ?>
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