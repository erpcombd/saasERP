<?php



//



//



require "../../config/inc.all.php";







// ::::: Edit This Section ::::: 



$title='Basic Information';		// Page Name and Page Title



$page="basic_list.php";		// PHP File Name

$page_name = 'view_profile';

$input_page="employee_basic_information_input.php";



$root='admin';







$table='personnel_basic_info';		// Database Table Name Mainly related to this page



$unique='PBI_ID';			// Primary Key of this Database table



$shown='PBI_FATHER_NAME';	







do_calander('#PBI_DUE_DOJ');



do_calander('#PBI_DOB');



do_calander('#PBI_DOJ_PP');



do_calander('#PBI_DOC');



do_calander('#PBI_DOC2');



do_calander('#PBI_DOJ');



do_calander('#PBI_APPOINTMENT_LETTER_DATE');



do_calander('#JOB_STATUS_DATE');







// ::::: End Edit Section :::::







$crud      =new crud($table);


$member = $_SESSION['employee_selected'];

$data = find_all_field('personnel_basic_info','','PBI_ID='.$member);

$required_id=find_a_field($table,$unique,'PBI_ID='.$member);



if($required_id>0)



$$unique = $_GET[$unique] = $required_id;



$required_id=find_a_field($table,$unique,'PBI_ID='.$member);



if($required_id>0)



$$unique = $_GET[$unique] = $required_id;



else



$$unique = $member=$_POST['employee_selected'];



	//for Modify..................................




if(isset($$unique))



{



$condition=$unique."=".$$unique;



$data=db_fetch_object($table,$condition);



foreach ($data as $key => $value)



{ $$key=$value;}



}





     $interval = date_diff(date_create($_POST['PBI_DOJ']), date_create(date('Y-m-d')));

       $interval->format("%Y Year, %M Months, %d Days");

         $total_service_days_current_date = $interval->format('%a');

//pic
$staff_jpg = "../../../hrm_mod/pic/staff/".$_SESSION['employee_selected'].".jpg";
$staff_png = "../../../hrm_mod/pic/staff/".$_SESSION['employee_selected'].".png";
$staff_jpeg = "../../../hrm_mod/pic/staff/".$_SESSION['employee_selected'].".jpeg";
$staff_PNG1 = "../../../hrm_mod/pic/staff/".$_SESSION['employee_selected'].".PNG";
if(file_exists($staff_jpg)){
$staff_pic = $staff_jpg;
}elseif(file_exists($staff_png)){
$staff_pic = $staff_png;
}elseif(file_exists($staff_jpeg)){
$staff_pic = $staff_jpeg;
}elseif(file_exists($staff_PNG1)){
$staff_pic = $staff_PNG1;
}

//nid
$nid_jpg = "../../../hrm_mod/pic/nid/".$_SESSION['employee_selected'].".jpg";
$nid_png = "../../../hrm_mod/pic/nid/".$_SESSION['employee_selected'].".png";
$nid_jpeg = "../../../hrm_mod/pic/nid/".$_SESSION['employee_selected'].".jpeg";
$nid_PNG1 = "../../../hrm_mod/pic/nid/".$_SESSION['employee_selected'].".PNG";
$nid_pdf = "../../../hrm_mod/pic/nid/".$_SESSION['employee_selected'].".pdf";
if(file_exists($nid_jpg)){
$nid_att = $nid_jpg;
}elseif(file_exists($nid_png)){
$nid_att = $nid_png;
}elseif(file_exists($nid_jpeg)){
$nid_att = $nid_jpeg;
}elseif(file_exists($nid_PNG1)){
$nid_att = $nid_PNG1;
}elseif(file_exists($nid_pdf)){
$nid_att = $nid_pdf;
}

//tin
$tin_jpg = "../../../hrm_mod/pic/tin/".$_SESSION['employee_selected'].".jpg";
$tin_png = "../../../hrm_mod/pic/tin/".$_SESSION['employee_selected'].".png";
$tin_jpeg = "../../../hrm_mod/pic/tin/".$_SESSION['employee_selected'].".jpeg";
$tin_PNG1 = "../../../hrm_mod/pic/tin/".$_SESSION['employee_selected'].".PNG";
$tin_pdf = "../../../hrm_mod/pic/tin/".$_SESSION['employee_selected'].".pdf";
if(file_exists($tin_jpg)){
$tin_att = $tin_jpg;
}elseif(file_exists($tin_png)){
$tin_att = $tin_png;
}elseif(file_exists($tin_jpeg)){
$tin_att = $tin_jpeg;
}elseif(file_exists($tin_PNG1)){
$tin_att = $tin_PNG1;
}elseif(file_exists($tin_pdf)){
$tin_att = $tin_pdf;
}

