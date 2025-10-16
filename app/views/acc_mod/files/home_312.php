<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title = "Accounts Dashboard";

require_once SERVER_CORE."routing/inc.notify.php";
$today = date('Y-m-d');
$lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));

//$in_qty = find_a_field('journal_item','sum(item_in)','1 and warehouse_id="'.$_SESSION['user'].'"');
//$in_price = find_a_field('journal_item','avg(item_price)','1 and warehouse_id="'.$_SESSION['user'].'"');


?>

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
  
  
  </style>

<!--<style>



.card-stats .card-header.card-header-icon i {

   font-size: none; 

   line-height: none; 

    width: none;

   height: none; 

    text-align: center;

}



</style>

-->

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

		
<!--<div class="row">
			
			<div class="col-md-6">
	
	
	<canvas id="myLineCharts"></canvas>
	</div>
			<div class="col-md-6">
	
	<canvas id="myBarCharts"></canvas>
	</div>
			
			</div>-->
			
			
			
			
			
			
			<!--<div class="row">
			<div class="col-md-6">
				
	<canvas id="myRadarCharts"></canvas>
				</div>
			<div class="col-md-6">
				
	<canvas id="myPieCharts"></canvas>
				</div>
		</div>-->




			<!--<div class="row">
			<div class="col-md-6">
				
	<canvas id="myPolarCharts"></canvas>
				</div>
			<div class="col-md-6">
				
				<div class="text">
					<marquee direction="up" height="300px;"  scrolldelay="500">
				<p style="border: 1px solid gray; padding: 5px; font-size: 12px;">This is the demo text This is the demo text This is the demo text This is the demo text This is the demo text - $1000 </p>
				<p style="border: 1px solid gray; padding: 5px; font-size: 12px;">This is the demo text This is the demo text This is the demo text This is the demo text This is the demo text - $1000 </p>
				<p style="border: 1px solid gray; padding: 5px; font-size: 12px;">This is the demo text This is the demo text This is the demo text This is the demo text This is the demo text - $1000 </p>
				<p style="border: 1px solid gray; padding: 5px; font-size: 12px;">This is the demo text This is the demo text This is the demo text This is the demo text This is the demo text - $1000 </p>
				<p style="border: 1px solid gray; padding: 5px; font-size: 12px;">This is the demo text This is the demo text This is the demo text This is the demo text This is the demo text - $1000 </p>
				<p style="border: 1px solid gray; padding: 5px; font-size: 12px;">This is the demo text This is the demo text This is the demo text This is the demo text This is the demo text - $1000 </p>
				<p style="border: 1px solid gray; padding: 5px; font-size: 12px;">This is the demo text This is the demo text This is the demo text This is the demo text This is the demo text - $1000 </p>
				<p style="border: 1px solid gray; padding: 5px; font-size: 12px;">This is the demo text This is the demo text This is the demo text This is the demo text This is the demo text - $1000 </p>
				<p style="border: 1px solid gray; padding: 5px; font-size: 12px;">This is the demo text This is the demo text This is the demo text This is the demo text This is the demo text - $1000 </p>
				</marquee>
				
				</div>
				</div>
		</div>-->
		




		<!--<div class="row">

		  
		  <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats">

                <div class="card-header card-header-info">

                  <div class="card-icon">

                    <i class="fab fa-avianex"></i>

                  </div>

                  <p class="card-category" style="color:#FFFFFF">INVENTORY VALUE</p>

                  <h3 class="card-title"><?=$cur.number_format(find_a_field('journal_item','sum((item_in-item_ex)* final_price)','1'),0);?></h3>

                </div>

				

				

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">update</i> Last 24 Hours

                  </div>

                </div>

              </div>

            </div>

			

			

			  <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats">

                <div class="card-header card-header-danger">

                  <div class="card-icon">

                    <i class="fas fa-donate"></i>

                  </div>

                  <p class="card-category" style="color:#FFFFFF">CURRENT STOCK)</p>

                  <h3 class="card-title"><?=$cur.number_format(find_a_field('journal_item','sum(item_in-item_ex)','1'),0);?></h3>

                </div>

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">local_offer</i> Last 24 Hours

                  </div>

                </div>

              </div>

            </div>

			

			

			

			

			

			<div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats">

                <div class="card-header card-header-primary">

                  <div class="card-icon">

                    <i class="fas fa-hand-holding-usd"></i>

                  </div>

                  <p class="card-category" style="color:#FFFFFF">INCOMMING TRANSFERS</p>

                  <h3 class="card-title"><?=$cur.number_format(find_a_field('journal_item','sum(item_in)','1 and tr_from in("Issue","Purchase")'),0);?>

                    <small></small>

                  </h3>

                </div>

               <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">local_offer</i> Last 24 Hours

                  </div>

                </div>



              </div>

            </div>

			

			

			

			

			<div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats">

                <div class="card-header card-header-success">

                  <div class="card-icon">

                    <i class="fas fa-chart-pie"></i>

                  </div>

                  <p class="card-category" style="color:#FFFFFF">OUTGOING TRANSFERS</p>

                  <h3 class="card-title"><?=$cur.number_format(find_a_field('journal_item','sum(item_ex)','1 and tr_from in ("Sales","Other Issue") '),0);?></h3>

                </div>

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">date_range</i> Last 24 Hours

                  </div>

                </div>

              </div>

            </div>

			

			</div>-->




















