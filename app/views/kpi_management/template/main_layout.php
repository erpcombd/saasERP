<!DOCTYPE html>

<html lang="en">

  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Meta, title, CSS, favicons, etc. -->

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

	

	

	

      <title>AKSID KPI MODULE</title>

   <link rel="shortcut icon" href="../../pic/icon.png" type="image/png"/>  

   

   

	

	

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



<? @session_start();

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

              <a href="../inventory/home.php" class="site_title"><img src="../../pic/img3.png" style=" width:150px; padding-left:10px; height:45px; "></a>

			  

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

       <div class="profile clearfix">

              <div class="profile_pic">

			  <?

			                    $imgJPG = "../../../hrm_mod/pic/staff/".$_SESSION['employee_selected'].".png";

								$imgjpg = "../../../hrm_mod/pic/staff/".$_SESSION['employee_selected'].".jpg";

								$imgPNG = "../../../hrm_mod/pic/staff/".$_SESSION['employee_selected'].".PNG";

								$imgJPEG = "../../../hrm_mod/pic/staff/".$_SESSION['employee_selected'].".jpeg";

								if(file_exists($imgJPEG)){

								  $link = $imgJPEG;

								}elseif(file_exists($imgJPG)){

								  $link = $imgJPG;

								}elseif(file_exists($imgjpg)){

								  $link = $imgjpg;

								}elseif(file_exists($imgJPEG)){

								  $link = $imgJPEG;

								} 

			  ?>

			  <img src="<?=$link?>" alt="..." class="img-circle profile_img" />

                

              </div>

              <div class="profile_info">

			  

                <span>Welcome</span>

                <h2><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$_SESSION['employee_selected']);?></h2>

              </div>

              <div class="clearfix"></div>

            </div>

            <!-- /menu profile quick info -->



            <br />

			

			

			<i class="fas fa-address-card"></i>

			

			

			  <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

              <div class="menu_section">

                

                <ul class="nav side-menu">

				
 <? if($_SESSION['employee_selected']==101656 || $_SESSION['employee_selected']==2147484030 || $_SESSION['employee_selected']==921638 || $_SESSION['employee_selected']==2147483983 ){?>
                  <li><a><i class="fa fa-users"></i>Setup Panel<span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                     

					    <li><a href="../setup/user_access_control.php"> User Access Control </a></li>

						<li><a href="../setup/kpi_set.php"> KPI Setup </a></li>
						
						

						<li><a href="../setup/pa_set.php"> Appraisal Setup </a></li>
                       
						<li><a href="../setup/add_week.php"> Add Weeks </a></li>

					

                    </ul>

                  </li>

				  	  <? } ?>

				

				  

				  

         

             

             <?php /*?>  <? 

			     $check = find_a_field('essential_info','PBI_ID','ESSENTIAL_REPORTING="'.$_SESSION['employee_selected'].'"');

				 if($check>0){

			   ?>  
			   
			   
			   <? } ?><?php */?>
			   

                <li><a><i class="fa fa-cog"></i>KPI<span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">
					
					

					 <li><a href="../kpi/kpi_view.php">KPI Entry</a></li>
					 
					 <li><a href="../kpi/user_interface.php">My KPI</a></li>

                     

					  

				    </ul>  

                  </li>

				  

				   <li><a><i class="fa fa-cog"></i>Performance Appraisal<span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

					 <li><a href="../pa/pa_view.php">PA Entry</a></li>

                     

					  

				    </ul>

                  </li>

				

				  

				 <? if($_SESSION['employee_selected']==101656 || $_SESSION['employee_selected']==2147484030|| $_SESSION['employee_selected']==921638 || $_SESSION['employee_selected']==2147483983){?> 

				   
                <li><a><i class="fa fa-cog"></i>Approval  <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

					 <li><a href="../od_report/report_approval_layer.php">Approve Performance Appraisal</a></li>

                     

					  

				    </ul>

                  </li>
				  

				  <? } ?>

				  

				  

				  

				  

				    

				   <li><a><i class="fa fa-file-text"></i> Report<span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

					

                

					   <li><a href="../od_report/kpi_report.php">KPI Report</a></li>
					   
					  <?php /*?> <? if($_SESSION['employee_selected']!=101656|| $_SESSION['employee_selected']==2147484030 || $_SESSION['employee_selected']!=31502){?>
					   <li><a href="../od_report/appraisal_for_emp.php">Performance Appraisal</a></li>
					     <? }?><?php */?>
					   
					    <? if($_SESSION['employee_selected']==101656 || $_SESSION['employee_selected']==2147484030 || $_SESSION['employee_selected']==921638 || $_SESSION['employee_selected']==31502 || $_SESSION['employee_selected']==2147483983){?>

					   <li><a href="../od_report/appraisal.php">Performance Appraisal</a></li>
					   

					       <? }else{?>
						 <li><a href="../od_report/appraisal_for_emp.php">Performance Appraisal</a></li>
					     <? }?>

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

          <img src="../../../hrm_mod/pic/staff/<?=$_SESSION['employee_selected']?>.jpeg" alt="..."  />Welcome..Aksid Corporation

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

		

		

		

		



		

		

	

	

	

	

	

	

	

	

	



