<?php
//session_start ();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";

//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
include '../config/function.php';
$menu         = 'Home';
$title='Dashboard';	

//include 'inc/header.php';
//include 'inc/sidebar.php';

$total_shop = find1("select count(*) from ss_shop");
?>  

<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="../../../dashboard_assets/morris/morris.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="../../../dashboard_assets/morris/morris.css"/>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>  </title>
   <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

  <!-- CSS Files -->
  <link href="../../../../../public/dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  
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

             <i class="fa-solid fa-bangladeshi-taka-sign" style="color: #ffffff;"></i>

                  </div>

                  <p class="card-category">30 Day</p>

                  <h3 class="card-title font-siz"><span id="sales7day" class="loader">4</span></h3>

                    <small></small>

                  </h3>

                </div>

               <div class="card-footer" style="border-top:1px solid orange">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold">Today's Sales VS Target</h5>

                  </div>

                </div>

              </div>

            </div>





            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid green;">

                <div class="card-header card-header-success card-header-icon">

                  <div class="card-icon p-0">

          <i class="fa-solid fa-chart-line" style="color: #ffffff;"></i>
                  </div>

                  <p class="card-category">30 Day</p>

                  <h3 class="card-title font-siz">
                    <span id="possales7day" class="loader">53%</span>
                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid green">

                  <div class="stats m-0"><h5 class="m-0 font-weight-bold">Total sale</h5></div>

                </div>
              </div>
            </div>




            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid red;">

                <div class="card-header card-header-danger card-header-icon">

                  <div class="card-icon p-0">

  <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                  </div>

                  <p class="card-category">30 DAy</p>

                  <h3 class="card-title font-siz">
                   <span id="localsales7day" class="loader"> 44</span>
                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid red">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold">Today's  Visited Shop</h5>
                  </div>
                </div>
              </div>
            </div>



            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid #1ec1d5;">

                <div class="card-header card-header-info card-header-icon">

                  <div class="card-icon p-0">
        <i class="fa-solid fa-shop" style="color: #ffffff;"></i>
                   </div>

                  <p class="card-category">30 Day</p>

                  <h3 class="card-title font-siz">
                    <!--<small>?</small>-->
                    <span id="salesReturn" class="loader">65</span>
                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid #1ec1d5">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold">Today's Ordered Shop</h5>

                  </div>
                </div>
              </div>
            </div>


          <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid red;">

                <div class="card-header card-header-primary card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-hand-holding-usd"></i>

                  </div>

                  <p class="card-category">30 DAy</p>

                  <h3 class="card-title font-siz">
                   <span id="localsales7day" class="loader"> 44</span>
                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid red">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold">Total shop</h5>
                  </div>
                </div>
              </div>
            </div>
			
			
			<div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid red;">

                <div class="card-header card-header-dark card-header-icon">

                  <div class="card-icon p-0">

<i class="fa-solid fa-users" style="color: #ffffff;"></i>
                  </div>

                  <p class="card-category">30 DAy</p>

                  <h3 class="card-title font-siz">
                   <span id="localsales7day" class="loader"> 75/5</span>
                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid black">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold">Total users (Active/Inactive)
</h5>
                  </div>
                </div>
              </div>
            </div>





          </div>




		  
		  
		  <div  class="row">
		  
		  <!--2nd Dealy seals reporte chart-->
				<div class="col-lg-6 col-md-12">  
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">Sales VS Target</h4>
						</div>
						<div class="card-header">
								<canvas id="oilChart" width="600" height="400"></canvas>
						</div>
					</div>

				</div>
				
				
				<!--1st One yeare report chart-->
			  <div class="col-lg-6 col-md-12">
				<div class="card card-chart"> 
					<div class="card-body">
					  	<h4 class="card-title">Last 7 Days Sales Report</h4>
	<!--				 	<p class="card-category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> increase. </p>-->
					</div>
			
					<div class="card-header">
					  <canvas id="chart_0"></canvas>
					</div>
	
			   </div>
			</div>
				

				
								
				<!--4th Monthly seals report chart-->	
				<div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">Monthly Sales VS Target Report</h4>
						</div>
						<div class="card-header">
								<div id="reportPage">
									<canvas id="onemounth"></canvas>
								</div>
						</div>
					</div>
				</div>

			
			
							
				<!--3rd One yeare report chart-->	
				<div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">Yearly Sales Vs Target Report</h4>
						</div>
						<div class="card-header">
								<div id="reportPage">
									<canvas id="oneweek"></canvas>
								</div>
						</div>
					</div>
				</div>
			
			
	
				
			  </div>
		  </div>
        </div>

<input type="hidden" id="mSalesChart" value="0">
<input type="hidden" id="pSalesChart" value="0">
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








<script type="text/javascript">

<!--///////////// 1st One Week report chart//////////////////-->
function salesBar(){
/*var hSat = document.getElementById('hSat').value;
var hSun = document.getElementById('hSun').value;
var hMon = document.getElementById('hMon').value;
var hTue = document.getElementById('hTue').value;
var hWed = document.getElementById('hWed').value;
var hThu = document.getElementById('hThu').value;
var hFri = document.getElementById('hFri').value;*/

var hSat = 1000;
var hSun = 1500;
var hMon = 2000;
var hTue = 2500;
var hWed = 3000;
var hThu = 3500;
var hFri = 4000;
var data = {
  labels: ["Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri"],
  datasets: [{
    label: "Sales",
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
	
//	var mSalesChart = document.getElementById('mSalesChart').value;
//    var pSalesChart = document.getElementById('pSalesChart').value;
	var mSalesChart = 300;
    var pSalesChart = 400;
	var oilCanvas = document.getElementById("oilChart");

Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var oilData = {
    labels: [
        "Sales",
        "Target"
        
    ],
    datasets: [
        {
            data: [mSalesChart, pSalesChart],
            backgroundColor: [
                "#FF6384",
                "#63FF84"
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
  labels: ["2024", "2023", "2022", "2021", "2020"],
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
            label: 'Sales', // Name the series
            data: [sjan,	sfeb,	smar,	sapr,	smay,	sjun,	sjul,	saug,	ssept, soct, snov, sdec], // Specify the data values array
            fill: false,
            borderColor: '#2196f3', // Add custom color border (Line)
            backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
            borderWidth: 1 // Specify bar border width
        },
                  {
            label: 'Target', // Name the series
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
url:"sales_dashboard_ajax.php",
method:"POST",
dataType:"JSON",
//data:{ data_no:data_no },hSat, hSun, hMon, hTue, hWed, hThu, hFri
success: function(result, msg){
var res = result;
setTimeout(view_data, 5000);
$("#sales7day").html(res[0]);
$("#possales7day").html(res[1]);
$("#localsales7day").html(res[2]);
$("#salesReturn").html(res[3]);


$("#mSalesChart").val('400');
$("#pSalesChart").val('500');
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

require_once SERVER_CORE."routing/layout.bottom.php";

?>