<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start ();
include ("../config/db.php");
include ("../config/function.php");



if (isset($_POST['username']) && isset($_POST['password'])){	

$username = validation($_POST['username']);
$password = validation($_POST['password']);
		
		$query = mysqli_query($conn, "SELECT * FROM admin_users WHERE username='$username'");
		
		$numrows = mysqli_num_rows ($query);
		
		if($numrows !=0)
		
		{
		
		while ($row = mysqli_fetch_assoc($query))
			{
			
			$dbuserid        = $row['id'];
			$dbusername     = $row['username'];
			$dbpassword     = $row['password'];
			$dbcompany      = $row['company_id'];
			$dblevel 	    = $row['role'];
			
			}
		
				if ($username==$dbusername && $password==$dbpassword)
			{
				$_SESSION['user_id']		=$dbuserid;
				$_SESSION['username']		=$dbusername;
				$_SESSION['company_id']		=$dbcompany;
				$_SESSION['level']			=$dblevel;
				$_SESSION['admin_login']	='YES';

			redirect('home.php');

				
			}
			else 
				echo "Incorrect password";
			}
			
			else
				die ("That username doesnt exist");
}


?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/imgs/theme/favicon.svg">
    <!-- Template CSS -->
    <link href="assets/css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <main>
        
		
		
<header class="main-header style-2 navbar">
	<div class="col-brand">
		<a href="#" class="brand-wrap">
			<img src="../images/logo/1.png" class="logo" alt="Dashboard">
		</a>
	</div>
	<div class="col-nav">
		
	</div>
</header>
		
		
		
		
		
        <section class="content-main mt-50 mb-20">
            <div class="card mx-auto card-login">
                <div class="card-body">
                    <h4 class="card-title mb-4">Visitor Management System</h4>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <input class="form-control" id="username" name="username" placeholder="Username" type="text" value="">
                        </div> 
                        <div class="mb-3">
                            <input class="form-control" placeholder="Password" type="password" name="password" id="password" value="">
                        </div> 
                        <div class="mb-3">
                            <a href="#" class="float-end font-sm text-muted">Forgot password?</a>
                            <label class="form-check">
                                <input type="checkbox" class="form-check-input" checked="">
                                <span class="form-check-label">Remember</span>
                            </label>
                        </div> 
                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary w-100"> Login </button>
                        </div> <!-- form-group// -->
                    </form>

                </div>
            </div>
        </section>
        <footer class="main-footer text-center">
            <p class="font-xs">
                <script>
                document.write(new Date().getFullYear())
                </script> ©, Website.com .
            </p>
            <p class="font-xs mb-30">All rights reserved</p>
        </footer>
    </main>
    <script src="assets/js/vendors/jquery-3.6.0.min.js"></script>
    <script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
    <!-- Main Script -->
    <script src="assets/js/main.js" type="text/javascript"></script>
</body>

</html>