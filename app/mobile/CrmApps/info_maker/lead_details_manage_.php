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
$title = "Lead Information Manage";
$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);
do_calander('#date');

 $cur = '&#x9f3;';
 
 $tableOrganaization = 'crm_project_org';
 $table1 = 'crm_project_lead';
 $tablecontact = 'crm_lead_contacts';
 $tableproductadd = 'crm_lead_product_individual';
 $crmLeadManageTable = 'crm_lead_manage';

 $uniqueproduct="product_individual_id";



 $crudcontact1 = new crud($tablecontact);
 $crudproductadd1 = new crud($tableproductadd);
 $crudOrgManage= new crud($tableOrganaization);
 $crudLeadManage = new crud($crmLeadManageTable);
 



$pbi_id  =  $_SESSION['employee_selected'];
$user_role  =  $_SESSION['user']['fname'];


 $table2 = 'crm_task_lists';


echo  $id = decrypTS($_GET['view']);
echo $type = decrypTS($_GET['tp']);
 $orgId=find_a_field('crm_project_lead','organization','id="'.$id.'"');

  $qryrr = "SELECT * FROM crm_lead_manage WHERE lead_id = '$id'";

 $rsltrr = db_query($qryrr);
 $rows = mysqli_fetch_object($rsltrr);
 $orgname = $rows->company_name;
 $email = $rows->email;
 $phone = $rows->phone;
 $no_of_employees = $rows->no_of_employees;
 $street_address = $rows->city;
 $first_name = $rows->first_name;
 $lead_owner = $rows->lead_owner;

 



$condition="id=".$id;

$data=db_fetch_object('crm_project_lead',$condition);
foreach($data as $key=>$value)
{ $$key=$value;}


if(isset($_POST['addcontactinfo']))
{
$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudcontact1->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
}


if(isset($_POST['insertconverttolead'])){

/*_____Insert New Organization  in crm_project_org  table   -> After Convert to lead ____*/
$_POST['name']=$orgname;
$_POST['total_employees']= $no_of_employees;
$_POST['lead_source']= $_POST['campaign'];
$_POST['assigned_person_id']=$lead_owner;
$_POST['address']=$street_address;
$_POST['contact_person']=$first_name;
$_POST['contact_number']=$phone;
$_POST['contact_email']=$email;
$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']= time();
$org_id = $crudOrgManage->insert();
$type=1;

/*_____Insert New Lead in lead table   -> After Convert to lead ____*/
$_POST['organization'] =  $org_id;
$table1 = 'crm_project_lead';
$crud1 = new crud($table1);


/*_____UPDATE crm_lead_manage Status -> Convert to lead ____*/
$_POST['lead_status']=9;
$crudLeadManage->update('lead_id');

/* _______ LOG___________INSERT */
$_POST['entry_at']=date('Y-m-d h:i:sa');
$_POST['entry_by'] = $_SESSION['user']['id'];
$log_id=$crud1->insert();

$cd= new crud('crm_lead_log');
$_POST['lead_id']=$log_id;
$cd->insert(); 	

echo "<script>window.top.location='../main/leads.php'<script>";
}



if(isset($_POST['productadd']))
{

$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudproductadd1->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';

        echo "<script>window.top.location='../info_maker/lead_details_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

 
}



if (isset($_POST['scCall1'])) {

	$crud   = new crud('crm_lead_activity_manage');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();
    echo "<script>window.top.location='lead_details_manage_.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

}




