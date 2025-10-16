<?php

session_start();

//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title='Complex Reporting'; 	


do_calander('#ijdb');

do_calander('#ijda');

do_calander('#ppjdb');

do_calander('#ppjda');

?>


	<style>
		tr:nth-child(odd){
			background-color: white !important;
		}

		tr:nth-child(even){
			background-color: whitesmoke!important;
		}
	</style>

<div class="form-container_large">

		<form  action="../report/master_report_complex.php" target="_blank" method="post">
			<!--        top form start hear-->
			<div class="container-fluid bg-form-titel">
				<h4 class="text-center bg-titel bold pt-2 pb-2"> Select Options </h4>

				<div class="row">
					<!--left form-->
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<div class="container n-form2">
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Name</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<input name="name" type="text" id="name"/>
								</div>
							</div>
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Domain</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="domain" id="domain">

									  <option></option>
							
									<? foreign_relation('domai','DOMAIN_SHORT_NAME','DOMAIN_SHORT_NAME',$PBI_DOMAIN, ' 1 order by DOMAIN_SHORT_NAME');?>
							
								  </select>

								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Zone</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="zone"  id="zone">

									  <option></option>
							
									<? foreign_relation('zon','ZONE_NAME','ZONE_NAME',$PBI_ZONE, ' 1 order by ZONE_NAME');?>
							
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
						
						<div class="container n-form2">
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Present File Status</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<select name="personal_file_status" id="personal_file_status" >

										<? foreign_relation('present_file_status','id','present_file_status',$personal_file_status);?>
								
									  </select>
								</div>
						  </div>
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Designation</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="DESG_GRADE1"  id="DESG_GRADE1">
							
									  <option></option>
							
									<? foreign_relation('designation','DESG_GRADE','DESG_DESC',$DESG_GRADE1, ' 1 order by DESG_DESC');?>
							
								  </select>

								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Blood Group</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="blood_group"  id="blood_group">

										<option selected="selected"></option>
								
															<option>A(+ve)</option>
								
															<option>A(-ve)</option>
								
															<option>AB(+ve)</option>
								
															<option>AB(-ve)</option>
								
															<option>B(+ve)</option>
								
															<option>B(-ve)</option>
								
															<option>O(+ve)</option>
								
															<option>O(-ve)</option>
								
															<option>N/I</option>
								
									  </select>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Status</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="PBI_JOB_STATUS">

										<option selected="selected">  </option>
					
										<option>In Service</option>
					
										<option>Not In Service</option>
					
									  </select>

								</div>
							</div>
							

						</div>
						<div class="container n-form2">
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Area of Expertise</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<select name="PBI_SPECIALTY" id="PBI_SPECIALTY" >

										<option>
								
										  <?=$PBI_SPECIALTY?>
								
										  </option>
								
										<? foreign_relation('area_expertise','id','area_expertise',$PBI_SPECIALTY);?>
								
									  </select>
								</div>
						  </div>
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Function Designation</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="functional_designation">

										<? foreign_relation('hrm_functional_designation','id','functional_designation',$functional_designation);?>
								
									  </select>

								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Initial Joining Date(Before)</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input name="ijdb" type="text" id="ijdb"  />
								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">P Post Joining Date(Before)</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input name="ppjdb" type="text" id="ppjdb" />

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
								
										<? foreign_relation('department','DEPT_SHORT_NAME','DEPT_DESC',$PBI_DEPARTMENT, ' 1 order by DEPT_DESC');?>
								
									  </select>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Project</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="project" id="project">

										  <option></option>
								
										<? foreign_relation('project','PROJECT_SHORT_NAME','PROJECT_DESC',$PBI_PROJECT, ' 1 order by PROJECT_DESC');?>
								
									  </select>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Area</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="area"  id="area">

									  <option></option>
							
									<? foreign_relation('area','AREA_NAME','AREA_NAME',$PBI_AREA, ' 1 order by AREA_NAME');?>
							
									</select>

								</div>
							</div>
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Branch</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="branch" id="branch">

										<option></option>
								
										<? foreign_relation('branch','BRANCH_NAME','BRANCH_NAME',$PBI_BRANCH, ' 1 order by BRANCH_NAME');?>
								
									  </select>

								</div>
							</div>
							

						</div>

						<div class="container n-form2">
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Region</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<select name="region"  id="region">

									<option></option>
							
									  <? foreign_relation('region','region_id','region_name',$PBI_BRANCH, ' 1 order by region_name');?>
							
									</select>
								</div>
							</div>
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Designation</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="DESG_GRADE2"  id="DESG_GRADE2">

										  <option></option>
								
										<? foreign_relation('designation','DESG_GRADE','DESG_DESC',$DESG_GRADE2, ' 1 order by DESG_DESC');?>
								
									  </select>

								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Edu Qualification</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="edu_qua" id="edu_qua">

									  <option selected="selected"></option>
								
										<option>ALIM</option><option>B Com
										
										</option><option>B Ed
										
										</option><option>B Sc
										
										</option><option>BA
										
										</option><option>BA (Special)
										
										</option><option>BA(Hons)
										
										</option><option>BBS
										
										</option><option>BSC Agri Eng
										
										</option><option>BSC Eng
										
										</option><option>BSS
										
										</option><option>CA(CC)
										
										</option><option>Class Eight
										
										</option><option>Class Five
										
										</option><option>Class Nine
										
										</option><option>Class Seven
										
										</option><option>Class Ten
										
										</option><option>Class Three
										
										</option><option>DAKHIL
										
										</option><option>Diploma Eng
										
										</option><option>Diploma in Ag
										
										</option><option>Diploma in Commerce
										
										</option><option>DVM
										
										</option><option>FADIL
										
										</option><option>Fazil B.A. (Special)
										
										</option><option>Higher Diploma Eng
										
										</option><option>Hons
										
										</option><option>HSC
										
										</option><option>KAMIL
										
										</option><option>M Com</option>
										
									  </select>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Age More Than</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="age"  id="age">

										<option selected="selected"></option>
								
										<? for($i=60;$i>24;$i--) echo '<option>'.$i.'</option>';?>
								
									  </select>

								</div>
							</div>
							

						</div>
						
						<div class="container n-form2">
						
						
							
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Code Class</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<select name="code_class"  id="code_class">

										<option selected="selected"></option>
								
										<option value="101">SR-TMSS(101)</option>
								
										<option value="102">SR-THS(102)</option>
								
										<option value="103">SR-TTI(103)</option>
								
										<option value="104">SR-TPSC(104)</option>
								
										<option value="201">Contructual(201)</option>
								
										<option value="301">Project Based(301)</option>
								
									</select>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">

								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Type</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<select name="employee_type">

										<? foreign_relation('hrm_employee_type','id','employee_type',$employee_type);?>
								
									  </select>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Initail Joining Date(After)</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input name="ijda" type="text" id="ijda" />

								</div>
							</div>
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">P Post Joining Date(After)</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<input name="ppjda" type="text" id="ppjda" />

								</div>
							</div>
							

						</div>

					</div>


				</div>

				
			</div>

			<br />


			<div class="container-fluid pt-5 p-0 ">

				<h4 class="text-center bg-titel bold pt-2 pb-2">
					Select Columns
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

						<td><input name="report" type="hidden" value="201" checked="checked" />

       						 <input name="PBI_NAME" type="checkbox" id="PBI_NAME" value="1" /></td>
		
						<td align="center"> <label for="0">Full Name</label></td>
						

						<td align="center" class="alt"><input name="PBI_MARITAL_STA" type="checkbox" id="PBI_MARITAL_STA" value="1" /></td>
						<td align="center"><label for="1">Marital Status</label></td>

					</tr>

					<tr >

						<td align="center"><input name="PBI_FATHER_NAME" type="checkbox" id="PBI_FATHER_NAME" value="1" /></td>

						<td align="center"><label for="2">Father's Name</label></td>

						<td align="center"><input name="PBI_MOTHER_NAME" type="checkbox" id="PBI_MOTHER_NAME" value="1" /></td>

						<td align="center"><label for="3">Mother's Name </label></td>

					</tr>

					<tr >

						
						<td align="center"><input name="PBI_DESIGNATION" type="checkbox" id="PBI_DESIGNATION" value="1" /></td>

						<td align="center"><label for="4">Designation </label></td>

						<td align="center" class="alt"><input name="PBI_PRESENT_ADD" type="checkbox" id="PBI_PRESENT_ADD" value="1" /></td>

						<td align="center"><label for="5">Present Address </label></td>

					</tr>

					<tr >
							
							
						<td align="center" class="alt"><input name="PBI_SEX" type="checkbox" id="PBI_SEX" value="1" /></td>

						<td align="center"><label for="6">Gender</label></td>

						<td align="center" class="alt"><input name="PBI_PERMANENT_ADD" type="checkbox" id="PBI_PERMANENT_ADD" value="1" /></td>

						<td align="center"><label for="7"> Permanent Address</label></td>

					</tr>

					<tr >

						<td align="center" class="alt"><input name="PBI_PHONE" type="checkbox" id="PBI_PHONE" value="1" /></td>

						<td align="center"><label for="8">Phone No </label></td>

						<td align="center" class="alt"><input name="PBI_DOB" type="checkbox" id="PBI_DOB" value="1" /></td>

						<td align="center"><label for="9">Birth Date</label></td>

					</tr>

					<tr>
					
				

						<td align="center" class="alt"><input name="PBI_MOBILE" type="checkbox" id="PBI_MOBILE" value="1" /></td>

						<td align="center"><label for="10"> Mobile No</label></td>

						<td align="center" class="alt"><input name="PBI_RELIGION" type="checkbox" id="PBI_RELIGION" value="1" /></td>

						<td align="center"><label for="11">Religion</label></td>

					</tr>
					<tr>
						
						<td align="center" class="alt"><input name="ESSENTIAL_VOTER_ID" type="checkbox" id="ESSENTIAL_VOTER_ID" value="1" /></td>

						<td align="center"><label for="10"> National ID </label></td>

						<td align="center" class="alt"><input name="ESSENTIAL_BLOOD_GROUP" type="checkbox" id="ESSENTIAL_BLOOD_GROUP" value="1" /></td>

						<td align="center"><label for="11">Blood Group</label></td>

					</tr>
					<tr>
			
						<td align="center" class="alt"><input name="PBI_EMAIL" type="checkbox" id="PBI_EMAIL" value="1" /></td>

						<td align="center"><label for="10"> Email</label></td>

						<td align="center" class="alt"><input name="JOB_STATUS" type="checkbox" id="JOB_STATUS" value="1" /></td>

						<td align="center"><label for="11">Job Status</label></td>

					</tr>
					<tr>
			

						<td align="center" class="alt"><input name="PBI_DOMAIN" type="checkbox" id="PBI_DOMAIN" value="1" /></td>

						<td align="center"><label for="10"> Domain</label></td>

						<td align="center" class="alt"><input name="PBI_DEPARTMENT" type="checkbox" id="PBI_DEPARTMENT" value="1" /></td>

						<td align="center"><label for="11">Department</label></td>

					</tr>
					<tr>
			
						<td align="center" class="alt"><input name="PBI_DOJ" type="checkbox" id="PBI_DOJ" value="1" /></td>

						<td align="center"><label for="10"> Initial Joining Date </label></td>

						<td align="center" class="alt"><input name="PBI_DOJ_PP" type="checkbox" id="PBI_DOJ_PP" value="1" /></td>

						<td align="center"><label for="11">Joining Date (PP)</label></td>

					</tr>
					<tr>
				

						<td align="center" class="alt"><input name="PBI_REGION" type="checkbox" id="PBI_REGION" value="1" /></td>

						<td align="center"><label for="10"> Region</label></td>

						<td align="center" class="alt"><input name="PBI_PROJECT" type="checkbox" id="PBI_PROJECT" value="1" /></td>

						<td align="center"><label for="11">Project</label></td>

					</tr>
					<tr>
					
		

						<td align="center" class="alt"><input name="PBI_ZONE" type="checkbox" id="PBI_ZONE" value="1" /></td>

						<td align="center"><label for="10"> Zone</label></td>

						<td align="center" class="alt"><input name="PBI_EDU_QUALIFICATION" type="checkbox" id="PBI_EDU_QUALIFICATION" value="1" /></td>

						<td align="center"><label for="11">Educational Qualification</label></td>

					</tr>
					<tr>
			

						<td align="center" class="alt"><input name="PBI_AREA" type="checkbox" id="PBI_AREA" value="1" /></td>

						<td align="center"><label for="10">Area</label></td>

						<td align="center" class="alt"><input name="PBI_BRANCH" type="checkbox" id="PBI_BRANCH" value="1" /></td>

						<td align="center"><label for="11">Branch</label></td>

					</tr>
					<tr>
					
			
						<td align="center" class="alt"><input name="resign_date" type="checkbox" id="resign_date" value="1" /></td>

						<td align="center"><label for="10"> Resign Date</label></td>

						<td align="center" class="alt"><input name="PBI_separation_type" type="checkbox" id="PBI_separation_type" value="1" /></td>

						<td align="center"><label for="11">Separation Type</label></td>

					</tr>
					<tr>
					
			
						<td align="center" class="alt"><input name="PBI_SPECIALTYs" type="checkbox" id="PBI_SPECIALTYs" value="1" /></td>

						<td align="center"><label for="10"> Expertise</label></td>

						<td align="center" class="alt"><input name="PBI_NATIONALITY" type="checkbox" id="PBI_NATIONALITY" value="1" /></td>

						<td align="center"><label for="11">Nationality</label></td>

					</tr>
					<tr>
			
			
						<td align="center" class="alt"><input name="PBI_DOC" type="checkbox" id="PBI_DOC" value="1" /></td>

						<td align="center"><label for="10">Confirmation Date</label></td>

						<td align="center" class="alt"><input name="JOB_LOCATION" type="checkbox" id="JOB_LOCATION" value="1" /></td>

						<td align="center"><label for="11">Job Location</label></td>

					</tr>
					<tr>
					
			
						<td align="center" class="alt"><input name="PBI_PRIMARY_JOB_STATUS" type="checkbox" id="PBI_PRIMARY_JOB_STATUS" value="1" /></td>

						<td align="center"><label for="10"> Initial Job Status</label></td>

						<td align="center" class="alt"><input name="personal_file_status" type="checkbox" id="personal_file_status" value="1" /></td>

						<td align="center"><label for="11">Present File Status</label></td>

					</tr>
					<tr>
			
						<td align="center" class="alt"><input name="PBI_GARDIAN" type="checkbox" id="PBI_GARDIAN" value="1" /></td>

						<td align="center"><label for="10"> Gardian</label></td>

						<td align="center" class="alt"><input name="PBI_POB" type="checkbox" id="PBI_POB" value="1" /></td>

						<td align="center"><label for="11">Place of Birth (District)</label></td>

					</tr>
					<tr>
			
			
						<td align="center" class="alt"><input name="resign_date" type="checkbox" id="resign_date" value="1" /></td>

						<td align="center"><label for="10"> Resign Date</label></td>

						<td align="center" class="alt"><input name="PBI_separation_type" type="checkbox" id="PBI_separation_type" value="1" /></td>

						<td align="center"><label for="11">Separation Type</label></td>

					</tr>
					<tr>
			
						<td align="center" class="alt"><input name="PBI_SERVICE_LENGTH" type="checkbox" id="PBI_SERVICE_LENGTH" value="1" /></td>

						<td align="center"><label for="10"> Total Service Length</label></td>

						<td align="center" class="alt"><input name="service_length_pp" type="checkbox" id="service_length_pp" value="1" /></td>

						<td align="center"><label for="11">Service Length (PP)</label></td>

					</tr>
					<tr>
			
			
						<td align="center" class="alt"><input name="PBI_RELIGION" type="checkbox" id="PBI_RELIGION" value="1" /></td>

						<td align="center"><label for="10"> Religion</label></td>

						<td align="center" class="alt">&nbsp;</td>

						<td align="center"><label for="11">&nbsp;</label></td>

					</tr>

					</tbody>

				</table>


				<div class="n-form-btn-class">
					<input name="submit" type="submit" id="submit" class="btn1 btn1-bg-submit" value="SHOW" />
				</div>

			</div>

		</form>


	</div>




