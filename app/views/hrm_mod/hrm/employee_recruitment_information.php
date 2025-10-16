<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
if(isset($_POST['button'])){
//$pbi = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['employee_selected'].'"');
$_SESSION['employee_selected'] = $_POST['employee_selected'];
}


if(isset($_POST['reset'])){
//$pbi = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['employee_selected'].'"');
unset($_SESSION['employee_selected']);

}

// ::::: Edit This Section ::::: 
$title='Employee Basic Info' ; 		// Page Name and Page Title
$page="employee_basic_information.php";		// PHP File Name
$input_page="employee_basic_information_input.php";
$root='hrm';
$table='personnel_basic_info';		// Database Table Name Mainly related to this page
$unique='PBI_ID';			// Primary Key of this Database table
$shown='PBI_FATHER_NAME';	
do_calander('#PBI_DUE_DOJ');
do_calander('#PBI_DOB');
do_calander('#PBI_DOJ_PP');
do_calander('#PBI_DOC');

do_calander('#PBI_DOC2');











//do_calander('#PBI_DOJ');











do_calander('#PBI_APPOINTMENT_LETTER_DATE');











do_calander('#JOB_STATUS_DATE');











// ::::: End Edit Section :::::











$crud      =new crud($table);











$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);











if($required_id>0)











$$unique = $_GET[$unique] = $required_id;











if(isset($_POST[$shown]))











