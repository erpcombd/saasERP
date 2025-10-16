<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";
$title = "Purchase management Dashboard";
 $tr_type="Show";
 $today = date('Y-m-d');
 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
 $cur = '&#x9f3;';

 function getMonthlySales($month, $year) {
	$current_year = date('Y');
    // Get the start and end dates of the specified month
    $start_date = date("$year-$month-01");
    $end_date = date("$year-$month-t"); // 't' gives the last day of the month



    // Query to get the sales total for the month, excluding certain statuses
    return  $new_purchase_order_amount=find_a_field('purchase_invoice pi, purchase_master pm','SUM(pi.amount)','1 and pi.po_no = pm.po_no and pm.po_date BETWEEN  "'.$start_date.'" AND "'.$end_date.'" and pm.status NOT IN ("MANUAL","CANCELED")');
	
}

function getYearlySales($year) {
    $salesData = [];
    
    // Loop through each month
    for ($month = 1; $month <= 12; $month++) {
        // Format month as two digits (e.g., "01" for January)
        $formattedMonth = str_pad($month, 2, '0', STR_PAD_LEFT);
        
        // Get sales for the month
        $salesData[$formattedMonth] = getMonthlySales($formattedMonth, $year);
    }
    
    return $salesData;
}
 function getMonthlySalesReturn($month, $year) {
	$current_year = date('Y');
    // Get the start and end dates of the specified month
    $start_date = date("$year-$month-01");
    $end_date = date("$year-$month-t"); // 't' gives the last day of the month



    // Query to get the sales total for the month, excluding certain statuses
    return find_a_field('purchase_return_details pi, 
	purchase_return_master pm',
	'SUM(pi.total_amt)','1 and pi.pr_no = pm.pr_no and pm.pr_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"');
	
}

function getYearlyReturn($year) {
    $salesData = [];
    
    // Loop through each month
    for ($month = 1; $month <= 12; $month++) {
        // Format month as two digits (e.g., "01" for January)
        $formattedMonth = str_pad($month, 2, '0', STR_PAD_LEFT);
        
        // Get sales for the month
        $salesData[$formattedMonth] = getMonthlySalesReturn($formattedMonth, $year);
    }
    
    return $salesData;
}


$jan_start = date('Y-01-01');
$jan_end = date('Y-01-31');

$feb_start = date('Y-02-01');
$feb_end = date('Y-02-28');

$mar_start = date('Y-03-01');
$mar_end = date('Y-03-31');

$apr_start = date('Y-04-01');
$apr_end = date('Y-04-30');

$may_start = date('Y-05-01');
$may_end = date('Y-05-31');

$jun_start = date('Y-06-01');
$jun_end = date('Y-06-30');

$jul_start = date('Y-07-01');
$jul_end = date('Y-07-31');

$aug_start = date('Y-08-01');
$aug_end = date('Y-08-31');

$sep_start = date('Y-09-01');
$sep_end = date('Y-9-30');

$oct_start = date('Y-10-01');
$oct_end = date('Y-10-31');

$nov_start = date('Y-11-01');
$nov_end = date('Y-11-30');

$dec_start = date('Y-12-01');
$dec_end = date('Y-12-31');

// Usage example for the current year
$yearlySales = getYearlySales(date('Y'));
// Access sales data for each month

$salesJan = isset($yearlySales['01']) ? $yearlySales['01'] : 0;
$salesFeb = isset($yearlySales['02']) ? $yearlySales['02'] : 0;
$salesMar = isset($yearlySales['03']) ? $yearlySales['03'] : 0;
$salesApr = isset($yearlySales['04']) ? $yearlySales['04'] : 0;
$salesMay = isset($yearlySales['05']) ? $yearlySales['05'] : 0;
$salesJun = isset($yearlySales['06']) ? $yearlySales['06'] : 0;
$salesJul = isset($yearlySales['07']) ? $yearlySales['07'] : 0;
$salesAug = isset($yearlySales['08']) ? $yearlySales['08'] : 0;
$salesSep = isset($yearlySales['09']) ? $yearlySales['09'] : 0;
$salesOct = isset($yearlySales['10']) ? $yearlySales['10'] : 0;
$salesNov = isset($yearlySales['11']) ? $yearlySales['11'] : 0;
$salesDec = isset($yearlySales['12']) ? $yearlySales['12'] : 0;

// Usage example for the current year
$yearlySalesReturn = getYearlyReturn(date('Y'));
// Access sales data for each month

