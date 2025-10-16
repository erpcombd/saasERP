<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

?>

<!doctype html>

<html lang="en">

<head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>.: Employment Record Report :.</title>



    <style>

        table{

            font-size: 12px;

        }

        .form-control,.input-group-text{

            font-size: 12px!important;

        }

        .none{

            border: none;

        }



    </style>



    <script language="javascript">

        function hide()

        {

            document.getElementById('pr').style.display='none';

        }

    </script>

</head>



<body>



<section>

    <div class="container-fluid">



        <h2 align="center">

            <button type="button" class="btn btn-success" id="pr"  onclick="hide();window.print();">Print</button>

        </h2>
		
		
		
		<?  
		
		$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$_REQUEST['PBI_ID'].'"');
		
		
	
		
		?>



        <table width="100%"  style="font-size: 14px">

            <tr>

                <td style="width: 20%"> <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['group']?>.png" width="120px" height="80px" /></td>

                <td style="width: 60%" class="text-center">

                    <h3 class="m-0 p-0"><?php echo find_a_field('project_info','proj_name','1')?></h3>

                    <p class="m-0  p-0" style="letter-spacing:1px; font-weight: bold;">Quality product at affordable cost</p>

                    <p class="m-0 p-0">

                        <?php echo find_a_field('project_info','warehouse_address','1')?>

                        <strong>Cell:</strong> <?php echo find_a_field('project_info','proj_phone','1')?>.

                        <strong>Email: </strong><?php echo find_a_field('project_info','proj_email','1')?>

                        <br> <strong><?php echo find_a_field('project_info','website','1')?></strong>

                    </p>

                </td>
				

                <td style="width: 20%">
				
				 

                               <div class="col-sm-12 border border-dark" style="height: 154px; width:122px;">
							   <? if($basic->PBI_PICTURE_ATT_PATH!=""){ $ext = explode(".",$basic->PBI_PICTURE_ATT_PATH);  ?>

  <img src="../../../assets/support/upload_view.php?name=<?=$basic->PBI_PICTURE_ATT_PATH?>&folder=hrm_emp_pic&ext=<?=$ext[1]?>" width="120" height="152"/>
							
							      <? } ?>

                              

                               </div>

                           
				</td>

            </tr>

        </table>

		

		<div>

		    <p class="m-0 p-0"  style="text-align:center; font-weight:600"><strong>EMPLOYMENT RECORD</strong></p>

		</div>









        <table class="table table-bordered table-sm">

            <thead>

            <tr class="none">

                <th style="text-align: left; border: none;"><strong>Employment No: </strong><?=$basic->PBI_CODE;?></th>

                <th style="text-align: right; border: none;"><strong>Reporting Time: </strong><?=date("h:i A d-m-Y")?></th>

            </tr>

            </thead>



            <tbody class="text-center table-striped" style="font-size: 12px;">

