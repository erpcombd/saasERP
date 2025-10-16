<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title="Self Assessment";
 
if(isset($_POST['initiate'])){
$emp_id=$_POST['employee_name'];

$all_data=find_all_field('personnel_basic_info','*','EMP_ID='.$emp_id);
echo $ins_sql='insert into self_assessment_appraisal(employee_id,concern_name,appraisal_for,from_date,to_date,present_date,status,entry_by)values("'.$_POST['employee_name'].'","'.$all_data->PBI_ORG.'","'.$_POST['appraisal_for'].'","'.$_POST['from_date'].'","'.$_POST['to_date'].'","'.$_POST['present_date'].'","MANUAL","'.$_SESSION['user']['id'].'")';
db_query($ins_sql);
$last_id=mysqli_insert_id();
header("Location: self_assessment.php?id=".$last_id);

} 

if(isset($_POST['update'])){
$emp_id=$_POST['employee_name'];

$all_data=find_all_field('personnel_basic_info','*','EMP_ID='.$emp_id);
  $up_one_sql='update self_assessment_appraisal set employee_id="'.$_POST['employee_name'].'",concern_name="'.$all_data->PBI_ORG.'",appraisal_for="'.$_POST['appraisal_for'].'",from_date="'.$_POST['from_date'].'",to_date="'.$_POST['to_date'].'" where id="'.$_GET['id'].'" ';
db_query($up_one_sql);
 
header("Location: self_assessment.php?id=".$_GET['id']);

} 

$all_data_master=find_all_field('self_assessment_appraisal','*','id='.$_GET['id']);
$all_data=find_all_field('personnel_basic_info','*','EMP_ID='.$all_data_master->employee_id); 
$all_edu=find_all_field('hrm_education_detail','*','PBI_ID="'.$all_data->PBI_ID.'" order by EDUCATION_D_ID desc ');

