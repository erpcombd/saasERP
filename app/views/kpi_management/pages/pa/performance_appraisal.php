<?php

@session_start();

ob_start();

require "../../config/inc.all.php";

require "../../template/main_layout.php";






/*
if($_GET['PBI_ID']>0){



  $_SESSION['employee_selected'] = $_GET['PBI_ID'];

}*/

// ::::: Edit This Section :::::

$title='Performance Appraisal';		// Page Name and Page Title

$page="performance_appraisal.php";		// PHP File Name

$input_page="performance_appraisal_input.php";

$root='kpi';



$table='performance_appraisal';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='type';





// ::::: End Edit Section :::::



$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_GET['id'].'"');
$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$_SESSION['employee_selected'].'"');

$EMPLOYMENT_TYPE = find_a_field('essential_info','EMPLOYMENT_TYPE','PBI_ID="'.$_GET['id'].'"');

$DEPT_HEAD =  find_a_field('hrm_pa_set','DEPT_HEAD','PBI_ID="'.$_GET['id'].'"');

$crud      =new crud($table);

/*$required_id=find_a_field($table,$unique,'PBI_ID='.$_GET['id']);
if($required_id>0)

$$unique = $_GET[$unique] = $required_id;*/


// INFORMATION **********


$designation = find_a_field('designation','DESG_DESC','DESG_ID="'.$employee->PBI_DESIGNATION.'"');
$PBI_DEPARTMENT = find_a_field('department','DEPT_DESC','DEPT_ID="'.$employee->PBI_DEPARTMENT.'"');
$JOB_LOCATION = find_a_field('project','PROJECT_DESC','PROJECT_ID="'.$employee->JOB_LOCATION.'"');

$job_period = date_diff(date_create(date('Y-m-d')), date_create($employee->PBI_DOJ));





//if(isset($_POST[$shown]))

//{
$check = find_a_field('performance_appraisal','id','year="'.$_GET['year'].'" and PBI_ID="'.$_GET['id'].'" and status!="Done" and entry_by="'.$_SESSION['user']['id'].'"');
$$unique = $check;
if(isset($_POST['submit']))

	{

            
			if($check=='' || $check==0){
            $_REQUEST['uniq_code']=$_POST['uniq_code'];
            $_REQUEST['PBI_ID']=$employee->PBI_ID;

			$_REQUEST['type']='Annual Review';

			$_REQUEST['submit_date']=date('Y-m-d');

			//$_REQUEST['year']=date('Y');

			$_REQUEST['entry_at']=date('Y-m-d h:s:i');

			$_REQUEST['entry_by']=$_SESSION['employee_selected'];
			
			$_REQUEST['EMPLOYMENT_TYPE'] = $EMPLOYMENT_TYPE;
			
			$_REQUEST['DEPT_HEAD'] = $DEPT_HEAD;
			
			$_REQUEST['designation'] = $designation;
			
			$_REQUEST['PBI_DEPARTMENT'] = $PBI_DEPARTMENT;
			$_REQUEST['JOB_LOCATION'] = $JOB_LOCATION;
			
			$_REQUEST['job_period'] = $job_period->format("%Y Year, %M Months, %d Days");
			
			
			
			
			$$unique = $crud->insert();
             
			 }else{
             $$unique = $crud->update($unique);
             }
		   
		   $type=1;

			$msg='New Entry Successfully Inserted.';
    
			//unset($_POST);

			//unset($$unique);

			echo '<script type="text/javascript">parent.parent.document.location.href = "performance_appraisal_2nd.php?id='.$_GET['id'].'&&year='.$_POST['year'].'&&uniq='.$_POST['uniq_code'].'";</script>';



	}







