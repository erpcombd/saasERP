<?php
require_once "../../../controllers/routing/layout.top.php";
$current_page = "events";

$report_unique_id=$_GET['unique_report_id'];
$title='eProcurement Entry';
do_calander("#f_date");
do_calander("#t_date");
//do_datatable('rfq_table');
unset($_SESSION['rfq_no']);
unset($_SESSION['rfq_version']);
unset($_SESSION['master_status']);


// ini_set('display_errors','1');
// ini_set('display_startup_errors','1');
// error_reporting(E_ALL);




$sql_str = "SELECT * FROM report_structure_information WHERE report_id='".$_GET['unique_report_id']."'";
$result = $conn->query($sql_str);
echo '<script>
const columnDefs = [];



</script>'; 

if ($result->num_rows > 0) {
    // Fetch each row
    while ($row = $result->fetch_assoc()) {
 
		// echo ' columnOrderingData.push({columnIndex: "'.$row['column_index'].'", sortOrder: "'.$sort_order.'"})';
        echo '<script>
            columnDefs.push({
                targets: ' . intval($row['original_index']) . ', 
                visible: ' . $row['visibility']. '
            });
        </script>';
	  


        // For demonstration purposes, echo the variable name and value
        // echo $columnNameOrder.": rrrrrrrrrrrrrrrrrrrrrrrrrr" . $$columnNameOrder . "<br>";
    }
}

echo '<script>
columnDefs.push( { targets: "_all", visible: false });

</script>';

if(isset($_POST['del'])){
	$rfq_master = find_all_field('rfq_master','*','rfq_no='.$_POST['rfq_no']);
	if($rfq_master->status=='MANUAL'){
		
		$delQl = 'update rfq_master set del = 1 where rfq_no = '.$rfq_master->rfq_no;
		db_query($delQl);   
	
		
		$msg = "Deleted Successfuly";
	}
}
?>

<? //include_once 'ep_menu.php'; ?>
    <script type="text/javascript" src="../../../../public/assets/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../../../../public/assets/js/jquery-3.4.1.min.js"></script>


<style>
.nav-tabs .nav-item .nav-link, .nav-tabs .nav-item .nav-link:hover, .nav-tabs .nav-item .nav-link:focus {
    border: 0 !important;
    color: #007bff !important;
    font-weight: 500;
}
.sidebar, .sidemenu{
	display:none;
    width: 0% !important;
}

.main_content{
	width: 100% !important;
}

.tab-content>.active {
    display: block;
    border: 1px solid #f5f5f5;
	background-color: #fbfbfb9e;
}

.nav-tabs .nav-item .nav-link.active{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}
.nav-tabs .nav-item .nav-link:hover{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}
.d-flex-bg-color{
background-color:#333 !important;
}
.ep-bg-color{
	background-color:#f5f5f5 !important;
}
.btn1-bg-submit{
	margin:10px !important;
	background-color:#FFFFFF !important;
	color:#333 !important;
	font-weight:bold !important;	
}
.alerts-bg{
	background-color:#f0f0f0;
	padding:10px;
}
.bg-alerts-bg{
background-color:#FFFFFF !important;
}
.alerts-table{
	height:300px !important;
}
.sourcing-table{
	width:100%;
}

