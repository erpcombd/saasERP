<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$page = "reports";

require_once '../assets/template/inc.header.php';
?>
<?
$user_id = $_SESSION['user_id'];
$order_no = $_GET['order_id'];
//$order = findall('select * from ss_do_master where do_no="'.$order_no.'"');
$sql = 'SELECT a.shop_name,a.shop_address,a.mobile,b.* from ss_do_master b,ss_shop a where b.do_no="' . $order_no . '" and a.dealer_code=b.dealer_code';
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_object($result);


// Improved dealer information retrieval
$depot_info = findall("SELECT * FROM dealer_info WHERE dealer_code = '".$row->depot_id."' ");
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
	.tttt{
		width: 360px;
		margin-bottom:15px;	
	}

	.logo {
		max-width: 150px;
		width: 100%;
		height: auto;
		padding-left: 45px;
	}

	.invoice-header {
		
		color: #0089D0;
		padding: 7px !important;
	
		font-size: 30px !important;
		font-weight: bold;
		display: flex;
		margin-right:10px;
	}

	.table th {
		background-color: #0089D0;
		color: white;
	}
	

	.hhh {
		margin-bottom: -80px;
	}

	.table1 {
		
		border: 2.1px solid #595959;
	}

	.card-header {
		background-color: #fff;
	}

	h1{
	
		color: black;
		font-size: 12px;	
	}
	
	
	.fds{
		background-color: 	#0089D0;
		color: #fff;
	
	}
	.tttt{
		width: 250px;	
	}

	@media (max-width: 767px) {
		.invoice-header {
			font-size: 20px !important;
			
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

		#printButton {
			display: none;
		}

		#page,
		#footer,
		.opacity-30 {
			display: none !important;
		}

		body {
			zoom: 90%;
		}
	}
	
</style>
<script>
  // Store a reference to your back button
const backButton = document.querySelector('.btn-print');

// Variable to store scroll position
let savedScrollPosition = 0;

// Function to run when page loads
document.addEventListener('DOMContentLoaded', function() {
  // Check if we're coming back from the order view page
  if (sessionStorage.getItem('returnToOrderList')) {
    // Get saved scroll position
    savedScrollPosition = parseInt(sessionStorage.getItem('scrollPosition') || '0');
    
    // Restore scroll position after a short delay to ensure page is fully loaded
    setTimeout(() => {
      window.scrollTo(0, savedScrollPosition);
      // Clear the flag
      sessionStorage.removeItem('returnToOrderList');
    }, 100);
  }
  
  // Add event listener to view buttons (assuming they have a class like 'view-order-btn')
  const viewButtons = document.querySelectorAll('.view-order-btn');
  viewButtons.forEach(button => {
    button.addEventListener('click', function() {
      // Save current scroll position before navigating
      sessionStorage.setItem('scrollPosition', window.scrollY.toString());
    });
  });
  
  // If we're on the order view page, add click handler to back button
  if (backButton) {
    backButton.addEventListener('click', function(e) {
      // Set flag to indicate we're returning to the order list
      sessionStorage.setItem('returnToOrderList', 'true');
      
      // Let the normal href navigation proceed
      // No need to prevent default since we want the link to work
    });
  }
});
    </script>

<!-- start of Page Content-->
<div class="page-content header-clear-medium hhh ">
<a href="do_entry.php"><button class="btn btn-print view-order-btn text-center" style="background-color:#00BCD4 !important; margin-left: 5px; color: #fff !important;">Back </button></a>
	
	<div class="row justify-content-between align-items-center mb-3 " style="width:100% !important;">
						<div class="col-6">
								<a href="#" class=" btn-m btn-full  hhs invoice-header text-uppercase font-900   ">Order View</a>
						</div>
						
						<div class="col-6 text-end">
						<h1>Authorized Distributor</h1>
			<img src="../assets/images/logo/Logo MEP Png.png" alt="Logo" class="logo">
						</div>
						
					</div>

