<? 

session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//require_once '../../../controllers/core/init.php';

$cid = $_SESSION['proj_id'];
?>



<?php

   

//session_start();

//include 'config/db.php';

//include '../config/function.php';
include '../config/access.php';

$user_id	=$_SESSION['user_id'];



$page="home";






?>



<?php 
include_once('../template/header.php'); 
require "../include/custom.php";

?>


<? 


//echo $u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];
 $u_id  =  $_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);



$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$PBI_ID.'"');




?>




<?php
//______________________________________ DASHBOARD PART ________________________
 $sqlTasks = "SELECT 
        l.organization, 
        l.lead_name, 
        l.lead_value, 
        l.assign_person, 
        l.status, 
        l.id
    FROM 
        crm_project_lead l, 
        crm_project_org o 
    WHERE  
        l.organization = o.id 
        AND l.assign_person = ".$PBI_ID;

// Execute the query
$resultTasks = db_query($sqlTasks);

// Initialize an array to store lead IDs
$leadIds = [];

// Check if there are any results
if ($resultTasks) {
    while ($row = mysqli_fetch_object($resultTasks)) {
        $leadIds[] = $row->id;
    }
}

// If there are lead IDs, fetch activity counts in a single query
if (!empty($leadIds)) {

 $leadIdsString = implode(',', $leadIds);
	
	
	// $toDayTask = find_a_field('crm_lead_activity','COUNT(activity_id)','lead_id IN ("'.$leadIdsString.'")  and activity_type="Meeting"');
	
	
	
	
		//______TO Day ______
		
		
	$today = date('Y-m-d');
	 $sqltoday = "SELECT COUNT(activity_id) as meeting_count FROM crm_lead_activity WHERE lead_id IN ($leadIdsString) ";
	 
	 
//	 	$sqltoday = "SELECT COUNT(activity_id) as upcoming_count 
//					FROM crm_lead_activity 
//					WHERE lead_id IN ($leadIdsString) 
//					AND DATE(date) = '$today'";
	 
	 
      $resultToday= db_query($sqltoday);
      if ($resultToday) {
        while ($TodayRow = mysqli_fetch_object($resultToday)) {
             $TodayCounts = $TodayRow->meeting_count;
        }
      }
	  
	  
	//______FOR ALL ______
	 $sqlActivities = "SELECT COUNT(activity_id) as all_count FROM crm_lead_activity WHERE lead_id IN ($leadIdsString)";
      $resultActivities = db_query($sqlActivities);
      if ($resultActivities) {
        while ($activityRow = mysqli_fetch_object($resultActivities)) {
             $activityCounts = $activityRow->all_count;
        }
      }
	
	//____________Upcoming __________
	$tomorrow = date('Y-m-d', strtotime('+1 day'));
	$sqlUpcoming = "SELECT COUNT(activity_id) as upcoming_count 
					FROM crm_lead_activity 
					WHERE lead_id IN ($leadIdsString) 
					AND DATE(date) >= '$tomorrow'";
	
		// Check if the query execution was successful and fetch the result
		if ($resultUpcomingActivities) {
			while ($upcomingActivityRow = mysqli_fetch_object($resultUpcomingActivities)) {
				$upcomingActivityCounts = $upcomingActivityRow->upcoming_count;
			}
		}
		
		// Output the result (for debugging purposes)
		echo $upcomingActivityCounts;
	

	
	//___________VISIT ___________
		  $sqlvisit = "SELECT COUNT(activity_id) as visit_count FROM crm_lead_activity WHERE lead_id IN ($leadIdsString) AND activity_type='Visit'";
      $resultVisit = db_query($sqlvisit);
      if ($resultVisit) {
        while ($visitRow = mysqli_fetch_object($resultVisit)) {

             $all_visit = $visitRow->visit_count;
        }
      }
	
	
		//___________CALL ___________
		  $sqlcall = "SELECT COUNT(activity_id) as call_count FROM crm_lead_activity WHERE lead_id IN ($leadIdsString) AND activity_type='Call'";
      $resultCall = db_query($sqlcall);
      if ($resultCall) {
        while ($callRow = mysqli_fetch_object($resultCall)) {
             $all_Call = $callRow->call_count;
        }
      }
	
	
			//___________CALL ___________
		  $sqlcall = "SELECT COUNT(activity_id) as call_count FROM crm_lead_activity WHERE lead_id IN ($leadIdsString) AND activity_type='Call'";
      $resultCall = db_query($sqlcall);
      if ($resultCall) {
        while ($callRow = mysqli_fetch_object($resultCall)) {
             $all_Call = $callRow->call_count;
        }
      }
	  
	  
	  
	  
	  		//___________EMAIL ___________
		  $sqlEmail = "SELECT COUNT(activity_id) as email_count FROM crm_lead_activity WHERE lead_id IN ($leadIdsString) AND activity_type='Email'";
      $resultEmail = db_query($sqlEmail);
      if ($resultEmail) {
        while ($emailRow = mysqli_fetch_object($resultEmail)) {
             $all_Email = $emailRow->email_count;
        }
      }
	
	
	
		  
	  		//___________TASK ___________
		  $sqlTask = "SELECT COUNT(activity_id) as task_count FROM crm_lead_activity WHERE lead_id IN ($leadIdsString) AND activity_type='Task'";
      $resultTask = db_query($sqlTask);
      if ($resultTask) {
        while ($taskRow = mysqli_fetch_object($resultTask)) {
             $all_Task = $taskRow->task_count;
        }
      }
	
	
	
	
	
} else {
    echo "No tasks found.";
}


