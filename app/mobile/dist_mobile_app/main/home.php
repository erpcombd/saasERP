<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';
//var_dump($_SESSION);

$title = "home";
$page = "home.php";
$menu = 'home';
$menu_active='active';

require_once '../assets/template/inc.header.php';


$currentDate = date('Y-m-d');
$dealer_code	= $_SESSION['user']['id'];
//$emp_code		= $_SESSION['user']['username'];
$emp_code		=  $_SESSION['user']['id'];
$user_region_id	= $_SESSION['user']['region_id'];
$user_zone_id	= $_SESSION['user']['zone_id'];
$user_area_id	= $_SESSION['user']['area_id'];

$dinfo = findall("select * from dealer_info where dealer_code='" . $dealer_code . "' ");

$dayName = date('l');
//$sql_r = 'select * from ss_schedule where PBI_ID="' . $_SESSION['user']['username'] . '" and day_name="' . $dayName . '"';
//old_$total_visit =   find1("select COUNT(DISTINCT dealer_code) from ss_do_master where do_date='" . date('Y-m-d') . "' and depot_id='" . $emp_code . "'");
$total_visit =   find1("select COUNT(DISTINCT do_no) from ss_do_master where do_date='" . date('Y-m-d') . "' and depot_id='" . $emp_code . "'");
$total_visit_deli = find1("select COUNT(DISTINCT do_no) from ss_do_master where do_date='" . date('Y-m-d') . "' and status='COMPLETED' and depot_id='" . $emp_code . "'");
//$query_r = db_query($sql_r);
//$row_r = mysqli_fetch_object($query_r);
$count_target_Shops = find1("SELECT COUNT(*) FROM ss_shop WHERE master_dealer_code = '" . $emp_code . "'");

$fdate = date('Y-m-01');
$tdate = date('Y-m-d');



$year = date("Y", strtotime($tdate));

