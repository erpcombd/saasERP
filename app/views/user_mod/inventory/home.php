<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title = "User Management Dashboard";



$u_id=$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$check_idd =find_a_field('user_activity_management','default_checker','PBI_ID="'.$PBI_ID.'"');


if($check_idd==0){

header("Location:../leave/change_password.php");


}


$_SESSION['employee_selected'] = $PBI_ID;



 $today = date('Y-m-d');

 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));

 $cur = '&#x9f3;';



echo $_SESSION['user']['module'];



//Mail function start





    $to_date =  date("Y-m-d");

    $found=find_a_field('mail_forwarding','kpi','mail_date>="'.$to_date.'"');

   

	 //$start_date = date("Y-m-d",time()-(7*24*60*60));

	 //$end_date =  date("Y-m-d",time()-(1*24*60*60));

	

/*if($found==10){ 

  $start_date = date("Y-m-d",time()-(7*24*60*60));

  $end_date =  date("Y-m-d",time()-(1*24*60*60));

  $cdate = strtotime($start_date);

  $edate = strtotime($end_date);

  $week_name = find_a_field('hrm_weeks','week_name','s_date between "'.$start_date.'" and "'.$end_date.'"');

		  

		  $str.='<table width="50%" border="1" cellspacing="0" cellpadding="0" style="font-family:cambria;">

		  <tr align="center">

           <td>SL</td>

		   <td>ID</td>

		   <td>Name</td>

		   <td>Designation</td>

		   <td>Joining Date</td>

		   <td>Grade</td>

		  </tr>

		 </table>';

		  

		  

		  $check = 'select k.*,p.PBI_ID,p.PBI_NAME,p.PBI_DESIGNATION,p.PBI_DOJ from hrm_final_score k, personnel_basic_info p where k.PBI_ID=p.PBI_ID and k.week="1ST WEEK" and k.year="'.date('Y').'"';

		  $query = db_query($check);

		 

		  while($data=mysqli_fetch_object($query)){

		

		  

		  $str.= '<tr align="center">';

		    $str.= '<td>'.++$i.'</td>';

            $str.= '<td>'.$data->PBI_ID.'</td>';

			$str.= '<td>'.$data->PBI_NAME.'</td>';

			$str.= '<td>'.find_a_field('designation','DESG_DESC','DESG_ID='.$data->PBI_DESIGNATION).'</td>';

			$str.= '<td>'.date('d-M-Y',strtotime($data->PBI_DOJ)).'</td>';

			$str.= '<td>A</td>';

          $str.= '</tr>';

		  

		  }

		  

		  $str.= '</table>';



$mail = find_a_field('personnel_basic_info','PBI_EMAIL','PBI_ID="'.$_GET['id'].'"');

$headers = "MIME-Version: 1.0\r\n";

$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$to = $mail.',bimolerp@gmail.com,tanvir@aksidcorp.com';

$subject = "Weekly KPI Summary Report";

$headers .= "From: AKSID HUMAN RESOURCES<hr@aksidcorp.com>";

mail($to,$subject,$str,$headers);

		

		}*/

		//Mail function end



?>


<style>
	@media (max-width: 768px) {
  .today-clock{
  display:none !important;  
  }
  }
</style>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Details Staff Report</title>

<!-- CSS Files -->

<link href="../../../../../public/dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
<body>








<?=$check?>

<?
$leave_iddd = $_SESSION['user']['id'];
$leave_id = find_a_field('user_activity_management','PBI_ID','user_id='.$leave_iddd);
$welcome = find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$leave_id);


if($leave_id>0)



{


$g_s_date=date('Y-01-01');



$g_e_date=date('Y-12-31');







$hrm_leave_info=find_all_field('hrm_leave_info','','PBI_ID='.$leave_id);







$leave_days_casual=find_a_field('hrm_leave_info','sum(total_days)','type=1 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);







$leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type=2 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);







$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type=3 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);



