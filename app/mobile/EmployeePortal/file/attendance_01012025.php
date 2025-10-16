<?php 
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

$title = "Submit Attendance";
$page = "attendance.php";


require_once '../assets/template/inc.header.php';

$u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);


$username	= $PBI_ID; //$_SESSION['user_id'];

$show = find_a_field('user_activity_management', 'username, fname', 'user_id="'.$username.'"');


$ip = $_SERVER['REMOTE_ADDR'];




$check_intime = find_a_field('ss_location_log', 'access_time', "access_date='".date('Y-m-d')."' AND user_id='".$username."' AND attendance_type='IN TIME'");


$check_outtime = find_a_field("ss_location_log", "access_time", "access_date='".date('Y-m-d')."' AND user_id='".$username."' AND attendance_type='OUT TIME'");









if(isset($_REQUEST['in_time'])){

    $_POST['attendance_type']='IN TIME';

    if($_POST['user_id']>0){

	$time = date('H:i:s');

   //$insert_id=@insert('hrm_attdump');
   

  

    $sql = 'insert into hrm_attdump(`ztime`,`bizid`,`EMP_CODE`,`xenrollid`,`time`,`xtime`,`xdate`,`xlocationid`,`latitude`,`longitude`,`schedule_notes`,`sch_latitude_point`,`sch_longitude_point`) 
  value("'.date('Y-m-d H:i:s').'","'.$PBI_ID.'","'.$PBI_ID.'","'.$PBI_ID.'","'.$time.'","'.date('Y-m-d H:i:s').'","'.date('Y-m-d').'","999","'.$_POST['latitude'].'","'.$_POST['longitude'].'",
  "'.$_POST['schedule_notes'].'" , "'.$_POST['sch_latitude_point'].'", "'.$_POST['sch_longitude_point'].'")';

    $insert = $conn->query($sql);

	$insert_id = $conn->insert_id;

	//db_query($conn,$insert);

	 $img = $_POST['image'];

	$folderPath = "files/att/";

    $image_parts = explode(";base64,", $img);

    $image_type_aux = explode("image/", $image_parts[0]);

    $image_type = $image_type_aux[1];



    $image_base64 = base64_decode($image_parts[1]);

    $fileName = $insert_id.'.png';



    $file = $folderPath . $fileName;

    file_put_contents($file, $image_base64);

    

    $msg="Attendance In time insert successfully";

    redirect2("att_location_report.php");
	


	}

}











if(isset($_REQUEST['out_time'])){

$_POST['attendance_type']='OUT TIME';

    if($_POST['user_id']>0){

    //$insert_id=@insert('hrm_attdump');

	 $insert = 'insert into hrm_attdump (`ztime`,`bizid`,`EMP_CODE`,`time`,`xtime`,`xdate`,`xlocationid`,`latitude`,`longitude`,`schedule_notes`,`sch_latitude_point`,`sch_longitude_point`) 
	value("'.date('Y-m-d H:i:s').'","'.$PBI_ID.'","'.$PBI_ID.'","'.$time.'","'.date('Y-m-d').'","'.date('Y-m-d').'","999","'.$_POST['latitude'].'","'.$_POST['longitude'].'",
	"'.$_POST['schedule_notes'].'" , "'.$_POST['sch_latitude_point'].'", "'.$_POST['sch_longitude_point'].'")';
	
	
	
	

  
  

	db_query($conn,$insert);

	$img = $_POST['image'];

	$folderPath = "files/att/";

    $image_parts = explode(";base64,", $img);

    $image_type_aux = explode("image/", $image_parts[0]);

    $image_type = $image_type_aux[1];



    $image_base64 = base64_decode($image_parts[1]);

    $fileName = '10.png';



    $file = $folderPath . $fileName;

    file_put_contents($file, $image_base64);



$msg="Attendance Out time insert successfully";

redirect2("attendance.php");

}

}










?>


    