//signature
$signature_jpg = "../../../hrm_mod/pic/signature/".$_SESSION['employee_selected'].".jpg";
$signature_png = "../../../hrm_mod/pic/signature/".$_SESSION['employee_selected'].".png";
$signature_jpeg = "../../../hrm_mod/pic/signature/".$_SESSION['employee_selected'].".jpeg";
$signature_PNG1 = "../../../hrm_mod/pic/signature/".$_SESSION['employee_selected'].".PNG";
if(file_exists($signature_jpg)){
$signature_att = $signature_jpg;
}elseif(file_exists($signature_png)){
$signature_att = $signature_png;
}elseif(file_exists($signature_jpeg)){
$signature_att = $signature_jpeg;
}elseif(file_exists($signature_PNG1)){
$signature_att = $signature_PNG1;
}

?>



    <script type="text/javascript">



        function DoNav(lk) {



            return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>=' + lk, 600, 940)



        }







        function add_date(cd) {



            var arr = cd.split('-');



            var mon = (arr[1] * 1) + 6;



            var day = (arr[2] * 1);



            var yr = (arr[0] * 1);



            if (mon > 12) {



                mon = mon - 12;



                yr = yr + 1;



            }



            var con_date = yr + '-' + mon + '-' + day;



            document.getElementById('PBI_DOC').value = con_date;



        }

    </script>

	

	<script>

	   

	   function changeDate(){

	   

	     var due_date = document.getElementById('PBI_CON_TYPE').value;

		 var pbi_doj = document.getElementById('PBI_DOJ').value;

		 var service_days = document.getElementById('service_days_current_date').value;

		 

		 

		 

//const date1 = new Date('7/1/2015');

//const date2 = new Date(pbi_doj);

//const diffTime = Math.abs(date2 - date1);

//const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

//alert(diffDays);

		

		 

		 

	  	Date.prototype.addDays = function(days) {

        var date = new Date(this.valueOf());

        date.setDate(date.getDate() + days);

        return date;

       }



       const date = new Date(pbi_doj);



       //alert(date);



		function convert(str) {

  var date = new Date(str),

    mnth = ("0" + (date.getMonth() + 1)).slice(-2),

    day = ("0" + date.getDate()).slice(-2);

  return [date.getFullYear(), mnth, day].join("-");

}



//console.log(convert("Thu Jun 09 2011 00:00:00 GMT+0530 (India Standard Time)"))

//alert(convert(date.addDays(18)));



if(due_date==3){

		    

			 new_days = 92;

		   

		 }else if(due_date==6){

		    

			new_days = 183;

			

		 }

		 //var actual_days = new_days-service_days;

document.getElementById('PBI_DUE_DOJ').value = convert(date.addDays(new_days));





		

	   

	   }

	   

	  // window.onload = changeDate;

	

	</script>



    <style type="text/css">



        <!-- .'' {



            color: #FF0000



        }



        



        -->

		

		input::-webkit-outer-spin-button,

input::-webkit-inner-spin-button {

    /* display: none; <- Crashes Chrome on hover */

    -webkit-appearance: none;

    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */

}



input[type=number] {

    -moz-appearance:textfield; /* Firefox */

}



    </style>







    



        <div class="oe_view_manager oe_view_manager_current">







            <? //include('../../common/title_bar.php');?>

