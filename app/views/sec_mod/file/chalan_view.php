<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

include '../config/function.php';
$user_id	=$_SESSION['user_id'];

$page="home";
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Secondary Sales</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!--<link rel="manifest" href="manifest.json" />-->

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="assets/img/favicon180.png" sizes="180x180">
    <link rel="icon" href="assets/img/favicon32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="assets/img/favicon16.png" sizes="16x16" type="image/png">

    <!-- Google fonts-->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- nouislider CSS -->
    <link href="assets/vendor/nouislider/nouislider.min.css" rel="stylesheet">

    <!-- date rage picker -->
    <link rel="stylesheet" href="assets/vendor/daterangepicker/daterangepicker.css">

    <!-- swiper carousel css -->
    <link rel="stylesheet" href="assets/vendor/swiperjs-6.6.2/swiper-bundle.min.css">

    <!-- style css for this template -->
    <link href="assets/scss/style.css" rel="stylesheet" id="style">
</head>

<body class="body-scroll theme-pink" data-page="shop">



<?
if($_GET['v']>0){

$chalan_no = $_GET['v'];
$chalan_info    = findall("select * from ss_do_chalan where chalan_no='".$chalan_no."' limit 1"); 
$dealer_code    = $chalan_info->dealer_code;
$dealer         = findall("select * from ss_shop where dealer_code='".$dealer_code."'");

$chalan_amount = find1("select sum(total_amt) from ss_do_chalan where chalan_no='".$chalan_no."'");

$master_dealer  = $dealer->master_dealer_code;
$mdealer = findall("select * from dealer_info where dealer_code='".$master_dealer."'");

}

?>

        <!-- main page content -->
        <div class="content-wrapper" style="padding-left: 30px;">
            <!-- Biling -->
<center>
<!--<img src="assets/img/mep_logo.jpeg" width="150px"/>-->
<div>
<h4><?=$mdealer->dealer_name_e?></h4>
<h6><?=$mdealer->address_e?></h6>
<span><?=$mdealer->mobile_no?></span><br>
<span class="">Authorized Distributor of </span>

</div>
</center>
<br>
<?


?>
            <div class="row mb-3">
                <div class="col align-self-center">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <div class="row">
                                <center><span style="font-size:20px;">Invoice</span></center>
                                
                                <div class="col-auto">
                                    <h6 class="mb-1">Chalan No #<?php echo $chalan_no?></h6>
                                    <p>Order NO #<?php echo $chalan_info->do_no;?></p>
                                </div>
                                <div class="col text-end">
                                    <h6 class="mb-1"><i class="bi bi-check-circle"></i> Chalan Date</h6>
                                    <p><b><?php echo $chalan_info->chalan_date;?></b></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!--<div class="col-12 col-md-6 mb-4">-->
                                <!--    <p class="mb-2">Sold By:</p>-->
                                <!--    <p class="text-secondary">Z,-->
                                <!--        <br>full address,<br>Dhaka -1000-->
                                <!--    </p>-->
                                <!--</div>-->
                                <div class="col-12 col-md-6">
                                    <!--<p class="mb-2"></p>-->
                                    <p class="text-secondary">Code: <?php echo $dealer->dealer_code;?> - <?php echo $dealer->shop_name;?></p>
                                    <p class="text-secondary"><?php echo $dealer->shop_address;?></p>
                                    <p class="text-secondary">Mobile: <?php echo $dealer->mobile;?></p>
                                    
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>

           
           
           
           
           
           
           
<!-- products -->
<div class="row mb-2">
                
<div class="container">           
  <table class="table table-sm table-bordered" width="100%" border="1" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
			<th>SL</th>
			<th class="text-left">Product Code</th>
			<th class="text-left">Product</th>
			<th class="text-left">TP</th>
			<th class="text-left">Offer%</th>
			<th class="text-left">NSP</th>
			<th class="text-left">Qty</th>
			<th class="text-left">TP TOTAL</th>
			<th class="text-left">NSP TOTAL</th>
      </tr>
    </thead>
    <tbody>
<?php 
$sql="select c.*,i.*,c.nsp_per as nsp,c.t_price as tp 
from ss_do_chalan c,item_info i 
where i.item_id=c.item_id and c.chalan_no='".$chalan_no."'   ";
$query=mysqli_query($conn,$sql);
$sl=1;
while($row=mysqli_fetch_object($query)){
?>			 
	<tr>
		<td class="no"><?php echo $sl++?></td>
		<td class="text-left"><?php echo $row->finish_goods_code?></td>
		<td class="text-left"><?php echo $row->item_name?></td>
		<td class="unit"><?php echo number_format($row->tp,2)?></td>
		<td class="unit"><?php echo number_format($row->nsp,2)?></td>
		<td class="unit"><?php echo number_format($row->unit_price,2)?></td>
		<td class="qty"><?php echo $row->total_unit; $gqty+=$row->total_unit;?></td>
		<td class="total"><?php $tptotal = $row->total_tp; echo $tptotal; $final_tpamount +=$tptotal;?></td>
		<td class="total"><?php $total = ($row->unit_price*$row->total_unit); echo $total; $final_amount +=$total;?></td>
	</tr>
<?php } ?>
	<tr>
	  
	  <td class="no">&nbsp;</td>
	  <td class="no">&nbsp;</td>
	  <td class="no">&nbsp;</td>
	  <td class="text-left">&nbsp;</td>
	  <td class="unit">&nbsp;</td>
	  <td class="qty">Total</td>
	  <td class="total"><strong><?php echo $gqty?></strong></td>
	  <td class="total"><strong><?php echo $final_tpamount?></strong></td>
	  <td class="total"><strong><?php echo $final_amount?></strong></td>
	  </tr>
    </tbody>
  </table>


</div>               
                
          
</div>


<p><br><br><p>
<div class="row"> 
    <div class="col-4">FO Signature</div>
    <div class="col-4">Customer Signature</div>
    <div class="col-4">Distributor Signature</div>
</div> 

            <!-- pricing -->
            <!--<div class="row mb-4">
                <div class="col align-self-center">
                    <h6 class="title">Pricing</h6>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <p>Shipping Cost</p>
                </div>
                <div class="col-auto">$ 10.00</div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <p>Subtotal</p>
                </div>
                <div class="col-auto">$ 32.00</div>
            </div>

            <div class="row mb-3 text-success">
                <div class="col">
                    <p>Discount</p>
                </div>
                <div class="col-auto">$ 89.00</div>
            </div>-->

<p>



        </div>
        <!-- main page content ends -->
  
  

    </main>
    <!-- Page ends-->

<!-- Footer -->

    <!-- Required jquery and libraries -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/vendor/bootstrap-5/js/bootstrap.bundle.min.js"></script>

    <!-- Customized jquery file  -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/color-scheme.js"></script>

    <!-- Chart js script -->
    <script src="assets/vendor/chart-js-3.3.1/chart.min.js"></script>

    <!-- Progress circle js script -->
    <script src="assets/vendor/progressbar-js/progressbar.min.js"></script>

    <!-- swiper js script -->
    <script src="assets/vendor/swiperjs-6.6.2/swiper-bundle.min.js"></script>

    <!-- daterange picker script -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="assets/vendor/daterangepicker/daterangepicker.js"></script>

    <!-- nouislider js -->
    <!--<script src="assets/vendor/nouislider/nouislider.min.js"></script>-->

    <!-- PWA app service registration and works -->
    <!--<script src="assets/js/pwa-services.js"></script>-->

    <!-- page level custom script -->
    <script src="assets/js/app.js"></script>
<?php include "inc/footer.php"; ?>
</body>

</html>