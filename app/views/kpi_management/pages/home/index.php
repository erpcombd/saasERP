<!DOCTYPE html>

<html lang="en">

<head>

	<title>AKSID KPI MODULE</title>

	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--===============================================================================================-->

	<link rel="icon" type="image/png" href="log_panel/images/icons/favicon.ico" />

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





	if (isset($_POST['ibssignin'])) {







		$uid  = $_POST['uid'];



		$passward = $_POST['pass'];







		if ($_POST['uid'] == $_POST['pass']) {



			$uid = (int)$uid;



			$passward = (int)$passward;
		} else {



			$uid = (int)$uid;
		}







		$cid  = $_POST['cid'];







		$sql = "SELECT b.db_user,b.db_pass,b.db_name,a.cid,a.id FROM company_info a,database_info b WHERE a.cid='$cid' and a.id=b.company_id and a.status='ON' limit 1";







		$sql = @mysql_query($sql);



		if ($proj = @mysql_fetch_object($sql)) {











			$_SESSION['proj_id']	= $proj->cid;



			$_SESSION['db_name']	= $proj->db_name;



			$_SESSION['db_user']	= $proj->db_user;



			$_SESSION['db_pass']	= $proj->db_pass;







			require_once "../../config/db_connect.php";



			$user_sql = "select p.* from personnel_basic_info p,hrm_user_access u where  p.PBI_CODE='" . $uid . "' AND p.pass = '" . $passward . "' and p.PBI_JOB_STATUS='In Service' and p.PBI_ID=u.PBI_ID and u.kpi_module=1";







			$user_query = mysql_query($user_sql);



			if (mysql_num_rows($user_query) > 0) {



				$proj_sql = "select * from project_info limit 1";



				$proj = @mysql_fetch_object(mysql_query($proj_sql));



				$info = @mysql_fetch_row($user_query);











				$_SESSION['user']['level']	= 1;



				$_SESSION['user']['id']	= $_SESSION['employee_selected'] = $info[0];



				$_SESSION['user']['fname']	= $info[4];







				$_SESSION['separator'] = '';



				$_SESSION['mhafuz'] = 'Active';



				$_SESSION['voucher_type'] = 3;



				$_SESSION['user']['panel'] = 'YES';











				//add_user_activity_log($_SESSION['user']['id'],1,1,'Login Page','Succ4essfully Logged In',$_SESSION['user']['level']);







	?>







				<style>







				</style>



				<script>
					window.location.assign("../inventory/home.php")
				</script>



	<?







			} else {

				$msg = '<span style="color:red; font-weight:bold;">Sorry! Invalid Information</span>';
			}
		}
	} else



		session_destroy();



	?>









	<?

	$sq = 'select note from welcome_note where id=1';



	$qr = mysql_query($sq);







	$dt = mysql_fetch_object($qr);











	?>







	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>



	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>







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

































				<form action="" method="post" class="login100-form validate-form">



					<span class="login100-form-title p-b-43">



						<tr>
							<td>&nbsp;</td>
						</tr>







					</span>































					<div class="text-center p-t-46 p-b-20">



						<span class="txt2">



						</span>



					</div>











					<div class="text-center p-t-46 p-b-20">



						<span class="txt2">



						</span>



					</div>







					<div class="text-center">



						<span class="txt2">



							<tr>
								<td>&nbsp;</td>
							</tr>



							<tr>
								<td>&nbsp;</td>
							</tr>



						</span>



					</div>











					<div class="text-center p-t-46 p-b-20">



						<span class="txt2">



						</span>



					</div>

























					<span class="login100-form-title p-b-43">

						<tr>
							<td></td>
						</tr>

					</span>

					<?= $msg ?>
					<div style="padding-top:50px">
			</div>

			<input class="input100" type="hidden" placeholder="Company Name" name="cid" style="color:#000000;" value="aksid">



			<div class="wrap-input100 validate-input" data-validate="ID NO is required">

				<input class="input100" name="uid" placeholder="ID No" type="text" style="color:#000000;">



				<input type="hidden" name="ibssignin" />

				<span class="focus-input100"></span>

				<span class="label-input100"></span>

			</div>





			<div class="wrap-input100 validate-input" data-validate="Password is required">

				<input class="input100" type="password" placeholder="Password" name="pass" style="color:#000000;">

				<span class="focus-input100"></span>

				<span class="label-input100"></span>

			</div>













			<div class="container-login100-form-btn">

				<button name="submit" class="login100-form-btn">

					Login

				</button>

			</div>







			<div class="login100-form-social flex-c-m">

				<!--	<a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">

							<i class="fa fa-facebook-f" aria-hidden="true"></i>

						</a>-->



				<a href="log.php" target="_blank" class="login100-form-social-item flex-c-m bg2 m-r-5">

					<i class="fa fa-gear fa-spin" style="color:red; font-size:35px"></i> </a>

			</div>











			</form>









			<div class="login100-more" style="background-image:url('file/home/e5135f68cc.jpg')">





				<div class="container">



					<div class="row">











						<?php



						if ($dt->note != '') {



						?>



							<div style="font:left; height:auto; width:69%;">
								<marquee style="color:#fff; font-size:18px; font-weight:bold; font-family:bankgothic;" behavior="alternate" truespeed="truespeed" width="800px;"></marquee>
							</div>



						<?php } ?>







					</div>

				</div>

			</div>

		</div>





		<script>
			function myfunction() {



				var x = document.getElementById("show");



				if (x.style.display === "none") {



					x.style.display = "";



				} else {



					x.style.display = "none";



				}











			}











			function myfunction2() {



				var x = document.getElementById("show1");



				if (x.style.display === "none") {



					x.style.display = "";



				} else {



					x.style.display = "none";



				}











			}







			function myfunction3() {



				var x = document.getElementById("show2");



				if (x.style.display === "none") {



					x.style.display = "";



				} else {



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