.sourcing-table tr:nth-child(odd), .sourcing-table tr:nth-child(even)  {
    background-color: #fff !important;
    color: #333!important;
	text-align:left;
}
.tab-pane{
height:292px;
background-color:#fff !important;
}
.nav-tabs {
    border-bottom: 1px solid #d9d9d9;
    background-color: #fffefe;
}

 .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 210px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
	left: 10px; 
	padding: 5px 0px;
	border-radius: 3px;
	background-color: white;
  }
  .dropdown-content a{
  	background-color:#fff !important;
	text-align:left;
	padding: 5px 0px 5px 10px;
  }
  .dropdown-content a:hover{
  color:#f37025;
  }
  
  
  
  .fs-8{font-size:8px !important;}.fs-9{font-size:9px !important;}.fs-10{font-size:10px !important;}.fs-11{font-size:11px !important;}.fs-12{font-size:12px !important;}.fs-13{font-size:13px !important;} .fs-14{font-size:14px !important;}  .fs-15{font-size:15px !important;}  .fs-16{font-size:16px !important;}  .fs-17{font-size:17px !important;}  .fs-18{font-size:18px !important;}  .fs-19{font-size:19px !important;}  .fs-20{font-size:20px !important;} .fs-21{font-size:21px !important;}.fs-22{font-size:22px !important;}
  
  
  
  .modal-dialog {
    max-width: 1000px;
	top: 10%;
   }
   .modal-header{
	   background-color:#333;
	   padding: 13px;
   }
    
   .modal-header .modal-title, .modal-header button i {
   		color:#fff;
   }

	.new-even{
		width: 100%;
		height: 250px;
		border: 1px solid #d5d4d4;
		border-radius: 10px;
		padding: 10px;
	}
	
	.even-ul,.even-ul .even-li{
		margin:0px;
		padding:0px;
		list-style:none;
		line-height:2;
	}
	.overflow-even{
		overflow-x: hidden !important;
		overflow: scroll;
		height: 160px;
		width: 100%;
	}
	.btn1-bg-cancel,.btn1-bg-cancel:hover {
    	background-color: #efefef;
    	color: #181818;
    	font-weight: bold !important;
	}
	.ul{
	list-style:none;
	padding-left:5px;
	}
	.ul .li{
	
	}
	.hidden-column {
        background-color: red !important;
        color: white;
    }
	/* Default state for the colvis menu items */
    .dt-button-collection .buttons-columnVisibility {
        background-color: white;
        color: black;
    }

    /* Style for deselected columns (hidden) */
    .dt-button-collection .buttons-columnVisibility.deselected {
        background-color: red !important;
        color: white !important;
    }
	button.dt-button.active {
    background: #b5e550 !important;
}
</style>
<h1 class="container" style=" font-size: 30px !important; ">Robi Group eSourcing Platform  &nbsp; <?php if($_SESSION['msg']!=''){ echo $_SESSION['msg'];unset($_SESSION['msg']);}else{ echo '';}?></h1>
<div class="row" style="margin-left:75px !important;">
<form class="pl-4 pt-5 md-6" action="eprocurement_entry.php" method="post">
					<button class="btn1 btn1-bg-hrm" type="submit">Back to Home</button>
	</form>
<form class="pl-4 pt-5 md-6" action="eprocurement_report_view.php?report_id=<?=$report_unique_id?>" method="post">
					<button class="btn1 btn1-bg-hrm" type="submit">View Report</button>
	</form>
</div>

<input type="hidden" id="unique_report_id" value="<?=$_GET['unique_report_id']?>">
<input type="hidden" id="rfq_no" value="<?=$_GET['rfq_no']?>">
<div class="container ep-bg-color pt-0 mt-5 p-0 ">






