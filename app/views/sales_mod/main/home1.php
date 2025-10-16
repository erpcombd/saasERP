<?php
require_once "../../../controllers/routing/default_values.php"; 
require_once "../../../controllers/routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";
$title = "Target Vs Sales Dashboard";
 $today = date('Y-m-d');
 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
 $last30days = 	date("Y-m-d", strtotime("-30 days", strtotime($today)));
 $cur = '&#x9f3;';
 $tr_type="show";
 $tr_from="Sales";
?>


<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>


  <script src="../../../dashboard_assets/morris/morris.min.js" type="text/javascript"></script>
  <script src=""></script>
  <link rel="stylesheet" href="../../../dashboard_assets/morris/morris.css"/>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from designreset.com/cork/ltr/demo3/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Mar 2020 08:10:15 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>  </title>
   <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../../../dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  
<style>
  #onemounth{
  	height: 268px;
  
  }
  @media(max-width: 1200px) {
	  #onemounth{
		    height: 212px;
	  }
   }
   
     @media(max-width: 1400px) {
	  #onemounth{
		    height: 212px;
	  }
   }
   
   @media(max-width: 1500px) {
	  #onemounth{
		    height: 357px;
	  }
   }
  
  
  </style>

</head>



<div class="content">
        <div class="container-fluid">




        <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid orange;">

                <div class="card-header card-header-warning card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-chart-pie"></i>

                  </div>

                  <p class="card-category"> Last Month </p>

                  <h3 class="card-title font-siz">
				  
				  <!--<span id="sales7day" class="loader">Checking..</span>-->
				  <span id="sales30days" class="loader">Checking..</span>

				  </h3>
                    <small></small>

                  </h3>

                </div>

               <div class="card-footer" style="border-top:1px solid orange">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold">LAST MONTH SALES</h5>

                  </div>

                </div>

              </div>

            </div>





            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid green;">

                <div class="card-header card-header-success card-header-icon">

                  <div class="card-icon p-0">

                   <i class="fas fa-donate"></i>

                  </div>

                  <p class="card-category">  Last Month </p>

                  <h3 class="card-title font-siz">
                    <!--<span id="possales7day" class="loader">Checking..</span>-->
					<span id="sale30target" class="loader">Checking..</span>
					
                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid green">

                  <div class="stats m-0"><h5 class="m-0 font-weight-bold">LAST MONTH TARGET</h5></div>

                </div>
              </div>
            </div>




            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid red;">

                <div class="card-header card-header-danger card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-hand-holding-usd"></i>

                  </div>

                  <p class="card-category"> This Month </p>

                  <h3 class="card-title font-siz">
                  <!-- <span id="localsales7day" class="loader">Checking..</span>-->
				   <span id="thismonthsales" class="loader">Checking..</span>
				   
                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid red">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold">THIS MONTH SALES</h5>
                  </div>
                </div>
              </div>
            </div>





            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid #1ec1d5;">

                <div class="card-header card-header-info card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-chart-pie"></i>

                  </div>

                  <p class="card-category">This Month </p>

                  <h3 class="card-title font-siz">
                    <!--<small>৳</small>--> 
                   <!-- <span id="salesReturn" class="loader">Checking..</span>-->
					<span id="thismonthtarget" class="loader">Checking..</span>
                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid #1ec1d5">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold">THIS MONTH TARGET</h5>

                  </div>
                </div>
              </div>
            </div>



          </div>












		 <div class="row">
