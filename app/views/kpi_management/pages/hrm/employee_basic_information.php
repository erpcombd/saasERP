<?php

session_start();

ob_start();

require "../../config/inc.all.php";



// ::::: Edit This Section ::::: 

$title='Employee Basic Info';		// Page Name and Page Title

$page="employee_basic_information.php";		// PHP File Name

$input_page="employee_basic_information_input.php";

$root='hrm';

$location='user';

$pages_show='show_user.php';

$table='personnel_basic_info';		// Database Table Name Mainly related to this page

$unique='PBI_ID';			// Primary Key of this Database table

$shown='PBI_FATHER_NAME';	



do_calander('#PBI_DOB');

do_calander('#PBI_DOJ_PP');

do_calander('#PBI_DOC');

do_calander('#PBI_DOJ');

do_calander('#resign_date');

do_calander('#PBI_PASS_ISSUE');

do_calander('#PBI_PASS_EXP');


if(isset($_REQUEST["clear"])){
unset($_SESSION['employee_selected']);unset($_SESSION['employee_selected1']);unset($_SESSION['employee_selected2']);
}

// ::::: End Edit Section :::::





$crud =new crud($table);

if($_GET['remove']=='selected'){ unset($_SESSION['employee_selected']);unset($_SESSION['employee_selected1']);unset($_SESSION['employee_selected2']);}



$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);

if($required_id>0)

$$unique = $_GET[$unique] = $required_id;

if(isset($_POST[$shown]))

{	if(isset($_POST['insert']))

		{		

				$_POST['PBI_DESG_GRADE'] = find_a_field('designation','DESG_GRADE','DESG_SHORT_NAME='.$_POST['PBI_DESIGNATION']);

				$path='../../pic/staff';

				$_POST['pic']=image_upload($path,$_FILES['pic']);

				$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];

				$crud->insert();

				$type=1;

				$msg='New Entry Successfully Inserted.';

				unset($_POST);

				unset($$unique);

$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);

if($required_id>0)

$$unique = $_GET[$unique] = $required_id;

		}

	//for Modify..................................

	if(isset($_POST['update']))

	{

				$_POST['PBI_DESG_GRADE'] = find_a_field('designation','DESG_GRADE','DESG_SHORT_NAME='.$_POST['PBI_DESIGNATION']);

				$path='../../pic/staff';

				$_POST['pic']=image_upload($path,$_FILES['pic']);

				$crud->update($unique);

				$type=1;

	}

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

while (list($key, $value)=each($data))

{ $$key=$value;}

}

?>

<script type="text/javascript"> function DoNav(lk){

	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)

	}</script>

	

	<script>

	function delete_alert(){

	var answer = confirm("Are You Sure ! Delete this data ?")

    if (answer){

       alert("Delete Sucessfully")

       window.location = "http://www.google.com/";

    }

      else{

      alert("No")

    }

	}

	</script>

	

	<script>

function validateForm() {

    var x = document.forms["myForm"]["PBI_NAME"].value;

	var y = document.forms["myForm"]["PBI_DOMAIN"].value;

	var z = document.forms["myForm"]["PBI_DEPARTMENT"].value;

	var q = document.forms["myForm"]["PBI_DESIGNATION"].value;

	var r = document.forms["myForm"]["office_time"].value;

    if (x == null || x == "" && y== null || y=="" && z==null || z=="" && q== null || q=="" && r==null || r=="") {

        alert("Name, Company Name, Department, Designation, Office Time must be filled out");

        return false;

    }

}

</script>





