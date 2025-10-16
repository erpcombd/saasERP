<?php 

session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//require_once '../../../controllers/core/init.php';

$cid = $_SESSION['proj_id'];

include '../config/access.php';
$user_id	=$_SESSION['user_id'];



$page="home";
include_once('../template/header.php'); 




//echo $u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];
$u_id  =  $_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$PBI_ID.'"');
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
		echo $upcomingActivityCounts;
	
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


?> <style>
  .Meeting {
    background-color: #ffeb3b !important;
    /* Yellow */
  }

  .Call {
    background-color: #4caf50 !important;
    /* Green */
  }

  .Email {
    background-color: #2196f3 !important;
    /* Blue */
  }

  .Visit {
    background-color: #9c27b0 !important;
    /* Purple */
  }

  .Task {
    background-color: #ff9800 !important;
    /* Orange */
  }
</style>
<div class="page-content header-clear-medium">
  <div class="splide tripple-slider slider-no-arrows slider-no-dots" id="double-slider-1">
    <div class="splide__track">
      <div class="splide__list"> <?   
				  
				  
// If there are lead IDs, fetch activity counts in a single query

   // $leadIdsString = implode(',', $leadIds);
	
    $sqlActivities = "
        SELECT activity_type,date,lead_id,time
        FROM 
            crm_lead_activity 
        WHERE 
            lead_id IN ($leadIdsString) 
            AND status!=2";
    
    $resultActivities = db_query($sqlActivities);


    if ($resultActivities) {
        while ($activityRow = mysqli_fetch_object($resultActivities)) {
          
     		$leadid = $activityRow->lead_id;
			// for warning by color
			 $status = $activityRow->activity_type;
			$formattedDate = date('d M, Y', strtotime($activityRow->date));

			if ($activityRow->activity_type == 'Meeting') {
				$status = 'Meeting';
			} elseif ($activityRow->activity_type == 'Call') {
				$status = 'Call';
			} elseif ($activityRow->activity_type == 'Email') {
				$status = 'Email';
			} elseif ($activityRow->activity_type == 'Visit') {
				$status = 'Visit';
			} else {
				$status = 'Task';
			}
			
			
			$bg_activity = '';
			$icon = '';
			switch ($status) {
				case 'Meeting':
					$bg_activity = 'Meeting';
					$icon = 'fa-calendar';
					break;
				case 'Email':
					$bg_activity = 'Email';
					$icon = 'fa-envelope';
					break;
				case 'Visit':
					$bg_activity = 'Visit';
					$icon = 'fa-map-location-dot';
					break;
				case 'Call':
					$bg_activity = 'Call';
					$icon = 'fa-phone';
					break;
				default:
					$bg_activity = 'Task';
					$icon = 'fa-tasks';
					break;
			}
				  
				  
				  ?> <div class="splide__slide">
          <a href="#" data-menu="menu-task-group">
            <div data-card-height="170" class="card ms-3 rounded-m shadow-l" style="position: relative;">
              <div class="card-top">
                <span class="icon icon-m rounded-circle <?=$bg_activity?> ms-3 mt-3">
                  <i class="fa color-white <?=$icon?>"></i>
                </span>
				        <!-- Text positioned at the top right corner -->
        <h4 class="font-15 mb-3 ms-3" style="position: absolute; top: 10px; right: 10px;">
            <?=$activityRow->activity_type;?>
        </h4>
              </div>
			  
			  
              <div class="card-bottom">
				<h4 class="color-theme font-15 m-3 ms-3"> <?=find_a_field('crm_project_lead','lead_name','id="'.$leadid.'"');?> </h4>

				</p>
				<p class="font-10 ms-3 opacity-50" style="display: inline;">
					<i class="fa fa-calendar pe-2"></i><?=$formattedDate;?>
				</p>

              </div>
              <div class="card-overlay bg-theme"></div>
            </div>
          </a>
        </div> <?      }  }  ?> 
		
		
		
		<?   
					
					$sqlTask = "SELECT * FROM  crm_task_add_information WHERE lead_id IN ($leadIdsString) AND status!=2";
                    $resultsqlTask = db_query($sqlTask);
				
				
					if ($resultsqlTask) {
						while ($taskRow = mysqli_fetch_object($resultsqlTask)) {    ?> <div class="splide__slide">
          <a href="#" data-menu="menu-task-group">
            <div data-card-height="170" class="card ms-3 rounded-m shadow-l">
              <div class="card-top">
                <span class="icon icon-m rounded-circle bg-red-light ms-3 mt-3">
                  <i class="fa color-white fa-tasks"></i>
                </span>
              </div>
              <div class="card-bottom">
                <h4 class="color-theme font-15 mb-3 ms-3"> <?=$taskRow->task_details?> <br> <?=$taskRow->task_date?> </h4>
              </div>
              <div class="card-overlay bg-theme"></div>
            </div>
          </a>
        </div> <?  }} ?>
        <!--  
                    <div class="splide__slide"><a href="#" data-menu="menu-task-group"><div data-card-height="170" class="card ms-3 rounded-m shadow-l"><div class="card-top"><span class="icon icon-m rounded-circle bg-green-light ms-3 mt-3"><i class="fa color-white fa-check"></i></span></div><div class="card-bottom"><h4 class="color-theme font-15 mb-3 ms-3">Product<br>Development</h4></div><div class="card-overlay bg-theme"></div></div></a></div><div class="splide__slide"><a href="#" data-menu="menu-task-group"><div data-card-height="170" class="card ms-3 rounded-m shadow-l"><div class="card-top"><span class="icon icon-m rounded-circle bg-brown-light ms-3 mt-3"><i class="fa color-white fa-brush"></i></span></div><div class="card-bottom"><h4 class="color-theme font-15 mb-3 ms-3">Website <br> Re-Design</h4></div><div class="card-overlay bg-theme"></div></div></a></div>
					
					-->
      </div>
    </div>
  </div>
  <div class="content">
    <div class="row mb-n2">
      <div class="col-3 pe-2">
        <div class="card card-style mx-0 mb-3">
          <div class="p-3">
            <h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2"> Active Lead</h4>
            <h1 class="font-700 font-34 color-green-dark  mb-0">
              <span class="textspan"> <?=find_a_field('crm_project_lead', 'count(id)', 'status = "1"')?> </span>
            </h1>
            <i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
          </div>
        </div>
      </div>
      <div class="col-3 ps-2 pe-2">
        <div class="card card-style mx-0 mb-3">
          <div class="p-3">
            <h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2"> Total Lead</h4>
            <h1 class="font-700 font-34 color-blue-dark mb-0">
              <span class="textspan"> <?=find_a_field('crm_project_lead', 'count(id)', '1')?> </span>
            </h1>
            <i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
          </div>
        </div>
      </div>
      <div class="col-3 ps-2">
        <div class="card card-style mx-0 mb-3">
          <div class="p-3">
            <h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2"> Projects</h4>
            <h1 class="font-700 font-34 color-yellow-dark mb-0">
              <span class="textspan"> <?=find_a_field('crm_project_lead a, crm_project_org b', 'count(b.id)', 'a.organization=b.id AND a.status="1"')?> </span>
            </h1>
            <i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
          </div>
        </div>
      </div>
      <div class="col-3 ps-2">
        <div class="card card-style mx-0 mb-3">
          <div class="p-3">
            <h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2">Total Task</h4>
            <h1 class="font-700 font-34 color-red-dark mb-0">
              <span class="textspan"> <?=find_a_field('crm_task_add_information', 'count(task_id)', '1')?> </span>
            </h1>
            <i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card card-style">
    <div class="content mb-0">
      <h3>Your Tasks</h3>
      <p class="font-11 mt-n2 mb-0 opacity-50">9/10 Tasks Completed</p>
      <div class="divider mt-3 mb-3"></div>
      <a href="#" class="d-flex pb-3 mb-2">
        <i class="align-self-center fa-fw font-12 line-height-xs">📅</i>
        <h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Today</h5>
        <span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500"> <?=$all_metting;?>
      </a>
      </a>
      <a href="#" class="d-flex pb-3 mb-2">
        <i class="align-self-center fa-fw font-12 line-height-xs">🏠</i>
        <h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Upcoming</h5>
        <span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500"> <?=$upcomingActivityCounts;?>
      </a>
      </a>
      <a href="#" class="d-flex pb-3 mb-2">
        <i class="align-self-center fa-fw font-12 line-height-xs">💼</i>
        <h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">All</h5>
        <span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500"> <?=$activityCounts;?>
      </a>
      </a>
      <div class="divider mb-3"></div>
      <a href="#" class="d-flex pb-3 mb-2">
        <i class="align-self-center fa-fw font-12 line-height-xs">😃</i>
        <h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Meeting</h5>
        <span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500"> <?=$all_metting;?>
      </a>
      </a>
      <a href="#" class="d-flex pb-3 mb-2">
        <i class="align-self-center fa-fw font-12 line-height-xs">📅</i>
        <h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Call</h5>
        <span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500"> <?=$all_Call;?>
      </a>
      </a>
      <a href="#" class="d-flex pb-3 mb-2">
        <i class="align-self-center fa-fw font-12 line-height-xs">🏠</i>
        <h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Email</h5>
        <span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500"> <?=$all_Email;?>
      </a>
      </a>
      <a href="#" class="d-flex pb-3 mb-2">
        <i class="align-self-center fa-fw font-12 line-height-xs">💼</i>
        <h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Visit</h5>
        <span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500"> <?=$all_visit;?>
      </a>
      </a>
      <a href="#" class="d-flex pb-3 mb-2">
        <i class="align-self-center fa-fw font-12 line-height-xs">😃</i>
        <h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Task</h5>
        <span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500"> <?=$all_Task;?>
      </a>
      </a>
      <div class="divider mb-3"></div>
      <a href="#" class="d-flex pb-3 mb-2">
        <i class="align-self-center fa-fw fa fa-check color-theme opacity-50 font-12"></i>
        <h5 class="align-self-center ps-2 ms-2 mb-0 font-15 font-600 line-height-xs">Complete</h5>
        <span class="align-self-center badge bg-gray-light color-black opacity-50 ms-auto font-10 font-500">43
      </a>
      </a>
    </div>
  </div>
  <div class="card card-style">
    <div class="content mb-0">
      <div class="row mb-2 mt-n2">
        <div class="col-6 text-start">
          <h4 class="font-700 text-uppercase font-12 opacity-50">Remainder Notifications</h4>
        </div>
        <div class="col-6 text-end">
          <a href="../info_maker/schedule_manage.php" class="font-12">View All</a>
        </div>
      </div>
      <div class="divider mb-3"></div> <?   
				  
				 $sqlRemainder= "SELECT a.*,b.lead_name FROM crm_lead_activity a,crm_project_lead b 
				WHERE a.lead_id=b.id and  a.remainder_date >= CURDATE() and a.lead_id IN ($leadIdsString)  AND a.status!=2 order by a.activity_id DESC LIMIT 5";
				$resultRemainder = db_query($sqlRemainder);
				if ($resultRemainder) {
				while ($remainderRow = mysqli_fetch_object($resultRemainder)) {
				
					// Define the start datetime
				$startDateTime = new DateTime($remainderRow->entry_at);
				$endDateTime = new DateTime('now');
				$interval = $startDateTime->diff($endDateTime);
				$timeDifference = $interval->format('%d days %h hours %i min');
          		$activityStatus = $remainderRow->status;
				// for warning by color
			 $status = $remainderRow->activity_type;
			
			if ($remainderRow->activity_type == 'Meeting') {
				$status = 'Meeting';
			} elseif ($remainderRow->activity_type == 'Call') {
				$status = 'Call';
			} elseif ($remainderRow->activity_type == 'Email') {
				$status = 'Email';
			} elseif ($remainderRow->activity_type == 'Visit') {
				$status = 'Visit';
			} else {
				$status = 'Task';
			}
			
			
			$bg_activity = '';
			$icon = '';
			$text ='';
			switch ($status) {
				case 'Meeting':
					$bg_activity = 'Meeting';
					$icon = 'fa-calendar';
					$text ='with ';
					break;
				case 'Email':
					$bg_activity = 'Email';
					$icon = 'fa-envelope';
					$text ='regarding ';
					break;
				case 'Visit':
					$bg_activity = 'Visit';
					$icon = 'fa-map-location-dot';
					$text ='to ';
					break;
				case 'Call':
					$bg_activity = 'Call';
					$icon = 'fa-phone';
					$text ='with';
					break;
				default:
					$bg_activity = 'Task';
					$icon = 'fa-tasks';
					$text ='related to ';
					break;
			}
                 ?> <a href="#" class="item">
        <div class="d-flex mb-4">
          <div class="pe-3">
            <span class="icon icon-xs 
								<?=$bg_activity?> rounded-sm">
              <i class="fa color-white 
									<?=$icon?>">
              </i>
            </span>
          </div>
          <div class="align-self-center w-100">
            <p class="line-height-s font-12 font-400">Reminder for <strong class="font-800"> <?=$remainderRow->activity_type?> </strong> <?=$text?> <strong class="font-800"> <?=$remainderRow->lead_name?>
                <!-- <span class="badge bg-blue-dark color-white ms-2">UPDATE</span>--> <? if($remainderRow->status =='2'){ ?> <span class="badge bg-green-dark color-white ms-2">COMPLETE</span> <? }elseif($remainderRow->status =='1'){ ?> <span class="badge bg-red-dark color-white ms-2">PENDING</span> <? }else{ ?> <span class="badge bg-blue-dark color-white ms-2">CANCELLED</span> <?  } ?> </p>
          </div>
          <div class="align-self-center flex-grow-1">
            <p class="ps-3 font-10 line-height-xs text-center opacity-40"> <?=$timeDifference;?> </p>
          </div>
        </div>
      </a> <?  } }?> <div class="row mb-2 mt-n2">
        <div class="col-6 text-start">
          <h4 class="font-700 text-uppercase font-12 opacity-50">My Task Remainder Notifications</h4>
        </div>
        <div class="col-6 text-end">
          <a href="../info_maker/task_manage.php" class="font-12">View All</a>
        </div>
      </div>
      <div class="divider mb-3"></div> <?   
				  
				 $sqlTaskRemainder= "SELECT a.*,b.lead_name FROM crm_task_add_information a,crm_project_lead b 
				WHERE a.lead_id=b.id and  a.reaminder_start_date >= CURDATE() and a.lead_id IN ($leadIdsString)  AND a.status!=2 order by a.task_id DESC LIMIT 5";
				$resultTaskRemainder = db_query($sqlTaskRemainder);
				if ($resultTaskRemainder) {
				while ($remainderTaskRow = mysqli_fetch_object($resultTaskRemainder)) {
				
				// Define the start datetime
				$startDateTime = new DateTime($remainderTaskRow->entry_at);
				$endDateTime = new DateTime('now');
				$interval = $startDateTime->diff($endDateTime);
				$timeDifference = $interval->format('%d days %h hours %i min');
          // for warning by color
			 $status = $remainderTaskRow->activity_type;
			
			if ($remainderTaskRow->activity_type == 'Meeting') {
				$status = 'Meeting';
			} elseif ($remainderTaskRow->activity_type == 'Call') {
				$status = 'Call';
			} elseif ($remainderTaskRow->activity_type == 'Email') {
				$status = 'Email';
			} elseif ($remainderTaskRow->activity_type == 'Visit') {
				$status = 'Visit';
			} else {
				$status = 'Task';
			}
			
			
			$bg_activity = '';
			$icon = '';
			$text ='';
			switch ($status) {
				case 'Meeting':
					$bg_activity = 'Meeting';
					$icon = 'fa-calendar';
					$text ='with ';
					break;
				case 'Email':
					$bg_activity = 'Email';
					$icon = 'fa-envelope';
					$text ='regarding ';
					break;
				case 'Visit':
					$bg_activity = 'Visit';
					$icon = 'fa-map-location-dot';
					$text ='to ';
					break;
				case 'Call':
					$bg_activity = 'Call';
					$icon = 'fa-phone';
					$text ='with';
					break;
				default:
					$bg_activity = 'Task';
					$icon = 'fa-tasks';
					$text ='related to ';
					break;
			}
                 ?> <a href="#" class="item">
        <div class="d-flex mb-4">
          <div class="pe-3">
            <span class="icon icon-xs <?=$bg_activity?> rounded-sm">
              <i class="fa color-white <?=$icon?>">
              </i>
            </span>
          </div>
          <div class="align-self-center w-100">
            <p class="line-height-s font-12 font-400">Reminder for <strong class="font-800"> <?=$remainderTaskRow->subject?> </strong> <?=$text?> <strong class="font-800"> <?=$remainderTaskRow->lead_name?> <? if($remainderTaskRow->status =='2'){ ?> <span class="badge bg-green-dark color-white ms-2">COMPLETE</span> <? }elseif($remainderTaskRow->status =='1'){ ?> <span class="badge bg-red-dark color-white ms-2">PENDING</span> <? }else{ ?> <span class="badge bg-blue-dark color-white ms-2">CANCELLED</span> <?  } ?> </p>
          </div>
          <div class="align-self-center flex-grow-1">
            <p class="ps-3 font-10 line-height-xs text-center opacity-40"> <?=$timeDifference;?> </p>
          </div>
        </div>
      </a> <?  } }?>
      <!--<a href="#" class="item"><div class="d-flex mb-4"><div class="pe-3"><span class="icon icon-xs bg-red-dark rounded-sm"><i class="fa fa-times"></i></span></div><div class="align-self-center w-100"><p class="line-height-s font-12 font-400">Mockups Rejected. Event <strong class="font-800">Emergency Meeting</strong> created by <strong class="font-800">Admin</strong>.
                                <span class="badge bg-red-dark color-white ms-2">URGENT</span></p></div><div class="align-self-center flex-grow-1"><p class="ps-3 font-10 line-height-xs text-center opacity-40">10 hrs</p></div></div></a>-->
    </div>
  </div>
  <!--        <div class="card card-style"><div class="content mb-0"><div class="row mb-2 mt-n2"><div class="col-6 text-start"><h4 class="font-700 text-uppercase font-12 opacity-50">INBOX</h4></div><div class="col-6 text-end"><a href="#" class="font-12">View All</a></div></div><div class="divider mb-3"></div><a href="#" class="d-flex mb-4"><div class="align-self-center"><img src="../images/pictures/faces/1s.png" width="45" class="rounded-xl border border-s me-3"></div><div class="align-self-center w-100"><h5>John Doe <span class="badge ms-1 bg-highlight color-white border-0 font-10" style="transform:translateY(-2px);">ADMIN</span></h5><p class="font-500 opacity-70 mt-n2">Ping me when you get this, we need...</p></div></a><a href="#"  class="d-flex mb-4"><div class="align-self-center"><img src="../images/pictures/faces/4s.png" width="45" class="rounded-xl border border-s me-3"></div><div class="align-self-center w-100"><h5>Jack Son <span class="badge ms-1 bg-blue-dark color-white border-0 font-10" style="transform:translateY(-2px);">CLIENT</span></h5><p class="font-500 opacity-70 mt-n2">Hello, have time for a chat?</p></div></a><a href="#"  class="d-flex mb-4"><div class="align-self-center"><img src="../images/pictures/faces/2s.png" width="45" class="rounded-xl border border-s me-3"></div><div class="align-self-center w-100"><h5>Joe Markus <span class="badge ms-1 bg-green-dark color-white border-0 font-10" style="transform:translateY(-2px);">DESIGN</span></h5><p class="font-500 opacity-70 mt-n2">PSD's are ready. Wanna see them?</p></div></a></div></div>-->
  <div class="footer card card-style">
    <p class="footer-copyright">Copyright &copy; Enabled <span id="copyright-year">2017</span>. All Rights Reserved. </p>
    <p class="footer-links">
      <a href="#" class="color-highlight">Privacy Policy</a> | <a href="#" class="color-highlight">Terms and Conditions</a> | <a href="#" class="back-to-top color-highlight"> Back to Top</a>
    </p>
    <div class="clear"></div>
  </div>
</div>
<!-- End of Page Content-->
<!-- All Menus, Action Sheets, Modals, Notifications, Toasts, Snackbars get Placed outside the <div class="page-content"> --> <?php include_once('../template/link_footer.php'); ?>