<form action="" method="post" enctype="multipart/form-data"  name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}" >

                <div class="oe_view_manager_body">







                    <div class="oe_view_manager_view_list"></div>







                    <div class="oe_view_manager_view_form">



                        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">



                            <div class="oe_form_buttons"></div>



                            <div class="oe_form_sidebar"></div>



                            <div class="oe_form_pager"></div>



                            <div class="oe_form_container">



                                <div class="oe_form">

                                <div align="center"> <?=$msg;?></div>

                                    <div class="">



                                        <? //include('../../common/input_bar_basic.php');?>

										



                                            <div>



                                                <div>



                                                    <table class="table table-bordered" width="100%">



                                                        <tbody>



                                                            <tr class="oe_form_group_row">



                                                                <td colspan="1" class="oe_form_group_cell" width="100%">



                                                                    <table  class="table  oe_form_group " width="100%">



                                                                        <tbody>



                                                                            <tr class="oe_form_group_row">



                                                                              <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<strong>Employee ID</strong></td>



                                                                              <td colspan="2" class="oe_form_group_cell"><?=$PBI_CODE?></td>



                                                                              <td class="oe_form_group_cell ''">&nbsp;</td>



                                                                              <td class="oe_form_group_cell"><span class="oe_form_group_cell ''"><strong>Concern</strong></span></td>



                                                                              <td class="oe_form_group_cell">
                                                                                <?=find_a_field('user_group','group_name','id="'.$PBI_ORG.'"');?>                                                                              </td>
                                                                            </tr>



                                                                            <tr class="oe_form_group_row">



                                                                                <td  width="260" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong></td>



                                                                                <td colspan="2" class="oe_form_group_cell">



                                                                                    <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

																					

												<input name="PBI_ID2" id="PBI_ID2" value="<?=(!isset($$unique))?(find_a_field('personnel_basic_info','max(PBI_ID)','1')+1):$$unique;?>" type="hidden" class="''" readonly/>



                                                                                    <? //$PBI_ID?>                                                                       </td>



                                                                                <td  width="146" class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  width="239" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label"><span class="''"><!--Business Unit :--></span></span><span class="''">Department:</span></strong></td>



                                                                                <td  width="341" class="oe_form_group_cell">



                                                                                    <!--<select name="JOB_LOCATION" id="JOB_LOCATION"  class="form-control" >



																					



                                                                                        <? foreign_relation('business_unit','id','unit_name',$JOB_LOCATION,' 1');?>
                                                                                    </select>-->                                                                                
                                                                                      <?=find_a_field('department','DEPT_DESC','DEPT_ID='.$PBI_DEPARTMENT);?>                                                                                   </td>
                                                                            </tr>



                                                                            <tr class="oe_form_group_row">



                                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>



                    <label>&nbsp;&nbsp;<span class="">Name :</span></label>



                  </strong></td>



                                                                                <td colspan="2" class="oe_form_group_cell">



                                                                                    <?=$PBI_NAME?>                                                                      </td>



                                                                                <td  class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  class="oe_form_group_cell"><strong><span class="''">Sub Department:</span></strong></td>



                                                                                <td  class="oe_form_group_cell">
                                                                                  <?=find_a_field('sub_department','SUB_DEPT_DESC','SUB_DEPT_ID='.$PBI_SUB_DEPARTMENT);?>                                                                               </td>
                                                                            </tr>

																			


                                                                            <tr class="oe_form_group_row">



                                                                                <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label ''"><strong>&nbsp;&nbsp;Father's Name : </strong></td>



                                                                                <td colspan="2"  class="oe_form_group_cell">







                                                                                   <?=$PBI_FATHER_NAME?> </td>



                                                                                <td  class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label"><span class="''">Blood Group :</span></span></strong></td>



                                                                                <td  class="oe_form_group_cell">


<?=$BLOOD_GROUP?>                                                                            </td>
                                                                            </tr>



                                                                            <tr class="oe_form_group_row">



                                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label ''"><strong>&nbsp;&nbsp;Mother's Name :</strong></td>



                                                                                <td colspan="2" class="oe_form_group_cell">



                                                                                    <?=$PBI_MOTHER_NAME?>                                                                               </td>



                                                                                <td  class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  class="oe_form_group_cell"><strong>Employee Type </strong></td>



                                                                                <td  class="oe_form_group_cell">



																				<?=$EMPLOYMENT_TYPE?>																				</td>
                                                                            </tr>



                                                                            <tr class="oe_form_group_row">



                                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label ''"><strong>&nbsp;&nbsp;Designation :</strong></td>



                                                                                <td width="237"  class="oe_form_group_cell">



                                                                                  
                                                                                        <?=find_a_field('designation','DESG_DESC','DESG_ID="'.$PBI_DESIGNATION.'"');?>                                                                                                                                                            </td>



                                                                                <td width="41"  class="oe_form_group_cell">



                                                                                                                                                                </td>



                                                                                <td  class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">Service Length:<br />



                  </span></strong></td>



                                                                              <td  class="oe_form_group_cell"><? 



echo $servicel=find_a_field('personnel_basic_info','CONCAT( TIMESTAMPDIFF(YEAR, PBI_DOJ, CURDATE())," Year, ",TIMESTAMPDIFF(MONTH, PBI_DOJ, CURDATE()) % 12," mon ")','1 and PBI_ID=" '.$PBI_ID.' "');