?>

    <div class="page-content header-clear-medium">

        <div class="decoration decoration-margins"></div>

        <div class="calendar bg-theme shadow-xl rounded-m">
            <div class="cal-footer">
                <h6 class="cal-sub-title uppercase bold bg-highlight color-white">Schedule Box</h6>
                <!--<span class="cal-message mt-3 mb-3">
                    <i class="fa fa-bell font-18 color-green-dark"></i>
                    <strong class="color-gray-dark">Reminder: Call the plumber for Kitchen Sink</strong>
                    <strong class="color-gray-dark">Reminder: Today is Karla Black's Birthday.</strong>
                </span>
			      <div class="divider mb-0"></div>-->
				  
				  
				  
				  <?  
				  
				  	//___________Metting ___________
                $sqlRemainder= "SELECT a.*,b.lead_name FROM crm_lead_activity a,crm_project_lead b 
				WHERE a.lead_id=b.id and activity_type='Meeting' and a.lead_id IN ($leadIdsString) AND a.status!=2 order by a.activity_id DESC";
				$resultRemainder = db_query($sqlRemainder);
				if ($resultRemainder) {
				while ($remainderRow = mysqli_fetch_object($resultRemainder)) {
					// Format the date
					$formattedDate = date('d M, Y', strtotime($remainderRow->date));
					// Format the time
					$formattedTime = date('h:i A', strtotime($remainderRow->time));
          
    		  
				  ?>

					
					
								<a href="#">
				  

				    <div class="cal-schedule pt-2 pb-2">
					
					<!-- Button positioned at top right corner -->
					<div class="row col-12 m-0 p-0">
						<div class="col-3">
							<button class="fa fa-edit color-brown-dark" data-menu="editschedulemeeting" onclick="openModalupdatetask('<?=$row->activity_id;?>')"></button>

						</div>
						<div class="col-9 d-flex justify-content-center align-items-center">
																			
											<?php if ($remainderRow->priority_status == 'LOW') { ?>
												<span class="badge float-end ms-1 font-10 m-2">
													<i class="fas fa-flag color-green-dark" ></i>LOW
												</span>
											<?php } elseif ($remainderRow->priority_status == 'MEDIUM') { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-blue-dark" ></i>MEDIUM
												</span>
											<?php } elseif ($remainderRow->priority_status == 'HIGH') { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-red-dark" ></i>HIGH
												</span>
											<?php } else { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-red-dark"></i>HIGH
												</span>
											<?php } ?>
											
											
											
											<? if($remainderRow->status =='2'){ ?>

                                            <span class=" modal-icon badge bg-green-dark float-end m-2 color-white font-10 m-2">COMPLETE</span>
												<? }elseif($remainderRow->status =='1'){ ?>
														   
											<span class="modal-icon badge bg-red-dark float-end m-2 color-white font-10 m-2">PENDING</span>
													<? }else{ ?>
														   
											<span class=" badge bg-blue-dark float-end color-white font-10 m-2 modal-icon">CANCELLED</span>
														<?  } ?>
						</div>													




					
					</div>
						<div class="row m-0 p-0 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
							<div class="col-3 d-flex justify-content-center ">
								<em class="p-0"><?=$formattedDate?><br> <?=$formattedTime?> </em>
							</div>
							<div class="col-9">
						
						<p class="m-0 bold"><?=$remainderRow->activity_type?> with <?=$remainderRow->lead_name?></p>
						<span class="task-details" title="<?=$remainderRow->location?>">
							<i class="fa fa-list-check" style=" padding: 0px !important; width: 20px; "></i>
							<?=$remainderRow->task_details;?>
						</span>
						<span><i class="fa  fa-list-check" style=" padding: 0px !important; width: 20px; "></i>Assign Person:<?=find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "'.$remainderRow->assign_person.'"')?></span>
						<span><i class="fa  fa-list-check" style=" padding: 0px !important; width: 20px; "></i>Company Name:<?=find_a_field('crm_project_org', 'name', 'id = "'.$remainderRow->lead_id.'"')?></span>                                
						




							
							
							</div>
						</div>
						
                	</div>
				</a>
					
				<?     } }	 ?>
			
		
				
				 <?  
				  
				  	//___________Visit ___________
                $sqlRemainder= "SELECT a.*,b.lead_name FROM crm_lead_activity a,crm_project_lead b 
				WHERE a.lead_id=b.id and activity_type='Visit' and a.lead_id IN ($leadIdsString) AND a.status!=2 order by a.activity_id DESC";
				$resultRemainder = db_query($sqlRemainder);
				if ($resultRemainder) {
				while ($remainderRow = mysqli_fetch_object($resultRemainder)) {
					// Format the date
					$formattedDate = date('d M, Y', strtotime($remainderRow->date));
					// Format the time
					$formattedTime = date('h:i A', strtotime($remainderRow->time));
          
    		  
				  ?>

				<a href="#">
				  

				    <div class="cal-schedule pt-2 pb-2">
					
					<!-- Button positioned at top right corner -->
					<div class="row col-12 m-0 p-0">
						<div class="col-3">
							<button class="fa fa-edit color-brown-dark" data-menu="editvisitmodal" onclick="openModalupdatetask('<?=$row->activity_id;?>')"></button>

						</div>
						<div class="col-9 d-flex justify-content-center align-items-center">
																			
											<?php if ($remainderRow->priority_status == 'LOW') { ?>
												<span class="badge float-end ms-1 font-10 m-2">
													<i class="fas fa-flag color-green-dark" ></i>LOW
												</span>
											<?php } elseif ($remainderRow->priority_status == 'MEDIUM') { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-blue-dark" ></i>MEDIUM
												</span>
											<?php } elseif ($remainderRow->priority_status == 'HIGH') { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-red-dark" ></i>HIGH
												</span>
											<?php } else { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-red-dark"></i>HIGH
												</span>
											<?php } ?>
											
											
											
											<? if($remainderRow->status =='2'){ ?>

                                            <span class=" modal-icon badge bg-green-dark float-end m-2 color-white font-10 m-2">COMPLETE</span>
												<? }elseif($remainderRow->status =='1'){ ?>
														   
											<span class="modal-icon badge bg-red-dark float-end m-2 color-white font-10 m-2">PENDING</span>
													<? }else{ ?>
														   
											<span class=" badge bg-blue-dark float-end color-white font-10 m-2 modal-icon">CANCELLED</span>
														<?  } ?>
						</div>													




					
					</div>
						<div class="row m-0 p-0 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
							<div class="col-3 d-flex justify-content-center ">
								<em class="p-0"><?=$formattedDate?><br> <?=$formattedTime?> </em>
							</div>
							<div class="col-9">
						
						<p class="m-0 bold"><?=$remainderRow->activity_type?> to <?=$remainderRow->lead_name?></p>
						<span class="task-details" title="<?=$remainderRow->location?>">
							<i class="fa fa-list-check" style=" padding: 0px !important; width: 20px; "></i>
							<?=$remainderRow->task_details;?>
						</span>
						<span><i class="fa  fa-list-check" style=" padding: 0px !important; width: 20px; "></i>Assign Person:<?=find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "'.$remainderRow->assign_person.'"')?></span>
						<span><i class="fa  fa-list-check" style=" padding: 0px !important; width: 20px; "></i>Company Name:<?=find_a_field('crm_project_org', 'name', 'id = "'.$remainderRow->lead_id.'"')?></span>                                
						




							
							
							</div>
						</div>
						
                	</div>
				</a>
				
				
				
				<?     } }	 ?>
				
				
				
				
								 <?  
				  
				  	//___________Task ___________
                $sqlRemainder= "SELECT a.*,b.lead_name FROM crm_lead_activity a,crm_project_lead b 
				WHERE a.lead_id=b.id and activity_type='Task' and a.lead_id IN ($leadIdsString) AND a.status!=2 order by a.activity_id DESC";
				$resultRemainder = db_query($sqlRemainder);
				if ($resultRemainder) {
				while ($remainderRow = mysqli_fetch_object($resultRemainder)) {
					// Format the date
					$formattedDate = date('d M, Y', strtotime($remainderRow->date));
					// Format the time
					$formattedTime = date('h:i A', strtotime($remainderRow->time));
    		  
				  ?>
<a href="#">
				  

				    <div class="cal-schedule pt-2 pb-2">
					
					<!-- Button positioned at top right corner -->
					<div class="row col-12 m-0 p-0">
						<div class="col-3">
							<button class="fa fa-edit color-brown-dark" data-menu="edittaskmodal" onclick="openModalupdatetask('<?=$row->activity_id;?>')"></button>

						</div>
						<div class="col-9 d-flex justify-content-center align-items-center">
																			
											<?php if ($remainderRow->priority_status == 'LOW') { ?>
												<span class="badge float-end ms-1 font-10 m-2">
													<i class="fas fa-flag color-green-dark" ></i>LOW
												</span>
											<?php } elseif ($remainderRow->priority_status == 'MEDIUM') { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-blue-dark" ></i>MEDIUM
												</span>
											<?php } elseif ($remainderRow->priority_status == 'HIGH') { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-red-dark" ></i>HIGH
												</span>
											<?php } else { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-red-dark"></i>HIGH
												</span>
											<?php } ?>
											
											
											
											<? if($remainderRow->status =='2'){ ?>

                                            <span class=" modal-icon badge bg-green-dark float-end m-2 color-white font-10 m-2">COMPLETE</span>
												<? }elseif($remainderRow->status =='1'){ ?>
														   
													<span class="modal-icon badge bg-red-dark float-end m-2 color-white font-10 m-2">PENDING</span>
														   <? }else{ ?>
														   
														   <span class=" badge bg-blue-dark float-end color-white font-10 m-2 modal-icon">CANCELLED</span>
														   <?  } ?>
						</div>													




					
					</div>
						<div class="row m-0 p-0 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
							<div class="col-3 d-flex justify-content-center ">
								<em class="p-0"><?=$formattedDate?><br> <?=$formattedTime?> </em>
							</div>
							<div class="col-9">
						
						<p class="m-0 bold">Task Name:<?=$remainderRow->task_name;?></p>
						<span class="task-details" title="<?=$remainderRow->task_details;?>">
							<i class="fa fa-list-check" style=" padding: 0px !important; width: 20px; "></i>
							<?=$remainderRow->task_details;?>
						</span>
						<span><i class="fa  fa-list-check" style=" padding: 0px !important; width: 20px; "></i>Assign Person:<?=find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "'.$remainderRow->assign_person.'"')?></span>
						<span><i class="fa  fa-list-check" style=" padding: 0px !important; width: 20px; "></i>Company Name:<?=find_a_field('crm_project_org', 'name', 'id = "'.$remainderRow->lead_id.'"')?></span>                                
						




							
							
							</div>
						</div>
						
                	</div>
				</a>
				<?     } }	 ?>
				
				
				
				
												 <?  
				  
				  	//___________Email ___________
                $sqlRemainder= "SELECT a.*,b.lead_name FROM crm_lead_activity a,crm_project_lead b 
				WHERE a.lead_id=b.id and activity_type='Email' and a.lead_id IN ($leadIdsString) AND a.status!=2 order by a.activity_id DESC";
				$resultRemainder = db_query($sqlRemainder);
				if ($resultRemainder) {
				while ($remainderRow = mysqli_fetch_object($resultRemainder)) {
					// Format the date
					$formattedDate = date('d M, Y', strtotime($remainderRow->date));
					// Format the time
					$formattedTime = date('h:i A', strtotime($remainderRow->time));
          
    		  
				  ?>

							<a href="#">
				  

				    <div class="cal-schedule pt-2 pb-2">
					
					<!-- Button positioned at top right corner -->
					<div class="row col-12 m-0 p-0">
						<div class="col-3">
							<button class="fa fa-edit color-brown-dark" data-menu="editemailmodal" onclick="openModalupdatetask('<?=$row->activity_id;?>')"></button>

						</div>
						<div class="col-9 d-flex justify-content-center align-items-center">
																			
											<?php if ($remainderRow->priority_status == 'LOW') { ?>
												<span class="badge float-end ms-1 font-10 m-2">
													<i class="fas fa-flag color-green-dark" ></i>LOW
												</span>
											<?php } elseif ($remainderRow->priority_status == 'MEDIUM') { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-blue-dark" ></i>MEDIUM
												</span>
											<?php } elseif ($remainderRow->priority_status == 'HIGH') { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-red-dark" ></i>HIGH
												</span>
											<?php } else { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-red-dark"></i>HIGH
												</span>
											<?php } ?>
											
											
											
											<? if($remainderRow->status =='2'){ ?>

                                            <span class=" modal-icon badge bg-green-dark float-end m-2 color-white font-10 m-2">COMPLETE</span>
												<? }elseif($remainderRow->status =='1'){ ?>
														   
											<span class="modal-icon badge bg-red-dark float-end m-2 color-white font-10 m-2">PENDING</span>
													<? }else{ ?>
														   
											<span class=" badge bg-blue-dark float-end color-white font-10 m-2 modal-icon">CANCELLED</span>
														<?  } ?>
						</div>													




					
					</div>
						<div class="row m-0 p-0 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
							<div class="col-3 d-flex justify-content-center ">
								<em class="p-0"><?=$formattedDate?><br> <?=$formattedTime?> </em>
							</div>
							<div class="col-9">
						
						<p class="m-0 bold"><?=$remainderRow->activity_type?> to <?=$remainderRow->lead_name?></p>
						<span class="task-details" title="<?=$remainderRow->location?>">
							<i class="fa fa-list-check" style=" padding: 0px !important; width: 20px; "></i>
							<?=$remainderRow->task_details;?>
						</span>
						<span><i class="fa  fa-list-check" style=" padding: 0px !important; width: 20px; "></i>Assign Person:<?=find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "'.$remainderRow->assign_person.'"')?></span>
						<span><i class="fa  fa-list-check" style=" padding: 0px !important; width: 20px; "></i>Company Name:<?=find_a_field('crm_project_org', 'name', 'id = "'.$remainderRow->lead_id.'"')?></span>                                
						




							
							
							</div>
						</div>
						
                	</div>
				</a>
				<?     } }	 ?>
				
				
					  <?  
				  
				  	//___________Call ___________
                $sqlRemainder= "SELECT a.*,b.lead_name FROM crm_lead_activity a,crm_project_lead b 
				WHERE a.lead_id=b.id and activity_type='Call' and a.lead_id IN ($leadIdsString) AND a.status!=2 order by a.activity_id DESC";
				$resultRemainder = db_query($sqlRemainder);
				if ($resultRemainder) {
				while ($remainderRow = mysqli_fetch_object($resultRemainder)) {
					// Format the date
					$formattedDate = date('d M, Y', strtotime($remainderRow->date));
					// Format the time
					$formattedTime = date('h:i A', strtotime($remainderRow->time));
          
    		  
				  ?>

				
							<a href="#">
				  

				    <div class="cal-schedule pt-2 pb-2">
					
					<!-- Button positioned at top right corner -->
					<div class="row col-12 m-0 p-0">
						<div class="col-3">
							<button class="fa fa-edit color-brown-dark" data-menu="editschedulecall" onclick="openModalupdatetask('<?=$row->activity_id;?>')"></button>

						</div>
						<div class="col-9 d-flex justify-content-center align-items-center">
																			
											<?php if ($remainderRow->priority_status == 'LOW') { ?>
												<span class="badge float-end ms-1 font-10 m-2">
													<i class="fas fa-flag color-green-dark" ></i>LOW
												</span>
											<?php } elseif ($remainderRow->priority_status == 'MEDIUM') { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-blue-dark" ></i>MEDIUM
												</span>
											<?php } elseif ($remainderRow->priority_status == 'HIGH') { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-red-dark" ></i>HIGH
												</span>
											<?php } else { ?>
												<span class="badge float-end ms-1  font-10 m-2">
													<i class="fas fa-flag color-red-dark"></i>HIGH
												</span>
											<?php } ?>
											
											
											
											<? if($remainderRow->status =='2'){ ?>

                                            <span class=" modal-icon badge bg-green-dark float-end m-2 color-white font-10 m-2">COMPLETE</span>
												<? }elseif($remainderRow->status =='1'){ ?>
														   
											<span class="modal-icon badge bg-red-dark float-end m-2 color-white font-10 m-2">PENDING</span>
													<? }else{ ?>
														   
											<span class=" badge bg-blue-dark float-end color-white font-10 m-2 modal-icon">CANCELLED</span>
														<?  } ?>
						</div>													




					
					</div>
						<div class="row m-0 p-0 col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
							<div class="col-3 d-flex justify-content-center ">
								<em class="p-0"><?=$formattedDate?><br> <?=$formattedTime?> </em>
							</div>
							<div class="col-9">
						
						<p class="m-0 bold"><?=$remainderRow->activity_type?> <?=$remainderRow->call_to?></p>
						<span class="task-details" title="<?=$remainderRow->details?>">
							<i class="fa fa-list-check" style=" padding: 0px !important; width: 20px; "></i>
							<?=$remainderRow->details?>
						</span>
						<span><i class="fa  fa-list-check" style=" padding: 0px !important; width: 20px; "></i>Assign Person:<?=find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "'.$remainderRow->assign_person.'"')?></span>
						<span><i class="fa  fa-list-check" style=" padding: 0px !important; width: 20px; "></i>Company Name:<?=find_a_field('crm_project_org', 'name', 'id = "'.$remainderRow->lead_id.'"')?></span>                                
						




							
							
							</div>
						</div>
						
                	</div>
				</a>
					<?     } }	 ?>				
            </div>
        </div>
		
		
        <div class="footer card card-style">
        
            <p class="footer-copyright">Copyright &copy; Enabled <span id="copyright-year">2017</span>. All Rights Reserved.</p>
            <p class="footer-links"><a href="#" class="color-highlight">Privacy Policy</a> | <a href="#" class="color-highlight">Terms and Conditions</a> | <a href="#" class="back-to-top color-highlight"> Back to Top</a></p>
            <div class="clear"></div>
        </div>


    </div>
    <!-- End of Page Content-->
    <!-- edit Call Modal -->