<?php /*?><form action="../report/master_report_complex.php" target="_blank" method="post">

<div class="oe_view_manager oe_view_manager_current">

        

        <div class="oe_view_manager_body">

            

                <div  class="oe_view_manager_view_list"></div>

            

                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

        <div class="oe_form_buttons"></div>

        <div class="oe_form_sidebar"></div>

        <div class="oe_form_pager"></div>

        <div class="oe_form_container"><div class="oe_form">

          <div class="">

<div class="oe_form_sheetbg">

        <div class="oe_form_sheet oe_form_sheet_width">



          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">

<table width="100%" border="0" class="table table-bordered table-sm"><thead>



<tr class="oe_list_header_columns">

  <th colspan="4"><span style="text-align:center; font-size:16px; color:#C00">Select Options</span></th>

  </tr>

</thead><tfoot>

</tfoot><tbody>

  <tr>

    <td width="40%" align="right"><strong>Name :</strong></td>

  <td width="10%" align="left"><input name="name" type="text" id="name" size="30" style="width:160px;"/></td>

  <td width="40%" align="right" class="alt"><strong>Department :</strong></td>

    <td width="10%"><span class="oe_form_group_cell">

      <select name="department" style="width:160px;" id="department">

          <option></option>

        <? foreign_relation('department','DEPT_SHORT_NAME','DEPT_DESC',$PBI_DEPARTMENT, ' 1 order by DEPT_DESC');?>

      </select></span></td>

  </tr>



  <tr  class="alt">

    <td align="right"><strong>Domain :</strong></td><td align="left"><span class="oe_form_group_cell">

      <select name="domain" style="width:160px;" id="domain">

          <option></option>

        <? foreign_relation('domai','DOMAIN_SHORT_NAME','DOMAIN_SHORT_NAME',$PBI_DOMAIN, ' 1 order by DOMAIN_SHORT_NAME');?>

      </select>

    </span></td>

    <td align="right"><strong>Project :</strong></td>

    <td><span class="oe_form_group_cell">

      <select name="project" style="width:160px;" id="project">

          <option></option>

        <? foreign_relation('project','PROJECT_SHORT_NAME','PROJECT_DESC',$PBI_PROJECT, ' 1 order by PROJECT_DESC');?>

      </select></span></td>

  </tr>

  <tr >

    <td align="right"><strong>Zone :</strong></td>

    <td align="left"><span class="oe_form_group_cell">

      <select name="zone" style="width:160px;" id="zone">

          <option></option>

        <? foreign_relation('zon','ZONE_NAME','ZONE_NAME',$PBI_ZONE, ' 1 order by ZONE_NAME');?>

      </select>

    </span></td>

    <td align="right"><strong>Area :</strong></td>

    <td><span class="oe_form_group_cell">

      <select name="area" style="width:160px;" id="area">

          <option></option>

        <? foreign_relation('area','AREA_NAME','AREA_NAME',$PBI_AREA, ' 1 order by AREA_NAME');?>

        </select></span></td>

  </tr>

  <tr >

    <td align="right"><strong>Gender :</strong></td>

    <td align="left">      <select name="gender" style="width:160px;">

        <option selected="selected"></option>

        <option>Male</option>

        <option>Female</option>

      </select>    </td>

    <td align="right"><strong>Branch :</strong></td>

    <td>      <select name="branch" style="width:160px;" id="branch">

        <option></option>

        <? foreign_relation('branch','BRANCH_NAME','BRANCH_NAME',$PBI_BRANCH, ' 1 order by BRANCH_NAME');?>

      </select>    </td>

  </tr>

  <tr >

    <td align="right"><strong>Present File Status : </strong></td>

    <td align="left"><span class="oe_form_group_cell">

        <option></option>

      <select name="personal_file_status" id="personal_file_status" style="width:160px;">

        <? foreign_relation('present_file_status','id','present_file_status',$personal_file_status);?>

      </select>

    </span></td>

    <td align="right"><strong>Region : </strong></td>

    <td>      <select name="region" style="width:160px;" id="region">

        <option></option>

          <? foreign_relation('region','region_id','region_name',$PBI_BRANCH, ' 1 order by region_name');?>

            </select>    </td>

  </tr>

  <tr >

    <td align="right" bgcolor="#CC99FF"><strong>Designation :</strong></td>

    <td align="left" bgcolor="#CC99FF"><span class="oe_form_group_cell">

      <select name="DESG_GRADE1" style="width:160px;" id="DESG_GRADE1">

          <option></option>

        <? foreign_relation('designation','DESG_GRADE','DESG_DESC',$DESG_GRADE1, ' 1 order by DESG_DESC');?>

      </select>

    </span></td>

    <td align="right" bgcolor="#CC99FF"><strong>To Designation :</strong></td>

    <td align="left" bgcolor="#CC99FF"><span class="oe_form_group_cell">

      <select name="DESG_GRADE2" style="width:160px;" id="DESG_GRADE2">

          <option></option>

        <? foreign_relation('designation','DESG_GRADE','DESG_DESC',$DESG_GRADE2, ' 1 order by DESG_DESC');?>

      </select></span></td>

    </tr>

  <tr >

    <td align="right"><strong>Blood Group :</strong></td>

    <td align="left"><span class="oe_form_group_cell">

      <select name="blood_group" style="width:160px;" id="blood_group">

        <option selected="selected"></option>

<option>A(+ve)</option>

                            <option>A(-ve)</option>

                            <option>AB(+ve)</option>

                            <option>AB(-ve)</option>

                            <option>B(+ve)</option>

                            <option>B(-ve)</option>

                            <option>O(+ve)</option>

                            <option>O(-ve)</option>

                            <option>N/I</option>

      </select>

    </span></td>

    <td align="right"><strong>Edu Qualification :</strong></td>

    <td><span class="oe_form_group_cell">

      <select name="edu_qua" style="width:160px;" id="edu_qua">

      <option selected="selected"></option>

<option>ALIM</option><option>B Com

</option><option>B Ed

</option><option>B Sc

</option><option>BA

</option><option>BA (Special)

</option><option>BA(Hons)

</option><option>BBS

</option><option>BSC Agri Eng

</option><option>BSC Eng

</option><option>BSS

</option><option>CA(CC)

</option><option>Class Eight

</option><option>Class Five

</option><option>Class Nine

</option><option>Class Seven

</option><option>Class Ten

</option><option>Class Three

</option><option>DAKHIL

</option><option>Diploma Eng

</option><option>Diploma in Ag

</option><option>Diploma in Commerce

</option><option>DVM

</option><option>FADIL

</option><option>Fazil B.A. (Special)

</option><option>Higher Diploma Eng

</option><option>Hons

</option><option>HSC

</option><option>KAMIL

</option><option>M Com</option>

      </select></span></td>

  </tr>

  <tr >

    <td align="right"><strong>Job Status :</strong></td>

    <td align="left"><select name="PBI_JOB_STATUS">

                    <option selected="selected">                      </option>

                    <option>In Service</option>

                    <option>Not In Service</option>

                  </select>&nbsp;</td>

    <td align="right"><strong>Age (More Than) :</strong></td>

    <td><span class="oe_form_group_cell">

      <select name="age" style="width:160px;" id="age">

        <option selected="selected"></option>

        <? for($i=60;$i>24;$i--) echo '<option>'.$i.'</option>';?>

      </select></span></td>

  </tr>

  <tr >

    <td align="right"><span class="oe_form_group_cell_label oe_form_group_cell"><strong>Area of expertise :</strong></span></td>

    <td align="left"><span class="oe_form_field oe_datepicker_root oe_form_field_date">

      <select name="PBI_SPECIALTY" id="PBI_SPECIALTY" style="width:160px;">

        <option>

          <?=$PBI_SPECIALTY?>

          </option>

        <? foreign_relation('area_expertise','id','area_expertise',$PBI_SPECIALTY);?>

      </select>

    </span></td>

    <td align="right"><strong>Employee Code Class :</strong></td>

    <td><select name="code_class" style="width:160px;" id="code_class">

        <option selected="selected"></option>

        <option value="101">SR-TMSS(101)</option>

        <option value="102">SR-THS(102)</option>

        <option value="103">SR-TTI(103)</option>

        <option value="104">SR-TPSC(104)</option>

        <option value="201">Contructual(201)</option>

        <option value="301">Project Based(301)</option>

    </select></td>

  </tr>

  <tr >

    <td align="right"><strong>Function Designation : </strong></td>

    <td align="left"><strong>

      <select name="functional_designation">

        <? foreign_relation('hrm_functional_designation','id','functional_designation',$functional_designation);?>

      </select>

    </strong></td>

    <td align="right"><strong>Employee Type :</strong></td>

    <td><strong>

      <select name="employee_type">

        <? foreign_relation('hrm_employee_type','id','employee_type',$employee_type);?>

      </select>

    </strong></td>

  </tr>

  <tr >

    <td align="right"><strong>Initial Joining Date(Before) :</strong></td>

    <td align="left"><input name="ijdb" type="text" id="ijdb" size="30" style="width:160px;" /></td>

    <td align="right"><strong>Initial Joining Date(After) :</strong></td>

    <td><input name="ijda" type="text" id="ijda" size="30" style="width:160px;" /></td>

  </tr>

  <tr >

    <td align="right"><strong>P Post Joining Date(Before)  :</strong></td>

    <td align="left"><input name="ppjdb" type="text" id="ppjdb" size="30" style="width:160px;" /></td>

    <td align="right"><strong>P Post  Joining Date(After)  :</strong></td>

    <td><input name="ppjda" type="text" id="ppjda" size="30" style="width:160px;" /></td>

  </tr>

  </tbody></table>

<div style="text-align:center">

<table width="100%" class="table table-bordered table-sm">

  <thead>

<tr class="oe_list_header_columns">

  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Columns</span></th>

  </tr>

  </thead>

  <tfoot>

  </tfoot>

  <tbody>

    <tr>

      <td align="center" class="alt"><input name="report" type="hidden" value="201" checked="checked" />

        <input name="PBI_NAME" type="checkbox" id="PBI_NAME" value="1" /></td>

      <td class="alt"><strong>Full Name</strong></td>

      <td width="4%" align="center"><input name="PBI_MARITAL_STA" type="checkbox" id="PBI_MARITAL_STA" value="1" /></td>

      <td width="44%">Marital Status</td>

      </tr>

    <tr>

      <td align="center"><span class="alt">

        <input name="PBI_FATHER_NAME" type="checkbox" id="PBI_FATHER_NAME" value="1" />

      </span></td>

      <td>Father Name </td>

      <td align="center" class="alt"><input name="PBI_MOTHER_NAME" type="checkbox" id="PBI_MOTHER_NAME" value="1" /></td>

      <td class="alt">Mother Name </td>

    </tr>

    <tr>

      <td width="4%" align="center"><input name="PBI_DESIGNATION" type="checkbox" id="PBI_DESIGNATION" value="1" /></td>

      <td width="44%">Designation</td>

      <td align="center" class="alt"><input name="PBI_PRESENT_ADD" type="checkbox" id="PBI_PRESENT_ADD" value="1" /></td>

      <td class="alt">Present Address</td>

    </tr>

    <tr >

      <td align="center" class="alt"><input name="PBI_SEX" type="checkbox" id="PBI_SEX" value="1" /></td>

      <td class="alt">Gender</td>

      <td align="center"><input name="PBI_PERMANENT_ADD" type="checkbox" id="PBI_PERMANENT_ADD" value="1" /></td>

      <td>Permanent Address</td>

    </tr>

    <tr >

      <td align="center" class="alt"><input name="PBI_PHONE" type="checkbox" id="PBI_PHONE" value="1" /></td>

      <td class="alt">Phone No</td>

      <td align="center"><input name="PBI_DOB" type="checkbox" id="PBI_DOB" value="1" /></td>

      <td>Birth Date</td>

      </tr>

    <tr >

      <td align="center" class="alt"><input name="PBI_MOBILE" type="checkbox" id="PBI_MOBILE" value="1" /></td>

      <td class="alt">Mobile No</td>

      <td align="center"><input name="PBI_RELIGION" type="checkbox" id="PBI_RELIGION" value="1" /></td>

      <td>Religion</td>

      </tr>

    <tr >

      <td align="center"><input name="ESSENTIAL_VOTER_ID" type="checkbox" id="ESSENTIAL_VOTER_ID" value="1" /></td>

      <td>National ID </td>

      <td align="center"><input name="ESSENTIAL_BLOOD_GROUP" type="checkbox" id="ESSENTIAL_BLOOD_GROUP" value="1" /></td>

      <td>Blood Group </td>

    </tr>

    <tr >

      <td align="center"><input name="PBI_EMAIL" type="checkbox" id="PBI_EMAIL" value="1" /></td>

      <td>Email </td>

      <td align="center"><input name="JOB_STATUS" type="checkbox" id="JOB_STATUS" value="1" /></td>

      <td>Job Status</td>

    </tr>

    

<tr >

<td align="center"><input name="PBI_DOMAIN" type="checkbox" id="PBI_DOMAIN" value="1" /></td>

<td>Domain</td>

<td align="center"><input name="PBI_DEPARTMENT" type="checkbox" id="PBI_DEPARTMENT" value="1" /></td>

<td>Department</td>

</tr>



<tr >

<td align="center"><input name="PBI_DOJ" type="checkbox" id="PBI_DOJ" value="1" /></td>

<td>Initial Joining Date </td>

<td align="center"><input name="PBI_DOJ_PP" type="checkbox" id="PBI_DOJ_PP" value="1" /></td>

<td>Joining Date (PP)</td>

</tr>



<tr >

  <td align="center"><input name="PBI_REGION" type="checkbox" id="PBI_REGION" value="1" /></td>

  <td>Region </td>

  <td align="center"><input name="PBI_PROJECT" type="checkbox" id="PBI_PROJECT" value="1" /></td>

  <td>Project</td>

</tr>

<tr >

  <td align="center"><input name="PBI_ZONE" type="checkbox" id="PBI_ZONE" value="1" /></td>

  <td>Zone </td>

  <td align="center"><input name="PBI_EDU_QUALIFICATION" type="checkbox" id="PBI_EDU_QUALIFICATION" value="1" /></td>

  <td>Educational Qualification</td>

</tr>

<tr >

  <td align="center"><input name="PBI_AREA" type="checkbox" id="PBI_AREA" value="1" /></td>

  <td>Area</td>

  <td align="center"><input name="PBI_BRANCH" type="checkbox" id="PBI_BRANCH" value="1" /></td>

  <td>Branch</td>

</tr>

<tr >

  <td align="center"><input name="resign_date" type="checkbox" id="resign_date" value="1" /></td>

  <td>Resign Date</td>

  <td align="center"><input name="PBI_separation_type" type="checkbox" id="PBI_separation_type" value="1" /></td>

  <td>Separation Type</td>

</tr>

<tr >

  <td align="center"><input name="PBI_SPECIALTYs" type="checkbox" id="PBI_SPECIALTYs" value="1" /></td>

  <td>Expertise</td>

  <td align="center"><input name="PBI_NATIONALITY" type="checkbox" id="PBI_NATIONALITY" value="1" /></td>

  <td>Nationality</td>

</tr>

<tr >

  <td align="center"><input name="PBI_DOC" type="checkbox" id="PBI_DOC" value="1" /></td>

  <td>Confirmation Date </td>

  <td align="center"><input name="JOB_LOCATION" type="checkbox" id="JOB_LOCATION" value="1" /></td>

  <td>Job Location </td>

</tr>

<tr >

  <td align="center"><input name="PBI_PRIMARY_JOB_STATUS" type="checkbox" id="PBI_PRIMARY_JOB_STATUS" value="1" /></td>

  <td>Initial Job Status </td>

  <td align="center"><input name="personal_file_status" type="checkbox" id="personal_file_status" value="1" /></td>

  <td>Present File Status </td>

</tr>

<tr >

  <td align="center"><input name="PBI_GARDIAN" type="checkbox" id="PBI_GARDIAN" value="1" /></td>

  <td>Gardian</td>

  <td align="center"><input name="PBI_POB" type="checkbox" id="PBI_POB" value="1" /></td>

  <td>Place of Birth (District) </td>

</tr>

<tr >

  <td align="center"><input name="PBI_SERVICE_LENGTH" type="checkbox" id="PBI_SERVICE_LENGTH" value="1" /></td>

  <td>Total Service Length </td>

  <td align="center"><input name="service_length_pp" type="checkbox" id="service_length_pp" value="1" /></td>

  <td>Service Length (PP) </td>

</tr>

<tr >

  <td align="center"><input name="PBI_RELIGION" type="checkbox" id="PBI_RELIGION" value="1" /></td>

  <td>Religion</td>

  <td align="center">&nbsp;</td>

  <td>&nbsp;</td>

</tr>

<tr >

  <td align="center">&nbsp;</td>

  <td>&nbsp;</td>

  <td align="center">&nbsp;</td>

  <td>&nbsp;</td>

</tr>

  </tbody>

</table>

<input name="submit" type="submit" id="submit" class="btn1 btn1-bg-submit" value="SHOW" />

          </div></div></div>

          </div>

    </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

            

        </div>

  </div>

</form><?php */?>

<?


require_once SERVER_CORE."routing/layout.bottom.php";

?>