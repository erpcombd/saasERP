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
	echo "
<script>window.top.location='task_list.php'</script>";
}


?> <style type="text/css">
	<!--
	.style3 {
		color: #FFFFFF;
		font-weight: bold;
	}
	-->
</style> <?php /*?> <center>Personal Task List</center>
<div class="text-right">
	<a href="task_entry_personal.php">
		<button class="btn btn-primary">Add Task</button>
	</a>
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
			<tbody class="tbody1"> <?php

				$uID = find_a_field('user_activity_management', 'PBI_ID', 'user_id="' . $_SESSION['user']['id'] . '"');

				$i = 1;



				$sql = "select * from task_manage where assign_person='" . $uID . "' and status!='Done'";

				$query = db_query($sql);

				while ($data = mysqli_fetch_object($query)) {



				?> <tr>
					<td> <?= $i++; ?> </td>
					<td style="cursor:pointer" onclick="window.open('task_up.php?id=
						<?= $data->id ?>')"> <?= $data->task_name ?> </td>
					<td> <?= $data->task_start ?> </td>
					<td> <?= $data->task_end ?> </td>
					<td>
						<form method="post">
							<input type="hidden" value="
								<?= $data->id ?>" name="id" />
							<select name="status" width="50%">
								<option value="
										<?= $data->status ?>"> <?= $data->status ?> </option>
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
				</tr> <? } ?> </tbody>
		</table>
	</div>
</div> <?php */?> <style>
	.card {
		margin-bottom: 1.5rem;
		box-shadow: 0 .25rem .5rem rgba(0, 0, 0, .025)
	}

	.card-border-primary {
		border-top: 4px solid #2979ff
	}

	.card-border-secondary {
		border-top: 4px solid #efefef
	}

	.card-border-success {
		border-top: 4px solid #00c853
	}

	.card-border-info {
		border-top: 4px solid #3d5afe
	}

	.card-border-warning {
		border-top: 4px solid #ff9100
	}

	.card-border-danger {
		border-top: 4px solid #ff1744
	}

	.card-border-light {
		border-top: 4px solid #f8f9fa
	}

	.card-border-dark {
		border-top: 4px solid #6c757d
	}

	.card-header {
		border-bottom-width: 1px
	}

	.card-actions a {
		color: #495057;
		text-decoration: none
	}

	.card-actions svg {
		width: 16px;
		height: 16px
	}

	.card-actions .dropdown {
		line-height: 1.4
	}

	.card-title {
		font-weight: 500;
		margin-top: .1rem
	}

	.card-subtitle {
		font-weight: 400
	}

	.card-table {
		margin-bottom: 0
	}

	.card-table tr td:first-child,
	.card-table tr th:first-child {
		padding-left: 1.25rem
	}

	.card-table tr td:last-child,
	.card-table tr th:last-child {
		padding-right: 1.25rem
	}

	.card-img-top {
		height: 100%
	}

	.card {
		margin-bottom: 1.5rem;
		box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, .025);
	}

	.card {
		position: relative;
		display: -ms-flexbox;
		display: flex;
		-ms-flex-direction: column;
		flex-direction: column;
		min-width: 0;
		word-wrap: break-word;
		background-color: #fff;
		background-clip: border-box;
		border: 1px solid #e5e9f2;
		border-radius: .2rem;
	}

	.card-header:first-child {
		border-radius: calc(.2rem - 1px) calc(.2rem - 1px) 0 0;
	}

	.card-header {
		border-bottom-width: 1px;
	}

	.card-header {
		padding: .75rem 1.25rem;
		margin-bottom: 0;
		color: inherit;
		background-color: #fff;
		border-bottom: 1px solid #e5e9f2;
	}

	.scrollable {
		display: flex;
		flex-direction: row;
		flex-wrap: nowrap;
		overflow-x: scroll;
	}

	.date-picker-controls {
		width: 200px;
		display: flex;
		align-items: center;
	}

	.date-picker-arrow {
		background-color: transparent;
		border: none;
		font-size: 1.5em;
		cursor: pointer;
		margin: 0 10px;
		outline: none;
	}

	/* Define styles only for the custom date picker */
	/*.custom-date-picker label {
  font-size: 18px;
  
}*/
	.custom-date-picker input[type=date] {
		padding: 10px;
		border: 1px solid #ccc;
		border-radius: 5px;
		font-size: 16px;
	}

	.custom-date-picker input[type=submit] {
		padding: 10px 20px;
		background-color: #007bff;
		color: #fff;
		border: none;
		border-radius: 5px;
		font-size: 16px;
		cursor: pointer;
	}

	.custom-date-picker input[type=date]::-webkit-calendar-picker-indicator {
		background: transparent;
		color: transparent;
		cursor: pointer;
		position: relative;
		right: 5px;
	}

	.custom-date-picker input[type=date]::-webkit-calendar-picker-indicator:hover {
		background: #007bff;
		color: #fff;
	}

	.bn3637 {
		display: inline-flex;
		width: 100%;
		align-items: center;
		justify-content: center;
		padding: 0.7rem 2rem;
		font-weight: 700;
		font-size: 18px;
		text-align: center;
		text-decoration: none;
		color: black;
		backface-visibility: hidden;
		border: 0.3rem solid transparent;
		border-radius: 3rem;
	}

	.bn38 {
		border-color: transparent;
		transition: background-color 0.3s ease-in-out;
	}

	.bn38:hover {
		background-color: #60605e;
	}

	.todo-list {
		font-family: Arial, sans-serif;
	}

	.todo {
		display: flex;
		align-items: center;
		margin-bottom: 10px;
	}

	.todo__state {
		display: none;
	}

	.todo__icon {
		width: 30px;
		height: 30px;
		margin-right: 10px;
		cursor: pointer;
	}

	.todo__text {
		font-size: 16px;
	}

	.todo__line {
		fill: none;
		stroke-width: 2;
	}

	.todo__box {
		fill: none;
		stroke-width: 2;
	}

	.todo__check {
		fill: none;
		stroke-width: 3;
	}

	.todo__circle {
		fill: none;
		stroke-width: 2;
	}

	.todo {
		display: block;
		position: relative;
		padding: 1em 1em 1em 16%;
		margin: 0 auto;
		cursor: pointer;
		border-bottom: solid 1px #ddd;
	}

	.todo:last-child {
		border-bottom: none;
	}

	.todo__state {
		position: absolute;
		top: 0;
		left: 0;
		opacity: 0;
	}

	.todo__text {
		color: #135156;
		transition: all 0.4s linear 0.4s;
	}

	.todo__icon {
		position: absolute;
		top: 0;
		bottom: 0;
		left: 0;
		width: 100%;
		height: auto;
		margin: auto;
		fill: none;
		stroke: #27FDC7;
		stroke-width: 2;
		stroke-linejoin: round;
		stroke-linecap: round;
	}

	.todo__line,
	.todo__box,
	.todo__check {
		transition: stroke-dashoffset 0.8s cubic-bezier(0.9, 0, 0.5, 1);
	}

	.todo__circle {
		stroke: #27FDC7;
		stroke-dasharray: 1 6;
		stroke-width: 0;
		transform-origin: 13.5px 12.5px;
		transform: scale(0.4) rotate(0deg);
		-webkit-animation: none 0.8s linear;
		animation: none 0.8s linear;
	}

	@-webkit-keyframes explode {
		30% {
			stroke-width: 3;
			stroke-opacity: 1;
			transform: scale(0.8) rotate(40deg);
		}

		100% {
			stroke-width: 0;
			stroke-opacity: 0;
			transform: scale(1.1) rotate(60deg);
		}
	}

	@keyframes explode {
		30% {
			stroke-width: 3;
			stroke-opacity: 1;
			transform: scale(0.8) rotate(40deg);
		}

		100% {
			stroke-width: 0;
			stroke-opacity: 0;
			transform: scale(1.1) rotate(60deg);
		}
	}

	.todo__box {
		stroke-dasharray: 56.1053, 56.1053;
		stroke-dashoffset: 0;
		transition-delay: 0.16s;
	}

	.todo__check {
		stroke: #27FDC7;
		stroke-dasharray: 9.8995, 9.8995;
		stroke-dashoffset: 9.8995;
		transition-duration: 0.32s;
	}

	.todo__line {
		stroke-dasharray: 168, 1684;
		stroke-dashoffset: 168;
	}

	.todo__circle {
		-webkit-animation-delay: 0.56s;
		animation-delay: 0.56s;
		-webkit-animation-duration: 0.56s;
		animation-duration: 0.56s;
	}

	.todo__state:checked~.todo__text {
		transition-delay: 0s;
		color: #5EBEC1;
		opacity: 0.6;
		text-decoration: line-through;
	}

	.todo__state:checked~.todo__icon .todo__box {
		stroke-dashoffset: 56.1053;
		transition-delay: 0s;
	}

	.todo__state:checked~.todo__icon .todo__line {
		stroke-dashoffset: -8;
	}

	.todo__state:checked~.todo__icon .todo__check {
		stroke-dashoffset: 0;
		transition-delay: 0.48s;
	}

	.todo__state:checked~.todo__icon .todo__circle {
		-webkit-animation-name: explode;
		animation-name: explode;
	}

	.top-padding-red {
		padding-top: 20px;
		/* Adjust this value as needed */
		background-color: red;
	}

	.card~.card-yallow {
		background: linear-gradient(0deg, #FFC107, white, white, white, white, white, white, white, white, white, white) !important;
	}

	.card~.card-red {
		background: linear-gradient(0deg, #DC4C64, white, white, white, white, white, white, white, white, white, white) !important;
	}

	.card~.card-green {
		background: linear-gradient(0deg, #14A44D, white, white, white, white, white, white, white, white, white, white) !important;
	}
</style>
<div class="mycontainer p-0">
	<div class="title-container">
		<h1 class="h3 mb-3">Upcoming</h1>
		<div class="date-picker-controls">
			<form action="/action_page.php">
				<div class="date-picker-controls">
					<button type="button" class="date-picker-arrow" id="prev-week">&lt;</button>
					<!--<label for="birthday">Week of:</label>-->
					<input type="date" id="birthday" name="birthday" class="custom-date-picker">
					<button type="button" class="date-picker-arrow" id="next-week">&gt;</button>
				</div>
				<input type="submit" value="Submit">
			</form>
		</div>
	</div>
	<div class="row scrollable">
		<div class="col-12 col-lg-6 col-xl-3">
			<div class="card card-border-primary">
				<div class="card-header">
					<div class="card-actions float-right">
						<div class="dropdown show">
							<a href="#" data-toggle="dropdown" data-display="static">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle">
									<circle cx="12" cy="12" r="1"></circle>
									<circle cx="19" cy="12" r="1"></circle>
									<circle cx="5" cy="12" r="1"></circle>
								</svg>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#">Edit</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</div>
					</div>
					<h5 class="card-title">Today</h5>
					<h6 class="card-subtitle text-muted">Nam pretium turpis et arcu. Duis arcu tortor.</h6>
				</div>
				<div class="card-body p-3">
					<!--------- Start ----------->
					<div class="card mb-3 bg-light card-yallow">
						<div class="card-body p-3">
							<div class="card-actions float-right">
								<div class="dropdown show">
									<a href="#" data-toggle="dropdown" data-display="static">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle">
											<circle cx="12" cy="12" r="1"></circle>
											<circle cx="19" cy="12" r="1"></circle>
											<circle cx="5" cy="12" r="1"></circle>
										</svg>
									</a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="#">Edit</a>
										<a class="dropdown-item" href="#">Set priority</a>
									</div>
								</div>
							</div>
							<div class="float-left mr-n2"> <?php /*?> <label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" checked="">
									<span class="custom-control-label"></span>
								</label> <?php */?> </div>
							<div class="card-title"> Task Name 10 </div>
							<svg viewBox="0 0 0 0" style="position: absolute; z-index: -1; opacity: 0;">
								<defs>
									<linearGradient id="boxGradient" gradientUnits="userSpaceOnUse" x1="0" y1="0" x2="25" y2="25">
										<stop offset="0%" stop-color="#27FDC7" />
										<stop offset="100%" stop-color="#0FC0F5" />
									</linearGradient>
									<linearGradient id="lineGradient">
										<stop offset="0%" stop-color="#0FC0F5" />
										<stop offset="100%" stop-color="#27FDC7" />
									</linearGradient>
									<path id="todo__line" stroke="url(#lineGradient)" d="M21 12.3h168v0.1z"></path>
									<path id="todo__box" stroke="url(#boxGradient)" d="M21 12.7v5c0 1.3-1 2.3-2.3 2.3H8.3C7 20 6 19 6 17.7V7.3C6 6 7 5 8.3 5h10.4C20 5 21 6 21 7.3v5.4"></path>
									<path id="todo__check" stroke="url(#boxGradient)" d="M10 13l2 2 5-5"></path>
									<circle id="todo__circle" cx="13.5" cy="12.5" r="10"></circle>
								</defs>
							</svg>
							<div class="todo-list">
								<label class="todo">
									<input class="todo__state" type="checkbox" />
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 200 25" class="todo__icon">
										<use xlink:href="#todo__line" class="todo__line"></use>
										<use xlink:href="#todo__box" class="todo__box"></use>
										<use xlink:href="#todo__check" class="todo__check"></use>
										<use xlink:href="#todo__circle" class="todo__circle"></use>
									</svg>
									<div class="todo__text">Do a very important task</div>
								</label>
							</div>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar6.png" width="32" height="32" class="rounded-circle" alt="Avatar">
								<img src="https://bootdey.com/img/Content/avatar/avatar6.png" width="32" height="32" class="rounded-circle" alt="Avatar">
								<img src="https://bootdey.com/img/Content/avatar/avatar6.png" width="32" height="32" class="rounded-circle" alt="Avatar">
								<img src="https://bootdey.com/img/Content/avatar/avatar6.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<!---------End ----------->
					<div class="card mb-3 bg-light card-yallow">
						<div class="card-body p-3">
							<div class="card-actions float-right">
								<div class="dropdown show">
									<a href="#" data-toggle="dropdown" data-display="static">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle">
											<circle cx="12" cy="12" r="1"></circle>
											<circle cx="19" cy="12" r="1"></circle>
											<circle cx="5" cy="12" r="1"></circle>
										</svg>
									</a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="#">Action</a>
										<a class="dropdown-item" href="#">Another action</a>
										<a class="dropdown-item" href="#">Something else here</a>
									</div>
								</div>
							</div>
							<div class="float-left mr-n2"> <?php /*?> <label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" checked="">
									<span class="custom-control-label"></span>
								</label> <?php */?> </div>
							<div class="card-title"> Task Name </div>
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" checked="">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<svg viewBox="0 0 0 0" style="position: absolute; z-index: -1; opacity: 0;">
								<defs>
									<linearGradient id="boxGradient" gradientUnits="userSpaceOnUse" x1="0" y1="0" x2="25" y2="25">
										<stop offset="0%" stop-color="#27FDC7" />
										<stop offset="100%" stop-color="#0FC0F5" />
									</linearGradient>
									<linearGradient id="lineGradient">
										<stop offset="0%" stop-color="#0FC0F5" />
										<stop offset="100%" stop-color="#27FDC7" />
									</linearGradient>
									<path id="todo__line" stroke="url(#lineGradient)" d="M21 12.3h168v0.1z"></path>
									<path id="todo__box" stroke="url(#boxGradient)" d="M21 12.7v5c0 1.3-1 2.3-2.3 2.3H8.3C7 20 6 19 6 17.7V7.3C6 6 7 5 8.3 5h10.4C20 5 21 6 21 7.3v5.4"></path>
									<path id="todo__check" stroke="url(#boxGradient)" d="M10 13l2 2 5-5"></path>
									<circle id="todo__circle" cx="13.5" cy="12.5" r="10"></circle>
								</defs>
							</svg>
							<div class="todo-list">
								<label class="todo">
									<input class="todo__state" type="checkbox" />
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 200 25" class="todo__icon">
										<use xlink:href="#todo__line" class="todo__line"></use>
										<use xlink:href="#todo__box" class="todo__box"></use>
										<use xlink:href="#todo__check" class="todo__check"></use>
										<use xlink:href="#todo__circle" class="todo__circle"></use>
									</svg>
									<div class="todo__text">Do a very important task</div>
								</label>
							</div>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar1.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<div class="card mb-3 bg-light card-red">
						<div class="card-body p-3">
							<div class="float-right mr-n2"></div>
							<svg viewBox="0 0 0 0" style="position: absolute; z-index: -1; opacity: 0;">
								<defs>
									<linearGradient id="boxGradient" gradientUnits="userSpaceOnUse" x1="0" y1="0" x2="25" y2="25">
										<stop offset="0%" stop-color="#27FDC7" />
										<stop offset="100%" stop-color="#0FC0F5" />
									</linearGradient>
									<linearGradient id="lineGradient">
										<stop offset="0%" stop-color="#0FC0F5" />
										<stop offset="100%" stop-color="#27FDC7" />
									</linearGradient>
									<path id="todo__line" stroke="url(#lineGradient)" d="M21 12.3h168v0.1z"></path>
									<path id="todo__box" stroke="url(#boxGradient)" d="M21 12.7v5c0 1.3-1 2.3-2.3 2.3H8.3C7 20 6 19 6 17.7V7.3C6 6 7 5 8.3 5h10.4C20 5 21 6 21 7.3v5.4"></path>
									<path id="todo__check" stroke="url(#boxGradient)" d="M10 13l2 2 5-5"></path>
									<circle id="todo__circle" cx="13.5" cy="12.5" r="10"></circle>
								</defs>
							</svg>
							<div class="todo-list">
								<label class="todo">
									<input class="todo__state" type="checkbox" />
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 200 25" class="todo__icon">
										<use xlink:href="#todo__line" class="todo__line"></use>
										<use xlink:href="#todo__box" class="todo__box"></use>
										<use xlink:href="#todo__check" class="todo__check"></use>
										<use xlink:href="#todo__circle" class="todo__circle"></use>
									</svg>
									<div class="todo__text">Do a very important task </div>
								</label>
							</div>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar2.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<div class="card mb-3 bg-light">
						<div class="card-body p-3">
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<p>In hac habitasse platea dictumst. Curabitur at lacus ac velit ornare lobortis. Curabitur a felis tristique.</p>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar3.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<div class="card mb-3 bg-light ">
						<div class="card-body p-3">
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<p>Nam pretium turpis et arcu. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum.</p>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar4.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<div>
						<a href="/" class="bn3637 bn38"> + Add new </a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-6 col-xl-3">
			<div class="card card-border-warning">
				<div class="card-header">
					<div class="card-actions float-right">
						<div class="dropdown show">
							<a href="#" data-toggle="dropdown" data-display="static">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle">
									<circle cx="12" cy="12" r="1"></circle>
									<circle cx="19" cy="12" r="1"></circle>
									<circle cx="5" cy="12" r="1"></circle>
								</svg>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</div>
					</div>
					<h5 class="card-title">Tommorow</h5>
					<h6 class="card-subtitle text-muted">Nam pretium turpis et arcu. Duis arcu tortor.</h6>
				</div>
				<div class="card-body">
					<div class="card mb-3 bg-light">
						<div class="card-body p-3">
							<div class="card-actions float-right">
								<div class="dropdown show">
									<a href="#" data-toggle="dropdown" data-display="static">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle">
											<circle cx="12" cy="12" r="1"></circle>
											<circle cx="19" cy="12" r="1"></circle>
											<circle cx="5" cy="12" r="1"></circle>
										</svg>
									</a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="#">Action</a>
										<a class="dropdown-item" href="#">Another action</a>
										<a class="dropdown-item" href="#">Something else here</a>
									</div>
								</div>
							</div>
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<p>Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo. Maecenas malesuada.</p>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar6.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<div class="card mb-3 bg-light">
						<div class="card-body p-3">
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<p>Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis.</p>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar7.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<div class="card mb-3 bg-light">
						<div class="card-body p-3">
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<p>Nam pretium turpis et arcu. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum.</p>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar8.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<div class="card mb-3 bg-light">
						<div class="card-body p-3">
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<p>In hac habitasse platea dictumst. Curabitur at lacus ac velit ornare lobortis. Curabitur a felis tristique.</p>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar1.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<a href="#" class="btn btn-primary btn-block">Add new</a>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-6 col-xl-3">
			<div class="card card-border-danger">
				<div class="card-header">
					<div class="card-actions float-right">
						<div class="dropdown show">
							<a href="#" data-toggle="dropdown" data-display="static">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle">
									<circle cx="12" cy="12" r="1"></circle>
									<circle cx="19" cy="12" r="1"></circle>
									<circle cx="5" cy="12" r="1"></circle>
								</svg>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</div>
					</div>
					<h5 class="card-title">On hold</h5>
					<h6 class="card-subtitle text-muted">Nam pretium turpis et arcu. Duis arcu tortor.</h6>
				</div>
				<div class="card-body">
					<div class="card mb-3 bg-light">
						<div class="card-body p-3">
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<p>In hac habitasse platea dictumst. Curabitur at lacus ac velit ornare lobortis. Curabitur a felis tristique.</p>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar2.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<div class="card mb-3 bg-light">
						<div class="card-body p-3">
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<p>Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis.</p>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar3.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<div class="card mb-3 bg-light">
						<div class="card-body p-3">
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<p>Nam pretium turpis et arcu. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum.</p>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar4.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<a href="#" class="btn btn-primary btn-block">Add new</a>
				</div>
			</div>
		</div>

		<div class="col-12 col-lg-6 col-xl-3">
			<div class="card card-border-success">
				<div class="card-header">
					<div class="card-actions float-right">
						<div class="dropdown show">
							<a href="#" data-toggle="dropdown" data-display="static">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle">
									<circle cx="12" cy="12" r="1"></circle>
									<circle cx="19" cy="12" r="1"></circle>
									<circle cx="5" cy="12" r="1"></circle>
								</svg>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</div>
					</div>
					<h5 class="card-title">Completed</h5>
					<h6 class="card-subtitle text-muted">Nam pretium turpis et arcu. Duis arcu tortor.</h6>
				</div>
				<div class="card-body">
					<div class="card mb-3 bg-light">
						<div class="card-body p-3">
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<p>Nam pretium turpis et arcu. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum.</p>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar6.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<div class="card mb-3 bg-light">
						<div class="card-body p-3">
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<p>In hac habitasse platea dictumst. Curabitur at lacus ac velit ornare lobortis. Curabitur a felis tristique.</p>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar7.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<div class="card mb-3 bg-light">
						<div class="card-body p-3">
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<p>Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis.</p>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar8.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<div class="card mb-3 bg-light">
						<div class="card-body p-3">
							<div class="float-right mr-n2">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input">
									<span class="custom-control-label"></span>
								</label>
							</div>
							<p>Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo. Maecenas malesuada.</p>
							<div class="float-right mt-n1">
								<img src="https://bootdey.com/img/Content/avatar/avatar1.png" width="32" height="32" class="rounded-circle" alt="Avatar">
							</div>
							<a class="btn btn-outline-primary btn-sm" href="#">View</a>
						</div>
					</div>
					<a href="#" class="btn btn-primary btn-block">Add new</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script></script>
<script type="text/javascript">
	function Do_Nav() {
		var URL = 'pop_ledger_selecting_list.php';
		popUp(URL);
	}

	function DoNav(theUrl) {
		document.location.href = 'add_project.php?project_id=' + theUrl;
	}

	function popUp(URL) {
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
	}
</script>
<script type="text/javascript">
	document.onkeypress = function(e) {
		var e = window.event || e
		var keyunicode = e.charCode || e.keyCode
		if (keyunicode == 13) {
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