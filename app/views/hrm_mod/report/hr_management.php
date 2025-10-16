<?php

session_start();

//


require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

$title='HR MANAGEMENT';

do_calander('#ijdb');

do_calander('#ijda');

do_calander('#ppjdb');

do_calander('#ppjda');

if($_POST['mon']!=''){

$mon=$_POST['mon'];}

else{

$mon=date('n');

}

if($_POST['year']!=''){

$year=$_POST['year'];}

else{

$year=date('Y');

}

if(isset($_POST['lock'])){

$check_sql = 'select 1 from salary_lock where month='.$_POST['mon'].' and year='.$_POST['year'].'';

$check_query = db_query($check_sql);

$last_check = mysqli_num_rows($check_query );

if($last_check >0){

echo "<h3 style='text-align:center;background-color:red;color:white;'>This month and Year Salary Exist. Lock down is not possible</h3>";

}else{

for($i=0;$i<count($_POST['tr_type']);$i++){

$sql = 'INSERT INTO `salary_lock`( `month`, `year`, `job_location`, `salary_amount`, `tr_type`) 

VALUES ("'.$_POST['mon'].'","'.$_POST['year'].'","'.$_POST['job_location'][$i].'" , "'.$_POST['salary_amount'][$i].'" ,"'.$_POST['tr_type'][$i].'" )';

db_query($sql);

}

echo "<h3 style='text-align:center;background-color:green;color:white;'>Salary is been Locked</h3>";

}

}

