<? 


session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

require_once '../assets/support/Calendar.php';
//require_once '../assets/support/crud.php';
require_once '../assets/support/custom.php';

require_once '../assets/support/mix_function.php';
require_once '../assets/support/reg__ajax.php';


$title = "Task Information";
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
 $tablecontact = 'crm_lead_activity';
 $tableproductadd = 'crm_lead_product_individual';

 $uniqueproduct="product_individual_id";



 $crudcontact1 = new crud($tablecontact);
 $crudproductadd1 = new crud($tableproductadd);

$pbi_id  =  $_SESSION['employee_selected'];
$user_role  =  $_SESSION['user']['fname'];


 $table2 = 'crm_task_lists';


 $id = decrypTS($_GET['view']);
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



if(isset($_POST['submitinfo']))
{

$_POST['entry_by']=$_SESSION['user']['id'];
   $person_ids = $_POST['person_ids'];
    $_POST['assign_person'] = implode(",", $person_ids);
	
		$crudcontact1->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
		
		
		    // Display the message in a JavaScript alert
       /* echo "<script type='text/javascript'>alert('$msg');</script>";*/
    echo "<script>window.top.location='../file/task_manage.php'</script>";
}


if (isset($_POST['scCall'])) {

	$crud   = new crud('crm_lead_activity');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();

	

	echo "<script>window.top.location='../info_maker/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

}
if(isset($_POST['updatecontact']))
{


$_POST['edit_at']=time();
$_POST['edit_by']=$_SESSION['user']['id'];
		$crudcontact1->update('id');
		$type=1;
		$msg='Successfully Updated.';
        echo "<script>window.top.location='../info_maker/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}


if(isset($_POST['updateTasks']))
{

    $crud   = new crud('crm_task_add_information');
        $_POST['edit_at']=time();
        $_POST['edit_by']=$_SESSION['user']['id'];
        $crud->update('task_id');
		$type=1;
		$msg='Successfully Updated.';
         echo "<script>window.top.location='../info_maker/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
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
         echo "<script>window.top.location='../info_maker/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";
}

if(isset($_POST['deleteproduct']))
{
       
        $product_individual_id = $_POST['product_individual_id'];

        
        $deletesql = "DELETE FROM crm_lead_product_individual WHERE product_individual_id = " . $product_individual_id;
        db_query($deletesql);
        $tr_type = "Delete";
        $type = 1;
        $msg = 'Successfully Deleted.';
        echo "<script>window.top.location='../info_maker/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

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
        echo "<script>window.top.location='../info_maker/lead_details_show.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";


}

?>
<style>
.select2-container--default .select2-search--inline .select2-search__field {
    background: transparent;
    border: none !important;
    outline: 0;
    box-shadow: none;
    -webkit-appearance: textfield;
}
</style>



        
  <div class="page-content header-clear-medium">
  

  
  <div class="card card-style mb-3">
    <div class="content m-0">
      	<form method="post" action="">  
        <div class="row mb-3">
		
            <div class="col-6">
							<input type="hidden" name="mode" value="postsale"/>
							<input type="hidden" name="activity_type" value="Task" />
							<input type="hidden" name="status" value="1"/>
							<label for="form4">Task Name :</label>
						   <input type="text" class="form-control validate-text" name="subject" id="subject" placeholder="Task Name">
            </div>
			
			
			
			<div class="col-6">
                    <label for="project_id">Project Name :</label>
                  <select class="form-control validate-text req" name="project_id" id="project_id">
					  <option value=""></option>
					  <? foreign_relation('crm_project_org','id','name',$project_id,'1'); ?>
					</select>				

            </div>
			
			
			
            <div class="col-12">
            		<label for="companyName" >Task Details :</label>
					<textarea class="form-control validate-text" name="details" id="details" placeholder="Task Details"></textarea>
            </div>
			
			
			
			<div class="col-12">
                    <label for="emp_id1" >Person Name :</label>
                       <select class="form-control validate-text req" name="person_ids[]" id="emp_id1" multiple >
						  <option value=""></option>
						  <?php foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_ID," - ",PBI_NAME)', $PBI_ID, '1'); ?>
						</select>				
            </div>
			
			
		

        </div>

        <h1 align="center"> Task Date & Deadline </h1>
        
        <div class="row">
		
            <div class="col-6">
                    <label for="district" >Task Date</label>
                   <input type="date" name="date" class="form-control validate-text" id="form-6">				
            </div>
			
			
			
			
			
			
            <div class="col-6">
                    <label for="district">Deadline</label>
                   <input type="date" name="deadline" class="form-control validate-text" id="form-6">	
            </div>

            

            

            

            
			
			
			
		<h3 align="center" class="mt-3"> Reminder Day</h3>
        
        <div class="col-6">

                    <label for="district">Reminder Date</label>
                   <input type="date" name="remainder_date" class="form-control validate-text" id="form-6">				
            </div>
			
			

            <div class="col-6">
                <label for="Rating" >Priority</label>
                <select class="form-control validate-text req" name="priority_status" id="rating" required>
                <option value="LOW"> <span class="flag flag-low">LOW</span> </option>
                <option value="MEDIUM"> <span class="flag flag-medium">MEDIUM</span> </option>
                <option value="HIGH"> <span class="flag flag-high">HIGH</span> </option>
              </select>
			  
            </div>

				
		<button type="submit" name="submitinfo" class="btn btn-m btn-full bg-blue-dark text-uppercase font-700 rounded-sm mt-3"> Submit </button>
    </div>
</form>
</div>
 

  
    <!-- End of Page Content--> 

	
	






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
     
    
 <? require_once '../assets/template/inc.footer.php'; 
    selected_erp("#emp_id1");
    selected_erp("#project_id");
    
 ?>