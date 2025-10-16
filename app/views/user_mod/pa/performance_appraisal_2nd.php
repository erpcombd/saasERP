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
	
			
			$update = 'update performance_appraisal set part_11="'.$_POST['part_11'].'",part_12="'.$_POST['part_12'].'",part_13="'.$_POST['part_13'].'",part_14="'.$_POST['part_14'].'",part_15="'.$_POST['part_15'].'",part_16="'.$_POST['part_16'].'",part_17="'.$_POST['part_17'].'",part_18="'.$_POST['part_18'].'",part_19="'.$_POST['part_19'].'",part_20="'.$_POST['part_20'].'",total_score="'.$_POST['total_score'].'" where PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"';
		
		db_query($update);
		
		echo '<script type="text/javascript">parent.parent.document.location.href = "performance_appraisal_next.php?id='.$_GET['id'].'&&year='.$_GET['year'].'";</script>';

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
$color2 = '#00CCFF';

?>



	<script>
	  
	  
	  function avg(){
	       
		   
		   var ratingk = parseFloat(document.getElementById('part_11').value);
		   if(ratingk>0){
		     var rating11 = ratingk;
		   }else{
		   var rating11 = 0;
		   }
		   var ratingl = parseFloat(document.getElementById('part_12').value);
		   if(ratingl>0){
		     var rating12 = ratingl;
		   }else{
		   var rating12 = 0;
		   }
		   var ratingm = parseFloat(document.getElementById('part_13').value);
		   if(ratingm>0){
		     var rating13 = ratingm;
		   }else{
		   var rating13 = 0;
		   }
		   var ratingn = parseFloat(document.getElementById('part_14').value);
		   if(ratingn>0){
		     var rating14 = ratingn;
		   }else{
		   var rating14 = 0;
		   }
		   var ratingo = parseFloat(document.getElementById('part_15').value);
		   if(ratingo>0){
		     var rating15 = ratingo;
		   }else{
		   var rating15 = 0;
		   }
		   var ratingp = parseFloat(document.getElementById('part_16').value);
		   if(ratingp>0){
		     var rating16 = ratingp;
		   }else{
		   var rating16 = 0;
		   }
		   var ratingq = parseFloat(document.getElementById('part_17').value);
		   if(ratingq>0){
		     var rating17 = ratingq;
		   }else{
		   var rating17 = 0;
		   }
		   var ratingr = parseFloat(document.getElementById('part_18').value);
		   if(ratingr>0){
		     var rating18 = ratingr;
		   }else{
		   var rating18 = 0;
		   }
		   var ratings = parseFloat(document.getElementById('part_19').value);
		   if(ratings>0){
		     var rating19 = ratings;
		   }else{
		   var rating19 = 0;
		   }
		   var ratingt = parseFloat(document.getElementById('part_20').value);
		   if(ratingt>0){
		     var rating20 = ratingt;
		   }else{
		   var rating20 = 0;
		   }
		   var pre = parseFloat(document.getElementById('pre_score').value);
		   if(pre>0){
		     var score = pre;
		   }else{
		   var score = 0;
		   }
		   
		   var rating_sum = rating11+rating12+rating13+rating14+rating15+rating16+rating17+rating18+rating19+rating20+score;
		   
		 
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
						<td align="center" style="background:<?=$color2?>;">Step 2</td>
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

<br /><br />


	  
   <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">
     
	 <!--Part-1-->
	  <tr>
		<td style="padding:5px; width:5%" align="center" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" /><strong>PART I &nbsp;&nbsp;EMPLOYEE</strong></td>
		<td style="padding:5px; width:10%" align="center"><strong>Rating</strong></td>
	  </tr>
	 
	  <tr>
		<td style="padding:5px;" ><span style="writing-mode: tb-rl;">Process Improvement </span></td>
		<td style="padding:5px;">11.&nbsp;&nbsp;Seeks to continually improve processes and work methods<br>সবসময় কাজের পদ্ধতি এবং প্রক্রিয়ার উন্নতি করতে চায় কি না</td>
		<td style="padding:5px;"><select name="part_11" id="part_11" onchange="avg()">
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
		<td style="padding:5px;" ><span style="writing-mode: tb-rl;">Problem Solving </span></td>
		<td style="padding:5px;">12.&nbsp;&nbsp; Helps resovle staff problems on work related matters<br>কাজ স¤পর্কিত বিষয়ে স্টাফদের সমস্যা সমাধান করতে সাহায্য করে কি না </td>
		<td style="padding:5px;"><select name="part_12" id="part_12" onchange="avg()">
		 <option selected="selected" disabled="disabled">..Select One..</option>
		 <option>0</option>
		 <option>1</option>
		 <option>2</option>
	     <option>3</option>
		 <option>4</option>
		 <option>5</option>
		</select></td>
	  </tr>
	  
	  
	   <!--Part-1 End-->
	  
	   <!--Part-2-->
	  
	  <tr>
		<td style="padding:5px;" >&nbsp;</td>
		<td style="padding:5px;">13.&nbsp;&nbsp;Handles problem situations effectively<br>যে কোন সমস্যা সামনে আসলে তা সঠিকভাবে পরিচালনা করে বা সামলাতে পারে কি না </td>
		<td style="padding:5px;"><select name="part_13" id="part_13" onchange="avg()">
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
		<td style="padding:5px;" ><span style="writing-mode: tb-rl;">Supervision / Motivation of Staff</span> </td>
		<td style="padding:5px;">14.&nbsp;&nbsp;Is a positive role model for other staff?<br>অন্য কর্মীদের জন্য একজন ভাল কর্মী কি না? </td>
		<td style="padding:5px;"><select name="part_14" id="part_14" onchange="avg()">
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
		<td style="padding:5px;">15.&nbsp;&nbsp;Effectively supervises work of subordinates<br>সঠিকভাবে অধীনস্তদের কাজ তত্ত¡াবধান করে কি না </td>
		<td style="padding:5px;"><select name="part_15" id="part_15" onchange="avg()">
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
		<td style="padding:5px;" ><span style="writing-mode: tb-rl;">Dependability / Responsibility</span></td>
		<td style="padding:5px;">16.&nbsp;&nbsp;Is able to work with limited supervision<br>অল্পতেই কাজ বুঝিয়ে দিলে কাজ করতে সক্ষম কিনা  </td>
		<td style="padding:5px;"><select name="part_16" id="part_16" onchange="avg()">
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
		<td style="padding:5px;">17.&nbsp;&nbsp;Is trustworthy, responsible and reliable<br>বিশ্বাসযোগ্য, দায়িত্ববান এবং নির্ভরযোগ্য কি না </td>
		<td style="padding:5px;"><select name="part_17" id="part_17" onchange="avg()">
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
		<td style="padding:5px;">18.&nbsp;&nbsp;Is adaptable and willing to accept new responsibilites<br>যে কোন নতুন পরিস্থিতিতে বা অবস্থায় মানিয়ে চলতে পারে এবং নতুন দায়িত্ব গ্রহণ করতে ইচ্ছুক কি না</td>
		<td style="padding:5px;"><select name="part_18" id="part_18" onchange="avg()">
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
		<td style="padding:5px;" ><span style="writing-mode: tb-rl;">Attendence/Punctuality</span></td>
		<td style="padding:5px;">19.&nbsp;&nbsp;Has good attendance<br>পর্যাপ্ত উপস্থিতি বা হাজিরা রয়েছে কি না </td>
		<td style="padding:5px;"><select name="part_19" id="part_19" onchange="avg()">
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
		<td style="padding:5px;">20.&nbsp;&nbsp;Is punctual<br>এই ব্যক্তি কি সময়মত কাজ করে? </td>
		<td style="padding:5px;"><select name="part_20" id="part_20" onchange="avg()">
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
		<td style="padding:5px;" colspan="2"><textarea name="part_3_comment" id="part_3_comment" cols="100" style="width:100%;"></textarea></td>
	  </tr>
	   <tr>
		<td style="padding:5px;" >Total Score : </td>
		<td style="padding:5px;" colspan="2"><textarea name="total_score" id="total_score" cols="100" style="width:400px;"></textarea></td>
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