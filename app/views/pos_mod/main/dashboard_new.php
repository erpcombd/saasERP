<?php
require_once "../../../assets/template/layout.top.php";

?>


<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);

require_once "../../../assets/support/inc.all.php";




$req=$_GET['req'];


$dealercode=find_a_field('wo_requisition_master','dealer_code','req_no="'.$req.'"');
$dealername=find_a_field('dealer_info','dealer_name_e','dealer_code="'.$dealercode.'"');

?>







<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from designreset.com/cork/ltr/demo3/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Mar 2020 08:10:15 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>  </title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
	
	
	
	
	 <script src="assets/js/loader.js"></script>
	
	
	<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
   
 
 
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
	
	

</head>









<div class="main-container" id="container">

     

        <!--  BEGIN SIDEBAR  -->
        
        <!--  END SIDEBAR  -->
		
		
		
		
		<div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">
				
				
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">
						

                    <div class="header">
                                    <div class="header-body">
                                        <h6>All task and Services at a glance And Create new also </h6>
                                        <p class="meta-date"><?php echo date("Y/m/d") ; ?></p>
										
										



                                    </div>
                                    <div class="task-action">
                                        <div class="dropdown  custom-dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask">
                                                <a class="dropdown-item" href="javascript:void(0);"><a href="../motif_do/do.php" target="_blank" class="btn btn-danger">New Service +</a></a>
                                                <a class="dropdown-item" href="javascript:void(0);"><a href="../other_issue/other_issue.php" target="_blank" class="btn btn-danger">Direct Service +</a></a>
                                                <a class="dropdown-item" href="javascript:void(0);"><a href="../pof/po_create.php" target="_blank" class="btn btn-danger">New Purchase +</a></a>
                                                <a class="dropdown-item" href="javascript:void(0);"><a href="../other_receive/local_purchase.php" target="_blank" class="btn btn-danger">Direct Purchase+</a></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                    </div>
					
					
					
					
					
					
					
					
					
				
				
				  <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">

                            <div class="widget-heading">
                                <h5 class="" style="color:#00988b">Service / Task Request
								<p style="float:right"><a href="../motif_do/do.php" target="_blank" class="btn btn-primary">New +</a> </p>
								
								</h5>
								
								
                            </div>

                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Req No</div></th>
                                                <th><div class="th-content">Request Provider</div></th>
                                                <th><div class="th-content">Req For</div></th>
                                             
                                            </tr>
                                        </thead>
										
										
                                        <tbody>
										
									<?php		
				
						$res = "select a.req_no req,a.req_no,d.dealer_name_e,req_for from wo_requisition_master a,dealer_info d where  a.status ='UNCHECKED' and a.dealer_code=d.dealer_code and a.req_no='".$req."'
 order by a.req_date desc";
 $query=mysql_query($res);
 while($data=mysql_fetch_object($query)){
						?>	
						                
					                     <tr onClick="location.href='../motif_do/do.php?req=<?=$req;?>'">
										 
										 <td ><div class="td-content"><?=$data->req_no ?></div></td>
										 
										 <td><div class="td-content product-brand"><?=$data->dealer_name_e ?></div></td>
                                         <td><div class="td-content"><?=$data->req_for ?></div></td>
										 
										
                                  
									
									
									</tr>
							        
									 <?php } ?>		
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							
							
						
							<!-- end  another -->
							
                        </div>
                    </div>
					
					
					
					
					
					
					 <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">
					
					
					
					
							
							
								 <div class="widget-heading">
                                <h5 class="" style=" color:#fe434f">MRR
								<p style="float:right"><a href="../motif_do/do.php" target="_blank" class="btn btn-primary">New +</a> </p> </h5>
                            </div>
							
							
							<div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Req No</div></th>
                                                <th><div class="th-content">Request Provider</div></th>
                                                <th><div class="th-content">Req For</div></th>
                                             
                                            </tr>
                                        </thead>
										
										
                                        <tbody>
							<?php		
				
						$res = "select a.req_no req,a.req_no,d.dealer_name_e,req_for from wo_requisition_master a,dealer_info d where  a.status ='UNCHECKED' and a.dealer_code=d.dealer_code and a.req_no='".$req."'
 order by a.req_date desc";
 $query=mysql_query($res);
 while($data=mysql_fetch_object($query)){
						?>	
										
						                
					                     <tr onClick="location.href='../motif_do/do.php?req=<?=$req;?>'">
										 
										 <td ><div class="td-content"><?=$data->req_no ?></div></td>
										 
										 <td><div class="td-content product-brand"><?=$data->dealer_name_e ?></div></td>
                                         <td><div class="td-content"><?=$data->req_for ?></div></td>
										 
										
                                  
									
									
									</tr>
							        <?php } ?> 
											
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							
					   </div>
                    </div>
					
					
					
					
				<!-- end  another -->	
				
				
				
				
					<!-- start another 3 -->
					
					<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">
						
						
						
						<div class="widget-heading">
                                <h5 class="" style="color:#ff4379">Direct Service 
								<p style="float:right"><a href="../other_issue/other_issue.php" target="_blank" class="btn btn-primary">New +</a> </p></h5>
                            </div>
							
							
							
							
							<div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Req No</div></th>
                                                <th><div class="th-content">Request Provider</div></th>
                                                <th><div class="th-content">Req For</div></th>
                                             
                                            </tr>
                                        </thead>
										
										
                                        <tbody>
						<?php		
				
						$res = "select a.req_no req,a.req_no,d.dealer_name_e,req_for from wo_requisition_master a,dealer_info d where  a.status ='UNCHECKED' and a.dealer_code=d.dealer_code and a.req_no='".$req."'
 order by a.req_date desc";
 $query=mysql_query($res);
 while($data=mysql_fetch_object($query)){
						?>			
						                
					                     <tr onClick="location.href='../other_issue/other_issue.php?req=<?=$req;?>'">
										 
										 <td ><div class="td-content"><?=$data->req_no ?></div></td>
										 
										 <td><div class="td-content product-brand"><?=$data->dealer_name_e ?></div></td>
                                         <td><div class="td-content"><?=$data->req_for ?></div></td>
									
                                  
									
									
									</tr>
							        <?php } ?> 
											
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
						
					
					
					      </div>
                    </div>
					
					
					<!-- end  another -->
					
					
					
					<!-- start another 2 -->
					
					
					 <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">
					
					
					
					
							
							
							 <div class="widget-heading">
                                <h5 class="" style="color:#f19d38">Service / Task Purchase Order
								
								<p style="float:right"><a href="../pof/po_create.php" target="_blank" class="btn btn-primary">New +</a> </p> </h5>
                            </div>
							
							
							<div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Req No</div></th>
                                                <th><div class="th-content">Request Provider</div></th>
                                                <th><div class="th-content">Req For</div></th>
                                             
                                            </tr>
                                        </thead>
										
										
                                        <tbody>
							<?php		
				
						$res = "select a.req_no req,a.req_no,d.dealer_name_e,req_for from wo_requisition_master a,dealer_info d where  a.status ='UNCHECKED' and a.dealer_code=d.dealer_code and a.req_no='".$req."'
 order by a.req_date desc";
 $query=mysql_query($res);
 while($data=mysql_fetch_object($query)){
						?>	
										
						                
					                     <tr onClick="location.href='../pof/po_create.php?req=<?=$req;?>'">
										 
										 <td ><div class="td-content"><?=$data->req_no ?></div></td>
										 
										 <td><div class="td-content product-brand"><?=$data->dealer_name_e ?></div></td>
                                         <td><div class="td-content"><?=$data->req_for ?></div></td>
									
                                  
									
									
									</tr>
							        <?php } ?> 
											
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							
					   </div>
                    </div>
					
					
					
					
				<!-- end  another -->	
				
				
				
				
				
				
				
				<!-- start another 3 -->
					
					
					
				
				
				
				
				
				
					
					
					
					
					
					
					
					
					
				<!--   break   --->	
					
					
					<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">
						
						
						

                            <div class="widget-heading">
                                <h5 class="" style="color:#00aa5a">Service / Task Order  
								<p style="float:right"><a href="../motif_do/do.php" target="_blank" class="btn btn-primary">New +</a> </p>
								</h5>
								
								
								
								
								
                            </div>

                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Req No</div></th>
                                                <th><div class="th-content">Request Provider</div></th>
                                                <th><div class="th-content">Req For</div></th>
                                             
                                            </tr>
                                        </thead>
										
										
                                        <tbody>
							<?php		
				
						$res = "select a.req_no req,a.req_no,d.dealer_name_e,req_for from wo_requisition_master a,dealer_info d where  a.status ='UNCHECKED' and a.dealer_code=d.dealer_code and a.req_no='".$req."'
 order by a.req_date desc";
 $query=mysql_query($res);
 while($data=mysql_fetch_object($query)){
						?>
										
						                
					                     <tr onClick="location.href='../motif_do/do.php?req=<?=$req;?>'">
										 
										 <td ><div class="td-content"><?=$data->req_no ?></div></td>
										 
										 <td><div class="td-content product-brand"><?=$data->dealer_name_e ?></div></td>
                                         <td><div class="td-content"><?=$data->req_for ?></div></td>
									
                                  
									
									
									</tr>
							        <?php } ?> 
											
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							
							
							
					
                        </div>
                    </div>
					
					
					<!-- end  another -->
							
							<!-- start another -->
					
					
					
					
					
					<!-- start another 4 -->
					
					
					 <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">
					
					
					
					
							
							
							 <div class="widget-heading">
                                <h5 class="" style="color:#fe434f">Direct Purchase
								<p style="float:right"><a href="../other_receive/local_purchase.php" target="_blank" class="btn btn-primary">New +</a> </p> </h5>
                            </div>
							
							
							<div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Req No</div></th>
                                                <th><div class="th-content">Request Provider</div></th>
                                                <th><div class="th-content">Req For</div></th>
                                             
                                            </tr>
                                        </thead>
										
										
                                        <tbody>
							<?php		
				
						$res = "select a.req_no req,a.req_no,d.dealer_name_e,req_for from wo_requisition_master a,dealer_info d where  a.status ='UNCHECKED' and a.dealer_code=d.dealer_code and a.req_no='".$req."'
 order by a.req_date desc";
 $query=mysql_query($res);
 while($data=mysql_fetch_object($query)){
						?>	
										
						                
					                     <tr onClick="location.href='../other_receive/local_purchase.php?req=<?=$req;?>'">
										 
										 <td ><div class="td-content"><?=$data->req_no ?></div></td>
										 
										 <td><div class="td-content product-brand"><?=$data->dealer_name_e ?></div></td>
                                         <td><div class="td-content"><?=$data->req_for ?></div></td>
										
                                  
									
									
									</tr>
							        <?php } ?> 
											
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							
					   </div>
                    </div>
					
					
					
					
				<!-- end  another -->	
					
					
						
							
					<!-- start another 2 -->
					
					<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-two">
						
						
						
						 <div class="widget-heading">
                                <h5 class="">Service / Task Status 
								
								<p style="float:right"><a href="../wojoud_do/do_chalan.php" target="_blank" class="btn btn-primary">New +</a> </p></h5>
								
								
                            </div>
							
							<div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Req No</div></th>
                                                <th><div class="th-content">Request Provider</div></th>
                                                <th><div class="th-content">Req For</div></th>
                                             
                                            </tr>
                                        </thead>
										
										
                                        <tbody>
						<?php		
				
						$res = "select a.req_no req,a.req_no,d.dealer_name_e,req_for from wo_requisition_master a,dealer_info d where  a.status ='UNCHECKED' and a.dealer_code=d.dealer_code and a.req_no='".$req."'
 order by a.req_date desc";
 $query=mysql_query($res);
 while($data=mysql_fetch_object($query)){
						?>			
						                
					                     <tr onClick="location.href='../wojoud_do/do_chalan.php?req=<?=$req;?>'">
										 
										 <td ><div class="td-content"><?=$data->req_no ?></div></td>
										 
										 <td><div class="td-content product-brand"><?=$data->dealer_name_e ?></div></td>
                                         <td><div class="td-content"><?=$data->req_for ?></div></td>
									
                                  
									
									
									</tr>
							        <?php } ?> 
											
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
						
						
					
					
					      </div>
                    </div>
					
					
					<!-- end  another -->
					
					
					
					
					
					
			
                    
					
					
					

                    

                    

                    

                    

                    

                    

                    

                    

                    

                    

                </div>

            </div>

            
        </div>
		
		
        
        <!--  BEGIN CONTENT AREA  -->
        
        <!--  END CONTENT AREA  -->

    </div>






   <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="plugins/apex/apexcharts.min.js"></script>
    <script src="assets/js/dashboard/dash_1.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="plugins/apex/apexcharts.min.js"></script>
    <script src="assets/js/dashboard/dash_2.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->


<?

require_once "../../../assets/template/layout.bottom.php";

?>