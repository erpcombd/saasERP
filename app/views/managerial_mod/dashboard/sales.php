<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";
$title = "Sales Management Dashboard";
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


$sql_last_week_sales = '
SELECT dates.ji_date as date_info,
       DATE_FORMAT(dates.ji_date, "%a") AS day_short_name,
       IFNULL(SUM(pi.total_amt), 0) AS daily_total_amount
FROM (
    SELECT CURDATE() AS ji_date
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 1 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 2 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 3 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 4 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 5 DAY)
    UNION ALL SELECT DATE_SUB(CURDATE(), INTERVAL 6 DAY)
) AS dates
LEFT JOIN sale_do_master pm ON dates.ji_date = DATE(pm.do_date)
    AND pm.status IN ("CHECKED","COMPLETED")
    AND YEAR(pm.do_date) = YEAR(CURDATE())
LEFT JOIN sale_do_details pi ON pi.do_no = pm.do_no
GROUP BY dates.ji_date
ORDER BY dates.ji_date DESC';

$sql_last_week_sales_qry = db_query($sql_last_week_sales);

$sales_data = array();  

while($row = mysqli_fetch_object($sql_last_week_sales_qry)) {
	
    $sales_data[] = $row; 
}





$sales_order_current_year=find_a_field('sale_do_master ','count( distinct do_no)','1 and YEAR(do_date) ="'.$current_year.'" and status in ("CHECKED","COMPLETED")');
$sales_order_current_year_amount=find_a_field('sale_do_details pi, sale_do_master pm','SUM(pi.total_amt)','1 and pi.do_no = pm.do_no and YEAR(pm.do_date) ="'.$current_year.'" and pm.status IN ("CHECKED","COMPLETED")');


$sales_order_yesterday=find_a_field('sale_do_master ','count( distinct do_no)','1 and do_date ="'.$yesterday.'" and status in ("CHECKED","COMPLETED")');
$sales_order_yesterday_amount=find_a_field('sale_do_details pi, sale_do_master pm','SUM(pi.total_amt)','1 and pi.do_no = pm.do_no and pm.do_date ="'.$yesterday.'" and pm.status IN ("CHECKED","COMPLETED")');

$sales_order_last_week=find_a_field('sale_do_master ','count( distinct do_no)','1 and do_date between "'.$lastdays.'" and "'.$yesterday.'" and status in ("CHECKED","COMPLETED")');
$sales_order_last_week_amount=find_a_field('sale_do_details pi, sale_do_master pm','SUM(pi.total_amt)','1 and pi.do_no = pm.do_no and pm.do_date between "'.$lastdays.'" and "'.$yesterday.'" and pm.status IN ("CHECKED","COMPLETED")');

$sales_order_last_month=find_a_field('sale_do_master ','count( distinct do_no)','1 and do_date between "'.$firstDayLastMonth.'" and "'.$lastDayLastMonth.'" and status in ("CHECKED","COMPLETED")');
$sales_order_last_month_amount=find_a_field('sale_do_details pi, sale_do_master pm','SUM(pi.total_amt)','1 and pi.do_no = pm.do_no and pm.do_date between "'.$firstDayLastMonth.'" and "'.$lastDayLastMonth.'" and pm.status IN ("CHECKED","COMPLETED")');

$sales_chalan_yesterday=find_a_field('sale_do_chalan ','count( distinct do_no)','1 and chalan_date ="'.$yesterday.'"');
$sales_chalan_yesterday_amount=find_a_field('sale_do_chalan ','sum(total_amt)','1 and chalan_date ="'.$yesterday.'"');

$sales_chalan_last_week=find_a_field('sale_do_chalan ','count( distinct do_no)','1 and chalan_date between "'.$lastdays.'" and "'.$yesterday.'"');
$sales_chalan_last_week_amount=find_a_field('sale_do_chalan ','sum(total_amt)','1 and chalan_date between "'.$lastdays.'" and "'.$yesterday.'"');

$sales_chalan_last_month=find_a_field('sale_do_chalan ','count( distinct do_no)','1 and chalan_date between "'.$firstDayLastMonth.'" and "'.$lastDayLastMonth.'"');
$sales_chalan_last_month_amount=find_a_field('sale_do_chalan ','sum(total_amt)','1 and chalan_date between "'.$firstDayLastMonth.'" and "'.$lastDayLastMonth.'"');

