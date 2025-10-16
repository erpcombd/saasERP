<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
?>
<link href="../../../../../public/dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
<style>@media (max-width: 768px) {
  .today-clock{
  display:none !important;  
  }
  }
  </style>




    <div class="content">
        <div class="container-fluid">





            <div class="row">

                <div class="col-lg-3 col-md-3 col-sm-12">

                    <div class="card card-stats" style="border: 1px solid orange;">

                        <div class="card-header card-header-warning card-header-icon">

                            <div class="card-icon p-0">

                                <i class="fab fa-avianex"></i>

                            </div>

                            <p class="card-category bold"> TOTAL</p>

                            <h3 class="card-title font-siz">00</h3>

                        </div>

                        <div class="card-footer" style="border-top:1px solid orange">

                            <div class="stats m-0">
                                <h5 class="m-0 font-weight-bold"> RAW  MATERIALS</h5>

                            </div>

                        </div>

                    </div>

                </div>





                <div class="col-lg-3 col-md-3 col-sm-12">

                    <div class="card card-stats" style="border: 1px solid green;">

                        <div class="card-header card-header-success card-header-icon">

                            <div class="card-icon p-0">

                                <i class="fas fa-donate"></i>

                            </div>

                            <p class="card-category bold">TOTAL </p>

                            <h3 class="card-title font-siz">00</h3>

                        </div>

                        <div class="card-footer" style="border-top:1px solid green">

                            <div class="stats m-0"><h5 class="m-0 font-weight-bold"> TODAY PRODUCTION</h5></div>

                        </div>
                    </div>
                </div>



                <div class="col-lg-3 col-md-3 col-sm-12">

                    <div class="card card-stats" style="border: 1px solid red;">

                        <div class="card-header card-header-danger card-header-icon">

                            <div class="card-icon p-0">

                                <i class="fas fa-hand-holding-usd"></i>

                            </div>

                            <p class="card-category bold"> TOTAL </p>

                            <h3 class="card-title font-siz">
                                $ 00
                            </h3>

                        </div>

                        <div class="card-footer" style="border-top:1px solid red">

                            <div class="stats m-0">
                                <h5 class="m-0 font-weight-bold">TODAY CONGESTION</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12">

                    <div class="card card-stats" style="border: 1px solid #1ec1d5;">

                        <div class="card-header card-header-info card-header-icon">

                            <div class="card-icon p-0">

                                <i class="fas fa-chart-pie"></i>

                            </div>

                            <p class="card-category bold">TOTAL</p>

                            <h3 class="card-title font-siz">00</h3>

                        </div>

                        <div class="card-footer" style="border-top:1px solid #1ec1d5">

                            <div class="stats m-0">
                                <h5 class="m-0 font-weight-bold"> FLOW REQUISITION</h5>

                            </div>
                        </div>
                    </div>
                </div>




                <div class="col-lg-3 col-md-3 col-sm-12">

                    <div class="card card-stats" style="border: 1px solid red;">

                        <div class="card-header card-header-danger card-header-icon">

                            <div class="card-icon p-0">

                                <i class="fas fa-hand-holding-usd"></i>

                            </div>

                            <p class="card-category bold"> TOTAL </p>

                            <h3 class="card-title font-siz">
                                $ 00
                            </h3>

                        </div>

                        <div class="card-footer" style="border-top:1px solid red">

                            <div class="stats m-0">
                                <h5 class="m-0 font-weight-bold">TODAY PRODUCTION SALES</h5>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>






<?
   


require_once SERVER_CORE."routing/layout.bottom.php";



?>