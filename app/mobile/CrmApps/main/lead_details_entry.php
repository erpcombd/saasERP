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
 $tablecontact = 'crm_lead_manage';
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
		$crudcontact1->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
		
		
		    // Display the message in a JavaScript alert
    echo "<script type='text/javascript'>alert('$msg');</script>";
	
		echo "<script>window.top.location='../main/leads.php'</script>";
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




        
  <div class="page-content header-clear-medium">
  

  
  <div class="card card-style mb-3">
    <div class="content">
        <h1> Lead Information </h1>
      	<form method="post" action="">  
        <div class="row">
            
            
    
            
            
            
              <div class="col-6">
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="leadStatus" class="color-highlight">Select Lead Owner</label>
                  	<select class="form-select"  name="lead_owner" id="lead_owner" required>
                                <option>Select Lead Owner</option>
                                <?=foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME','1');?>
                            </select>				
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
            </div>
            
            
			
            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-building"></i> 
                    <input type="text" class="form-control validate-name" name="company_name" id="company_name" placeholder="Company Name">
					
                    <label for="companyName" class="color-highlight">Company Name</label>

                </div>
            </div>

            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-user"></i>  
                    <input type="text" class="form-control validate-name" name="first_name" id="first_name" placeholder="First Name">
                    <label for="firstName" class="color-highlight">First Name</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>

            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-user"></i>  
                    <input type="text" class="form-control validate-name" name="last_name" id="last_name" placeholder="Last Name">
                    <label for="lastName" class="color-highlight">Last Name</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>

            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-briefcase"></i> 
                    <input type="text" class="form-control validate-name" name="title" id="title" placeholder="Title">
                    <label for="title" class="color-highlight">Title</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>

            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-envelope"></i> 
                    <input type="email" class="form-control validate-name" name="email" id="email" placeholder="Email">
                    <label for="email" class="color-highlight">Email</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>
			<div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-envelope"></i> 
                    <input type="email" class="form-control validate-name" name="secondary_email" id="secondary_email" placeholder="Secondary Email">
                    <label for="email" class="color-highlight">Secondary Email</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>

            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-phone"></i> 
                    <input type="text" class="form-control validate-name" name="phone" id="phone" placeholder="Phone">
                    <label for="phone" class="color-highlight">Phone</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>

            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-globe"></i> 
                    <input type="text" class="form-control validate-name" name="website" id="website" placeholder="Website">
                    <label for="website" class="color-highlight">Website</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>
            
            <div class="col-6">
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="leadSource" class="color-highlight">Lead Source</label>
                    <select class="form-control req" name="lead_source" id="lead_source" required>
                        <option value=""></option>
						<?=foreign_relation('crm_lead_source','id','source','1');?>
                    </select>				
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
            </div>
			
            <div class="col-6">
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="leadStatus" class="color-highlight">Lead Status</label>
                    <select class="form-control req" name="lead_status" id="lead_status" required>
                        <option value=""></option>
							<?=foreign_relation('crm_lead_status_manage','id','status','1');?>
                    </select>				
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
            </div>
			
            <div class="col-6">
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="industry" class="color-highlight">Industry</label>
                    <select class="form-control req" name="industry" id="industry" required>
                        <option value=""></option>
						<?=foreign_relation('crm_company_category','id','category_name','1');?>
                    </select>				
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
            </div>

            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-users"></i> 
                    <input type="text" class="form-control validate-name" name="no_of_employees" id="no_of_employees" placeholder="No. of Employees">
                    <label for="employees" class="color-highlight">No. of Employees</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>

            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-envelope"></i> 
                    <input type="email" class="form-control validate-name" id="secondaryEmail" placeholder="Secondary Email">
                    <label for="secondaryEmail" class="color-highlight">Secondary Email</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>
			<div class="col-6">
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="Rating" class="color-highlight">Rating</label>
                    <select class="form-control req" name="rating" id="rating" required>
                        <option value=""></option>
						<?=foreign_relation('crm_lead_rating_status','id','status','1');?>
                    </select>				
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
            </div>

        </div>

        <h1> Address Information </h1>
        
        <div class="row">
            <div class="col-6">
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="division" class="color-highlight">Division</label>
                    <select class="form-control req" name="division" id="division" required>
                        <option value=""></option>
						<?=foreign_relation('division','division_id','division_name','1');?>
                    </select>				
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
            </div>
			
            <div class="col-6">
                <div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="district" class="color-highlight">District</label>
                    <select class="form-control req" name="district" id="district" required>
                        <option value=""></option>
						<?=foreign_relation('district_list','id','district_name','1');?>
                    </select>				
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
            </div>

            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-map-marker-alt"></i> 
                    <input type="text" class="form-control validate-name" name="street_address" id="street_address" placeholder="Street Address">
                    <label for="streetAddress" class="color-highlight">Street Address</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>

            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-map-marker-alt"></i> 
                    <input type="text" class="form-control validate-name" name="zip_code" id="zip_code" placeholder="Zip Code">
                    <label for="zipCode" class="color-highlight">Zip Code</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>

            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-map-marker-alt"></i> 
                    <input type="text" class="form-control validate-name" name="city" id="city" placeholder="City">
                    <label for="city" class="color-highlight">City</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>

            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-globe"></i> 
                    <input type="text" class="form-control validate-name" name="country" id="country" placeholder="Country">
                    <label for="country" class="color-highlight">Country</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>
<h1> Contact Information </h1>
        
        <div class="row">
            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-user"></i>
                    <input type="text" class="form-control validate-name" name="contact_person" id="contact_person" placeholder="Person">
                    <label for="form1" class="color-highlight">Person</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>

            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-phone"></i>
                    <input type="text" class="form-control validate-name" name="contact_number" id="contact_number" placeholder="Number">
                    <label for="form1" class="color-highlight">Number</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>
            
            <div class="col-6">
                <div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-envelope"></i>
                    <input type="email" class="form-control validate-name" name="contact_email " id="contact_email" placeholder="Email">
                    <label for="form1" class="color-highlight">Email</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
            </div>

        </div>
				<div class="input-style has-borders no-icon validate-field mb-4">
                    
                    <label for="form1" class="color-highlight">Description Information</label>
   					<textarea class="form-control validate-name" name="description_information" id="description_information" placeholder="Description Information"></textarea>
					
                </div>
		<button type="submit" name="submitinfo" class="btn btn-m btn-full bg-blue-dark text-uppercase font-700 rounded-sm"> Submit </button>
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
     
    
 <? require_once '../assets/template/inc.footer.php'; ?>