<!-- first section -->

            <tr class="none">

               <td colspan="2" class="none">

                   <table width="100%">

                       <tr>

                           <td>

                               <div class="col-sm-12">

                                   <p style="margin: 0; padding: 0; border: 1px solid #333; border-left:none; border-right:none;" align="left"><strong>Please answer each question clearly and completely. The information will be treated as private and confidential.</strong></p>



                               </div>

							   



                               <table width="100%" class="table table-bordered table-sm">

                                   <tr>

                                       <td colspan="2" align="left" ><strong>1. Name: <?=$basic->PBI_NAME;?> </strong> </td>

                                   </tr>



                                   <tr>

                                       <td align="left" ><strong>2. Position: <?=find_a_field('designation','DESG_DESC','DESG_ID='.$basic->DESG_ID);?></strong> </td>

                                       <td align="left" ><strong>Joining Date: <?=$basic->PBI_DOJ;?></strong> </td>

                                   </tr>



                                   <tr>

                                       <td colspan="2" align="left" ><strong>3. National ID: <?=$basic->nid;?></strong> </td>

                                   </tr>



                                   <tr>

                                       <td colspan="2" align="left" ><strong>4. Father's Name: <?=$basic->PBI_FATHER_NAME;?></strong> </td>

                                   </tr>

                                   <tr>

                                       <td colspan="2" align="left" ><strong>Occupation: <?=$basic->FATHER_OCU;?></strong> </td>

                                   </tr>



                                   <tr>

                                       <td colspan="2" align="left" ><strong>5. Mother's Name: <?=$basic->PBI_MOTHER_NAME;?></strong> </td>

                                   </tr>



                                   <tr>

                                       <td colspan="2" align="left" ><strong>Occupation: <?=$basic->MATHER_OCU;?></strong> </td>

                                   </tr>





                                   <tr>

                                       <td align="left" ><strong>6. Mailing Address: <?=$basic->pre_house_no;?>,<br><?=$basic->pre_flat;?>,<br><?=$basic->pre_road_no;?>,<br><?=$basic->pre_block_no;?>,<br><?=$basic->pre_ps;?>,<br><?=$basic->pre_district;?></strong> </td>

                                       <td align="left" ><strong>7. Permanent Address: <?=$basic->par_village_name;?>,<br><?=$basic->par_po_name;?>,<br><?=$basic->par_ps;?>,<br><?=$basic->PBI_POB;?></strong> </td>

                                   </tr>







                                   <tr>

                                       <td align="left"> </td>

                                       <td align="left" ><strong>Home District: <?=$basic->PBI_POB;?></strong> </td>

                                   </tr>





                                   <tr>

                                       <td align="left" ><strong>Cell No: <?=$basic->PBI_MOBILE;?></strong> </td>

                                       <td align="left" ><strong>Tel/Cell No: <?=$basic->PBI_MOBILE;?></strong> </td>

                                   </tr>

								   

                               </table>

							   



                           </td>

                          

                       </tr>

					   

                   </table>

               </td>

            </tr>







