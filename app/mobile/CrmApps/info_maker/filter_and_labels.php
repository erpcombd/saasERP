<?php
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
$page = "home";

require_once '../assets/template/inc.header.php';


$u_id  =  $_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management', 'PBI_ID', 'user_id=' . $u_id);
$basic = find_all_field('personnel_basic_info', '', 'PBI_ID="' . $PBI_ID . '"');

$cur = '&#x9f3;';
$table1 = 'crm_project_lead';


/* __________  UPDATE DAILY ACTIVITYS ____________*/

if(isset($_POST['UpdateTaskActivity']))
{

        $crud   = new crud('crm_lead_activity');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('activity_id');
		$type=1;
		$msg='Successfully Updated.';
       
}

/* __________ ALL METTING FEEDBACK_____ UPDATE DAILY ACTIVITYS ____________*/

if (isset($_POST['meeting_feedback']) && !empty(trim($_POST['meeting_feedback']))) {

	$crud   = new crud('crm_lead_activity_feedback');
	$_POST['activity_id'] = $_POST['activity_id'];
	$_POST['feedback']  = $_POST['meeting_feedback'];
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();
   

}


?>

<style>
    .width-100 {
        width: 100%;
    }
</style>



<script>
                        document.addEventListener("DOMContentLoaded", function () {
                            // Define arrays of colors for background and text (excluding white)
                            var backgroundColors = ["blue", "green", "yellow", "brown", "purple",  "cyan", "pink", "grey"];
                            var textColors = ["blue", "green", "yellow", "brown", "purple",  "cyan", "pink", "grey"];
                        
                            // Select all elements with class 'mycard'
                            var cards = document.querySelectorAll('.mycard');
                        
                            // // Set the first card to have a white background
                            // cards[0].setAttribute('data-background', 'white');
                            // cards[0].setAttribute('data-color', 'black'); // You can set the text color as well
                        
                            // Loop through each card starting from the second one
                            for (var i = 0; i < cards.length; i++) {
                                // Generate a random index to select a color from the arrays
                                var randomBackgroundIndex = Math.floor(Math.random() * backgroundColors.length);
                                var randomTextIndex = Math.floor(Math.random() * textColors.length);
                        
                                // Get the random colors
                                var randomBackgroundColor = backgroundColors[randomBackgroundIndex];
                                var randomTextColor = textColors[randomTextIndex];
                        
                                // Set the data-background attribute to the random background color
                                cards[i].setAttribute('data-background', randomBackgroundColor);
                                // Set the data-color attribute to the random text color
                                cards[i].setAttribute('data-color', randomTextColor);
                        
                                // Add the random color classes to the card
                                cards[i].classList.add('mycard[data-background="' + randomBackgroundColor + '"]');
                                cards[i].classList.add('mycard[data-color="' + randomTextColor + '"]');
                            }
                        });
                        
                                
                        
                            function openModalcontact(contactId, contactName, contactphone,contactemail,contactdesignation) {
                                console.log(contactId, contactName, contactphone,contactemail,contactdesignation)
                                // document.getElementById('id').value = contactId;
                                document.getElementById('contactsave').classList.add('d-none');// or 'inline' depending on your styling
                                document.getElementById('contactedit').classList.remove('d-none');// or 'inline' depending on your styling
                                document.getElementById('contact_name').value = contactName;
                                document.getElementById('contact_phone').value = contactphone;
                                document.getElementById('contact_email').value = contactemail;
                                document.getElementById('contact_designation').value = contactdesignation;
                                
                                var idInput = document.createElement('input');
                                idInput.setAttribute('type', 'hidden');
                                idInput.setAttribute('name', 'id');
                                idInput.setAttribute('id', 'id');
                                idInput.setAttribute('value', contactId);
                        
                                // Append the id input field to the form using the form's ID
                                var form = document.getElementById('contactformidnew');
                                form.appendChild(idInput);
                        
                            }
                            function openModalproduct(productId, productName) {
                                console.log(productId)
                                document.getElementById('product_individual_id').value = productId;
                             // or 'inline' depending on your 
                        
                            }
                            function openModalcancelmeeting(activityId) {
                                console.log(activityId)
                                document.getElementById('activity_id').value = activityId;
                             // or 'inline' depending on your 
                        
                        
                            }
							
							
						 function openModalUpdateTask(taskId) {
							console.log(taskId)
							document.getElementById('task_id').value = taskId;
						 // or 'inline' depending on your 
					      }
                        
                            function openModalfortask(taskId, taskName, taskDetails,taskDate,taskTime) {
                            console.log(taskId, taskName, taskDetails,taskDate,taskTime);
                            document.getElementById('tasktittleid').innerText = taskName;
                            document.getElementById('exampleDetailsid').innerText = 'Task Details: ' + taskDetails;
                        	document.getElementById('exampleDateid').innerText = 'Task Date: ' + taskDate;
                        	document.getElementById('exampleTimeid').innerText = 'Task Time: ' + taskTime;
                        }
                            function openModalStatusUpdate(statusid) {
                                console.log(statusid);
                                var selectElement = document.getElementById('status');
                                console.log(selectElement);
                        // Check if the correct select element is found
                        for (var i = 0; i < selectElement.options.length; i++) {
                            // Check the value of each option
                            if (selectElement.options[i].value == statusid) {
                                selectElement.options[i].selected = true;
                                break;
                            }
                        }
                            document.getElementById('tasktittleid').innerText = taskName;
                            document.getElementById('exampleDetailsid').innerText = 'Task Details: ' + taskDetails;
                        
                        }
                        
                        
                            // JavaScript to handle modal show event
                    </script>

