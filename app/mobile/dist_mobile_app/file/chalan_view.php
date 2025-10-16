<?php

session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$user_id = $_SESSION['user']['id'];
$title = "Chalan View";
$page = "chalan_view.php";

require_once '../assets/template/inc.header.php';

if ($_GET['v'] > 0) {
	$chalan_no = $_GET['v'];
	$chalan_info = findall("SELECT * FROM ss_do_chalan WHERE chalan_no='" . $chalan_no . "' LIMIT 1");
	$dealer_code = $chalan_info->dealer_code;
	$dealer = findall("SELECT * FROM ss_shop WHERE dealer_code='" . $dealer_code . "'");
	$chalan_amount = find1("SELECT SUM(total_amt) FROM ss_do_chalan WHERE chalan_no='" . $chalan_no . "'");
	$master_dealer = $chalan_info->depot_id;
	$mdealer = findall("SELECT * FROM dealer_info WHERE dealer_code='" . $master_dealer . "'");
}
?>
<style>
/*.header {display:none !important;}*/
	.logo {
		max-width: 150px;
		width: 100%;
		height: auto;
		padding-left: 45px;
		/*margin-left:1370px;
		margin-bottom: 10px;*/
	}
	body{
		background-color: #fff;	
		color: black !important;
		font-size: 18px !important;
	}