<div id="editschedulecall" class="menu menu-box-modal menu-box-detached">
    <div class="menu-title">
        <h1>Schedule a Call</h1>
        <p class="color-highlight">Enter Call Details</p>
        <a href="#" class="close-menu"><i class="fa fa-times"></i></a>
    </div>
    <div class="divider divider-margins mt-3 mb-2"></div>
    <div class="content px-1">
        <form method="post" action="">
            <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
            <input type="hidden" name="activity_type" value="Call" />
            <input type="hidden" name="main" value="1" />
            <input type="hidden" name="status" value="1" />

            <div class="input-style has-borders no-icon validate-field mb-4">
                <input type="text" name="call_to" class="form-control validate-text" id="call_to" placeholder="Call to">
                <label for="call_to" class="color-highlight">Call to:</label>
                <i class="fa fa-times disabled invalid color-red-dark"></i>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <em>(required)</em>
            </div>

            <div class="row mb-0">
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="priority_status" class="color-highlight">Priority Type</label>
                        <select class="form-control req" name="priority_status" id="priority_status" required>
                            <option value="LOW">LOW</option>
                            <option value="MEDIUM">MEDIUM</option>
                            <option value="HIGH">HIGH</option>
                        </select>
                        <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                        <i class="fa fa-check valid color-green-dark"></i>
                        <i class="fa fa-check disabled invalid color-red-dark"></i>
                        <em></em>
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="call_type" class="color-highlight">Call Type</label>
                        <select class="form-control req" name="call_type" id="call_type" required>
                            <option value="default" disabled selected>Select a Value</option>
                            <option value="Inbound Call">Inbound Call</option>
                            <option value="Outbound Call">Outbound Call</option>
                        </select>
                        <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                        <i class="fa fa-check valid color-green-dark"></i>
                        <i class="fa fa-check disabled invalid color-red-dark"></i>
                        <em></em>
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="call_time" class="color-highlight text-uppercase font-700 font-10 mt-1">Call Time</label>
                        <input type="time" name="time" class="form-control validate-text" id="call_time">
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="call_date" class="color-highlight text-uppercase font-700 font-10 mt-1">Call Date</label>
                        <input type="date" style="width:100%" name="date" class="form-control validate-text" id="call_date">
                    </div>
                </div>
            </div>

            <div class="input-style has-borders no-icon mb-4">
                <textarea id="call_subject" name="subject" placeholder="Call Subject"></textarea>
                <label for="call_subject" class="color-highlight">Call Subject</label>
            </div>

            <div class="input-style has-borders no-icon mb-4">
                <textarea id="call_details" name="details" placeholder="Details"></textarea>
                <label for="call_details" class="color-highlight">Details</label>
            </div>

            <button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Confirm</button>
        </form>
    </div>
