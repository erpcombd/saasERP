<?php

ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);


// index.php

// Specify the target path
$targetPath = '/app/views/auth/userApp/upserApps.php';

// Redirect to the new path
header('Location: ' . $targetPath);
exit();
?>







<?php
/*session_start();
include 'config/db.php';
include 'config/function.php';

$cid1 = explode('.', $_SERVER['HTTP_HOST'])[0];


$ip = $_SERVER['REMOTE_ADDR'];  



if(isset($_COOKIE['cloudhrm_e_app'])){

		 $token=$_COOKIE['cloudhrm_e_app'];
	 
	 

		$sql="SELECT * FROM user_cookie_log WHERE token='$token'";
		$query = db_query($conn, $sql);
		while($row=mysqli_fetch_assoc($query)){
		$user_name= $row['user_name'];
		$pass = $row['user_pass'];
		}
		
		$sql2="SELECT * FROM user_activity_management WHERE username='$user_name'";
		$query = db_query($conn, $sql2);
		$numrows = mysqli_num_rows ($query);
		if($numrows !=0){
		
		while ($row = mysqli_fetch_assoc($query))
			{
			
			$dbuser_id  = $row['user_id'];
			$dbusername = $row['username'];
			$dbpassword = $row['password'];
			$dbfullname = $row['fname'];
			$dblevel    = $row['level'];
			$dbcom      = $row['group_for'];
			
			}
		
				if ($user_name==$dbusername && $pass==$dbpassword)
			{
			
	
//location_save($username,$ip,$latitude,$longitude);
				
				
				$_SESSION['user_id']        =$dbuser_id;
				$_SESSION['username']       =$dbusername;	
				$_SESSION['name']           =$dbfullname;
				$_SESSION['level']          =$dblevel;
				$_SESSION['company_id']     =$dbcom;
				$_SESSION['palkey']         ='my2ndSales22';

				
                header("Location: home.php"); 			
				
				
			}
			else 
				echo "Incorrect password";
				
				
			}
	
	
}


if ($_POST['username'] && $_POST['password']){

$username = $_POST['username'];
$password = $_POST['password'];


//$ip  		= $_POST['ipss'];
$latitude  	= $_POST['latitude'];
$longitude  = $_POST['longitude'];
					
		
	$sql2="SELECT * FROM user_activity_management WHERE username='$username'";
		$query = db_query($conn, $sql2);
		$numrows = mysqli_num_rows ($query);
		if($numrows !=0){
		
		while ($row = mysqli_fetch_assoc($query))
			{
			
			$dbuser_id  = $row['user_id'];
			$dbusername = $row['username'];
			$dbpassword = $row['password'];
			$dbfullname = $row['fname'];
			$dblevel    = $row['level'];
			$dbcom      = $row['group_for'];
			
			}
		
				if ($username==$dbusername && $password==$dbpassword)
			{
			
	
location_save($username,$ip,$latitude,$longitude);
				
				
				$_SESSION['user_id']        =$dbuser_id;
				$_SESSION['username']       =$dbusername;	
				$_SESSION['name']           =$dbfullname;
				$_SESSION['level']          =$dblevel;
				$_SESSION['company_id']     =$dbcom;
				$_SESSION['palkey']         ='my2ndSales22';

				
                header("Location: home.php"); 			
				
				
			}
			else 
				echo "Incorrect password";
				
				
				
				
					$token = rand();
                    $ins_sql = "INSERT INTO `user_cookie_log` (`token`, `user_name`, `user_pass`) VALUES ('".$token."', '".$dbusername."', '".$dbpassword."') ";
                    db_query($conn,$ins_sql);
                    
                    if(!isset($_COOKIE['cloudhrm_e_app'])){
                    setcookie("cloudhrm_e_app", $token ,time() + (10 * 365 * 24 * 60 * 60));
                    }
				
				
				
			}
			
			else
				die ("That username doesnt exist");



}*/
?>

