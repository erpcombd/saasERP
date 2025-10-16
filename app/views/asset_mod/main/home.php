<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = "Fixed Asset Dashboard";
$today = date('Y-m-d');
$lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
?>
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
.font-siz{
font-size:20px;
font-weight:bold;
}
@media(max-width: 1200px) {
}
@media(max-width: 1400px) {
}
@media(max-width: 1500px) {
}
</style>
</head>
<div class="content">
<div class="container-fluid">
<!--new-->

<div class="row">

<div class="col-lg-12 col-sm-12 col-md-12">
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header card-header-primary card-header-icon">
<div class="card-icon p-0">
<i class="fas fa-chart-line"></i>
</div>
<p class="card-category" style="color:#BA04F9; font-weight:bold;">Total Fixed Asset</p>
<h3 class="card-title"><span id="salesReturn" class="loader">79</span></h3>
</div>
<div class="card-footer">
<div class="stats">
<i class="material-icons">date_range</i> Last 7 Days
</div>
</div>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header card-header-success card-header-icon">
<div class="card-icon p-0">
<i class="fab fa-audible"></i>
</div>
<p class="card-category" style="color:#0CBB37; font-weight:bold;">Total Issue(Current Month)</p>
<h3 class="card-title"><span id="purchaseReturn" class="loader">50</span></h3>
</div>
<div class="card-footer">
<div class="stats">
<i class="material-icons">date_range</i> Last 7 Days
</div>
</div>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header card-header-danger card-header-icon">
<div class="card-icon p-0">
<i class="far fa-calendar-times"></i>
</div>
<p class="card-category" style="color:#F00712; font-weight:bold;">Total Receive(Current Month)</p>
<h3 class="card-title"><span id="transferIssue" class="loader">20</span></h3>
</div>
<div class="card-footer">
<div class="stats">
<i class="material-icons">update</i> Last 7 Days
</div>
</div>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header card-header-warning card-header-icon">
<div class="card-icon p-0">
<i class="fas fa-calendar-check"></i>
</div>
<p class="card-category" style="color:#F5DB01; font-weight:bold;">Previous Year Deprciation Value</p>
<h3 class="card-title"><span id="transferReceive" class="loader">৳:35,000</span></h3>
</div>
<div class="card-footer">
<div class="stats">
<i class="material-icons">update</i> Last 7 Days
</div>
</div>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header card-header-info card-header-icon">
<div class="card-icon p-0">
<i class="fas fa-file-export"></i>
</div>
<p class="card-category" style="color:#0fa9d7; font-weight:bold;">Local Sales</p>
<h3 class="card-title"><span id="localSales" class="loader">Checking..</span></h3>
</div>
<div class="card-footer">
<div class="stats">
<i class="material-icons">update</i> Last 7 Days
</div>
</div>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header card-header-primary card-header-icon">
<div class="card-icon p-0">
<i class="fas fa-file-download"></i>
</div>
<p class="card-category" style="color:#BA04F9; font-weight:bold;">Local Purchase</p>
<h3 class="card-title"><span id="localPurchase" class="loader">Checking..</span></h3>
</div>
<div class="card-footer">
<div class="stats">
<i class="material-icons">update</i> Last 7 Days
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!--<div class="row">
<div class="col-md-4">
<div class="card card-chart">
<div class="card-header card-header-success">
<div class="ct-chart" id="dailySalesChart"></div>
</div>
<div class="card-body">
<h4 class="card-title">Requisition Last Month</h4>
<p class="card-category">
<span class="text-success"><i class="fa fa-long-arrow-up"></i> 1% </span> increase.</p>
</div>
<div class="card-footer">
<div class="stats">
<i class="material-icons">access_time</i> Last Month
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
<h4 class="card-title">Chalan Last Month</h4>
<p class="card-category">
<span class="text-success"><i class="fa fa-long-arrow-up"></i> 5% </span> increase.</p>
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
<span class="text-warning"><i class="fa fa-long-arrow-down"></i> 10% </span> Dicrease.</p>
</div>
<div class="card-footer">
<div class="stats">
<i class="material-icons">access_time</i> Last 7 Days
</div>
</div>
</div>
</div>
</div>-->
<!--<div class="row">
<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header card-header-warning card-header-icon">
<div class="card-icon">
<i class="material-icons">content_copy</i>
</div>
<p class="card-category">Total Chalan Today</p>
<h3 class="card-title"><?=find_a_field('sale_do_chalan','count(chalan_no)','chalan_date="'.$today.'"');?>
<small></small>
</h3>
</div>
<div class="card-footer">
<div class="stats">
<i class="material-icons">date_range</i> Last 24 Hours
</div>
</div>
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header card-header-success card-header-icon">
<div class="card-icon">
<i class="material-icons">store</i>
</div>
<p class="card-category">Total MR Today</p>
<h3 class="card-title"><?=find_a_field('requisition_master','count(req_no)','req_date="'.$today.'"');?></h3>
</div>
<div class="card-footer">
<div class="stats">
<i class="material-icons">date_range</i> Last 24 Hours
</div>
</div>
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header card-header-danger card-header-icon">
<div class="card-icon">
<i class="material-icons">info_outline</i>
</div>
<p class="card-category">Total PR Today</p>
<h3 class="card-title"><?=find_a_field('purchase_receive','count(pr_no)','rec_date="'.$today.'"');?></h3>
</div>
<div class="card-footer">
<div class="stats">
<i class="material-icons">local_offer</i> Tracked from Warehouse
</div>
</div>
</div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6">
<div class="card card-stats">
<div class="card-header card-header-info card-header-icon">
<div class="card-icon">
<i class="fas fa-user"></i>
</div>
<p class="card-category">New Client</p>
<h3 class="card-title"><?=find_a_field('dealer_info','count(dealer_code)','app_date between ="'.$lastdays.'" and "'.$today.'"');?></h3>
</div>
<div class="card-footer">
<div class="stats">
<i class="material-icons">update</i> Last 7 Days
</div>
</div>
</div>
</div>
</div>-->
<div class="row">
<!--Last 5Client Inforamation Tabel -->
<div class="col-lg-6 col-md-12">
<div class="card card-chart">
<div class="card-body table-responsive">
<h4 class="card-title text-center font-weight-bold">Last 5 Client Information</h4>
<p class="card-category text-center">Just Updated</p>
<div id="clientList" class="table table-hover table-striped">Checking..</div>
<!--<table class="table table-hover table-striped">
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
</table>-->
</div>
</div>
</div>
<!--2nd Dealy seals reporte chart-->
<div class="col-lg-6 col-md-12">
<div class="card card-chart">
<div class="card-body">
<h4 class="card-title">DAILY SALES CHART </h4>
</div>
<div class="card-header">
<canvas id="chart_0" width="600" height="400"></canvas>
</div>
</div>
</div>
</div>
</div>
</div>
<input type="hidden" name="hSat" id="hSat" value="">
<input type="hidden" id="hSun" value="">
<input type="hidden" id="hMon" value="">
<input type="hidden" id="hTue" value="">
<input type="hidden" id="hWed" value="80">
<input type="hidden" id="hThu" value="80">
<input type="hidden" id="hFri" value="80">
<input type="hidden" id="cYear" value="">
<input type="hidden" id="oYear" value="">
<input type="hidden" id="ooYear" value="">
<input type="hidden" id="oilChartValue1" value="">
<input type="hidden" id="oilChartValue2" value="">
<input type="hidden" id="oilChartValue3" value="">
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>-->
<script type="text/javascript">
function salesBar(){
var hSat = document.getElementById('hSat').value;
var hSun = document.getElementById('hSun').value;
var hMon = document.getElementById('hMon').value;
var hTue = document.getElementById('hTue').value;
var hWed = document.getElementById('hWed').value;
var hThu = document.getElementById('hThu').value;
var hFri = document.getElementById('hFri').value;
<!--///////////// 1st One Week report chart//////////////////-->
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
<!--/////////////3rd Last 4 year seals reports Bar chart//////////////////-->
function yearChart(){
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
/*var randomScalingFactor = function() {
return (Math.random() > 0.5 ? 1.0 : 1.0) * Math.round(Math.random() * 100);
};*/
var data =  {
labels: ["2022", "2021", "2020"],
datasets: [{
label: 'SALES',
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
<!--/////////////2rd One Week Report chart//////////////////-->
function newoilChart(){
var oilChartValue1 = document.getElementById('oilChartValue1').value;
var oilChartValue2 = document.getElementById('oilChartValue2').value;
var oilChartValue3 = document.getElementById('oilChartValue3').value;
var oilCanvas = document.getElementById("oilChart");
Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;
var oilData = {
labels: [
"Sales",
"Purchase",
"Production"
],
datasets: [
{
data: [oilChartValue1, oilChartValue2, oilChartValue3],
backgroundColor: [
"#84FF63",
"#ffb429d9",
"#FF6384"
]
}]
};
var pieChart = new Chart(oilCanvas, {
type: 'pie',
data: oilData
});
}
</script>
<!--	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>-->
<!--<script>
var ctx = document.getElementById('myLineCharts');
var myChart = new Chart(ctx, {
type: 'line',
data: {
labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
datasets: [{
label: '# of Votes',
data: [12, 19, 3, 5, -20, 3],
backgroundColor: [
'rgba(255, 99, 132, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(255, 206, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(255, 159, 64, 0.2)'
],
borderColor: [
'rgba(255, 99, 132, 1)',
'rgba(54, 162, 235, 1)',
'rgba(255, 206, 86, 1)',
'rgba(75, 192, 192, 1)',
'rgba(153, 102, 255, 1)',
'rgba(255, 159, 64, 1)'
],
borderWidth: 1
}]
},
options: {
scales: {
yAxes: [{
ticks: {
beginAtZero: true
}
}]
}
}
});
</script>-->
<!--<script>
var ctx = document.getElementById('myBarCharts');
var myChart = new Chart(ctx, {
type: 'bar',
data: {
labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
datasets: [{
label: '# of Votes',
data: [12, 19, 3, -5, 2, 3],
backgroundColor: [
'rgba(255, 99, 132, 0.2)',
'rgba(54, 162, 235, 0.2)',
'rgba(255, 206, 86, 0.2)',
'rgba(75, 192, 192, 0.2)',
'rgba(153, 102, 255, 0.2)',
'rgba(255, 159, 64, 0.2)'
],
borderColor: [
'rgba(255, 99, 132, 1)',
'rgba(54, 162, 235, 1)',
'rgba(255, 206, 86, 1)',
'rgba(75, 192, 192, 1)',
'rgba(153, 102, 255, 1)',
'rgba(255, 159, 64, 1)'
],
borderWidth: 1
}]
},
options: {
scales: {
yAxes: [{
ticks: {
beginAtZero: true
}
}]
}
}
});
</script>-->
<!--<script>
var ctx = document.getElementById('myRadarCharts');
var myChart = new Chart(ctx, {
type: 'radar',
data: {
labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
datasets: [{
label: '# of Votes',
data: [12, 19, 3, -5, 2, 3],
backgroundColor: [
'rgba(255, 99, 132, 0.2)'
],
borderColor: [
'rgba(255, 99, 132, 1)'
],
borderWidth: 1
}]
},
options: {
scales: {
yAxes: [{
ticks: {
beginAtZero: true
}
}]
}
}
});
</script>-->
<!--<script>
var ctx = document.getElementById('myPieCharts');
var myDoughnutChart  = new Chart(ctx, {
type: 'pie',
data: {
labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
datasets: [{
label: '# of Votes',
data: [12, 19, 3, -5, 2, 3],
backgroundColor: [
'rgba(255, 99, 132, 0.2)'
],
borderColor: [
'rgba(255, 99, 132, 1)'
],
borderWidth: 1
}]
},
options: {
scales: {
yAxes: [{
ticks: {
beginAtZero: true
}
}]
}
}
});
</script>-->
<!--<script>
var ctx = document.getElementById('myPolarCharts');
var myPolarChart  = new Chart(ctx, {
data: {
datasets: [{
data: [10, 20, 30]
}],
// These labels appear in the legend and in the tooltips when hovering different arcs
labels: [
'Red',
'Yellow',
'Blue'
]
},
type: 'polarArea'
});
</script>-->
<script>
function view_data(){
$.ajax({
url:"dashboard_ajax.php",
method:"POST",
dataType:"JSON",
//data:{ data_no:data_no },hSat, hSun, hMon, hTue, hWed, hThu, hFri
success: function(result, msg){
var res = result;
setTimeout(view_data, 5000);
$("#presentStock").html(res[0]);
$("#inventoryValue").html(res[1]);
$("#grnValue").html(res[2]);
$("#invoiceValue").html(res[3]);
$("#clientList").html(res[4]);
$("#salesReturn").html(res[5]);
$("#purchaseReturn").html(res[6]);
$("#transferIssue").html(res[7]);
$("#transferReceive").html(res[8]);
$("#localSales").html(res[9]);
$("#localPurchase").html(res[10]);
$("#hSat").val(res[11]);
$("#hSun").val(res[12]);
$("#hMon").val(res[13]);
$("#hTue").val(res[14]);
$("#hWed").val(res[15]);
$("#hThu").val(res[16]);
$("#hFri").val(res[17]);
$("#cYear").val(res[18]);
$("#oYear").val(res[19]);
$("#ooYear").val(res[20]);
$("#oilChartValue1").val(res[21]);
$("#oilChartValue2").val(res[22]);
$("#oilChartValue3").val(res[23]);
//salesBar();
}
}); 
}
window.onload = setTimeout(view_data, 5000);
window.onload = setTimeout(salesBar, 6000);
window.onload = setTimeout(yearChart, 6000);
window.onload = setTimeout(newoilChart, 6000);
</script>

