<?php

session_start();

include 'config/access.php';

include 'config/db.php';

include 'config/function.php';

$page       ="attendance";

include "inc/header.php";

$u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);


$username	= $PBI_ID; //$_SESSION['user_id'];

$show       =findall('select username,fname from user_activity_management where user_id="'.$username.'"');

$ip = $_SERVER['REMOTE_ADDR'];







$check_intime = find1("select access_time from ss_location_log where access_date='".date('Y-m-d')."' and user_id='".$username."' and attendance_type='IN TIME'");

$check_outtime = find1("select access_time from ss_location_log where access_date='".date('Y-m-d')."' and user_id='".$username."' and attendance_type='OUT TIME'");









if(isset($_REQUEST['in_time'])){

    $_POST['attendance_type']='IN TIME';

    if($_POST['user_id']>0){

	$time = date('H:i:s');

   //$insert_id=@insert('hrm_attdump');

  /*  $sql = 'insert into hrm_attdump(`ztime`,`EMP_CODE`,`time`,`xtime`,`xdate`,`xlocationid`,`xmechineid`,`xenrollid`)
  value("'.date('Y-m-d H:i:s').'","'.$PBI_ID.'","'.$time.'","'.date('Y-m-d H:i:s').'","'.date('Y-m-d').'","999","999","240")'; */


      $sql = 'insert into hrm_attdump(`ztime`,`bizid`,`EMP_CODE`,`time`,`xtime`,`xdate`,`xlocationid`,`latitude`,`longitude`)
    value("'.date('Y-m-d H:i:s').'","'.$PBI_ID.'","'.$PBI_ID.'","'.$time.'","'.date('Y-m-d H:i:s').'","'.date('Y-m-d').'",
    "999","'.$_POST['latitude'].'","'.$_POST['longitude'].'")';

      $insert = $conn->query($sql);

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

    //redirect2("attendance.php");

	}

}











if(isset($_REQUEST['out_time'])){

$_POST['attendance_type']='OUT TIME';

    if($_POST['user_id']>0){

    //$insert_id=@insert('hrm_attdump');

	/*$insert = 'insert into hrm_attdump(`ztime`,`EMP_CODE`,`time`,`xtime`,`xdate`,`xlocationid`,`xmechineid`,`xenrollid`)
	value("'.date('Y-m-d H:i:s').'","'.$PBI_ID.'","'.$time.'","'.date('Y-m-d').'","999","999","240")';*/

  $insert = 'insert into hrm_attdump (`ztime`,`bizid`,`EMP_CODE`,`time`,`xtime`,`xdate`,`xlocationid`,`latitude`,`longitude`)
 value("'.date('Y-m-d H:i:s').'","'.$PBI_ID.'","'.$PBI_ID.'","'.$time.'","'.date('Y-m-d').'","'.date('Y-m-d').'","999","'.$_POST['latitude'].'","'.$_POST['longitude'].'")';



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

//redirect2("attendance.php");

}

}









?>

<!-- main page content -->

<div class="main-container container">





<div class="row text-center mb-3"><h3>Submit Attendance</h3></div>

<?php if(isset($_GET['edit_id'])){ ?> <a class="btn btn-primary" href="?" role="button">New Entry</a> <? } ?>

<?php if(isset($msg)){ ?><div class="alert alert-primary msg" role="alert"><?php echo @$msg; ?></div><?php } ?>

<?php if(isset($emsg)){ ?><div class="alert alert-danger emsg" role="alert"><?php echo @$emsg; ?></div><?php } ?>







<form action="" method="post" id="demo" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">



<div class="row">

            <div class="col-md-6 col-xs-6 text-center">

                <div id="my_camera"></div>

                <br/>

                <!-- <input type="button" class="btn btn-success btn-xs"  value="Take Picture" onClick="take_snapshot()"> -->

                <input type="hidden" name="image" class="image-tag">

            </div>

            <div class="col-md-6 col-xs-6 text-center">

                <div id="results"></div>

            </div>



        </div>

<!--<div class="row mb-10 mb-2">

	<div class="col-4"><label class="control-label" for="fname">User Name<span class="required"></span></label></div>

	<div class="col-7"><input type="text" name="fname" required="required" disable autocomplete="off" value="<?=$show->fname?>" class="form-control"></div>

</div>-->



				<input type="hidden" name="access_date" id="access_date"  value="<?=date('Y-m-d')?>">

				<input type="hidden" name="access_time" id="access_time"  value="<?=date('Y-m-d H:i:s')?>">



				<input type="hidden" name="user_id" id="user_id"  value="<?=$username;?>">

				<input type="hidden" name="ip" id="ip"  value="<?=$ip;?>">

				<input type="hidden" name="latitude" id="latitude"  value="">

				<input type="hidden" name="longitude" id="longitude"  value="">





<div class="ln_solid mt-2"></div>

<div class="form-group">

    <div class="col-md-6 col-sm-6 col-md-offset-3">



            <div class="col-11 col-sm-11 mt-auto mx-auto py-4">

                <div class="row ">



                    <div class="col-6 d-grid"><button type="submit" onClick="take_snapshot()" name="in_time" class="btn btn-default btn-lg btn-rounded shadow-sm">PUNCH</button></div>







                </div>

            </div>





    </div>

</div>

</form>



<!--<div class="container row">

IN TIME: <?=$check_intime;?><br>OUT TIME: <?=$check_outtime;?>

</div>-->









<!-- User list items  -->













</div>

<!-- main page content ends -->

</main>

<!-- Page ends-->





<script>

        // var x=document.getElementById("demo");



        function getLocation(){



            if (navigator.geolocation)

            {

            navigator.geolocation.getCurrentPosition(showPosition);

            // }else{x.innerHTML="Geolocation is not supported by this browser.";



            }

        }





        function showPosition(position){

        // x.innerHTML="Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;



        var latitude  = position.coords.latitude;

        var longitude  = position.coords.longitude;



        document.getElementById("latitude").value = latitude;

        document.getElementById("longitude").value = longitude;



        }

        document.body.onload = function(){

        getLocation();

        };





</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>



<script language="JavaScript">

    Webcam.set({

        width: 150,

        height: 150,

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



<?php include "inc/footer.php"; ?>
