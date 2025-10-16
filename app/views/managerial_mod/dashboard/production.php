<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";
$title = "Production Dashboard";
$tr_type="Show";
$cur = '&#x9f3;';

$tr_from="Purchase";
$today = date('Y-m-d');
//current year
$yesterday = date('Y-m-d', strtotime('-1 day'));
$firstDayLastMonth = date('Y-m-01', strtotime('first day of last month'));
$lastDayLastMonth = date('Y-m-t', strtotime('last day of last month'));
$current_year = date('Y');
$firstDayOfYear = date('Y') .'-01-01';
$lastDayOfYear = date('Y') .'-12-31';
$lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
$user_id = $_SESSION['user']['id'];
$depot = $_SESSION['user']['depot'];


$sql_last_week_production_receive = '
SELECT dates.ji_date as date_info,
       DATE_FORMAT(dates.ji_date, "%a") AS day_short_name,
       IFNULL(SUM(pm.item_in), 0) AS daily_total_amount
FROM (
    SELECT CURDATE() AS ji_date
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 1 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 2 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 3 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 4 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 5 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 6 DAY)
) AS dates
LEFT JOIN journal_item pm ON dates.ji_date = DATE(pm.ji_date)
    AND pm.tr_from IN ("Production Receive")
    AND YEAR(pm.ji_date) = YEAR(CURDATE())
GROUP BY dates.ji_date
ORDER BY dates.ji_date DESC';

$sql_last_week_production_receive_qry = db_query($sql_last_week_production_receive);

$production_receive_data = array();  

while($row = mysqli_fetch_object($sql_last_week_production_receive_qry)) {
	
    $production_receive_data[] = $row; 
}

$sql_last_week_consumption = '
SELECT dates.ji_date as date_info,
       DATE_FORMAT(dates.ji_date, "%a") AS day_short_name,
       IFNULL(SUM(pm.item_ex), 0) AS daily_total_amount
FROM (
    SELECT CURDATE() AS ji_date
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 1 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 2 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 3 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 4 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 5 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 6 DAY)
) AS dates
LEFT JOIN journal_item pm ON dates.ji_date = DATE(pm.ji_date)
    AND pm.tr_from IN ("Consumption")
    AND YEAR(pm.ji_date) = YEAR(CURDATE())
GROUP BY dates.ji_date
ORDER BY dates.ji_date DESC';

$sql_last_week_consumption_qry = db_query($sql_last_week_consumption);

$consumption_data = array();  

while($row = mysqli_fetch_object($sql_last_week_consumption_qry)) {
	
    $consumption_data[] = $row; 
}



$requisition_yesterday=find_a_field('master_requisition_master ','count( distinct req_no)','1 and req_date ="'.$yesterday.'" and status NOT IN ("MANUAL","CANCELED","STOPPED")');
$requisition_yesterday_qty=find_a_field('master_requisition_details pi, master_requisition_master pm','SUM(pi.qty)','1 and pi.req_no = pm.req_no and pm.req_date ="'.$yesterday.'" and pm.status NOT IN ("MANUAL","CANCELED","STOPPED")');

$requisition_last_week=find_a_field('master_requisition_master ','count( distinct req_no)','1 and req_date between "'.$lastdays.'" and "'.$yesterday.'" and status NOT IN ("MANUAL","CANCELED","STOPPED")');
$requisition_last_week_qty=find_a_field('master_requisition_details pi, master_requisition_master pm','SUM(pi.qty)','1 and pi.req_no = pm.req_no and pm.req_date  between "'.$lastdays.'" and "'.$yesterday.'" and pm.status NOT IN ("MANUAL","CANCELED","STOPPED")');

$requisition_last_month=find_a_field('master_requisition_master ','count( distinct req_no)','1 and req_date between "'.$firstDayLastMonth.'" and "'.$lastDayLastMonth.'" and status NOT IN ("MANUAL","CANCELED","STOPPED")');
$requisition_last_month_qty=find_a_field('master_requisition_details pi, master_requisition_master pm','SUM(pi.qty)','1 and pi.req_no = pm.req_no and pm.req_date   between "'.$firstDayLastMonth.'" and "'.$lastDayLastMonth.'" and pm.status NOT IN ("MANUAL","CANCELED","STOPPED")');

