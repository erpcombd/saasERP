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





// Get the status parameter
$status = isset($_GET['status']) ? $_GET['status'] : '';
$priority_status = isset($_GET['priority_status']) ? $_GET['priority_status'] : '';

 $lead_id = isset($_GET['lead_id']) ? $_GET['lead_id'] : '';


?>







<style>

/*btn width CSS*/
	.width-100{
		width:100%;
	}



</style>


    <div class="page-content header-clear-medium">



        <div class="decoration decoration-margins"></div>

        <div class="calendar bg-theme shadow-xl rounded-m">
            <div class="cal-footer">
                <h6 class="cal-sub-title uppercase bold bg-highlight color-white">Today Schedule Box</h6>

				  
				  
				  
				  
				
				
				<?  
				  
				  	//___________Task ___________
           $sqlRemainder = "SELECT * FROM crm_task_add_information a WHERE entry_by = $u_id";
            if ($status !== '') {
                $sqlRemainder .= " AND status = '$status'";
            }
            if ($priority_status !== '') {
                $sqlRemainder .= " AND priority_status = '$priority_status'";
            }
			if ($lead_id !== '') {
    		echo $sqlRemainder .= " AND lead_id = '$lead_id'";
			}
            $sqlRemainder .= " ORDER BY `task_id` DESC;";
            
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
						<span class="task-details"><i class="fa  fa-list-check "></i><?=$remainderRow->task_details;?></span>
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

  
  
  <script>

  
  
  </script>
  
  <?php include_once('../template/link_footer.php'); ?>
