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

<style>
	.new_bt_data{
    display: flex;
    justify-content: center;
    align-items: center;
    align-content: center;
	top: -10px;
    font-size: 26px !important;
	}
	
/*	.header {
		width: 3% !important;
		border-radius: 20%;
		margin-left: -7px;
		margin-top: -5px;
	}*/
	
	.header {
      width: 50px !important;
      border-radius: 0% 0% 100%;
      height: 50px !important;
	}
	
	.menu1 {
		margin-left: 5px !important;
		margin-top: 3px !important;
	}

	.borderWH {

		background-color: #fff !important;
		border-radius: 10px !important;

	}
	.leave{
		background-color: #C7D3D4FF !important;
	}

	@media only screen and (max-width: 600px) {

		.header {

        width: 50px !important;
        border-radius: 0% 0% 100%;
        height: 50px !important;
			/*width: 11% !important;
			border-radius: 20%;
			/* margin-left: -10px;
			margin-top: -10px; */

		}

		.menu1 {}
	}
</style>

    

        
   <div class="page-content header-clear-small">
    <div class="content">
        <?php
      
        $today = date('Y-m-d');
        $attendance_given = find_a_field('hrm_attdump', 'sl', 'EMP_CODE="'.$PBI_ID.'" and xdate="'.$today.'"');
        
        if(!$attendance_given) { 
        ?>
		<a href="../file/daily_attendance2.php"> 
        <div class="card borderWH card-style mx-0 " style="margin-bottom: 10px;">
            <div class="p-3" style="background-color: #FEE715;">
                <h4 class="font-700 text-uppercase font-12">Present</h4>
                <p>Attendance is missing. Please give your attendance.</p>
				 <a> <i class="fa fa-arrow-right float-end mt-n3 "></a></i>
            </div>
        </div>
		</a>
        <?php } ?>
       <div class="card leave card-style" style="display: none;">
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
	
    <div class="row mb-n2">
      <div class="col-6 pe-2">
    <div class="card borderWH card-style mx-0 mb-3" >
      <div class="p-3" style="background-color: #FF99FF;">
        <h4 class="font-700 text-uppercase font-12 mt-n2" > Total Absent</h4>
        <h1 class="font-700 font-34  mb-0">
          <span class="textspan">
            <?php 
            // Get all days in current month up to today
            $startDate = new DateTime(date('Y-m-01')); // First day of current month
            $endDate = new DateTime(date('Y-m-d'));    // Today's date
            $interval = $startDate->diff($endDate);
            $totalDays = $interval->days + 1; // +1 to include the first day itself

            // Count attendance records (days present)
            $present_days = find_a_field('hrm_attdump', 'COUNT(*)', 'EMP_CODE="'.$PBI_ID.'" and xdate BETWEEN "'.date('Y-m-01').'" AND "'.date('Y-m-d').'"');

            // Calculate absent days
            $absent_days = $totalDays - $present_days;

            // Echo the absent days
            echo $absent_days;
            ?>
          </span>
        </h1>
        <i class="fa fa-arrow-right float-end mt-n3 "></i>
      </div>
    </div>
  </div>
  
      <div class="col-6 ps-2 pe-2">
	  <a href="location.php">
        <div class="card borderWH card-style mx-0 mb-3">
          <div class="p-3" style="background-color: pink;">
            <h4 class="font-700 text-uppercase font-12  mt-n2" style="height: 53px;"> FInd Me</h4>
            <?php /*?><h1 class="font-700 font-34  mb-0">
              <span class="textspan"> <? if($attedance->ab <0){ echo $attedance->ab;}else{echo '0';}?> </span>
            </h1><?php */?>
            <a><i class="fa fa-arrow-right float-end mt-n3 "></i></a>
          </div>
        </div>
		 </a>
      </div>
	 
      <div class="col-6 pe-2">
	  <a href="leave_status.php">
  <div class="card borderWH card-style mx-0 mb-3">
    <div class="p-3" style="background-color: #FFCC99;">
      <h4 class="font-700 text-uppercase font-12 mt-n2"> Available Leave</h4>
      <h1 class="font-700 font-34 mb-0">
        <span class="textspan">
          <?php 

            $total_cl_balance = $leave_rule->CL - $lv_days_casual;
            $total_sl_balance = $leave_rule->MED - $leave_days_sick;
            $total_al_balance = $leave_rule->ANU - $leave_days_annual;
            
   
            $total_available_leave = $total_cl_balance + $total_sl_balance + $total_al_balance;
            echo $total_available_leave;
          ?>
        </span>
      </h1>
      <a><i class="fa fa-arrow-right float-end mt-n3"></i></a>
    </div>
  </div>
  </a>
