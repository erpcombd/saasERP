<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$page = "reports";

require_once '../assets/template/inc.header.php';
?>
<?
$user_id = $_SESSION['user']['id'];
$order_no = $_GET['do'];
//$order = findall('select * from ss_do_master where do_no="'.$order_no.'"');
$sql = 'SELECT a.shop_name,a.shop_address,a.mobile,b.* from ss_do_master b,ss_shop a where b.do_no="' . $order_no . '" and a.dealer_code=b.dealer_code';
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_object($result);


?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
		background-color: #fff;
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



<!-- start of Page Content-->
<div class="page-content header-clear-medium hhh ">
<!--	<div class=" mb-1">
		<img alt="this is img" src="../assets/images/logo/mep.png" style=" 	width: 250px;" class="logo">
	</div>-->

</div>
<div class="card card-style" style=" zoom: 51%; ">
	<div class="content m-0">
		<div class="card-header m-0 p-0">
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
					<div class="row justify-content-between align-items-center mb-3">
						<div class="col-md-4">
							<img src="../assets/images/logo/mep.png" alt="Logo" class="logo">
						</div>

						<div class="col-md-4 text-end">
							<button id="printButton" onclick="window.print()" class="btn btn-print">Print</button>
						</div>
					</div>
			<div class="row mb-0">

				<!-- <div class="d-flex justify-content-center row mt-0"> -->

				<!-- <center><span style="font-size:20px;"></span></center> -->

				<div class="col-4 table-responsive ">
					<table class="table table-bordered  table1">
						<thead>

							<tr>
								<td class="td1">Authorized Distributor </td>
							</tr>
							<tr>
								<td class="table1">MEP GROUP</td>
							</tr>
							<tr>
								<td class="text-dark fw-bold table1">Shop Code:<?php echo $row->dealer_code ?></td>
							</tr>
							<tr>
								<td class="text-dark fw-bold table1">Shop Name:<?php echo $row->shop_name ?></td>
							</tr>
							<tr>
								<td class="text-dark fw-bold table1">Address:<?php echo $row->shop_address ?></td>
							</tr>
							<tr>
								<td class="text-dark fw-bold table1">Mobile Number:<?php echo $row->mobile ?></td>
							</tr>
						</thead>
					</table>
				</div>
				<div class="col-4 mb-3 mb-md-0 ">
					<a href="#" class=" btn-m btn-full mb-3 invoice-header text-uppercase text-center font-900   ">Invoice</a>
				</div>


				<div class="col-4 table-responsive  ">
					<table class="table table-bordered   ">
						<thead class="th1">
							<tr>
								<td class="td1">Tonmoy Electric</td>
							</tr>
							<tr>
								<td class="table2">Rohim Uddin Plaza, M.A Khan Lane, Bogra</td>
							</tr>
							<tr>
								<td class="table2">Contact Number: 8801711-869249</td>

							</tr>
							<tr>
								<td class="table2">Order No-<?php echo $row->do_no ?></td>

							</tr>
							<tr>
								<td class="table2">Order Date:<?php echo $row->do_date ?></td>

							</tr>
							<tr>
								<td class="table2">Challan Date: 22-Dec-2024</td>
							</tr>

						</thead>
					</table>
				</div>
				<!-- </div> -->




			</div>
			<div class="table-responsive ">

				<table class="table table-bordered text-center shadow-l table1" style="overflow: hidden;">
					<thead class="th1">
						<tr class="bg-night-light text-center">

							<th scope="col" class="color-white">SL</th>
							<th scope="col" class="color-white">Item Code</th>
							<th scope="col" class="color-white">Item Name</th>
							<th scope="col" class="color-white">QTY</th>
							<th scope="col" class="color-white">TP</th>
							<th scope="col" class="color-white">NSP</th>
							<th scope="col" class="color-white">Offer %</th>
							<th scope="col" class="color-white">Total TP Amt</th>
							<th scope="col" class="color-white">Total NSP Amt</th>
						</tr>
					</thead>
					<tbody>


				<? $res = 'select a.id,b.finish_goods_code,b.item_name,b.unit_name, a.t_price as tp,a.nsp_per,a.unit_price as rate,a.pkt_unit as pcs,a.total_amt  as amt ,a.total_tp from ss_do_details a,item_info b where b.item_id=a.item_id and a.depot_id='.$user_id.' and a.do_no=' . $order_no . ' order by a.id';
						//echo link_report_add_del_auto($res,'',6,7);

						$query = mysqli_query($conn, $res);
						$sl = 1;
						$sum_tp_amt = 0;
						$sum_nsp_amt = 0;
						while ($data = mysqli_fetch_object($query)) {
						?>

							<tr>
								<td class="table1"><?= $sl++ ?></td>
								<td class="table1"><?= $data->finish_goods_code ?></td>
								<td class="table1">
									<p style="width:200px;" class="text-dark"><?= $data->item_name ?></p>
								</td>
								<td class="table1"><?= $data->pcs;
													$gqty += $data->pcs; ?></td>
								<td class="table1"><?= floatval($data->tp); ?></td>
								<td class="table1"><?= floatval($data->rate); ?></td>
								<td class="table1"><?= floatval($data->nsp_per); ?></td>
								<td class="table1"><?= floatval($data->total_tp);
													$sum_tp_amt += $data->total_tp; ?></td>
								<td class="table1"><?= $data->amt;
													$sum_nsp_amt += $data->amt; ?></td>
							</tr>
						<? } ?>

					</tbody>
				</table>
			</div>
			<!-- <div class="footer d-flex flex-row-reverse"> -->
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end">
					<table class="footer-table table-bordered table1">
						<tr>
							<td class="fw-bold "><strong>Total TP Amount</strong></td>
							<td><?= number_format($sum_tp_amt += $data->total_tp, 2); ?></td>
						</tr>
						<tr>
							<td><strong>Discount Amount</strong></td>
							<td><?= number_format($sum_dis_amt = $sum_tp_amt - $sum_nsp_amt, 2); ?></td>
						</tr>
						<tr>
							<td><strong>Net Payable Amount</strong></td>
							<td><?= number_format($sum_nsp_amt += $data->amt, 2); ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- End of Page Content-->

<?php
require_once '../assets/template/inc.footer.php';
?>