<!--		  <div class="col-lg-3 col-md-6 col-sm-6">-->
			
			
						
						
			<!--<div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card">
                <div class="card-header card-header-warning">
                  <div class="card-icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
				  <b class="card-category" style="color:#FFFFFF; text-align:center; padding:0px;">TOTAL</b>
                  <p class="card-category" style="color:#FFFFFF">ORDER TODAY</p>
                  <h3 class="card-title"> <small> </small>
				  	<?=find_a_field('sale_do_master','count(do_no)','do_date="'.date('Y-m-d').'"');?>
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>-->
			
				
			
			
			
			
			<!--<div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card">
                <div class="card-header card-header-success">
                  <div class="card-icon">
                    <i class="fas fa-file-export"></i>
                  </div>
				  <b class="card-category" style="color:#FFFFFF; text-align:center; padding:0px;">TOTAL</b>
                  <p class="card-category" style="color:#FFFFFF">ORDER VALUE</p>
                  <h3 class="card-title"> <small> </small>
				  	0
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>-->
			

									
			<!--<div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card">
                <div class="card-header card-header-info">
                  <div class="card-icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
				  <b class="card-category" style="color:#FFFFFF; text-align:center; padding:0px;">DAILY SALES</b>
                  <p class="card-category" style="color:#FFFFFF"> increase in today</p>
                  <h3 class="card-title"> <small> 50</small>
				  	%
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>-->
			
			
			<!--<div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card">
                <div class="card-header card-header-danger">
                  <div class="card-icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
				  <b class="card-category" style="color:#FFFFFF; text-align:center; padding:0px;">BILL COLLECTED</b>
                  <p class="card-category" style="color:#FFFFFF">Increase in today</p>
                  <h3 class="card-title"> <small>40</small>
				  	%
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>-->
			
			</div>
			
			
			
			
					
			
			
			
			
			
		
		
          
    <!--      <div class="row">
            <div class="col-md-4">
              <div class="card card-chart">
                <div class="card-header card-header-success">
                  <div class="ct-chart" id="dailySalesChart"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Daily Sales</h4>
                  <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> Last 7 Days
                  </div>
                </div>
              </div>
            </div>
			
			
			
			
            <div class="col-md-4">
              <div class="card card-chart">
                <div class="card-header card-header-warning">
                  <div class="ct-chart" id="websiteViewsChart"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Bill Collected</h4>
                 <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 40% </span> increase in Collection.</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> Last 7 Days
                  </div>
                </div>
              </div>
            </div>
			
			
			
            <div class="col-md-4">
              <div class="card card-chart">
                <div class="card-header card-header-danger">
                  <div class="ct-chart" id="completedTasksChart"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Sales Return</h4>
                  <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> Increase in Sales Return.</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> Last 7 Days
                  </div>
                </div>
              </div>
            </div>
			
			
          </div>-->
		  
		  
		  
		  
		  
		  <div class="row">
		  
		  
		  <!--2nd Dealy seals reporte chart-->
				<div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title" style="TEXT-TRANSFORM: UPPERCASE;">Sales Vs Target LAST MONTH</h4>
						</div>
						<div class="card-header">
								<canvas id="oilChart" width="600" height="400"></canvas>
						</div>
					</div>
				</div>
								
				<!--4th Monthly seals report chart-->	
				<div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">SALES VS TARGET THIS YEAR </h4>
						</div>
						<div class="card-header">
								<div id="reportPage">
									<canvas id="onemounth"></canvas>
								</div>
						</div>
					</div>
				</div>
				
				<!--1st One yeare report chart-->
<!--			  <div class="col-lg-6 col-md-12">
				<div class="card card-chart">
					<div class="card-body">-->
					  	<!--<h4 class="card-title">ONE WEEK SALES CHART </h4>-->
	<!--				 	<p class="card-category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> increase. </p>-->
<!--					</div>
			
					<div class="card-header">
					  <canvas id="chart_0"></canvas>
					</div>
	
			   </div>
			</div>-->
			
			
			
							
				<!--3rd One yeare report chart-->	
<!--				<div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">LAST 3 YEAR SEALS REPORTS </h4>
						</div>
						<div class="card-header">
								<div id="reportPage">
									<canvas id="oneweek"></canvas>
								</div>
						</div>
					</div>
				</div>-->
			
			
			
				
				
				
				
				
				
				
				
				
				
				
				<!--5th Monthly seals report chart-->	
				<!--<div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">MONTHLY SEALS REPORTS </h4>
						</div>
						<div class="card-header">
								<div id="reportPage">
									<canvas id="acquisition"></canvas>
								</div>
						</div>
					</div>
				</div>-->
			
			
			
			
			
			
			
			

			
			<!--Last 5Client Inforamation Tabel -->
           <!--<div class="col-lg-6 col-md-12">
				<div class="card card-chart">
					<div class="card-body table-responsive">
						<h4 class="card-title text-center font-weight-bold">Last 5 Client Information</h4>
						 <p class="card-category text-center">Just Updated</p>
					  <table class="table table-hover table-striped">
						<thead class="bg-success text-light">
						  <th class="font-weight-bold">Code</th>
						  <th class="font-weight-bold">Dealer Name</th>
						  <th class="font-weight-bold">Contact</th>
						  <th class="font-weight-bold">Company</th>
						</thead>
						<tbody>
							<?php
							  $sl = 'select * from dealer_info where 1 order by dealer_code desc limit 5';
							  $qr = db_query($sl);
							  while($dt=mysqli_fetch_object($qr)){
							?>
						  <tr>
							<td><?=$dt->dealer_code?></td>
							<td><?=$dt->dealer_name_e?></td>
							<td><?=$dt->moile_no?></td>
							<td><?=$dt->propritor_name_e?></td>
						  </tr>
						 <? } ?>
						</tbody>
					  </table>
					</div>
				  </div>
				  
				</div>-->
				
				
				

				


				
			  </div>
		  </div>
        </div>
			
			
			<!--</div>-->
		  
		  
		  
