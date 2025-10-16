<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>Attendance Management</title>
<link rel="stylesheet" type="text/css" href="../assets/styles/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="../assets/styles/style.css"/>
<link rel="stylesheet" type="text/css" href="../assets/styles/select2.min.css"/>

<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../assets/fonts/css/fontawesome-all.min.css">    
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
<link rel="manifest" href="../assets/template/_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
<link rel="" href="../assets/template/_service-worker.js">
<link rel="apple-touch-icon" sizes="180x180" href="../assets/app/icons/icon-192x192.png">
</head>
    
<body class="theme-light" data-highlight="highlight-red" data-gradient="body-default">
    
<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>
    
<div id="page">
    
    <!----------------------------------------------------------------
    ----------------------- Head top start ---------------------------
    ----------------------------------------------------------------->
    <? if($title =="home"){ ?>
		<div class="header header-fixed header-logo-center">
			<a data-menu="menu-sidebar-left-1" href="#" class="header-icon header-icon-1 new_bt_data"><i class="fa-solid fa-bars menu1"></i> <strong class="titel-header-ss"></strong> </a>
		</div>
	
    <? } else { ?>
    <div class="header header-fixed header-logo-center">
        <a data-menu="menu-sidebar-left-1" href="#" class="header-icon header-icon-1"><i class="fa-solid fa-bars"></i> <strong class="titel-header-ss"><?=$title;?></strong> </a>
    </div>
    <? } ?>
    <!----------------------------------------------------------------
    ------------------------- Head top end ---------------------------
    ----------------------------------------------------------------->
    
    

    <!----------------------------------------------------------------
    ----------------------- footer menu start ------------------------
    ----------------------------------------------------------------->
    <div id="footer-bar" class="footer-bar-1">      
        <a href="../main/home.php" class="active-nav"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="../file/od_entry.php"><i class="fa-thin fa-briefcase"></i><span>OD Entry</span></a>
		<a href="../file/daily_attendance2.php"><i class="fa-thin fa-calendar-circle-user"></i><span>Attendence</span></a>
        <a href="../file/leave.php"><i class="fa-thin fa-mailbox"></i><span>Leave Entry</span></a>
		<a href="../file/att_location_report.php"><i class="fa-thin fa-list-dropdown"></i><span>Report</span></a>
    </div>
    <!----------------------------------------------------------------
    ----------------------- footer menu end --------------------------
    ----------------------------------------------------------------->
    
    

    <!----------------------------------------------------------------
    ----------------------- Sidebar menu start -----------------------
    ----------------------------------------------------------------->
    <div id="menu-sidebar-left-1" class="bg-white menu menu-box-left" data-menu-width="310">
<!--        <div class="d-flex flex-row-reverse">
            <a href="#" class="close-menu  icon icon-m text-center color-red-dark "><i class="fa font-12 fa-times"></i></a>
        </div>-->
        <div class="ps-3 pe-3 pt-0 mt-3 mb-2">
            <div class="d-flex">
                <div class="me-3">
                    <img src="../assets/images/user.gif" style=" height: 50px; width: 50px; ">
                </div>
                <div class="flex-grow-1">
                    <h1 class="font-16 font-700 mb-0"><?=$_SESSION['user']['fname'];?> (<?=$_SESSION['user']['username'];?>)</h1>
                    <p class="mt-n2 m-0 font-10 font-400">Software Engineer</p>
                </div>
            </div>
        </div>

        <div class="me-3 ms-3">
		<hr style=" margin: 0px; border: 1px solid #0069b5; "/>
            <!--<span class="text-uppercase font-900 font-11 opacity-30">Navigation</span>-->
            <div class="list-group list-custom-small list-icon-0">
                <a href="../main/home.php">
                     <img src="../assets/images/home/dashboard.png" style="width: 25px; height: 25px;"/>
                    <span>Dashboard</span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				<!--this is menu 1 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a href="../file/task_manage.php">
						 <img src="../assets/images/home/task.png" style="width: 25px; height: 25px;"/>
                        <span class="font-14">Task Management</span>
                        <i class="fa fa-angle-right"></i>
                    </a>        
                </div>
				<!--this is menu 1 start-->
