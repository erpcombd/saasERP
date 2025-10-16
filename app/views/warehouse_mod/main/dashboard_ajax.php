<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

$today = date('Y-m-d');
$lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
$sunday=date('Y-m-d',strtotime('last sunday'));
$monday=date('Y-m-d',strtotime('last monday'));
$tuesday=date('Y-m-d',strtotime('last tuesday'));
$wednesday=date('Y-m-d',strtotime('last wednesday'));
$thursday=date('Y-m-d',strtotime('last thursday'));
$friday=date('Y-m-d',strtotime('last friday'));
$saturday=date('Y-m-d',strtotime('last saturday'));

$in_qty = find_a_field('journal_item','sum(item_in)','1 and warehouse_id="'.$_SESSION['user']['depot'].'"');
$in_price = find_a_field('journal_item','avg(item_price)','1 and warehouse_id="'.$_SESSION['user']['depot'].'"');
$ex_qty = find_a_field('journal_item','sum(item_ex)','1 and warehouse_id="'.$_SESSION['user']['depot'].'"');
$ex_price = find_a_field('journal_item','avg(item_price)','1 and warehouse_id="'.$_SESSION['user']['depot'].'"');
$total_in_price = $in_price*$in_qty;
$total_ex_price = $ex_price*$ex_qty;
$presentStock = $in_qty - $ex_qty;
$stock_value = $total_in_price-$total_ex_price;

$total_grn_value = find_a_field('purchase_receive','sum(amount)','rec_date between "'.$lastdays.'" and "'.$today.'" and warehouse_id="'.$_SESSION['user']['depot'].'"');
$total_invoice_value = find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$lastdays.'" and "'.$today.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$total_production_value = 0;

$sales_return_value = find_a_field('sale_return_details s, sale_return_master m','sum(s.total_amt)','m.do_date between "'.$lastdays.'" and "'.$today.'" and m.depot_id="'.$_SESSION['user']['depot'].'" and m.status not in ("MANUAL","CANCELED") and s.do_no=m.do_no');

$purchase_return_value = find_a_field('purchase_return_details s, purchase_return_master m','sum(s.total_amt)','m.pr_no=s.pr_no and m.pr_date between "'.$lastdays.'" and "'.$today.'" and m.depot_id="'.$_SESSION['user']['depot'].'"');

$trasfer_value = find_a_field('warehouse_transfer_detail','sum(total_amt)','pi_date between "'.$lastdays.'" and "'.$today.'" and warehouse_from="'.$_SESSION['user']['depot'].'" and status not in ("MANUAL")');
$trasfer_receive_value = find_a_field('warehouse_transfer_detail','sum(total_amt)','pi_date between "'.$lastdays.'" and "'.$today.'" and warehouse_to="'.$_SESSION['user']['depot'].'" and status not in ("MANUAL")');

$localSales = find_a_field('warehouse_other_issue_detail','sum(amount)','oi_date between "'.$lastdays.'" and "'.$today.'" and warehouse_id="'.$_SESSION['user']['depot'].'" and issue_type in ("Local Sales")');

$localPurchase = find_a_field('warehouse_other_receive_detail','sum(amount)','or_date between "'.$lastdays.'" and "'.$today.'" and warehouse_id="'.$_SESSION['user']['depot'].'" and receive_type in ("Local Purchase")');


$res = 'select dealer_code,dealer_code as Client_id,dealer_name_e as dealer_name, contact_no, propritor_name_e as company from dealer_info where 1 order by dealer_code desc limit 5';

$Sat=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$saturday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$Sun=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$sunday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$Mon=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$monday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$Tue=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$tuesday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$Wed=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$wednesday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$Thu=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$thursday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$Fri=find_a_field('sale_do_chalan','sum(total_amt)','chalan_date="'.$friday.'" and depot_id="'.$_SESSION['user']['depot'].'"');
$totalSales = $Sat+$Sun+$Mon+$Tue+$Wed+$Thu+$Fri;

$hSat=($Sat*100)/$totalSales;
$hSun=($Sun*100)/$totalSales;
$hMon=($Mon*100)/$totalSales;
$hTue=($Tue*100)/$totalSales;
$hWed=($Wed*100)/$totalSales;
$hThu=($Thu*100)/$totalSales;
$hFri=($Fri*100)/$totalSales;


$thisYear = date('Y');
$lastYear = date('Y')-1;
$previousYear = date('Y')-2;

$thisYearSdate = $thisYear.'-01-01';
$thisYearEdate = $thisYear.'-12-31';
$thisYearSales = find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$thisYearSdate.'" and "'.$thisYearEdate.'" and depot_id="'.$_SESSION['user']['depot'].'"');

$lastYearSdate = $lastYear.'-01-01';
$lastYearEdate = $lastYear.'-12-31';
$lastYearSales = find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$lastYearSdate.'" and "'.$lastYearEdate.'" and depot_id="'.$_SESSION['user']['depot'].'"');

$preYearSdate = $previousYear.'-01-01';
$preYearEdate = $previousYear.'-12-31';
$preYearSales = find_a_field('sale_do_chalan','sum(total_amt)','chalan_date between "'.$preYearSdate.'" and "'.$preYearEdate.'" and depot_id="'.$_SESSION['user']['depot'].'"');

$cyear = 10;
$oyear = 25;
$ooyear = 20;


$total_transaction=$total_grn_value+$total_invoice_value+$total_production_value;
$oilChartValue1 = ($total_invoice_value*100)/$total_transaction;
$oilChartValue2 = ($total_grn_value*100)/$total_transaction;
$oilChartValue3 = ($total_production_value*100)/$total_transaction;


$all_dealer[]=number_format($presentStock,2);
$all_dealer[]=number_format($stock_value,2);
$all_dealer[]=number_format($total_grn_value,2);
$all_dealer[]=number_format($total_invoice_value,2);
$all_dealer[]=link_report($res);
$all_dealer[]=number_format($sales_return_value,2);
$all_dealer[]=number_format($purchase_return_value,2);
$all_dealer[]=number_format($trasfer_value,2);
$all_dealer[]=number_format($trasfer_receive_value,2);
$all_dealer[]=number_format($localSales,2);
$all_dealer[]=number_format($localPurchase,2);

$all_dealer[]=$hSat;
$all_dealer[]=$hSun;
$all_dealer[]=$hMon;
$all_dealer[]=$hTue;
$all_dealer[]=$hWed;
$all_dealer[]=$hThu;
$all_dealer[]=$hFri;

$all_dealer[]=$thisYearSales;
$all_dealer[]=$lastYearSales;
$all_dealer[]=$preYearSales;

$all_dealer[]=$oilChartValue1;
$all_dealer[]=$oilChartValue2;
$all_dealer[]=$oilChartValue3;




echo json_encode($all_dealer);

?>



