<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";

$title = "Inventory management Dashboard";
 $tr_type="Show";
 $today = date('Y-m-d');
 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
 $cur = '&#x9f3;';

//current year
$current_year = date('Y');


//dashboared data 
//present stock
$in_qty = find_a_field('journal_item','sum(item_in)','1');
$in_price = find_a_field('journal_item','avg(item_price)','1');
$ex_qty = find_a_field('journal_item','sum(item_ex)','1');
$ex_price = find_a_field('journal_item','avg(item_price)','1');
$total_in_price = $in_price*$in_qty;
$total_ex_price = $ex_price*$ex_qty;
$stock_value = $total_in_price-$total_ex_price;
echo '<pre>';
 $presentStock = $in_qty - $ex_qty;
echo '</pre>';
//end dashboared data 






$thisYear = date('Y');
$lastYear = date('Y')-1;
$previousYear = date('Y')-2;
$previousLastYear = date('Y')-3;

$thisYearSdate = $thisYear.'-01-01';
$thisYearEdate = $thisYear.'-12-31';
$thisYearSales = find_a_field('sale_do_details','sum(total_amt)','do_date between "'.$thisYearSdate.'" and "'.$thisYearEdate.'" and status not in ("MANUAL","CANCELED")');

$thisYearSalesReturn = find_a_field('sale_return_master sm, sale_return_details sd','sum(sd.total_amt)',' sm.sr_no=sd.sr_no and sd.sr_date between "'.$thisYearSdate.'" and "'.$thisYearEdate.'" and sm.status IN ("CHECKED")');

$lastYearSdate = $lastYear.'-01-01';
$lastYearEdate = $lastYear.'-12-31';
$lastYearSales = find_a_field('sale_do_details','sum(total_amt)','do_date between "'.$lastYearSdate.'" and "'.$lastYearEdate.'"  and status not in ("MANUAL","CANCELED")');

$lastYearSalesReturn = find_a_field('sale_return_master sm, sale_return_details sd','sum(sd.total_amt)',' sm.sr_no=sd.sr_no and sd.sr_date between "'.$lastYearSdate.'" and "'.$lastYearEdate.'" and sm.status IN ("CHECKED")');

$preYearSdate = $previousYear.'-01-01';
$preYearEdate = $previousYear.'-12-31';
$preYearSales = find_a_field('sale_do_details','sum(total_amt)','do_date between "'.$preYearSdate.'" and "'.$preYearEdate.'" and depot_id="'.$_SESSION['user']['depot'].'" and status not in ("MANUAL","CANCELED")');

$preYearSalesReturn = find_a_field('sale_return_master sm, sale_return_details sd','sum(sd.total_amt)',' sm.sr_no=sd.sr_no and sd.sr_date between "'.$preYearSdate.'" and "'.$preYearEdate.'" and sm.status IN ("CHECKED")');



$preLastYearSdate = $previousLastYear.'-01-01';
$preLastYearEdate = $previousLastYear.'-12-31';
$preLastYearSales = find_a_field('sale_do_details','sum(total_amt)','do_date between "'.$preLastYearSdate.'" and "'.$preLastYearEdate.'" and depot_id="'.$_SESSION['user']['depot'].'" and status not in ("MANUAL","CANCELED")');

$preLastSalesReturn = find_a_field('sale_return_master sm, sale_return_details sd','sum(sd.total_amt)',' sm.sr_no=sd.sr_no and sd.sr_date between "'.$preLastYearSdate.'" and "'.$preLastYearEdate.'" and sm.status IN ("CHECKED")');







 //dashboard Data
