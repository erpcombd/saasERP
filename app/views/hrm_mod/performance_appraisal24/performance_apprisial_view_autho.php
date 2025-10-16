<?php

session_start();
ob_start();
//====================== EOF ===================

//var_dump($_SESSION);

require_once "../../../assets/support/inc.all.php";
 

$all_data_master=find_all_field('performance_appraisal','*','id='.$_GET['id']);
$all_data=find_all_field('personnel_basic_info','*','EMP_ID='.$all_data_master->employee_id); 
$all_edu=find_all_field('hrm_education_detail','*','PBI_ID="'.$all_data->PBI_ID.'" order by EDUCATION_D_ID desc ');
 
  $all_data_details_two=find_all_field('performance_appraisal_details_two','*','pa_id='.$_GET['id']);
  if(isset($_POST['submit'])){
  
    $all_sql='select * from performance_appraisal_details where pa_id="'.$_GET['id'].'"';
			$all_query=mysql_query($all_sql);
			while($row=mysql_fetch_object($all_query)){
			$employee_id=$_POST['emp_id'];
			$pa_id=$_GET['id'];
			$criteria=$_POST['criteria_'.$row->id];
			$outstanding=$_POST['outstanding_'.$row->id];
				$excellent=$_POST['excellent_'.$row->id];
					$good=$_POST['good_'.$row->id];
						$average=$_POST['average_'.$row->id];
							$below_average=$_POST['below_average_'.$row->id];
								$unsatisfactory=$_POST['unsatisfactory_'.$row->id];
			
	 
			
			  $up_sql='update performance_appraisal_details set  outstanding="'.$outstanding.'",excellent="'.$excellent.'",good="'.$good.'",average="'.$average.'",unsatisfactory="'.$unsatisfactory.'" where pa_id="'.$_GET['id'].'" and id="'.$row->id.'"';
			mysql_query($up_sql);
			}
 
  
  $up_sql2='update performance_appraisal_details_two set group_involvement="'.$_POST['group_involvement'].'",increment="'.$_POST['increment'].'",promotion="'.$_POST['promotion'].'",confirmation="'.$_POST['confirmation'].'",extension_of_confirmation="'.$_POST['extension_of_confirmation'].'",termination="'.$_POST['termination'].'",others="'.$_POST['others'].'",other_recommendation="'.$_POST['other_recommendation'].'",increment_amount="'.$_POST['increment_amount'].'",promotion_to="'.$_POST['promotion_to'].'",authorize_comments="'.$_POST['authorize_comments'].'",autho_increment_amount="'.$_POST['autho_increment_amount'].'",authorize_by="'.$_SESSION['user']['id'].'" where pa_id='.$_GET['id'];
  mysql_query($up_sql2);
  $up_sql3='update performance_appraisal set status="APPROVED" where id="'.$_GET['id'].'"';
			mysql_query($up_sql3);
			header("Location: performance_apprisial_view_autho_view.php?id=".$_GET['id']);
  }

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
	table.table-bordered > thead > tr > th{
  border:1px solid black;
}
	table.table-bordered > tbody> tr > td{
  border:1px solid black;
}
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
 
