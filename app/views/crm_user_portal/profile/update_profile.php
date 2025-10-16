<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$page_name = 'update_profile';

function alt_field_name($field){
	
	 $f = find_a_field('pbi_field_name_alt','alt_name','pbi_field="'.$field.'"');
	 
	  return $f;
	}
	
	
$user = find_all_field('hrm_roll_assign','','PBI_ID="'.$_SESSION['user']['PBI_ID'].'"');

function next_ledger_ids($group_id)

{

$max=($group_id*1000000000000)+1000000000000;

$min=($group_id*1000000000000)-1;

 $s='select max(ledger_id) from accounts_ledger where ledger_id>'.$min.' and ledger_id<'.$max;

$sql=db_query($s);

if(mysqli_num_rows($sql)>0)

$data=mysqli_fetch_row($sql);

else

$acc_no=$min;

if(!isset($acc_no)&&(is_null($data[0]))) 

$acc_no=$cls;

else

$acc_no=$data[0]+100000000;

return $acc_no;

}

// ::::: Edit This Section ::::: 

$title='Employee Basic Info';		// Page Name and Page Title

$page="update_profile.php";		// PHP File Name

$input_page="employee_basic_information_input.php";

$root='profile';



$table='personnel_basic_info';		// Database Table Name Mainly related to this page

$unique='PBI_ID';			// Primary Key of this Database table

$shown='PBI_FATHER_NAME';	



do_calander('#PBI_DUE_DOJ');

//do_calander('#PBI_DOB');

do_calander('#PBI_DOJ_PP');

do_calander('#PBI_DOC');

do_calander('#PBI_DOC2');

do_calander('#PBI_DOJ');

do_calander('#PBI_APPOINTMENT_LETTER_DATE');

do_calander('#JOB_STATUS_DATE');



// ::::: End Edit Section :::::



$crud      =new crud($table);


   

   if(isset($_POST['button'])){

	 $sql = 'select PBI_ID from personnel_basic_info where PBI_CODE="'.$_POST['employee_selected'].'"';

	 $query = db_query($sql);

	 $data = mysqli_fetch_object($query);

   $_SESSION['employee_selected'] = $data->PBI_ID;
   
   echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';

   }
    if(isset($_POST['button_name'])){
     $sql = 'select PBI_ID from personnel_basic_info where PBI_NAME="'.$_POST['employee_selected_name'].'"';

	 $query = db_query($sql);

	 $data = mysqli_fetch_object($query);

   $_SESSION['employee_selected'] = $data->PBI_ID;
    echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
   }
   
    if(isset($_POST['button_phone'])){
     $sql = 'select PBI_ID from personnel_basic_info where PBI_MOBILE="'.$_POST['employee_selected_phone'].'"';

	 $query = db_query($sql);

	 $data = mysqli_fetch_object($query);

   $_SESSION['employee_selected'] = $data->PBI_ID;
    echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
   }

  $data = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);



$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);

if($required_id>0)

$$unique = $_GET[$unique] = $required_id;

if(isset($_POST[$shown]))

{	

$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);

if($required_id>0)

$$unique = $_GET[$unique] = $required_id;

else

$$unique = $_SESSION['employee_selected']=$_POST['employee_selected'];

	//for Modify..................................

	if(isset($_POST['update']))

	{

		$path='../../../hrm_mod/pic/staff';

			//$_POST['pic']=image_upload($path,$_FILES['pic']);
			if($_FILES['emp_pic']['tmp_name']!=''){

			$file_name= $_FILES['emp_pic']['name'];

			$file_tmp= $_FILES['emp_pic']['tmp_name'];

			$ext=end(explode('.',$file_name));

			$path='../../../hrm_mod/pic/staff/';
			
			$staff_pic=$path.$_SESSION['employee_selected'].'.'.$ext;

			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.'.$ext);
			$_POST['picture_file'] = $staff_pic;

			}

			if($_FILES['nid_pic']['tmp_name']!=''){

			$file_name= $_FILES['nid_pic']['name'];

			$file_tmp= $_FILES['nid_pic']['tmp_name'];

			$ext=end(explode('.',$file_name));

			$path='../../../hrm_mod/pic/nid/';
			
			$nid_pic=$path.$_SESSION['employee_selected'].'.'.$ext;

			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.'.$ext);
			$_POST['nid_file'] = $nid_pic;

			}

			

			if($_FILES['pass_pic']['tmp_name']!=''){

			$file_name= $_FILES['pass_pic']['name'];

			$file_tmp= $_FILES['pass_pic']['tmp_name'];

			$ext=end(explode('.',$file_name));

			$path='../../../hrm_mod/pic/passport/';
			
			$passport_pic = $path.$_SESSION['employee_selected'].'.'.$ext;

			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.'.$ext);
			//$_POST['nid_file'] = $passport_pic;

}
           if($_FILES['tin_certificate']['tmp_name']!=''){

			$file_name= $_FILES['tin_certificate']['name'];

			$file_tmp= $_FILES['tin_certificate']['tmp_name'];

			$ext=end(explode('.',$file_name));

			$path='../../../hrm_mod/pic/tin/';
			
			$tin_pic = $path.$_SESSION['employee_selected'].'.'.$ext;

			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.'.$ext);
			$_POST['tin_file'] = $tin_pic;

}

			if($_FILES['signature']['tmp_name']!=''){
			$file_name= $_FILES['signature']['name'];
			$file_tmp= $_FILES['signature']['tmp_name'];
			$ext=end(explode('.',$file_name));
			$path='../../../hrm_mod/pic/signature/';
			$signature_pic = $path.$_SESSION['employee_selected'].'.'.$ext;
			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.'.$ext);
			$_POST['signature_file'] = $signature_pic;
			}

			
			$_POST['edit_at'] = date('Y-m-d h:i:s');
			$_POST['edit_by'] = $_SESSION['user']['id'];
		   $crud->update($unique);

		  $type=1;


		
      
	}

	
	if(isset($_POST['reset']))

	{

	   unset($_SESSION['employee_selected']);

	   header('location:employee_basic_information.php');

	}

	

}



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

