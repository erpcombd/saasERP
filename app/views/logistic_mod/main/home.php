<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";
$title = "Logistic Dashboard";
 $tr_type="Show";
 $today = date('Y-m-d');
 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
 $cur = '&#x9f3;';

$vehicle_qry = 'SELECT * FROM vehicle_information WHERE 1';
$vehicle_res = db_query($vehicle_qry);
while($vehicle_rows = mysqli_fetch_object($vehicle_res)){
    $vehicle_name[$vehicle_rows->id] = $vehicle_rows->vehicle_model.'::'.$vehicle_rows->reg_number ;
}

$vehicle_cost_qry = 'SELECT * FROM vehicle_cost_type WHERE 1';
$vehicle_cost_res = db_query($vehicle_cost_qry);
while($vehicle_cost_rows = mysqli_fetch_object($vehicle_cost_res)){
    $vehicle_cost_name[$vehicle_cost_rows->id] = $vehicle_cost_rows->cost_name;
}


do_datatable('example');









$tr_from="Purchase";
?>

  
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
    font-size: 18px;
		white-space: nowrap;
		overflow: hidden;
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
   @media (max-width: 768px) {
  .today-clock{
  display:none !important;  
  }
  }
  
</style>
                <?
                            $v_details_qry = 'SELECT 
                                            v.approved_vehicle,
                                            v.FromDate,
                                            v.ToDate,
                                            v.StartTime,
                                            v.ENDTime,
                                            v.to_location
                                        FROM 
                                            vehicle_req_list v
                                        JOIN 
                                            (SELECT 
                                                 approved_vehicle, MAX(id) AS max_id
                                             FROM 
                                                 vehicle_req_list
                                             WHERE 
                                                 1
                                             GROUP BY 
                                                 approved_vehicle) AS sub
                                        ON 
                                            v.approved_vehicle = sub.approved_vehicle 
                                            AND  v.approved_vehicle > 0 
                                            AND v.id = sub.max_id ';
                                         $v_details_res = db_query($v_details_qry);
                                        while($vehicle_details_rows =  mysqli_fetch_object($v_details_res)){
                                        $FromDate[$vehicle_details_rows->approved_vehicle]=$vehicle_details_rows->FromDate;
                                             
                                        $ToDate[$vehicle_details_rows->approved_vehicle]=$vehicle_details_rows->ToDate;
                                        
                                        $StartTime[$vehicle_details_rows->approved_vehicle]=$vehicle_details_rows->StartTime;
                                        
                                         $ENDTime[$vehicle_details_rows->approved_vehicle]=$vehicle_details_rows->ENDTime;
                                         
                                         $Location[$vehicle_details_rows->approved_vehicle]=$vehicle_details_rows->Location;
                                        }
?>

<div class="container-fluid">
    <div class="row m-0 p-0"> <!-- Row outside the loop -->
        <?php
        $vehicle_name_qry = 'SELECT id, vehicle_model,reg_number, sit_number FROM vehicle_information WHERE 1';
        $vh_name_res = db_query($vehicle_name_qry);
        while ($vehicle_name_rows = mysqli_fetch_object($vh_name_res)) {
            
            
if (isset($FromDate[$vehicle_name_rows->id]) && isset($StartTime[$vehicle_name_rows->id])) {
    $sSchedule = date('Y-m-d H:i:s', strtotime($FromDate[$vehicle_name_rows->id] . ' ' . $StartTime[$vehicle_name_rows->id]));
} else {
    $sSchedule = null; // Handle missing values
}


if (isset($ToDate[$vehicle_name_rows->id]) && isset($ENDTime[$vehicle_name_rows->id])) {
    $eSchedule = date('Y-m-d H:i:s', strtotime($ToDate[$vehicle_name_rows->id] . ' ' . $ENDTime[$vehicle_name_rows->id]));
} else {
    $eSchedule = null; // Handle missing values
}
       
      
      
            $alreadyAvailed = (date('Y-m-d H:i:s') >= $sSchedule && date('Y-m-d H:i:s') <= $eSchedule) ? 1 : 0;
			
        ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 new">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title bold">Model : <?=$vehicle_name_rows->vehicle_model?> <span>||Reg No: <?=$vehicle_name_rows->reg_number?> </span></h5>
                        <div class="d-flex justify-content-between p-3" style="background-color: <?= ($alreadyAvailed > 0) ? '#ffcccc' : '#ccffcc'; ?>;">
                            
                            <?=($alreadyAvailed > 0) ? 'Available IN:' : 'Available'; ?>
							<?if($alreadyAvailed > 0){ 
							$availSchedule = new DateTime($ToDate[$vehicle_name_rows->id] . ' ' . $ENDTime[$vehicle_name_rows->id]); 
							$currentTime = new DateTime();
							
							$diff = $currentTime->diff($availSchedule);
							
							echo '<br>'.$diff->format('%a days %h hours %i minutes'); 
								
								}?>
								
							
                          <!--<div class="new-icon primary" >-->
                          <!--  </div>-->
                            <!--<div class="new-icon-text">-->
                            <!--    <p class="p-sub1">-->
                            <!--        <span><i class="fa-solid fa-bangladeshi-taka-sign"></i>: <?= $amount ?? 0 ?></span>-->
                            <!--    </p>-->
                            <!--</div>-->
                        </div>
                        <a href="#" class="d-flex justify-content-center a">
                             <?if($alreadyAvailed > 0){?>
                             <button type="button" class="btn bg-danger button-cs d-flex justify-content-center" 
                                   >
                               
                                  Wait for Available 
                            </button>
                            
                            <?}else{?>
                            <button type="button" class="btn bg-primary button-cs d-flex justify-content-center" 
                                    onclick="window.open('../vehicle_req/manual_req.php', '_blank');">
                               
                                <i class="fas fa-check-circle"></i> Create Requisition 
                            </button>
                            <?}?>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    
    
    
    <br>
    <br>
    
    
    <div>
            <table id="example" class="table">
                
                <thead>
                    <tr>
                       <th>Vehicle No</th> 
                       <th>Cost Type</th> 
                       <th>Total Amount</th>
                    </tr>
                </thead>
                
                <tbody>
                    
                    <?php
                    
                       

                        $sql = "SELECT SUM(a.cost_amt) AS total_cost, a.cost_id, a.cost_id, b.vehicle_id FROM vehicle_req_cost a JOIN vehicle_cost_master b ON a.cost_id = b.id GROUP BY b.vehicle_id, a.cost_id";
                        $rslt = db_query($sql);
                        while($data = mysqli_fetch_object($rslt)){
                    
                    ?>
                     
                    <tr>
                       <td><?=$vehicle_name[$data->vehicle_id]?></td> 
                       <td><?=$vehicle_cost_name[$data->cost_id]?></td>
                       <td><?=$data->total_cost?></td>
                    </tr>
                    
                    <?php
                    
                        $cnt++;
                        
                        }
                    
                    ?>
                    
                </tbody>
                
            </table>
    </div>
</div>



   
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>