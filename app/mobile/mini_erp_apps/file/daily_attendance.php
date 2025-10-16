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

if(isset($_REQUEST['in_time'])){

    $_POST['type']='Attendance';
    $_POST['attendance_type']='IN TIME';
    $_POST['shop_name']=find1("select shop_name from ss_shop where dealer_code='".$_POST['shop_id']."'");
    $_POST['shop_name_unschedule']=find1("select shop_name from ss_shop where dealer_code='".$_POST['shop_id_unschedule']."'");
    $_POST['status'] = 'UNAPPROVED';
    $_POST['approved_status'] = 'PENDING';
    
    
    @insert('ss_location_log');
    
    $msg="Attendance In time insert successfully";
    redirect2("daily_attendance.php");
}





if(isset($_REQUEST['out_time'])){
    
    $_POST['type']='Attendance';
    $_POST['attendance_type']='OUT TIME';
    $shop_info =findall("select * from ss_shop where dealer_code='".$_POST['shop_id']."'");
    $_POST['shop_name']     =$shop_info->shop_name;
    $_POST['shop_address']  =$shop_info->shop_address;
    
    $datetime1 = new DateTime($check_intime);
    $datetime2 = new DateTime($_POST['access_time']);
    
    $interval = $datetime1->diff($datetime2);
    $_POST['work_time_min'] = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
    
    @insert('ss_location_log');
    
    $msg="Attendance Out time insert successfully";
    redirect2("daily_attendance.php");
}






?>
    
    <style>
        #content {
            display: none; /* Initially hidden */

        }
        button {
            cursor: pointer;
        }
    </style>
        <script>
        function cus_toggle(){
            
            document.getElementById('content').style.display="block";
            document.getElementById('content').style.display=" ";
            
            document.getElementById('button_show').style.display="none";
            document.getElementById('button_show').style.display=" ";
             
        }
    </script>
    
    

    