$salesReturnJan = isset($yearlySalesReturn['01']) ? $yearlySalesReturn['01'] : 0;
$salesReturnFeb = isset($yearlySalesReturn['02']) ? $yearlySalesReturn['02'] : 0;
$salesReturnMar = isset($yearlySalesReturn['03']) ? $yearlySalesReturn['03'] : 0;
$salesReturnApr = isset($yearlySalesReturn['04']) ? $yearlySalesReturn['04'] : 0;
$salesReturnMay = isset($yearlySalesReturn['05']) ? $yearlySalesReturn['05'] : 0;
$salesReturnJun = isset($yearlySalesReturn['06']) ? $yearlySalesReturn['06'] : 0;
$salesReturnJul = isset($yearlySalesReturn['07']) ? $yearlySalesReturn['07'] : 0;
$salesReturnAug = isset($yearlySalesReturn['08']) ? $yearlySalesReturn['08'] : 0;
$salesReturnSep = isset($yearlySalesReturn['09']) ? $yearlySalesReturn['09'] : 0;
$salesReturnOct = isset($yearlySalesReturn['10']) ? $yearlySalesReturn['10'] : 0;
$salesReturnNov = isset($yearlySalesReturn['11']) ? $yearlySalesReturn['11'] : 0;
$salesReturnDec = isset($yearlySalesReturn['12']) ? $yearlySalesReturn['12'] : 0;





//current year
$current_year = date('Y');

 //dashboard Data
//  SELECT SUM(pi.amount) AS total_amount
// FROM purchase_invoice pi
// JOIN purchase_master pm ON pi.po_no = pm.po_no
// WHERE YEAR(pm.po_date) = YEAR(CURDATE())
//   AND pm.status = 'UNCHECKED'
//   AND pm.entry_by = 'your_user_id';

 $new_purchase_order=find_a_field('purchase_master ','count(*)','1 and YEAR(po_date) ="'.$current_year.'" and status in ("CHECKED","COMPLETED")');
 $new_purchase_order_amount=find_a_field('purchase_invoice pi, purchase_master pm','SUM(pi.amount)','1 and pi.po_no = pm.po_no and YEAR(pm.po_date) ="'.$current_year.'" and pm.status IN ("CHECKED","COMPLETED")');

 $new_local_purchase_order=find_a_field('warehouse_other_receive','count(*)','1 and YEAR(or_date) ="'.$current_year.'" and status="UNCHECKED"');
 $new_local_purchase_order_amount=find_a_field('warehouse_other_receive_detail pi, warehouse_other_receive pm','SUM(pi.amount)','1 and pi.or_no = pm.or_no and YEAR(pm.or_date) ="'.$current_year.'" and pm.status IN ("CHECKED","COMPLETED")');


 $receive_order=find_a_field('purchase_receive pr, purchase_master pm','count(pm.po_no)','1 and pm.po_no=pr.po_no and YEAR(rec_date) ="'.$current_year.'"');
 $receive_order_amount=find_a_field('purchase_receive pr, purchase_master pm','sum(pr.amount)','1 and pm.po_no=pr.po_no and YEAR(rec_date) ="'.$current_year.'"');


 $purchase_return=find_a_field('purchase_return_master','count(*)','1 and YEAR(pr_date) ="'.$current_year.'"');
 $purchase_return_amount=find_a_field('purchase_return_details pi, purchase_return_master pm','SUM(pi.total_amt)','1 and pi.pr_no = pm.pr_no and YEAR(pm.pr_date) ="'.$current_year.'" and pm.status IN ("CHECKED")');


 $approved_po=find_a_field('purchase_master ','count(*)','1 and YEAR(po_date) ="'.$current_year.'" and status="CHECKED"');
 $approved_po_amount=find_a_field('purchase_invoice pi, purchase_master pm','SUM(pi.amount)','1 and pi.po_no = pm.po_no and YEAR(pm.po_date) ="'.$current_year.'" and pm.status="CHECKED"');





 $sql_last_week_sales = '
SELECT dates.ji_date,
       DATE_FORMAT(dates.ji_date, "%a") AS day_short_name,
       IFNULL(SUM(pi.amount), 0) AS daily_total_amount
FROM (
    SELECT CURDATE() AS ji_date
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 1 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 2 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 3 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 4 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 5 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 6 DAY)
) AS dates
LEFT JOIN purchase_master pm ON dates.ji_date = DATE(pm.po_date)
    AND pm.status != "MANUAL"
    AND YEAR(pm.po_date) = YEAR(CURDATE())
