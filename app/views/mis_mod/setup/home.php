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

 $ronysql='select user_id from user_activity_management group by user_id';
$roneyQuery=db_query($ronysql);
while($ronData=mysqli_fetch_object($roneyQuery)){


for($j=$currentDate; $j<=$endDate;$j=$j+86400){

 $thisDate=date("Y-m-d", $j);

 $userData[$ronData->user_id][$thisDate]=0;


}


}

 $uSql='select user_id,access_date,count(id) as ualno from user_action_log action_log 

where access_date between "'.date("Y-m-d",$currentDate).'" and "'.date("Y-m-d",$endDate).'" group by user_id,access_date';
$uQuery=db_query($uSql);
while($uRow=mysqli_fetch_object($uQuery)){


$userData[$uRow->user_id][$uRow->access_date]=$uRow->ualno;


}


$dcon="[";
 $f=0;

for($j=$currentDate; $j<=$endDate;$j=$j+86400){

 $thisDate=date("Y-m-d", $j);



 $lol='select user_id from user_activity_management group by user_id';
$lolqu=db_query($lol);
$ccvf=1;
while($lolData=mysqli_fetch_object($lolqu)){

 //$lolData->user_id."-->".date("Y-m-d",$currentDate)."===".$userData[$lolData->user_id][date("Y-m-d",$currentDate)]."<br>";






if($userData[$lolData->user_id][$thisDate]==0){


$ac[$lolData->user_id] .= ",0";
}

else{
$ac[$lolData->user_id] .= ",".$userData[$lolData->user_id][$thisDate];
}

}


 $acSql='select access_date,count(id) as dayentry from user_action_log where access_date = "'.$thisDate.'" ';
 $acQuery=db_query($acSql);

 while($acRow=mysqli_fetch_object($acQuery)){
 if($f==0){
 $dcon.=$acRow->dayentry;
 }else{
 $dcon.=",".$acRow->dayentry;
 }
 ++$f;
 }
 
 // $currentDate = strtotime('+1 day', $currentDate);

}


 $dcon.="]";
 
 //echo $vc="[".ltrim($ac[10037],",")."]";
 

 
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
            borderWidth: 3 // Specify bar border width
        },
		
		<?
		
		
     
	

		 $fql='select user_id from user_action_log where access_date between "'.date("Y-m-d",$adate).'" and "'.date("Y-m-d",$bdate).'" group by user_id';
		$fry=db_query($fql);
		while($vv=mysqli_fetch_object($fry)){
		$color='rgb(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ')';
		?>
		
                  {
            label: "<?=find_a_field('user_activity_management','username','user_id="'.$vv->user_id.'"')?>", // Name the series
            data: <?="[".ltrim($ac[$vv->user_id],",")."]"?>, // Specify the data values array
            fill: false,
            borderColor: '<?=$color ?>', // Add custom color border (Line)
            backgroundColor: '<?=$color?>', // Add custom color background (Points and Fill)
            borderWidth: 2 // Specify bar border width
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

  


</script>

<script>

window.onload = setTimeout(oneYearChart, 1);



</script>


   
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>