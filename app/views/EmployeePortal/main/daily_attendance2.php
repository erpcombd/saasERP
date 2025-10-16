<?php


	
	
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
include '../config/access.php';
//include 'config/db.php';
//include '../config/function.php';
$page ="attendance";
include "../inc/header.php";
date_default_timezone_set('Asia/Dhaka');
$title='Attendance Operation';
date("Y-m-d H:i:s");


//$u_id= $_SESSION['user_id'];

$u_id  =  $_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
if(isset($_POST['submitit'])){


if($_POST['latitude']!='' && $_POST['longitude']!=''){

$img = $_POST['image'];
$time = date('H:i:s');

 $query = 'insert into hrm_attdump(`ztime`,`bizid`,`EMP_CODE`,`xenrollid`,`time`,`xtime`,`xdate`,`xlocationid`,`latitude`,`longitude`,`schedule_notes`,`sch_latitude_point`,`sch_longitude_point`)

    value("'.date('Y-m-d H:i:s').'","'.$PBI_ID.'","'.$PBI_ID.'","'.$PBI_ID.'","'.$time.'","'.date('Y-m-d H:i:s').'","'.date('Y-m-d').'",

    "999","'.$_POST['latitude'].'","'.$_POST['longitude'].'", "'.$_POST['schedule_notes'].'" , "'.$_POST['sch_latitude_point'].'", "'.$_POST['sch_longitude_point'].'")';
	
	
// Assuming $query contains the SQL query string
if (!empty($query)) {
    
$insert = $conn->query($query);
$insert_id = $conn->insert_id;
db_query($insert);
$xid = db_insert_id();


    //$result = mysqli_query($conn, $query);
	
   
} else {
   
    echo "Error: Empty query string.";
   
}


 
 
 



// ===================================Image Upload Operation Start From Here =================================
$folderPath = "../../../../attandance_image/";
$image_parts = explode(";base64,", $img);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$fileName = $xid.'.png';
$file = $folderPath . $fileName;
echo file_put_contents($file, $image_base64);
// ===================================Image Upload Operation Start From Here =================================
$msg = 'Thank You. Successfully Inserted Your Daily Attendance!!';

//redirect2("att_location_report.php");

header("Location:att_location_report.php");


//   }else{
//   $msg2 = 'Please click on "Take Picture" and then click on "PRESS" again.';
//   }
}else{
$msg2 = 'Something is went worng!!';
}}



?>






<style>
  .openerp img{
    width: 100%;
  }

  .mob.scrollbar{
  display:none;
  }


  /* Extra small devices (phones, 600px and down) */
