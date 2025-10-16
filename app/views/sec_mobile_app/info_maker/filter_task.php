<? 
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$cid = $_SESSION['proj_id'];
include '../config/access.php';
$user_id	=$_SESSION['user_id'];
//$page="home";
include_once('../template/header.php'); 
require "../include/custom.php";

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

	$crud   = new crud('crm_lead_activity');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();
    echo "<script>window.top.location='../info_maker/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";

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

$tabletask='crm_task_add_information';		
$crudtask    =new crud($tabletask);		

if(isset($_POST['insertTasks']))
{

$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudtask->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
        echo "<script>window.top.location='../info_maker/task_manage.php?view=" . encrypTS($id) . "&tp=" . encrypTS('lead') . "'</script>";


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


        
  <div class="page-content header-clear-medium">
  
  
<?php /*?>              <?php
					$sqlTasks = "SELECT l.organization,l.lead_name,l.lead_value, l.assign_person, l.product, l.property_type, l.status, l.campaign,  l.req_loc, l.req_size, l.customer_bud, l.req_loan, l.cus_remarks, l.visitor_type, l.lead_source, l.lead_doc1, l.lead_doc2, l.lead_doc3, l.reamarks, o.id, o.assigned_person_id, o.name, o.website, o.total_employees, o.annual_revenue, o.lead_source, o.lead_type, o.company_name, o.address, o.city, o.zip, o.country, o.division, o.district, o.description, o.logo, o.visiting_card_img, o.product, o.lead FROM crm_project_lead l, crm_project_org o WHERE  l.organization =o.id AND l.id= ".$id."";
					$resultTasks = db_query($sqlTasks);
					if($row = mysqli_fetch_object($resultTasks)) { 
					
					
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
					
					
  
  <div data-card-height="230" class="card card-style round-medium shadow-huge top-30">
            <div class="card-top mt-3 ms-3">
                <h2 class="color-white pt-3 pb-3"><?=$orgname?></h2>
                <p class="color-white font-10 opacity-80 mb-n1"><i class="far fa-calendar"></i> Source: <?=find_a_field('crm_lead_source','source','id="'.$row->lead_source.'"');?> <i class="ms-4 far fa-clock"></i> Revenue: <?=$row->annual_revenue?></p>
				<p class="color-white font-10 opacity-80 mb-n1"><i class="fa fa-map-marker-alt"></i>  <?=$row->website?></p>
                <p class="color-white font-10 opacity-80"><i class="fa fa-map-marker-alt"></i> <?=$row->address?>,<?=$row->city?>,<?=$row->district?>,<?=$row->division?>,<?=$row->zip?></p>
				
				
            </div>
            <div class="card-top mt-3 me-3">
                <a href="#" class="btn btn-m float-end rounded-xl shadow-xl text-uppercase font-800 <?=$class?> fa-2x mt-1 modal-icon bg-highligh"><?=find_a_field('crm_lead_status', 'status', 'id = "'.$row->status.'"')?></a>
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
                <h5 class="font-13 color-white mb-n1"><?=$name_of_lead_name = $row->lead_name?></h5>
                <p class="color-white font-10 opacity-70">Event Creator</p>
            </div>
            <div class="card-overlay bg-highlight opacity-90"></div>
            <div class="card-overlay bg-gradient"></div>
        </div>

           <?php } ?><?php */?>

<!--	
	<div class="content">
			<div class="d-flex text-center px-2">
				<div class="me-auto">
					<a href="#" data-menu="schedulemeeting" class="icon icon-xxl bg-theme gradient-green color-white shadow-l rounded-m"><i class="fa fa-plus"></i></a>
					<span class="font-11 font-500 color-theme d-block">Metting</span>
				</div>
				
				
				<div class="m-auto">
					<a href="#" data-menu="schedulecall" class="icon icon-xxl bg-theme gradient-blue color-white shadow-l rounded-m"><i class="fa fa-arrow-down"></i></a>
					<span class="font-11 font-500 color-theme d-block">Call</span>
				</div>
				
				
				<div class="m-auto">
					<a href="#" data-menu="schedulevisit" class="icon icon-xxl bg-theme gradient-red color-white shadow-l rounded-m"><i class="fa fa-arrow-up"></i></a>
					<span class="font-11 font-500 color-theme d-block">Visit</span>
				</div>
				
				<div class="m-auto">
					<a href="#" data-menu="scheduleemail" class="icon icon-xxl bg-theme gradient-red color-white shadow-l rounded-m"><i class="fa fa-arrow-up"></i></a>
					<span class="font-11 font-500 color-theme d-block">Email</span>
				</div>
				
				

			</div>
		</div>
		
		-->
		
                
        <div class="tab-group-1">
            <div class="card card-style">

                <div class="content mb-0">

                    <h3>Sort Tasks</h3>
                    <p>
                       Simplify Your Workflow and Stay Productive.
                    </p>

                    <div class="divider mb-0"></div>
                </div>
                
            </div>
			
			
			
			

            <div class="content" id="tab-group-1">
			
			
			
                    <!-- All Tab -->    
					
					                 <?php
                                $currentDateTime = date("Y-m-d H:i:s");
         $sqlTasks = "SELECT * FROM crm_task_add_information a WHERE entry_by = $u_id  AND status != 'cancelled' ORDER BY `task_id` DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->task_date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->task_time));
									
                                ?>
								
								            
                    <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1"> 
					
					
					
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">

								
								<h3>Task Name:<?=$row->task_name;?></h3>
								<p class="font-11 mt-n2 mb-0 opacity-50">Company Name:<?=find_a_field('crm_project_org', 'name', 'id = "'.$row->lead_id.'"')?></p>
				
								<div class="divider mb-3 mt-3"></div>


                                <p class="mb-0">
                                    <?=$row->task_details;?>
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
                                <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
                                <span class="badge bg-blue-dark color-white font-10 mt-2"><?=find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "'.$row->assign_person.'"')?></span>
<!--                                <img src="../images/empty.png" data-src="../images/pictures/faces/1s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/2s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/3s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">-->

                                <div class="divider mt-3 mb-2"></div>
                                <div class="row mb-n2 color-theme">
                                    <div class="col-6 font-10 text-start">
                                        <i class="fa fa-clock pe-2"></i><? echo $formattedTime; ?>
                                    </div>
                                    <div class="col-6 font-10 text-end">
                                        <i class="fa fa-calendar pe-2"></i><?php echo $day; ?>  <?php echo strtolower($month);?> <span class="copyright-year"></span>
                                    </div>
                                </div>
                            </div>
                        </a>
						
						
				
                    </div>
                
                  <?php } ?>
                
                    <!--   Tab -->   
					
					        <?php
                                $currentDateTime = date("Y-m-d H:i:s");
         $sqlTasks = "SELECT * FROM crm_task_add_information a WHERE entry_by = $u_id  AND status = '2' ORDER BY task_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->task_date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
                                ?>
								
								             
                    <div data-bs-parent="#tab-group-1" class="collapse" id="tab-2">  
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Task Name:<?=$row->task_name;?></h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">1/25 Tasks Completed</p>	
								<div class="divider mb-3 mt-3"></div>
                                <p class="mb-0">
                                    <?=$row->task_details;?>
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
                                <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
                                <img src="../images/empty.png" data-src="../images/pictures/faces/1s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/2s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/3s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">

                                <div class="divider mt-3 mb-2"></div>
                                <div class="row mb-n2 color-theme">
                                    <div class="col-6 font-10 text-start">
                                        <i class="fa fa-clock pe-2"></i><? echo $formattedTime; ?>
                                    </div>
                                    <div class="col-6 font-10 text-end">
                                        <i class="fa fa-calendar pe-2"></i><?php echo $day; ?>  <?php echo strtolower($month);?> <span class="copyright-year"></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                
                 <?php } ?>
				 
				 
				 
				   <!-- Call  Tab -->    
					
	                                <?php
							$currentDateTime = date("Y-m-d H:i:s");
							$sqlTasks = "SELECT * FROM crm_task_add_information a WHERE entry_by = $u_id AND status = '1' ORDER BY task_id DESC;";
							$resultTasks = db_query($sqlTasks);
					
							while ($row = mysqli_fetch_object($resultTasks)) {
							$task_date = $row->task_date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
							?>
							            
                    <div data-bs-parent="#tab-group-1" class="collapse" id="tab-3">
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Task Name:<?=$row->task_name;?></h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">3/25 Tasks Completed</p>
                                <p class="mb-0">
                                    <?=$row->task_details;?>
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
                                <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
                                <img src="../images/empty.png" data-src="../images/pictures/faces/3s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/1s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/2s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">

                                <div class="divider mt-3 mb-2"></div>
                                <div class="row mb-n2 color-theme">
                                    <div class="col-6 font-10 text-start">
                                        <i class="fa fa-clock pe-2"></i><? echo $formattedTime; ?>
                                    </div>
                                    <div class="col-6 font-10 text-end">
                                        <i class="fa fa-calendar pe-2"></i><?php echo $day; ?>  <?php echo strtolower($month);?> <span class="copyright-year"></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
					
					<?php } ?>
					
					
                
                    <!-- Visit Tab -->    
					
	                 <?php
									$currentDateTime = date("Y-m-d H:i:s");
									$sqlTasks = "SELECT * FROM crm_task_add_information a WHERE entry_by = $u_id AND lead_id = '' AND status = '3' ORDER BY activity_id DESC;";
									$resultTasks = db_query($sqlTasks);
									
									while ($row = mysqli_fetch_object($resultTasks)) {
									$task_date = $row->date;
								
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$formattedTime = date('h:i A', strtotime($row->time));
									?>
							            
                    <div data-bs-parent="#tab-group-1" class="collapse" id="tab-4">
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Task Name:<?=$row->task_name;?></h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">3/25 Tasks Completed</p>
                                <p class="mb-0">
                                   <?=$row->task_details;?>
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
                                <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
                                <img src="../images/empty.png" data-src="../images/pictures/faces/3s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/1s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/2s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">

                                <div class="divider mt-3 mb-2"></div>
                                <div class="row mb-n2 color-theme">
                                    <div class="col-6 font-10 text-start">
                                        <i class="fa fa-clock pe-2"></i><? echo $formattedTime; ?>
                                    </div>
                                    <div class="col-6 font-10 text-end">
                                        <i class="fa fa-calendar pe-2"></i><?php echo $day; ?>  <?php echo strtolower($month);?><span class="copyright-year"></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
					
					<?php } ?>
                
                    <!-- Email Tab -->   
					
					       <?php
									$currentDateTime = date("Y-m-d H:i:s");
									$sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'Email' AND status != 'cancelled' ORDER BY activity_id DESC;";
									$resultTasks = db_query($sqlTasks);
									
									while ($row = mysqli_fetch_object($resultTasks)) {
										$task_date = $row->task_date;
								
								// Convert the date to a timestamp and extract day and month
								$day = date('d', strtotime($task_date));
								$month = date('M', strtotime($task_date));
								$formattedTime = date('h:i A', strtotime($row->time));
							?>
									
									             
                    <div data-bs-parent="#tab-group-1" class="collapse" id="tab-5">
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Email Subject:<?=$row->subject;?></h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">5/10 Tasks Completed</p>
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
                                <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/1s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/2s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/3s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">

                                <div class="divider mt-3 mb-2"></div>
                                <div class="row mb-n2 color-theme">
                                    <div class="col-6 font-10 text-start">
                                        <i class="fa fa-clock pe-2"></i><? echo $formattedTime; ?>
                                    </div>
                                    <div class="col-6 font-10 text-end">
                                        <i class="fa fa-calendar pe-2"></i><?php echo $day; ?>  <?php echo strtolower($month);?><span class="copyright-year"></span>
                                    </div>
                                </div>
                            </div>
                        </a>                    
                    </div>
					
					<?php } ?>
					
					         <!-- Task  Tab -->   
		 <?php
			$currentDateTime = date("Y-m-d H:i:s");
			 $sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'Task' AND status != 'cancelled' ORDER BY activity_id DESC;";
			$resultTasks = db_query($sqlTasks);
			while ($row = mysqli_fetch_object($resultTasks)) {
				$task_date = $row->task_date;
				
				// Convert the date to a timestamp and extract day and month
				$day = date('d', strtotime($task_date));
				$month = date('M', strtotime($task_date));
				$formattedTime = date('h:i A', strtotime($row->time));
							
			?>
									
									             
                    <div data-bs-parent="#tab-group-1" class="collapse" id="tab-6">
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Task Name :<?=$row->subject;?></h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">5/10 Tasks Completed</p>
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
                                <p class="font-11 font-800 text-uppercase color-theme mb-0 opacity-50">Assigned TEAM</p>
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/1s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/2s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/3s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">
                                <img src="../images/empty.png" data-src="../images/pictures/faces/4s.png" width="40" class="rounded-circle preload-img me-n3 border border-gray-light border-xs">

                                <div class="divider mt-3 mb-2"></div>
                                <div class="row mb-n2 color-theme">
                                    <div class="col-6 font-10 text-start">
                                        <i class="fa fa-clock pe-2"></i><? echo $formattedTime; ?>
                                    </div>
                                    <div class="col-6 font-10 text-end">
                                        <i class="fa fa-calendar pe-2"></i><?php echo $day; ?>  <?php echo strtolower($month);?> <span class="copyright-year"></span>
                                    </div>
                                </div>
                            </div>
                        </a>                    
                    </div>
					
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
		<div class="menu-title"><h1>Schedule a Meeting</h1><p class="color-highlight"> Enter Meeting Details</p>
		<a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-2"></div>
		<div class="content px-1">
		
		<form method="post" action="">
		
		
				
				
				<div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="form5" class="color-highlight">Meeting type:</label>
                    <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                    <input type="hidden" name="activity_type" value="Meeting" />
                    <input type="hidden" name="main" value="1" />
					
					 <select class="form-control req" name="meeting_type" id="form5" required>
                                            <option value="default" disabled="" selected="">Select a Value</option>
                                             <option value="Online">Online </option>
                                            <option value="Offline">Offline</option>
                                        </select>
										
										
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
				
				
				<div class="input-style has-borders no-icon validate-field mb-4">
                    <input type="text" name="call_to" class="form-control validate-text" id="form44" placeholder="Meeting With">
                    <label for="form44" class="color-highlight">Meeting With</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
				
					<div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="form5" class="color-highlight">Priority type</label>
               
					
					 <select class="form-control req" name="priority_status" id="form5" required>
                     <option value="LOW">LOW</option>
                     <option value="MEDIUM">MEDIUM</option>
					 <option value="HIGH">HIGH </option>
                     </select>
										
										
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
				

				

				   <div class="input-style has-borders no-icon mb-4 input-style-active">
				
						<input type="date" name="date" class="form-control validate-text" id="date" placeholder="Meeting Date">
						<label for="form6" class="color-highlight">Meeting Date</label>
						<i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
						<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                	</div>
				
				
				   <div class="input-style has-borders no-icon mb-4 input-style-active">
				 
                    <input type="time"  name="time" class="form-control validate-text" id="form6">
                    <label for="form6" class="color-highlight">Meeting Time</label>
                    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                </div>
				
				
				<div class="input-style has-borders no-icon mb-4">
                    <textarea id="form7" name="subject" placeholder="Meeting Purpose"></textarea>
                    <label for="form7" class="color-highlight">Meeting Purpose</label>
                
                </div>
				
				
					<div class="input-style has-borders no-icon mb-4">
                    <textarea id="form7" name="details" placeholder="Note"></textarea>
                    <label for="form7" class="color-highlight">Note</label>
                 
                </div>
				
				
				
				
				
				
				
	<button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100"> Confirm </button>


			
			</form>
		</div>
	</div>
	




	<!-- Request VISIT  ---- -->
	<div id="schedulevisit" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Schedule a Visit</h1><p class="color-highlight"> Enter Visit Details</p>
		<a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-2"></div>
		<div class="content px-1">
		
		<form method="post" action="">
		
		
				
				
				<div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="form5" class="color-highlight">Priority type</label>
                     	<input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                    <input type="hidden" name="activity_type" value="Visit" />
                    <input type="hidden" name="main" value="1" />
					
					 <select class="form-control req" name="priority_status" id="form5" required>
                     <option value="LOW">LOW</option>
                     <option value="MEDIUM">MEDIUM</option>
					 <option value="HIGH">HIGH </option>
                     </select>
										
										
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
				
				<!--<div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="form5" class="color-highlight">Meeting type:</label>
               
					
					 <select class="form-control req" name="meeting_type" id="form5" required>
                                            <option value="default" disabled="" selected="">Select a Value</option>
                                             <option value="Online">Online </option>
                                            <option value="Offline">Offline</option>
                                        </select>
										
										
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>-->
				
				
				<div class="input-style has-borders no-icon validate-field mb-4">
                    <input type="text" name="location" class="form-control validate-text" id="form44" placeholder="Visit Location">
                    <label for="form44" class="color-highlight">Location:</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
				
				
				
				
				
				
				   <div class="input-style has-borders no-icon mb-4 input-style-active">
				
                    <input type="date" name="date" class="form-control validate-text" id="date" placeholder="Visit Date">
                    <label for="form6" class="color-highlight">Visit Date</label>
                    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                </div>
				
				
				   <div class="input-style has-borders no-icon mb-4 input-style-active">
				 
                    <input type="time"  name="time" class="form-control validate-text" id="form6">
                    <label for="form6" class="color-highlight">Visit Time</label>
                    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                </div>
				
				
				<div class="input-style has-borders no-icon mb-4">
                    <textarea id="form7" name="subject" placeholder="Visit Purpose"></textarea>
                    <label for="form7" class="color-highlight">Visit Purpose</label>
                
                </div>
				
				
					<div class="input-style has-borders no-icon mb-4">
                    <textarea id="form7" name="details" placeholder="Note"></textarea>
                    <label for="form7" class="color-highlight">Note</label>
                 
                </div>
				
				
				
				
				
				
				
	<button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100"> Confirm </button>


			
			</form>
		</div>
	</div>




<!-- Request Task  ---- -->
	<div id="scheduletask" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Schedule a Task</h1><p class="color-highlight"> Enter Task Details</p>
		<a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-2"></div>
		<div class="content px-1">
		
		<form method="post" action="">
		
		
				<div class="input-style has-borders no-icon mb-4">
					<input type="hidden" name="status" value="1" />
                    <Input type="text" id="form7" name="task_name" placeholder="Task Name">
                    <label for="form7" class="color-highlight">Task Name</label>
                
                </div>
				<div class="input-style has-borders no-icon mb-4">
                    <textarea id="form7" name="task_details" placeholder="Task Details"></textarea>
                    <label for="form7" class="color-highlight">Task Details</label>
                
                </div>
			
				<div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="form5" class="color-highlight">Priority type</label>
               
					
					 <select class="form-control req" name="priority_status" id="form5" required>
                     <option value="LOW">
						  <span class="flag flag-low">LOW</span>
						</option>
						<option value="MEDIUM">
						  <span class="flag flag-medium">MEDIUM</span>
						</option>
						<option value="HIGH">
						  <span class="flag flag-high">HIGH</span>
						</option>
                     </select>
								
										
										
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
				
				<div class="input-style has-borders no-icon mb-4">
                    <label for="form5" class="color-highlight">Assign Person</label>
               
					
					  <select class="form-control req" name="assign_person" id="form5">
                     <option value=""></option>
					 <option>
						<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$assign_person,'1'); ?>
						</option>
                     </select>
					  <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
				<div class="input-style has-borders no-icon mb-4">
                    <label for="form5" class="color-highlight">Project Name</label>
               
					
					 <select class="form-control req" name="lead_id" id="form5">
                     <option value=""></option>

						<? foreign_relation('crm_project_org','id','name',$lead_id,'1'); ?>

                     </select>
					  <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
				
				
				
				
				<!--test start-->
				
