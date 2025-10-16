<?php 
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

// ini_set('display_errors','1');
// ini_set('display_startup_errors','1');
// error_reporting(E_ALL);

$title = "Daily Attendance";
$page = "daily_attendance.php";


require_once '../assets/template/inc.header.php';

date_default_timezone_set('Asia/Dhaka');
$title='Attendance Operation';
date("Y-m-d H:i:s");


$username	=$_SESSION['user']['username'];
$show       =findall('select username,fname from ss_user where username="'.$username.'"');
$ip = $_SERVER['REMOTE_ADDR'];



$in_info = findall("select * from ss_location_log where access_date='".date('Y-m-d')."' and user_id='".$username."' and attendance_type='IN TIME'");
$out_info = findall("select * from ss_location_log where access_date='".date('Y-m-d')."' and user_id='".$username."' and attendance_type='OUT TIME'");

$check_intime = $in_info->access_time;
$check_outtime= $out_info->access_time;

$sql_job_location = 'SELECT jl.* FROM job_location_schedule jls JOIN job_location jl ON jls.job_location_id = jl.id WHERE jls.employe_id = "'.$username.'"
AND jls.date = CURDATE()';
$query_job_location = mysqli_query($conn, $sql_job_location);
$info_job_location=mysqli_fetch_object($query_job_location);

function haversineDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo) {
    $earthRadius = 6371; 

    
    $latFrom = deg2rad((float) $latitudeFrom);
    $lonFrom = deg2rad((float) $longitudeFrom);
    $latTo = deg2rad((float) $latitudeTo);
    $lonTo = deg2rad((float) $longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $a = pow(sin($latDelta / 2), 2) +
         cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2);
    $c = 2 * asin(sqrt($a));

    return $earthRadius * $c;
}





if (isset($_REQUEST['in_time'])) {
   

/*    if ($info_job_location) {*/
 
        $latitude = $_POST['latitude'];
        
       
       $longitude = $_POST['longitude'];
        
        $latitudeJobLocation = $info_job_location->latitude;
      
        $longitudeJobLocation = $info_job_location->longitude;
       
        $range = $info_job_location->distance_range;
   
        $range=$range/1000;
   
         $distance = haversineDistance($latitude, $longitude, $latitudeJobLocation, $longitudeJobLocation);
        
       // if ($distance <= $range) {
          if($_POST['latitude'] != '' &&  $_POST['longitude'] != ''){
            $_POST['type'] = 'Attendance';
            $_POST['attendance_type'] = 'IN TIME';
            $_POST['shop_name'] = find1("SELECT shop_name FROM ss_shop WHERE dealer_code = '".$_POST['shop_id']."'");

            
            @insert('ss_location_log');

            $msg = "Attendance In time insert successfully";
            redirect2("daily_attendance.php");
          }else{
            $msg = "Location is not found please try again";

          }
       // } else {
//            
//            
//            $msg = "Location is not within the allowed range.";
//         
//        }
   // } else {
//        $msg = "No job location found for today.Please ask your adminstrator";
//        
//        
//    }
}





if(isset($_REQUEST['out_time'])){
$_POST['type']='Attendance';
$_POST['attendance_type']='OUT TIME';
$shop_info =findall("select * from ss_shop where dealer_code='".$_POST['shop_id']."'");
$_POST['shop_name']     =$shop_info->shop_name;
$_POST['shop_address']  =$shop_info->shop_address;

@insert('ss_location_log');

$msg="Attendance Out time insert successfully";
redirect2("daily_attendance.php");
}




?>
    

<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
   
   

    
		
		
		

        <div class="card card-style">
			<form action="" enctype="multipart/form-data" method="post" name="" id="demo" >
				<div class="content">
					<h4 id="demo" class="text-center mb-3">Please press the button for putting your attendance.</h4>
					
					   <? if(isset($msg)) { ?>



        <div class="alert alert-info" role="alert">



          <?=$msg?>



        </div>



        <? } ?>



		
		<? if(isset($msg2)) { ?>



        <div class="alert alert-danger" role="alert">



          <?=$msg2?>



        </div>



        <? } ?>
		

		
		
		<input type="hidden" name="xtime" value="<?=date("Y-m-d H:i:s")?>">



        <input  type="hidden"   name="xdate" value="<?=date("Y-m-d")?>">
		
	

					<div class="input-style has-borders no-icon mb-4">
						<textarea id="schedule_notes" name="schedule_notes" placeholder="Enter your message"><?=$roster_point->point_short_name?></textarea>
						<input type="hidden" name="access_date" id="access_date"  value="<?=date('Y-m-d')?>">
						<input type="hidden" name="access_time" id="access_time"  value="<?=date('Y-m-d H:i:s')?>">
						
						<input type="hidden" name="user_id" id="user_id"  value="<?=$username;?>">
						<input type="hidden" name="ip" id="ip"  value="<?=$ip;?>">
						
						<input type="hidden" name="latitude" id="latitude"  value="">
						<input type="hidden" name="longitude" id="longitude"  value="">
							   <?
				   
					 $sql_job_location = 'SELECT jl.*
						FROM job_location_schedule jls
						JOIN job_location jl ON jls.job_location_id = jl.id
						WHERE jls.employe_id = "'.$username.'"
						AND jls.date = CURDATE()';
						$query_job_location = mysqli_query($conn, $sql_job_location);
						$info_job_location=mysqli_fetch_object($query_job_location);?>
						<input type="hidden" name="latitude_job_location" id="latitude_job_location"  value="<?=$info_job_location->latitude?>">
						<input type="hidden" name="longitude_job_location" id="longitude_job_location"  value="<?= $info_job_location->longitude?>">
				   
				   <? ?>

       					 <input type="hidden" name="error_detection" id="error_detection" class="form-control" required value="0" /><input type="hidden" name="sch_longitude_point  id="sch_longitude_point" class="form-control"  value="<?=$roster_point->longitude_point?>"  readonly/> <br>
		
						<label for="form7" class="color-highlight">Enter your Message</label>
						<em class="mt-n3">(required)</em>
					</div>
					
            <div class="d-flex justify-content-center row">
              <div class="col-6 ">
              <? if($check_intime!=''){ }else{ ?>
                <input class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light w-100"  type="submit" name="in_time" onClick="take_snapshot()" id="submitit" value="In Punch" ">
                <?}?>
                <? if($check_outtime=='' && $check_intime!=''){ ?>
                <input class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light w-100"  type="submit" name="out_time" onClick="take_snapshot()" id="submitit" value="Out Punch" ">

                <?}?>
              </div>
            </div>
				</div>
				
			</form>
            </div>
			
			
			
			
			
			
			
			
			
			
        </div>
    <!-- End of Page Content--> 
    
    











<?php 
 require_once '../assets/template/inc.footer.php';
 ?>
 

<script>
      
        
        function getLocation(){
            
            if (navigator.geolocation)
            {
            navigator.geolocation.getCurrentPosition(showPosition);
           
                
            }
        }
        
        
        function showPosition(position){
 
        
        var latitude  = position.coords.latitude;
        var longitude  = position.coords.longitude;
        
        document.getElementById("latitude").value = latitude; 
        document.getElementById("longitude").value = longitude; 
            
        }
        document.body.onload = function(){
        getLocation();
        };
        

</script>