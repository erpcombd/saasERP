<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Apps OD & TADA Report';
do_calander("#f_date");
do_calander("#t_date");



;?>
<div class="d-flex justify-content-center">
	<form class="n-form1 pt-4" action="master_report_apps.php" method="post" name="form1" target="_blank" id="form1">
		<div class="row m-0 p-0 fo-width1">
			<div class="col-sm-5">
				<div align="left">Select Report </div>
					<div class="form-check">
						<input name="report" type="radio" class="radio1" id="report1_btn_20241029" value="20241029" checked="checked" />
						<label class="form-check-label p-0" for="report1_btn_20241029">OD & TADA Details (20241029) </label>
					</div>
					<div class="form-check">
						<input name="report" type="radio" class="radio1" id="report1_btn_20241029" value="20241031" checked="checked" />
						<label class="form-check-label p-0" for="report1_btn_20241031">OD Details Report  </label>
					</div>
					<div class="form-check">
						<input name="report" type="radio" class="radio1" id="report1_btn_20241030" value="202410292" />
						<label class="form-check-label p-0" for="report1_btn_20241030"> TADA Summary Report(202410292) </label>
					</div>
							
			
			</div>
			<div class="col-sm-7">
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
				<label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Employee Name:</label>
					<div class="col-sm-8 p-0">
						<select name="PBI_ID"  id="PBI_ID">
						<option></option>
						<?
						if($_SESSION['employee_selected']==10001){
							foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['PBI_ID'],'1');
						}else{
							foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['PBI_ID'],'PBI_ID="'.$_SESSION['employee_selected'].'" and PBI_JOB_STATUS="In Service"');
						}
						?>
						</select>
					</div>
				</div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
				<label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Start Date:</label>
					<div class="col-sm-8 p-0">
					<input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" />
					</div>
				</div>
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
				<label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">End Date:</label>
					<div class="col-sm-8 p-0">
					<span class="oe_form_group_cell">
					<input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" />
					</span>
					</div>
				</div>
			</div>
		</div>
		<div class="n-form-btn-class">
			<input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6">
		</div>
	</form>
</div>

<?
	require_once SERVER_CORE."routing/layout.bottom.php";
	selected_two("#PBI_ID");
?>