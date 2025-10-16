<?php
session_start();
ob_start();
//====================== EOF ===================

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
	
	<style>
    .main-content > *{
	font-size:12px;	
		}
    </style>

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
                                        <h6>All transactions and Services at a glance And Create new also </h6>
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
				
				  <div class="row">
                  <div class="col-sm-6">
    <div class="col-sm-12 layout-spacing">
                        <div class="widget widget-table-two">

                            <div class="widget-heading">
                                <h5 class="" style="color:#00988b">TOP 5 Stock Product
								<p style="float:right"><a href="../ob/opening_balance.php" target="_blank" class="btn btn-primary">New +</a> </p>
								
								</h5>
								
								
                            </div>

                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Sl</div></th>
                                                <th><div class="th-content">Item name</div></th>
                                                <th><div class="th-content">Stock</div></th>
                                             
                                            </tr>
                                        </thead>
										
										
                                        <tbody>
										
									<?php		
				
						$res = "select item_info.item_name,sum(journal_item.item_in-journal_item.item_ex) as stock from journal_item left join item_info on item_info.item_id = journal_item.item_id where warehouse_id = '".$_SESSION['user']['depot']."' GROUP BY journal_item.item_id having sum(journal_item.item_in-journal_item.item_ex) > 0 ORDER BY stock desc limit 0, 5";
 $query=mysql_query($res);
 $r =0;
 $r_count = mysql_num_rows($query);
 if($r_count>0){
while($data=mysql_fetch_assoc($query)){
	 extract($data);
	 $r++;
	?>
    <tr>
	<td ><div class="td-content"><?=$r?></div></td>
	<td><div class="td-content"><?=$item_name?></div></td>
    <td><div class="td-content"><?=$stock?></div></td>
	</tr>
	 <?php } 		 
	 }else{
	echo "<tr><td><div class='td-content'>No Data Found</div></td></tr>";
	 }
 ?>	
    </tbody>
    </table>
	</div>
    </div>
	</div>
    </div>
    <div class="col-sm-12 layout-spacing">
                        <div class="widget widget-table-two">
					
					
					
					
							
							
								 <div class="widget-heading">
                                <h5 class="" style=" color:#fe434f">Last 5 Stock IN Products
								<p style="float:right"><a href="../motif_do/do.php" target="_blank" class="btn btn-primary">New +</a> </p> </h5>
                            </div>
							
							
							<div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">SL</div></th>
                                                <th><div class="th-content">Item Name</div></th>
                                                <th><div class="th-content">Qty</div></th>
                                                <th><div class="th-content">Transaction From</div></th>
                                            </tr>
                                        </thead>
										
										
                                        <tbody>
							<?php		
				
						$res = "select item_info.item_name, journal_item.item_in, journal_item.tr_from FROM journal_item, item_info where journal_item.warehouse_id = '".$_SESSION['user']['depot']."' AND item_info.item_id = journal_item.item_id and journal_item.item_in > 0 order BY journal_item.id DESC LIMIT 0,5";
 $query=mysql_query($res);
 $j=0;
 $rr_count = mysql_num_rows($query);
 if($rr_count>0){
 while($data=mysql_fetch_assoc($query)){
$j++;
	 extract($data);
						?>	
										
						                
					                     <tr>
										 
										 <td ><div class="td-content"><?=$j?></div></td>
										 
										 <td><div class="td-content product-brand"><?=$item_name?></div></td>
                                         <td><div class="td-content"><?=$item_in?></div></td>
										 <td><div class="td-content"><?=$tr_from?></div></td>
										
                                  
									
									
									</tr>
							        <?php } 
 }else{
echo "<tr><td><div class='td-content'>No Data Found</div></td></tr>";
	 }
									?> 
											
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							
					   </div>
                    </div>
    <div class="col-sm-12 layout-spacing">
                        <div class="widget widget-table-two">
						
						
						
<div class="widget-heading"><h5 class="" style="color:#ff4379">Last 5 Material Requisition<p style="float:right"><a href="../mr/mr_create.php?new=2" target="_blank" class="btn btn-primary">New +</a> </p></h5>
                            </div>
							
							
							
							
							<div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Req No</div></th>
												<th><div class="th-content">Req Date</div></th>
                                                <th><div class="th-content">Req For</div></th>
                                                <th><div class="th-content">Request Provider</div></th>
                                                <th><div class="th-content">Status</div></th>
                                             
                                            </tr>
                                        </thead>
										
										
                                        <tbody>
