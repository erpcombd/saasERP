<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";

$title = "Vehicle management Dashboard";
 $today = date('Y-m-d');
 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
 $cur = '&#x9f3;';
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
</head>



<div class="content">
        <div class="container-fluid">
		
		
		
		 <div class="row">
		 
		 
		  <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-primary">
                  <div class="card-icon">
                    <i class="fab fa-avianex"></i>
                  </div>
                  <p class="card-category" style="color:#FFFFFF">TOTAL VEHICLE</p>
                  <h3 class="card-title"><?=find_a_field('vehicle_info','count(vehicle_id)','1');?></h3>
                </div>
				
				
                <div class="card-footer">
                  <!--<div class="stats">
                    <i class="material-icons">update</i> Last 24 Hours
                  </div>-->
                </div>
              </div>
            </div>
		 
		  
		  <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info">
                  <div class="card-icon">
                    <i class="fab fa-avianex"></i>
                  </div>
                  <p class="card-category" style="color:#FFFFFF">REQUISITION(TODAY)</p>
                  <h3 class="card-title"><?=find_a_field('vehicle_requisition','count(req_no)','from_date="'.date('Y-m-d').'"');?></h3>
                </div>
				
				
                <div class="card-footer">
                  <!--<div class="stats">
                    <i class="material-icons">update</i> Last 24 Hours
                  </div>-->
                </div>
              </div>
            </div>
			
			
	
			
			<div class="col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success">
                  <div class="card-icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
                  <p class="card-category" style="color:#FFFFFF">FUEL EXPENSE(CURRENT MONTH)</p>
 <h3 class="card-title">৳ <?=find_a_field('fuel_expense_detail','sum(amount)','status="APPROVED" and expense_date between "'.date('Y-m-01').'" and "'.date('Y-m-31').'"')?></h3>
                </div>
                <div class="card-footer">
                  <!--<div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                  </div>-->
                </div>
              </div>
            </div>
			
			
			
			<div class="col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning">
                  <div class="card-icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
                  <p class="card-category" style="color:#FFFFFF">MAINTENANCE EXPENSE(CURRENT MONTH)</p>
<h3 class="card-title">৳ <?=find_a_field('tool_maintenance_detail','sum(amount)','status="APPROVED" and expense_date between "'.date('Y-m-01').'" and "'.date('Y-m-31').'"')?></h3>
                </div>
                <div class="card-footer">
                  <!--<div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                  </div>-->
                </div>
              </div>
            </div>
			
			
			</div>
<?



?>
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header card-header-success">
                  <h4 class="card-title">Notish Board</h4>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-primary">
                      <th>Vehicle</th>
                      <th>Type</th>
                      <th>Expire Date</th>
                      <th>Day Left</th>
                    </thead>
                    <tbody>
                        <?php
						
						$date = new DateTime();
						$date->modify("+30 day");
                          $sl = 'select d.*,v.vehicle_name from vehicle_doc_type d,vehicle_info v where d.vehicle_id=v.vehicle_id and d.exp_date between "'.date('Y-m-d').'" and "'.$date->format("Y-m-d").'"';
                          $qr = db_query($sl);
						  
						  
						  $cDate=date("Y-m-d");
                          while($dt=mysqli_fetch_object($qr)){
						  $date1=date_create($cDate);
						 $date2=date_create($dt->exp_date);
						 $diff=date_diff($date1,$date2);
						 $exp=$diff->format("%R%a days");
						  	
                        ?>
                      <tr >
                        <td ><?=$dt->vehicle_name?></td>
                        <td><?=$dt->type_name?></td>
                        <td><?=$dt->exp_date?></td>
                        <td class="alert alert-danger"><?=$exp?></td>
                      </tr>
                     <? } ?>
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