if(isset($_POST['updatecontact']))
{


$_POST['edit_at']=time();
$_POST['edit_by']=$_SESSION['user']['id'];
		$crudcontact1->update('id');
		$type=1;
		$msg='Successfully Updated.';
        echo "<script>window.top.location='../info_maker/lead_details_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}


if(isset($_POST['updatecall']))
{
$_POST['edit_at']=time();
$_POST['edit_by']=$_SESSION['user']['id'];
		$crud->update('task_id');
		$type=1;
		$msg='Successfully Updated.';
        echo "<script>window.top.location='../info_maker/lead_details_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}





if(isset($_POST['updateTasks']))
{

    $crud   = new crud('crm_task_add_information');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('task_id');
		$type=1;
		$msg='Successfully Updated.';
         echo "<script>window.top.location='../info_maker/lead_details_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
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
         echo "<script>window.top.location='../info_maker/lead_details_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}

/* __________  UPDATE DAILY ACTIVITYS ____________*/

if(isset($_POST['UpdateMettingActivity']))
{

        $crud   = new crud('crm_lead_activity');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('activity_id');
		$type=1;
		$msg='Successfully Updated.';
         echo "<script>window.top.location='../info_maker/lead_details_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}

/*____________ update VISIT ----------*/

if(isset($_POST['UpdateVisit']))
{

        $crud   = new crud('crm_lead_activity');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('activity_id');
		$type=1;
		$msg='Successfully Updated.';
         echo "<script>window.top.location='../info_maker/lead_details_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}



/*____________ update Call ----------*/

if(isset($_POST['UpdateCall']))
{

        $crud   = new crud('crm_lead_activity');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('activity_id');
		$type=1;
		$msg='Successfully Updated.';
         echo "<script>window.top.location='../info_maker/lead_details_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}



/* __________ ALL METTING FEEDBACK_____ UPDATE DAILY ACTIVITYS ____________*/

if (isset($_POST['meeting_feedback']) && !empty(trim($_POST['meeting_feedback']))) {

	$crud   = new crud('crm_lead_activity_feedback');
	$_POST['activity_id'] = $_POST['activity_id'];
	$_POST['feedback']  = $_POST['meeting_feedback'];
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();
    echo "<script>window.top.location='../info_maker/lead_details_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

}





if(isset($_POST['deleteproduct']))
{
       
        $product_individual_id = $_POST['product_individual_id'];

        
        $deletesql = "DELETE FROM crm_lead_product_individual WHERE product_individual_id = " . $product_individual_id;
        db_query($deletesql);
        $tr_type = "Delete";
        $type = 1;
        $msg = 'Successfully Deleted.';
        echo "<script>window.top.location='../info_maker/lead_details_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

}

$tabletask='crm_task_add_information';		
$crudtask    =new crud($tabletask);		

if(isset($_POST['insertTasks']))
{

$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudtask->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
        echo "<script>window.top.location='../info_maker/lead_details_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";


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
	
	.scrollable-div {
        margin-right: 30%;
        max-height: 100px; /* Adjust the height as needed */
        overflow-y: scroll;
        padding: 5px; /* Optional: Adds padding for better look */
    }
	
	.no-border{
	border:none !important;
	}

        .contact-icon {
            margin-right: 6px;
        }
	
</style>
<!-- Create Account NEW MODAL-->
<!-- Form Wizard Full Screen-->



<div id="menu-wizard-step-1" class="menu menu-box-left" data-menu-height="cover" data-menu-width="cover">
<div class="card card-style bg-transparent shadow-0 mb-0" style="height:100%;">
<div class="card-top mt-4">
<div class="d-flex pb-3 mb-n4"> <a href="#" style="width:35px; line-height:35px;" class="me-auto font-600 rounded-l text-center bg-green-dark">1</a> <a href="#" style="width:35px; line-height:35px;" class="m-auto font-600 rounded-l text-center bg-gray-dark">2</a> </div>
<div class="divider position-absolute start-0 end-0 mt-n2" style="z-index:-1;"></div>
<h1 class="pt-4 mt-3">Convert Lead
  <?=$orgname?>
</h1>
<p> Create New Account
  <?=$orgname?>
  <br />
<p class="color-highlight font-12 mt-n3 pt-1 mb-2">Lead Owner
  <?=$basic->PBI_NAME;?>
</p>
</p>
<h5>Deal Name</h5>
<div class="input-style has-borders no-icon validate-field mb-4">
<form method="post" action="">
  <input type="hidden" name="organizationn" id="organizationn" value="<?=$id?>" />
  <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
  <input type="hidden" name="assign_person" id="assign_person" value="<?=$PBI_ID?>" />
  <input type="hidden" name="lead_source" id="lead_source" value="<?=$id?>" />
  <input type="text" name="lead_name" class="form-control validate-name" id="form1" value="<?=$orgname?>">
  <label for="form1" class="color-highlight disabled">John</label>
  <i class="fa fa-times disabled invalid color-red-dark"></i> <i class="fa fa-check disabled valid color-green-dark"></i> <em>(optional)</em>
  </div>
  <h5>Amount </h5>
  <div class="input-style has-borders no-icon validate-field mb-4">
    <input type="text" name="lead_value" class="form-control validate-name" id="form1">
    <label for="form1" class="color-highlight disabled">Europe</label>
    <i class="fa fa-times disabled invalid color-red-dark"></i> <i class="fa fa-check disabled valid color-green-dark"></i> <em>(required)</em> </div>
  <h5>Closing Date</h5>
  <div class="input-style has-borders no-icon mb-4">
    <label for="form5" class="color-highlight disabled">Select A Value</label>
    <input type="date" class="form-control validate-name" id="form1" name="closing_date">
    <i class="fa fa-check disabled valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
  </div>
  <div class="card-bottom mb-5 pb-3"> <a href="#" data-menu="menu-wizard-step-2" 
  class="btn btn-full btn-m rounded-m bg-blue-dark font-700 text-uppercase">Next Step</a> </div>
  </div>
  </div>
  
  
  <div id="menu-wizard-step-2" class="menu menu-box-left" data-menu-height="cover" data-menu-width="cover">
    <div class="card card-style bg-transparent shadow-0 mb-0" style="height:100%;">
      <div class="card-top mt-4">
        <div class="d-flex pb-3 mb-n4"> <a href="#" style="width:35px; line-height:35px;" data-menu="menu-wizard-step-1" class="me-auto font-600 text-center rounded-l bg-green-dark"><i class="fa fa-check mx-n1"></i></a> <a href="#" style="width:35px; line-height:35px;" class="m-auto font-600 text-center rounded-l bg-green-dark">2</a> <a href="#" style="width:35px; line-height:35px;" class="ms-auto font-600 text-center rounded-l bg-gray-dark">3</a> </div>
        <div class="divider position-absolute start-0 end-0 mt-n2" style="z-index:-1;"></div>
        <h1 class="pt-4 mt-3">Convert Lead
          <?=$orgname?>
        </h1>
        <h5>Campaign Source</h5>
        <div class="input-style has-borders no-icon validate-field mb-4">
          <select  name="campaign" id="form5a">
            <option value="default" disabled selected>Select a Value</option>
            <? foreign_relation('crm_campaign_management','id','camp_name',$campaign,'1'); ?>
          </select>
          <label for="form1a" class="color-highlight disabled">Sticky</label>
          <i class="fa fa-times disabled invalid color-red-dark"></i> <i class="fa fa-check disabled valid color-green-dark"></i> <em>(optional)</em> </div>
        <h5>Stage </h5>
        <div class="input-style has-borders no-icon mb-4">
          <label for="form5a" class="color-highlight disabled">Campaign Source</label>
          <select  name="status" id="form5a">
            <option value="default" disabled selected>Select a Value</option>
            <? foreign_relation('crm_deal_stage_status','id','status',$lead_status,'1'); ?>
          </select>
          <span><i class="fa fa-chevron-down"></i></span> <i class="fa fa-check disabled valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
      </div>
      <div class="card-bottom mb-5 pb-3"> <a href="#" data-menu="menu-wizard-step-3" class="btn btn-full btn-m rounded-m bg-blue-dark font-700 text-uppercase">Next Step</a> </div>
    </div>
  </div>
  <div id="menu-wizard-step-3" class="menu menu-box-left" data-menu-height="cover" data-menu-width="cover">
    <div class="card card-style bg-transparent shadow-0 mb-0" style="height:100%;">
      <div class="card-center text-center"> <i class="fa fa-check-circle scale-box color-green-dark fa-5x pb-3"></i>
        <h1>Thank you!</h1>
        <p class="px-3 mb-5"> We'll get back to you if we need clarifications. Thank you for taking our survay! </p>
      </div>
      <div class="card-bottom mb-5 pb-3">
        <input name="insertconverttolead" type="submit" id="contactsave" value="Save" 
					class="close-menu btn btn-full btn-m rounded-m bg-green-dark font-700 text-uppercase">
        <br />
        <input type="button" value="Cancel" 
                class="close-menu btn btn-full btn-m rounded-m bg-red-dark font-700 text-uppercase">
      </div>
    </div>
  </div>
</form>
<!-- Form Wizard Sheets-->









<!-- ___________  Contact Information modal Start _________  -->
<div id="addContact" class="menu menu-box-modal menu-box-detached">
  <form id="contactformidnew" method="post">
    <div class="modal-body">
      <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
      <input type="hidden" name="activity_type" value="Call" />
      <input type="hidden" name="main" value="1" />
      <div class="menu-title">
        <h1>Add Contact Information </h1>
        <p class="color-highlight">
          <?=$orgname?>
        </p>
        <a href="#" class="close-menu"><i class="fa fa-times"></i></a> </div>
      <div class="divider divider-margins mb-1 mt-3"></div>
      <div class="content px-1">
        <div class="input-style has-borders no-icon mb-4">
          <input type="text" id="contact_name" name="contact_name" placeholder="Contact Person Name">
          <label for="form7" class="color-highlight">Contact Person Name</label>
        </div>
        <div class="input-style has-borders no-icon mb-4">
          <input type="text" id="contact_phone" name="contact_phone" placeholder="Contact Person Mobile">
          <label for="form7" class="color-highlight">Contact Person Mobile</label>
        </div>
        <div class="input-style has-borders no-icon mb-4">
          <input type="text" id="contact_email" name="contact_email" placeholder="Contact Person Email">
          <label for="form7" class="color-highlight">Contact Person Email</label>
        </div>
        <div class="input-style has-borders no-icon mb-4">
          <input type="text" id="contact_designation" name="contact_designation" placeholder="Contact Person Designation">
          <label for="form7" class="color-highlight">Contact Person Designation</label>
        </div>
        <input name="addcontactinfo" type="submit" id="contactsave" value="Add Contact" 
					class="close-menu btn btn-full btn-m bg-highlight rounded-sm text-uppercase font-800 mb-3 width-100">
      </div>
    </div>
  </form>
</div>
<!-- _________________________  Contact Information modal END      ______________________-->
<!-- Recent Transactions Menus -->
<div id="menu-transaction-1" class="menu menu-box-bottom menu-box-detached">
  <form method="post" action="">
    <input type="hidden" name="lead_id" id="lead_id_edit" value="<?=$id?>" />
    <input type="hidden" name="activity_id" id="activity_id_edit" value="" />
    <div class="menu-title mt-1">
      <h1>Payment Sent</h1>
      <p class="color-highlight">Transaction Details for Payment</p>
      <a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
    <div class="divider divider-margins mb-1 mt-3"></div>
    <div class="content">
      <div class="divider mt-3 mb-3"></div>
      <div class="row mb-0">
        <div class="col-2">
          <h4 class="font-14">Details</h4>
        </div>
        <div class="col-10">
          <p class="font-14">Details of task</p>
        </div>
        <div class="divider divider-margins w-100 mt-2 mb-2"></div>
        <div class="col-6">
          <h4 class="font-14 mt-1">Amount</h4>
        </div>
        <div class="col-6">
          <h4 class="font-14 text-end mt-1">$530.24</h4>
        </div>
        <div class="divider divider-margins w-100 mt-2 mb-2"></div>
        <div class="col-6">
          <h4 class="font-14 mt-1">P</h4>
        </div>
        <div class="col-6">
          <h4 class="font-14 text-end mt-1">#123-456-165</h4>
        </div>
        <div class="divider divider-margins w-100 mt-2 mb-2"></div>
        <div class="col-6">
          <h4 class="font-14 mt-1">Status</h4>
        </div>
        <div class="col-6">
          <h4 class="font-14 text-end mt-1 color-green-dark">Completed</h4>
        </div>
        <div class="divider divider-margins w-100 mt-2 mb-3"></div>
        <div class="col-12">
          <button type="submit" name="taskupdate" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-3">Submit</button>
        </div>
      </div>
    </div>
  </form>
</div>









<!--Modal for meeting start-->

<!-- Form Wizard Full Screen-->

<?php /*?>

<div id="menu-wizard-step-meeting" class="menu menu-box-left" data-menu-height="cover" data-menu-width="cover">
<div class="card card-style bg-transparent shadow-0 mb-0" style="height:100%;">
<div class="card-top mt-4">
<div class="d-flex pb-3 mb-n4"> <a href="#" style="width:35px; line-height:35px;" class="me-auto font-600 rounded-l text-center bg-green-dark">1</a> <a href="#" style="width:35px; line-height:35px;" class="m-auto font-600 rounded-l text-center bg-gray-dark">2</a> </div>
<div class="divider position-absolute start-0 end-0 mt-n2" style="z-index:-1;"></div>
<h1 class="pt-4 mt-3">Convert Lead
  <?=$orgname?>
</h1>
<p> Create New Account
  <?=$orgname?>
  <br />
<p class="color-highlight font-12 mt-n3 pt-1 mb-2">Lead Owner
  <?=$basic->PBI_NAME;?>
</p>
</p>
<h5>Deal Name</h5>
<div class="input-style has-borders no-icon validate-field mb-4">
<form method="post" action="">
  <input type="hidden" name="organization" id="organization" value="<?=$id?>" />
  <input type="hidden" name="assign_person" id="assign_person" value="<?=$PBI_ID?>" />
  <input type="hidden" name="lead_source" id="lead_source" value="<?=$id?>" />
  <input type="text" name="lead_name" class="form-control validate-name" id="form1" value="<?=$orgname?>">
  <label for="form1" class="color-highlight disabled">John</label>
  <i class="fa fa-times disabled invalid color-red-dark"></i> <i class="fa fa-check disabled valid color-green-dark"></i> <em>(optional)</em>
  </div>
  <h5>Amount </h5>
  <div class="input-style has-borders no-icon validate-field mb-4">
    <input type="text" name="lead_value" class="form-control validate-name" id="form1">
    <label for="form1" class="color-highlight disabled">Europe</label>
    <i class="fa fa-times disabled invalid color-red-dark"></i> <i class="fa fa-check disabled valid color-green-dark"></i> <em>(required)</em> </div>
  <h5>Closing Date</h5>
  <div class="input-style has-borders no-icon mb-4">
    <label for="form5" class="color-highlight disabled">Select A Value</label>
    <input type="date" class="form-control validate-name" id="form1" name="closing_date">
    <i class="fa fa-check disabled valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
  </div>
  <div class="card-bottom mb-5 pb-3"> <a href="#" data-menu="menu-wizard-step-2" class="btn btn-full btn-m rounded-m bg-blue-dark font-700 text-uppercase">Next Step</a> </div>
  </div>
  </div>
  <div id="menu-wizard-step-2" class="menu menu-box-left" data-menu-height="cover" data-menu-width="cover">
    <div class="card card-style bg-transparent shadow-0 mb-0" style="height:100%;">
      <div class="card-top mt-4">
        <div class="d-flex pb-3 mb-n4"> <a href="#" style="width:35px; line-height:35px;" data-menu="menu-wizard-step-1" class="me-auto font-600 text-center rounded-l bg-green-dark"><i class="fa fa-check mx-n1"></i></a> <a href="#" style="width:35px; line-height:35px;" class="m-auto font-600 text-center rounded-l bg-green-dark">2</a> <a href="#" style="width:35px; line-height:35px;" class="ms-auto font-600 text-center rounded-l bg-gray-dark">3</a> </div>
        <div class="divider position-absolute start-0 end-0 mt-n2" style="z-index:-1;"></div>
        <h1 class="pt-4 mt-3">Convert Lead
          <?=$orgname?>
        </h1>
        <h5>Campaign Source</h5>
        <div class="input-style has-borders no-icon validate-field mb-4">
          <select  name="campaign" id="form5a">
            <option value="default" disabled selected>Select a Value</option>
            <? foreign_relation('crm_campaign_management','id','camp_name',$campaign,'1'); ?>
          </select>
          <label for="form1a" class="color-highlight disabled">Sticky</label>
          <i class="fa fa-times disabled invalid color-red-dark"></i> <i class="fa fa-check disabled valid color-green-dark"></i> <em>(optional)</em> </div>
        <h5>Stage </h5>
        <div class="input-style has-borders no-icon mb-4">
          <label for="form5a" class="color-highlight disabled">Campaign Source</label>
          <select  name="status" id="form5a">
            <option value="default" disabled selected>Select a Value</option>
            <? foreign_relation('crm_deal_stage_status','id','status',$lead_status,'1'); ?>
          </select>
          <span><i class="fa fa-chevron-down"></i></span> <i class="fa fa-check disabled valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
      </div>
      <div class="card-bottom mb-5 pb-3"> <a href="#" data-menu="menu-wizard-step-3" class="btn btn-full btn-m rounded-m bg-blue-dark font-700 text-uppercase">Next Step</a> </div>
    </div>
  </div>
  <div id="menu-wizard-step-3" class="menu menu-box-left" data-menu-height="cover" data-menu-width="cover">
    <div class="card card-style bg-transparent shadow-0 mb-0" style="height:100%;">
      <div class="card-center text-center"> <i class="fa fa-check-circle scale-box color-green-dark fa-5x pb-3"></i>
        <h1>Thank you!</h1>
        <p class="px-3 mb-5"> We'll get back to you if we need clarifications. Thank you for taking our survay! </p>
      </div>
      <div class="card-bottom mb-5 pb-3">
        <input name="insertconverttolead" type="submit" id="contactsave" value="Save" 
					class="close-menu btn btn-full btn-m rounded-m bg-green-dark font-700 text-uppercase">
        <br />
        <input type="button" value="Cancel" 
                class="close-menu btn btn-full btn-m rounded-m bg-red-dark font-700 text-uppercase">
      </div>
    </div>
  </div>
</form><?php */?>
<!-- Form Wizard Sheets-->




<!-- ___________  Contact Information modal Start _________  -->
<div id="addContact" class="menu menu-box-modal menu-box-detached">
  <form id="contactformidnew" method="post">
    <div class="modal-body">
      <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
      <input type="hidden" name="activity_type" value="Call" />
      <input type="hidden" name="main" value="1" />
      <div class="menu-title">
        <h1>Add Contact Information </h1>
        <p class="color-highlight">
          <?=$orgname?>
        </p>
        <a href="#" class="close-menu"><i class="fa fa-times"></i></a> </div>
      <div class="divider divider-margins mb-1 mt-3"></div>
      <div class="content px-1">
        <div class="input-style has-borders no-icon mb-4">
          <input type="text" id="contact_name" name="contact_name" placeholder="Contact Person Name">
          <label for="form7" class="color-highlight">Contact Person Name</label>
        </div>
        <div class="input-style has-borders no-icon mb-4">
          <input type="text" id="contact_phone" name="contact_phone" placeholder="Contact Person Mobile">
          <label for="form7" class="color-highlight">Contact Person Mobile</label>
        </div>
        <div class="input-style has-borders no-icon mb-4">
          <input type="text" id="contact_email" name="contact_email" placeholder="Contact Person Email">
          <label for="form7" class="color-highlight">Contact Person Email</label>
        </div>
        <div class="input-style has-borders no-icon mb-4">
          <input type="text" id="contact_designation" name="contact_designation" placeholder="Contact Person Designation">
          <label for="form7" class="color-highlight">Contact Person Designation</label>
        </div>
        <input name="addcontactinfo" type="submit" id="contactsave" value="Add Contact" 
					class="close-menu btn btn-full btn-m bg-highlight rounded-sm text-uppercase font-800 mb-3 width-100">
      </div>
    </div>
  </form>
</div>
<!-- _________________________  Contact Information modal END      ______________________-->
<!-- Recent Transactions Menus -->
<div id="menu-transaction-1" class="menu menu-box-bottom menu-box-detached">
  <form method="post" action="">
    <input type="hidden" name="lead_id" id="lead_id_edit" value="<?=$id?>" />
    <input type="hidden" name="activity_id" id="activity_id_edit" value="" />
    <div class="menu-title mt-1">
      <h1>Payment Sent</h1>
      <p class="color-highlight">Transaction Details for Payment</p>
      <a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
    <div class="divider divider-margins mb-1 mt-3"></div>
    <div class="content">
      <div class="divider mt-3 mb-3"></div>
      <div class="row mb-0">
        <div class="col-2">
          <h4 class="font-14">Details</h4>
        </div>
        <div class="col-10">
          <p class="font-14">Details of task</p>
        </div>
        <div class="divider divider-margins w-100 mt-2 mb-2"></div>
        <div class="col-6">
          <h4 class="font-14 mt-1">Amount</h4>
        </div>
        <div class="col-6">
          <h4 class="font-14 text-end mt-1">$530.24</h4>
        </div>
        <div class="divider divider-margins w-100 mt-2 mb-2"></div>
        <div class="col-6">
          <h4 class="font-14 mt-1">P</h4>
        </div>
        <div class="col-6">
          <h4 class="font-14 text-end mt-1">#123-456-165</h4>
        </div>
        <div class="divider divider-margins w-100 mt-2 mb-2"></div>
        <div class="col-6">
          <h4 class="font-14 mt-1">Status</h4>
        </div>
        <div class="col-6">
          <h4 class="font-14 text-end mt-1 color-green-dark">Completed</h4>
        </div>
        <div class="divider divider-margins w-100 mt-2 mb-3"></div>
        <div class="col-12">
          <button type="submit" name="taskupdate" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-3">Submit</button>
        </div>
      </div>
    </div>
  </form>
</div>











<!--Modal for meeting end-->


<div class="page-content header-clear-medium">
<?php
					$sqlTasks = "SELECT * FROM crm_lead_manage l WHERE l.lead_id= ".$id."";
					$resultTasks = db_query($sqlTasks);
					if($row = mysqli_fetch_object($resultTasks)) { 
					
			$phone = $row->phone;
			$email   = $row->email;		
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
<div data-card-height="250" class="card card-style round-medium shadow-huge top-30">
  <div class="card-top mt-3 ms-3">
    <h2 class="color-white pt-3 pb-3">
      <?=$row->company_name?>
    </h2>
    <p class="color-white font-10 opacity-80 mb-n1"><i class="fa fa-bullhorn"></i> Source:
      <?=find_a_field('crm_lead_source','source','id="'.$row->lead_source.'"');?>
      <i class="ms-4 fa fa-users"></i> No of employees:
      <?=$row->no_of_employees?>
    </p>
    <p class="color-white font-10 opacity-80 mb-n1"><i class="fa fa-globe"></i>
      <?=$row->website?>
    </p>
	<p class="color-white font-10 opacity-80 mb-n1"><i class="fa fa-briefcase"></i>
	  <?=find_a_field('crm_company_category','category_name','id="'.$row->industry.'"');?>
    </p>
    <p class="color-white font-10 opacity-80"><i class="fa fa-map-marker-alt"></i>
      <?=$row->street_address?>
      ,
      <?=$row->city?>
      ,
	  <?=find_a_field('district_list','district_name','id="'.$row->district.'"');?>
	  ,
	  <?=find_a_field('division','division_name','division_CODE="'.$row->division.'"');?>
      ,
      <?=$row->zip_code?>
	  ,
	  <?=$row->country?>
    </p>

	
	
	
  </div>
  <div class="card-top mt-3 me-3"> <a href="#" data-menu="menu-wizard-step-1"  class="btn btn-m float-end rounded-xl shadow-xl text-uppercase font-800 <?=$class?> fa-2x mt-1 modal-icon bg-highligh"> Convert
    <? //=find_a_field('crm_lead_status', 'status', 'id = "'.$row->lead_status.'"')?>
    </a> </div>
  <!--<div class="card-bottom pb-3 pe-4">
                <div class="float-end">
                    <h4 class="font-12 color-white font-400 opacity-50">John, and 143 more are attending</h4>
                    <img class="shadow-xl rounded-xl preload-img float-end" width="40" src="../images/empty.png" data-src="images/pictures/faces/1s.png">
                    <img class="shadow-xl rounded-xl preload-img float-end" width="40" src="../images/empty.png" data-src="images/pictures/faces/2s.png">
                    <img class="shadow-xl rounded-xl preload-img float-end" width="40" src="../images/empty.png" data-src="images/pictures/faces/3s.png">
                </div>
            </div>-->
  <div class="card-bottom ms-3 mb-3"> <img data-src="../images/pictures/faces/4small.png" alt="img" width="40" class="pb-1 preload-img shadow-xl rounded-m"> </div>
  <div class="card-bottom mb-n3 ps-5 ms-4">
    <h5 class="font-13 color-white mb-n1">
      <?=find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "'.$row->lead_owner.'"')?>
    </h5>
    <p class="color-white font-10 opacity-70"><?=find_a_field('personnel_basic_info', 'PBI_DESIGNATION', 'PBI_ID = "'.$row->lead_owner.'"')?></p>
  </div>
  <div class="card-overlay bg-highlight opacity-90"></div>
  <div class="card-overlay bg-gradient"></div>
</div>
<?php } ?>

<!--Contact Information Section Start -->


<div class="card card-style">
            <div class="content mb-0">
                <h3 class="font-700">Contact Information</h3>
            

                <div class="list-group list-custom-small">
                    <a class="default-link" href="tel:+1 234 567 890">
                        <i class="fa font-14 fa-phone color-phone"></i>
                        <span>+88<?=$phone;?></span>
                        <span class="badge bg-red-dark">TAO TO CALL</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a class="default-link" href="mailto:mail@domain.com">
                        <i class="fa font-14 fa-envelope color-mail"></i>
                        <span><?=$email;?></span>
                        <span class="badge bg-red-dark">TAO TO MAIL</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                 
                    <a href="#" class="border-0">
                        <i class="fab font-14 fa-linkedin color-linkedin"></i>
                        <span>@Enabled</span>
                        <i class="fa fa-link"></i>
                    </a>

                </div>
            </div>
        </div>
		


<!--Product Section Start -->



<div class="card card-style">
            <div class="content mb-2">
                <h3>Product List</h3><p><button class="float-end bg-highlight btn btn-xs text-uppercase font-900 rounded-xl font-11" data-menu="addProduct">Add</button></p>
		
                <table class="table table-borderless text-center rounded-sm shadow-l" style="overflow: hidden;">
                    <thead>
                        <tr class="bg-night-light">
                            <th scope="col" class="color-white">Name</th>
                            <th scope="col" class="color-white">Price</th>
                            <th scope="col" class="color-white">Status</th>
                        </tr>
                    </thead>
                    <tbody>
					
					   <?php
                               $sqlTasks = "SELECT * FROM crm_lead_products JOIN crm_lead_product_individual ON
                                      crm_lead_products.id=crm_lead_product_individual.product_id WHERE crm_lead_product_individual.lead_id=$id;";
						$resultTasks = db_query($sqlTasks);
						while ($row = mysqli_fetch_object($resultTasks)) { 
								
                              
				       ?>
                        <tr>
                            <th scope="row"><?=$row->products;?></th>
                            <td class="color-green-dark"><?=$task_date ;?></td>
                            <td><i class="fa fa-arrow-up rotate-45 color-green-dark"></i></td>
                        </tr>
                          <?php } ?>
                        
                    </tbody>
                </table>
            </div>
        </div>


<!--Product Section End -->





<?php /*?><!-- Start of  Call Activity Manage -->
<div class=" mb-0">
  <!-- Start of card-->
  <div class="card card-style">
    <div class="content mb-0">
      <h4 class="font-700 text-uppercase font-12 color-highlight opacity-70 mb-3 mt-n2">Call Activity</h4>
      <div class="position-absolute top-0 end-0 mt-3 me-3">
        <button class="fa fa-edit color-brown-dark" data-menu="edittaskmodal" onclick="openModalEditTask('<?=$row->activity_id;?>')"></button>
      </div>
    </div>
    <!-- End of card-->
    <div class="content mb-0" id="tab-group-1">
      <div class="tab-controls tabs-medium tabs-rounded" data-highlight="bg-highlight">
	  <a href="#" class="font-600 bg-highlight no-click" data-active="" data-bs-toggle="collapse" data-bs-target="#tab-1" aria-expanded="true">Open Calls</a> 
	  <a href="#" class="font-600 collapsed" data-bs-toggle="collapse" data-bs-target="#tab-2" aria-expanded="false">Closed Calls</a> </div>
      <div class="clearfix mb-3"></div>
      <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1" style="">
        <div class="list-group list-custom-small">
          <?php
                                $currentDateTime = date("Y-m-d H:i:s");
         $sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id AND activity_type = 'Call'  AND status != 'cancelled' ORDER BY lead_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
                                ?>
          <!-- File Item 2-->
          <div class="d-flex">
            <div class="pe-3 align-self-center"> <a href="#" class="icon icon-xs rounded-sm shadow-l me-1 bg-phone"><i class="fa fa-phone"></i></a></div>
            <div class="align-self-center"> <span class="color-theme font-11 opacity-60 font-600">Status <span class="color-blue-dark">
              <?=find_a_field('crm_lead_status','status','id='.$row->status);?>
              </span></span>
              <h3 class="mt-n2 mb-n1 font-18">
                <?=$row->subject;?>
              </h3>
			  				<h3 class="color-theme font-10 opacity-40 font-400">Call to :<?=$row->call_to;?>	(<? if($row->call_type == 'Inbound Call'){ ?>
								INBOUND CALL
								<? }elseif($row->call_type == 'Outbound Call'){ ?>	   
								OUTBOUND CALL
								<? }else{ ?>
								No data
								<?  } ?>)
								</h3>
              <span class="color-theme font-10 opacity-40 font-400">Call on:
              <?=$task_date ;?>  <?=$formattedTime ?>
              </span> </div>
            <div class="align-self-center ms-auto"> <a href="#" data-bs-toggle="dropdown" class="icon icon-m color-theme"><i class="fa fa-ellipsis-h"></i></a>
              <div class="dropdown-menu border-0 bg-theme rounded-m shadow-xl px-2 mt-n4">
                <div class="list-group list-custom-small mt-n2 mb-n2"> <a href="#" data-menu="menu-archive"><i class="fa font-14 fa-archive color-brown-dark opacity-60"></i>Archive<i class="fa"></i></a> <a href="#" data-menu="menu-transaction-1" onclick="taskedit('<?=$row->activity_id;?>')"><i class="fa font-14 fa-download color-blue-dark opacity-60"></i>Edit<i class="fa"></i></a> <a href="#" data-menu="menu-delete"><i class="fa font-14 fa-trash color-red-dark opacity-60"></i>Delete<i class="fa"></i></a> </div>
              </div>
            </div>
          </div>
          <!-- End of File-->
          <div class="pb-3"></div>
          <?php } ?>
        </div>
      </div>
      <div data-bs-parent="#tab-group-1" class="collapse" id="tab-2" style="">
        <div class="list-group list-custom-small">
          <!-- File Item 2-->
          <div class="d-flex">
            <div class="pe-3 align-self-center"> <i class="fa fa-file-archive fa-4x color-yellow-dark"></i> </div>
            <div class="align-self-center"> <span class="color-theme font-11 opacity-60 font-600">Assigned to you by <span class="color-blue-dark">John</span></span>
              <h3 class="mt-n2 mb-n1 font-18">Complete Assets</h3>
              <span class="color-theme font-10 opacity-40 font-400">Uploaded on: 15h Dec - 175 mb</span> </div>
            <div class="align-self-center ms-auto"> <a href="#" data-bs-toggle="dropdown" class="icon icon-m color-theme"><i class="fa fa-ellipsis-h"></i></a>
              <div class="dropdown-menu border-0 bg-theme rounded-m shadow-xl px-2 mt-n4">
                <div class="list-group list-custom-small mt-n2 mb-n2"> <a href="#" data-menu="menu-archive"><i class="fa font-14 fa-archive color-brown-dark opacity-60"></i>Archive<i class="fa"></i></a> <a href="#" data-menu="menu-download"><i class="fa font-14 fa-download color-blue-dark opacity-60"></i>Edit<i class="fa"></i></a> <a href="#" data-menu="menu-delete"><i class="fa font-14 fa-trash color-red-dark opacity-60"></i>Delete<i class="fa"></i></a> </div>
              </div>
            </div>
          </div>
          <!-- End of File-->
          <div class="pb-3"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End of Call Activity--><?php */?>







<!-- Start of  Meeting Activity Manage -->
<div class=" mb-0">
  <!-- Start of card-->
  <div class="card card-style">
    <div class="content mb-0">
      <h4 class="font-700 text-uppercase font-12 color-highlight opacity-70 mb-3 mt-n2">Meeting Activity</h4>
      <div class="position-absolute top-0 end-0 mt-3 me-3">
        <button class="fa fa-edit color-brown-dark" data-menu="editmeetingmodal" onclick="openModalEditTask('<?=$row->activity_id;?>')"></button>
      </div>
    </div>
    <!-- End of card-->
    <div class="content mb-0" id="tab-group-2">
      <div class="tab-controls tabs-medium tabs-rounded" data-highlight="bg-highlight">
	  <a href="#" class="font-600 bg-highlight no-click" data-active="" data-bs-toggle="collapse" data-bs-target="#tab-1" aria-expanded="true">Open Meetings</a> 
	  <a href="#" class="font-600 collapsed" data-bs-toggle="collapse" data-bs-target="#tab-2" aria-expanded="false">Closed Meetings</a> </div>
      <div class="clearfix mb-3"></div>
      <div data-bs-parent="#tab-group-2" class="collapse show" id="tab-1">
        <div class="list-group">
          <?php
                                $currentDateTime = date("Y-m-d H:i:s");
       $sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id AND activity_type = 'Meeting'  AND status=1 ORDER BY lead_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
                                ?>
          <!-- File Item 2-->
          <div class="d-flex align-items-center justify-content-center">
            <div class="pe-3 "> 
			
			<a href="#" class="icon icon-xs rounded-sm shadow-l me-1 gradient-green color-white  d-flex align-items-center justify-content-center">
			<div ><i class="fa fa-calendar m-0 p-0"></i></div>
			</a>
			</div>
            <div class="align-self-start"> 
			<span class="color-theme font-11 opacity-60">Status </span><span class="font-11 color-blue-dark">
              <?=find_a_field('deal_status','status','id='.$row->status);?>
              </span>
              <h3 class="mt-n2 mb-n1 font-18">
                <?=$row->subject;?>
              </h3>
				<h3 class=" p-0 m-0 color-theme font-10 opacity-40 font-400">Meeting Location :<?=$row->location;?>	(<? if($row->meeting_type == 'Online'){ ?>
								ONLINE
								<? }elseif($row->meeting_type == 'Offline'){ ?>	   
								OFFLINE
								<? }else{ ?>
								No data
								<?  } ?>)
								</h3>
              <span class="color-theme font-10 opacity-40 font-400">Meeting on:
              <?=$task_date ;?>  <?=$formattedTime ?>
              </span>
					  
			  </div>
            <div class="align-self-center ms-auto"> <a href="#" data-bs-toggle="dropdown" class="icon icon-m color-theme"><i class="fa fa-ellipsis-h"></i></a>
              <div class="dropdown-menu border-0 bg-theme rounded-m shadow-xl px-2 mt-n4">
                <div class="list-group list-custom-small mt-n2 mb-n2"> <a href="#" data-menu="menu-transaction-1" onclick="taskedit('<?=$row->activity_id;?>')"><i class="fa font-14 fa-download color-blue-dark opacity-60"></i>Edit<i class="fa"></i></a> <a href="#" data-menu="menu-delete"><i class="fa font-14 fa-trash color-red-dark opacity-60"></i>Delete<i class="fa"></i></a> </div>
              </div>
            </div>
          </div>
		    
          <!-- End of File-->
		<div class="divider p-0 m-1"></div>
          <?php } ?>
        </div>
      </div>
      <div data-bs-parent="#tab-group-2" class="collapse" id="tab-2" >
        <div class="list-group">
                   <?php
                                $currentDateTime = date("Y-m-d H:i:s");
         $sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id AND activity_type = 'Meeting'  AND status in (2,3) ORDER BY lead_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
                                ?>
          <!-- File Item 2-->
          <div class="d-flex align-items-center justify-content-center">
            <div class="pe-3 "> 
			
			<a href="#" class="icon icon-xs rounded-sm shadow-l me-1 gradient-green color-white  d-flex align-items-center justify-content-center">
			<div ><i class="fa fa-calendar m-0 p-0"></i></div>
			</a>
			</div>
            <div class="align-self-start"> 
			<span class="color-theme font-11 opacity-60">Status </span><span class="font-11 color-blue-dark">
              <?=find_a_field('deal_status','status','id='.$row->status);?>
              </span>
              <h3 class="mt-n2 mb-n1 font-18">
                <?=$row->subject;?>
              </h3>
				<h3 class=" p-0 m-0 color-theme font-10 opacity-40 font-400">Meeting Location :<?=$row->location;?>	(<? if($row->meeting_type == 'Online'){ ?>
								ONLINE
								<? }elseif($row->meeting_type == 'Offline'){ ?>	   
								OFFLINE
								<? }else{ ?>
								No data
								<?  } ?>)
								</h3>
              <span class="color-theme font-10 opacity-40 font-400">Meeting on:
              <?=$task_date ;?>  <?=$formattedTime ?>
              </span>
					  
			  </div>
            <div class="align-self-center ms-auto"> <a href="#" data-bs-toggle="dropdown" class="icon icon-m color-theme"><i class="fa fa-ellipsis-h"></i></a>
              <div class="dropdown-menu border-0 bg-theme rounded-m shadow-xl px-2 mt-n4">
                <div class="list-group list-custom-small mt-n2 mb-n2"> <a href="#" data-menu="menu-archive"><i class="fa font-14 fa-archive color-brown-dark opacity-60"></i>Archive<i class="fa"></i></a> <a href="#" data-menu="menu-transaction-1" onclick="taskedit('<?=$row->activity_id;?>')"><i class="fa font-14 fa-download color-blue-dark opacity-60"></i>Edit<i class="fa"></i></a> <a href="#" data-menu="menu-delete"><i class="fa font-14 fa-trash color-red-dark opacity-60"></i>Delete<i class="fa"></i></a> </div>
              </div>
            </div>
          </div>
		    
          <!-- End of File-->
		<div class="divider p-0 m-1"></div>
          <?php } ?>
		  
		  
		  
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End of Meeting Activity-->











<!-- Start of  Call Activity Manage -->
<div class=" mb-0">
  <!-- Start of card-->
  <div class="card card-style">
    <div class="content mb-0">
      <h4 class="font-700 text-uppercase font-12 color-highlight opacity-70 mb-3 mt-n2">Call Activity</h4>
      <div class="position-absolute top-0 end-0 mt-3 me-3">
        <button class="fa fa-edit color-brown-dark" data-menu="editcallmodal" onclick="openModalEditTask('<?=$row->activity_id;?>')"></button>
      </div>
    </div>
    <!-- End of card-->
    <div class="content mb-0" id="tab-group-1">
      <div class="tab-controls tabs-medium tabs-rounded" data-highlight="bg-highlight">
	  <a href="#" class="font-600 bg-highlight no-click" data-active="" data-bs-toggle="collapse" data-bs-target="#tab-3" aria-expanded="true">Open Calls</a> 
	  <a href="#" class="font-600 collapsed" data-bs-toggle="collapse" data-bs-target="#tab-4" aria-expanded="false">Closed Calls</a> </div>
      <div class="clearfix mb-3"></div>
      <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-3">
        <div class="list-group">
          <?php
                                $currentDateTime = date("Y-m-d H:i:s");
         $sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id AND activity_type = 'Call'  AND status =1 ORDER BY lead_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
                                ?>
          <!-- File Item 2-->
          <div class="d-flex align-items-center justify-content-center">
            <div class="pe-3 "> 
			
			<a href="#" class="icon icon-xs rounded-sm shadow-l me-1 gradient-yellow color-white  d-flex align-items-center justify-content-center">
			<div ><i class="fa fa-phone m-0 p-0"></i></div>
			</a>
			</div>
            <div class="align-self-start"> 
			<span class="color-theme font-11 opacity-60">Status </span><span class="font-11 color-blue-dark">
              <?=find_a_field('deal_status','status','id='.$row->status);?>
              </span>
              <h3 class="mt-n2 mb-n1 font-18">
                <?=$row->subject;?>
              </h3>
			  				<h3 class="color-theme font-10 opacity-40 font-400">Call to :<?=$row->call_to;?>	(<? if($row->call_type == 'Inbound Call'){ ?>
								INBOUND CALL
								<? }elseif($row->call_type == 'Outbound Call'){ ?>	   
								OUTBOUND CALL
								<? }else{ ?>
								No data
								<?  } ?>)
								</h3>
              <span class="color-theme font-10 opacity-40 font-400">Call on:
              <?=$task_date ;?>  <?=$formattedTime ?>
              </span>
					  
			  </div>
            <div class="align-self-center ms-auto"> <a href="#" data-bs-toggle="dropdown" class="icon icon-m color-theme"><i class="fa fa-ellipsis-h"></i></a>
              <div class="dropdown-menu border-0 bg-theme rounded-m shadow-xl px-2 mt-n4">
                <div class="list-group list-custom-small mt-n2 mb-n2"><a href="#" data-menu="menu-transaction-1" onclick="taskedit('<?=$row->activity_id;?>')"><i class="fa font-14 fa-download color-blue-dark opacity-60"></i>Edit<i class="fa"></i></a> <a href="#" data-menu="menu-delete"><i class="fa font-14 fa-trash color-red-dark opacity-60"></i>Delete<i class="fa"></i></a> </div>
              </div>
            </div>
          </div>
		    
          <!-- End of File-->
		<div class="divider p-0 m-1"></div>
          <?php } ?>
        </div>
      </div>
      <div data-bs-parent="#tab-group-1" class="collapse" id="tab-4" >
        <div class="list-group">
                   <?php
                                $currentDateTime = date("Y-m-d H:i:s");
         $sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id AND activity_type = 'Call'  AND status in (2,3) ORDER BY lead_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
                                ?>
          <!-- File Item 2-->
          <div class="d-flex align-items-center justify-content-center">
            <div class="pe-3 "> 
			
			<a href="#" class="icon icon-xs rounded-sm shadow-l me-1 gradient-yellow color-white  d-flex align-items-center justify-content-center">
			<div ><i class="fa fa-phone m-0 p-0"></i></div>
			</a>
			</div>
            <div class="align-self-start"> 
			<span class="color-theme font-11 opacity-60">Status </span><span class="font-11 color-blue-dark">
              <?=find_a_field('deal_status','status','id='.$row->status);?>
              </span>
              <h3 class="mt-n2 mb-n1 font-18">
                <?=$row->subject;?>
              </h3>
				  				<h3 class="color-theme font-10 opacity-40 font-400">Call to :<?=$row->call_to;?>	(<? if($row->call_type == 'Inbound Call'){ ?>
								INBOUND CALL
								<? }elseif($row->call_type == 'Outbound Call'){ ?>	   
								OUTBOUND CALL
								<? }else{ ?>
								No data
								<?  } ?>)
								</h3>
              <span class="color-theme font-10 opacity-40 font-400">Call on:
              <?=$task_date ;?>  <?=$formattedTime ?>
              </span>
					  
			  </div>
            <div class="align-self-center ms-auto"> <a href="#" data-bs-toggle="dropdown" class="icon icon-m color-theme"><i class="fa fa-ellipsis-h"></i></a>
              <div class="dropdown-menu border-0 bg-theme rounded-m shadow-xl px-2 mt-n4">
                <div class="list-group list-custom-small mt-n2 mb-n2"> <a href="#" data-menu="menu-archive"><i class="fa font-14 fa-archive color-brown-dark opacity-60"></i>Archive<i class="fa"></i></a> <a href="#" data-menu="menu-transaction-1" onclick="taskedit('<?=$row->activity_id;?>')"><i class="fa font-14 fa-download color-blue-dark opacity-60"></i>Edit<i class="fa"></i></a> <a href="#" data-menu="menu-delete"><i class="fa font-14 fa-trash color-red-dark opacity-60"></i>Delete<i class="fa"></i></a> </div>
              </div>
            </div>
          </div>
		    
          <!-- End of File-->
		<div class="divider p-0 m-1"></div>
          <?php } ?>
		  
		  
		  
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End of Meeting Activity-->







<!-- Start of  Task Activity Manage -->
<div class=" mb-0">
  <!-- Start of card-->
  <div class="card card-style">
    <div class="content mb-0">
      <h4 class="font-700 text-uppercase font-12 color-highlight opacity-70 mb-3 mt-n2">Task Activity</h4>
      <div class="position-absolute top-0 end-0 mt-3 me-3">
        <button class="fa fa-edit color-brown-dark" data-menu="edittaskmodal" onclick="openModalEditTask('<?=$row->activity_id;?>')"></button>
      </div>
    </div>
    <!-- End of card-->
    <div class="content mb-0" id="tab-group-1">
      <div class="tab-controls tabs-medium tabs-rounded" data-highlight="bg-highlight">
	  <a href="#" class="font-600 bg-highlight no-click" data-active="" data-bs-toggle="collapse" data-bs-target="#tab-5" aria-expanded="true">Open Tasks</a> 
	  <a href="#" class="font-600 collapsed" data-bs-toggle="collapse" data-bs-target="#tab-6" aria-expanded="false">Closed Tasks</a> </div>
      <div class="clearfix mb-3"></div>
      <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-5">
        <div class="list-group">
          <?php
                                $currentDateTime = date("Y-m-d H:i:s");
         $sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id AND activity_type = 'Task'  AND status =1 ORDER BY lead_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
                                ?>
          <!-- File Item 2-->
          <div class="d-flex align-items-center justify-content-center">
            <div class="pe-3 "> 
			
			<a href="#" class="icon icon-xs rounded-sm shadow-l me-1 bg-phone  d-flex align-items-center justify-content-center">
			<div ><i class="fa fa-calendar m-0 p-0"></i></div>
			</a>
			</div>
            <div class="align-self-start"> 
			<span class="color-theme font-11 opacity-60">Status </span><span class="font-11 color-blue-dark">
              <?=find_a_field('deal_status','status','id='.$row->status);?>
              </span>
              <h3 class="mt-n2 mb-n1 font-18">
                <?=$row->subject;?>
              </h3>

              <span class="color-theme font-10 opacity-40 font-400">Call on:
              <?=$task_date ;?>  <?=$formattedTime ?>
              </span>
					  
			  </div>
            <div class="align-self-center ms-auto"> <a href="#" data-bs-toggle="dropdown" class="icon icon-m color-theme"><i class="fa fa-ellipsis-h"></i></a>
              <div class="dropdown-menu border-0 bg-theme rounded-m shadow-xl px-2 mt-n4">
                <div class="list-group list-custom-small mt-n2 mb-n2"> <a href="#" data-menu="menu-transaction-1" onclick="taskedit('<?=$row->activity_id;?>')"><i class="fa font-14 fa-download color-blue-dark opacity-60"></i>Edit<i class="fa"></i></a> <a href="#" data-menu="menu-delete"><i class="fa font-14 fa-trash color-red-dark opacity-60"></i>Delete<i class="fa"></i></a> </div>
              </div>
            </div>
          </div>
		    
          <!-- End of File-->
		<div class="divider p-0 m-1"></div>
          <?php } ?>
        </div>
      </div>
      <div data-bs-parent="#tab-group-1" class="collapse" id="tab-6" >
        <div class="list-group">
                   <?php
                                $currentDateTime = date("Y-m-d H:i:s");
         $sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id AND activity_type = 'Task'  AND status in (2,3) ORDER BY lead_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
                                ?>
          <!-- File Item 2-->
          <div class="d-flex align-items-center justify-content-center">
            <div class="pe-3 "> 
			
			<a href="#" class="icon icon-xs rounded-sm shadow-l me-1 bg-phone  d-flex align-items-center justify-content-center">
			<div ><i class="fa fa-calendar m-0 p-0"></i></div>
			</a>
			</div>
            <div class="align-self-start"> 
			<span class="color-theme font-11 opacity-60">Status </span><span class="font-11 color-blue-dark">
              <?=find_a_field('deal_status','status','id='.$row->status);?>
              </span>
              <h3 class="mt-n2 mb-n1 font-18">
                <?=$row->subject;?>
              </h3>

              <span class="color-theme font-10 opacity-40 font-400">Call on:
              <?=$task_date ;?>  <?=$formattedTime ?>
              </span>
					  
			  </div>
            <div class="align-self-center ms-auto"> <a href="#" data-bs-toggle="dropdown" class="icon icon-m color-theme"><i class="fa fa-ellipsis-h"></i></a>
              <div class="dropdown-menu border-0 bg-theme rounded-m shadow-xl px-2 mt-n4">
                <div class="list-group list-custom-small mt-n2 mb-n2"> <a href="#" data-menu="menu-archive"><i class="fa font-14 fa-archive color-brown-dark opacity-60"></i>Archive<i class="fa"></i></a> <a href="#" data-menu="menu-transaction-1" onclick="taskedit('<?=$row->activity_id;?>')"><i class="fa font-14 fa-download color-blue-dark opacity-60"></i>Edit<i class="fa"></i></a> <a href="#" data-menu="menu-delete"><i class="fa font-14 fa-trash color-red-dark opacity-60"></i>Delete<i class="fa"></i></a> </div>
              </div>
            </div>
          </div>
		    
          <!-- End of File-->
		<div class="divider p-0 m-1"></div>
          <?php } ?>
		  
		  
		  
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End of Meeting Activity-->






<?php /*?><!-- Start of  Task Activity Manage -->
<div class=" mb-0">
  <!-- Start of card-->
  <div class="card card-style">
    <div class="content mb-0">
      <h4 class="font-700 text-uppercase font-12 color-highlight opacity-70 mb-3 mt-n2">Task Activity</h4>
      <div class="position-absolute top-0 end-0 mt-3 me-3">
        <button class="fa fa-edit color-brown-dark" data-menu="edittaskmodal" onclick="openModalEditTask('<?=$row->activity_id;?>')"></button>
      </div>
    </div>
    <!-- End of card-->
    <div class="content mb-0" id="tab-group-1">
      <div class="tab-controls tabs-medium tabs-rounded" data-highlight="bg-highlight">
	  <a href="#" class="font-600 bg-highlight no-click" data-active="" data-bs-toggle="collapse" data-bs-target="#tab-1" aria-expanded="true">Open Task</a> 
	  <a href="#" class="font-600 collapsed" data-bs-toggle="collapse" data-bs-target="#tab-2" aria-expanded="false">Closed Task</a> </div>
      <div class="clearfix mb-3"></div>
      <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1" style="">
        <div class="list-group list-custom-small">
          <?php
                                $currentDateTime = date("Y-m-d H:i:s");
         $sqlTasks = "SELECT * FROM crm_lead_activity_manage a WHERE lead_id = $id AND activity_type = 'Task'  AND status != 'cancelled' ORDER BY lead_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
                                ?>
          <!-- File Item 2-->
          <div class="d-flex ">
            <div class="pe-3  align-self-center"> 
			
			<a href="#" class="icon icon-xs rounded-sm shadow-l me-1 bg-phone">
			<div ><i class="fa fa-phone"></i></div>
			</a>
			</div>
            <div class="align-self-start"> 
			<span class="color-theme font-11 opacity-60 font-600">Status <span class="color-blue-dark">
              <?=find_a_field('crm_lead_status','status','id='.$row->status);?>
              </span>
              <h3 class="mt-n2 mb-n1 font-18">
                <?=$row->subject;?>
              </h3>
              <span class="color-theme font-10 opacity-40 font-400">Meeting on:
              <?=$task_date ;?>  <?=$formattedTime ?>
              </span>
					  
			  </div>
            <div class="align-self-center ms-auto"> <a href="#" data-bs-toggle="dropdown" class="icon icon-m color-theme"><i class="fa fa-ellipsis-h"></i></a>
              <div class="dropdown-menu border-0 bg-theme rounded-m shadow-xl px-2 mt-n4">
                <div class="list-group list-custom-small mt-n2 mb-n2"> <a href="#" data-menu="menu-archive"><i class="fa font-14 fa-archive color-brown-dark opacity-60"></i>Archive<i class="fa"></i></a> <a href="#" data-menu="menu-transaction-1" onclick="taskedit('<?=$row->activity_id;?>')"><i class="fa font-14 fa-download color-blue-dark opacity-60"></i>Edit<i class="fa"></i></a> <a href="#" data-menu="menu-delete"><i class="fa font-14 fa-trash color-red-dark opacity-60"></i>Delete<i class="fa"></i></a> </div>
              </div>
            </div>
          </div>
          <!-- End of File-->
          <div class="pb-3"></div>
          <?php } ?>
        </div>
      </div>
      <div data-bs-parent="#tab-group-1" class="collapse" id="tab-2" style="">
        <div class="list-group list-custom-small">
          <!-- File Item 2-->
          <div class="d-flex">
            <div class="pe-3 align-self-center"> <i class="fa fa-file-archive fa-4x color-yellow-dark"></i> </div>
            <div class="align-self-center"> <span class="color-theme font-11 opacity-60 font-600">Assigned to you by <span class="color-blue-dark">John</span></span>
              <h3 class="mt-n2 mb-n1 font-18">Complete Assets</h3>
              <span class="color-theme font-10 opacity-40 font-400">Uploaded on: 15h Dec - 175 mb</span> </div>
            <div class="align-self-center ms-auto"> <a href="#" data-bs-toggle="dropdown" class="icon icon-m color-theme"><i class="fa fa-ellipsis-h"></i></a>
              <div class="dropdown-menu border-0 bg-theme rounded-m shadow-xl px-2 mt-n4">
                <div class="list-group list-custom-small mt-n2 mb-n2"> <a href="#" data-menu="menu-archive"><i class="fa font-14 fa-archive color-brown-dark opacity-60"></i>Archive<i class="fa"></i></a> <a href="#" data-menu="menu-download"><i class="fa font-14 fa-download color-blue-dark opacity-60"></i>Edit<i class="fa"></i></a> <a href="#" data-menu="menu-delete"><i class="fa font-14 fa-trash color-red-dark opacity-60"></i>Delete<i class="fa"></i></a> </div>
              </div>
            </div>
          </div>
          <!-- End of File-->
          <div class="pb-3"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End of Task Activity-->
<?php */?>







</div>


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
							
							
						  function openModalEditTask(activityId) {
                                console.log(activityId)
                                document.getElementById('activity_id').value = activityId;
                             // or 'inline' depending on your 
                        
                        
                            }
							
							
							function taskedit(activityId) {
                                console.log(activityId)
                                document.getElementById('activity_id').value = activityId;
                             // or 'inline' depending on your 
                        
                        
                            }
							
							
							
							
							function openModalEditall(activityId) {
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
<!-- ___________ add product Edit Menu Start _________  -->
<div id="addProduct" class="menu menu-box-modal menu-box-detached">
  <form method="post">
    <div class="modal-body">
      <input type="hidden" name="product_individual_id" id="product_individual_id" value="" />
      <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
      <div class="menu-title">
        <h1>Add Product</h1>
        <p class="color-highlight">
          <?=$orgname?>
        </p>
        <a href="#" class="close-menu"><i class="fa fa-times"></i></a> </div>
      <div class="divider divider-margins mb-1 mt-3"></div>
      <div class="content px-1">
        <div class="input-style input-style-always-active no-borders no-icon">
          <label for="f1" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Product Name</label>
          <select class="form-control req" name="product_id" id="product_id">
            <? foreign_relation('crm_lead_products','id','products',$product,'1'); ?>
          </select>
          <span><i class="fa fa-chevron-down"></i></span> <i class="fa fa-check disabled valid color-green-dark"></i> <em></em> </div>
        <input name="productadd" type="submit" id="productadd" value="Add Product" class="close-menu btn btn-full btn-m bg-highlight rounded-sm text-uppercase font-800 mb-3 width-100">
      </div>
    </div>
  </form>
</div>
<!-- _________________________  EDIT OPTION END      ______________________-->
<!-- Edit Meeting Modal -->


<div id="editmeetingmodal" class="menu menu-box-modal menu-box-detached">
  <div class="menu-title">
    <h1> Meeting Info</h1>
    <p class="color-highlight">add metting Details</p>
    <a href="#" class="close-menu"><i class="fa fa-times"></i></a> </div>
  <div class="divider divider-margins mt-3 mb-2"></div>
  <div class="content px-1">
    <form method="post" action="">
      <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
      <input type="hidden" name="activity_type" value="Meeting" />
      <input type="hidden" name="main" value="1" />
      <input type="hidden" name="status" value="1" />
      <input type="hidden" name="activity_id" id="activity_id" value="" />
     
       <div class="input-style has-borders no-icon mb-4">
        <input id="task_details_edit" name="subject" placeholder="Meeting Title">
        <label for="task_details_edit" class="color-highlight">Meeting Title</label>
      </div>
      
      
      <div class="input-style has-borders no-icon mb-4">
        <input id="task_details_edit" name="location" placeholder="Meeting location">
        <label for="task_details_edit" class="color-highlight">Meeting Location</label>
      </div>
      
      
      <div class="input-style has-borders no-icon mb-4">
        <textarea id="task_details_edit" name="details" placeholder="Meeting Details"></textarea>
        <label for="task_details_edit" class="color-highlight">Meeting Details</label>
      </div>
     <div class="row">
    <div class="col-md-6">
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
    </div>
    <div class="col-md-6">
        <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="form5" class="color-highlight">Meeting Type</label>
            <select class="form-control req" name="meeting_type" id="form5" required>
                <option value="Online">Online</option>
                <option value="Offline">Offline</option>
            </select>
        </div>
    </div>
</div>

        
        
      <!--<h5 class="mb-2 font-15 mt-2">Task</h5>-->
      <div class="row mb-0">
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="task_time_edit" class="color-highlight text-uppercase font-700 font-10 mt-1">Meeting Time</label>
            <input type="time" name="time" class="form-control validate-text" id="task_time_edit">
          </div>
        </div>
        
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="task_date_edit" class="color-highlight text-uppercase font-700 font-10 mt-1">Meeting Date</label>
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
      <button type="submit" name="scCall1" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Confirm</button>
    </form>
  </div>
</div>






<!-- Edit Meeting Modal -->












<!-- Edit Call Modal -->


<div id="editcallmodal" class="menu menu-box-modal menu-box-detached">
  <div class="menu-title">
    <h1> Call Info</h1>
    <p class="color-highlight">Add Call Details</p>
    <a href="#" class="close-menu"><i class="fa fa-times"></i></a> </div>
  <div class="divider divider-margins mt-3 mb-2"></div>
  <div class="content px-1">
    <form method="post" action="">
      <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
      <input type="hidden" name="activity_type" value="Call" />
      <input type="hidden" name="main" value="1" />
      <input type="hidden" name="status" value="1" />
      <input type="hidden" name="activity_id" id="activity_id" value="" />
     
     
      <div class="input-style has-borders no-icon mb-4">
        <input id="task_details_edit" name="call_to" placeholder="Call To">
        <label for="call_to" class="color-highlight">Call To</label>
      </div>
      
      
       <div class="input-style has-borders no-icon mb-4">
        <input id="task_details_edit" name="subject" placeholder="Call Subject">
        <label for="task_details_edit" class="color-highlight">Call Subject</label>
      </div>
      
      

      
      
      <div class="input-style has-borders no-icon mb-4">
        <textarea id="task_details_edit" name="details" placeholder="Call Details"></textarea>
        <label for="task_details_edit" class="color-highlight">Call Details</label>
      </div>
     <div class="row">
    <div class="col-md-6">
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
    </div>
    <div class="col-md-6">
        	<div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="form5" class="color-highlight">Call type:</label>
               
					
					 <select class="form-control req" name="call_type" id="form5" required>
                                            <option value="default" disabled="" selected="">Select a Value</option>
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

        
        
      <!--<h5 class="mb-2 font-15 mt-2">Task</h5>-->
      <div class="row mb-0">
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="task_time_edit" class="color-highlight text-uppercase font-700 font-10 mt-1">Call Time</label>
            <input type="time" name="time" class="form-control validate-text" id="task_time_edit">
          </div>
        </div>
        
        <div class="col-6">
          <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="task_date_edit" class="color-highlight text-uppercase font-700 font-10 mt-1">Call Date</label>
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
      <button type="submit" name="scCall1" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Confirm</button>
    </form>
  </div>
</div>






<!-- Edit Call Modal -->









<!-- Edit Task Modal -->
<div id="edittaskmodal" class="menu menu-box-modal menu-box-detached">
  <div class="menu-title">
    <h1>Edit Task</h1>
    <p class="color-highlight">Edit Task Details</p>
    <a href="#" class="close-menu"><i class="fa fa-times"></i></a> </div>
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
        <span class="disabled"><i class="fa fa-chevron-down"></i></span> <i class="fa fa-check valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
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
      <button type="submit" name="scCall1" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Confirm</button>
    </form>
  </div>
</div>
<!-- Edit Email Modal -->















<div id="editemailmodal" class="menu menu-box-modal menu-box-detached">
  <div class="menu-title">
    <h1>Edit Email</h1>
    <p class="color-highlight">Edit Email Details</p>
    <a href="#" class="close-menu"><i class="fa fa-times"></i></a> </div>
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
        <span class="disabled"><i class="fa fa-chevron-down"></i></span> <i class="fa fa-check valid color-green-dark"></i> <i class="fa fa-check disabled invalid color-red-dark"></i> <em></em> </div>
      <div class="input-style has-borders no-icon validate-field mb-4">
        <input type="email" name="email_to" class="form-control validate-text" id="email_to_edit" placeholder="Email to">
        <label for="email_to_edit" class="color-highlight">Email to:</label>
        <i class="fa fa-times disabled invalid color-red-dark"></i> <i class="fa fa-check disabled valid color-green-dark"></i> <em>(required)</em> </div>
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
<? require_once '../assets/template/inc.footer.php'; ?>