<!--				<div class="list-group list-custom-small list-icon-0">
                    <a href="../file/Conveyance_manage.php">
						<i class="fa font-14 fa-star color-yellow-dark"></i>
                        <span class="font-14">Conveyance Management</span>
                        <i class="fa fa-angle-right"></i>
                    </a>        
                </div>-->
				
				
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-1">
						 <img src="../assets/images/home/attendance.png" style="width: 25px; height: 25px;"/>
                        <span class="font-14">Attendance</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-1">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/daily_attendance2.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Daily Attendance</span>
                            <i class="fa fa-angle-right"></i>
                        </a> 
                        <a href="../file/attendance.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Daily Attendance (Pic)</span>
                            <i class="fa fa-angle-right"></i>
                        </a> 
						 <a href="../file/att_report.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Punch Status</span>
                            <i class="fa fa-angle-right"></i>
                        </a> 
						<a href="../file/att_location_report.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Attendance Report</span>
                            <i class="fa fa-angle-right"></i>
                        </a> 
						       
						       
                    </div>
                </div>
				<!--this is menu 1 End-->
				
				
				<!--this is menu 2 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-2">
					 <img src="../assets/images/home/time-management.png" style="width: 25px; height: 25px;"/>
                        <span class="font-14">Leave & IOM & OD</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>

                <div class="collapse" id="collapse-2">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/leave.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Leave Entry</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/short_leave.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Half Day Leave</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
						<a href="../file/iom_entry.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>IOM Entry</span>
                            <i class="fa fa-angle-right"></i>
                        </a>    
                        
                        <a href="../file/od_entry.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>OD Entry</span>
                            <i class="fa fa-angle-right"></i>
                        </a> 
						       
                    </div>
                </div>
				<!--this is menu 2 End-->
				
							
				<!--this is menu 3 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-3">
					 <img src="../assets/images/home/status.png" style="width: 25px; height: 25px;"/>
                        <span class="font-14">Leave & Iom Status</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-3">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/leave_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Leave Status</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/iom_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Iom Status</span>
                            <i class="fa fa-angle-right"></i>
                        </a>         
						       
                    </div>
                </div>
				<!--this is menu 3 End-->
				
				
				
				
				
				
				<!--this is menu 4 start-->
				<!--<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-4">
						<i class="fa font-14 fa-cog color-blue-dark"></i>
                        <span class="font-14">Reporting Auth. Approval</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-4">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/view_leave_incharge.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Leave</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/view_iom_incharge.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Iom</span>
                            <i class="fa fa-angle-right"></i>
                        </a>         
						       
                    </div>
                </div>-->
				<!--this is menu 4 End-->
				
				
				
				<!--this is menu 5 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-5">
					 <img src="../assets/images/home/survey.png" style="width: 25px; height: 25px;"/>
                        <span class="font-14">Reports</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-5">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/attendance_report.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Attendance Report</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/apps_od_report.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>TA/DA Report</span>
                            <i class="fa fa-angle-right"></i>
                        </a>  
						<a href="../file/apps_od_report_2.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>OD Report</span>
                            <i class="fa fa-angle-right"></i>
                        </a>         
						       
                    </div>
                </div>
				<!--this is menu 5 End-->
				
				<div class="list-group list-custom-small list-icon-0">
                    <a  href="../main/logout.php">
				 <img src="../assets/images/home/logout.png" style="width: 25px; height: 25px;"/>
                        <span class="font-14">Log Out</span>
                       <i class="fa fa-angle-right"></i>
                    </a>        
                </div>
				
				
				
				
				
				
				
				
				
				
				
				
<!--                <a href="#">
                    <i class="fa font-14 fa-cog color-blue-dark"></i>
                    <span>Components</span>
                    <span class="badge bg-red-dark">NEW</span>
                    <i class="fa fa-angle-right"></i>
                </a>
                <a href="#">
                    <i class="fa font-14 fa-file color-brown-dark"></i>
                    <span>Pages</span>
                    <i class="fa fa-angle-right"></i>
                </a>
                <a href="#">
                    <i class="fa font-14 fa-camera color-green-dark"></i>
                    <span>Media</span>
                    <i class="fa fa-angle-right"></i>
                </a>
                <a href="#" class="border-0">
                    <i class="fa font-14 fa-image color-teal-dark"></i>
                    <span>Contact</span>
                    <i class="fa fa-angle-right"></i>
                </a>-->
            </div>
        </div>
        </div>

    </div>
            
    <!----------------------------------------------------------------
    ----------------------- Sidebar menu end -------------------------
    ----------------------------------------------------------------->
