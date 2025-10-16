<?php 
session_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";




$cid = $_SESSION['proj_id'];
$title = "home";
$page = "home.php";


require_once '../assets/template/inc.header.php';
$u_id  =  $_SESSION['user']['id'];

 $PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$currentMonth = date("m");
$currentYear = date("Y");

$attedance = find_all_field('hrm_attendence_final','','PBI_ID="'.$PBI_ID.'" and mon="'.$currentMonth.'" and year="'.$currentYear.'"');

$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$PBI_ID.'"');



// *********  DISTANCE CALCULATION FUNCTION STRAT ***********

$damp = find_all_field('hrm_attdump','','EMP_CODE="'.$PBI_ID.'" and xdate="'.date('Y-m-d').'"');


function Distance($lat1, $lon1, $lat2, $lon2, $unit) {
  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}


$current_year = date('Y');
$current_month = date('m');
$holidays_query = "SELECT * FROM salary_holy_day WHERE YEAR(holy_day) = '$current_year' AND MONTH(holy_day) = '$current_month' ORDER BY holy_day ASC";
$holidays_result = mysqli_query($conn, $holidays_query);
$holidays = [];

if ($holidays_result) {
    while ($row = mysqli_fetch_assoc($holidays_result)) {
        $holidays[] = $row;
    }
}



$lat1 = $damp->latitude; //"23.791166";
$lon1 = $damp->longitude;  //"90.4082562";

$lat2 = $damp->sch_latitude_point;  //"23.8289778";
$lon2 = $damp->sch_longitude_point;  //"90.3637915";
$unit = "K";
if (!empty($lat2) && !empty($lon2)){
    $distance = Distance($lat1, $lon1, $lat2, $lon2, $unit);
}else{
    
}

// *********  DISTANCE CALCULATION FUNCTION END ***********
?>

<div class="page-content header-clear-small" style="margin-top: 20px;">
<div class="card leave card-style">
					<div class="content " style="background-color: white;">
						<div class="text-center pb-1 pt-1 bg-color-notice"><h4>Individual Leave Status</h4></div>
		
						
						<? 
						$g_s_date=date('Y-01-01');
						$g_e_date=date('Y-12-31');
						
						$leave_rule = find_all_field('hrm_leave_rull_manage','','1');
						$lv_days_casual =find_a_field('hrm_leave_info','sum(total_days)','type=1 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
						$leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type=2 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
						$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type=3 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
						$leave_days_marrige=find_a_field('hrm_leave_info','sum(total_days)','type=4 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
						$leave_days_maternity=find_a_field('hrm_leave_info','sum(total_days)','type=5 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
						$leave_days_paternity=find_a_field('hrm_leave_info','sum(total_days)','type=6 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
						$leave_days_Hajj=find_a_field('hrm_leave_info','sum(total_days)','type=7 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
						$leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date>="'.$g_s_date.'" and 
						half_leave_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
						$leave_days_EOL=find_a_field('hrm_leave_info','sum(total_days)','type=8 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
						?>
						
						
						<table class="table1  table-striped table-bordered table-hover table-sm" style="margin: 0 auto;">
                            <thead class="thead1 bold">
                                <tr class="bgc-info">
                                    <th> Type </th>
                                    <th> Casual Leave (CL) </th>
                                    <th> Sick Leave (SL) </th>
                                    <th> Annual Leave (AL) </th>
                                    <th> Extra Ordinary Leave (EOL) </th>
                                </tr>
                            </thead>

                            <tbody class="tbody1">
                                <tr>
                                    <td>Entitlement</td>
                                    <td><?=$leave_rule->CL?></td>
                                    <td><?=$leave_rule->MED?></td>
                                    <td><?=$leave_rule->ANU?></td>
                                    <td> As per Management Approval</td>
                                </tr>
                                <tr>
                                    <td>Availed</td>
                                    <td><?=$lv_days_casual;?></td>
                                    <td><?=$leave_days_sick;?></td>
                                    <td><?=$leave_days_annual;?></td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td>Balance</td>
                                    <td><?=$leave_rule->CL-$lv_days_casual;?></td>
                                    <td><?=$leave_rule->MED-$leave_days_sick;?></td>
                                    <td><?=$leave_rule->ANU-$leave_days_annual;?></td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table>
						
						
					</div>
			</div>
			</div>
<?php require_once '../assets/template/inc.footer.php'; ?>