<!doctype html>
<html lang="en" class="h-200">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>User Portal</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!--<link rel="manifest" href="manifest.json" />-->

    <!-- Favicons -->
<link rel="icon" type="image/x-icon" href="assets/favicon/erp_favicon-32x32.png"> 

    <!-- Google fonts-->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- style css for this template -->
    <link href="assets/scss/style.css" rel="stylesheet" id="style">
</head>

<body class="body-scroll d-flex flex-column h-100 theme-pink" data-page="signin">

    <!-- Header -->
<!--    <header class="header position-fixed header-filled">-->
<!--        <div class="row">-->
<!--            <div class="col">-->
<!--                <div class="logo-small">-->
<!--<!--                    <img src="assets/img/logo.png" alt="" class="rounded-circle" />-->
<!--                    <img src="assets/img/logo.png" alt=""/>-->
<!--                    <h5>Attendance<br /><span class="text-secondary fw-light">Management</span></h5>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-auto">-->
<!--               <!-- <a href="signup.php" target="_self">-->
<!--                    Sign up-->
<!--                </a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </header>-->
    <!-- Header ends -->

<!-- Begin page content -->
	<style>
		.bg-img{
			 background-image: url("bacground-img.png");
			 
			 background-repeat: no-repeat;
			 background-attachment: fixed;
			 background-size: 100% 100%;
		}
	
	</style>
	
<main class="container-fluid bg-img h-100">
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <div style="margin: 0 auto; width: 200px; ">
	    <?
        $cloud_logo = "../logo/clouderplogo.png";
        $project_logo = "../logo/".$cid1.".png";
						
		if(is_file($project_logo)) {
			$show_logo = $project_logo;
		} else {
				$show_logo = $cloud_logo;
			}
								
        ?>
        <img src="<?=$show_logo?>" style="width: 100%; height: 70px;">
								
<!--        <img src="assets/img/logo.png" alt="" style="width: 100%; height: 100%"/>-->
    </div>


<form action="" method="POST" class="form-fill">
        <div class="row h-100">
            <div class="col-11 col-sm-11 col-md-6 col-lg-5 col-xl-3 mx-auto align-self-center py-4">
<!--                <h4 class="mb-4"><span class="text-secondary fw-light">Sign in to</span><br />Attendance Module</h4>-->
                <div class="form-group form-floating mb-3 is-valid">
				
                    <input type="text" class="form-control" name="username" id="email" placeholder="Username" style="background: #fff;">
                    <label class="form-control-label" for="email">Username</label>
                </div>

                <div class="form-group form-floating is-invalid mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" style="background: #fff;">
                    <label class="form-control-label" for="password">Password</label>
                    <button type="button" class="text-danger tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="left" title="Enter valid Password" id="passworderror">
                        <i class="bi bi-info-circle"></i>
                    </button>
                </div>

                <!--
                <p class="mb-3 text-end">
                    <a href="forgot-password.php" class="">
                        Forgot your password?
                    </a>
                </p>
                -->


            </div>
            <div class="col-11 col-sm-11 mt-auto mx-auto py-4">
                <div class="row ">
                    <div class="col-12 d-grid">
                        <button type="submit" class="btn btn-default btn-lg btn-rounded shadow-sm">Sign In</button>
                    </div>
                </div>
            </div>
        </div>

				<!--<input type="text" name="ipss" id="ipss" value="">-->
				<input type="hidden" name="latitude" id="latitude"  value="">
				<input type="hidden" name="longitude" id="longitude"  value="">
    </form>
</main>


    <!-- Required jquery and libraries -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/vendor/bootstrap-5/js/bootstrap.bundle.min.js"></script>

    <!-- Customized jquery file  -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/color-scheme.js"></script>

    <!-- PWA app service registration and works -->
    <!--<script src="assets/js/pwa-services.js"></script>-->

    <!-- page level custom script -->
    <script src="assets/js/app.js"></script>
    

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

</body>

</html>