if(isset($_POST['confirm'])){
  $up_sql='update self_assessment_appraisal set name_of_appraisee="'.$_POST['name_of_appraisee'].'",designation="'.$_POST['designation'].'",department="'.$_POST['department'].'",doj="'.$_POST['doj'].'",qualification="'.$_POST['qualification'].'",aca_sub="'.$_POST['aca_sub'].'",experience="'.$_POST['experience'].'",experience_tpc="'.$_POST['experience_tpc'].'",late_join_date="'.$_POST['late_join_date'].'",absent_pay="'.$_POST['absent_pay'].'",warning="'.$_POST['warning'].'",present_salary="'.$_POST['present_salary'].'" ,last_inc_amt="'.$_POST['last_inc_amt'].'",last_inc_date="'.$_POST['last_inc_date'].'",tot_availed="'.$_POST['tot_availed'].'",status="CHECKED"  where id='.$_GET['id'];
db_query($up_sql);
header("Location: self_apprisial_view_hr1.php?id=".$_GET['id']);
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
  
  th,tr,th,td{
  border:1px solid;
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
 
  <body style="padding:10px;">

    <section>
      <div class="container"> <br><br>
	  	<form  action="" method="post" >
			

	  
	  <div class="first_part">
	  
	  <div class="row">
	
		<div class="col-12 text-center pt-3">
			<h1>SELF ASSESSMENT FORM</h1>
		</div>
		
	</div>
	  <br>
	  

            
			
            <br><div class="row m-0 p-0">
      <div class="col-6">
		    
			<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Name of Employee</span>
			  </div>
			   <input list="employee_names" name="employee_name" id="employee_name" style="width:370px; margin-left:5px;" value="<?php echo $all_data_master->employee_id;?>" >
		
					  <datalist id="employee_names">
						<?php 
								$sql='select * from personnel_basic_info';
								$query=db_query($sql);
								while($row=mysqli_fetch_object($query)){
								?>
						<option value="<?php echo $row->EMP_ID;?>"><?php echo $row->EMP_ID,"-> ",$row->PBI_NAME;?></option>
								<?php } ?>
					  </datalist>
			</div>
			
				<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend" style="width:25%">
				<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Appraisal For</span>
			  </div>
			  <select name="appraisal_for" id="appraisal_for" class="form-control" style="width:350px; margin-left:5px;">
			  	<option value="<?php echo $all_data_master->appraisal_for;?>"><?php echo $all_data_master->appraisal_for;?></option>
			  	<option value="Confirmation">Confirmation</option>
				<option value="Half Yearly">Half Yearly</option>
				<option value="Yearly">Yearly</option>
			  </select>
			   
			  <input type="hidden" style="width:350px; margin-left:5px;" class="form-control" name="present_date" id="present_date" value="<?php echo date('Y-m-d');?>">
			</div>
			
			
			
		  </div>
		  <div class="col-6">
		    
		<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend">
				<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Appraisal Period From</span>
			  </div>
			   <input type="date" style="font-size:14px; font-weight:bold; margin-left:10px;" class="form-control" name="from_date" value="<?php echo $all_data_master->from_date;?>" id="from_date">
			  
			</div>
			
				<div class="input-group mb-3 input-group-sm">
			  <div class="input-group-prepend" style=" width:30%;">
				<span class="input-group-text"  style="font-weight:bold;font-size:14px;">To</span>
			  </div>
			  <input type="date" style="font-size:14px; font-weight:bold; margin-left:10px;" class="form-control" value="<?php echo $all_data_master->to_date;?>" name="to_date" id="to_date">
			</div>
			
			
			
			
			
		  </div>
              
            </div>  
			
			
			
			
			
			
			
			<div class="row m-0 p-0">
					
			 
				<div class="col-12 text-center">
			 <?php 
			 if($_GET['id']>0){
			 ?>
			 <button type="submit" name="update" id="update" class="btn btn-primary">Update</button>
			 <?php } else { ?>
					  <button type="submit" name="initiate" id="initiate" class="btn btn-primary">Initiate</button>
		 <?php } ?>
					
				</div>
				
			</div>
	 </form>
	 
	 </div>
	 
	 <div class="second_part">
	 	 <?php 
			 if($_GET['id']>0){
			 ?>
	 <form action="" method="post">
			<br><br>
				<div class="row m-0 p-0">
					  <div class="col-6">
							
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:30%">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Name of Appraisee</span>
							  </div>
							  <input type="text" style="font-size:14px;font-weight:bold;" class="form-control" name="name_of_appraisee" id="name_of_appraisee" value="<?php echo $all_data->PBI_NAME;?>">
							</div>
							
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:30%">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Employee ID</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="employee_id" id="employee_id" value="<?php echo $all_data->EMP_ID;?>">
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:30%">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Designation</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="designation" id="designation" value="<?php echo $all_data->PBI_DESIGNATION;?>">
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:30%">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Department</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="department" id="department" value="<?php echo $all_data->PBI_DEPARTMENT;?>">
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:30%">
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
							  <div class="input-group-prepend" style="width:38%">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Concer Name</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="concern_name" id="concern_name" value="<?php echo find_a_field('user_group','group_name','id='.$all_data->PBI_ORG);?>">
							  
							</div>
								<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:38%">
								<span class="input-group-text"  style="font-weight:bold;font-size:14px;">Last Academic Qualification</span>
							  </div>
							  <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="qualification" id="qualification" value="<?php echo $all_edu->EDUCATION_NOE;?>">
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:38%">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Concern Academic Subject</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="aca_sub" id="aca_sub" value="<?php echo $all_edu->EDUCATION_SUBJECT;?>">
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:38%">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Total Year(s) of Experience</span>
							  </div>
							  
							  <?
							  
							   //Others company Experience
								
								  $sql=" select * from hrm_experience_detail where PBI_ID='".$all_edu->PBI_ID."'";
								$query=db_query($sql);
								while($row=mysqli_fetch_object($query))
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
												// echo $diff = strtotime($start1) - strtotime($end1)."<br>"; 
											  
												// 1 day = 24 hours 
												// 24 * 60 * 60 = 86400 seconds 
												//$tot_day= abs(round($diff / 86400)); 
											$now = strtotime($end1); // or your date as well
$your_date = strtotime($start1);
$datediff = $now - $your_date;

  $tot_day=round($datediff / (60 * 60 * 24));
											  
									$other_exp+=$tot_day;
										
			
									
								}
						 
							  
							  			//Tpc Experience
										$today=date('Y-m-d');
										$cur_date=strtotime($today);	
										$join_date=strtotime($all_data->PBI_DOJ);
										$datediff_tpc = $cur_date - $join_date;

    $tot_day_tpc=round($datediff_tpc / (60 * 60 * 24));
										
								 
										 
										// echo $other_exp."<br>".$tpc_exp;
										 //Total Experience
										   $total_day=$other_exp+$tot_day_tpc;
							
							  	 	$years = intval($total_day / 365); 
									$total_day = $total_day % 365;
									$months = intval($total_day / 30); 
								$total_day = $total_day % 30; // the rest of days
									
									//echo $years.' years, '.$month.' months, '.$days.' days';
									
								//echo "$years years, $months months, $total_day days";
							
							  
							  ?>
							  							  
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="experience" id="experience" value="<?php  echo $years.' years, '.$months.' months, '.$total_day.' days'; ?>">
							  
							</div>
							
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend" style="width:38%">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Experience in TPC Group </span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="experience_tpc" id="experience_tpc" value="<?php echo $all_data->PBI_SERVICE_LENGTH;?>">
							  
							</div>
							
							
							
							
						  </div>
              
            </div>
			
	 
			
			
			
			
			<br><br>
			
	 
				<div class="row m-0 p-0">
					<h4 style="text-align:center;">Necessary Information (During appraisal period):</h4> 
					  <div class="col-6 pt-4">
					  <div class="row m-0 p-0">
					  	<div class="col-6">
						<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Late join in office</span>
							  </div>
							  
							  <?php 
							  $date_mon_from=explode("-",$all_data_master->from_date);
							    $date_mon_to=explode("-",$all_data_master->to_date);
								if($date_mon_from[1]==12){
								$date_mon_from[1]=1;
								$date_mon_from[0]=$date_mon_from[0]+1;
								}
								else{
								$date_mon_from[1]+=1;
								$date_mon_from[0]=$date_mon_from[0];
								}
								
								//echo $date_mon_from[0]."year".$date_mon_from[1]."mon";
							  $from_id=find_a_field('salary_attendence','id','mon="'.$date_mon_from[1].'" and year="'.$date_mon_from[0].'" and EMP_ID="'.$all_data_master->employee_id.'"');
							  	    $to_id=find_a_field('salary_attendence','id','mon="'.$date_mon_to[1].'" and year="'.$date_mon_to[0].'" and EMP_ID="'.$all_data_master->employee_id.'"');
							 $total_late=find_a_field('salary_attendence','sum(lt)','EMP_ID="'.$all_data_master->employee_id.'" and id between "'.$from_id.'" and "'.$to_id.'"');
							 'select id from salary_attendence where mon="'.$date_mon_from[1].'" and year="'.$date_mon_from[0].'" and EMP_ID="'.$all_data_master->employee_id.'"';
							 		 $total_lwp_absent=find_a_field('salary_attendence','sum(ab+lwp)','EMP_ID="'.$all_data_master->employee_id.'" and id between "'.$from_id.'" and "'.$to_id.'"');
							   'select sum(ab+lwp) from salary_attendence where EMP_ID="'.$all_data_master->employee_id.'" and id between "'.$from_id.'" and "'.$to_id.'"';
							  ?>
							  
							  <input type="text" style="font-size:14px;font-weight:bold;" class="form-control" name="late_join_date" id="late_join_date" value="<?php echo $total_late;?>">
							</div>
						
						</div>
					  <div class="col-6 ">
					  
					  		<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Leave Availed</span>
							  </div>
							  
							  <?php 
			$hrm_leave_rull_manage=find_all_field('hrm_leave_rull_manage','*','id='.$all_data->JOB_LOCATION);
			  $conf_date=$all_data->PBI_DOC2;
			   $get_conf=explode("-",$conf_date);
   $conf_month=$get_conf[1];
			   $prev_year= date("Y",strtotime("-1 year"));
  $prev_cus_year= date("Y",strtotime("-2 year"));
  $prev_cus_year_two= date("Y",strtotime("-3 year"));
$g_s_date=$prev_year."-12-26";
$g_e_date=date('Y-12-25');

			 if($all_data->EMPLOYMENT_TYPE=="Probation"){
		$this_year_op_cl=0;
		$this_year_op_sick=0;
		$this_year_op_anual=0;
		
		}
		else{
		 ////////// this year ager prappo leave start///////
    if($conf_date<$g_s_date){
  
     $this_year_op_cl=$hrm_leave_rull_manage->CL;
     $this_year_op_sick=$hrm_leave_rull_manage->MED;
      $this_year_op_anual=$hrm_leave_rull_manage->ANU;
  
  }
  else if($conf_date>=$g_s_date && $conf_date<$g_e_date){
		   if($conf_month==12){
			$tot_payable_month=12;
		 }
		 else{
		  $tot_payable_month=12-$conf_month;
		 }
		 
		
 
    	    $this_year_op_cl=$tot_payable_month*$hrm_leave_rull_manage->per_month;
    $this_year_op_sick=$tot_payable_month*$hrm_leave_rull_manage->per_month;
     $this_year_op_anual=$tot_payable_month*$hrm_leave_rull_manage->per_month;
  }
 
   ////////// this year ager prappo leave  END///////
		
		}
		$hrm_leave_rull_manage=$this_year_op_cl+$this_year_op_sick+$this_year_op_anual;
		//echo number_format($this_year_op_cl,2);
			
			
							 		   $total_leave_availed=find_a_field('salary_attendence','sum(lv)','EMP_ID="'.$all_data_master->employee_id.'" and id between "'.$from_id.'" and "'.$to_id.'"');
							// echo 'select sum(lv) from salary_attendence where EMP_ID="'.$all_data_master->employee_id.'" and id between "'.$from_id.'" and "'.$to_id.'"';
							  ?>
							  
							  <input type="text" style="font-size:14px;font-weight:bold;" class="form-control" name="tot_availed" id="tot_availed" value="<?php echo $total_leave_availed." Out of ".$hrm_leave_rull_manage;?>">
							</div>
					  </div>
					  </div>
							
							
							
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Absent/Leave without pay</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="absent_pay" id="absent_pay"  value="<?php echo $total_lwp_absent;?>" >
							  
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Warning/Show cause/Penalty notice issued</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="warning" id="warning">
							  
							</div>
							
							
							
							
							
						  </div>
						  <div class="col-6 pt-4">
							
						<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold;font-size:14px;">Present Salary</span>
							  </div>
							  
							  <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="present_salary" id="present_salary" value="<?php echo find_a_field('salary_info','gross_salary','PBI_ID="'.$all_data->PBI_ID.'"');?>">
							</div>
							
								<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold;font-size:14px;">Last Increment Amount</span>
							  </div>
							  <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="last_inc_amt" id="last_inc_amt" value="<?php echo find_a_field('increment_detail','INCREMENT_AMT','PBI_ID="'.$all_data->PBI_ID.'" order by INCREMENT_D_ID desc');?>">
							</div>
							<div class="input-group mb-3 input-group-sm">
							  <div class="input-group-prepend">
								<span class="input-group-text"  style="font-weight:bold; font-size:14px;">Last Increment Date</span>
							  </div>
							   <input type="text" style="font-size:14px; font-weight:bold;" class="form-control" name="last_inc_date_show" id="last_inc_date_show" value="<?php   $last_inc_date=find_a_field('increment_detail','INCREMENT_EFFECT_DATE','PBI_ID="'.$all_data->PBI_ID.'" order by INCREMENT_D_ID desc');
							   
							echo date('d-m-Y',strtotime($last_inc_date)); 
							   ?>">
							   	   <input type="hidden" style="font-size:14px; font-weight:bold;" class="form-control" name="last_inc_date" id="last_inc_date" value="<?php   echo $last_inc_date=find_a_field('increment_detail','INCREMENT_EFFECT_DATE','PBI_ID="'.$all_data->PBI_ID.'" order by INCREMENT_D_ID desc');
							   
							  
							   ?>">
							  
							</div>
							
							
							
						  </div>
						  <br><br>
						  
						  <div class="col-12" align="center">
						  	<button type="submit" name="confirm" id="confirm" class="btn btn-primary">Confirm & Forward</button>
						  </div>
						  
              
            </div>
			
</form>	


</div>
 <?php  
 }
 ?>
</div>
</body>
</html>
			

    <?php 
		require_once SERVER_CORE."routing/layout.bottom.php";
	
	?>
	

	
	