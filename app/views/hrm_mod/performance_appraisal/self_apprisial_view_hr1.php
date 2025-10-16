<?php

session_start();
//
//====================== EOF ===================

//var_dump($_SESSION);


require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";
 

$all_data_master=find_all_field('self_assessment_appraisal','*','id='.$_GET['id']);
$all_data=find_all_field('personnel_basic_info','*','EMP_ID='.$all_data_master->employee_id); 
$all_edu=find_all_field('hrm_education_detail','*','PBI_ID="'.$all_data->PBI_ID.'" order by EDUCATION_D_ID desc ');
 
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>.: Delivery Chalan Bill Report :.</title>
	<script>
function print_cus(){
document.getElementById('pr').style.display='none';

var cur_time= new Date().toLocaleString();
document.getElementById('cur_date_time').style.display='block';
document.getElementById('cur_date_time').innerHTML="Reporting Time: "+cur_time;
window.print();
}
</script>
    <style>
	 .mb-3{
margin-bottom:4px!important;
}
.input-group-text{
font-size:12px;
}
      * {
    margin: 0;
    padding: 0;
	font-size:13px;
  }
  p {
    margin: 0;
    padding: 0;
  }
  h1,
  h2,
  h3,
  h4,
  h5,
  h6
   {
    margin: 0 !important;
    padding: 0 !important;
  }
  

label{

}

.first_part{
	background-color: #fffecf;
}
.second_part{
	background-color: #edfaff;
}