</div>
      <div class="col-6 ps-2 pe-2">
  <div class="card borderWH card-style mx-0 mb-3">
    <div class="p-3" style="background-color: #B7C9E2;">
      <h4 class="font-700 text-uppercase font-12 mt-n2">Total Late</h4>
      <h1 class="font-700 font-34 mb-0">
        <span class="textspan"> 
          <?php 
            $threshold_time =new DateTime('10:15:00');
			$late_days = 0;
			
			$start_date = date('Y-m-01');
			$end_date = date('Y-m-d');
			
			$query = "SELECT min(time) as att_time , xdate FROM `hrm_attdump` WHERE EMP_CODE = '$PBI_ID' AND `xdate` BETWEEN '$start_date' AND '$end_date' group by xdate";
			$result = mysqli_query($conn, $query);
			
			if ($result) {
				$dates_checked = [];
			
				while ($row = mysqli_fetch_assoc($result)) {
						$att_time=new DateTime($row['att_time']);
						
						
						
						if ($att_time > $threshold_time) {
						
							
							$late_days++;
						}
			
						$dates_checked[$row['xdate']] = true;
					}
				}
			
				echo "$late_days";
			

          ?>
        </span>
      </h1>
      <i class="fa fa-arrow-right float-end mt-n3"></i>
    </div>
  </div>
</div>
    </div>
  </div>
	
	
	
	
        
        
		
		
		
		<!--notice board start-->
                <!--notice board start-->
<div class="card leave card-style">
    <div class="content">
        <div class="card-title"><h4>Notice Board - <?php echo date('F Y'); ?></h4></div>
        <hr>
        <ul class="list-group">
            <?php
            // First, let's try to get the structure of the notice table to see available columns
            $table_structure_query = "SHOW COLUMNS FROM notice";
            $structure_result = mysqli_query($conn, $table_structure_query);
            
            $date_column = null;
            if ($structure_result) {
                while ($column = mysqli_fetch_assoc($structure_result)) {
                    // Look for commonly used date column names
                    if (in_array(strtolower($column['Field']), ['created_at', 'date', 'notice_date', 'post_date', 'published_at', 'created'])) {
                        $date_column = $column['Field'];
                        break;
                    }
                }
            }
            
            // If we found a date column, filter by it; otherwise, show all notices
            if ($date_column) {
                $current_year = date('Y');
                $current_month = date('m');
                $notice_query = "SELECT * FROM notice WHERE YEAR($date_column) = '$current_year' AND MONTH($date_column) = '$current_month' ORDER BY id DESC";
            } else {
                // Fallback to showing all notices if no date column is found
                $notice_query = "SELECT * FROM notice ORDER BY id DESC";
            }
            
            $notice_result = mysqli_query($conn, $notice_query);
            
            if ($notice_result && mysqli_num_rows($notice_result) > 0) {
                while($notice = mysqli_fetch_assoc($notice_result)) {
               echo '<li class="list-group-item">'.$notice['notice_title']. ':-'.$notice['notice_description'].'</li>';
                }
            } else {
                echo '<li class="list-group-item">No notices available for '.date('F Y').'.</li>';
            }
            ?>
        </ul>
    </div>
</div>
		<div class="card leave card-style">
    <div class="content">
       <div class="card-title"><h4>Holidays - <?php echo date('F Y'); ?></h4></div>
        <hr>
        <ul class="list-group">
            <?php if (count($holidays) > 0): ?>
                <?php foreach ($holidays as $holiday): ?>
                    <li class="list-group-item">
                        <?php 
                        $holiday_date = new DateTime($holiday['holy_day']);
                        echo $holiday_date->format('d M, Y') . ' - ' . $holiday['reason']; 
                        ?>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item">No upcoming holidays found</li>
            <?php endif; ?>
        </ul>
    </div>
</div>
			
			<!--Individual Leave Status start-->
				
      

    
       



       

    </div>
    <!-- End of Page Content--> 
    
    



<script>
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
          alert("Geolocation is not supported by this browser.");
        }
      }
      function showPosition(position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        var mapSrc = "https://maps.google.com/maps?q=" + lat + "," + lon + "&z=17&output=embed";
        document.getElementById("map").src = mapSrc;
      }
    </script>




<? require_once '../assets/template/inc.footer.php'; ?>