<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
   
   

        
		
		
		

        <div class="card card-style">
		<h4 class="p-3 text-center">Submit Attendance</h4>
		<?php /*?><?php if(isset($_GET['edit_id'])){ ?> <a class="btn btn-primary" href="?" role="button">New Entry</a> <? } ?>

<?php if(isset($msg)){ ?><div class="alert alert-primary msg" role="alert"><?php echo @$msg; ?></div><?php } ?>

<?php if(isset($emsg)){ ?><div class="alert alert-danger emsg" role="alert"><?php echo @$emsg; ?></div><?php } ?><?php */?>

     <? if($msg){ ?>

        <div class="alert alert-info" role="alert">

          <?=$msg?>

        </div>

        <? } ?>

        <? if($msg2){ ?>

        <div class="alert alert-danger" role="alert">

          <?=$msg2?>

        </div>

        <? } ?>
		
			<form action=""  method="post" id="demo" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
				<div class="content">
				


         <div class="row">

            <div class="col-md-6 col-xs-6 text-center">

                <div id="my_camera" style="margin: 0 auto;"></div>

                <br/>

                <!-- <input type="button" class="btn btn-success btn-xs"  value="Take Picture" onClick="take_snapshot()"> -->

                <input type="hidden" name="image" class="image-tag">

            </div>

            <div class="col-md-6 col-xs-6 text-center">

                <div id="results"></div>

            </div>

        

        </div>
					
					
						<?   
		$roster = find_all_field('hrm_roster_allocation','','PBI_ID="'.$PBI_ID.'" and roster_date="'.date("Y-m-d").'"');
		
		$roster_point = find_all_field('hrm_roster_point','','id="'.$roster->point_1.'"');
		
		?>  
					
					<div class="input-style has-borders no-icon mb-4">
						<textarea name="schedule_notes" value="<?=$roster_point->point_short_name?>" placeholder="Enter your message"></textarea>
						<label for="form7" class="color-highlight">Enter your Schedule Notes</label>
						<em class="mt-n3">(required)</em>
					</div>
				<input type="hidden" name="access_date" id="access_date"  value="<?=date('Y-m-d')?>">

				<input type="hidden" name="access_time" id="access_time"  value="<?=date('Y-m-d H:i:s')?>">

				

				<input type="hidden" name="user_id" id="user_id"  value="<?=$username;?>">

				<input type="hidden" name="ip" id="ip"  value="<?=$ip;?>">

				<input type="hidden" name="latitude" id="latitude"  value="">

				<input type="hidden" name="longitude" id="longitude"  value="">
					
					<div class="d-flex justify-content-center row">
						<div class="col-6">
							<input class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light w-100" type="submit" value="PUNCH" onClick="take_snapshot()" name="in_time">
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
 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

<script>

var x = document.getElementById("demo");





window.onload = function() {

    if (navigator.geolocation) {

    navigator.geolocation.getCurrentPosition(showPosition,showError);

  } else { 

    x.innerHTML = "Geolocation is not supported by this browser.";

  }

}



// function getLocation() {

//   if (navigator.geolocation) {

//     navigator.geolocation.getCurrentPosition(showPosition);

//   } else { 

//     x.innerHTML = "Geolocation is not supported by this browser.";

//   }

// }



function showPosition(position) {

  // x.innerHTML = "Latitude: " + position.coords.latitude + 

  // "<br>Longitude: " + position.coords.longitude;





  document.getElementById("latitude").value=position.coords.latitude;

  document.getElementById("longitude").value=position.coords.longitude;



  

}





function showError(error) {

  switch(error.code) {

    case error.PERMISSION_DENIED:

      x.innerHTML = "<span style='color: red; font-weight: bold;'>User denied the request for Geolocation. Please Activate your location from your device and reload this page again.</span>";

      document.getElementById("error_detection").value=1;

      document.getElementById("submitit").disabled = true;

      break;

    case error.POSITION_UNAVAILABLE:

      x.innerHTML = "<span style='color: red; font-weight: bold;'>Location information is unavailable. Please relaod this page again.</span>";

      document.getElementById("error_detection").value=1;

      document.getElementById("submitit").disabled = true;

      break;

    case error.TIMEOUT:

      x.innerHTML = "<span style='color: red; font-weight: bold;'>The request to get user location timed out. Please relaod this page again.</span>";

      document.getElementById("error_detection").value=1;

      document.getElementById("submitit").disabled = true;

      break;

    case error.UNKNOWN_ERROR:

      x.innerHTML = "<span style='color: red; font-weight: bold;'>An unknown error occurred. Please relaod this page again.</span>";

      document.getElementById("error_detection").value=1;

      document.getElementById("submitit").disabled = true;

      break;

  }

}

</script>

<script language="JavaScript">

    Webcam.set({

        width: 250,

        height: 250,

        image_format: 'jpeg',

        jpeg_quality: 90

    });

  

    Webcam.attach( '#my_camera' );

  

    function take_snapshot() {

        Webcam.snap( function(data_uri) {

            $(".image-tag").val(data_uri);

            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';

        } );

    }





    navigator.getUserMedia({video: true}, function (stream) {

     if (stream.getVideoTracks().length > 0 ) {

         //code for when none of the devices are available   

        //  document.getElementById("submitit").disabled = true;                     

     } else {

         document.getElementById("submitit").disabled = true; 

         x.innerHTML = "<span style='color: red; font-weight: bold;'>Please Allow Camera and Audio Access. Then please relaod this page again.</span>";

     }

}, function (error) { 

   // code for when there is an error

   document.getElementById("submitit").disabled = true;

   x.innerHTML = "<span style='color: red; font-weight: bold;'>Please Allow Camera and Audio Access. Then please relaod this page again.</span>";

});

</script>