LEFT JOIN purchase_invoice pi ON pi.po_no = pm.po_no
GROUP BY dates.ji_date
ORDER BY dates.ji_date DESC;

';

$sql_last_week_sales_qry = db_query($sql_last_week_sales);

$sales_data = array();  

while($row = mysqli_fetch_object($sql_last_week_sales_qry)) {
	
    $sales_data[] = $row; 
}





 







$thisYear = date('Y');
$lastYear = date('Y')-1;
$previousYear = date('Y')-2;
$previousLastYear = date('Y')-3;

$thisYearSdate = $thisYear.'-01-01';
$thisYearEdate = $thisYear.'-12-31';
$thisYearSales = find_a_field('purchase_invoice pi, purchase_master pm','SUM(pi.amount)','1 and pi.po_no = pm.po_no and pm.po_date BETWEEN  "'.$thisYearSdate.'" AND "'.$thisYearEdate.'" and pm.status NOT IN ("MANUAL","CANCELED")');

$thisYearLocalPurchase = find_a_field('warehouse_other_receive_detail pi, warehouse_other_receive pm','SUM(pi.amount)','1 and pi.or_no = pm.or_no and pm.or_date BETWEEN  "'.$thisYearSdate.'" AND "'.$thisYearEdate.'" and pm.status="UNCHECKED"');




$lastYearSdate = $lastYear.'-01-01';
$lastYearEdate = $lastYear.'-12-31';
$lastYearSales = find_a_field('purchase_invoice pi, purchase_master pm','SUM(pi.amount)','1 and pi.po_no = pm.po_no and pm.po_date BETWEEN  "'.$lastYearSdate.'" AND "'.$lastYearEdate.'" and pm.status NOT IN ("MANUAL","CANCELED")');

$lastYearLocalPurchase = find_a_field('warehouse_other_receive_detail pi, warehouse_other_receive pm','SUM(pi.amount)','1 and pi.or_no = pm.or_no and pm.or_date BETWEEN  "'.$lastYearSdate.'" AND "'.$lastYearEdate.'" and pm.status="UNCHECKED"');

$preYearSdate = $previousYear.'-01-01';
$preYearEdate = $previousYear.'-12-31';
$preYearSales = find_a_field('purchase_invoice pi, purchase_master pm','SUM(pi.amount)','1 and pi.po_no = pm.po_no and pm.po_date BETWEEN  "'.$preYearSdate.'" AND "'.$preYearEdate.'" and pm.status NOT IN ("MANUAL","CANCELED")');

$preYearLocalPurchase = find_a_field('warehouse_other_receive_detail pi, warehouse_other_receive pm','SUM(pi.amount)','1 and pi.or_no = pm.or_no and pm.or_date BETWEEN  "'.$preYearSdate.'" AND "'.$preYearEdate.'" and pm.status="UNCHECKED"');



$preLastYearSdate = $previousLastYear.'-01-01';
$preLastYearEdate = $previousLastYear.'-12-31';
$preLastYearSales = find_a_field('purchase_invoice pi, purchase_master pm','SUM(pi.amount)','1 and pi.po_no = pm.po_no and pm.po_date BETWEEN  "'.$preLastYearSdate.'" AND "'.$preLastYearEdate.'" and pm.status NOT IN ("MANUAL","CANCELED")');

$preLastSalesReturn = find_a_field('warehouse_other_receive_detail pi, warehouse_other_receive pm','SUM(pi.amount)','1 and pi.or_no = pm.or_no and pm.or_date BETWEEN  "'.$preLastYearSdate.'" AND "'.$preLastYearEdate.'" and pm.status="UNCHECKED"');












$tr_from="Purchase";
?>

  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  
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



<div class="container-fluid">
			<div class="row m-0 p-0">
			
						
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Purchase <span>|| Year <?=date('Y'); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon primary"><?=$new_purchase_order?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold">&nbsp;</p>-->
							<p class="p-sub1">  <span><i class="fa-solid fa-bangladeshi-taka-sign"></i>: <?=$new_purchase_order_amount?></span></p>
						 </div>
						
						</div>
						
						<a href="#" class="d-flex justify-content-center a">
                                   <button 
    type="button" 
    class="btn bg-primary button-cs d-flex justify-content-center" 
    onclick="window.open('../po/po_create.php', '_blank');">
    <i class="fas fa-check-circle"></i> Create Order 
