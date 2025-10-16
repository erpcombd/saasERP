<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Receive View Reports";
$page = "receive_view.php";
$user_id 	= $_SESSION['user']['user_id'];
$or_no		= $_GET['v_no'];
$order 		= findall('select * from ss_receive_master where or_no="' . $or_no . '"');

require_once '../assets/template/inc.header.php';
?>
<style>
	.logo {
		max-width: 150px;
		width: 100%;
		height: auto;
		padding-left: 45px;
	}

	.invoice-header {
		background-color: #0f3193;
		color: white;
		padding: 7px !important;
		text-align: center;
		font-size: 20px !important;
		font-weight: bold;
		display: flex;
		justify-content: center !important;
		width: 45%;
		margin: auto;



	}

	.table th {
		background-color: #1a237e;
		color: white;
	}



	.td1 {
		background-color: #0f3193 !important;
		color: white !important;
	}

	.hhh {
		margin-bottom: -80px;
	}

	.table1 {
		background-color: #d8d9e9 !important;
		border: 2px solid black;
	}

	.card-header {
		background-color: #f8f9fa;
		border: none;
		
		
	}

	.table2 {
		background-color: #d8d9e9 !important;
		border: 1px solid #d8d9e9 !important;
	}

	.th1 {
		border: 2px solid black;
	}

	@media (max-width: 767px) {
		.invoice-header {
			font-size: 20px;
		}

		.billing-info {
			text-align: left !important;
		}

		.table {
			font-size: 14px;
		}
	}
</style>
<!-- Start of Page Content -->
<div class="page-content header-clear-medium">



	<!-- Alert Section -->
	<div class="card card-style">
		<div class="alert alert-success	 text-center font-16 font-weight-bold" role="alert">
			<b>Return NO :</b> <?= htmlspecialchars($or_no) ?></span><br>
			<b>Date :</b> <?= htmlspecialchars($order->or_date) ?>
		</div>
	</div>
	<div class="card card-style" style=" zoom: 50%; ">
	<div class="content m-0">
		<div class="card-header m-0 p-0">
			<div class="row mb-0">
			<div class="col-4 table-responsive ">
					<table class="table table-bordered  table1">
						<thead>
							<!-- Dealer Info Header -->
							<tr>
								<td class="td1">Authorized Distributor</td>



							</tr>
							<tr>
								<td class="table1">Dealer Information</td>
							</tr>

							<tr>
								<td class="text-dark fw-bold table1">Code: <?= $dealer->dealer_code ?></td>
							</tr>
							<tr>
								<td class="text-dark fw-bold table1">Name: <?= $dealer->shop_name ?></td>
							</tr>
							<tr>
								<td class="text-dark fw-bold table1">Address: <?= $dealer->shop_address ?></td>
							</tr>
							<tr>
								<td class="text-dark fw-bold table1">Mobile: <?= $dealer->mobile ?></td>
							</tr>

						</thead>
					</table>
				</div>

				<div class="col-4 mb-3 mb-md-0 ">
					<a href="#" class=" btn-m btn-full mb-3 invoice-header text-uppercase text-center font-900   ">Chalan</a>
				</div>
				<!-- Chalan Details -->
				<div class="col-4 table-responsive  ">
					<table class="table table-bordered   ">
						<thead class="th1">

							<tr>
								<td class="td1"><?= $mdealer->dealer_name_e ?></td>
							</tr>
							<tr>
								<td class="table2"><?= $mdealer->address_e ?> </td>
							</tr>
							<tr>
								<td class="table2">Contact Number: <?= $mdealer->mobile_no ?></td>
							</tr>

							<tr>
								<td class="table2">Order No: <?= $chalan_info->do_no ?></td>
							</tr>
							<tr>
								<td class="table2">Chalan No: <?= $chalan_no ?></td>
							</tr>
							<tr>
								<td class="table2">Chalan Date: <?= $chalan_info->chalan_date ?></td>
							</tr>



						</thead>
					</table>
				</div>

			</div>
			</div>
			</div>
			</div>

	<!-- Table Section -->
	<div class="card card-style">
		<div class="content">
			<table class="table table-borderless text-center table-scroll table_new_border">
				<thead class="bg-primary text-white">
					<tr class="bg-night-light1">
						<th scope="col">#</th>
						<th scope="col">Product</th>
						<th scope="col">Rate</th>
						<th scope="col">Qty</th>
						<th scope="col">Total</th>
					</tr>
				</thead>
				<tbody class="text-center">
					<?php
					$sss = "SELECT DISTINCT(d.id), d.*, i.item_name 
						FROM ss_receive_details d, item_info i, ss_receive_master m
						WHERE m.or_no = d.or_no AND m.or_no = '$or_no' AND d.item_id = i.item_id 
						GROUP BY d.id";
					$query = mysqli_query($conn, $sss);
					$sl = 1;
					$final_amount = 0;

					while ($row = mysqli_fetch_object($query)) {
					?>
						<tr>
							<td><?= $sl++ ?></td>
							<td class="text-left"><?= htmlspecialchars($row->item_name) ?></td>
							<td><?= number_format($row->rate, 2, '.', '') ?></td>
							<td><?= (int)$row->qty ?></td>
							<td><?= number_format($row->amount, 2, '.', '') ?></td>
							<?php $final_amount += $row->amount; ?>
						</tr>
					<?php } ?>
					<tr class="font-weight-bold">
						<td colspan="2"><b>Grand Total</b></td>
						<td><?= number_format($final_amount, 2, '.', '') ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Back Button Section -->
	<div class="d-flex justify-content-center">
		<a href="return_sales_status.php" class="btn btn-warning btn-lg font-weight-bold text-uppercase shadow-sm rounded">
			Back
		</a>
	</div>

</div>
<!-- End of Page Content -->

<?php
require_once '../assets/template/inc.footer.php';
?>