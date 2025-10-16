<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>Secondary Sales</title>
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
        <!--<? if($title =="home"){ ?>-->
    <!--<? } else { ?>-->
    <!--<div class="header header-fixed header-logo-center">-->
    <!--    <a href="../main/home.php" class="header-title"> <?=$title;?> </a>-->
    <!--    <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>-->
    <!--    <a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-lightbulb"></i></a>-->
    <!--</div>-->
    <!--<? } ?>-->
    
    <? if($title =="home"){ ?>
	
	
				<div class="header header-fixed header-logo-center">
			<!-- <a href="../main/home.php" class="header-title">  </a>-->
			<a data-menu="menu-sidebar-left-1" href="#" class="header-icon header-icon-1 new_bt_data"><i class="fa-solid fa-bars menu1"></i> <strong class="titel-header-ss"></strong> </a>
			<!--<a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-lightbulb"></i></a>-->
		</div>
	
	
	
    <? } else { ?>
    <div class="header header-fixed header-logo-center">
       <!-- <a href="../main/home.php" class="header-title">  </a>-->
        <a data-menu="menu-sidebar-left-1" href="#" class="header-icon header-icon-1"><i class="fa-solid fa-bars"></i> <strong class="titel-header-ss"><?=$title;?></strong> </a>
        <!--<a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-lightbulb"></i></a>-->
    </div>
    <? } ?>
    <!----------------------------------------------------------------
    ------------------------- Head top end ---------------------------
    ----------------------------------------------------------------->
    
    

    <!----------------------------------------------------------------
    ----------------------- footer menu start ------------------------
    ----------------------------------------------------------------->
    <div id="footer-bar" class="footer-bar-1">
        <!--<a href="../main/home.php" class="active-nav"><i class="fa fa-home"></i><span>Home</span></a>-->
        <!--<a href="../file/do.php"><i class="fa fa-heart"></i><span>Order Entry</span></a>-->
        <!--<a data-menu="menu-sidebar-left-1" href="#"><i class="fa font-14 fa-align-left color-yellow-dark"></i><span>Features</span></a>-->
        <!--<a href="../file/chalan_list.php"><i class="fa fa-search"></i><span>Delivery List</span></a>-->
        <!--<a href="#" data-menu="menu-settings"><i class="fa fa-cog"></i><span>Settings</span></a>-->
        
        		
        <a href="../main/home.php" class="active-nav"><i class="fa fa-home"></i><span>Home</span></a>
        <a href="../file/daily_attendance.php"><i class="fa-thin fa-calendar-circle-user"></i><span>Attendence</span></a>
        <a href="../file/order_list.php"><i class="fa-thin fa-cube"></i><span>Order</span></a>
        <a href="../file/chalan_list.php"><i class="fa-thin fa-cart-shopping-fast"></i><span>Delivery</span></a>
		<a href="../file/report_list.php"><i class="fa-thin fa-list-dropdown"></i><span>Report</span></a>
		
        
        
        
        
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
        <!--<div class="ps-3 pe-3 pt-0 mt-2 mb-2">-->
		<div class="ps-3 pe-3 pt-0 mt-3 mb-2">
            <div class="d-flex">
                <div class="me-3">
                    <!--<img src="../assets/images/preload-logo.png" width="43">-->
					<img src="../assets/images/user.gif" style=" height: 50px; width: 50px; ">
                </div>
                <div class="flex-grow-1">
                    <h1 class="font-16 font-700 mb-0"><?=$_SESSION['user']['fname'];?> (<?=$_SESSION['user']['username'];?>)</h1>
					<?
						$region_name = find1("select BRANCH_NAME from branch where BRANCH_ID='" . $_SESSION['user']['region_id']. "'");
						$zone_name = find1("select ZONE_NAME from zon where ZONE_CODE='" .$_SESSION['user']['zone_id']. "'");
						$area_name = find1("select AREA_NAME from area where AREA_CODE='" . $_SESSION['user']['area_id'] . "'");
					?>
                    <p class="mt-n2 m-0 font-10 font-400"><?= $region_name ?>-<?= $zone_name ?>-<?= $area_name ?></p>
                </div>
            </div>
        </div>

        <div class="me-3 ms-3">		
		<hr style=" margin: 0px; border: 1px solid #0069b5; "/>	
			<!--Admin menu-->
			<?php if($_SESSION['user']['level']==0){?>
				<div class="list-group list-custom-small list-icon-0">
                <a href="../main/home.php">
                   <img src="../assets/images/home/dashboard.gif" style=" height: 20px; width: 20px; ">
                    <span>Dashboard<?=$_SESSION['user']['lavel']?></span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				
				
				<!--this is menu 2 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-2">					
						<i class="fa-solid fa-person-booth font-14"   style="color: #42cdb1;"></i>
                        <span class="font-14">Attendance Manage</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-2">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/daily_attendance.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Daily Attendance</span>
                            <i class="fa fa-angle-right"></i>
                        </a>  
						
						<a href="../file/attendance.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Attendance(Pic)</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
                        
                        <a href="../file/daily_attendance_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Attendance Status</span>
                            <i class="fa fa-angle-right"></i>
                        </a>  
						                        
                        <a href="../file/daily_attendance_status_approved.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Attendance Approved </span>
                            <i class="fa fa-angle-right"></i>
                        </a> 
						
						<a href="../file/daily_attendance_approved_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Attendance Approved Status</span>
                            <i class="fa fa-angle-right"></i>
                        </a>        
						       
                    </div>
                </div>
			
				<!--this is menu 2 End-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-10">
						<i class="fa-solid fa-store font-14" style="color: #a3ea5d;"></i>
                        <span class="font-14">Leave Manage</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
				<div class="collapse" id="collapse-10">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/leave.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Leave Entry</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/leave_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Leave Status</span>
                            <i class="fa fa-angle-right"></i>
                        </a>                 
                    </div>
                </div>
				
				
				<!--this is menu 3 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-3">
						<i class="fa-solid fa-store font-14" style="color: #a3ea5d;"></i>
                        <span class="font-14">Shop Settings</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-3">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/setup_opening.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Opening Entry</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/new_shop.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>New Shop</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
							<a href="../file/shop_list.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Shop List</span>
                            <i class="fa fa-angle-right"></i>
                        </a>       
						       
                    </div>
                </div>
				<!--this is menu 3 End-->	
				
				
				<!--this is menu 1 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-1">
						<i class="fa-solid fa-cart-plus font-14 color-blue-dark"></i>
                        <span class="font-14">Order Manage</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-1">
                    <div class="list-group list-custom-small ps-3">
                        
						  <a href="../file/do.php">
                            <i class="fa-solid fa-rectangle-list font-14" style="color: #51e692;"></i>
                            <span>Schedule Route</span>
                            <i class="fa fa-angle-right"></i>
                        </a> 
						<a href="../file/select_shop.php">
                           <i class="fa-solid fa-route font-14" style="color: #6e3df5;"></i>
                            <span>Unschedule Route)</span>
                            <i class="fa fa-angle-right"></i>
                        </a>        
						<a href="../file/do_list.php">
                            <i class="fa-solid fa-clock-rotate-left font-14  " style="color: #c1f05c;"></i>
                            <span>Pending Delivery List</span>
                            <i class="fa fa-angle-right"></i>
                        </a>  
