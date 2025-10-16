<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Managerial Dashboard";

require_once SERVER_CORE."routing/inc.notify.php";

 $today = date('Y-m-d');

 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));

 $cur = '&#x9f3;';

 

?>





<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>





  <script src="../../../dashboard_assets/morris/morris.min.js" type="text/javascript"></script>

  <script src=""></script>

  <link rel="stylesheet" href="../../../dashboard_assets/morris/morris.css"/>






  
  <!-- CSS Files -->
  <link href="../../../../../public/dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
<style type="text/css">
	/*new Deshbord css start*/
	.sr-main-content .pt-4{
	padding:0px !important;
	}
 	.card-title{
		text-align:left;
		font-size: 14px;
		color:#004085;
		margin: 0px;
	}
	
	.card-title span{
		font-weight: normal;
		color:#605d5d;
	}
	
	.bold{
		font-weight:bold;
	}
	
	.button-cs{
		padding:2px !important;
		font-size: 12px !important;
	}
	
	.new{
	    padding-left: 8px;
    	padding-right: 8px;
	}
	
	.new-icon{
	    width: 50px;
		height: 50px;
		background: #dfe9f3;
		border-radius: 50%;
		color: #007bff;
		text-align: center;
		padding: 12px;
    font-size: 18px;
		white-space: nowrap;
		overflow: hidden;
	}
	
	.primary{
	    background-color: whitesmoke !important;
    	color: #007bff !important;
	}
	
		
	.success{
	    background-color: #cfffcf !important;
    	color: #3cb514 !important;
	}
	
		
	.danger{
	    background-color: #ffe9eb !important;
    	color: #dc3545 !important;
	}
	
		
	.info{
	    background-color: #dbfaff !important;
    	color: #17a2b8 !important;
	}

	.warning{
		background-color: #fea2204f !important;
		color: #c8811f !important;
	}
	
	.bg-warning {
		background-color: #fb9006 !important;
	}
	
	button.bg-warning:hover{
		background-color: #fb9006 !important;	
	}
	
	.green-new{
		background-color: #008fa15c !important;
    	color: #17a2b8 !important;
	}
	
	.bg-green-new {
		background-color: #008fa1 !important;
	}
	button.bg-green-new:hover{
		background-color: #008fa1 !important;	
	}

	
	.purple-new{
		background-color: #5c31a45c !important;
    	color: #5c31a4 !important;
	}
	
	.bg-purple-new {
		background-color: #5c31a4 !important;
	}
	button.bg-purple-new:hover{
		background-color: #5c31a4 !important;	
	}
	
	.violet-new{
		background-color: #aa20ad4d  !important;
    	color: #aa20ad !important;
	}
	
	.bg-violet-new {
		background-color: #aa20ad !important;
	}
	button.bg-violet-new:hover{
		background-color: #aa20ad !important;	
	}

	.new-icon-text{
		padding-left: 10px;
		color: #333;
		font-size: 16px;
		padding-top: 3px;
	}
	
	.p-sub, .p-sub1{
	    margin: 0px;
	}
	
	.p-sub{
		color:#1a1972;
	}
	
	.p-sub1{
		font-size: 12px;
	}
	
	.p-sub1 span{
		font-weight:bold;
		color:#28a745;
	}
	
	.btn:hover, .a{
	color:#fff !important;
	}
	
	.new .card {
		margin: 15px 0px 0px 0px !important;
	}
	
	.card {
		margin: 0px !important;
	}
	
	/*new Deshbord css end*/

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
   @media (max-width: 768px) {
  .today-clock{
  display:none !important;  
  }
  }
  
