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
</style>
<div class="pt-5" style=" width:100% !important;">

    <!-- Content to Print -->
    <div id="print" style="width:100% !important;">
	    <!-- Button for Print -->
					<div class="row justify-content-between align-items-center mb-3 " style="width:100% !important;">
						<div class="col-md-4">
							<img src="../assets/images/logo/mepdemo.png" alt="Logo" class="logo">
						</div>

						<div class="col-md-4 text-end">
							<button id="printButton" onclick="window.print()" class="btn btn-print">Print</button>
						</div>
					</div>
        <!-- Dealer Info -->


        <div class="card card-style pt-2 m-0 p-3" style="zoom: 50%; width:100% !important;">
            <div class="content m-0 ms-2 me-2">
                <div class="card-header m-0 p-0">
                    <div class="row mb-0">

                        <!-- <div class="d-flex justify-content-center row mt-0"> -->

                        <!-- <center><span style="font-size:20px;"></span></center> -->

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







                        <!-- Dealer Details -->
                        <div class="card shadow-sm mt-4" style="margin-bottom: 21px;">

                        </div>

                        <!-- Chalan Table -->
                        <div class="table-responsive ">

                            <table class="table table-bordered text-center shadow-l table1" style="overflow: hidden;">
                                <thead class="th1">
                                    <tr class="bg-night-light text-center">
                                        <th scope="col" class="color-white">SL</th>
                                        <th scope="col" class="color-white">Product Code</th>
                                        <th scope="col" class="color-white">Product</th>
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
                                            <td><?= $sl++ ?></td>
                                            <td><?= $row->finish_goods_code ?></td>
                                            <td style="text-align:left;"><?= $row->item_name ?></td>
                                            <td><?= number_format($row->tp, 2) ?></td>
                                            <td><?= number_format($row->nsp, 2) ?></td>
                                            <td><?= number_format($row->unit_price, 2) ?></td>
                                            <td><?= $row->total_unit ?></td>
                                            <td><?= number_format($tptotal, 2) ?></td>
                                            <td><?= number_format($total, 2) ?></td>
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
                    </div>
                </div>

                <!-- Signatures -->
                <div class="row text-center mt-5">
                    <div class="col-md-4">
                        <strong>FO Signature</strong>
                    </div>
                    <div class="col-md-4">
                        <strong>Customer Signature</strong>
                    </div>
                    <div class="col-md-4">
                        <strong>Distributor Signature</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../assets/template/inc.footer.php';
?>