/*$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);

if($required_id>0)

$$unique = $_GET[$unique] = $required_id;

else

$$unique = $_SESSION['employee_selected']=$_POST['PBI_ID'];*/



	//for Modify..................................

	if(isset($_POST['update']))

	{

		$path='../../pic/staff';

		$_POST['pic']=image_upload($path,$_FILES['pic']);



		if($_FILES['emp_pic']['tmp_name']!=''){

			$file_name= $_FILES['emp_pic']['name'];

			$file_tmp= $_FILES['emp_pic']['tmp_name'];

			$ext=end(explode('.',$file_name));

			$path='../../pic/staff/';

			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.jpeg');

			}



			if($_FILES['nid_pic']['tmp_name']!=''){

			$file_name= $_FILES['nid_pic']['name'];

			$file_tmp= $_FILES['nid_pic']['tmp_name'];

			$ext=end(explode('.',$file_name));

			$path='../../pic/nid/';

			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.jpeg');

			}



			if($_FILES['pass_pic']['tmp_name']!=''){

			$file_name= $_FILES['pass_pic']['name'];

			$file_tmp= $_FILES['pass_pic']['tmp_name'];

			$ext=end(explode('.',$file_name));

			$path='../../pic/passport/';

			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.jpeg');

			}



		    $_POST['PBI_ID']=$_SESSION['employee_selected'];

			$inserted = $crud->insert();

			$type=1;

			$msg='New Entry Successfully Inserted.';

			unset($_POST);

			unset($$unique);

			echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/confirmation_list.php";</script>';

	}



	if(isset($_POST['reset']))

	{

		echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/confirmation_list.php";</script>';

	}

//}



if(isset($_POST['delete']))



{		$condition=$unique."=".$$unique;		$crud->delete($condition);



		unset($$unique);



		echo '<script type="text/javascript">



parent.parent.document.location.href = "../'.$root.'/'.$page.'";



</script>';



		$type=1;



		$msg='Successfully Deleted.';



}





if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

while (list($key, $value)=each($data))

{ $$key=$value;}

}



$data = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);



$color = '#00CCFF';





?>







	<script>





	  function avg(){



		   var ratinga = parseFloat(document.getElementById('part_1').value);

		   if(ratinga>0){

		     var rating1 = ratinga;

		   }else{

		   var rating1 = 0;

		   }

		   var ratingb = parseFloat(document.getElementById('part_2').value);

		   if(ratingb>0){

		     var rating2 = ratingb;

		   }else{

		   var rating2 = 0;

		   }

		   var ratingc = parseFloat(document.getElementById('part_3').value);

		   if(ratingc>0){

		     var rating3 = ratingc;

		   }else{

		   var rating3 = 0;

		   }

		   var ratingd = parseFloat(document.getElementById('part_4').value);

		   if(ratingd>0){

		     var rating4 = ratingd;

		   }else{

		   var rating4 = 0;

		   }

		   var ratinge = parseFloat(document.getElementById('part_5').value);

		   if(ratinge>0){

		     var rating5 = ratinge;

		   }else{

		   var rating5 = 0;

		   }

		  /* var ratingf = parseFloat(document.getElementById('part_6').value);

		   if(ratingf>0){

		     var rating6 = ratingf;

		   }else{

		   var rating6 = 0;

		   }*/

		   var ratingg = parseFloat(document.getElementById('part_7').value);

		   if(ratingg>0){

		     var rating7 = ratingg;

		   }else{

		   var rating7 = 0;

		   }

		   var ratingh = parseFloat(document.getElementById('part_8').value);

		   if(ratingh>0){

		     var rating8 = ratingh;

		   }else{

		   var rating8 = 0;

		   }

		   var ratingi = parseFloat(document.getElementById('part_9').value);

		   if(ratingi>0){

		     var rating9 = ratingi;

		   }else{

		   var rating9 = 0;

		   }

		 /*  var ratingj = parseFloat(document.getElementById('part_10').value);

		   if(ratingj>0){

		     var rating10 = ratingj;

		   }else{

		   var rating10 = 0;

		   }*/



		   var ratingk = parseFloat(document.getElementById('part_11').value);

		   if(ratingk>0){

		     var rating11 = ratingk;

		   }else{

		   var rating11 = 0;

		   }


		    var ratingu = parseFloat(document.getElementById('part_21').value);

		   if(ratingu>0){

		     var rating21 = ratingu;

		   }else{

		   var rating21 = 0;

		   }


		    var ratingv = parseFloat(document.getElementById('part_22').value);

		   if(ratingv>0){

		     var rating22 = ratingv;

		   }else{

		   var rating22 = 0;

		   }

        
           //rating6+rating10
		   var rating_sum = rating1+rating2+rating3+rating4+rating5+rating7+rating8+rating9+rating11+rating21+rating22;





		  //var avg = (rating_sum*13)/100;



		  document.getElementById('total_score_1').value=rating_sum.toFixed(0);

	  }

	</script>







<style type="text/css">

<!--
.style1 {font-weight: bold}

-->

