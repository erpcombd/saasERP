<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = 'Daily Activity Entry';

$crud = new crud('activity_manage');

$unique = 'id';

$pId = find_all_field('user_activity_management', '', 'user_id="' . $_SESSION['user']['id'] . '"');

if (isset($_POST['submit'])) {

	$_POST['assign_person'] = $pId->PBI_ID;

	$_POST['entry_by'] = $_SESSION['user']['id'];

	$crud->insert();

	echo "<script>window.top.location='daily_activity.php'</script>";
}

if (isset($_POST['update'])) {

	db_query('update activity_manage set status="' . $_POST['statusUp'] . '" where id="' . $_POST['upId'] . '"');

	echo "<script>window.top.location='daily_activity.php'</script>";
}

?>


<div class="row">
	<div class="col-5">

		<form action="" method="post" style="text-align:left">



			<div class="form-group">

				<label for="recipient-name" class="col-form-label">Activity Name:</label>

				<input type="text" class="form-control" name="activity_name" id="recipient-name">

			</div>

			<div class="form-group">

				<label for="message-text" class="col-form-label"> Activity Description:</label>

				<textarea class="form-control" name="activity_des"></textarea>

			</div>

			<div class="form-group">

				<label for="recipient-name" class="col-form-label">Company Name:</label>

				<input type="text" class="form-control" name="company" id="recipient-name">

			</div>

			<div class="form-group">

				<label for="recipient-name" class="col-form-label"> Date:</label>

				<input type="date" class="form-control" name="task_start" value="date(" Y-m-d")" id="recipient-name">

			</div>

			<div class="row">
				<div class="col-6">
					<div class="form-group">

						<label for="recipient-name" class="col-form-label"> Start Time:</label>

						<input type="time" class="form-control" name="task_start_time" value="<?= $task_data->start_time ?>" id="recipient-name">

					</div>
				</div>
				<div class="col-6">
					<div class="form-group">

						<label for="recipient-name" class="col-form-label"> End Time:</label>

						<input type="time" class="form-control" name="task_end_time" value="<?= $task_data->end_time ?>" id="recipient-name">

					</div>
				</div>
			</div>





			<div class="form-group">

				<label for="message-text" class="col-form-label">Priority Level:</label>
				<select type="time" class="form-control" style="width:30%" name="task_priority" value="<?= $task_data->end_time ?>" id="recipient-name">
					<option></option>
					<? foreign_relation('mis_task_priority', 'id', 'priority', '', ' 1'); ?>
				</select>

			</div>



			<div class="form-group">

				<label for="recipient-name" class="col-form-label">Status:</label>

				<select name="status" id="status" class="custom-select custom-select-sm">

					<option value="Pending">Pending</option>

					<option value="Started">Started</option>

					<option value="On-Progress">On-Progress</option>

					<option value="On-Hold">On-Hold</option>

					<option value="Over Due">Over Due</option>

					<option value="Done">Done</option>

				</select>

			</div>

			<div class="form-group">
				<input type="submit" class="form-control btn btn-success" name="submit" value="Confirm">
			</div>

			<form>

	</div>
	<div class="col-7">
		<center>
			<h4>Today Activity List</h4>
		</center>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th> Company</th>
					<th>Activity Name</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = 'select * from activity_manage where assign_person=' . $pId->PBI_ID . ' and status!="Done"';
				$query = db_query($sql);
				while ($data = mysqli_fetch_object($query)) {
				?>
					<tr>
						<form action="" method="post">
							<td><?= $data->company ?></td>
							<td><?= $data->activity_name ?></td>
							<td><?= $data->task_start_time ?></td>
							<td><?= $data->task_end_time ?></td>
							<input type="hidden" name="upId" value="<?= $data->id ?>">
							<td><select name="statusUp" class="form-control">
									<option value="<?= $data->status ?>"><?= $data->status ?></option>
									<option value="Pending">Pending</option>
									<option value="Started">Started</option>
									<option value="On-Progress">On-Progress</option>
									<option value="On-Hold">On-Hold</option>
									<option value="Done">Done</option>

								</select></td>
							<td><button type="submit" name="update" class="btn btn-sm btn-warning">Update</button></td>
						</form>
					</tr>

				<? } ?>
			</tbody>
		</table>
	</div>
</div>



<?



require_once SERVER_CORE."routing/layout.bottom.php";




?>