<!--							<a href="../file/do_list_booking.php">
							<i class="fa-solid fa-spinner font-14" style="color: #c1f05c;"></i>
                            <span>Pending Booking List</span>
                            <i class="fa fa-angle-right"></i>
                        </a> --> 
						
						<a href="../file/chalan_list.php">
                           
							<i class="fa-solid fa-truck font-14" style="color: #f2cc63;"></i>
                            <span>Delivery List</span>
                            <i class="fa fa-angle-right"></i>
                        </a>  
						
						<a href="../file/do_status.php">
                           <i class="fa-solid fa-list font-14 "  style="color: #c1f05c;"></i>
                            <span>Order List</span>
                            <i class="fa fa-angle-right"></i>
                        </a>  
						
						<a href="../file/do_hold.php">
                           <i class="fa-solid fa-list font-14 "  style="color: #c1f05c;"></i>
                            <span>Hold List</span>
                            <i class="fa fa-angle-right"></i>
                        </a>  
							   
                    </div>
                </div>
			
				<!--this is menu 1 End-->
				

				
								
				<!--this is menu 5 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-5">
						<i class="fa-solid fa-bag-shopping font-14 color-blue-dark"></i>
                        <span class="font-14">Sales Return</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-5">
                    <div class="list-group list-custom-small ps-3">
						<!--<a href="../file/return_sales.php?pal=2">-->
                        <a href="../file/return_list.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Return Entry</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/return_sales_unfinished.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Return Hold</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						
						<a href="../file/return_sales_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Return Report</span>
                            <i class="fa fa-angle-right"></i>
                        </a>       
						       
                    </div>
                </div>
			
				<!--this is menu 5 End-->
				
				
				

				
				<!--this is menu 8 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-8">
						<i class="fa-solid fa-bookmark font-14" style="color: #ec6f81;"></i>
                        <span class="font-14">Replace Return</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-8">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/other_receive.php?pal=2">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Replace Return Entry</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/other_receive_unfinished.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Hold</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						
						<a href="../file/other_receive_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Replace Return Report</span>
                            <i class="fa fa-angle-right"></i>
                        </a>       
						       
                    </div>
                </div>
				<!--this is menu 8 End-->
				

				
				
				
				
				<!--this is menu 4 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-4">
						<i class="fa-solid fa-cart-arrow-down font-14" style="color: #ec6f81;"></i>
                        <span class="font-14">Damage Manage</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-4">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/damage_entry.php?pal=2">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Damage Entry</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/damage_unfinished.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Damage Hold</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						
						<a href="../file/damage_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Damage Report</span>
                            <i class="fa fa-angle-right"></i>
                        </a>       
						       
                    </div>
                </div>
				<!--this is menu 4 End-->
				
				
				
				<!--this is menu 6 start-->
				
				<!--<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-9">
						<i class="fa-solid fa-gift font-14" style="color: #ec6f81;"></i>
                        <span class="font-14">Gift Manage</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-9">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/select_outlet.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Select Outlate</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/gift_unfinished.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Gift Hold</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						
						<a href="../file/gift_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Gift Report</span>
                            <i class="fa fa-angle-right"></i>
                        </a>       
						       
                    </div>
                </div>-->
				
				<!--this is menu 6 End-->
				
				
								
				<!--this is menu 6 start-->
				
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-6">
						<i class="fa font-14 fa-cog color-blue-dark"></i>
                        <span class="font-14">Primary DO</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-6">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/so.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>New Sales Order</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/select_unfinished_do.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Select unfinished Do</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						
						<a href="../file/sales_invoice_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Sales Order Status</span>
                            <i class="fa fa-angle-right"></i>
                        </a>       
						       
                    </div>
                </div>
				
				<!--this is menu 6 End-->
				
							<!--this is menu 7 start-->
					
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-7">
						<i class="fa-solid fa-receipt font-14"   style="color: #42cdb1;"></i>
                        <span class="font-14">Report</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-7">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/report_list.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>All Reports</span>
                            <i class="fa fa-angle-right"></i>
                        </a>       
						       
                    </div>
                </div>
				<? } ?>
				<!--this is menu 7 End-->
				
				
				
				
				
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
			<!--Admin menu End-->
			
			<?php if($_SESSION['user']['level']==1){?>
            <div class="list-group list-custom-small list-icon-0">
                <a href="../main/home.php">
                    <i class="fa font-14 fa-star color-yellow-dark"></i>
                    <span>Dashboard<?=$_SESSION['user']['lavel']?></span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				<!--this is menu 1 start-->
				
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-1">
						<i class="fa font-14 fa-cog color-blue-dark"></i>
                        <span class="font-14">Order Manage</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-1">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/do.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Order Entry</span>
                            <i class="fa fa-angle-right"></i>
                        </a>        
						<a href="../file/do_list.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Pending Delivery List</span>
                            <i class="fa fa-angle-right"></i>
                        </a>  
						
						<a href="../file/chalan_list.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Delivery List</span>
                            <i class="fa fa-angle-right"></i>
                        </a>  
						
						<a href="../file/do_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Order List</span>
                            <i class="fa fa-angle-right"></i>
                        </a>  
							   
                    </div>
                </div>
			
				<!--this is menu 1 End-->
				
				
				<!--this is menu 2 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-2">
						<i class="fa font-14 fa-cog color-blue-dark"></i>
                        <span class="font-14">Attendance Manage</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-2">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/daily_attendance.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Daily Attendance</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/attendance.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Attendance(Pic)</span>
                            <i class="fa fa-angle-right"></i>
                        </a>         
						       
                    </div>
                </div>
				<? }	?>
				<!--this is menu 2 End-->
				
				<? if($_SESSION['user']['level']==2){?>		
				<!--this is menu 3 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-3">
						<i class="fa font-14 fa-cog color-blue-dark"></i>
                        <span class="font-14">Shop Settings</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-3">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/setup_opening.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Opening Entry</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/new_shop.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>New Shop</span>
                            <i class="fa fa-angle-right"></i>
                        </a>         
						       
                    </div>
                </div>
				<!--this is menu 3 End-->
				
				
				
				
				
				<!--this is menu 4 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-8">
						<i class="fa font-14 fa-cog color-blue-dark"></i>
                        <span class="font-14">Damage Manage</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-8">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/damage_entry.php?pal=2">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Damage Entry</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/damage_unfinished.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Damage Hold</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						
						<a href="../file/damage_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Damage Report</span>
                            <i class="fa fa-angle-right"></i>
                        </a>       
						       
                    </div>
                </div>
				<!--this is menu 4 End-->
				
								
				<!--this is menu 5 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-5">
						<i class="fa font-14 fa-cog color-blue-dark"></i>
                        <span class="font-14">Sales Return</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-5">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/return_sales.php?pal=2">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Return Entry</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/return_sales_unfinished.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Return Hold</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						
						<a href="../file/return_sales_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Return Report</span>
                            <i class="fa fa-angle-right"></i>
                        </a>       
						       
                    </div>
                </div>
				<? }	?>
				<!--this is menu 5 End-->
				
				
								
				<!--this is menu 6 start-->
				<? if($_SESSION['user']['level']==3){?>
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-6">
						<i class="fa font-14 fa-cog color-blue-dark"></i>
                        <span class="font-14">Primary DO</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-6">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/so.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>New Sales Order</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						<a href="../file/select_unfinished_do.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Select unfinished Do</span>
                            <i class="fa fa-angle-right"></i>
                        </a>   
						
						<a href="../file/sales_invoice_status.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>Sales Order Status</span>
                            <i class="fa fa-angle-right"></i>
                        </a>       
						       
                    </div>
                </div>
				<? }	?>
				<!--this is menu 6 End-->
				
							<!--this is menu 7 start-->
						<? if($_SESSION['user']['level']==4){?>
				<div class="list-group list-custom-small list-icon-0">
                    <a data-bs-toggle="collapse" class="no-effect" href="#collapse-7">
						<i class="fa font-14 fa-cog color-blue-dark"></i>
                        <span class="font-14">Report</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-7">
                    <div class="list-group list-custom-small ps-3">
                        <a href="../file/report_list.php">
                            <i class="fa font-14 fa-file color-brown-dark"></i>
                            <span>All Reports</span>
                            <i class="fa fa-angle-right"></i>
                        </a>       
						       
                    </div>
                </div>
				<? }	?>
				<!--this is menu 7 End-->
				
				
				
								
				<!--this is menu 8 start-->
				<div class="list-group list-custom-small list-icon-0">
                    <a  href="../main/logout.php">
						<i class="fa font-14 fa-cog color-blue-dark"></i>
                        <span class="font-14">Log Out</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
				
                </div>
				<!--this is menu 8 End-->
				
				
				
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
            
    <!----------------------------------------------------------------
    ----------------------- Sidebar menu end -------------------------
    ----------------------------------------------------------------->
    

    
    
    
    
    
    
    
    
    
    
    
    
    
        
    <!----------------------------------------------------------------
    ----------- now start setting modale menu settings ---------------
    ----------------------------------------------------------------->
    
    <!-- All Menus, Action Sheets, Modals, Notifications, Toasts, Snackbars get Placed outside the <div class="page-content"> -->
    <!--<div id="menu-settings" class="menu menu-box-bottom menu-box-detached">
        <div class="menu-title mt-0 pt-0"><h1>Settings</h1><p class="color-highlight">Flexible and Easy to Use</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
        <div class="divider divider-margins mb-n2"></div>
        <div class="content">
            <div class="list-group list-custom-small">
                <a href="#" data-toggle-theme data-trigger-switch="switch-dark-mode" class="pb-2 ms-n1">
                    <i class="fa font-12 fa-moon rounded-s bg-highlight color-white me-3"></i>
                    <span>Dark Mode</span>
                    <div class="custom-control scale-switch ios-switch">
                        <input data-toggle-theme type="checkbox" class="ios-input" id="switch-dark-mode">
                        <label class="custom-control-label" for="switch-dark-mode"></label>
                    </div>
                    <i class="fa fa-angle-right"></i>
                </a>    
            </div>
            <div class="list-group list-custom-large">
                <a data-menu="menu-highlights" href="#">
                    <i class="fa font-14 fa-tint bg-green-dark rounded-s"></i>
                    <span>Page Highlight</span>
                    <strong>16 Colors Highlights Included</strong>
                    <span class="badge bg-highlight color-white">HOT</span>
                    <i class="fa fa-angle-right"></i>
                </a>        
                <a data-menu="menu-backgrounds" href="#" class="border-0">
                    <i class="fa font-14 fa-cog bg-blue-dark rounded-s"></i>
                    <span>Background Color</span>
                    <strong>10 Page Gradients Included</strong>
                    <span class="badge bg-highlight color-white">NEW</span>
                    <i class="fa fa-angle-right"></i>
                </a>        
            </div>
        </div>
    </div>-->
    <!-- Menu Settings Highlights-->
    <!--<div id="menu-highlights" class="menu menu-box-bottom menu-box-detached">
        <div class="menu-title"><h1>Highlights</h1><p class="color-highlight">Any Element can have a Highlight Color</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
        <div class="divider divider-margins mb-n2"></div>
        <div class="content">
            <div class="highlight-changer">
                <a href="#" data-change-highlight="blue"><i class="fa fa-circle color-blue-dark"></i><span class="color-blue-light">Default</span></a>
                <a href="#" data-change-highlight="red"><i class="fa fa-circle color-red-dark"></i><span class="color-red-light">Red</span></a>    
                <a href="#" data-change-highlight="orange"><i class="fa fa-circle color-orange-dark"></i><span class="color-orange-light">Orange</span></a>    
                <a href="#" data-change-highlight="pink2"><i class="fa fa-circle color-pink2-dark"></i><span class="color-pink-dark">Pink</span></a>    
                <a href="#" data-change-highlight="magenta"><i class="fa fa-circle color-magenta-dark"></i><span class="color-magenta-light">Purple</span></a>    
                <a href="#" data-change-highlight="aqua"><i class="fa fa-circle color-aqua-dark"></i><span class="color-aqua-light">Aqua</span></a>      
                <a href="#" data-change-highlight="teal"><i class="fa fa-circle color-teal-dark"></i><span class="color-teal-light">Teal</span></a>      
                <a href="#" data-change-highlight="mint"><i class="fa fa-circle color-mint-dark"></i><span class="color-mint-light">Mint</span></a>      
                <a href="#" data-change-highlight="green"><i class="fa fa-circle color-green-light"></i><span class="color-green-light">Green</span></a>    
                <a href="#" data-change-highlight="grass"><i class="fa fa-circle color-green-dark"></i><span class="color-green-dark">Grass</span></a>       
                <a href="#" data-change-highlight="sunny"><i class="fa fa-circle color-yellow-light"></i><span class="color-yellow-light">Sunny</span></a>    
                <a href="#" data-change-highlight="yellow"><i class="fa fa-circle color-yellow-dark"></i><span class="color-yellow-light">Goldish</span></a>
                <a href="#" data-change-highlight="brown"><i class="fa fa-circle color-brown-dark"></i><span class="color-brown-light">Wood</span></a>    
                <a href="#" data-change-highlight="night"><i class="fa fa-circle color-dark-dark"></i><span class="color-dark-light">Night</span></a>
                <a href="#" data-change-highlight="dark"><i class="fa fa-circle color-dark-light"></i><span class="color-dark-light">Dark</span></a>
                <div class="clearfix"></div>
            </div>
            <a href="#" data-menu="menu-settings" class="mb-3 btn btn-full btn-m rounded-sm bg-highlight shadow-xl text-uppercase font-900 mt-4">Back to Settings</a>
        </div>
    </div>-->    
    <!-- Menu Settings Backgrounds-->
    <!--<div id="menu-backgrounds" class="menu menu-box-bottom menu-box-detached">
        <div class="menu-title"><h1>Backgrounds</h1><p class="color-highlight">Change Page Color Behind Content Boxes</p><a href="#" class="close-menu"><i class="fa fa-times"></i></a></div>
        <div class="divider divider-margins mb-n2"></div>
        <div class="content">
            <div class="background-changer">
                <a href="#" data-change-background="default"><i class="bg-theme"></i><span class="color-dark-dark">Default</span></a>
                <a href="#" data-change-background="plum"><i class="body-plum"></i><span class="color-plum-dark">Plum</span></a>
                <a href="#" data-change-background="magenta"><i class="body-magenta"></i><span class="color-dark-dark">Magenta</span></a>
                <a href="#" data-change-background="dark"><i class="body-dark"></i><span class="color-dark-dark">Dark</span></a>
                <a href="#" data-change-background="violet"><i class="body-violet"></i><span class="color-violet-dark">Violet</span></a>
                <a href="#" data-change-background="red"><i class="body-red"></i><span class="color-red-dark">Red</span></a>
                <a href="#" data-change-background="green"><i class="body-green"></i><span class="color-green-dark">Green</span></a>
                <a href="#" data-change-background="sky"><i class="body-sky"></i><span class="color-sky-dark">Sky</span></a>
                <a href="#" data-change-background="orange"><i class="body-orange"></i><span class="color-orange-dark">Orange</span></a>
                <a href="#" data-change-background="yellow"><i class="body-yellow"></i><span class="color-yellow-dark">Yellow</span></a>
                <div class="clearfix"></div>
            </div>
            <a href="#" data-menu="menu-settings" class="mb-3 btn btn-full btn-m rounded-sm bg-highlight shadow-xl text-uppercase font-900 mt-4">Back to Settings</a>
        </div>
    </div>-->


    <!----------------------------------------------------------------
    ---------------- end setting modale menu settings ----------------
    ----------------------------------------------------------------->



    
    