if($_GET['del']>0){
    
	$del = 'delete from  education_detail where EDUCATION_D_ID="'.$_GET['del'].'"';
	$child_del = db_query($del);
	
	echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
  
}

if($_GET['cddel']>0){
    
	$del2 = 'delete from  course_diploma_detail where CD_D_ID="'.$_GET['cddel'].'"';
	$cd_del = db_query($del2);
	
	echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
  
}

if($_GET['exdel']>0){
    
	$del3 = 'delete from  experience_detail where EXPERIENCE_DETAIL_ID="'.$_GET['exdel'].'"';
	$ex_del = db_query($del3);
	
	echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
  
}

if($_GET['deldefendant']>0){
    
	$del4 = 'delete from  defendant_info where id="'.$_GET['deldefendant'].'"';
	$ex_del = db_query($del4);
	
	echo '<script type="text/javascript">
parent.parent.document.location.href = "../'.$root.'/'.$page.'";
</script>';
  
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

        <!-- .style1 {

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



            <? include('../../common/title_bar_basic.php');?>

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

                                <div align="left" style="font-size:16px;"> <?=$msg;?></div>

                                    <div class="">

                                        <? include('../../common/input_bar_basic2.php');?>

                                            <div>

                                                <div>

          <table align="center" class="table table-bordered" width="80%" style=" margin-top: 5%;background: #ffd602 !important; border-radius: 5px;text-align: right; padding: 12px;">

                                                        <tbody>
                                                           <tr class="oe_form_group_row">
                                 <td colspan="6"  class="oe_form_group_cell oe_form_group_cell_label" align="center">
                                 <button name="update" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit" style="background:red; color:#FFFFFF; width:180px; height:40px; box-shadow:2px 3px 2px 1px;" onclick="confirm("Are you sure ?");">Update Information</button>                                </td>
                                 </tr>
                                                            <tr class="oe_form_group_row">

                                                                <td colspan="1" class="oe_form_group_cell" width="100%">

                                                                    <table  class="table  oe_form_group " width="100%">

                                                                        <tbody>

                                                                            <tr class="oe_form_group_row">

                                                                              <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label style1">&nbsp;<strong> Employee ID </strong> </td>

                                                                              <td colspan="2" class="oe_form_group_cell">            
																			   <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                                                                    <input name="PBI_ID" type="hidden" id="PBI_ID" value="<?=$PBI_ID?>" class="form-control" />
																			  
																			  
																			  <input type="hidden" name="service_days_current_date" id="service_days_current_date" value="<?=$total_service_days_current_date?>" />
																			  <input name="PBI_CODE" type="text" id="PBI_CODE" value="<?=$PBI_CODE?>" class="form-control" readonly="readonly" />
																			  <input type="hidden" name="service_days_current_date2" id="service_days_current_date2" value="<?=$total_service_days_current_date?>" /></td>

                                                                              <td class="oe_form_group_cell style1">&nbsp;</td>

                                                                              <td class="oe_form_group_cell"><span class="oe_form_group_cell style1">Concern </span></td>

                                                                              <td class="oe_form_group_cell"><select name="PBI_ORG"  class="form-control">

                                                                               
                                                                                <?=foreign_relation('user_group','id','group_name',$PBI_ORG);?>

                                                                              </select></td>
                                                                            </tr>

                                                                            <tr class="oe_form_group_row">

                 <td  width="235" colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong><span class="style1">&nbsp;&nbsp;Name </span>
</strong></td>

                                                                                <td colspan="2" class="oe_form_group_cell"><input name="PBI_NAME" type="text" id="PBI_NAME"  class="form-control"  value="<?=$PBI_NAME?>" /></td>

                                                                                <td  width="99" class="oe_form_group_cell">&nbsp;</td>

                                                                                <td  width="205" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"><span class="style1"><!--Business Unit :--></span></span>Father's Name </td>

                                                                                <td  width="224" class="oe_form_group_cell">

                                                                              <!--<select name="JOB_LOCATION" id="JOB_LOCATION"  class="form-control" >

                                                                                        <? foreign_relation('business_unit','id','unit_name',$JOB_LOCATION,' 1');?>
                                                                                    </select>-->
                                                                              <input name="PBI_FATHER_NAME"  class="form-control"  type="text" id="PBI_FATHER_NAME" value="<?=$PBI_FATHER_NAME?>" /></td>
                                                                            </tr>

                                                                            <tr class="oe_form_group_row">

                    <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Mother's Name </td>

                                                                                <td colspan="2" class="oe_form_group_cell"><input name="PBI_MOTHER_NAME"  class="form-control"  type="text" id="PBI_MOTHER_NAME" value="<?=$PBI_MOTHER_NAME?>" /></td>

                                                                                <td  class="oe_form_group_cell">&nbsp;</td>

                                                                                <td  class="oe_form_group_cell"><strong><span class="style1">Blood Group </span></strong></td>

                                                                                <td  class="oe_form_group_cell"><select name="PBI_BLOOD_GROUP"  class="form-control" >
                                                                                  <option>
                                                                                    <?=$PBI_BLOOD_GROUP?>
                                                                                  </option>
                                                                                  <option>A(+ve)</option>
                                                                                  <option>A(-ve)</option>
                                                                                  <option>AB(+ve)</option>
                                                                                  <option>AB(-ve)</option>
                                                                                  <option>B(+ve)</option>
                                                                                  <option>B(-ve)</option>
                                                                                  <option>O(+ve)</option>
                                                                                  <option>O(-ve)</option>
                                                                                  <option>N/I</option>
                                                                                </select></td>
                                                                            </tr>

																			
                                                                            <tr class="oe_form_group_row">

                                                                                <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label style1"><strong>&nbsp;&nbsp;Date of Birth </strong></td>

                                                                                <td colspan="2"  class="oe_form_group_cell"><input name="PBI_DOB" type="date" id="PBI_DOB" value="<?=$PBI_DOB?>"  class="form-control" style="width:189px" /></td>

                                                                                <td  class="oe_form_group_cell">&nbsp;</td>

                                                                                <td  class="oe_form_group_cell">Place of Birth </td>

                                                                                <td  class="oe_form_group_cell"><select name="PBI_POB"  class="form-control" >
                                                                                  <option value="<?=$PBI_POB?>">
                                                                                  <?=$PBI_POB?>
                                                                                  </option>
                                                                                  <? foreign_relation('district_list','district_name','district_name',$PBI_POB,' 1 order by district_name');?>
                                                                                </select></td>
                                                                            </tr>
																			
																			
																			
																			<!--<tr class="oe_form_group_row">

                                                                                <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label style1">&nbsp;</td>

                                                                                <td colspan="2"  class="oe_form_group_cell">&nbsp;</td>

                                                                                <td  class="oe_form_group_cell">&nbsp;</td>

                                                                                <td  class="oe_form_group_cell"><strong><span class="oe_form_group_cell oe_form_group_cell_label">                                                                                        <span class="">SBU Type   :</span></span></strong></td>

                                                                                <td  class="oe_form_group_cell">

                                                                                    <select name="JOB_LOCATION" id="JOB_LOCATION"  class="form-control" >
                                                                                        <option></option>
                                                                                        <? foreign_relation('business_unit','id','unit_name',$JOB_LOCATION,' 1');?>
                                                                                    </select>                                                                                </td>
                                                                            </tr>-->

                                                                            <tr class="oe_form_group_row">

                                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label style1"><strong><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Marital Status </span></strong></td>

                                                                                <td colspan="2" class="oe_form_group_cell"><select name="PBI_MARITAL_STA"  class="form-control" >
                                                                                  <option selected="selected">
                                                                                  <?=$PBI_MARITAL_STA?>
                                                                                  </option>
                                                                                  <option>Single</option>
                                                                                  <option>Married</option>
                                                                                 
                                                                                </select></td>

                                                                                <td  class="oe_form_group_cell">&nbsp;</td>

                                                                                <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">Nationality  </span></td>

                                                                                <td  class="oe_form_group_cell"><select name="PBI_NATIONALITY"  class="form-control" >
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

                                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label style1"><strong>&nbsp;&nbsp;<span class="style1">Gender </span></strong></td>

                                                                                <td width="165"  class="oe_form_group_cell"><select name="PBI_SEX" id="PBI_SEX"  class="form-control" >
                                                                                  <option>
                                                                                  <?=$PBI_SEX?>
                                                                                  </option>
                                                                                  <option>Male</option>
                                                                                  <option>Female</option>
                                                                                </select></td>

                                                                                <td width="71"  class="oe_form_group_cell">&nbsp;</td>

                                                                                <td  class="oe_form_group_cell">&nbsp;</td>

                                                                                <td  class="oe_form_group_cell">Religion  <span class="oe_form_group_cell oe_form_group_cell_label"><br />

                  </span></td>

                                                                                <td  class="oe_form_group_cell"><select name="PBI_RELIGION"  class="form-control" >
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
                                                                                </select></td>
                                                                            </tr>

                                                                            <tr class="oe_form_group_row">

                                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Job Description </td>

                                                                                <td colspan="2" class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">
                                                                                  <textarea name="PBI_JOB_DESCRIPTION" id="PBI_JOB_DESCRIPTION" class="form-control"><?=$PBI_JOB_DESCRIPTION?>
                                                                                  </textarea>
                                                                                </span></td>

                                                                                <td class="oe_form_group_cell">&nbsp;</td>

                                                                                <td class="oe_form_group_cell">&nbsp;</td>

                                                                                <td class="oe_form_group_cell">&nbsp;</td>
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


<!-------Emergency Contact Information start----->																			
    <tr class="oe_form_group_row">
      <td colspan="6" bgcolor="#CCCCCC" class="oe_form_group_cell oe_form_group_cell_label" align="center"><strong>:: Emergency&nbsp;contact :: </strong></td>
    </tr>
    <tr class="oe_form_group_row">
      <td colspan="1"     class="oe_form_group_cell oe_form_group_cell_label"><strong class="style1">&nbsp;&nbsp;Contact Number : </strong></td>
      <td     colspan="2" class="oe_form_group_cell"> <input required name="PBI_EMERGENCY_MOBILE" id="PBI_EMERGENCY_MOBILE" value="<?=$PBI_EMERGENCY_MOBILE;?>" class="form-control"></td>      <td>&nbsp;</td>
	  <td     class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"><strong class="style1">&nbsp;&nbsp;Contact Name :</strong></td>
      <td     class="oe_form_group_cell"><input required name="PBI_EMERGENCY_NAME" type="text" class="form-control"  id="PBI_EMERGENCY_NAME" value="<?=$PBI_EMERGENCY_NAME;?>"/></td>
    </tr>																				
<!-------Emergency Contact Information End----->	

<!-------Referance----->																			
    <tr class="oe_form_group_row">
      <td colspan="6" bgcolor="#CCCCCC" class="oe_form_group_cell oe_form_group_cell_label" align="center"><strong>:: Referance :: </strong></td>
    </tr>
    <tr class="oe_form_group_row">
      <td colspan="1"     class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Referance 1 : </strong></td>
      <td     colspan="2" class="oe_form_group_cell"> <input name="PBI_REF1" id="PBI_REF1" value="<?=$PBI_REF1;?>" class="form-control"></td>      <td>&nbsp;</td>
	  <td     class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Referance 2 :</strong></td>
      <td     class="oe_form_group_cell"><input name="PBI_REF2" type="text" class="form-control"  id="PBI_REF2" value="<?=$PBI_REF2;?>"/></td>
    </tr>	
	<tr class="oe_form_group_row">
      <td colspan="1"     class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Referance 3 : </strong></td>
      <td     colspan="2" class="oe_form_group_cell"> <input name="PBI_REF3" id="PBI_REF3" value="<?=$PBI_REF3;?>" class="form-control"></td>      <td>&nbsp;</td>
	  <td     class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label"><strong class="style1">&nbsp;&nbsp;</strong></td>
      <td     class="oe_form_group_cell">&nbsp;</td>
    </tr>																			
<!-------Referance----->	

																			
                                                                          <!--Education Start-->
                                                                            <tr class="oe_form_group_row" bgcolor="#3399CC">
																			  
                                                                              <td colspan="6" class="oe_form_group_cell oe_form_group_cell_label"><div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold;">Education</div></td>
                                                                            </tr>
                                                                            
                                                                            
																			 
                                                                            	
								
								<?
								  $ss = 'select * from education_detail where PBI_ID='.$_SESSION['employee_selected'];
								  $query = db_query($ss);
								  while($data = mysqli_fetch_object($query)){
								  
								?>
                                
                                 <tr class="oe_form_group_row">
                                  <td colspan="6" bgcolor="#CCCCCC" class="oe_form_group_cell oe_form_group_cell_label"><strong>:: Degree(<?=++$i?>) :: </strong></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1"     class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>Education Qualification</td>
                                  <td     colspan="2" class="oe_form_group_cell"> <input name="EDUCATION_NOE"  id="EDUCATION_NOE" value="<?=$data->EDUCATION_NOE;?>" class="form-control">                   </td>           <td>&nbsp;</td>
									<td     class="oe_form_group_cell">&nbsp;&nbsp;Passing year </td>
                                    <td     class="oe_form_group_cell"><input name="EDUCATION_YEAR" type="text" class="form-control"  id="EDUCATION_YEAR" value="<?=$data->EDUCATION_YEAR?>"/></td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>University/Board </td>
                                  <td  colspan="2" class="oe_form_group_cell"><input style="width: 211px;" name="EDUCATION_BU" type="text" id="EDUCATION_BU" class="form-control"  value="<?=$data->EDUCATION_BU?>"/></td>
								  <td>&nbsp;</td>
                                  <td  class="oe_form_group_cell">&nbsp;&nbsp;Grade/Class</td>
                                  <td  class="oe_form_group_cell"><input name="" type="text" id="" value="<?=$data->EDUCATION_GRADE_CLASS?>" class="form-control" /></td>
                                </tr>
								
								<tr class="oe_form_group_row">
								  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Subject</td>
								  <td  colspan="2" class="oe_form_group_cell"> <input name="EDUCATION_SUBJECT" type="text" id="EDUCATION_SUBJECT" class="form-control"  value="<?=$data->EDUCATION_SUBJECT;?>" style="width: 211px;" /></td>
								  <td  class="oe_form_group_cell">&nbsp;</td>
								  <td  class="oe_form_group_cell">GPA </td>
								  <td  class="oe_form_group_cell"><input name="EDUCATION_GPA" type="text" id="EDUCATION_GPA" class="form-control"  value="<?=$data->EDUCATION_GPA?>"/></td>
								  </tr>
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Document</td>
                                  <td  colspan="2" class="oe_form_group_cell"><?
								    $edu_loc = '../../../hrm_mod/pic/education/'.$data->EDUCATION_D_ID.'.pdf';
									if(file_exists($edu_loc)){
								  ?>
								  <a href="<?=$edu_loc?>" target="_blank" class="form-control">Download Document</a>
								   <? } ?>	</td>
								  <td  class="oe_form_group_cell">								  							  </td>
								  
                                  <td  class="oe_form_group_cell"><a href="?del=<?=$data->EDUCATION_D_ID?>">
                                    <input name="button" type="button" class="form-control"  style="background:red; color:#FFFFFF; width:100px" onclick="if(!confirm('Are You Sure Delete this?')){return false;}" value="Delete" />
                                  </a></td>
                                  <td  class="oe_form_group_cell"><a href="?del=<?=$data->EDUCATION_D_ID?>"></a><a href="edcation_input_b.php?EDUCATION_D_ID=<?=$data->EDUCATION_D_ID?>" rel = "gb_page_center[940, 600]">
                                  <button name="update" accesskey="S" class="form-control"  type="button" style="background:red; color:#FFFFFF; width:100px">Update</button></a></td>
                                </tr>
<? } ?>
								
								
								<tr class="oe_form_group_row">
                                 <td colspan="6" class="oe_form_group_cell oe_form_group_cell_label">
                                 <a href="edcation_input_b.php" rel = "gb_page_center[940, 600]">
                                 <button  name="insert" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="button" style="background:green; color:#FFFFFF; width:100px; margin-left:45%">ADD NEW</button></a>                                 </td>
                                 </tr>
                                
                                                                            <!--Education Start-->
																			
																			 <!--Experience Start-->
                                                                            <tr class="oe_form_group_row" bgcolor="#3399CC">
                                                                              <td colspan="6" class="oe_form_group_cell oe_form_group_cell_label"><div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold;">Experience</div></td>
                                                                            </tr>
                                                                            
                                                                            
																			 
                                                                            	
								
								<?
								  $ss = 'select * from experience_detail where PBI_ID='.$_SESSION['employee_selected'];
								  $query = db_query($ss);
								  while($data = mysqli_fetch_object($query)){
								  
								?>
                                
                                 <tr class="oe_form_group_row">
                                  <td colspan="6" bgcolor="#CCCCCC" class="oe_form_group_cell oe_form_group_cell_label"><strong>:: Experience(<?=++$s?>) :: </strong></td>
                                </tr>
                                <tr class="oe_form_group_row">
                                  <td colspan="1"     class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>Organization Name </td>
                                  <td     colspan="2" class="oe_form_group_cell"> <input name="EXPERIENCE_NOO" id="EXPERIENCE_NOO" value="<?=$data->EXPERIENCE_NOO;?>" class="form-control">                   </td>           <td>&nbsp;</td>
									<td     class="oe_form_group_cell">Post </td>
                                    <td     class="oe_form_group_cell"><input name="EXPERIENCE_POST" type="text" class="form-control"  id="EXPERIENCE_POST" value="<?=$data->EXPERIENCE_POST?>"/></td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong>From </td>
                                  <td  colspan="2" class="oe_form_group_cell"><input style="width: 211px;" name="EXPERIENCE_FROM" type="text" id="EXPERIENCE_FROM" class="form-control"  value="<?=$data->EXPERIENCE_FROM?>"/></td>
								  <td>&nbsp;</td>
                                  <td  class="oe_form_group_cell"><span class="oe_form_group_cell oe_form_group_cell_label">To</span></td>
                                  <td  class="oe_form_group_cell"><? if($data->EXPERIENCE_TO=='0000-00-00'){?><input name="EXPERIENCE_TO" type="text" id="EXPERIENCE_TO" value="Continue" class="form-control" readonly /><? } else{?><input name="EXPERIENCE_TO" type="text" id="EXPERIENCE_TO" value="<?=$data->EXPERIENCE_TO?>" class="form-control" readonly /><? }?></td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong class="style1">&nbsp;&nbsp;Last Salary</strong></td>
                                  <td  colspan="2" class="oe_form_group_cell"><input style="width: 211px;" name="LAST_SALARY" type="text" id="LAST_SALARY" class="form-control"  value="<?=$data->LAST_SALARY;?>"/></td>
								  <td>&nbsp;</td>
                                  <td  class="oe_form_group_cell">&nbsp;</td>
                                  <td  class="oe_form_group_cell">&nbsp;</td>
                                </tr>
								
								<tr class="oe_form_group_row">
                                  <td colspan="1"  class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;<strong>&nbsp;&nbsp;<!--</strong>Experience Length :</strong>--></td>
                                  <td  colspan="2" class="oe_form_group_cell"></td>
								  <td  class="oe_form_group_cell">
								  <?
								    $loc = '../../pic/experience/'.$data->EXPERIENCE_DETAIL_ID.'.pdf';
									if(file_exists($loc)){
								  ?>
								  <a href="<?=$loc?>" target="_blank" class="form-control">Document</a>
								   <? } ?>								  </td>
								  
                                  <td  class="oe_form_group_cell"><a href="?exdel=<?=$data->EXPERIENCE_DETAIL_ID?>">
                                    <input name="button" type="button" class="form-control"  style="background:red; color:#FFFFFF; width:100px" onclick="if(!confirm('Are You Sure Delete this?')){return false;}" value="Delete" />
                                  </a></td>
                                  <td  class="oe_form_group_cell"><a href="?dela=<?=$data->EXPERIENCE_DETAIL_ID?>"></a><a href="experience_input_b.php?EXPERIENCE_DETAIL_ID=<?=$data->EXPERIENCE_DETAIL_ID?>" rel = "gb_page_center[940, 600]">
                                  <button name="update" accesskey="S" class="form-control"  type="button" style="background:red; color:#FFFFFF; width:100px">Update</button></a></td>
                                </tr>
								<? } ?>
								
								<tr class="oe_form_group_row">
                                 <td colspan="6"  class="oe_form_group_cell oe_form_group_cell_label"><a href="experience_input_b.php" rel = "gb_page_center[940, 600]">
                                 <button name="insert" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="button" style="background:green; color:#FFFFFF; width:100px; margin-left:45%">ADD NEW</button></a>                                 </td>
                                 </tr>
                                
                                                                            <!--Experience Start-->
																			
																			
                                                                            <tr class="oe_form_group_row">
																			

																			

										 <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong class="style1">&nbsp;&nbsp;Present Address </strong></td>

                                                                                <td colspan="2" class="oe_form_group_cell"><input required name="PBI_PRESENT_ADD" type="text" id="PBI_PRESENT_ADD" value="<?=$PBI_PRESENT_ADD?>"  class="form-control"></td>

                                                                              

                                                                                <td  class="oe_form_group_cell">&nbsp;</td>

                                                                                <td  class="oe_form_group_cell"><strong>&nbsp;&nbsp;</strong><strong>Tin No </strong></td>

                                                                                <td  class="oe_form_group_cell"><input name="PBI_TIN_NO" type="number" id="PBI_TIN_NO" value="<?=$PBI_TIN_NO?>"  class="form-control" /></td>
                                                                            </tr>

                                                                            <tr class="oe_form_group_row">

                                                                              <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong class="style1">&nbsp;&nbsp;Permanent Address </strong></td>

                                                                                <td colspan="2"  class="oe_form_group_cell"><input name="PBI_PERMANENT_ADD" type="text" id="PBI_PERMANENT_ADD" value="<?=$PBI_PERMANENT_ADD?>" required class="form-control" /></td>

                                                                                <td class="oe_form_group_cell">&nbsp;</td>

                                                                                <td class="oe_form_group_cell"><strong class="style1">&nbsp;&nbsp;National ID </strong></td>

                                                                                <td class="oe_form_group_cell"><input required name="nid" type="number" id="nid" value="<?=$nid?>"  class="form-control" /></td>
                                                                            </tr>

                                                                            <tr class="oe_form_group_row">

                                <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;<span class="style1">Mobile Office</span></strong></td>

                                <td colspan="2"  class="oe_form_group_cell"><input name="PBI_MOBILE" type="number" id="PBI_MOBILE" value="<?=$PBI_MOBILE?>"  class="form-control" step="0.01" ></td>

                                                                                <td  class="oe_form_group_cell">&nbsp;</td>

                                                                               <td class="oe_form_group_cell">&nbsp;&nbsp;E-mail </td>

                                                                                <td class="oe_form_group_cell"><input name="PBI_EMAIL" type="text" id="PBI_EMAIL" value="<?=$PBI_EMAIL?>"  class="form-control" /></td>
                                                                            </tr>

                                                                            <tr class="oe_form_group_row">

                                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Mobile Personal  </td>

                                                                                <td colspan="2" class="oe_form_group_cell"><input name="PBI_MOBILE_ALT" type="number" id="PBI_MOBILE_ALT" value="<?=$PBI_MOBILE_ALT?>"  class="form-control" step="0.01"></td>

                                                                                <td class="oe_form_group_cell">&nbsp;</td>

																				

																				 <td  class="oe_form_group_cell">&nbsp;&nbsp;Alt E-mail</td>

                                                                                 <td  class="oe_form_group_cell"><input name="PBI_EMAIL_ALT" type="text" id="PBI_EMAIL_ALT" value="<?=$PBI_EMAIL_ALT?>"  class="form-control" /></td>
                                                                            </tr>

																			

																			<!--<tr class="oe_form_group_row">

                                                                                <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;</strong></td>

                                                                                <td colspan="2" class="oe_form_group_cell">&nbsp;</td>

                                                                                <td class="oe_form_group_cell">&nbsp;</td>

                                                                                <td class="oe_form_group_cell"><strong>&nbsp;&nbsp;Tax Ledger :</strong></td>

                                                                                <td class="oe_form_group_cell">

																				

																				<?php 

																						  $last_id=find_a_field('personnel_basic_info','max(PBI_ID)','1')+1;

																				?>

									

																				

																				<input name="tax_ledger" type="text" id="tax_ledger" class="form-control"  value="<?php if($$unique=$last_id){

																				echo $tax_ledger=next_ledger_ids('2003');

																				} else {

																				echo $tax_ledger;}?>" readonly/>																				</td>
                                                                            </tr>

                                                                            <tr class="oe_form_group_row">

                                                                              <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;PF Ledger :</strong></td>

                                                                              <td colspan="2"  class="oe_form_group_cell">

																			  <input name="pf_ledger" type="text" id="pf_ledger" class="form-control"  value="<?php if($$unique=$last_id){

																				echo $pf_ledger=next_ledger_ids('2002');

																				} else {

																				echo $pf_ledger;}?>" readonly />																			  </td>

                                                                              <td  class="oe_form_group_cell">&nbsp;</td>

                                                                              <td  class="oe_form_group_cell"><strong>&nbsp;&nbsp;Advance Ledger :</strong></td>

                                                                              <td  class="oe_form_group_cell">

																			   <input name="advance_ledger" type="text" id="advance_ledger" class="form-control"  value="<?php if($$unique=$last_id){

																				echo $advance_ledger=next_ledger_ids('1087');

																				} else {

																				echo $advance_ledger;}?>" readonly />																			  </td>
                                                                            </tr>-->

                                                                            <tr class="oe_form_group_row">

                                                                                <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Employee  Picture  </strong></td>

                                                                                <td colspan="2"  class="oe_form_group_cell"><input type="file" name="emp_pic" id="emp_pic" class="form-control" /></td>

                                                                                <td  class="oe_form_group_cell">&nbsp;</td>

                                                                                <td  class="oe_form_group_cell">&nbsp;&nbsp;National ID</td>

                                                                                <td  class="oe_form_group_cell"><input type="file" name="nid_pic" id="nid_pic" class="form-control" /></td>
                                                                            </tr>

                                                                            <tr class="oe_form_group_row">

                                                                               <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><strong>&nbsp;&nbsp;Employee signature  </strong></td>

                                                                               <td colspan="2" class="oe_form_group_cell"><input type="file" name="signature" id="signature" class="form-control" value=""/></td>

                                                                                <td     class="oe_form_group_cell">&nbsp;</td>

                                                                                <td     class="oe_form_group_cell"><span class="">&nbsp;&nbsp;Tin Certificate</span></td>

                                                                                <td     class="oe_form_group_cell"><input type="file" name="tin_certificate" id="tin_certificate" class="form-control" />                                                                                </tr>

                                                                            <tr class="oe_form_group_row">

                                                                                <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Employee Picture</td>

                                <td colspan="2"  class="oe_form_group_cell"><img src="<?=$picture_file?>" style="width:200px; "/></td>
								<td width="1"  class="oe_form_group_cell">&nbsp;</td>

                                                                                <td  class="oe_form_group_cell">NID </td>
                                                                                <?
																			    $files_pdf = '../../../hrm_mod/pic/nid/'.$_SESSION['employee_selected'].'.pdf';
																				$files_jpg = '../../../hrm_mod/pic/nid/'.$_SESSION['employee_selected'].'.jpg';
																				$files_png = '../../../hrm_mod/pic/nid/'.$_SESSION['employee_selected'].'.png';
																				if(file_exists($files_pdf)){
																				$nid_doc = $files_pdf;
																				$text = 'Download NID';
																				$pdf = 1;
																				}elseif(file_exists($files_jpg)){
																				$nid_doc = $files_jpg;
																				$text = 'NID';
																				$pdf = 0;
																				}elseif(file_exists($files_png)){
																				$nid_doc = $files_png;
																				$text = 'NID';
																				$pdf = 0;
																				}else{
																				$nid_doc = '';
																				$text = 'NID not upload yet';
																				$pdf = 0;
																				}
																			  ?>
																			   <? if($pdf>0){?>
                                                                                <td  class="oe_form_group_cell"><a href="<?=$nid_doc?>" style="width:98%;" target="_blank"><?=$text?></a></td>
																				<? }else{?>
																				<td  class="oe_form_group_cell"><img src="<?=$nid_doc?>" style="width:200px;" /></td>
																				<? } ?>

                                                                                
                                                                            </tr>
																			
																			
