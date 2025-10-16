<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';


$title = "Gift List";
$page = "do_status.php";
$user_id	= $_SESSION['user_id'];
$username = $_SESSION['user']['username'];
$emp_code = $username;
$today 		= date('Y-m-d');

$status 		= 'CHECKED';
$target_url 	= 'gift_view.php';


require_once '../assets/template/inc.header.php';

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
	<form action="" method="post" name="codz" id="codz">
		<div class="card card-style">
			<div class="content">

				<!-- <div class="input-style-new input-style-always-active  has-borders no-icon mb-4">						 -->
				<label for="fdate">Date Form</label>

				<input type="date" class="form-control validate-text" name="fdate" id="fdate" value="2024-04-01" />
				<!-- <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
						<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
					</div> -->


				<!-- <div class="input-style-new input-style-always-active  has-borders no-icon mb-4">					 -->
				<label for="tdate">Date To</label>

				<input type="date" class="form-control validate-text" name="tdate" id="tdate" value="2024-04-30" />
				<!-- <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
						<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
					</div> -->


				<div class="d-flex justify-content-center row m-0 mt-3">
					<div class="col-6">
						<input class="btn btn-3d btn-m btn-full mb-0 rounded-xs b-n  font-900 shadow-s btn-success w-100"
							type="submit" name="submitit" id="submitit" value="View" />
					</div>
				</div>
			</div>
		</div>
	</form>



	<?
	if (isset($_POST['submitit'])) {

		if ($_POST['fdate'] != '' && $_POST['tdate'] != '') {
			$con .= 'and a.oi_date between "' . $_POST['fdate'] . '" and "' . $_POST['tdate'] . '"';
		}

		// '.$con.'  

		$res = 'select  a.oi_no,a.oi_no as no,a.oi_date as apply_date,a.offer_no as offer, a.shop_name as shop,
		FORMAT(sum(amount),2) as Total
        from ss_do_gift_master a,ss_do_gift_details b 
        where a.oi_no=b.oi_no
        and a.status in ("CHECKED","COMPLETED")
         and a.entry_by="' . $emp_code . '" and a.offer_no="Offer April-24"
        group by a.oi_no order by a.oi_no desc';

		echo link_report_ss($res, 'po_print_view.php');
	}
	?>

</div>
<!-- End of Page Content-->




<?php
require_once '../assets/template/inc.footer.php';
?>