</button>

						</a>
					  </div>
					</div>
				</div>
				
	
				
				
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Local Purchase<span> || Year <?=date('Y');?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon success"><?=$new_local_purchase_order?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold">&nbsp;</p>-->
							<p class="p-sub1"> <span><i class="fa-solid fa-bangladeshi-taka-sign"></i>:<?=$new_local_purchase_order_amount?> </span></p>
						 </div>
						
						</div>
						
						<a href="#" class="d-flex justify-content-center a">
						 <button 
    type="button" 
    class="btn bg-success button-cs d-flex justify-content-center" 
    onclick="window.open('../report/purchase_order_report.php', '_blank');">
    <i class="fas fa-check-circle"></i> New Order 
</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Purchase Receive <span> || Year <?=date('Y'); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger"><?=$receive_order?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold">&nbsp;</p>-->
							<p class="p-sub1"><span><i class="fa-solid fa-bangladeshi-taka-sign"></i>:<?=$receive_order_amount?> </span></p>
						 </div>
						
						</div>
						
						<a href="#" class="d-flex justify-content-center a">
							<button 
                            type="button" 
                            class="btn bg-danger button-cs d-flex justify-content-center" 
                            onclick="window.open('../../warehouse_mod/po_receiving/select_upcoming_po.php', '_blank');">
                            <i class="fas fa-check-circle"></i> Pending GRN
                        </button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Purchase Return<span> || Year <?=date('Y'); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon info"><?=$purchase_return?></div>
						<div class="new-icon-text">
						 	<!--<p class="p-sub bold">&nbsp;</p>-->
							<p class="p-sub1"> <span><i class="fa-solid fa-bangladeshi-taka-sign"></i>: <?=$purchase_return_amount?></span></p>
						 </div>
						
						</div>
						
						<a href="#" class="d-flex justify-content-center a">
						<button 
    type="button" 
    class="btn bg-info button-cs d-flex justify-content-center" 
    onclick="window.open('../report/purchase_order_report.php', '_blank');">
    <i class="fas fa-check-circle"></i> New Order 
</button>
						</a>
					  </div>
					</div>
				</div>


			
				<!--<div class="col-3 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Approved PO <span> || Year 2024</span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon warning"><?= $approved_po?></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"> <span><i class="fa-solid fa-bangladeshi-taka-sign"></i>:<?=$approved_po_amount?></span></p>
						 </div>
						
						</div>
						
						<a href="#" class="d-flex justify-content-center a">
							<button 
    type="button" 
    class="btn bg-warning button-cs d-flex justify-content-center" 
    onclick="window.open('../po/po_status.php', '_blank');">
    <i class="fas fa-check-circle"></i> New Order 
