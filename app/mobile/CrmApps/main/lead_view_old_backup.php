<? 

session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//require_once '../../../controllers/core/init.php';

$cid = $_SESSION['proj_id'];
?>



<?php

   

//session_start();

//include 'config/db.php';

//include '../config/function.php';
include '../config/access.php';

$user_id	=$_SESSION['user_id'];



$page="home";

if(isset($_POST['submit']))
{
$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
		$crudcontact1->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
}

if (isset($_POST['scCall'])) {

	$crud   = new crud('crm_lead_activity');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();

}


?>



<?php 
include_once('../template/header.php'); 
require "../include/custom.php";
?>


<? 

 $table1 = 'crm_project_lead';
 $tablecontact = 'crm_lead_contacts';
 $tableproductadd = 'crm_lead_product_individual';
 $uniqueproduct="product_individual_id";


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

//echo $u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];
 $u_id  =  $_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$currentMonth = date("m");
$currentYear = date("Y");

$attedance = find_all_field('hrm_attendence_final','','PBI_ID="'.$PBI_ID.'" and mon="'.$currentMonth.'" and year="'.$currentYear.'"');

$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$PBI_ID.'"');

?>



<style>
/*custom CSS*/


.width-100{
	width:100%;
}

</style>









        
  <div class="page-content header-clear-medium">

        

	
	<div class="content">
			<div class="d-flex text-center px-2">
				<div class="me-auto">
					<a href="#" data-menu="menu-add-funds" class="icon icon-xxl bg-theme gradient-green color-white shadow-l rounded-m"><i class="fa fa-plus"></i></a>
					<span class="font-11 font-500 color-theme d-block">Metting </span>
				</div>
				<div class="m-auto">
					<a href="#" data-menu="menu-transaction-request" class="icon icon-xxl bg-theme gradient-blue color-white shadow-l rounded-m"><i class="fa fa-arrow-down"></i></a>
					<span class="font-11 font-500 color-theme d-block">Call</span>
				</div>
				
				
				<div class="m-auto">
					<a href="#" data-menu="menu-transaction-transfer-visit" class="icon icon-xxl bg-theme gradient-red color-white shadow-l rounded-m"><i class="fa fa-arrow-up"></i></a>
					<span class="font-11 font-500 color-theme d-block">Visit</span>
				</div>
				
				<div class="m-auto">
					<a href="#" data-menu="menu-transaction-transfer-email" class="icon icon-xxl bg-theme gradient-red color-white shadow-l rounded-m"><i class="fa fa-arrow-up"></i></a>
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
					<a href="#" data-bs-toggle="collapse" data-bs-target="#tab-2">Meeting</a>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-3">Call</a>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-4">Visit</a>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-5">Email</a>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#tab-6">Task</a>
                </div>
            </div>

            <div class="content" id="tab-group-1">
                    <!--Meeting Tab --> 
                    <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1">
  							<?php
                                $currentDateTime = date("Y-m-d H:i:s");
           						$sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'Meeting' AND status != 'cancelled' ORDER BY activity_id DESC;";
                                $resultTasks = db_query($sqlTasks);
                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->task_date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$timestamp = strtotime($row->time);
									$formattedTime = date('h:i A', $timestamp);
                                ?>
                        <a href="#" class="card mx-0 card-style">

                            <div class="content">
                                <h3>Meeting Subject :<?=$row->subject;?></h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">5/10 Tasks Completed</p>
								<p class="font-11 mt-n2 mb-0 ">Meeting Location :<?=$row->location;?></p>
								<? if($row->meeting_type == 'Online'){ ?>
                                            <span class="badge bg-green-dark font-11 mt-n2 mb-0 ">ONLINE</span>
												<? }elseif($row->meeting_type == 'Offline'){ ?>	   
													<span class="badge bg-red-dark font-11 mt-n2 mb-0 ">OFFLINE</span>
														   <? }else{ ?>
														   <span class="badge bg-red-dark font-11 mt-n2 mb-0 ">No data</span>
														  <?  } ?>
								<div class="divider mb-3 mt-3"></div>
								
								
                                <p class="mb-0">
                                    <?=$row->details;?>
                                </p>



