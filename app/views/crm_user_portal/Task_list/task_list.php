<?php

//

//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = 'Task List';

$proj_id = $_SESSION['proj_id'];

$table = 'task_manage';

$unique = 'id';

do_datatable('ac_ledger');

$crud = new crud($table);

if (isset($_POST['upProgress'])) {

	$crud->update($unique);
	echo "<script>window.top.location='task_list.php'</script>";
}


?>

<style type="text/css">
	<!--
	.style3 {
		color: #FFFFFF;
		font-weight: bold;
	}
	-->

</style>









<center>Personal Task List</center>



<div class="text-right">
	<a href="task_entry_personal.php"><button class="btn btn-primary">Add Task</button></a>
</div>


<div class="form-container_large">

	<div class="container-fluid pt-5 p-0">



		<table class="table1  table-striped table-bordered table-hover table-sm" id="ac_ledger">

			<thead class="thead1">

				<tr class="bgc-info">

					<th>SL</th>

					<th>Task Name</th>

					<th>Start Date</th>

					<th>End Date</th>

					<th>Task Status</th>

					<th>Action</th>

				</tr>

			</thead>



			<tbody class="tbody1">



				<?php

				$uID = find_a_field('user_activity_management', 'PBI_ID', 'user_id="' . $_SESSION['user']['id'] . '"');

				$i = 1;



				$sql = "select * from task_manage where assign_person='" . $uID . "' and status!='Done'";

				$query = db_query($sql);

				while ($data = mysqli_fetch_object($query)) {



				?>

					<tr>
						<td><?= $i++; ?></td>
						<td style="cursor:pointer" onclick="window.open('task_up.php?id=<?= $data->id ?>')"><?= $data->task_name ?></td>
						<td><?= $data->task_start ?></td>
						<td><?= $data->task_end ?></td>
						<td>
							<form method="post">
								<input type="hidden" value="<?= $data->id ?>" name="id" />
								<select name="status" width="50%">
									<option value="<?= $data->status ?>"><?= $data->status ?></option>
									<option value="Pending">Pending</option>

									<option value="Started">Started</option>

									<option value="On-Progress">On-Progress</option>

									<option value="On-Hold">On-Hold</option>

									<option value="Over Due">Over Due</option>

									<option value="Done">Done</option>

								</select>
						</td>
						<td>


							<input type="submit" class="btn btn-success" name="upProgress" value="Update" />

							</form>
						</td>


					</tr>

				<? } ?>


			</tbody>

		</table>





	</div>

</div>

















<script type="text/javascript">
	function Do_Nav() {

		var URL = 'pop_ledger_selecting_list.php';

		popUp(URL);

	}



	function DoNav(theUrl) {

		document.location.href = 'add_project.php?project_id=' + theUrl;

	}



	function popUp(URL)

	{

		day = new Date();

		id = day.getTime();

		eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

	}
</script>

<script type="text/javascript">
	document.onkeypress = function(e) {

		var e = window.event || e

		var keyunicode = e.charCode || e.keyCode

		if (keyunicode == 13)

		{

			return false;

		}

	}



	$(document).ready(function() {

		$('.select2').select2({

			placeholder: "Please select here",

			width: "100%"

		});

	})
</script>

<?



//

require_once SERVER_CORE."routing/layout.bottom.php";

?>