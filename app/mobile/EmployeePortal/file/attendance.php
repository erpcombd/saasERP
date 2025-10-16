<?php 
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

$title = "Submit Attendance";
$page = "attendance.php";


require_once '../assets/template/inc.header.php';

$u_id= $_SESSION['user']['user_id']; 
// $PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$PBI_ID=$_SESSION['user']['username'];
$username	= $PBI_ID; 

$show       =find_all_field('user_activity_management','','user_id="'.$username.'"');

$ip = $_SERVER['REMOTE_ADDR'];







$check_intime = find_a_field('ss_location_log','access_time','access_date="'.date('Y-m-d').'" and user_id="'.$username.'" and attendance_type="IN TIME"');

$check_outtime = find_a_field('ss_location_log','access_time','access_date="'.date('Y-m-d').'" and user_id="'.$username.'" and attendance_type="OUT TIME"');

//$check_outtime = find1("select access_time from ss_location_log where access_date='".date('Y-m-d')."' and user_id='".$username."' and attendance_type='OUT TIME'");









if(isset($_REQUEST['in_time'])){

    $_POST['attendance_type']='IN TIME';

    if($_POST['user_id']>0){

	$time = date('H:i:s');


   

  

    $sql = 'insert into hrm_attdump(`ztime`,`bizid`,`EMP_CODE`,`xenrollid`,`time`,`xtime`,`xdate`,`xlocationid`,`latitude`,`longitude`,`schedule_notes`,`sch_latitude_point`,`sch_longitude_point`) 
  value("'.date('Y-m-d H:i:s').'","'.$PBI_ID.'","'.$PBI_ID.'","'.$PBI_ID.'","'.$time.'","'.date('Y-m-d H:i:s').'","'.date('Y-m-d').'","999","'.$_POST['latitude'].'","'.$_POST['longitude'].'",
  "'.$_POST['schedule_notes'].'" , "'.$_POST['sch_latitude_point'].'", "'.$_POST['sch_longitude_point'].'")';

    $insert = $conn->query($sql);

	$insert_id = $conn->insert_id;

	

        // Process and save the captured image
        $img = $_POST['image']; // Base64 image data
        $folderPath = "uploads/attendance_pic/"; // Folder to save images

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = time() . '.png'; // Generate a unique filename using timestamp
        $file = $folderPath . $fileName;

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0775, true); // Create the folder if it doesn't exist
        }

        file_put_contents($file, $image_base64);

    

    $msg="Attendance In time insert successfully";

    // redirect2("att_location_report.php");
	


	}

}











if(isset($_REQUEST['out_time'])){

$_POST['attendance_type']='OUT TIME';

    if($_POST['user_id']>0){

  

	 $insert = 'insert into hrm_attdump (`ztime`,`bizid`,`EMP_CODE`,`time`,`xtime`,`xdate`,`xlocationid`,`latitude`,`longitude`,`schedule_notes`,`sch_latitude_point`,`sch_longitude_point`) 
	value("'.date('Y-m-d H:i:s').'","'.$PBI_ID.'","'.$PBI_ID.'","'.$time.'","'.date('Y-m-d').'","'.date('Y-m-d').'","999","'.$_POST['latitude'].'","'.$_POST['longitude'].'",
	"'.$_POST['schedule_notes'].'" , "'.$_POST['sch_latitude_point'].'", "'.$_POST['sch_longitude_point'].'")';
	
	


  
  

	mysql_query($conn,$insert);
		$insert2 = 'insert into ss_location_log (`access_time`,`user_id`,`access_date`) 
	value("'.date('Y-m-d H:i:s').'","'.$PBI_ID.'","'.date('Y-m-d').'")';
	mysql_query($conn,$insert2);	

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
		
			<form id="attendance_form" action=""  method="post" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
				<div class="content">
				


         <div class="row">

            <div class="col-md-6 col-xs-6 text-center">

                <div id="my_camera" style="margin: 0 auto;"></div>

                <br/>



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
                <input type="hidden" name="in_time" value="1">
					
					<div class="d-flex justify-content-center row">
						<div class="col-6">
						  <input type="button" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light w-100" value="punch"  name="in_time" onClick="captureAndSubmit(event)"> 
							<!--<input class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light w-100" type="submit" value="punch"  name="in_time">-->
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






function showPosition(position) {







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

  function captureAndSubmit(event) {
    event.preventDefault(); // Prevent the default form submission

    // Take the snapshot
    take_snapshot();

    // Allow time for the snapshot to complete
    setTimeout(function() {
        document.getElementById('attendance_form').submit(); // Submit the form programmatically
    }, 1000); // Adjust the delay if necessary
}

    function take_snapshot() {

        Webcam.snap( function(data_uri) {

            $(".image-tag").val(data_uri);

            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';

        } );

    }





    navigator.getUserMedia({video: true}, function (stream) {

     if (stream.getVideoTracks().length > 0 ) {

                           

     } else {

         document.getElementById("submitit").disabled = true; 

         x.innerHTML = "<span style='color: red; font-weight: bold;'>Please Allow Camera and Audio Access. Then please relaod this page again.</span>";

     }

}, function (error) { 



   document.getElementById("submitit").disabled = true;

   x.innerHTML = "<span style='color: red; font-weight: bold;'>Please Allow Camera and Audio Access. Then please relaod this page again.</span>";

});

</script>