<!--                                <span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
								<span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
								<span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
								<span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">HIGH PRIORITY</span>
								-->
										<? if($row->status =='COMPLETE'){ ?>

                                            <span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
												<? }elseif($row->status =='OVERDUE'){ ?>
														   
													<span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
														   <? }else{ ?>
														   
														   <span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
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
						<?php } ?>
						
						
						
						<!--Call Tab --> 
										
               
                    <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1"> 
					           <?php
                                $currentDateTime = date("Y-m-d H:i:s");
           $sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'call' AND status != 'cancelled' ORDER BY activity_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->task_date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$timestamp = strtotime($row->time);
									$formattedTime = date('h:i A', $timestamp);
                                ?>
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Call Purpose: <?=$row->subject;?></h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">5/10 Tasks Completed</p>
								<p class="font-11 mt-n2 mb-0">Call to:<?=$row->call_to;?></p>
								<? if($row->call_type == 'Inbound Call'){ ?>
                                            <span class="badge bg-green-dark font-11 mt-n2 mb-0 ">Inbound Call</span>
												<? }elseif($row->call_type == 'Outbound Call'){ ?>	   
													<span class="badge bg-red-dark font-11 mt-n2 mb-0 ">Outbound Call</span>
														   <? }else{ ?>
														   <span class="badge bg-red-dark font-11 mt-n2 mb-0 ">No data</span>
														  <?  } ?>
								<div class="divider mb-3 mt-3"></div>
								
								
                                <p class="mb-0">
                                    <?=$row->details;?>
                                </p>



<!--                                <span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
								<span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
								<span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
								<span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">HIGH PRIORITY</span>
								-->
										<? if($row->status =='COMPLETE'){ ?>

                                            <span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
												<? }elseif($row->status =='OVERDUE'){ ?>
														   
													<span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
														   <? }else{ ?>
														   
														   <span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
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
						<?php } ?>
						
						
						
						
						
						
						
						
						
						<!-- VISIT Tab --> 
										
           <?php
                                $currentDateTime = date("Y-m-d H:i:s");
           						$sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'visit' AND status != 'cancelled' ORDER BY activity_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->task_date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$timestamp = strtotime($row->time);
									$formattedTime = date('h:i A', $timestamp);
                                ?>               
                    <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1"> 
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Visit Purpose: <?=$row->subject;?></h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">5/10 Tasks Completed</p>
								<p class="font-11 mt-n2 mb-0 ">Visit Location :<?=$row->location;?></p>
								<div class="divider mb-3 mt-3"></div>
								
								
                                <p class="mb-0">
                                    <?=$row->details;?>
                                </p>



<!--                                <span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
								<span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
								<span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
								<span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">HIGH PRIORITY</span>
								-->
										<? if($row->status =='COMPLETE'){ ?>

                                            <span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
												<? }elseif($row->status =='OVERDUE'){ ?>
														   
													<span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
														   <? }else{ ?>
														   
														   <span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
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
						<?php } ?>
						
						
						
						
						    <!--Email Tab --> 
					
           <?php
                                $currentDateTime = date("Y-m-d H:i:s");
           $sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'Email' AND status != 'cancelled' ORDER BY activity_id DESC;";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->task_date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$timestamp = strtotime($row->time);
									$formattedTime = date('h:i A', $timestamp);
                                ?>               
                    <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1"> 
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Email Subject :<?=$row->subject;?></h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">5/10 Tasks Completed</p>
								<p class="font-11 mt-n2 mb-0 ">Email To :<?=$row->email_to;?></p>
								<div class="divider mb-3 mt-3"></div>
								
								
                                <p class="mb-0">
                                    <?=$row->details;?>
                                </p>



<!--                            <span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
								<span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
								<span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
								<span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">HIGH PRIORITY</span>
								-->
										<? if($row->status =='COMPLETE'){ ?>

                                            <span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
												<? }elseif($row->status =='OVERDUE'){ ?>
														   
													<span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
														   <? }else{ ?>
														   
														   <span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
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
						<?php } ?>
						
						
						
												
						    <!--Task Tab --> 
					
           <?php
                                $currentDateTime = date("Y-m-d H:i:s");
           $sqlTasks = "SELECT * FROM crm_task_add_information WHERE lead_id=$id   ORDER BY task_id DESC";
                                $resultTasks = db_query($sqlTasks);

                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->task_date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$timestamp = strtotime($row->time);
									$formattedTime = date('h:i A', $timestamp);
									
									
                                ?>               
                    <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1"> 
                        <a href="#" class="card mx-0 card-style">
                            <div class="content">
                                <h3>Task Name :<?=$row->subject;?></h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">5/10 Tasks Completed</p>
								<div class="divider mb-3 mt-3"></div>
								
								
                                <p class="mb-0">
                                    <?=$row->details;?>
                                </p>