<div class="oe_view_manager oe_view_manager_current">

    <form action="?" method="post" enctype="multipart/form-data">  

    <? include('../../common/title_bar.php');?>

	</form>
	
	

        <form action="" method="post" enctype="multipart/form-data">

		<div class="oe_view_manager_body">

            

                <div  class="oe_view_manager_view_list"></div>

            

                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

        <div class="oe_form_buttons"></div>

        <div class="oe_form_sidebar"></div>

        <div class="oe_form_pager"></div>

        <div class="oe_form_container"><div class="oe_form">

          <div class="">

                      <? include('../../common/input_bar.php');?>

                      <div class="oe_form_sheetbg">

                        <div class="oe_form_sheet oe_form_sheet_width">

        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">

        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>

    </label>

          </h1>

		  <table width="801" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">

            <tbody>

			<tr class="oe_form_group_row">

            <td colspan="1" class="oe_form_group_cell" width="100%"><table width="794" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">

              <tbody>

                <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" width="23%" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;ID :</td>

                  <td bgcolor="#E8E8E8" width="23" colspan="2" class="oe_form_group_cell">

                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                  <input name="EMP_ID" type="text" id="EMP_ID" value="<?=($PBI_ID>0)?$EMP_ID:'RA-'.$_SESSION['employee_selected'];?>" readonly="readonly" />				  </td>

					

                  <td bgcolor="#E8E8E8" width="23%" class="oe_form_group_cell">

				  <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Company Name :</span>				  </td>

                  <td bgcolor="#E8E8E8" width="31%" class="oe_form_group_cell">

				  <select name="PBI_DOMAIN" required>
				  <option value="1">Regent Airways</option>

                                     </select>				  </td>
                </tr>

                <tr class="oe_form_group_row">

                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label>&nbsp; Name :</label></td>

                  <td colspan="2" class="oe_form_group_cell">

				  <input name="PBI_NAME" type="text" id="PBI_NAME" value="<?=$PBI_NAME?>" required/></td>

                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Department :</span></td>

                  <td class="oe_form_group_cell">

				  <select name="PBI_DEPARTMENT" required>

                    <? foreign_relation('department','DEPT_ID','DEPT_DESC',$PBI_DEPARTMENT);?>
                  </select>				  </td>
                </tr>

                <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Father/Husband Name : </td>

                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell">

                  

                  <input name="PBI_FATHER_NAME" type="text" id="PBI_FATHER_NAME" value="<?=$PBI_FATHER_NAME?>" />                  </td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Designation :</span></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">

				  <select name="PBI_DESIGNATION" required>

                    <? foreign_relation('designation','DESG_ID','DESG_DESC',$PBI_DESIGNATION);?>
                  </select>				  </td>
                </tr>

                <tr class="oe_form_group_row">

                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Mother Name :</td>

                  <td colspan="2" class="oe_form_group_cell">

				  <input name="PBI_MOTHER_NAME" type="text" id="PBI_MOTHER_NAME" value="<?=$PBI_MOTHER_NAME?>" /></td>

                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Date of Birth : </span></td>

                  <td class="oe_form_group_cell">

				  <input name="PBI_DOB" type="text" id="PBI_DOB" value="<?=$PBI_DOB?>" />				  </td>
                </tr>

                <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Gender :</td>

                  <td bgcolor="#E8E8E8" colspan="2" class="oe_form_group_cell">

				  <select name="PBI_SEX">

                   <option selected><?=$PBI_SEX?></option>

						<option>Male</option>

						<option>Female</option>
                  </select>				  </td>

                  

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;AGE : </span></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell"><input name="PBI_SERVICE_LENGTH2" type="text" id="PBI_SERVICE_LENGTH2" value="<?=Date2age($PBI_DOB)?>" readonly="readonly" /></td>
                </tr>

                <tr class="oe_form_group_row">

                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Marital Status : </td>

                  <td colspan="2" class="oe_form_group_cell">

				  <select name="PBI_MARITAL_STA">

                    <option selected="selected">

                    <?=$PBI_MARITAL_STA?>
                    </option>

                    <option>Married</option>

                    <option>Unmarried</option>

                    <option>Widow</option>

                    <option>Divorcee</option>
                  </select></td>

                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Nationality :</span></td>

                  <td class="oe_form_group_cell">

				  <select name="PBI_NATIONALITY">

                    <option selected="selected">

                    <?=$PBI_NATIONALITY?>
                    </option>

					

                    <option>Bangladeshi</option>

                    <option>Canadian</option>

                    <option>English</option>

                    <option>Indian</option>

                    <option>Pakistani</option>

                    <option>Nepali</option>
                  </select></td>
                </tr>

                

                <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Religion :</td>

                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell">

				  <select name="PBI_RELIGION">

                    <option selected="selected">

                      <?=$PBI_RELIGION?>
                      </option>

                    <option>Islam</option>

                    <option>Bahai</option>

                    <option>Buddhism</option>

                    <option>Christianity</option>

                    <option>Confucianism </option>

                    <option>Druze</option>

                    <option>Hinduism</option>

                    <option>Jainism</option>

                    <option>Judaism</option>

                    <option>Shinto</option>

                    <option>Sikhism</option>

                    <option>Taoism</option>

                    <option>Zoroastrianism</option>

                    <option>Others</option>
                  </select>				  </td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">

				  <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;National ID No :</span></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">

				  <input name="national_id" type="text" id="national_id" value="<?=$national_id?>" />				  </td>
                </tr>

                

                <tr class="oe_form_group_row">
                  <td colspan="1" bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Passport No. :</td>
                  <td colspan="2" bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="PBI_PASSPORT" type="text" id="PBI_PASSPORT" value="<?=$PBI_PASSPORT?>" /></td>
                  <td bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp; Passport Issue Date :</td>
                  <td bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="PBI_PASS_ISSUE" type="text" id="PBI_PASS_ISSUE" value="<?=$PBI_PASS_ISSUE?>" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td colspan="2" bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp;</td>
                  <td bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="oe_form_group_cell">&nbsp; Passport Expiry Date :</td>
                  <td bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="oe_form_group_cell"><input name="PBI_PASS_EXP" type="text" id="PBI_PASS_EXP" value="<?=$PBI_PASS_EXP?>" /></td>
                </tr>
                <tr class="oe_form_group_row">

                  <td colspan="1" bordercolor="#FFFFFF" bgcolor="#CCCCCC" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Present Add :</td>

                  <td colspan="2" bordercolor="#FFFFFF" bgcolor="#CCCCCC" class="oe_form_group_cell">

				  <input name="PBI_PRESENT_ADD" type="text" id="PBI_PRESENT_ADD" value="<?=$PBI_PRESENT_ADD?>" />				  </td>

                  <td bordercolor="#FFFFFF" bgcolor="#CCCCCC" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Place of Birth (District) : </span></td>
                  <td bordercolor="#FFFFFF" bgcolor="#CCCCCC" class="oe_form_group_cell"><select name="PBI_POB">
                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_POB);?>
                    </select>                  </td>
                </tr>
				
				<tr class="oe_form_group_row">

                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Permanent Add :</td>

                  <td colspan="2" class="oe_form_group_cell">

				  <input name="PBI_PERMANENT_ADD" type="text" id="PBI_PERMANENT_ADD" value="<?=$PBI_PERMANENT_ADD?>" />				  </td>

                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Cell No. 1  :</span></td>

                  <td class="oe_form_group_cell">

				  <input name="PBI_MOBILE" type="text" id="PBI_MOBILE" value="<?=$PBI_MOBILE?>" />                  </td>
                </tr>

                <tr class="oe_form_group_row">
                  <td colspan="1" bgcolor="#CCCCCC" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; E-mail 1:</td>

                  <td colspan="2" bgcolor="#CCCCCC" class="oe_form_group_cell">

				  <input name="PBI_EMAIL" type="text" id="PBI_EMAIL" value="<?=$PBI_EMAIL?>" />				  </td>
                  <td bgcolor="#CCCCCC" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Cell No. 2  :</span></td>

                  <td bgcolor="#CCCCCC" class="oe_form_group_cell">

				  <input name="PBI_MOBILE2" type="text" id="PBI_MOBILE2" value="<?=$PBI_MOBILE2?>" />                  </td>
                </tr>
                <tr class="oe_form_group_row">

                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; E-mail 2:</td>

                  <td colspan="2" class="oe_form_group_cell">

				  <input name="PBI_EMAIL2" type="text" id="PBI_EMAIL2" value="<?=$PBI_EMAIL2?>" />				  </td>

                  <td class="oe_form_group_cell">

				  <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Edu Qualification :</span></td>

                  <td class="oe_form_group_cell">

				  <select name="PBI_EDU_QUALIFICATION">                    

                    <? foreign_relation('edu_qua','EDU_QUA_CODE','EDU_QUA_DESC',$PBI_EDU_QUALIFICATION);?>
                  </select>				  </td>
                </tr>

                <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Office Time:</td>

                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell">

				  <select name="office_time" >

                    <? foreign_relation('hrm_schedule_info','id','schedule_name',$office_time);?>
                  </select>				   </td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">

				  <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Initial Job Type :</span></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">

				  <select name="PBI_PRIMARY_JOB_STATUS">

                    <option selected="selected"><?=$PBI_PRIMARY_JOB_STATUS?></option>

					<option></option>

                    <option>Permanent</option>

                    <option>Project Staff</option>

                    <option>Contract Based</option>
                   </select>				  </td>
                </tr>

                <tr class="oe_form_group_row">

                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Joining Date : </td>

                  <td colspan="2" class="oe_form_group_cell">

				  <input name="PBI_DOJ" type="text" id="PBI_DOJ" value="<?=$PBI_DOJ?>" />				  </td>

                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Job Status : </span></td>

                  <td class="oe_form_group_cell">

				  <select name="PBI_JOB_STATUS">

                    <? foreign_relation('job_status','id','job_status',$PBI_JOB_STATUS);?>
                  </select>				  </td>
                </tr>

                <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Confirmation Date :</td>

                  <td colspan="2" bgcolor="#E8E8E8" class="oe_form_group_cell">

				  <input name="PBI_DOC" type="text" id="PBI_DOC" value="<?=$PBI_DOC?>" /></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">

				  <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Type of Separation :</span></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">

				  <span class="oe_form_field oe_datepicker_root oe_form_field_date">

                    <select name="PBI_separation_type">

                    <option selected="selected">

                      <?=$PBI_separation_type?>
                      </option>

					  <option></option>

                    <option>Resignation</option>

                    <option>Discharge</option>

                    <option>Dismissal</option>

                    <option>Termination (Self)</option>

                    <option>Termination (Authority)</option>

                    <option>Retirement</option>
                  </select>
                  </span></td>
                </tr>

                <tr class="oe_form_group_row">

                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Total Service Length :</td>

                  <td colspan="2" class="oe_form_group_cell">

				  <input name="PBI_SERVICE_LENGTH" type="text" id="PBI_SERVICE_LENGTH" value="<?=Date2age($PBI_DOJ)?>" readonly />				  </td>

                  <td class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span>

                  <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span>Staff Picture :</td>

                  <td class="oe_form_group_cell">

				  <input type="file" name="pic" id="pic" accept="image/jpeg" />				  </td>
                </tr>

                <tr class="oe_form_group_row">

                  <td colspan="1" bordercolor="#CCCCCC" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"> &nbsp;&nbsp;Off Day: </td>

                  <td colspan="2" bordercolor="#CCCCCC" bgcolor="#E8E8E8" class="oe_form_group_cell"><select name="off_day">

				 <option></option>

						<option value="5" <?=($off_day==5)?'selected':'';?>>Friday</option>

						<option value="6" <?=($off_day==6)?'selected':'';?>>Saturday</option>

						<option value="7" <?=($off_day==7)?'selected':'';?>>Sunday</option>

						<option value="1" <?=($off_day==1)?'selected':'';?>>Monday</option>

						<option value="2" <?=($off_day==2)?'selected':'';?>>Tuesday</option>

						<option value="3" <?=($off_day==3)?'selected':'';?>>Wednesday</option>

						<option value="4" <?=($off_day==4)?'selected':'';?>>Thursday</option>

						

                  </select>&nbsp;</td>

                  <td colspan="1" bordercolor="#CCCCCC" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Leave Type :</td>
                  <td colspan="1" bordercolor="#CCCCCC" bgcolor="#E8E8E8" class="oe_form_group_cell">
				  <select name="LEAVE_RULE_ID">
                    <? foreign_relation('hrm_leave_rull_manage','id','rule_name',$LEAVE_RULE_ID);?>
                  </select></td>
                </tr>
				

                <tr class="oe_form_group_row">
                  <td colspan="1" bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Job Location</td>
                  <td colspan="2" bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="oe_form_group_cell">
				  <select name="JOB_LOCATION">
                   
				 <option></option>
				 		<option value="Head Office" <?=($JOB_LOCATION=="Head Office")?'selected':'';?>>Head Office</option>

						<option value="Dhaka Airport" <?=($JOB_LOCATION=="Dhaka Airport")?'selected':'';?>>Dhaka Airport</option>

						<option value="Sector-1, Uttara" <?=($JOB_LOCATION=="Sector-1, Uttara")?'selected':'';?>>Sector-1, Uttara</option>

						<option value="Nasirabad, Chittagong" <?=($JOB_LOCATION=="Nasirabad, Chittagong")?'selected':'';?>>Nasirabad, Chittagong</option>
						
						<option value="Cox`s Bazar Airport" <?=($JOB_LOCATION=="Cox`s Bazar Airport")?'selected':'';?>>Cox`s Bazar Airport</option>

						<option value="Chittagong Airport" <?=($JOB_LOCATION=="Chittagong Airport")?'selected':'';?>>Chittagong Airport</option>

						<option value="OCC, Dhaka Airport" <?=($JOB_LOCATION=="OCC, Dhaka Airport")?'selected':'';?>>OCC, Dhaka Airport</option>
						
						<option value="Agrabad, Chittagong" <?=($JOB_LOCATION=="Agrabad, Chittagong")?'selected':'';?>>Agrabad, Chittagong</option>
						
						<option value="Gulshan/Motijheel/Airport" <?=($JOB_LOCATION=="Gulshan/Motijheel/Airport")?'selected':'';?>>Gulshan/Motijheel/Airport</option>
						
						<option value="Gulshan" <?=($JOB_LOCATION=="Gulshan")?'selected':'';?>>Gulshan</option>
						
						<option value="Agrabad Sales Counter (CGP)" <?=($JOB_LOCATION=="Agrabad Sales Counter (CGP)")?'selected':'';?>>Agrabad Sales Counter (CGP)</option>
						
						<option value="Zone-B, Dhaka Airport" <?=($JOB_LOCATION=="Zone-B, Dhaka Airport")?'selected':'';?>>Zone-B, Dhaka Airport</option>
						
						<option value="Kolkata, India Airport" <?=($JOB_LOCATION=="Kolkata, India Airport")?'selected':'';?>>Kolkata, India Airport</option>
						
						<option value="MD House" <?=($JOB_LOCATION=="MD House")?'selected':'';?>>MD House</option>
						
						<option value="Group Office, Chittagong" <?=($JOB_LOCATION=="Group Office, Chittagong")?'selected':'';?>>Group Office, Chittagong</option>
						
						<option value="Gulshan Sales Counter" <?=($JOB_LOCATION=="Gulshan Sales Counter")?'selected':'';?>>Gulshan Sales Counter</option>
						
						<option value="Bankok, Thailand Airport" <?=($JOB_LOCATION=="Bankok, Thailand Airport")?'selected':'';?>>Bankok, Thailand Airport</option>
						
						<option value="Kuala Lumpur, Malaysia Airport" <?=($JOB_LOCATION=="Kuala Lumpur, Malaysia Airport")?'selected':'';?>>Kuala Lumpur, Malaysia Airport</option>
						
						<option value="Kathmandu, Nepal Airport" <?=($JOB_LOCATION=="Kathmandu, Nepal Airport")?'selected':'';?>>Kathmandu, Nepal Airport</option>
						
						<option value="Motijheel" <?=($JOB_LOCATION=="Motijheel")?'selected':'';?>>Motijheel</option>
						
						<option value="Nasirabad Sales Counter (CGP)" <?=($JOB_LOCATION=="Nasirabad Sales Counter (CGP)")?'selected':'';?>>Nasirabad Sales Counter (CGP)</option>
                  </select></td>
				  
                  <td bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="oe_form_group_cell">Blood Group:</td>
                  <td bordercolor="#FFFFFF" bgcolor="#FFFFFF" class="oe_form_group_cell">
				  <select name="BLOOD_GROUP">
                   
				 <option></option>
				 		<option value="1" <?=($BLOOD_GROUP==1)?'selected':'';?>>O-</option>

						<option value="2" <?=($BLOOD_GROUP==2)?'selected':'';?>>O+</option>

						<option value="3" <?=($BLOOD_GROUP==3)?'selected':'';?>>A-</option>

						<option value="4" <?=($BLOOD_GROUP==4)?'selected':'';?>>A+</option>
						
						<option value="5" <?=($BLOOD_GROUP==5)?'selected':'';?>>B-</option>

						<option value="6" <?=($BLOOD_GROUP==6)?'selected':'';?>>B+</option>

						<option value="7" <?=($BLOOD_GROUP==7)?'selected':'';?>>AB-</option>
						
						<option value="8" <?=($BLOOD_GROUP==8)?'selected':'';?>>AB+</option>
						</select>				  </td>
                </tr>
				
				
                <tr class="oe_form_group_row">

                  <td colspan="1" bordercolor="#CCCCCC" bgcolor="#CCCCCC" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Resign Date :</td>

                  <td colspan="2" bordercolor="#CCCCCC" bgcolor="#CCCCCC" class="oe_form_group_cell">

				  <input name="resign_date" type="text" id="resign_date" value="<?=$resign_date?>" />				  </td>

                  <td bordercolor="#CCCCCC" bgcolor="#CCCCCC" class="oe_form_group_cell">

				  <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span> 

				  <span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</span>Staff Others File :</td>

                  <td bordercolor="#FFFFFF" bgcolor="#CCCCCC" class="oe_form_group_cell">

				  <input type="file" name="pic_staff" id="pic_staff" accept="image/jpeg" />				  </td>
                </tr>
                </tbody></table></td>

            <td colspan="1" class="oe_form_group_cell oe_group_right" width="100%">&nbsp;</td>

            </tr></tbody></table></div>

                      </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

        </div>

		</form>

    </div>



<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>