<?php		
$res = "SELECT requisition_master.req_no, requisition_master.req_date, requisition_master.req_note, user_activity_management.fname, requisition_master.status FROM requisition_master, user_activity_management WHERE requisition_master.entry_by = user_activity_management.user_id order by requisition_master.req_no and requisition_master.depot='".$_SESSION['user']['depot']."' desc limit 0,5";
$query=mysql_query($res);
$ee_count = mysql_num_rows($query);
if($ee_count>0){
 while($data=mysql_fetch_assoc($query)){
	 extract($data);
						?>			
						                
					                     <tr onClick="location.href='../other_issue/other_issue.php?req=<?=$req;?>'">
										 
										 <td ><div class="td-content"><?=$req_no ?></div></td>
										 
										 <td><div class="td-content"><?=$req_date?></div></td>
                                         <td><div class="td-content"><?=$req_note?></div></td>
                                         <td><div class="td-content"><?=$fname?></div></td>                                         
                                         <td><div class="td-content"><?=$status?></div></td>                                         
									
                                  
									
									
									</tr>
							        <?php } }else{echo "<tr><td><div class='td-content'>No Data Found</div></td></tr>";}?> 
											
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
						
					
					
					      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                   <div class="col-sm-12 layout-spacing">
                        <div class="widget widget-table-two">
					
					
					
					
							
							
							 <div class="widget-heading">
                                <h5 class="" style="color:#f19d38">Last 5 Stock Out Products
								
								<p style="float:right"><a href="../pof/po_create.php" target="_blank" class="btn btn-primary">New +</a> </p> </h5>
                            </div>
							
							
							<div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Id</div></th>
                                                <th><div class="th-content">Item Name</div></th>
                                                <th><div class="th-content">Qty</div></th>
                                                <th><div class="th-content">Transaction From</div></th>                                             
                                            </tr>
                                        </thead>
										
										
                                        <tbody>
							<?php
                            $res = "select item_info.item_name, journal_item.item_ex, journal_item.tr_from FROM journal_item, item_info where journal_item.warehouse_id = ".$_SESSION['user']['depot']." AND item_info.item_id = journal_item.item_id and journal_item.item_ex > 0 order BY journal_item.id DESC LIMIT 0,5";
 $query=mysql_query($res);
 $r=0;
 $ww_count = mysql_num_rows($query);
 if($ww_count>0){
 while($data=mysql_fetch_assoc($query)){
	 extract($data);
	 $r++;
						?>	
										
						                
					                     <tr>
										 
										 <td ><div class="td-content"><?=$r?></div></td>
										 
										 <td><div class="td-content product-brand"><?=$item_name?></div></td>
                                         <td><div class="td-content"><?=$item_ex?></div></td>
                                         <td><div class="td-content"><?=$tr_from?></div></td>
									</tr>
							        <?php } }else{
echo "<tr><td><div class='td-content'>No data Found</div></td></tr>";
										}?> 
											
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							
					   </div>
                    </div>
					
					<div class="col-sm-12 layout-spacing">
                        <div class="widget widget-table-two">
						
						
						

                            <div class="widget-heading">
                                <h5 class="" style="color:#00aa5a">Pending Delivery Challan <p style="float:right"><a href="../motif_do/do.php" target="_blank" class="btn btn-primary">New +</a> </p>
								</h5>
								
								
								
								
								
                            </div>

                            <div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">Do No</div></th>
                                                <th><div class="th-content">Do Date</div></th>
                                                <th><div class="th-content">Dealer Name</div></th>
                                                <th><div class="th-content">Status</div></th>                                             
                                                <th><div class="th-content">Action</div></th>
                                            </tr>
                                        </thead>
										
										
                                        <tbody>
							<?php		
				
$res = "select sale_do_master.do_no, sale_do_master.do_date, dealer_info.dealer_name_e, sale_do_master.status from sale_do_master left join dealer_info ON dealer_info.dealer_code = sale_do_master.dealer_code where sale_do_master.status = 'CHECKED' order by sale_do_master.do_no desc limit 0,5";
 $query=mysql_query($res);
 while($data=mysql_fetch_assoc($query)){
	 extract($data);
						?>	                
					                     <tr onClick="location.href='../motif_do/do.php?req=<?=$req;?>'">
										 
										 <td align="center" valign="middle" style="text-align: center" ><div class="td-content"><?=$do_no?></div></td>
										 <td align="center" valign="middle" style="text-align: center" ><div class="td-content"><?=$do_date?></div></td>
										 <td align="center" valign="middle" style="text-align: center" ><div class="td-content"><?=$dealer_name_e?></div></td>
                                         <td align="center" valign="middle" style="text-align: center"><div class="td-content"><?=$status?></div></td>
										<td align="center" valign="middle" style="text-align: center"><a target="_blank" href="../do/do_chalan.php?do=<?=$do_no?>" class="btn btn-danger">Open</a></td>
									</tr>
							        <?php } ?> 
											
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							
							
							
					
                        </div>
                    </div>
                    
					 <div class="col-sm-12 layout-spacing">
                        <div class="widget widget-table-two">
					
					
					
					
							
							
							 <div class="widget-heading">
                                <h5 class="" style="color:#fe434f">Pending Purchase Receive<p style="float:right"><a href="../other_receive/local_purchase.php" target="_blank" class="btn btn-primary">New +</a> </p> </h5>
                            </div>
							
							
							<div class="widget-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><div class="th-content">PO No</div></th>
                                                <th><div class="th-content">PO Date</div></th>
                                                <th><div class="th-content">Vendor Name</div></th>
                                                <th><div class="th-content">Status</div></th>
                                                <th><div class="th-content">Action</div></th>
                                             
                                            </tr>
                                        </thead>
										
										
                                        <tbody>
							<?php		
$res = "select purchase_master.po_no, purchase_master.po_date, vendor.vendor_name, purchase_master.status from purchase_master, vendor where purchase_master.vendor_id = vendor.vendor_id and purchase_master.status = 'CHECKED' and purchase_master.warehouse_id = ".$_SESSION['user']['depot']." ORDER BY purchase_master.po_no DESC LIMIT 0, 5";
$query=mysql_query($res);
while($data=mysql_fetch_assoc($query)){
extract($data);
						?>				 <tr onClick="location.href='../other_receive/local_purchase.php?req=<?=$req;?>'">
										 
										 <td ><div class="td-content"><?=$po_no?></div></td>
										 <td><div class="td-content product-brand"><?=$po_date?></div></td>
                                         <td><div class="td-content"><?=$vendor_name?></div></td>
                                         <td><div class="td-content"><?=$status?></div></td>
                                         <td><div class="td-content"><a href=""></a></div></td>										
                                  
									
									
									</tr>
							        <?php } ?> 
											
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							
					   </div>
                    </div>
                  </div>
                  </div>
                  
					
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