@media(max-width: 600px) {
  .mob.scrollbar{
  	display:block;
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






<style>
#preloader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #fff;
  z-index: 9999;
}

.loading {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.loading img {
  width: 100px;
  height: 100px;
}
</style>



<script>
setTimeout(function() {
    document.getElementById("preloader").style.display = "none";
}, 2000);

</script>





<!--
onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}"-->

<form action=""  enctype="multipart/form-data" method="post" name="codz" id="codz" >



  
<div id="preloader">
  <div class="loading">
    <img src="loading-gif.gif" alt="Loading...">
  </div>
</div>




<div class="row m-0 p-0">



<!--<div class="col-md-4"> -->



  



<!--  <div class="card">-->



<!--  <div class="card-body">-->



<!--   <div id="my_camera"></div>-->



<!--            <br/>-->



            <!-- <input type="button" class="btn btn-success btn-xs"  value="Take Picture" onClick="take_snapshot()"> -->



<!--            <input type="hidden" name="image" class="image-tag">-->



<!--	</div>-->



<!--	</div>-->



  



<!--  </div>-->



  



  



  



  



 <!-- <div class="col-md-4"> -->



  



 <!-- <div class="card">-->



 <!-- <div class="card-body">-->



 <!--   <div id="results"><?=$ms?>tt Your image will appear here...</div>-->



	<!--</div>-->



	<!--</div>-->



  



 <!-- </div>-->



  





  



  



   <div class="col-md-4" style="margin: 0 auto;">



  



  <div class="card">



  <div class="card-body">



   



    <p id="demo" style="text-align: center;  Font-weight: bold;" class="alert alert-primary">Please press the button for putting your attendance. </p>



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
		
		<?   
		$roster = find_all_field('hrm_roster_allocation','','PBI_ID="'.$PBI_ID.'" and roster_date="'.date("Y-m-d").'"');
		
		//$roster_point = find_all_field('hrm_roster_point','','id="'.$roster->point_1.'"');
		
		if($roster && isset($roster->point_1)) { 
			$roster_point = find_all_field('hrm_roster_point', '', 'id="' . $roster->point_1 . '"');
		}

		
		?>  
		
		
		
	
		  

       



        <input type="hidden" name="xtime" value="<?=date("Y-m-d H:i:s")?>">



        <input  type="hidden"   name="xdate" value="<?=date("Y-m-d")?>">
		
		<label for="schedule_notes"> Schedule Notes :</label>
		<!--<input  type="text" class="form-control"  name="schedule_notes" value="<? //=$roster_point->point_short_name?>">-->
		
		<textarea class="form-control" id="schedule_notes" name="schedule_notes" style="height: 120px; background-color: whitesmoke;"><?=$roster_point->point_short_name?></textarea>
		
		<input type="hidden" name="sch_latitude_point" id="sch_latitude_point" class="form-control"  value="<?=$roster_point->latitude_point?>" readonly/>
        <input type="hidden" name="sch_longitude_point" id="sch_longitude_point" class="form-control"  value="<?=$roster_point->longitude_point?>"  readonly/> <br>
		

      <!--  <textarea class="form-control" id="adresssss" style="height: 120px; background-color: whitesmoke;"></textarea>-->
		
		
	
  

        <input type="hidden" name="latitude" id="latitude" class="form-control" required value="<?=$_POST['latitude']?>" readonly/>
        <input type="hidden" name="longitude" id="longitude" class="form-control" required value="<?=$_POST['longitude']?>"  readonly/>



        <input type="hidden" name="error_detection" id="error_detection" class="form-control" required value="0" />



        <br>



        <div class="form-group" style="text-align:center">



      <input class="btn btn-danger" type="submit" name="submitit" onClick="take_snapshot()" id="submitit" style="height: 100px; width: 100px; color:#FFFFFF; border-radius: 50%;" value="PRESS" />
		  
	



        </div>



        <br>


	</div>


	</div>

  </div>


	 </div>  



	  



   



  </form>







<?php //include "../inc/footer.php"; ?>






<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script>


var x = document.getElementById("demo");
window.onload = function() {
if (navigator.geolocation) {
navigator.geolocation.getCurrentPosition(showPosition,showError);
} else { 
x.innerHTML = "Geolocation is not supported by this browser.";
}}

function showPosition(position) {
document.getElementById("latitude").value=position.coords.latitude;
document.getElementById("longitude").value=position.coords.longitude;

var latlng = position.coords.latitude+","+position.coords.longitude;
var url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyAKYGY2-qCVcd9EdlPJCcSvawTOReYGJew&latlng="+position.coords.latitude+","+position.coords.longitude+"&sensor=true";
$.getJSON(url, function (data) {
document.getElementById("adresssss").value=data.results[0].formatted_address;
});


}











function showError(error) {



  switch(error.code) {



    case error.PERMISSION_DENIED:



      x.innerHTML = "<span style='color: red; font-weight: bold;'>User denied the request for Geolocation. Please Activate your location from your device and reload this page again.</span>";



      document.getElementById("error_detection").value=1;



      document.getElementById("submitit").disabled = true;



      break;



    case error.POSITION_UNAVAILABLE:



      x.innerHTML = "<span style='color: red; font-weight: bold;' class='alert alert-danger'>Location information is unavailable. Please relaod this page again.</span>";



      document.getElementById("error_detection").value=1;



      document.getElementById("submitit").disabled = true;



      break;



    case error.TIMEOUT:



      x.innerHTML = "<span style='color: red; font-weight: bold;' class='alert alert-danger'>The request to get user location timed out. Please relaod this page again.</span>";



      document.getElementById("error_detection").value=1;



      document.getElementById("submitit").disabled = true;



      break;



    case error.UNKNOWN_ERROR:



      x.innerHTML = "<span style='color: red; font-weight: bold;' class='alert alert-danger'>An unknown error occurred. Please relaod this page again.</span>";





      document.getElementById("error_detection").value=1;



      document.getElementById("submitit").disabled = true;



      break;


}
}

</script>






<?php include "../inc/footer.php"; ?>

<!--<script language="JavaScript">-->



<!--    Webcam.set({-->



<!--        width: 250,-->



<!--        height: 250,-->



<!--        image_format: 'jpeg',-->



<!--        jpeg_quality: 90-->



<!--    });-->





<!--    Webcam.attach( '#my_camera' );-->
<!--    function take_snapshot() {-->



<!--        Webcam.snap( function(data_uri) {-->



<!--            $(".image-tag").val(data_uri);-->



<!--            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';-->



<!--        } );-->



<!--    }-->



<!--    navigator.getUserMedia({video: true}, function (stream) {-->



<!--     if (stream.getVideoTracks().length > 0 ) {-->



         <!--//code for when none of the devices are available   -->



        <!--//  document.getElementById("submitit").disabled = true;                     -->



<!--     } else {-->



<!--         document.getElementById("submitit").disabled = true; -->



<!--         x.innerHTML = "<span style='color: red; font-weight: bold;'>Please Allow Camera and Audio Access. Then please relaod this page again.</span>";-->



<!--     }-->



<!--}, function (error) { -->



   <!--// code for when there is an error-->



<!--   document.getElementById("submitit").disabled = true;-->



<!--   x.innerHTML = "<span style='color: red; font-weight: bold;'>Please Allow Camera and Audio Access. Then please relaod this page again.</span>";-->



<!--});-->



<!--</script>-->