$requisition_current_year=find_a_field('master_requisition_master ','count( distinct req_no)','1 and YEAR(req_date) ="'.$current_year.'" and status NOT IN ("MANUAL","CANCELED","STOPPED")');
$requisition_current_year_qty=find_a_field('master_requisition_details pi, master_requisition_master pm','SUM(pi.qty)','1 and pi.req_no = pm.req_no and YEAR(pm.req_date) ="'.$current_year.'" and pm.status NOT IN ("MANUAL","CANCELED","STOPPED")');


$production_receive_yesterday=find_a_field('journal_item','count(distinct sr_no)','1 and tr_from IN ("Production Receive") and ji_date ="'.$yesterday.'"');
$production_receive_yesterday_qty=find_a_field('journal_item ','sum(item_in)','1 and tr_from IN ("Production Receive") and ji_date ="'.$yesterday.'"');

$production_receive_last_week=find_a_field('journal_item','count(distinct sr_no)','1 and tr_from IN ("Production Receive") and ji_date between "'.$lastdays.'" and "'.$yesterday.'"');
$production_receive_last_week_qty=find_a_field('journal_item ','sum(item_in)','1 and tr_from IN ("Production Receive") and ji_date between "'.$lastdays.'" and "'.$yesterday.'"');

$production_receive_last_month=find_a_field('journal_item','count(distinct sr_no)','1 and tr_from IN ("Production Receive") and ji_date between "'.$firstDayLastMonth.'" and "'.$lastDayLastMonth.'"');
$production_receive_last_month_qty=find_a_field('journal_item ','sum(item_in)','1 and tr_from IN ("Production Receive") and ji_date between "'.$firstDayLastMonth.'" and "'.$lastDayLastMonth.'"');

$production_receive_current_year=find_a_field('journal_item','count(distinct sr_no)','1 and tr_from IN ("Production Receive") and YEAR(ji_date) ="'.$current_year.'"');
$production_receive_current_year_qty=find_a_field('journal_item ','sum(item_in)','1 and tr_from IN ("Production Receive") and YEAR(ji_date) ="'.$current_year.'"');


$consumption_yesterday=find_a_field('journal_item','count(distinct item_id)','1 and tr_from IN ("Consumption") and ji_date ="'.$yesterday.'"');
$consumption_yesterday_qty=find_a_field('journal_item ','sum(item_ex)','1 and tr_from IN ("Consumption") and ji_date ="'.$yesterday.'"');

$consumption_last_week=find_a_field('journal_item','count(distinct item_id)','1 and tr_from IN ("Consumption") and ji_date between "'.$lastdays.'" and "'.$yesterday.'"');
$consumption_last_week_qty=find_a_field('journal_item ','sum(item_ex)','1 and tr_from IN ("Consumption") and ji_date between "'.$lastdays.'" and "'.$yesterday.'"');

$consumption_last_month=find_a_field('journal_item','count(distinct item_id)','1 and tr_from IN ("Consumption") and ji_date between "'.$firstDayLastMonth.'" and "'.$lastDayLastMonth.'"');
$consumption_last_month_qty=find_a_field('journal_item ','sum(item_ex)','1 and tr_from IN ("Consumption") and ji_date between "'.$firstDayLastMonth.'" and "'.$lastDayLastMonth.'"');

$consumption_current_year=find_a_field('journal_item','count(distinct item_id)','1 and tr_from IN ("Consumption") and YEAR(ji_date) ="'.$current_year.'"');
$consumption_current_year_qty=find_a_field('journal_item ','sum(item_ex)','1 and tr_from IN ("Consumption") and YEAR(ji_date) ="'.$current_year.'"');


$transfer_yesterday=find_a_field('journal_item','count(distinct sr_no)','1 and tr_from IN ("fg_transfer") and ji_date ="'.$yesterday.'"');
$transfer_yesterday_qty=find_a_field('journal_item ','sum(item_ex)','1 and tr_from IN ("fg_transfer") and ji_date ="'.$yesterday.'"');

$transfer_last_week=find_a_field('journal_item','count(distinct sr_no)','1 and tr_from IN ("fg_transfer") and ji_date between "'.$lastdays.'" and "'.$yesterday.'"');
$transfer_last_week_qty=find_a_field('journal_item ','sum(item_ex)','1 and tr_from IN ("fg_transfer") and ji_date between "'.$lastdays.'" and "'.$yesterday.'"');

$transfer_last_month=find_a_field('journal_item','count(distinct sr_no)','1 and tr_from IN ("fg_transfer") and ji_date between "'.$firstDayLastMonth.'" and "'.$lastDayLastMonth.'"');
$transfer_last_month_qty=find_a_field('journal_item ','sum(item_ex)','1 and tr_from IN ("fg_transfer") and ji_date between "'.$firstDayLastMonth.'" and "'.$lastDayLastMonth.'"');

