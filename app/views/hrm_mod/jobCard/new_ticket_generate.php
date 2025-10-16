<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Ticket Management';			// Page Name and Page Title
$page="new_ticket_generate.php";		// PHP File Name

$root='user_management';

$table='cutomer_tickets_genarate';		// Database Table Name Mainly related to this page
$unique='ticket_id';			// Primary Key of this Database table
$shown='customer_id';				// For a New or Edit Data a must have data field
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

if(isset($_POST['insertTicket']))
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
foreach($data as $key => $value)
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
?>
<style>
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
		
		
		
body{
    background: #F4F7FD;
    margin-top:20px;
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
    background-color: #ffffff;
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
  color: #4e73e5;
  font-weight: 500;
  font-size: 1.5rem;
  line-height: 1;
}

.widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-month {
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
    </style>
<form action="" method="post">
  <div class="container mt-5">
    <!-- Task Status Tabs -->
    <ul class="nav nav-tabs rounded" id="taskTabs">
      <li class="nav-item">
        <button type="button" class="btn btn-primary btn-md nav-link" data-toggle="modal" 
    data-target="#addtaskmodal" style="background-color: #2962FF !important; float-right"> <i class="fa fa-plus"></i> Add a Task </button>
      </li>
      <li class="nav-item"> <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending"> <i class="fas fa-exclamation-circle"></i> Pending </a> </li>
      <li class="nav-item"> <a class="nav-link" id="complete-tab" data-toggle="tab" href="#complete"> <i class="fas fa-check-circle"></i> Complete </a> </li>
      <li class="nav-item"> <a class="nav-link" id="archives-tab" data-toggle="tab" href="#archives"> <i class="fas fa-archive"></i> Archives </a> </li>
    </ul>
    <!-- Task Status Tab Content -->
    <div class="tab-content mt-3">
      <!-- Pending Tab -->
      <div class="tab-pane fade show active" id="pending">
        <div class="row">
          <div class="col">
            <!-- Bootstrap Table for Pending Tasks -->
            <?php /*?><div class="card">
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
                          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal"> <i class="fas fa-edit"></i> </button>
                          <!-- Delete Task Icon (Open Confirm Modal) -->
                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"> <i class="fas fa-trash-alt"></i> </button></td>
                     
                    </tr>
                    
					
					<? } ?>
					
					
					
                  </tbody>
                </table>
              </div>
            </div><?php */?>
			
			<div class="container">
<div class="row">

         <?

//and a.entry_by='.$_SESSION['employee_selected'].'
					$s=1;
                   //customer_id="'.$_SESSION['user']['id'].'" 
					 $res='select *  from cutomer_tickets_genarate  where 1';

					$query=db_query($res);
					while($data = mysqli_fetch_object($query)){



					?>


    <div class="col-lg-4">
        <div class="card card-margin">
            <div class="card-header no-border">
                <h5 class="card-title"><?=$data->ticket_id?></h5>
            </div>
            <div class="card-body pt-0">
                <div class="widget-49">
                    <div class="widget-49-title-wrapper">
                        <div class="widget-49-date-primary">
                            <span class="widget-49-date-day">09</span>
                            <span class="widget-49-date-month">apr</span>
                        </div>
                        <div class="widget-49-meeting-info">
                            <span class="widget-49-pro-title"><?=$data->task_name?></span>
                            <span class="widget-49-meeting-time">12:00 to 13.30 Hrs</span>
                        </div>
                    </div>
                    <ol class="widget-49-meeting-points">
                        <li class="widget-49-meeting-item"><span>Expand module is removed</span></li>
                        <li class="widget-49-meeting-item"><span>Data migration is in scope</span></li>
                        <li class="widget-49-meeting-item"><span>Session timeout increase to 30 minutes</span></li>
                    </ol>
                    <div class="widget-49-meeting-action">
                        <a href="#" class="btn btn-sm btn-flash-border-primary">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <? } ?>
</div>
</div>


            
          </div>
        </div>
      </div>
      <!-- Complete Tab -->
      <div class="tab-pane fade" id="complete">
        <div class="row">
          <div class="col">
            <!-- Bootstrap Table for Complete Tasks -->
            <div class="container">
<div class="row">
    <div class="col-lg-4">
        <div class="card card-margin">
            <div class="card-header no-border">
                <h5 class="card-title">MOM</h5>
            </div>
            <div class="card-body pt-0">
                <div class="widget-49">
                    <div class="widget-49-title-wrapper">
                        <div class="widget-49-date-primary">
                            <span class="widget-49-date-day">09</span>
                            <span class="widget-49-date-month">apr</span>
                        </div>
                        <div class="widget-49-meeting-info">
                            <span class="widget-49-pro-title">PRO-08235 DeskOpe. Website</span>
                            <span class="widget-49-meeting-time">12:00 to 13.30 Hrs</span>
                        </div>
                    </div>
                    <ol class="widget-49-meeting-points">
                        <li class="widget-49-meeting-item"><span>Expand module is removed</span></li>
                        <li class="widget-49-meeting-item"><span>Data migration is in scope</span></li>
                        <li class="widget-49-meeting-item"><span>Session timeout increase to 30 minutes</span></li>
                    </ol>
                    <div class="widget-49-meeting-action">
                        <a href="#" class="btn btn-sm btn-flash-border-primary">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-margin">
            <div class="card-header no-border">
                <h5 class="card-title">MOM</h5>
            </div>
            <div class="card-body pt-0">
                <div class="widget-49">
                    <div class="widget-49-title-wrapper">
                        <div class="widget-49-date-warning">
                            <span class="widget-49-date-day">13</span>
                            <span class="widget-49-date-month">apr</span>
                        </div>
                        <div class="widget-49-meeting-info">
                            <span class="widget-49-pro-title">PRO-08235 Lexa Corp.</span>
                            <span class="widget-49-meeting-time">12:00 to 13.30 Hrs</span>
                        </div>
                    </div>
                    <ol class="widget-49-meeting-points">
                        <li class="widget-49-meeting-item"><span>Scheming module is removed</span></li>
                        <li class="widget-49-meeting-item"><span>App design contract confirmed</span></li>
                        <li class="widget-49-meeting-item"><span>Client request to send invoice</span></li>
                    </ol>
                    <div class="widget-49-meeting-action">
                        <a href="#" class="btn btn-sm btn-flash-border-warning">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-margin">
            <div class="card-header no-border">
                <h5 class="card-title">MOM</h5>
            </div>
            <div class="card-body pt-0">
                <div class="widget-49">
                    <div class="widget-49-title-wrapper">
                        <div class="widget-49-date-success">
                            <span class="widget-49-date-day">22</span>
                            <span class="widget-49-date-month">apr</span>
                        </div>
                        <div class="widget-49-meeting-info">
                            <span class="widget-49-pro-title">PRO-027865 Opera module</span>
                            <span class="widget-49-meeting-time">12:00 to 13.30 Hrs</span>
                        </div>
                    </div>
                    <ol class="widget-49-meeting-points">
                        <li class="widget-49-meeting-item"><span>Scope is revised and updated</span></li>
                        <li class="widget-49-meeting-item"><span>Time-line has been changed</span></li>
                        <li class="widget-49-meeting-item"><span>Received approval to start wire-frame</span></li>
                    </ol>
                    <div class="widget-49-meeting-action">
                        <a href="#" class="btn btn-sm btn-flash-border-success">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
          <h5 class="modal-title" id="exampleModalLabel">New ticket</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <i class="fa-solid fa-xmark"></i> </button>
        </div>
        <div class="modal-body m-3  ">
          
          
       
          <input type="hidden" name="customer_id " id="customer_id " value="2323" />
          <div class="form-outline mb-2">
            <textarea style=" font-size: 14px;"  class="form-control form-control-lg  mb-2"  type="text"  name="task_name" id="task_name" cols="30" rows="5" placeholder="*What is your request?"></textarea>
          </div>
          <div class="form-outline mt-4 mb-2">
            <label for="">Enter request date</label>
            <input type="date" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_date" id="task_date"   placeholder="Subject">
          </div>
          <div class="form-outline mb-2">
            <label for="">Enter request Time</label>
            <input type="time" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_time" id="task_time"   placeholder="Subject">
          </div>
          <div class="form-outline mb-2">
            <label for="">Request Type</label>
            <input type="text" class="form-control form-control-lg " style="margin-top:1em !important;" name="request_type" id="request_type"  
			 placeholder="Subject">
          </div>
          <div class="form-outline mb-2">
            <label for="">More Information If Needed </label>
            <input type="text" class="form-control form-control-lg " style="margin-top:1em !important;" name="task_details" id="task_details" placeholder="Subject">
          </div>
          <div class="text-center text-lg-start mt-4 pt-2">
            <input type="submit" name="insertTicket" id="submit" value="submit" class="btn btn-primary btn-lg"/>
          
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