</div>
  
  
  <!-- edit Meeting Modal -->
<div id="editschedulemeeting" class="menu menu-box-modal menu-box-detached">
    <div class="menu-title">
        <h1>Schedule a Meeting</h1>
        <p class="color-highlight">Enter Meeting Details</p>
        <a href="#" class="close-menu"><i class="fa fa-times"></i></a>
    </div>
    <div class="divider divider-margins mt-3 mb-2"></div>
    <div class="content px-1">
        <form method="post" action="">
            <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
            <input type="hidden" name="activity_type" value="Meeting" />
            <input type="hidden" name="status" value="1" />
            <input type="hidden" name="main" value="1" />

            <div class="row mb-0">
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="meeting_type" class="color-highlight">Meeting Type</label>
                        <select class="form-control req" name="meeting_type" id="meeting_type" required>
                            <option value="default" disabled selected>Select a Value</option>
                            <option value="Online">Online</option>
                            <option value="Offline">Offline</option>
                        </select>
                        <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                        <i class="fa fa-check valid color-green-dark"></i>
                        <i class="fa fa-check disabled invalid color-red-dark"></i>
                        <em></em>
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="priority_status" class="color-highlight">Priority Type</label>
                        <select class="form-control req" name="priority_status" id="priority_status" required>
                            <option value="LOW">LOW</option>
                            <option value="MEDIUM">MEDIUM</option>
                            <option value="HIGH">HIGH</option>
                        </select>
                        <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                        <i class="fa fa-check valid color-green-dark"></i>
                        <i class="fa fa-check disabled invalid color-red-dark"></i>
                        <em></em>
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="meeting_time" class="color-highlight text-uppercase font-700 font-10 mt-1">Meeting Time</label>
                        <input type="time" name="time" class="form-control validate-text" id="meeting_time">
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="meeting_date" class="color-highlight text-uppercase font-700 font-10 mt-1">Meeting Date</label>
                        <input type="date" style="width:100%" name="date" class="form-control validate-text" id="meeting_date">
                    </div>
                </div>
            </div>

            <div class="input-style has-borders no-icon mb-4">
                <input type="text" id="meeting_location" name="location" placeholder="Meeting Location">
                <label for="meeting_location" class="color-highlight">Meeting Location</label>
            </div>

            <div class="input-style has-borders no-icon mb-4">
                <textarea id="meeting_subject" name="subject" placeholder="Meeting Subject"></textarea>
                <label for="meeting_subject" class="color-highlight">Meeting Subject</label>
            </div>

            <div class="input-style has-borders no-icon mb-4">
                <textarea id="meeting_details" name="details" placeholder="Meeting Details"></textarea>
                <label for="meeting_details" class="color-highlight">Meeting Details</label>
            </div>

            <button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Confirm</button>
        </form>
    </div>