$transfer_current_year=find_a_field('journal_item','count(distinct sr_no)','1 and tr_from IN ("fg_transfer") and YEAR(ji_date) ="'.$current_year.'"');
$transfer_current_year_qty=find_a_field('journal_item ','sum(item_ex)','1 and tr_from IN ("fg_transfer") and YEAR(ji_date) ="'.$current_year.'"');





function getMonthlyProductionReceive($month, $year) {
    $start_date = date("$year-$month-01");
    $end_date = date("$year-$month-t"); 

    return $new_production_amount = find_a_field('journal_item','sum(item_in)','1 AND ji_date BETWEEN "' . $start_date . '" AND "' . $end_date . '" AND tr_from IN ("Production Receive")');
	
}

function getYearlyProductionReceive($year) {
    $productionData = [];
    
    for ($month = 1; $month <= 12; $month++) {
        $formattedMonth = str_pad($month, 2, '0', STR_PAD_LEFT);
        
        $productionData[$formattedMonth] = getMonthlyProductionReceive($formattedMonth, $year);
    }
    
    return $productionData;
}


$yearlyProduction = getYearlyProductionReceive(date('Y'));

$productionJan = $yearlyProduction['01'];
$productionFeb = $yearlyProduction['02'];
$productionMar = $yearlyProduction['03'];
$productionApr = $yearlyProduction['04'];
$productionMay = $yearlyProduction['05'];
$productionJun = $yearlyProduction['06'];
$productionJul = $yearlyProduction['07'];
$productionAug = $yearlyProduction['08'];
$productionSep = $yearlyProduction['09'];
$productionOct = $yearlyProduction['10'];
$productionNov = $yearlyProduction['11'];
$productionDec = $yearlyProduction['12'];


function getMonthlyConsumption($month, $year) {
    $start_date = date("$year-$month-01");
    $end_date = date("$year-$month-t"); 

    return $new_production_amount = find_a_field('journal_item','sum(item_ex)','1 AND ji_date BETWEEN "' . $start_date . '" AND "' . $end_date . '" AND tr_from IN ("Consumption")');
}

function getYearlyConsumption($year) {
    $consumptionData = [];
    
    for ($month = 1; $month <= 12; $month++) {
        $formattedMonth = str_pad($month, 2, '0', STR_PAD_LEFT);
        
        $consumptionData[$formattedMonth] = getMonthlyConsumption($formattedMonth, $year);
    }
    
    return $consumptionData;
}

$yearlyConsumption = getYearlyConsumption(date('Y'));

$consumptionJan = $yearlyConsumption['01'];
$consumptionFeb = $yearlyConsumption['02'];
$consumptionMar = $yearlyConsumption['03'];
$consumptionApr = $yearlyConsumption['04'];
$consumptionMay = $yearlyConsumption['05'];
$consumptionJun = $yearlyConsumption['06'];
$consumptionJul = $yearlyConsumption['07'];
$consumptionAug = $yearlyConsumption['08'];
$consumptionSep = $yearlyConsumption['09'];
$consumptionOct = $yearlyConsumption['10'];
$consumptionNov = $yearlyConsumption['11'];
$consumptionDec = $yearlyConsumption['12'];





$thisYear = date('Y');
$lastYear = date('Y')-1;
$previousYear = date('Y')-2;
$previousLastYear = date('Y')-3;

$thisYearSdate = $thisYear.'-01-01';
$thisYearEdate = $thisYear.'-12-31';
$lastYearSdate = $lastYear.'-01-01';
$lastYearEdate = $lastYear.'-12-31';
$preYearSdate = $previousYear.'-01-01';
$preYearEdate = $previousYear.'-12-31';
$preLastYearSdate = $previousLastYear.'-01-01';
$preLastYearEdate = $previousLastYear.'-12-31';


$thisYearProduction = find_a_field('journal_item','sum(item_in)','ji_date between "'.$thisYearSdate.'" and "'.$thisYearEdate.'" AND tr_from IN ("Production Receive")');
$lastYearProduction = find_a_field('journal_item','sum(item_in)','ji_date between "'.$lastYearSdate.'" and "'.$lastYearEdate.'" AND tr_from IN ("Production Receive")');
$preYearProduction = find_a_field('journal_item','sum(item_in)','ji_date between "'.$preYearSdate.'" and "'.$preYearEdate.'" AND tr_from IN ("Production Receive")');
$preLastYearProduction = find_a_field('journal_item','sum(item_in)','ji_date between "'.$preLastYearSdate.'" and "'.$preLastYearEdate.'"  AND tr_from IN ("Production Receive")');

