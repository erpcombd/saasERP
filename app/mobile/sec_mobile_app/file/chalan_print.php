<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$user_id = $_SESSION['user']['username'];
$title = "Chalan View";
$page = "chalan_view.php";

require_once '../assets/template/inc.header.php';

if ($_GET['v'] > 0) {
    $chalan_no = $_GET['v'];
    $chalan_info = findall("SELECT * FROM ss_do_chalan WHERE chalan_no='" . $chalan_no . "' LIMIT 1");
    $dealer_code = $chalan_info->dealer_code;
    $dealer = findall("SELECT * FROM ss_shop WHERE dealer_code='" . $dealer_code . "'");
    $chalan_amount = find1("SELECT SUM(total_amt) FROM ss_do_chalan WHERE chalan_no='" . $chalan_no . "'");
    $master_dealer = $dealer->master_dealer_code;
    $mdealer = findall("SELECT * FROM dealer_info WHERE dealer_code='" . $master_dealer . "'");
}
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
		margin-bottom: 10px;	
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
		margin-top: -140px;
	}
	

	@media (max-width: 767px) {
		.invoice-header {
			font-size: 32px !important;
			
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
			zoom: 130%;
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
	
	
		
	}

	/* Responsive Styles */
	
</style>
<!--<style>
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

    .btn-print {
        background-color: #0f3193;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        border: none;
    }

    /* Print Styles */
    @media print {




        /* .container, */
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
		@page {
		  margin: 0.5in 0.5in; /* top/bottom 1 inch, left/right 0.5 inch */
		}
    }
</style>-->

<div class="page-content header-clear-medium hhh "></div>
<div class="pt-5" style=" width:100% !important;">
		<a href="chalan_list.php" class="back_button "><button class="btn btn-print" style="background-color:#00BCD4 !important; margin-bottom: 3px; margin-left:5px; color: #fff !important;">Back </button></a>
							<button id="printButton" onClick="window.print()" class="btn btn-print">Print</button>
    <!-- Content to Print -->
	
	
					
    <div id="print" style="width:100% !important;">
	
	<div class="row justify-content-between align-items-center mb-0 mt-3 " style="width:100% !important;">
						<div class="col-6">
						<div >
					<a href="#" class=" btn-m btn-full  invoice-header text-uppercase font-900   ">INVOICE</a>
				</div>
						
							
						</div>

						<div class="col-6 hhs text-end">
						<h1>Authorized Distributor</h1>
							<img src="../assets/images/logo/Logo MEP Png.png" alt="Logo" class="logo">
						</div>
					</div>
	    <!-- Button for Print -->
					<!--<div class="row justify-content-between align-items-center mb-3 " style="width:100% !important;">
						<div class="col-md-4">
							<img src="../assets/images/logo/mepdemo.png" alt="Logo" class="logo">
						</div>

						<div class="col-md-4 text-end">
							<button id="printButton" onclick="window.print()" class="btn btn-print">Print</button>
						</div>
					</div>-->
        <!-- Dealer Info -->


        <div class="card card-style pt-2 m-0 p-3" style="zoom: 50%; width:100% !important;">
            <div class="content m-0 ms-2 me-2">
        <!--        <div class="card-header m-0 p-0">-->
                    <div class="row mb-0">

                        <!-- <div class="d-flex justify-content-center row mt-0"> -->

                        <!-- <center><span style="font-size:20px;"></span></center> -->

                       <div class="col-6 table-responsive mb-2">
							<table  cellspacing="0" cellpadding="2" border="0" >
							<thead>
									 <tr>
									 	<td  width="25%" >Retailer Code</td>
										<td width="3%">:</td>
										<td width="60%"><?= $dealer->dealer_code ?></td>
                                       
                                    </tr>
                                    <tr>
									<td >Retailer Name</td>
									<td>:</td>
									<td><?= $dealer->shop_name ?></td>
                                      
                                    </tr>
                                    <tr>
									<td >Address</td>
									<td>:</td>
									<td><?= $dealer->shop_address ?></td>
									
                                    </tr>
                                    <tr>
								<td >Mobile No</td>
								<td>:</td>
								<td><?= $dealer->mobile ?></td>
                                        
                                    </tr>

                                </thead>
                            </table>
                        </div>

                        
                        <!-- Chalan Details -->
                      <div class="col-6 table-responsive justify-content-end d-flex mb-2 ">
						<table cellspacing="0" cellpadding="2" border="0">
						<thead >
								<tr>
							<td width="32%" >Distributor Name</td>
							<td width="3%">:</td>
							<td width="60%"><?= $mdealer->dealer_name_e ?></td>
                                       
                                    </tr>
                                    <tr>
										<td>Address</td>
										<td >:</td>
										<td class="table2"><?= $mdealer->address_e ?></td>
                                    
                                    </tr>
                                    <tr>
										<td>Mobile No</td>
										<td >:</td>
                                        <td class="table2"><?= $mdealer->mobile_no ?></td>
                                    </tr>

                                    <tr>
										<td>Order No</td>
										<td>:</td>
										<td><?= $chalan_info->do_no ?></td>
                                     
                                    </tr>
                                    <tr>
								<td>Order Date:</td>
								<td>:</td>
								<td><?= $chalan_info->do_date ?></td>
                                       <?php /*?> <td class="table2">Chalan No: <?= $chalan_no ?></td><?php */?>
                                    </tr>
                                    <tr>
										<td class="table2">Challan Date </td>
										<td>:</td>
										<td><?= $chalan_info->chalan_date ?></td>
                                       
                                    </tr>



                                </thead>
                            </table>
                        </div>







                        <!-- Dealer Details -->
                        

                        <!-- Chalan Table -->
                       <div class="table-responsive mt-4">
						<table class="table  text-center  mb-4 table-bordered shadow-l bds table1" style="overflow: hidden; margin:0px;">
						<thead class="th1">
						<tr class="bg-night-light text-center">
                                        <th scope="col" class="color-white">SL</th>
                                        <th scope="col" class="color-white">Product Code</th>
                                        <th scope="col" class="color-white">Product</th>
                      
                                        <th style="display: none;" scope="col" class="color-white">Offer%</th>
                                        <th style="display: none;" scope="col" class="color-white">NSP</th>
                                        <th scope="col" class="color-white">Qty</th>
										<th scope="col" class="color-white">TP</th>
                                        <th scope="col" class="color-white">TP Total</th>
                                        <th style="display: none;" scope="col" class="color-white">NSP Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT c.*, i.*, c.nsp_per AS nsp, c.t_price AS tp 
                                FROM ss_do_chalan c, item_info i 
                                WHERE i.item_id=c.item_id AND c.chalan_no='" . $chalan_no . "'";
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
                                            <td  ><?= $sl++ ?></td>
                                            <td style="text-align:left;"><?= $row->finish_goods_code ?></td>
                                            <td style="text-align:left;"><?= $row->item_name ?></td>
                                            
                                            <td style="display: none;"><?= number_format($row->nsp, 2) ?></td>
                                            <td style="display: none;"><?= number_format($row->unit_price, 2) ?></td>
                                            <td><?= $row->total_unit ?></td>
											<td><?= number_format($row->tp, 2) ?></td>
                                            <td><?= number_format($tptotal, 2) ?></td>
                                            <td style="display: none;"><?= number_format($total, 2) ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="3"  style="text-align:right;"><strong>Total</strong></td>
                                        <td><strong><?= $gqty ?></strong></td>
                                        <td><strong><?= number_format($final_tpamount, 2) ?></strong></td>
                                        <td><strong><?= number_format($tptotal, 2) ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
						<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-end">
<table class="footer-table table-bordered table1 tttt mt-3">
    <tr>
        <td class="fw-bold"><strong>Total TP Amount</strong></td>
        <td><?= number_format($tptotal, 2); ?></td>
    </tr>
    <tr>
				<td>Discount Amount</td>
				<td align="center"><?= number_format($final_tpamount - $final_amount, 2); ?></td>
			</tr>
    <tr class="fds">
				<td>Net Payable Amount</td>
				<td align="center"><?= number_format($final_amount, 2); ?></td>
			</tr>
</table>
</div>
						<div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-start">
<p class="p mb-1"><strong>In Words : </strong>
		<strong><?php
$currency_type = 'taka'; // Set this to 'taka' or 'dollar' based on user input

$scs =  $final_amount;
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
              <!--  </div>-->

                <!-- Signatures -->
                <div style=" width:100% !important;">
				<!--<div class="footer w-100" style="zoom: 50%; width:100% !important; position: fixed; bottom: 0px;">-->
                <div class="row text-center" style="margin-top: 60px;">
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
        </div>
		<br /><br /><br /><br /><br />
    </div>
	

</div>

<?php
require_once '../assets/template/inc.footer.php';
?>