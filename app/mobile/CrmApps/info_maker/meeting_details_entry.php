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
$user_id	=$_SESSION['user_id'];
require_once '../assets/template/inc.header.php';
?>
<? 
//echo $u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];
$u_id  =  $_SESSION['user']['id'];
 $PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$PBI_ID.'"');



// ::::: Edit This Section ::::: 
$title = "Lead Info";
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

        echo "<script>window.top.location='../info_maker/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

 
}

if (isset($_POST['scCall'])) {

    $person_ids = $_POST['person_ids'];
    $_POST['assign_person'] = implode(",", $person_ids);
    $crud   = new crud('crm_lead_activity');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();
    echo "<script>window.top.location='../info_maker/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

}



$tablSchedule='hrm_roster_allocation';		
$crudschedule    =new crud($tablSchedule);		

if(isset($_POST['insertSchedule']))
{


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
        echo "<script>window.top.location='../info_maker/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}


if(isset($_POST['updateTasks']))
{

    $crud   = new crud('crm_task_add_information');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('task_id');
		$type=1;
		$msg='Successfully Updated.';
         echo "<script>window.top.location='../info_maker/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
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
         echo "<script>window.top.location='../info_maker/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}

if(isset($_POST['deleteproduct']))
{
       
        $product_individual_id = $_POST['product_individual_id'];

        
        $deletesql = "DELETE FROM crm_lead_product_individual WHERE product_individual_id = " . $product_individual_id;
        db_query($deletesql);
        $tr_type = "Delete";
        $type = 1;
        $msg = 'Successfully Deleted.';
        echo "<script>window.top.location='../info_maker/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

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
        echo "<script>window.top.location='../info_maker/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";


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
         echo "<script>window.top.location='../info_maker/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}


/* __________ ALL METTING FEEDBACK_____ UPDATE DAILY ACTIVITYS ____________*/

if (isset($_POST['meeting_feedback']) && !empty(trim($_POST['meeting_feedback']))) {

	$crud   = new crud('crm_lead_activity_feedback');
	$_POST['activity_id'] = $_POST['activity_id'];
	$_POST['feedback']  = $_POST['meeting_feedback'];
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();
    echo "<script>window.top.location='../info_maker/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

}



?>
        <!-- Closing div.col-6 -->
        <style type="text/css">
			.select2{width: 100% !important;}
		</style> 
		
		
<div class="page-content header-clear-medium">
  

  
  <div class="card card-style mb-3">
    <div class="content">
        <h1> Add Meeting Minutes Information </h1>
		
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
          <div class="input-style-new input-style-always-active has-borders no-icon mb-4"> 
            <select class="form-control req" name="project_id" id="project_id">
              <option value=""></option>
              <? foreign_relation('crm_project_org','id','name',$project_id,'1'); ?>
            </select>
            <label for="point_1" class="color-blue-dark"><i class="color-red-dark fa fa-map-marker-alt"></i> Project Name</label>
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
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <input type="text" id="form7" name="location" placeholder="Meeting location">
            <label for="form7" class="color-highlight">Meeting location</label>
          </div>
        </div>
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <input type="text" id="subject" name="subject" placeholder="Meeting Subject">
            <label for="form7" class="color-highlight">Meeting Subject</label>
          </div>
        </div>
      </div>
      <div class="row mb-0">
        <!-- Opening div.row -->
        <div class="col-6">
            <!-- Opening div.input-style -->
            <label for="emp_id1" class="color-highlight text-uppercase font-700 font-10 mt-1">Assign Person Name</label>
			<select class="form-control req" name="person_ids[]" id="emp_id1" multiple>
              <option value=""></option>
				<?php foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_ID," - ",PBI_NAME)', $assign_person, '1'); ?>
            </select>
          </div>
          <!-- Closing div.input-style -->
        <!-- Opening div.row -->
        <div class="col-6">
			  <div class="input-style has-borders no-icon mb-4 input-style-active">
				<!--<input type="text" name="note" class="form-control validate-text" id="form-4">-->
				<textarea id="meeting_person"  name="meeting_person" rows="4" cols="50" class="form-control validate-text"></textarea>
				<label for="meeting_person" class="color-highlight">Meeting Person</label>
			  </div>
          </div>
		</div>
      <br />
      <div class="input-style has-borders no-icon mb-4 input-style-active">
        <!--<input type="text" name="note" class="form-control validate-text" id="form-4">-->
		<textarea id="note"  name="note" rows="4" cols="50" class="form-control validate-text"></textarea>
        <label for="note" class="color-highlight">Notes</label>
      </div>
	  
	        <br />
      <div class="input-style has-borders no-icon mb-4 input-style-active">
        <!--<input type="text" name="details" class="form-control validate-text" id="form-4">-->
		<textarea id="details"  name="details" rows="4" cols="50" class="form-control validate-text"></textarea>
        <label for="details" class="color-highlight">Decision</label>
      </div>
	  
	        <br />
      <div class="input-style has-borders no-icon mb-4 input-style-active">
        <!--<input type="text" name="plan" class="form-control validate-text" id="form-4">-->
	  	<textarea id="plan"  name="plan" rows="4" cols="50" class="form-control validate-text"></textarea>
        <label for="plan" class="color-highlight">Next Action Plan</label>
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
      <button type="submit" name="scCall" class="close-menu btn btn-m btn-full bg-blue-dark text-uppercase font-700 rounded-sm w-100"> Confirm </button>
    </form>
</div>
<!-- End of Page Content--> 



<? 
 require_once '../assets/template/inc.footer.php';
 selected_two('#emp_id1');
 selected_two('#project_id');
?>