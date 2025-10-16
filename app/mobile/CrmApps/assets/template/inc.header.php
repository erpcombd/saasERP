<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>CRM Mobile</title>
<link rel="stylesheet" type="text/css" href="../assets/styles/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../assets/styles/style.css">
<link href="../../../../public/assets/css/select2.min.css" type="text/css" rel="stylesheet"/>

<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../assets/fonts/css/fontawesome-all.min.css">    
<link rel="manifest" href="../assets/template/_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
<link rel="" href="../assets/template/_service-worker.js">
<link rel="apple-touch-icon" sizes="180x180" href="../assets/app/icons/icon-192x192.png">
</head>
    
<body class="theme-light" data-highlight="highlight-red" data-gradient="body-default">
    
<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>
    
<div id="page">
    <!----------------------------------------------------------------
    ----------------------- Head top start ---------------------------
    ----------------------------------------------------------------->	
    <? if($title =="home"){ ?>
    <? } else { ?>
    <div class="header header-fixed header-logo-center">
        <a href="../main/home.php" class="header-title"> <?=$title;?> </a>
        <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
        <a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-lightbulb"></i></a>
    </div>
    <? } ?>
    <!----------------------------------------------------------------
    ------------------------- Head top end ---------------------------
    ----------------------------------------------------------------->
    
    

    <!----------------------------------------------------------------
    ----------------------- footer menu start ------------------------
    ----------------------------------------------------------------->    
    <div id="footer-bar" class="footer-bar-1">
        <a href="../main/home.php"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="../info_maker/task_manage.php"><i class="fa fa-star"></i><span>Post Mode</span></a>
		<a data-menu="menu-sidebar-left-3" href="#" class="active-nav"><i class="fa fa-bars"></i><span>Menu</span></a>
        <a href="../main/lead_list.php"><i class="fa fa-search"></i><span>Deals</span></a>
        <a href="#" data-menu="menu-settings"><i class="fa fa-cog"></i><span>Settings</span></a>
    </div>
    <!----------------------------------------------------------------
    ----------------------- footer menu end --------------------------
    ----------------------------------------------------------------->
    
    

    <!----------------------------------------------------------------
    ----------------------- Sidebar menu start -----------------------
    ----------------------------------------------------------------->
	<?
$u_id  =  $_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

	
	
