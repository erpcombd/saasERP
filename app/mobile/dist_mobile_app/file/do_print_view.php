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


$sql_data = 'SELECT d.* from dealer_info d where d.dealer_code="' .$row->depot_id . '"';
$d_result = mysqli_query($conn, $sql_data);
$depot_data = mysqli_fetch_object($d_result);

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
	.logo {
		max-width: 150px;
		width: 100%;
		height: auto;
		padding-left: 7px;
	}

	.invoice-header {
		padding: 7px !important;
		font-size: 38px  !important;
		font-weight: bold;
		display: flex;
		background-color: #fff;
		color: #0089D0;
	}
		
	.hhs{
		margin-bottom: -23px;	
	}
	
	
	.fds{
		background-color: 	#0089D0;
		color: #fff;
	
	}
	
	.tttt{
		width: 360px;
		margin-bottom:15px;	
	}
	.card{
		font-size: 	22px;
	}

	h1{
	
		color: black;
		font-size:14px;	
	}

	.table1{
		border: 2.1px solid #595959;	
	}

	.td1 {
		background-color: #0089D0 !important;
		color: white !important;
	}

	
	.card-header {
		background-color: #fff;
	}

	.table2 {
		background-color: #fff !important;
		border: 0px;
	}

	.th1 {
		border: 2px solid black;
	}
	.table th {
		background-color: #0089D0;
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
	.space{
	display:none;
	}
	
	.hhh {
		margin-bottom: -80px;
	}
	

	@media (max-width: 767px) {
		.invoice-header {
			font-size: 32px !important;
			margin-left: -3px;
		}

		.table {
			font-size: 14px;
		}
		.billing-info {
			text-align: left !important;
		}
		
	.card{
		font-size: 14px !important;	
	}
	.logo {
		max-width: 100px;
		width: 100%;
		height: auto;
		
		
	}
	h1{
	
		font-size:10px;	
	}
	.invoice-header {
		margin-bottom: 16px;
	}
	}

	
	/* Print Styles */
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
		
	.hhs{
		padding:25px;	
	}

		#printButton {
			display: none;
		}

		#page,
		#footer,
		.opacity-30 {
			display: none !important;
		}

/*		.footer div {
			width: 59% !important;
			float: right;
		}*/

		.footer div table {
			width: 100% !important;
		}

		body {
			zoom: 100%;
		}
		.bds{
			width: 99% !important;	
			
		}
		.invoice-header {
			font-size: 32px !important;
			margin-left: -15px !important;
		}
		.logo {
		max-width: 100px;
		width: 100%;
		height: auto;
		padding-left: 7px;
	}
	
	body, .card, .table{
		font-size: 18px !important;
		
	}
	
		
	}

	/* Responsive Styles */
	
</style>

<body>


<!-- start of Page Content-->
<div class="page-content header-clear-medium hhh ">
<a href="do_status.php" class="back_button"><button class="btn btn-print" style="background-color:#00BCD4 !important; margin-bottom: 3px; margin-left:5px; color: #fff !important;">Back </button></a>
							<button id="printButton" onClick="window.print()" class="btn btn-print">Print</button>
<!--	<div class=" mb-1">
		<img alt="this is img" src="../assets/images/logo/mep.png" style=" 	width: 250px;" class="logo">
	</div>-->
	    <!-- Button for Print -->
		
					<div class="row justify-content-between align-items-center mb-0 mt-3 " style="width:100% !important;">
						<div class="col-6">
						<div >
					<a href="#" class=" btn-m btn-full  invoice-header text-uppercase font-900   ">Order</a>
				</div>
						
							
						</div>

						<div class="col-6 hhs text-end">
						<h1>Authorized Distributor</h1>
							<img src="../assets/images/logo/LogoMEP.png" alt="Logo" class="logo">
						</div>
					</div>
