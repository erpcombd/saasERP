<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require "../../template/main_layout.php";



/*if($_GET['PBI_ID']>0){
  
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

$crud      =new crud($table);

$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;



			
//if(isset($_POST[$shown]))
//{	
if(isset($_POST['submit']))
	{
	
			
			$_REQUEST['PBI_ID']=$employee->PBI_ID;
			$_REQUEST['type']='Annual Review';
			$_REQUEST['submit_date']=date('Y-m-d');
			//$_REQUEST['year']=date('Y');
			$_REQUEST['entry_at']=date('Y-m-d h:s:i');
			$_REQUEST['entry_by']=$_SESSION['employee_selected'];
			$inserted = $crud->insert();
			$type=1;
			$msg='New Entry Successfully Inserted.';
			//unset($_POST);
			//unset($$unique);
			echo '<script type="text/javascript">parent.parent.document.location.href = "performance_appraisal_2nd.php?id='.$_GET['id'].'&&year='.$_POST['year'].'";</script>';

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
foreach ($data as $key => $value)
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
		   var ratingf = parseFloat(document.getElementById('part_6').value);
		   if(ratingf>0){
		     var rating6 = ratingf;
		   }else{
		   var rating6 = 0;
		   }
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
		   var ratingj = parseFloat(document.getElementById('part_10').value);
		   if(ratingj>0){
		     var rating10 = ratingj;
		   }else{
		   var rating10 = 0;
		   }
		   
		   
		   var rating_sum = rating1+rating2+rating3+rating4+rating5+rating6+rating7+rating8+rating9+rating10;
		   
		 
		  //var avg = (rating_sum*13)/100;
		  
		  document.getElementById('total_score').value=rating_sum.toFixed(0);
	  }
	</script>
	

	
    <style type="text/css">
<!--
.style1 {font-weight: bold}
-->
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
						<td align="center">Setp 3</td>
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
               
		
		<table width="90%" border="1" cellspacing="0" cellpadding="0" align="center">
		<tr height="60">
		  <td>
		    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
			
			<tr>
			   <td style="font-size:16px; padding:2px;"> ID NO : <strong><?=$employee->PBI_ID?></strong></td>
			   <td style="font-size:16px; padding:2px;">NAME : <strong><?=$employee->PBI_NAME?></strong> , </td>
			    <td style="font-size:16px; padding:2px;">DESIGNATION :  <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$employee->PBI_DESIGNATION);?></strong></td>
			</tr>
			
			<tr>
			   <td style="font-size:16px; padding:2px;">DEPARTMENT :  <strong><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$employee->PBI_DEPARTMENT);?></strong>,</td>
			   <td style="font-size:16px; padding:2px;"> PROJECT NAME :  <strong><?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$employee->JOB_LOCATION);?></strong>,   </td>
			    <td style="font-size:16px; padding:2px;">JOINING DATE :  <strong><?=$employee->PBI_DOJ?></strong></td>
			</tr>
			
			
			 <tr>
			   <td style="font-size:16px; padding:2px;">Name of Appraiser : <strong><?=$appraiser->PBI_NAME?></strong></td>
			  
			   <td style="font-size:16px; padding:2px;">Designation of Appraiser : <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$appraiser->PBI_DESIGNATION);?></strong></td>
			   <td></td>
			</tr>
			</table>
		  </td>
		   
	 </tr>
	 
	
			
	 
	
</table>

<br />


<table width="90%" border="1" cellspacing="0" cellpadding="0" align="center">
     
	
	  <tr>
		<td style="padding:5px; width:20%;"><strong>Rating Scale</strong></td>
		<td style="padding:5px; width:30%;"><strong>Description</strong></td>
		<td style="padding:5px; width:20%;"><strong>Rating Scale</strong></td>
		<td style="padding:5px; width:30%;"><strong>Description</strong></td>
		
	  </tr>
	  
	    <tr>
		<td style="padding:5px;">0-Point</td>
		<td style="padding:5px;" >Performance does not meet requirements of the job</td>
		<td style="padding:5px;">1-Point</td>
		<td style="padding:5px;">Performance is inconsistent. Meets requirements of the job</td>
	  </tr>
	  
	    <tr>
		<td style="padding:5px;">2-Point</td>
		<td style="padding:5px;">Performance is satisfactory. Meets minimum requirements of the Needs</td>
		<td style="padding:5px;">3-Point</td>
		<td style="padding:5px;">Performance is consistent. Clearly meets job requirements</td>
	  </tr>
	  
	  <tr>
		<td style="padding:5px;">4-Point</td>
		<td style="padding:5px;">Performance is consistent and exceeds expectations</td>
		<td style="padding:5px;">5-Point</td>
		<td style="padding:5px;">Performance is exceptional and far exceeds expectations. Demonstrates excellent standards</td>
	  </tr>
	 
	 
	 
		</table>
<br /><br />

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">
  <tr>
   <td><div align="center">Select Year : <select name="year" id="year" required="required" >
   <option label="Please Select" value=""></option>
   <option>2019</option>
   <option>2020</option>
   <option>2021</option>
   <option>2022</option>
   <option>2023</option>
   </select></div></td>
 </tr>
</table><br /><br />

<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">
     
	 <!--Part-1-->
	  <tr>
		<td style="padding:5px; width:5%" align="center" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><strong>PART I &nbsp;&nbsp;EMPLOYEE</strong></td>
		<td style="padding:5px; width:10%" align="center"><strong>Rating</strong></td>
	  </tr>
	 
	  <tr>
		<td style="padding:5px;" ><span style="writing-mode: tb-rl;">Teamwork</span></td>
		<td style="padding:5px;">1.&nbsp;&nbsp;Able and willing to work effectively with others in a team <br> দলের অন্যদের সঙ্গে কাজ করতে ইচ্ছুক এবং সক্ষম কি না</td>
		<td style="padding:5px;"><select name="part_1" id="part_1" onchange="avg()">
		  <option selected="selected" disabled="disabled">..Select One..</option>
		  <option>0</option>
		  <option>1</option>
		  <option>2</option>
	      <option>3</option>
		  <option>4</option>
		  <option>5</option>
		</select></td>
	   </tr>
	  
	   <tr>
		<td style="padding:5px;" ><span style="writing-mode: tb-rl;">Communication Skills</span></td>
		<td style="padding:5px;">2.&nbsp;&nbsp; Communicates effectively to share information and/or skills with colleagues<br>সহকর্মীদের সাথে তথ্য এবং দক্ষতা ভাগ করে নেওয়ার জন্য যোগাযোগ করে কি না </td>
		<td style="padding:5px;"><select name="part_2" id="part_2" onchange="avg()">
		 <option selected="selected" disabled="disabled">..Select One..</option>
		 <option>0</option>
		 <option>1</option>
		 <option>2</option>
	     <option>3</option>
		 <option>4</option>
		 <option>5</option>
		</select></td>
	  </tr>
	  
	  <tr>
		<td style="padding:5px;" >Comments</td>
		<td style="padding:5px;" colspan="2"><textarea name="part_1_comment" id="part_1_comment" cols="100" style="width:100%;"></textarea></td>
	  </tr>
	   <!--Part-1 End-->
	  
	   <!--Part-2-->
	  
	  <tr>
		<td style="padding:5px;" ><span style="writing-mode: tb-rl;">Job Knowledger / Technical Skills </span></td>
		<td style="padding:5px;">3.&nbsp;&nbsp;Possesses knowledge of work procedures and requirements of job<br>কাজের পদ্ধতি জানে এবং কাজের জন্য প্রয়োজনীয় জ্ঞান সম্পন্ন কি না </td>
		<td style="padding:5px;"><select name="part_3" id="part_3" onchange="avg()">
		  <option selected="selected" disabled="disabled">..Select One..</option>
		  <option>0</option>
		  <option>1</option>
		  <option>2</option>
	      <option>3</option>
		  <option>4</option>
		  <option>5</option>
		</select></td>
	   </tr>
	  
	   <tr>
		<td style="padding:5px;" >&nbsp;</td>
		<td style="padding:5px;">4.&nbsp;&nbsp; Shows technical competence/skill in area of specialization<br>বিশেষ ক্ষেত্রে প্রযুক্তিগত দক্ষতা বা পারদর্শিতা রয়েছে কি না  </td>
		<td style="padding:5px;"><select name="part_4" id="part_4" onchange="avg()">
		 <option selected="selected" disabled="disabled">..Select One..</option>
		 <option>0</option>
		 <option>1</option>
		 <option>2</option>
	     <option>3</option>
		 <option>4</option>
		 <option>5</option>
		</select></td>
	  </tr>
	  
	 
	  <tr>
		<td style="padding:5px;" ><span style="writing-mode: tb-rl;">Work Attitude </span></td>
		<td style="padding:5px;">5.&nbsp;&nbsp;Displays commitment to work<br>কাজের প্রতি নিবেদিত বা প্রতিজ্ঞাবদ্ধ কি না </td>
		<td style="padding:5px;"><select name="part_5" id="part_5" onchange="avg()">
		  <option selected="selected" disabled="disabled">..Select One..</option>
		  <option>0</option>
		  <option>1</option>
		  <option>2</option>
	      <option>3</option>
		  <option>4</option>
		  <option>5</option>
		</select></td>
	   </tr>
	   
	   <tr>
		<td style="padding:5px;" >&nbsp;</td>
		<td style="padding:5px;">6.&nbsp;&nbsp;Displays a willingness to learn<br>নতুন কিছু শিখতে ইচ্ছুক কি না </td>
		<td style="padding:5px;"><select name="part_6" id="part_6" onchange="avg()">
		  <option selected="selected" disabled="disabled">..Select One..</option>
		  <option>0</option>
		  <option>1</option>
		  <option>2</option>
	      <option>3</option>
		  <option>4</option>
		  <option>5</option>
		</select></td>
	   </tr>
	   
	   <tr>
		<td style="padding:5px;" >&nbsp;</td>
		<td style="padding:5px;">7.&nbsp;&nbsp;Has a sense fo urgency in acting on work matters<br>জরুরীভিত্তিতে কাজ করার প্রবণতা রয়েছে কি না  </td>
		<td style="padding:5px;"><select name="part_7" id="part_7" onchange="avg()">
		  <option selected="selected" disabled="disabled">..Select One..</option>
		  <option>0</option>
		  <option>1</option>
		  <option>2</option>
	      <option>3</option>
		  <option>4</option>
		  <option>5</option>
		</select></td>
	   </tr>
	   
	   <tr>
		<td style="padding:5px;" ><span style="writing-mode: tb-rl;">Quality of Work</span> </td>
		<td style="padding:5px;">8.&nbsp;&nbsp;In accurate, thorough and careful with work performed<br>কাজ নির্ভুলভাবে, সঠিকভাবে এবং সতর্কতার সঙ্গে স¤পন্ন করে কি না </td>
		<td style="padding:5px;"><select name="part_8" id="part_8" onchange="avg()">
		  <option selected="selected" disabled="disabled">..Select One..</option>
		  <option>0</option>
		  <option>1</option>
		  <option>2</option>
	      <option>3</option>
		  <option>4</option>
		  <option>5</option>
		</select></td>
	   </tr>
	   
	   <tr>
		<td style="padding:5px;" ><span style="writing-mode: tb-rl;">Quantity of Work </span></td>
		<td style="padding:5px;">9.&nbsp;&nbsp;I able to handle a reasonable volume of work<br>নির্দিষ্ট পরিমানের কাজের চাপ সামলাতে পারে কি না </td>
		<td style="padding:5px;"><select name="part_9" id="part_9" onchange="avg()">
		  <option selected="selected" disabled="disabled">..Select One..</option>
		  <option>0</option>
		  <option>1</option>
		  <option>2</option>
	      <option>3</option>
		  <option>4</option>
		  <option>5</option>
		</select></td>
	   </tr>
	   <tr>
		<td style="padding:5px;" ><span style="writing-mode: tb-rl;">Safety</span></td>
		<td style="padding:5px;">10.&nbsp;&nbsp;Ensures careful work habits that comply with safety requirements<br>সাবধানতার সহিত কাজ করে যা নিরাপত্তা প্রয়োজনীয়তা সন্তুষ্ট করে কি না </td>
		<td style="padding:5px;"><select name="part_10" id="part_10" onchange="avg()">
		  <option selected="selected" disabled="disabled">..Select One..</option>
		  <option>0</option>
		  <option>1</option>
		  <option>2</option>
	      <option>3</option>
		  <option>4</option>
		  <option>5</option>
		</select></td>
	   </tr>
	   
	    <tr>
		<td style="padding:5px;" >Comments</td>
		<td style="padding:5px;" colspan="2"><textarea name="part_2_comment" id="part_2_comment" cols="100" style="width:100%;"></textarea></td>
	  </tr>
	  
	   <tr>
		<td style="padding:5px;" >Total Score : </td>
		<td style="padding:5px;" colspan="2"><textarea name="total_score" id="total_score" cols="100" style="width:100%;"></textarea></td>
	  </tr>
	   <!--Part-2 End-->
	  </table>
	  
   
<br />

		<br />

<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
	  <td align="center"><input type="submit" name="submit" id="submit" value="Submit" style="background: skyblue;" /></td>
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