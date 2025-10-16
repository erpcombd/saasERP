<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';
$title = "Receive View Reports";
$page = "receive_view.php";
$user_id = $_SESSION['user']['user_id'];
$or_no = $_GET['do'];

// Fetch the receive master information
$order = findall('select * from ss_receive_master where or_no="' . $or_no . '"');

// Get vendor_id from the order data instead of POST
$vendor_id = $order->vendor_id; // Using the vendor_id from the receive master table

// Get shop details
$shop_info =  findall('select * from ss_shop where dealer_code="'.$vendor_id. '"');

	$depot_info = findall('select * from dealer_info where dealer_code="'.$order->warehouse_id. '"');
	$order_info = findall('SELECT * FROM ss_do_master WHERE dealer_code="' . $vendor_id . '"');

// Get chalan information if needed
$chalan_info = findall('SELECT * FROM ss_do_chalan WHERE dealer_code="' . $vendor_id . '"');
require_once '../assets/template/inc.header.php';
?>
<style>
	.logo {
		max-width: 150px;
		width: 100%;
		height: auto;
		padding-left: 45px;
	}
	body{
		color: black !important;	
	}

.invoice-header {
		color: #0089D0;
		padding: 7px !important;
		font-size: 20px !important;
		font-weight: bold;
		display: flex;
		margin-right:35px;
	}
	h1{
		color: black;
		font-size: 12px;	
	}
	.fds{
		background-color: 	#0089D0;
		color: #fff;
	}

	.table th {
		background-color: #0089D0;
		color: white;
	}
	.tttt{
		width: 360px;
		margin-bottom:15px;		
	}
	.hhh {
		margin-bottom: -80px !important;	
	}
	body{
		background-color: #fff !important;	
	}
	.table1 {
		background-color: #fff !important;
		border: 1px solid black;
		font-size:16px;
	}
	.card-header {
		background-color: #fff;
	}
	.table2 {
		font-size:15px;
	}
	.th1 {
		border: 2px solid black;
	}
	
	@media (max-width: 767px) {
		.invoice-header {
		font-size: 11px !important;
	}
		.billing-info {
			text-align: left !important;
		}
		.card{
		font-size: 14px !important;	
	}
		.table {
			font-size: 14px;
		}
		h1{
		font-size:9px;	
	}
	.logo {
		max-width: 130px;
		width: 100%;
		height: auto;	
	}
	}
	@media print {
	    @page {
		  size: A4; /* Set page size to A4 */
		  margin: 1cm; /* Set margins */
		}
		.space{
		display: block !important;}
		.online-message,.offline-message,.back_button{
		display:none !important;
		}
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
		body {
			zoom: 100%;
		}
        #printButton {
            display: none;
        }
		.hhs{
			font-size: 18px !important;
	}
        #page,
        #footer,
        .opacity-30 {
            display: none !important;
        }
		.tttt{
		margin-right:23px !important;	
	}
        .footer div table {
            width: 100% !important;
        }
		body, .card, .table{
		font-size: 18px !important;
	}
	.invoice-header {
			font-size: 32px !important;
			margin-left: -15px !important;
		}
    }
</style>
<!-- Start of Page Content -->
	<div class="page-content header-clear-medium">	 
 	<a href="other_receive_status.php" class="back_button "><button class="btn btn-print" style="background-color:#00BCD4 !important; margin-bottom: 3px; margin-left:		    5px; color: #fff !important;">Back </button></a>
	<button id="printButton" onClick="window.print()" class="btn btn-print btn-primary ">Print</button>
	<div class="row justify-content-between align-items-center mb-3 " style="width:100% !important;">
						<div class="col-6">
						<a href="#" class=" btn-m btn-full mb-3 invoice-header text-uppercase text-center font-900   ">Replace Return View</a>	
						</div>
						<div class="col-6 text-end">
						<h1>Authorized Distributor</h1>
							<img src="../assets/images/logo/Logo MEP Png.png" alt="Logo" class="logo">
						</div>
					</div>
	<div class="card card-style" style=" zoom: 60%; ">
	<div class="content m-0">
			<div class="row mb-0">
			<div class="col-6 table-responsive mb-2 table2 ">
					<table  cellspacing="0" cellpadding="2" border="0" class="hhs  mb-2">
						<thead>
							<tr>
								<td  width="30%"> Replace Return NO </td>
								<td width="3%">:</td>
								<td width="60%"><?= htmlspecialchars($or_no) ?></td>
							</tr>
							<tr>
								<td >Date </td>
								<td >:</td>
								<td><?= htmlspecialchars($order->or_date) ?></td>
							</tr>
							<tr>
								<td >Shop Code</td>
								<td >:</td>
								<td ><?= $shop_info->dealer_code ;?></td>
							</tr>
							<tr>
								<td >Shop Name</td>
								<td >:</td>
								<td><?= $shop_info->shop_name; ?></td>
							</tr>
							<tr>
								<td >Shop Address</td>
								<td >:</td>
								<td><?= $shop_info->shop_address; ?></td>
							</tr>
							<tr>
								<td >Mobile No </td>
								<td >:</td>
								<td><?= $shop_info->mobile; ?></td>
							</tr>
						</thead>
					</table>
				</div>
				<div class="col-6 table-responsive justify-content-end justify-content-center   d-flex mb-2 table2 ">
					<table cellspacing="0" cellpadding="2" border="0" class="hhs mb-2">
						<thead>
							<tr>
								<td width>Distributor Name</td>
								<td width>:</td>
								<td width><?= $depot_info->dealer_name_e; ?></td>
							</tr>
							<tr>
								<td>Address</td>
								<td >:</td>
								<td><?=  $depot_info->address_e ; ?> </td>
							</tr>
							<tr>
								<td>Contact Number </td>
								<td >:</td>
								<td><?= $depot_info->mobile_no;?></td>
							</tr>
							<tr>
								<td>Order No </td>
								<td >:</td>
								<td><?=  $order_info->do_no ; ?></td>
							</tr>
							<tr>
								<td>Chalan No </td>
								<td >:</td>
								<td><?=  $chalan_info->chalan_no ;?></td>
							</tr>
							<tr>
								<td>Chalan Date </td>
								<td >:</td>
								<td><?=  $chalan_info->chalan_date ;?></td>
							</tr>
						</thead>
					</table>
				</div>
			<div class="table-responsive ">
		<table class="table  text-center table-bordered shadow-l table1" style="overflow: hidden; margin:0px;">
				<thead class="th1">
						<tr class="bg-night-light text-center">
						<th scope="col">#</th>
						<th scope="col">Code</th>
						<th scope="col" >Product</th>
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
							<td><?=($row->item_id) ?></td>
							<td class="text-left"><?= htmlspecialchars($row->item_name) ?></td>
							<td><?= number_format($row->rate, 2, '.', '') ?></td>
							<td><?= (int)$row->qty ?></td>
							<td><?= number_format($row->amount, 2, '.', '') ?></td>
							<?php $final_amount += $row->amount; ?>
						</tr>
					<?php } ?>
					<tr class="font-weight-bold">
						<td colspan="5" align="right"><b>Grand Total</b></td>
						<td><?= number_format($final_amount, 2, '.', '') ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- End of Page Content -->

<?php
require_once '../assets/template/inc.footer.php';
?>