<!--				<div class="row">
					<div class="col-6">
						 <div class="input-style has-borders no-icon mb-4 input-style-active">
							<input type="date" name="task_date" class="form-control validate-text" id="task_date">
							<label for="task_date" class="color-highlight">Task Date</label>
							<i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
							<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
						</div>       
					</div>
					<div class="col-6">
							<div class="input-style has-borders no-icon mb-4 input-style-active">
								<input type="time" name="task_time" class="form-control validate-text" id="task_time">
								<label for="task_time" class="color-highlight">Task Time</label>
								<i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
								<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
							</div>     
					</div>
        		</div>-->
				
				<!--test END-->
				
				
				
				
				
				
	
					<h5 class="mb-2 font-15 mt-2">Task</h5>
						<div class="row mb-0">
						  <div class="col-6">
							<div class="input-style has-borders no-icon mb-4 input-style-active">
							  <label for="form6" class="color-highlight text-uppercase font-700 font-10 mt-1">Task Time</label>
								<input type="time"  name="time" class="form-control validate-text" id="form6">
							</div>
						  </div>
						  <div class="col-6">
							<div class="input-style has-borders no-icon mb-4 input-style-active">
							  <label for="form6" class="color-highlight text-uppercase font-700 font-10 mt-1">Task Date</label>
								<input type="date" style="width:100%"  name="date" class="form-control validate-text" id="form6">
							</div>
						  </div>
						</div>
				
				
				
				
				
				
				
					<h5 class="mb-2 font-15 mt-2">Remainder</h5>
						<div class="row mb-0">
						  <div class="col-6">
							<div class="input-style has-borders no-icon mb-4 input-style-active">
							  <label for="form-4" class="color-highlight text-uppercase font-700 font-10 mt-1">Remainder time</label>
								<input type="time"  name="reaminder_time" class="form-control validate-text" id="form-4">
							</div>
						  </div>
						  <div class="col-6">
							<div class="input-style has-borders no-icon mb-4 input-style-active">
							  <label for="form6" class="color-highlight text-uppercase font-700 font-10 mt-1">Reaminder Date</label>
								<input type="date" style="width:100%"  name="reaminder_date" class="form-control validate-text" id="form-4">
							</div>
						  </div>
						</div>
                    

				

				
	<button type="submit" name="insertTasks" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100"> Confirm </button>
			
			</form>
		</div>
	</div>