<div class="container-fluid pt-3 p-5 " style="overflow:scroll">

                <table id="rfq_table" class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th scope="col">Sl</th>
						
						<th scope="col">Org</th>
                        <th scope="col">Request Received Date</th>
						<th scope="col">Workflow Case Number</th>

                        <th scope="col">RFQ Ref. No.  (Event No.)</th>
						<th scope="col">Particular</th>
						<th scope="col">Technical Evaluator</th>
						<th scope="col">Business User Department</th>
						<th scope="col">Business User Division</th>
						<th scope="col">Final Request Received Date</th>
						
						<th scope="col">Planned timeline (Scope to approved PA)</th>
						<th scope="col">Priority</th>
						
						<th scope="col">Current Stage</th>
						<th scope="col">Approval Number</th>
						<!-- <th scope="col">Raising Date of PA</th> -->
						<th scope="col">Approved Date of  PA</th>
						<th scope="col">Date of Cancellation or Halted since</th>
						<th scope="col">Reason of cancellation or halted</th>
						
						<th scope="col">Extra calendar days taken by User that has evidence</th>
						<th scope="col">Extra calendar days taken by SCM that has evidence</th>
						<th scope="col">Extra calendar days taken by Vendor that has evidence</th>
						<th scope="col">Extra calendar days taken by others that has evidence</th>
						
						<th scope="col">Reason for extra days taken exlcuding SCM (if any)</th>
						<th scope="col">Reason for taking more than standard lead time by SCM</th>
				
						<th scope="col">Total PA Amount in BDT</th>
						
						<th scope="col">Total Base Amount in BDT</th>
						<th scope="col">Total Savings Amount in BDT</th>
						<th scope="col">Savings Type</th>
						<th scope="col">Awarded Supplier(s)</th>
						
						<th scope="col">Sourcing Type</th>
						<!-- <th scope="col">Sourcing Method</th> -->
						<th scope="col">Commodity</th>
						<th scope="col">Sub Commodity</th>
						
						<th scope="col">Project Lead</th>
						<th scope="col">Capex /Opex</th>
						<th scope="col">Actual timeline (Request Received to approved PA)</th>
						<th scope="col">Actual timeline (final scope to approved PA)</th>
						
						<th scope="col">Actual timeline excluding user extra days</th>
						<th scope="col">Actual timeline excluding user & others extra days</th>
						<!-- <th scope="col">Actual timeline in calendar days (request to to approved PA w/o exlcusion)</th> -->
						<!-- <th scope="col">Actual timeline in calendar days (final scope to approved PA)</th> -->
						
						<!-- <th scope="col">Actual timeline in calendar days (final scope to approved PA excluding user & other extra days)</th> -->
						<!-- <th scope="col">PA raise to Approve date</th>
						<th scope="col">WIP?</th> -->
						<!-- <th scope="col">WIP (working days taken (including extra days) till to-date)</th> -->
						
						<th scope="col">WIP (working days taken  (excluding extra days) till to-date)</th>
						<!-- <th scope="col">WIP (calendar days taken (including extra days) till to-date)</th> -->
						<!-- <th scope="col">WIP (calendar days taken  (excluding extra days) till to-date)</th> -->
						<!-- <th scope="col">Validation remarks</th> -->
						
						<!-- <th scope="col">Scope / Requirement Changed?</th> -->
						<th scope="col">Additional Time Taken for Scope / Requirement finalization</th>
						<!-- <th scope="col">Completed Month</th>
						<th scope="col">Complete aging</th> -->
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?php 
					$sql = 'select r.*,u.fname from rfq_master r, user_activity_management u, rfq_evaluation_team t where t.rfq_no=r.rfq_no and t.user_id="'.$_SESSION['user']['id'].'" and u.user_id=r.entry_by and r.del !=1 group by t.rfq_no,r.rfq_no order by r.rfq_no desc';
					$qry = db_query($sql);
					while($rfq=mysqli_fetch_object($qry)){
					
					$eventEndAt = $rfq->eventEndDate.' '.$rfq->eventEndTime;
					$eventEndAtInt = strtotime($eventEndAt);
					$currentDateTime = strtotime(date('Y-m-d H:i:s'));
					
					$winner_id = find_a_field('rfq_vendor_details','vendor_id','rfq_no="'.$rfq->rfq_no.'" and status="SELECTED"');
					$winner_name = find_a_field('vendor','vendor_name','vendor_id="'.$winner_id.'"');
					if($rfq->status=='MANUAL'){
					$status = 'Draft';
					}elseif($rfq->status=='COMPLETE'){
					$status = 'Completed';
					}elseif($rfq->status=='CANCELED'){
					$status = 'Cancelled';
					}elseif($eventEndAtInt<=$currentDateTime){
					$status = 'Evaluation';
					}elseif($rfq->status=='CHECKED'){
					$status = 'Live';
					}elseif($rfq->status=='UNSEALED'){
					$status = 'Evaluation';
					}else{
					$status = $rfq->status;
					}
					if($rfq->master_rfq_no==0){
					 $rounding = '<a href="rounding.php?rfq_no='.$rfq->rfq_no.'" target="_blank" rel="noopener">#'.$rfq->rfq_no.' New Round</a>';
					}else{
					$rounding = '';
					}
					$role = find_a_field('rfq_evaluation_team','action','rfq_no="'.$rfq->rfq_no.'" and user_id="'.$_SESSION['user']['id'].'"');
					
					$rfq->eventEndAt = $rfq->eventEndDate." ".$rfq->eventEndTime;
					
					$responses = find_a_field('rfq_vendor_response','count(DISTINCT vendor_id)','rfq_no='.$rfq->rfq_no.' and status like "SUBMITED" ');
					?>
					
					    <tr>
						
                            <td style="white-space:nowrap"><a href="../eProcurement/eprocurement_entry_entry.php?old_rfq_no=<?=url_encode($rfq->rfq_no)?>&&clear=1" target="_blank" rel="noopener"><?=$rfq->rfq_version?></a></td>
							
							<td><?=find_a_field('rfq_group_for g, user_group u','u.group_name','u.id=g.group_for and g.rfq_no='.$rfq->rfq_no);?></td>
							
                            <td><?=$rfq->request_recieved_date?></td>
                            <td></td>

                            <td><a href="../eProcurement/eprocurement_entry_entry.php?old_rfq_no=<?=url_encode($rfq->rfq_no)?>&&clear=1" target="_blank" rel="noopener"><?=$rfq->rfq_version?></a></td>
							<td><?=$rfq->event_name?></td>
							<td>
                             <?
                            $sql_evolution_team = 'select a.id,u.fname,a.action,a.is_master,u.email from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$rfq->rfq_no.'" and a.action="Evaluator"';
							$qry_evolution_team = db_query($sql_evolution_team);
							while($info_evolution_team=mysqli_fetch_object($qry_evolution_team )){
                              ?>
							  <p><?=$info_evolution_team->fname?></p>
							  <?
							}
                            
							 ?>

							</td>
							<td>

							<?
                            $sql_evolution_team = 'select a.id,u.fname,a.action,a.is_master,u.email,u.department from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$rfq->rfq_no.'" and a.action="Owner"';
							$qry_evolution_team = db_query($sql_evolution_team);
							while($info_evolution_team=mysqli_fetch_object($qry_evolution_team )){
                              ?>
							  <p><?=$info_evolution_team->department?></p>
							  <?
							}
                            
							 ?>
							</td>
							<td>

							<?
                            $sql_evolution_team = 'select a.id,u.fname,a.action,a.is_master,u.email,u.division from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$rfq->rfq_no.'" and a.action="Owner"';
							$qry_evolution_team = db_query($sql_evolution_team);
							while($info_evolution_team=mysqli_fetch_object($qry_evolution_team )){
                              ?>
							  <p><?=$info_evolution_team->division?></p>
							  <?
							}
                            
							 ?>

							</td>
							<td>
								<?=$rfq->final_request_recieved_date?>
							</td>
							<td>
                              <?
						$sql_planned_date = 'SELECT DATEDIFF(MAX(endDate),MIN(startDate)) as planned_days FROM timeline_Tasks WHERE rfq_no = "'.$rfq->rfq_no.'" GROUP BY rfq_no';
						$query_planned_date= db_query($sql_planned_date);
						$info_planned_date=mysqli_fetch_object($query_planned_date);

							  ?>
                             <?=$info_planned_date->planned_days?>
							</td>
							<td>
							 <?=$rfq->priority?>
							</td>
							<td>	<?=$status?></td>
							<td><?=$rfq->approve_no?></td>
							<td><?=$rfq->approve_date_of_pa?></td>
							<td><?if($rfq->cancelAt!=''){echo $rfq->cancelAt;}else if($rfq->hold_date != ''){echo $rfq->hold_date;}?></td>
							
							<td><?=$rfq->event_cancel_remarks;?></td>
							<td>
							<?
						$sql_aditional_date = 'SELECT SUM(DATEDIFF(actualDate,endDate)) as additional_days_businessuser FROM timeline_Tasks WHERE rfq_no = "'.$rfq->rfq_no.'" and responsible="business user"';
						$query_aditional_date= db_query($sql_aditional_date);
						$info_aditional_date=mysqli_fetch_object($query_aditional_date);

							  ?>
                            <?if($info_aditional_date->additional_days_businessuser>0) {echo $info_aditional_date->additional_days_businessuser;}?>
							</td>
							<td>
							<?
						$sql_aditional_date = 'SELECT SUM(DATEDIFF(actualDate,endDate)) as additional_days_businessuser FROM timeline_Tasks WHERE rfq_no = "'.$rfq->rfq_no.'" and responsible="supply chain"';
						$query_aditional_date= db_query($sql_aditional_date);
						$info_aditional_date=mysqli_fetch_object($query_aditional_date);

							  ?>
                            <?if($info_aditional_date->additional_days_businessuser>0) {echo $info_aditional_date->additional_days_businessuser;}?>

							</td>
							<td>
							<?
						$sql_aditional_date = 'SELECT SUM(DATEDIFF(actualDate,endDate)) as additional_days_businessuser FROM timeline_Tasks WHERE rfq_no = "'.$rfq->rfq_no.'" and responsible="supplier"';
						$query_aditional_date= db_query($sql_aditional_date);
						$info_aditional_date=mysqli_fetch_object($query_aditional_date);

							  ?>
                            <?if($info_aditional_date->additional_days_businessuser>0) {echo $info_aditional_date->additional_days_businessuser;}?>


							</td>
							<td>
							<?
						$sql_aditional_date = 'SELECT SUM(DATEDIFF(actualDate,endDate)) as additional_days_businessuser FROM timeline_Tasks WHERE rfq_no = "'.$rfq->rfq_no.'" and responsible="others"';
						$query_aditional_date= db_query($sql_aditional_date);
						$info_aditional_date=mysqli_fetch_object($query_aditional_date);

							  ?>
                            <?if($info_aditional_date->additional_days_businessuser>0) {echo $info_aditional_date->additional_days_businessuser;}?>


							</td>
							<td>
                        <?
						
						$sql_task_date = 'SELECT * FROM timeline_Tasks WHERE rfq_no = "'.$rfq->rfq_no.'" and responsible !="supply chain"';
						$query_task_date= db_query($sql_task_date);
						while($info_task_date=mysqli_fetch_object($query_task_date)){
						  if($info_task_date->reasonRemarks!=''){
                          echo '"'.$info_task_date->reasonRemarks.'"<br>';
						  }
						}
						?>
                         

							</td>
							<td>
							<?
						
						$sql_task_date = 'SELECT * FROM timeline_Tasks WHERE rfq_no = "'.$rfq->rfq_no.'" and responsible ="supply chain"';
						$query_task_date= db_query($sql_task_date);
						while($info_task_date=mysqli_fetch_object($query_task_date)){
						  if($info_task_date->reasonRemarks!=''){
                          echo '"'.$info_task_date->reasonRemarks.'"<br>';
						  }
						}
						?>


							</td>
							<!-- <td></td> -->
							<td><?=$rfq->pa_amt?></td>
							<td><?=$rfq->base_amt?></td>
							<!-- 26 -->
							<td>
								<?php 
								if (is_numeric($rfq->base_amt) && is_numeric($rfq->pa_amt)) {
									echo (float)$rfq->base_amt - (float)$rfq->pa_amt;
								} else {
									echo "N/A"; // Or any other fallback value if the values are not numeric
								}
								?>
							</td>

						
							<td><?=$rfq->cost_avoidance?></td>
							<td>

							<?
                            $sql_evolution_team = "SELECT * FROM `rfq_vendor_details` WHERE rfq_no = '".$rfq->rfq_no."' and award_per !=''";
							$qry_evolution_team = db_query($sql_evolution_team);
							while($info_evolution_team=mysqli_fetch_object($qry_evolution_team )){
                              ?>
							  <p><?=$info_evolution_team->vendor_name?></p>
							  <?
							}
                            
							 ?>
							</td>
							<td><?=$rfq->sourcing_type?></td>
							<td><?=$rfq->commodity?></td>
							<td><?=$rfq->coupa_commodity?></td>
							<td><?=$rfq->project_lead?></td>
							<td><?=$rfq->capex_opex?></td>
							
							<?
								$requestReceivedDate = new DateTime($rfq->request_recieved_date);
								$approveDateOfPa = new DateTime($rfq->approve_date_of_pa);

								$interval = $requestReceivedDate->diff($approveDateOfPa);
								$daysDifference = $interval->days; // Get the total difference in days
								?>

							<td>
									
							<?= $daysDifference ?>
							</td>
							<?
								$requestReceivedDate = new DateTime($rfq->final_request_recieved_date);
								$approveDateOfPa = new DateTime($rfq->approve_date_of_pa);

								$interval = $requestReceivedDate->diff($approveDateOfPa);
								$daysDifference_final = $interval->days; // Get the total difference in days
								?>

							<td>
									
							<?= $daysDifference_final ?>
							</td>
							<td>
							<?
						$sql_aditional_date = 'SELECT SUM(DATEDIFF(actualDate,endDate)) as additional_days_businessuser FROM timeline_Tasks WHERE rfq_no = "'.$rfq->rfq_no.'" and responsible="business user"';
						$query_aditional_date= db_query($sql_aditional_date);
						$info_aditional_date=mysqli_fetch_object($query_aditional_date);
                        echo $daysDifference_final -$info_aditional_date->additional_days_businessuser;
							  ?>


							</td>
							<td>
							<?
						$sql_aditional_date = 'SELECT SUM(DATEDIFF(actualDate,endDate)) as additional_days_businessuser FROM timeline_Tasks WHERE rfq_no = "'.$rfq->rfq_no.'" and responsible !="supply chain"';
						$query_aditional_date= db_query($sql_aditional_date);
						$info_aditional_date=mysqli_fetch_object($query_aditional_date);
                        echo $daysDifference_final-$info_aditional_date->additional_days_businessuser;
							  ?>
							</td>
							<!-- <td></td> -->
							<!-- <td></td> -->
							<!-- <td></td> -->
							<!-- <td></td>
							<td></td>
							<td></td> -->
							
							<td>
							<?
						$requestReceivedDate_wip = new DateTime($rfq->final_request_recieved_date);
						$current_Date = new DateTime(date('Y-m-d'));

						$interval = $requestReceivedDate_wip->diff($current_Date);
						$daysDifference_wip = $interval->days; // Get the total difference in days
						
						$sql_aditional_date = 'SELECT SUM(DATEDIFF(actualDate,endDate)) as additional_days_businessuser FROM timeline_Tasks WHERE rfq_no = "'.$rfq->rfq_no.'" and responsible !="supply chain"';
						$query_aditional_date= db_query($sql_aditional_date);
						$info_aditional_date=mysqli_fetch_object($query_aditional_date);
                        echo $daysDifference_wip-$info_aditional_date->additional_days_businessuser;
							  ?>								
							</td>
							<!-- <td></td>
							<td></td>
							<td></td> 
							<td></td>-->
							<td>							<?
								$finalrequestReceivedDate = new DateTime($rfq->final_request_recieved_date);
								$requestReceivedDate = new DateTime($rfq->request_recieved_date);

								$interval = $finalrequestReceivedDate->diff($requestReceivedDate);
								$daysDifference_additional = $interval->days; // Get the total difference in days
								?>

							
									
							<?= $daysDifference_additional ?>
						</td>
							<!-- <td></td>
							<td></td> -->
							
							
                        </tr>
						<? } ?>
					</tbody>
                </table>





</div>







<script>



function get_event_lis(user_id,type,data){
	getData2('get_event_list_ajax.php',type,user_id,data);
}

function get_event_template_lis(user_id,type,data){
	getData2('get_event_template_list_ajax.php',type,user_id,data);
}


</script>


<script>
function toggleDropdown() {
  var dropdown = document.getElementById("myDropdown");
  if (dropdown.style.display === "block") {
    dropdown.style.display = "none";
  } else {
    dropdown.style.display = "block";
  }
}





document.body.addEventListener("click", function(event) {
  var dropdown = document.getElementById("myDropdown");
  var dropdownButton = document.getElementById("dropdown");
  if (!dropdown.contains(event.target) && !dropdownButton.contains(event.target)) {
    dropdown.style.display = "none";
  }
});
</script>

<?
// datatable("#rfq_table");
require_once SERVER_ROOT."public/assets/datatable/datatable2.php";
require_once "../../../controllers/routing/layout.bottom.php";
?>