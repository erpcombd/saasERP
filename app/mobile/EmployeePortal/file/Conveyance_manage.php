<?php 
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

$title = "Conveyance Manage";
$page = "Conveyance_manage.php";


require_once '../assets/template/inc.header.php';

 
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

        

 
}

if (isset($_POST['scCall'])) {

    $person_ids = $_POST['person_ids'];
    $_POST['assign_person'] = implode(",", $person_ids);
    $crud   = new crud('crm_lead_activity');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();
    

}



if(isset($_POST['updatecontact']))
{


$_POST['edit_at']=time();
$_POST['edit_by']=$_SESSION['user']['id'];
		$crudcontact1->update('id');
		$type=1;
		$msg='Successfully Updated.';
        
}


if(isset($_POST['updateTasks']))
{

    $crud   = new crud('crm_task_add_information');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('task_id');
		$type=1;
		$msg='Successfully Updated.';
        
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
         
}

if(isset($_POST['deleteproduct']))
{
       
        $product_individual_id = $_POST['product_individual_id'];

        
        $deletesql = "DELETE FROM crm_lead_product_individual WHERE product_individual_id = " . $product_individual_id;
        db_query($deletesql);
        $tr_type = "Delete";
        $type = 1;
        $msg = 'Successfully Deleted.';
        

}

$tabletask='bills';		
$crudtask    =new crud($tabletask);		