<!--                            <span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
								<span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
								<span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
								<span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">HIGH PRIORITY</span>
								-->
										<? if($row->status =='COMPLETE'){ ?>

                                            <span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
												<? }elseif($row->status =='OVERDUE'){ ?>
														   
													<span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
														   <? }else{ ?>
														   
														   <span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
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
						
						
						<?php } ?>
						
                    </div>
                
                
                
                    <!-- Tab -->                
                    <div data-bs-parent="#tab-group-1" class="collapse" id="tab-2">  
					
					<?php
                                $currentDateTime = date("Y-m-d H:i:s");
           						$sqlTasks = "SELECT * FROM crm_lead_activity a WHERE lead_id = $id AND activity_type = 'Meeting' AND status != 'cancelled' ORDER BY activity_id DESC;";
                                $resultTasks = db_query($sqlTasks);
                                while ($row = mysqli_fetch_object($resultTasks)) {
								$task_date = $row->task_date;
									// Convert the date to a timestamp and extract day and month
									$day = date('d', strtotime($task_date));
									$month = date('M', strtotime($task_date));
									$timestamp = strtotime($row->time);
									$formattedTime = date('h:i A', $timestamp);
                                ?>
                        <a href="#" class="card mx-0 card-style">

                            <div class="content">
                                <h3>Meeting Subject :<?=$row->subject;?></h3>
                                <p class="font-11 mt-n2 mb-0 opacity-50">5/10 Tasks Completed</p>
								<p class="font-11 mt-n2 mb-0 ">Meeting Location :<?=$row->location;?></p>
								<? if($row->meeting_type == 'Online'){ ?>
                                            <span class="badge bg-green-dark font-11 mt-n2 mb-0 ">ONLINE</span>
												<? }elseif($row->meeting_type == 'Offline'){ ?>	   
													<span class="badge bg-red-dark font-11 mt-n2 mb-0 ">OFFLINE</span>
														   <? }else{ ?>
														   <span class="badge bg-red-dark font-11 mt-n2 mb-0 ">No data</span>
														  <?  } ?>
								<div class="divider mb-3 mt-3"></div>
								
								
                                <p class="mb-0">
                                    <?=$row->details;?>
                                </p>



<!--                                <span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
								<span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
								<span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
								<span class="badge bg-red-dark float-end ms-2 color-white font-10 mt-2">HIGH PRIORITY</span>
								-->
										<? if($row->status =='COMPLETE'){ ?>

                                            <span class="badge bg-green-dark color-white font-10 mt-2">COMPLETE</span>
												<? }elseif($row->status =='OVERDUE'){ ?>
														   
													<span class="badge bg-highlight color-white font-10 mt-2">OVERDUE</span>
														   <? }else{ ?>
														   
														   <span class="badge bg-blue-dark color-white font-10 mt-2">UPCOMING</span>
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
						<?php } ?>
					
					
					
					
					
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
                    <div data-bs-parent="#tab-group-1" class="collapse" id="tab-5">
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
                    <div data-bs-parent="#tab-group-1" class="collapse" id="tab-6">
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
	
	
	 <!-- Meeting add Menu-->
    <div id="menu-add-funds" class="menu menu-box-bottom menu-box-detached">
        <div class="menu-title"><h1>Meeting Add</h1><p class="color-highlight">Schedule your Meeting</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
        <div class="divider divider-margins mb-1 mt-3"></div>
        <div class="content px-1">
		<form method="post">
                <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
				<input type="hidden" name="activity_type" value="Meeting" />
		
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="number" class="form-control border-0" id="f3" placeholder="<?=$orgname?>" disabled="disabled">
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Lead Organization</label>
			</div>


            <div class="input-style input-style-always-active no-borders no-icon">
                <label for="f1" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Meeting Type</label>
                <select id="f1" class="form-control req" name="meeting_type">
                     <option value="Online">Online </option>
                     <option value="Offline">Offline</option>
                </select>
                <span><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <em></em>
            </div>

			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="text" name="subject" id="subject" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Meeting Subject:</label>
			</div>
			
			
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="text" name="location" id="location" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Location:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="date" name="date" id="date" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Meeting Date:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="time" name="time" id="time" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Meeting Time:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
                <label for="f4" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Prioritys Type</label>
                <select id="f4" class="form-control req" name="priority_status">
                     <option value="LOW">LOW</option>
                     <option value="MEDIUM">MEDIUM</option>
					 <option value="HIGH">HIGH </option>
                </select>
                <span><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <em></em>
            </div>
			<div class="input-style input-style-always-active no-borders no-icon">
				<textarea class="form-control req1" name="details"></textarea>
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Note:</label>
			</div>
<!--            <div class="input-style input-style-always-active no-borders no-icon">
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
            </div>-->
            <!--<a href="#" class="close-menu btn btn-full btn-m bg-highlight rounded-sm text-uppercase font-800 mb-4">Add Meeting</a>-->
			<button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-highlight rounded-sm text-uppercase font-800 mb-4 width-100">Add Meeting </button>
			</form>
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
	<div id="menu-transaction-transfer-visit" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Visit</h1><p class="color-highlight">Schedule your Vist</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-3"></div>
		<div class="content px-1">

				<form method="post">
                 <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                 <input type="hidden" name="activity_type" value="Visit" />

<div class="input-style input-style-always-active no-borders no-icon">
				<input type="number" class="form-control border-0" id="f3" placeholder="<?=$orgname?>" disabled="disabled">
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Lead Organization</label>
			</div>


			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="text" name="subject" id="subject" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Visit Purpose:</label>
			</div>
			
			
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="text" name="location" id="location" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Visit Location:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="date" name="date" id="date" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Visit Date:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="time" name="time" id="time" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Visit Time:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
                <label for="f4" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Prioritys Type</label>
                <select id="f4" class="form-control req" name="priority_status">
                     <option value="LOW">LOW</option>
                     <option value="MEDIUM">MEDIUM</option>
					 <option value="HIGH">HIGH </option>
                </select>
                <span><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <em></em>
            </div>
			<div class="input-style input-style-always-active no-borders no-icon">
				<textarea class="form-control req1" name="details"></textarea>
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Note:</label>
			</div>









<!--			<div class="input-style input-style-always-active no-borders no-icon">
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
			</div>-->
			<button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-highlight rounded-sm text-uppercase font-800 mb-4 width-100">Add Visit </button>
			</form>
		</div>
	</div>
	
	<!-- Transfer Menus -->
	<div id="menu-transaction-transfer-email" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Email</h1><p class="color-highlight">Email Details</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-3"></div>
		<div class="content px-1">

           <form method="post">
             <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
			 <input type="hidden" name="activity_type" value="Email" />



			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="number" class="form-control border-0" id="f3" placeholder="<?=$orgname?>" disabled="disabled">
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Lead Organization</label>
			</div>


			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="date" name="date" id="date" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Email Date:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="time" name="time" id="time" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Email Time:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
                <label for="f4" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Prioritys Type</label>
                <select id="f4" class="form-control req" name="priority_status">
                     <option value="LOW">LOW</option>
                     <option value="MEDIUM">MEDIUM</option>
					 <option value="HIGH">HIGH </option>
                </select>
                <span><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <em></em>
            </div>

			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="email" name="email_to" id="email_to" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Email to:</label>
			</div>
			
			
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="text" name="subject" id="subject" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Email Subject:</label>
			</div>

			<div class="input-style input-style-always-active no-borders no-icon">
				<textarea class="form-control req1" name="details"></textarea>
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Email Body:</label>
			</div>














<!--			<div class="input-style input-style-always-active no-borders no-icon">
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
			</div>-->
			<button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-highlight rounded-sm text-uppercase font-800 mb-4 width-100">Add Email </button>
			</form>
		</div>
	</div>

	<!-- call Request Menus -->
	<div id="menu-transaction-request" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Request Call</h1><p class="color-highlight">Enter Call Details</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-2"></div>
		<div class="content px-1">
		<form method="post">
				 <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
                 <input type="hidden" name="call_main" value="Schedule" />
                 <input type="hidden" name="activity_type" value="Call" />
                 <input type="hidden" name="main" value="1" />
					<div class="input-style input-style-always-active no-borders no-icon">
				<input type="number" class="form-control border-0" id="f3" placeholder="<?=$orgname?>" disabled="disabled">
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Lead Organization</label>
			</div>



			<div class="input-style input-style-always-active no-borders no-icon">
				 <input type="text" class="form-control req" name="call_to" id="call_to">
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Call to:</label>
			</div>



            <div class="input-style input-style-always-active no-borders no-icon">
                <label for="f1" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Call type:</label>
                <select id="f1" class="form-control req" name="call_type" required>
                   <option value="Inbound Call">Inbound Call</option>
                   <option value="Outbound Call">Outbound Call</option>
                </select>
                <span><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <em></em>
            </div>
						<div class="input-style input-style-always-active no-borders no-icon">
                <label for="f4" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Prioritys Type</label>
                <select id="f4" class="form-control req" name="priority_status">
                     <option value="LOW">LOW</option>
                     <option value="MEDIUM">MEDIUM</option>
					 <option value="HIGH">HIGH </option>
                </select>
                <span><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <em></em>
            </div>
			

			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="date" name="date" id="date" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Call Date:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="time" name="time" id="time" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Call Time:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="text" name="subject" id="subject" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Call Purpose:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
				<textarea class="form-control req1" name="details"></textarea>
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Note:</label>
			</div>
		
		
		
		
		
		
		
		
		
		
		
<!--			<div class="input-style input-style-always-active validate-field no-borders no-icon">
				<input type="email" class="form-control validate-email" id="f2c" placeholder=name@domain.com>
				<label for="f2c" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Request From</label>
				<i class="fa fa-times disabled invalid color-red-dark"></i>
				<i class="fa fa-check disabled valid color-green-dark"></i>
				<em>(required)</em>
			</div>

			<div class="input-style input-style-always-active validate-field no-borders no-icon">
				<input type="number" class="form-control validate-number" id="f3" placeholder="1000">
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Enter AMMOUNT</label>
				<i class="fa fa-times disabled invalid color-red-dark"></i>
				<i class="fa fa-check disabled valid color-green-dark"></i>
				<em>(required)</em>
			</div>-->
			
			<button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Add Call </button>
			</form>
		</div>
	</div>

	<!-- Convert Menus -->
	<div id="menu-transaction-convert" class="menu menu-box-bottom menu-box-detached">
		<div class="menu-title"><h1>Tasks</h1><p class="color-highlight">Enter Task Details</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
		<div class="divider divider-margins mt-3 mb-2"></div>
		<div class="content px-1">
		<form method="post">
		     <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
             <input type="hidden" name="activity_type" value="Task" />
		
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="number" class="form-control border-0" id="f3" placeholder="<?=$orgname?>" disabled="disabled">
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Lead Organization</label>
			</div>

			<div class="input-style input-style-always-active no-borders no-icon">
				<input class="form-control req" name="subject" id="subject">
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Task Name:</label>
			</div>

			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="date" name="date" id="date" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Task Date:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="time" name="time" id="time" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Task Time:</label>
			</div>
			
		<div class="input-style input-style-always-active no-borders no-icon">
				<input type="date" name="remainder_date" id="remainder_date" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Remainder Date:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
				<input type="time" name="remainder_time" id="remainder_time" value="" class="form-control req" />
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Remainder Time:</label>
			</div>
			<div class="input-style input-style-always-active no-borders no-icon">
                <label for="f4" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Prioritys Type</label>
                <select id="f4" class="form-control req" name="priority_status">
                     <option value="LOW">LOW</option>
                     <option value="MEDIUM">MEDIUM</option>
					 <option value="HIGH">HIGH </option>
                </select>
                <span><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check disabled valid color-green-dark"></i>
                <em></em>
            </div>
			<div class="input-style input-style-always-active no-borders no-icon">
				<textarea class="form-control req1" name="details"></textarea>
				<label for="f3" class="color-theme opacity-30 text-uppercase font-700 font-10 mt-1">Tasks Details:</label>
			</div>
		
		

		
<!--		
		
		
		
		
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
			</div>-->
			
			<button type="submit" name="scCall" class="close-menu btn btn-full btn-m bg-blue-dark rounded-sm text-uppercase font-800 mb-4 width-100">Add Task </button>
			
			
			</form>
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
     
    
  <?php include_once('../template/link_footer.php'); ?>