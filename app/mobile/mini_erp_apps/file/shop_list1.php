<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Shop List";
$page = "shop_list.php";
$username	= $_SESSION['user']['username'];
$emp_code = $username;
require_once '../assets/template/inc.header.php';

?>



<!-- start of Page Content-->
<div class="page-content header-clear-medium">
	<?
	$sql = "select m.do_no,s.*,sum(d.total_amt) as total_amt,m.do_date 
	from ss_shop s,ss_do_master m,ss_do_details d 
	where s.dealer_code=m.dealer_code and m.do_no=d.do_no and m.status='CHECKED'
	and m.entry_by='" . $emp_code . "'
	group by m.do_no order by m.do_no desc";
	// $query=mysqli_query($conn, $sql);
	$query = db_query($sql);
	while ($data = mysqli_fetch_object($query)) {
	?>
		<a href="do_chalan.php?do=<?= $data->do_no ?>">
			<div class="card card-style">
				<div class="content">
					<div class="d-flex pb-2">
						<div class="align-self-center pe-3">
							<i class="fa-solid fa-bag-shopping fa-fade fa-3x"></i>
						</div>
						<div class="align-self-center">
							<h2 class="font-700 mb-0">Shop Name: <?= $data->do_no ?> <?= $data->shop_name ?></h2>
							<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase color-aqua-dark">Route Name: <?= $data->do_date ?></p>
							<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase color-aqua-dark">Shop Address: <?= $data->do_date ?></p>
							<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase color-aqua-dark ">Owner Name: <?= $data->do_date ?></p>
							<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase color-aqua-dark">Mobile no: <?= $data->do_date ?></p>
						</div>
						<div class="align-self-center ms-auto mt-5">
							<p class="m-0 p-0">Amount: <?= $data->total_amt; ?></p>
							<p><button class="btn btn-3d btn-m btn-full mb-0 rounded-xs text-uppercase font-900 shadow-s border-mint-dark bg-mint-dark w-100">Show</button></p>

						</div>
					</div>
				</div>
			</div>
		</a>

	<? } ?>

</div>
<!-- End of Page Content-->


<?php
require_once '../assets/template/inc.footer.php';
?>