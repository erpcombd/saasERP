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
$title = "Task Management";
$cid = $_SESSION['proj_id'];
$user_id	=$_SESSION['user_id'];
require_once '../assets/template/inc.header.php';
?>
<? 
//echo $u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];
$u_id  =  $_SESSION['user']['id'];
 $PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$PBI_ID.'"');



// ::::: Edit This Section ::::: 
$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);
do_calander('#date');

 $cur = '&#x9f3;';

 $table1 = 'crm_project_lead';
 $tablecontact = 'crm_lead_contacts';
 $tableproductadd = 'crm_lead_product_individual';

 $uniqueproduct="product_individual_id";



 $crudcontact1 = new crud($tablecontact);
 $crudproductadd1 = new crud($tableproductadd);

$pbi_id  =  $_SESSION['employee_selected'];
$user_role  =  $_SESSION['user']['fname'];


 $table2 = 'crm_task_lists';


 $id = 10; //decrypTS($_GET['view']);
 $orgId=find_a_field('crm_project_lead','organization','id="'.$id.'"');

 $qryrr = "SELECT * FROM crm_project_org WHERE id = '$orgId'";

 $rsltrr = db_query($qryrr);
 $rows = mysqli_fetch_object($rsltrr);
 $orgname=$rows->name;

$type = decrypTS($_GET['tp']);

$condition="id=".$id;
$data=db_fetch_object('crm_project_lead',$condition);
foreach($data as $key=>$value)
{ $$key=$value;}


if(isset($_POST['submit']))
{
$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudcontact1->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
}
if(isset($_POST['productadd']))
{

$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudproductadd1->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';

        echo "<script>window.top.location='../file/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

 
}

if (isset($_POST['scCall'])) {

    $person_ids = $_POST['person_ids'];
    $_POST['assign_person'] = implode(",", $person_ids);
    $crud   = new crud('crm_lead_activity');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();
    echo "<script>window.top.location='../file/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

}



$tablSchedule='hrm_roster_allocation';		
$crudschedule    =new crud($tablSchedule);		

if(isset($_POST['insertSchedule']))
{       
        $roster_date = $_POST['roster_date'];
        $pbi_id = $_POST['PBI_ID'];
        mysqli_query($conn, "DELETE FROM hrm_roster_allocation WHERE roster_date = '$roster_date' AND PBI_ID = '$pbi_id'");
        $_POST['entry_at']= date('Y-m-d H:i:s');
        $_POST['entry_by']=$_SESSION['user']['id'];
		$crudschedule->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
      
}