</div>
<div class="card card-style" style=" zoom: 51%; ">
<a href="offer.php"></a>
	<div class="content m-0">
		<!--<div class="card-header m-0 p-0">-->
			<div class="row mb-0">

				<!-- <div class="d-flex justify-content-center row mt-0"> -->

				<!-- <center><span style="font-size:20px;"></span></center> -->

				<div class="col-6 table-responsive mb-2">
					<table  cellspacing="0" cellpadding="2" border="0">
						<thead>

							<tr>
								<td width="30%">Retailer Code</td>
								<td width="3%">:</td>
								<td width="60"><?php echo $row->dealer_code ?></td>
							</tr>
							
							<tr>
								
								<td  >Retailer Name</td>
								<td >:</td>
								<td ><?php echo $row->shop_name ?></td>
							</tr>
							<tr>
								<td >Address</td>
								<td>:</td>
								<td ><?php echo $row->shop_address ?></td>
								
							</tr>
							<tr>
								<td >Mobile No</td>
								<td >:</td>
								<td ><?php echo $row->mobile ?></td>
								
							</tr>
						</thead>
					</table>
				</div>
				


				<div class="col-6 table-responsive justify-content-end d-flex mb-2 ">
					<table cellspacing="0" cellpadding="2" border="0">
						<thead>
							<tr>
							<td width="30%" >Distributor Name</td>
							<td width="3%">:</td>
							<td width="60%"><?= $depot_info->dealer_name_e; ?></td>
							</tr>
							<tr>
								<td>Address</td>
								<td >:</td>
								<td ><?=$depot_info->address_e;?></td>
							</tr>
							<tr>
								<td class="table2">Mobile No</td>
								<td >:</td>
								<td ><?=$depot_info->mobile_no;?></td>

							</tr>
							<tr>
								<td>Order Date:</td>
								<td>:</td>
								<td><?php echo $row->do_date ?></td>

							</tr>
							
							
						</thead>
					</table>
				</div>
				<!-- </div> -->





			</div>
			<div class="table-responsive ">

				<table class="table  text-center table-bordered shadow-l table1" style="overflow: hidden; margin:0px;">
					<thead class="th1">
						<tr class="bg-night-light text-center">

								<th scope="col" class="color-white">SL</th>
							<th scope="col" class="color-white" width="10%">Item Code</th>
							<th scope="col" class="color-white" width="30%">Item Name</th>
							<th scope="col" class="color-white">QTY</th>
							<th scope="col" class="color-white">TP</th>
							<th scope="col" class="color-white">NSP</th>
							<th scope="col" class="color-white">Offer %</th>
							<th scope="col" class="color-white">Total TP Amt</th>
							<th scope="col" class="color-white">Total NSP Amt</th>
						</tr>
					</thead>
					<tbody>


						<? $res = 'select a.id,b.finish_goods_code,b.item_name,b.unit_name, a.t_price as tp,a.nsp_per,a.stock,a.unit_price as rate,a.pkt_unit as pcs,a.total_amt  as amt ,a.total_tp from ss_do_details a,item_info b where b.item_id=a.item_id and a.do_no=' . $order_no . ' order by a.id';
						//echo link_report_add_del_auto($res,'',6,7);

						$query = mysqli_query($conn, $res);
						$sl = 1;
						$sum_tp_amt = 0;
						$sum_nsp_amt = 0;
						while ($data = mysqli_fetch_object($query)) {
						?>

							<tr>
								<td class="table1"><?= $sl++ ?></td>
								<td class="table1" align="left"><?= $data->finish_goods_code ?></td>
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
					<table class="footer-table table-bordered table1 tttt mt-3">
						<tr>
							<td class="fw-bold "><strong>Total TP Amount</strong></td>
							<td><?= number_format($sum_tp_amt, 2); ?></td>
						</tr>
						<tr>
							<td><strong>Discount Amount</strong></td>
							<td><?= number_format($sum_dis_amt = $sum_tp_amt - $sum_nsp_amt, 2); ?></td>
						</tr>
						<tr>
							<td><strong>Net Payable Amount</strong></td>
							<td><?= number_format($sum_nsp_amt, 2); ?></td>
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

if(isset($credit_amt[1]) && $credit_amt[1]>0){
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
		<!--</div>-->
	</div>
</div>


<?php
require_once '../assets/template/inc.footer.php';
?>