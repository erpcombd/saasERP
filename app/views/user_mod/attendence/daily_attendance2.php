<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
date_default_timezone_set('Asia/Dhaka');
$title='Attendance Operation';
 date("Y-m-d H:i:s");

$u_id=$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

if(isset($_POST['submitit'])){

if($_POST['latitude']!='' && $_POST['longitude']!=''){
  $distance = haversineDistance($_POST['latitude'],  $_POST['longitude'], 23.840419931321687, 90.3656383041611);
  if($distance<=50){

   $img = $_POST['image'];
  
  if($img!=''){










  $insert = 'insert into hrm_attdump set ztime="'.$_POST['xtime'].'",
  bizid="'.$PBI_ID.'",
  xenrollid="'.$PBI_ID.'",
  xdate="'.$_POST['xdate'].'",
  xtime="'.$_POST['xtime'].'",
  status="1",
  EMP_CODE="'.$PBI_ID.'",
  latitude="'.$_POST['latitude'].'",
  longitude="'.$_POST['longitude'].'"
  ';
  db_query($insert);

  $xid = db_insert_id();

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

  }else{
    
  $msg2 = 'Please click on "Take Picture" and then click on "PRESS" again.';
  }
}else{
  $msg2 = 'You are out of range From Head Office Please Submit your OD';
}


}else{
  $msg2 = 'Something is went worng!!';
}
 

}



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

  #my_camera, #my_camera video{
      position: inherit !important;
      width: 100% !important;
      height: 100% !important;
  }


</style>



<form action=""  enctype="multipart/form-data" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  
<div class="row">  
<div class="col-md-4"> 
  
  <div class="card">
  <div class="card-body">
   <div id="my_camera"></div>
            <br/>
            <!-- <input type="button" class="btn btn-success btn-xs"  value="Take Picture" onClick="take_snapshot()"> -->
            <input type="hidden" name="image" class="image-tag">
	</div>
	</div>
  
  </div>
  
  
  
  
  <div class="col-md-4"> 
  
  <div class="card">
  <div class="card-body">
    <div id="results">Your image will appear here...</div>
	</div>
	</div>
  
  </div>
  
  
  
   <div class="col-md-4"> 
  
  <div class="card">
  <div class="card-body">
  
    <p id="demo" style="text-align: center; Font-weight: bold;">Please press the button for putting your attendance. </p>
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
        <input type="hidden" name="xtime" value="<?=date("Y-m-d H:i:s")?>">
        <input  type="hidden"   name="xdate" value="<?=date("Y-m-d")?>">
        <input type="hidden" name="latitude" id="latitude" class="form-control" required value="<?=$_POST['latitude']?>"/>
        <input type="hidden" name="longitude" id="longitude" class="form-control" required value="<?=$_POST['longitude']?>"/>
        <input type="hidden" name="error_detection" id="error_detection" class="form-control" required value="0"/>
        <br>
        <div class="form-group" style="text-align:center">
          <input class="btn btn-danger" type="submit" name="submitit" onClick="take_snapshot()" id="submitit" style="height: 100px; width: 100px; border-radius: 50%;" value="PRESS" />
        </div>
        <br>
	
	</div>
	</div>
  
  </div>
	
   
            
       
	
	  
	
	 </div>  
	  
   
  </form>


















<div class="form-container_large">



  
  <div class="row m-0">
    <div class="col-md-12 p-0 mob">
        <h5 class="text-center bg-titel bold pt-2 pb-2">
            Attendance Statistics For :
            <?=date('Y')?>
            -
            <?=date('F')?>
        </h5>

      <table id="example" class="table1  table-striped table-bordered table-hover table-sm">
        <thead class="thead1">
          <tr class="bgc-info">
            <th width="15%">Name</th>
            <th width="15%">Date</th>
            <th width="10%">Day</th>
            <th width="10%">In Time</th>
            <th width="10%">In Time Location</th>
            <th width="10%">In Time Image</th>
            <th width="10%">Out Time</th>
            <th width="10%">Out Time Location</th>
            <th width="10%">Out Time Image</th>
          </tr>
        </thead>
        <tbody class="tbody1">
          <?
      $month_end = strtotime('last day of this month', time());

//  $end_day =  date('d', $month_end).'<br/>';
 $end_day =  31;