<body style="width:90%;margin:0 auto;">

    <section >
      <div  >  
	  	<form  action="" method="post" >
			

	  
	  
	  
	  <div class="row">
	
		<div class="col-12 text-center pt-3">
			<img src="../leave/hrd_logo.jpeg" width="100px;">
			<h3> <br>PERFORMANCE APPRAISAL FORM</h3>
			 
	
		</div>
		
	</div>
	  <br>
	  

            
			
            <br>
			<div   style="border:2px solid black;" class="first_part">
			<div class="row">
      <div class="col-6">
	  	<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
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
	  
	  <div class="col-6">
	  
	 <?php
	 if($all_data_details_two->group_involvement=="No Involvement"){
	 $group_point=5;
	 }
	 else if($all_data_details_two->group_involvement=="Active"){
	  $group_point=-10;
	 }
	 else{
	 $group_point=-5;
	 }
	 $tot_point=find_a_field('performance_appraisal_details','sum(outstanding+excellent+good+average+below_average+unsatisfactory)','pa_id='.$_GET['id'])+$group_point;
	  ?>
	  <span style="font-size:20px; font-weight:bold;">Points Gain <span style="color:red;font-size:20px;font-weight:bold;"><?php echo $tot_point; ?></span> Out of 100</span>
	   
	  
	  </div>
	  </div>
	  
	  
			
			<div class="row">
      <div class="col-6">
		    
			 
			
				
			
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
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
			
			 
	 </form>
	 <form action="" method="post">
			<br><br>
				<div class="row">
					  <div class="col-6">
							
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Name of Appraisee</span>
							  </div>
							  <input type="text" style="font-size:14px;font-weight:bold;" class="form-control" name="name_of_appraisee" id="name_of_appraisee" value="<?php echo $all_data->PBI_NAME;?>">
							</div>
							
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Employee ID</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="employee_id" id="employee_id" value="<?php echo $all_data->EMP_ID;?>">
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Designation</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="designation" id="designation" value="<?php echo $all_data->PBI_DESIGNATION;?>">
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Department</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="department" id="department" value="<?php echo $all_data->PBI_DEPARTMENT;?>">
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
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
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold;font-size:14px;">Last Academic Qualification</span>
							  </div>
							  <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="qualification" id="qualification" value="<?php echo $all_edu->EDUCATION_NOE;?>">
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Concern Academic Subject</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="aca_sub" id="aca_sub" value="<?php echo $all_edu->EDUCATION_SUBJECT;?>">
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Total Year(s) of Experience</span>
							  </div>
							  
							  <?
							  
							   //Others company Experience
								
								$sql=" select * from hrm_experience_detail where PBI_ID='".$all_edu->PBI_ID."'";
								$query=mysql_query($sql);
								while($row=mysql_fetch_object($query))
									  {
								
											// Start date 
											$date1 = $row->EXPERIENCE_FROM; 
											$start=explode(" ",$date1);
											$start1=$start[0];
											  
											// End date 
											$date2 = $row->EXPERIENCE_TO;
											$end=explode(" ",$date2);
											$end1=$end[0];
											  
    
												// Calculating the difference in timestamps 
												$diff = strtotime($start1) - strtotime($end1); 
											  
												// 1 day = 24 hours 
												// 24 * 60 * 60 = 86400 seconds 
												$tot_day= abs(round($diff / 86400)); 
											
											  
									$other_exp+=$tot_day;
										
										 
									
								}
							  
							  
							  			//Tpc Experience
										$today=date('Y-d-m');							  
							  			 $tot_diff = strtotime($all_data->PBI_DOJ) - strtotime($today);
										 $tpc_exp=abs(round($tot_diff / 86400)); 
										 
										 
										 //Total Experience
										 $total_day=$other_exp+$tpc_exp;
							
							  	 	$years = ($total_day / 365) ;
									$years = floor($years); 
									$month = ($total_day % 365) / 30.5; 
									$month = floor($month); 
									$days = ($total_day % 365) % 30.5; // the rest of days
									
									// echo $years.' years, '.$month.' months, '.$days.' days';
									
								
							
							  
							  ?>
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
			
			
			
			<br> 
			<div   style="border:2px solid black;" class="second_part">
	 
				<div class="row" style="padding:10px;">
					<h4 style="padding:4px!important;font-weight:bold;padding-bottom:20px !important;">Necessary Information (During appraisal period):</h4> 
					  <div class="col-6">
					  
					  
					  <div class="row">
					  	<div class="col-6">
						<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Late join in office</span>
							  </div>
							  
							  
							  
				 <input type="text" style="font-size:14px;font-weight:bold;" class="form-control" name="late_join_date" id="late_join_date" value="<?php echo $all_data_master->late_join_date;?>">
							</div>
						
						</div>
					  <div class="col-6">
					  
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
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="warning" id="warning" value="<?php echo $all_data_master->warning;?>">
							  
							</div>
							
							
							
							
							
				  </div>
						  <div class="col-6">
							
						<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
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
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Last Increment Date</span>
							  </div>
							<input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="last_inc_date" id="last_inc_date" value="<?php echo date('d-m-Y',strtotime($all_data_master->last_inc_date));?>">
							  
							</div>
							
							
							
						  </div>
						
				
            </div>
			 </div>
			<br>  
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
		<br> 	 
		
		
		<table class="table table-bordered table-sm" style="width:100%;">
			<thead>
				<tr style="text-align:center;">
					<th rowspan="2">SL</th>
					<th rowspan="2">Criteria</th>
					<th colspan="6" >Rating</th>
				</tr>
				<tr style="text-align:center;">
				  <th>Outstanding<br>(5)</th>
			      <th>Excellent<br>(4)</th>
			      <th>Good<br>(3)</th>
			      <th>Average<br>(2)</th>
			      <th>Bellow Average<br>(1) </th>
			      <th>Unsatisfactory<br>(0)</th>
			  </tr>
			</thead>
			<tbody>
			<?php 
			$all_sql='select * from performance_appraisal_details where pa_id="'.$_GET['id'].'"';
			$all_query=mysql_query($all_sql);
			while($row=mysql_fetch_object($all_query)){
			//	echo 'select count(id) from performance_appraisal_details where pa_id="'.$_GET['id'].'" and criteria="'.$row->id.'" and employee_id="'.$all_data_master->employee_id.'" and outstanding=5';
			?>
				<tr>
					<td><?php echo ++$i;?></td>
					<td><?php echo find_a_field('pa_criteria','criteria_name','id='.$row->criteria);?>
					<input type="hidden" name="criteria_<?php echo $row->id;?>" id="criteria_<?php echo $row->id;?>" value="<?php echo $row->id;?>">
					<input type="hidden" name="emp_id" id="emp_id" value="<?php echo $all_data_master->employee_id;?>">
					</td>
					<td><input type="checkbox" <?php 
					$check_outstanding=find_a_field('performance_appraisal_details','count(id)','pa_id="'.$_GET['id'].'" and id="'.$row->id.'" and employee_id="'.$all_data_master->employee_id.'" and outstanding=5');
				
					if($check_outstanding>0){
					?>
					checked="checked"
					<?php } ?>
					 id="outstanding_<?php echo $row->id;?>" name="outstanding_<?php echo $row->id;?>" value="5" style="height: 29px;width: 39px;"></td>
				    <td><input type="checkbox"
					<?php 
					$check_excellent=find_a_field('performance_appraisal_details','count(id)','pa_id="'.$_GET['id'].'" and id="'.$row->id.'" and employee_id="'.$all_data_master->employee_id.'" and excellent=4');
				
					if($check_excellent>0){
					?>
					checked="checked"
					<?php } ?>
					 id="excellent_<?php echo $row->id;?>" name="excellent_<?php echo $row->id;?>" value="4" style="height: 29px;width: 39px;"></td>
				    <td><input type="checkbox"
					<?php 
					$check_good=find_a_field('performance_appraisal_details','count(id)','pa_id="'.$_GET['id'].'" and id="'.$row->id.'" and employee_id="'.$all_data_master->employee_id.'" and good=3');
				
					if($check_good>0){
					?>
					checked="checked"
					<?php } ?>
					 id="good_<?php echo $row->id;?>" name="good_<?php echo $row->id;?>" value="3" style="height: 29px;width: 39px;"></td>
				    <td><input type="checkbox" 
					<?php 
					$check_average=find_a_field('performance_appraisal_details','count(id)','pa_id="'.$_GET['id'].'" and id="'.$row->id.'" and employee_id="'.$all_data_master->employee_id.'" and average=2');
				
					if($check_average>0){
					?>
					checked="checked"
					<?php } ?>
					id="average_<?php echo $row->id;?>" name="average_<?php echo $row->id;?>" value="2" style="height: 29px;width: 39px;"></td>
				    <td><input type="checkbox"
						<?php 
					$check_below_average=find_a_field('performance_appraisal_details','count(id)','pa_id="'.$_GET['id'].'" and id="'.$row->id.'" and employee_id="'.$all_data_master->employee_id.'" and below_average=1');
				
					if($check_below_average>0){
					?>
					checked="checked"
					<?php } ?>
					 id="below_average_<?php echo $row->id;?>" name="below_average_<?php echo $row->id;?>" value="1" style="height: 29px;width: 39px;"></td>
				    <td><input type="checkbox"
					<?php 
					$check_unsatisfactory=find_a_field('performance_appraisal_details','count(id)','pa_id="'.$_GET['id'].'" and id="'.$row->id.'" and employee_id="'.$all_data_master->employee_id.'" and unsatisfactory!=""');
				
					if($check_unsatisfactory>0){
					?>
					checked="checked"
					<?php } ?>
					 id="unsatisfactory_<?php echo $row->id;?>" name="unsatisfactory_<?php echo $row->id;?>" value="0" style="height: 29px;width: 39px;"></td>
				</tr>
				<?php } ?>
				<tr>
					<td>
						20
					</td>
					<td>
						Involvement in Grouping
					</td>
					<td colspan="6" style="background-color:darkseagreen;">
						<select name="group_involvement" id="group_involvement" class="form-control" style="margin: 0 auto;width:70px;">
						
							<option value="<?php echo $all_data_details_two->group_involvement;?>"><?php echo $all_data_details_two->group_involvement;?></option>
						 
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		<p style="color:red;font-weight:bold;">N.B: Grouping-Actively involved (-10) & Less Actively involved(-5) will be deducted from total points.</p>
		<table class="table table-bordered table-condensed">
		<tbody>
		<tr>
			<td colspan="2">
			<span style="font-weight:bold;">i) Recommendation For:......</span>
			<table>
				<tr>
					<td><input type="checkbox" <?php if($all_data_details_two->increment>0){?> checked="checked" <?php } ?>  id="increment" name="increment" value="1" style="height: 19px;width: 29px;"> <span style="vertical-align:top;">Increment</span></td>
					<td>&nbsp;&nbsp;</td>
					<td><input type="checkbox" <?php if($all_data_details_two->extension_of_confirmation>0){?> checked="checked" <?php } ?>  id="extension_of_confirmation" name="extension_of_confirmation" value="1" style="height: 19px;width: 29px;"><span style="vertical-align:top;"> Extension of Confirmation</span></td>
				</tr>
				<tr>
					<td><input type="checkbox" <?php if($all_data_details_two->promotion>0){?> checked="checked" <?php } ?>  id="promotion" name="promotion" value="1" style="height: 19px;width: 29px;"> <span style="vertical-align:top;">Promotion</span></td>
					<td>&nbsp;&nbsp;</td>
					<td><input type="checkbox" <?php if($all_data_details_two->termination>0){?> checked="checked" <?php } ?>  id="termination" name="termination" value="1" style="height: 19px;width: 29px;"> <span style="vertical-align:top;">Termination</span></td>
				</tr>
				<tr>
					<td><input type="checkbox" <?php if($all_data_details_two->confirmation>0){?> checked="checked" <?php } ?>  id="confirmation" name="confirmation" value="1" style="height: 19px;width: 29px;"> <span style="vertical-align:top;">Confirmation</span></td>
					<td>&nbsp;&nbsp;</td>
					<script>
					function set_other(){
					var chboxs = document.getElementById("other_recommendation").style.display;
    var vis = "none";
        if(chboxs=="none"){
         vis = "block"; }
        if(chboxs=="block"){
         vis = "none"; }
    document.getElementById("other_recommendation").style.display = vis;
					
					}
					
					</script>
					
					
					<td><input type="checkbox" <?php if($all_data_details_two->others>0){?> checked="checked" <?php } ?>  id="others" name="others" onClick="set_other()" value="1" style="height: 19px;width: 29px;"> <span style="vertical-align:top;">Others</span>
					<input type="text" name="other_recommendation" id="other_recommendation" <?php if($all_data_details_two->others<1){?> style="display:none;float: right;" <?php } ?> >
					</td>
				</tr>
			</table>
					<span style="font-weight:bold;">ii) Please specifically mention for increment and promotion, if any-:......</span>
			</td>
		</tr>
			<tr>
			<td>a) Pay Increase Amount: TK. <input type="text" name="increment_amount" value="<?php echo $all_data_details_two->increment_amount;?>" id="increment_amount" style="background:#a1f9a4;"></td>
		    <td>b) Promotion To- <input type="text" name="promotion_to" id="promotion_to" value="<?php echo $all_data_details_two->promotion_to;?>" style="background:#aae9f3;"></td>
		  </tr>
			<tr>
			<td colspan="2">Comments (if any)<br>
			<textarea style="height: 70px;width: 80%;" name="incharge_comments" id="incharge_comments"><?php echo $all_data_details_two->incharge_comments;?></textarea>
			</td>
		</tr>
		</tbody>
		</table>
		
		<br>  
				<table style="width:25%;" >	  
						   
					<tr style="border:0px solid;">
						<td style="text-align:center;" ><?php 
						echo find_a_field('user_activity_management','fname','user_id='.$all_data_details_two->incharge_entry_by);
						?></td>
					</tr>
						<tr style="border-top:1px solid black;">
						<td style="text-align:center;font-weight:bold;">Signature of the HOD/Verifier</td>
					</tr>		  
              </table>
		<br> 
		<span style="font-weight:bold;">2. Next recommendations from Authorizer</span>
			<table class="table table-bordered table-condensed">
		<tbody>
		<tr>
			<td>Approve Amount <input type="text" name="autho_increment_amount" value="" id="autho_increment_amount" style="background:#a1f9a4;"></td>
		   
		  </tr>
		<tr>
				<td  >Comments<br>
			<textarea style="height: 70px;width: 80%;" name="authorize_comments" id="authorize_comments"><?php echo $all_data_details_two->authorize_comments;?></textarea>
			</td>
		</tr>
		</tbody>
		</table>
		
		 <br>
		<div class="text-center">
		<input type="submit" name="submit" class="btn btn-success btn-lg" id="submit" value="Submit">
		 </div>
		  <br> <br>
</form>	 
</div>
</body>
</html>
			

    