{	if(isset($_POST['insert'])) {		



$_POST['PBI_ID']= $_POST['PBI_ID'];

$_POST['PBI_CODE']= $_POST['PBI_CODE'];

$due_date = date("Y-m-d", strtotime($_POST['PBI_DOJ']."+".$_POST['PBI_CON_TYPE']." months"));



$_REQUEST['PBI_DUE_DOJ']=$due_date;

$_REQUEST['PBI_DEPARTMENT'] = find_a_field('department','DEPT_DESC','DEPT_ID='.$_REQUEST['DEPT_ID']);

$_REQUEST['PBI_DESIGNATION'] = find_a_field('designation','DESG_DESC','DESG_ID='.$_REQUEST['DESG_ID']);

$interval = date_diff(date_create(date('Y-m-d')), date_create($_POST['PBI_DOJ']));

$service_length =  $interval->format("%Y Year, %M Months, %d Days");

$_POST['PBI_SERVICE_LENGTH'] = $service_length;
//******** EMP IMAGE
$folder='hrm_emp_pic'; 
$field = 'PBI_PICTURE_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';
$file_name = $folder.'-'.$_SESSION['employee_selected'];
if($_FILES['PBI_PICTURE_ATT_PATH']['tmp_name']!=''){
$_POST['PBI_PICTURE_ATT_PATH']=upload_file($folder,$field,$file_name);
}


//////////NID////////////////
if($_FILES['PBI_NID_ATT_PATH']['tmp_name']!=''){
$folder='hrm_nid_pic'; 
$field = 'PBI_NID_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';
$file_name = $folder.'-'.$_SESSION['employee_selected'];

if($_FILES['PBI_NID_ATT_PATH']['tmp_name']!=''){
$_POST['PBI_NID_ATT_PATH']=upload_file($folder,$field,$file_name);
}
}



//////////TIN////////////////

$path_tin='../../pic/tin';

if($_FILES['tin_pic']['tmp_name']!=''){

$file_name2= $_FILES['tin_pic']['name'];

$file_tmp2= $_FILES['tin_pic']['tmp_name'];

$ext2=end(explode('.',$file_name2));

$path_tin='../../pic/tin/';

$uploaded_file2 = $path_tin.$_SESSION['employee_selected'].'.'.$ext2;

$_POST['tin_pic'] = $uploaded_file2;

move_uploaded_file($file_tmp2, $path_tin.$_SESSION['employee_selected'].'.'.$ext2);

}



//////////PASSPORT////////////////
if($_FILES['PBI_PASSPORT_ATT_PATH']['tmp_name']!=''){
$folder='hrm_passport_pic'; 
$field = 'PBI_PASSPORT_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';

$file_name = $folder.'-'.$_SESSION['employee_selected'];

if($_FILES['PBI_PASSPORT_ATT_PATH']['tmp_name']!=''){
$_POST['PBI_PASSPORT_ATT_PATH']=upload_file($folder,$field,$file_name);
}
}



//$_POST['PBI_ID']=$_SESSION['employee_selected'];

$_POST['PBI_DESIGNATION']=find_a_field('designation','DESG_DESC','DESG_ID="'.$_POST['DESG_ID'].'"');

$_POST['PBI_DEPARTMENT']=find_a_field('department','DEPT_DESC','DEPT_ID="'.$_POST['DEPT_ID'].'"');

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

$_REQUEST['PBI_DEPARTMENT'] = find_a_field('department','DEPT_SHORT_NAME','DEPT_ID='.$_REQUEST['DEPT_ID']);

$_REQUEST['PBI_DESIGNATION'] = find_a_field('designation','DESG_SHORT_NAME','DESG_ID='.$_REQUEST['DESG_ID']);

//$due_date_d=$_POST['PBI_CON_TYPE']-1;

$due_date = date("Y-m-d", strtotime($_POST['PBI_DOJ']."+".$_POST['PBI_CON_TYPE']." months"));

$_REQUEST['PBI_DUE_DOJ']=$due_date;

$_POST['PBI_DESIGNATION']=find_a_field('designation','DESG_DESC','DESG_ID="'.$_POST['DESG_ID'].'"');

$_POST['PBI_DEPARTMENT']=find_a_field('department','DEPT_DESC','DEPT_ID="'.$_POST['DEPT_ID'].'"');


//============== EMP PIC

$folder='hrm_emp_pic'; 

$field = 'PBI_PICTURE_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';

$file_name = $folder.'-'.$_SESSION['employee_selected'];



if($_FILES['PBI_PICTURE_ATT_PATH']['tmp_name']!=''){

$_POST['PBI_PICTURE_ATT_PATH']=upload_file($folder,$field,$file_name);





}



//=============== NID PIC



$folder='hrm_nid_pic'; 

$field = 'PBI_NID_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';

$file_name = $folder.'-'.$_SESSION['employee_selected'];



if($_FILES['PBI_NID_ATT_PATH']['tmp_name']!=''){

$_POST['PBI_NID_ATT_PATH']=upload_file($folder,$field,$file_name);

}


//////////PASSPORT////////////////
if($_FILES['PBI_PASSPORT_ATT_PATH']['tmp_name']!=''){
$folder='hrm_passport_pic'; 
$field = 'PBI_PASSPORT_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';

$file_name = $folder.'-'.$_SESSION['employee_selected'];

if($_FILES['PBI_PASSPORT_ATT_PATH']['tmp_name']!=''){
$_POST['PBI_PASSPORT_ATT_PATH']=upload_file($folder,$field,$file_name);
}
}






$interval = date_diff(date_create(date('Y-m-d')), date_create($_POST['PBI_DOJ']));

$service_length =  $interval->format("%Y Year, %M Months, %d Days");

$_POST['PBI_SERVICE_LENGTH'] = $service_length;



$crud->update($unique);











$type=1;











}











}











if(isset($$unique))











{











$condition=$unique."=".$$unique;











$data=db_fetch_object($table,$condition);











foreach($data as $key => $value)






{ $$key=$value;}}



$max_pbi_code = find_a_field('personnel_basic_info','max(PBI_CODE)','PBI_CODE like "%UBSL3%"');
$new = explode("UBSL",$max_pbi_code);
$max_id =  $new[1];
$new_pbi_code = $max_id+1;
$new_pbi_code = 'UBSL'.$new_pbi_code;

?>
<script type="text/javascript"> function DoNav(lk){











return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)











}











function add_date(cd)











{











var arr=cd.split('-');











var mon = (arr[1]*1)+6;











var day = (arr[2]*1);











var yr =  (arr[0]*1);











if(mon>12)











{











mon = mon-12;











yr  = yr+1;











}











var con_date = yr+'-'+mon+'-'+day;











document.getElementById('PBI_DOC').value=con_date;











}











</script>
<style type="text/css">