<input type="hidden" id="tSalesChart" value="0">
<input type="hidden" id="trSalesChart" value="0">
<input type="hidden" id="lSalesChart" value="0">
<input type="hidden" id="salesReturnChart" value="0">

<input type="hidden" name="hSat" id="hSat" value="">
<input type="hidden" id="hSun" value="">
<input type="hidden" id="hMon" value="">
<input type="hidden" id="hTue" value="">
<input type="hidden" id="hWed" value="">
<input type="hidden" id="hThu" value="">
<input type="hidden" id="hFri" value="">

<input type="hidden" id="sjan" />
<input type="hidden" id="sfeb" />
<input type="hidden" id="smar" />
<input type="hidden" id="sapr" />
<input type="hidden" id="smay" />
<input type="hidden" id="sjun" />
<input type="hidden" id="sjul" />
<input type="hidden" id="saug" />
<input type="hidden" id="ssept" />
<input type="hidden" id="soct" />
<input type="hidden" id="snov" />
<input type="hidden" id="sdec" />

<input type="hidden" id="srjan" />
<input type="hidden" id="srfeb" />
<input type="hidden" id="srmar" />
<input type="hidden" id="srapr" />
<input type="hidden" id="srmay" />
<input type="hidden" id="srjun" />
<input type="hidden" id="srjul" />
<input type="hidden" id="sraug" />
<input type="hidden" id="srsept" />
<input type="hidden" id="sroct" />
<input type="hidden" id="srnov" />
<input type="hidden" id="srdec" />

<input type="hidden" id="cYear" value="">
<input type="hidden" id="oYear" value="">
<input type="hidden" id="ooYear" value="">

		



 <!--///////////////////////////////////////////chart start values ////////////////////////////////////////////////////////////////-->

<script type="text/javascript">