if(isset($_POST['insertTasks']))
{

 

        $_POST['entry_at']= date('Y-m-d H:i:s');
        $_POST['entry_by']=$_SESSION['user']['id'];
		$crudtask->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
        


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
/*custom CSS*/
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
<!-- start of Page Content-->
<div class="page-content header-clear-medium">
  <div class="card card-style">
    <form action="" method="post">
      	<div class="row mb-0 mx-3">
							<div class="col-6 ps-0">
								<div class="input-style has-borders no-icon mb-4 shadow-l rounded-m bg-theme">
								
						 <label for="form-4" class="">From Date</label>
						 <input type="date" style="width:100%" name="s_date" class="form-control validate-text" value="<?=$_POST['s_date'];?>" id="form-4">
									<span><i class="fa fa-chevron-down"></i></span>
								</div>
							</div>
							<div class="col-6 pe-0">
								<div class="input-style has-borders no-icon mb-4 shadow-l rounded-m bg-theme">
									<label for="form-4" class="">To Date</label>
									 <input type="date" style="width:100%" name="e_date" class="form-control validate-text" value="<?=$_POST['e_date'];?>" id="form-4">
									<span><i class="fa fa-chevron-down"></i></span>
								</div>
							</div>
						</div>
						
						
						
						
						
						
						
						
						<div class="card card-style shadow-l mx-3 mt-3 mb-0">
						
							<input type="submit"  name="showResult" class="btn btn-l btn-full bg-highlight font-700 text-uppercase"  value="Show Results" id="form-4">
							
						</div>
    </form>
  </div>

  <?php 
  
    ?>
    <div class="card card-style">
      <div class="content">
        <div class="ms-auto float-end"> 
          <a href="#" data-menu="scheduleconveyance" class="icon icon-xxl bg-theme gradient-green color-white shadow-l rounded-m">
            <i class="fa fa-plus"></i>
          </a> 
          <span class="font-11 font-500 color-theme d-block">
            <center>Add</center>
          </span> 
        </div>
        <div class="ms-auto float-end">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <h3>Conveyance Manage</h3>
        <p>Sort Your Conveyance.</p>
        <div class="divider mb-0"></div>

        <?php 
		if(isset($_POST['showResult'])){
        $con = '';
        if($_POST['s_date'] != '' && $_POST['e_date'] != '') {
          $con = ' AND a.conveyance_date BETWEEN "'.$_POST['s_date'].'" AND "'.$_POST['e_date'].'" ';
        }
        
         $sql_t = "SELECT a.*, a.bills_id,a.conveyance_date FROM bills a WHERE emp_code='".$PBI_ID."' ".$con." ORDER BY a.bills_id";
        $query2 = db_query($sql_t);
      
        if ($query2) {
        ?>
        <table class="table table-borderless text-center rounded-sm shadow-l" style="overflow: hidden;">
          <thead>
            <tr class="bg-night-light">
              <th scope="col" class="color-white">SL</th>
              <th scope="col" class="color-white">Conveyance No.</th>
              <th scope="col" class="color-white">Conveyance Type</th>
              <th scope="col" class="color-white">Conveyance Date</th>
              <th scope="col" class="color-white">From</th>
              <th scope="col" class="color-white">To</th>
              <th scope="col" class="color-white">Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $s = 0;
            while($data2 = mysqli_fetch_object($query2)){
            ?>
            <tr>
              <th scope="row"><?= ++$s ?></th>
              <td><?= $data2->conveyance_no; ?></td>
              <td><?= $data2->conveyance_type ?></td>
              <td><?= $data2->conveyance_date ?></td>
              <td><?= $data2->from_address ?></td>
              <td><?= $data2->to_address ?></td>
              <td><?= number_format($data2->amount, 2) ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php 
        } else {
          echo "Error: Query execution failed.";
        }
        ?>
      </div>
    </div>
    <?php 
  } 
  
  else{
        $first_day_of_month = date('Y-m-01');
        $last_day_of_month = date('Y-m-t');
        {
          $con = ' AND a.conveyance_date BETWEEN "'.$first_day_of_month.'" AND "'.$last_day_of_month.'" ';
        }
        
         $sql_t = "SELECT a.*, a.bills_id,a.conveyance_date FROM bills a WHERE emp_code='".$PBI_ID."' ".$con." ORDER BY a.bills_id";
        $query2 = db_query($sql_t);
      
        if ($query2) {
        ?>
        <table class="table table-borderless text-center rounded-sm shadow-l" style="overflow: hidden;">
          <thead>
            <tr class="bg-night-light">
              <th scope="col" class="color-white">SL</th>
              <th scope="col" class="color-white">Conveyance No.</th>
              <th scope="col" class="color-white">Conveyance Type</th>
              <th scope="col" class="color-white">Conveyance Date</th>
              <th scope="col" class="color-white">From</th>
              <th scope="col" class="color-white">To</th>
              <th scope="col" class="color-white">Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $s = 0;
            while($data2 = mysqli_fetch_object($query2)){
            ?>
            <tr>
              <th scope="row"><?= ++$s ?></th>
              <td><?= $data2->conveyance_no; ?></td>
              <td><?= $data2->conveyance_type ?></td>
              <td><?= $data2->conveyance_date ?></td>
              <td><?= $data2->from_address ?></td>
              <td><?= $data2->to_address ?></td>
              <td><?= number_format($data2->amount, 2) ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php 
        } else {
          echo "Error: Query execution failed.";
        }
        ?>
      </div>
    </div>
    <?php 
  
  
  
  }
  ?>
  
  <div class="footer card card-style mt-0">
    <p class="footer-links"><a href="#" class="color-highlight">Privacy Policy</a> | <a href="#" class="color-highlight">Terms and Conditions</a> | <a href="#" class="back-to-top color-highlight">Back to Top</a></p>
    <div class="clear"></div>
  </div>
</div>

<!-- End of Page Content-->
<!-- Request Meeting  ---- -->
<div id="schedulemeeting" class="menu menu-box-bottom menu-box-detached">
  <div class="menu-title">
    <h1>Schedule a Meeting</h1>
    <p class="color-highlight"> Enter Meeting Details</p>
    <a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
  <div class="divider divider-margins mt-3 mb-2"></div>
  <div class="content px-1">
    <form method="post" action="">
      <!--				<div class="input-style has-borders no-icon validate-field mb-4">
                    <input type="text" name="call_to" class="form-control validate-text" id="form44" placeholder="Meeting With">
                    <label for="form44" class="color-highlight">Meeting With</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
-->
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
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form5" class="color-highlight">Priority type</label>
            <select class="form-control req" name="priority_status" id="form5" required>
              <option value="LOW">LOW</option>
              <option value="MEDIUM">MEDIUM</option>
              <option value="HIGH">HIGH </option>
            </select>
            <span class="disabled"><i class="fa fa-chevron-down"></i></span> <i class="fa fa-check valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
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
            <label for="form6" class="color-highlight text-uppercase font-700 font-10 mt-1">Meeting Date</label>
            <input type="date" style="width:100%"  name="date" class="form-control validate-text" id="form6">
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
        <label for="form5" class="color-highlight">Project Name</label>
        <select class="form-control req" name="project_id" id="form5">
          <option value=""></option>
          <? foreign_relation('crm_project_org','id','name',$project_id,'1'); ?>
        </select>
        <span class="disabled"><i class="fa fa-chevron-down"></i></span> <i class="fa fa-check valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
      <div class="input-style has-borders no-icon mb-4">
        <textarea id="form7" name="details" placeholder="Details"></textarea>
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
              <label for="form-4" class="color-highlight text-uppercase font-700 font-10 mt-1">Reminder Time</label>
              <input type="time" name="remainder_time" class="form-control validate-text" id="form-4">
            </div>
          </div>
          <div class="col-6">
            <div class="input-style has-borders no-icon mb-4 input-style-active">
              <label for="form-6" class="color-highlight text-uppercase font-700 font-10 mt-1">Reminder Date</label>
              <input type="date" style="width:100%" name="remainder_date" class="form-control validate-text" id="form-6">
            </div>
          </div>
        </div>
      </div>
      <button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100"> Confirm </button>
    </form>
  </div>
</div>
<!-- Request Conveyance  ---- -->
<div id="scheduleconveyance" class="menu menu-box-bottom menu-box-detached">
  <div class="menu-title">
    <h1>Make a Conveyance</h1>
    <p class="color-highlight"> Enter Conveyance Details</p>
    <a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
  <div class="divider divider-margins mt-3 mb-2"></div>
  <div class="content px-1">
    <form method="post" action="">
      <input type="hidden" name="emp_code" value="<?=$PBI_ID;?>" />
      <div class="input-style has-borders no-icon mb-4">
        <Input type="text" name="conveyance_no" id="conveyance_no"  
       value="<? echo $PBI_ID; echo '-'; echo find_a_field('bills','bills_id','1 order by bills_id desc')+1;?>" required readonly>
        <label for="form7" class="color-highlight">Conveyance No </label>
      </div>
      <div class="input-style has-borders no-icon mb-4 input-style-active">
        <label for="form6" class="color-highlight text-uppercase font-700 font-10 mt-1">Conveyance Date</label>
        <input type="date"  name="conveyance_date" value="<?=$conveyance_date?>" class="form-control validate-text" id="form6" required="required">
      </div>
      <div class="input-style has-borders no-icon mb-4">
        <input type="text" id="means" name="means" placeholder="Means of conveyanc">
        <label for="form7" class="color-highlight">Means of conveyance</label>
      </div>
      <div class="input-style has-borders no-icon mb-4">
        <textarea id="remarks" name="remarks" placeholder="Remarks"></textarea>
        <label for="form7" class="color-highlight">Remarks</label>
      </div>
      <div class="input-style has-borders no-icon mb-4 input-style-active">
        <label for="form5" class="color-highlight">type</label>
        <select class="form-control req" name="conveyance_type" id="con_type">
          <option value=""></option>
          <option value="Food">Food</option>
          <option value="Transport">Transport</option>
        </select>
        <span class="disabled"><i class="fa fa-chevron-down"></i></span> <i class="fa fa-check valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
      <div class="input-style has-borders no-icon mb-4">
        <input type="text" id="from_address" name="from_address" placeholder="From Address">
        <label for="form7" class="color-highlight">From Address</label>
      </div>
      <div class="input-style has-borders no-icon mb-4">
        <input type="text" id="to_address" name="to_address" placeholder="Means of conveyanc">
        <label for="form7" class="color-highlight">To Address</label>
      </div>
      <div class="input-style has-borders no-icon mb-4">
        <input type="text" id="amount" name="amount" placeholder="Amount">
        <label for="form7" class="color-highlight">Amount</label>
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
      <input type="hidden" name="activity_type" value="Task" />
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
<?php 
 require_once '../assets/template/inc.footer.php';
 ?>
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