//and entry_by="'.$_SESSION['user']['id'].'";

 $stocks = find_all_field_sql("SELECT
    SUM(CASE WHEN stock > 0 THEN 1 ELSE 0 END) AS cstock,
    SUM(CASE WHEN stock < 0 THEN 1 ELSE 0 END) AS nstock,
    SUM(CASE WHEN stock = 0 THEN 1 ELSE 0 END) AS zstock
FROM (
    SELECT item_id, SUM(item_in - item_ex) AS stock
    FROM journal_item
    GROUP BY item_id
) AS item_stock");
 


 
 $Pending_chalan= find_all_field_sql(" SELECT COUNT(do_no)n FROM `sale_do_master` WHERE status in ('checked','Processing')");



 $Pending_PO= find_all_field_sql(" SELECT COUNT(po_no)n FROM `purchase_master` WHERE status in ('checked','Processing');");
 
  $po= find_all_field_sql("SELECT SUM(i.amount) AS amount FROM purchase_master m JOIN purchase_invoice i ON m.po_no = i.po_no WHERE m.status NOT IN ('MANUAL', 'CANCELED') AND m.po_date >='".date('Y-m-01')."'");
  
  
    $do= find_all_field_sql("SELECT SUM(i.total_amt) AS amount 
          FROM sale_do_master m 
          JOIN sale_do_details i ON m.do_no = i.do_no 
          WHERE m.status NOT IN ('MANUAL', 'CANCELED') 
            AND m.do_date >= '" . date('Y-m-01') . "'"

);



  $pr= find_all_field_sql("SELECT SUM(i.total_amt) AS amount 
          FROM production_receive_master m 
          JOIN production_receive_detail i ON m.pr_no = i.pr_no 
          WHERE m.status IN ('RECEIVED') 
            AND m.pr_date >= '" . date('Y-m-01') . "'");







 
 $total_voucherR = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from='Receipt'  ");
 
 $total_voucherJ = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from='journal'  ");
 
 $total_voucherC = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from='Contra'  ");
 
 
 $MRR_Approve = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from secondary_journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from in 
 ('LocalPurchase','Purchase')");
 
  $Chalan_Approve = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from secondary_journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from in 
 ('Sales')");
 
   //$GR_Approve = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from secondary_journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from in ('Goods Return')");
   
    $GR_Approve = find_all_field_sql("select COUNT(DISTINCT sd.sr_no)as n,SUM(sd.total_amt)as m from sale_return_master sm, sale_return_details sd where sm.sr_no=sd.sr_no and sd.sr_date between '".$thisYearSdate."' and '".$thisYearEdate."' and sm.status IN ('CHECKED')");
 
 $PR_Approve = find_all_field_sql("select COUNT(DISTINCT jv_no)as n,SUM(dr_amt)as m from secondary_journal where 1 and jv_date>='".$current_year.'-01-01'."' and tr_from in 
 ('Purchase Return')");
 
 
 //$new_local_purchase_order=find_a_field('warehouse_other_receive','count(*)','1 and YEAR(or_date) ="'.$current_year.'" and status="UNCHECKED" and entry_by="'.$_SESSION['user']['id'].'"');
 
 //$receive_order=find_a_field('purchase_receive pr, purchase_master pm','count(pm.po_no)','1 and pm.po_no=pr.po_no and YEAR(rec_date) ="'.$current_year.'" and pm.entry_by="'.$_SESSION['user']['id'].'" group by pm.po_no');



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
		font-size: 25px;
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
  
</style>



<div class="container-fluid">
			<div class="row m-0 p-0">
			
						
				<div class="col-3 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">PRESENT STOCK <br/><span> OF <?php echo date("d-m-Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon primary"><!--<i class="fas fa-dollar-sign"></i> --><i class="fas fa-chart-pie"></i></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">Total : </br><span style=" color:#66CC33"><?=$presentStock?></span></p>
							
						 </div>
						
						</div>
						<a href="../report/work_order_report.php" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-primary button-cs"> <i class="fas fa-check-circle"></i> Check reports</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-3 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">INVENTORY VALUE <br/><span> OF <?php echo date("d-m-Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon success"><i class="fas fa-donate"></i></div>
						<div class="new-icon-text">
<p class="p-sub bold">Total : </br> <?=number_format($stock_value,2)?></p>
						 </div>
						
						</div>
						
						<a href="../report/work_order_report.php" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-success button-cs"> <i class="fas fa-check-circle"></i>Check reports</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-3 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">PENDING CHALAN <br/><span> OF <?php echo date("d-m-Y"); ?></span></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger"><i class="fas fa-file-export"></i></i></div>
						<div class="new-icon-text">
						<div style="display: flex; align-items: center; justify-content: center;">
							<p style="margin: 0; font-weight: bold;">Total : </p>
							<p style="margin: 0; font-size: 35px !important; color: #FFCC00; margin-left: 5px;"><?=$Pending_chalan->n ?></p>
						</div>

							
						 </div>
						
						</div>
						
						<a href="../wo/select_wo_for_challan.php?new=2" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-danger button-cs"> <i class="fas fa-check-circle"></i> New Stock Out</button>
						</a>
					  </div>
					</div>
				</div>
			
				<div class="col-3 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">PENDING PO RECEIVE <br/><span> OF <?php echo date("d-m-Y"); ?></span></h5>
						
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon danger"><i class="fas fa-file-download"></i></i></div>
						<div class="new-icon-text">
						<div style="display: flex; align-items: center; justify-content: center;">
							<p style="margin: 0; font-weight: bold;">Total : </p>
							<p style="margin: 0; font-size: 35px !important; color: #FFCC00; margin-left: 5px;"><?=$Pending_PO->n ?></p>
						</div>


							
						 </div>
						
						</div>
						
						<a href="../po_receiving/select_upcoming_po.php" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-info button-cs"> <i class="fas fa-check-circle"></i> New Receive </button>
						</a>
					  </div>
					</div>
				</div>


			
				<div class="col-3 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Approve MRR <span> OF <?php echo date("Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon warning"><?= $MRR_Approve->n?></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">Total MRR </p>
							<p class="p-sub1"><span><i class="fa-solid fa-bangladeshi-taka-sign"></i> <?=$MRR_Approve->m?></span></p>
						 </div>
						 
						 
						
						</div>
						
						<a href="../po_receiving/select_upcoming_po.php" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-warning button-cs"> <i class="fas fa-check-circle"></i> Pending MRR</button>
						</a>
					  </div>
					</div>
				</div>


			
				<div class="col-3 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Approve Chalan <span> OF <?php echo date("Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon green-new"><?= $Chalan_Approve ->n?></div>
						<div class="new-icon-text">
						 <p class="p-sub bold">Total Chalan </p>
							<p class="p-sub1"><span> <i class="fa-solid fa-bangladeshi-taka-sign"></i> <?= $Chalan_Approve->m?></span></p>
						 </div>
						
						</div>
						
						<a href="../wo/select_wo_for_challan.php?new=2" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-green-new button-cs"> <i class="fas fa-check-circle"></i> Pending Challan</button>
						</a>
					  </div>
					</div>
				</div>


			
				<div class="col-3 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Purchase Return<span> OF <?php echo date("Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon purple-new"><?=$PR_Approve->n?></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold"> Total </p>
							<p class="p-sub1"><span><i class="fa-solid fa-bangladeshi-taka-sign"></i> <?=$PR_Approve->m?></span></p>
						 </div>
						
						</div>
						
						<a href="../po_return/pr_status.php" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-purple-new button-cs"> <i class="fas fa-check-circle"></i> Return Details</button>
						</a>
					  </div>
					</div>
				</div>
				
				
		
				<div class="col-3 new">
					<div class="card">
					  <div class="card-body">
						<h5 class="card-title bold">Sales Return<span> OF <?php echo date("Y"); ?></span></h5>
						
						<div class="d-flex ustify-content-between p-3">
						<div class="new-icon violet-new"> <?=$GR_Approve->n?></div>
						<div class="new-icon-text">
						 	<p class="p-sub bold">Total  </p>
							<p class="p-sub1"><span><i class="fa-solid fa-bangladeshi-taka-sign"></i> <?=$GR_Approve->m?></span></p>
						 </div>
						
						</div>
						
						<a href="../sales_return_invoice/sales_return_status.php" class="d-flex justify-content-center a">
							<button type="button" class="btn bg-violet-new button-cs"> <i class="fas fa-check-circle"></i> Return Details</button>
						</a>
					  </div>
					</div>
				</div>


			</div>

		
				  
				  <div class="row m-0 p-0">
				  
				  
				  <!--1st chart-->
						<!--<div class="col-lg-6 col-md-12 p-2 mt-2">
							<div class="card card-chart">
								<div class="card-body">
									<h5 class="card-title bold">MONTHLY INVENTORY CHART<span> OF <?php echo date("Y"); ?></span></h5>
								</div>
								<div class="card-header">
										<canvas id="oilChart" width="600" height="400"></canvas>
								</div>
							</div>
						</div>-->
						
						
						<!--2nd chart-->
					  <!--<div class="col-lg-6 col-md-12 p-2 mt-2">
						<div class="card card-chart">
							<div class="card-body">
								<h4 class="card-title bold">ONE WEEK PURCHASE CHART<span> OF <?php echo date("Y"); ?></span></h4>
							</div>
					
							<div class="card-header">
							  <canvas id="chart_0" style="height: 321px !important;width: 482px;" width="650" height="321"></canvas>
							</div>
			
					   </div>
					</div>-->
						
		
						
										
						<!--3rd chart-->	
						<!--<div class="col-lg-6 col-md-12 p-2">
							<div class="card card-chart">
								<div class="card-body">
									<h5 class="card-title bold">ONE YEAR PURCHASE REPORTS<span> OF <?php echo date("Y"); ?></span></h5>
								</div>
								<div class="card-header">
											<canvas id="onemounth" style="height: 367px!important; width: 482px;" width="650" height="367"></canvas>
		
								</div>
							</div>
						</div>-->
		
					
				
						<!--4th chart-->	
						<!--<div class="col-lg-6 col-md-12 p-2">
							<div class="card card-chart">
								<div class="card-body">
								<h5 class="card-title bold">LAST 4 YEAR PURCHASE REPORTS<span> OF <?php echo date("Y"); ?></span></h5>
								</div>
								<div class="card-header">
											<canvas id="fouryear" style="width: 482px; height: 367px;" width="650" height="367"></canvas>
								</div>
							</div>
						</div>-->
						
<!--						<div class="col-lg-6 col-md-12 p-2">
							<div class="card card-chart">
								<div class="card-body">
								<h5 class="card-title bold">LAST 4 YEAR SALES REPORTS<span> OF <?php echo date("Y"); ?></span></h5>
								</div>
								<div class="card-header">
											<canvas id="oneweek" style="width: 482px; height: 367px;" width="650" height="367"></canvas>
								</div>
							</div>
						</div>
					
		
					  </div>-->
					    <div class="col-12 new">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title bold">Quick Shortcuts </h5>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon primary" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Item Creation</span>
          </div>
		  
		  <a href="../item_info/item_info.php?new=2">
		  <div class="d-flex align-items-center"><span class="text-success"><i class="fas fa-arrow-up"></i> Open </span>		</a>
          </div>
        </div>
		

		
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon warning" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Pending Purchase Receive</span>
          </div>
          <div class="d-flex align-items-center">
          <a href="../po_receiving/select_upcoming_po.php"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span>		</a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon success" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Pending Challan</span>
          </div>
          <div class="d-flex align-items-center">
           
            <a href="../wo/select_wo_for_challan.php?new=2"><span class="text-success"><i class="fas fa-arrow-up"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon info" style="width: 15px; height: 15px; border-radius: 50%;"></div>
           <span class="ml-2">Purchase Return</span>
          </div>
          <div class="d-flex align-items-center">
           
             <a href="../po_return/select_dealer_return_adjustment.php"><span class="text-success"><i class="fas fa-arrow-up"></i> Open </span></a>
          </div>
        </div>
        
        <div class="d-flex justify-content-between p-3 border-bottom">
          <div class="d-flex align-items-center">
            <div class="new-icon danger" style="width: 15px; height: 15px; border-radius: 50%;"></div>
            <span class="ml-2">Sales Return</span>
          </div>
          <div class="d-flex align-items-center">
          
            <a href="../sales_return_invoice/select_dealer_return_adjustment.php"><span class="text-danger"><i class="fas fa-arrow-down"></i> Open </span></a>
          </div>
        </div>
        
      </div>
    </div>
	
	<br />
					  
</div>




<?php

$today = new DateTime();
$startOfWeek = clone $today;
$startOfWeek->modify('last Saturday');
$endOfWeek = clone $startOfWeek;
$endOfWeek->modify('+6 days');

 "Week starts on: " . $startOfWeek->format('Y-m-d') . "\n";
"Week ends on: " . $endOfWeek->format('Y-m-d') . "\n";



 $res=
'SELECT 
    DAYNAME(m.po_date) as day_name,
    DATE(m.po_date) as day,
    SUM(i.amount) as amnt 
FROM 
    purchase_invoice i,
    purchase_master m 
WHERE 
    m.po_no = i.po_no 
    AND m.status != "manual" 
    AND m.po_date >= "'.$startOfWeek->format('Y-m-d').'" 
    AND m.po_date <= DATE_ADD("'.$startOfWeek->format('Y-m-d').'", INTERVAL 7 DAY)
GROUP BY 
    DATE(m.po_date)
ORDER BY 
    day';

$query = db_query($res);
				
				
				while($data = mysqli_fetch_object($query))
				{
				
				  $day_amount[$data->day_name]=$data->amnt;
				
				}





   $res=
'SELECT 
    DAYNAME(m.or_date) as day_name,
    DATE(m.or_date) as day,
    SUM(i.amount) as amnt 
FROM 
    warehouse_other_receive_detail i,
    warehouse_other_receive m 
WHERE 
    m.or_no = i.or_no 
    AND m.status not in ("MANUAL","CANCELED") and m.receive_type="Local Purchase"
    AND m.or_date >= "'.$startOfWeek->format('Y-m-d').'" 
    AND m.or_date <= DATE_ADD("'.$startOfWeek->format('Y-m-d').'", INTERVAL 7 DAY)
GROUP BY 
    DATE(m.or_date)
ORDER BY 
    day';

$query = db_query($res);
				
				
				while($datal = mysqli_fetch_object($query))
				{
				
				  $day_amountl[$datal->day_name]=$datal->amnt;
				
				}





?>






<!--// for year data ------------------------------------------------------------------start-->
<?php

$currentYear = date('Y'); // Get the current year

$res = '
SELECT 
    MONTH(m.po_date) as month_number,
    MONTHNAME(m.po_date) as month_name,
    SUM(i.amount) as amnt 
FROM 
    purchase_invoice i,
    purchase_master m 
WHERE 
    m.po_no = i.po_no 
    AND m.status != "manual" 
    AND m.po_date >= "'.$currentYear.'-01-01" 
    AND m.po_date <= "'.$currentYear.'-12-31"
GROUP BY 
    MONTH(m.po_date)
ORDER BY 
    MONTH(m.po_date)';
    
$query = db_query($res);

// Initialize an array to store the monthly amounts
$month_amount = [];

while ($data = mysqli_fetch_object($query)) {
    // Store the total amount for each month in the array
    $month_amount[$data->month_name] = $data->amnt;
}


//foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month) {
//    echo $month . ': ' . (isset($month_amount[$month]) ? $month_amount[$month] : 0) . "<br>";
//}





 $resl = '
SELECT 
    MONTH(m.or_date) as month_number,
    MONTHNAME(m.or_date) as month_name,
    SUM(i.amount) as amnt 
FROM 
    warehouse_other_receive_detail i,
    warehouse_other_receive m 
WHERE 
    m.or_no = i.or_no 
    AND m.status NOT IN ("MANUAL", "CANCELED") 
    AND m.receive_type = "Local Purchase"
    AND m.or_date >= "'.$currentYear.'-01-01" 
    AND m.or_date <= "'.$currentYear.'-12-31"
GROUP BY 
    MONTH(m.or_date)
ORDER BY 
    MONTH(m.or_date)';
	
$queryl = db_query($resl);

$month_amountl = [];

while ($datal = mysqli_fetch_object($queryl)) {
    $datal->month_name;
   
     $month_amountl[$datal->month_name] = $datal->amnt;
}

//foreach ($month_amount as $month => $amount) {
//    echo $month . ": " . $amount . "<br>";
//}

?>
 <!--for year data ------------------------------------------------------------------end-->


 <!--///////////////////////////////////////////chart start values ////////////////////////////////////////////////////////////////-->

<script type="text/javascript">



///////////// 1st chart//////////////////



var mSalesChart = <?=$do->amount?>;
var pSalesChart = <?=$po->amount?>;
var lSalesChart = <?=$pr->amount?>;



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
            data: [mSalesChart, pSalesChart, lSalesChart],
            backgroundColor: [
                "#008fa1",
                "#5DE2E7",
                "#FE9900"
            ]
        }]

};

var pieChart = new Chart(oilCanvas, {
  type: 'pie',
  data: oilData
});































///////////// 2nd chart//////////////////
    // Set fixed data values for each label between 1000 and 7000
	
 
	
    var purchaseData = [
        <?=$day_amount['Saturday']?>,
        <?=$day_amount['Sunday']?>,
        <?=$day_amount['Monday']?>,
        <?=$day_amount['Tuesday']?>,
        <?=$day_amount['Wednesday']?>,
        <?=$day_amount['Thursday']?>,
        <?=$day_amount['Friday']?>];
		
		
    var localData = [
        <?=$day_amountl['Saturday']?>,
        <?=$day_amountl['Sunday']?>,
        <?=$day_amountl['Monday']?>,
        <?=$day_amountl['Tuesday']?>,
        <?=$day_amountl['Wednesday']?>,
        <?=$day_amountl['Thursday']?>,
        <?=$day_amountl['Friday']?>];
    
    var data = {
        labels: ["Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri"],
        datasets: [
            {
                label: "Purchase",
                backgroundColor: "#fb9006",  // Soft teal background
                borderColor: "#fb9006",         // Teal border
                borderWidth: 2,
                hoverBackgroundColor: "#fb9006", // Soft blue hover
                hoverBorderColor: "#fb9006",     // Blue hover border
                data: purchaseData
            },
            {
                label: "Local",
                backgroundColor: "#008fa1",   // Soft orange background
                borderColor: "#008fa1",          // Orange border
                borderWidth: 2,
                hoverBackgroundColor: "#008fa1", // Soft red hover
                hoverBorderColor: "#008fa1",     // Red hover border
                data: localData
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


///////////// 3rd chart//////////////////
    // Example data values between 1000 and 20000
	

	
	  var purchaseData = [<?=$month_amount['January']?>, <?=$month_amount['February']?>, <?=$month_amount['March']?>, <?=$month_amount['April']?>, <?=$month_amount['May']?>, <?=$month_amount['June']?>, <?=$month_amount['July']?>, <?=$month_amount['August']?>,<?=$month_amount['September']?>,<?=$month_amount['October']?>,<?=$month_amount['November']?>,<?=$month_amount['December']?>];
	
  
	var purchaseReturnData = [<?=$month_amountl['January']?>, <?=$month_amountl['February']?>, <?=$month_amountl['March']?>, <?=$month_amountl['April']?>, <?=$month_amountl['May']?>, <?=$month_amountl['June']?>, <?=$month_amountl['July']?>, <?=$month_amountl['August']?>,<?=$month_amountl['September']?>,<?=$month_amountl['October']?>,<?=$month_amountl['November']?>,<?=$month_amountl['December']?>];

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
                    label: 'Local',
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