.invoice-header {
		
		color: #0089D0;
		padding: 7px !important;
	
		font-size: 28px !important;
		font-weight: bold;
		display: flex;
		margin-right:10px;
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
		margin-bottom: -80px;
	}

	.table1 {
		background-color: #fff !important;
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
</style>

<div class="page-content header-clear-medium hhh "></div>

		    <!-- Button for Print -->
			<a href="chalan_list.php"><button class="btn btn-print" style="background-color:#00BCD4 !important; margin-left:5px; color: #fff !important;">Back </button></a>
						<div class="row justify-content-between align-items-center mb-3 " style="width:100% !important;">
						<div class="col-6">
						<a href="#" class=" btn-m btn-full mb-3 invoice-header text-uppercase text-center font-900   ">Invoice</a>
							
						</div>

						<div class="col-6 text-end">
						<h1>Authorized Distributor</h1>
							<img src="../assets/images/logo/LogoMEP.png" alt="Logo" class="logo">
						</div>
					</div>
<div class="card card-style pt-2 m-0 p-3" style="zoom: 50%; width:100% !important; ">
	<div class="content m-0">

	
	
		<!--<div class="card-header m-0 p-0 border-0">-->
			<div class="row mb-0">

				<!-- <div class="d-flex justify-content-center row mt-0"> -->

				<!-- <center><span style="font-size:20px;"></span></center> -->

				<div class="col-6 table-responsive mb-2">
					<table  cellspacing="0" cellpadding="2" border="0">
						<thead>
							<!-- Dealer Info Header -->

							<tr>
								<td width="30%">Retailer Code</td>
								<td width="3%">:</td>
								<td width="60%"> <?= $dealer->dealer_code ?></td>
							</tr>
							<tr>
								<td >Retailer Name</td>
								<td >:</td>
								<td> <?= $dealer->shop_name ?></td>
							</tr>
							<tr>
								<td >Address </td>
								<td >:</td>
								<td><?= $dealer->shop_address ?></td>
							</tr>
							<tr>
								<td >Mobile No </td>
								<td >:</td>
								<td><?= $dealer->mobile ?></td>
							</tr>

						</thead>
					</table>
				</div>

				<!-- Chalan Details -->
				<div class="col-6 table-responsive justify-content-end d-flex mb-2 ">
					<table cellspacing="0" cellpadding="2" border="0">
						<thead>

							<tr>
								<td width="30%" >Distributor Name</td>
								<td width="3%">:</td>
								<td width="60%"><?= $mdealer->dealer_name_e ?></td>
							</tr>
							<tr>
								<td>Address</td>
								<td >:</td>
								<td><?= $mdealer->address_e ?> </td>
							</tr>
							<tr>
								<td>Contact Number </td>
								<td >:</td>
								<td><?= $mdealer->mobile_no ?></td>
							</tr>

							<tr>
								<td>Order No </td>
								<td >:</td>
								<td><?= $chalan_info->do_no ?></td>
							</tr>
							<tr>
								<td>Chalan No</td>
								<td >:</td>
								<td><?= $chalan_no ?></td>
							</tr>
							<tr>
								<td>Chalan Date </td>
								<td >:</td>
								<td><?= $chalan_info->chalan_date ?></td>
							</tr>



						</thead>
					</table>
				</div>







				<!-- Dealer Details -->

				<!-- Chalan Table -->
				<div class="table-responsive ">

					<table class="table  text-center table-bordered shadow-l table1" style="overflow: hidden; margin:0px;">
						<thead class="th1">
							<tr class="bg-night-light text-center">
								<th scope="col" class="color-white" >SL</th>
								<th scope="col" class="color-white" width="10%">Product Code</th>
								<th scope="col" class="color-white" width="30%">Product</th>
								<th scope="col" class="color-white">TP</th>
								<th scope="col" class="color-white">Offer%</th>
								<th scope="col" class="color-white">NSP</th>
								<th scope="col" class="color-white">Qty</th>
								<th scope="col" class="color-white">TP Total</th>
								<th scope="col" class="color-white">NSP Total</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = "SELECT c.*, i.*, c.nsp_per AS nsp, c.t_price AS tp 
                                FROM ss_do_chalan c, item_info i 
                                WHERE i.item_id=c.item_id AND c.depot_id='".$user_id."' AND c.chalan_no='" . $chalan_no . "'";
							$query = mysqli_query($conn, $sql);
							$sl = 1;
							$gqty = $final_tpamount = $final_amount = 0;

							while ($row = mysqli_fetch_object($query)) {
								$tptotal = $row->total_tp;
								$total = $row->unit_price * $row->total_unit;

								$gqty += $row->total_unit;
								$final_tpamount += $tptotal;
								$final_amount += $total;
							?>
								<tr>
									<td><?= $sl++ ?></td>
									<td align="left"><?= $row->finish_goods_code ?></td>
									<td style="text-align:left;"><?= $row->item_name ?></td>
									<td><?= number_format($row->tp, 2) ?></td>
									<td><?= number_format($row->nsp, 2) ?></td>
									<td><?= number_format($row->unit_price, 2) ?></td>
									<td><?= $row->total_unit ?></td>
									<td><?= number_format($tptotal, 2) ?></td>
									<td><?= number_format($total, 2); $sum_nsp_amt +=$total; ?></td>
								</tr>
							<?php } ?>
							<tr>
								<td colspan="6"><strong>Total</strong></td>
								<td><strong><?= $gqty ?></strong></td>
								<td><strong><?= number_format($final_tpamount, 2) ?></strong></td>
								<td><strong><?= number_format($final_amount, 2) ?></strong></td>
							</tr>
						</tbody>
					</table>
				</div>
				
<br><p>				
				
				
				<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end" style=" margin-left: 25px;">
					<table class="footer-table table-bordered table1 tttt mt-3">
						<tr>
							<td width="70%">Total TP Amount</td>
							<td width="30%" align="center"><?= number_format($final_tpamount, 2); ?></td>
						</tr>
						<tr>
							<td>Discount Amount</td>
							<td align="center"><?= number_format($sum_dis_amt = $final_tpamount - $final_amount, 2); ?></td>
						</tr>
						<tr class="fds">
							<td >Net Payable Amount</td>
							<td align="center"><?= number_format($sum_nsp_amt, 2); ?></td>
						</tr>
					</table>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-start">
<p class="p mb-1"><strong>In Words : </strong>
		<strong><?php
$currency_type = 'taka'; // Set this to 'taka' or 'dollar' based on user input

$scs =  $sum_nsp_amt;
$credit_amt = explode('.',$scs);

if($credit_amt[0]>0){
    echo convertNumberToWordsForIndia($credit_amt[0]);
    echo ' ' . ($currency_type == 'taka' ? 'Taka' : 'Dollars');
}

if($credit_amt[1]>0){
    if($credit_amt[1]<10) $credit_amt[1] = $credit_amt[1]*10;
    echo ' & ' . convertNumberToWordsForIndia($credit_amt[1]);
    echo ' ' . ($currency_type == 'taka' ? 'Paisa' : 'Cents');
}

echo ' Only.';
?>
</strong>
		</p>
				</div>
			</div>
			</div>
<!--
		</div>
-->	


<!-- Signatures -->
<div style=" width:100% !important;">
				<!--<div class="footer w-100" style="zoom: 50%; width:100% !important; position: fixed; bottom: 0px;">-->
                <div class="row text-center">
					<!--<div class="col-12 space"><br /><br /><br /><br /><br /></div>-->
                    <div class="col-4">
                        <p>FO Signature</p>
                    </div>
                    <div class="col-4">
                        <p>Customer Signature</p>
                    </div>
                    <div class="col-4">
                        <p>Distributor Signature</p>
                    </div>
                </div>
</div>


</div>







<br /><br /><br /><br /><br />
</div>

<?php
require_once '../assets/template/inc.footer.php';
?>