.style1{color: #FF0000;}











.oe_form_group_cell{padding:8px;}











.label {font-weight:bold;}











</style>
<form action="" method="post" enctype="multipart/form-data">
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
                <? include('../common/input_bar.php');?>
                <div class="oe_form_sheetbg" style="margin-top:-10px">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <div class="card">
                      <div style="font-weight:bold; font-size:16px; background-color:#1D3195; z-index: 0!important; text-transform:uppercase; color:#fff" class="card-header">
                        <center>
                          Personal Informations
                        </center>
                      </div>
                      <div class="card-body">
                        <div class="row ">
                          <div class="col-md-2 form-group">
                            <label  class="label success" for="PBI_ID" >Code : </label>
                            <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                            <input   name="PBI_CODE" type="text" id="PBI_CODE" value="<?=$PBI_CODE; //if($PBI_ID>0) echo $PBI_ID; else echo find_a_field('personnel_basic_info','max(PBI_ID)+1','1');?>" 
							class="form-control" />
                            <input name="PBI_ID" type="hidden" id="PBI_ID" value="<?=$PBI_ID?>" readonly="readonly" class="form-control"/>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="MACHINE_ID">Machine  ID : </label>
                            <input   name="MACHINE_ID" class="form-control"  type="text" id="MACHINE_ID" value="<?=$MACHINE_ID?>"/>
                          </div>
                          <div class="col-md-3 form-group">
                            <label class="label" for="PBI_NAME">Name : </label>
                            <input   name="PBI_NAME" class="form-control"  type="text" id="PBI_NAME" value="<?=$PBI_NAME?>"/>
                          </div>
                          <div class="col-md-3 form-group">
                            <label class="label" for="PBI_FATHER_NAME">Father's Name : </label>
                            <input   name="PBI_FATHER_NAME" class="form-control"  type="text" id="PBI_FATHER_NAME" value="<?=$PBI_FATHER_NAME?>"/>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_MOTHER_NAME">Mother's Name : </label>
                            <input   name="PBI_MOTHER_NAME" class="form-control"  type="text" id="PBI_MOTHER_NAME" value="<?=$PBI_MOTHER_NAME?>"/>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_SEX">Gender :</label>
                            <select name="PBI_SEX" class="form-control">
                              <option selected>
                              <?=(isset($PBI_SEX))?$PBI_SEX:'Male';?>
                              </option>
                              <option>Male</option>
                              <option>Female</option>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_MARITAL_STA">Marital Status :</label>
                            <select name="PBI_MARITAL_STA" class="form-control">
                              <option selected="selected">
                              <?=$PBI_MARITAL_STA?>
                              </option>
                              <option>Married</option>
                              <option>Unmarried</option>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_RELIGION">Religion :</label>
                            <select name="PBI_RELIGION" class="form-control">
                              <option selected>
                              <?=(isset($PBI_RELIGION))?$PBI_RELIGION:'Islam';?>
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
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_NATIONALITY">Nationality :</label>
                            <select name="PBI_NATIONALITY" class="form-control">
                              <option selected="selected">
                              <?=(isset($PBI_NATIONALITY))?$PBI_NATIONALITY:'Bangladeshi';?>
                              </option>
                              <option>Bangladeshi</option>
                              <option>Canadian</option>
                              <option>English</option>
                              <option>Indian</option>
                              <option>Pakistani</option>
                              <option>Nepali</option>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_EDU_QUALIFICATION">Edu Qualification :</label>
                            <select name="PBI_EDU_QUALIFICATION" class="form-control">
                              <option></option>
                              <? foreign_relation('edu_qua','EDU_QUA_DESC','EDU_QUA_DESC',$PBI_EDU_QUALIFICATION,' 1 order by EDU_QUA_DESC');?>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="institute_id">Institutes :</label>
                            <select name="institute_id" id="institute_id" class="form-control">
                              <option></option>
                              <? foreign_relation('university','UNIVERSITY_CODE','UNIVERSITY_NAME',$institute_id);?>
                            </select>
                          </div>
                          <div class="col-md-3 form-group">
                            <label class="label" for="PBI_MOBILE">Mobile :</label>
                            <input name="PBI_MOBILE" type="text" id="PBI_MOBILE" class="form-control" value="<?=$PBI_MOBILE?>"/>
                          </div>
                          <div class="col-md-3 form-group">
                            <label class="label" for="PBI_PHONE">Phone :</label>
                            <input name="PBI_PHONE" type="text" id="PBI_PHONE" class="form-control" value="<?=$PBI_PHONE?>" />
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_EMAIL">E-mail :</label>
                            <input name="PBI_EMAIL" type="text" id="PBI_EMAIL" value="<?=$PBI_EMAIL?>" class="form-control" />
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_PERMANENT_ADD">Permanent Add :</label>
                            <input name="PBI_PERMANENT_ADD" type="text" id="PBI_PERMANENT_ADD" class="form-control" value="<?=$PBI_PERMANENT_ADD?>"/>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_POB">Division :</label>
                            <select name="division" class="form-control">
                              <option value="<?=$division?>">
                              <?=$division?>
                              </option>
                              <? foreign_relation('division','division_name','division_name',$division,' 1 order by division_name');?>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_BLOOD_GROUP">Blood Group :</label>
                            <input name="PBI_BLOOD_GROUP" type="text" id="PBI_BLOOD_GROUP" value="<?=$PBI_BLOOD_GROUP?>" class="form-control" />
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_PRESENT_ADD">Present Add :</label>
                            <input name="PBI_PRESENT_ADD" type="text" id="PBI_PRESENT_ADD" class="form-control" value="<?=$PBI_PRESENT_ADD?>"/>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_DOB">Date Of Birth : </label>
                            <input name="PBI_DOB" type="text" id="PBI_DOB" value="<?=$PBI_DOB?>" class="form-control"/>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_POB">Place Of Birth (District) :</label>
                            <select name="PBI_POB" class="form-control">
                              <option value="<?=$PBI_POB?>">
                              <?=$PBI_POB?>
                              </option>
                              <? foreign_relation('district_list','district_name','district_name',$PBI_POB,' 1 order by district_name');?>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_POB">Zone :</label>
                            <select name="PBI_ZONE" class="form-control">
                              <option value="<?=$PBI_ZONE?>">
                              <?=$PBI_ZONE?>
                              </option>
                              <? foreign_relation('district_list','district_name','district_name',$PBI_ZONE,' 1 order by district_name');?>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_POB">Area :</label>
                            <select name="PBI_AREA" class="form-control">
                              <option value="<?=$PBI_AREA?>">
                              <?=$PBI_AREA?>
                              </option>
                              <? foreign_relation('area','AREA_NAME','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');?>
                            </select>
                          </div>
                        </div>
                        <div class="row"> </div>
                        <!--Card END-->
                      </div>
                    </div>
                    <div class="card">
                      <div style="font-weight:bold; font-size:16px; background-color:#1D3195; z-index: 0!important; text-transform:uppercase; color:#fff" class="card-header">
                        <center>
                          Office Information Section
                        </center>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_ORG">Organization : </label>
                            <select  id="PBI_ORG" class="form-control" name="PBI_ORG">
                              <? foreign_relation('user_group','id','group_name',$PBI_ORG,' 1');?>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="DEPT_ID">Department : </label>
                            <select name="DEPT_ID" id="DEPT_ID" class="form-control">
                              <? foreign_relation('department','DEPT_ID','DEPT_DESC',$DEPT_ID,' 1 order by DEPT_DESC');?>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="DESG_ID">Designation : </label>
                            <select name="DESG_ID" id="DESG_ID" class="form-control">
                              <option></option>
                              <? foreign_relation('designation','DESG_ID','DESG_DESC',$DESG_ID,'1 order by DESG_DESC');?>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_SERVICE_LENGTH">Service Length: </label>
                            <input name="PBI_SERVICE_LENGTH" type="text" id="PBI_SERVICE_LENGTH"  class="form-control"











value="<?=$PBI_SERVICE_LENGTH?>" readonly="readonly">
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_APPOINTMENT_LETTER_DATE">Appointment Date :</label>
                            <input name="PBI_APPOINTMENT_LETTER_DATE" type="text" id="PBI_APPOINTMENT_LETTER_DATE" value="<?=$PBI_APPOINTMENT_LETTER_DATE?>"  class="form-control"/>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_DOJ">Joining Date :</label>
                            <input name="PBI_DOJ" type="date" id="PBI_DOJ" value="<?=$PBI_DOJ?>" class="form-control"  onchange="add_date(this.value)"/>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_DOC2">Confirm Date :</label>
                            <input name="PBI_DOC2" type="text" id="PBI_DOC2" value="<?=$PBI_DOC2?>" class="form-control" />
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_CON_TYPE">Confirm Duration :</label>
                            <select name="PBI_CON_TYPE" id="PBI_CON_TYPE" class="form-control">
                              <option value="6" <?= ($PBI_CON_TYPE==6)?'selected':''?>>6 Monthes</option>
                              <option value="3" <?= ($PBI_CON_TYPE==3)?'selected':''?>>3 Monthes</option>
                              <!-- <option value="0" <?= ($PBI_CON_TYPE==0)?'selected':''?>>Confirmed Position</option>-->
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_CON_POLICY">Confirm Type :</label>
                            <select name="PBI_CON_POLICY" id="PBI_CON_POLICY" class="form-control">
                              <option ></option>
                              <option value="ACR" <?= ($PBI_CON_POLICY=='ACR')?'selected':''?>>ACR</option>
                              <option value="Policy" <?= ($PBI_CON_POLICY=='Policy')?'selected':''?>>Policy</option>
                            </select>
                          </div>
                          <!--<div class="col-md-2 form-group">











<label class="label" for="PBI_APPOINTMENT_LETTER_NO">Appointment Letter :</label>











<input name="PBI_APPOINTMENT_LETTER_NO" type="text" id="PBI_APPOINTMENT_LETTER_NO" value="<?=$PBI_APPOINTMENT_LETTER_NO?>" class="form-control" />











</div>-->
                          <div class="col-md-3 form-group">
                            <label class="label" for="PBI_SPECIALTY">Leave Rule Manage :</label>
                            <select name="LEAVE_RULE_ID" id="LEAVE_RULE_ID" class="form-control">
                              <option></option>
                              <option value="1">General</option>
                            </select>
                          </div>
                          <div class="col-md-3 form-group">
                            <label class="label" for="PBI_SPECIALTY">Area Of Expertise :</label>
                            <input name="PBI_SPECIALTY" type="text" id="PBI_SPECIALTY" value="<?=$PBI_SPECIALTY?>" class="form-control" />
                          </div>
                          <div class="col-md-2 form-group"> </div>
                        </div>
                        <div class="row"> </div>
                        <div class="row"> </div>
                        <div class="row">
                          <div class="col-md-2 form-group">
                            <label class="label" for="JOB_LOCATION">Job Location :</label>
                            <select name="JOB_LOC_ID" id="JOB_LOC_ID"  class="form-control"  >
                              <option></option>
                              <option <?=($JOB_LOC_ID==1)? 'selected' : '' ?> value="1">Head Office</option>
                              <option <?=($JOB_LOC_ID==2)? 'selected' : '' ?> value="2">Factory</option>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_JOB_STATUS">Job Status :</label>
                            <select name="PBI_JOB_STATUS" class="form-control">
                              <option <?=($PBI_JOB_STATUS=='In Service')?'selected':'';?>>In Service</option>
                              <option <?=($PBI_JOB_STATUS=='Not In Service')?'selected':'';?>>Not In Service</option>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="PBI_BRANCH">Branch :</label>
                            <select name="PBI_BRANCH" id="PBI_BRANCH" class="form-control">
                              <option></option>
                              <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH);?>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="incharge_id">Incharge ID :</label>
                            <select name="incharge_id" id="incharge_id" class="form-control">
                              <option></option>
                              <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$incharge_id,' 1 order by PBI_NAME asc');?>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="employee_type">Roster Type :</label>
                            <select name="employee_type" id="employee_type" class="form-control" >
                              <option></option>
                              <option selected="selected">
                              <?=$employee_type?>
                              </option>
                              <option>Roster</option>
                              <option>Non Roster</option>
                              <option>Direct Portal</option>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="define_schedule">Define Schedule :</label>
                            <select name="define_schedule" id="define_schedule" class="form-control" >
                              <option></option>
                              <? foreign_relation('hrm_schedule_info','id','schedule_name',$define_schedule,' 1');?>
                            </select>
                          </div>
                        </div>
                        <div class="row" >
                          <div class="col-md-2 form-group">
                            <label class="label" for="grace_type"> Schedule Type :</label>
                            <select name="schedule_type" id="schedule_type">
                              <option selected="selected">
                              <?=$schedule_type?>
                              </option>
                              <option>Regular</option>
                              <option>Roster</option>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="define_offday">Punch Type :</label>
                            <select name="punch_type" id="punch_type" class="form-control">
                              <option selected="selected">
                              <?=$punch_type?>
                              </option>
                              <option>Regular</option>
                              <option>Regular</option>
                              <option>Single</option>
                              <option>No Punch</option>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="grace_type">Grace Type :</label>
                            <select name="grace_type" id="grace_type" class="form-control" >
                              <option selected="selected">
                              <?=$grace_type?>
                              </option>
                              <option>No Grace</option>
                              <option>Single Punch Grace</option>
                              <option>General Grace</option>
                              <option>Production Grace</option>
                            </select>
                          </div>
                          <div class="col-md-2 form-group">
                            <label class="label" for="define_offday">Define Offday :</label>
                            <select name="define_offday" id="define_offday" class="form-control" >
                              <option selected="selected">
                              <?=$define_offday?>
                              </option>
                              <option>Friday</option>
                              <option>Saterday</option>
                              <option>Sunday</option>
                              <option>Monday</option>
                              <option>Tuesday</option>
                              <option>Wednesday</option>
                              <option>Thursday</option>
                            </select>
                          </div>
                          <div class="col-md-4 form-group">
                            <label class="label" for="define_offday">Employment Type :</label>
                            <select name="EMPLOYMENT_TYPE" id="EMPLOYMENT_TYPE" class="form-control">
                              <option selected="selected">
                              <?=$EMPLOYMENT_TYPE?>
                              </option>
                              <option>Contractual</option>
                              <option>Casual Staff</option>
                              <option>Probationary</option>
                              <option>Permanent</option>
                              <option>Temporary</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--CARD START -->
                    <div class="card">
                      <div style="font-weight:bold; font-size:16px; background-color:#1D3195; z-index: 0!important; text-transform:uppercase; color:#fff" class="card-header">
                        <center>
                          Bank Information Section
                        </center>
                      </div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-4 form-group">
                            <label class="label" for="nid">National ID :</label>
                            <input name="nid" type="text" id="nid" value="<?=$nid?>" class="form-control" />
                          </div>
                          <div class="col-md-4 form-group">
                            <label class="label" for="nid">Bank Name :</label>
                            <input name="PBI_BANK" type="text" id="PBI_BANK" value="<?=$PBI_BANK?>" class="form-control" />
                          </div>
                          <div class="col-md-4 form-group">
                            <label class="label" for="nid">Swift Code:</label>
                            <input name="PBI_BANK_SWIFT" type="text" id="PBI_BANK_SWIFT" value="<?=$PBI_BANK_SWIFT?>" class="form-control" />
                          </div>
                          <div class="col-md-4 form-group">
                            <label class="label" for="nid">Account Number :</label>
                            <input name="PBI_BANK_ACC_NO" type="text" id="PBI_BANK_ACC_NO" value="<?=$PBI_BANK_ACC_NO?>" class="form-control" />
                          </div>
                          <div class="col-md-4 form-group">
                            <label class="label" for="nid">Branch:</label>
                            <input name="PBI_BANK_BRANCH" type="text" id="PBI_BANK_BRANCH" value="<?=$PBI_BANK_BRANCH?>" class="form-control" />
                          </div>
                          <div class="col-md-4 form-group">
                            <label class="label" for="nid">Account Name :</label>
                            <input name="PBI_BANK_ACC_NAME" type="text" id="PBI_BANK_ACC_NAME" value="<?=$PBI_BANK_ACC_NAME?>" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--------Reference Card Start------>
                    <div class="card">
                      <div style="font-weight:bold; font-size:16px; background-color:#1D3195; z-index: 0!important;  text-transform:uppercase; color:#fff" class="card-header">
                        <center>
                          Employee File Upload
                        </center>
                      </div>
                      <div class="card-body" style="background-color: #f5f5f5 !important;">
                        <div class="row">
                          <div class="col-md-3 form-group">
                            <label class="label" for="pic">Employee Picture :</label>
                            <input type="file" name="PBI_PICTURE_ATT_PATH" id="PBI_PICTURE_ATT_PATH" accept="image/jpeg" class="form-control" style="opacity:3!important;position:initial;" />
                          </div>
                          <div class="col-md-3 form-group">
                            <label class="label" for="pic">NID :</label>
                            <input type="file" name="PBI_NID_ATT_PATH" id="PBI_NID_ATT_PATH" accept="image/jpeg" class="form-control" style="opacity:3!important;position:initial;" />
                          </div>
                          <div class="col-md-3 form-group">
                            <label class="label" for="pic">Passport :</label>
                            <input name="PBI_PASSPORT_ATT_PATH" type="file" id="PBI_PASSPORT_ATT_PATH" accept="image/jpeg" class="form-control" style="opacity:3!important;position:initial;"/>
                          </div>
                          <div class="col-md-3 form-group">
                            <label class="label" for="pic">TIN :</label>
                            <input name="tin_pic" type="file" id="tin_pic" class="form-control" style="opacity:3!important;position:initial;"/>
                          </div>
                        </div>
                        <div class="oe_form_group_row">
                          <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                          <td colspan="2"  class="oe_form_group_cell">&nbsp;</td>
                          <td  class="oe_form_group_cell_label oe_form_group_cell">&nbsp;</td>
                          <td  class="oe_form_group_cell">&nbsp;</td>
                        </div>
                        <div class="row">
                          <div class="col-md-3 form-group">
                            <label class="label" for="pic">Employee Picture</label>
                          </div>
                          <div class="col-md-3 form-group">
                            <label class="label" for="pic">NID</label>
                          </div>
                          <div class="col-md-3 form-group">
                            <label class="label" for="pic">Passport</label>
                          </div>
                          <div class="col-md-3 form-group">
                            <label class="label" for="pic">TIN</label>
                          </div>
                        </div>
                        <?











