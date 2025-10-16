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
		background-color: #fff !important;
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
    <div class="row mb-n2 mt-5">
      <div class="col-6 pe-2">
        <div class="card borderWH card-style mx-0 mb-3">
          <div class="p-3">
            <h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2"> Total Present</h4>
            <h1 class="font-700 font-34 color-green-dark  mb-0">
              <span class="textspan"> <? if($attedance->pre <0){ echo $attedance->pre;}else{echo '0';}?>  </span>
            </h1>
            <i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
          </div>
        </div>
      </div>
      <div class="col-6 ps-2 pe-2">
        <div class="card borderWH card-style mx-0 mb-3">
          <div class="p-3">
            <h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2"> Total Absent</h4>
            <h1 class="font-700 font-34 color-blue-dark mb-0">
              <span class="textspan"> <? if($attedance->ab <0){ echo $attedance->ab;}else{echo '0';}?> </span>
            </h1>
            <i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
          </div>
        </div>
      </div>
      <div class="col-6 pe-2">
        <div class="card borderWH card-style mx-0 mb-3">
          <div class="p-3">
            <h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2"> Total Late</h4>
            <h1 class="font-700 font-34 color-yellow-dark mb-0">
              <span class="textspan"> <? if($attedance->lt <0){ echo $attedance->lt;}else{echo '0';}?> </span>
            </h1>
            <i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
          </div>
        </div>
      </div>
      <div class="col-6 ps-2 pe-2">
        <div class="card borderWH card-style mx-0 mb-3">
          <div class="p-3">
            <h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2">Total leave</h4>
            <h1 class="font-700 font-34 color-red-dark mb-0">
              <span class="textspan"> <? if($attedance->lv <0){ echo $attedance->lv;}else{echo '0';}?></span>
            </h1>
            <i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
	
	
	
	
        
        <div class="card card-style">
    
        <div class="card-body leave">
          <h5 class="card-title">CURRENT LOCATION</h5>
          <hr>

				  <body onLoad="getLocation()">
					<iframe id="map" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
				  </body>
        </div>
		</div>
		
		
		
		<!--notice board start-->
                <div class="card leave card-style">
			<div class="content">
<div class="text-center pb-1 pt-1 bg-color-notice"><h4>Notice Board</h4></div>

            <ul class="list-group list-group-flush bg-none">

            <li class="list-group-item border-0">

                <div class="row">



                    <div class="col px-0">

                        <p class="p-2"> Notice Titel <?  echo $distance;?></br>

                        <small class="text-secondary">Notice Text</small>

                        </p>





                    </div>

                </div>

            </li>



        </ul>



    </div>


		</div>
			
			<!--Individual Leave Status start-->
			<div class="card leave card-style">
					<div class="content ">
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