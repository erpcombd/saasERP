<? 
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/Calendar.php';
//require_once '../assets/support/crud.php';
require_once '../assets/support/custom.php';
//require_once '../assets/support/menu_dynamic.php';
require_once '../assets/support/mix_function.php';
require_once '../assets/support/reg__ajax.php';

$cid = $_SESSION['proj_id'];
?>



<?php



$user_id	=$_SESSION['user_id'];



$page="home";






?>



<?php 
require_once '../assets/template/inc.header.php';


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


<style>

/*btn width CSS*/
	.width-100{
		width:100%;
	}


</style>


    <div class="page-content header-clear-medium">

<!--        <div class="calendar bg-theme shadow-xl rounded-m">
            <div class="cal-header">
                <h4 class="cal-title text-center text-uppercase font-800 bg-highlight color-white">June</h4>
                <h6 class="cal-title-left color-white"><i class="fa fa-chevron-left"></i></h6>
                <h6 class="cal-title-right color-white"><i class="fa fa-chevron-right"></i></h6>
            </div>
            <div class="clearfix"></div>
            <div class="cal-days bg-highlight opacity-80 bottom-0">
                <a href="#">SUN</a>
                <a href="#">MON</a>
                <a href="#">TUE</a>
                <a href="#">WED</a>
                <a href="#">THU</a>
                <a href="#">FRI</a>
                <a href="#">SAT</a>
                <div class="clearfix"></div>
            </div>
            <div class="cal-dates cal-dates-border">
                <a href="#" class="cal-disabled">25</a>
                <a href="#" class="cal-disabled">26</a>
                <a href="#" class="cal-disabled">27</a>
                <a href="#" class="cal-disabled">28</a>
                <a href="#" class="cal-disabled">29</a>
                <a href="#" class="cal-disabled">30</a>
                <a href="#">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">7</a>
                <a href="#">8</a>
                <a href="#">9</a>
                <a href="#">10</a>
                <a href="#">11</a>
                <a href="#" class="cal-selected"><i class="fa fa-square color-highlight"></i><span>12</span></a>
                <a href="#">13</a>
                <a href="#">14</a>
                <a href="#">15</a>
                <a href="#">16</a>
                <a href="#">17</a>
                <a href="#">18</a>
                <a href="#">19</a>
                <a href="#">20</a>
                <a href="#">21</a>
                <a href="#">22</a>
                <a href="#">23</a>
                <a href="#">24</a>
                <a href="#">25</a>
                <a href="#">26</a>
                <a href="#">27</a>
                <a href="#">28</a>
                <a href="#">29</a>
                <a href="#">30</a>
                <a href="#">31</a>
                <a href="#" class="cal-disabled">1</a>
                <a href="#" class="cal-disabled">2</a>
                <a href="#" class="cal-disabled">3</a>
                <a href="#" class="cal-disabled">4</a>
                <a href="#" class="cal-disabled">5</a>
                <div class="clearfix"></div>
            </div>
        </div>-->

        <div class="decoration decoration-margins"></div>

        <div class="calendar bg-theme shadow-xl rounded-m">
            <div class="cal-footer">
                <h6 class="cal-sub-title uppercase bold bg-highlight color-white">Upcoming Schedule Box</h6>
                <!--<span class="cal-message mt-3 mb-3">
                    <i class="fa fa-bell font-18 color-green-dark"></i>
                    <strong class="color-gray-dark">Reminder: Call the plumber for Kitchen Sink</strong>
                    <strong class="color-gray-dark">Reminder: Today is Karla Black's Birthday.</strong>
                </span>
			      <div class="divider mb-0"></div>-->
				  
				  
				  
				  
				
				
				<?  
				  
				  	//___________Task ___________
                $sqlRemainder= "SELECT * FROM crm_task_add_information a WHERE entry_by = $u_id  AND status != 'cancelled' ORDER BY `task_id` DESC;";
				$resultRemainder = db_query($sqlRemainder);
				if ($resultRemainder) {
				while ($remainderRow = mysqli_fetch_object($resultRemainder)) {
					// Format the date
					$formattedDate = date('d M, Y', strtotime($remainderRow->task_date));
					// Format the time
					$formattedTime = date('h:i A', strtotime($remainderRow->task_time));
    		  
				  ?>
				  
				  <?php /*?><a href="../info_maker/task_manage.php?view=<?=encrypTS($remainderRow->lead_id)?>&tp='<?=encrypTS('lead')?>'"><?php */?>
				  <a href="#">
				  

				    <div class="cal-schedule position-relative">
					<!-- Button positioned at top right corner -->
						
						<? if($remainderRow->status =='2'){ ?>

                                            <span class="badge bg-green-dark float-end ms-2 color-white font-10 m-2">COMPLETE</span>
												<? }elseif($remainderRow->status =='1'){ ?>
														   
													<span class="badge bg-red-dark float-end ms-2 color-white font-10 m-2">PENDING</span>
														   <? }else{ ?>
														   
														   <span class="badge bg-blue-dark float-end color-white font-10 m-2">CANCELLED</span>
														   <?  } ?>
								
								
										<? if($remainderRow->priority_status == 'LOW'){ ?>
                                            <span class="badge bg-green-dark float-end ms-2 color-white font-10 m-2">LOW</span>
												<? }elseif($remainderRow->priority_status == 'MEDIUM'){ ?>	   
													<span class="badge bg-blue-dark float-end ms-2 color-white font-10 m-2">MEDIUM</span>
														<? }elseif($remainderRow->priority_status == 'HIGH'){ ?>
														   <span class="badge bg-red-dark float-end ms-2 color-white font-10 m-2">HIGH</span>
														   <? }else{ ?>
														   <span class="badge bg-red-dark float-end ms-2 color-white font-10 m-2">No data</span>
														  <?  } ?>

						<div class="position-absolute top-0 end-0  mt-5 me-3">
							<button class="fa fa-edit color-brown-dark" data-menu="addProduct" onclick="openModalupdatetask('<?=$row->activity_id;?>')"></button>
						</div>
						<em><?=$formattedDate?><br> <?=$formattedTime?> </em>
						<strong class="d-block mb-n2">Task Name:<?=$remainderRow->task_name;?></strong>
						<span><i class="fa  fa-list-check"></i><?=$remainderRow->task_details;?></span>
						<span><i class="fa  fa-list-check"></i>Assign Person:<?=find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "'.$remainderRow->assign_person.'"')?></span>
						<span><i class="fa  fa-list-check"></i>Company Name:<?=find_a_field('crm_project_org', 'name', 'id = "'.$remainderRow->lead_id.'"')?></span>                                
						

						
						
                	</div>
				</a>
				<?     } }	 ?>
				
				
				
				
												 
				
	
				
                <!--<div class="cal-schedule">
                    <em>08:00 PM<br>10:00 AM</em>
                    <strong class="d-block mb-n2">Closing Hours</strong>
                    <span><i class="fa fa-map-marker"></i>Envato Headquarters</span>
                </div>
				
				
                <div class="cal-schedule">
                    <em>10:00 AM<br>12:00 AM</em>
                    <strong class="d-block mb-n2">Meeting with Board</strong>
                    <span><i class="fa fa-building"></i>Office, Envato Headquarters</span>
                </div>
				
				
				
                <div class="cal-schedule">
                    <em>12:00 AM<br>02:00 PM</em>
                    <strong class="d-block mb-n2">Lunch</strong>
                    <span><i class="fa fa-shopping-bag"></i>McDonalds, Town Hall</span>
                </div>
                <div class="cal-schedule">
                    <em>02:00 PM<br>05:00 PM</em>
                    <strong class="d-block mb-n2">Quarter Report</strong>
                    <span><i class="fa fa-building"></i>Office, Envato Headquarters</span>
                </div>
				
				
              
				
				
                <div class="cal-schedule">
                    <em>07:00 PM<br>09:00 PM</em>
                    <strong class="d-block mb-n2">Watch Movie</strong>
                    <span><i class="fa fa-at"></i>with <u class="color-green-dark">John Doe</u>, <u class="color-orange-dark">Carla Black</u></span>
                </div>
				-->
				
              
				
				
				
            </div>
        </div>
		
		
		

		
		
		



    </div>
    <!-- End of Page Content-->
  <!-- ___________  Edit Menu Start _________  -->
    
	
