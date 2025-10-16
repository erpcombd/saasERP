<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	
	
	
   <title>Chemtrek Group|Erp.Com.BD </title>
	
	
	<!-- ERP MAIN DESIGN LINK -->
<script type = "text/javascript">var GB_ROOT_DIR = "../../GBox/";</script>
<script type = "text/javascript" src = "../../GBox/AJS.js"></script>
<script type = "text/javascript" src = "../../GBox/AJS_fx.js"></script>
<script type = "text/javascript" src = "../../GBox/gb_scripts.js"></script>
<link href = "../../GBox/gb_styles.css" rel = "stylesheet" type = "text/css" media = "all"/>
<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="../../js/jquery.validate.js"></script>
<script type="text/javascript" src="../../js/paging.js"></script>
<script type="text/javascript" src="../../js/ddaccordion.js"></script>
<script type="text/javascript" src="../../js/js.js"></script>
<script type="text/javascript" src="../../js/pg.js"></script>
<link href="../../css/css.css" type="text/css" rel="stylesheet"/>
<link href="../../css/menu.css" type="text/css" rel="stylesheet"/>
<link href="../../css/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

<!--  ERP DESIGN LINK END --> 
<?=$head?>

<? @//
$user_level='level'.$_SESSION['user']['level'];
$user_id=$_SESSION['user']['id'];
$PBI_data = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);
$reporting_auth = find_all_field('essential_info','','ESSENTIAL_REPORTING='.$_SESSION['employee_selected']);

?>
<script type="text/javascript">

  $(document).ready(function(){
    $("#codz").validate();
  });

</script>
<script type="text/javascript">
$(document).ready(function(){

$(function() {
$("#date_birth").datepicker({
changeMonth: true,
changeYear: true,
dateFormat: "yy-mm-dd"
});

});

});</script>



    <!-- Bootstrap -->
    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="../inventory/home.php" class="site_title"><i class="fa fa-paw"></i> <span>ERP.COM.BD</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="../../pic/staff/<?=$_SESSION['employee_selected']?>.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome</span>
                <h2><?=$_SESSION['user']['fname']?></h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />
			
			
			<i class="fas fa-address-card"></i>
			
			
			  <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-users"></i> ADMIN <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                     
					    <li><a href="../leave/change_password.php"> Change Password </a></li>
						
                   
                    </ul>
                  </li>
         
             
            
                <li><a><i class="fa fa-cog"></i>Leave Management<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../inventory/home.php">Leave Status</a></li>
					  <li><a href="../leave/leave_request_input.php">Application for Leave</a></li>
					   <li><a href="../leave/half_leave_request_input.php">Application For Short Leave (SHL)</a></li>
					   <li><a href="../hrm/course_diploma.php">Course/Diploma</a></li>
					  <li><a href="../hrm/experience.php">Experienc</a></li>
				    </ul>
                  </li>
				  
				  
				   <li><a><i class="fa fa-edit"></i>Compansation Management <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../payroll/salary_information.php">Salary & Allowance</a></li>
                
                       <li><a href="../payroll/advance_payment.php">Advance Salary</a></li>
					   <li><a href="../payroll/other_deductions.php">Other Deductions</a></li>
					   <li><a href="../payroll/monthly_attendence.php">Monthly Attendence (Dept)</a></li>
                
                       <li><a href="../payroll/mobile_food_other_deduction.php">Monthly Mobile and Food Deduction</a></li>
					   </ul>
                  </li>
				  
				  
				  
				  
				  <li><a><i class="fa fa-file-text"></i> Report<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="../report/hr_management.php">HR Management</a></li>
                      <li><a href="../report/compensation_report.php">Compensation Management</a></li>
					   <li><a href="../report/leaveOd_report.php">Leave & OD Management</a></li>
					   <li><a href="../report/mobileBilling_report.php">Mobile Billing Report</a></li>
					  
                    </ul>
                  </li>
				  
				  
        
                
                </ul>
              </div>
			  
              <div class="menu_section">
                <!--<h3>Live On</h3>-->
                <ul class="nav side-menu">
                  <!--<li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="new.php">new</a></li>
                   
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>-->
                
                  <!--<li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li> -->                 
                
                </ul>
				
				
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="../main/logout.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/img.jpg" alt="">Welcome... Aksid Corporation
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                
                   
                    <li><a href="../main/logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

             
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
		
	<td class="oe_application"><div>
            <?=$main_content;?>
          </div></td>	
		
		
		
		

		
		
	
	
	
	
	
	
	
	
	