</div>
<br />

        <div class="card card-style pt-2 m-0 p-3" style="zoom: 50%; width:100% !important;">
					<!--<div class="row justify-content-between align-items-center mb-3">
						<div class="col-md-4">
							<img src="../assets/images/logo/mep.png" alt="Logo" class="logo">
						</div>

						<div class="col-md-4 text-end">
							<button id="printButton" onclick="window.print()" class="btn btn-print">Print</button>
						</div>
					</div>-->
			<div class="row mb-0">

				<!-- <div class="d-flex justify-content-center row mt-0"> -->

				<!-- <center><span style="font-size:20px;"></span></center> -->
				


				<div class="col-6 table-responsive mb-2">
					<table  cellspacing="0" cellpadding="2" border="0" >
						<thead>

							
							<tr>
								<td  width="30%" >Retailer Code</td>
								<td width="3%">:</td>
								<td width="60%"><?php echo $row->dealer_code ?></td>
							</tr>
							<tr>
								<td >Retailer Name</td>
								<td>:</td>
								<td><?php echo $row->shop_name ?></td>
							</tr>
							<tr>
								<td >Address</td>
								<td>:</td>
								<td><?php echo $row->shop_address ?></td>
							</tr>
							<tr>
								<td >Mobile No</td>
								<td>:</td>
								<td><?php echo $row->mobile ?></td>
							</tr>
						</thead>
					</table>
				</div>
			

				<div class="col-6 table-responsive justify-content-end d-flex mb-2 ">
					<table cellspacing="0" cellpadding="2" border="0">
						<thead >
							<tr>
							<td width="30%" >Distributor Name</td>
							<td width="3%">:</td>
							<td width="60%"><?=$depot_data->dealer_name_e;?></td>
							</tr>
							<tr>
								<td>Address</td>
								<td >:</td>
								<td class="table2"><?=$depot_data->address_e;?></td>
							</tr>
							<tr>
								<td>Mobile No</td>
								<td >:</td>
								<td><?=$depot_data->mobile_no;?></td>

							</tr>
							<tr>
								<td>Order No</td>
								<td>:</td>
								<td><?php echo $row->do_no ?></td>

							</tr>
							<tr>
							<td>Order Date:</td>
								<td>:</td>
								<td><?php echo $row->do_date ?></td>

							</tr>
							<tr>
								<td class="table2">Challan Date </td>
								<td>:</td>
								<td>22-Dec-2024</td>
							</tr>

						</thead>
					</table>
				</div>
				<!-- </div> -->




			</div>
			<div class="table-responsive ">

				<table class="table  text-center  mb-4 table-bordered shadow-l bds table1" style="overflow: hidden; margin:0px;">
					<thead class="th1">
						<tr class="bg-night-light text-center">

							<th width="3%" scope="col" class="color-white">SL</th>
							<th scope="col" class="color-white" width="10%">Item Code</th>
							<th scope="col" class="color-white" width="30%">Item Name</th>
							<th width="7%" scope="col" class="color-white">TP Rate</th>
							<th width ="5%" scope="col" class="color-white">QTY</th>
							
							<!--<th scope="col" class="color-white">NSP</th>
							<th scope="col" class="color-white">Offer %</th>
							<th scope="col" class="color-white">Total TP Amt</th>-->
							<th width ="9%" scope="col" class="color-white">Total Amt</th>
						</tr>
					</thead>
					<tbody>


				<? $res = 'select a.id,b.finish_goods_code,b.item_name,b.unit_name, a.t_price as tp,a.nsp_per,a.unit_price as rate,a.pkt_unit as pcs,a.total_amt  as amt ,a.total_tp 
				from ss_do_details a,item_info b where b.item_id=a.item_id and a.depot_id='.$user_id.' and a.do_no=' . $order_no . ' order by a.id';
						//echo link_report_add_del_auto($res,'',6,7);

						$query = mysqli_query($conn, $res);
						$sl = 1;
						$sum_tp_amt = 0;
						$sum_nsp_amt = 0;
						while ($data = mysqli_fetch_object($query)) {
						?>

							<tr>
								<td class="table1" ><?= $sl++ ?></td>
								<td align="left"><?= $data->finish_goods_code ?></td>
								<td align="left">
									<?= $data->item_name ?>
								</td>
								
								<td class="table1"><?= floatval($data->tp); ?></td>
								<td class="table1"><?= $data->pcs; $gqty += $data->pcs; ?></td>
								<?php /*?><td class="table1"><?= floatval($data->rate); ?></td>
								<td class="table1"><?= floatval($data->nsp_per); ?></td><?php */?>
								
								<td class="table1"><?= floatval($data->total_tp); $sum_tp_amt += $data->total_tp; ?></td>
								<!--<td class="table1"><?= $data->amt; $sum_nsp_amt += $data->amt; ?></td>-->
							</tr>
						<? } ?>
						<tr>
								<td></td>
								<td></td>
								<td>Total</td>
								<td></td>
								
								<td class="table1"><strong><?=$gqty;?></strong></td>
								
								
								
								<td class="table1"><strong><?=floatval($sum_tp_amt); ?></strong></td>
							<?php /*?>	<td class="table1"><?=$sum_nsp_amt; ?></td><?php */?>
							</tr>

					</tbody>
				</table>
			</div>
			<!-- <div class="footer d-flex flex-row-reverse"> -->
			<div class="row mb-0">
				
						<div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end">
					<table class="footer-table table-bordered table1 tttt">
						<tr>
							<td width="65%">Total TP Amount</td>
							<td width="65%" align="center"><?= number_format($sum_tp_amt += $data->total_tp, 2); ?></td>
						</tr>
						<tr>
							<td>Discount Amount</td>
							<td align="center"><?= number_format($sum_dis_amt = $sum_tp_amt - $sum_nsp_amt, 2); ?></td>
						</tr>
						<tr class="fds">
							<td>Net Payable Amount</td>
							<td align="center"><?= number_format($sum_nsp_amt += $data->amt, 2); ?></td>
						</tr>
					</table>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-start ">
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
	                <!-- Signatures -->
				<div class="footer "  style="zoom: 50%; padding-top:5px;  width:100% !important;">
				<!--<div class="footer w-100" style="zoom: 50%; width:100% !important; position: fixed; bottom: 0px;">-->
                <div class="row text-center mt-5" style="margin-top:50px; ">
					<div class="col-12 space"><br /><br /><br /><br /><br /></div>
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
				
				
</body>
<!-- End of Page Content-->

<?php
require_once '../assets/template/inc.footer.php';
?>