<!-- Request Email  ---- -->
	<div id="scheduleemail" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Schedule a Email</h1><p class="color-highlight"> Enter Email Details</p>
		<a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-2"></div>
		<div class="content px-1">
		
		<form method="post" action="">
		
		
				
				
				<div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="form5" class="color-highlight">Priority type</label>
               
					 <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                    <input type="hidden" name="activity_type" value="Email" />
                    <input type="hidden" name="main" value="1" />
					 <select class="form-control req" name="priority_status" id="form5" required>
                     <option value="LOW">LOW</option>
                     <option value="MEDIUM">MEDIUM</option>
					 <option value="HIGH">HIGH </option>
                     </select>
										
										
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
                </div>
				
				
				<div class="input-style has-borders no-icon validate-field mb-4">
                    <input type="email" name="email_to" class="form-control validate-text" id="form44" placeholder="Email to">
                    <label for="form44" class="color-highlight">Email to:</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
				
				
				
				
				
				
				   <div class="input-style has-borders no-icon mb-4 input-style-active">
				
                    <input type="date" name="date" class="form-control validate-text" id="date" placeholder="Email Date">
                    <label for="form6" class="color-highlight">Email Date</label>
                    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                </div>
				
				
				   <div class="input-style has-borders no-icon mb-4 input-style-active">
				 
                    <input type="time"  name="time" class="form-control validate-text" id="form6">
                    <label for="form6" class="color-highlight">Email Time</label>
                    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                </div>
				
				
				<div class="input-style has-borders no-icon mb-4">
                    <textarea id="form7" name="subject" placeholder="Email Subject"></textarea>
                    <label for="form7" class="color-highlight">Email Subject</label>
                
                </div>
				
				
					<div class="input-style has-borders no-icon mb-4">
                    <textarea id="form7" name="details" placeholder="Email Body"></textarea>
                    <label for="form7" class="color-highlight">Email Body</label>
                 
                </div>
				
				
				
				
				
				
				
	<button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100"> Confirm </button>


			
			</form>
		</div>
	</div>
	
	

	<!-- Request Call ---- -->
	<div id="schedulecall" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Schedule a call</h1><p class="color-highlight">Enter Call Details</p>
		<a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-2"></div>
		<div class="content px-1">
		
		<form method="post" action="">
		
		
				
				
				<div class="input-style has-borders no-icon validate-field mb-4">
					<input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />

                    <input type="hidden" name="activity_type" value="Call" />
                    <input type="hidden" name="main" value="1" />
                    <input type="text" name="call_to" class="form-control validate-text" id="form44" placeholder="Call to">
                    <label for="form44" class="color-highlight">Call to:</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
				
				<div class="input-style has-borders no-icon mb-4 input-style-active">
                    <label for="form5" class="color-highlight">Priority type</label>
               
					
					 <select class="form-control req" name="priority_status" id="form5" required>
                     <option value="LOW">LOW</option>
                     <option value="MEDIUM">MEDIUM</option>
					 <option value="HIGH">HIGH </option>
                     </select>
										
										
                    <span class="disabled"><i class="fa fa-chevron-down"></i></span>
                    <i class="fa fa-check valid color-green-dark"></i>
                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                    <em></em>
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
				
				
				
				   <div class="input-style has-borders no-icon mb-4 input-style-active">
				
                    <input type="date" name="date" class="form-control validate-text" id="date" placeholder="Call Date">
                    <label for="form6" class="color-highlight">Call Date</label>
                    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                </div>
				
				
				   <div class="input-style has-borders no-icon mb-4 input-style-active">
				 
                    <input type="time"  name="time" class="form-control validate-text" id="form6">
                    <label for="form6" class="color-highlight">Call Time</label>
                    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                </div>
				
				
				<div class="input-style has-borders no-icon mb-4">
                    <textarea id="form7" name="subject" placeholder="Call Purpose"></textarea>
                    <label for="form7" class="color-highlight">Call Purpose</label>
                
                </div>
				
				
					<div class="input-style has-borders no-icon mb-4">
                    <textarea id="form7" name="details" placeholder="Details"></textarea>
                    <label for="form7" class="color-highlight">Details</label>
                 
                </div>
				
				
				
				
				
				
				
	<button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100"> Confirm </button>


			
			</form>
		</div>
	</div>
	
	
	

	<!-- Convert Menus -->
	



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
     
    
  <?php include_once('../template/link_footer.php'); ?>