$thisYearConsumption = find_a_field('journal_item','sum(item_ex)','ji_date between "'.$thisYearSdate.'" and "'.$thisYearEdate.'" AND tr_from IN ("Consumption")');
$lastYearConsumption = find_a_field('journal_item','sum(item_ex)','ji_date between "'.$lastYearSdate.'" and "'.$lastYearEdate.'" AND tr_from IN ("Consumption")');
$preYearConsumption = find_a_field('journal_item','sum(item_ex)','ji_date between "'.$preYearSdate.'" and "'.$preYearEdate.'" AND tr_from IN ("Consumption")');
$preLastYearConsumption = find_a_field('journal_item','sum(item_ex)','ji_date between "'.$preLastYearSdate.'" and "'.$preLastYearEdate.'" AND tr_from IN ("Consumption")');

 

// Query to check if there�s an entry with a matching ID
$firstDayCurrentMonth = date('Y-m-01');
$lastDayCurrentMonth = date('Y-m-t');

$currentMonthlyProductionRec = find_all_field_sql('select sum(item_in) as pro_qty from journal_item where ji_date between "'.$firstDayCurrentMonth.'" and "'.$lastDayCurrentMonth.'" AND tr_from IN ("Production Receive")');
		
$currentMonthlyConsumption = find_all_field_sql('select sum(item_ex) as cons_qty from journal_item where ji_date between "'.$firstDayCurrentMonth.'" and "'.$lastDayCurrentMonth.'" AND tr_from IN ("Consumption")');
		
  






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
						<h5 class="card-title bold">FLOOR REQUISITION <br/> <span>  <?= $yesterday; ?> </span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon primary">
						
						<form action="../..//report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="1" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = $yesterday;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear =$yesterday;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$requisition_yesterday;?>" tabindex="6" />
						  </form>
						
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1">  <span> <?=number_format($requisition_yesterday_qty,2);?> QTY</span></p>
						 </div>
						
						</div>
					
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">PRODUCTION RECEIVE  <br/> <span>  <?=$yesterday; ?></span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../../production_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="261124" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = $yesterday;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear = $yesterday;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$production_receive_yesterday?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($production_receive_yesterday_qty,2);?> QTY </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">RAW CONSUMPTION  <br/> <span>  <?=$yesterday; ?></span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../../production_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="261124" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = $yesterday;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear = $yesterday;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$consumption_yesterday?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($consumption_yesterday_qty,2);?> QTY </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">FG TRANSFER  <br/> <span>  <?=$yesterday; ?></span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../..//report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="31" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = $yesterday;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear = $yesterday;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap;
								 overflow: hidden;" name="submit" type="submit" value="<?=$transfer_yesterday?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($transfer_yesterday_qty,2);?> QTY </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
			
			
			<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">FLOOR REQUISITION <br/> <span> Last Week</span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon primary">
						
						<form action="../..//report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="1" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$lastdays;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$yesterday;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$requisition_last_week;?>" tabindex="6" />
						  </form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1">  <span>  <?=number_format($requisition_last_week_qty,2);?> QTY</span></p>
						 </div>
						
						</div>
					
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">PRODUCTION RECEIVE <br/> <span> Last Week</span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../../production_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="261124" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$lastdays;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$yesterday;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$production_receive_last_week?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($production_receive_last_week_qty,2);?> QTY </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">RAW CONSUMPTION <br/> <span> Last Week</span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../../production_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="261124" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$lastdays;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$yesterday;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$consumption_last_week?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($consumption_last_week_qty,2);?> QTY </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">FG TRANSFER <br/> <span> Last Week</span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../..//report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="31" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$lastdays;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$yesterday;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$transfer_last_week?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($transfer_last_week_qty,2);?> QTY </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
				
				
				
				
				
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">FLOOR REQUISITION <br/> <span>  Last Month</span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon primary">
						
						<form action="../..//report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="1" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayLastMonth;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayLastMonth;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$requisition_last_month;?>" tabindex="6" />
						  </form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1">  <span>  <?=number_format($requisition_last_month_qty,2);?>  QTY</span></p>
						 </div>
						
						</div>
					
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">PRODUCTION RECEIVE  <br/> <span> Last Month</span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../../production_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="261124" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayLastMonth;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayLastMonth;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$production_receive_last_month?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($production_receive_last_month_qty,2);?> QTY </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">RAW CONSUMPTION  <br/> <span> Last Month</span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../../production_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="261124" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayLastMonth;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayLastMonth;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$consumption_last_month?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($consumption_last_month_qty,2);?> QTY </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">FG TRANSFER  <br/> <span> Last Month</span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../..//report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="31" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = date('Y') .'-01-01';?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear = date('Y') .'-12-31';?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$transfer_last_month?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($transfer_last_month_qty,2);?> QTY </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
			
			
			
			
			
			
			
			
						
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">FLOOR REQUISITION <br/> <span> Year <?=$current_year;?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon primary">
						
						<form action="../..//report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="1" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = date('Y') .'-01-01';?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear = date('Y') .'-12-31';?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$requisition_current_year;?>" tabindex="6" />
						  </form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1">  <span>  <?=$requisition_current_year_qty;?> QTY</span></p>
						 </div>
						
						</div>
					
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">PRODUCTION RECEIVE  <br/><span>  Year <?=$current_year;?></span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../../production_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="261124" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = date('Y') .'-01-01';?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear = date('Y') .'-12-31';?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$production_receive_current_year?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($production_receive_current_year_qty,2);?> QTY </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">RAW CONSUMPTION  <br/><span>  Year <?=$current_year;?></span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../../production_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="261124" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = date('Y') .'-01-01';?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear = date('Y') .'-12-31';?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$consumption_current_year?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($consumption_current_year_qty,2);?> QTY </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">FG TRANSFER  <br/><span>  Year <?=$current_year;?></span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../..//report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="31" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = date('Y') .'-01-01';?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear = date('Y') .'-12-31';?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$transfer_current_year?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($transfer_current_year_qty,2);?> QTY </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>


		


			</div>

		
				  
				  <div class="row m-0 p-0">
				  
				  
					  <!--1st chart-->
						<div class="col-lg-6 col-md-12 p-2 mt-2">
							<div class="card card-chart">
								<div class="card-body">
									<h5 class="card-title bold">MONTHLY PRODUCTION CHART<span> OF <?php echo date("Y"); ?></span></h5>
								</div>
								<div class="card-header">
										<canvas id="oilChart" width="600" height="400"></canvas>
								</div>
							</div>
						</div>
						
						
						<!--2nd chart-->
					  <div class="col-lg-6 col-md-12 p-2 mt-2">
						<div class="card card-chart">
							<div class="card-body">
								<h4 class="card-title bold">ONE WEEK PRODUCTION CHART<span> OF <?php echo date("Y"); ?></span></h4>
						  </div>
					
							<div class="card-header">
							  <canvas id="chart_0" style="height: 321px !important;width: 482px;" width="650" height="321"></canvas>
							</div>
			
					   </div>
					</div>
						
		
						
										
						<!--3rd chart-->	
						<div class="col-lg-6 col-md-12 p-2">
							<div class="card card-chart">
								<div class="card-body">
									<h5 class="card-title bold">ONE YEAR PRODUCTION REPORTS<span> OF <?php echo date("Y"); ?></span></h5>
							  </div>
								<div class="card-header">
											<canvas id="onemounth" style="height: 367px!important; width: 482px;" width="650" height="367"></canvas>
		
								</div>
							</div>
						</div>
		
					
				
						<!--4th chart-->	
						<div class="col-lg-6 col-md-12 p-2">
							<div class="card card-chart">
								<div class="card-body">
								<h5 class="card-title bold">LAST 4 YEAR PRODUCTION REPORTS<span> OF <?php echo date("Y"); ?></span></h5>
							  </div>
								<div class="card-header">
											<canvas id="oneweek" style="width: 482px; height: 367px;" width="650" height="367"></canvas>
								</div>
							</div>
						</div>
					
		
					  </div>