<!--///////////// 1st One Week report chart//////////////////-->
function salesBar(){
var hSat = document.getElementById('hSat').value;
var hSun = document.getElementById('hSun').value;
var hMon = document.getElementById('hMon').value;
var hTue = document.getElementById('hTue').value;
var hWed = document.getElementById('hWed').value;
var hThu = document.getElementById('hThu').value;
var hFri = document.getElementById('hFri').value;
var data = {
  labels: ["Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri"],
  datasets: [{
    label: "Sales #1",
    backgroundColor: "rgba(255,99,132,0.2)",
    borderColor: "rgba(255,99,132,1)",
    borderWidth: 2,
    hoverBackgroundColor: "rgba(255,99,132,0.4)",
    hoverBorderColor: "rgba(255,99,132,1)",
    data: [hSat, hSun, hMon, hTue, hWed, hThu, hFri],
  }]
};

var option = {
  scales: {
    yAxes: [{
      stacked: true,
      gridLines: {
        display: true,
        color: "rgba(255,99,132,0.2)"
      }
    }],
    xAxes: [{
      gridLines: {
        display: false
      }
    }]
  }
};

Chart.Bar('chart_0', {
  options: option,
  data: data
});
}





 <!--/////////////2rd One Week Report chart//////////////////-->
    function salesChartWeekly(){
	
	var tSalesChart = document.getElementById('tSalesChart').value;
	var trSalesChart = document.getElementById('trSalesChart').value;
    //var trSalesChart = document.getElementById('trSalesChart').value;
    //var lSalesChart = document.getElementById('lSalesChart').value;
    //var salesReturnChart = document.getElementById("salesReturnChart").value;
	var oilCanvas = document.getElementById("oilChart");

Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var oilData = {
    labels: [
        "Total Sales",
		"Target Sales"
        //"Pos Sales",
        //"Local Sales",
        //"Sales Return"
    ],
    datasets: [
        {
            data: [tSalesChart, trSalesChart],
            backgroundColor: [
				"#63FF84",
				"#FF6384"
                //"#63FF84",
                //"#84FF63",
                //"#8463FF"
            ]
        }]
		
};

var pieChart = new Chart(oilCanvas, {
  type: 'pie',
  data: oilData
});
}



 <!--/////////////3rd Last 4 year seals reports Bar chart//////////////////-->
 function threeYearChart(){
 var cYear = document.getElementById('cYear').value;
 var oYear = document.getElementById('oYear').value;
 var ooYear = document.getElementById('ooYear').value;
 var chartColors = {
  red: 'rgb(255, 99, 132)',
  orange: 'rgb(255, 159, 64)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgb(75, 192, 192)',
  blue: 'rgb(54, 162, 235)',
  purple: 'rgb(153, 102, 255)',
  grey: 'rgb(231,233,237)'
};

var data =  {
  labels: ["2022", "2021", "2020"],
  datasets: [{
    label: 'Seals',
    backgroundColor: [
      chartColors.red,
      chartColors.blue,
      chartColors.yellow],
	  
    /*data: [
      randomScalingFactor(), 
      randomScalingFactor(), 
      randomScalingFactor(), 
    ]*/
	data: [cYear,oYear,ooYear]
  }]
};

var myBar = new Chart(document.getElementById("oneweek"), {
  type: 'horizontalBar', 
  data: data, 
  options: {
    responsive: true,
    title: {
      display: false,
      text: "Last One week Sales"
    },
    tooltips: {
      mode: 'index',
      intersect: false
    },
    legend: {
      display: false,
    },
    scales: {
      xAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});
}





 <!--/////////////4rd one Yarly seals Bar chart//////////////////-->
function oneYearChart(){
var sjan = document.getElementById('sjan').value;
var sfeb = document.getElementById('sfeb').value;
var smar = document.getElementById('smar').value;
var sapr = document.getElementById('sapr').value;
var smay = document.getElementById('smay').value;
var sjun = document.getElementById('sjun').value;
var sjul = document.getElementById('sjul').value;
var saug = document.getElementById('saug').value;
var ssept = document.getElementById('ssept').value;
var soct = document.getElementById('soct').value;
var snov = document.getElementById('snov').value;
var sdec = document.getElementById('sdec').value;

var srjan = document.getElementById('srjan').value;
var srfeb = document.getElementById('srfeb').value;
var srmar = document.getElementById('srmar').value;
var srapr = document.getElementById('srapr').value;
var srmay = document.getElementById('srmay').value;
var srjun = document.getElementById('srjun').value;
var srjul = document.getElementById('srjul').value;
var sraug = document.getElementById('sraug').value;
var srsept = document.getElementById('srsept').value;
var sroct = document.getElementById('sroct').value;
var srnov = document.getElementById('srnov').value;
var srdec = document.getElementById('srdec').value;

var ctx = document.getElementById("onemounth").getContext('2d');

var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Jan",	"Feb",	"Mar",	"Apr",	"May",	"Jun",	"Jul", "Aug",	"Sep","Oct","Nov","Dec"],
        datasets: [{
            label: 'TOTAL SALES', // Name the series
            data: [sjan,	sfeb,	smar,	sapr,	smay,	sjun,	sjul,	saug,	ssept, soct, snov, sdec], // Specify the data values array
            fill: false,
            borderColor: '#2196f3', // Add custom color border (Line)
            backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
            borderWidth: 1 // Specify bar border width
        },
                  {
            label: 'TARGET SALES', // Name the series
            data: [srjan,	srfeb,	srmar,	srapr,	srmay,	srjun,	srjul,	sraug,	srsept, sroct,srnov,srdec], // Specify the data values array
            fill: false,
            borderColor: '#4CAF50', // Add custom color border (Line)
            backgroundColor: '#4CAF50', // Add custom color background (Points and Fill)
            borderWidth: 1 // Specify bar border width
        }]
    },
    options: {
      responsive: true, // Instruct chart js to respond nicely.
      maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
    }
});
}









 <!--/////////////5th Monthly seals Bar chart//////////////////-->
/*=========================================
User Acquisition
===========================================*/
var acquisition = document.getElementById('acquisition');