if(isset($_POST['updatecontact']))
{


$_POST['edit_at']=time();
$_POST['edit_by']=$_SESSION['user']['id'];
		$crudcontact1->update('id');
		$type=1;
		$msg='Successfully Updated.';
        echo "<script>window.top.location='../file/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}


if(isset($_POST['updateTasks']))
{

    $crud   = new crud('crm_task_add_information');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('task_id');
		$type=1;
		$msg='Successfully Updated.';
         echo "<script>window.top.location='../file/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}



if(isset($_POST['updatestatus']))
{
    $crud= new crud('crm_project_lead');
    $crud->update('id');
  
}


if(isset($_POST['cancelActivity']))
{

    $crud   = new crud('crm_lead_activity');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('activity_id');
		$type=1;
		$msg='Successfully Updated.';
         echo "<script>window.top.location='../file/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}

if(isset($_POST['deleteproduct']))
{
       
        $product_individual_id = $_POST['product_individual_id'];

        
        $deletesql = "DELETE FROM crm_lead_product_individual WHERE product_individual_id = " . $product_individual_id;
        db_query($deletesql);
        $tr_type = "Delete";
        $type = 1;
        $msg = 'Successfully Deleted.';
        echo "<script>window.top.location='../file/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

}

$tabletask='crm_lead_activity';		
$crudtask    =new crud($tabletask);		

if(isset($_POST['insertTasks']))
{

        $person_ids = $_POST['person_ids'];
 
        $_POST['assign_person'] = implode(",", $person_ids);

        $_POST['entry_at']= date('Y-m-d H:i:s');
        $_POST['entry_by']=$_SESSION['user']['id'];
		$crudtask->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
        echo "<script>window.top.location='../file/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";


}


/* __________  UPDATE DAILY ACTIVITYS ____________*/

if(isset($_POST['UpdateTaskActivity']))
{

        $crud   = new crud('crm_lead_activity');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('activity_id');
		$type=1;
		$msg='Successfully Updated.';
         echo "<script>window.top.location='../file/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}


/* __________ ALL METTING FEEDBACK_____ UPDATE DAILY ACTIVITYS ____________*/

if (isset($_POST['meeting_feedback']) && !empty(trim($_POST['meeting_feedback']))) {

	$crud   = new crud('crm_lead_activity_feedback');
	$_POST['activity_id'] = $_POST['activity_id'];
	$_POST['feedback']  = $_POST['meeting_feedback'];
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();
    echo "<script>window.top.location='../file/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

}



?>
<style>
/*custom CSS*/
	.card-style{
		background-color: #fff !important;
		border-radius: 10px !important;
	}
/*Status Color CSS*/
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
/*btn width CSS*/
	.width-100{
		width:100%;
	}






</style>
<div class="page-content header-clear-medium">
  <div class="tab-group-1">
    <div class="card card-style">
      <div class="content mb-0">
        <div class="ms-auto float-end"> <a href="#" data-menu="schedule" class="icon icon-xxl bg-theme gradient-red color-white shadow-l rounded-m"><i class="fa fa-clock"></i></a> <span class="font-11 font-500 color-theme d-block">
          <center>
            Schedule
          </center>
          </span> </div>
        <div class="ms-auto float-end">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <div class="ms-auto float-end"> <a href="task_details_entry.php"  class="icon icon-xxl bg-theme gradient-green color-white shadow-l rounded-m"><i class="fa fa-plus"></i></a> <span class="font-11 font-500 color-theme d-block">
          <center>
            Task
          </center>
          </span> </div>
        <div class="ms-auto float-end">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <!--<div class="ms-auto float-end"> <a href="#" data-menu="schedulemeeting" class="icon icon-xxl bg-theme gradient-red color-white shadow-l rounded-m"><i class="fa fa-calendar"></i></a> <span class="font-11 font-500 color-theme d-block">
          <center>
            Metting Mod
          </center>
          </span> </div>-->
		  
		  <div class="ms-auto float-end"> <a href="meeting_details_entry.php" class="icon icon-xxl bg-theme gradient-red color-white shadow-l rounded-m"><i class="fa fa-calendar"></i></a> <span class="font-11 font-500 color-theme d-block">
          <center>
            Meeting
          </center>
          </span> </div>
		  
		  
<!--        <h3> Activities (Post-Sale)</h3>
        <p> Sort Your Daily Activities. </p>
        <div class="divider mb-0"></div>-->
      </div>
      <div class="tab-controls content tabs-small tabs-rounded" data-highlight="bg-blue-dark"> <a href="#" data-active data-bs-toggle="collapse" data-bs-target="#tab-1">All</a> <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-2">COMPLETE</a> <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-3">PENDING</a> <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-4">CANCELLED</a>
        <!--<a href="#" data-bs-toggle="collapse" data-bs-target="#tab-5">Email</a>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-6">Task</a>-->
      </div>
    </div>
	
	
	
	
	
    <div class="content" id="tab-group-1">
      <!-- All Tab -->
                    <?php
                                $currentDateTime = date("Y-m-d H:i:s");
								
								  
								  $user_id = $basic->PBI_ID;
								  
                         

					
                                 $sqlTasks = "SELECT * FROM crm_lead_activity a 
								WHERE FIND_IN_SET('$user_id', assign_person) AND status != 3 and mode ='postsale' ORDER BY `activity_id` DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
									
                                ?>
      <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1"> <div class="card mx-0 card-style">
        <div class="content">
          <!-- Button positioned at top right corner -->
          <div class="position-absolute top-0 end-0 mt-3 me-3">
		  	<? if($row->status !=''){?>
            	<button class="fa fa-edit color-brown-dark" data-menu="edittaskmodal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')"></button>
			<? } ?>
          </div>
          <h3><?=$row->activity_type;?> Name: <!--Task Name:-->
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
		  <div class="d-flex">
		  	<?php if($row->activity_type == "Meeting"){?>
				<a  href="meeting_details_print.php?met_id=<?=$row->activity_id;?>" target="_blank">
				<button class="btn btn-xxs btn-full mb-2 me-2 rounded-xl text-uppercase font-900 border-blue-dark color-blue-dark bg-theme"> Print View </button>
				</a>
			<? } ?>
          <button class="btn btn-xxs btn-full mb-2 rounded-xl text-uppercase font-900 border-blue-dark color-blue-dark bg-theme" data-bs-toggle="collapse" href="#feedbackForm<?=$row->activity_id;?>" aria-expanded="false" 
                aria-controls="feedbackForm<?=$row->activity_id;?>"> Show Feedback</button>

			<?php if($row->status ==''){?>
				<a  href="meeting_details_entry.php?met_id=<?=$row->activity_id;?>" target="_blank">
				<button class="btn btn-xxs btn-full mb-2 ms-2 rounded-xl text-uppercase font-900 border-red-dark color-red-dark bg-theme"> Edit Meeting </button>
				</a>
			<? } ?>
				
		  
		  </div>

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
        </div> </div>
      <?php } ?>
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
      <!--  COMPLETE Tab -->
	  
	  
	  
<?php
$currentDateTime = date("Y-m-d H:i:s");
  $user_id = $basic->PBI_ID;
								  

$sqlTasks = "SELECT * FROM crm_lead_activity a WHERE FIND_IN_SET('$user_id', assign_person) AND status = '2' and mode ='postsale' ORDER BY activity_id DESC;";
$resultTasks = db_query($sqlTasks);

// Check if there are any rows returned by the query
if (mysqli_num_rows($resultTasks) > 0) {
    // Loop through the results and display each task
    while ($row = mysqli_fetch_object($resultTasks)) {
        $task_date = $row->date;
        $day = date('d', strtotime($task_date));
        $month = date('M', strtotime($task_date));
        $formattedTime = date('h:i A', strtotime($row->time));
        ?>
        <div data-bs-parent="#tab-group-1" class="collapse" id="tab-2">
            <a href="#" class="card mx-0 card-style">
                <div class="content">
                    <div class="position-absolute top-0 end-0 mt-3 me-3">
                        <button class="fa fa-edit color-brown-dark" data-menu="edittaskmodal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')"></button>
                    </div>
                    <h3>Task Name: <?=$row->subject;?></h3>
                    <p class="font-11 mt-n2 mb-0 opacity-50">1/25 Tasks Completed</p>
                    <div class="divider mb-3 mt-3"></div>
                    <p class="mb-0"><?=$row->details;?></p>
                    <?php if ($row->status == '2') { ?>
                        <span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
                    <?php } elseif ($row->status == '1') { ?>
                        <span class="badge bg-highlight color-white font-10 mt-2">PENDING</span>
                    <?php } else { ?>
                        <span class="badge bg-blue-dark color-white font-10 mt-2">CANCELLED</span>
                    <?php } ?>
                    <?php if ($row->priority_status == 'LOW') { ?>
                        <span class="badge bg-green-dark float-end ms-2 color-white font-10 mt-2">LOW</span>
                    <?php } elseif ($row->priority_status == 'MEDIUM') { ?>
                        <span class="badge bg-blue-dark float-end ms-2 color-white font-10 mt-2">MEDIUM</span>
                    <?php } elseif ($row->priority_status == 'HIGH') { ?>
                        <span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">HIGH</span>
                    <?php } else { ?>
                        <span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">No data</span>
                    <?php } ?>
                    <div class="row mb-n2 color-theme">
                        <div class="col-6 font-10 text-start">
                            <i class="fa fa-clock pe-2"></i><?php echo $formattedTime; ?>
                        </div>
                        <div class="col-6 font-10 text-end">
                            <i class="fa fa-calendar pe-2"></i><?php echo $day; ?> <?php echo strtolower($month);?> <span class="copyright-year"></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
    }
} else {
    // Display a card with "No data found" message if there are no results
    ?>
    <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-2">
        <a href="#" class="card mx-0 card-style">
            <div class="content">
                <h3>No data found</h3>
                <p class="mb-0">There are no tasks to display at this time.</p>
            </div>
        </a>
    </div>
    <?php
}
?>

      <!-- PENDING  Tab -->
     <?php
$currentDateTime = date("Y-m-d H:i:s");
$user_id = $basic->PBI_ID;


$sqlTasks = "SELECT * FROM crm_lead_activity a WHERE FIND_IN_SET('$user_id', assign_person) AND status = '1' and mode ='postsale' ORDER BY activity_id DESC;";
$resultTasks = db_query($sqlTasks);

// Check if there are any rows returned by the query
if (mysqli_num_rows($resultTasks) > 0) {
    // Loop through the results and display each task
    while ($row = mysqli_fetch_object($resultTasks)) {
        $task_date = $row->date;
        $day = date('d', strtotime($task_date));
        $month = date('M', strtotime($task_date));
        $formattedTime = date('h:i A', strtotime($row->time));
        ?>
        <div data-bs-parent="#tab-group-1" class="collapse" id="tab-3">
            <a href="#" class="card mx-0 card-style">
                <div class="content">
                    <div class="position-absolute top-0 end-0 mt-3 me-3">
                        <button class="fa fa-edit color-brown-dark" data-menu="edittaskmodal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')"></button>
                    </div>
                    <h3>Task Name: <?=$row->subject;?></h3>
                    <p class="font-11 mt-n2 mb-0 opacity-50">3/25 Tasks Completed</p>
                    <p class="mb-0"><?=$row->details;?></p>
                    <?php if ($row->status == '2') { ?>
                        <span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
                    <?php } elseif ($row->status == '1') { ?>
                        <span class="badge bg-highlight color-white font-10 mt-2">PENDING</span>
                    <?php } else { ?>
                        <span class="badge bg-blue-dark color-white font-10 mt-2">CANCELLED</span>
                    <?php } ?>
                    <?php if ($row->priority_status == 'LOW') { ?>
                        <span class="badge bg-green-dark float-end ms-2 color-white font-10 mt-2">LOW</span>
                    <?php } elseif ($row->priority_status == 'MEDIUM') { ?>
                        <span class="badge bg-blue-dark float-end ms-2 color-white font-10 mt-2">MEDIUM</span>
                    <?php } elseif ($row->priority_status == 'HIGH') { ?>
                        <span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">HIGH</span>
                    <?php } else { ?>
                        <span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">No data</span>
                    <?php } ?>
                    <div class="row mb-n2 color-theme">
                        <div class="col-6 font-10 text-start">
                            <i class="fa fa-clock pe-2"></i><?php echo $formattedTime; ?>
                        </div>
                        <div class="col-6 font-10 text-end">
                            <i class="fa fa-calendar pe-2"></i><?php echo $day; ?> <?php echo strtolower($month);?> <span class="copyright-year"></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
    }
} else {
    // Display a card with "No data found" message if there are no results
    ?>
    <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-3">
        <a href="#" class="card mx-0 card-style">
            <div class="content">
                <h3>No data found</h3>
                <p class="mb-0">There are no tasks to display at this time.</p>
            </div>
        </a>
    </div>
    <?php
}
?>

      <!-- CANCELLED Tab -->
      <?php
									$currentDateTime = date("Y-m-d H:i:s");
									
								  $user_id = $basic->PBI_ID;
								 
								  
									$sqlTasks = "SELECT * FROM crm_lead_activity a WHERE FIND_IN_SET('$user_id', assign_person) AND 
									status = '3' and mode ='postsale' ORDER BY activity_id DESC;";
									$resultTasks = db_query($sqlTasks);
									
									while ($row = mysqli_fetch_object($resultTasks)) {
									$task_date = $row->date;
								
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
									?>
      <div data-bs-parent="#tab-group-1" class="collapse" id="tab-4"> <a href="#" class="card mx-0 card-style">
        <div class="content">
          <!-- Button positioned at top right corner -->
          <div class="position-absolute top-0 end-0 mt-3 me-3">
            <button class="fa fa-edit color-brown-dark" data-menu="edittaskmodal" onclick="openModalcancelmeeting('<?=$row->activity_id;?>')"></button>
          </div>
          <h3>Task Name:
            <?=$row->subject;?>
          </h3>
          <p class="font-11 mt-n2 mb-0 opacity-50">3/25 Tasks Completed</p>
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
          <div class="divider mb-3 mt-3"></div>
          <!--                                <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
                                <img src="../images/empty.png" data-src="../images/pictures/faces/3s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/1s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/2s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">-->
          <div class="divider mt-3 mb-2"></div>
          <div class="row mb-n2 color-theme">
            <div class="col-6 font-10 text-start"> <i class="fa fa-clock pe-2"></i><? echo $formattedTime; ?> </div>
            <div class="col-6 font-10 text-end"> <i class="fa fa-calendar pe-2"></i><?php echo $day; ?> <?php echo strtolower($month);?><span class="copyright-year"></span> </div>
          </div>
        </div>
        </a> </div>
      <?php } ?>
    </div>
  </div>
  <div class="footer card card-style mt-0">
    <p class="footer-links"><a href="#" class="color-highlight">Privacy Policy</a> | <a href="#" class="color-highlight">Terms and Conditions</a> | <a href="#" class="back-to-top color-highlight"> Back to Top</a></p>
    <div class="clear"></div>
  </div>
</div>
<!-- End of Page Content-->
<!-- All Menus, Action Sheets, Modals, Notifications, Toasts, Snackbars get Placed outside the <div class="page-content"> -->
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
<!-- Request Meeting  ---- -->
<div id="schedulemeeting" class="menu menu-box-bottom menu-box-detached">
  <div class="menu-title">
    <h1>Schedule a Meeting</h1>
    <p class="color-highlight"> Enter Meeting Details</p>
    <a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
  <div class="divider divider-margins mt-3 mb-2"></div>
  <div class="content px-1">
    <form method="post" action="">
      <div class="row mb-0">
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form5" class="color-highlight">Meeting type:</label>
            <input type="hidden" name="mode" value="postsale"/>
            <input type="hidden" name="activity_type" value="Meeting" />
            <input type="hidden" name="status" value="1" />
            <input type="hidden" name="main" value="1" />
            <select class="form-control req" name="meeting_type" id="form5" required>
              <option value="default" disabled="" selected="">Select a Value</option>
              <option value="Online">Online </option>
              <option value="Offline">Offline</option>
            </select>
            <span class="disabled"><i class="fa fa-chevron-down"></i></span> <i class="fa fa-check valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
        </div>
        <div class="col-6">
          <div class="input-style has-borders input-style-always-active has-icon validate-field mb-4"> <i class="color-red-dark fa fa-map-marker-alt"></i>
            <select class="form-control req" name="project_id" id="form5">
              <option value=""></option>
              <? foreign_relation('crm_project_org','id','name',$project_id,'1'); ?>
            </select>
            <label for="point_1" class="color-blue-dark">Project Name</label>
            <i class="fa fa-times disabled invalid color-red-dark"></i> <i class="fa fa-check disabled valid color-green-dark"></i> </div>
        </div>
      </div>
      <h5 class="mb-2 font-15 mt-2">Meeting</h5>
      <div class="row mb-0">
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form6" class="color-highlight text-uppercase font-700 font-10 mt-1">Meeting Time</label>
            <input type="time"  name="time" class="form-control validate-text" id="form6">
          </div>
        </div>
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form-6" class="color-blue-dark text-uppercase font-700 font-10 mt-1">Meeting Date</label>
            <input type="date" style="width:100%" name="date" class="form-control validate-text" id="form-6">
          </div>
        </div>
      </div>
      <div class="row mb-0">
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4">
            <input type="text" id="form7" name="location" placeholder="Meeting location">
            <label for="form7" class="color-highlight">Meeting location</label>
          </div>
        </div>
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4">
            <input type="text" id="subject" name="subject" placeholder="Meeting Subject">
            <label for="form7" class="color-highlight">Meeting Subject</label>
          </div>
        </div>
      </div>
      <div class="row mb-0">
        <!-- Opening div.row -->
        <div class="col-12">
          <!-- Opening div.col-6 -->
          <div class="">
            <!-- Opening div.input-style -->
            <label for="emp_id" class="color-highlight text-uppercase font-700 font-10 mt-1">Person Name</label>
            <select class="form-control req" name="person_ids[]" id="emp_id" multiple >
              <option value=""></option>
              <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_ID," - ",PBI_NAME)', $assign_person, '1'); ?>
            </select>
          </div>
          <!-- Closing div.input-style -->
        </div>
        <!-- Closing div.col-6 -->
        <style type="text/css">
							.select2{
							    width: 100% !important;
							}
						</style>
        <em></em> </div>
      <br />
      <div class="input-style has-borders no-icon mb-4">
        <input type="text" name="details" class="form-control validate-text" id="form-4">
        <label for="form7" class="color-highlight">Details</label>
      </div>
      <!-- Reminder Section -->
      <div class="list-group list-custom-small list-icon-0 ">
        <!-- Opening div.list-group -->
        <a data-bs-toggle="collapse" class="no-effect collapsed no-border" href="#reminderCollapse" aria-expanded="false" aria-controls="reminderCollapse"> <i class="fa-solid font-14 fa-bell color-yellow-dark"></i> <span class="font-14">Reminder</span> <i class="fa fa-angle-down"></i> </a>
        </h5>
      </div>
      <div class="collapse" id="reminderCollapse">
        <div class="row mb-0">
          <div class="col-6">
            <div class="input-style has-borders no-icon mb-4 input-style-active">
              <label for="form-6" class="color-blue-dark text-uppercase font-700 font-10 mt-1">Reminder Date</label>
              <input type="date" style="width:100%" name="remainder_date" class="form-control validate-text" id="form-6">
            </div>
          </div>
          <div class="col-6">
            <div class="input-style has-borders input-style-always-active has-icon validate-field mb-4"> <i class="color-green-dark fa fa-calendar-alt"></i>
              <select class="form-control validate-text" name="priority_status" id="form5" required>
                <option value="LOW"> <span class="flag flag-low">LOW</span> </option>
                <option value="MEDIUM"> <span class="flag flag-medium">MEDIUM</span> </option>
                <option value="HIGH"> <span class="flag flag-high">HIGH</span> </option>
              </select>
              <label for="shedule_1" class="color-blue-dark">Priority</label>
              <i class="fa fa-times disabled invalid color-red-dark"></i> <i class="fa fa-check disabled valid color-green-dark"></i> </div>
          </div>
        </div>
      </div>
      <button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100"> Confirm </button>
    </form>
  </div>
</div>
<!-- Request Schedule  ---- -->
<div id="schedule" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="320">
        <div class="menu-title">
            <h1>Create Schedule</h1>
            <a href="#" class="close-menu mt-n2"><i class="fa fa-times font-16"></i></a>
        </div>
        <div class="divider divider-margins mt-3"></div>
        <div class="content">
		      <form method="post" action="">
				<div class="row mb-0 mt-4">
					<div class="col-6">
					<!--	<div class="input-style has-borders input-style-always-active has-icon validate-field mb-4">-->
							<label for="PBI_ID" class="color-blue-dark">Name</label>
							<input type="text" list="eip_ids" name="PBI_ID" class="form-control req" id="PBI_ID"/>
							<datalist id="eip_ids">
								<option></option>
								<?php
									foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_ID," - ",PBI_NAME)', $PBI_ID, '1');
								?>
							</datalist>
							
							<!--<i class="fa fa-times disabled invalid color-red-dark"></i>
							<i class="fa fa-check disabled valid color-green-dark"></i>-->
						<!--</div>-->
					</div>
					<div class="col-6">

							<!--<div class="input-style has-borders no-icon mb-4 input-style-active">-->
								<label for="form-6" class="color-blue-dark text-uppercase font-700 font-10 ">Schedule Date</label>
								<input type="date" style="width:100%" name="roster_date" class="form-control validate-text" id="form-6">
							<!--</div>-->
						
						
					</div>
				</div>

	
			
					<div class="row mb-0 mt-4">
						<div class="col-6">
							<!--<div class="input-style has-borders input-style-always-active has-icon validate-field mb-4">-->
							<label for="shedule_1" class="color-blue-dark">Duty Schedule</label>
								<select name="shedule_1" id="shedule_1" class="form-control validate-text">
									<option></option>
									<?php foreign_relation('hrm_schedule_info', 'id', 'schedule_name', $shedule_1, '1'); ?>
								</select>
								
								<!--<i class="fa fa-times disabled invalid color-red-dark"></i>
								<i class="fa fa-check disabled valid color-green-dark"></i>
								<em>(required)</em>
							</div>-->
						</div>
					
						<div class="col-6">
							<!--<div class="input-style has-borders input-style-always-active has-icon validate-field mb-4">
								<i class="color-red-dark fa fa-map-marker-alt"></i>-->
								<label for="point_1" class="color-blue-dark">Select Project</label>
								<select name="point_1" id="point_1" class="form-control validate-text">
									<option></option>
									<?php foreign_relation('crm_project_org', 'id', 'name', $point_1, '1'); ?>
									
									
									
								</select>
								
								<!--<i class="fa fa-times disabled invalid color-red-dark"></i>
								<i class="fa fa-check disabled valid color-green-dark"></i>
								<em>(required)</em>
							</div>-->
						</div>
					</div>

	<button type="submit" name="insertSchedule" class="close-menu btn btn-m text-uppercase font-700 btn-full bg-blue-dark rounded-sm mt-4 mb-4"> Confirm </button>
			
			
				</form>
        </div>
    </div>
	
	
	
	
<?php /*?><div id="schedule" class="menu menu-box-bottom menu-box-detached">
  <div class="menu-title">
    <h1>Make a Schedule</h1>
    <p class="color-highlight"> Enter Schedule Details</p>
    <a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
  <div class="divider divider-margins mt-3 mb-2"></div>
  <div class="content px-1">
    <form method="post" action="">
      <h5 class="mb-2 font-15 mt-2">Schedule</h5>
      <div class="row mb-0">
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form6" class="color-highlight text-uppercase font-700 font-10 mt-1">Start Date</label>
            <input type="date" style="width:100%"  name="date" class="form-control validate-text" id="form6">
          </div>
        </div>
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form6" class="color-highlight text-uppercase font-700 font-10 mt-1">End Date</label>
            <input type="date" style="width:100%"  name="date" class="form-control validate-text" id="form6">
          </div>
        </div>
      </div>
      <div class="row mb-0">
        <!-- Opening div.row -->
        <div class="col-12">
          <!-- Opening div.col-6 -->
          <div class="">
            <!-- Opening div.input-style -->
            <label for="emp_id" class="color-highlight text-uppercase font-700 font-10 mt-1">Person Name</label>
            <select class="form-control req" name="person_ids[]" id="emp_id" multiple >
              <option value=""></option>
              <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_ID," - ",PBI_NAME)', $assign_person, '1'); ?>
            </select>
          </div>
          <!-- Closing div.input-style -->
        </div>
        <!-- Closing div.col-6 -->
        <style type="text/css">
							.select2{
							    width: 100% !important;
							}
						</style>
        <em></em> </div>
      <br />
      <div class="input-style has-borders no-icon mb-4">
        <label for="form5" class="color-highlight">Customer</label>
        <select class="form-control req" name="project_id" id="form5">
          <option value=""></option>
          <? foreign_relation('crm_project_org','id','name',$project_id,'1'); ?>
        </select>
        <span class="disabled"><i class="fa fa-chevron-down"></i></span> <i class="fa fa-check valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
      <div class="input-style has-borders no-icon mb-4">
        <label for="form5" class="color-highlight">Customer</label>
        <select class="form-control req" name="project_id" id="form5">
          <option value=""></option>
          <? foreign_relation('crm_project_org','id','name',$project_id,'1'); ?>
        </select>
        <span class="disabled"><i class="fa fa-chevron-down"></i></span> <i class="fa fa-check valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
      <button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100"> Confirm </button>
    </form>
  </div>
</div><?php */?>



<!-- Request Task  ---- -->
<div id="scheduletask" class="menu menu-box-bottom menu-box-detached">
  <div class="menu-title">
    <h1>Schedule a Task</h1>
    <p class="color-highlight"> Enter Task Details</p>
    <a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
  <div class="divider divider-margins mt-3 mb-2"></div>
  <div class="content px-1">
    <form method="post" action="">
      <div class="input-style has-borders no-icon mb-4">
        <input type="hidden" name="mode" value="postsale"/>
        <input type="hidden" name="activity_type" value="Meeting" />
        <input type="hidden" name="status" value="1"/>
        <Input type="text" id="form7" name="subject" placeholder="Task Name">
        <label for="form7" class="color-highlight">Task Name</label>
      </div>
      <div class="input-style has-borders no-icon mb-4">
        <Input type="text" id="form7" name="details" placeholder="Task Details">
        <label for="form7" class="color-highlight">Task Details</label>
      </div>
      <div class="row mb-0">
        <!-- Opening div.row -->
        <div class="col-12">
          <!-- Opening div.col-6 -->
          <div class="">
            <!-- Opening div.input-style -->
			
			
			  <label for="emp_id" class="color-highlight text-uppercase font-700 font-10 mt-1">Person Name</label>
            <select class="form-control req" name="person_ids[]" id="emp_id" multiple >
              <option value=""></option>
              <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_ID," - ",PBI_NAME)', $assign_person, '1'); ?>
            </select>
          </div>
          <!-- Closing div.input-style -->
        </div>
        <!-- Closing div.col-6 -->
        <style type="text/css">
							.select2{
							    width: 100% !important;
							}
						</style>
        <em></em> </div>
      <br />
	
      <div class="input-style has-borders input-style-always-active has-icon validate-field mb-4"> <i class="color-red-dark fa fa-map-marker-alt"></i>
        <select class="form-control req" name="project_id" id="form5">
          <option value=""></option>
          <? foreign_relation('crm_project_org','id','name',$project_id,'1'); ?>
        </select>
        <label for="point_1" class="color-blue-dark">Project Name</label>
        <i class="fa fa-times disabled invalid color-red-dark"></i> <i class="fa fa-check disabled valid color-green-dark"></i> </div>
      <h5 class="mb-2 font-15 mt-2">Task Date & Deadline</h5>
      <div class="row mb-0">
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form-6" class="color-blue-dark text-uppercase font-700 font-10 mt-1">Task Date</label>
            <input type="date" style="width:100%" name="date" class="form-control validate-text" id="form-6">
          </div>
        </div>
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form-6" class="color-blue-dark text-uppercase font-700 font-10 mt-1">Deadline</label>
            <input type="date" style="width:100%" name="deadline" class="form-control validate-text" id="form-6">
          </div>
        </div>
      </div>
      <!-- Reminder Section -->
      <div class="list-group list-custom-small list-icon-0 ">
        <!-- Opening div.list-group -->
        <a data-bs-toggle="collapse" class="no-effect collapsed no-border" href="#reminderCollapse" aria-expanded="false" aria-controls="reminderCollapse"> <i class="fa-solid font-14 fa-bell color-yellow-dark"></i> <span class="font-14">Reminder</span> <i class="fa fa-angle-down"></i> </a>
        </h5>
      </div>
      <div class="collapse" id="reminderCollapse">
        <div class="row mb-0">
          <div class="col-6">
            <div class="input-style has-borders no-icon mb-4 input-style-active">
              <label for="form-6" class="color-blue-dark text-uppercase font-700 font-10 mt-1">Reminder</label>
              <input type="date" style="width:100%" name="remainder_date" class="form-control validate-text" id="form-6">
            </div>
          </div>
          <div class="col-6">
            <div class="input-style has-borders input-style-always-active has-icon validate-field mb-4"> <i class="color-green-dark fa fa-calendar-alt"></i>
              <select class="form-control validate-text" name="priority_status" id="form5" required>
                <option value="LOW"> <span class="flag flag-low">LOW</span> </option>
                <option value="MEDIUM"> <span class="flag flag-medium">MEDIUM</span> </option>
                <option value="HIGH"> <span class="flag flag-high">HIGH</span> </option>
              </select>
              <label for="shedule_1" class="color-blue-dark">Priority</label>
              <i class="fa fa-times disabled invalid color-red-dark"></i> <i class="fa fa-check disabled valid color-green-dark"></i> </div>
          </div>
        </div>
      </div>
      <button type="submit" name="insertTasks" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100"> Confirm </button>
    </form>
  </div>
