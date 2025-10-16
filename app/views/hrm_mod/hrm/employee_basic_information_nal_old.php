<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);






if(isset($_POST['employee_selected'])) {
$pbiCode = $_POST['employee_selected'];

$_SESSION['employee_selected'] = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$pbiCode.'"');
$_SESSION['PBI_CODE'] = $pbiCode;


} 





if(isset($_POST['button'])){

$_SESSION['employee_selected'] = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['employee_selected'].'"');
$_SESSION['PBI_CODE'] = $_POST['employee_selected'];

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

do_calander('#child1_dob');
do_calander('#child2_dob');
do_calander('#child3_dob');
do_calander('#child4_dob');

do_calander('#PBI_DOC');

do_calander('#PBI_DOC2');

do_calander('#PBI_DOJ');
do_calander('#PBI_APPOINTMENT_LETTER_DATE');

do_calander('#resign_date');

do_calander('#JOB_STATUS_DATE');

// ::::: End Edit Section :::::

$crud      =new crud($table);

$image_path = find_all_field('personnel_basic_info','','PBI_ID="'.$_SESSION['employee_selected'].'"');

$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);


if($required_id>0)


$$unique = $_GET[$unique] = $required_id;



if(isset($_POST[$shown]))


{ if(isset($_POST['insert'])) {		
$_POST['PBI_ID']= $_POST['PBI_ID'];
$_POST['PBI_CODE']= $_POST['PBI_CODE'];
$due_date = date("Y-m-d", strtotime($_POST['PBI_DOJ']."+".$_POST['PBI_CON_TYPE']." months"));
$_REQUEST['PBI_DUE_DOJ']=$due_date;
$_REQUEST['PBI_DEPARTMENT'] = find_a_field('department','DEPT_DESC','DEPT_ID='.$_REQUEST['DEPT_ID']);
$_REQUEST['PBI_DESIGNATION'] = find_a_field('designation','DESG_DESC','DESG_ID='.$_REQUEST['DESG_ID']);
$interval = date_diff(date_create(date('Y-m-d')), date_create($_POST['PBI_DOJ']));
$service_length =  $interval->format("%Y Year, %M Months, %d Days");
$_POST['PBI_SERVICE_LENGTH'] = $service_length;
$folder='hrm_emp_pic'; 
$field = 'PBI_PICTURE_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';
$file_name = $folder.'-'.$_SESSION['employee_selected'];
if($_FILES['PBI_PICTURE_ATT_PATH']['tmp_name']!=''){
$_POST['PBI_PICTURE_ATT_PATH']=upload_file($folder,$field,$file_name);
}











//////////NID////////////////







//$path_nid='../../pic/nid';







if($_FILES['PBI_NID_ATT_PATH']['tmp_name']!=''){




$folder='hrm_nid_pic'; 

$field = 'PBI_NID_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';

$file_name = $folder.'-'.$_SESSION['employee_selected'];

if($_FILES['PBI_NID_ATT_PATH']['tmp_name']!=''){

$_POST['PBI_NID_ATT_PATH']=upload_file($folder,$field,$file_name);



}



}



//////////TIN////////////////

// $path_tin='../../pic/tin';

// if($_FILES['tin_pic']['tmp_name']!=''){

// $file_name2= $_FILES['tin_pic']['name'];

// $file_tmp2= $_FILES['tin_pic']['tmp_name'];

// $ext2=end(explode('.',$file_name2));


// $path_tin='../../pic/tin/';


// $uploaded_file2 = $path_tin.$_SESSION['employee_selected'].'.'.$ext2;


// $_POST['tin_pic'] = $uploaded_file2;


// move_uploaded_file($file_tmp2, $path_tin.$_SESSION['employee_selected'].'.'.$ext2);


if($_FILES['PBI_TIN_ATT_PATH']['tmp_name']!=''){

  $folder='tin_pic'; 
  $field = 'PBI_TIN_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';
  
  $file_name = $folder.'-'.$_SESSION['employee_selected'];
  
  
  if($_FILES['PBI_TIN_ATT_PATH']['tmp_name']!=''){
  
  
  
  $_POST['PBI_TIN_ATT_PATH']=upload_file($folder,$field,$file_name);
  
}
  


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



	

	//////////CV////////////////



if($_FILES['PBI_CV_ATT_PATH']['tmp_name']!=''){



$folder='hrm_cv'; 



$field = 'PBI_CV_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';



$file_name = $folder.'-'.$_SESSION['employee_selected'];



if($_FILES['PBI_CV_ATT_PATH']['tmp_name']!=''){



$_POST['PBI_CV_ATT_PATH']=upload_file($folder,$field,$file_name);



}



}




  $entry_by = $_SESSION['user']['id'];
  $last_id  = find_a_field('hrm_roster_assign','id','PBI_ID="'.$_POST['PBI_ID'].'"');
  
  
  if($_POST['PBI_DOJ']>0){
  $joining_date  = $_POST['PBI_DOJ'];
  }else{
  $joining_date  = date('Y-m-d');
  }
  
  
 if (empty($last_id) && isset($_POST['define_schedule']) && isset($joining_date)) {
    $att_sql = "INSERT INTO hrm_roster_assign (PBI_ID,roster_start_date,roster_end_date,shedule_1,entry_by) 
        VALUES ('".$_POST['PBI_ID']."','".$joining_date."', '2030-10-31' , '".$_POST['define_schedule']."','$entry_by')";
        $att_query = db_query($att_sql);
       } 




	//////////OTHER////////////////
if($_FILES['PBI_OTHER_ATT_PATH']['tmp_name']!=''){
$folder='hrm_other'; 
$field = 'PBI_OTHER_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';
$file_name = $folder.'-'.$_SESSION['employee_selected'];
if($_FILES['PBI_OTHER_ATT_PATH']['tmp_name']!=''){
$_POST['PBI_OTHER_ATT_PATH']=upload_file($folder,$field,$file_name);
}
}

$_POST['PBI_DESIGNATION']=find_a_field('designation','DESG_DESC','DESG_ID="'.$_POST['DESG_ID'].'"');
$_POST['PBI_DEPARTMENT']=find_a_field('department','DEPT_DESC','DEPT_ID="'.$_POST['DEPT_ID'].'"');

$_POST['joining_designation']= $_POST['DESG_ID'];


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



if(isset($_POST['update'])){





	$_REQUEST['PBI_DEPARTMENT'] = find_a_field('department','DEPT_SHORT_NAME','DEPT_ID='.$_REQUEST['DEPT_ID']);



	$_REQUEST['PBI_DESIGNATION'] = find_a_field('designation','DESG_SHORT_NAME','DESG_ID='.$_REQUEST['DESG_ID']);

	//$due_date_d=$_POST['PBI_CON_TYPE']-1;



	$due_date = date("Y-m-d", strtotime($_POST['PBI_DOJ']."+".$_POST['PBI_CON_TYPE']." months"));



	$_REQUEST['PBI_DUE_DOJ']=$due_date;



	$_POST['PBI_DESIGNATION']=find_a_field('designation','DESG_DESC','DESG_ID="'.$_POST['DESG_ID'].'"');



	$_POST['PBI_DEPARTMENT']=find_a_field('department','DEPT_DESC','DEPT_ID="'.$_POST['DEPT_ID'].'"');

	 
   $entry_by = $_SESSION['user']['id'];
  $last_id  = find_a_field('hrm_roster_assign','id','PBI_ID="'.$_SESSION['employee_selected'].'"');
  
  if($_POST['PBI_DOJ']>0){
  $joining_date  = $_POST['PBI_DOJ'];
  }else{
  $joining_date  = date('Y-m-d');
  }
  
  
 if (empty($last_id) && isset($_POST['define_schedule']) && isset($joining_date)) {
   $att_sql = "INSERT INTO hrm_roster_assign (PBI_ID,roster_start_date,roster_end_date,shedule_1,entry_by) 
        VALUES ('".$_SESSION['employee_selected']."','".$joining_date."', '2030-10-31' , '".$_POST['define_schedule']."','$entry_by')";
        $att_query = db_query($att_sql);
       } 


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
	//////////TIN////////////////



	if($_FILES['PBI_TIN_ATT_PATH']['tmp_name']!=''){



	$folder='tin_pic'; 



	$field = 'PBI_TIN_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';



	$file_name = $folder.'-'.$_SESSION['employee_selected'];



	if($_FILES['PBI_TIN_ATT_PATH']['tmp_name']!=''){



		$_POST['PBI_TIN_ATT_PATH']=upload_file($folder,$field,$file_name);



		}

	}



	//////////OTHER////////////////



	if($_FILES['PBI_OTHER_ATT_PATH']['tmp_name']!=''){



	$folder='hrm_other'; 



	$field = 'PBI_OTHER_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';



	$file_name = $folder.'-'.$_SESSION['employee_selected'];



	if($_FILES['PBI_OTHER_ATT_PATH']['tmp_name']!=''){



		$_POST['PBI_OTHER_ATT_PATH']=upload_file($folder,$field,$file_name);



		}



	}





	//////////CV////////////////



	if($_FILES['PBI_CV_ATT_PATH']['tmp_name']!=''){



	$folder='hrm_cv'; 



	$field = 'PBI_CV_ATT_PATH';  //'PBI_PICTURE_ATT_PATH';



	$file_name = $folder.'-'.$_SESSION['employee_selected'];



	if($_FILES['PBI_CV_ATT_PATH']['tmp_name']!=''){



		$_POST['PBI_CV_ATT_PATH']=upload_file($folder,$field,$file_name);



		}

	}



	$interval = date_diff(date_create(date('Y-m-d')), date_create($_POST['PBI_DOJ']));



	$service_length =  $interval->format("%Y Year, %M Months, %d Days");



	$_POST['PBI_SERVICE_LENGTH'] = $service_length;



	$crud->update($unique);



	$type=1;



}



}



if(isset($$unique)){



$condition=$unique."=".$$unique;





$data=db_fetch_object($table,$condition);



foreach($data as $key => $value)



{ $$key=$value;}



}



$max_pbi_code = find_a_field('personnel_basic_info','max(PBI_CODE)','PBI_CODE like "%UBSL3%"');


$new = explode("UBSL",$max_pbi_code);


$max_id =  $new[1];



$new_pbi_code = $max_id+1;


$new_pbi_code = 'UBSL'.$new_pbi_code;


?>
<script type="text/javascript"> function DoNav(lk){

return GB_show('ggg', '<?SERVER_ROOT?>app/views/hrm_mod/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)


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
<script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../../assets/js/popper.min.js"></script>
<script type="text/javascript" src="../../../assets/js/jquery-3.4.1.min.js"></script>
<style type="text/css">

.style1{color: #FF0000;}

.oe_form_group_cell{padding:8px;}

.label {font-weight:bold;}

.new-color{ 
    /*background-color: #F0F1F3 !important;*/
    background-color: #E3F1FD !important;
}

.new-bg-color{
    background-color: white;
    border-radius: 6px;
    padding-top: 1rem !important;
    padding-bottom: 1rem !important;
}

.h_titel{
    background-color: #81C8FF !important;
    color: #333;
}

.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color:#fff !important;
    /*background-color: #31c971 !important;*/
    background-color: #004d89 !important;
    border-radius: 0px;
} 
.search-bgc{
    background-color: #81c8ff !important;
    color: #333 !important;
}

.new-sr .nav-item{
   border: 1px solid #7a7a7a;
}
.nav-item .nav-link:hover, .nav-pills .nav-link.active:hover, .nav-pills .show>.nav-link:hover {
    background-color: #81c8ff !important;
    color: #333 !important;
    border-radius: 0px;
}

</style>
<form action="" method="post" enctype="multipart/form-data">
  <div class="oe_view_manager oe_view_manager_current">
    <? include('../common/title_bar.php');?>
    <? //include('../common/title_bar_new.php');?>
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
                <div class="oe_form_sheetbg" style="margin-top:-10px">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <div class="padding sr">
                      <div class="row p-0 m-0">
                        <div class="col-lg-12 col-lg-12 p-0">
                          <div class="mt-3 mb-0" data-sr-id="2"  style=" zoom: 77%; visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s; border-radius: 0px !important; border: 0px !important; background-color: #fff; box-shadow: none !important;">
                            <div class="d-flex">
                              <ul class="nav new-sr nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#" data-toggle="tab" data-target="#tab_1" style="color:#333;font-weight:bold"> <i class="fa-solid fa-pen-to-square"></i> EMPLOYEE </a></li>
                                <!--<li class="nav-item"><a class="nav-link" href="#" data-toggle="tab" data-target="#tab_2" style="color:#333;font-weight:bold"> <i class="fa-solid fa-envelope-open"></i>  ADDRESS</a></li>-->

 <li class="nav-item"><a class="nav-link" href="#" data-toggle="tab" data-target="#tab_3" style="color:#333;font-weight:bold"> <i class="fa-solid fa-business-time"></i> WORK</a></li>
 
  <li class="nav-item"><a class="nav-link" href="#" data-toggle="tab" data-target="#tab_6" style="color:#333;font-weight:bold"> <i class="fa-regular fa-clock"></i> SHIFT & CALENDAR</a></li>
                                
 <!--<li class="nav-item"><a class="nav-link" href="../payroll/salary_information.php" style="color:#333;font-weight:bold"> <i class="fa-regular fa-folder-open"></i> SALARY (MGT) </a> </li>-->
 
 <li class="nav-item"><a class="nav-link" href="../salary_config/salary_info.php" style="color:#333;font-weight:bold"> <i class="fa-regular fa-folder-open"></i> SALARY </a> </li>
 
  <li class="nav-item"><a class="nav-link" href="#" data-toggle="tab" data-target="#tab_2" style="color:#333;font-weight:bold"> <i class="fa-solid fa-envelope-open"></i> PERSONAL INFORMATION </a></li>
 

 
 <li class="nav-item"><a class="nav-link" href="#" data-toggle="tab" data-target="#tab_4" style="color:#333;font-weight:bold"> <i class="fa-solid fa-person-chalkboard"></i> EMPLOYEE RELIEVING INFO</a></li>

 <li class="nav-item"><a class="nav-link" href="#" data-toggle="tab" data-target="#tab_5" style="color:#333;font-weight:bold"> <i class="fa-solid fa-chart-user"></i> REFERANCE</a></li>
                                <li class="nav-item"><a class="nav-link" href="#" data-toggle="tab" data-target="#tab_7" style="color:#333;font-weight:bold"> <i class="fa-regular fa-folder-open"></i> FILES UPLOAD</a></li>
                                <!--<li class="nav-item"><a class="nav-link" href="#" data-toggle="tab" data-target="#tab_7" style="color:#e91e63;font-weight:bold"> <i class="fa-regular fa-folder-open"></i> FILES UPLOAD</a></li>-->
                              </ul>
                            </div>
                          </div>
                          <div class="tab-content" style="border: 1px solid #005395; padding: 0px 10px; border-radius: 0px 0px 5px 5px;">
                            <div class="tab-pane fade active show" id="tab_1">
                              <div class="card">
                                <div  class="h_titel">
                                  <center>
                                    Employee
                                  </center>
                                </div>
                                <div class="card-body new-color">
                                  <div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                      <div class="container new-bg-color">
                                        <div class="form-group row m-0 pb-1">
                                          <label  for="PBI_ID" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center req-input pr-1 bg-form-titel-text">
                                              ID NO : </label>
                                          <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                             <input name="PBI_ID" type="hidden" id="PBI_ID" 
                                            value="<? if($PBI_ID>0) echo $PBI_ID; else echo find_a_field('personnel_basic_info','max(MACHINE_ID)+1','1');?>"/>
                                            
                                            <input   name="PBI_CODE" type="text" id="PBI_CODE" required="required" 
                                            value="<?=$PBI_CODE;?>" />
                                        
                                            <input name="PBI_ID" type="hidden" id="PBI_ID" 
                                            value="<? if($PBI_ID>0) echo $PBI_ID; else echo find_a_field('personnel_basic_info','max(MACHINE_ID)+1','1');?>" class="form-control"/>
                                          </div>
                                        </div>
                                        
                                        <div class="form-group row m-0 pb-1">
                                          <label for="MACHINE_ID" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start req-input align-items-center pr-1 bg-form-titel-text">
                                               Employee Code : </label>
                                          <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <input   name="MACHINE_ID" class="form-control"  type="text" id="MACHINE_ID" 
                                            value="<?  if($MACHINE_ID>0) echo $MACHINE_ID; else echo find_a_field('personnel_basic_info','max(MACHINE_ID)+1','1');?>" />
                                          </div>
                                        </div>
                                        <div class="form-group row m-0 pb-1">
                                          <label for="PBI_NAME" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Employee Name : </label>
                                          <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <input   name="PBI_NAME" class="form-control"  type="text" required="required" id="PBI_NAME" value="<?=$PBI_NAME?>"/>
                                          </div>
                                        </div>
                                        <div class="form-group row m-0 pb-1">
                                          <label for="last name" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Nickname : </label>
                                          <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <input   name="last_name" class="form-control"  type="text" id="last_name" value="<?=$last_name?>"/>
                                          </div>
                                        </div>
                                        <div class="form-group row m-0 pb-1">
                                          <label for="PBI_DOB" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Date Of Birth : </label>
                                          <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <input name="PBI_DOB" type="date"  id="birthdate" value="<?=$PBI_DOB?>" class="form-control"  autocomplete="off" onChange="calculateAge()"/>
                                          </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row m-0 pb-1">
                                          <label  for="PBI_SEX" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Gender : </label>
                                          <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <select name="PBI_SEX" class="form-control" required="required">
                                              <option selected>
                                              <?=(isset($PBI_SEX))?$PBI_SEX:'Male';?>
                                              </option>
                                              <option>Male</option>
                                              <option>Female</option>
                                            </select>
                                          </div>
                                        </div>
                                        
                                        
                                        <div class="form-group row m-0 pb-1">
                                          <label for="PBI_RELIGION" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Religion : </label>
                                          <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <select name="PBI_RELIGION" class="form-control" required="required">
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
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                      <div class="container new-bg-color">
                                        <div class="form-group row m-0 pb-1">
                                          <label  for="PBI_EMAIL" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Work E-mail : </label>
                                          <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <input name="PBI_EMAIL" type="email" id="PBI_EMAIL" value="<?=$PBI_EMAIL?>" class="form-control" />
                                          </div>
                                        </div>
                                        
                                        <div class="form-group row m-0 pb-1">
                                          <label for="PBI_PHONE" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Work Cell No: </label>
                                          <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <input name="PBI_PHONE" type="text" id="PBI_PHONE" class="form-control" value="<?=$PBI_PHONE?>" />
                                          </div>
                                        </div>
                                        
                                        <div class="form-group row m-0 pb-1">
                                          <label  for="PBI_SEX" 
                                          class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Sim Type : </label>
                                          <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <select name="cell_no_traking" class="form-control">
                                             
                                              <option><?=$cell_no_traking?></option>
                                               <option></option>
                                              <option value="TRAKING">TRAKING</option>
                                              <option value="NON TRAKING">NON TRAKING</option>
                                            </select>
                                          </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="container-fluid p-0">
                                          <p>Employee Picture</p>
                                          <div class="mx-auto col-md-4">
                                            <? if($row->PBI_PICTURE_ATT_PATH!=""){  ?>
                                            <a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$row->PBI_PICTURE_ATT_PATH?>&folder=hrm_emp_pic&proj_id=<?=$_SESSION['proj_id']?>" target="_blank" download> <img src="<?=SERVER_CORE?>core/upload_view.php?name=<?=$row->PBI_PICTURE_ATT_PATH?>&folder=hrm_emp_pic&proj_id=<?=$_SESSION['proj_id']?>" width="120" height="160" /></a>
                                            <? }else{ ?>
                                            <img src="<?=SERVER_CORE?>core/hrm_emp_pic/employee.png" width="150px" height="160"/>
                                            <? } ?>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div/>
                                  </div>
                                  <!--Card END-->
                                </div>
                                <center style=" padding-top: 15px; ">
                                  <? include('../common/input_bar.php');?>
                                </center>
                              </div>
                            </div>
                            <!--end-->
                          </div>
                          <div class="tab-pane fade" id="tab_2">
                            <div class="card">
                              <div class="h_titel">
                                <center>
                                  PERSONAL INFORMATION
                                </center>
                              </div>
                              <div class="row m-0 new-color pt-3 pb-3">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                  <div class="container new-bg-color">
                                    <?php /*?>
                            <div class="form-group row m-0 pb-1">
								<label  for="PBI_ID" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center req-input pr-1 bg-form-titel-text"> Employee Code : </label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
								        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                        <input   name="PBI_CODE" type="text" id="PBI_CODE" value="<?=$PBI_CODE; //if($PBI_ID>0) echo $PBI_ID; else echo find_a_field('personnel_basic_info','max(PBI_ID)+1','1');?>" 
                                        <input name="PBI_ID" type="hidden" id="PBI_ID" value="<?=$PBI_ID?>" readonly="readonly" class="form-control"/>
                                        
								</div>
							</div>
							<?*/ ?>
                                    <!--                     <div class="form-group row m-0 pb-1">-->
                                    <!--	<label for="MACHINE_ID" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start req-input align-items-center pr-1 bg-form-titel-text">ID NO :  </label>-->
                                    <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                    <!--                             <input   name="MACHINE_ID" class="form-control"  type="text" id="MACHINE_ID" value="<?=$MACHINE_ID?>"/>-->
                                    <!--	</div>-->
                                    <!--</div>-->
                                    <!--                     <div class="form-group row m-0 pb-1">-->
                                    <!--	<label for="PBI_NAME" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">First Name :  </label>-->
                                    <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                    <!--                             <input   name="PBI_NAME" class="form-control"  type="text" id="PBI_NAME" value="<?=$PBI_NAME?>"/>-->
                                    <!--	</div>-->
                                    <!--</div>-->
                                    <!--                     <div class="form-group row m-0 pb-1">-->
                                    <!--	<label for="last name" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Last Name : </label>-->
                                    <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                    <!--                                 <input   name="last_name" class="form-control"  type="text" id="last_name" value="<?=$last_name?>"/>-->
                                    <!--	</div>-->
                                    <!--</div>-->
                                    <div class="form-group row m-0 pb-1">
                                      <label for="PBI_FATHER_NAME" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Father's Name : </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                        <input   name="PBI_FATHER_NAME" class="form-control"  type="text" id="PBI_FATHER_NAME" value="<?=$PBI_FATHER_NAME?>"/>
                                      </div>
                                    </div>
                                    <div class="form-group row m-0 pb-1">
                                      <label for="PBI_MOTHER_NAME" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Mother's Name : </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                        <input   name="PBI_MOTHER_NAME" class="form-control"  type="text" id="PBI_MOTHER_NAME" value="<?=$PBI_MOTHER_NAME?>"/>
                                      </div>
                                    </div>
                                    <!--                     <div class="form-group row m-0 pb-1">-->
                                    <!--	<label  for="PBI_SEX" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Gender : </label>-->
                                    <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                    <!--                                 <select name="PBI_SEX" class="form-control">-->
                                    <!--                                   <option selected>-->
                                    <!--                                   <?=(isset($PBI_SEX))?$PBI_SEX:'Male';?>-->
                                    <!--                                   </option>-->
                                    <!--                                   <option>Male</option>-->
                                    <!--                                   <option>Female</option>-->
                                    <!--                                 </select>-->
                                    <!--	</div>-->
                                    <!--</div>-->
                                    <!--                     <div class="form-group row m-0 pb-1">-->
                                    <!--	<label for="PBI_DOB" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Date Of Birth :  </label>-->
                                    <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                    <!--                             <input name="PBI_DOB" type="date" id="birthdate" value="<?=$PBI_DOB?>" class="form-control"  autocomplete="off" onChange="calculateAge()"/>-->
                                    <!--	</div>-->
                                    <!--</div>-->
                                    <div class="form-group row m-0 pb-1">
                                      <label for="spouse_name" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Spouse Name  : </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                        <input name="spouse_name" type="text" id="spouse_name" value="<?=$spouse_name?>" class="form-control" />
                                      </div>
                                    </div>
                                    <div class="form-group row m-0 pb-1">
                                      <label for="PBI_BLOOD_GROUP" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Blood Group : </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                        <select name="PBI_BLOOD_GROUP" class="form-control">
                                          <option selected="selected">
                                          <?=$PBI_BLOOD_GROUP?>
                                          </option>
                                          <option>O+</option>
                                          <option>O-</option>
                                          <option>A+</option>
                                          <option>A-</option>
                                          <option>B+</option>
                                          <option>B-</option>
                                          <option>AB+</option>
                                          <option>AB-</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group row m-0 pb-2">
                                      <label for="medical" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Height in cm : </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                        <input name="highte" type="text" id="highte" value="<?=$highte?>" class="form-control" />
                                      </div>
                                    </div>
                                    <div class="form-group row m-0 pb-2">
                                      <label for="medical" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Weight in kg : </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                        <input name="weight" type="text" id="weight" value="<?=$weight?>" class="form-control" />
                                      </div>
                                    </div>
                                    <div class="form-group row m-0 pb-1">
                                      <label  for="PBI_NATIONALITY" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Nationality : </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
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
                                    </div>
                                    <div class="form-group row m-0 pb-1">
                                      <label for="nid" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text req-input">National ID No. : </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                        <input name="nid" type="text" id="nid" value="<?=$nid?>" class="form-control" />
                                      </div>
                                    </div>
                                    <div class="form-group row m-0 pb-1">
                                      <label for="nid" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text req-input">Birth Registration No. : </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                        <input name="birth_reg_no" type="text" id="birth_reg_no" value="<?=$birth_reg_no?>" class="form-control" />
                                      </div>
                                    </div>
                                    
                                                                        
                                    <div class="form-group row m-0 pb-1">
                                      <label  for="PBI_EMAIL" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Hobbies & Interest: </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                        <textarea id="hobbies" name="hobbies" rows="2" class="form-control" style="font-weight:normal; font-size:12px;"> <?=$hobbies?> </textarea>
                                      </div>
                                    </div>
                                    
                                    <!--<div class="form-group row m-0 pb-1">-->
                                    <!--  <label for="PBI_EDU_QUALIFICATION" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Edu Qualification : </label>-->
                                    <!--  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                    <!--    <select name="PBI_EDU_QUALIFICATION" class="form-control">-->
                                    <!--      <option></option>-->
                                    <!--      <? foreign_relation('edu_qua','EDU_QUA_DESC','EDU_QUA_DESC',$PBI_EDU_QUALIFICATION,' 1 order by EDU_QUA_DESC');?>-->
                                    <!--    </select>-->
                                    <!--  </div>-->
                                    <!--</div>-->
                                    
                                    <!--<div class="form-group row m-0 pb-1">-->
                                    <!--  <label for="institute_id" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Institutes : </label>-->
                                    <!--  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                    <!--    <select name="institute_id" id="institute_id" class="form-control">-->
                                    <!--      <option></option>-->
                                    <!--      <? foreign_relation('university','UNIVERSITY_CODE','UNIVERSITY_NAME',$institute_id);?>-->
                                    <!--    </select>-->
                                    <!--  </div>-->
                                    <!--</div>-->
                                    
                                    
                                  </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                  <div class="container new-bg-color">
                                      
                                    <div class="form-group row m-0 pb-1">
                                    	<label for="PBI_MOBILE" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text req-input">Cell No  : </label>
                                    	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <input name="PBI_MOBILE" type="text" id="PBI_MOBILE" class="form-control" value="<?=$PBI_MOBILE?>"/>
                                    	</div>
                                    </div>		
                                      
                                                                            
                                    <div class="form-group row m-0 pb-1">
                                    	<label for="PBI_MOBILE" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text req-input">Email No  : </label>
                                    	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <input name="PBI_EMAIL_ALT" type="email" id="PBI_EMAIL_ALT" class="form-control" value="<?=$PBI_EMAIL_ALT?>"/>
                                    	</div>
                                    </div>
                                      
                                      
                                    <div class="form-group row m-0 pb-1">
                                      <label  for="PBI_MARITAL_STA" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Marital Status : </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                        <select name="PBI_MARITAL_STA" class="form-control">
                                          <option selected="selected">
                                          <?=$PBI_MARITAL_STA?>
                                          </option>
                                          <option>Married</option>
                                          <option>Unmarried</option>
                                          <option>Widowed</option>
                                          <option>Divorced</option>
                                        </select>
                                      </div>
                                    </div>

                                    
                                    <div class="form-group row m-0 pb-1">
                                      <label  for="PBI_EMAIL" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Marks of Identification </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                        <input name="note" type="text" id="note" value="<?=$note?>" class="form-control" />
                                      </div>
                                    </div>
                                    <div class="form-group row m-0 pb-1">
                                      <label  for="PBI_EMAIL" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Nominee : </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                        <input name="nominee" type="text" id="nominee" value="<?=$nominee?>" class="form-control" />
                                      </div>
                                    </div>
                                    <div class="form-group row m-0 pb-1">
                                      <label  for="PBI_EMAIL" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Relationship : </label>
                                      <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                        <input name="nominee_relation" type="text" id="nominee_relation" value="<?=$nominee_relation?>" class="form-control" />
                                      </div>
                                    </div>
                                    <div class="container-fluid p-0">
                                      <p>Nominee's Picture</p>
                                      <div class="mx-auto col-md-4">
                                        <? if($row->PBI_PASSPORT_ATT_PATH!=""){  ?>
                                        <a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$row->PBI_PASSPORT_ATT_PATH?>&folder=hrm_passport_pic&proj_id=<?=$_SESSION['proj_id']?>" target="_blank" download> <img src="<?=SERVER_CORE?>core/upload_view.php?name=<?=$row->PBI_PASSPORT_ATT_PATH?>&folder=hrm_passport_pic&proj_id=<?=$_SESSION['proj_id']?>" width="120" height="152" /></a>
                                        <? }else{ ?>
                                        <img src="<?=SERVER_CORE?>core/folder=hrm_passport_pic/employee.png" width="150px" height=""/>
                                        <? } ?>
                                      </div>
                                    </div>
                                    <!--<div class="form-group row m-0 pb-1">-->
                                    <!--	<label for="PBI_RELIGION" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Religion : </label>-->
                                    <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                    <!--                             <select name="PBI_RELIGION" class="form-control">-->
                                    <!--                               <option selected>-->
                                    <!--                               <?=(isset($PBI_RELIGION))?$PBI_RELIGION:'Islam';?>-->
                                    <!--                               </option>-->
                                    <!--                               <option>Islam</option>-->
                                    <!--                               <option>Bahai</option>-->
                                    <!--                               <option>Buddhism</option>-->
                                    <!--                               <option>Christianity</option>-->
                                    <!--                               <option>Confucianism </option>-->
                                    <!--                               <option>Druze</option>-->
                                    <!--                               <option>Hinduism</option>-->
                                    <!--                               <option>Jainism</option>-->
                                    <!--                               <option>Judaism</option>-->
                                    <!--                               <option>Shinto</option>-->
                                    <!--                               <option>Sikhism</option>-->
                                    <!--                               <option>Taoism</option>-->
                                    <!--                               <option>Zoroastrianism</option>-->
                                    <!--                               <option>Others</option>-->
                                    <!--                             </select>-->
                                    <!--	</div>-->
                                    <!--</div>-->
                                    <!--                     <div class="form-group row m-0 pb-1">-->
                                    <!--	<label  for="PBI_EMAIL" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Work E-mail : </label>-->
                                    <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                    <!--                             <input name="PBI_EMAIL" type="email" id="PBI_EMAIL" value="<?=$PBI_EMAIL?>" class="form-control" />-->
                                    <!--	</div>-->
                                    <!--</div>-->
                                    <!--                     <div class="form-group row m-0 pb-1">-->
                                    <!--	<label for="PBI_PHONE" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Work Cell No: </label>-->
                                    <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                    <!--                             <input name="PBI_PHONE" type="text" id="PBI_PHONE" class="form-control" value="<?=$PBI_PHONE?>" />-->
                                    <!--	</div>-->
                                    <!--</div>-->
                             
                                    <!--                     <div class="form-group row m-0 pb-1">-->
                                    <!--	<label for="medical" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Medical Records : </label>-->
                                    <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                    <!--                                 <input name="medical" type="text" id="medical" value="<?=$medical?>" class="form-control" />-->
                                    <!--	</div>-->
                                    <!--</div>-->
                                    <br>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="h_titel">
                                <center>
                                  Child Information
                                </center>
                              </div>
                              <div class="row m-0 new-color">
                                  
                                <div class="col-md-6">
                                  <div class="card-body new-color">
                                    <div class="form-group">
                                      <label class="label" for="PBI_PRESENT_ADD">Child 1 :</label>
                                      <hr size="3" color="#333333">
                                    </div>
                                    <div class="form-row">
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_name">Name :</label>
                                        <input name="child1_name" type="text" id="child1_name" class="form-control" value="<?=$child1_name;?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_address">Date Of Birth :</label>
                                        <input name="child1_dob" type="date" id="child1_dob" class="form-control" value="<?=$child1_dob;?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_cell">More Details :</label>
                                        <input name="child1_details" type="text" id="child1_details" class="form-control" value="<?=$child1_details;?>" />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="card-body new-color">
                                    <div class="form-group">
                                      <label class="label" for="PBI_PRESENT_ADD">Child 2 :</label>
                                      <hr size="3" color="#333333">
                                    </div>
                                    <div class="form-row">
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_name">Name :</label>
                                        <input name="child2_name" type="text" id="child2_name" class="form-control" value="<?=$child2_name;?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_address">Date Of Birth :</label>
                                        <input name="child2_dob" type="date" id="child2_dob" class="form-control" value="<?=$child2_dob;?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_cell">More Details :</label>
                                        <input name="child2_details" type="text" id="child2_details" class="form-control" value="<?=$child2_details;?>" />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                                                  
                                <div class="col-md-6">
                                  <div class="card-body new-color">
                                    <div class="form-group">
                                      <label class="label" for="PBI_PRESENT_ADD">Child 3 :</label>
                                      <hr size="3" color="#333333">
                                    </div>
                                    <div class="form-row">
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_name">Name :</label>
                                        <input name="child3_name" type="text" id="child3_name" class="form-control" value="<?=$child3_name;?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_address">Date Of Birth :</label>
                                        <input name="child3_dob" type="date" id="child3_dob" class="form-control" value="<?=$child3_dob;?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_cell">More Details :</label>
                                        <input name="child3_details" type="text" id="child3_details" class="form-control" value="<?=$child3_details;?>" />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="card-body new-color">
                                    <div class="form-group">
                                      <label class="label" for="PBI_PRESENT_ADD">Child 4 :</label>
                                      <hr size="3" color="#333333">
                                    </div>
                                    <div class="form-row">
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_name">Name :</label>
                                        <input name="child4_name" type="text" id="child4_name" class="form-control" value="<?=$child4_name;?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_address">Date Of Birth :</label>
                                        <input name="child4_dob" type="date" id="child4_dob" class="form-control" value="<?=$child4_dob;?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_cell">More Details :</label>
                                        <input name="child4_details" type="text" id="child4_details" class="form-control" value="<?=$child4_details;?>" />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                
                                
                                
                                
                                
                                
                                
                              </div>
                            </div>
                            <div class="card new-color">
                              <div class="h_titel">
                                <center>
                                  Address
                                </center>
                              </div>
                              <div class="row m-0 new-color">
                                <div class="col-md-6 col-sm-6 col-lg-6">
                                  <div class="card-body new-color">
                                    <div class="form-group">
                                      <label class="label" for="PBI_PRESENT_ADD">Present Address :</label>
                                      <hr size="3" color="#333333">
                                    </div>
                                    
                                    <div class="form-row">
                                        
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_house_no">House No :</label>
                                        <input name="pre_house_no" type="text" id="pre_house_no" class="form-control" value="<?=$pre_house_no ?>" />
                                      </div>
                                      
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_flat">House Owner :</label>
                                        <input name="house_owener" type="text" id="house_owener" class="form-control" value="<?=$house_owener ?>" />
                                      </div> 
                                                                            
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_flat">Para/Mahalla :</label>
                                        <input name="para_moholla" type="text" id="para_moholla" class="form-control" value="<?=$para_moholla?>" />
                                      </div> 
                                      
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_flat">Flat/Floor :</label>
                                        <input name="pre_flat" type="text" id="pre_flat" class="form-control" value="<?= $pre_flat ?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_road_no">Road No :</label>
                                        <input name="pre_road_no" type="text" id="pre_road_no" class="form-control" value="<?= $pre_road_no ?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_block_no">Block No :</label>
                                        <input name="pre_block_no" type="text" id="pre_block_no" class="form-control" value="<?= $pre_block_no ?>" />
                                      </div>
									  <div class="col-md-4 form-group">
                                        <label class="label" for="pre_block_no">Post Office :</label>
                                        <input name="post_office" type="text" id="post_office" class="form-control" value="<?= $post_office ?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label req-input" for="par_ps">Police Station :</label>
                                        <select name="pre_ps" id="pre_ps" class="form-control">
                                          <option value="<?=$pre_ps ?>">
                                          <?=$pre_ps ?>
                                          <? foreign_relation('thana_info', 'id', 'thana', $pre_ps, ' 1'); ?>
                                        </select>
                                      </div>
                                      
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_district">District :</label>
                                        <select name="pre_district" id="pre_district" class="form-control">
                                          <option value="<?=$pre_district ?>">
                                          <?=$pre_district ?>
                                          </option>
                                          <? foreign_relation('district_list', 'district_name', 'district_name', $pre_district, ' 1 order by district_name'); ?>
                                        </select>
                                      </div>
                                      
                                      
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-lg-6">
<script>
function auto_address(){
var pre_house_no=document.getElementById("pre_house_no").value;
var house_owener=document.getElementById("house_owener").value;
var para_moholla=document.getElementById("para_moholla").value;
var pre_flat=document.getElementById("pre_flat").value;
var pre_road_no=document.getElementById("pre_road_no").value;
var pre_block_no=document.getElementById("pre_block_no").value;
var pre_ps=document.getElementById("pre_ps").value;
var pre_district=document.getElementById("pre_district").value;
 
		var vehicle1 = document.getElementById('vehicle1').value;

								if (document.getElementById('vehicle1').checked) {

document.getElementById("pre_house_no2").value=pre_house_no;
document.getElementById("house_owener2").value=house_owener;
document.getElementById("para_moholla2").value=para_moholla;
document.getElementById("pre_flat2").value=pre_flat;
document.getElementById("pre_road_no2").value=pre_road_no;
document.getElementById("pre_block_no2").value=pre_block_no;
document.getElementById("pre_ps2").value=pre_ps;
document.getElementById("pre_district2").value=pre_district;

 }
 else{
 document.getElementById("pre_house_no2").value="";
document.getElementById("house_owener2").value="";
document.getElementById("para_moholla2").value="";
document.getElementById("pre_flat2").value="";
document.getElementById("pre_road_no2").value="";
document.getElementById("pre_block_no2").value="";
document.getElementById("pre_ps2").value="";
document.getElementById("pre_district2").value="";
 }

//alert(pre_house_no);
}
</script>
  
                                  <div class="card-body new-color">
                                        <input type="checkbox" id="vehicle1" name="vehicle1" value="" onclick="auto_address()">
                                        <label for="vehicle1" class="bold"> The present Address is the same as the Permanent  Address</label>
                                        
                                    <div class="form-group">
                                      <label class="label" for="PBI_PERMANENT_ADD">Permanent Address :</label>
                                      <hr size="3" color="#333333">
                                    </div>
                                    <div class="form-row">
                                        
                                                                                
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_house_no">House No :</label>
                                        <input name="pre_house_no2" type="text" id="pre_house_no2" class="form-control" value="<?=$pre_house_no2 ?>" />
                                      </div>
                                      
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_flat">House Owner :</label>
                                        <input name="house_owener2" type="text" id="house_owener2" class="form-control" value="<?=$house_owener2 ?>" />
                                      </div> 
                                                                            
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_flat">Para/Mahalla :</label>
                                        <input name="para_moholla2" type="text" id="para_moholla2" class="form-control" value="<?=$para_moholla2 ?>" />
                                      </div> 
                                      
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_flat">Flat/Floor :</label>
                                        <input name="pre_flat2" type="text" id="pre_flat2" class="form-control" value="<?=$pre_flat2 ?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_road_no">Road No :</label>
                                        <input name="pre_road_no2" type="text" id="pre_road_no2" class="form-control" value="<?=$pre_road_no2 ?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_block_no">Block No :</label>
                                        <input name="pre_block_no2" type="text" id="pre_block_no2" class="form-control" value="<?=$pre_block_no2 ?>" />
                                      </div>
									  <div class="col-md-4 form-group">
                                        <label class="label" for="pre_block_no">Post Office :</label>
                                        <input name="pr_post_office" type="text" id="pr_post_office" class="form-control" value="<?= $pr_post_office ?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label req-input" for="par_ps">Police Station :</label>
                                        <select name="pre_ps2" id="pre_ps2" class="form-control">
                                             <option value="<?= $pre_ps2 ?>">
                                          <?= $pre_ps2 ?>
                                          </option>
                                          <? foreign_relation('thana_info', 'id', 'thana', $pre_ps2, ' 1'); ?>
                                        </select>
                                      </div>
                                      
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="pre_district2">District :</label>
                                        <select name="pre_district2" id="pre_district2" class="form-control">
                                          <option value="<?= $pre_district2 ?>">
                                          <?= $pre_district2 ?>
                                          </option>
                                          <? foreign_relation('district_list', 'district_name', 'district_name', $pre_district2, ' 1 order by district_name'); ?>
                                        </select>
                                      </div>
                                        
                                        
                                      <!--<div class="col-md-6 form-group">-->
                                      <!--  <label class="label req-input" for="par_village_name">Village/Road :</label>-->
                                      <!--  <input name="par_village_name" type="text" id="par_village_name" class="form-control" value="<?= $par_village_name ?>" />-->
                                      <!--</div>-->
                                      <!--<div class="col-md-6 form-group">-->
                                      <!--  <label class="label req-input" for="par_po_name">Post Office :</label>-->
                                      <!--  <input name="par_po_name" type="text" id="par_po_name" class="form-control" value="<?= $par_po_name ?>" />-->
                                      <!--</div>-->
                                      <!--<div class="col-md-4 form-group">-->
                                      <!--  <label class="label req-input" for="par_po_name">Sector :</label>-->
                                      <!--  <input name="sector" type="text" id="sector" class="form-control" value="<?=$sector ?>" />-->
                                      <!--</div>-->
                                      <!--<div class="col-md-4 form-group">-->
                                      <!--  <label class="label req-input" for="par_ps">Police Station :</label>-->
                                      <!--  <select name="par_ps" id="par_ps" class="form-control">-->
                                      <!--    <option> </option>-->
                                      <!--    <? foreign_relation('thana_info', 'id', 'thana', $par_ps, ' 1'); ?>-->
                                      <!--  </select>-->
                                      <!--</div>-->
                                      
                                      <!--<div class="col-md-4 form-group">-->
                                      <!--  <label class="label req-input" for="PBI_POB">District :</label>-->
                                      <!--  <select name="PBI_POB" class="form-control">-->
                                      <!--    <option value="<?= $PBI_POB ?>">-->
                                      <!--    <?= $PBI_POB ?>-->
                                      <!--    </option>-->
                                      <!--    <? foreign_relation('district_list', 'district_name', 'district_name', $PBI_POB, ' 1 order by district_name'); ?>-->
                                      <!--  </select>-->
                                      <!--</div>-->
                                      
                                      
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <center style=" padding-top: 15px; ">
                                <? include('../common/input_bar.php');?>
                              </center>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="tab_3">
                            <div class="card">
                              <div class="h_titel">
                                <center>
                                  Work
                                </center>
                              </div>
                              <div class="card-body new-color">
                                <div class="row">
                                  <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="container new-bg-color">
                                      <div class="form-group row m-0 pb-1">
                                        <label for="PBI_ORG" class="col-sm-4 col-md-4 req-input col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Company : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select  id="PBI_ORG" class="form-control" name="PBI_ORG" required="required">
                                            <? foreign_relation('user_group','id','group_name',$PBI_ORG,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <? if($_SESSION['proj_id'] != 'demo'){ ?>
                                                                              
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Function : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="PBI_FUNCTION" id="PBI_FUNCTION" class="form-control" >
                                            <option selected="selected">
                                            <? foreign_relation('hrm_function','id','function_name',$PBI_FUNCTION, '1');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <? } ?>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="cost_center" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Cost Center : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="cost_center" id="cost_center" class="form-control" >
                                            <option selected="selected">
                                            <? foreign_relation('hrm_cost_center','id','center_name',$cost_center,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="DEPT_ID" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Department : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="DEPT_ID" id="DEPT_ID" class="form-control" >
                                              <option></option>
                                            <? foreign_relation('department','DEPT_ID','DEPT_DESC',$DEPT_ID,' 1 order by DEPT_DESC');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Section : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="section" id="section" class="form-control" >
                                            <option selected="selected">
                                            <? foreign_relation('PBI_Section','sec_id','sec_name',$section,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <? if($_SESSION['proj_id']=='demo'){ ?>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Region : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="PBI_BRANCH" id="PBI_BRANCH" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">
                                            <option selected="selected">
                                            <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 order by BRANCH_NAME');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Zone : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <span id="zone">
                                          <select name="PBI_ZONE" id="PBI_ZONE"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">
                                            <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 order by ZONE_NAME');?>
                                          </select>
                                          </span>
                                        </div>
                                      </div>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Area : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            <span id="area">
                                          <select name="PBI_AREA" id="PBI_AREA">
                                            <? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');?>
                                          </select>
                                          </span>
                                        </div>
                                      </div>
                                      
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="section" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Payroll Designation : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <input name="payroll_designation" id="payroll_designation" class="form-control" value="<?=$payroll_designation;?>" type="text" />
                                            
                                        </div>
                                      </div>
                                      
                                      <? } ?>
                                      
                                  
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="DESG_ID" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text req-input">Designation : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="DESG_ID" id="DESG_ID" class="form-control"  >
                                            <option></option>
                                            <? foreign_relation('designation','DESG_ID','DESG_DESC',$DESG_ID,'1 order by DESG_DESC');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label  for="job_title" class="col-sm-4 req-input col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Job Title : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <input name="job_title" type="text" id="job_title" value="<?=$job_title?>" class="form-control" />
                                        </div>
                                      </div>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="grade" class="col-sm-4 col-md-4 col-lg-4 req-input col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Grade : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="grade" id="grade" class="form-control" >
                                            <option selected="selected">
                                            <? foreign_relation('hrm_grade','id','grade_name',$grade,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                        <!--                     <div class="form-group row m-0 pb-1">-->
                                      <!--	<label for="define_offday" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Employment Type : </label>-->
                                      <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                      <!--                     <select name="EMPLOYMENT_TYPE" id="EMPLOYMENT_TYPE" class="form-control">-->
                                      <!--                       <option selected="selected">-->
                                      <!--                       <?=$EMPLOYMENT_TYPE?>-->
                                      <!--                       </option>-->
                                      <!--                       <option>Contractual</option>-->
                                      <!--                       <option>Casual Staff</option>-->
                                      <!--                       <option>Probationary</option>-->
                                      <!--                       <option>Permanent</option>-->
                                      <!--                       <option>Temporary</option>-->
                                      <!--                     </select>-->
                                      <!--	</div>-->
                                      <!--</div>-->
                                      
                                      <? if($_SESSION['proj_id'] != 'demo'){ ?>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="salary_schedule" class="col-sm-4 req-input col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Salary Schedule : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="salary_schedule" id="salary_schedule" class="form-control" >
                                            <option selected="selected">
                                            <? foreign_relation('salary_schedule','id','schedule_name',$salary_schedule,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <? } ?>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="job_description" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Job Description : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="job_description" type="text" id="job_description"  class="form-control" />
										  		<option><?=$job_description?></option>
												<option value="Administrative">Administrative</option>
												<option value="Manufacturing">Manufacturing</option>
										  </select>
                                        </div>
                                      </div>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="class" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Class : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="class" id="class" class="form-control" >
                                            <option selected="selected">
                                            <? foreign_relation('hrm_class','id','class_name',$class,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      
                                <div class="form-group row m-0 pb-5">
                                <label for="PBI_JOB_STATUS" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Employment Status : </label>
                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <select name="PBI_JOB_STATUS" class="form-control">
                               <option <?=($PBI_JOB_STATUS=='In Service')?'selected':'';?>>In Service</option>
                                 <option <?=($PBI_JOB_STATUS=='Not In Service')?'selected':'';?>>Not In Service</option>
                                    </select>
                                   </div>
                                </div>

                                   
                                    </div>
                                  </div>
                                  <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="container new-bg-color">
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="level" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Employment Type : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="level" id="level" class="form-control" >
                                            <option selected="selected">
                                            <? foreign_relation('hrm_level','id','level_name',$level,' 1');?>
                                          </select>
                                        </div>
                                      </div>


                                      <div class="form-group row m-0 pb-1">
                                        <label for="define_offday2" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Cost Type : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="cost_type" id="cost_type" class="form-control" >
                                            <option selected="selected">
                                            <?=$cost_type?>
                                            </option>
                                            <option></option>
                                            <option>Direct Cost</option>
                                            <option>Indirect Cost</option>
                                          </select>
                                        </div>
                                      </div>
                                      <? if($_SESSION['proj_id'] != 'demo'){ ?>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="line" class="col-sm-4 col-md-4 col-lg-4 req-input col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Line : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="line" id="line" class="form-control" >
                                            <option selected="selected">
                                            <? foreign_relation('hrm_line','id','line_name',$line,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                      <? } ?>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="PBI_DOJ" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex req-input justify-content-start align-items-center pr-1 bg-form-titel-text">Joining Date : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <input name="PBI_DOJ" type="date" id="joiningdate"   value="<?=$PBI_DOJ?>" class="form-control" autocomplete="off" onChange="calculateAge()"/>
                                        </div>
                                      </div>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="PBI_DURATION" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Probation Month : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <input name="PBI_DURATION" type="number" id="monthNumber" value="<?=$PBI_DURATION?>" required="required" class="form-control"  />
                                        </div>
                                      </div>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="PBI_DOC2" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex req-input justify-content-start align-items-center pr-1 bg-form-titel-text">Confirmation Date : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <input name="PBI_DOC2" type="date" id="appointmentDate" value="<?=$PBI_DOC2?>" class="form-control" autocomplete="off"/>
                                        </div>
                                      </div>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="age_on_join" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Age on Joining Date : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <input name="age_on_join" type="text" id="age" value="<?=$age_on_join?>"  class="form-control"  />
                                        </div>
                                      </div>
                                      
                                            <div class="form-group row m-0 pb-1">
                                        <label for="JOB_LOCATION" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Location : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="JOB_LOC_ID" id="JOB_LOC_ID"  class="form-control"  >
                                            <option></option>
                                            <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$JOB_LOC_ID);?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label for="PBI_WORK_STATION" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 req-input d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Work Station : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="PBI_WORK_STATION" id="PBI_WORK_STATION"  class="form-control"  >
                                            <option></option>
                                            <? foreign_relation('hrm_workstation','station_id','work_station_name',$PBI_WORK_STATION);?>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="DESG_ID" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Joining Designation : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
											<input type="text" name="joining_designation_new" readonly="readonly" value="<?=find_a_field('designation','DESG_DESC','DESG_ID='.$joining_designation);?>" />
										
                                          <!--<select name="joining_designation_new" id="joining_designation_new" readonly="readonly" class="form-control" >
                                            <option></option>
                                            <? foreign_relation('designation','DESG_ID','DESG_DESC',$joining_designation ,'1 order by DESG_DESC');?>
                                          </select>-->
                                        </div>
                                      </div>
                                      
                                      <!-- <div class="form-group row m-0 pb-1">
                                        <label for="PBI_SPECIALTY" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Joining Salary: </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <input name="joining_salary" type="text" id="joining_salary" value="<?=$joining_salary?>" class="form-control" />
                                        </div>
                                      </div> -->
                                      
                                                                            
                                         <div class="form-group row m-0 pb-1">
                                        <label  for="incharge_id" class="col-sm-4 col-md-4 col-lg-4 col-xl-4  
                                        req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> 1st Reporting Supervisor </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            
                                        <input type="text" list="incharge" name="incharge_id" id="incharge_id" class="form-control" 
                                        value="<? if($incharge_id>0) echo $incharge_id;?>" />
                                        <datalist id="incharge" >
                                        <option></option>
                                  
                        <? 
                        foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_NAME, " - ", PBI_CODE)', $incharge_id, ' 1 order by PBI_NAME asc');?>
               
                    </datalist>
      
      
                                          
                                        </div>
                                      </div>
                                      
                                      <div class="form-group row m-0 pb-1">
                                        <label  for="incharge_id_2" class="col-sm-4 col-md-4 col-lg-4 req-input col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">2nd Reporting Supervisor </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                            
                    <input type="text" list="incharge2" name="incharge_id_2" id="incharge_id_2" class="form-control" 
                    value="<? if($incharge_id_2>0) echo $incharge_id_2;?>" />
                    <datalist id="incharge2" >
                   <option></option>
                                  
                        <? 
                        foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_NAME, " - ", PBI_CODE)', $incharge_id_2, ' 1 order by PBI_NAME asc');?>
               
                    </datalist>                       
                            
                                          
                                          
                                          
                                        </div>
                                      </div>
                                    
                                      
                                      
                                      <!--                          <div class="form-group row m-0 pb-1">-->
                                      <!--						<label for="PBI_SERVICE_LENGTH" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex req-input justify-content-start align-items-center pr-1 bg-form-titel-text">Service Length :  </label>-->
                                      <!--						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                      <!--<input name="PBI_SERVICE_LENGTH" type="text" id="PBI_SERVICE_LENGTH"  class="form-control" value="<?=$PBI_SERVICE_LENGTH?>" readonly="readonly">-->
                                      <!--						</div>-->
                                      <!--					</div>-->
                                      <?php /*?>
                            <div class="form-group row m-0 pb-1">
								<label for="PBI_APPOINTMENT_LETTER_DATE" class="req-input col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Appointment Date : </label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                            <input name="PBI_APPOINTMENT_LETTER_DATE" type="text" id="PBI_APPOINTMENT_LETTER_DATE" value="<?=$PBI_APPOINTMENT_LETTER_DATE?>" autocomplete="off"  class="form-control"/>
								</div>
							</div>	<?php */?>
                                      <!--                     <div class="form-group row m-0 pb-1">-->
                                      <!--	<label for="PBI_SPECIALTY" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Area Of Expertise : </label>-->
                                      <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                      <!--                                 <input name="PBI_SPECIALTY" type="text" id="PBI_SPECIALTY" value="<?=$PBI_SPECIALTY?>" class="form-control" />-->
                                      <!--	</div>-->
                                      <!--</div>-->
                                      <!--                     <div class="form-group row m-0 pb-1">-->
                                      <!--	<label for="PBI_JOB_STATUS" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Employee Status : </label>-->
                                      <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                      <!--                     <select name="PBI_JOB_STATUS" class="form-control">-->
                                      <!--                       <option <?=($PBI_JOB_STATUS=='In Service')?'selected':'';?>>In Service</option>-->
                                      <!--                       <option <?=($PBI_JOB_STATUS=='Not In Service')?'selected':'';?>>Not In Service</option>-->
                                      <!--                     </select>-->
                                      <!--	</div>-->
                                      <!--</div>-->
                                      <!--                     <div class="form-group row m-0 pb-1">-->
                                      <!--	<label for="PBI_BRANCH" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Branch : </label>-->
                                      <!--	<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                      <!--                     <select name="PBI_BRANCH" id="PBI_BRANCH" class="form-control">-->
                                      <!--                       <option></option>-->
                                      <!--                       <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH);?>-->
                                      <!--                     </select> -->
                                      <!--	</div>-->
                                      <!--</div>-->
                                    </div>
                                  </div>
                                  <div class="col-md-2 form-group"> </div>
                                </div>
                                <center style=" padding-top: 15px; ">
                                  <? include('../common/input_bar.php');?>
                                </center>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="tab_4">
                            <div class="card">
                              <div class="h_titel">
                                <center>
                                  Employee Relieving Info
                                </center>
                              </div>
                              <div class="card-body new-color">
                                <div class="row">
                                  <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="container new-bg-color">
                                      <div class="form-group row m-0 pb-1">
                                        <label for="Resign_Date" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Date Of Leaving:</label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <input name="resign_date" type="date" id="resign_date" value="<?=$resign_date?>" autocomplete="off" class="form-control"/>
                                        </div>
                                      </div>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="emp_date_deleted_at" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Date Deleted :</label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <input name="emp_date_deleted_at" id="emp_date_deleted_at" class="form-control" 
                                          
                                          value="<?
                                          
                                          $delete_at = find_a_field('personnel_basic_info','emp_date_deleted_at','PBI_ID="'.$_SESSION['employee_selected'].'"');
                                          
                                          if($delete_at>0){
                                          
                                          echo $emp_date_deleted_at;
                                              
                                          }else{ 
                                              
                                               if($_POST['resign_date']>0){
                                        
                                                echo  date("Y-m-d"); } 
                                          
                                          }
                                          
                                          ?>" readonly/>
                                        </div>
                                      </div>
                                      <!--<div class="form-group row m-0 pb-1">
                                        <label  for="resign_type" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Employee Deletion Type </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="resign_type" class="form-control">
                                            <option value="<?=$resign_type ?>">
                                            <?=$resign_type?>
                                            </option>
                                            <? foreign_relation('hrm_resign_type', 'id', 'resign_type', $resign_type, '1'); ?>
                                          </select>
                                        </div>
                                      </div>-->
                                    </div>
                                  </div>
                                  <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="container new-bg-color">
                                      <div class="form-group row m-0 pb-1">
                                        <label for="emp_deletion_reason" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 req-input m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Deletion Reason </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="emp_deletion_reason" class="form-control">
                                            <option value="<?=$emp_deletion_reason ?>">
                                            <?=$emp_deletion_reason ?>
                                            </option>
                                            <? foreign_relation('hrm_deletion_reason', 'id', 'deletion_type', $emp_deletion_reason, '1'); ?>
                                          </select>
                                        </div>
                                      </div>
                                   
                                    </div>
                                  </div>
                                </div>
                                <center style=" padding-top: 15px; ">
                                  <? include('../common/input_bar.php');?>
                                </center>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="tab_5">
                            <div class="card new-color">
                              <div class="h_titel">
                                <center>
                                  Referance
                                </center>
                              </div>
                              <div class="row m-0 new-color">
                                <div class="col-md-6">
                                  <div class="card-body new-color">
                                    <div class="form-group">
                                      <label class="label" for="PBI_PRESENT_ADD">Referance 1 :</label>
                                      <hr size="3" color="#333333">
                                    </div>
                                    <div class="form-row">
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_name">Name :</label>
                                        <input name="ref_name" type="text" id="ref_name" class="form-control" value="<?= $ref_name ?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_address">Address :</label>
                                        <input name="ref_address" type="text" id="ref_address" class="form-control" value="<?= $ref_address ?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_cell">Cell No :</label>
                                        <input name="ref_cell" type="text" id="ref_cell" class="form-control" value="<?= $ref_cell ?>" />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="card-body new-color">
                                    <div class="form-group">
                                      <label class="label" for="PBI_PERMANENT_ADD">Referance 2 :</label>
                                      <hr size="3" color="#333333">
                                    </div>
                                    <div class="form-row">
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_name2">Name :</label>
                                        <input name="ref_name2" type="text" id="ref_name2" class="form-control" value="<?= $ref_name2?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_address2">Address :</label>
                                        <input name="ref_address2" type="text" id="ref_address2" class="form-control" value="<?= $ref_address2?>" />
                                      </div>
                                      <div class="col-md-4 form-group">
                                        <label class="label" for="ref_cell2">Cell No :</label>
                                        <input name="ref_cell2" type="text" id="ref_cell2" class="form-control" value="<?= $ref_cell2 ?>" />
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <center style=" padding-top: 15px; ">
                                <? include('../common/input_bar.php');?>
                              </center>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="tab_6">
                            <div class="card">
                              <div class="h_titel">
                                <center>
                                  SHIFT
                                </center>
                              </div>
                              <div class="card-body new-color">
                                <div class="row">
                                  <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="container new-bg-color">
                                      <label class="label" for="pre_house_no">Employee Calendar:</label>
                                      <table align="center" class="table table-bordered table-sm">
                                        <thead>
                                          <tr>
                                            <th>Day</th>
                                            <th>Status </th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td style="font-weight: 700;">Friday</td>
                                            <td><select class="status-dropdown form-control" name="Friday" id="Friday" >
                                                <option></option>
                                                <option selected="selected">
                                                <?=$Friday?>
                                                </option>
                                                <option value="Weekend">Weekend</option>
                                                <option value="Day_Off">Day Off</option>
                                                <option value="Working_Day">Working Day</option>
                                              </select>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td style="font-weight: 700;">Saturday</td>
                                            <td><select class="status-dropdown form-control" name="Saturday" id="Saturday">
                                                <option></option>
                                                <option selected="selected">
                                                <?=$Saturday?>
                                                </option>
                                                <option value="Weekend">Weekend</option>
                                                <option value="Day_Off">Day Off</option>
                                                <option value="Working_Day">Working Day</option>
                                              </select>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td style="font-weight: 700;">Sunday</td>
                                            <td><select class="status-dropdown form-control" name="Sunday" id="Sunday">
                                                <option></option>
                                                <option selected="selected">
                                                <?=$Sunday?>
                                                </option>
                                                <option value="Weekend">Weekend</option>
                                                 <option value="Day_Off">Day Off</option>
                                                <option value="Working_Day">Working Day</option>
                                              </select>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td style="font-weight: 700;">Monday</td>
                                            <td><select class="status-dropdown form-control" name="Monday" id="Monday">
                                                <option></option>
                                                <option selected="selected">
                                                <?=$Monday?>
                                                </option>
                                                <option value="Weekend">Weekend</option>
                                                <option value="Day_Off">Day Off</option>
                                                <option value="Working_Day">Working Day</option>
                                              </select>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td style="font-weight: 700;">Tuesday</td>
                                            <td><select class="status-dropdown form-control" name="Tuesday" id="Tuesday">
                                                <option></option>
                                                <option selected="selected">
                                                <?=$Tuesday?>
                                                </option>
                                                <option value="Weekend">Weekend</option>
                                                <option value="Day_Off">Day Off</option>
                                                <option value="Working_Day">Working Day</option>
                                              </select>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td style="font-weight: 700;">Wednesday</td>
                                            <td><select class="status-dropdown form-control" name="Wednesday" id="Wednesday">
                                                <option></option>
                                                <option selected="selected">
                                                <?=$Wednesday?>
                                                </option>
                                                <option value="Weekend">Weekend</option>
                                                <option value="Day_Off">Day Off</option>
                                                <option value="Working_Day">Working Day</option>
                                              </select>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td style="font-weight: 700;">Thursday</td>
                                            <td><select class="status-dropdown form-control" name="Thursday" id="Thursday">
                                                <option></option>
                                                <option selected="selected">
                                                <?=$Thursday?>
                                                </option>
                                                <option value="Weekend">Weekend</option>
                                                 <option value="Day_Off">Day Off</option>
                                                <option value="Working_Day">Working Day</option>
                                              </select>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  
                                
                                  <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="container new-bg-color">
                                      <!--                         <div class="col-md-2 form-group">
                            <label class="label req-input" for="PBI_SPECIALTY">Leave Rule Manage:</label>
                            <select name="LEAVE_RULE_ID" id="LEAVE_RULE_ID" class="form-control">
                              <option></option>
                              <option <?=($LEAVE_RULE_ID==1)? 'selected' : '' ?> value="1">General</option>
                            </select>
                          </div>-->
                                      <!--  <div class="form-group row m-0 pb-1">
                                        <label for="employee_type" class="col-sm-4 col-md-4 req-input col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Roster Type :</label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
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
                                      </div> -->
                                      <div class="form-group row m-0 pb-1">
                                        <label for="define_schedule" class="col-sm-4 col-md-4 req-input col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Default Shift : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="define_schedule" id="define_schedule" class="form-control" >
                                            <option></option>
                                            <? foreign_relation('hrm_schedule_info','id','schedule_name',$define_schedule,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                    <!--  <div class="form-group row m-0 pb-1">
                                        <label for="grace_type" class="col-sm-4 col-md-4 req-input col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Schedule Type : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="schedule_type" id="schedule_type">
                                            <option selected="selected">
                                            <?=$schedule_type?>
                                            </option>
                                            <option>Regular</option>
                                            <option>Roster</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-group row m-0 pb-1">
                                        <label for="define_offday" class="col-sm-4 col-md-4 req-input col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Punch Type : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
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
                                      </div>
                                      <div class="form-group row m-0 pb-3">
                                        <label for="grace_type" class="col-sm-4 col-md-4 req-input col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Grace Type : </label>
                                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                          <select name="grace_type" id="grace_type" class="form-control" >
                                            <option selected="selected">
                                            <? foreign_relation('grace_type','ID','grace_type',$grace_type,' 1');?>
                                          </select>
                                        </div>
                                      </div>
                                      <!--                  <div class="form-group row m-0 pb-1">-->
                                      <!--<label for="define_offday" class="col-sm-4 col-md-4 req-input col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Define Offday : </label>-->
                                      <!--<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                      <!--                            <select name="define_offday" id="define_offday" class="form-control" >-->
                                      <!--                              <option selected="selected">-->
                                      <!--                              <?=$define_offday?>-->
                                      <!--                              </option>-->
                                      <!--                              <option></option>-->
                                      <!--                              <option>Friday</option>-->
                                      <!--                              <option>Saturday</option>-->
                                      <!--                              <option>Sunday</option>-->
                                      <!--                              <option>Monday</option>-->
                                      <!--                              <option>Tuesday</option>-->
                                      <!--                              <option>Wednesday</option>-->
                                      <!--                              <option>Thursday</option>-->
                                      <!--                            </select>-->
                                      <!--</div>-->
                                      <!--</div>-->
                                      <!--                  <div class="form-group row m-0 pb-1">-->
                                      <!--<label for="define_offday2" class="col-sm-4 col-md-4 req-input col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text"> Define Offday 2 :</label>-->
                                      <!--<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">-->
                                      <!--                            <select name="define_offday2" id="define_offday2" class="form-control" >-->
                                      <!--                              <option selected="selected">-->
                                      <!--                              <?=$define_offday2?>-->
                                      <!--                              </option>-->
                                      <!--                              <option></option>-->
                                      <!--                              <option>Friday</option>-->
                                      <!--                              <option>Saturday</option>-->
                                      <!--                              <option>Sunday</option>-->
                                      <!--                              <option>Monday</option>-->
                                      <!--                              <option>Tuesday</option>-->
                                      <!--                              <option>Wednesday</option>-->
                                      <!--                              <option>Thursday</option>-->
                                      <!--                            </select>-->
                                      <!--</div>-->
                                      <!--</div>-->
                                      <br>
                                      <br>
                                      <br>
                                      <br>
                                      <br>
                                      <br>
                                      <br>
                                      <br>
                                    </div>
                                  </div>
                                
                                
                                </div>
                                <center style=" padding-top: 15px; ">
                                  <? include('../common/input_bar.php');?>
                                </center>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane fade" id="tab_7">
                            <div class="card">
                              <div  class="h_titel">
                                <center>
                                  Employee File Upload
                                </center>
                              </div>
                              <div class="card-body new-color">
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
                                    <label class="label" for="pic"> Nominee :</label>
                                    <input name="PBI_PASSPORT_ATT_PATH" type="file" id="PBI_PASSPORT_ATT_PATH" accept="image/jpeg" class="form-control" style="opacity:3!important;position:initial;"/>
                                  </div>
                                  <div class="col-md-3 form-group">
                                    <label class="label" for="pic">TIN :</label>
                                    <input name="PBI_TIN_ATT_PATH" type="file" id="PBI_TIN_ATT_PATH" class="form-control" style="opacity:3!important;position:initial;"/>
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
                                    <label class="label" for="pic">Nominee</label>
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
                                    <a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$row->PBI_PICTURE_ATT_PATH?>&folder=hrm_emp_pic&proj_id=<?=$_SESSION['proj_id']?>" target="_blank" download> <img src="<?=SERVER_CORE?>core/upload_view.php?name=<?=$row->PBI_PICTURE_ATT_PATH?>&folder=hrm_emp_pic&proj_id=<?=$_SESSION['proj_id']?>" width="120" height="152" /></a>
                                    <? }else{ ?>
                                    <img src="../../pic/employee.png" width="150px" height=""/>
                                    <? } ?>
                                  </div>
                                  <div class="col-md-3 form-group">
                                    <? if($row->PBI_NID_ATT_PATH!=""){  ?>
                                    <a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$row->PBI_NID_ATT_PATH?>&folder=hrm_nid_pic&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank" download> <img src="<?=SERVER_CORE?>core/upload_view.php?name=<?=$row->PBI_NID_ATT_PATH?>&folder=hrm_nid_pic&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" width="120" height="152"/></a>
                                    <? }else{ ?>
                                    <img src="../../pic/nid.png" width="150px" height=""/>
                                    <? } ?>
                                  </div>
                                  <div class="col-md-3 form-group">
                                    <? if($row->PBI_PASSPORT_ATT_PATH!=""){  ?>
                                    <a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$row->PBI_PASSPORT_ATT_PATH?>&folder=hrm_passport_pic&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank" download> <img src="<?=SERVER_CORE?>core/upload_view.php?name=<?=$row->PBI_PASSPORT_ATT_PATH?>&folder=hrm_passport_pic&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" width="120" height="152" /></a>
                                    <? }else{ ?>
                                    <img src="../../pic/employee.png" width="150px" height=""/>
                                    <? } ?>
                                  </div>
                                  <div class="col-md-3 form-group">
                                    <? if($row->PBI_TIN_ATT_PATH!=""){  ?>
                                      <a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$row->PBI_TIN_ATT_PATH?>&folder=tin_pic&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank" download> <img src="<?=SERVER_CORE?>core/upload_view.php?name=<?=$row->PBI_TIN_ATT_PATH?>&folder=tin_pic&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" width="120" height="152"/></a>
                                    <? }else{ ?>
                                    <img src="../../pic/tin.png" width="150px" height=""/>
                                    <? } ?>
                                  </div>
                                  <?php /*?>			  
                          <div class="col-md-3 mt-5 form-group">
                            <label class="label" for="pic">Other Document :</label>
                            <input type="file" name="PBI_OTHER_ATT_PATH" id="PBI_OTHER_ATT_PATH" accept="image/jpeg/pdf/jpg" class="form-control" style="opacity:3!important;position:initial;" />
                            <p style="color:#333333; font-size: 13px" class="label mt-5 mb-3" for="pic">Other Document</p>
                            <? if($image_path->PBI_OTHER_ATT_PATH!=""){  ?>
                            <a href="../../../assets/support/upload_view.php?name=<?=$image_path->PBI_OTHER_ATT_PATH?>&folder=hrm_other&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank" download> <img src="../../../assets/support/upload_view.php?name=<?=$image_path->PBI_OTHER_ATT_PATH?>&folder=hrm_other&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" width="120" height="152"/></a>
                            <? }else{ ?>
                            <img src="../../pic/Other_Doc.png" width="150px" height=""/>
                            <? } ?>
                          </div>
                          <div class="col-md-3 mt-5 form-group">
                            <label class="label" for="pic">Approve CV :</label>
                            <input type="file" name="PBI_CV_ATT_PATH" id="PBI_CV_ATT_PATH" accept="image/jpeg/pdf/jpg" class="form-control" style="opacity:3!important;position:initial;"/>
                            <p style="color:#333333; font-size: 13px" class="label mt-5 mb-3" for="pic">Approve CV</p>
                            <? if($image_path->PBI_CV_ATT_PATH!=""){  ?>
                            <a href="../../../assets/support/upload_view.php?name=<?=$image_path->PBI_CV_ATT_PATH?>&folder=hrm_cv" target="_blank" download> <img src="../../../assets/support/upload_view.php?name=<?=$image_path->PBI_CV_ATT_PATH?>&folder=hrm_cv" width="120" height="152"/> </a>
                            <? }else{ ?>
                            <img src="../../pic/approved.png" width="150px" height=""/>
                            <? } ?>
                          </div><?php */?>
                                </div>
                              </div>
                            </div>
                            <center style=" padding-top: 15px; ">
                              <? include('../common/input_bar.php');?>
                            </center>
                          </div>
                        </div>
                      </div>
                    </div>
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
  </div>
</form>
<script>

function calculateDuration() {

  var joiningDate = new Date(document.getElementById("PBI_DOJ").value);

  var confirmDate = new Date(document.getElementById("PBI_DOC2").value);

  if (joiningDate && confirmDate) {

    var timeDiff = Math.abs(confirmDate.getTime() - joiningDate.getTime());

    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

    var durationInMonths = Math.ceil(diffDays / 30);

    document.getElementById("PBI_DURATION").value = durationInMonths;

  }

}

</script>
<script>
$(document).ready(function() {
    // Select the dropdown elements by class.
    const $statusDropdowns = $('.status-dropdown');

    // Event handler when a dropdown value changes.
    $statusDropdowns.change(function() {
        // Get the selected status value.
        const selectedStatus = $(this).val();

        // Find the index of the changed dropdown.
        const selectedIndex = $statusDropdowns.index(this);

        // Update the following dropdowns with the same value.
        for (let i = selectedIndex + 1; i < $statusDropdowns.length; i++) {
            $statusDropdowns.eq(i).val(selectedStatus);
        }
    });
});


</script>
<script>
        function calculateAge() {
            const birthdate = new Date(document.getElementById("birthdate").value);
            const joiningdate = new Date(document.getElementById("joiningdate").value);

            if (!isNaN(birthdate.getTime()) && !isNaN(joiningdate.getTime())) {
                const ageInMillis = joiningdate - birthdate;
                const ageDate = new Date(ageInMillis);
                const years = ageDate.getUTCFullYear() - 1970;

                document.getElementById("age").value = years;
            } else {
                document.getElementById("age").value = "";
            }
        }
    </script>
<script>
        document.getElementById('monthNumber').addEventListener('input', function () {
            const joiningDateInput = document.getElementById('joiningdate');
            const monthNumberInput = document.getElementById('monthNumber');
            const appointmentDateInput = document.getElementById('appointmentDate');

            const joiningDate = new Date(joiningDateInput.value);
            const monthNumber = parseInt(monthNumberInput.value, 10);

            if (!isNaN(monthNumber)) {
                const appointmentDate = new Date(joiningDate);
                appointmentDate.setMonth(joiningDate.getMonth() + monthNumber);
                const formattedAppointmentDate = appointmentDate.toISOString().split('T')[0]; // Format as yyyy-mm-dd
                appointmentDateInput.value = formattedAppointmentDate;
            } else {
                appointmentDateInput.value = ''; // Clear the field if month number is not valid
            }
        });
    </script>
<?







require_once SERVER_CORE."routing/layout.bottom.php";















?>