?></td>
                                                                            </tr>



                                                                            <tr class="oe_form_group_row">



                                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label ''"><strong>&nbsp;&nbsp;Date of Birth :</strong></td>



                                                                                <td colspan="2" class="oe_form_group_cell">



                                                                                    <?=$PBI_DOB?>                                                                          </td>



                                                                                <td class="oe_form_group_cell">&nbsp;</td>



                                                                                <td class="oe_form_group_cell"><strong>Due Confirm Date </strong></td>



                                                                              <td class="oe_form_group_cell">

                                                                                

																			  <?=$PBI_DUE_DOJ?>																  </td>
                                                                            </tr>



                                                                            <tr class="oe_form_group_row">



                                                                                <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Place of Birth (District) :</strong></td>



                                                                                <td colspan="2"  class="oe_form_group_cell">




                                                                                        <?=$PBI_POB?>                                                                                                                                                             </td>



                                                                                <td  class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">Marital Status :</span></strong></td>



                                                                                <td  class="oe_form_group_cell">
                                                                                  <?=$PBI_MARITAL_STA?>                                                                                 </td>
                                                                            </tr>



                                                                            <tr class="oe_form_group_row">



                                                                                <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;<span class="''">Joining Date :</span></strong></td>



                                                                                <td colspan="2" bgcolor="#FFFFFF" class="oe_form_group_cell">



                                                                                   <?=$PBI_DOJ?>   </td>



                                                                                <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;</td>



                                                                                <td bgcolor="#FFFFFF" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">Nationality : </span></strong></td>







                                                                                <td bgcolor="#FFFFFF" class="oe_form_group_cell">
                                                                                  <?=$PBI_NATIONALITY?>                                                                                  </td>
                                                                            </tr>







                                                                            <tr class="oe_form_group_row">



                                                                                <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Confirm Duration:</strong></td>







                                                                                <td colspan="2"  class="oe_form_group_cell">



                                                                                    <?=$PBI_CON_TYPE?>
                                                                                <td  class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label"><span class="''">Job Status :</span></span></strong></td>



                                                                                <td  class="oe_form_group_cell">
																				 <?=$PBI_JOB_STATUS?></td>
                                                                            </tr>



                                                                            <tr class="oe_form_group_row">



                                                                                <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Confirm Date :</strong></td>



                                                                                <td colspan="2" bgcolor="#FFFFFF" class="oe_form_group_cell"><?=$PBI_DOC2?></td>



                                                                                <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;</td>



                                                                                <td bgcolor="#FFFFFF" class="oe_form_group_cell"><strong>Resign Type :</strong></td>



                                                                                <td bgcolor="#FFFFFF" class="oe_form_group_cell"><?=$resign_typ?></td>
                                                                            </tr>



                                                                            <tr class="oe_form_group_row">



                                                                                <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;<span class="''">Gender :</span></strong></td>



                                                                                <td colspan="2"  class="oe_form_group_cell">

                                                                                  <?=$PBI_SEX?>                                                                                 </td>



                                                                                <td  class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  class="oe_form_group_cell"><strong>Job Status Date :</strong></td>



                                                                                <td  class="oe_form_group_cell"><?=$JOB_STATUS_DATE?></td>
                                                                            </tr>



                                                                            <!--                <tr class="oe_form_group_row">



                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp; Joining Date(PP):</strong></td>



                  <td colspan="2" class="oe_form_group_cell"><input name="PBI_DOJ_PP" type="text" id="PBI_DOJ_PP" value="<?=$PBI_DOJ_PP?>" /></td>



                  <td class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Service Length (PP) :</span></strong></td>



                  <td class="oe_form_group_cell"><input name="PBI_SERVICE_LENGTH_PP" type="text" id="PBI_SERVICE_LENGTH_PP" value="<?=$PBI_SERVICE_LENGTH_PP?>" /></td>



                </tr>-->



                                                                            <!--<tr class="oe_form_group_row">



                  <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp; Appointment Letter :</strong></td>




                  <td colspan="2"  class="oe_form_group_cell"><input name="PBI_APPOINTMENT_LETTER_NO" type="text" id="PBI_APPOINTMENT_LETTER_NO" value="<?=$PBI_APPOINTMENT_LETTER_NO?>" /></td>



                  <td  class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Appointment Date :</span></strong></td>



                  <td  class="oe_form_group_cell"><input name="PBI_APPOINTMENT_LETTER_DATE" type="text" id="PBI_APPOINTMENT_LETTER_DATE" value="<?=$PBI_APPOINTMENT_LETTER_DATE?>" /></td>



