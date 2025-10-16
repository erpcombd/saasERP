<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Daily Task Entry';

$crud = new crud('task_manage');

$pId=find_all_field('user_activity_management','','user_id="'.$_SESSION['user']['id'].'"');

if(isset($_POST['submit'])){

$_POST['entry_by']=$_SESSION['user']['id'];

$crud->insert();

echo "<script>window.top.location='task_list.php'</script>";

}



?>



<div class="modal-body">

        <form action="" method="post" style="text-align:left">

          <div class="form-group">

            <label for="recipient-name" class="col-form-label">Assign Person: </label>

            <select class="form-control " name="assign_person" value="" id="recipient-name" >
			<option value="<?=$pId->PBI_ID?>"><?=$pId->fname?></option>

				

			</select>

          </div>
		  
		  
		  <div class="form-group">

            <label for="recipient-name" class="col-form-label">Project: </label>

            <select class="form-control " name="project" value="" id="recipient-name" required>
			<option> </option>

				<?  foreign_relation('crm_project_org','id','name',$project,' 1');?>

			</select>

          </div>

		  <div class="form-group">

            <label for="recipient-name" class="col-form-label">Task Name:</label>

            <input type="text" class="form-control" name="task_name"  id="recipient-name">

          </div>
		  
		  <div class="form-group">

            <label for="message-text" class="col-form-label">Description:</label>

            <textarea class="form-control" name="task_des" ></textarea>

          </div>

		  

		  <div class="row">
		  <div class="col-6">
		  <div class="form-group">

            <label for="recipient-name" class="col-form-label">Task Start Date:</label>

            <input type="date" class="form-control" name="task_start"  value="<?=$task_data->task_date?>" id="recipient-name">

          </div>
		  </div>
<div class="col-6">
		  <div class="form-group">

            <label for="recipient-name" class="col-form-label">Task End Date:</label>

            <input type="date" class="form-control" name="task_end" value="<?=$task_data->task_end_date?>" id="recipient-name">

          </div>
		  </div>
		  </div>

		  <div class="form-group">

            <span>Start Time:</span>

            <input type="time" style="width:30%" class="form-control" name="task_start_time" value="<?=$task_data->start_time?>" id="recipient-name">

			<span>End Time:</span>

            <input type="time" class="form-control" style="width:30%" name="task_end_time" value="<?=$task_data->end_time?>" id="recipient-name">

          </div>

          
		  
		  <div class="form-group">
		  
		  <label for="message-text" class="col-form-label">Priority Level:</label>
		  <select type="time" class="form-control" style="width:30%" name="task_priority" value="<?=$task_data->end_time?>" id="recipient-name">
		  <option></option>
		  <?  foreign_relation('mis_task_priority','id','priority','',' 1');?>
		  </select>
		  
		  </div>

		  

		  <div class="form-group">

            <label for="recipient-name" class="col-form-label">Status:</label>

            <select name="status" id="status" class="custom-select custom-select-sm">

				<option value="Pending">Pending</option>

				<option value="Started" >Started</option>

				<option value="On-Progress" >On-Progress</option>

				<option value="On-Hold" >On-Hold</option>

				<option value="Over Due" >Over Due</option>

				<option value="Done" >Done</option>

			</select>

          </div>
		  
		  <div class="form-group">
		   <input type="submit" class="form-control btn btn-success"  name="submit" value="Confirm" >
		  </div>

        <form>

      </div>
	  
<?



require_once SERVER_CORE."routing/layout.bottom.php";




?>