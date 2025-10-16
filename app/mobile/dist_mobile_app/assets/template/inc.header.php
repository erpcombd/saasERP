<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />

<title>Distributor Portal</title>

<link rel="stylesheet" type="text/css" href="../assets/styles/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="../assets/styles/style.css"/>
<link rel="stylesheet" type="text/css" href="../assets/styles/select2.min.css"/>

<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../assets/fonts/css/fontawesome-all.min.css">    
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
<link rel="manifest" href="../assets/template/_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">

<!--<link rel="" href="../assets/template/_service-worker.js">-->
<!--<link rel="apple-touch-icon" sizes="180x180" href="../assets/app/icons/icon-192x192.png">-->
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
        
        <a href="../main/home.php" <? if($menu == 'home'){?>class="active-nav"<? } ?>><i class="fa fa-home"></i><span>Home</span></a>
        <a href="../file/do_status.php"  <? if($menu == 'order'){?>class="active-nav"<? } ?>><i class="fa-thin fa-calendar-circle-user"></i><span>Order List</span></a>
        <a href="../file/shop_list.php" <? if($menu == 'shop'){?>class="active-nav"<? } ?>><i class="fa-thin fa-cube"  ></i><span>Shop List</span></a>
        <a href="../file/chalan_list.php"  <? if($menu == 'challan'){?>class="active-nav"<? } ?>><i class="fa-thin fa-cart-shopping-fast"></i><span>Delivery List</span></a>
		<a href="../file/report_list.php"  <? if($menu == 'report'){?>class="active-nav"<? } ?>><i class="fa-thin fa-list-dropdown"></i><span>Report</span></a>
		<a href="../file/update_password.php"  <? if($menu == 'update_password'){?>class="active-nav"<? } ?>><i class="fa-thin fa-user-gear"></i><span>My Profile</span></a>
		
    </div>
    <!----------------------------------------------------------------
    ----------------------- footer menu end --------------------------
    ----------------------------------------------------------------->
    
    

    <!----------------------------------------------------------------
    ----------------------- Sidebar menu start -----------------------
    ----------------------------------------------------------------->
    <div id="menu-sidebar-left-1" class="bg-white menu menu-box-left" data-menu-width="310">
        <!--<div class="d-flex flex-row-reverse">
            <a href="#" class="close-menu  icon icon-m text-center color-red-dark "><i class="fa font-12 fa-times"></i></a>
        </div>-->
        <div class="ps-3 pe-3 pt-0 mt-2 mb-2">
            <div class="d-flex pt-3">
                <div class="me-3">
                    <img src="../assets/images/profile.png" width="43">
                </div>
                <div class="flex-grow-1">
                    <h1 class="font-15 font-700 mb-0 titel_sub"><?=$_SESSION['user']['fname'];?> (<?=$_SESSION['user']['username'];?>)</h1>
                    <p class="mt-n2 m-0 font-11 font-400"><strong>Address:</strong> <?=$_SESSION['user']['address'];?></p>
                </div>
            </div>
        </div>

        <div class="me-3 ms-3">
			
			<!--Admin menu-->
				<div class="list-group list-custom-small list-icon-0">
                <a href="../main/home.php">
                    <i class="fa font-14 fa-star color-yellow-dark"></i>
                    <span>Dashboard<?=$_SESSION['user']['lavel']?></span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
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
						 
                    </div>
                </div>				
				
				
				<!--this is menu 2 start-->
                <a href="../file/shop_list.php">
                    <i class="fa-solid fa-store font-14" style="color: #a3ea5d;"></i>
                    <span>Shop List </span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				<!--this is menu 3 start-->
                <a href="../file/other_receive_status.php">
                    <i class="fa-solid fa-bookmark font-14" style="color: #ec6f81;"></i>
                    <span>Replace Return Report </span>
                    <i class="fa fa-angle-right"></i>
                </a>				
								
				<!--this is menu 4 start-->
                <a href="../file/return_sales_status.php">
                    <i class="fa-solid fa-bag-shopping font-14 color-blue-dark"></i>
                    <span>Sales Return Report </span>
                    <i class="fa fa-angle-right"></i>
                </a>
				
				<!--this is menu 5 start-->
                <a href="../file/report_list.php">
                    <i class="fa-solid fa-receipt font-14" style="color: #42cdb1;"></i>
                    <span>Report </span>
                    <i class="fa fa-angle-right"></i>
                </a>
                
                <a href="../file/update_password.php">
                    <i class="fa-solid fa-user font-14" style="color: #42cdb1;"></i>
                    <span>My Profile </span>
                    <i class="fa fa-angle-right"></i>
                </a>                
				
				<!--this is menu 6 start-->
                <a href="../main/logout.php">
                    <i class="fa font-14 fa-cog color-blue-dark"></i>
                    <span>Log Out </span>
                    <i class="fa fa-angle-right"></i>
                </a>

            </div>
			<!--Admin menu End-->
                </div>

            </div>
        </div>

    </div>
            
    <!----------------------------------------------------------------
    ----------------------- Sidebar menu end -------------------------
    ----------------------------------------------------------------->


    <!----------------------------------------------------------------
    ---------------- end setting modale menu settings ----------------
    ----------------------------------------------------------------->



    
    