</tr>-->







                                                                            <tr class="oe_form_group_row">



                                                                                <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Religion : </strong></td>



                                                                                <td colspan="2" bgcolor="#FFFFFF" class="oe_form_group_cell">
                                                                                  <?=$PBI_RELIGION?>                                                                                 </td>



                                                                                <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;</td>



                                                                                <td bgcolor="#FFFFFF" class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">Note:</span></strong></td>



                                                                                <td bgcolor="#FFFFFF" class="oe_form_group_cell"><?=$note?></td>
                                                                            </tr>
																			
																			<tr class="oe_form_group_row">
																			<td bgcolor="#FFFFFF" class="oe_form_group_cell"> <strong><span class="''">&nbsp;&nbsp;Job Description</span></strong></td>
                                                                              <td colspan="5" class="oe_form_group_cell oe_form_group_cell_label"><?=$PBI_JOB_DESCRIPTION?></td>
                                                                            </tr>


                                                                          <!--Education Start-->
                                                                            <tr class="oe_form_group_row" bgcolor="#3399CC">
																			  
                                                                              <td colspan="6" class="oe_form_group_cell oe_form_group_cell_label"><div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold;">Education</div></td>
                                                                            </tr>
                                                                            
                                                                            
																			 
                                                                            	
								
								<?
								  $ss = 'select * from education_detail where PBI_ID='.$member;
								  $query = db_query($ss);
								  while($data = mysqli_fetch_object($query)){
								  
								?>
                                
                                 <tr class="oe_form_group_row">
                                  <td colspan="6" bgcolor="#CCCCCC" class="oe_form_group_cell oe_form_group_cell_label"><strong>:: Degree(<?=++$i?>) :: </strong></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>Education Qualification</td>
                                  <td bgcolor="#FFFFFF" colspan="2" class="oe_form_group_cell"> <?=$data->EDUCATION_NOE;?></td>           <td>&nbsp;</td>
									<td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;&nbsp;Passing year :</td>
                                    <td bgcolor="#FFFFFF" class="oe_form_group_cell"><?=$data->EDUCATION_YEAR?></td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>University/Board :</td>
                                  <td  colspan="2" class="oe_form_group_cell"><?=$data->EDUCATION_BU?></td>
								  <td>&nbsp;</td>
                                  <td  class="oe_form_group_cell">&nbsp;&nbsp;Grade/Class</td>
                                  <td  class="oe_form_group_cell"><?=$data->EDUCATION_GRADE_CLASS?></td>
                                </tr>
								
								<tr class="oe_form_group_row">
								  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Subject</td>
								  <td  colspan="2" class="oe_form_group_cell"><?=$data->EDUCATION_SUBJECT;?></td>
								  <td  class="oe_form_group_cell">&nbsp;</td>
								  <td  class="oe_form_group_cell">GPA :</td>
								  <td  class="oe_form_group_cell"><?=$data->EDUCATION_GPA?></td>
								  </tr>
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong><strong>&nbsp;&nbsp;Document</strong></strong></td>
                                  <td  colspan="2" class="oe_form_group_cell"><?
								    $edu_loc = '../../pic/education/'.$data->EDUCATION_D_ID.'.pdf';
									if(file_exists($edu_loc)){
								  ?>
								  <a href="<?=$edu_loc?>" target="_blank" class="form-control">Download Document</a>
								   <? } ?>	</td>
								  <td  class="oe_form_group_cell">								  							  </td>
								  
                                  <td  class="oe_form_group_cell"></td>
                                  <td  class="oe_form_group_cell"></td>
                                </tr>
								
								<? } ?>
								<tr class="oe_form_group_row">
                                 <td colspan="6"  class="oe_form_group_cell oe_form_group_cell_label"></td></tr>
                                                                            <!--Education Start-->
																			
																			 <!--Experience Start-->
                                                                            <tr class="oe_form_group_row" bgcolor="#3399CC">
                                                                              <td colspan="6" class="oe_form_group_cell oe_form_group_cell_label"><div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold;">Experience</div></td>
                                                                            </tr>
                                                                            
                                                                            
																			 
                                                                            	
								
								<?
								  $ss = 'select * from experience_detail where PBI_ID='.$member;
								  $query = db_query($ss);
								  while($data = mysqli_fetch_object($query)){
								  
								?>
                                
                                 <tr class="oe_form_group_row">
                                  <td colspan="6" bgcolor="#CCCCCC" class="oe_form_group_cell oe_form_group_cell_label"><strong>:: Experience(<?=++$s?>) :: </strong></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>Organization Name </td>
                                  <td bgcolor="#FFFFFF" colspan="2" class="oe_form_group_cell"><?=$data->EXPERIENCE_NOO;?>                  </td>           <td>&nbsp;</td>
									<td bgcolor="#FFFFFF" class="oe_form_group_cell"><strong>Post </strong> :</td>
                                    <td bgcolor="#FFFFFF" class="oe_form_group_cell"><?=$data->EXPERIENCE_POST?></td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>From :</td>
                                  <td  colspan="2" class="oe_form_group_cell"><?=$data->EXPERIENCE_FROM?></td>
								  <td>&nbsp;</td>
                                  <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">To</span> : </td>
                                  <td  class="oe_form_group_cell"><?=$data->EXPERIENCE_TO?></td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;<strong>&nbsp;&nbsp;</strong>Last Salary :</strong></td>
                                  <td  colspan="2" class="oe_form_group_cell"><?=$data->LAST_SALARY;?></td>
								  <td  class="oe_form_group_cell">
								  <?
								    $loc = '../../pic/experience/'.$data->EXPERIENCE_DETAIL_ID.'.pdf';
									if(file_exists($loc)){
								  ?>
								  <a href="<?=$loc?>" target="_blank" class="form-control">Document</a>
								   <? } ?>								  </td>
								  
                                  <td  class="oe_form_group_cell"><? if($user->member_info_edit==1){?>
                                                                        <? } ?></td>
                                  <td  class="oe_form_group_cell"><? if($user->member_info_edit==1){?><a href="../?dela=<?=$data->EXPERIENCE_DETAIL_ID?>"></a><? } ?></td>
                                </tr>
								
								<? } ?>
								<tr class="oe_form_group_row">
                                 <td colspan="6"  class="oe_form_group_cell oe_form_group_cell_label"></td></tr>
                                                                            <!--Experience Start-->
																			
																			<!--Course/Diploma Start-->
                                                                            <tr class="oe_form_group_row" bgcolor="#3399CC">
                                                                              <td colspan="6" class="oe_form_group_cell oe_form_group_cell_label"><div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold;">Course/Training</div></td>
                                                                            </tr>
                                                                            
                                                                            
																			 
                                                                            	
								
								<?
								  $ss = 'select * from course_diploma_detail where PBI_ID='.$member;
								  $query = db_query($ss);
								  while($data = mysqli_fetch_object($query)){
								  
								?>
                                
                                 <tr class="oe_form_group_row">
                                  <td colspan="6" bgcolor="#CCCCCC" class="oe_form_group_cell oe_form_group_cell_label"><strong>:: Course(<?=++$k?>) :: </strong></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>Name of Course/Diploma:</td>
                                  <td bgcolor="#FFFFFF" colspan="2" class="oe_form_group_cell"><?=$data->CD_NOCD;?>                   </td>           <td>&nbsp;</td>
									<td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;&nbsp;Passing year :</td>
                                    <td bgcolor="#FFFFFF" class="oe_form_group_cell"><?=$data->CD_PASSING_YEAR?></td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>Subject :  :</td>
                                  <td  colspan="2" class="oe_form_group_cell"><?=$data->CD_SUBJECT?></td>
								  <td>&nbsp;</td>
                                  <td  class="oe_form_group_cell">&nbsp;&nbsp;Grade/Class</td>
                                  <td  class="oe_form_group_cell"><?=$data->CD_GRADE_CLASS?></td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong><strong>&nbsp;&nbsp;</strong>Duration :</strong></td>
                                  <td  colspan="2" class="oe_form_group_cell"><?=$data->CD_DURATION?></td>
								  <td  class="oe_form_group_cell">
								  <?
								    $c_loc = '../../pic/course/'.$data->CD_D_ID.'.pdf';
									if(file_exists($c_loc)){
								  ?>
								  <a href="<?=$c_loc?>" target="_blank" class="form-control">Document</a>
								   <? } ?>								  </td>
								  
                                  <td  class="oe_form_group_cell"><? if($user->member_info_edit==1){?><? } ?></td>
                                  <td  class="oe_form_group_cell"><? if($user->member_info_edit==1){?><a href="../?delc=<?=$data->CD_D_ID?>"></a><? } ?></td>
                                </tr>
								
								<? } ?>
								<tr class="oe_form_group_row">
                                 <td colspan="6"  class="oe_form_group_cell oe_form_group_cell_label"></td></tr>
                                                                            <!--Course/Diploma Start-->
																			
																			
                                                                            <tr class="oe_form_group_row" bgcolor="#3399CC">
                                                                              <td colspan="6" class="oe_form_group_cell oe_form_group_cell_label"><div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold;">Salary Part</div></td>
                                                                            </tr>
                                                                            
                                                                            
																			 
                                                                            	
								
								<?
								  //$ss = 'select * from salary_info where PBI_ID='.$member;
								  $ss = 'select * from salary_info where PBI_ID=5555555555555';
								  $query = db_query($ss);
								  $data = mysqli_fetch_object($query);
								  
								?>
                                
                                 
                                <tr class="oe_form_group_row">
                                  <td colspan="1" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>Gross</td>
                                  <td bgcolor="#FFFFFF" colspan="2" class="oe_form_group_cell"><?=$data->gross_salary;?>                   </td>           <td>&nbsp;</td>
									<td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;&nbsp;Basic :</td>
                                    <td bgcolor="#FFFFFF" class="oe_form_group_cell"><?=$data->basic_salary?></td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>Basic Aggregation  :</td>
                                  <td  colspan="2" class="oe_form_group_cell"><?=$data->special_allowance?></td>
								  <td>&nbsp;</td>
                                  <td  class="oe_form_group_cell">&nbsp;&nbsp;House Rent</td>
                                  <td  class="oe_form_group_cell"><?=$data->house_rent?></td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>Conveyance  :</td>
                                  <td  colspan="2" class="oe_form_group_cell"><?=$data->ta?></td>
								  <td>&nbsp;</td>
                                  <td  class="oe_form_group_cell">&nbsp;&nbsp;Food Allowance</td>
                                  <td  class="oe_form_group_cell"><?=$data->food_allowance?></td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>Child Allowance  :</td>
                                  <td  colspan="2" class="oe_form_group_cell"><?=$data->child_allowance?></td>
								  <td>&nbsp;</td>
                                  <td  class="oe_form_group_cell">&nbsp;&nbsp;Mobile Allowance</td>
                                  <td  class="oe_form_group_cell"><?=$data->mobile_allowance?></td>
                                </tr>
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>Medical Allowance  :</td>
                                  <td  colspan="2" class="oe_form_group_cell"><?=$data->medical_allowance?></td>
								  <td>&nbsp;</td>
                                  <td  class="oe_form_group_cell">&nbsp;&nbsp;Mobile Allowance</td>
                                  <td  class="oe_form_group_cell"><?=$data->mobile_allowance?></td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>Performance Bonus  :</td>
                                  <td  colspan="2" class="oe_form_group_cell"><?=$data->performance_bonus?></td>
								  <td>&nbsp;</td>
                                  <td  class="oe_form_group_cell">&nbsp;&nbsp;Resource Bonus</td>
                                  <td  class="oe_form_group_cell"><?=$data->resourse_bonus?></td>
                                </tr>
								 
								 <tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>PF  :</td>
                                  <td  colspan="2" class="oe_form_group_cell"><?=$data->pf?></td>
								  <td>&nbsp;</td>
                                  <td  class="oe_form_group_cell">&nbsp;&nbsp;Income Tax</td>
                                  <td  class="oe_form_group_cell"><?=$data->income_tax?></td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="6" bgcolor="#CCCCCC"  class="oe_form_group_cell oe_form_group_cell_label"></td>
                                 
                                </tr>
								
								
								
								<tr class="oe_form_group_row">
                                 <td colspan="6"  class="oe_form_group_cell oe_form_group_cell_label"></td></tr>
                                                                            
                                                                            <tr class="oe_form_group_row">
																			

																			

																			  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Present Add :</td>



                                                                                <td colspan="2" class="oe_form_group_cell"><?=$PBI_PRESENT_ADD?></td>



                                                                              



                                                                                <td  class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  class="oe_form_group_cell">Line Manager : </td>



                                                                                <td  class="oe_form_group_cell">
																				  <?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$incharge_id.'"');?>																				 																	</td>
                                                                            </tr>



                                                                            <tr class="oe_form_group_row">



                                                                              <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Permanent Add :</td>



                                                                                <td colspan="2"  class="oe_form_group_cell"><?=$PBI_PERMANENT_ADD?></td>

                                                                                <td class="oe_form_group_cell">&nbsp;</td>



                                                                                <td class="oe_form_group_cell">National ID :</td>



                                                                                <td class="oe_form_group_cell"><?=$nid?></td>
                                                                            </tr>



                                                                            <tr class="oe_form_group_row">



                                                                                <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;<span class="''">Mobile Office:</span></td>



                                                                                <td colspan="2"  class="oe_form_group_cell"><?=$PBI_MOBILE?></td>



                                                                                <td  class="oe_form_group_cell">&nbsp;</td>



                                                                               <td class="oe_form_group_cell">E-mail :</td>



                                                                                <td class="oe_form_group_cell"><?=$PBI_EMAIL?></td>
                                                                            </tr>



                                                                            <tr class="oe_form_group_row">



                                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Mobile Personal  :</td>



                                                                                <td colspan="2" class="oe_form_group_cell"><?=$PBI_MOBILE_ALT?></td>



                                                                                <td class="oe_form_group_cell">&nbsp;</td>

																				

																				 <td  class="oe_form_group_cell">Alt E-mail :</td>



                                                                              <td  class="oe_form_group_cell"><?=$PBI_EMAIL_ALT?></td>
                                                                            </tr>

																			

																			<tr class="oe_form_group_row">



                                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Emergency Mobile No :</td>



                                                                                <td colspan="2" class="oe_form_group_cell"><?=$PBI_EMERGENCY_MOBILE?></td>



                                                                                <td class="oe_form_group_cell">&nbsp;</td>



                                                                                <td class="oe_form_group_cell">&nbsp;</td>



                                                                                <td class="oe_form_group_cell">&nbsp;</td>
                                                                            </tr>


                                                                            <tr class="oe_form_group_row">



                                                                                <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Picture : </td>



                                                                                <td colspan="2"  class="oe_form_group_cell"><img src="<?=$staff_pic?>" style="width:200px; height:220px;" /></td>



                                                                                <td  class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  class="oe_form_group_cell">National ID</td>


                                                                               <? if(strpos($nid_att, 'pdf')==true){?>
                                                                                <td  class="oe_form_group_cell"><a href="<?=$nid_att?>" target="_blank">Download NID</a></td>
																				<? }else{?>
																				<td  class="oe_form_group_cell"><img src="<?=$nid_att?>" style="width:200px; height:220px;" /></td>
																				<? } ?>
                                                                            </tr>
																			
																			<tr class="oe_form_group_row">



                                                                                <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Signature : </td>



                                                                                
                                                                                <td colspan="2" class="oe_form_group_cell"><img src="<?=$signature_att?>" style="width:200px; height:220px;" /></td>
																				
																				 <td  class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  class="oe_form_group_cell">&nbsp;&nbsp;TIN</td>


                                                                               <? if(strpos($tin_att, 'pdf')==true){?>
                                                                                <td  class="oe_form_group_cell"><a href="<?=$tin_att?>" target="_blank">Download TIN</a></td>
																				<? }else{?>
																				<td  class="oe_form_group_cell"><img src="<?=$tin_att?>" style="width:200px; height:220px;" /></td>
																				<? } ?>
                                                                            </tr>



                                                                            <tr class="oe_form_group_row">



                                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;</td>



                                                                                <td colspan="2" class="oe_form_group_cell">&nbsp;</td>



                                                                                <td bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;</td>



                                                                                <td bgcolor="#FFFFFF" class="oe_form_group_cell"><strong><span class="">&nbsp;</span></strong></td>



                                                                                <td bgcolor="#FFFFFF" class="oe_form_group_cell">                                                                                                                                                             </tr>


                                                                    
																			
																			
                                                                            <tr class="oe_form_group_row">



                                                                                <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>



                                                                                <td colspan="2"  class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  class="oe_form_group_cell">&nbsp;</td>



                                                                                <td  class="oe_form_group_cell">&nbsp;</td>
                                                                            </tr>
																			 <tr class="oe_form_group_row">



                                                                                <td colspan="6" class="oe_form_group_cell oe_form_group_cell_label"><div align="center"></div></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>



                                                              </td>



                                                            </tr>



                                                        </tbody>



                                                    </table>



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



<script>$("#cz").validate();$("#cloud").validate();</script>

    <?



//



//



require_once SERVER_CORE."routing/layout.bottom.php";



?>