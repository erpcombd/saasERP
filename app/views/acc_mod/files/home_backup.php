<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Accounts Dashboard";

require_once SERVER_CORE."routing/inc.notify.php";
 $today = date('Y-m-d');
 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
 $cur = '&#x9f3;';
 
 $cur_bank = '&#x9f3;';
 $cur_cash = '&#x9f3;';
 
 $cr = '(CR)';
 $dr = '(DR)';
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
  	height: 268px;

  }
  @media(max-width: 1200px) {
	  #onemounth{
		    height: 212px;
	  }
   }

     @media(max-width: 1400px) {
	  #onemounth{
		    height: 200px;
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

            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid orange;">

                <div class="card-header card-header-warning card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-chart-pie"></i>

                  </div>

                  <p class="card-category"> Last 24 Hours </p>

                  <h3 class="card-title font-siz">
                    <?=$cur = number_format(find_a_field('journal','sum(dr_amt)','ledger_id like "3%" '),0);?>
                  </h3>

                </div>

               <div class="card-footer" style="border-top:1px solid orange">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold">TOTAL REVENUE</h5>

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

                  <p class="card-category">  Last 24 Hours </p>

                  <h3 class="card-title font-siz">

				  <?php


				  $f_date = date('Y-m-01');
				  $t_date = date('Y-m-d');


				  //$cur_bank=find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.acc_sub_sub_class=1207');


				  $cur=find_a_field('journal','sum(cr_amt)','ledger_id like "4%" and jv_date between "'.$f_date.'" and "'.$t_date.'" ');


				  ?>



				  <a class="text-dark" href="master_report.php?f_date=<?=$f_date;?>&t_date=<?=$t_date;?>&report=210617006&submit=1" target="_blank" title="Trade Creditors">

				  <?=number_format($cur,2); ?>



				  </a>


                    </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid green">

                  <div class="stats m-0"><h5 class="m-0 font-weight-bold"> TOTAL EXPENSE</h5></div>

                </div>
              </div>
            </div>



            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid #a217d9;">

                <div class="card-header card-header-primary card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-hand-holding-usd"></i>

                  </div>

                  <p class="card-category"> Last 24 Hours </p>

                  <h3 class="card-title font-siz">

				  <?php


				  $f_date = date('Y-m-01');
				  $t_date = date('Y-m-d');


				  $cur_bank=find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.acc_sub_sub_class=1207');


				  ?>



				  <a class="text-dark" href="master_report.php?f_date=<?=$f_date;?>&t_date=<?=$t_date;?>&report=210617005&submit=1" target="_blank" title="Trade Creditors">

				  <?      if($cur_bank<1) {
				  	echo number_format($cur_bank*(-1),0).' '.$cr;
				  }else {
				  	echo number_format($cur_bank,0).' '.$dr;
				  } ?>



				  </a>



                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid #a217d9">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold"> TOTAL CASH AT BANK</h5>
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

                  <p class="card-category">Last 24 Hours</p>

                  <h3 class="card-title font-siz">

				   <?


				  $f_date = date('Y-m-01');
				  $t_date = date('Y-m-d');


				  $cur_cash=find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and acc_sub_sub_class=1206 ');


				  ?>


				  <a class="text-dark" href="master_report.php?f_date=<?=$f_date;?>&t_date=<?=$t_date;?>&report=210617004&submit=1" target="_blank" title="Trade Creditors">

				  <?  if($cur_cash<1) {
				  	echo number_format($cur_cash*(-1),0).' '.$cr;
				  }else {
				  	echo number_format($cur_cash,0).' '.$dr;
				  } ?>



				  </a>



                  </h3>

                </div>

                <div class="card-footer" style="border-top:1px solid #1ec1d5">

                  <div class="stats m-0">
				  <h5 class="m-0 font-weight-bold"> TOTAL CASH IN HAND</h5>

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

			</div>

				<div class="col-lg-8 col-sm-8 col-md-8">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="card card-stats">
								<div class="card-header card-header-primary card-header-icon">
									<div class="card-icon p-0">
										<i class="fas fa-chart-line"></i>
									</div>
									<p class="card-category"  style="color:#BA04F9; font-weight:bold;">TOTAL ADVANCES</p>
									<h3 class="card-title">

									    				   <?


				  $f_date = date('Y-m-01');
				  $t_date = date('Y-m-d');


				 $adv_sql="select a.ledger_id, a.ledger_name, sum(c.dr_amt-c.cr_amt) as closing_amt from accounts_ledger a, acc_reference b, journal c where a.ledger_id=b.ledger_id and b.id=c.reference_id and a.ledger_group_id in (120301) and c.jv_date <='".$t_date."' ";
$adv_data = find_all_field_sql($adv_sql);


				//  $cur_cash=find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and acc_sub_sub_class=1206 ');


				  ?>




				  <a class="text-dark" href="master_report.php?ledger_group=120301&f_date=<?=$f_date;?>&t_date=<?=$t_date;?>&report=210617003&submit=1" target="_blank" title="Trade Creditors">

				  <? if($adv_data->closing_amt<1) {
				  	echo number_format($adv_data->closing_amt*(-1),0).' '.$cr;
				  }else {
				  	echo number_format($adv_data->closing_amt,0).' '.$dr;
				  }?> </a>



                                    </h3>

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

                                  <p class="card-category" style="color:#0CBB37; font-weight:bold;">TOTAL PURCHASE</p>

                                  <h3 class="card-title">0</h3>

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

					  <p class="card-category"  style="color:#F00712; font-weight:bold;"> CUSTOMER BALANCE </p>

					  <h3 class="card-title">0</h3>

					</div>

					<div class="card-footer">

					  <div class="stats">

						<i class="material-icons">update</i>  Last 7 Days

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

					  <p class="card-category" style="color:#F5DB01; font-weight:bold;">TRADE CREDITORS</p>

					  <h3 class="card-title">
					     <?


				  $f_date = date('Y-m-01');
				  $t_date = date('Y-m-d');


				 $suppliyer_sql="select a.ledger_id, a.ledger_name, sum(c.dr_amt-c.cr_amt) as closing_amt from accounts_ledger a, acc_reference b, journal c where a.ledger_id=b.ledger_id and b.id=c.reference_id and a.ledger_group_id in (220301) and c.jv_date <='".$t_date."' ";
$suppliyer_data = find_all_field_sql($suppliyer_sql);


				//  $cur_cash=find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and acc_sub_sub_class=1206 ');


				  ?>


				  <a class="text-dark" href="master_report.php?ledger_group=220301&f_date=<?=$f_date;?>&t_date=<?=$t_date;?>&report=210617003&submit=1" target="_blank" title="Trade Creditors">

				  <? if($suppliyer_data->closing_amt<1) {
				  	echo number_format($suppliyer_data->closing_amt*(-1),0).' '.$cr;
				  }else {
				  	echo number_format($suppliyer_data->closing_amt,0).' '.$dr;
				  }?> </a>


                      </h3>

					</div>

					<div class="card-footer">

					  <div class="stats">

						<i class="material-icons">update</i>  Last 7 Days

					  </div>

					</div>

				  </div>

				</div>




			  		</div>
				</div>

		  </div>






		<div class="row">


					<!--1st One Week Purchase report chart-->
			  <div class="col-lg-6 col-md-12">
				<div class="card card-chart">
					<div class="card-body">
					  	<h4 class="card-title">ONE WEEK PURCHASE REPORT </h4>
	<!--				 	<p class="card-category"><span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> increase. </p>-->
					</div>

					<div class="card-header">
					  <canvas id="chart_0"></canvas>
					</div>

			   </div>
			</div>


				<!--3rd One yeare Accounts report chart-->
				<div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">LAST 3 YEAR ACCOUNTS REPORTS </h4>
						</div>
						<div class="card-header">
								<div id="reportPage">
									<canvas id="oneweek"></canvas>
								</div>
						</div>
					</div>
				</div>






				<!--4th One year ACCOUNTS report chart-->
				<div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">ONE YEAR ACCOUNTS REPORTS </h4>
						</div>
						<div class="card-header">
								<div id="reportPage">
									<canvas id="onemounth"></canvas>
								</div>
						</div>
					</div>
				</div>






				<!--5th Monthly ACCOUNTS report chart-->
				<div class="col-lg-6 col-md-12">
					<div class="card card-chart">
						<div class="card-body">
							<h4 class="card-title">MONTHLY ACCOUNTS REPORTS </h4>
						</div>
						<div class="card-header">
								<div id="reportPage">
									<canvas id="acquisition"></canvas>
								</div>
						</div>
					</div>
				</div>


		</div>













		
		
		
		 <!--<div class="row">
		  
		  <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info">
                  <div class="card-icon">
                    <i class="fab fa-avianex"></i>
                  </div>
                  <p class="card-category" style="color:#FFFFFF">TOTAL REVENUE</p>
                  <h3 class="card-title" style="font-size:16px;"><?=$cur = number_format(find_a_field('journal','sum(dr_amt)','ledger_id like "3%" '),0);?></h3>
                </div>
				
				
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i>
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
                  <p class="card-category" style="color:#FFFFFF">TOTAL EXPENSE</p>
                  <h3 class="card-title" style="font-size:16px;">




				  <?


				  $f_date = date('Y-m-01');
				  $t_date = date('Y-m-d');


				  //$cur_bank=find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.acc_sub_sub_class=1207');


				  $cur=find_a_field('journal','sum(cr_amt)','ledger_id like "4%" and jv_date between "'.$f_date.'" and "'.$t_date.'" ');


				  ?>



				  <a href="master_report.php?f_date=<?=$f_date;?>&t_date=<?=$t_date;?>&report=210617006&submit=1" target="_blank" title="Trade Creditors">

				  <?=number_format($cur,2); ?>



				  </a>




				  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">local_offer</i> This Month
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
                  <p class="card-category" style="color:#FFFFFF">TOTAL CASH AT BANK</p>
                  <h3 class="card-title" style="font-size:16px;">
			
				  
				  <?php
				  
				  
				  $f_date = date('Y-m-01');
				  $t_date = date('Y-m-d');
				 
				 
				  $cur_bank=find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.acc_sub_sub_class=1207');

				 
				  ?>
				  
	  
				  
				  <a href="master_report.php?f_date=<?=$f_date;?>&t_date=<?=$t_date;?>&report=210617005&submit=1" target="_blank" title="Trade Creditors"> 
				  
				  <?      if($cur_bank<1) {
				  	echo number_format($cur_bank*(-1),0).' '.$cr;
				  }else {
				  	echo number_format($cur_bank,0).' '.$dr;
				  } ?> 
				  
				  
				  
				  </a>
				  
				  
				  
                  </h3>
                </div>
               <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">local_offer</i> Last  Day
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
                  <p class="card-category" style="color:#FFFFFF; text-transform:uppercase;">Total Cash in Hand</p>
                  <h3 class="card-title" style="font-size:16px;">
	
				  
				   <? 
				  
				  
				  $f_date = date('Y-m-01');
				  $t_date = date('Y-m-d');
				 
				 
				  $cur_cash=find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and acc_sub_sub_class=1206 ');
			
				  
				 
				  ?>
				  
				  
				  
				  
				  <a href="master_report.php?f_date=<?=$f_date;?>&t_date=<?=$t_date;?>&report=210617004&submit=1" target="_blank" title="Trade Creditors"> 
				  
				  <?  if($cur_cash<1) {
				  	echo number_format($cur_cash*(-1),0).' '.$cr;
				  }else {
				  	echo number_format($cur_cash,0).' '.$dr;
				  } ?> 
				  
				  
				  
				  </a>
				  
				  
				  
				  
				  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Last  Day
                  </div>
                </div>
              </div>
            </div>

		  
		  		<div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info">
                  <div class="card-icon">
                    <i class="fab fa-avianex"></i>
                  </div>
                  <p class="card-category" style="color:#FFFFFF; text-transform:uppercase;">Advances</p>
                  <h3 class="card-title" style="font-size:16px;">
				  
				   <? 
				  
				  
				  $f_date = date('Y-m-01');
				  $t_date = date('Y-m-d');
				 
				 
				 $adv_sql="select a.ledger_id, a.ledger_name, sum(c.dr_amt-c.cr_amt) as closing_amt from accounts_ledger a, acc_reference b, journal c where a.ledger_id=b.ledger_id and b.id=c.reference_id and a.ledger_group_id in (120301) and c.jv_date <='".$t_date."' ";
$adv_data = find_all_field_sql($adv_sql);
				 
				  
				//  $cur_cash=find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and acc_sub_sub_class=1206 ');
				  
				 
				  ?>
				  
				  
				  
				  
				  <a href="master_report.php?ledger_group=120301&f_date=<?=$f_date;?>&t_date=<?=$t_date;?>&report=210617003&submit=1" target="_blank" title="Trade Creditors"> 
				  
				  <? if($adv_data->closing_amt<1) {
				  	echo number_format($adv_data->closing_amt*(-1),0).' '.$cr;
				  }else {
				  	echo number_format($adv_data->closing_amt,0).' '.$dr;
				  }?> </a>
				  
				  
				  </h3>
                </div>
				
				
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i> Current Balance
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
                  <p class="card-category" style="color:#FFFFFF; text-transform:uppercase;">TOTAL Purchase</p>
                  <h3 class="card-title" style="font-size:16px;"><?=$cur.number_format(find_a_field('journal','sum(cr_amt)',' tr_from like "Payment" '),0);?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">local_offer</i> Last  Day
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
                  <p class="card-category" style="color:#FFFFFF">CUSTOMER BALANCE</p>
                  <h3 class="card-title" style="font-size:16px;">
				 <?php /*?> <? $cur_bank=find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and a.acc_sub_sub_class=1207');
				  
				    if($cur_bank<1) {
				  	echo number_format($cur_bank*(-1),0).' '.$cr;
				  }else {
				  	echo number_format($cur_bank,0).' '.$dr;
				  }
				
				  ?><?php */?>
                  </h3>
                </div>
               <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">local_offer</i> Last  Day
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
                  <p class="card-category" style="color:#FFFFFF; text-transform: uppercase;">Trade Creditors</p>
                  <h3 class="card-title" style="font-size:16px;">
				  <? 
				  
				  
				  $f_date = date('Y-m-01');
				  $t_date = date('Y-m-d');
				 
				 
				 $suppliyer_sql="select a.ledger_id, a.ledger_name, sum(c.dr_amt-c.cr_amt) as closing_amt from accounts_ledger a, acc_reference b, journal c where a.ledger_id=b.ledger_id and b.id=c.reference_id and a.ledger_group_id in (220301) and c.jv_date <='".$t_date."' ";
$suppliyer_data = find_all_field_sql($suppliyer_sql);
				 
				  
				//  $cur_cash=find_a_field('journal j, accounts_ledger a','sum(j.dr_amt-j.cr_amt)','j.ledger_id=a.ledger_id and acc_sub_sub_class=1206 ');
				  
				 
				  ?>
				  
				  
				  <a href="master_report.php?ledger_group=220301&f_date=<?=$f_date;?>&t_date=<?=$t_date;?>&report=210617003&submit=1" target="_blank" title="Trade Creditors"> 
				  
				  <? if($suppliyer_data->closing_amt<1) {
				  	echo number_format($suppliyer_data->closing_amt*(-1),0).' '.$cr;
				  }else {
				  	echo number_format($suppliyer_data->closing_amt,0).' '.$dr;
				  }?> </a>
				  
				  
				  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Current Balance
                  </div>
                </div>
              </div>
            </div>
			
			
			</div>-->
			
			
			
			
		
		
          
          <?php /*?><div class="row">
            <div class="col-md-4">
              <div class="card card-chart">
                <div class="card-header card-header-success">
                  <div class="ct-chart" id="dailySalesChart"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Daily Sales</h4>
                  <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
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
                <div class="card-header card-header-warning">
                  <div class="ct-chart" id="websiteViewsChart"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Bill Collected</h4>
                 <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 40% </span> increase in Collection.</p>
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
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> Increase in Sales Return.</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> Last 7 Days
                  </div>
                </div>
              </div>
            </div>
			
			
          </div><?php */?>
		  
		  
		  
		  
		  
		  <!--<div class="row">
		  <div class="col-md-12">
			
			<div class="card card-chart">
                <div class="card-header">
                   <div id="myfirstchart4" style="height: 250px;"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">REVENUE FLOW CHART </h4>
                 <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> increase. </p>
                </div>
                
              </div>
		    
            </div>

		  
		  
		  <div class="row">
		  
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="fas fa-file-export"></i>
                  </div>
                  <p class="card-category">Total DO Today</p>
                  <h3 class="card-title"><?=find_a_field('sale_do_master','count(do_no)','do_date="'.date('Y-m-d').'"');?>
                    <small></small>
                  </h3>
                </div>
               <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Day
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
                  <p class="card-category">Total DO Value</p>
                  <h3 class="card-title"><?=find_a_field('sale_do_master','sum(total_amt)','do_date="'.date('Y-m-d').'"');?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Day
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
                  <p class="card-category">Today Sales Return</p>
                  <h3 class="card-title"><?=find_a_field('warehouse_other_receive','sum(total_amt)','or_date="'.date('Y-m-d').'" and receive_type="SalesReturn"');?></h3>
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
          </div>
		  
		  
		  
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-success">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title">Sales Activity:</span>
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            <i class="far fa-smile-beam"></i>  Confirmed(323)  
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#messages" data-toggle="tab">
                            <i class="fas fa-fighter-jet"></i> To Be Delivered
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#settings" data-toggle="tab">
                            <i class="far fa-edit"></i>  To Be Invoiced
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                      <table class="table">
                        <tbody>
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="" checked>
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Sign contract for "What are conference organizers afraid of?"</td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="">
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="">
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                            </td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="" checked>
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Create 4 Invisible User Experiences you Never Knew About</td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="messages">
                      <table class="table">
                        <tbody>
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="" checked>
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                            </td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="">
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Sign contract for "What are conference organizers afraid of?"</td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="settings">
                      <table class="table">
                        <tbody>
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="">
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="" checked>
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                            </td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="" checked>
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Sign contract for "What are conference organizers afraid of?"</td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title">Last 5 Client Information</h4>
                  <p class="card-category">Just Updated</p>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-warning">
                      <th>Code</th>
                      <th>Name</th>
                      <th>Contact</th>
                      <th>Company</th>
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
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>-->



















      </div>





<!--   Core JS Files   -->
  <script src="../../../dashboard_assets/js/core/jquery.min.js"></script>
  <script src="../../../dashboard_assets/js/core/popper.min.js"></script>
  <script src="../../../dashboard_assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="../../../dashboard_assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="../../../dashboard_assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="../../../dashboard_assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="../../../dashboard_assets/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="../../../dashboard_assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="../../../dashboard_assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="../../../dashboard_assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="../../../dashboard_assets/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="../../../dashboard_assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="../../../dashboard_assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="../../../dashboard_assets/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="../../../dashboard_assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../../../dashboard_assets/js/plugins/nouislider.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="../../../dashboard_assets/js/plugins/arrive.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chartist JS -->
  <script src="../../../dashboard_assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../../../dashboard_assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../../dashboard_assets/js/material-dashboard-sales.js?v=2.1.3" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }

        }

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();

    });
  </script>






























 <!--///////////////////////////////////////////chart start values ////////////////////////////////////////////////////////////////-->
  <script type="text/javascript">

 <!--/////////////1st TODAY REPORT chart//////////////////-->
  var oilCanvas = document.getElementById("oilChart");

Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var oilData = {
    labels: [
        "Revenue",
        "Expense",
        "Advance",
        "Purchase"

    ],
    datasets: [
        {
            data: [100.00, 86.2, 52.2,30.00],
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




<!--///////////// 2st ONE WEEK PURCHASE REPORTchart//////////////////-->
var data = {
  labels: ["Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri"],
  datasets: [{
    label: "Sales #1",
    backgroundColor: "rgba(255,99,132,0.2)",
    borderColor: "rgba(255,99,132,1)",
    borderWidth: 2,
    hoverBackgroundColor: "rgba(255,99,132,0.4)",
    hoverBorderColor: "rgba(255,99,132,1)",
    data: [65, 59, 20, 81, 56, 55, 40],
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






 <!--/////////////3rd LAST 3 YEAR ACCOUNTS REPORTS Bar chart//////////////////-->
var chartColors = {
  red: 'rgb(255, 99, 132)',
  orange: 'rgb(255, 159, 64)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgb(75, 192, 192)',
  blue: 'rgb(54, 162, 235)',
  purple: 'rgb(153, 102, 255)',
  grey: 'rgb(231,233,237)'
};

var randomScalingFactor = function() {
  return (Math.random() > 0.5 ? 1.0 : 1.0) * Math.round(Math.random() * 100);
};

var data =  {
  labels: ["2022", "2021", "2020"],
  datasets: [{
    label: 'Seals',
    backgroundColor: [
      chartColors.red,
      chartColors.blue,
      chartColors.yellow],

    data: [
      randomScalingFactor(),
      randomScalingFactor(),
      randomScalingFactor(),
    ]
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






 <!--/////////////4rd ONE YEAR ACCOUNTS REPORTS chart//////////////////-->

var ctx = document.getElementById("onemounth").getContext('2d');

var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Jan",	"Feb",	"Mar",	"Apr",	"May",	"Jun",	"Jul", "Aug",	"Sep","Oct","Nov","Dec"],
        datasets: [{
            label: 'Series 1', // Name the series
            data: [40000,	50000,	100000,	150000,	200000,	250000,	300000,	350000,	400000, 450000, 500000, 550000], // Specify the data values array
            fill: false,
            borderColor: '#2196f3', // Add custom color border (Line)
            backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
            borderWidth: 1 // Specify bar border width
        },
                  {
            label: 'Series 2', // Name the series
            data: [100000,	150000,	100000,	70000,	50000,	200000,	300000,	10000,	500000, 600000,550000,400000], // Specify the data values array
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










 <!--/////////////5th MONTHLY ACCOUNTS REPORTS chart//////////////////-->
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




   
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>