if ($_SESSION['employee_selected']!=''){











//Employee Pic











$imgJPG = "../../pic/staff/".$_SESSION['employee_selected'].".JPG";











$imgjpg = "../../pic/staff/".$_SESSION['employee_selected'].".jpg";











$imgPNG = "../../pic/staff/".$_SESSION['employee_selected'].".PNG";











$imgJPEG = "../../pic/staff/".$_SESSION['employee_selected'].".jpeg";











if(file_exists($imgJPEG)){











$link = $imgJPEG;











}elseif(file_exists($imgJPG)){











$link = $imgJPG;











}elseif(file_exists($imgjpg)){











$link = $imgjpg;











}elseif(file_exists($imgJPEG)){











$link = $imgJPEG;











}











//Employee Nid











$nidJPG = "../../pic/nid/".$_SESSION['employee_selected'].".JPG";











$nidjpg = "../../pic/nid/".$_SESSION['employee_selected'].".jpg";











$nidPNG = "../../pic/nid/".$_SESSION['employee_selected'].".PNG";











$nidJPEG = "../../pic/nid/".$_SESSION['employee_selected'].".jpeg";











$nidPDF = "../../pic/nid/".$_SESSION['employee_selected'].".pdf";











if(file_exists($nidJPG)){











$nid_link = $nidJPG;











}elseif(file_exists($nidjpg)){











$nid_link = $nidjpg;











}elseif(file_exists($nidPNG)){











$nid_link = $nidPNG;











}elseif(file_exists($nidJPEG)){











$nid_link = $nidJPEG;











}elseif(file_exists($nidPDF)){











$nid_link = $nidPDF;











}











//Employee Tin











$tinJPG = "../../pic/tin/".$_SESSION['employee_selected'].".JPG";

$tinjpg = "../../pic/tin/".$_SESSION['employee_selected'].".jpg";

$tinPNG = "../../pic/tin/".$_SESSION['employee_selected'].".PNG";

$tinJPEG = "../../pic/tin/".$_SESSION['employee_selected'].".jpeg";

$tinPDF = "../../pic/tin/".$_SESSION['employee_selected'].".pdf";



if(file_exists($tinJPG)){











$tin_link = $tinJPG;











}elseif(file_exists($tinjpg)){











$tin_link = $tinjpg;











}elseif(file_exists($tinPNG)){











$tin_link = $tinPNG;











}elseif(file_exists($tinJPEG)){











$tin_link = $tinJPEG;











}elseif(file_exists($tinPDF)){











$tin_link = $tinPDF;











}











//Employee Passport











$passportJPG = "../../pic/passport/".$_SESSION['employee_selected'].".JPG";











$passportjpg = "../../pic/passport/".$_SESSION['employee_selected'].".jpg";











$passportPNG = "../../pic/passport/".$_SESSION['employee_selected'].".PNG";











$passportJPEG = "../../pic/passport/".$_SESSION['employee_selected'].".jpeg";











$passportPDF = "../../pic/passport/".$_SESSION['employee_selected'].".pdf";











if(file_exists($passportJPG)){











$passport_link = $passportJPG;











}elseif(file_exists($passportjpg)){











$passport_link = $passportjpg;











}elseif(file_exists($passportPNG)){











$passport_link = $passportPNG;











}elseif(file_exists($passportJPEG)){
$passport_link = $passportJPEG;
}elseif(file_exists($passportPDF)){
$passport_link = $passportPDF;


}

}
?>
                        <div class="row">
                          <div class="col-md-3 form-group">
                            <? if($row->PBI_PICTURE_ATT_PATH!=""){  ?>
                            <a href="../../../assets/support/upload_view.php?name=<?=$row->PBI_PICTURE_ATT_PATH?>&folder=hrm_emp_pic" target="_blank" download> <img src="../../../assets/support/upload_view.php?name=<?=$row->PBI_PICTURE_ATT_PATH?>&folder=hrm_emp_pic" width="120" height="152" /></a>
                            <? }else{ ?>
                            <img src="../../pic/employee.png" width="150px" height=""/>
                            <? } ?>
                          </div>
                          <div class="col-md-3 form-group">
                            <? if($row->PBI_NID_ATT_PATH!=""){  ?>
                            <a href="../../../assets/support/upload_view.php?name=<?=$row->PBI_NID_ATT_PATH?>&folder=hrm_nid_pic" target="_blank" download> <img src="../../../assets/support/upload_view.php?name=<?=$row->PBI_NID_ATT_PATH?>&folder=hrm_nid_pic" width="120" height="152"/></a>
                            <? }else{ ?>
                            <img src="../../pic/nid.png" width="150px" height=""/>
                            <? } ?>
                          </div>
                          <div class="col-md-3 form-group">
                            <? if($row->PBI_PASSPORT_ATT_PATH!=""){  ?>
                            <a href="../../../assets/support/upload_view.php?name=<?=$row->PBI_PASSPORT_ATT_PATH?>&folder=hrm_passport_pic" target="_blank" download> <img src="../../../assets/support/upload_view.php?name=<?=$row->PBI_PASSPORT_ATT_PATH?>&folder=hrm_passport_pic" width="120" height="152" /></a>
                            <? }else{ ?>
                            <img src="../../pic/tin.png" width="150px" height=""/>
                            <? } ?>
                          </div>
                          <div class="col-md-3 form-group">
                            <? if($row->PBI_NID_ATT_PATH!=""){  ?>
                            <a href="<?=$passport_link?>" target="_blank" download><img src="<?=$passport_link?>" width="120" height="152"/></a>
                            <? }else{ ?>
                            <img src="../../pic/passport.png" width="150px" height=""/>
                            <? } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--<div class="row"> 











<div class="col-md-3 form-group">











<label class="label" for="pic">Employee Picture :</label>		











<input type="file" name="pic" id="pic" accept="image/jpeg" class="form-control" /> 











</div>	</div>-->
                    <!--











new images upload option











-->
                    <!--end-->
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
  </div>
</form>
<?

require_once SERVER_CORE."routing/layout.bottom.php";



?>