<div class="page-content">


		
		
				
				
		<br />
					
		<div class="card mx-2 bg-transparent" data-card-height="" style="height:400px">
			<div class="card-center">
				<h1 class="text-center font-28">Find your Stuff</h1>
				<br />
						
				   <form action="" method="POST">	
					<!-- Tab 1 -->
					<div data-bs-parent="#tab-group" class="collapse show">
						<div class="input-style has-borders no-icon mx-3 shadow-l rounded-m bg-theme">
							<label for="form-1" class="disabled"></label>
							 
								  <select class="form-control req" name="assign_person[]" id="emp_id form-4" multiple> 
                                     <option value=""></option>
                                    <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_ID," - ",PBI_NAME)', $assign_person, '1'); ?>
                                </select>
								
									<style type="text/css">
										.select2{
											width: 100% !important;
										}
									</style>
								
							
							<span><i class="fa fa-chevron-down"></i></span>
						</div>
						
						
						<div class="row mb-0 mx-3">
							<div class="col-6 ps-0">
								<div class="input-style has-borders no-icon mb-4 shadow-l rounded-m bg-theme">
								
						 <label for="form-4" class="">From Date</label>
					<?php
				$selected_date = isset($_POST['s_date']) ? $_POST['s_date'] : '';
					?>

<input type="date" style="width:100%" name="s_date" class="form-control validate-text" value="<?= htmlspecialchars($selected_date); ?>" id="form-4">

									<span><i class="fa fa-chevron-down"></i></span>
								</div>
							</div>
							<div class="col-6 pe-0">
								<div class="input-style has-borders no-icon mb-4 shadow-l rounded-m bg-theme">
									<label for="form-4" class="">To Date</label>
			<?php
// Check if the form was submitted and set the date, otherwise use an empty value
$selected_end_date = isset($_POST['e_date']) ? $_POST['e_date'] : '';
?>