</button>
						</a>
					  </div>
					</div>
				</div>-->


			
				<!--<div class="col-3 new">-->
				<!--	<div class="card">-->
				<!--	  <div class="card-body">-->
				<!--		<h5 class="card-title bold">Name Add <span> || Year 2024</span></h5>-->
						
				<!--		<div class="d-flex ustify-content-between p-3">-->
				<!--		<div class="new-icon green-new"><i class="fa-solid fa-bangladeshi-taka-sign"></i></div>-->
				<!--		<div class="new-icon-text">-->
				<!--		 	<p class="p-sub bold">00.00	</p>-->
				<!--			<p class="p-sub1"> Currency <span>BDT</span></p>-->
				<!--		 </div>-->
						
				<!--		</div>-->
						
				<!--		<a href="#" class="d-flex justify-content-center a">-->
				<!--			<button type="button" class="btn bg-green-new button-cs"> <i class="fas fa-check-circle"></i> New Order</button>-->
				<!--		</a>-->
				<!--	  </div>-->
				<!--	</div>-->
				<!--</div>-->


			
				<!--<div class="col-3 new">-->
				<!--	<div class="card">-->
				<!--	  <div class="card-body">-->
				<!--		<h5 class="card-title bold">Name Add <span> || Year 2024</span></h5>-->
						
				<!--		<div class="d-flex ustify-content-between p-3">-->
				<!--		<div class="new-icon purple-new"><i class="fa-solid fa-bangladeshi-taka-sign"></i></div>-->
				<!--		<div class="new-icon-text">-->
				<!--		 	<p class="p-sub bold">00.00	</p>-->
				<!--			<p class="p-sub1"> Currency <span>BDT</span></p>-->
				<!--		 </div>-->
						
				<!--		</div>-->
						
				<!--		<a href="#" class="d-flex justify-content-center a">-->
				<!--			<button type="button" class="btn bg-purple-new button-cs"> <i class="fas fa-check-circle"></i> New Order</button>-->
				<!--		</a>-->
				<!--	  </div>-->
				<!--	</div>-->
				<!--</div>-->



			
				<!--<div class="col-3 new">-->
				<!--	<div class="card">-->
				<!--	  <div class="card-body">-->
				<!--		<h5 class="card-title bold">Name Add <span> || Year 2024</span></h5>-->
						
				<!--		<div class="d-flex ustify-content-between p-3">-->
				<!--		<div class="new-icon violet-new"><i class="fa-solid fa-bangladeshi-taka-sign"></i></div>-->
				<!--		<div class="new-icon-text">-->
				<!--		 	<p class="p-sub bold">00.00	</p>-->
				<!--			<p class="p-sub1"> Currency <span>BDT</span></p>-->
				<!--		 </div>-->
						
				<!--		</div>-->
						
				<!--		<a href="#" class="d-flex justify-content-center a">-->
				<!--			<button type="button" class="btn bg-violet-new button-cs"> <i class="fas fa-check-circle"></i> New Order</button>-->
				<!--		</a>-->
				<!--	  </div>-->
				<!--	</div>-->
				<!--</div>-->


			</div>

		
				  
				  <!--<div class="row m-0 p-0">
				  
				  
				  1st chart
						<div class="col-lg-6 col-md-12 p-2 mt-2">
							<div class="card card-chart">
								<div class="card-body">
									<h5 class="card-title bold">MONTHLY PURCHASE CHART<span> || Year 2024</span></h5>
								</div>
								<div class="card-header">
										<canvas id="oilChart" width="600" height="400"></canvas>
								</div>
							</div>
						</div>
						
						
						2nd chart
					  <div class="col-lg-6 col-md-12 p-2 mt-2">
						<div class="card card-chart">
							<div class="card-body">
								<h4 class="card-title bold">ONE WEEK PURCHASE CHART<span> || Year 2024</span></h4>
							</div>
					
							<div class="card-header">
							  <canvas id="chart_0" style="height: 321px !important;width: 482px;" width="650" height="321"></canvas>
							</div>
			
					   </div>
					</div>
						
		
						
										
						3rd chart	
						<div class="col-lg-6 col-md-12 p-2">
							<div class="card card-chart">
								<div class="card-body">
									<h5 class="card-title bold">ONE YEAR PURCHASE REPORTS<span> || Year 2024</span></h5>
								</div>
								<div class="card-header">
											<canvas id="onemounth" style="height: 367px!important; width: 482px;" width="650" height="367"></canvas>
		
								</div>
							</div>
						</div>
		
					
				
						4th chart	
						<div class="col-lg-6 col-md-12 p-2">
							<div class="card card-chart">
								<div class="card-body">
								<h5 class="card-title bold">LAST 4 YEAR PURCHASE REPORTS<span> || Year 2024</span></h5>
								</div>
								<div class="card-header">
											<canvas id="oneweek" style="width: 482px; height: 367px;" width="650" height="367"></canvas>
								</div>
							</div>
						</div>
					
		
					  </div>-->
					  
					  
					  
					  
					  
	<div class="row m-0 p-0 mt-4">
  <div class="col-12 new">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title bold">Top 5 Purchase Reports  <span> || Year-<?php echo date("Y"); ?></span></h5>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon primary" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Purchase order Details</span>
          </div>
		  
		  <a href="../report/purchase_order_report.php">
		  <div class="d-flex align-items-center"><span class="text-success"><i class="fas fa-arrow-up"></i> Open </span>		</a>
          </div>
        </div>
		

		
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon warning" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Present Stock Summary </span>
          </div>
          <div class="d-flex align-items-center">
          <a href="../report/purchase_order_report.php"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span>		</a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon success" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Purchase Requisition Report</span>
          </div>
          <div class="d-flex align-items-center">
           
            <a href="../../warehouse_mod/report/mr_work_order_report.php"><span class="text-success"><i class="fas fa-arrow-up"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon info" style="width: 15px; height: 15px; border-radius: 50%;"></div>
           <span class="ml-2"> Vendor Report</span>
          </div>
          <div class="d-flex align-items-center">
           
             <a href="../vendor/vendor_report.php"><span class="text-success"><i class="fas fa-arrow-up"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon danger" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2"> Local Purchase Order Report</span>
          </div>
          <div class="d-flex align-items-center">
          
            <a href="../../warehouse_mod/local_purchase_cash/purchase_order_report.php"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
      </div>
    </div>
	
	
	
  </div>
  
  
  <br />