$sales_chalan_current_year=find_a_field('sale_do_chalan ','count( distinct do_no)','1 and  YEAR(chalan_date) ="'.$current_year.'"');
$sales_chalan_current_year_amount=find_a_field('sale_do_chalan ','sum(total_amt)','1 and  YEAR(chalan_date) ="'.$current_year.'"');





function getMonthlySales($month, $year) {
    // Get the start and end dates of the specified month
    $start_date = date("$year-$month-01");
    $end_date = date("$year-$month-t"); // 't' gives the last day of the month

    // Query to get the sales total for the month, excluding certain statuses
    return $new_sale_amount = find_a_field('sale_do_master m, sale_do_details d','sum(d.total_amt)', '1 and m.do_date BETWEEN "'.$start_date.'" AND "'.$end_date.'" and m.do_no=d.do_no AND m.status IN ("CHECKED", "COMPLETED")');
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





/* 
 
 $new_local_purchase_order=find_a_field('warehouse_other_receive','count(*)','1 and YEAR(or_date) ="'.$current_year.'" and status="UNCHECKED" and entry_by="'.$_SESSION['user']['id'].'"');
 $receive_order=find_a_field('purchase_receive pr, purchase_master pm','count(pm.po_no)','1 and pm.po_no=pr.po_no and YEAR(rec_date) ="'.$current_year.'" and pm.entry_by="'.$_SESSION['user']['id'].'" group by pm.po_no');
 $purchase_return=find_a_field('purchase_return_master','count(*)','1 and YEAR(pr_date) ="'.$current_year.'"  and entry_by="'.$_SESSION['user']['id'].'"');
 $approved_po=find_a_field('purchase_master ','count(*)','1 and YEAR(po_date) ="'.$current_year.'" and status="CHECKED" and entry_by="'.$_SESSION['user']['id'].'"');



echo '<pre>';
echo 'ddddddddddddd';
echo $purchase_return;
echo 'zzzzzzzzzzzzzzzzzzzzz';
echo '</pre>';*/


//_____________ CALCULATION DASHBOARD LOGIC __________////////




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


$Sat=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$saturday.'" and    status not in ("MANUAL","CANCELED")');
$Sun=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$sunday.'" and status not in ("MANUAL","CANCELED")');
$Mon=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$monday.'" and   status not in ("MANUAL","CANCELED")');
$Tue=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$tuesday.'"   and status not in ("MANUAL","CANCELED")');
$Wed=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$wednesday.'"  and status not in ("MANUAL","CANCELED")');
$Thu=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$thursday.'"  and status not in ("MANUAL","CANCELED")');
$Fri=find_a_field('sale_do_details','sum(total_amt)','do_date="'.$friday.'"  and status not in ("MANUAL","CANCELED")');