<!--new-->

<div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid orange;">

                <div class="card-header card-header-warning card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fa-solid fa-file-invoice-dollar"></i>

                  </div>

                  <p class="card-category"> Last 30 Days</p>

                  <h3 class="card-title font-siz"><span id="presentStock" class="loader">Checking..</span></h3>

                </div>

               <div class="card-footer" style="border-top:1px solid orange">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold"> PAYMENT<button onclick="view_data()">Hit</button></h5>
				  
                  </div>

                </div>

              </div>

            </div>

			
			
			
           
            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid green;">

                <div class="card-header card-header-success card-header-icon">

                  <div class="card-icon p-0">

                   <i class="fas fa-donate"></i>

                  </div>

                  <p class="card-category">Last 30 Days </p>

                  <h3 class="card-title font-siz"><span id="inventoryValue" class="loader">Checking..</span></h3>

                </div>

                <div class="card-footer" style="border-top:1px solid green">

                  <div class="stats m-0"><h5 class="m-0 font-weight-bold"> RECEIVE</h5></div>
				  
                </div>
              </div>
            </div>
          



            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid red;">

                <div class="card-header card-header-danger card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-hand-holding-usd"></i>

                  </div>

                  <p class="card-category"> Last 30 Days </p>

                  <h3 class="card-title font-siz"><span id="grnValue" class="loader">Checking..</span></h3>

                </div>

                <div class="card-footer" style="border-top:1px solid red">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold"> PAYABLE</h5>
                  </div>
                </div>
              </div>
            </div>
			
			
			
			

            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid #1ec1d5;">

                <div class="card-header card-header-info card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-chart-pie"></i>

                  </div>

                  <p class="card-category">Last 30 Days</p>

                  <h3 class="card-title font-siz"><span id="invoiceValue" class="loader">Checking..</span></h3>

                </div>

                <div class="card-footer" style="border-top:1px solid #1ec1d5">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold"> RECEIVABLE</h5>
				 
                  </div>
                </div>
              </div>
            </div>	

			

          </div>



		<div class="row">
			
			
			
			<div class="col-lg-4 col-sm-4 col-md-4"> 
			
				

				<div class="container">
							<!--3rd One yeare report chart-->
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">TODAY REPORT </h4>
						</div>
						<div class="card-header">
								<div id="reportPage">
									<canvas id="oilChart"></canvas>
								</div>
						</div>
					</div>
				</div>

			
			
			
			
				<!--<div class="container">
			
										
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">LAST 3 YEAR SEALS REPORTS </h4>
						</div>
						<div class="card-header">
								<div id="reportPage">
									<canvas id="oneweek"></canvas>
								</div>
						</div>
					</div>
				</div>-->

			</div>
			
			
			
			
			
			<div class="col-lg-8 col-sm-8 col-md-8">
				<div class="row">
		
            		<div class="col-lg-6 col-md-6 col-sm-6">
              			<div class="card card-stats">
                			<div class="card-header card-header-primary card-header-icon">
                  				<div class="card-icon p-0">
                    				<i class="fas fa-chart-line"></i>
                  				</div>
                  				<p class="card-category" style="color:#BA04F9; font-weight:bold;">Receivables</p>
				  				<h3 class="card-title"><span id="receivables" class="loader">Checking..</span></h3>

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

                  <p class="card-category" style="color:#0CBB37; font-weight:bold;">Payables</p>

                  <h3 class="card-title"><span id="payables" class="loader">Checking..</span></h3>

                </div>

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">date_range</i> Last 7 Days

                  </div>

                </div>

              </div>

            </div>

            <!--<div class="col-lg-6 col-md-6 col-sm-6">

              <div class="card card-stats">

                <div class="card-header card-header-danger card-header-icon">

                  <div class="card-icon p-0">

                    <i class="far fa-calendar-times"></i>

                  </div>

                  <p class="card-category" style="color:#F00712; font-weight:bold;">Outgoing Transfer</p>

                  <h3 class="card-title"><span id="transferIssue" class="loader">Checking..</span></h3>

                </div>

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">update</i> Last 7 Days

                  </div>

                </div>

              </div>

            </div>-->

            <!--<div class="col-lg-6 col-md-6 col-sm-6">

              <div class="card card-stats">

                <div class="card-header card-header-warning card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-calendar-check"></i>

                  </div>

                  <p class="card-category" style="color:#F5DB01; font-weight:bold;">Incomming Transfer</p>

                  <h3 class="card-title"><span id="transferReceive" class="loader">Checking..</span></h3>

                </div>

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">update</i> Last 7 Days

                  </div>

                </div>

              </div>

            </div>-->

			

			<div class="col-lg-6 col-md-6 col-sm-6">

              <div class="card card-stats">

                <div class="card-header card-header-info card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-file-export"></i>

                  </div>

                  <p class="card-category" style="color:#0fa9d7; font-weight:bold;">Sales Return</p>

                  <h3 class="card-title"><span id="salesReturn" class="loader">Checking..</span></h3>

                </div>

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">update</i> Last 30 Days

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

                  <p class="card-category" style="color:#BA04F9; font-weight:bold;">Damage Value</p>

                  <h3 class="card-title"><span id="damage" class="loader">Checking..</span></h3>

                </div>

                <div class="card-footer">

                  <div class="stats">

                    <i class="material-icons">update</i> Last 30 Days

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
		  
		  <div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">ONE YEAR RECEIPT VS PAYMENT CURVE </h4>
						</div>
						<div class="card-header">
								<div id="reportPage">
									<canvas id="onemounth"></canvas>
								</div>
						</div>
					</div>
				</div>
		  
		  			<!--Last 5Client Inforamation Tabel -->
           <div class="col-lg-6 col-md-12">
				<div class="card card-chart">
					<div class="card-body table-responsive">
						<h4 class="card-title text-center font-weight-bold">Last 5 Transaction</h4>
						 <p class="card-category text-center">Just Updated</p>
						 <div id="transactionList" class="table table-hover table-striped">Checking..</div>
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
				<!--<div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">DAILY SALES CHART </h4>
						</div>
						<div class="card-header">
								<canvas id="chart_0" width="600" height="400"></canvas>
						</div>
					</div>
				</div>-->
				
				

            

            

          </div>

        </div>

      </div>


		  