</style>



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

  @import url('https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap');

  a{color: #fff;text-decoration: none}

  body{height: 100vh;background: #3e3232;font-family: 'Poppins', sans-sherif;display: flex;align-items: center;justify-content: center;color: #fff;overflow: hidden}

  .ticker{font-family: 'Tiro Bangla', serif;display: flex;flex-wrap: wrap;width: 100%;height: 50px;margin: 0 auto}.news{width: 80%;background: #cc4444;padding: 7px 2%}.title{width: 20%;text-align: center;background: #c81c1c;position: relative}.title:after{position: absolute;content: "";right: -18%;border-left: 20px solid #c81c1c;border-top: 28px solid transparent;border-right: 20px solid transparent;border-bottom: 21px solid transparent;top: 5px}.title h5{font-size: 18px;color:#FFFFFF;margin: 8% 0}.news marquee{font-size: 18px;margin-top: 12px}.news-content p{margin-right: 41px;display: inline;color:white}

  .blink {

                animation: blinker 1.5s linear infinite;

               font-family: 'Poppins', sans-sherif;

            }

            @keyframes blinker {

                50% {

                    opacity: 0;

                }

            }

  </style>



</head>







<div class="content">

        <div class="container-fluid">

<?php

$dcode=find_a_field('user_activity_management','vendor_code','user_id="'.$_SESSION['user']['id'].'"');

$ddate=date('Y-m-d');

 $sql='select * from vendor_notice where vendor_id="'.$dcode.'" and start_date<="'.$ddate.'" and end_date>="'.$ddate.'"';

 $query=db_query($sql);

 



 while($data=mysqli_fetch_object($query)){

 

 $not .="(".$data->notice.")";

 

 }

$exc=find_a_field('vendor_notice','count(vendor_id)','vendor_id="'.$dcode.'" and start_date<="'.$ddate.'" and end_date>="'.$ddate.'"');

if($exc>0){

?>



 <div class="ticker mb-4"> <div class="title"><h5>Notice</h5></div> <div class="news"> <marquee scrollamount="4" class="news-content blink"> <p><?=$not?></p> </marquee> </div> </div>

 

 <? }?>

        <div class="row">

	<?

	$exc1=find_a_field('vendor_message','count(vendor_id)','vendor_id="'.$dcode.'" and start_date<="'.$ddate.'" and end_date>="'.$ddate.'"');

	if($exc1>0){

	?>	

		<div class="col-lg-12 col-md-12">

				<div class="card card-chart">

					<div class="card-body">

					  	<h4 class="card-title">Message Board</h4>

	<!--				 	<p class="card-category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> increase. </p>-->

					</div>

			

					<div class="card-header">

	<?php

$dcode=find_a_field('user_activity_management','vendor_code','user_id="'.$_SESSION['user']['id'].'"');

$ddate=date('Y-m-d');

 $sql1='select * from vendor_message where vendor_id="'.$dcode.'" and start_date<="'.$ddate.'" and end_date>="'.$ddate.'"';

 $query1=db_query($sql1);

 while($data1=mysqli_fetch_object($query1)){

 

 $msge.=$data1->message."<br>";

 

 }

echo $msge;

?>				 

					</div>

	

			   </div>

			</div>

			

			<? }?>



            
			
		<div class="container-fluid">
			<div class="row m-0 p-0">
			
						
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						
						
						<div class="d-flex justify-content-center">
						<div class=""><img src="purchase_icon.png" height="60px" width="60px"></div>
						
						
						</div>
						<a href="../dashboard/purchase.php" class="d-flex justify-content-center " style="margin-top: 20px;">
							<button type="button" class="btn bg-primary button-cs"> <i class="fas fa-check-circle"></i>Purchase Dashboard</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
					  <div class="d-flex justify-content-center">
						<div class=""><img src="sale_icon.png" height="60px" width="60px"></div>
						
						</div>
						
						
						<a href="../dashboard/sales.php" class="d-flex justify-content-center " style="margin-top: 20px;">
							<button type="button" class="btn bg-success button-cs"> <i class="fas fa-check-circle"></i>Sales Dashboard</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<div class="d-flex justify-content-center">
						<div class=""><img src="warehouse_icon.png" height="60px" width="60px"></div>
						
						</div>
						
						<a href="../dashboard/warehouse.php" class="d-flex justify-content-center " style="margin-top: 20px;">
							<button type="button" class="btn bg-danger button-cs"> <i class="fas fa-check-circle"></i>Warehouse Dashboard</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<div class="d-flex justify-content-center">
						<div class=""><img src="accounts_icon.png" height="60px" width="60px"></div>
						
						</div>
						
						<a href="../dashboard/accounts.php" class="d-flex justify-content-center " style="margin-top: 20px;">
							<button type="button" class="btn bg-info button-cs"> <i class="fas fa-check-circle"></i> Accounts Dashboard</button>
						</a>
					  </div>
					</div>
				</div>
				
				
				
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<div class="d-flex justify-content-center">
						<div class=""><img src="warehouse_icon.png" height="60px" width="60px"></div>
						
						</div>
						
						<a href="../dashboard/production.php" class="d-flex justify-content-center " style="margin-top: 20px;">
							<button type="button" class="btn bg-info button-cs"> <i class="fas fa-check-circle"></i> Production Dashboard</button>
						</a>
					  </div>
					</div>
				</div>
				
				
				
			</div>
  
</div>











            









            











            







          </div>





		  

		  

		  

		  

		  

		  <div class="row">

		  

		  

		  <!--2nd Dealy seals reporte chart-->

				

				

				

				<!--1st One yeare report chart-->

			  

				



				

								

				<!--4th Monthly seals report chart-->	

				



			

			

							

				<!--3rd One yeare report chart-->	

				

			

			

			

				

				

				

				

				

				

				

				

				

				

				

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

	

	var mSalesChart = document.getElementById('mSalesChart').value;

    var pSalesChart = document.getElementById('pSalesChart').value;

    var lSalesChart = document.getElementById('lSalesChart').value;

    var salesReturnChart = document.getElementById("salesReturnChart").value;

	var oilCanvas = document.getElementById("oilChart");



Chart.defaults.global.defaultFontFamily = "Lato";

Chart.defaults.global.defaultFontSize = 18;



var oilData = {

    labels: [

        "Total Sales",

        "Pos Sales",

        "Local Sales",

        "Sales Return"

    ],

    datasets: [

        {

            data: [mSalesChart, pSalesChart, lSalesChart, salesReturnChart],

            backgroundColor: [

                "#FF6384",

                "#63FF84",

                "#84FF63",

                "#8463FF"

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

            label: 'Sales', // Name the series

            data: [sjan,	sfeb,	smar,	sapr,	smay,	sjun,	sjul,	saug,	ssept, soct, snov, sdec], // Specify the data values array

            fill: false,

            borderColor: '#2196f3', // Add custom color border (Line)

            backgroundColor: '#2196f3', // Add custom color background (Points and Fill)

            borderWidth: 1 // Specify bar border width

        },

                  {

            label: 'Sales Return', // Name the series

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



$("#mSalesChart").val(res[4]);

$("#pSalesChart").val(res[5]);

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