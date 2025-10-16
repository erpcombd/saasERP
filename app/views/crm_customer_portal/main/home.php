<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = "Billing Dashboard";

require_once SERVER_CORE."routing/inc.notify.php";
 $today = date('Y-m-d');
 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
  $user_all=find_all_field('user_activity_management','*','user_id="'.$_SESSION['user']['id'].'"');
 if($_SESSION['user']['id']!=10001){
 $cus_con='and customer="'.$user_all->organization.'"';
 }

 $tot_pending_bill=find_a_field('crm_bill_info','count(bill_no)','status="BILL SUBMITTED" '.$cus_con.'');
 $tot_paid_bill=find_a_field('crm_bill_info','count(bill_no)','status="BILL RECEIVED" '.$cus_con.'');
 
?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from designreset.com/cork/ltr/demo3/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Mar 2020 08:10:15 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Billing</title>
   <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../../../dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  
  <style>
  	.small-box h3{
		color: #000000 !important;
	}
	.small-box p{
		color: #000000 !important;
	}
  </style>
</head>

<!-- <h3>Task Management Module</h3> -->

<hr>


<div class="content">
    <div class="container-fluid">


 <div class="row">
 <div class="col-lg-12 col-md-12 col-sm-12">
<p style="text-align:center;font-weight:bold;font-size:35px!important; ">Wellcome <?php echo $user_all->fname;?></p>
</div>
</div>
<br><br>
        <div class="row">

            <div class="col-lg-4 col-md-6 col-sm-6">
<a href="dashboard_details.php?unid=10111">
                <div class="card card-stats" style="border: 1px solid orange;">

                    <div class="card-header card-header-warning card-header-icon">

                        <div class="card-icon p-0">

                            <i class="fab fa-avianex"></i>

                        </div>

                        <p class="card-category" style="color:red;font-weight:bold;font-size:27px!important;"> Total Pending Bills</p>

                        <h3 class="card-title font-siz" style="color:red;font-weight:bold;font-size:43px!important;"> <?php echo $tot_pending_bill;?></h3>

                    </div>

                    <div class="card-footer" style="border-top:1px solid orange">

                        <div class="stats m-0">
                            <h5 class="m-0 font-weight-bold"> Pending Bills</h5>

                        </div>

                    </div>

                </div>
 </a>
            </div>





            <div class="col-lg-4 col-md-6 col-sm-6">
<a href="dashboard_details.php">
                <div class="card card-stats" style="border: 1px solid green;">

                    <div class="card-header card-header-success card-header-icon">

                        <div class="card-icon p-0">

                            <i class="fas fa-donate"></i>

                        </div>

                        <p class="card-category" style="color:green;font-weight:bold;font-size:27px!important;">Total Paid Bills </p>

                        <h3 class="card-title font-siz" style="color:green;font-weight:bold;font-size:43px!important;"> <?php echo $tot_paid_bill;?></h3>

                    </div>

                    <div class="card-footer" style="border-top:1px solid green">

                        <div class="stats m-0"><h2 class="m-0 font-weight-bold"> Total Paid BIll </h2></div>

                    </div>
                </div>
				</a>
            </div>




             




             






             





             







        </div>



         




    </div>
</div>










<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>