<input type="date" style="width:100%" name="e_date" class="form-control validate-text" value="<?= htmlspecialchars($selected_end_date); ?>" id="form-4">

									<span><i class="fa fa-chevron-down"></i></span>
								</div>
							</div>
						</div>
						
						
						
						<div class="row mb-0 mx-3">
						
						
							<div class="col-6 ps-0">
								<div class="input-style has-borders no-icon mb-4 shadow-l rounded-m bg-theme">
								
						 <label for="form-4" class="">Company Name</label>
						 							<?php
													// Check if form was submitted and get the selected company name
													$selected_company_name = isset($_POST['company_name']) ? $_POST['company_name'] : 'default';
													?>
						      <select class="form-control req" name="company_name" id="form4">
								<option value="default" disabled="" <?php echo ($selected_company_name == 'default') ? 'selected' : ''; ?>>Select a Company</option>
								
								<?php
								// Generate options dynamically from the database, with the selected company auto-selected
								foreign_relation('crm_project_org', 'id', 'name', $selected_company_name, '1');
								?>
							</select>
									<span><i class="fa fa-chevron-down"></i></span>
								</div>
							</div>
							
							




							
							
							
							<div class="col-6 pe-0">
								<div class="input-style has-borders no-icon mb-4 shadow-l rounded-m bg-theme">
									<label for="form-4" class="">Status</label>
									    <select class="form-control req" name="status" id="form4">
										<option selected="selected">Select a Status</option>
											<?=foreign_relation('deal_status','id','status','1');?>
										  </select>
									<span><i class="fa fa-chevron-down"></i></span>
								</div>
							</div>
						</div>
						
						
						
						
						<div class="card card-style shadow-l mx-3 mt-3 mb-0">
						
							<input type="submit"  name="showResult" class="btn btn-l btn-full bg-highlight font-700 text-uppercase"  value="Show Results" id="form-4">
							
						</div>
					</div>
					
				
		</div></div>
	


                         <?php   
						         
								 
								 if (isset($_POST['assign_person']) && is_array($_POST['assign_person'])) {
                                 $person_ids = $_POST['assign_person'];
								 $ffffff = implode(",", $person_ids);
									} else {
									
										$ffffff = ''; 
										
									}
								 
						
                                if($_POST['s_date']>0) $dateConn = " and date between '".$_POST['s_date']."' and '".$_POST['e_date']."'";
								if($_POST['company_name']>0) $comConn = " and project_id='".$_POST['company_name']."'";
                                if($_POST['status']>0) $statusConn = " and status='".$_POST['status']."'";
								if($_POST['assign_person']>0) $personCon = " and assign_person IN ($ffffff)";
								
								
								

                                $currentDateTime = date("Y-m-d H:i:s");
                                $sqlTasks = 'SELECT * FROM crm_lead_activity a 
								WHERE mode ="postsale"  '.$dateConn.$comConn.$statusConn.$personCon.'
								ORDER BY `activity_id` DESC;';
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
								
									
                                ?>
		
		<div class="card card-style mb-3">
			<a href="#" class="content">
			
			
			<div class="content">
          <!-- Button positioned at top right corner -->
          <div class="position-absolute top-0 end-0 mt-3 me-3">
            <button class="fa fa-edit color-brown-dark" data-menu="edittaskmodal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')"></button>
          </div>
          <h3>Task Name:
            <?=$row->subject;?>
          </h3>
          <p class="font-11 mt-n2 mb-0 opacity-50">Company Name:
            <?=find_a_field('crm_project_org', 'name', 'id = "'.$row->project_id.'"')?>
          </p>
          <div class="divider mb-3 mt-3"></div>
          <p class="mb-0">
            <?=$row->details;?>
          </p>
          <? if($row->status =='2'){ ?>
          <span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
          <? }elseif($row->status =='1'){ ?>
          <span class="badge bg-highlight color-white font-10 mt-2">PENDING</span>
          <? }else{ ?>
          <span class="badge bg-blue-dark color-white font-10 mt-2">CANCELLED</span>
          <?  } ?>
          <? if($row->priority_status == 'LOW'){ ?>
          <span class="badge bg-green-dark float-end ms-2 color-white font-10 mt-2">LOW</span>
          <? }elseif($row->priority_status == 'MEDIUM'){ ?>
          <span class="badge bg-blue-dark float-end ms-2 color-white font-10 mt-2">MEDIUM</span>
          <? }elseif($row->priority_status == 'HIGH'){ ?>
          <span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">HIGH</span>
          <? }else{ ?>
          <span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">No data</span>
          <?  } ?>
          <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
          <?  $ids = explode(',', $row->assign_person);
					    foreach ($ids as $id) {  ?>
          <span class="badge bg-blue-dark color-white font-10 mt-2">
          <?=find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "'.$id.'"')?>
          </span>
          <? }?>
          <!-- Feedback Section -->
          <div class="divider mt-3 mb-2"></div>
          <button class="btn btn-xxs btn-full mb-3 rounded-xl text-uppercase font-900 border-blue-dark color-blue-dark bg-theme" data-bs-toggle="collapse" href="#feedbackForm<?=$row->activity_id;?>" aria-expanded="false" 
                aria-controls="feedbackForm<?=$row->activity_id;?>"> Show Feedback </button>
          <div class="collapse mt-2" id="feedbackForm<?=$row->activity_id;?>">
            <?php 
						
						  // Fetch feedback for the current activity
							$activity_id = $row->activity_id;
							$sqlFeedback = "SELECT * FROM crm_lead_activity_feedback WHERE activity_id = $activity_id ORDER BY id DESC";
							$resultFeedback = db_query($sqlFeedback);
							
							while ($feedbackRow = mysqli_fetch_object($resultFeedback)) { ?>
            <!-- Left Chet-->
            <div class="d-flex">
              <div class="align-self-center"> <span class="font-11 ps-2 d-inline-block font-700 color-theme">
			 <?=find_a_field('user_activity_management','fname','user_id="'.$feedbackRow->entry_by.'"');?></span> <span class="font-9 ps-1 d-inline-block font-400 color-theme opacity-40">38 minutes ago</span>
                <div class="bg-theme shadow-m px-3 py-2 rounded-m">
                  <p class="lh-base mb-0 color-theme">
                    <?=$feedbackRow->feedback;?>
                  </p>
                </div>
              </div>
            </div>
            <?php } ?>
            <!-- End of Feedback Display -->
          </div>
          <!-- End of Feedback Section -->
          <div class="divider mt-3 mb-2"></div>
          <div class="row mb-n2 color-theme">
            <div class="col-6 font-10 text-start"> <i class="fa fa-clock pe-2"></i><? echo $formattedTime; ?> </div>
            <div class="col-6 font-10 text-end"> <i class="fa fa-calendar pe-2"></i><?php echo $day; ?> <?php echo strtolower($month);?> <span class="copyright-year"></span> </div>
          </div>
        </div>
				
				
				
			</a>
		</div>
		
		   <?php } ?>
		
		
		
		
		
		
		 </form>
		
		
		
		
		
		
		
		
		

        <div class="footer card card-style">
         
            <p class="footer-links"><a href="#" class="color-highlight">Privacy Policy</a> | <a href="#" class="color-highlight">Terms and Conditions</a> | <a href="#" class="back-to-top color-highlight"> Back to Top</a></p>
            <div class="clear"></div>
        </div>

    </div>
    <!-- End of Page Content-->

	<!-- Menu Filters-->
	
	
	
	<!--UPDATE -->
	<!-- Edit Task Modal -->
