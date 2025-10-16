<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = 'Lead Activity Entry';
$pbi_id  =  $_SESSION['employee_selected'];
$user_role  =  $_SESSION['user']['fname'];



if (isset($_POST['scCall'])) {

	$crud   = new crud('crm_lead_activity');
	$_POST['entry_by'] = $_SESSION['user']['id'];
	$_POST['entry_at'] = date("Y-m-d H:i:s");
	$crud->insert();

	

	echo "<script>window.top.location='lead_task.php'</script>";
}
?>

<script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>

<style>
	.sr-main-content-padding {
		background: #e7e7e7;
	}

	.crm-top-sa {
		width: 100%;
		background-color: #FFFFFF;
		padding: 5px;
		border-radius: 10px;
	}

	.crm-top-sa .left {
		float: left;
		width: 60%;
	}

	.crm-top-sa .right {
		float: right;
		width: 40%;
	}

	.modal-title {
		font-size: 16px !important;
		font-weight: bold;

	}

	ol,
	ul,
	li {
		margin: 0px;
		padding: 0px;
	}


	.toggle {
		all: unset;
		background-color: dodgerblue;
		color: white;
		padding: 10px;
		font-weight: 700;
		display: flex;
		justify-content: space-between;
		align-items: center;
		border-radius: 5px;
		cursor: pointer;
		height: 10px;
	}

	.list1 {
		color: #444;
		list-style: none;
		display: grid;
		padding: 0px;
		grid-template-rows: repeat(4, 40px);
		border-radius: 5px;
		overflow: hidden;
		height: 0;
		transition: 0.4s;
	}

	.list-item1 {
		align-items: center;

		transition: 0.4s, transform 0.4s var(--delay);
		transform: translateX(-100%);
		user-select: none;
		cursor: pointer;
	}

	.list-item11:hover {
		background-color: dodgerblue;
		color: #fff;
	}

	.toggle:focus::after {
		transform: rotate(225deg);
	}

	.toggle:focus~.list1 {
		height: 80px;
	}

	.toggle:focus~.list1 .list-item1 {
		transform: translateX(0);
	}

	.bgc {
		background-color: #ffffff;
		border-radius: 15px;
		min-height: 150px;
	}

	tr:nth-child(odd) {
		background-color: #ffffff !important;
		color: var(--child-text-color) !important;
	}

	tr:nth-child(even) {
		background-color: #ffffff !important;
		color: var(--child-text-color) !important;
	}
</style>