.first_part, .second_part{
	padding: 15px 0px;
}

    </style>
  </head>
 
  <body>

    <section >
      <div class="container"> <br><br>
	  	<form  action="" method="post" >
			

	  
	  
	  
	  <div class="row m-0 p-0">
	
		<div class="col-12 text-center pt-3">
			<img src="../leave/hrd_logo.jpeg" width="100px;">
			<h3> <br>SELF ASSESSMENT FORM</h3>
			 
	
		</div>
		
	</div>
	  <br>
	  

            
			
            <br>
			<div class="container first_part" style="border:2px solid black;" > 
			<a href="performance_apprisial.php"><input type="button" class="btn btn-primary" value="Go Back" style="margin-left:10px; margin-bottom:5px;"></a>
			<div class="row m-0 p-0">
      <div class="col-6">
	  	<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend" style="width:31%">
				<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Appraisal For</span>
			  </div>
			  <select name="appraisal_for" id="appraisal_for" class="form-control">
			  	<option value="<?php echo $all_data_master->appraisal_for;?>"><?php echo $all_data_master->appraisal_for;?></option>
			  	<option value="Confirmation">Confirmation</option>
				<option value="Half Yearly">Half Yearly</option>
				<option value="Yearly">Yearly</option>
			  </select>
			   
			  <input type="hidden" style="font-size:14px;font-weight:bold;" class="form-control" name="present_date" id="present_date" value="<?php echo date('Y-m-d');?>">
			</div>
	  
	  </div>
	  </div>
	  
	  
			
			<div class="row m-0 p-0">
      <div class="col-6">
		    
			 
			
				
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend" style="width:31%">
				<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Appraisal Period From</span>
			  </div>
			   <input type="date" style="font-size:14px; font-weight:bold;" class="form-control" name="from_date" value="<?php echo $all_data_master->from_date;?>" id="from_date">
			  
			</div>
			
		  </div>
		  <div class="col-6">
		    
		 
			
				<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold;font-size:14px;">To</span>
			  </div>
			  <input type="date" style="font-size:14px; font-weight:bold;" class="form-control" value="<?php echo $all_data_master->to_date;?>" name="to_date" id="to_date">
			</div>
			
			
			
			
			
		  </div>
              
            </div>  
			
			 
	 
			<br><br>
				<div class="row m-0 p-0">
					  <div class="col-6">
							
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:31%">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Name of Appraisee</span>
							  </div>
							  <input type="text" style="font-size:14px;font-weight:bold;" class="form-control" name="name_of_appraisee" id="name_of_appraisee" value="<?php echo $all_data->PBI_NAME;?>">
							</div>
							
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:31%">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Employee ID</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="employee_id" id="employee_id" value="<?php echo $all_data->EMP_ID;?>">
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:31%">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Designation</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="designation" id="designation" value="<?php echo $all_data->PBI_DESIGNATION;?>">
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:31%">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Department</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="department" id="department" value="<?php echo $all_data->PBI_DEPARTMENT;?>">
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:31%">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Date of Joining</span>
							  </div>
							   <input type="date" style="font-size:14px; font-weight:bold;" class="form-control" name="doj" id="doj" value="<?php echo $all_data->PBI_DOJ;?>">
							  
							</div>
							
							
							
						  </div>
						  <div class="col-6">
							
						<!--<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold;font-size:14px;">To</span>
							  </div>
							  
							  <input type="date" style="font-size:14px; font-weight:bold;" class="form-control" name="tdate" id="tdate">
							</div>-->
							
								<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:39%;">
								<span class="input-group-text"  style="font-weight:bold;font-size:14px;">Last Academic Qualification</span>
							  </div>
							  <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="qualification" id="qualification" value="<?php echo $all_edu->EDUCATION_NOE;?>">
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:39%;">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Concern Academic Subject</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="aca_sub" id="aca_sub" value="<?php echo $all_edu->EDUCATION_SUBJECT;?>">
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:39%;">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Total Year(s) of Experience</span>
							  </div>
							  
							  
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="experience" id="experience" value="<?php echo $all_data_master->experience;?>">
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Experience in TPC Group Y(s)</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="experience_tpc" id="experience_tpc" value="<?php echo $all_data_master->experience_tpc;?>">
							  
							</div>
							
							
							
							
						  </div>
              
            </div>
			
	   </div>
			
			
			
			
			<br><br>
			
	 <div class="container second_part" style="border:2px solid black;" > 
				<div class="row m-0 p-0" style="padding:10px;">
					<h4 style="padding:4px!important;font-weight:bold;">Necessary Information (During appraisal period):</h4>
					
					  <div class="col-6 col-sm-6 col-md-6 col-lg-6">
							
							
							
							
							<div class="row m-0 p-0">
					  	<div class="col-6 col-sm-6 col-md-6 col-lg-6">
						<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Late join in office</span>
							  </div>
							  
							  
							  
				 <input type="text" style="font-size:14px;font-weight:bold;" class="form-control" name="late_join_date" id="late_join_date" value="<?php echo $all_data_master->late_join_date;?>">
							</div>
						
						</div>
					  <div class="col-6 col-sm-6 col-md-6 col-lg-6">
					  
					  		<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Leave Availed</span>
							  </div>
							  
							  
							  
							  <input type="text" style="font-size:14px;font-weight:bold;" class="form-control" name="tot_availed" id="tot_availed" value="<?php echo $all_data_master->tot_availed;?>">
							</div>
					  </div>
					  </div>
					  
					  
					  
							 
							
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Absent/Leave without pay</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="absent_pay" id="absent_pay"  value="<?php echo $all_data_master->absent_pay;?>" >
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Warning/Show cause/Penalty notice issued</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" value="<?php echo $all_data_master->warning;?>" class="form-control" name="warning" id="warning">
							  
							</div>
							
							
							
							
							
						  </div>
						  <div class="col-6">
							
						<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:33%;">
								<span class="input-group-text"  style="font-weight:bold;font-size:14px;">Present Salary</span>
							  </div>
							  
							  <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="present_salary" id="present_salary" value="<?php echo $all_data_master->present_salary;?>">
							</div>
							
								<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold;font-size:14px;">Last Increment Amount</span>
							  </div>
							  <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="last_inc_amt" id="last_inc_amt" value="<?php echo $all_data_master->last_inc_amt;?>">
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:33%;">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Last Increment Date</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="last_inc_date" id="last_inc_date" value="<?php echo date('d-m-Y',strtotime($all_data_master->last_inc_date));?>">
							  
							</div>
							
							
							
						  </div>
						
				
            </div>
			</div>

			<br>	<br>	<br>	 
				<table style="width:25%;" >	  
						   
					<tr style="border:0px solid;">
						<td style="text-align:center;" ><?php 
						echo find_a_field('user_activity_management','fname','user_id='.$all_data_master->entry_by);
						?></td>
					</tr>
						<tr style="border-top:1px solid black;">
						<td style="text-align:center;font-weight:bold;">Record Provider(HR Dept)</td>
					</tr>		  
              </table>
		<br>	<br>	 <br>	<br>	 
</form>	 
</div>
</body>
</html>
			

    