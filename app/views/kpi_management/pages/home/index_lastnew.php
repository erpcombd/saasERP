<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V18</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="log_panel/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="log_panel/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="log_panel/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="log_panel/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="log_panel/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="log_panel/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="log_panel/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="log_panel/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="log_panel/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="log_panel/css/util.css">
	<link rel="stylesheet" type="text/css" href="log_panel/css/main.css">
<!--===============================================================================================-->

  



<?php

session_start();



require_once("../../config/default_values.php");

require_once('../../config/db_connect_scb_main.php');

require "../../template/log_link.php";







if(isset($_POST['ibssignin']))

{

	

	$uid  = $_POST['uid'];

	$passward = $_POST['pass'];

	

	if($_POST['uid']==$_POST['pass']){

	$uid=(int)$uid;

	$passward=(int)$passward;

	}else{

	$uid=(int)$uid;

	}

	

	$cid  = $_POST['cid'];



$sql="SELECT b.db_user,b.db_pass,b.db_name,a.cid,a.id FROM company_info a,database_info b WHERE a.cid='$cid' and a.id=b.company_id and a.status='ON' limit 1";



	$sql=@mysql_query($sql);

	if($proj=@mysql_fetch_object($sql))

	{





					$_SESSION['proj_id']	= $proj->cid;

					$_SESSION['db_name']	= $proj->db_name;

					$_SESSION['db_user']	= $proj->db_user;

					$_SESSION['db_pass']	= $proj->db_pass;

					

require_once "../../config/db_connect.php";		

$user_sql="select * from personnel_basic_info where  PBI_ID='$uid' AND pass = '$passward'";

		

				$user_query=mysql_query($user_sql);

				if(mysql_num_rows($user_query)>0)

				{

				$proj_sql="select * from project_info limit 1";

				$proj=@mysql_fetch_object(mysql_query($proj_sql));

				$info=@mysql_fetch_row($user_query);

				

					

			$_SESSION['user']['level']	= 1;

					$_SESSION['user']['id']	= $_SESSION['employee_selected'] = $info[0];

					$_SESSION['user']['fname']	= $info[4];

					

					$_SESSION['separator']='';

					$_SESSION['mhafuz']='Active';

					$_SESSION['voucher_type']=3;

					$_SESSION['user']['panel']='YES';

		

					

//add_user_activity_log($_SESSION['user']['id'],1,1,'Login Page','Succ4essfully Logged In',$_SESSION['user']['level']);



?>




<script>



    window.location.assign("../inventory/home.php")



</script>

<?

					

				}

		}



}

else

session_destroy();

?>




<?







 $sq = 'select note from welcome_note where id=1';

$qr = mysql_query($sq);



$dt = mysql_fetch_object($qr);





?>



<?

	  $select2 = 'select * from welcome_images where 1 and status="PUBLISHED" ';

   $qr2 = mysql_query($select2);

   $image = mysql_fetch_object($qr2);



	?>



</head>























<body style="background-color: #666666;">




	
	<div class="limiter">
	
	
	
		<div class="container-login100">
		
		
		
			<div class="wrap-login100">
			
			
			
				<form class="login100-form validate-form" method="post">
					<span class="login100-form-title p-b-43">
						Login to continue
					</span>
					
					
					
					
			  
			  
			      <div class="wrap-input100 validate-input" data-validate="Company Name is required">
						<input type="text" class="input100"   name="cid">
						<span class="focus-input100"></span>
						<span class="label-input100">Company Name</span>
					</div>
					
					
					<div class="wrap-input100 validate-input" data-validate = "Valid User ID required: 132787">
						<input class="input100" type="text"  name="uid" >
						<input type="hidden" class="form-control" name="ibssignin"  />
						<span class="focus-input100"></span>
						<span class="label-input100">ID NO</span>
					</div>
					
					
				
					
				<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="pass" >
						         
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>
					
				
					
					

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>
						
						

						<div>
							<a href="#" class="txt1">
								Forgot Password?
							</a>
						</div>
					</div>
					
					
					

			     <div class="container-login100-form-btn">
				<button name="submit" class="login100-form-btn">Login </button>
	 
					</div>

			

					
					
					
					
					
					<div class="text-center p-t-46 p-b-20">
						<span class="txt2">
							or sign up using
						</span>
					</div>
					
					
		

					<div class="login100-form-social flex-c-m">
						<a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">
							<i class="fa fa-facebook-f" aria-hidden="true"></i>
						</a>

						<a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">
							<i class="fa fa-twitter" aria-hidden="true"></i>
						</a>
					</div>
					
					
				
				
				
		<div class="login100-more" style="background-image: url('log_panel/images/bg-01.jpg');"></div>
			</div>
		</div>
	</div>
	
	

	

 <script>

function myfunction() {

  var x = document.getElementById("show");

  if (x.style.display === "none") {

    x.style.display = "";

  }else{

     x.style.display = "none";

  }

  

  

}





function myfunction2() {

  var x = document.getElementById("show1");

  if (x.style.display === "none") {

    x.style.display = "";

  }else{

     x.style.display = "none";

  }

  

  

}



function myfunction3() {

  var x = document.getElementById("show2");

  if (x.style.display === "none") {

    x.style.display = "";

  }else{

     x.style.display = "none";

  }

  

  

}







</script>    


<!--===============================================================================================-->
	<script src="log_panel/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="log_panel/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="log_panel/vendor/bootstrap/js/popper.js"></script>
	<script src="log_panel/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="log_panel/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="log_panel/vendor/daterangepicker/moment.min.js"></script>
	<script src="log_panel/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="log_panel/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="log_panel/js/main.js"></script>
	

</body>
</html>