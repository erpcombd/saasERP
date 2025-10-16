<?php
session_start();
ob_start();
require "../../config/inc.all.php";
require "../../template/main_layout.php";



if($_GET['PBI_ID']>0){
  
  $_SESSION['employee_selected'] = $_GET['PBI_ID'];
}
// ::::: Edit This Section ::::: 
$title='Probation Progress';		// Page Name and Page Title
$page="confirmation.php";		// PHP File Name
$input_page="confirmation_input.php";
$root='hrm';

$table='confirmation_detail';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='suitable';	


// ::::: End Edit Section :::::

$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_GET['id'].'"');

$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$_SESSION['employee_selected'].'"');

$crud      =new crud($table);

$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;

			
	if(isset($_POST['submit']))
	{		
	
    $update = 'update performance_appraisal set recommendation="'.$_POST['final'].'",status="Done" where PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"';
	mysql_query($update);
	
	echo '<script type="text/javascript">parent.parent.document.location.href = "pa_view.php";</script>';

	}
	
	
		
/*$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
else
$$unique = $_SESSION['employee_selected']=$_POST['PBI_ID'];*/

	//for Modify..................................
	

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
$color4 = '#00CCFF';


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
						<td align="center" style="background:<?=$color4?>;">Final</td>
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


<table width="90%" border="1" cellspacing="0" cellpadding="0" align="center">
     
	
	  <tr>
		<td style="padding:5px; width:20%;"><strong>Rating Scale</strong></td>
		<td style="padding:5px; width:30%;"><strong>Description</strong></td>
		<td style="padding:5px; width:20%;"><strong>Rating Scale</strong></td>
		<td style="padding:5px; width:30%;"><strong>Description</strong></td>
		
	  </tr>
	  
	    <tr>
		<td style="padding:5px;">90%-100%</td>
		<td style="padding:5px;" ><strong>Outstanding</strong><br>Performance is exceptional and far exceeds expectations. Consistently demonstrates excellent standards in all job requirements.</td>
		<td style="padding:5px;">76%-89%</td>
		<td style="padding:5px;" ><strong>Very Good</strong><br>Performance is consistent and exceeds expectations in all situations</td>
	  </tr>
	  
	    <tr>
		<td style="padding:5px;">60%-75%</td>
		<td style="padding:5px;" ><strong>Good</strong><br>Performance is consistent. Clearly meets essential requirements of job.</td>
		<td style="padding:5px;">45%-59%</td>
		<td style="padding:5px;" ><strong>Fair</strong><br>Performance is satisfactory. Meets requirements of the job.</td>
	  </tr>
	  
	   <tr>
		<td style="padding:5px;">31%-44%</td>
		<td style="padding:5px;" ><strong>Needs Improvement</strong><br>Performance is inconsistent. Meets requirements of the job occasionally. Supervision and trainig are required for most problem areas.</td>
		<td style="padding:5px;">0%-30%</td>
		<td style="padding:5px;" ><strong>Unsatisfactory</strong><br>Performance does not meet the minimum  requirements of the job.</td>
	  </tr>
	  </table>
	  
	  <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">
	  <tr>
	    <td>Recommendations</td>
	  </tr>
	   <tr>
	    <td><hr /></td>
	  </tr>
	   <tr>
	    <td><strong><input type="radio" name="final" id="final" value="Confirmation" />&nbsp;Confirmation</strong></td>
	  </tr>
	   <tr>
	    <td><strong><input type="radio" name="final" id="final" value="Extension of Probation Period" />&nbsp;Extension of Probation Period</strong></td>
	  </tr>
	   <tr>
	    <td><strong><input type="radio" name="final" id="final" value="Salary Increment" />&nbsp;Salary Increment</strong></td>
	  </tr>
	   <tr>
	    <td><strong><input type="radio" name="final" id="final" value="No Salary Increment" />&nbsp;No Salary Increment</strong></td>
	  </tr>
	   <tr>
	    <td><strong><input type="radio" name="final" id="final" value="Promotion" />&nbsp;Promotion</strong></td>
	  </tr>
	   <tr>
	    <td><strong><input type="radio" name="final" id="final" value="No Promotion" />&nbsp;No Promotion</strong></td>
	  </tr>
	   <tr>
	    <td><strong><input type="radio" name="final" id="final" value="Discontinuation/Termination" />&nbsp;Discontinuation/Termination</strong></td>
	  </tr>
	  
	  </table><br />
	  
	   <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">
	   
	   <tr>
	    <td><input type="submit" name="submit" id="submit" value="Completed" style="background: aqua;" /></td>
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