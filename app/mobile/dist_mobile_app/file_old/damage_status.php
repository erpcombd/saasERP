<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Damage Report";
$page = "damage_status.php";


require_once '../assets/template/inc.header.php';

$user_id	= $_SESSION['user']['user_id'];
$today 		= date('Y-m-d');


$status 		= 'CHECKED';
$target_url 	= 'receive_view.php';



if ($_REQUEST[$unique] > 0) {
	$_SESSION[$unique] = $_REQUEST[$unique];
	header('location:' . $target_url);
}

?>
<script language="javascript">
	function custom(theUrl) {
		window.open('<?= $target_url ?>?v_no=' + theUrl);
	}
</script>


<!-- start of Page Content-->
<div class="page-content header-clear-medium">


	<div class="card card-style">
		<form action="" method="post" name="codz" id="codz">
			<div class="content">

				<!-- <div class="input-style-new input-style-always-active has-borders no-icon mb-4"> -->
				<label for="fdate">Date Form</label>

				<input type="date" name="fdate" id="fdate" value="<?= date('Y-m-01') ?>" placeholder="Date Form" class="form-control validate-text" />
				<!-- <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
						<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
					</div> -->

				<!-- <div class="input-style-new input-style-always-active has-borders no-icon mb-4"> -->
				<label for="fdate">Date To</label>
				<input type="date" name="tdate" id="tdate" value="<?= date('Y-m-d') ?>" placeholder="Date To" class="form-control validate-text" />

				<!-- <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
						<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
					</div> -->

				<div class="d-flex justify-content-center row mt-3">
					<div class="col-6">
						<input type="submit" name="submitit" id="submitit" class="btn btn-3d btn-m btn-full mb-3 rounded-xs  font-900 b-n btn-success w-100" value="View" />

					</div>
				</div>


			</div>
		</form>
	</div>




	<?
	if (isset($_POST['submitit'])) {

		if ($_POST['fdate'] != '' && $_POST['tdate'] != '')
			$con .= 'and a.oi_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '"';

		$res = 'select  a.oi_no,a.oi_no as no,a.oi_date as return_date, a.vendor_name as party,
		FORMAT(sum(amount),2) as Total
        from ss_issue_master a,ss_issue_details b 
        where a.oi_no=b.oi_no
        and a.issue_type = "Damage"  and a.status="Checked"
        ' . $con . ' and a.entry_by="' . $emp_code . '"
        group by a.oi_no order by a.oi_no desc';
		echo link_report_ss($res, 'po_print_view.php');
	} else {

		$res = 'select  a.oi_no,a.oi_no as no,a.oi_date as return_date, a.vendor_name as party,
		FORMAT(sum(amount),2) as Total
        from ss_issue_master a,ss_issue_details b 
        where a.oi_no=b.oi_no
        and a.issue_type = "Sales Return"  and a.status="Checked"
        and a.oi_date between "' . date('Y-m-01') . '" and "' . date('Y-m-d') . '"
		and a.entry_by="' . $emp_code . '"
        group by a.oi_no order by a.oi_no desc';
		echo link_report_ss($res, 'po_print_view.php');
	}
	?>


</div>
<!-- End of Page Content-->













<?php
require_once '../assets/template/inc.footer.php';
?>