<br />
<br />
<br />

  
  
  <!--<div class="col-6 new">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title bold">Top 5 Financial Reports  <span> || Year-<?php echo date("Y"); ?></span></h5>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon primary" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Comparative Financial Statements</span>
          </div>
          <div class="d-flex align-items-center">
          <a href="../financial_report/financial_statement_comparative.php"><span class="text-success"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon warning" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Comparative Income Statement</span>
          </div>
          <div class="d-flex align-items-center">
             <a href="../financial_report/financial_profit_loss_comparative.php"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon success" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Statement of Profit or Loss & Other Income</span>
          </div>
          <div class="d-flex align-items-center">
            <a href="../financial_report/financial_profit_loss.php"><span class="text-success"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon info" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Cost of Goods Sold</span>
          </div>
          <div class="d-flex align-items-center">
            <a href="../financial_report/financial_cogs_cal.php"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon danger" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Receipt & Payment Statement</span>
          </div>
          <div class="d-flex align-items-center">
          <a href="../financial_report/receipt_payment_statement.php"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
      </div>
    </div>
	
	
	
  </div>-->
</div>



		



 <!--///////////////////////////////////////////chart start values ////////////////////////////////////////////////////////////////-->

<script type="text/javascript">

///////////// 1st chart//////////////////
var purchase = <?=$new_purchase_order_amount?>;
var localpurchase = <?=$new_local_purchase_order_amount?>;
var receive = <?=$receive_order_amount?>;
var purchase_return = <?=$purchase_return_amount?>;
var oilCanvas = document.getElementById("oilChart");
console.log(purchase+'fff'+localpurchase+'hhh'+receive);
Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var oilData = {
    labels: [
        "Purchase",
        "Local",
        "Receive",
        "Return"
    ],
    datasets: [
        {
            data: [purchase, localpurchase, receive, purchase_return],
            backgroundColor: [
                "#008fa1",
                "#6491d1",
                "#5b995e",
                "#fb9006"
            ]
        }]

};

var pieChart = new Chart(oilCanvas, {
  type: 'pie',
  data: oilData
});



///////////// 2nd chart//////////////////
    // Set fixed data values for each label between 1000 and 7000
    // Extract labels and data dynamically from PHP array
    var labels = [
        <?php foreach ($sales_data as $data) { echo '"' . $data->day_short_name . '", '; } ?>
    ];

    var purchaseData = [
        <?php foreach ($sales_data as $data) { echo $data->daily_total_amount . ', '; } ?>
    ];

    // Define chart data with dynamically populated values
    var data = {
        labels: labels,
        datasets: [
            {
                label: "Purchase",
                backgroundColor: "#fb9006",
                borderColor: "#fb9006",
                borderWidth: 2,
                hoverBackgroundColor: "#fb9006",
                hoverBorderColor: "#fb9006",
                data: purchaseData
            },
            {
                label: "Local",
                backgroundColor: "#008fa1",
                borderColor: "#008fa1",
                borderWidth: 2,
                hoverBackgroundColor: "#008fa1",
                hoverBorderColor: "#008fa1",
                data: [2000, 500, 4000, 3000, 5500, 4000, 6500] // Example data
            }
        ]
    };

    // Chart options
    var option = {
        scales: {
            yAxes: [{
                stacked: false,
                gridLines: {
                    display: true,
                    color: "rgba(220, 220, 220, 0.3)"
                }
            }],
            xAxes: [{
                gridLines: {
                    display: false
                }
            }]
        },
        legend: {
            display: true,
            labels: {
                fontColor: "#333",
                fontSize: 14
            }
        }
    };
    // Set canvas size before initializing chart
    var canvas = document.getElementById("chart_0");
    canvas.width = 482;  // Set the width
    canvas.height = 321; // Set the height

    // Initialize the chart on the canvas element with id 'chart_0'
    var ctx = document.getElementById("chart_0").getContext("2d");
    new Chart(ctx, {
        type: 'bar',
        data: data,
        options: option
    });


