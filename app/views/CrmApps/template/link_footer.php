<!--<script type="text/javascript" src="../styles/select2.min.js"></script>
<script type="text/javascript" src="../styles/jquery-3.4.1.min.js"></script>-->





<?
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
    <!-- Menu Sidebar Left 1 -->
    <!-- Menu Sidebar Left 1 -->
    <!-- Menu Sidebar Left 1 -->
    

    <!-- Menu Sidebar Left 2 -->
    <!-- Menu Sidebar Left 2 -->
    <!-- Menu Sidebar Left 2 -->
    


    <!-- Menu Sidebar Left 3 -->
    <!-- Menu Sidebar Left 3 -->
    <!-- Menu Sidebar Left 3 -->
    <div id="menu-sidebar-left-3" class="bg-white menu menu-box-left" data-menu-width="320" data-menu-effect="menu-parallax">
        <div class="d-flex flex-row-reverse">
            
            <a href="#" class="close-menu  icon icon-m text-center color-red-dark "><i class="fa font-12 fa-times"></i></a>
        </div>
        <div class="ps-3 pe-3 pt-3 mt-4 mb-2">
            <div class="d-flex">
                <div class="me-3">
                    <img src="../images/preload-logo.png" width="43">
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
                    <i class="fa font-14 fa-camera rounded-s bg-green-dark"></i>
                    <span>Filters & Labels</span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
                <a href="../main/lead_list.php" class="border-0">
                    <i class="fa fa-bookmark bg-red-dark rounded-s"></i>
                    <span> Leads (Pre-Sale)</span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				<a href="../info_maker/task_manage.php" class="border-0">
                    <i class="fa fa-server bg-blue-dark rounded-s"></i>
                    <span> Activities (Post-Sale)</span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				
				<a href="../info_maker/schedule_manage.php" class="border-0">
                    <i class="fa fa-chart-bar bg-brown-dark rounded-s"></i>
                    <span>Schedule</span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				
            </div>
        </div>
		
		
		
		<!-- NEW CODE --->
<div class="me-3 ms-3">
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
			
			


			
			
			
                <?php /*?><a href="../info_maker/lead_details_show.php?view=<?=encrypTS($row->id)?>&tp='<?=encrypTS('lead')?>'"><?php */?>
				<a href="../info_maker/project_task_view.php?lead_id=<?=$row->id?>">
                    <i class="fa font-14  fa-hashtag rounded-s bg-blue-dark"></i>
                    <span><?=$row->name?></span>
                    <span class="badge <?=$class?>"><?=find_a_field('crm_lead_status', 'status', 'id = "'.$row->status.'"')?></span>

                    <i class="fa fa-angle-right"></i>
                </a>

				

				

            </div>
 				
        </div>
				<?       } ?>  								   		
	
		
		
		

        <!--<div class="me-3 ms-3 mt-4">
            <span class="text-uppercase font-900 font-11 opacity-30">SOCIAL LINKS</span>
            <div class="list-group list-custom-small">
                <a href="#">
                    <i class="fab font-14 fa-facebook-f rounded-s bg-facebook"></i>
                    <span>Facebook</span>
                    <i class="fa fa-link"></i>
                </a>
                <a href="#">
                    <i class="fab font-14 fa-twitter rounded-s bg-twitter"></i>
                    <span>Twitter</span>
                    <i class="fa fa-link"></i>
                </a>
                <a href="#" class="border-0">
                    <i class="fab font-14 fa-instagram rounded-s bg-instagram"></i>
                    <span>Instagram</span>
                    <i class="fa fa-link"></i>
                </a>
            </div>
        </div>-->

<!--        <div class="me-3 ms-3 mt-4 pt-2">
            <span class="text-uppercase font-900 font-11 opacity-30">Account Settings</span>
            <div class="list-group list-custom-small">
                <a href="#" data-toggle-theme data-trigger-switch="switch-dark3-mode">
                    <i class="fa font-12 fa-moon bg-gray-dark rounded-s"></i>
                    <span>Dark Mode</span>
                    <div class="custom-control scale-switch ios-switch">
                        <input data-toggle-theme type="checkbox" class="ios-input" id="switch-dark3-mode">
                        <label class="custom-control-label" for="switch-dark3-mode"></label>
                    </div>
                    <i class="fa fa-angle-right"></i>
                </a>
                <a data-trigger-switch="sidebar-311-switch-2" href="#">
                    <i class="fa font-14 fa-circle rounded-s bg-green-dark"></i>
                    <span>Active Mode</span>
                    <div class="custom-control scale-switch ios-switch">
                        <input type="checkbox" class="ios-input" id="sidebar-311-switch-2" checked>
                        <label class="custom-control-label" for="sidebar-311-switch-2"></label>
                    </div>
                    <i class="fa fa-angle-right"></i>
                </a>
                <a data-trigger-switch="sidebar-31-switch-3" href="#" class="border-0">
                    <i class="fa font-14 fa-bell rounded-s bg-blue-dark"></i>
                    <span>Notifications</span>
                    <div class="custom-control scale-switch ios-switch">
                        <input type="checkbox" class="ios-input" id="sidebar-31-switch-3" checked>
                        <label class="custom-control-label" for="sidebar-31-switch-3"></label>
                    </div>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>-->
		
		
		
		
		
		
		
		
    </div>









 
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
    <!-- Menu Share -->


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