$leave_days_marrige=find_a_field('hrm_leave_info','sum(total_days)','type=4 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);



$leave_days_maternity=find_a_field('hrm_leave_info','sum(total_days)','type=5 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);



$leave_days_paternity=find_a_field('hrm_leave_info','sum(total_days)','type=6 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);



$leave_days_Hajj=find_a_field('hrm_leave_info','sum(total_days)','type=7 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);



$leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date>="'.$g_s_date.'" and half_leave_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);



$leave_days_EOL=find_a_field('hrm_leave_info','sum(total_days)','type=8 and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);







$leave_days_compensatory=find_a_field('hrm_leave_info','sum(total_days)','type="Compensatory Off" and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);







$leave_days_lwp=find_a_field('hrm_leave_info','sum(total_days)','type=9 and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);


$dayoff=find_a_field('hrm_leave_info','sum(total_days)','type=10 and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);







$personnel_basic_info=find_all_field('personnel_basic_info','','PBI_ID='.$leave_id);







$designation=find_all_field('designation','DESG_DESC','DESG_ID='.$personnel_basic_info->DESG_ID);







$department=find_all_field('department','DEPT_DESC','DEPT_ID='.$personnel_basic_info->DEPT_ID);







$hrm_leave_rull_manage=find_all_field('hrm_leave_rull_manage','','id='.$personnel_basic_info->LEAVE_RULE_ID);


}

?>



<div class="content">
	<div class="container-fluid">

		<div class="row">



			<div class="col-lg-4 col-sm-4 col-md-4">

				<div class="container">
					<!--3rd One yeare report chart-->
					<div class="card card-chart pt-2 pb-2" style="background-color: #f9ff67b3;">
						<div class="card-body p-1">
							<h4 class="card-title text-center bold"> <u>Basic Information</u> </h4>
						</div>
						<div class="card-header p-1 pl-3" id="my_basic_info">Loading..
							<!--<table>
								<tr>
									<td class="bold">ID:</td>
									<td>0001</td>
								</tr>

								<tr>
									<td class="bold">NAME: </td>
									<td>Md. OMAR FARUK</td>
								</tr>

								<tr>
									<td class="bold">Designation: </td>
									<td>CEO</td>
								</tr>

								<tr>
									<td class="bold">Department: </td>
									<td>Software Engineer</td>
								</tr>

								<tr>
									<td class="bold">Joining Date: </td>
									<td> 22-Nov-2022</td>
								</tr>


								<tr>
									<td class="bold">Confirmation Date: </td>
									<td>22-Nov-2022</td>
								</tr>


								<tr>
									<td class="bold">Sevice Length: </td>
									<td>Year/ Months/ Days</td>
								</tr>

							</table>-->
						</div>

					</div>


					<div>
						<div class="card card-stats pt-2">

							<div class="card-header card-header-warning card-header-icon">

								<p class="card-category" style="color:orange; font-weight:bold;">Next holiday</p>

								<h3 class="card-title"><span class="loader" style=" font-size: 18px;">Independence Day</span></h3>

							</div>

							<div class="card-footer" style="border-top:1px solid orange">

								<div class="stats">

									<i class="material-icons"></i> 15-Dec-2022

								</div>

							</div>

						</div>
					</div>
				</div>

			</div>





			<div class="col-lg-8 col-sm-8 col-md-8">
				<div class="row">

					<div class="col-lg-6 col-md-6 col-sm-6">
						<div class="card card-stats">
							<div class="card-header card-header-success card-header-icon">
								<div class="card-icon p-0">
									<i class="fas fa-chart-line"></i>
								</div>
								<p class="card-category" style="color:#0CBB37; font-weight:bold;">Total Present</p>
								<h3 class="card-title"><span  class="loader" id="total_present">Checking..<small>Day</small></span></h3>

							</div>

							<div class="card-footer" style="border-top:1px solid green">

								<div class="stats">

									<i class="material-icons"></i> This Month

								</div>

							</div>

						</div>

					</div>



					<div class="col-lg-6 col-md-6 col-sm-6">

						<div class="card card-stats">

							<div class="card-header card-header-primary  card-header-icon">

								<div class="card-icon p-0">

									<i class="fab fa-audible"></i>

								</div>

								<p class="card-category" style="color:#BA04F9; font-weight:bold;">Total Absent</p>

								<h3 class="card-title"><span class="loader" id="total_absent">Checking..<small>Day</small></span></h3>

							</div>

							<div class="card-footer" style="border-top:1px solid #BA04F9">

								<div class="stats">

									<i class="material-icons"></i> This Month

								</div>

							</div>

						</div>

					</div>




					<div class="col-lg-6 col-md-6 col-sm-6">

						<div class="card card-stats">

							<div class="card-header card-header-info card-header-icon">

								<div class="card-icon p-0">

									<i class="fas fa-file-export"></i>

								</div>

								<p class="card-category" style="color:#0fa9d7; font-weight:bold;">Total Late</p>

								<h3 class="card-title"><span class="loader" id="total_late">Checking..<small>Day</small></span></h3>

							</div>

							<div class="card-footer" style="border-top:1px solid #1ec1d5">

								<div class="stats">

									<i class="material-icons"></i>This Month

								</div>

							</div>

						</div>

					</div>





					<div class="col-lg-6 col-md-6 col-sm-6">

						<div class="card card-stats">

							<div class="card-header card-header-danger card-header-icon">

								<div class="card-icon p-0">


									<i class="fas fa-file-download"></i>

								</div>

								<p class="card-category" style="color:#BA04F9; font-weight:bold;">Total leave</p>

								<h3 class="card-title"><span class="loader" id="total_leave">Checking..<small>Day</small></span></h3>

							</div>

							<div class="card-footer" style="border-top:1px solid red">

								<div class="stats">

									<i class="material-icons"></i> This Year

								</div>

							</div>

						</div>

					</div>





				</div>

			</div>


		</div>





		<div class="row">

			<!--<div class="col-lg-6 col-md-12">
				<div class="card card-chart"  style="height: 290px;">
					<div class="card-header">
						<h4 class="card-title text-center bold"> <u>Last 5 Day Attendance Sheet</u> </h4>

						<table class="table1  table-striped table-bordered table-hover table-sm">
							<thead class="thead1">
							<tr class="bgc-success">
								<th>#</th>
								<th>Date</th>
								<th>In-Time</th>
								<th>Out-Time</th>
								<th>Status</th>
							</tr>
							</thead>
							<tbody class="tbody1">
							<tr>
								<td>01</td>
								<td>00-00-000</td>
								<td>00:00 am</td>
								<td>00:00 pm</td>
								<td>present</td>
							</tr>

							<tr>
								<td>02</td>
								<td>00-00-000</td>
								<td>00:00 am</td>
								<td>00:00 pm</td>
								<td>present</td>
							</tr>

							<tr>
								<td>03</td>
								<td>00-00-000</td>
								<td>00:00 am</td>
								<td>00:00 pm</td>
								<td>present</td>
							</tr>

							<tr>
								<td>04</td>
								<td>00-00-000</td>
								<td>00:00 am</td>
								<td>00:00 pm</td>
								<td>present</td>
							</tr>

							<tr>
								<td>05</td>
								<td>00-00-000</td>
								<td>00:00 am</td>
								<td>00:00 pm</td>
								<td>present</td>
							</tr>

							</tbody>
						</table>

					</div>
				</div>
			</div>-->



			<div class="col-lg-6 col-md-12">
				<div class="card card-chart" style="height: 290px; background-color: #FFFFFF;">
					<h4 class="text-center bg-warning bold pt-2 pb-2">  Notice Board </h4>

					<div class="card-header">
						<h6 class="bold m-0 p-0">Notice Titel</h6>
						<p>Notice Text</p>
					</div>

				</div>
			</div>


			<div class="col-lg-6 col-md-12">
				<div class="card card-chart"  style="height: 290px;">
					<div class="card-header">
						<h4 class="card-title text-center bold"> <u>Last 7 Day Activities</u> </h4>

						<div id="activities">Checking..</div>

					</div>
				</div>
			</div>





		</div>

	</div>





		<div class="container-fluid">
				<h4 class="text-center bg-titel bold pt-2 pb-2">  Individual Leave Status <?php echo date('Y')?> </h4>
				<table align="center" class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1 bold">
					<tr class="bgc-info">
						<td>Type</td>
						<td>Casual Leave (CL)</td>
						<td>Sick Leave (SL)</td>
						<td>Annual Leave (AL)</td>
						<td> Extra Ordinary Leave (EOL)</td>
					</tr>



					</thead>


					<tbody class="tbody1">


					<tr>

						<td><strong>Entitlement</strong></td>



						<td style="margin-top:20px;"><?=$casual=find_a_field('hrm_leave_type','yearly_leave_days','id=1');?></td>



						<td style="margin-top:20px;"><?=$sick_leave=find_a_field('hrm_leave_type','yearly_leave_days','id=2');?></td>



						<td  style="margin-top:15px;"><?=$annual=find_a_field('hrm_leave_type','yearly_leave_days','id=3');?></td>

						<td>As per Management Approval </td>
					</tr>



					<tr>
						<td><strong>Availed</strong></td>

						<td>  <?=$leave_days_casual?>  </td>



						<td> <?=$leave_days_sick?> </td>



						<td>   <?=$leave_days_annual?>  </td>



						<td><?=$leave_days_EOL?></td>

					</tr>



					<tr>
						<td><strong>Balance</strong></td>
						<td>  <?=$casual-$leave_days_casual?> </td>
						<td> <?=$sick_leave-$leave_days_sick?></td>
						<td> <?=$annual-$leave_days_annual?></td>


						<td><?=$leave_days_EOL?> </td>

					</tr>

					</tbody>

				</table>



		</div>



</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>

<script>

function view_data(){

$.ajax({
url:"user_dashboard_ajax.php",
method:"POST",
dataType:"JSON",
//data:{ data_no:data_no },hSat, hSun, hMon, hTue, hWed, hThu, hFri
success: function(result, msg){
var res = result;
setTimeout(view_data, 5000);
$("#my_basic_info").html(res[0]);
$("#total_present").html(res[1]);
$("#total_absent").html(res[2]);
$("#total_late").html(res[3]);
$("#total_leave").html(res[4]);
$("#activities").html(res[5]);
$("#hSat").val(res[11]);
}
}); 
}
window.onload = setTimeout(view_data, 3000);
//window.onload = setTimeout(salesBar, 6000);
//window.onload = setTimeout(yearChart, 6000);
//window.onload = setTimeout(newoilChart, 6000);

</script>

                    