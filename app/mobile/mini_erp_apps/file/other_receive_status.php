<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Other Receive Report";
$page = "other_receive_status.php";
require_once '../assets/template/inc.header.php';


$user_id	= $_SESSION['user']['username'];
$emp_code = $user_id;
$today 		= date('Y-m-d');



$unique 		= 'po_no';
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
			<div class="content m-0">

				<label for="fdate">Date Form</label>
				<input type="date" name="fdate" id="fdate" value="<?= date('Y-m-01') ?>" placeholder="Date Form" class="form-control validate-text" />
				
				<label for="fdate">Date To</label>
				<input type="date" name="tdate" id="tdate" value="<?= date('Y-m-d') ?>" placeholder="Date To" class="form-control validate-text" />

				<div class="d-flex justify-content-center row mt-3">
					<div class="col-6">
						<input type="submit" name="submitit" id="submitit" class="b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" value="View" />
					</div>
				</div>

			</div>
		</form>
	</div>


<div class="table-responsive pt-2" style="zoom: 70%;">
	<?
	if (isset($_POST['submitit'])) {

		if ($_POST['fdate'] != '' && $_POST['tdate'] != '')
			$con .= 'and a.or_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '"';
		$res = 'select  a.or_no,a.or_no as Replace_No,a.or_date as return_date, a.vendor_id as Party_Code, a.vendor_name as Party_Name, FORMAT(sum(qty),2) as Replace_Qty, FORMAT(sum(amount),2) as Total
        from ss_receive_master a,ss_receive_details b 
        where a.or_no=b.or_no
        and a.receive_type = "Other Receive"  and a.status="Checked"
        ' . $con . ' and a.entry_by="' . $emp_code . '"
        group by a.or_no order by a.or_no desc';
		echo link_report_ss($res, 'po_print_view.php');
	}
	?>

</div>


</div>
<!-- End of Page Content-->



<?php
require_once '../assets/template/inc.footer.php';
?>