for($i=1;$i<=$end_day;$i++){

          ?>
          <tr>
            <td><?=find_a_field('user_activity_management','fname','user_id="'.$_SESSION['user']['id'].'"')?></td>
            <td><?=date('Y')?>
              -
              <?=date('m')?>
              -
              <?=$i?></td>
            <td><?
$date = date('Y').'-'.date('m').'-'.$i;
 $off_day =  date('D', strtotime($date));
 if($off_day=='Fri'){ echo '<span class="btn btn-warning btn-xs">'.date('l', strtotime($date)).'</span>';}else{ echo '<span class="btn btn-primary">'.date('l', strtotime($date)).'</span>'; }
?>
            </td>
            <td><? $in_time = find_a_field('hrm_attdump','min(ztime)','bizid="'.$PBI_ID.'" and xdate="'.$date.'" group by xdate'); if($in_time!=''){ echo $in_time;}else{ if($off_day=='Fri'){ echo '<span class="btn btn-success">Day Off</span>'; }else{ echo '<span class="btn btn-danger btn-xs">Absent</span>'; } }?></td>
            <td><? $in_latitute =  find_a_field('hrm_attdump','latitude','bizid="'.$PBI_ID.'" and xdate="'.$date.'" and ztime="'.$in_time.'"'); $in_longitude = find_a_field('hrm_attdump','longitude',
'bizid="'.$PBI_ID.'" and xdate="'.$date.'" and ztime="'.$in_time.'"'); if($in_latitute!='' && $in_longitude!=''){?>
              <a href="https://www.latlong.net/c/?lat=<?=$in_latitute?>&long=<?=$in_longitude?>" target="_blank" class="btn btn-warning">View</a>
              <? } ?></td>
            <td><?  $in_id = find_a_field('hrm_attdump','sl','bizid="'.$PBI_ID.'" and xdate="'.$date.'" and ztime="'.$in_time.'"'); $in_file_make = '../../../../attandance_image/'.$in_id.'.png'; if(file_exists($in_file_make)>0){ ?>
              <a href="<?=$in_file_make?>"  target="_blank" class="btn btn-info btn-xs">View</a>
              <? } ?></td>
            <td><? $out_time = find_a_field('hrm_attdump','max(ztime)','bizid="'.$PBI_ID.'" and xdate="'.$date.'" group by xdate'); if($out_time!=''){ echo $out_time;}else{ if($off_day=='Fri'){ echo '<span class="btn btn-success">Day Off</span>'; }else{ echo '<span class="btn btn-danger">Absent</span>'; } }?></td>
            <td><? $out_latitute =  find_a_field('hrm_attdump','latitude','bizid="'.$PBI_ID.'" and xdate="'.$date.'" and ztime="'.$out_time.'"'); $out_longitude = find_a_field('hrm_attdump','longitude',
'bizid="'.$PBI_ID.'" and xdate="'.$date.'" and ztime="'.$out_time.'"'); if($out_latitute!='' && $out_longitude!=''){?>
              <a href="https://www.latlong.net/c/?lat=<?=$out_latitute?>&long=<?=$out_longitude?>" target="_blank" class="btn btn-warning">View</a>
              <? } ?></td>
            <td><?  $out_id = find_a_field('hrm_attdump','sl','bizid="'.$PBI_ID.'" and xdate="'.$date.'" and ztime="'.$out_time.'"'); $out_file_make = '../../../../attandance_image/'.$out_id.'.png'; if(file_exists($out_file_make)){ ?>
              <a href="<?=$out_file_make?>"  target="_blank" class="btn btn-info">View</a>
              <? } ?></td>
          </tr>
          <? } ?>
        </tbody>
<!--        <tfoot>-->
<!--          <tr class="bgc-info">-->
<!--            <th>Name</th>-->
<!--            <th>Date</th>-->
<!--            <th>Day</th>-->
<!--            <th>In Time</th>-->
<!--            <th>In Time Location</th>-->
<!--            <th>In Time Image</th>-->
<!--            <th>Out Time</th>-->
<!--            <th>Out Time Location</th>-->
<!--            <th>Out Time Image</th>-->
<!--          </tr>-->
<!--        </tfoot>-->
      </table>
    </div>
  </div>
</div>
<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
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