.english_font{font-size: 11;};
.bangla_font{font-size: 10;};


    </style>







	<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->

          <div class="">







        <div class="clearfix"></div>



            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">



				<h3 align="center">PERFORMANCE APPRAISAL</h3>



		     <? //include('../../common/new_title.php');?>





                  </div>



				  <div class="x_panel">

				  <table width="100%" style="height:30px;" border="0" cellspacing="0" cellpadding="0" align="center">

				     <tr>

					    <td align="center" style="background:<?=$color?>;">Step 1</td>

						<td align="center">Step 2</td>

						<!--<td align="center">Setp 3</td>-->

						<td align="center">Final</td>

					 </tr>

				  </table>

                  </div>



				  	 <div class="openerp openerp_webclient_container">









                  <div class="x_content">











<form action="" method="post"  style="text-align:center" enctype="multipart/form-data">

  <div class="oe_view_manager oe_view_manager_current">

    <? //include('../../common/title_bar_data.php');?><br />

    <div class="oe_view_manager_body">

      <div  class="oe_view_manager_view_list"></div>

      <div class="oe_view_manager_view_form">

        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

          <div class="oe_form_buttons"></div>

          <div class="oe_form_sidebar"></div>

          <div class="oe_form_pager"></div>





                <? //include('../../common/input_bar.php');?>







                  <div class="container" style="margin-top:1%;">

				 <br />

                <div class="oe_chatter">

                  <div class="oe_followers oe_form_invisible">

                    <div class="oe_follower_list"></div>

                  </div>





		<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">

		<tr height="60">

		  <td>

		    <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">



			<tr>

			   <td style="font-size:16px; padding:2px;"> ID NO : <b><?=$employee->PBI_CODE?></b></td>

			   <td style="font-size:16px; padding:2px;">NAME : <b><?=$employee->PBI_NAME?></b> </td>

			    <td style="font-size:16px; padding:2px;">DESIGNATION :  <b><?=find_a_field('designation','DESG_DESC','DESG_ID='.$employee->PBI_DESIGNATION);?></b></td>

			</tr>



			<tr>

			   <td style="font-size:16px; padding:2px;">DEPARTMENT :  <b><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$employee->PBI_DEPARTMENT);?></b></td>

			   <td style="font-size:16px; padding:2px;"> PROJECT NAME :  <b><?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$employee->JOB_LOCATION);?></b></td>

			    <td style="font-size:16px; padding:2px;">JOINING DATE :  <b><?=date('d-M-Y',strtotime($employee->PBI_DOJ))?></b></td>

			</tr>





			 <tr>

			   <td style="font-size:16px; padding:2px;">NAME OF APPRAISER : <b><?=$appraiser->PBI_NAME?></b></td>



			   <td style="font-size:16px; padding:2px;">DESIGNATION OF APPRAISER : <b><?=find_a_field('designation','DESG_DESC','DESG_ID='.$appraiser->PBI_DESIGNATION);?></b></td>

			   <td style="font-size:16px; padding:2px;"> EMPLOYEE TYPE :  <b><?=find_a_field('essential_info','EMPLOYMENT_TYPE','PBI_ID='.$employee->PBI_ID);?></b></td>

			</tr>

			</table>

		  </td>



	 </tr>











</table>



<br />
<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td style="padding:5px; width:5%; background-color:#87CEEB"><div style="text-align:center"><b>Rating Scale</b></div></td>
    <td style="padding:5px; width:30%; text-align:center;background-color:#87CEEB"><b>Description</b></td>
    <td style="padding:5px; width:5%; text-align:center;background-color:#87CEEB"><b>Rating Scale</b></td>
    <td style="padding:5px; width:30%; text-align:center;background-color:#87CEEB"><b>Description</b></td>
  </tr>
  <tr>
    <td style="padding:5px; text-align:center">0</td>
    <td style="padding:5px;">Performance does not meet minimum requirements of the job.</td>
    <td style="padding:5px; text-align:center">1</td>
    <td style="padding:5px;">Performance is inconsistent.  Meets requirements of the job occasionally.</td>
  </tr>
  <tr>
    <td style="padding:10px; text-align:center">2</td>
    <td style="padding:5px;">Performance is satisfactory. Meets requirements of the needs.</td>
    <td style="padding:10px; text-align:center">3</td>
    <td style="padding:5px;">Performance is consistent. Clearly meets job requirements.</td>
  </tr>
  <tr>
    <td style="padding:10px; text-align:center">4</td>
    <td style="padding:5px;">Performance is consistent and exceeds expectations.</td>
    <td style="padding:5px; text-align:center">5</td>
	<td style="padding:5px;">Performance is exceptional and far exceeds expectations. Demonstrates excellent standard.</td>

  </tr>