<input type="hidden" id="asset" value="0">
<input type="hidden" id="revenue" value="0">
<input type="hidden" id="liability" value="0">
<input type="hidden" id="expense" value="0">

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

 <!--/////////////2rd One Week Report chart//////////////////-->
  function newoilChart(){
  var mSalesChart = document.getElementById('asset').value;
  var pSalesChart = document.getElementById('revenue').value;
  var lSalesChart = document.getElementById('liability').value;
  var receivablesChart = document.getElementById("expense").value;
  var oilCanvas = document.getElementById("oilChart");

Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var oilData = {
    labels: [
        "Asset",
        "Revenue",
        "Liability",
        "Expense"
    ],
    datasets: [
        {
            data: [mSalesChart, pSalesChart, lSalesChart, receivablesChart],
            backgroundColor: [
                "#0CBB37",
                "#0AA3EA",
                "#ffb429d9",
                "#DBD80D"

            ]
        }]

};

var pieChart = new Chart(oilCanvas, {
  type: 'pie',
  data: oilData
});


}


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
            label: 'Receipt', // Name the series
            data: [sjan,	sfeb,	smar,	sapr,	smay,	sjun,	sjul,	saug,	ssept, soct, snov, sdec], // Specify the data values array
            fill: false,
            borderColor: '#2196f3', // Add custom color border (Line)
            backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
            borderWidth: 1 // Specify bar border width
        },
                  {
            label: 'Payment', // Name the series
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
url:"acc_dashboard_ajax.php",
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

$("#asset").val(res[4]);
$("#revenue").val(res[5]);
$("#liability").val(res[6]);
$("#expense").val(res[7]);

$("#receivables").html(res[8]);
$("#payables").html(res[9]);

$("#salesReturn").html(res[10]);
$("#damage").html(res[11]);

$("#sjan").val(res[12]);
$("#sfeb").val(res[13]);
$("#smar").val(res[14]);
$("#sapr").val(res[15]);
$("#smay").val(res[16]);
$("#sjun").val(res[17]);
$("#sjul").val(res[18]);
$("#saug").val(res[19]);
$("#ssept").val(res[20]);
$("#soct").val(res[21]);
$("#snov").val(res[22]);
$("#sdec").val(res[23]);

$("#srjan").val(res[24]);
$("#srfeb").val(res[25]);
$("#srmar").val(res[26]);
$("#srapr").val(res[27]);
$("#srmay").val(res[28]);
$("#srjun").val(res[29]);
$("#srjul").val(res[30]);
$("#sraug").val(res[31]);
$("#srsept").val(res[32]);
$("#sroct").val(res[33]);
$("#srnov").val(res[34]);
$("#srdec").val(res[35]);
$("#transactionList").html(res[36]);

}
}); 
}
window.onload = setTimeout(view_data, 3000);
window.onload = setTimeout(salesBar, 4000);
window.onload = setTimeout(yearChart, 4000);
window.onload = setTimeout(newoilChart, 4000);
window.onload = setTimeout(oneYearChart, 4000);

</script>
	
	
	
	
	