<!-- Second section -->

           <tr class="none">

               <td colspan="2" class="none">

                   <table width="100%">

                       <tr>

                           <td>

						   

						   <div class="col-sm-12">

                                   <p style="margin: 0; padding: 0; border: 1px solid #333; border-left:none; border-right:none; border-bottom:none" align="left"></p>



                               </div>

                               <table width="100%" class="table table-bordered table-sm">

							   		



                                   <tr>

                                       <td align="left" ><strong>8. Date Of Birth: <?=$basic->PBI_DOB;?></strong> </td>

                                       <td align="left" ><strong>9. Place Of Birth: <?=$basic->PBI_POB;?></strong> </td>
									   <td align="left" > </td>

                                   </tr>



                                   <tr>

                                       <td  align="left" ><strong>10. Nationality: <?=$basic->PBI_NATIONALITY;?></strong> </td>

									   <td  align="left" ><strong>11. Religion: <?=$basic->PBI_RELIGION;?></strong> </td>

									   <td  align="left" ><strong>12. Blood Group: <?=$basic->PBI_BLOOD_GROUP;?></strong> </td>

                                   </tr>



                                   <tr>

                                       <td  align="left" ><strong>13. Sex: <?=$basic->PBI_SEX;?></strong> </td>

									   <td  align="left" ><strong>14. Marital Status: <?=$basic->PBI_MARITAL_STA;?></strong> </td>
									   <td align="left" > </td>

                                   </tr>

                                   <tr>

                                       <td colspan="3" align="left" ><strong>15. Spouse's Information (If Applicable):</strong> </td>

                                   </tr>



                                   <tr>

                                       <td align="left" ><strong>Name: <?=find_a_field('family_master','FAMILY_SPOUSE_NAME','PBI_ID="'.$_REQUEST['PBI_ID'].'"')?></strong> </td>

									   <td align="left" ><strong>Blood Group: <?=find_a_field('family_master','bg_group','PBI_ID="'.$_REQUEST['PBI_ID'].'"')?></strong> </td>
									   <td align="left" > </td>

                                   </tr>



                                   <tr>

                                       <td align="left" ><strong>Occupation: <?=find_a_field('family_master','FAMILY_SPOUSE_PROFESSION','PBI_ID="'.$_REQUEST['PBI_ID'].'"')?></strong> </td>

									   <td align="left" ><strong>Nationality: <?=find_a_field('family_master','nationality','PBI_ID="'.$_REQUEST['PBI_ID'].'"')?></strong> </td>
									   <td align="left" > </td>

                                   </tr>



                               </table>



                           </td>

                       </tr>

                   </table>

               </td>

            </tr>

			

			

			<!-- Third section -->

           <tr class="none">

               <td colspan="2" class="none">

                   <table width="100%">

                       <tr>

                           <td>

						   	<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0; border: 1px solid #333; border-left:none; border-right:none; border-bottom:none" align="left"><strong>16. Name of Dependents:(Including Parents, Spouse & Children who are dependent on you for Support):</strong></p>



                               </div>

							   

							   <!--First Table-->

                              <table width="100%" border="0" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									<tbody>

							

										<tr>

											<th>SL</th>

											<th>Name</th>

											<th>Date of Birth</th>

											<th>Relationship</th>

										</tr>

										<? 

										

										$res='select * FROM  brother_sister_detail  WHERE  PBI_ID = '.$basic->PBI_ID.'';
                                        $sl=1;

										$query = db_query($res);

										while($data=mysqli_fetch_object($query))

										{

										?>

										<tr>

										  <td valign="top"><?=$sl++;?></td>

										  <td valign="top"><?=$data->FAMILY_BS_NAME;?></td>

										  <td valign="top"><?=$data->FAMILY_CHILD_DOB;?></td>

										  <td valign="top"><?=$data->FAMILY_BS_RELATION;?></td>

										</tr>

							

										<? }?>

							

									</tbody>

								</table>
								

								

								<!--Second Table-->

								<table width="100%" border="0" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									<tbody>

							

										<tr>

											<th>SL</th>

											<th>Name of Child</th>

											<th>Education Level</th>

											<th>Blood Group</th>

										</tr>

										<? 

										
										$res='select * FROM  child_detail  WHERE  PBI_ID = '.$basic->PBI_ID.'';
                                        $sl=1;

										$query = db_query($res);

										while($data=mysqli_fetch_object($query))

										{

										?>

										<tr>

										  <td valign="top"><?=$sl++;?></td>

										  <td valign="top"><?=$data->FAMILY_CHILD_NAME;?></td>

										  <td valign="top"><?=$data->edu_level;?></td>

										  <td valign="top"><?=$data->bg_group;?></td>

										</tr>

							

										<? }?>

							

									</tbody>

								</table>

								<!-- Fourth section -->

								<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0; border: 1px solid #333; border-left:none; border-right:none; border-bottom:none" align="left"><strong>17. Have you ever been arrested, indicted or summoned into court as defendant in a criminal proceeding, or convicted, fine or imprisoned for the violation of any law (Excluding Minor Traffic violations):</strong></p>



                               </div>
							   
							   <tr>

                                       <td  align="left" ><strong><?=$basic->arrested;?></strong> </td>

                                   </tr>

                           </td>

                       </tr>

                   </table>

               </td>

            </tr>

			

			

			

			<!-- Fifth section -->

			<tr class="none">

               <td colspan="2" class="none">

                   <table width="100%">

                       <tr>

                           <td>

						   	<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0; border: 1px solid #333; border-left:none; border-right:none; border-bottom:none" align="left"><strong>18. Language Proficiency(Excellent/Good/Satisfactory/Poor/None):</strong></p>



                               </div>

							   

							   <!--First Table-->

                              <table width="100%" border="0" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									<tbody>

							

										<tr>

											<th>SL</th>

											<th>Language</th>

											<th>Spoken</th>

											<th>Written</th>

										</tr>

										<? 

										$res='select * FROM  language_master  WHERE  PBI_ID = '.$basic->PBI_ID.'';
                                        $sl=1;

										$query = db_query($res);

										while($data=mysqli_fetch_object($query))

										{

										?>

										<tr>

										  <td valign="top"><?=$sl++;?></td>

										  <td valign="top"><?=$data->LANGUAGE_NAME;?></td>

										  <td valign="top"><?=$data->FAMILY_SPOUSE_ADDRESS;?></td>

										  <td valign="top"><?=$data->nationality;?></td>

										</tr>

							

										<? }?>

							

									</tbody>

								</table>

								

								<!--second Table-->

								<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0;" align="left"><strong>19. Educational & Professional Qualifications. Give full details i.e School/College/University/Institution:</strong></p>



                               </div>

                              <table width="100%" border="1" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									<tbody>

							

										<tr>

											<th>SL</th>

											<th>Institution (Name & Place)</th>

											<th>From</th>

											<th>To</th>

											<th>Degree</th>

											<th>Div/Class/Grade</th>

											<th>Main Course of Study</th>

										</tr>

										<? 

										$res='select * FROM  hrm_education_detail  WHERE  PBI_ID = '.$basic->PBI_ID.'';
                                        $sl=1;

										$query = db_query($res);

										while($data=mysqli_fetch_object($query))

										{

										?>

										

										<tr>

										  <td valign="top"><?=$sl++;?></td>

										  <td valign="top"><?=$data->EDUCATION_NOI;?></td>

										  <td valign="top"><?=$data->EDUCATION_YEAR;?></td>

										  <td valign="top"><?=$data->EDUCATION_YEAR_TO;?></td>

										  <td valign="top"><?=$data->EDUCATION_NOE;?></td>

										  <td valign="top"><?=$data->EDUCATION_GRADE_CLASS;?></td>

										  <td valign="top"><?=$data->EDUCATION_SUBJECT;?></td>

										</tr>

							

										<? }?>

							

									</tbody>

								</table>

								

								<!--Third Table-->

								<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0;" align="left"><strong>20. If you Have any relative(s) working in Radiant, provide the following:</strong></p>



                               </div>

                              <table width="100%" border="0" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									<tbody>

							

										<tr>

											<th>SL</th>

											<th>Name</th>

											<th>Relation</th>

											<th>Unit</th>

											<th>Department</th>

											<th>Designation</th>

											<th>Location</th>

										</tr>

										<? 

										$res='select * FROM  relative_detail  WHERE  PBI_ID = '.$basic->PBI_ID.'';
                                        $sl=1;

										$query = db_query($res);

										while($data=mysqli_fetch_object($query))

										{

										?>

										<tr>

										  <td valign="top"><?=$sl++;?></td>

										  <td valign="top"><?=$data->RELATIVE_NAME;?></td>

										  <td valign="top"><?=$data->RELATIVE_RELATION;?></td>

										  <td valign="top"><?=$data->RELATIVE_ID;?></td>

										  <td valign="top"><?=$data->RELATIVE_DEPARTMENT;?></td>

										  <td valign="top"><?=$data->RELATIVE_DESIGNATION;?></td>

										  <td valign="top"><?=$data->RELATIVE_LOCATION;?></td>

										</tr>

							

										<? }?>

							

									</tbody>

								</table>

								

								<!--fourth Table-->

								<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0;" align="left"><strong>21. Professional Membership(if any):</strong></p>



                               </div>

                              <table width="100%" border="0" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									<tbody>

							

										<tr>

											<th>SL</th>

											<th>Name</th>

										</tr>

										<? 


										$res='select * FROM  membership_master  WHERE  PBI_ID = '.$basic->PBI_ID.'';
                                        $sl=1;

										$query = db_query($res);

										while($data=mysqli_fetch_object($query))

										{

										?>

										<tr>

										  <td valign="top"><?=$sl++;?></td>

										  <td valign="top"><?=$data->MEMBERSHIP;?></td>

										</tr>

							

										<? }?>

							

									</tbody>

								</table>

								

								

								<!--fifth Table-->

								<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0;" align="left"><strong>22. Other Qualifications (Course attended, training received or certificates obtained - not less than 7 days):</strong></p>



                               </div>

                              <table width="100%" border="0" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									<tbody>

							

										<tr>

											<th>SL</th>

											<th>From</th>

											<th>To</th>

											<th>Course Attended</th>

											<th>Institute</th>

											<th>Country</th>

										</tr>

										<? 

										
										$res='select * FROM  hrm_course_diploma_detail  WHERE  PBI_ID = '.$basic->PBI_ID.'';
                                        $sl=1;

										$query = db_query($res);

										while($data=mysqli_fetch_object($query))

										{

										?>

										<tr>

										  <td valign="top"><?=$sl++;?></td>

										  <td valign="top"><?=$data->start_from;?></td>

										  <td valign="top"><?=$data->date_to;?></td>

										  <td valign="top"><?=$data->CD_NOCD;?></td>

										  <td valign="top"><?=$data->CD_NOI;?></td>

										  <td valign="top"></td>

										</tr>

							

										<? }?>

							

									</tbody>

								</table>

								

								

								<!--sixth Table-->

								<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0;" align="left"><strong>23. Employment Record (Start with your present job first):</strong></p>



                               </div>

                              <table width="100%" border="0" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									<tbody>

							

										<tr>

											<th>SL</th>

											<th>From</th>

											<th>To</th>

											<th>Name & Address of Employer</th>

											<th>Last Salary Drawn</th>

											<th>Job Title and Duties</th>

											<th>Reason for Leaving</th>

										</tr>

										<? 

										$res='select * FROM  hrm_experience_detail  WHERE  PBI_ID = '.$basic->PBI_ID.'';
                                        $sl=1;

										$query = db_query($res);

										while($data=mysqli_fetch_object($query))

										{

										?>

										<tr>

										  <td valign="top"><?=$sl++;?></td>

										  <td valign="top"><?=$data->EXPERIENCE_FROM;?></td>

										  <td valign="top"><?=$data->EXPERIENCE_TO;?></td>

										  <td valign="top"><?=$data->EXPERIENCE_NOO;?></td>

										  <td valign="top"><?=$data->last_sallary;?></td>

										  <td valign="top"><?=$data->EXPERIENCE_POST;?></td>

										  <td valign="top"><?=$data->leave_reason;?></td>

										</tr>

							

										<? }?>

							

									</tbody>

								</table>

								

								

								<!--seventh Table-->

								<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0;" align="left"><strong>24. Are you suffering/had suffered from any chronic/serious illness? (YES/NO) If YES, Give Details:</strong></p>



                               </div>
							   
							   <tr>

                                       <td  align="left" ><strong><?=$basic->medical;?></strong> </td>

                                   </tr>
							   

                              <table width="100%" border="0" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									

								</table>

								

								<!--eighth Table-->

								<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0;" align="left"><strong>25. Hobbies & Interests:</strong></p>



                               </div>

                              <table width="100%" border="0" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									<tbody>

							

										<tr>

											<th>SL</th>

											<th>Name</th>

										</tr>

										<? 

										$res='select * FROM  hobbies_master  WHERE  PBI_ID = '.$basic->PBI_ID.'';
                                        $sl=1;

										$query = db_query($res);

										while($data=mysqli_fetch_object($query))

										{

										?>

										<tr>

										  <td valign="top"><?=$sl++;?></td>

										  <td valign="top"><?=$data->HOBBIES;?></td>

										</tr>

							

										<? }?>

							

									</tbody>

								</table>

								

								

								<!--ninth Table-->

								<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0;" align="left"><strong>26. Special Skills:</strong></p>



                               </div>

                              <table width="100%" border="0" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									<tbody>

							

										<tr>

											<th>SL</th>

											<th>Name</th>

										</tr>

										<? 

										$res='select * FROM  skills_master  WHERE  PBI_ID = '.$basic->PBI_ID.'';
                                        $sl=1;

										$query = db_query($res);

										while($data=mysqli_fetch_object($query))

										{

										?>

										<tr>

										  <td valign="top"><?=$sl++;?></td>

										  <td valign="top"><?=$data->SKILLS;?></td>

										</tr>

							

										<? }?>

							

									</tbody>

								</table>

								

								

								<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0;" align="left"><strong>27. Have you ever been dismissed or terminated from any employment? (YES/NO) If YES, Give Details:</strong></p>
                               </div>
							   
							   		<tr>

                                       <td  align="left" colspan="2"><strong><?=$basic->dismissed;?></strong> </td>

                                   </tr>

                              <table width="100%" border="0" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									

								</table>

								

								<!--eleventh Table-->

								<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0;" align="left"><strong>28. Reference: List two persons not related to you, who are familliar with your character, qualifications and competence, whom the company may contact at any time:</strong></p>



                               </div>

                              <table width="100%" border="0" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									<tbody>

							

										<tr>

											<th>SL</th>

											<th>Name</th>

											<th>Occupation</th>

											<th>Address</th>

											<th>Tel No</th>

										</tr>

										<? 

										$res='select * FROM  reference_person  WHERE  PBI_ID = '.$basic->PBI_ID.'';
                                        $sl=1;

										$query = db_query($res);

										while($data=mysqli_fetch_object($query))

										{

										?>

										<tr>

										  <td valign="top"><?=$sl++;?></td>

										  <td valign="top"><?=$data->RPERSON_F_NAME;?></td>

										  <td valign="top"><?=$data->RPERSON_F_PROFESSION;?></td>

										  <td valign="top"><?=$data->RPERSON_F_WORKING_LOCATION;?></td>

										  <td valign="top"><?=$data->RPERSON_F_PHONE;?></td>

										</tr>

							

										<? }?>

							

									</tbody>

								</table>

								

								

								<!--twelvth Table-->

								<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0;" align="left"><strong>29. Contact Persons:</strong></p>



                               </div>

                              <table width="100%" border="0" cellpadding="2" cellspacing="0" class="table table-bordered table-sm">

		

								<thead>

									<tbody>

							

										<tr>

											<th>SL</th>

											<th>Name</th>

											<th>Relationship</th>

											<th>Address</th>

											<th>Tel No</th>

										</tr>

										<? 

										$res='select * FROM  guardian  WHERE  PBI_ID = '.$basic->PBI_ID.'';
                                        $sl=1;

										$query = db_query($res);

										while($data=mysqli_fetch_object($query))

										{

										?>

										<tr>

										  <td valign="top"><?=$sl++;?></td>

										  <td valign="top"><?=$data->GUARDIAN_NAME;?></td>

										  <td valign="top"><?=$data->GUARDIAN_RELATION;?></td>

										  <td valign="top"><?=$data->GUARDIAN_PRESENT_ADDRESS;?></td>

										  <td valign="top"><?=$data->GUARDIAN_PHONE;?></td>

										</tr>

							

										<? }?>

							

									</tbody>

								</table>

								

                           </td>

                       </tr>

                   </table>

               </td>

            </tr>

			

			

			

			<!-- sixth section -->

           <tr class="none">

               <td colspan="2" class="none">

                   <table width="100%">

                       <tr>

                           <td>

						   

						   		<div class="col-sm-12">

                                   <p style="margin: 0; padding: 0; " align="center"><strong>DECLARATION</strong></p>



                               </div>

							   

							   <div class="col-sm-12">

                                   <p style="margin: 0; padding: 0; " align="left"><strong>I <?=$basic->PBI_NAME;?> hereby declare that,</strong></p>



                               </div>

							   <br>

							   

							   <div class="col-sm-12">

                                   <p style="margin: 0; padding: 0; " align="left"><strong>1. The perticulars furnished in this applications are accurate and complete to my knowledge and belief and have not knowingly withheld any information, which, if disclosed, would affect my application unfavourably.</strong></p>



                               </div>

							   <br>

							   

							   <div class="col-sm-12">

                                   <p style="margin: 0; padding: 0;" align="left"><strong>2. I shall be deemed to have been guilty of gross default, misconduct in the event of my appointment with Radiant if at any future date it is found that my declaration as above is false or materially incorrect in any respect and in that case my service with the company will be liable to be terminated without notice or payment of benefit whatsoever.</strong></p>



                               </div>

							   <br>

							   

							   

							   <div class="col-sm-12">

                                   <p style="margin: 0; padding: 0;" align="left"><strong>3. In the event of my being selected for employment with Radiant, I agree to abide by the rules and regulations of the company which may be in force from time to time.</strong></p>



                               </div>

                               



                           </td>

                       </tr>

                   </table>
				   <br>
				   <table width="100%" >
				   		<tr>
                            <td align="left" ><strong>Signature :</strong> </td>
                       </tr>
					   
					   <tr>
                            <td align="left" ><strong>Date :</strong></td>
                       </tr>
					   
				   </table>

               </td>

            </tr>

			

		



            </tbody>

        </table>

    </div>







</section>



<!-- Option 1: Bootstrap Bundle with Popper -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>