var acChart = new Chart(acquisition, {
    // The type of chart we want to create
    type: 'line',
    
    // The data for our dataset
    data: {
        labels: ["4 Jan", "5 Jan", "6 Jan", "7 Jan", "8 Jan", "9 Jan", "10 Jan"],
        datasets: [
        {
          label: "Referral",
          backgroundColor: 'rgb(76, 132, 255)',
          borderColor: 'rgba(76, 132, 255,0)',
          data: [78, 88, 68, 74, 50, 55, 25],
          lineTension: 0.3,
          pointBackgroundColor: 'rgba(76, 132, 255,0)',
          pointHoverBackgroundColor: 'rgba(76, 132, 255,1)',
          pointHoverRadius: 3,
          pointHitRadius: 30,
          pointBorderWidth: 2,
          pointStyle: 'rectRounded'
        },
          {
          label: "Direct",
          backgroundColor: 'rgb(254, 196, 0)',
          borderColor: 'rgba(254, 196, 0,0)',
          data: [88, 108, 78, 95, 65, 73, 42],
          lineTension: 0.3,
          pointBackgroundColor: 'rgba(254, 196, 0,0)',
          pointHoverBackgroundColor: 'rgba(254, 196, 0,1)',
          pointHoverRadius: 3,
          pointHitRadius: 30,
          pointBorderWidth: 2,
          pointStyle: 'rectRounded'
        },
          {
          label: "Social",
          backgroundColor: 'rgb(41, 204, 151)',
          borderColor: 'rgba(41, 204, 151,0)',
          data: [103, 125, 95, 110, 79, 92, 58],
          lineTension: 0.3,
          pointBackgroundColor: 'rgba(41, 204, 151,0)',
          pointHoverBackgroundColor: 'rgba(41, 204, 151,1)',
          pointHoverRadius: 3,
          pointHitRadius: 30,
          pointBorderWidth: 2,
          pointStyle: 'rectRounded'
        }
      ]
    },
    
    // Configuration options go here
    options: {
      legend: {
          display: false
       },
      
      scales: {
        xAxes: [{
          gridLines: {
            display:false
          }
        }],
        yAxes: [{
          gridLines: {
             display:true
          },
          ticks: {
             beginAtZero: true,
          },
       }]
     },
     tooltips: {
    }
  }
});
document.getElementById('customLegend').innerHTML = acChart.generateLegend();




  


</script>

<script>

function view_data(){
$.ajax({
url:"sales_dashboard_ajax1.php",
method:"POST",
dataType:"JSON",
//data:{ data_no:data_no },hSat, hSun, hMon, hTue, hWed, hThu, hFri
success: function(result, msg){
var res = result;
setTimeout(view_data, 5000);
//$("#sales7day").html(res[0]);
$("#sales30days").html(res[0]);
//$("#possales7day").html(res[1]); 
$("#sale30target").html(res[1]);
$("#thismonthsales").html(res[2]);
//$("#localsales7day").html(res[2]);

$("#thismonthtarget").html(res[3]);
//$("#salesReturn").html(res[3]);
$("#tSalesChart").val(res[4]);
$("#trSalesChart").val(res[5]);

$("#lSalesChart").val(res[6]);
$("#salesReturnChart").val(res[7]);

$("#hSat").val(res[8]);
$("#hSun").val(res[9]);
$("#hMon").val(res[10]);
$("#hTue").val(res[11]);
$("#hWed").val(res[12]);
$("#hThu").val(res[13]);
$("#hFri").val(res[14]);

$("#sjan").val(res[15]);
$("#sfeb").val(res[16]);
$("#smar").val(res[17]);
$("#sapr").val(res[18]);
$("#smay").val(res[19]);
$("#sjun").val(res[20]);
$("#sjul").val(res[21]);
$("#saug").val(res[22]);
$("#ssept").val(res[23]);
$("#soct").val(res[24]);
$("#snov").val(res[25]);
$("#sdec").val(res[26]);

$("#srjan").val(res[27]);
$("#srfeb").val(res[28]);
$("#srmar").val(res[29]);
$("#srapr").val(res[30]);
$("#srmay").val(res[31]);
$("#srjun").val(res[32]);
$("#srjul").val(res[22]);
$("#sraug").val(res[34]);
$("#srsept").val(res[35]);
$("#sroct").val(res[36]);
$("#srnov").val(res[37]);
$("#srdec").val(res[38]);

$("#cYear").val(res[39]);
$("#oYear").val(res[40]);
$("#ooYear").val(res[41]);

//$("#transferReceive").html(res[8]);
//$("#localSales").html(res[9]);
//$("#localPurchase").html(res[10]);


//
//$("#oilChartValue1").val(res[21]);
//$("#oilChartValue2").val(res[22]);
//$("#oilChartValue3").val(res[23]);
 

}
}); 
}
window.onload = setTimeout(view_data, 3000);
window.onload = setTimeout(salesChartWeekly, 4000);
window.onload = setTimeout(salesBar, 4000);
window.onload = setTimeout(oneYearChart, 4000);
window.onload = setTimeout(threeYearChart, 4000);


</script>


<?
require_once "../../../controllers/routing/layout.bottom.php";
?>