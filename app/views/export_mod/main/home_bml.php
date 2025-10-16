<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$table_master='wo_requisition_master';
$unique_master='req_no';
$$unique_master=$_SESSION[$unique_master];
//$target_url = '../main/dashboard_new.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$ssql = "select sum(total_amt) as tot_amt from sale_do_details where status = 'COMPLETED'";
$sq = db_query($ssql);
$result1 = mysqli_fetch_object($sq);
$sum_reg_sale = $result1->tot_amt;
$ssql2 = "select sum(total_amt) as tot_amt from sale_pos_details, sale_pos_master where sale_pos_master.pos_id = sale_pos_details.pos_id and sale_pos_master.status ='COMPLETED'";
$sq2 = db_query($ssql2);
$result2 = mysqli_fetch_object($sq2);
$sum_pos_sale = $result2->tot_amt;
$total_sale = ($sum_reg_sale+$sum_pos_sale);
$first_percentage = (100 / $total_sale)*$sum_reg_sale;
$second_percentage = (100/ $total_sale)*$sum_pos_sale;
//last 5 sales

$all_sql = "select sdm.do_no, sdm.do_date, d.dealer_name_e, sum(sdd.total_amt) as tot_amt, sdm.status from sale_do_master sdm, dealer_info d, sale_do_details sdd where sdm.dealer_code = d.dealer_code and sdd.do_no = sdm.do_no group by sdm.do_no order by do_no desc limit 0,5";

$all_query = db_query($all_sql);

while($datas = mysqli_fetch_assoc($all_query)){
	extract($datas);
	$dd['do_no'][] = $do_no;
	$dd['do_date'][] = $do_date;
	$dd['dealer_name'][]= $dealer_name_e;
	$dd['tot_amt'][] = $tot_amt;
	$dd['status'][] = $status;
	}

$all_sql2 = " select sale_pos_master.pos_id, sale_pos_master.pos_date, dealer_info.dealer_name_e, sum(sale_pos_details.total_amt) as tot_amt, sale_pos_master.status from sale_pos_master, sale_pos_details, dealer_info where sale_pos_master.pos_id = sale_pos_details.pos_id and sale_pos_master.dealer_id = dealer_info.dealer_code group by sale_pos_master.pos_id order by sale_pos_master.pos_id desc limit 0,5";

$all_query2 = db_query($all_sql2);

while($datas2 = mysqli_fetch_assoc($all_query2)){
	extract($datas2);
	$d['pos_id'][] = $pos_id;
	$d['pos_date'][] = $pos_date;
	$d['dealer_name'][]= $dealer_name_e;
	$d['tot_amt'][] = $tot_amt;
	$d['status'][] = $status;
	}
$link = $_SERVER['PHP_SELF'];

if(strpos($link, "sales_mod")==true){
$title = "Sales Module || Cloud ERP";
	}
?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from designreset.com/cork/ltr/demo3/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Mar 2020 08:10:15 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
<title><?=$title?></title>
<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
<script src="assets/js/loader.js"></script>

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
<link href="assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
<link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
<script>
window.onload = function () {

var options = {
	animationEnabled: false,
	data: [{
		type: "pie",
		startAngle: 40,
		toolTipContent: "<b>{label}</b>: {y}%",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 12,
		indexLabel: "{label} - {y}%",
		dataPoints: [
			{ y: <?=number_format($first_percentage, 2)?>, label: "Regular Sale" },
			{ y: <?=number_format($second_percentage, 2)?>, label: "POS Sale" },
		]
	}]
};
$("#chartContainer").CanvasJSChart(options);
$(".canvasjs-chart-credit").remove();
}
</script>
</head>