</table>
<br />
<br />



<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">

<tr>

   <td><div align="center"><strong>Appraisal  Type : </strong> <input type="text" value="<?=find_a_field('essential_info','EMPLOYMENT_TYPE','PBI_ID='.$employee->PBI_ID);?>" readonly="readonly"/></div></td>

 </tr> 
 
 

  

</table><br />



<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">



  <tr>

   <td><div align="center"><strong>Appraisal  Year : </strong><select name="year" id="year" required="required" >

   <option label="Please Select" value=""></option>


   <option <?=($year==2021)? 'selected' : ''?>>2021</option>

   <option <?=($year==2022)? 'selected' : ''?>>2022</option>

   <option <?=($year==2023)? 'selected' : ''?>>2023</option>
   
    <option <?=($year==2024)? 'selected' : ''?>>2024</option>
	
	<option <?=($year==2025)? 'selected' : ''?>>2025</option>
	
	<option <?=($year==2026)? 'selected' : ''?>>2026</option>
	
	<option <?=($year==2027)? 'selected' : ''?>>2027</option>
	
	<option <?=($year==2028)? 'selected' : ''?>>2028</option>
	
	<option <?=($year==2029)? 'selected' : ''?>>2029</option>
	
	<option <?=($year==2030)? 'selected' : ''?>>2030</option>
	
   </select></div></td>
 
 </tr> 
 
 

</table>


<br />


<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">

<tr>

   <td><div align="center"><strong>Assessment Year : </strong>
   
   <select name="assessment_year" id="assessment_year" disabled>




   <option <?=($year==2024)? 'selected' : ''?>>2024</option>
   
   <option <?=($year==2023)? 'selected' : ''?>>2023</option>

   <option <?=($year==2022)? 'selected' : ''?>>2022</option>

   

   </select></div></td>

 </tr>

</table>


<br />