<div class="container-fluid">
<?echo $user_role;?>
	<div class="row">
		<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-3">
			<div class="container pt-2 bgc">
				<div class="row p-2 m-0">
					<div class="crm-top-sa col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="left">
							<p class="bold m-0 p-0" style=" font-size: 16px !important;"> OPEN CALLS <span class="badge badge-warning">0</span></p>
						</div>


						<div class="right" align="left">
							<!--dropdown start-->
							<button class="btn toggle"><i class="fa-solid fa-plus"></i></button>
							<div class="list1">
								<div class="list-item1" style="--delay:0.2s">
									<!-- Button trigger modal start-->
									<button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#exampleModal">
										Schedule a call
									</button>
									<!-- Button trigger modal end-->
								</div>
								<div class="list-item1" style="--delay:0.4s">
									<!-- Button trigger modal start-->
									<button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#exampleModal1">
										Log a call
									</button>
									<!-- Button trigger modal end-->
								</div>
							</div>
							<!--dropdown end-->
						</div>






						<!--Schedule a call Modal Start-->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Schedule a call</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<i class="fa-solid fa-xmark"></i>
										</button>
									</div>


									<form method="post">
										<div class="modal-body">

											<input type="hidden" name="call_main" value="Schedule" />
											<input type="hidden" name="activity_type" value="Call" />
											<input type="hidden" name="main" value="1" />

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Select call Lead:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<select class="form-control req" name="lead_id" id="lead_id">
														<? 
														if($user_role=="Admin"){
															foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');
														}else{
														foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id and l.assign_person="'.$pbi_id.'"'); 
														}?>
													</select>
												</div>
											</div>


											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call to:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

													<input class="form-control req" name="call_to" id="call_to">
												</div>
											</div>


											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call type:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<select class="form-control req" name="call_type" required>
														<option></option>
														<option value="Inbound Call">Inbound Call</option>
														<option value="Outbound Call">Outbound Call</option>
													</select>
												</div>
											</div>

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Date:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="date" name="date" id="date" value="" class="form-control req" />
												</div>
											</div>

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Time:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="time" name="time" id="time" value="" class="form-control req" />
												</div>
											</div>


											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Purpose:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="text" name="subject" id="subject" value="" class="form-control req" />
												</div>
											</div>

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Note:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<textarea class="form-control req1" name="details"></textarea>
												</div>
											</div>




										</div>
										<div class="modal-footer">
											<button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
											<button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!--Schedule a call Modal End-->



						<!--Log a call Modal 1st Start-->
						<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">

									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel1">Log a call</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<i class="fa-solid fa-xmark"></i>
										</button>
									</div>


									<form method="post">
										<div class="modal-body">

											<input type="hidden" name="call_main" value="Log" />
											<input type="hidden" name="activity_type" value="Call" />

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Select Log Lead:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<select class="form-control req" name="lead_id" id="lead_id">
													<? 
														if($user_role=="Admin"){
															foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');
														}else{
														foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id and l.assign_person="'.$pbi_id.'"'); 
														}?>
													</select>
												</div>
											</div>



											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call to:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

													<input class="form-control req" name="call_to" id="call_to">
												</div>
											</div>



											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call type:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<select class="form-control req" name="call_type" required>
														<option></option>
														<option value="Inbounde Call">Inbounde Call</option>
														<option value="Outbound Call">Outbound Call</option>
													</select>
												</div>
											</div>

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Date:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="date" name="date" id="date" value="" class="form-control req" />
												</div>
											</div>

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Time:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="time" name="time" id="time" value="" class="form-control req" />
												</div>
											</div>


											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Duration:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="text" name="call_duration" id="call_duration" value="" class="form-control req" />
												</div>
											</div>


											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Purpose:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="text" name="subject" id="subject" value="" class="form-control req" />
												</div>
											</div>

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Note:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<textarea class="form-control req1" name="details"></textarea>
												</div>
											</div>




										</div>
										<div class="modal-footer">
											<button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
											<button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button>
										</div>
									</form>

								</div>
							</div>
						</div>
						<!--Log a call Modal End-->

					</div>

				</div>

		<?php

				 														
				if($user_role=="Admin"){
					$psql = 'select * from crm_lead_activity where main="1" ORDER BY id DESC';

				}else{
					$psql = 'SELECT * 
					FROM crm_lead_activity 
					JOIN crm_project_lead ON crm_lead_activity.lead_id = crm_project_lead.id 
					WHERE crm_lead_activity.main = "1" 
					  AND crm_project_lead.assign_person = "'.$pbi_id.'"
					ORDER BY crm_lead_activity.id DESC';
				}

	   
				echo $pquery = db_query($psql);
				$i = 1;

				echo $exc = find_a_field('crm_lead_activity', 'id', 'main="1"');
				if ($exc == '') {
					echo "<span class='text-danger'>Data Not Found</span>";
				}

				while ($pdata = mysqli_fetch_object($pquery)) {
				?>

					<div class="container-fluid pb-3 pt-3" style="cursor:pointer" onclick="window.location='schedule_call_up.php?id=<?= $pdata->id ?>';">
						<!--table titel start-->
						<h4 class="bold m-0"> Call scheduled with <?= $pdata->call_to ?>. <?= find_a_field('crm_project_org o,crm_project_lead l,crm_lead_log a,crm_lead_products p', 'concat(o.name,"(",p.products,")")', 'l.organization=o.id and l.product=p.id and l.id="' . $pdata->lead_id . '"') ?> </h4>
						<!--table titel end-->

						<table>
							<tr>
								<td style=" width: 22%; ">Call type</td>
								<td>: <?= $pdata->call_type ?></td>
							</tr>

							<tr>
								<td style=" width: 22%; "> Call time</td>
								<td>: <?= $pdata->date ?> <?= date("h:i A", strtotime($pdata->time)) ?></td>
							</tr>

							<tr>
								<td style=" width: 22%; ">Call Purpose</td>
								<td>: <?= $pdata->subject ?></td>
							</tr>

							<tr>
								<td style=" width: 22%; vertical-align: top; ">Note</td>
								<td>: <?= $pdata->details ?></td>
							</tr>

						</table>
					</div>

				<? } ?>

			</div>

		</div>



		<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-3">
			<div class="container pt-2 bgc">
				<div class="row p-2 m-0">
					<div class="crm-top-sa col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="left">
							<p class="bold m-0 p-0" style=" font-size: 16px !important;"> Visit <span class="badge badge-warning">0</span></p>
						</div>

						<div class="right" align="left">

							<!-- Button trigger modal start-->
							<button type="button" class="btn toggle" data-toggle="modal">
								<i class="fa-solid fa-plus"></i>
							</button>
						<div class="list1">
								<div class="list-item1" style="--delay:0.2s">
									<!-- Button trigger modal start-->
									<button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#exampleModal3">
										Schedule a Visit
									</button>
									<!-- Button trigger modal end-->
								</div>
								<div class="list-item1" style="--delay:0.4s">
									<!-- Button trigger modal start-->
									<button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#exampleModal1">
										Log a Visit
									</button>
									<!-- Button trigger modal end-->
								</div>
							</div>
							<!-- Button trigger modal end-->

						</div>



						<!--Visit Modal 1st Start-->
						<div class="modal fade " id="exampleModa3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content w-100">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Visit </h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<i class="fa-solid fa-xmark"></i>
										</button>
									</div>
									<form method="post">
										<div class="modal-body">

											<input type="hidden" name="activity_type" value="Visit" />
											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Select Lead:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

													<select class="form-control req" name="lead_id">
													<? 
														if($user_role=="Admin"){
															foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');
														}else{
														foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id and l.assign_person="'.$pbi_id.'"'); 
														}?>
													</select>
												</div>
											</div>



											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Location:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

													<input type="text" name="location" id="location" value="" class="form-control req" />
												</div>
											</div>



											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Purpose:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="text" name="subject" id="subject" value="" class="form-control req" />
												</div>
											</div>

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Date:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="date" name="date" id="date" value="" class="form-control req" />
												</div>
											</div>
											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Time:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="time" name="time" id="time" value="" class="form-control req" />
												</div>
											</div>


											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Note:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<textarea class="form-control req1" name="details"></textarea>
												</div>
											</div>




										</div>

										<div class="modal-footer">
											<button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
											<button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!--Visit  Modal 1st End-->



					</div>

				</div>
				<?php
				if($user_role=="Admin"){
					$vsql = 'select * from crm_lead_activity where activity_type="Visit" order by id DESC limit 2';
				}else{
					$vsql = 'SELECT * 
				FROM crm_lead_activity 
				JOIN crm_project_lead ON crm_lead_activity.lead_id = crm_project_lead.id 
				WHERE crm_lead_activity.activity_type = "Visit" 
				  AND crm_project_lead.assign_person = "'.$pbi_id.'"
				ORDER BY crm_lead_activity.id DESC';
					// $vsql = 'select * from crm_lead_activity where activity_type="Visit" order by id DESC limit 2';
				}
				
				$vquery = db_query($vsql);
				$i = 1;

				$exv = find_a_field('crm_lead_activity', 'id', 'activity_type="Visit"');
				if ($exv == '') {
					echo "<span class='text-danger'>Data Not Found</span>";
				}

				while ($vdata = mysqli_fetch_object($vquery)) {
				?>

					<div class="container-fluid pb-3 pt-3">
						<!--table titel start-->
						<h4 class="bold m-0"> Visit: <?= find_a_field('crm_project_org o,crm_project_lead l,crm_lead_log a,crm_lead_products p', 'concat(o.name,"(",p.products,")")', 'l.organization=o.id and l.product=p.id and l.id="' . $vdata->lead_id . '"') ?> </h4>
						<!--table titel end-->

						<table>
							<tr>
								<td style=" width: 22%; ">Visit Location</td>
								<td>: <?= $vdata->location ?></td>
							</tr>

							<tr>
								<td style=" width: 22%; "> Visit Purpose</td>
								<td>: <?= $vdata->subject ?></td>
							</tr>

							<tr>
								<td style=" width: 22%; "> Visit time</td>
								<td>: <?= $vdata->date ?> <?= date("h:i A", strtotime($vdata->time)) ?></td>
							</tr>

							<tr>
								<td style=" width: 22%; vertical-align: top; ">Note</td>
								<td>: <?= $vdata->details ?></td>
							</tr>

						</table>
					</div>
				<? } ?>
			</div>

		</div>



		<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-3">
			<div class="container pt-2 bgc">
				<div class="row p-2 m-0">
					<div class="crm-top-sa col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="left">
							<p class="bold m-0 p-0" style=" font-size: 16px !important;"> Meeting <span class="badge badge-warning">0</span></p>
						</div>

						<div class="right" align="left">

							<!-- Button trigger modal start-->
							<button type="button" class="btn toggle" >
								<i class="fa-solid fa-plus"></i>
							</button>

							<div class="list1">
								<div class="list-item1" style="--delay:0.2s">
									<!-- Button trigger modal start-->
									<button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#exampleModa4">
										Schedule a Meeting
									</button>
									<!-- Button trigger modal end-->
								</div>
								<div class="list-item1" style="--delay:0.4s">
									<!-- Button trigger modal start-->
									<button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#exampleModal1">
										Log a meeting
									</button>
									<!-- Button trigger modal end-->
								</div>
							</div>
							<!-- Button trigger modal end-->

						</div>



						<!--Meeting Modal 1st Start-->
						<div class="modal fade " id="exampleModa4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content w-100">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Meeting Add </h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<i class="fa-solid fa-xmark"></i>
										</button>
									</div>

									<form method="post">
										<div class="modal-body">


											<input type="hidden" name="activity_type" value="Meeting" />
											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Select Lead:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

													<select class="form-control req" name="lead_id">
													<? 
														if($user_role=="Admin"){
															foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');
														}else{
														foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id and l.assign_person="'.$pbi_id.'"'); 
														}?>
													</select>
												</div>
											</div>




											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Meeting Type:</label>

												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<select class="form-control req" name="meeting_type">
														<option value="Online">Online </option>
														<option value="Offline">Offline</option>
													</select>
												</div>
											</div>



											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Meeting Subject:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="text" name="subject" id="subject" value="" class="form-control req" />
												</div>
											</div>

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Location:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="text" name="location" id="location" value="" class="form-control req" />
												</div>
											</div>

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Date:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="date" name="date" id="date" value="" class="form-control req" />
												</div>
											</div>
											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Visit Time:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="time" name="time" id="time" value="" class="form-control req" />
												</div>
											</div>


											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Note:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<textarea class="form-control req1" name="details"></textarea>
												</div>
											</div>




										</div>

										<div class="modal-footer">
											<button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
											<button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!--Meeting  Modal 1st End-->



					</div>

				</div>
				<?php

				if($user_role=="Admin"){
					$msql = 'select * from crm_lead_activity where activity_type="Meeting" order by id DESC';
					
				}else{
					$msql = 'SELECT * 
					FROM crm_lead_activity 
					JOIN crm_project_lead ON crm_lead_activity.lead_id = crm_project_lead.id 
					WHERE crm_lead_activity.activity_type = "Meeting" 
					  AND crm_project_lead.assign_person = "'.$pbi_id.'"
					ORDER BY crm_lead_activity.id DESC';
				}
			
				$mquery = db_query($msql);
				$i = 1;

				$mxv = find_a_field('crm_lead_activity', 'id', 'activity_type="Meeting"');
				if ($mxv == '') {
					echo "<span class='text-danger'>Data Not Found</span>";
				}

				while ($mdata = mysqli_fetch_object($mquery)) {
				?>

					<div class="container-fluid pb-3 pt-3">
						<!--table titel start-->
						<h4 class="bold m-0"> Meeting with <?= find_a_field('crm_project_org o,crm_project_lead l,crm_lead_log a,crm_lead_products p', 'concat(o.name,"(",p.products,")")', 'l.organization=o.id and l.product=p.id and l.id="' . $mdata->lead_id . '"') ?></h4>
						<!--table titel end-->


						<table>
							<tr>
								<td style=" width: 22%; ">Meeting Type</td>
								<td>: <?= $mdata->meeting_type ?></td>
							</tr>

							<tr>
								<td style=" width: 22%; "> Meeting Subject</td>
								<td>: <?= $mdata->subject ?></td>
							</tr>

							<tr>
								<td style=" width: 22%; ">Location</td>
								<td>: <?= $mdata->location ?></td>
							</tr>

							<tr>
								<td>Date & Time</td>
								<td>: <?= $mdata->date ?> <?= date("h:i A", strtotime($mdata->time)) ?></td>
							</tr>

							<tr>
								<td style=" width: 22%; vertical-align: top; ">Note</td>
								<td>: <?= $mdata->details ?></td>
							</tr>

						</table>
					</div>

				<? } ?>
			</div>

		</div>


		<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-3">
			<div class="container pt-2 bgc">
				<div class="row p-2 m-0">
					<div class="crm-top-sa col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="left">
							<p class="bold m-0 p-0" style=" font-size: 16px !important;"> Email <span class="badge badge-warning">0</span></p>
						</div>

						<div class="right" align="left">

							<!-- Button trigger modal start-->
							<button type="button" class="btn toggle">
								<i class="fa-solid fa-plus"></i>
							</button>
							<div class="list1">
								<div class="list-item1" style="--delay:0.2s">
									<!-- Button trigger modal start-->
									<button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#exampleModa5">
										Schedule a Email
									</button>
									<!-- Button trigger modal end-->
								</div>
								<div class="list-item1" style="--delay:0.4s">
									<!-- Button trigger modal start-->
									<button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#exampleModa5">
										Log a Email
									</button>
									<!-- Button trigger modal end-->
								</div>
							</div>
							<!-- Button trigger modal end-->

						</div>



						<!--Email Modal 1st Start-->
						<div class="modal fade " id="exampleModa5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content w-100">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Email Add </h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<i class="fa-solid fa-xmark"></i>
										</button>
									</div>
									<form method="post">
										<div class="modal-body">


											<input type="hidden" name="activity_type" value="Email" />
											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Select Lead:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

													<select class="form-control req" name="lead_id">
													<? 
														if($user_role=="Admin"){
															foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');
														}else{
														foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id and l.assign_person="'.$pbi_id.'"'); 
														}?>
													</select>
												</div>
											</div>

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Date:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="date" name="date" id="date" value="" class="form-control req" />
												</div>
											</div>
											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Time:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="time" name="time" id="time" value="" class="form-control req" />
												</div>
											</div>

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Email to:</label>

												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="text" name="call_to" id="call_to" value="" class="form-control req" />
												</div>
											</div>



											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Email Subject:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="text" name="subject" id="subject" value="" class="form-control req" />
												</div>
											</div>

											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Email Body:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="text" name="details" id="details" value="" class="form-control req" />
												</div>
											</div>

											<?php /*?>								<div class="form-group row m-0 pt-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Attachment:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<input type="file" name="" id="" value="" class="form-control req" style="padding:3px;" />
									</div>
								</div>
<?php */ ?>


										</div>


										<div class="modal-footer">
											<button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
											<button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button>
										</div>

									</form>
								</div>
							</div>
						</div>
						<!--Email  Modal 1st End-->



					</div>

				</div>
				<?php
				if($user_role=="Admin"){
					$esql = 'select * from crm_lead_activity where activity_type="Email" order by id DESC';
					
				}else{
					$esql = 'SELECT * 
					FROM crm_lead_activity 
					JOIN crm_project_lead ON crm_lead_activity.lead_id = crm_project_lead.id 
					WHERE crm_lead_activity.activity_type = "Email" 
					  AND crm_project_lead.assign_person = "'.$pbi_id.'"
					ORDER BY crm_lead_activity.id DESC';
				}
			
				$equery = db_query($esql);
				$i = 1;

				$exv = find_a_field('crm_lead_activity', 'id', 'activity_type="Email"');
				if ($exv == '') {
					echo "<span class='text-danger'>Data Not Found</span>";
				}

				while ($edata = mysqli_fetch_object($equery)) {
				?>

					<div class="container-fluid pb-3 pt-3">
						<!--table titel start-->
						<h4 class="bold m-0"> Email for <?= find_a_field('crm_project_org o,crm_project_lead l,crm_lead_log a,crm_lead_products p', 'concat(o.name,"(",p.products,")")', 'l.organization=o.id and l.product=p.id and l.id="' . $edata->lead_id . '"') ?></h4>
						<!--table titel end-->
						<table>
							<tr>
								<td style=" width: 22%; ">Date & Time</td>
								<td>: <?= $edata->date ?> <?= date("h:i A", strtotime($edata->time)) ?></td>
							</tr>
							<tr>
								<td style=" width: 22%; ">Email to</td>
								<td>: <?= $edata->call_to ?></td>
							</tr>

							<tr>
								<td style=" width: 22%; "> Email Subject</td>
								<td>: <?= $edata->subject ?></td>
							</tr>

							<tr>
								<td style=" width: 22%; ">Email Body</td>
								<td>: <?= $edata->details ?></td>
							</tr>

							<?php /*?>	<tr>
								<td>Attachment</td> <td>: Test</td>
							</tr><?php */ ?>

						</table>
					</div>

				<? } ?>
			</div>

		</div>






		<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-3">
			<div class="container pt-2 bgc">
				<div class="row p-2 m-0">
					<div class="crm-top-sa col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="left">
							<p class="bold m-0 p-0" style=" font-size: 16px !important;"> Other Activities <span class="badge badge-warning">0</span></p>
						</div>

						<div class="right" align="left">

							<!-- Button trigger modal start-->
							<button type="button" class="btn toggle">
								<i class="fa-solid fa-plus"></i>
							</button>

							<div class="list1">
								<div class="list-item1" style="--delay:0.2s">
									<!-- Button trigger modal start-->
									<button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#exampleModa6">
										Schedule  Other Activity
									</button>
									<!-- Button trigger modal end-->
								</div>
								<div class="list-item1" style="--delay:0.4s">
									<!-- Button trigger modal start-->
									<button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#exampleModa6">
										Log other Activity
									</button>
									<!-- Button trigger modal end-->
								</div>
							</div>
							<!-- Button trigger modal end-->

						</div>



						<!--Other Activities Modal 1st Start-->
						<div class="modal fade " id="exampleModa6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content w-100">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Other Activities </h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<i class="fa-solid fa-xmark"></i>
										</button>
									</div>
									<form method="post">
										<div class="modal-body">



											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Select Lead:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

													<select class="form-control req" name="lead_id">
													<? 
														if($user_role=="Admin"){
															foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id');
														}else{
														foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p', 'l.id', 'concat(o.id,"-",o.name,"##(",p.products,")")', $organization, 'l.organization=o.id and l.product=p.id and l.assign_person="'.$pbi_id.'"'); 
														}?>
													</select>
												</div>
											</div>



											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">List of other activities:</label>

												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<select class="form-control req" name="activity_type">
														<? foreign_relation('crm_lead_activity_type', 'activity_name', 'activity_name', $activity_type, '1'); ?>
													</select>
												</div>
											</div>




											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Date:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="date" name="date" id="date" value="" class="form-control req" />
												</div>
											</div>
											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Time:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<input type="time" name="time" id="time" value="" class="form-control req" />
												</div>
											</div>



											<div class="form-group row m-0 pt-1">
												<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Note:</label>
												<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
													<textarea class="form-control req1" name="details"></textarea>
												</div>
											</div>




										</div>

										<div class="modal-footer">
											<button type="button" class="btn1 btn1-bg-cancel" data-dismiss="modal">Cancel</button>
											<button type="submit" name="scCall" class="btn1 btn1-bg-submit">Save </button>
										</div>

									</form>
								</div>
							</div>
						</div>
						<!--Other Activities  Modal 1st End-->



					</div>

				</div>
				<?php
				$osql = 'select * from crm_lead_activity where activity_type NOT in("Call","Visit","Meeting","Email") order by id DESC limit 2';
				$oquery = db_query($osql);
				$i = 1;

				$oxv = find_a_field('crm_lead_activity', 'id', 'activity_type NOT in("Call","Visit","Meeting","Email")');
				if ($oxv == '') {
					echo "<span class='text-danger'>Data Not Found</span>";
				}

				while ($odata = mysqli_fetch_object($oquery)) {
				?>

					<div class="container-fluid pb-3 pt-3">
						<!--table titel start-->
						<h4 class="bold m-0"> Activities Of <?= find_a_field('crm_project_org o,crm_project_lead l,crm_lead_log a,crm_lead_products p', 'concat(o.name,"(",p.products,")")', 'l.organization=o.id and l.product=p.id and l.id="' . $odata->lead_id . '"') ?> </h4>
						<!--table titel end-->

						<table>
							<tr>
								<td style=" width: 22%; ">Activities List</td>
								<td>: <?= $odata->activity_type ?></td>
							</tr>

							<tr>
								<td style=" width: 22%; ">Date & Time</td>
								<td>: <?= $edata->date ?> <?= date("h:i A", strtotime($edata->time)) ?></td>
							</tr>

							<tr>
								<td style=" width: 22%; vertical-align: top; ">Note</td>
								<td>: <?= $odata->details ?></td>
							</tr>

						</table>
					</div>

				<? } ?>
			</div>

		</div>












	</div>

</div>

<script>
	function cvsss() {
		alert('hi');

	}
</script>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>