$mon = date("m", strtotime($tdate));
//$st = "select target_amount from ss_target_upload where target_year='" . $year . "' and target_month='" . $mon . "' and dealer_code='" . $emp_code . "'";
//$sales_target = find1($st);
//$sales_target_formatted = number_format($sales_target, 2);
$sales	= find1("select sum((item_ex-item_in)*item_price) as sales from ss_journal_item 
where ji_date between '" . $fdate . "' and '" . $tdate . "' and warehouse_id='" . $emp_code . "' and tr_from in('Sales','Sales Return')");

$sales_fotmatted = number_format($sales, 2);

$sql_last_week_sales = " SELECT dates.ji_date, DATE_FORMAT(dates.ji_date, '%a') as day_short_name, IFNULL(SUM((item_ex - item_in) * item_price), 0) as daily_sales FROM ( SELECT CURDATE() AS ji_date UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 1 DAY) UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 2 DAY) UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 3 DAY) UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 4 DAY) UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 5 DAY) UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 6 DAY) ) AS dates LEFT JOIN ss_journal_item si ON dates.ji_date = si.ji_date AND si.warehouse_id = '".$emp_code."' AND si.tr_from IN ('Sales', 'Sales Return') GROUP BY dates.ji_date ORDER BY dates.ji_date DESC ";
$sql_last_week_sales_qry = db_query($sql_last_week_sales);

$sales_data = array();

while ($row = mysqli_fetch_object($sql_last_week_sales_qry)) {

	$sales_data[] = $row;
}


//$currentDate = new DateTime();
//
//
//$months = [];
//
//
//for ($i = 0; $i < 4; $i++) {
//
//	$dateClone = clone $currentDate;
//
//	$dateClone->modify("-$i month");
//
//
//	$previousMonthNumber = ltrim($dateClone->format('m'), '0');
//	$previousMonthName = $dateClone->format('F');
//
//
//	$dateClone->modify('first day of this month');
//	$fromdate = $dateClone->modify('first day of this month')->format('Y-m-d');
//	$todate = $dateClone->modify('last day of this month')->format('Y-m-d');
//
//
//
//	$st = "select target_amount from ss_target_upload where target_year='" . $year . "' and target_month='" . $previousMonthNumber . "' and dealer_code='" . $emp_code . "'";
//	$sales_target_each_month = find1($st);
//
//	$sales_each_month = find1("SELECT SUM((item_ex - item_in) * item_price) AS sales 
//	FROM ss_journal_item 
//	WHERE ji_date BETWEEN '$fromdate' AND '$todate' 
//	  AND entry_by='$emp_code' 
//	  AND tr_from IN ('Sales', 'Sales Return')");
//
//	if ($sales_each_month == '') {
//		$sales_each_month = 0;
//	}
//	if ($sales_target_each_month == '') {
//		$sales_target_each_month = 0;
//	}
//
//	$months[] = [
//		'month_number' => $previousMonthNumber,
//		'month_name' => $previousMonthName,
//		'sales_target' => $sales_target_each_month,
//		'sales' => $sales_each_month
//	];
//}


?>


<style>
	.new_bt_data{
    display: flex;
    justify-content: center;
    align-items: center;
    align-content: center;
	top: -10px;
    font-size: 26px !important;
	}
	
/*	.header {
		width: 3% !important;
		border-radius: 20%;
		margin-left: -7px;
		margin-top: -5px;
	}*/
	
	.header {
      width: 50px !important;
      border-radius: 0% 0% 100%;
      height: 50px !important;
	}
	
	.menu1 {
		margin-left: 5px !important;
		margin-top: 3px !important;
	}

	.borderWH {

		background-color: #fff !important;
		border-radius: 10px !important;

	}

	@media only screen and (max-width: 600px) {

		.header {

        width: 50px !important;
        border-radius: 0% 0% 100%;
        height: 50px !important;
			/*width: 11% !important;
			border-radius: 20%;
			/* margin-left: -10px;
			margin-top: -10px; */

		}

		.menu1 {}
	}
</style>


<div class="page-content header-clear-small">

	<div class="content">


<?php /*?>		<div class="header header-fixed header-logo-center">
			<!-- <a href="../main/home.php" class="header-title">  </a>-->
			<a data-menu="menu-sidebar-left-1" href="#" class="header-icon header-icon-1 new_bt_data"><i class="fa-solid fa-bars menu1"></i> <strong class="titel-header-ss"></strong> </a>
			<!--<a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-lightbulb"></i></a>-->
		</div><?php */?>


		<div class="row mb-n2">

			<div class="col-12 pe-2">
				<div class="card borderWH card-style mx-0 mb-3">
					<div class="p-3 text-center">
						<h1 class="font-700 text-uppercase font-20 opacity-80 header1 titel_sub text-center">Welcome Back!</h1>
						<h4 class="font-700 text-uppercase font-15 opacity-80 mt-n2"> <?= $_SESSION['user']['fname']; ?> (<?= $_SESSION['user']['username']; ?>)</h4>
						<?
						$region_name = find1("select BRANCH_NAME from branch where BRANCH_ID='" . $user_region_id . "'");
						$zone_name = find1("select ZONE_NAME from zon where ZONE_CODE='" . $user_zone_id . "'");
						$area_name = find1("select AREA_NAME from area where AREA_CODE='" . $user_area_id . "'");
						?>
						
						<!--<h4 class="text-uppercase font-12 opacity-80 mt-n2"><strong>Address:</strong> <?=$_SESSION['user']['address'];?> </h4>-->
						<h4 class="text-uppercase font-12 opacity-80 mt-n2"><?=$region_name; ?> - <?=$zone_name; ?> - <?=$area_name; ?> </h4>
						<!--<h4 class="font-700 text-uppercase font-12 opacity-80 mt-n2">Dealer: <?= $dinfo->dealer_code ?> <?= $dinfo->dealer_name_e ?> <?= $dinfo->mobile_no ?> </h4>-->

						<?php /*?><h1 class="font-700 font-34 color-green-dark  mb-0">
				  <span class="textspan"> <?if($count_target_Shops!=''){echo $count_target_Shops;}else{echo 0;}?> </span>
				</h1><?php */ ?>

					</div>
				</div>
			</div>


			<div class="col-6 pe-2">
				<a href="../file/shop_list.php">
				<div class="card borderWH card-style mx-0 mb-3">
					<div class="p-3">
						<h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2"> Total Shop</h4>
						<h1 class="font-700 font-34 color-green-dark  mb-0">
							<span class="textspan"> <? if ($count_target_Shops != '') {
														echo $count_target_Shops;
													} else {
														echo 0;
													} ?> </span>
						</h1>
						<i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
					</div>
				</div>
				</a>
			</div>
			<div class="col-6 ps-2 pe-2">
				<a href="../file/do_status.php">
				<div class="card borderWH card-style mx-0 mb-3">
					<div class="p-3">
						<h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2">Today Order</h4>
						<h1 class="font-700 font-34 color-blue-dark mb-0">
							<span class="textspan"><? if ($total_visit != '') {
														echo $total_visit;
													} else {
														echo 0;
													} ?></span>
						</h1>
						<i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
					</div>
				</div>
				</a>
			</div>
			<div class="col-6 pe-2">
			<a href="../file/chalan_list.php">
				<div class="card borderWH card-style mx-0 mb-3">
					<div class="p-3">
						<h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2"> Delivery This Month</h4>
						<h1 class="font-700 font-18 color-yellow-dark mb-0">
							<span class="textspan"><? if ($sales == '') {
														echo 0;
													} else {
														echo number_format($sales, 2);
													} ?></span>
						</h1>
						<i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
					</div>
				</div>
				</a>
			</div>
			
			<div class="col-6 ps-2 pe-2">
						<a href="../file/chalan_list.php">
				<div class="card borderWH card-style mx-0 mb-3">
					<div class="p-3">
						<h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2">Today Delivery</h4>
						<h1 class="font-700 font-34 color-red-dark mb-0">
							<span class="textspan"><? if ($total_visit_deli != '') {
														echo $total_visit_deli;
													} else {
														echo 0;
													} ?></span>
						</h1>
						<i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
					</div>
				</div>
								</a>
			</div>
			
			
			
			
<!--			<div class="col-6 ps-2 pe-2">
				<div class="card borderWH card-style mx-0 mb-3">
					<div class="p-3">
						<h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2">Target Sales</h4>
						<h1 class="font-700 font-34 color-red-dark mb-0">
							<span class="textspan"><? if ($sales_target == '') {
														echo 0;
													} else {
														echo number_format($sales_target, 2);
													} ?></span>
						</h1>
						<i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
					</div>
				</div>
			</div>-->
		</div>
	</div>

	<!--<div class="card borderWH card-style p-0">
		<div class="content m-0">
			<a href="view_route_plan_user.php">
				<div data-card-height="90" class="card card-style maps m-0 rounded-s" style="height: 90px;">
					<div class="card-center d-flex justify-content-center">
						<button class="btn">
							<h4 class="text-center color-white text-uppercase">View Scheduled Maps</h4>
						</button>
					</div>
					<div class="card-overlay rounded-s bg-black opacity-70"></div>
				</div>
			</a>
		</div>
	</div>-->




	<div class="card borderWH card-style">
		<div class="content">
			<h2 class="text-center">Delivery Progress </h2>
			<p class="text-center mt-n2 mb-1 font-11 color-highlight">Delivery Progress weekly</p>
			<div class="chart-container" style="width:100%; height:300px;">
				<canvas class="graph" id="sales-chart" /></canvas>
			</div>
		</div>
	</div>


	<!--<div class="card borderWH card-style">
		<div class="content mb-0">
			<h2 class="text-center bottom-0">Sales VS Target</h2>
			<p class="text-center mt-n2 font-11 color-highlight">Total Sales vs Target Sales Monthly</p>
			<div class="chart-container mb-2" style="width:100%; height:250px;">
				<canvas class="graph" id="component-chart" />
			</div>
		</div>
	</div>-->

	<!--<div class="card borderWH card-style">
		<div class="content">
			<h2 class="text-center">Target Component </h2>
			<p class="text-center mt-n2 mb-2 font-11 color-highlight">Target Component Yearly</p>
			<div class="chart-container" style="width:100%; height:350px;">
				<canvas class="graph" id="target-chart" /></canvas>
			</div>
		</div>
	</div>-->




</div>
<!-- End of Page Content-->










<? require_once '../assets/template/inc.footer.php'; ?>

<?php /*?><script>
	//1st Sales VS Target component Charts
	var newFull = '#01BDAE';
	var redFull = '#EC2637';
	var sales = Number("<?= $sales_fotmatted ?>".replace(/,/g, ''));
	var target = Number("<?= $sales_target_formatted ?>".replace(/,/g, ''));
	var doughnutChart = document.querySelectorAll('#component-chart')[0]
	if (doughnutChart) {
		var doughnutDemoChart = new Chart(doughnutChart, {
			type: 'doughnut',
			data: {
				labels: ["Total Sales", "Target Sales"],
				datasets: [{
					backgroundColor: [newFull, redFull],
					borderColor: "rgba(255,255,255,0.1)",
					data: [sales, target]
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: true,
						position: 'bottom',
						labels: {
							fontSize: 13,
							padding: 15,
							boxWidth: 12
						},
					},
				},
				tooltips: {
					enabled: true
				},
				animation: {
					duration: 1500
				},
				layout: {
					padding: {
						bottom: 30
					}
				}
			}
		});
	}
</script><?php */?>

<script>
	//2nd Sales Component  Charts
	var greenFull = '#8CC152';
	var greenFade = 'rgba(140, 193, 82, 0.1)';
	var blueFull = '#5D9CEC';
	var blueFade = 'rgba(93, 156, 236, 0.2)';

	var lineChart = document.querySelectorAll('#sales-chart')[0]
	if (lineChart) {
		var lineDemoChart = new Chart(lineChart, {
			type: 'line',
			data: {
				labels: ['<?= $sales_data[0]->day_short_name ?>', '<?= $sales_data[1]->day_short_name ?>', '<?= $sales_data[2]->day_short_name ?>', '<?= $sales_data[3]->day_short_name ?>', '<?= $sales_data[4]->day_short_name ?>', '<?= $sales_data[5]->day_short_name ?>'],
				datasets: [{
					data: [<?= $sales_data[0]->daily_sales ?>, <?= $sales_data[1]->daily_sales ?>, <?= $sales_data[2]->daily_sales ?>, <?= $sales_data[3]->daily_sales ?>, <?= $sales_data[4]->daily_sales ?>, <?= $sales_data[5]->daily_sales ?>],
					label: "Order",
					fill: true,
					backgroundColor: blueFade,
					borderColor: blueFull,
					lineTension: 0.3,
					pointRadius: 0,
				}, ]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: true,
						position: 'bottom',
						labels: {
							fontSize: 13,
							padding: 15,
							boxWidth: 12
						},
					},
				},
				title: {
					display: false
				}
			}
		});
	}
</script>

<?php /*?><script>
	var months = <?= json_encode($months) ?>;

	console.log(months);
	//3rd Target Component Charts
	var greenFade2 = 'rgba(1, 189, 174, 1)';
	var blueFade2 = 'rgba(236, 38, 55, 1)';


	var verticalChart = document.querySelectorAll('#target-chart')[0]
	if (verticalChart) {
		var verticalDemoChart = new Chart(verticalChart, {
			type: 'bar',
			data: {
				labels: months.map(month => month.month_name),
				datasets: [{
					label: "Target",
					backgroundColor: blueFade2,
					data: months.map(month => month.sales_target)
				}, {
					label: "Sales",
					backgroundColor: greenFade2,
					data: months.map(month => month.sales)
				}]
			},

			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: true,
						position: 'bottom',
						labels: {
							fontSize: 13,
							padding: 15,
							boxWidth: 12
						},
					},
				},
				title: {
					display: false
				}
			}
		});
	}
</script><?php */?>