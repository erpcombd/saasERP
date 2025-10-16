<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Roll Management';			// Page Name and Page Title
$page="module_manage.php";		// PHP File Name
$input_page="module_manage_input.php";
$root='user_management';

$table='user_module_manage';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='module_name';				// For a New or Edit Data a must have data field
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

if(isset($_POST['insert']))
{		
$now				= time();


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
<script type="text/javascript"> function DoNav(theUrl)
{
	window.open('roll_create_assign.php?user_id='+theUrl,'_self',false);
}</script>

<form action="" method="post">

<p class="text-muted font-13 m-b-30">
<button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#addtaskmodal"> <i class="fa fa-plus"></i> Add a Task</button>
</p>
					
					
					
  <div class="container-fluid pt-5 p-0 ">
    <table id="grp" class="table1  table-striped table-bordered table-hover table-sm ">
      <thead class="thead1">
        <tr class="bgc-info">
          <th>User ID</th>
          <th>User Name</th>
          <th>Fname</th>
          <th>Designation</th>
          <th>Level</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody class="tbody1">
        <?

//and a.entry_by='.$_SESSION['employee_selected'].'
					$s=1;

					 $res='select user_id,user_id,username,fname,designation,level,status 
					 from user_activity_management where PBI_ID>0';

					$query=db_query($res);
					while($data = mysqli_fetch_object($query)){



					?>
        <tr>
          <td><?=$data->user_id;?></td>
          <td><?=$data->username;?></td>
          <td><?=$data->fname?></td>
          <td><?=$data->designation?></td>
          <td><?=$data->level?></td>
          <td><?=$data->status?></td>
          <td><a class="btn1 btn1-bg-update" href="roll_create_assign.php?user_id=<?=$data->user_id?>">Edit</a></td>
        </tr>
        <? } ?>
      </tbody>
    </table>
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
            <input name="task_name" id="task_name" value="" type="text" id="form3Example3" class="form-control form-control-lg"
                                placeholder="Enter your task name" />
          </div>
          <input type="text" name="lead_id" id="lead_id" value="<?=$id?>" />
          <input type="hidden" name="activity_id" id="activity_id" value="<?=$activityd?>" />
          <div class="form-outline mb-3">
            <select class="form-control form-control-lg ">
              <option value="<?=$orgname?>">
              <?=$orgname?>
              </option>
              <!-- <? //foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');?> -->
            </select>
          </div>
          <!-- <div class="form-outline mb-3">

                                <select class="form-control form-control-lg ">
                                    <option value="<?//=$orgname?>"><?//=$orgname?></option>
                                                <? //foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');?> -->
          <!-- </select> -->
          <!-- </div> -->
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




  <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
 



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