session_start();
$tabletask='crm_task_add_information';	
$crudtask    =new crud($tabletask);		
$table1 = 'crm_project_lead';
if(isset($_POST['insertTasks1']))
{
$person_ids = $_POST['person_ids'];
$_POST['assign_person'] = implode(",", $person_ids);
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudtask->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
        echo "<script>window.top.location='../info_maker/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}

?>

<style>
.input-container {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.input-style {
    flex: 1;
}

.input-style .form-control {
    width: 100%;
}

.input-style .color-highlight {
    font-size: 14px;
    margin-top: 5px;
}

.input-style .fa {
    margin-top: 10px;
}


.Cancel { 
        background-color: #ff4d4d !important; /* Red */
}
.Lost { 
        background-color: #ff704d !important; /* Dark Salmon */
}
.Active {
        background-color: #66cc66 !important; /* Green */
}
 .Won { 
        background-color: #4da6ff !important; /* Blue */
}
.Proposal { 
        background-color: #cccccc !important; /* Gray */
}
.Qualified { 
        background-color: #ffff66 !important; /* Yellow */
}
.Negotiation { 
        background-color: #66d9ff !important; /* Cyan */
}
.Closed { 
        background-color: #85e085 !important; /* Medium Green */
}
.Junk { 
        background-color: #cccccc !important; /* Gray */
}
.NoBid { 
        background-color: #99aabb !important; /* Slate Blue */
}

</style>
    <div id="menu-sidebar-left-3" class="bg-white menu menu-box-left" data-menu-width="320" data-menu-effect="menu-parallax">
        <div class="d-flex flex-row-reverse">
            
            <a href="#" class="close-menu  icon icon-m text-center color-red-dark "><i class="fa font-12 fa-times"></i></a>
        </div>
        <div class="ps-3 pe-3 pt-3 mt-4 mb-2">
            <div class="d-flex">
                <div class="me-3">
                    <img src="../assets/images/preload-logo.png" width="43">
                </div>
                <div class="flex-grow-1">
                    <h1 class="font-22 font-700 mb-0"><?=find_a_field('user_activity_management','concat(fname," - ",PBI_ID)','PBI_ID='.$PBI_ID);?></h1>
                 <!--   <p class="mt-n2  font-10 font-400">The Best Mobile Template</p>-->
                </div>
            </div>
        </div>

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
		$upcomingActivityCounts = 0;
		if ($resultUpcomingActivities) {
			while ($upcomingActivityRow = mysqli_fetch_object($resultUpcomingActivities)) {
				$upcomingActivityCounts = $upcomingActivityRow->upcoming_count;
			}
		}

		
		// Output the result (for debugging purposes)
		$upcomingActivityCounts;
	
	//___________Metting ___________
	
	  $sqlmetting = "SELECT COUNT(activity_id) as meeting_count FROM crm_lead_activity WHERE lead_id IN ($leadIdsString) AND activity_type='Meeting'";
      $resultMetting = db_query($sqlmetting);
      if ($resultMetting) {
        while ($mettingRow = mysqli_fetch_object($resultMetting)) {
             $all_metting = $mettingRow->meeting_count;
        }
      }
	
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


        <div class="me-3 ms-3">
            <span class="text-uppercase font-900 font-11 opacity-30">Navigation</span>
            <div class="list-group list-custom-small">
                <a href="../info_maker/task_manage.php" data-menu="scheduletask">
                    <i class="fa font-14 fa-plus rounded-s bg-yellow-dark"></i>
                    <span>Add Task</span>
                    <i class="fa fa-angle-right"></i>
                </a>
                <a href="../info_maker/today_schedule_manage.php">
                    <i class="fa font-14 fa-cog rounded-s bg-blue-dark"></i>
                    <span>Today</span>
                    <span class="badge bg-red-light"><?=$all_metting;?></span>
                    <i class="fa fa-angle-right"></i>
                </a>
                <a href="../info_maker/upcoming_schedule_manage.php">
                    <i class="fa font-14 fa-file rounded-s bg-brown-dark"></i>
                    <span>Upcoming</span>
					<span class="badge bg-red-light"><?=$upcomingActivityCounts;?></span>
                    <i class="fa fa-angle-right"></i>
                </a>
<!--               <a href="../main/project_list.php">
                    <i class="fa font-14 fa-camera rounded-s bg-green-dark"></i>
                    <span>Projects</span>
                    <i class="fa fa-angle-right"></i>
                </a>
-->				<a href="../info_maker/filter_and_labels.php">
                    <i class="fa fa-filter font-14 rounded-s bg-green-dark"></i>
                    <span>Filters & Labels</span>
                    <i class="fa fa-angle-right"></i>
                </a>

				<a href="../main/leads.php" class="border-0">
                    <i class="fa fa-users bg-red-dark rounded-s"></i>
                    <span> Leads </span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				
                <a href="../main/lead_list.php" class="border-0">
                    <i class="fa fa-handshake bg-brown-dark rounded-s"></i>
                    <span> Deals </span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				<div class="list-group list-custom-small ">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-2">					
						<i class="fa fa-solid fa-person-booth bg-green-dark rounded-s"   style="color: #42cdb1;"></i>
                        <span class="font-14">TADA Management</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
				<div class="collapse" id="collapse-2">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../info_maker/od_entry.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>TADA</span>
                            <i class="fa fa-angle-right"></i>
                        </a>  
						
						<a href="../info_maker/od_approval.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>OD Approval</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
                        
                        <a href="../info_maker/tada_approval.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>TA/DA Approval</span>
                            <i class="fa fa-angle-right"></i>
                        </a>      
						
						<a href="../info_maker/tada_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>TA/DA Status</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
						
						<a href="../info_maker/od_report.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>TA/DA Rrport</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
				
				<a href="../info_maker/customer.php" class="border-0">
                    <i class="fa fa-user-tie bg-blue-dark rounded-s"></i>
                    <span> Customer </span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				<a href="../main/clients.php" class="border-0">
                    <i class="fa fa-user-tie bg-blue-dark rounded-s"></i>
                    <span> clients </span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				
				<a href="../info_maker/contact_list.php" class="border-0">
                    <i class="fa fa-address-book bg-red-dark rounded-s"></i>
                    <span> Contacts </span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				<a href="../info_maker/product_list.php" class="border-0">
                    <i class="fa fa-box bg-blue-dark rounded-s"></i>
                    <span> Products </span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				<a href="../info_maker/task_manage.php" class="border-0">
                    <i class="fa fa-tasks bg-blue-dark rounded-s"></i>
                    <span> Activities (Post-Sale)</span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				
				<a href="../info_maker/schedule_manage.php" class="border-0">
                    <i class="fa fa-calendar bg-brown-dark rounded-s"></i>
                    <span>Schedule</span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				
				
				
            </div>
        </div>
		
		
		
		<!-- NEW CODE --->
<?php /*?><div class="me-3 ms-3">
            <span class="text-uppercase font-900 font-11 opacity-30">Project</span>
			</div>
		
         <? 
		
		  $sn = 1;
		
		  $leadsQry = "SELECT a.*,o.name FROM $table1 a,crm_project_org o WHERE a.organization=o.id and a.assign_person=$PBI_ID ORDER BY a.id DESC";
		  $rslt = db_query($leadsQry);

          while($row = mysqli_fetch_object($rslt)){
		  
			$entryAt = $row->entry_at;
			$formattedDate = date('d M, Y', strtotime($entryAt));
			$formattedTime = date('h:i A', strtotime($entryAt));
		    // for warning by color
		  $status = $row->status;

		  if($row->status ==1){
          $status = 'Active';
          }elseif($row->status ==2){
          $status = 'Lost';
          }elseif($row->status ==3){
		  $status = 'Won';
		  }elseif($row->status ==4){
		  $status = 'Cancel';
		  }elseif($row->status ==5){
		  $status = 'No Bid';
		  }elseif($row->status ==6){
		  $status = 'Proposal';
		  }elseif($row->status ==7){
		  $status = 'Qualified';
		  }elseif($row->status ==8){
		  $status = 'Negotiation';
		  }elseif($row->status ==9){
		  $status = 'Closed';
		  }else{
		  $status = 'Junk';
		  }

		 
		 
		 
		       $class = '';
               switch ($status) {
                case 'Active':
                    $class = 'Active';
                    break;
                case 'Lost':
                    $class = 'Lost';
                    break;
                case 'Won':
                    $class = 'Won';
                    break;
				case 'Cancel':
                    $class = 'Cancel';
                    break;
				case 'No Bid':
                    $class = 'NoBid';
                    break;
				case 'Proposal':
                    $class = 'Proposal';
                    break;
				case 'Qualified':
                    $class = 'Qualified';
                    break;
				case 'Negotiation':
                    $class = 'Negotiation';
                    break;
				case 'Closed':
                    $class = 'Closed';
                    break;
					
				case 'Junk':
                    $class = 'Junk';
                    break;

            }

		
		?>
		
		
		
		<div class="me-3 ms-3">
          <div class="list-group list-custom-small">
			
				<a href="../info_maker/project_task_view.php?lead_id=<?=$row->id?>">
                    <i class="fa font-14  fa-hashtag rounded-s bg-blue-dark"></i>
                    <span><?=$row->name?></span>
                    <span class="badge <?=$class?>"><?=find_a_field('crm_lead_status', 'status', 'id = "'.$row->status.'"')?></span>

                    <i class="fa fa-angle-right"></i>
                </a>

				

				

            </div>
 				
        </div>
				<? } ?>  		<?php */?>
				
				
										

    </div>
	
	<!-- Request Task  ---- -->
	<div id="scheduletask" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Schedule a Task</h1><p class="color-highlight"> Enter Task Details</p>
		<a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-2"></div>
		<div class="content px-1">
		
		<form method="post" action="">
		
				<input type="hidden" name="status" value="1" />
				<div class="input-style has-borders no-icon mb-4">
                    <Input type="text" id="form7" name="task_name" placeholder="Task Name">
                    <label for="form7" class="color-highlight">Task Name</label>
                
                </div>
				<div class="input-style has-borders no-icon mb-4">
                    <textarea id="form7" name="task_details" placeholder="Task Details"></textarea>
                    <label for="form7" class="color-highlight">Task Details</label>
                
                </div>
			
				<div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="form5" class="color-highlight">Priority type</label>
               
					
					 <select class="form-control req" name="priority_status" id="form5" required>
                     <option value="LOW">
						  <span>LOW</span>
						</option>
						<option value="MEDIUM">
						  <span>MEDIUM</span>
						</option>
						<option value="HIGH">
						  <span>HIGH</span>
						</option>
                     </select>
										
										
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
				

                   		
			<div class="row mb-0"><!-- Opening div.row -->
                        <div class="col-12"><!-- Opening div.col-6 -->
                            <div class=""><!-- Opening div.input-style -->
                                <label for="emp_id" class="color-highlight text-uppercase font-700 font-10 mt-1">Person Name</label>
                                <select class="form-control req" name="person_ids[]" id="emp_id" multiple > 
                                    <option value=""></option>
                                    <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_ID," - ",PBI_NAME)', $assign_person, '1'); ?>
                                </select>
                            </div><!-- Closing div.input-style -->
                        </div><!-- Closing div.col-6 -->
						<style type="text/css">
							.select2{
							    width: 100% !important;
							}
						</style>
                     
                
                    <em></em>
                    </div><br />
				
				
		
						<div class="row mb-0">
						  
						  <div class="col-12">
							<div class="input-style has-borders no-icon mb-4">
								<label for="form5" class="color-highlight">Project Name</label>
						   
								
								 <select class="form-control req" name="lead_id" id="form5">
								 <option value=""></option>
			
									<? foreign_relation('crm_project_org','id','name',$lead_id,'1'); ?>
			
								 </select>
								  <span class="disabled"><i class="fa fa-chevron-down"></i></span>
								<i class="fa fa-check valid color-green-dark"></i>
								<i class="fa fa-check disabled invalid color-red-dark"></i>
								<em></em>
							</div>
						  </div>
						</div>
		
		
		
		
			<!--<div class="input-style has-borders no-icon mb-4 input-style-active">
				<input type="date" name="task_date" class="form-control validate-text" id="task_date">
				<label for="task_date" class="color-highlight">Task Date</label>
				<i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
				<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
			</div>
		
			<div class="input-style has-borders no-icon mb-4 input-style-active">
				<input type="time" name="task_time" class="form-control validate-text" id="task_time">
				<label for="task_time" class="color-highlight">Task Time</label>
				<i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
				<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
			</div>
		
		
		
			<div class="input-style has-borders no-icon mb-4 input-style-active">
				<input type="date" name="reminder_start_date" class="form-control validate-text" id="reminder_start_date" placeholder="Reminder date">
				<label for="reminder_start_date" class="color-highlight">Reminder Date</label>
				<i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
				<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
			</div>
		
			<div class="input-style has-borders no-icon mb-4 input-style-active">
				<input type="time" name="reminder_start_time" class="form-control validate-text" id="reminder_start_time">
				<label for="reminder_start_time" class="color-highlight">Reminder Time</label>
				<i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
				<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
			</div>-->





					<h5 class="mb-2 font-15 mt-2">Task</h5>
						<div class="row mb-0">
						  <div class="col-6">
							<div class="input-style has-borders no-icon mb-4 input-style-active">
							  <label for="form6" class="color-highlight text-uppercase font-700 font-10 mt-1">Task Time</label>
								<input type="time"  name="task_time" class="form-control validate-text" id="form6">
							</div>
						  </div>
						  <div class="col-6">
							<div class="input-style has-borders no-icon mb-4 input-style-active">
							  <label for="form6" class="color-highlight text-uppercase font-700 font-10 mt-1">Task Date</label>
								<input type="date" style="width:100%"  name="task_date" class="form-control validate-text" id="form6">
							</div>
						  </div>
						</div>
				
				
				
				
				
				
				
					<h5 class="mb-2 font-15 mt-2">Remainder</h5>
						<div class="row mb-0">
						  <div class="col-6">
							<div class="input-style has-borders no-icon mb-4 input-style-active">
							  <label for="form-4" class="color-highlight text-uppercase font-700 font-10 mt-1">Remainder time</label>
								<input type="time"  name="reaminder_start_time" class="form-control validate-text" id="form-4">
							</div>
						  </div>
						  <div class="col-6">
							<div class="input-style has-borders no-icon mb-4 input-style-active">
							  <label for="form6" class="color-highlight text-uppercase font-700 font-10 mt-1">Reaminder Date</label>
								<input type="date" style="width:100%"  name="reaminder_start_date" class="form-control validate-text" id="form-4">
							</div>
						  </div>
						</div>
                    

				

				
	<button type="submit" name="insertTasks1" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100"> Confirm </button>
			
			</form>
		</div>
	</div>
            
    <!----------------------------------------------------------------
    ----------------------- Sidebar menu end -------------------------
    ----------------------------------------------------------------->
    

    
    
    
    
    
    
    
    
    
    
    
    
    
        
    <!----------------------------------------------------------------
    ----------- now start setting modale menu settings ---------------
    ----------------------------------------------------------------->
    
    <!-- All Menus, Action Sheets, Modals, Notifications, Toasts, Snackbars get Placed outside the <div class="page-content"> -->
    <div id="menu-settings" class="menu menu-box-bottom menu-box-detached">
        <div class="menu-title mt-0 pt-0"><h1>Settings</h1><p class="color-highlight">Flexible and Easy to Use</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
        <div class="divider divider-margins mb-n2"></div>
        <div class="content">
            <div class="list-group list-custom-small">
                <a href="#" data-toggle-theme data-trigger-switch="switch-dark-mode" class="pb-2 ms-n1">
                    <i class="fa font-12 fa-moon rounded-s bg-highlight color-white me-3"></i>
                    <span>Dark Mode</span>
                    <div class="custom-control scale-switch ios-switch">
                        <input data-toggle-theme type="checkbox" class="ios-input" id="switch-dark-mode">
                        <label class="custom-control-label" for="switch-dark-mode"></label>
                    </div>
                    <i class="fa fa-angle-right"></i>
                </a>    
            </div>
            <div class="list-group list-custom-large">
                <a data-menu="menu-highlights" href="#">
                    <i class="fa font-14 fa-tint bg-green-dark rounded-s"></i>
                    <span>Page Highlight</span>
                    <strong>16 Colors Highlights Included</strong>
                    <span class="badge bg-highlight color-white">HOT</span>
                    <i class="fa fa-angle-right"></i>
                </a>        
                <a data-menu="menu-backgrounds" href="#" class="border-0">
                    <i class="fa font-14 fa-cog bg-blue-dark rounded-s"></i>
                    <span>Background Color</span>
                    <strong>10 Page Gradients Included</strong>
                    <span class="badge bg-highlight color-white">NEW</span>
                    <i class="fa fa-angle-right"></i>
                </a>        
            </div>
        </div>
    </div>
    <!-- Menu Settings Highlights-->
    <div id="menu-highlights" class="menu menu-box-bottom menu-box-detached">
        <div class="menu-title"><h1>Highlights</h1><p class="color-highlight">Any Element can have a Highlight Color</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
        <div class="divider divider-margins mb-n2"></div>
        <div class="content">
            <div class="highlight-changer">
                <a href="#" data-change-highlight="blue"><i class="fa fa-circle color-blue-dark"></i><span class="color-blue-light">Default</span></a>
                <a href="#" data-change-highlight="red"><i class="fa fa-circle color-red-dark"></i><span class="color-red-light">Red</span></a>    
                <a href="#" data-change-highlight="orange"><i class="fa fa-circle color-orange-dark"></i><span class="color-orange-light">Orange</span></a>    
                <a href="#" data-change-highlight="pink2"><i class="fa fa-circle color-pink2-dark"></i><span class="color-pink-dark">Pink</span></a>    
                <a href="#" data-change-highlight="magenta"><i class="fa fa-circle color-magenta-dark"></i><span class="color-magenta-light">Purple</span></a>    
                <a href="#" data-change-highlight="aqua"><i class="fa fa-circle color-aqua-dark"></i><span class="color-aqua-light">Aqua</span></a>      
                <a href="#" data-change-highlight="teal"><i class="fa fa-circle color-teal-dark"></i><span class="color-teal-light">Teal</span></a>      
                <a href="#" data-change-highlight="mint"><i class="fa fa-circle color-mint-dark"></i><span class="color-mint-light">Mint</span></a>      
                <a href="#" data-change-highlight="green"><i class="fa fa-circle color-green-light"></i><span class="color-green-light">Green</span></a>    
                <a href="#" data-change-highlight="grass"><i class="fa fa-circle color-green-dark"></i><span class="color-green-dark">Grass</span></a>       
                <a href="#" data-change-highlight="sunny"><i class="fa fa-circle color-yellow-light"></i><span class="color-yellow-light">Sunny</span></a>    
                <a href="#" data-change-highlight="yellow"><i class="fa fa-circle color-yellow-dark"></i><span class="color-yellow-light">Goldish</span></a>
                <a href="#" data-change-highlight="brown"><i class="fa fa-circle color-brown-dark"></i><span class="color-brown-light">Wood</span></a>    
                <a href="#" data-change-highlight="night"><i class="fa fa-circle color-dark-dark"></i><span class="color-dark-light">Night</span></a>
                <a href="#" data-change-highlight="dark"><i class="fa fa-circle color-dark-light"></i><span class="color-dark-light">Dark</span></a>
                <div class="clearfix"></div>
            </div>
            <a href="#" data-menu="menu-settings" class="mb-3 btn btn-full btn-m rounded-sm bg-highlight shadow-xl text-uppercase font-900 mt-4">Back to Settings</a>
        </div>
    </div>    
    <!-- Menu Settings Backgrounds-->
    <div id="menu-backgrounds" class="menu menu-box-bottom menu-box-detached">
        <div class="menu-title"><h1>Backgrounds</h1><p class="color-highlight">Change Page Color Behind Content Boxes</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
        <div class="divider divider-margins mb-n2"></div>
        <div class="content">
            <div class="background-changer">
                <a href="#" data-change-background="default"><i class="bg-theme"></i><span class="color-dark-dark">Default</span></a>
                <a href="#" data-change-background="plum"><i class="body-plum"></i><span class="color-plum-dark">Plum</span></a>
                <a href="#" data-change-background="magenta"><i class="body-magenta"></i><span class="color-dark-dark">Magenta</span></a>
                <a href="#" data-change-background="dark"><i class="body-dark"></i><span class="color-dark-dark">Dark</span></a>
                <a href="#" data-change-background="violet"><i class="body-violet"></i><span class="color-violet-dark">Violet</span></a>
                <a href="#" data-change-background="red"><i class="body-red"></i><span class="color-red-dark">Red</span></a>
                <a href="#" data-change-background="green"><i class="body-green"></i><span class="color-green-dark">Green</span></a>
                <a href="#" data-change-background="sky"><i class="body-sky"></i><span class="color-sky-dark">Sky</span></a>
                <a href="#" data-change-background="orange"><i class="body-orange"></i><span class="color-orange-dark">Orange</span></a>
                <a href="#" data-change-background="yellow"><i class="body-yellow"></i><span class="color-yellow-dark">Yellow</span></a>
                <div class="clearfix"></div>
            </div>
            <a href="#" data-menu="menu-settings" class="mb-3 btn btn-full btn-m rounded-sm bg-highlight shadow-xl text-uppercase font-900 mt-4">Back to Settings</a>
        </div>
    </div>


    <!----------------------------------------------------------------
    ---------------- end setting modale menu settings ----------------
    ----------------------------------------------------------------->
    