<div id="addProduct" class="menu menu-box-modal menu-box-detached">
    <form method="post" action="">
        <div class="modal-body">
            <input type="hidden" name="activity_id" id="activity_id" value="" />
            <div class="menu-title">
                <h1>Edit Task</h1>
                <p class="color-highlight"><?=$orgname?></p>
                <a href="#" class="close-menu"><i class="fa fa-times"></i></a>
            </div>
            <div class="divider divider-margins mb-1 mt-3"></div>
            <div class="content px-1">
                <div class="input-style has-borders no-icon mb-4">
                    <input type="text" id="edit_task_name" name="task_name" placeholder="Task Name">
                    <label for="edit_task_name" class="color-highlight">Task Name</label>
                </div>
                <div class="input-style has-borders no-icon mb-4">
                    <textarea id="edit_task_details" name="task_details" placeholder="Task Details"></textarea>
                    <label for="edit_task_details" class="color-highlight">Task Details</label>
                </div>
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="edit_priority_status" class="color-highlight">Priority type</label>
                    <select class="form-control req" name="priority_status" id="edit_priority_status" required>
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
                        <div class="input-style has-borders no-icon mb-4">
                            <label for="edit_assign_person" class="color-highlight">Assign Person</label>
                            <select class="form-control req" name="assign_person" id="edit_assign_person">
                                <option value=""></option>
                                <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$assign_person,'1'); ?>
                            </select>
                            <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                            <i class="fa fa-check valid color-green-dark"></i>
                            <i class="fa fa-check disabled invalid color-red-dark"></i>
                            <em></em>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-style has-borders no-icon mb-4">
                            <label for="edit_lead_id" class="color-highlight">Project Name</label>
                            <select class="form-control req" name="lead_id" id="edit_lead_id">
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
                <h5 class="mb-2 font-15 mt-2">Task</h5>
                <div class="row mb-0">
                    <div class="col-6">
                        <div class="input-style has-borders no-icon mb-4 input-style-active">
                            <label for="edit_task_time" class="color-highlight text-uppercase font-700 font-10 mt-1">Task Time</label>
                            <input type="time" name="task_time" class="form-control validate-text" id="edit_task_time">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-style has-borders no-icon mb-4 input-style-active">
                            <label for="edit_task_date" class="color-highlight text-uppercase font-700 font-10 mt-1">Task Date</label>
                            <input type="date" style="width:100%" name="task_date" class="form-control validate-text" id="edit_task_date">
                        </div>
                    </div>
                </div>
                <h5 class="mb-2 font-15 mt-2">Reminder</h5>
                <div class="row mb-0">
                    <div class="col-6">
                        <div class="input-style has-borders no-icon mb-4 input-style-active">
                            <label for="edit_reminder_start_time" class="color-highlight text-uppercase font-700 font-10 mt-1">Reminder time</label>
                            <input type="time" name="reminder_start_time" class="form-control validate-text" id="edit_reminder_start_time">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-style has-borders no-icon mb-4 input-style-active">
                            <label for="edit_reminder_start_date" class="color-highlight text-uppercase font-700 font-10 mt-1">Reminder Date</label>
                            <input type="date" style="width:100%" name="reminder_start_date" class="form-control validate-text" id="edit_reminder_start_date">
                        </div>
                    </div>
                </div>
                <button type="submit" name="updateTask" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Confirm</button>
            </div>
        </div>
    </form>
</div>


  
 <? require_once '../assets/template/inc.footer.php'; ?>