///////////// 3rd chart//////////////////
    // Example data values between 1000 and 20000
    var purchaseData = [<?=$salesJan?>, <?=$salesFeb?>, <?=$salesMar?>, <?=$salesApr?>, <?=$salesMay?>, <?=$salesJun?>, <?=$salesJul?> ,<?=$salesAug?>,<?=$salesSep?>,
	<?=$salesOct?>,<?=$salesNov?>,<?=$salesDec?>];
    var purchaseReturnData = [<?=$salesReturnJan?>, <?=$salesReturnFeb?>, <?=$salesReturnMar?>, <?=$salesReturnApr?>, <?=$salesReturnMay?>, <?=$salesReturnJun?>, <?=$salesReturnJul?> ,<?=$salesReturnAug?>,<?=$salesReturnSep?>,
	<?=$salesReturnOct?>,<?=$salesReturnNov?>,<?=$salesReturnDec?>];

    var ctx = document.getElementById("onemounth").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [
                {
                    label: 'Purchase',
                    data: purchaseData,
                    fill: false,
                    borderColor: '#fb9006',
                    backgroundColor: '#fb9006',
                    borderWidth: 2
                },
                {
                    label: 'Purchase Return',
                    data: purchaseReturnData,
                    fill: false,
                    borderColor: '#008fa1',
                    backgroundColor: '#008fa1',
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 10000  // Set a maximum Y-axis range slightly above your data range for better visualization
                }
            }
        }
    });


///////////// 4th chart//////////////////
    // Example data values between 3000 and 4000
var cYearSales = <?= !empty($thisYearSales) ? $thisYearSales : 0 ?>; // Current year Sales
var oYearSales = <?= !empty($lastYearSales) ? $lastYearSales : 0 ?>; // One year ago Sales
var ooYearSales = <?= !empty($preYearSales) ? $preYearSales : 0 ?>; // Two years ago Sales
var oooYearSales = <?= !empty($preLastYearSales) ? $preLastYearSales : 0 ?>; // Two years ago Sales 3

var cYearSales3 = <?= !empty($thisYearLocalPurchase) ? $thisYearLocalPurchase : 0 ?>; // Current year Sales 3
var oYearSales3 = <?= !empty($lastYearLocalPurchase) ? $lastYearLocalPurchase : 0 ?>; // One year ago Sales 3
var ooYearSales3 = <?= !empty($preYearLocalPurchase) ? $preYearLocalPurchase : 0 ?>; // Two years ago Sales 3
var oooYearSales3 = <?= !empty($preLastSalesReturn) ? $preLastSalesReturn : 0 ?>; // Two years ago Sales 3


    var chartColors = {
        yellow: '#008fa1',
        green: '#fb9006'
    };

    var data = {
		labels: ["<?=$thisYear;?>", "<?=$lastYear;?>", "<?=$previousYear;?>", "<?=$previousLastYear;?>"],
        datasets: [
            {
                label: 'Purchase',
                backgroundColor: [
                    chartColors.yellow,
                    chartColors.yellow,
                    chartColors.yellow,
                    chartColors.yellow
                ],
                data: [cYearSales, oYearSales, ooYearSales, oooYearSales]  // Sales data
            },
            {
                label: 'Local',
				backgroundColor: [
                    chartColors.green,
                    chartColors.green,
                    chartColors.green,
                    chartColors.green
                ],
                data: [cYearSales3, oYearSales3, ooYearSales3, oooYearSales3]  // Sales 3 data
            }
        ]
    };

    var myBar = new Chart(document.getElementById("oneweek"), {
        type: 'horizontalBar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            legend: {
                display: true,
                position: 'top'
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        suggestedMax: 4500  // Keeps the range appropriate for values between 3000 and 4000
                    }
                }]
            }
        }
    });

</script>
	<!--<script>
    function submitFormToMasterReport(button) {
         Get the 'report' value from the button's data-report attribute
        const reportValue = button.getAttribute('data-report');

         Create a new form element
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../report/master_report.php';
        form.target = '_blank'; // Open in a new tab

         Create an input element for 'report' with the value from the button
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'report';
        input.value = reportValue;
        
         Append the input to the form
        form.appendChild(input);
        
         Append the form to the body and submit
        document.body.appendChild(form);
        form.submit();

         Remove the form after submission to avoid cluttering the DOM
        document.body.removeChild(form);
    }
</script>-->


   
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>