<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = "Billing Dashboard";

require_once SERVER_CORE."routing/inc.notify.php";
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
    <title>Billing</title>
   <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../../../../public/dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  
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

            <div class="col-lg-3 col-md-6 col-sm-6">

                <div class="card card-stats" style="border: 1px solid orange;">

                    <div class="card-header card-header-warning card-header-icon">

                        <div class="card-icon p-0">

                            <i class="fab fa-avianex"></i>

                        </div>

                        <p class="card-category"> This Month</p>

                        <h3 class="card-title font-siz"> $ 00</h3>

                    </div>

                    <div class="card-footer" style="border-top:1px solid orange">

                        <div class="stats m-0">
                            <h5 class="m-0 font-weight-bold"> TOTAL BILL PAYABLE</h5>

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

                        <p class="card-category">This Month </p>

                        <h3 class="card-title font-siz"> $ 00</h3>

                    </div>

                    <div class="card-footer" style="border-top:1px solid green">

                        <div class="stats m-0"><h5 class="m-0 font-weight-bold"> TOTAL BILL RECEIVED </h5></div>

                    </div>
                </div>
            </div>




            <div class="col-lg-3 col-md-6 col-sm-6">

                <div class="card card-stats" style="border: 1px solid red;">

                    <div class="card-header card-header-danger card-header-icon">

                        <div class="card-icon p-0">

                            <i class="fas fa-hand-holding-usd"></i>

                        </div>

                        <p class="card-category"> This Month</p>

                        <h3 class="card-title font-siz">
                            $ 00
                        </h3>

                    </div>

                    <div class="card-footer" style="border-top:1px solid red">

                        <div class="stats m-0">
                            <h5 class="m-0 font-weight-bold">TOTAL BILL SUBMIT</h5>
                        </div>
                    </div>
                </div>
            </div>




            <div class="col-lg-3 col-md-6 col-sm-6">

                <div class="card card-stats" style="border: 1px solid #BA04F9;">

                    <div class="card-header card-header-primary card-header-icon">

                        <div class="card-icon p-0">

                            <i class="fas fa-chart-pie"></i>

                        </div>

                        <p class="card-category">Life Time</p>

                        <h3 class="card-title font-siz">  00</h3>

                    </div>

                    <div class="card-footer" style="border-top:1px solid #BA04F9">

                        <div class="stats m-0">
                            <h5 class="m-0 font-weight-bold"> TOTAL CUSTOMER</h5>

                        </div>
                    </div>
                </div>
            </div>






            <div class="col-lg-3 col-md-6 col-sm-6">

                <div class="card card-stats" style="border: 1px solid red;">

                    <div class="card-header card-header-danger card-header-icon">

                        <div class="card-icon p-0">

                            <i class="fas fa-chart-pie"></i>

                        </div>

                        <p class="card-category">Life Time</p>

                        <h3 class="card-title font-siz">  00</h3>

                    </div>

                    <div class="card-footer" style="border-top:1px solid red">

                        <div class="stats m-0">
                            <h5 class="m-0 font-weight-bold"> ACTIVE CUSTOMER</h5>

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

                        <p class="card-category">Life Time</p>

                        <h3 class="card-title font-siz">  00</h3>

                    </div>

                    <div class="card-footer" style="border-top:1px solid #1ec1d5">

                        <div class="stats m-0">
                            <h5 class="m-0 font-weight-bold"> INACTIVE CUSTOMER</h5>

                        </div>
                    </div>
                </div>
            </div>







        </div>



        <div class="row">


            <div class="col-lg-6 col-md-12">
                <div class="card card-chart" style="height: 290px; background-color: #FFFFFF;">
                    <div class="card-header">

                        <h4 class="card-title text-center bold"> <u>Last 7 Bill  Received Status</u> </h4>
                        <table align="center" class="table1  table-striped table-bordered table-hover table-sm">
                            <thead class="thead1 bold">
                            <tr class="bgc-info">
                                <td>Sl</td>
                                <td>Customer Name</td>
                                <td>Total Amount</td>
                                <td>Received Amount</td>
                            </tr>



                            </thead>


                            <tbody class="tbody1">

                            <tr>
                                <td> 0</td>
                                <td> 14</td>
                                <td> </td>
                                <td> </td>

                            </tr>

                            </tbody>

                        </table>




                    </div>
                </div>
            </div>




            <div class="col-lg-6 col-md-12">
                <div class="card card-chart" style="height: 290px; background-color: #FFFFFF;">
                    <div class="card-header">

                        <h4 class="card-title text-center bold"> <u>Last 7 Bill Submit Status</u> </h4>
                        <table align="center" class="table1  table-striped table-bordered table-hover table-sm">
                            <thead class="thead1 bold">
                            <tr class="bgc-info">
                                <td>Sl</td>
                                <td>Customer Name</td>
                                <td>Total Amount</td>
                                <td>Submit Amount</td>
                            </tr>



                            </thead>


                            <tbody class="tbody1">

                            <tr>
                                <td> 0</td>
                                <td> 14</td>
                                <td> </td>
                                <td> </td>


                            </tr>

                            </tbody>

                        </table>




                    </div>
                </div>
            </div>





            <div class="col-lg-12 col-md-12">
                <div class="card card-chart" style="height: 290px; background-color: #FFFFFF;">
                    <div class="card-header">

                        <h4 class="card-title text-center bold"> <u>Last 7 Customer Information</u> </h4>
                        <table align="center" class="table1  table-striped table-bordered table-hover table-sm">
                            <thead class="thead1 bold">
                            <tr class="bgc-info">
                                <td>Sl</td>
                                <td>Customer Name</td>
                                <td>Phone No</td>
                                <td>Address</td>
                                <td>Status</td>
                            </tr>



                            </thead>


                            <tbody class="tbody1">

                            <tr>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>

                            </tr>

                            </tbody>

                        </table>




                    </div>
                </div>
            </div>







        </div>




    </div>
</div>










<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>