<tr class="oe_form_group_row">
   <td  colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Employee Signature</td>
     
   <td colspan="2"  class="oe_form_group_cell"><? if(file_exists($signature_file)){ ?><img src="<?=$signature_file;?>" style="width:200px;" /><? }else{ echo 'Signature not upload yet'; } ?></td>
   <td  class="oe_form_group_cell">&nbsp;</td>
   
   <?
																			    $tin_pdf = '../../../hrm_mod/pic/tin/'.$_SESSION['employee_selected'].'.pdf';
																				$tin_jpg = '../../../hrm_mod/pic/tin/'.$_SESSION['employee_selected'].'.jpg';
																				$tin_png = '../../../hrm_mod/pic/tin/'.$_SESSION['employee_selected'].'.png';
																				if(file_exists($tin_pdf)){
																				$tin_doc = $tin_pdf;
																				$text = 'Download TIN';
																				$tin_pdf = 1;
																				}elseif(file_exists($tin_jpg)){
																				$tin_doc = $tin_jpg;
																				$text = 'TIN';
																				$tin_pdf = 0;
																				}elseif(file_exists($tin_png)){
																				$tin_doc = $tin_png;
																				$text = 'TIN';
																				$tin_pdf = 0;
																				}else{
																				$tin_doc = '';
																				$text = 'TIN not upload yet';
																				$tin_pdf = 0;
																				}
																			  ?>
   <td  class="oe_form_group_cell">TIN  </td>

   <? if($tin_pdf>0){?>
                                                                                <td  class="oe_form_group_cell"><a href="<?=$tin_doc?>" style="width:98%;" target="_blank"><?=$text?></a></td>
																				<? }else{?>
																				<td  class="oe_form_group_cell"><img src="<?=$tin_doc?>" style="width:200px;" /></td>
																				<? } ?>
   
 </tr>
 <tr class="oe_form_group_row">
                                 <td colspan="6"  class="oe_form_group_cell oe_form_group_cell_label" align="center">
                                 <button name="update" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit" style="background:red; color:#FFFFFF; width:100px;width:180px; height:40px; box-shadow:2px 3px 2px 1px;" onclick="confirm("Are you sure ?");">Update Information</button>                                </td>
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

require_once SERVER_CORE."routing/layout.bottom.php";
?>