<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Task Management';			// Page Name and Page Title
$page="new_task.php";		// PHP File Name

$root='user_management';

$table='crm_billMood_task_manage ';		// Database Table Name Mainly related to this page
$unique='task_id';			// Primary Key of this Database table
$shown='PBI_ID';				// For a New or Edit Data a must have data field
do_datatable('grp');
// ::::: End Edit Section :::::

if($_GET['user_id']>0){
	 $access = $_GET['user_id'];
	}
$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insertTasks']))
{		
$now				= time();

$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];

$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
}


//for Modify..................................

if(isset($_POST['update']))
{

		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		$type=1;
		$msg='Successfully Deleted.';
}
}

if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
  <style>
                        /* Custom Styles */
						.nav{
						justify-content: space-around;
						}
                        .nav-tabs {
							padding:20px;
                            border: 1px solid #dee2e6;
                            background: linear-gradient(45deg, #b3c8ff, #7da5ff, #467cff, #0048ff); /* Soft background color */
                            border-radius: 5px;
                        }
                
                        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
                            color: #fff;
                            background-color: #D8F0FA;
                            border-color: #007bff;
                        }
                
                        .nav-tabs .nav-link {
                            color: #007bff;
                            border: 1px solid transparent;
                            border-radius: 5px;
                        }
                
                       .card-header {
                            background-color: #D3BEBD !important;
                            color: #fff;
                            border-radius: 5px 5px 0 0;
                        }
                
                			   /* Define different card colors */
                		.card-visit .card-header {
                			background: linear-gradient(45deg, #6ec979, #8DE697, #B6F3A8) !important; /* Blue color */
                			color: #fff; /* White text */
                		}
                		
                		.card-call .card-header {
                			background: linear-gradient(90deg, #96dcff, #14A6EF) !important; /* Green color */
                			color: #fff; /* White text */
                		}
                		
                		.card-meeting .card-header {
                			background: linear-gradient(45deg, #812f19, #943921, #9f4229, #ad4a32, #bb543b, #c85d44) !important; /* Yellow color */
                			color: #fff; /* White text */
                		}
                		
                		.card-email .card-header {
                			background: linear-gradient(45deg, #800000, #dc143c, #eb4667) !important; /* Red color */
                			color: #fff; /* White text */
                		}
                		.card-task .card-header {
                			background: linear-gradient(45deg, #c11ceb, #6f19b5, #25007a) !important; /* Red color */
                			color: #fff; /* White text */
                		}
                
                
                        .progress-bar-success {
                            background-color: #28a745;
                        }
                
                        .progress-bar-warning {
                            background-color: #ffc107;
                        }
                
                        .progress-bar-danger {
                            background-color: #dc3545;
                        }
                		
                		.card-margin {
                			margin-bottom: 1.875rem;
                		}
                		
                		.card {
                			border: 0;
                			box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
                			-webkit-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
                			-moz-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
                			-ms-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
                		}
                		.card {
                			position: relative;
                			display: flex;
                			flex-direction: column;
                			min-width: 0;
                			word-wrap: break-word;
                			background: linear-gradient(45deg, #f2efdc, #f5f5f5) !important;
                			background-clip: border-box;
                			border: 1px solid #e6e4e9;
                			border-radius: 8px;
                		}
                		
                		.card .card-header.no-border {
                			border: 0;
                		}
                		.card .card-header {
                			background: none;
                			padding: 0 0.9375rem;
                			font-weight: 500;
                			display: flex;
                			align-items: center;
                			min-height: 50px;
                		}
                		.card-header:first-child {
                			border-radius: calc(8px - 1px) calc(8px - 1px) 0 0;
                		}
                		
                		.widget-49 .widget-49-title-wrapper {
						padding:20px;
                		  display: flex;
                		  align-items: center;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-primary {
                		  display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  flex-direction: column;
                		  background-color: #edf1fc;
                		  width: 4rem;
                		  height: 4rem;
                		  border-radius: 50%;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-day {
						display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  flex-direction: column;
                		  color: #4e73e5;
                		  font-weight: 500;
                		  font-size: 1.5rem;
                		  line-height: 1;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-month {
						display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  flex-direction: column;
                		  color: #4e73e5;
                		  line-height: 1;
                		  font-size: 1rem;
                		  text-transform: uppercase;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-secondary {
                		  display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  flex-direction: column;
                		  background-color: #fcfcfd;
                		  width: 4rem;
                		  height: 4rem;
                		  border-radius: 50%;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-day {
                		  color: #dde1e9;
                		  font-weight: 500;
                		  font-size: 1.5rem;
                		  line-height: 1;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-month {
                		  color: #dde1e9;
                		  line-height: 1;
                		  font-size: 1rem;
                		  text-transform: uppercase;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-success {
                		  display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  flex-direction: column;
                		  background-color: #e8faf8;
                		  width: 4rem;
                		  height: 4rem;
                		  border-radius: 50%;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-day {
                		  color: #17d1bd;
                		  font-weight: 500;
                		  font-size: 1.5rem;
                		  line-height: 1;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-month {
                		  color: #17d1bd;
                		  line-height: 1;
                		  font-size: 1rem;
                		  text-transform: uppercase;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-info {
                		  display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  flex-direction: column;
                		  background-color: #ebf7ff;
                		  width: 4rem;
                		  height: 4rem;
                		  border-radius: 50%;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-day {
                		  color: #36afff;
                		  font-weight: 500;
                		  font-size: 1.5rem;
                		  line-height: 1;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-month {
                		  color: #36afff;
                		  line-height: 1;
                		  font-size: 1rem;
                		  text-transform: uppercase;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-warning {
                		  display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  flex-direction: column;
                		  background-color: floralwhite;
                		  width: 4rem;
                		  height: 4rem;
                		  border-radius: 50%;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-day {
                		  color: #FFC868;
                		  font-weight: 500;
                		  font-size: 1.5rem;
                		  line-height: 1;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-month {
                		  color: #FFC868;
                		  line-height: 1;
                		  font-size: 1rem;
                		  text-transform: uppercase;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-danger {
                		  display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  flex-direction: column;
                		  background-color: #feeeef;
                		  width: 4rem;
                		  height: 4rem;
                		  border-radius: 50%;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-day {
                		  color: #F95062;
                		  font-weight: 500;
                		  font-size: 1.5rem;
                		  line-height: 1;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-month {
                		  color: #F95062;
                		  line-height: 1;
                		  font-size: 1rem;
                		  text-transform: uppercase;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-light {
                		  display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  flex-direction: column;
                		  background-color: #fefeff;
                		  width: 4rem;
                		  height: 4rem;
                		  border-radius: 50%;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-day {
                		  color: #f7f9fa;
                		  font-weight: 500;
                		  font-size: 1.5rem;
                		  line-height: 1;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-month {
                		  color: #f7f9fa;
                		  line-height: 1;
                		  font-size: 1rem;
                		  text-transform: uppercase;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-dark {
                		  display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  flex-direction: column;
                		  background-color: #ebedee;
                		  width: 4rem;
                		  height: 4rem;
                		  border-radius: 50%;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-day {
                		  color: #394856;
                		  font-weight: 500;
                		  font-size: 1.5rem;
                		  line-height: 1;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-month {
                		  color: #394856;
                		  line-height: 1;
                		  font-size: 1rem;
                		  text-transform: uppercase;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-base {
                		  display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  flex-direction: column;
                		  background-color: #f0fafb;
                		  width: 4rem;
                		  height: 4rem;
                		  border-radius: 50%;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-day {
                		  color: #68CBD7;
                		  font-weight: 500;
                		  font-size: 1.5rem;
                		  line-height: 1;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-month {
                		  color: #68CBD7;
                		  line-height: 1;
                		  font-size: 1rem;
                		  text-transform: uppercase;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-meeting-info {
                		  display: flex;
                		  flex-direction: column;
                		  margin-left: 1rem;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-pro-title {
                		  color: #3c4142;
                		  font-size: 14px;
                		}
                		
                		.widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-meeting-time {
                		  color: #B1BAC5;
                		  font-size: 13px;
                		}
                		
                		.widget-49 .widget-49-meeting-points {
                		  font-weight: 400;
                		  font-size: 13px;
                		  margin-top: .5rem;
                		}
                		
                		.widget-49 .widget-49-meeting-points .widget-49-meeting-item {
                		  display: list-item;
                		  color: #727686;
                		}
                		
                		.widget-49 .widget-49-meeting-points .widget-49-meeting-item span {
                		  margin-left: .5rem;
                		}
                		
                		.widget-49 .widget-49-meeting-action {
                		  text-align: right;
                		}
                		
                		.widget-49 .widget-49-meeting-action a {
                		  text-transform: uppercase;
                		}
                		.original-button {
                		  display: flex;
                		  align-items: center;
                		  justify-content: center;
                		  line-height: 1;
                		  text-decoration: none;
                		  color: #e80808;
                		  font-size: 15px;
                		  border-radius: 50px;
                		  width: 100px;
                		  height: 100px;
                		  font-weight: bold;
                		  transition: 0.3s;
                		  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.5);
                		  background-image: ;
                		}
                		
                		.original-button:hover {
                		  transform: translateY(2px);
                		  box-shadow: 0 0 rgba(0, 0, 0, 0);
                		}
                		
                		.complete-button {
                    display: inline-block;
                	margin:16px;
                    padding: 8px 8px;
                    background-color: #14A44D;
                    color: white;
                    text-align: center;
                    text-decoration: none;
                    border: none;
                    border-radius: 16px;
                    cursor: pointer;
                	}
                	
                	.complete-button:hover {
                		background-color: #14A44D;
                	}
                	
                	.complete-button:active {
                		background-color: #14A44D;
                	}
					
					
					.cancelled-button {
                    display: inline-block;
                	margin:16px;
                    padding: 8px 8px;
                    background-color: #DC4C64;
                    color: white;
                    text-align: center;
                    text-decoration: none;
                    border: none;
                    border-radius: 16px;
                    cursor: pointer;
                	}
                	
                	.cancelled-button:hover {
                		background-color: #DC4C64;
                	}
                	
                	.cancelled-button:active {
                		background-color: #DC4C64;
                	}
					
					.pending-button {
                    display: inline-block;
                	margin:16px;
                    padding: 8px 8px;
                    background-color: #E4A11B;
                    color: white;
                    text-align: center;
                    text-decoration: none;
                    border: none;
                    border-radius: 16px;
                    cursor: pointer;
                	}
                	
                	.pending-button:hover {
                		background-color: #E4A11B;
                	}
                	
                	.pending-button:active {
                		background-color: #E4A11B;
                	}
					
					
					       /* Custom Styles */
        .nav-tabs {
            border: 1px solid #dee2e6;
            background-color: #6BBF59; /* Soft background color */
            border-radius: 5px;
        }

        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #fff;
            background-color: #D8F0FA;
            border-color: #007bff;
        }

        .nav-tabs .nav-link {
            color: #007bff;
            border: 1px solid transparent;
            border-radius: 5px;
        }

       .card-header {
            background-color: #3D90A7 !important;
            color: #fff;
            border-radius: 5px 5px 0 0;
        }
       

        .progress-bar-success {
            background-color: #28a745;
        }

        .progress-bar-warning {
            background-color: #ffc107;
        }

        .progress-bar-danger {
            background-color: #dc3545;
        }
					
                    </style>
<form action="" method="post">
  <div class="mycontainer">
    <!-- Task Status Tabs -->
 <ul class="nav nav-tabs rounded" id="taskTabs">
      <li class="nav-item">
        <button type="button" class="btn btn-primary btn-md nav-link" data-toggle="modal" 
    data-target="#addtaskmodal" style="background-color: #2962FF !important; color: black; float-right"> <i class="fa fa-plus"></i> Add a Task </button>
      </li>
      <li class="nav-item"> <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending"style="color: black;"> <i class="fas fa-exclamation-circle"></i> Pending </a> </li>
      <li class="nav-item"> <a class="nav-link" id="complete-tab" data-toggle="tab" href="#complete"style="color: black;"> <i class="fas fa-check-circle"></i> Complete </a> </li>
      <li class="nav-item"> <a class="nav-link" id="archives-tab" data-toggle="tab" href="#archives"style="color: black;"> <i class="fas fa-archive"></i> Archives </a> </li>
    </ul>
    <!-- Task Status Tab Content -->
    <div class="tab-content mt-3">
      <!-- Pending Tab -->
      <div class="tab-pane fade show active" id="pending">
        <div class="row">
          <div class="col">
            <!-- Bootstrap Table for Pending Tasks -->
            <div class="card">
              <div class="card-header"> Pending Tasks </div>
              <div class="card-body">
                <table class="table table-bordered table-sm">
                  <!-- Table Header -->
                  <thead>
                    <tr>
                      <th>Task ID</th>
                      <th>Task Description</th>
                       <th>Status</th>
					  
					   <th>Task Date</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <!-- Table Body -->
                  <tbody>
                    <?

//and a.entry_by='.$_SESSION['employee_selected'].'
					$s=1;

					 $res='select *  from crm_billMood_task_manage  where entry_by="'.$_SESSION['user']['id'].'"';

					$query=db_query($res);
					while($data = mysqli_fetch_object($query)){



					?>
                    <tr>
                   
                        <td><?=$data->task_id;?></td>
                        <td>
						<h6 class="note-title text-truncate w-75 mb-0"> <?=$data->task_name?> </h6>
					    <p class="card-text"><?=$data->task_details?></p></td>
                        <td><?
							if ($data->task_details > 0) {
								echo '<span class="badge badge-primary">Complete</span>';
							} else {
								echo '<span class="badge badge-danger">Pending</span>';
							}
							?></td>
							
						 <td><?=$data->task_date;?></td>
						 
                        <td><!-- Edit Task Icon (Open Modal) -->
      <!-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#EditModal"> <i class="fas fa-edit"></i> </button>-->
						  
	 <button type="button" class="btn btn-sm btn-primary edit-btn" data-toggle="modal" data-target="#EditModal" data-task-id="<?=$data->task_id;?>">
    <i class="fas fa-edit"></i>
</button>


                          <!-- Delete Task Icon (Open Confirm Modal) -->
                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"> <i class="fas fa-trash-alt"></i> </button></td>
                     
                    </tr>
                    
					
					<? } ?>
					
					
					
                  </tbody>
                </table>
              </div>
            </div>
            <!-- Pagination for Pending Tasks -->
            <nav aria-label="Page navigation">
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <!-- Add more pages as needed -->
              </ul>
            </nav>
          </div>
        </div>
      </div>
      <!-- Complete Tab -->
      <div class="tab-pane fade" id="complete">
        <div class="row">
          <div class="col">
            <!-- Bootstrap Table for Complete Tasks -->
            <div class="card">
              <div class="card-header"> Complete Tasks </div>
              <div class="card-body">
                <table class="table">
                  <!-- Table Header -->
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Task Description</th>
                      <th>Employee</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <!-- Table Body -->
                  <tbody>
                        <?

//and a.entry_by='.$_SESSION['employee_selected'].'
					$s=1;

					 $res='select *  from crm_billMood_task_manage  where marked_as_done=1 and  entry_by="'.$_SESSION['user']['id'].'"';

					$query=db_query($res);
					while($data = mysqli_fetch_object($query)){



					?>
                    <tr>
                   
                        <td><?=$data->task_id;?></td>
                        <td>
						<h6 class="note-title text-truncate w-75 mb-0"> <?=$data->task_name?> </h6>
					    <p class="card-text"><?=$data->task_details?></p></td>
                        <td><?
							if ($data->task_details > 0) {
								echo '<span class="badge badge-primary">Complete</span>';
							} else {
								echo '<span class="badge badge-danger">Pending</span>';
							}
							?></td>
							
						 <td><?=$data->task_date;?></td>
						 
                        <td><!-- Edit Task Icon (Open Modal) -->
                  <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#EhhditModal"> <i class="fas fa-edit"></i> </button>
						  
		
                          <!-- Delete Task Icon (Open Confirm Modal) -->
                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"> <i class="fas fa-trash-alt"></i> </button></td>
                     
                    </tr>
                    
					
					<? } ?>
					
					
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Archives Tab -->
      <div class="tab-pane fade" id="archives">
        <!-- Similar structure as Pending Tab -->
      </div>
    </div>
  </div>
  <!-- Add Task Modal -->
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <!-- Similar structure as Add Task Modal -->
  </div>
  <!-- Edit Task Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <!-- Similar structure as Add Task Modal -->
  </div>
  <!-- Delete Task Confirm Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <!-- Similar structure as Add Task Modal -->
  </div>
 
  
  
  <div class="modal fade " id="addtaskmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content w-100">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Task </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <i class="fa-solid fa-xmark"></i> </button>
        </div>
        <div class="modal-body m-3  ">
          <div class="form-outline mb-2">
            <input name="task_name" id="task_name form3Example3"  type="text"  class="form-control form-control-lg"
                                placeholder="Enter your task name" />
          </div>
          <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
          <input type="hidden" name="activity_id" id="activity_id" value="<?=$activityd?>" />
          <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['user']['id'];?>" />
          <div class="form-outline mb-2">
            <textarea style=" font-size: 14px;"  class="form-control form-control-lg  mb-2"  type="text"  name="task_details" id="task_details" cols="30" rows="5" placeholder="Tasks Details"></textarea>
          </div>
          <div class="form-outline mt-4 mb-2">
            <label for="">Enter task date</label>
            <input type="date" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_date" id="task_date"   placeholder="Subject">
          </div>
          <div class="form-outline mb-2">
            <label for="">Enter task Time</label>
            <input type="time" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_time" id="task_time"   placeholder="Subject">
          </div>
          <div class="form-outline mb-2">
            <label for="">Enter Remainder Date</label>
            <input type="date" class="form-control form-control-lg " style="margin-top:1em !important;" name="reaminder_start_date" id="reaminder_start_date"   placeholder="Subject">
          </div>
          <div class="form-outline mb-2">
            <label for="">Enter Remainder Time</label>
            <input type="time" class="form-control form-control-lg " style="margin-top:1em !important;" name="reaminder_start_time" id="reaminder_start_time"   placeholder="Subject">
          </div>
          <div class="text-center text-lg-start mt-4 pt-2">
            <input type="submit" name="insertTasks" id="submit" value="submit" class="btn btn-primary btn-lg"/>
            <!-- <input name="reset" type="button" class="btn btn-danger  btn-lg" id="reset" value="RESET" onclick="parent.location='show_all_tasks.php'"> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  
  
  
  
  <!--Edit MOdal Start -->
  
  <?  
  


    $task = find_all_field('crm_billMood_task_manage','','task_id="'.$_POST['task_id'].'"');
	
	  echo $taskId = $_POST['task_id'];
  
  ?>
  
  <div class="modal fade " id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content w-100">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Edit  Task </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <i class="fa-solid fa-xmark"></i> </button>
        </div>
        <div class="modal-body m-3  ">
          <div class="form-outline mb-2">
     <input name="task_name" id="task_name form3Example3"  type="text" value="<?=$task->task_name;?>"  class="form-control form-control-lg"/>
          </div>
          <input type="hidden" name="lead_id" id="lead_id" value="<?=$id?>" />
          <input type="hidden" name="activity_id" id="activity_id" value="<?=$activityd?>" />
          <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['user']['id'];?>" />
          <div class="form-outline mb-2">
            <textarea style=" font-size: 14px;"  class="form-control form-control-lg  mb-2"  type="text"  name="task_details" id="task_details" cols="30" rows="5" placeholder="Tasks Details"></textarea>
          </div>
          <div class="form-outline mt-4 mb-2">
            <label for="">Enter task date</label>
            <input type="date" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_date" id="task_date"   placeholder="Subject">
          </div>
          <div class="form-outline mb-2">
            <label for="">Enter task Time</label>
            <input type="time" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_time" id="task_time"   placeholder="Subject">
          </div>
          <div class="form-outline mb-2">
            <label for="">Enter Remainder Date</label>
            <input type="date" class="form-control form-control-lg " style="margin-top:1em !important;" name="reaminder_start_date" id="reaminder_start_date"   placeholder="Subject">
          </div>
          <div class="form-outline mb-2">
            <label for="">Enter Remainder Time</label>
            <input type="time" class="form-control form-control-lg " style="margin-top:1em !important;" name="reaminder_start_time" id="reaminder_start_time"   placeholder="Subject">
          </div>
          <div class="text-center text-lg-start mt-4 pt-2">
            <input type="submit" name="insertTasks" id="submit" value="submit" class="btn btn-primary btn-lg"/>
            <!-- <input name="reset" type="button" class="btn btn-danger  btn-lg" id="reset" value="RESET" onclick="parent.location='show_all_tasks.php'"> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  
  
  
  
  
  
  
  
  
  
  
</form>

<script>
    $(document).ready(function () {
        $('.edit-btn').click(function () {
            var taskId = $(this).data('task-id');
        
        });
    });
</script>


<script>
   /* $(document).ready(function () {
        $('.edit-btn').click(function () {
            var taskId = $(this).data('task-id');
            $.ajax({
                type: 'POST',
                url: 'get_task_data.php', 
                data: { task_id: taskId },
                success: function (response) {
                    $('#EditModal .modal-content').html(response);
                }
            });
        });
    });*/
</script>



<script>
$(document).ready(function() {
    $("#addtaskmodal form").submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        // Collect form data
        var formData = $(this).serialize();
        // Send AJAX request
        $.ajax({
            url: "process_task.php", // Replace with your PHP file path
            type: "POST",
            data: formData,
            success: function(response) {
                // Handle successful insertion
                // Display a success message or update content
                alert("Task added successfully!"); // Simple example
                $("#addtaskmodal").modal("hide"); // Close the modal
            },
            error: function(error) {
                // Handle errors
                console.error(error);
                alert("Failed to add task. Please try again.");
            }
        });
    });
});

</script>
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