?>




	<!--DO create 2 form with table-->
	<div class="form-container_large">

		<form  action="../report/hr_master_report.php" target="_blank" method="post">
			<!--        top form start hear-->
			<div class="container-fluid bg-form-titel">
				<h4 class="text-center bg-titel bold pt-2 pb-2"> Select Options </h4>

				<div class="row">
					<!--left form-->
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<div class="container n-form2">
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<select name="PBI_ORG" id="PBI_ORG">

									<option></option>
									
									<? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
									
									</select>
								</div>
							</div>
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Name</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="PBI_ID">

									<option></option>
									
									<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['PBI_ID'],'PBI_JOB_STATUS="In Service"')?>
									
									</select>

								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Designation</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="designation"  id="designation">

										<option></option>
										
										<? foreign_relation('designation','DESG_ID','DESG_DESC',$ESS_DESIGNATION,'1 order by DESG_DESC');?>
										
										</select>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Gender</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="gender" >

									<option selected="selected"></option>
									
									<option>Male</option>
									
									<option>Female</option>
									
									</select>

								</div>
							</div>
							

						</div>



					</div>

					<!--Right form-->
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<div class="container n-form2">
						
						
							
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<select name="department"  id="department">

									<option></option>
									
									<? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT,'1 order by DEPT_DESC');?>
									
									</select>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Location</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="JOB_LOCATION" id="JOB_LOCATION" >

									<option></option>
									
									<? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$_POST['JOB_LOCATION'],'1 order by PROJECT_DESC');?>
									
									</select>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Status</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="job_status">

									<option selected="selected"></option>
									
									<option>IN SERVICE</option>
									
									<option>NOT IN SERVICE</option>
									
									</select>

								</div>
							</div>
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bonous Type</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="bonus_type" required = "required" >

									<option value="2">Eid-Ul-Adha</option>
									
									<option value="1">Eid-Ul-Fitre</option>
									
									</select>

								</div>
							</div>
							

						</div>



					</div>


				</div>

				
			</div>

			<br />

			<div class="container-fluid bg-form-titel">
            	<div class="row">
                
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row m-0">
                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Month</label>
                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                            <select name="mon" id="mon">

								<option value=""></option>
								
								<option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>
								
								<option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>
								
								<option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>
								
								<option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>
								
								<option value="5" <?=($mon=='5')?'selected':''?>>May</option>
								
								<option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>
								
								<option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>
								
								<option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>
								
								<option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>
								
								<option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
								
								<option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
								
								<option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>
								
								</select>

                        </div>
                    </div>
                </div>
				
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="form-group row m-0">
                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Year</label>
                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
                            <select name="year" style="width:160px;" id="year" required="required">

									<option <?=($year=='2013')?'selected':''?>>2013</option>
									
									<option <?=($year=='2014')?'selected':''?>>2014</option>
									
									<option <?=($year=='2015')?'selected':''?>>2015</option>
									
									<option <?=($year=='2016')?'selected':''?>>2016</option>
									
									<option <?=($year=='2017')?'selected':''?>>2017</option>
									
									<option <?=($year=='2018')?'selected':''?>>2018</option>
									
									<option <?=($year=='2019')?'selected':''?>>2019</option>
									
									<option <?=($year=='2020')?'selected':''?>>2020</option>
									
									<option <?=($year=='2021')?'selected':''?>>2021</option>
									
									<option <?=($year=='2022')?'selected':''?>>2022</option>
									
									<option <?=($year=='2023')?'selected':''?>>2023</option>
									
									<option <?=($year=='2024')?'selected':''?>>2024</option>
									
									<option <?=($year=='2025')?'selected':''?>>2025</option>
									
									<option <?=($year=='2026')?'selected':''?>>2026</option>
									
									<option <?=($year=='2027')?'selected':''?>>2027</option>
									
									<option <?=($year=='2028')?'selected':''?>>2028</option>
									
									<option <?=($year=='2029')?'selected':''?>>2029</option>
									
									<option <?=($year=='2030')?'selected':''?>>2030</option>
									
								</select>

                        </div>
                    </div>
                </div>

                

            </div>
        	</div>

			<br/>

			<div class="container-fluid pt-5 p-0 ">

				<h4 class="text-center bg-titel bold pt-2 pb-2">
					Select Report
				</h4>
				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th  width="5%"></th>
						<th class="text-left"></th>

						<th width="5%"></th>
						<th class="text-left"></th>
					</tr>
					</thead>

					<tbody class="tbody1">

					<tr>

						<td><input name="report" type="radio" class="radio" value="1" id="0" checked="checked" /></td>
						<td align="left"> <label for="0"><strong>Basic Information</strong></label></td>

						<td align="center" class="alt"><input id="1"  name="report" type="radio" class="radio" value="132" /></td>
						<td align="left"><label for="1"><strong>Monthly Employee Report</strong></label></td>

					</tr>

					<tr >

						<td align="center"><input id="2"  name="report" type="radio" class="radio" value="2019" /></td>

						<td align="left"><label for="2"><strong>Monthly Joining New Employee List</strong></label></td>

						<td align="center"><input id="3"  name="report" type="radio" class="radio" value="20191" /></td>

						<td align="left"><label for="3"><strong>Monthly Employee Separation List</strong> </label></td>

					</tr>

					<tr >

						<td align="center"><input id="4"  name="report" type="radio" class="radio" value="54673" /></td>

						<td align="left"><label for="4"><strong>Monthly Re-Joining List</strong> </label></td>

						<td align="center" class="alt"><input id="5"  name="report" type="radio" class="radio" value="322" /></td>

						<td align="left"><label for="5"><strong>Transfer Report</strong> </label></td>

					</tr>

					<tr >

						<td align="center" class="alt"><input id="6"  name="report" type="radio" class="radio" value="323" /></td>

						<td align="left"><label for="6"><strong>Probationary Period Report</strong></label></td>

						<td align="center" class="alt"><input id="7"  name="report" type="radio" class="radio" value="2454" /></td>

						<td align="left"><label for="7"> <strong>Employee Birthday Report</strong></label></td>

					</tr>

					<tr >

						<td align="center" class="alt"><input id="8"  name="report" type="radio" class="radio" value="2456" /></td>

						<td align="left"><label for="8"><strong>Employee Blood Group Report</strong> </label></td>

						<td align="center" class="alt"><input id="9"  name="report" type="radio" class="radio" value="2455" /></td>

						<td align="left"><label for="9"><strong>Employee Final Settlement</strong> </label></td>

					</tr>

					<tr>

						<td align="center" class="alt"><input id="10"  name="report" type="radio" class="radio" value="5312023" /></td>

						<td align="left"><label for="10"> <strong> Experience Certificate</strong></label></td>

						<td align="center" class="alt"><input id="11"  name="report" type="radio" class="radio" value="2457" /></td>

						<td align="left"><label for="11"><strong> Probation Extension Report</strong> </label></td>

					</tr>

					</tbody>

				</table>


				<div class="n-form-btn-class">
					<input name="submit" type="submit" id="submit" class="btn1 btn1-bg-submit" value="SHOW" />
				</div>

			</div>

		</form>


	</div>