<div class="main-container" id="container"> 
  
  <!--  BEGIN SIDEBAR  --> 
  
  <!--  END SIDEBAR  -->
  
  <div id="content" class="main-content">
    <div class="layout-px-spacing">
      <div class="row layout-top-spacing">
        <div class="col-sm-6 col-xs-12 layout-spacing">
          <div class="widget widget-one">
            <div class="widget-heading">
              <h6 class="">Sales</h6>
            </div>
            <div class="w-chart">
              <div class="w-chart-section">
                <div class="w-detail">
                  <p class="w-title">Regular Sale</p>
                  <p class="w-stats">
                    <?=number_format($sum_reg_sale, 2)?>
                  </p>
                </div>
              </div>
              <div class="w-chart-section">
                <div class="w-detail">
                  <p class="w-title">POS Sale</p>
                  <p class="w-stats">
                    <?=number_format($sum_pos_sale, 2)?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-xs-12">
          <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        </div>
        <br>
        <div class="col-sm-12 col-xl-12 layout-spacing">
          <div class="widget widget-table-two">
            <div class="widget-heading">
              <h5 class="">Regular Sale</h5>
            </div>
            <div class="widget-content">
              <div class="table-responsive">
                <table class="table" >
                  <thead>
                    <tr>
                      <th><div class="th-content">SL</div></th>
                      <th><div class="th-content">Do No</div></th>
                      <th><div class="th-content">Do Date</div></th>
                      <th><div class="th-content">Dealer Name</div></th>
                      <th><div class="th-content">Total Amount</div></th>
                      <th><div class="th-content">Status</div></th>
                      <th><div class="th-content">Action</div></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
   $r= 0;
   foreach($dd['do_no'] as $key=>$do){
   $r++; 	  
   ?>
                    <tr>
                      <td><div class="td-content">
                          <?=$r?>
                        </div></td>
                      <td><div class="td-content">
                          <?=$do?>
                        </div></td>
                      <td><div class="td-content">
                          <?=$dd['do_date'][$key]?>
                        </div></td>
                      <td><div class="td-content">
                          <?=$dd['dealer_name'][$key]?>
                        </div></td>
                      <td><div class="td-content">
                          <?=$dd['tot_amt'][$key]?>
                        </div></td>
                      <td><div class="td-content">
                          <?=$dd['status'][$key]?>
                        </div></td>
                      <td><div class="td-content"><a href="../../pages/report/do_view.php?v_no=<?=$do?>" target="_blank" class="btn btn-danger">
                          <div class="card-like">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg><span>Open</span></div>
                          </a></div></td>
                    </tr>
                    <?php
   }
   ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div class="col-sm-12 col-xl-12 layout-spacing">
          <div class="widget widget-table-two">
            <div class="widget-heading">
              <h5 class="">POS Sale</h5>
            </div>
            <div class="widget-content">
              <div class="table-responsive">
                <table class="table">
                <thead>
                <tr>
   <th><div class="th-content">SL</div></th><th><div class="th-content">POS ID</div></th><th><div class="th-content">POS Date</div></th><th><div class="th-content">Customer Name</div></th><th><div class="th-content">Total Amount</div></th><th><div class="th-content">Status</div></th>
   </tr>
                </thead>
   <tbody>
   <?php
   $t = 0;
   foreach($d['pos_id'] as $key=>$pi){
   $t++  
   ?>
   <tr>
   <td><div class="td-content"><?=$t++?></div></td><td><div class="td-content"><?=$pi?></div></td><td><div class="td-content"><?=$d['pos_date'][$key]?></div></td><td><div class="td-content"><?=$d['dealer_name'][$key]?></div></td><td><div class="td-content"><?=$d['tot_amt'][$key]?></div></td><td><div class="td-content"><?=$d['status'][$key]?></div></td>
   </tr>
   <?php
   }
   ?>
   </tbody>
   </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!--  BEGIN CONTENT AREA  --> 
  
  <!--  END CONTENT AREA  --> 
  
</div>

<!-- BEGIN GLOBAL MANDATORY SCRIPTS --> 
<script src="assets/js/libs/jquery-3.1.1.min.js"></script> 
<script src="bootstrap/js/popper.min.js"></script> 
<script src="bootstrap/js/bootstrap.min.js"></script> 
<script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script> 
<script src="assets/js/app.js"></script> 
<script>
        $(document).ready(function() {
            App.init();
        });
    </script> 
<script src="assets/js/custom.js"></script> 
<!-- END GLOBAL MANDATORY SCRIPTS --> 

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS --> 
<script src="plugins/apex/apexcharts.min.js"></script> 
<script src="assets/js/dashboard/dash_1.js"></script> 
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS --> 

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS --> 
<script src="plugins/apex/apexcharts.min.js"></script> 
<script src="assets/js/dashboard/dash_2.js"></script> 
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS --> 

<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script> 
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