</div>
<!-- Request Email  ---- -->
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
      <input type="hidden" name="activity_type" value="Meeting" />
      <input type="hidden" name="main" value="1" />
      <input type="hidden" name="mode" value="postsale" />
      <!--            <div class="input-style has-borders no-icon mb-4">
                <input type="text" id="task_name_edit" name="subject" placeholder="Task Name">
                <label for="task_name_edit" class="color-highlight">Task Name</label>
            </div>

            <div class="input-style has-borders no-icon mb-4">
                <textarea id="task_details_edit" name="details" placeholder="Task Details"></textarea>
                <label for="task_details_edit" class="color-highlight">Task Details</label>
            </div>-->
      <div class="col-12">
        <div class="input-style has-borders no-icon mb-4 input-style-active">
          <label for="meeting_type" class="color-highlight">TAsk Status</label>
          <select class="form-control req" name="status" id="status">
            <option></option>
            <?=foreign_relation('lead_status','id','status','1');?>
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
      <!-- <h5 class="mb-2 font-15 mt-2">Task</h5>
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
            </div>-->
      <div class="input-style has-borders no-icon mb-4">
        <textarea id="form7" name="meeting_feedback" placeholder="Task Feedback"></textarea>
        <label for="form7" class="color-highlight">Task Feedback</label>
      </div>
      <button type="submit" name="UpdateTaskActivity" id="UpdateTaskActivity" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Confirm</button>
    </form>
  </div>
</div>
 <? require_once '../assets/template/inc.footer.php';
   selected_two('#point_1');
 
 
  ?>