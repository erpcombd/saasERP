<?php 
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

// Get user ID from session
$u_id = $_SESSION['user']['id'];

// Find PBI_ID from user_activity_management
$PBI_ID = find_a_field('user_activity_management', 'PBI_ID', 'user_id='.$u_id);

$user_id = $PBI_ID;

$title = "Attendance Report";
$page = "att_location_report.php";

require_once '../assets/template/inc.header.php';
date("Y-m-d H:i:s");

/**
 * Calculate distance between two coordinates
 * 
 * @param float $lat1 Latitude of first point
 * @param float $lon1 Longitude of first point
 * @param float $lat2 Latitude of second point
 * @param float $lon2 Longitude of second point
 * @param string $unit Unit of measurement (K for kilometers, N for nautical miles, default for miles)
 * @return mixed Distance in specified unit or error message
 */
function distance($lat1, $lon1, $lat2, $lon2, $unit) {
    // Check if any of the coordinates are empty strings, null, or zero values
    if (empty($lat1) || empty($lon1) || empty($lat2) || empty($lon2)) {
        return "N/A"; // Coordinates not provided
    }
    
    // Validate coordinates are actual numbers
    if (!is_numeric($lat1) || !is_numeric($lon1) || !is_numeric($lat2) || !is_numeric($lon2)) {
        return "Invalid coordinates";
    }
    
    // Convert string values to floats
    $lat1 = floatval($lat1);
    $lon1 = floatval($lon1);
    $lat2 = floatval($lat2);
    $lon2 = floatval($lon2);
    
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = min(max($dist, -1.0), 1.0); // Ensure dist is within valid range [-1, 1]
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
?>

<style>
  .openerp img {
    width: 100%;
  }
  .mob.scrollbar {
    display: none;
  }
  .btn-new {
    border-radius: 4px;
    width: 100%;
  }
  .btn-primary1 {
    color: #fff;
    background-color: #235bad;
    border-color: #1656b5;
    border: 0px;
  }
  .btn-warning1 {
    color: #000;
    background-color: #ffc107;
    border-color: #ffc107;
  }
  .btn-warning2 {
    color: #000;
    background-color: #ffc107;
    border-color: #ffc107;
    border: 0px;
  }
  .btn-danger1 {
    color: #fff;
    background-color: #f03d4f;
    border-color: #f03d4f;
    border: 0px;
  }
  .btn-success1 {
    color: #fff;
    background-color: #129b52;
    border-color: #129b52;
    border: 0px;
  }
  .btn-info1 {
    color: #fff;
    background-color: #0ca7d1;
    border-color: #0ca7d1;
    border: 0px;
  }
  .btn-secondary {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
    border: 0px;
  }

  /* Extra small devices (phones, 600px and down) */
  @media(max-width: 600px) {
    .mob.scrollbar {
      display: block;
      margin-left: 30px;
      float: left;
      height: 300px;
      width: 555px;
      background: #F5F5F5;
      overflow-y: scroll;
      margin-bottom: 25px;
    }
  }
</style>

<!-- start of Page Content-->  
<div class="page-content header-clear-medium">
  <div class="card card-style font-900 shadow-s border-yellow-dark bg-yellow-light mb-2">
    <div class="content m-1">
      <div class="text-center">
        <p class="m-0 p-0">Attendance Report For: <?=date('Y')?> - <?=date('F')?></p>
      </div>
    </div>
  </div>
   
  <div class="content mt-0">
    <table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden; font-size: 11px !important; zoom: 90% !important;">
      <thead>
        <tr class="bg-night-light1" style="text-wrap: nowrap;">
          <th scope="col" class="color-white">Date</th>
          <th scope="col" class="color-white">Day</th>
          <th scope="col" class="color-white">In Time</th>
          <th scope="col" class="color-white">Out Time</th>
          <th scope="col" class="color-white">Schedule</th>
          <th scope="col" class="color-white">Diff K.M</th>
        </tr>
      </thead>

      <tbody class="tbody1">
<?php 
// Previous code remains the same up until the table body generation

// Inside the tbody section, modify the attendance status checking logic:

$month_end = strtotime('last day of this month', time());
$end_day = date('t'); // Gets the number of days in the current month
$today = date('Y-m-d'); // Get current date for future date comparison

for($i=1; $i<=$end_day; $i++) {
    // Format date with leading zeros for single-digit days
    $day_formatted = str_pad($i, 2, '0', STR_PAD_LEFT);
    $date = date('Y').'-'.date('m').'-'.$day_formatted;
    $off_day = date('D', strtotime($date));
    
    // Check if the date is in the future
    $is_future_date = ($date > $today);
    
    // REVISED: Check for holidays, leaves, and attendance status in proper order
    $holy_day = find_a_field('salary_holy_day', 'holy_day', 'holy_day="'.$date.'"');
    $leave_days = find_a_field('hrm_leave_info', 's_date', 's_date="'.$date.'" AND emp_id="'.$PBI_ID.'"'); // Added emp_id check
    $leave = find_a_field('hrm_att_summary', 'att_date', 'emp_id="'.$PBI_ID.'" and att_date="'.$date.'" and leave_id>0 group by att_date');
    $day_off_s = find_a_field('salary_holy_day_individual', 'holy_day', 'reason="Off day" and PBI_ID="'.$PBI_ID.'" and holy_day="'.$date.'"');
    
    // Get attendance times
    $in_time = find_a_field('hrm_attdump', 'min(xtime)', 'xenrollid="'.$PBI_ID.'" and xdate="'.$date.'" group by xdate');
    $out_time = find_a_field('hrm_attdump', 'max(xtime)', 'xenrollid="'.$PBI_ID.'" and xdate="'.$date.'" group by xdate');
    
    // Initialize location variables
    $in_latitute = '';
    $in_longitude = '';
    $out_latitute = '';
    $out_longitude = '';
    $sac_lt = '';
    $sac_lo = '';
    
    // Get location data if attendance exists
    if(!empty($in_time)) {
        $in_latitute = find_a_field('hrm_attdump', 'latitude', 'xenrollid="'.$PBI_ID.'" and xdate="'.$date.'" and xtime="'.$in_time.'"'); 
        $in_longitude = find_a_field('hrm_attdump', 'longitude', 'xenrollid="'.$PBI_ID.'" and xdate="'.$date.'" and xtime="'.$in_time.'"');
        $sac_lt = find_a_field('hrm_attdump', 'sch_latitude_point', 'xenrollid="'.$PBI_ID.'" and xdate="'.$date.'" and xtime="'.$in_time.'"');
        $sac_lo = find_a_field('hrm_attdump', 'sch_longitude_point', 'xenrollid="'.$PBI_ID.'" and xdate="'.$date.'" and xtime="'.$in_time.'"');  
    }
    
    if(!empty($out_time)) {
        $out_latitute = find_a_field('hrm_attdump', 'latitude', 'xenrollid="'.$PBI_ID.'" and xdate="'.$date.'" and xtime="'.$out_time.'"');
        $out_longitude = find_a_field('hrm_attdump', 'longitude', 'xenrollid="'.$PBI_ID.'" and xdate="'.$date.'" and xtime="'.$out_time.'"');
    }
?>
<tr>
  <td style="text-wrap: nowrap;"><?=$date?></td>
  <td style="text-wrap: nowrap;">
    <?php
    if($off_day=='Fri') { 
        echo '<button class="btn-new btn-warning2 font">'.$off_day.'</button>';
    } else { 
        echo '<button class="btn-new btn-primary1 font">'.$off_day.'</button>'; 
    }
    ?>
  </td>

  <td style="text-wrap: nowrap;">
    <?php 
    if($in_time != '') { 
        echo date("h:i a", strtotime($in_time));
    } else { 
        // Check for future dates first, then other statuses
        if ($is_future_date) {
            echo '<button class="btn-new btn-secondary font">Upcoming</button>';
        } elseif (!empty($holy_day)) {
            echo '<button class="btn-new btn-info1 font">Holiday</button>';
        } elseif ($off_day == 'Fri' || !empty($day_off_s)) {
            echo '<button class="btn-new btn-success1 font">Off Day</button>';
        } elseif ($leave > 0 || !empty($leave_days)) {
            echo '<button class="btn-new btn-secondary font">Leave</button>';
        } else {
            echo '<button class="btn-new btn-danger1 font">Absent</button>';
        }
    }
    ?>
    <br />
    <?php 
    if(!empty($in_latitute) && !empty($in_longitude)) {
    ?>
    <a href="https://www.latlong.net/c/?lat=<?=$in_latitute?>&long=<?=$in_longitude?>" target="_blank">
      <button class="btn-new btn-warning1 font">view</button>
    </a>
    <?php } ?>
  </td>

  <td style="text-wrap: nowrap;">
    <?php
    if($out_time != '') {  
        echo date("h:i a", strtotime($out_time));
    } else { 
        // Check for future dates first, then other statuses
        if ($is_future_date) {
            echo '<button class="btn-new btn-secondary font">Upcoming</button>';
        } elseif (!empty($holy_day)) {
            echo '<button class="btn-new btn-info1 font">Holiday</button>';
        } elseif ($off_day == 'Fri' || !empty($day_off_s)) {
            echo '<button class="btn-new btn-success1 font">Off Day</button>';
        } elseif ($leave > 0 || !empty($leave_days)) {
            echo '<button class="btn-new btn-secondary font">Leave</button>';
        } else {
            echo '<button class="btn-new btn-danger1 font">Absent</button>';
        }
    }
    ?>
    <br />
    <?php
    if(!empty($out_latitute) && !empty($out_longitude)) {
    ?>
    <a href="https://www.latlong.net/c/?lat=<?=$out_latitute?>&long=<?=$out_longitude?>" target="_blank">
      <button class="btn-new btn-warning1 font">view</button>
    </a>
    <?php } ?>
  </td>

  <td>
    <?php
    if(!empty($in_time)) {
        echo find_a_field('hrm_attdump', 'schedule_notes', 'xenrollid="'.$PBI_ID.'" and xdate="'.$date.'" and xtime="'.$in_time.'"');
    }
    ?>
  </td>

  <td>
    <?php
    $distance = distance($sac_lt, $sac_lo, $in_latitute, $in_longitude, "K");
    
    // Display distance or message
    if (is_numeric($distance)) {
        echo number_format($distance, 2); // Format to 2 decimal places if it's a number
    } else {
        echo $distance; // Display the message returned from the function
    }
    ?>
  </td>
</tr>
<?php } ?>
			
      </tbody>

      <tfoot>
        <tr class="bg-night-light1" style="text-wrap: nowrap;">
          <th>Date</th>
          <th>Day</th>
          <th>In Time</th>
          <th>Out Time</th>
          <th>Schedule</th>
          <th>Diff K.M</th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<!-- End of Page Content--> 

<?php 
require_once '../assets/template/inc.footer.php';
?>