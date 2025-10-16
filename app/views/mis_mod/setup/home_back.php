<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = "Sales Management Dashboard";

 $today = date('Y-m-d');
 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
 $cur = '&#x9f3;';
 
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
  	height: 400px;
  
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
		  
		
				

				
								
				<!--4th Monthly seals report chart-->	
				<div class="col-lg-12 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">Last 7 Days Action Chart </h4>
						</div>
						<div class="card-header">
								<div id="reportPage">
									<canvas id="onemounth"></canvas>
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
<?
$cDate=date('Y-m-d');
$fDate=date('Y-m-d', strtotime($Date. ' - 7 days'));

$currentDate = strtotime($fDate);
$endDate = strtotime($cDate);

$ccon='[';
$i=0;
while ($currentDate <= $endDate) {
if($i==0 ){
 $ccon.='"'.date('D', $currentDate).'"';
}else{
  $ccon.=',"'.date('D', $currentDate).'"';
  }
  ++$i;
  
  $currentDate = strtotime('+1 day', $currentDate);

}
$ccon.= ']';


///////
$currentDate = strtotime($fDate);
$endDate = strtotime($cDate);


 $uSql='select user_id,access_date,count(id) as ualno from user_action_log action_log 

where access_date between "'.date("Y-m-d",$currentDate).'" and "'.date("Y-m-d",$endDate).'" group by user_id,access_date';
$uQuery=db_query($uSql);
while($uRow=mysqli_fetch_object($uQuery)){


$userData[$uRow->user_id][$uRow->access_date]=$uRow->ualno;


}

if($userData[10001]["2023-08-11"]==''){
echo "//0";
}
echo "<br>";


$dcon="[";
 $f=0;

while($currentDate <= $endDate){





 $lol='select user_id,access_date from user_action_log where access_date="'.date("Y-m-d",$currentDate).'" group by user_id,access_date';
$lolqu=db_query($lol);
$ccvf=1;
while($lolData=mysqli_fetch_object($lolqu)){

 $lolData->user_id."-->".date("Y-m-d",$currentDate)."===".$userData[$lolData->user_id][date("Y-m-d",$currentDate)]."<br>";



//if($dData[$lolData->user_id][date("D",$currentDate)]=="Fri"){
//
//$ac[$lolData->user_id].=",0";
//}

$ac[$lolData->user_id].=",".$userData[$lolData->user_id][date("Y-m-d",$currentDate)];

}


 $acSql='select access_date,count(id) as dayentry from user_action_log where access_date = "'.date("Y-m-d",$currentDate).'" ';
 $acQuery=db_query($acSql);

 while($acRow=mysqli_fetch_object($acQuery)){
 if($f==0){
 $dcon.=$acRow->dayentry;
 }else{
 $dcon.=",".$acRow->dayentry;
 }
 ++$f;
 }
 
  $currentDate = strtotime('+1 day', $currentDate);

}


 $dcon.="]";
 
 echo $vc="[".ltrim($ac[10001],",")."]";
 
 
 $adate = strtotime($fDate);
$bdate = strtotime($cDate);
 ?>


 <!--///////////////////////////////////////////chart start values ////////////////////////////////////////////////////////////////-->

<script type="text/javascript">

 <!--/////////////4rd one Yarly seals Bar chart//////////////////-->
function oneYearChart(){


var ctx = document.getElementById("onemounth").getContext('2d');

var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?=$ccon?>,
        datasets: [{
            label: 'Action Log', // Name the series
            data: <?=$dcon?>, // Specify the data values array
            fill: false,
            borderColor: '#2196f3', // Add custom color border (Line)
            backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
            borderWidth: 2 // Specify bar border width
        },
		
		<?
		 $fql='select user_id from user_action_log where access_date between "'.date("Y-m-d",$adate).'" and "'.date("Y-m-d",$bdate).'" group by user_id';
		$fry=db_query($fql);
		while($vv=mysqli_fetch_object($fry)){
		?>
		
                  {
            label: "<?=find_a_field('user_activity_management','username','user_id="'.$vv->user_id.'"')?>", // Name the series
            data: <?="[".ltrim($ac[$vv->user_id],",")."]"?>, // Specify the data values array
            fill: false,
            borderColor: '#4CAF50', // Add custom color border (Line)
            backgroundColor: '#4CAF50', // Add custom color background (Points and Fill)
            borderWidth: 1 // Specify bar border width
        },
		
	<? }?>	
		
		
		
		
		]
    },
    options: {
      responsive: true, // Instruct chart js to respond nicely.
      maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
    }
});
}



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


window.onload = setTimeout(oneYearChart, 4000);



</script>


   
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>