$return_sat = find_all_field_sql("select SUM(sd.total_amt)as m from sale_return_master sm, sale_return_details sd where sm.sr_no=sd.sr_no and 
sd.sr_date='".$saturday."' and sm.status IN�('CHECKED')");

$return_sun = find_all_field_sql("select SUM(sd.total_amt)as m from sale_return_master sm, sale_return_details sd where sm.sr_no=sd.sr_no and 
sd.sr_date='".$sunday."' and sm.status IN�('CHECKED')");

$return_mon = find_all_field_sql("select SUM(sd.total_amt)as m from sale_return_master sm, sale_return_details sd where sm.sr_no=sd.sr_no and 
sd.sr_date='".$monday."' and sm.status IN�('CHECKED')");

$return_tue = find_all_field_sql("select SUM(sd.total_amt)as m from sale_return_master sm, sale_return_details sd where sm.sr_no=sd.sr_no and 
sd.sr_date='".$tuesday."' and sm.status IN�('CHECKED')");

$return_wed = find_all_field_sql("select SUM(sd.total_amt)as m from sale_return_master sm, sale_return_details sd where sm.sr_no=sd.sr_no and 
sd.sr_date='".$wednesday."' and sm.status IN�('CHECKED')");

$return_thu = find_all_field_sql("select SUM(sd.total_amt)as m from sale_return_master sm, sale_return_details sd where sm.sr_no=sd.sr_no and 
sd.sr_date='".$thursday."' and sm.status IN�('CHECKED')");

$return_fri = find_all_field_sql("select SUM(sd.total_amt)as m from sale_return_master sm, sale_return_details sd where sm.sr_no=sd.sr_no and 
sd.sr_date='".$friday."' and sm.status IN�('CHECKED')");




// Usage example for the current year
$yearlySales = getYearlySales(date('Y'));

// Access sales data for each month
$salesJan = $yearlySales['01'];
$salesFeb = $yearlySales['02'];
$salesMar=$yearlySales['03'];
$salesApr=$yearlySales['04'];
$salesMay=$yearlySales['05'];
$salesJun=$yearlySales['06'];
$salesJul=$yearlySales['07'];
$salesAug=$yearlySales['08'];
$salesSep= $yearlySales['09'];
$salesOct= $yearlySales['10'];
$salesNov= $yearlySales['11'];
$salesDec= $yearlySales['12'];

$srJan = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$jan_start.'" AND "'.$jan_end.'" AND m.status = "CHECKED"'
);

$srFeb = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$feb_start.'" AND "'.$feb_end.'" AND m.status = "CHECKED"'
);

$srMar = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$mar_start.'" AND "'.$mar_end.'" AND m.status = "CHECKED"'
);

$srApr = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$apr_start.'" AND "'.$apr_end.'" AND m.status = "CHECKED"'
);

$srMay = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$may_start.'" AND "'.$may_end.'" AND m.status = "CHECKED"'
);

$srJun = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$jun_start.'" AND "'.$jun_end.'" AND m.status = "CHECKED"'
);

$srJul = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$jul_start.'" AND "'.$jul_end.'" AND m.status = "CHECKED"'
);

$srAug = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$aug_start.'" AND "'.$aug_end.'" AND m.status = "CHECKED"'
);

$srSep = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$sep_start.'" AND "'.$sep_end.'" AND m.status = "CHECKED"'
);

$srOct = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$oct_start.'" AND "'.$oct_end.'" AND m.status = "CHECKED"'
);

$srNov = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$nov_start.'" AND "'.$nov_end.'" AND m.status = "CHECKED"'
);

$srDec = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$dec_start.'" AND "'.$dec_end.'" AND m.status = "CHECKED"'
);






$thisYear = date('Y');
$lastYear = date('Y')-1;
$previousYear = date('Y')-2;
$previousLastYear = date('Y')-3;

$thisYearSdate = $thisYear.'-01-01';
$thisYearEdate = $thisYear.'-12-31';
$thisYearSales = find_a_field(' sale_do_master m, sale_do_details d','sum(d.total_amt)','m.do_date between "'.$thisYearSdate.'" and "'.$thisYearEdate.'" and m.do_no=d.do_no and m.status in ("CHECKED","COMPLETED")');

$thisYearSalesReturn = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$thisYearSdate.'" AND "'.$thisYearEdate.'" AND m.status = "CHECKED"'
);



$lastYearSdate = $lastYear.'-01-01';
$lastYearEdate = $lastYear.'-12-31';
$lastYearSales = find_a_field(' sale_do_master m, sale_do_details d','sum(d.total_amt)','m.do_date between "'.$lastYearSdate.'" and "'.$lastYearEdate.'" and m.do_no=d.do_no and m.status in ("CHECKED","COMPLETED")');

$lastYearSalesReturn = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$lastYearSdate.'" AND "'.$lastYearEdate.'" AND m.status = "CHECKED"'
);

$preYearSdate = $previousYear.'-01-01';
$preYearEdate = $previousYear.'-12-31';
$preYearSales = find_a_field(' sale_do_master m, sale_do_details d','sum(d.total_amt)','m.do_date between '.$preYearSdate.'" and "'.$preYearEdate.'" and m.do_no=d.do_no and m.status in ("CHECKED","COMPLETED")');

$preYearSalesReturn = find_a_field('sale_return_details','sum(total_amt)','sr_date between "'.$preYearSdate.'" and "'.$preYearEdate.'"');



$preLastYearSdate = $previousLastYear.'-01-01';
$preLastYearEdate = $previousLastYear.'-12-31';
$preLastYearSales = find_a_field(' sale_do_master m, sale_do_details d','sum(d.total_amt)','m.do_date between "'.$preLastYearSdate.'" and "'.$preLastYearEdate.'" and m.do_no=d.do_no and m.status in ("CHECKED","COMPLETED")');

