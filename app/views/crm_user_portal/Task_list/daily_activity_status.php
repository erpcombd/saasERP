<?php

//

//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = 'Task List';

$proj_id = $_SESSION['proj_id'];

$table = 'activity_manage';

$unique = 'id';

do_datatable('ac_ledger');

$crud = new crud($table);

if (isset($_POST['upProgress'])) {

	$crud->update($unique);
	echo "<script>window.top.location='task_list.php'</script>";
}


?>






<center><button class="btn btn-info" id="hide" onclick="printDiv()">Print</button></center><br><br>

<form action="" method="post">
	<div class="row d-flex justify-content-center">
		<div class="col-3">
			<select name="status">

				<option value=""></option>

				<option value="Pending">Pending</option>

				<option value="Started">Started</option>

				<option value="On-Progress">On-Progress</option>

				<option value="On-Hold">On-Hold</option>

				<option value="Over Due">Over Due</option>

				<option value="Done">Done</option>

			</select>
		</div>
		<div class="col-3">
			<input type="date" name="fDate" class="form-control">
		</div>
		<div class="col-3">
			<input type="date" name="tDate" class="form-control">
		</div>
		<div class="col-3">
			<input class="btn btn-success" type="submit" name="search" value="Search">
		</div>
	</div>
</form>


<div class="form-container_large" id="pr">

	<center>Daily Activity Report</center>

	<div class="text-right"><?= date('Y-m-d H:i:s a') ?></div>

	<div class="container-fluid pt-5 p-0">



		<table class="table1  table-striped table-bordered table-hover table-sm">

			<thead class="thead1">

				<tr class="bgc-info">

					<th>SL</th>

					<th>Company Name</th>

					<th>Activity Name</th>

					<th>Date</th>

					<th>Start Time</th>

					<th>End Time</th>

					<th>Task Status</th>

				</tr>

			</thead>



			<tbody class="tbody1">



				<?php

				$uID = find_a_field('user_activity_management', 'PBI_ID', 'user_id="' . $_SESSION['user']['id'] . '"');

				$i = 1;

				if (isset($_POST['search'])) {
					if ($_POST['status'] != '') {
						$sCon = ' and status="' . $_POST['status'] . '"';
					}
					if ($_POST['fDate'] != '' && $_POST['tDate'] != '') {
						$sCon .= ' and task_start between "' . $_POST['fDate'] . '" and "' . $_POST['tDate'] . '"';
					}
				}

				$sql = "select * from activity_manage where assign_person='" . $uID . "' " . $sCon . "";

				$query = db_query($sql);

				while ($data = mysqli_fetch_object($query)) {



				?>

					<tr>
						<td><?= $i++; ?></td>
						<td><?= $data->company ?></td>
						<td><?= $data->activity_name ?></td>
						<td><?= $data->task_start ?></td>
						<td><?= $data->task_start_time ?></td>
						<td><?= $data->task_end_time ?></td>
						<td><?= $data->status ?></td>


					</tr>

				<? } ?>


			</tbody>

		</table>





	</div>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>