</div>
  
  
  
  
  <!-- Edit Task Modal -->
<div id="edittaskmodal" class="menu menu-box-modal menu-box-detached">
    <div class="menu-title">
        <h1>Edit Task</h1>
        <p class="color-highlight">Edit Task Details</p>
        <a href="#" class="close-menu"><i class="fa fa-times"></i></a>
    </div>
    <div class="divider divider-margins mt-3 mb-2"></div>
    <div class="content px-1">
        <form method="post" action="">
            <input type="hidden" name="lead_id" id="lead_id_edit" value="<?=$id?>" />
            <input type="hidden" name="activity_type" value="Task" />
            <input type="hidden" name="main" value="1" />
            <input type="hidden" name="status" value="1" />
            <input type="hidden" name="activity_id" id="activity_id_edit" value="" />

            <div class="input-style has-borders no-icon mb-4">
                <input type="text" id="task_name_edit" name="subject" placeholder="Task Name">
                <label for="task_name_edit" class="color-highlight">Task Name</label>
            </div>

            <div class="input-style has-borders no-icon mb-4">
                <textarea id="task_details_edit" name="details" placeholder="Task Details"></textarea>
                <label for="task_details_edit" class="color-highlight">Task Details</label>
            </div>

            <div class="input-style has-borders no-icon mb-4 input-style-active">
                <label for="priority_status_edit" class="color-highlight">Priority Type</label>
                <select class="form-control req" name="priority_status" id="priority_status_edit" required>
                    <option value="LOW">LOW</option>
                    <option value="MEDIUM">MEDIUM</option>
                    <option value="HIGH">HIGH</option>
                </select>
                <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check valid color-green-dark"></i>
                <i class="fa fa-check disabled invalid color-red-dark"></i>
                <em></em>
            </div>

            <h5 class="mb-2 font-15 mt-2">Task</h5>
            <div class="row mb-0">
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="task_time_edit" class="color-highlight text-uppercase font-700 font-10 mt-1">Task Time</label>
                        <input type="time" name="time" class="form-control validate-text" id="task_time_edit">
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="task_date_edit" class="color-highlight text-uppercase font-700 font-10 mt-1">Task Date</label>
                        <input type="date" style="width:100%" name="date" class="form-control validate-text" id="task_date_edit">
                    </div>
                </div>
            </div>

            <h5 class="mb-2 font-15 mt-2">Reminder</h5>
            <div class="row mb-0">
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="reminder_time_edit" class="color-highlight text-uppercase font-700 font-10 mt-1">Reminder Time</label>
                        <input type="time" name="reminder_time" class="form-control validate-text" id="reminder_time_edit">
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="reminder_date_edit" class="color-highlight text-uppercase font-700 font-10 mt-1">Reminder Date</label>
                        <input type="date" style="width:100%" name="reminder_date" class="form-control validate-text" id="reminder_date_edit">
                    </div>
                </div>
            </div>

            <button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Confirm</button>
        </form>
    </div>
