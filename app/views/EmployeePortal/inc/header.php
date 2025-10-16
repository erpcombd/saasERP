<? $cid1 = explode('.', $_SERVER['HTTP_HOST'])[0]; ?>

<!doctype html>

<html lang="en">

<?

//$u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];
$u_id = $_SESSION['user']['id'];
if ($_SESSION['user']['id'] > 0) {
} else {
	echo '<script>location.href="logout.php";</script>';
}

$PBI_ID = find_a_field('user_activity_management', 'PBI_ID', 'user_id=' . $u_id);
$basic = find_all_field('personnel_basic_info', '', 'PBI_ID="' . $PBI_ID . '"');


?>

<head>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<meta name="description" content="">

	<meta name="author" content="">

	<meta name="generator" content="">

	<title>Attendance Management

		<?= $ms; ?>

	</title>

	<!-- manifest meta -->

	<meta name="apple-mobile-web-app-capable" content="yes">

	<!--<link rel="manifest" href="manifest.json" />-->

	<!-- Favicons -->

	<link rel="icon" type="image/x-icon" href="../assets/favicon/erp_favicon-32x32.png">

	<!-- Google fonts-->

	<link rel="preconnect" href="https://fonts.googleapis.com">

	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

	<!-- bootstrap icons -->

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

	<!-- nouislider CSS -->

	<link href="../assets/vendor/nouislider/nouislider.min.css" rel="stylesheet">

	<!-- date rage picker -->

	<link rel="stylesheet" href="../assets/vendor/daterangepicker/daterangepicker.css">

	<!-- swiper carousel css -->

	<link rel="stylesheet" href="../assets/vendor/swiperjs-6.6.2/swiper-bundle.min.css">

	<!-- style css for this template -->

	<link href="../assets/scss/custom.css?version=1.0.1.7" rel="stylesheet" id="style">

	<link href="../assets/scss/style.css" rel="stylesheet" id="style">

</head>