<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('leadChart').getContext('2d');
        var leadData = {
            labels: ['Total Active Lead', 'Total Generated Lead'],
            datasets: [{
                data: [
                    <?=find_a_field('crm_project_lead', 'count(id)', 'status = "1"')?>,
                    <?=find_a_field('crm_project_lead', 'count(id)', '1')?>
                ],
                backgroundColor: ['#F7E3EE', '#D8F0FA']
            }]
        };
        var leadChart = new Chart(ctx, {
            type: 'pie',
            data: leadData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                }
            }
        });
    });

    function openModalleadentry(orgId, orgName, orgwebsite,orgyearlyturnover,sourcename,orgemployee,orgtype,orgaddress,orgdistrict,
	orgzip,orgcountry,orgdivision,orgdescription,orgconperson,orgconnumber,orgconmail) {
      orgdescription = orgdescription.replace(/"/g, "");

      // description = description.replace(/\n/g, '<br>');

 
      
        // document.getElementById('id').value = contactId;
        document.getElementById('orgsavebtn').classList.add('d-none');// or 'inline' depending on your styling
        document.getElementById('orgentryeditbtn').classList.remove('d-none');// or 'inline' depending on your styling
        document.getElementById('orgname').value = orgName;
 
       var selectElement = document.getElementById('lead_source');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
  // Check the value of each option
    if (selectElement.options[i].value == sourcename) {
        selectElement.options[i].selected = true;
        break;
    }
}
        // document.getElementById('lead_type').value = orgName;
       var selectElement = document.getElementById('lead_type');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgtype) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('district');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgdistrict) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('zip');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgzip) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('country');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgcountry) {
        selectElement.options[i].selected = true;
        break;
    }
}
       var selectElement = document.getElementById('division');
// Check if the correct select element is found
for (var i = 0; i < selectElement.options.length; i++) {
    // Check the value of each option
    if (selectElement.options[i].value == orgdivision) {
        selectElement.options[i].selected = true;
        break;
    }
}

        document.getElementById('annual_revenue').value = orgyearlyturnover;
        document.getElementById('website').value = orgwebsite;
        document.getElementById('total_employees').value = orgemployee;
        document.getElementById('orgaddress').value = orgaddress;
		document.getElementById('contact_person').value = orgconperson;
		document.getElementById('contact_number').value = orgconnumber;
		document.getElementById('contact_email').value = orgconmail;
	    // document.getElementById('lead_type').value = orgtype;
        
        var idInput = document.createElement('input');
        idInput.setAttribute('type', 'hidden');
        idInput.setAttribute('name', 'id');
        idInput.setAttribute('id', 'id');
        idInput.setAttribute('value', orgId);

        // Append the id input field to the form using the form's ID
        var form = document.getElementById('organizationentrytable');
        form.appendChild(idInput);

        document.getElementById('description').value = orgdescription;

    }
    function openModalConverttolead(orgId,orgName) {
 
      document.getElementById('organization').value = orgId;
      document.getElementById('organizationnamelead').value = orgName;
    }
  
</script>


<script>
        $(document).ready(function () {
        $('#example1').DataTable();
		$('#example').DataTable();
		 table.page.len(10).draw();
    });

    $('#leadentrymodal').on('hidden.bs.modal', function(e) {
  $(this).find('#organizationentrytable')[0].reset();
});
    $('#convertToLead').on('hidden.bs.modal', function(e) {
  $(this).find('#converttoleadform')[0].reset();
});
		
	
//	$(document).ready(function() {
//    // Initialize DataTable
//    var table = $('#example').DataTable();
//
//    // Set the length of displayed records
//
//});

</script>

<script>
function togglecustomerlist(){
    document.getElementById("customerlistid").style.display = "block";

    //document.getElementById("customerlistbutton").style.transform = "scale(0.8)";
    document.getElementById("customerlistbutton").style.backgroundColor = "#0c8";
    document.getElementById("customerleadbutton").style.backgroundColor = "#3d90a7";
    document.getElementById("customerleadbutton").style.transform = "scale(1)";
    document.getElementById("leadlistid").style.display = "none";
}
function toggleleadlist(){
    document.getElementById("leadlistid").style.display = "block";

    //document.getElementById("customerleadbutton").style.transform = "scale(0.8)";
    document.getElementById("customerleadbutton").style.backgroundColor = "#0c8";
    document.getElementById("customerlistbutton").style.backgroundColor = "#3d90a7";
    document.getElementById("customerlistbutton").style.transform = "scale(1)";
    document.getElementById("customerlistid").style.display = "none";
}
</script>



<script type="text/javascript" src="../styles/select2.min.js"></script>
<script type="text/javascript" src="../scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="../scripts/custom.js"></script>


</body>