</div>

  
  <!-- Edit Email Modal -->
<div id="editemailmodal" class="menu menu-box-modal menu-box-detached">
    <div class="menu-title">
        <h1>Edit Email</h1>
        <p class="color-highlight">Edit Email Details</p>
        <a href="#" class="close-menu"><i class="fa fa-times"></i></a>
    </div>
    <div class="divider divider-margins mt-3 mb-2"></div>
    <div class="content px-1">
        <form method="post" action="">
            <input type="hidden" name="lead_id" id="lead_id_edit" value="<?=$id?>" />
            <input type="hidden" name="activity_type" value="Email" />
            <input type="hidden" name="main" value="1" />
            <input type="hidden" name="status" value="1" />
            <input type="hidden" name="activity_id" id="activity_id_edit" value="" />
            
            <div class="input-style has-borders no-icon mb-4 input-style-active">
                <label for="priority_status_edit" class="color-highlight">Priority Type</label>
                <select class="form-control req" name="priority_status" id="priority_status_edit" required>
                    <option value="LOW">LOW</option>
                    <option value="MEDIUM">MEDIUM</option>
                    <option value="HIGH">HIGH</option>
                </select>
                <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check valid color-green-dark"></i>
                <i class="fa fa-check disabled invalid color-red-dark"></i>
                <em></em>
            </div>

            <div class="input-style has-borders no-icon validate-field mb-4">
                <input type="email" name="email_to" class="form-control validate-text" id="email_to_edit" placeholder="Email to">
                <label for="email_to_edit" class="color-highlight">Email to:</label>
                <i class="fa fa-times disabled invalid color-red-dark"></i>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <em>(required)</em>
            </div>

            <div class="row mb-0">
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="time_edit" class="color-highlight text-uppercase font-700 font-10 mt-1">Email Time</label>
                        <input type="time" name="time" class="form-control validate-text" id="time_edit">
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-style has-borders no-icon mb-4 input-style-active">
                        <label for="date_edit" class="color-highlight text-uppercase font-700 font-10 mt-1">Email Date</label>
                        <input type="date" style="width:100%" name="date" class="form-control validate-text" id="date_edit">
                    </div>
                </div>
            </div>

            <div class="input-style has-borders no-icon mb-4">
                <textarea id="subject_edit" name="subject" placeholder="Email Subject"></textarea>
                <label for="subject_edit" class="color-highlight">Email Subject</label>
            </div>

            <div class="input-style has-borders no-icon mb-4">
                <textarea id="details_edit" name="details" placeholder="Email Body"></textarea>
                <label for="details_edit" class="color-highlight">Email Body</label>
            </div>

            <button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Confirm</button>
        </form>
    </div>
