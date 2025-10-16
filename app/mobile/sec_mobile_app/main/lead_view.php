<? 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';
$cid = $_SESSION['proj_id'];

$user_id	=$_SESSION['user_id'];
//$page="home";


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
  
  
              <?php
					$sqlTasks = "SELECT l.organization,l.lead_name,l.lead_value, l.assign_person, l.product, l.property_type, l.status, l.campaign,  l.req_loc, l.req_size, l.customer_bud, l.req_loan, l.cus_remarks, l.visitor_type, l.lead_source, l.lead_doc1, l.lead_doc2, l.lead_doc3, l.reamarks, o.id, o.assigned_person_id, o.name, o.website, o.total_employees, o.annual_revenue, o.lead_source, o.lead_type, o.company_name, o.address, o.city, o.zip, o.country, o.division, o.district, o.description, o.logo, o.visiting_card_img, o.product, o.lead FROM crm_project_lead l, crm_project_org o WHERE  l.organization =o.id AND l.id= ".$id."";
					$resultTasks = db_query($sqlTasks);
					if($row = mysqli_fetch_object($resultTasks)) { ?>
					
					
  
  <div data-card-height="230" class="card card-style round-medium shadow-huge top-30">
            <div class="card-top mt-3 ms-3">
                <h2 class="color-white pt-3 pb-3"><?=$orgname?></h2>
                <p class="color-white font-10 opacity-80 mb-n1"><i class="far fa-calendar"></i> August 28 <i class="ms-4 far fa-clock"></i> 09:00 PM</p>
                <p class="color-white font-10 opacity-80"><i class="fa fa-map-marker-alt"></i> Melbourne, Victoria, Australia Collins Street</p>
            </div>
            <div class="card-top mt-3 me-3">
                <a href="#" class="float-end bg-white color-black btn btn-s rounded-xl font-900 mt-2 text-uppercase font-11">Join Event</a>
            </div>
            <div class="card-bottom pb-3 pe-4">
                <div class="float-end">
                    <h4 class="font-12 color-white font-400 opacity-50">John, and 143 more are attending</h4>
                    <img class="shadow-xl rounded-xl preload-img float-end" width="40" src="../images/empty.png" data-src="images/pictures/faces/1s.png">
                    <img class="shadow-xl rounded-xl preload-img float-end" width="40" src="../images/empty.png" data-src="images/pictures/faces/2s.png">
                    <img class="shadow-xl rounded-xl preload-img float-end" width="40" src="../images/empty.png" data-src="images/pictures/faces/3s.png">
                </div>
            </div>
            <div class="card-bottom ms-3 mb-3">
                <img data-src="../images/pictures/faces/4small.png" alt="img" width="40" class="pb-1 preload-img shadow-xl rounded-m">
            </div>
            <div class="card-bottom mb-n3 ps-5 ms-4">
                <h5 class="font-13 color-white mb-n1">Jack's Cousin</h5>
                <p class="color-white font-10 opacity-70">Event Creator</p>
            </div>
            <div class="card-overlay bg-highlight opacity-90"></div>
            <div class="card-overlay bg-gradient"></div>
        </div>

           <?php } ?>

	
	<div class="content">
			<div class="d-flex text-center px-2">
				<div class="me-auto">
					<a href="#" data-menu="menu-add-funds" class="icon icon-xxl bg-theme gradient-green color-white shadow-l rounded-m"><i class="fa fa-plus"></i></a>
					<span class="font-11 font-500 color-theme d-block">Metting</span>
				</div>
				
				
				<div class="m-auto">
					<a href="#" data-menu="schedulecall" class="icon icon-xxl bg-theme gradient-blue color-white shadow-l rounded-m"><i class="fa fa-arrow-down"></i></a>
					<span class="font-11 font-500 color-theme d-block">Call</span>
				</div>
				
				
				<div class="m-auto">
					<a href="#" data-menu="menu-transaction-transfer" class="icon icon-xxl bg-theme gradient-red color-white shadow-l rounded-m"><i class="fa fa-arrow-up"></i></a>
					<span class="font-11 font-500 color-theme d-block">Visit</span>
				</div>
				
				<div class="m-auto">
					<a href="#" data-menu="menu-transaction-transfer" class="icon icon-xxl bg-theme gradient-red color-white shadow-l rounded-m"><i class="fa fa-arrow-up"></i></a>
					<span class="font-11 font-500 color-theme d-block">Email</span>
				</div>
				
				
				<div class="ms-auto">
					<a href="#" data-menu="menu-transaction-convert" class="icon icon-xxl bg-theme gradient-yellow color-white shadow-l rounded-m"><i class="far fa-sync"></i></a>
					<span class="font-11 font-500 color-theme d-block">Add a Task</span>
				</div>
			</div>
		</div>
		
		
		
		
                
        <div class="tab-group-1">
            <div class="card card-style">
                <div class="content mb-0">
                    <h3>Sort Tasks</h3>
                    <p>
                        Using tabs, you can sort your tasks based on their status. You can use any text or icon for sorting.
                    </p>
                    <div class="divider mb-0"></div>
                </div>
                <div class="tab-controls content tabs-small tabs-rounded" data-highlight="bg-blue-dark">
                    <a href="#" data-active data-bs-toggle="collapse" data-bs-target="#tab-1">All</a>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-2">Complete</a>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-3">Upcoming</a>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-4">Overdue</a>
                </div>
            </div>

            <div class="content" id="tab-group-1">
                    <!-- Tab -->                
                    <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1"> 
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Payment Gateways</h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">5/10 Tasks Completed</p>
                                <p class="mb-0">
                                    Integration of payment gateways to Project
                                </p>

                                <span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
                                <span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">HIGH PRIORITY</span>

                                <div class="divider mb-3 mt-3"></div>
                                <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/1s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/2s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/3s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">

                                <div class="divider mt-3 mb-2"></div>
                                <div class="row mb-n2 color-theme">
                                    <div class="col-6 font-10 text-start">
                                        <i class="fa fa-clock pe-2"></i>09:00 - 12:00 AM
                                    </div>
                                    <div class="col-6 font-10 text-end">
                                        <i class="fa fa-calendar pe-2"></i>3 May <span class="copyright-year"></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Design Business Cards</h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">1/25 Tasks Completed</p>
                                <p class="mb-0">
                                    Create and Print Company Business Cards
                                </p>

                                <span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
                                <span class="badge bg-green-dark float-end ms-2 color-white font-10 mt-2">LOW PRIORITY</span>

                                <div class="divider mb-3 mt-3"></div>
                                <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
                                <img src="../images/empty.png" data-src="../images/pictures/faces/1s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/2s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/3s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">

                                <div class="divider mt-3 mb-2"></div>
                                <div class="row mb-n2 color-theme">
                                    <div class="col-6 font-10 text-start">
                                        <i class="fa fa-clock pe-2"></i>09:00 - 12:00 AM
                                    </div>
                                    <div class="col-6 font-10 text-end">
                                        <i class="fa fa-calendar pe-2"></i>17 June <span class="copyright-year"></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Create Landing Page</h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">3/25 Tasks Completed</p>
                                <p class="mb-0">
                                    Adevrtise upcoming website redesign and showcase all details on social media
                                </p>

                                <span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
                                <span class="badge bg-blue-dark float-end ms-2 color-white font-10 mt-2">MEDIUM PRIORITY</span>

                                <div class="divider mb-3 mt-3"></div>
                                <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
                                <img src="../images/empty.png" data-src="../images/pictures/faces/3s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/1s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/2s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">

                                <div class="divider mt-3 mb-2"></div>
                                <div class="row mb-n2 color-theme">
                                    <div class="col-6 font-10 text-start">
                                        <i class="fa fa-clock pe-2"></i>09:00 - 12:00 AM
                                    </div>
                                    <div class="col-6 font-10 text-end">
                                        <i class="fa fa-calendar pe-2"></i>24 July <span class="copyright-year"></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                
                
                
                    <!-- Tab -->                
                    <div data-bs-parent="#tab-group-1" class="collapse" id="tab-2">  
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Design Business Cards</h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">1/25 Tasks Completed</p>
                                <p class="mb-0">
                                    Create and Print Company Business Cards
                                </p>

                                <span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
                                <span class="badge bg-green-dark float-end ms-2 color-white font-10 mt-2">LOW PRIORITY</span>

                                <div class="divider mb-3 mt-3"></div>
                                <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
                                <img src="../images/empty.png" data-src="../images/pictures/faces/1s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/2s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/3s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">

                                <div class="divider mt-3 mb-2"></div>
                                <div class="row mb-n2 color-theme">
                                    <div class="col-6 font-10 text-start">
                                        <i class="fa fa-clock pe-2"></i>09:00 - 12:00 AM
                                    </div>
                                    <div class="col-6 font-10 text-end">
                                        <i class="fa fa-calendar pe-2"></i>17 June <span class="copyright-year"></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                
                
                
                    <!-- Tab -->                
                    <div data-bs-parent="#tab-group-1" class="collapse" id="tab-3">
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Create Landing Page</h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">3/25 Tasks Completed</p>
                                <p class="mb-0">
                                    Adevrtise upcoming website redesign and showcase all details on social media
                                </p>

                                <span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
                                <span class="badge bg-blue-dark float-end ms-2 color-white font-10 mt-2">MEDIUM PRIORITY</span>

                                <div class="divider mb-3 mt-3"></div>
                                <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
                                <img src="../images/empty.png" data-src="../images/pictures/faces/3s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/1s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/2s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">

                                <div class="divider mt-3 mb-2"></div>
                                <div class="row mb-n2 color-theme">
                                    <div class="col-6 font-10 text-start">
                                        <i class="fa fa-clock pe-2"></i>09:00 - 12:00 AM
                                    </div>
                                    <div class="col-6 font-10 text-end">
                                        <i class="fa fa-calendar pe-2"></i>24 July <span class="copyright-year"></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                
                    <!-- Tab -->                
                    <div data-bs-parent="#tab-group-1" class="collapse" id="tab-4">
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Payment Gateways</h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">5/10 Tasks Completed</p>
                                <p class="mb-0">
                                    Integration of payment gateways to Project
                                </p>

                                <span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
                                <span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">HIGH PRIORITY</span>

                                <div class="divider mb-3 mt-3"></div>
                                <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/1s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/2s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/3s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">

                                <div class="divider mt-3 mb-2"></div>
                                <div class="row mb-n2 color-theme">
                                    <div class="col-6 font-10 text-start">
                                        <i class="fa fa-clock pe-2"></i>09:00 - 12:00 AM
                                    </div>
                                    <div class="col-6 font-10 text-end">
                                        <i class="fa fa-calendar pe-2"></i>3 May <span class="copyright-year"></span>
                                    </div>
                                </div>
                            </div>
                        </a>                    
                    </div>
                </div>
        </div>

        <div class="footer card card-style mt-0">
            <a href="#" class="footer-title"><span class="color-highlight">StickyMobile</span></a>
            <p class="footer-text"><span>Made with <i class="fa fa-heart color-highlight font-16 ps-2 pe-2"></i> by Enabled</span><br><br>Powered by the best Mobile Website Developer on Envato Market. Elite Quality. Elite Products.</p>
            <div class="text-center mb-3">
                <a href="#" class="icon icon-xs rounded-sm shadow-l me-1 bg-facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="icon icon-xs rounded-sm shadow-l me-1 bg-twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" class="icon icon-xs rounded-sm shadow-l me-1 bg-phone"><i class="fa fa-phone"></i></a>
                <a href="#" data-menu="menu-share" class="icon icon-xs rounded-sm me-1 shadow-l bg-red-dark"><i class="fa fa-share-alt"></i></a>
                <a href="#" class="back-to-top icon icon-xs rounded-sm shadow-l bg-dark-light"><i class="fa fa-angle-up"></i></a>
            </div>
            <p class="footer-copyright">Copyright &copy; Enabled <span id="copyright-year">2017</span>. All Rights Reserved.</p>
            <p class="footer-links"><a href="#" class="color-highlight">Privacy Policy</a> | <a href="#" class="color-highlight">Terms and Conditions</a> | <a href="#" class="back-to-top color-highlight"> Back to Top</a></p>
            <div class="clear"></div>
        </div>    

    </div>
    <!-- End of Page Content--> 
    <!-- All Menus, Action Sheets, Modals, Notifications, Toasts, Snackbars get Placed outside the <div class="page-content"> -->
	
	
	 <!-- Add funds Menu-->
    <div id="menu-add-funds" class="menu menu-box-bottom menu-box-detached">
        <div class="menu-title"><h1>Add Funds</h1><p class="color-highlight">Top off your Account</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
        <div class="divider divider-margins mb-1 mt-3"></div>
        <div class="content px-1">

            <div class="input-style input-style-always-active no-borders no-icon">
                <label for="f1" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Add Funds To</label>
                <select id="f1">
                    <option value="default" selected>Default Account</option>
                    <option value="1">Business Account</option>
                    <option value="2">Savings Account</option>
                </select>
                <span><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <em></em>
            </div>

            <div class="input-style input-style-always-active no-borders no-icon">
                <label for="f1a" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Add Funds From</label>
                <select id="f1a">
                    <option value="default" selected>Visa Credit Card</option>
                    <option value="1">Mater Card Limited</option>
                    <option value="2">PayPal Account</option>
                </select>
                <span><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <em></em>
            </div>

            <div class="input-style input-style-always-active validate-field no-borders no-icon">
                <input type="number" class="form-control validate-number" id="f3ab" placeholder="12,250">
                <label for="f3ab" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Amount in USD</label>
                <i class="fa fa-times disabled invalid color-red-dark"></i>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <em>(required)</em>
            </div>
            <a href="#" class="close-menu btn btn-full btn-m bg-highlight rounded-sm text-uppercase font-800 mb-4">Add Funds</a>
        </div>
    </div>

    <!-- Recent Transactions Menus -->
    <div id="menu-transaction-1" class="menu menu-box-bottom menu-box-detached">
        <div class="menu-title"><h1>Payment Sent</h1><p class="color-highlight">Transaction Details for Payment</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
        <div class="divider divider-margins mb-1 mt-3"></div>
        <div class="content">
            <div class="row mb-0">
                <div class="col-3">
                    <img src="images/pictures/faces/1s.png" width="80" class="rounded-xl">
                </div>
                <div class="col-9 ps-4">
                    <div class="d-flex">
                        <div><p class="font-700 color-theme">To</p></div>
                        <div class="ms-auto"><p>John Doe</p></div>
                    </div>
                    <div class="d-flex">
                        <div><p class="font-700 color-theme">From</p></div>
                        <div class="ms-auto"><p> Card **** 9431</p></div>
                    </div>
                    <div class="d-flex">
                        <div><p class="font-700 color-theme">Date</p></div>
                        <div class="ms-auto"><p>15th July 2025</p></div>
                    </div>
                </div>
            </div>
            <div class="divider mt-3 mb-3"></div>
            <div class="row mb-0">
                <div class="col-6"><h4 class="font-14">Type</h4></div>
                <div class="col-6"><h4 class="font-14 text-end">Payment Sent</h4></div>
                <div class="divider divider-margins w-100 mt-2 mb-2"></div>
                <div class="col-6"><h4 class="font-14 mt-1">Amount</h4></div>
                <div class="col-6"><h4 class="font-14 text-end mt-1">$530.24</h4></div>
                <div class="divider divider-margins w-100 mt-2 mb-2"></div>
                <div class="col-6"><h4 class="font-14 mt-1">Transaction ID</h4></div>
                <div class="col-6"><h4 class="font-14 text-end mt-1">#123-456-165</h4></div>
                <div class="divider divider-margins w-100 mt-2 mb-2"></div>
                <div class="col-6"><h4 class="font-14 mt-1">Status</h4></div>
                <div class="col-6"><h4 class="font-14 text-end mt-1 color-green-dark">Completed</h4></div>
                <div class="divider divider-margins w-100 mt-2 mb-3"></div>
                <div class="col-12"><a href="#" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-3">Download PDF</a></div>
            </div>
        </div>
    </div>

	<!-- Transfer Menus -->
	<div id="menu-transaction-transfer" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Send Funds</h1><p class="color-highlight">Enter Transaction Details</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-3"></div>
		<div class="content px-1">

			<div class="input-style input-style-always-active no-borders no-icon">
				<label for="f1" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Select A Value</label>
				<select id="f1">
					<option value="default" selected>Default Account</option>
					<option value="1">Business Account</option>
					<option value="2">Savings Account</option>
				</select>
				<span><i class="fa fa-chevron-down"></i></span>
				<i class="fa fa-check disabled valid color-green-dark"></i>
				<em></em>
			</div>

			<div class="input-style input-style-always-active validate-field no-borders no-icon">
				<input type="email" class="form-control validate-email" id="f2a" placeholder=name@domain.com>
				<label for="f2a" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Receiver Email</label>
				<i class="fa fa-times disabled invalid color-red-dark"></i>
				<i class="fa fa-check disabled valid color-green-dark"></i>
				<em>(required)</em>
			</div>

			<div class="input-style input-style-always-active validate-field no-borders no-icon">
				<input type="number" class="form-control validate-number" id="f3" placeholder="12,250">
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Amount in USD</label>
				<i class="fa fa-times disabled invalid color-red-dark"></i>
				<i class="fa fa-check disabled valid color-green-dark"></i>
				<em>(required)</em>
			</div>
			<a href="#" class="close-menu btn btn-full btn-m bg-green-dark rounded-sm text-uppercase font-800 mb-4">Send Funds</a>
		</div>
	</div>
	
	

	<!-- Request Call ---- -->
	<div id="schedulecall" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Request Call</h1><p class="color-highlight">Enter Call Details</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-2"></div>
		<div class="content px-1">
		
		<form method="post">
		
		<div class="input-style has-borders has-icon validate-field mb-4">
                    <i class="fa fa-user"></i>
                    <input type="name" class="form-control validate-name" id="form1" placeholder="Name">
					<input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                    <input type="hidden" name="call_main" value="Schedule" />
                    <input type="hidden" name="activity_type" value="Call" />
                    <input type="hidden" name="main" value="1" />
                    <label for="form1" class="color-highlight">Name</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
				
				
				<div class="input-style has-borders no-icon validate-field mb-4">
                    <input type="text" name="call_to" class="form-control validate-text" id="form44" placeholder="Call to">
                    <label for="form44" class="color-highlight">Call to:</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
				
				
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
				
				
			<button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4"> Save </button>

			
			</form>
		</div>
	</div>
	
	
	

	<!-- Convert Menus -->
	<div id="menu-transaction-convert" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Convert Funds</h1><p class="color-highlight">Enter Transaction Details</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-2"></div>
		<div class="content px-1">
			<div class="input-style input-style-always-active no-borders no-icon">
				<label for="f2a" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Convert From</label>
				<select id="f2a">
					<option value="default" selected disabled>Please Select</option>
					<option value="1">Bitcoin - BTC</option>
					<option value="2">Ethereum - ETH</option>
					<option value="2">Dollar Coing - USC</option>
				</select>
				<span><i class="fa fa-chevron-down"></i></span>
				<i class="fa fa-check disabled valid color-green-dark"></i>
				<em></em>
			</div>
			<div class="d-flex">
				<div class="align-self-center w-25 me-auto">
					<div class="input-style input-style-always-active validate-field no-borders no-icon">
						<input type="number" class="form-control border-0" id="f3" placeholder="78.500">
						<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Amount</label>
					</div>
				</div>
				<div class="m-auto">
					<i class="fa fa-arrow-circle-right color-green-dark font-20 d-block mt-n4 pt-1"></i>
				</div>
				<div class="align-self-center ms-auto">
					<h1 class="mb-n2 mt-n4">1.53 BTC</h1>
					<span class="color-theme opacity-60 d-block mb-0">1 BTC = 56.425</span>
				</div>
			</div>
			<a href="#" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 mt-3">Convert Funds</a>
		</div>
	</div>



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
     
    
