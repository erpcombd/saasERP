<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$page = "reports";

require_once '../assets/template/inc.header.php';

$user_id = $_SESSION['user_id'];
$order_no = $_GET['do'];
$sql = 'SELECT a.shop_name, a.shop_address, a.mobile, b.* FROM ss_do_master b, ss_shop a 
        WHERE b.do_no="' . $order_no . '" AND a.dealer_code=b.dealer_code';
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_object($result);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
	/* General Styles */
	body {
		font-family: Arial, sans-serif;
	}

	.logo {
		max-width: 150px;
		width: 100%;
		height: auto;
	}

	.invoice-header {
		background-color: #0f3193;
		color: white;
		padding: 10px;
		text-align: center;
		font-size: 20px;
		font-weight: bold;
		margin-bottom: 20px;
	}

	.table th {
		background-color: #1a237e;
		color: white;
	}

	.table-bordered {
		border: 2px solid #000;
	}

	.table td {
		vertical-align: middle;
	}

	.btn-print {
		background-color: #0f3193;
		color: white;
		font-weight: bold;
		text-transform: uppercase;
		border: none;
	}

	.btn-print:hover {
		background-color: #1a237e;
	}

	/* Print Styles */
	@media print {

		.container,
		#print,
		.card,
		.content,
		.page-content,
		.card-header,
		.row {
			width: 100% !important;
			margin: 0px !important;
			padding: 0px !important;

		}

		#printButton {
			display: none;
		}

		#page,
		#footer,
		.opacity-30 {
			display: none !important;
		}

		.footer div {
			width: 59% !important;
			float: right;
		}

		.footer div table {
			width: 100% !important;
		}

		body {
			zoom: 90%;
		}
	}

	/* Responsive Styles */
	@media (max-width: 767px) {
		.invoice-header {
			font-size: 16px;
		}

		.table {
			font-size: 14px;
		}
	}
</style>
<div class="card card-style">
	<div class="content m-0">
		<div class="card-header m-0 pt-5">
			<div class="row mb-0">
				<!-- Page Content -->
				<div class="container mt-4">
					<div class="row justify-content-between align-items-center mb-3">
						<div class="col-md-4">
							<img src="../assets/images/logo/mepdemo.png" alt="Logo" class="logo">
						</div>

						<div class="col-md-4 text-end">
							<button id="printButton" onclick="window.print()" class="btn btn-print">Print</button>
						</div>
					</div>

					<div class="row">
						<!-- Shop Details -->
						<div class="col-md-4">
							<table class="table table-bordered">
								<tr>
									<th class="text-center">Authorized Distributor</th>
								</tr>
								<tr>
									<td>MEP GROUP</td>
								</tr>
								<tr>
									<td>Shop Code: <?php echo $row->dealer_code; ?></td>
								</tr>
								<tr>
									<td>Shop Name: <?php echo $row->shop_name; ?></td>
								</tr>
								<tr>
									<td>Address: <?php echo $row->shop_address; ?></td>
								</tr>
								<tr>
									<td>Mobile: <?php echo $row->mobile; ?></td>
								</tr>
							</table>
						</div>
						<div class="col-md-4 text-center">
							<div class="invoice-header">Invoice</div>
						</div>

						<!-- Invoice Details -->
						<div class="col-md-4">
							<table class="table table-bordered">
								<tr>
									<th class="text-center">Invoice Details</th>
								</tr>
								<tr>
									<td>Order No: <?php echo $row->do_no; ?></td>
								</tr>
								<tr>
									<td>Order Date: <?php echo $row->do_date; ?></td>
								</tr>
								<tr>
									<td>Challan Date: 22-Dec-2024</td>
								</tr>
							</table>
						</div>
					</div>


					<!-- Order Table -->
					<div class="table-responsive mt-4">
						<table class="table table-bordered text-center">
							<thead>
								<tr>
									<th>SL</th>
									<th>Item Code</th>
									<th>Item Name</th>
									<th>QTY</th>
									<th>TP</th>
									<th>Total TP Amt</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$res = 'SELECT a.id, b.finish_goods_code, b.item_name, a.t_price AS tp, 
                        a.total_tp, a.pkt_unit AS pcs 
                        FROM ss_do_details a, item_info b 
                        WHERE b.item_id=a.item_id AND a.do_no=' . $order_no . ' ORDER BY a.id';
								$query = mysqli_query($conn, $res);
								$sl = 1;
								$sum_tp_amt = 0;
								while ($data = mysqli_fetch_object($query)) {
									$sum_tp_amt += $data->total_tp;
								?>
									<tr>
										<td><?php echo $sl++; ?></td>
										<td><?php echo $data->finish_goods_code; ?></td>
										<td><?php echo $data->item_name; ?></td>
										<td><?php echo $data->pcs; ?></td>
										<td><?php echo number_format($data->tp, 2); ?></td>
										<td><?php echo number_format($data->total_tp, 2); ?></td>
									</tr>
								<?php } ?>
								<tr>
									<td colspan="5" class="text-end fw-bold">Total</td>
									<td><?php echo number_format($sum_tp_amt, 2); ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
require_once '../assets/template/inc.footer.php';
?>