</div>
  
  
     
 <!-- edit Meeting Modal -->
<div id="editmeetingmodal" class="menu menu-box-modal menu-box-detached">
    <form method="post" action="">
        <div class="modal-body">
            <div class="menu-title">
                <h1>Schedule a Meeting</h1>
                <p class="color-highlight">Enter Meeting Details</p>
                <a href="#" class="close-menu"><i class="fa fa-times"></i></a>
            </div>
            <div class="divider divider-margins mb-1 mt-3"></div>
            <div class="content px-1">
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="meeting_type" class="color-highlight">Meeting Type</label>
                    <select class="form-control req" name="meeting_type" id="meeting_type" required>
                        <option value="" disabled selected>Select a Value</option>
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                    </select>
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="priority_status" class="color-highlight">Priority Type</label>
                    <select class="form-control req" name="priority_status" id="priority_status" required>
                        <option value="LOW">LOW</option>
                        <option value="MEDIUM">MEDIUM</option>
                        <option value="HIGH">HIGH</option>
                    </select>
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
                <div class="row mb-0">
                    <div class="col-6">
                        <div class="input-style has-borders no-icon mb-4 input-style-active">
                            <label for="meeting_time" class="color-highlight text-uppercase font-700 font-10 mt-1">Meeting Time</label>
                            <input type="time" name="time" class="form-control validate-text" id="meeting_time">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-style has-borders no-icon mb-4 input-style-active">
                            <label for="meeting_date" class="color-highlight text-uppercase font-700 font-10 mt-1">Meeting Date</label>
                            <input type="date" name="date" class="form-control validate-text" id="meeting_date" style="width: 100%;">
                        </div>
                    </div>
                </div>
                <div class="input-style has-borders no-icon mb-4">
                    <label for="meeting_location" class="color-highlight">Meeting Location</label>
                    <input type="text" id="meeting_location" name="location" placeholder="Meeting location">
                </div>
                <div class="input-style has-borders no-icon mb-4">
                    <label for="meeting_subject" class="color-highlight">Meeting Subject</label>
                    <textarea id="meeting_subject" name="subject" placeholder="Meeting Subject"></textarea>
                </div>
                <div class="input-style has-borders no-icon mb-4">
                    <label for="meeting_details" class="color-highlight">Details</label>
                    <textarea id="meeting_details" name="details" placeholder="Details"></textarea>
                </div>
                <button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Confirm</button>
            </div>
        </div>
    </form>