<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">





	 <!--Part-1-->

	  <tr style="background-color:#87CEEB">

		<td style="padding:5px; width:40%" align="center" colspan="2">

		<input type="hidden" name="uniq_code" id="uniq_code" value="<?=uniqid();?>"/> 

		<input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /> <b>PART I &nbsp;&nbsp;</b> <b>EMPLOYEE</b></td>

		<td style="padding:5px; width:10%" align="center"><b><center>Rating</center></b></td>

	  </tr>



	  <tr>

		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Teamwork</span></td>

		<td style="padding:5px;">1. Able and willing to work effectively with others in a team.<br> <span style="font-size:14px">দলের অন্যদের সঙ্গে কাজ করতে ইচ্ছুক এবং সক্ষম কি না।</span></td>

		<td style="padding:5px; text-align:center"><select name="part_1" id="part_1" onchange="avg()">

		  <option selected="selected" disabled="disabled">..Select One..</option>
          
		  
		  <option <?=($part_1==0)? 'selected' : ''?>>0</option>

		  <option <?=($part_1==1)? 'selected' : ''?>>1</option>

		  <option <?=($part_1==2)? 'selected' : ''?>>2</option>

	      <option <?=($part_1==3)? 'selected' : ''?>>3</option>

		  <option <?=($part_1==4)? 'selected' : ''?>>4</option>
		  <option <?=($part_1==5)? 'selected' : ''?>>5</option>



		</select></td>

	   </tr>



	   <tr>

		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Communication Skills</span></td>

		<td style="padding:5px;">2. Highly disciplined in conveying information through presentations and does proper use of English while communicating via email or any other medium.<br>
		<span style="font-size:14px">উপস্থাপনার মাধ্যমে তথ্য জানানোর ক্ষেত্রে অত্যন্ত সুশৃঙ্খল এবং ইমেইল বা অন্য কোনো মাধ্যমে যোগাযোগ করার সময় ইংরেজির যথাযথ ব্যবহার করে থাকে।</span></td>

		<td style="padding:5px;text-align:center"><select name="part_2" id="part_2" onchange="avg()">

		 <option selected="selected" disabled="disabled">..Select One..</option>

		 <option <?=($part_2==0)? 'selected' : ''?>>0</option>

		 <option <?=($part_2==1)? 'selected' : ''?>>1</option>

		 <option <?=($part_2==2)? 'selected' : ''?>>2</option>

	     <option <?=($part_2==3)? 'selected' : ''?>>3</option>

		 <option <?=($part_2==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_2==5)? 'selected' : ''?>>5</option>



		</select></td>

	  </tr>

	  <!--New Section added-->

	  <tr>

		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Analytical Skills</span></td>

		<td style="padding:5px;">3. Analyzes data and information from several sources and arrives at logical conclusions.<br>
		<span style="font-size:14px">বিভিন্ন উৎস থেকে ডেটা এবং তথ্য বিশ্লেষণ করে এবং যৌক্তিক সিদ্ধান্তে পৌঁছায় কি না।</span></td>

		<td style="padding:5px;text-align:center"><select name="part_21" id="part_21" onchange="avg()">

		 <option selected="selected" disabled="disabled">..Select One..</option>

		 <option <?=($part_21==0)? 'selected' : ''?>>0</option>

		 <option <?=($part_21==1)? 'selected' : ''?>>1</option>

		 <option <?=($part_21==2)? 'selected' : ''?>>2</option>

	     <option <?=($part_21==3)? 'selected' : ''?>>3</option>

		 <option <?=($part_21==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_21==5)? 'selected' : ''?>>5</option>




		</select></td>

	  </tr>





	  <tr>

		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold; text-align:center" ><span style="writing-mode: sideways-lr;">Individual  Task</span></td>

		<td style="padding:5px;">4. Completes tasks in an error free manner and within the timeframe.<br><span style="font-size:14px">নির্ভুলভাবে এবং নির্ধারিত সময়সীমার মধ্যে কাজগুলি সম্পূর্ণ করে।  </span></td>

		<td style="padding:5px;text-align:center"><select name="part_22" id="part_22" onchange="avg()">

		 <option selected="selected" disabled="disabled">..Select One..</option>

		 <option <?=($part_22==0)? 'selected' : ''?>>0</option>

		 <option <?=($part_22==1)? 'selected' : ''?>>1</option>

		 <option <?=($part_22==2)? 'selected' : ''?>>2</option>

	     <option <?=($part_22==3)? 'selected' : ''?>>3</option>

		 <option <?=($part_22==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_22==5)? 'selected' : ''?>>5</option>




		</select></td>

	  </tr>


	  <!--END New Section added-->



	  <tr>

		<td style="padding:20px;text-align:center" >Comments <br /> (Describe Each Point)</td>

		<td style="padding:5px;" colspan="2"><textarea name="part_1_comment" id="part_1_comment" cols="100" style="width:100%;" required="required"><?=$part_1_comment?></textarea></td>

	  </tr>

	   <!--Part-1 End-->



	   <!--Part-2-->

	   <tr style="background-color:#87CEEB">

		<td style="padding:5px; width:40%" align="center" colspan="2">
		<input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><b>PART II &nbsp;&nbsp;</b> <b>PRODUCTS AND SERVICES</b></td>

		<td style="padding:5px; width:10%" align="center"><b>Rating</b></td>

	  </tr>







	  <tr>

		<th rowspan="2" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Job Knowledge / Technical Skills </span></th>

		<td style="padding:5px;">5. Possesses knowledge of work procedures and requirements of job.<br><span style="font-size:14px">কাজের পদ্ধতি জানে এবং কাজের জন্য প্রয়োজনীয় দক্ষতা ও জ্ঞান সম্পন্ন কি না।</span></td>

		<td style="padding:5px;text-align:center"><select name="part_3" id="part_3" onchange="avg()">

		  <option selected="selected" disabled="disabled">..Select One..</option>

		 <option <?=($part_3==0)? 'selected' : ''?>>0</option>

		 <option <?=($part_3==1)? 'selected' : ''?>>1</option>

		 <option <?=($part_3==2)? 'selected' : ''?>>2</option>

	     <option <?=($part_3==3)? 'selected' : ''?>>3</option>

		 <option <?=($part_3==4)? 'selected' : ''?>>4</option>
		 <option <?=($part_3==5)? 'selected' : ''?>>5</option>



		</select></td>


	   </tr>



	   <tr>



		<td style="padding:5px;">6. Shows technical competence/skill in area of specialization.<br><span style="font-size:14px">বিশেষ ক্ষেত্রে প্রযুক্তিগত দক্ষতা বা পারদর্শিতা রয়েছে কি না।</span></td>

		<td style="padding:5px;text-align:center"><select name="part_4" id="part_4" onchange="avg()">

		 <option selected="selected" disabled="disabled">..Select One..</option>

		 <option <?=($part_4==0)? 'selected' : ''?>>0</option>

		 <option <?=($part_4==1)? 'selected' : ''?>>1</option>

		 <option <?=($part_4==2)? 'selected' : ''?>>2</option>

	     <option <?=($part_4==3)? 'selected' : ''?>>3</option>

		 <option <?=($part_4==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_4==5)? 'selected' : ''?>>5</option>




		</select></td>

	  </tr>





	  <tr>

		<th rowspan="3" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Work Attitude </span></th>

		<td style="padding:5px;">7. Displays commitment to work and willingness to learn.<br><span style="font-size:14px">কাজের প্রতি নিবেদিত বা প্রতিজ্ঞাবদ্ধ এবং নতুন কিছু শিখতে আগ্রহী কি না।</span></td>

		<td style="padding:5px;text-align:center"><select name="part_5" id="part_5" onchange="avg()">

		  <option selected="selected" disabled="disabled">..Select One..</option>

		  <option <?=($part_5==0)? 'selected' : ''?>>0</option>

		 <option <?=($part_5==1)? 'selected' : ''?>>1</option>

		 <option <?=($part_5==2)? 'selected' : ''?>>2</option>

	     <option <?=($part_5==3)? 'selected' : ''?>>3</option>

		 <option <?=($part_5==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_5==5)? 'selected' : ''?>>5</option>



		</select></td>

	   </tr>



	   <tr>

    

		<?php /*?><td style="padding:5px;">Displays a willingness to learn. <br><span style="font-size:14px">নতুন কিছু শিখতে আগ্রহী কি না।</span></td>

		<td style="padding:5px;text-align:center"><select name="part_6" id="part_6" onchange="avg()">

		  <option selected="selected" disabled="disabled">..Select One..</option>

		 <option <?=($part_6==0)? 'selected' : ''?>>0</option>

		 <option <?=($part_6==1)? 'selected' : ''?>>1</option>

		 <option <?=($part_6==2)? 'selected' : ''?>>2</option>

	     <option <?=($part_6==3)? 'selected' : ''?>>3</option>

		 <option <?=($part_6==4)? 'selected' : ''?>>4</option>



		</select></td><?php */?>

	   </tr>



	   <tr>


		<td style="padding:5px;">8. Has a sense of urgency in acting on work matters.<br>
		  <span style="font-size:14px">জরুরীভিত্তিতে কাজ করার প্রবণতা রয়েছে কি না।</span></td>

		<td style="padding:5px;text-align:center"><select name="part_7" id="part_7" onchange="avg()">

		  <option selected="selected" disabled="disabled">..Select One..</option>

		 <option <?=($part_7==0)? 'selected' : ''?>>0</option>

		 <option <?=($part_7==1)? 'selected' : ''?>>1</option>

		 <option <?=($part_7==2)? 'selected' : ''?>>2</option>

	     <option <?=($part_7==3)? 'selected' : ''?>>3</option>

		 <option <?=($part_7==4)? 'selected' : ''?>>4</option>
		 <option <?=($part_7==5)? 'selected' : ''?>>5</option>



		</select></td>

	   </tr>



	   <tr>

		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Quality of Work</span> </td>

		<td style="padding:5px;">9. Is accurate, thorough and careful with work performed.<br>
		  <span style="font-size:14px">কাজ নির্ভুল, সঠিক এবং সতর্কতার সঙ্গে সম্পন্ন করে কি না। </span></td>

		<td style="padding:5px;text-align:center"><select name="part_8" id="part_8" onchange="avg()">

		  <option selected="selected" disabled="disabled">..Select One..</option>

		 <option <?=($part_8==0)? 'selected' : ''?>>0</option>

		 <option <?=($part_8==1)? 'selected' : ''?>>1</option>

		 <option <?=($part_8==2)? 'selected' : ''?>>2</option>

	     <option <?=($part_8==3)? 'selected' : ''?>>3</option>

		 <option <?=($part_8==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_8==5)? 'selected' : ''?>>5</option>


		</select></td>

	   </tr>



	   <tr>

		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;"> Quantity of Work </span></td>

		<td style="padding:5px;">10. Is able to handle a reasonable volume of work.<br><span style="font-size:14px">নির্দিষ্ট পরিমানের কাজের চাপ সামলাতে সক্ষম কি না।</span></td>

		<td style="padding:5px;text-align:center"><select name="part_9" id="part_9" onchange="avg()">

		  <option selected="selected" disabled="disabled">..Select One..</option>

		 <option <?=($part_9==0)? 'selected' : ''?>>0</option>

		 <option <?=($part_9==1)? 'selected' : ''?>>1</option>

		 <option <?=($part_9==2)? 'selected' : ''?>>2</option>

	     <option <?=($part_9==3)? 'selected' : ''?>>3</option>

		 <option <?=($part_9==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_9==5)? 'selected' : ''?>>5</option>



		</select></td>

	   </tr>

	   <tr>

		<?php /*?><td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Safety</span></td>

		<td style="padding:5px;">11. Ensures careful work habits that comply with safety requirements.<br><span style="font-size:14px">সাবধানতার সহিত কাজ করে যা প্রয়োজনীয় নিরাপত্তা সন্তুষ্ট করে কি না।</span></td>

		<td style="padding:5px;text-align:center"><select name="part_10" id="part_10" onchange="avg()">

		  <option selected="selected" disabled="disabled">..Select One..</option>

		   <option <?=($part_10==0)? 'selected' : ''?>>0</option>

		 <option <?=($part_10==1)? 'selected' : ''?>>1</option>

		 <option <?=($part_10==2)? 'selected' : ''?>>2</option>

	     <option <?=($part_10==3)? 'selected' : ''?>>3</option>

		 <option <?=($part_10==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_10==5)? 'selected' : ''?>>5</option>




		</select></td><?php */?>

	   </tr>



	   <tr>

		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Process Improvement </span></td>

		<td style="padding:5px;">11. Seeks to continuously improve processes and work methods.<br><span style="font-size:14px">সবসময় কাজের পদ্ধতি এবং প্রক্রিয়ার উন্নতি করতে চায় কি না।</span></td>

		<td style="padding:5px;text-align:center"><select name="part_11" id="part_11" onchange="avg()">

		  <option selected="selected" disabled="disabled">..Select One..</option>

		 <option <?=($part_11==0)? 'selected' : ''?>>0</option>

		 <option <?=($part_11==1)? 'selected' : ''?>>1</option>

		 <option <?=($part_11==2)? 'selected' : ''?>>2</option>

	     <option <?=($part_11==3)? 'selected' : ''?>>3</option>

		 <option <?=($part_11==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_11==5)? 'selected' : ''?>>5</option>



		</select></td>

	   </tr>



	    <tr>

		<td style="padding:20px; text-align:center" >Comments <br /> (Describe Each Point)</td>

		<td style="padding:5px;" colspan="2"><textarea name="part_2_comment" id="part_2_comment" cols="100" style="width:100%;" required="required"><?=$part_2_comment?></textarea></td>

	  </tr>



	   <tr>

		<td style="padding:5px;" >Total Score : </td>

		<td style="padding:5px;" colspan="2"><textarea name="total_score_1" id="total_score_1" cols="100" style="width:100%;" readonly="readonly"><?=$total_score_1?></textarea></td>

	  </tr>

	   <!--Part-2 End-->

	  </table>





<br />



		<br />



<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">

    <tr>

	  <td align="center"><center><strong><input type="submit" name="submit" id="submit" value="NEXT STEP" style="background: skyblue;" /></strong></center></td>

	</tr>

</table>



		<br />



		<br />



		<br />



		<br />







</form>







		   </div>





		   </div>

		    </div>

            </div>

			</div>

			</div>

			 </div>

              </div>



          </div>

        </div>

      </div>

    </div>

  </div>





    </div>



        <!-- /page content -->

<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

<script>



$(document).ready(function(){

	$("#LINE_MANAGER_ID").keyup(function(){

		$.ajax({

		type: "POST",

		url: "auto_com.php",

		data:'keyword='+$(this).val(),

		beforeSend: function(){

			$("#LINE_MANAGER_ID").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");

		},

		success: function(data){

			$("#suggesstion-box").show();

			$("#suggesstion-box").html(data);

			$("#LINE_MANAGER_ID").css("background","#FFF");

		}

		});

	});

});



function selectCountry(val) {

$("#LINE_MANAGER_ID").val(val);

$("#suggesstion-box").hide();

}



</script>





<?

include_once("../../template/footer.php");

?>
