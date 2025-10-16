<?php
session_start();


include 'config/db.php';
include 'config/function.php';

$ip = $_SERVER['REMOTE_ADDR'];  

// This section should be modified (by Mahfuz vai)

if ($_POST['company_name']){
	$company_name = $_POST['company_name'];
	
	$sql2="SELECT * FROM user_activity_management WHERE company_name='$company_name'";
		$query = db_query($conn, $sql2);
		$numrows = mysqli_num_rows ($query);
		if($numrows !=0){
		
		while ($row = mysqli_fetch_assoc($query)){	
			
			$dbcompany_name = $row['company_name'];			
			}
			if ($company_name==$dbcompany_name){
				
				
				location_save($company_name);
				$_SESSION['company_name']=$dbcompany_name;
				
				header("Location: index.php");
			}
			else 
				echo "Incorrect username";
			}
			
			else
				die ("That username doesnt exist");
}
?>

<!doctype html>
<html lang="en" class="h-200">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
	
    <title>Company Portal</title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!--<link rel="manifest" href="manifest.json" />-->

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="assets/img/favicon180.png" sizes="180x180">
    <link rel="icon" href="assets/img/favicon32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="assets/img/favicon16.png" sizes="16x16" type="image/png">

    <!-- Google fonts-->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- style css for this template -->
    <link href="assets/scss/style.css" rel="stylesheet" id="style">
</head>
	
	

<body class="body-scroll d-flex flex-column h-100 theme-pink" data-page="signin">
<!--background-position: center;-->

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
			<img src="assets/img/logo.png" alt="" style="width: 100%; height: 100%"/>
		</div>


	<form action="" method="POST" class="form-fill">
			<div class="row h-100">
				
				<div class="col-11 col-sm-11 col-md-6 col-lg-5 col-xl-3 mx-auto align-self-center py-4">
	
					<div class="form-group form-floating mb-3 is-valid">
						<input type="text" class="form-control" name="username" id="email" placeholder="Username" style="background: #fff;">
						<label class="form-control-label" for="email">Company Name</label>
					</div>			
				</div>
				
				<div class="col-11 col-sm-11 mt-auto mx-auto py-4">
					<div class="row ">
						<div class="col-12 d-grid">
							<button type="submit" class="btn btn-default btn-lg btn-rounded shadow-sm">Sign In</button>
						</div>
					</div>
				</div>
			</div>			
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
    


</body>

</html>