</div>   




<!-- edit Visit Modal -->
<div id="editvisitmodal" class="menu menu-box-modal menu-box-detached">
    <form method="post" action="">
        <div class="modal-body">
            <div class="menu-title">
                <h1>Schedule a Visit</h1>
                <p class="color-highlight">Enter Visit Details</p>
                <a href="#" class="close-menu"><i class="fa fa-times"></i></a>
            </div>
            <div class="divider divider-margins mb-1 mt-3"></div>
            <div class="content px-1">
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="priority_status" class="color-highlight">Priority Type</label>
                    <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                    <input type="hidden" name="activity_type" value="Visit" />
                    <input type="hidden" name="main" value="1" />
                    <input type="hidden" name="status" value="1" />
                    <select class="form-control req" name="priority_status" id="priority_status" required>
                        <option value="LOW">LOW</option>
                        <option value="MEDIUM">MEDIUM</option>
                        <option value="HIGH">HIGH</option>
                    </select>
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
                <div class="input-style has-borders no-icon validate-field mb-4">
                    <input type="text" name="location" class="form-control validate-text" id="visit_location" placeholder="Visit Location">
                    <label for="visit_location" class="color-highlight">Location:</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
                <h5 class="mb-2 font-15 mt-2">Visit</h5>
                <div class="row mb-0">
                    <div class="col-6">
                        <div class="input-style has-borders no-icon mb-4 input-style-active">
                            <label for="visit_time" class="color-highlight text-uppercase font-700 font-10 mt-1">Visit Time</label>
                            <input type="time" name="time" class="form-control validate-text" id="visit_time">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-style has-borders no-icon mb-4 input-style-active">
                            <label for="visit_date" class="color-highlight text-uppercase font-700 font-10 mt-1">Visit Date</label>
                            <input type="date" name="date" class="form-control validate-text" id="visit_date" style="width: 100%;">
                        </div>
                    </div>
                </div>
                <div class="input-style has-borders no-icon mb-4">
                    <label for="visit_purpose" class="color-highlight">Visit Purpose</label>
                    <textarea id="visit_purpose" name="subject" placeholder="Visit Purpose"></textarea>
                </div>
                <div class="input-style has-borders no-icon mb-4">
                    <label for="visit_details" class="color-highlight">Details</label>
                    <textarea id="visit_details" name="details" placeholder="Details"></textarea>
                </div>
                <button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Confirm</button>
            </div>
        </div>
    </form>
</div>
  
  <?php include_once('../template/link_footer.php'); ?>
