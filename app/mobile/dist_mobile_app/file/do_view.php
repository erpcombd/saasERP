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
	



	/*.td1 {
		background-color: #0089D0 !important;
		color: white !important;
	}*/

	.hhh {
		margin-bottom: -80px;
	}

	.table1 {
		
		border: 2.1px solid #595959;
	}

	.card-header {
		background-color: #fff;
	}

	/*.table2 {
		background-color: #d8d9e9 !important;
		
		width: 100%;
  border-collapse: collapse;
	}*/
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

	/*.th1 {
		border: 2px solid black;
	}*/

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

/*		.footer div {
			width: 59% !important;
			float: right;
		}*/

		.footer div table {
			width: 100% !important;
		}

		body {
			zoom: 90%;
		}
	}
	
</style>



<!-- start of Page Content-->
<div class="page-content header-clear-medium hhh mt-1 ">
<!--	<div class=" mb-1">
		<img alt="this is img" src="../assets/images/logo/mep.png" style=" 	width: 250px;" class="logo">
	</div>-->
		    <!-- Button for Print -->
				<a href="do_status.php"><button class="btn btn-print text-center" style="background-color:#00BCD4 !important; color: #fff !important;">Back </button></a>
					<div class="row justify-content-between align-items-center mb-3 " style="width:100% !important;">
						<div class="col-6">
								<a href="#" class=" btn-m btn-full  hhs invoice-header text-uppercase font-900   ">Order View</a>
						</div>
						
						<div class="col-6 text-end">
						<h1>Authorized Distributor</h1>
			<img src="../assets/images/logo/LogoMEP.png" alt="Logo" class="logo">
						</div>
						
					</div>
</div>
<div class="card card-style pt-2 m-0 p-3" style="zoom: 50%; width:100% !important; ">
	<div class="content m-0">
		<div class="card-header m-0 p-0 border-0">
		
			<div class="row mb-0">

				<!-- <div class="d-flex justify-content-center row mt-0"> -->

				<!-- <center><span style="font-size:20px;"></span></center> -->
				<!--<div class=" mb-3 mb-md-0 ">
					
				</div>-->
				
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
							<td width="60%"><?=$depot_data->dealer_name_e;?></td>
							</tr>
							<tr>
								<td>Address</td>
								<td >:</td>
								<td ><?=$depot_data->address_e;?></td>
							</tr>
							<tr>
								<td class="table2">Mobile No</td>
								<td >:</td>
								<td ><?=$depot_data->mobile_no;?></td>

							</tr>
							<tr>
								<td >Order No</td>
								<td>:</td>
								<td><?php echo $row->do_no ?></td>

							</tr>
							<tr>
								<td>Order Date:</td>
								<td>:</td>
								<td><?php echo $row->do_date ?></td>

							</tr>
							<!--<tr>-->
							<!--	<td class="table2">Challan Date </td>-->
							<!--	<td>:</td>-->
							<!--	<td><?php echo $row->chalan_date ?></td>-->
							<!--</tr>-->

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
								<td class="table1 " align="left"><?= $data->finish_goods_code ?></td>
								<td class="table1">
									<p class="text-dark"  align="left"><?= $data->item_name ?></p>
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
							<tr>
								<td></td>
								<td></td>
								<td>Total</td>
								<td class="table1"><?=$gqty;?></td>
								<td class="table1"></td>
								<td class="table1"></td>
								<td class="table1"></td>
								<td class="table1"><?=floatval($sum_tp_amt); ?></td>
								<td class="table1"><?=$sum_nsp_amt; ?></td>
							</tr>

					</tbody>
				</table>
			</div>
			<!-- <div class="footer d-flex flex-row-reverse"> -->
			<div class="row">
				
				<div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end">
					<table class="footer-table table-bordered table1 tttt mt-3">
					
					
						<tr>
							<td width="65%">Total TP Amount</td>
							<td width="35%" align="center"><?= number_format($sum_tp_amt += $data->total_tp, 2); ?></td>
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
	</div>
</div>





<?php /*?><div class="card card-style gradient-green">
					<div class="content">
						<h4 class="color-white">DO NO <?php echo $order_no;?> . Date # <?php echo $order->do_date;?></h4>
						<p class="color-white">
							Order Status: <?=$order->status;?>
						</p>
					</div>
				</div>
				
		<?php 
		$res=mysqli_query($conn,"select distinct(d.id) ,d.*,i.item_name 
		from ss_do_details d,item_info i,ss_do_master m
		where m.do_no=d.do_no and m.do_no='$order_no' and  d.item_id=i.item_id GROUP by d.id");
		$sl=1;
		while($row=mysqli_fetch_object($res)){
		?>


					<div class="card card-style">
						<div class="content">
							<div class="d-flex pb-2">
								<div class="align-self-center">
									<h2 class="font-700 mb-0"><?php echo $sl++?>. <?php echo $row->item_name?>p</h2>
									
									
									<table class="w-100">
										<tbody>
											<tr>
												<td>
													<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase"><strong class="color-highlight">TP:</strong> <?php echo $row->t_price?></p>
													<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase"><strong class="color-highlight">%:</strong> <?php echo $row->nsp_per?></p>
												</td>
												<td>
													<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase"><strong class="color-highlight">Rate:</strong> <?php echo $row->unit_price?></p>
													<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase"><strong class="color-highlight">Qty:</strong> <?php echo $row->total_unit?></p>
												</td>
											</tr>
										</tbody>
									</table>
									
								</div>
								<div class="align-self-center ms-auto">
									<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase">Total: <strong class="color-highlight"><?php $total = ($row->unit_price*$row->total_unit); echo $total; $final_amount +=$total;?></strong></p>
								</div>							
							</div>
						</div>
					</div>              
 <?php } ?>
 
					
				<div class="content">
				<p align="right"><strong>Total :<?php echo $final_amount?></strong></p>



 
				 <div class="row m-0 p-0">
				 <? if($order->status=='Manual'){?>  
					<div class="col-6">
						<a href="do.php?do_no=<?=$order_no?>" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light">Back to Order</a>
					</div>
					<? }else{ ?> 
					<div class="col-6">
						<a href="do_status.php" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light">Back to Order List</a>								 
					</div>
					 <? } ?>
				</div>
				
				</div>
		</div><?php */ ?>
<!-- End of Page Content-->






<?php
require_once '../assets/template/inc.footer.php';
?>