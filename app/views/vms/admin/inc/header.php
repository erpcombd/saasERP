<?php
session_start ();
$company_id     = $_SESSION['company_id'];
$level          = $_SESSION['level'];
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
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
	<link href="assets/css/custom.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
</head>

<body>
    <div class="screen-overlay"></div>
    
	
	
	<aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <a href="home.php" class="brand-wrap">
                <img src="../images/logo/<?php echo $company_id?>.png" class="logo" alt="Dashboard">
            </a>
            <div>
                <button class="btn btn-icon btn-aside-minimize"> <i class="text-muted material-icons md-menu_open"></i> </button>
            </div>
        </div>
        <nav>
            <ul class="menu-aside">
                <li class="menu-item">
                    <a class="menu-link" href="home.php"> <i class="icon material-icons md-home"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                
<?php if($level==5){ ?>
                <li class="menu-item has-submenu <?php if($menu=="Setup"){echo 'active';}?>">
                    <a class="menu-link" href="page-orders-1.php"> <i class="icon material-icons md-person"></i>
                        <span class="text">Setup</span>
                    </a>
                    <div class="submenu">
                        <a href="setup_company.php" <?php if($sub_menu=="company"){echo 'class="active"';}?>>Company Setup</a>
                        <a href="setup_department.php" <?php if($sub_menu=="department"){echo 'class="active"';}?>>Department Setup</a>
                        <a href="setup_card.php" <?php if($sub_menu=="card"){echo 'class="active"';}?>>Card Setup</a>
                        <a href="setup_user.php" <?php if($sub_menu=="new_user"){echo 'class="active"';}?>>User Setup</a>
                    </div>
                </li>
<?php } ?>
                
				
				<li class="menu-item has-submenu <?php if($menu=="Visitor"){echo 'active';}?>">
                    <a class="menu-link" href="page-orders-1.php"> <i class="icon material-icons md-person"></i>
                        <span class="text">Visitor Manage</span>
                    </a>
                    <div class="submenu">
<?php if($level==5){ ?>                        
<a href="visitor_out.php" target="_blank" <?php if($sub_menu=="visitor_out"){echo 'class="active"';}?>>Visitor Out Camera</a>
<?php } ?>                        
                        <a href="visitor_list.php" <?php if($sub_menu=="visitor_list"){echo 'class="active"';}?>>Visitor List</a>
                        <a href="visitor_entry.php" <?php if($sub_menu=="visitor_entry"){echo 'class="active"';}?>>New Visitor</a>
                    </div>
                </li>
                
                
                <li class="menu-item has-submenu <?php if($menu=="Report"){echo 'active';}?>">
                    <a class="menu-link" href="page-orders-1.php"> <i class="icon material-icons md-person"></i>
                        <span class="text">Reports</span>
                    </a>
                    <div class="submenu">
                        <a href="report_list.php" <?php if($sub_menu=="report_list"){echo 'class="active"';}?>>Visitor Report</a>
                    </div>
                </li>
				
				
				
			<hr>		
				
				
				
				<li class="menu-item has-submenu <?php if($menu=="Logout"){echo 'active';}?>">
                    <a class="menu-link" href="page-orders-1.php"> <i class="icon material-icons md-person"></i>
                        <span class="text">Logout</span>
                    </a>
                    <div class="submenu">
                        <a href="logout.php" <?php if($sub_menu=="logout"){echo 'class="active"';}?>>Exit</a>
                    </div>
                </li>			
			
				
				
				
				
				
				
				
				
			
            </ul>
            <br>
            <br>
        </nav>
    </aside>
    
	
<main class="main-wrap">