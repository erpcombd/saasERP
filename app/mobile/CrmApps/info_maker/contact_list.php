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





<div class="page-content">


		
		
				
				
		<br />
					
		<div class="card mx-2 bg-transparent" data-card-height="" style="height:250">
			<div class="card-center">
				<h1 class="text-center font-28">Find Contact List</h1>
				<br />
						
				   <form action="" method="POST">	
					<!-- Tab 1 -->
					<div data-bs-parent="#tab-group" class="collapse show">
					
					
						<div class="me-3 ms-3 mb-3">
         <div class="search-box bg-theme rounded-m shadow-l border-0">
                <i class="fa fa-search"></i>
					<?php
				$searchterm = isset($_POST['search-term']) ? $_POST['search-term'] : '';
			       ?>
                <input type="text" class="border-0" placeholder="Search here... e.g., John" name="search-term" value="<?=htmlspecialchars($searchterm); ?>">
                <a href="#" class="clear-search m-3 d-none" id="clear-search"><i class="fa fa-times color-red-dark"></i></a>
            </div>
    </div>
					   <div class="card card-style shadow-l mx-3 mt-3 mb-0">
						
							<input type="submit"  name="showResult" class="btn btn-l btn-full bg-highlight font-700 text-uppercase"  value="Show Results" id="form-4">
							
						</div>
					</div>
					
				
		</div></div>
	


                         <?php   
						         
								 
							// Check if the search form is submitted
								if (isset($_POST['showResult'])) {
									$searchTerm = trim($_POST['search-term']);
									if (!empty($searchTerm)) {
										// Prepare the search condition for the SQL query
										$personCon = " AND a.contact_name LIKE '%" . mysqli_real_escape_string($conn, $searchTerm) . "%'";
									}
								}

								 
	
								if($_POST['company_name']>0) $comConn = " and project_id='".$_POST['company_name']."'";
              
								
								
					
						
							
									
                                ?>
								
								

   
    <div class="card card-style search-results" id="search-results">
        <div class="content mb-0">
            <div id="result-container">
                <?php
           		
                                   	// Complete SQL query
									$sqlTasks = 'SELECT * FROM crm_lead_contacts a WHERE 1 ' . $personCon . ' ORDER BY id DESC;';
									$resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
                ?>
                    <a href="#" class="d-flex py-2 search-item" data-filter-name="<?= strtolower(trim($row->contact_name)) ?>">
                        
                        <div class="align-self-center">
                            <p class="font-14 font-600 color-theme mb-0 line-height-s"><?= $row->contact_name ?></p> 
							
                        <a class="default-link" href="tel:+<?=$row->contact_phone;?>">
                        <i class="fa font-14 fa-phone color-phone"></i>
                        <span>+88<?=$row->contact_phone ;?></span>
                        <span class="badge bg-red-dark">TAO TO CALL</span>
                       
                       </a>
					   
					   
					   
					    <br />
							
                            <p class="font-11 mb-0 line-height-s">Designation: <?= $row->contact_designation ?></p>
					
                        </div>
                    </a>
                    <div class="divider mb-3 search-divider"></div>
                <?php } ?>
            </div>
            
        </div>
    </div>

	
	
		
		
		
	
		
		
		
		
		
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

 <? require_once '../assets/template/inc.footer.php'; ?>