<body class="body-scroll theme-pink" data-page="shop">

	<!-- Sidebar main menu -->

	<div class="sidebar-wrap  sidebar-overlay">

		<!-- Add pushcontent or fullmenu instead overlay -->

		<div class="closemenu text-secondary">Close Menu</div>

		<div class="sidebar ">

			<!-- user information -->

			<div class="row">

				<div class="col-12 profile-sidebar">
					<a data-id="model" data-target="#mymodel">
						<div class="row">

							<div class="col-auto">

								<?

								//$sql =  @db_query("select PBI_NAME,PBI_PICTURE_ATT_PATH,DEPT_ID,DESG_ID,PBI_NID_ATT_PATH from  personnel_basic_info where PBI_ID = ".$PBI_ID ."");
								
								//$row = @mysqli_fetch_object($sql);
								
								$image_path = find_a_field('personnel_basic_info', 'PBI_PICTURE_ATT_PATH', 'PBI_ID="' . $PBI_ID . '"');

								if ($image_path !== "") {

									?>

									<figure class="avatar avatar-100 rounded-15 shadow-sm">

										<img src="../../../assets/support/upload_view.php?name=<?= $image_path ?>&folder=hrm_emp_pic&proj_id=<?= $cid1 ?>&mod=hrm_mod"
											alt="#" style=" width: 100%; height: 100%; ">

									</figure>

								<? } else { ?>

									<figure class="avatar avatar-100 rounded-15 shadow-sm"> <img src="assets/img/user1.png"
											alt="" style=" width: 100%; height: 100%; "> </figure>

								<? } ?>

							</div>

							<div class="col px-0 align-self-center">

								<p class="mb-2" style="font-size:13px">
									<?= find_a_field('user_activity_management', 'concat(fname," - ",PBI_ID)', 'PBI_ID=' . $PBI_ID); ?>
								</p>

								<p class="text-muted size-12">
									<?= find_a_field('personnel_basic_info', 'PBI_DESIGNATION', 'PBI_ID="' . $PBI_ID . '"'); ?><br />

									<?php /*?>Dep: <?=find_a_field('personnel_basic_info','PBI_DEPARTMENT','PBI_ID="'.$PBI_ID.'"');?><?php */ ?>
								</p>

							</div>

						</div>
					</a>
				</div>

			</div>

			<!-- user emnu navigation -->

			<div class="row">

				<div class="col-12">

					<ul class="nav nav-pills">

						<li class="nav-item"> <a class="nav-link active" aria-current="page" href="home.php">

								<div class="avatar avatar-40 icon"><i class="bi bi-speedometer2"></i></div>

								<div class="col">Dashboard</div>

								<div class="arrow"><i class="bi bi-chevron-right"></i></div>

							</a> </li>

						<!-- SETUP -->

						<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
								href="#" role="button" aria-expanded="false">

								<div class="avatar avatar-40 icon"><i class="bi bi-person-bounding-box"></i></div>

								<div class="col">Attendance</div>

								<div class="arrow"><i class="bi bi-chevron-down plus"></i><i
										class="bi bi-chevron-up minus"></i> </div>

							</a>

							<ul class="dropdown-menu">

								<li> <a class="dropdown-item nav-link" href="../main/daily_attendance2.php">

										<div class="avatar avatar-40 icon"><i class="bi bi-plus-lg"></i></div>

										<div class="col align-self-center">Daily Attendance</div>

										<div class="arrow"><i class="bi bi-chevron-right"></i></div>

									</a> </li>

								<li> <a class="dropdown-item nav-link" href="../main/attendance.php">

										<div class="avatar avatar-40 icon"><i class="bi bi-person-bounding-box"></i>
										</div>

										<div class="col align-self-center">Daily Attendance (Pic)</div>

										<div class="arrow"><i class="bi bi-chevron-right"></i></div>

									</a> </li>


								<li> <a class="dropdown-item nav-link" href="../main/att_report.php">

										<div class="avatar avatar-40 icon"><i class="bi bi-card-checklist"></i></div>

										<div class="col align-self-center">Punch Status</div>

										<div class="arrow"><i class="bi bi-chevron-right"></i></div>

									</a> </li>

								<li> <a class="dropdown-item nav-link" href="../main/att_location_report.php">

										<div class="avatar avatar-40 icon"><i class="bi bi-receipt"></i></div>

										<div class="col align-self-center">Attendance Report</div>

										<div class="arrow"><i class="bi bi-chevron-right"></i></div>

									</a> </li>

							</ul>

						</li>

						<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
								href="#" role="button" aria-expanded="false">

								<div class="avatar avatar-40 icon"><i class="bi bi-person-lines-fill"></i></div>

								<div class="col">Leave & IOM</div>

								<div class="arrow"><i class="bi bi-chevron-down plus"></i><i
										class="bi bi-chevron-up minus"></i> </div>

							</a>

							<ul class="dropdown-menu">

								<li> <a class="dropdown-item nav-link" href="../main/leave.php">

										<div class="avatar avatar-40 icon"><i class="bi bi-plus-lg"></i></div>

										<div class="col align-self-center">Leave Entry</div>

										<div class="arrow"><i class="bi bi-chevron-right"></i></div>

									</a> </li>

								<li> <a class="dropdown-item nav-link" href="../main/short_leave.php">

										<div class="avatar avatar-40 icon"><i class="bi bi-list-check"></i></div>

										<div class="col align-self-center">Half Day Leave</div>

										<div class="arrow"><i class="bi bi-chevron-right"></i></div>

									</a> </li>

								<li> <a class="dropdown-item nav-link" href="../main/iom_entry.php">

										<div class="avatar avatar-40 icon"><i class="bi bi-plus-lg"></i></div>

										<div class="col align-self-center">IOM Entry</div>

										<div class="arrow"><i class="bi bi-chevron-right"></i></div>

									</a> </li>

							</ul>

						</li>

						<!--Reports-->

						<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
								href="#" role="button" aria-expanded="false">

								<div class="avatar avatar-40 icon"><i class="bi bi-window-dock"></i></div>

								<div class="col">Leave & Iom Status</div>

								<div class="arrow"><i class="bi bi-chevron-down plus"></i><i
										class="bi bi-chevron-up minus"></i> </div>

							</a>

							<ul class="dropdown-menu">

								<li> <a class="dropdown-item nav-link" href="../main/leave_status.php">

										<div class="avatar avatar-40 icon"><i class="bi bi-card-checklist"></i></div>

										<div class="col align-self-center">Leave Status</div>

										<div class="arrow"><i class="bi bi-chevron-right"></i></div>

									</a> </li>

								<li> <a class="dropdown-item nav-link" href="../main/iom_status.php">

										<div class="avatar avatar-40 icon"><i class="bi bi-card-checklist"></i></div>

										<div class="col align-self-center">Iom Status</div>

										<div class="arrow"><i class="bi bi-chevron-right"></i></div>

									</a> </li>

							</ul>

						</li>






						<li class="nav-item"> <a class="nav-link" href="logout.php" tabindex="-1">

								<div class="avatar avatar-40 icon"><i class="bi bi-box-arrow-right"></i></div>

								<div class="col">Logout</div>
							</a>
						</li>

					</ul>

				</div>

			</div>

		</div>

	</div>

	<!-- Sidebar main menu ends -->

	<!-- Begin page -->

	<main class="h-100">

		<!-- Header -->

		<header class="header position-fixed header-filled" style=" padding: 5px 10px 5px 20px; ">

			<div class="row">

				<div class="col-auto" style="display:none;">

					<button type="button" class="btn btn-light btn-44 btn-rounded menu-btn"> <i class="bi bi-list"></i>
					</button>

				</div>

				<div class="col" style="padding-left: 0px;">

					<div class="logo-small">
						<a data-id="model" data-target="#mymodel">
							<?
							//$sql =  @db_query("select PBI_NAME,PBI_PICTURE_ATT_PATH,DEPT_ID,DESG_ID,PBI_NID_ATT_PATH from  personnel_basic_info where PBI_ID = ".$PBI_ID ."");
							//$row = @mysqli_fetch_object($sql);
							$image_path = find_a_field('personnel_basic_info', 'PBI_PICTURE_ATT_PATH', 'PBI_ID="' . $PBI_ID . '"');
							if ($image_path !== "") {
								?>

								<img src="../assets/img/user1.png" alt=""
									style=" width: 40px; height:40px; border-radius: 50%;">


								<?php /*?>		<img src="../../../assets/support/upload_view.php?name=<?=$image_path?>&folder=hrm_emp_pic&proj_id=<?=$cid1?>&mod=hrm_mod" alt="#" style=" width: 40px; height:40px; border-radius: 50%;">  <?php */ ?>



							<? } else { ?>

								<img src="../assets/img/user1.png" alt=""
									style=" width: 40px; height:40px; border-radius: 50%;">

							<? } ?>
						</a>
					</div>

				</div>

				<div class="col-auto">
					<div class="logo-small">
						<img src="../../../../public/uploads/logo/<?= $cid1 ?>.png" alt="" />

					</div>

				</div>

			</div>

		</header>

		<!-- Header ends -->



		<div id="mymodel" class="model">
			<div class="model-content" style=" position: fixed; overflow: scroll;">
				<div class="modal-header">
					<span class="close" data-close="model"
						style=" font-size: 32px !important; position: fixed; margin-top: 30px; ">&times;</span>
				</div>
				<div class="modal-body p-0">
					<div class="ds-top"></div>
					<style>
						.close {
							color: #fff;
						}

						.ds-top {
							/*				position: absolute;*/
							margin: auto;
							top: 0;
							right: 0;
							left: 0;
							width: 100%;
							height: 110px;
							/*background: crimson;*/
							background: #1a3961;
							animation: dsTop 1.5s;
						}

						.avatar-holder {
							position: absolute;
							margin: auto;
							top: 30px;
							right: 0;
							left: 0;
							width: 150px;
							height: 150px;
							border-radius: 50%;
							border: 4px solid #e8efde;
							box-shadow: -1px 2px 14px 1px rgba(0, 0, 0, 0.51);
							-webkit-box-shadow: -1px 2px 14px 1px rgba(0, 0, 0, 0.51);
							-moz-box-shadow: -1px 2px 14px 1px rgba(0, 0, 0, 0.51);

							/*				box-shadow: 0 0 0 5px #151515, inset 0 0 0 5px #000000,
				  inset 0 0 0 5px #000000, inset 0 0 0 5px #000000, inset 0 0 0 5px #000000;*/
							background: white;
							overflow: hidden;
							animation: mvTop 1.5s;
						}

						img {
							width: 100%;
							height: 100%;
							object-fit: cover;
						}

						.name {
							text-align: center;
							font-weight: bold;
						}

						.sub-desi {
							text-align: center;
							color: #CCCCCC;
							font-weight: 600;
						}

						.pt {
							padding-top: 85px;
						}

						.new1 {
							display: flex;
							border: 1px solid rgba(0, 0, 0, 0.125);
							border-radius: 5px;
						}

						.span-em {
							color: #818c99;
							font-weight: 700;
							font-size: 12px;
						}

						.span-em1 {
							font-weight: 600;
						}
					</style>
					<div class="avatar-holder">
						<?
						//$sql =  @db_query("select PBI_NAME,PBI_PICTURE_ATT_PATH,DEPT_ID,DESG_ID,PBI_NID_ATT_PATH from  personnel_basic_info where PBI_ID = ".$PBI_ID ."");
						//$row = @mysqli_fetch_object($sql);
						$image_path = find_a_field('personnel_basic_info', 'PBI_PICTURE_ATT_PATH', 'PBI_ID="' . $PBI_ID . '"');
						if ($image_path !== "") {
							?>
							<img src="../../../assets/support/upload_view.php?name=<?= $image_path ?>&folder=hrm_emp_pic&proj_id=<?= $cid1 ?>&mod=hrm_mod"
								alt="#">
						<? } else { ?>

							<img src="../assets/img/user1.png" alt="">

						<? } ?>

					</div>

					<div class="container-fluid pt pb-3">
						<h3 class="name"><? echo $basic->PBI_NAME; ?></h3>
						<p class="sub-desi"><span><? echo $basic->PBI_DESIGNATION; ?></span></p>


						<div class="new1 pt-1 pb-1 mt-2">
							<div class="d-flex justify-content-end align-items-center">
								<i class="nav-icon bi bi-hash size-22 p-2"></i>
							</div>

							<div>
								<span class="span-em">Employe ID</span>
								<p class="span-em1"><? echo $basic->PBI_CODE; ?></p>
							</div>
						</div>


						<div class="new1 pt-1 pb-1 mt-2">
							<div class="d-flex justify-content-end align-items-center">
								<i class="nav-icon bi bi-person-fill size-22 p-2"></i>
							</div>

							<div>
								<span class="span-em">Employe Name</span>
								<p class="span-em1"><? echo $basic->PBI_NAME; ?></p>
							</div>
						</div>


						<div class="new1 pt-1 pb-1 mt-2">
							<div class="d-flex justify-content-end align-items-center">
								<i class="nav-icon bi bi-award-fill size-22 p-2"></i>
							</div>

							<div>
								<span class="span-em">Designation</span>
								<p class="span-em1"><? echo $basic->PBI_DESIGNATION; ?></p>
							</div>
						</div>


						<div class="new1 pt-1 pb-1 mt-2">
							<div class="d-flex justify-content-end align-items-center">
								<i class="nav-icon bi bi-diagram-2-fill size-22 p-2"></i>
							</div>

							<div>
								<span class="span-em">Department</span>
								<p class="span-em1"><? echo $basic->PBI_DEPARTMENT; ?></p>
							</div>
						</div>


						<div class="new1 pt-1 pb-1 mt-2">
							<div class="d-flex justify-content-end align-items-center">
								<i class="nav-icon bi bi-calendar3 size-22 p-2"></i>
							</div>

							<div>
								<span class="span-em">Joining Date</span>
								<p class="span-em1"><? echo $basic->PBI_DOJ; ?></p>
							</div>
						</div>

						<div class="new1 pt-1 pb-1 mt-2">
							<div class="d-flex justify-content-end align-items-center">
								<i class="nav-icon bi bi-calendar3 size-22 p-2"></i>
							</div>

							<div>
								<span class="span-em">Service Length</span>
								<p class="span-em1">

									<?
									$ddd = date("Y-m-d");
									$date1 = new DateTime($basic->PBI_DOJ);
									$date2 = new DateTime($ddd);
									$diff = $date1->diff($date2);
									echo $diff->y . " years, " . $diff->m . " months, " . $diff->d . " days";
									?>
								</p>
							</div>
						</div>


						<div class="new1 pt-1 pb-1 mt-2">
							<div class="d-flex justify-content-end align-items-center">
								<i class="nav-icon bi bi-person-check-fill size-22 p-2"></i>
							</div>

							<div>
								<span class="span-em">Incharge</span>
								<p class="span-em1">
									<?= find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID="' . $basic->incharge_id . '"'); ?>
								</p>
							</div>
						</div>


					</div>


				</div>
			</div>
		</div>