<?php/*>
<div class="right_col" role="main">

<!-- Must not delete it ,this is main design header-->

<div class="">

<div class="clearfix"></div>

<div class="row">

<div class="col-md-12 col-sm-12 col-xs-12">

<div class="x_panel">

<div class="openerp openerp_webclient_container">

<div class="x_content">

<form action="../report/hr_master_report.php" target="_blank" method="post">

<div class="oe_view_manager oe_view_manager_current">

<div class="oe_view_manager_body">

<div  class="oe_view_manager_view_list"></div>

<div class="oe_view_manager_view_form">

<div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

<div class="oe_form_buttons"></div>

<div class="oe_form_sidebar"></div>

<div class="oe_form_pager"></div>

<div class="oe_form_container">

<div class="oe_form">

<div class="">

<div  class="oe_view_manager_view_list">

<div  class="oe_list oe_view">

<table width="100%" border="0" class="table table-bordered table-sm">

<thead>

<tr class="table-info">

<th colspan="4" align="center"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>

</tr>

</thead>

<tfoot>

</tfoot>

<tbody>

<tr>

<td align="right" style="font-size:16px" class="alt"><strong>Company :</strong></td>

<td align="left" class="alt"><span class="oe_form_group_cell">

<select name="PBI_ORG" style="width:160px;" id="PBI_ORG">

<option></option>

<? foreign_relation('user_group','id','group_name',$PBI_ORG);?>

</select>

</span></td>

<td width="40%" style="font-size:16px" align="right" class="alt"><strong>Department :</strong></td>

<td width="10%"><span class="oe_form_group_cell">

<select name="department" style="width:160px;" id="department">

<option></option>

<? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT,'1 order by DEPT_DESC');?>

</select>

</span></td>

</tr>

<tr  class="alt">

<td align="right" style="font-size:16px"><strong>Designation :</strong></td>

<td align="left"><span class="oe_form_group_cell">

<select name="designation" style="width:160px;" id="designation">

<option></option>

<? foreign_relation('designation','DESG_ID','DESG_DESC',$ESS_DESIGNATION,'1 order by DESG_DESC');?>

</select>

</span></td>

<td align="right" style="font-size:16px"><strong>Project / Job Location:</strong></td>

<td><span class="oe_form_group_cell">

<select name="JOB_LOCATION" id="JOB_LOCATION" style="width:160px;">

<option></option>

<? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$_POST['JOB_LOCATION'],'1 order by PROJECT_DESC');?>

</select>

</span></td>

</tr>

<tr >

<td align="right" style="font-size:16px"><strong>Gender :</strong></td>

<td align="left"><span class="oe_form_group_cell">

<select name="gender" style="width:160px;">

<option selected="selected"></option>

<option>Male</option>

<option>Female</option>

</select>

</span></td>

<td align="right" style="font-size:16px"><strong>Job Status :</strong></td>

<td><span class="oe_form_group_cell">

<select name="job_status" style="width:160px;">

<option selected="selected"></option>

<option>IN SERVICE</option>

<option>NOT IN SERVICE</option>

</select>

</span></td>

</tr>

<tr >

<td align="right" style="font-size:16px"><span class="alt"><strong>Bonus Type  : </strong></span></td>

<td align="left"><strong>

<select name="bonus_type" required = "required" style="width:160px;">

<option value="2">Eid-Ul-Adha</option>

<option value="1">Eid-Ul-Fitre</option>

</select>

</strong></td>

<td align="right"><strong>Job Status :</strong></td>

<td><span class="oe_form_group_cell">

<select name="PBI_ID" style="width:160px;">

<option></option>

<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['PBI_ID'],'PBI_JOB_STATUS="In Service"')?>

</select>

</span></td>

</tr>

<tr >

<td align="right" style="font-size:16px"><span class="alt"><strong> </strong></span></td>

<td align="left"><strong> </strong></td>

<td align="right" style="font-size:16px"><strong>ID NO:</strong></td>

<td align="center"><span class="oe_form_group_cell">

<div class="frmSearch">

<input type="text" id="id_no" name="id_no" placeholder="Employee Name..." />

<div id="suggesstion-box"></div>

</div>

<? //foreign_relation('personnel_basic_info','PBI_ID','CONCAT("",PBI_ID,"","-", " ",PBI_NAME )',$PBI_ID);?>

</span></td>

</tr>

<tr>

<td align="right" bgcolor="#7c5fc8" style="color:#FFFFFF; font-weight:bold; font-size:15px"><span>Month:</span> </td>

<td align="left" bgcolor="#7c5fc8" style="color:#FFFFFF; font-weight:bold; font-size:15px"><span class="oe_form_group_cell">

<select name="mon" style="width:160px;" id="mon">

<option value=""></option>

<option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>

<option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>

<option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>

<option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>

<option value="5" <?=($mon=='5')?'selected':''?>>May</option>

<option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>

<option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>

<option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>

<option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>

<option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>

<option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>

<option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>

</select>

</span></td>

<td align="right" bgcolor="#7c5fc8" style="color:#FFFFFF; text-align:center; font-weight:bold;font-size:15px; padding-top:2;"><span style="float:right">Year:</span></td>

<td bgcolor="#7c5fc8" style="color:#FFFFFF; text-align:center; font-weight:bold; padding-top:7px; font-size:15px" ><select name="year" style="width:160px;" id="year" required="required">

<option <?=($year=='2013')?'selected':''?>>2013</option>

<option <?=($year=='2014')?'selected':''?>>2014</option>

<option <?=($year=='2015')?'selected':''?>>2015</option>

<option <?=($year=='2016')?'selected':''?>>2016</option>

<option <?=($year=='2017')?'selected':''?>>2017</option>

<option <?=($year=='2018')?'selected':''?>>2018</option>

<option <?=($year=='2019')?'selected':''?>>2019</option>

<option <?=($year=='2020')?'selected':''?>>2020</option>

<option <?=($year=='2021')?'selected':''?>>2021</option>

<option <?=($year=='2022')?'selected':''?>>2022</option>

<option <?=($year=='2023')?'selected':''?>>2023</option>

<option <?=($year=='2024')?'selected':''?>>2024</option>

<option <?=($year=='2025')?'selected':''?>>2025</option>

<option <?=($year=='2026')?'selected':''?>>2026</option>

<option <?=($year=='2027')?'selected':''?>>2027</option>

<option <?=($year=='2028')?'selected':''?>>2028</option>

<option <?=($year=='2029')?'selected':''?>>2029</option>

<option <?=($year=='2030')?'selected':''?>>2030</option>

</select></td>

</tr>

</tbody>

</table>

<div style="text-align:center">

<table width="100%" class="table table-bordered table-sm">

<thead>

<tr>

<th colspan="4">
	<span style="text-align: center; font-size:16px; color:#C00">Select Report</span>
</th>

</tr>

</thead>

<tfoot>

</tfoot>

<tbody>

<tr>

<td align="center"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>

<td align="left"><strong>Basic </strong> <strong>Information</strong></td>

<td align="center" class="alt"><input name="report" type="radio" class="radio" value="132" /></td>

<td align="left"><strong>Monthly Employee Report</strong><strong></strong></td>

</tr>

<tr >

<td align="center"><input name="report" type="radio" class="radio" value="2019" /></td>

<td align="left"><strong>Monthly Joining New Employee List</strong><strong></strong></td>

<td align="center" class="alt"><input name="report" type="radio" class="radio" value="20191" /></td>

<td align="left"><strong>Monthly Employee Separation List</strong><strong></strong></td>

</tr>

<tr >

<td align="center" class="alt"><input name="report" type="radio" class="radio" value="54673" /></td>

<td align="left"><strong>Monthly Re-Joining List</strong><strong></strong></td>

<td align="center" class="alt"><input name="report" type="radio" class="radio" value="322" /></td>

<td align="left"><strong>Transfer Report</strong><strong></strong></td>

</tr>

<tr >

<td align="center" class="alt"><input name="report" type="radio" class="radio" value="323" /></td>

<td align="left"><strong>Probationary Period Report</strong><strong></strong></td>

<td align="center" class="alt"><input name="report" type="radio" class="radio" value="2454" /></td>

<td align="left"><strong>Employee Birthday Report</strong><strong></strong></td>

</tr>

<tr >

<td align="center" class="alt"><input name="report" type="radio" class="radio" value="2456" /></td>

<td align="left"><strong>Employee Blood Group Report</strong><strong></strong></td>

<td align="center" class="alt"><input name="report" type="radio" class="radio" value="2455" /></td>

<td align="left"><strong>Employee Final Settlement</strong><strong></strong></td>

</tr>

<tr>

<td align="center" class="alt"><input name="report" type="radio" class="radio" value="5312023" /></td>

<td align="left"><strong> Experience Certificate</strong></td>

<td align="center" class="alt"><input name="report" type="radio" class="radio" value="2457" /></td>

<td align="left"><strong> Probation Extension Report</strong></td>

</tr>

<tr>

<td align="center" class="alt"><input name="report" type="radio" class="radio" value="" /></td>

<td class="alt"><strong><a href="organogram_report.php" target="_blank" style="text-align:left; text-decoration:none">Organogram Report</a></strong><strong></strong></td>

</tr>

</tbody>


</table>

<input name="submit" type="submit" id="submit" class="btn1 btn1-bg-submit" value="SHOW" />

</div>

</div>

</div>

</div>

<div class="oe_chatter">

<div class="oe_followers oe_form_invisible">

<div class="oe_follower_list"></div>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</form>

</div>

</tr>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

</div>

<*/?>





<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>