<div id="edittaskmodal" class="menu menu-box-modal menu-box-detached">
  <div class="menu-title">
    <h1>Edit Task</h1>
    <p class="color-highlight">Edit Task Details</p>
    <a href="#" class="close-menu"><i class="fa fa-times"></i></a> </div>
  <div class="divider divider-margins mt-3 mb-2"></div>
  <div class="content px-1">
    <form method="post" action="">
      <input type="hidden" name="activity_id" id="activity_id" value="<?=$activity_id?>" />
      <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
      <input type="hidden" name="activity_type" value="Task" />
      <input type="hidden" name="main" value="1" />
      <input type="hidden" name="mode" value="postsale" />
     
      <div class="col-12">
        <div class="input-style has-borders no-icon mb-4 input-style-active">
          <label for="meeting_type" class="color-highlight">Task Status</label>
          <select class="form-control req" name="status" id="status">
            <option></option>
            <?=foreign_relation('deal_status','id','status','1');?>
          </select>
          <span class="disabled"><i class="fa fa-chevron-down"></i></span> <i class="fa fa-check valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
      </div>
      <div class="input-style has-borders no-icon mb-4 input-style-active">
        <label for="priority_status_edit" class="color-highlight">Priority Type</label>
        <select class="form-control req" name="priority_status" id="priority_status_edit" required>
          <option value="LOW">LOW</option>
          <option value="MEDIUM">MEDIUM</option>
          <option value="HIGH">HIGH</option>
        </select>
        <span class="disabled"><i class="fa fa-chevron-down"></i></span> <i class="fa fa-check valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
      
      <div class="input-style has-borders no-icon mb-4">
        <textarea id="form7" name="meeting_feedback" placeholder="Task Feedback"></textarea>
        <label for="form7" class="color-highlight">Task Feedback</label>
      </div>
      <button type="submit" name="UpdateTaskActivity" id="UpdateTaskActivity" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Confirm</button>
    </form>
  </div>
</div>

 <? require_once '../assets/template/inc.footer.php'; ?>