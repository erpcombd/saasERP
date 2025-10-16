<?php
session_start();
ob_start();
require "../../config/inc.all.php";
require "../../template/main_layout.php";



if($_GET['PBI_ID']>0){
  
  $_SESSION['employee_selected'] = $_GET['PBI_ID'];
}
/// ::::: Edit This Section ::::: 
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
		
/*$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
else
$$unique = $_SESSION['employee_selected']=$_POST['PBI_ID'];*/

	//for Modify..................................
	if(isset($_POST['submit']))
	{
		
		$update = 'update performance_appraisal set question_1="'.$_POST['one'].'",question_2="'.$_POST['two'].'",question_3="'.$_POST['three'].'",question_4="'.$_POST['four'].'",question_5="'.$_POST['five'].'",question_6="'.$_POST['six'].'",question_7="'.$_POST['seven'].'",question_8="'.$_POST['eight'].'",question_9="'.$_POST['nine'].'",question_10="'.$_POST['ten'].'",question_11="'.$_POST['eleven'].'",question_12="'.$_POST['twelve'].'",question_13="'.$_POST['thirteen'].'",question_14="'.$_POST['fourteen'].'",question_comment="'.$_POST['question_comment'].'" where PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"';
		
		mysql_query($update);
		
		echo '<script type="text/javascript">parent.parent.document.location.href = "performance_appraisal_last.php?id='.$_GET['id'].'&&year='.$_GET['year'].'";</script>';
		   
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
$color2 = '#00CCFF';
$color3 = '#00CCFF';

?>


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
                 
		     <? include('../../common/new_title.php');?>
		 
                    
                  </div>
				  
				    <div class="x_panel">
				  <table width="100%" style="height:30px;" border="0" cellspacing="0" cellpadding="0" align="center">
				     <tr>
					    <td align="center" style="background:<?=$color?>;">Step 1</td>
						<td align="center" style="background:<?=$color2?>;">Step 2</td>
						<td align="center" style="background:<?=$color3?>;">Setp 3</td>
						<td align="center">Final</td>
					 </tr>
				  </table>
                  </div>
				  
				  	 <div class="openerp openerp_webclient_container">
                    
			
				  
				  
                  <div class="x_content">
	
	
	
	
    
<form action="" method="post"  style="text-align:center" enctype="multipart/form-data">
  <div class="oe_view_manager oe_view_manager_current">
    <? include('../../common/title_bar_data.php');?><br />
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

<table  width="90%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:0 auto; font-size:16px;">
<tr>
  <td><div align="center"><span style="text-align:center; font-size:30px; color:#00CCCC;">Total Score : <?=find_a_field('performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?></span></div></td>
</tr>

</table><br />



		
		<table  width="90%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:0 auto; font-size:16px;">
		
		<div align="center"><tr>
		  <td><strong>অনুগ্রহ করে বৃত্ত পূরণ করুন </strong> </td>
		  
		</tr>
		<tr>
		  <td><hr /></td>
		</tr>
		<tr>
		  <td><strong> ১।&nbsp;AKSID আপনার প্রতিষ্ঠান হলে আপনি কি তাকে নিয়োগ করবেন ?</strong> </td>
		</tr>
		<tr>
		  <td><input type="radio" name="one" id="one" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		  <input type="radio" name="one" id="one" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="one" id="one" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		 <span></span>
		</tr>
		
		<tr>
		  <td><strong> ২।&nbsp;আপনি কি তার বেতন কমাতে সুপারিশ করবেন ?</strong></td>
		</tr>
		<tr>
		  <td><input type="radio" name="two" id="two" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		   <input type="radio" name="two" id="two" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="two" id="two" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		 
		</tr>
		
		<tr>
		  <td><strong> ৩।&nbsp;আপনি কি মনে করেন এই ব্যাক্তি সৎ ? </strong></td>
		</tr>
		<tr>
		  <td><input type="radio" name="three" id="three" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		  <input type="radio" name="three" id="three" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="three" id="three" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		 
		</tr>
		
		<tr>
		  <td><strong> ৪।&nbsp;আপনি কি তাকে কাজে উৎসাহিত করবেন ? </strong></td>
		</tr>
		<tr>
		  <td><input type="radio" name="four" id="four" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		  <input type="radio" name="four" id="four" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="four" id="four" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		 
		</tr>
		
		<tr>
		  <td><strong> ৫।&nbsp;আপনি কি মনে করেন এই ব্যক্তিটি পেশাদার ?</strong></td>
		</tr>
		<tr>
		  <td><input type="radio" name="five" id="five" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		  <input type="radio" name="five" id="five" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="five" id="five" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		 
		</tr>
		
		<tr>
		  <td><strong> ৬।&nbsp;আপনি কি মনে করেন এই ব্যক্তি কঠিনতম পরিস্তিতি সামলাতে পারে ? </strong></td>
		</tr>
		<tr>
		  <td><input type="radio" name="six" id="six" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		 <input type="radio" name="six" id="six" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="six" id="six" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		 
		</tr>
		
		<tr>
		  <td><strong> ৭।&nbsp;আপনি কি মনে করেন তার সহকর্মীরা তার সঙ্গে কাজ করতে স্বাচ্ছন্দ্য বোধ করেন ?</strong></td>
		</tr>
		<tr>
		  <td><input type="radio" name="seven" id="seven" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		 <input type="radio" name="seven" id="seven" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="seven" id="seven" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		 
		</tr>
		
		<tr>
		  <td><strong> ৮।&nbsp;আপনি কি মনে করেন Client তাকে পছন্দ করেন  ? </strong></td>
		</tr>
		<tr>
		  <td><input type="radio" name="eight" id="eight" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		  <input type="radio" name="eight" id="eight" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="eight" id="eight" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		 
		</tr>
		
		<tr>
		  <td><strong> ৯।&nbsp;আপনি কি মনে করেন এই ব্যক্তি আমাদের প্রতিষ্ঠান সম্পর্কে খারাপ সমালোচনা করেন   ? </strong></td>
		</tr>
		<tr>
		  <td><input type="radio" name="nine" id="nine" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		  <input type="radio" name="nine" id="nine" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="nine" id="nine" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		 
		</tr>
		
		<tr>
		  <td><strong> ১০।&nbsp;আপনি কি মনে করেন এই ব্যক্তি এই প্রতিষ্ঠানে থাকুক ? </strong> </td>
		</tr>
		<tr>
		  <td><input type="radio" name="ten" id="ten" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		  <input type="radio" name="ten" id="ten" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="ten" id="ten" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		 
		</tr>
		
		<tr>
		  <td><strong> ১১।&nbsp;আপনি কি তাকে বিশ্বাস করেন ? </strong> </td>
		</tr>
		<tr>
		  <td><input type="radio" name="eleven" id="eleven" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		  <input type="radio" name="eleven" id="eleven" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="eleven" id="eleven" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		</tr>
		
		<tr>
		  <td><strong> ১২।&nbsp;আমাদের প্রতিষ্ঠান সম্পর্কে খারাপ কিছু করতে বা বলতে দেখেছেন কিন ? </strong> </td>
		</tr>
		<tr>
		  <td><input type="radio" name="twelve" id="twelve" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		  <input type="radio" name="twelve" id="twelve" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="twelve" id="twelve" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		 
		</tr>
		
		<tr>
		  <td> <strong>১৩।&nbsp;আপনি কি মনে করেন এই ব্যক্তি আলস ?</strong> </td>
		</tr>
		<tr>
		  <td height="23"><input type="radio" name="thirteen" id="thirteen" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		  <input type="radio" name="thirteen" id="thirteen" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="thirteen" id="thirteen" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		 
		</tr>
		
		<tr>
		  <td> <strong>১৪।&nbsp;AKSID যদি আপনার প্রতিষ্ঠান হতো আপনি কি তাহার বেতন বৃদ্ধি করতেন ?</strong> </td>
		</tr>
		<tr>
		  <td><input type="radio" name="fourteen" id="fourteen" value="yes" style="margin-left:-80px;"/><span style="margin-left:-85px;"> হ্যাঁ </span> 
		  <input type="radio" name="fourteen" id="fourteen" value="no" /> <span style="margin-left:-85px;">না </span>
		  <input type="radio" name="fourteen" id="fourteen" value="no_comment" /> <span style="margin-left:-85px;">মন্তব্য নাই </span></td>
		 
		</tr></div></table><br /><br />
		
		<table  width="90%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:0 auto; font-size:16px;">
		
		
		
		<tr>
		  <td><textarea name="question_comment" id="question_comment" cols="100" style="width:100%;" placeholder="Comment"></textarea></td>
		 
		</tr></table><br /><br />
		<table  width="90%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:0 auto; font-size:16px;">
		
		
		<tr>
		  <td><input type="submit" name="submit" id="submit" value="Submit" style="background: aqua;"  /></td>
		</tr>
		
		
		</table>
<br /><br />


		<br />
		
		
		
<br /><br />

	 
	 
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