$preLastSalesReturn = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "'.$preLastYearSdate.'" AND "'.$preLastYearEdate.'" AND m.status = "CHECKED"'
);



/*___________ 7 DAYS Sales report____________*/


$sales7days = find_a_field('sale_do_details','sum(total_amt)','do_date between "'.$lastdays.'" and "'.$today.'" and depot_id="'.$_SESSION['user']['depot'].'" 
and status not in ("MANUAL","CANCELED")');



$YearlyPosSales = find_a_field('warehouse_other_issue m, warehouse_other_issue_detail s','sum(amount)','m.oi_date between "' . $current_year . '-01-01" 
and "'.$thisYearEdate.'"  and m.status not in ("MANUAL","CANCELED") and m.issue_type="DirectSales" and m.oi_no=s.oi_no');
		 

$CountPosSales = find_a_field('warehouse_other_issue m, warehouse_other_issue_detail s','COUNT(m.oi_no)','m.oi_date between "' . $current_year . '-01-01" 
and "'.$thisYearEdate.'"  and m.status not in ("MANUAL","CANCELED") and m.issue_type="DirectSales" and m.oi_no=s.oi_no');
		 
		 
$YearlyLocalSales = find_a_field('warehouse_other_issue m, warehouse_other_issue_detail s','sum(amount)','m.oi_date between "' . $current_year . '-01-01" 
and "'.$today.'"  and m.status not in ("MANUAL","CANCELED") and m.issue_type="Local Sales" and m.oi_no=s.oi_no');

$CountYearlyLocalSales = find_a_field('warehouse_other_issue m, warehouse_other_issue_detail s','COUNT(m.oi_no)','m.oi_date between "' . $current_year . '-01-01" 
and "'.$thisYearEdate.'"  and m.status not in ("MANUAL","CANCELED") and m.issue_type="Local Sales" and m.oi_no=s.oi_no');


$sales_return_value = find_a_field(
    'sale_return_details s, sale_return_master m',
    'SUM(s.total_amt)',
    's.sr_no = m.sr_no AND s.sr_date BETWEEN "' . $current_year . '-01-01"  AND "'.$thisYearEdate.'" AND m.status = "CHECKED"'
);



$count_return_value = find_a_field('sale_return_master','COUNT(sr_no)','sr_date BETWEEN "' . $current_year . '-01-01"  AND "'.$thisYearEdate.'" 
AND status = "CHECKED"');



 
/*$YearlySales = find_a_field('sale_do_details','sum(total_amt)','1 YEAR(do_date) ="'.$current_year.'" and depot_id="'.$_SESSION['user']['depot'].'" and status not in ("MANUAL","CANCELED")');*/



/* $new_purchase_order=find_a_field('purchase_master ','count(*)','1 and YEAR(po_date) ="'.$current_year.'" and status="UNCHECKED" 
 and entry_by="'.$_SESSION['user']['id'].'"');*/
 

// Query to check if there�s an entry with a matching ID
$has_entry = find_a_field('sale_do_details', 'COUNT(*)', 'entry_by = "' . $user_id . '"');

if ($has_entry > 0) {

        $YearlySales = find_all_field_sql("select COUNT(DISTINCT m.do_no)as do_no, SUM(b.total_amt) as sales_amt from sale_do_master m LEFT JOIN sale_do_details b ON m.do_no=b.do_no where 1 and m. do_date>='".$current_year.'-01-01'."'  and m.status in ('CHECKED','COMPLETED')");

      /*  $YearlyPosSales = find_a_field('sale_pos_details s, sale_pos_master m','SUM(s.total_amt)','s.pos_date BETWEEN "' . $current_year . '-01-01" AND "'
		 . $today . '" AND s.entry_by = "' . $user_id . '" AND m.status NOT IN ("MANUAL", "CANCELED") AND m.pos_id = s.pos_id');*/
  
     
} else {

                $YearlySales = find_all_field_sql("select COUNT(DISTINCT m.do_no)as do_no, SUM(b.total_amt) as sales_amt from sale_do_master m LEFT JOIN sale_do_details b ON m.do_no=b.do_no where 1 and m. do_date>='".$current_year.'-01-01'."'  and m.status in ('CHECKED','COMPLETED')");

       }





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
						<h5 class="card-title bold">TOTAL SALES <span> || <?= $yesterday; ?> </span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon primary">
						
						<form action="../../sales_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="1" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = $yesterday;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear =$yesterday;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$sales_order_yesterday;?>" tabindex="6" />
							</form>
						
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1">  <span> <?=number_format($sales_order_yesterday_amount,2);?> <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
					
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">SALES CHALAN <span> || <?=$yesterday; ?></span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../../sales_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="31" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = $yesterday;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear = $yesterday;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$sales_chalan_yesterday?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($sales_chalan_yesterday_amount,2);?><i class="fa-solid fa-bangladeshi-taka-sign"></i> </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">LOCAL SALES<span> || <?= $yesterday; ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger"><?= !empty($CountYearlyLocalSales) ? $CountYearlyLocalSales : 0 ?></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
					<p class="p-sub1"> <span> <?= !empty($YearlyLocalSales) ? $YearlyLocalSales : 0 ?>  <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
						
					
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">SALES RETURN<span> || <?= $yesterday; ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon info"><?= !empty($count_return_value) ? $count_return_value : 0 ?></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1">  <span> <?= !empty($sales_return_value) ? $sales_return_value : 0 ?> <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
						
					
					  </div>
					</div>
				</div>
			
			
			
			<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">TOTAL SALES <span> || Last Week</span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon primary">
						
						<form action="../../sales_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="1" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$lastdays;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$yesterday;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$sales_order_last_week;?>" tabindex="6" />
							</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1">  <span>  <?=number_format($sales_order_last_week_amount,2);?>  <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
					
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">SALES CHALAN <span> || Last Week</span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../../sales_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="31" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$lastdays;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$yesterday;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$sales_chalan_last_week?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($sales_chalan_last_week_amount,2);?><i class="fa-solid fa-bangladeshi-taka-sign"></i> </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">LOCAL SALES<span> || Last Week</span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger"><?= !empty($CountYearlyLocalSales) ? $CountYearlyLocalSales : 0 ?></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
					<p class="p-sub1"> <span> <?= !empty($YearlyLocalSales) ? $YearlyLocalSales : 0 ?>  <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
						
					
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">SALES RETURN<span> || Last Week</span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon info"><?= !empty($count_return_value) ? $count_return_value : 0 ?></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1">  <span> <?= !empty($sales_return_value) ? $sales_return_value : 0 ?> <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
						
					
					  </div>
					</div>
				</div>
				
				
				
				
				
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">TOTAL SALES <span> || Last Month</span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon primary">
						
						<form action="../../sales_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="1" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayLastMonth;?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayLastMonth;?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$sales_order_last_month;?>" tabindex="6" />
							</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1">  <span>  <?=number_format($sales_order_last_month_amount,2);?>  <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
					
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">SALES CHALAN<span> || Last Month</span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../../sales_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="31" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = date('Y') .'-01-01';?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear = date('Y') .'-12-31';?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$sales_chalan_last_month?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($sales_chalan_last_month_amount,2);?><i class="fa-solid fa-bangladeshi-taka-sign"></i> </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">LOCAL SALES<span> || Last Month</span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger"><?= !empty($CountYearlyLocalSales) ? $CountYearlyLocalSales : 0 ?></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
					<p class="p-sub1"> <span> <?= !empty($YearlyLocalSales) ? $YearlyLocalSales : 0 ?>  <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
						
					
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">SALES RETURN<span> || Last Month</span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon info"><?= !empty($count_return_value) ? $count_return_value : 0 ?></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1">  <span> <?= !empty($sales_return_value) ? $sales_return_value : 0 ?> <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
						
					
					  </div>
					</div>
				</div>
			
			
			
			
			
			
			
			
			
						
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">TOTAL SALES <span> || Year <?=$current_year;?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon primary">
						
						<form action="../../sales_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="1" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = date('Y') .'-01-01';?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear = date('Y') .'-12-31';?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$sales_order_current_year;?>" tabindex="6" />
							</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1">  <span>  <?=$sales_order_current_year_amount;?>  <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
					
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">SALES CHALAN<span> || Year <?=$current_year;?></span></h5>
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger">
						<form action="../../sales_mod/report/master_report.php" method="post" name="form1" target="_blank" id="form1">
								<input name="report" type="hidden" class="radio1" id="report1-btn" value="31" tabindex="1"/>
								<input name="f_date" type="hidden" id="f_date" value="<?=$firstDayOfYear = date('Y') .'-01-01';?>" />
								<input name="t_date" type="hidden" id="t_date" value="<?=$lastDayOfYear = date('Y') .'-12-31';?>" />
								<input style="background: none; border: none; text-align: left; font-size: 18px !important; color:blue; white-space: nowrap; overflow: hidden;" 
								name="submit" type="submit" value="<?=$sales_chalan_current_year?>" tabindex="6" />
						</form>
						
						</div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1"><span><?=number_format($sales_chalan_current_year_amount,2);?><i class="fa-solid fa-bangladeshi-taka-sign"></i> </span></p>
						 </div>
						
						</div>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">LOCAL SALES<span> || Year <?=$current_year;?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger"><?= !empty($CountYearlyLocalSales) ? $CountYearlyLocalSales : 0 ?></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
					<p class="p-sub1"> <span> <?= !empty($YearlyLocalSales) ? $YearlyLocalSales : 0 ?>  <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
						 </div>
						
						</div>
						
					
					  </div>
					</div>
				</div>
			
				<div class="col-lg-3 col-md-3 col-sm-12 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">SALES RETURN<span> || Year <?=$current_year;?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon info"><?= !empty($count_return_value) ? $count_return_value : 0 ?></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">&nbsp;</p>
							<p class="p-sub1">  <span> <?= !empty($sales_return_value) ? $sales_return_value : 0 ?> <i class="fa-solid fa-bangladeshi-taka-sign"></i></span></p>
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
									<h5 class="card-title bold">MONTHLY SALES CHART<span> OF <?php echo date("Y"); ?></span></h5>
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
								<h4 class="card-title bold">ONE WEEK SALES CHART<span> OF <?php echo date("Y"); ?></span></h4>
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
									<h5 class="card-title bold">ONE YEAR SALES REPORTS<span> OF <?php echo date("Y"); ?></span></h5>
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
								<h5 class="card-title bold">LAST 4 YEAR SALES REPORTS<span> OF <?php echo date("Y"); ?></span></h5>
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
var mSalesChart = <?=$YearlySales->sales_amt;?>;
var lSalesChart = <?php echo isset($YearlyLocalSales) ? $YearlyLocalSales : 0; ?>;
var salesReturnChart = <?php echo isset($sales_return_value) ? $sales_return_value : 0; ?>;
var oilCanvas = document.getElementById("oilChart");

Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var oilData = {
    labels: [
        "Sales",
        "Local Sales",
        "Return"
    ],
    datasets: [
        {
            data: [mSalesChart, lSalesChart, salesReturnChart],
            backgroundColor: [
                "#008fa1",
                "#5b995e",
                "#fb9006"
            ]
        }]

};

var pieChart = new Chart(oilCanvas, {
  type: 'pie',
  data: oilData
});



/*///////////// 2nd chart//////////////////
    // Set fixed data values for each label between 1000 and 7000

    var SalesData =  [<?=$Sat?>, <?=$Sun?>, <?=$Mon?>, <?=$Tue?>, <?=$Wed?>, <?=$Thu?>, <?=$Fri?>];
    var ReturnData = [<?=$return_sat->m?>, <?=$return_sun->m?>, <?=$return_mon->m?>, <?=$return_tue->m?>, <?=$return_wed->m?>, 
	<?=$return_thu->m?>, <?=$return_fri->m?>];
    
    var data = {
        labels: ["Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri"],
        datasets: [
            {
                label: "Sales",
                backgroundColor: "#fb9006",  // Soft teal background
                borderColor: "#fb9006",         // Teal border
                borderWidth: 2,
                hoverBackgroundColor: "#fb9006", // Soft blue hover
                hoverBorderColor: "#fb9006",     // Blue hover border
                data: SalesData
            },
            {
                label: "Sales Return",
                backgroundColor: "#008fa1",   // Soft orange background
                borderColor: "#008fa1",          // Orange border
                borderWidth: 2,
                hoverBackgroundColor: "#008fa1", // Soft red hover
                hoverBorderColor: "#008fa1",     // Red hover border
                data: ReturnData
            }
        ]
    };

    var option = {
        scales: {
            yAxes: [{
                stacked: false,  // Set to false for separate bars
                gridLines: {
                    display: true,
                    color: "rgba(220, 220, 220, 0.3)"  // Light grey grid lines
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
                fontColor: "#333",  // Dark grey for legend text
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

*/




///////////// 2nd chart//////////////////
    // Set fixed data values for each label between 1000 and 7000
    // Extract labels and data dynamically from PHP array
    var labels = [
        <?php foreach ($sales_data as $data) { echo '"' . $data->date_info . '", '; } ?> //.$data->day_short_name
    ];

    var saleData = [
        <?php foreach ($sales_data as $data) { echo $data->daily_total_amount . ', '; } ?>
    ];
	
	var saleReturnData = [
        <?php foreach ($saleReturnData as $data) { echo $data->daily_total_amount . ', '; } ?>
    ];

    // Define chart data with dynamically populated values
    var data = {
        labels: labels,
        datasets: [
            {
                label: "Sale",
                backgroundColor: "#fb9006",
                borderColor: "#fb9006",
                borderWidth: 2,
                hoverBackgroundColor: "#fb9006",
                hoverBorderColor: "#fb9006",
                data: saleData
            },
            {
                label: "Sales Return",
                backgroundColor: "#008fa1",
                borderColor: "#008fa1",
                borderWidth: 2,
                hoverBackgroundColor: "#008fa1",
                hoverBorderColor: "#008fa1",
                data: saleReturnData // Example data
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
	



    var SalesYData = [<?=$salesJan?>, <?=$salesFeb?>, <?=$salesMar?>, <?=$salesApr?>, <?=$salesMay?>, <?=$salesJun?>, <?=$salesJul?> ,<?=$salesAug?>,<?=$salesSep?>,
	<?=$salesOct?>,<?=$salesNov?>,<?=$salesDec?>];
	
    var ReturnYData = [<?=$srJan?>, <?=$srFeb?>, <?=$srMar?>, <?=$srApr?>, <?=$srMay?>, <?=$srJun?>, <?=$srJul?> ,<?=$srAug?>,<?=$srSep?>,
	<?=$srOct?>,<?=$srNov?>,<?=$srDec?>];

    var ctx = document.getElementById("onemounth").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [
                {
                    label: 'Sales',
                    data: SalesYData,
                    fill: false,
                    borderColor: '#fb9006',
                    backgroundColor: '#fb9006',
                    borderWidth: 2
                },
                {
                    label: 'Sales Return',
                    data: ReturnYData,
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
    var cYearSales = <?= !empty($thisYearSalesReturn) ? $thisYearSalesReturn : 0 ?>; // Current year Sales
    var oYearSales = <?= !empty($lastYearSalesReturn) ? $lastYearSalesReturn : 0 ?>; // One year ago Sales return
    var ooYearSales = <?= !empty($preYearSalesReturn) ? $preYearSalesReturn : 0 ?>;// Two years ago Sales return
    var oooYearSales = <?= !empty($preLastSalesReturn) ? $preLastSalesReturn : 0 ?>;// Two years ago Sales 3 return

    var cYearSales3 = <?=$thisYearSales;?>; // Current year Sales 3
    var oYearSales3 = <?= !empty($lastYearSales) ? $lastYearSales : 0 ?> ;  // One year ago Sales 3
    var ooYearSales3 = <?= !empty($preYearSales) ? $preYearSales : 0 ?> ;// Two years ago Sales 3
	var oooYearSales3 = <?= !empty($preLastYearSales) ? $preLastYearSales : 0 ?> ; // Two years ago Sales 3

    var chartColors = {
        yellow: '#008fa1',
        green: '#fb9006'
    };

    var data = {
        labels: ["<?=$thisYear;?>", "<?=$lastYear;?>", "<?=$previousYear;?>", "<?=$previousLastYear;?>"],
        datasets: [
            {
                label: 'Sales Return',
                backgroundColor: [
                    chartColors.yellow,
                    chartColors.yellow,
                    chartColors.yellow,
                    chartColors.yellow
                ],
                data: [cYearSales, oYearSales, ooYearSales, oooYearSales]  // Sales data
            },
            {
                label: 'Sales',
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


   
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>