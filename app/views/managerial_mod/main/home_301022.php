<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = "Purchase Management Dashboard";

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
		
		
		
		<!--new-->

<div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid orange;">

                <div class="card-header card-header-warning card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fab fa-avianex"></i>

                  </div>

                  <p class="card-category"> Last 24 Hours </p>

                  <h3 class="card-title font-siz">0</h3>

                    <small></small>

                  </h3>

                </div>

               <div class="card-footer" style="border-top:1px solid orange">

                  <div class="stats m-0">
				  <h5 class="m-0">TOTAL PO VALUE</h5>
				  
                  </div>

                </div>

              </div>

            </div>

			
			
			

            <div class="col-lg-3 col-md-6 col-sm-6">

              <div class="card card-stats" style="border: 1px solid green;">

                <div class="card-header card-header-success card-header-icon">

                  <div class="card-icon p-0">
                   <i class="fas fa-store"></i>

                  </div>

                  <p class="card-category">  Last 24 Hours </p>

                  <h3 class="card-title font-siz">0</h3>

                </div>

                <div class="card-footer" style="border-top:1px solid green">

                  <div class="stats m-0"><h5 class="m-0"> TOTAL LOW STOCK</h5></div>
				  
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

                  <h3 class="card-title font-siz"><?=find_a_field('purchase_master','count(po_no)','status not in ("COMPLETED")');?></h3>

                </div>

                <div class="card-footer" style="border-top:1px solid #a217d9">

                  <div class="stats m-0">
				  <h5 class="m-0"> TOTAL PENDING PO</h5>
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

                  <h3 class="card-title font-siz"><?=$cur.number_format(find_a_field('purchase_master','count(po_no)','1 and status="CHECKED"'),0);?></h3>

                </div>

                <div class="card-footer" style="border-top:1px solid #1ec1d5">

                  <div class="stats m-0">
				  <h5 class="m-0"> MRR PENDING</h5>
				 
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
							<h4 class="card-title">LAST WEEK'S TOP ITEMS </h4>
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
									<p class="card-category"  style="color:#BA04F9; font-weight:bold;">LAST WEEK'S TOTAL GRM</p>
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
	
					<div class="card-header card-header-success card-header-icon">
	
					  <div class="card-icon p-0">
	
					   <i class="fab fa-audible"></i>
	
					  </div>
	
					  <p class="card-category" style="color:#0CBB37; font-weight:bold;">LAST WEEK'S NEW VENDOR</p>
	
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
	
					  <p class="card-category"  style="color:#F00712; font-weight:bold;">	LAST WEEK'S PO TOP ITEM</p>
	
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
	
					  <p class="card-category" style="color:#F5DB01; font-weight:bold;">LAST WEEK'S MRR COMPLET</p>
	
					  <h3 class="card-title">0</h3>
	
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
		  <div class="col-lg-6 col-md-12">
				<div class="card card-chart">
					<div class="card-body table-responsive">
						<h4 class="card-title text-center font-weight-bold">LAST 5 VENDOR INFORMATION</h4>
						 <p class="card-category text-center">Just Updated</p>
					  <table class="table table-hover table-striped">
						<thead class="bg-success text-light">
						  <th class="font-weight-bold">Code</th>
						  <th class="font-weight-bold">Name</th>
						  <th class="font-weight-bold">Contact</th>
						  <th class="font-weight-bold">Company</th>
						</thead>
						<tbody>
							<?php
							  $sl = 'select * from vendor where 1 order by vendor_id desc limit 5';
							  $qr = db_query($sl);
							  while($dt=mysqli_fetch_object($qr)){
							?>
						  <tr>
							<td><?=$dt->vendor_id?></td>
							<td><?=$dt->vendor_name?></td>
							<td><?=$dt->contact_no?></td>
							<td><?=$dt->vendor_company?></td>
						  </tr>
						 <? } ?>
						</tbody>
					  </table>
					</div>
				  </div>
				  
				</div>
				
				
				
				
			<div class="col-lg-6 col-md-12">
				<div class="card card-chart">
					<div class="card-body table-responsive">
						<h4 class="card-title text-center font-weight-bold">LAST WEEK'S TOP 5 ITEM INFORMATION</h4>
						 <p class="card-category text-center">Just Updated</p>
					  <table class="table table-hover table-striped">
						<thead class="bg-info text-light">
						  <th class="font-weight-bold">Code</th>
						  <th class="font-weight-bold">Item Name</th>
						  <th class="font-weight-bold">Total PO</th>
						  <th class="font-weight-bold">Total Sales</th>
						</thead>
						<tbody>

						  <tr>
							<td>001</td>
							<td>Item 1</td>
							<td>1000</td>
							<td>990</td>
						  </tr>
						  
						  <tr>
							<td>002</td>
							<td>Item 2</td>
							<td>1100</td>
							<td>890</td>
						  </tr>
						  
						  <tr>
							<td>003</td>
							<td>Item 3</td>
							<td>900</td>
							<td>790</td>
						  </tr>
						  
						  <tr>
							<td>004</td>
							<td>Item 4</td>
							<td>1200</td>
							<td>1001</td>
						  </tr>
						  
						  <tr>
							<td>005</td>
							<td>Item 5</td>
							<td>1500</td>
							<td>1290</td>
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




<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>-->
<script type="text/javascript">
 <!--/////////////2rd One Week Report chart//////////////////-->
    
  var oilCanvas = document.getElementById("oilChart");

Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var oilData = {
    labels: [
        "ITEMS 1",
        "ITEMS 2",
        "ITEMS 3",
        "ITEMS 4"
      
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




</script>