</div>



		



 <!--///////////////////////////////////////////chart start values ////////////////////////////////////////////////////////////////-->

<script type="text/javascript">

///////////// 1st chart//////////////////
var mProductionReceive = <?=$currentMonthlyProductionRec->pro_qty;?>;
var mConsumption = <?=$currentMonthlyConsumption->cons_qty;?>;
var oilCanvas = document.getElementById("oilChart");

Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var oilData = {
    labels: [
        "Production Receive",
        "Consumption"

    ],
    datasets: [
        {
            data: [mProductionReceive, mConsumption],
            backgroundColor: [
                "#008fa1",
                "#5b995e"
            ]
        }]

};

var pieChart = new Chart(oilCanvas, {
  type: 'pie',
  data: oilData
});






///////////// 2nd chart//////////////////

    var labels = [
        <?php foreach ($production_receive_data as $data) { echo '"' . $data->date_info . '", '; } ?> 
    ];

    var receiveData = [
        <?php foreach ($production_receive_data as $data) { echo $data->daily_total_amount . ', '; } ?>
    ];
	
	var consumptionData = [
        <?php foreach ($consumption_data as $data) { echo $data->daily_total_amount . ', '; } ?>
    ];

    // Define chart data with dynamically populated values
    var data = {
        labels: labels,
        datasets: [
            {
                label: "Production Receive",
                backgroundColor: "#fb9006",
                borderColor: "#fb9006",
                borderWidth: 2,
                hoverBackgroundColor: "#fb9006",
                hoverBorderColor: "#fb9006",
                data: receiveData
            },
            {
                label: "Consumption",
                backgroundColor: "#008fa1",
                borderColor: "#008fa1",
                borderWidth: 2,
                hoverBackgroundColor: "#008fa1",
                hoverBorderColor: "#008fa1",
                data: consumptionData // data
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
            },
            ticks: {
                fontSize: 10 // Set font size for x-axis labels
            }
        }]
        },
        legend: {
            display: true,
            labels: {
                fontColor: "#333",
                fontSize: 15
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
	



    var receiveYData = [<?=$productionJan?>, <?=$productionFeb?>, <?=$productionMar?>, <?=$productionApr?>, <?=$productionMay?>, <?=$productionJun?>, 
	<?=$productionJul?>, <?=$productionAug?>, <?=$productionSep?>, <?=$productionOct?>, <?=$productionNov?>, <?=$productionDec?>];

    var consuptionYData = [<?=$consumptionJan?>, <?=$consumptionFeb?>, <?=$consumptionMar?>, <?=$consumptionApr?>, <?=$consumptionMay?>, <?=$consumptionJun?>, 
	<?=$consumptionJul?>, <?=$consumptionAug?>, <?=$consumptionSep?>, <?=$consumptionOct?>, <?=$consumptionNov?>, <?=$consumptionDec?>];


    var ctx = document.getElementById("onemounth").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [
                {
                    label: 'Production Receive',
                    data: receiveYData,
                    fill: false,
                    borderColor: '#fb9006',
                    backgroundColor: '#fb9006',
                    borderWidth: 2
                },
                {
                    label: 'Consumption',
                    data: consuptionYData,
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


    var cproduction =  <?= !empty($thisYearProduction) ? $thisYearProduction : 0 ?>;
    var oproduction = <?= !empty($lastYearProduction) ? $lastYearProduction : 0 ?> ; 
    var ooproduction = <?= !empty($preYearProduction) ? $preYearProduction : 0 ?> ;
	var oooproduction = <?= !empty($preLastYearProduction) ? $preLastYearProduction : 0 ?> ; 
	
	var cconsumption =  <?= !empty($thisYearConsumption) ? $thisYearConsumption : 0 ?>;
    var oconsumption = <?= !empty($lastYearConsumption) ? $lastYearConsumption : 0 ?> ; 
    var ooconsumption = <?= !empty($preYearConsumption) ? $preYearConsumption : 0 ?> ;
	var oooconsumption = <?= !empty($preLastYearConsumption) ? $preLastYearConsumption : 0 ?> ; 

    var chartColors = {
        yellow: '#008fa1',
        green: '#fb9006'
    };

    var data = {
        labels: ["<?=$thisYear;?>", "<?=$lastYear;?>", "<?=$previousYear;?>", "<?=$previousLastYear;?>"],
        datasets: [
            {
                label: 'Consumption',
                backgroundColor: [
                    chartColors.yellow,
                    chartColors.yellow,
                    chartColors.yellow,
                    chartColors.yellow
                ],
                data: [cconsumption, oconsumption, ooconsumption, oooconsumption]  
            },
            {
                label: 'Production Receive',
				backgroundColor: [
                    chartColors.green,
                    chartColors.green,
                    chartColors.green,
                    chartColors.green
                ],
                data: [cproduction, oproduction, ooproduction, oooproduction]  
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
                        suggestedMax: 8000000  // Keeps the range appropriate for values between 3000 and 4000
                    }
                }]
            }
        }
    });

</script>


   
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>