<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
        <div class="card card-style mb-0">
		<form action="" enctype="multipart/form-data" method="post" name="" id="demo" >
		<div class="content mt-0 mb-0">
			
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
		
		<!--<div class="input-style input-style-always-active  has-borders no-icon validate-field mb-4">		-->
					
    		<label for="manager_name">User Name</label>
    		<input type="text" class="form-control validate-text w-100" name="fname" required="required" disable autocomplete="off" value="<?=$show->fname?>">
    		<!--<i class="fa fa-times disabled invalid color-red-dark"></i>-->
    		<!--<i class="fa fa-check disabled valid color-green-dark"></i>-->
						
	    	<!--</div>-->
		<!--<div class="input-style input-style-always-active  has-borders no-icon mb-4">-->
		    
		    <? $route_id = getScheduleRoute()['route_id']; ?>
			<label for="shop">Schedule Route</label>			
                <input type="hidden" value="<?=$route_id;?>" name="schedule_route" readonly>

                <input value="<?echo getScheduleRoute()['route_name']; ?>" readonly>						
			<!--<span><i class="fa fa-chevron-down"></i></span>-->
			<!--<i class="fa fa-check disabled valid color-green-dark"></i>-->
			<!--<i class="fa fa-check disabled invalid color-red-dark"></i>-->
			<em></em>
			<!--</div>-->
			
			<div>
		    <label for="dealer_code">Route Wise Shop List</label>
			<select name="shop_id" required="required" id="shop_id" class="w-100 rounded">
			    <option value="0"></option>
				<?
			optionlist('select s.dealer_code,concat(r.route_name,"-",s.shop_name) as shop_name 
			from ss_shop s, ss_route r 
			where s.route_id=r.route_id and s.status="1" and r.route_id = "'.$route_id.'" and s.emp_code="'.$_SESSION['user']['username'].'" 
			order by r.route_id,s.shop_name'); ?>
			</select>
			</div>
			
			<br>
			
			
			
			<!--<div class="d-flex justify-content-center row">-->
			<!--			<div class="col-6 ">-->
   <!--        <? if($check_intime!=''){ }else{ ?>-->
			<!--				<input class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s w-100"  type="submit" name="in_time" onClick="take_snapshot()" id="submitit" value="In Punch" ">-->
   <!--           <?}?>-->
   <!--          <? if($check_outtime=='' && $check_intime!=''){ ?>-->
   <!--           <input class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light w-100"  type="submit" name="out_time" onClick="take_snapshot()" id="submitit" value="Out Punch" ">-->

   <!--           <?}?>-->
			<!--			</div>-->
			<!--			<div></div>-->
			<!--		</div>-->
			
			<div class="w-100 d-flex justify-content-center" id="button_show">
            <button type="submit" class="punch btn btn-success  " name="in_time" >Submit</button>
            <button type="button" class="no_scedule btn btn-primary " onclick="cus_toggle()">Un Schedule</button>
            </div>

            <br>
            <div id="content" class="m-0 p-0">
            <div>
            <label for="dealer_code">Un Schedule Route</label>
        	 <select name="unschedule_route" id="unschedule_route" onchange="FetchShopList(this.value)" class="w-100 rounded">
        	     <option></option>
				<? optionlist("select s.route_id,r.route_name from ss_route r, ss_shop s where s.route_id=r.route_id and s.emp_code='".$_SESSION['user']['username']."' group by s.route_id order by route_name");?>
			</select>  
            </div>
            
            <div>
            <label for="dealer_code">Un Route Wise Shop List</label>
			<select name="shop_id_unschedule" id="shop_id_unschedule" class="w-100 rounded">
			<option value="<?=$shop_id_unschedule?>"><?=find1("select concat(dealer_code,'-',shop_name) from ss_shop where dealer_code='".$shop_id_unschedule."' ");?></option>
			<? 
			optionlist('select s.dealer_code,concat(r.route_name,"-",s.shop_name) as shop_name 						from ss_shop s, ss_route r 
			where s.route_id=r.route_id  and s.emp_code="'.$_SESSION['user']['username'].'" and s.type="shop"
			order by r.route_id,s.shop_name');
			 ?>
			</select>
                
            </div>
            
            <div>
            <label for="dealer_code" > Reason </label>
            <input type="text" placeholder="Add no schedule Reason" id="reason_unschedule" name="reason_unschedule" class="rounded" >
            </div>
            
            <br>
            
			<input type="hidden" name="access_date" id="access_date"  value="<?=date('Y-m-d')?>">
			<input type="hidden" name="access_time" id="access_time"  value="<?=date('Y-m-d H:i:s')?>">
						
			<input type="hidden" name="user_id" id="user_id"  value="<?=$username;?>">
			<input type="hidden" name="ip" id="ip"  value="<?=$ip;?>">
						
			<input type="hidden" name="latitude" id="latitude"  value="">
			<input type="hidden" name="longitude" id="longitude"  value="">
						
						
			<?php /*?><div class="input-style has-borders no-icon mb-4">
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
			</div><?php */?>
					
		 <? /*php   <div class="d-flex justify-content-center row m-0">
			<div class="col-6 ">
            <? if($check_intime!=''){ }else{ ?>		
            <input class="btn btn-3d btn-m btn-full mb-3 rounded-xs font-900 shadow-s btn-danger w-100 send1"  type="submit" name="in_time" onClick="take_snapshot()" id="submitit" value="Send" ">
             <?}?>
             <? if($check_outtime=='' && $check_intime!=''){ ?>
              <input class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light w-100"  type="submit" name="out_time" onClick="take_snapshot()" id="submitit" value="Out Punch" ">

              <?}?>
			</div>
	    	</div> */?>
	    	
	    	
	        <div class="w-100 d-flex justify-content-center" id="button_show">
                <button type="submit" class="btn btn-danger" name="in_time" style="width: 123px !important;">Send</button>
            </div>
				<p class="m-0 p-0"><label>Status :</label> Pending </p>
<!--	    	<p class="m-0 p-0"><label>Status :</label> Pending / Deny / Allowed</p>-->
	    	</div>
			</div>
				
			</form>
			<!--<div class="container row">-->
			<!--	IN TIME: <?=$check_intime;?> , Shop Name: <?=$in_info->shop_name?>-->
			<!--	<br>-->
			<!--	OUT TIME: <?=$check_outtime;?>, Shop Name: <?=$out_info->shop_name?>-->
			<!--</div>-->
            </div>
			
			
			
			
			
			
			
			
			
			
        </div>
    <!-- End of Page Content--> 
    
    











<?php 
 require_once '../assets/template/inc.footer.php';
 ?>
 

<script>

  
function FetchShopList(id){
    $('#shop_id_unschedule').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { route_id : id},
      success : function(data){
         $('#shop_id_unschedule').html(data);
      }

    })
  }
  
  
  
  


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
