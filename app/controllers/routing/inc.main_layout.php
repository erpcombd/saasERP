<!DOCTYPE html>
<html lang="en" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="icon" type="image/x-icon" href="<?=SERVER_ROOT?>public/assets/images/login/erp_favicon-32x32.png"> 
<? $module_name = find_a_field('user_module_manage','module_name','id='.$_SESSION['mod']);?>
<title><?=$module_name?></title>

<?
require_once SERVER_ROOT."public/assets/js/inc.all.js.php";
require_once SERVER_ROOT."public/assets/css/inc.all.css.php";
echo $head;
?>

</head>
<body>

<div class="wrapper" style=" background-color: #ffffff;">
			<div class="body_box">
                <?php
                $sql = "SELECT * FROM config_template WHERE status=1";
                $template = db_query($sql);
                $temp = mysqli_fetch_object($template);

                if($temp->template_id==1){
                ?>

                    <style type="text/css">

                        .silverheader,.submenu{
                            text-align: left !important;
                        }
                        .menu_bg{
                            margin-top:0px !important;
                        }
                        .page_title{
                            border-radius: 5px;
                            background: transparent;
                            border: 0px;
                            float: left;
                            top: 3px;
                            margin-bottom: 15px;
                        }

                        .breadcrumb {
                            background-color: transparent;
                            border: none;
                            padding: 9px 13px;
                            margin-bottom: 0px;
                            padding-left: 0;
                            padding-bottom: 0;
                        }

                        .ol{
                            list-style-position: outside;
                            padding-left: 22px;
                        }

                        ol, ul {
                            margin-top: 0;
                            margin-bottom: 10px;
                        }

                        * {
                            -webkit-box-sizing: border-box;
                            -moz-box-sizing: border-box;
                            box-sizing: border-box;
                        }
               
                        ol {
                            display: block;
                            list-style-type: decimal;
                            margin-block-start: 1em;
                            margin-block-end: 1em;
                            margin-inline-start: 0px;
                            margin-inline-end: 0px;
                            padding-inline-start: 40px;
                        }

                        .sidebar::before, .off-canvas-sidebar nav .navbar-collapse::before{
                            height:auto!important;
                        }

                        @media only screen and (max-width: 1023px) {
                            .main_content {
                                position: relative;
                                float: left;
                                width: 100%;
                            }
                            .sidebar{width:50%;}
                        }


                        @media only screen and (max-width: 3000px) {
                            .main_content{
                                position: relative;
                                float:right;
                                width: 83%;
                            }

                            .sidebar{width:17%;}
                        }

                        .sidebar::-webkit-scrollbar {
                            width: .2em;
                            height: .0em;
                        }

                        .sidebar::-webkit-scrollbar-track {
                            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
                        }

                        .sidebar::-webkit-scrollbar-thumb {
                            background-color: green;
                            outline: 1px solid slategrey;
                        }

                        .sidebar{
                            height:100%; overflow:scroll;scrollbar-width: none;
                            background: white !important;
							position: fixed;

                        }

                        .main_content{
                            position: relative; float: right;
                        }

                        #collapse_sidebar{
                            display: none;
                        }

                        @media only screen and (max-width: 991px)  {
                            .main_content{
                                width: 100% !important;
                            }
                            .navbar-brand{
                                margin-left: 50px !important;
                            }
                            .navbar .navbar-toggler{
                                margin-top:7px;
                                z-index: 1000;
                                background: #c5c5d2;
                                color: white;
                                padding: 5px;
                            }

                        }

                        @media only screen and (max-width: 700px)  {
                            #user-settings-overlay{
                                display: none !important;
                            }

                            #clock{
                                display: none !important;
                            }

                            #avatar-upload{
                                display: none !important;
                            }
                            .help_tooltip{
                                display: none !important;
                            }

                            .sidebar{
                                width: 260px !important;
                            }

                        }

                        @media only screen and (min-width: 992px)  {
                            .sidebar{
                                width: 17% !important;
                            }

                            .main_content{
                                width: 83% !important;
                            }
                        }

                        .nav-open .sidebar{
                            left:0px !important;
                            z-index: 10;
                        }

                    </style>

                    <div class="sidebar" style=" height:100%; overflow:scroll; scrollbar-width: none;" >
                        <div class="title-image text-center" style="padding: 5px;">
                            <span class="title-image text-center" style="padding: 5px;">
                                <img alt="this is img" src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['user']['group']?>.png" style="width:65%;"></span>
                            <? require_once(SERVER_CORE.'routing/main_layout_menu.php');?>
                        </div>
                    </div>

                <?php
                }
                elseif($temp->template_id==2){?>
					<? if($mod_id==16){?>
					
						
                	<? } else { ?>
						<? require_once(SERVER_CORE.'routing/main_layout_menu2.php');?>
					<? } ?>
				<?php
                }
				
                elseif($temp->template_id==3){?>
						<? require_once(SERVER_CORE.'routing/main_layout_menu3.php');?>
                <?php
                }

                else{

                        echo "No records matching.";
                    }
                ?>

            
			
		
							
				<?php  if($temp->template_id==3){?>
				
				<style>
					.all-bg {
						background: #fbfbfb;
						padding: 15px 10px;
						border-radius: 10px;
					}
				</style>
				
				<div class="main_content" style=" width: 100%; ">
				
                            <div class="sr-main-content">
                                <div class="sr-main-content-padding" style="background-color: #fafafa;">
                                    <div class="sr-main-content-heading">
                                        <em class="fa-solid fa-database" style="padding-right:10px;"></em><?=$title?>
										<? if($help){ ?>
        <i class="fa-sharp-duotone fa-regular fa-circle-info" data-bs-toggle="tooltip" data-bs-placement="right" title="<?=$help;?>" role="button" style="cursor: pointer;" ></i>
										<? } ?>

                                        <? if($add_button_bar=='Mhafuz'){?>
                                            <div style="float:right; margin-top: -14px;">
                                                <a href="<?=$input_page?>">
													<button name="insert" accesskey="S" class="btn btn-primary" value="Add New" type="button">Add New</button>
												</a>
                                                	<button name="reset" class="btn btn-info" type="button" onClick="parent.location='<?=$page?>'" value="Clear">Refresh</button>
                                            </div>
                                          <? }?>
                                    </div>
                                </div>

                                <div class="sr-main-content-padding pt-3">
								     <div class="container-fluid pt-3 all-bg">
										<?=$main_content?>
									</div>
					
                                </div>
                            </div>
                        </div>
				
				
 <?php } else{ ?>
                        
						
								
		<?php
		//page access code start
		 $access_level= checkPageAccess();
		 $page_verify = OtherPageAccess();
		 if ($page_verify == 1 && $access_level == 1 || $page_verify == 0 && $access_level == 0 || $page_verify == 0 && $access_level == 1) {
		?>				
								
		<div class="main_content"  style="position: relative; width:82.5%; float: right;">
		<? require_once "../../../controllers/routing/inc.header.php"; ?>	
		<? if($mod_id==16){?>
			<? require_once SERVER_CORE."routing/main_layout_menu_crm.php";?>					
		<? }?>	  
		
		<div class="sr-main-content">
		<div class="sr-main-content-padding" style="background-color: #fafafa;">
		
		<div class="sr-main-content-heading d-flex align-items-center"><em class="fa-solid fa-database" style="padding-right:10px;"></em><?=$title?>
        <? if($help){ ?>
        <i 
        class="fa-sharp-duotone fa-regular fa-circle-info"
        data-bs-toggle="tooltip"
        data-bs-placement="right"
        title="<?=$help;?>"
        role="button"
        style="cursor: pointer;"></i>
        <? } ?>
		
		
		
<?php /*?>		<!--This is for helpe user guide-->
		<div class="p-0 pl-1 pr-1 ml-2 border rounded" data-toggle="tooltip" data-placement="bottom" title="upload file"> <i class="fa-light fa-circle-info"></i> </div>
		
		  <script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script><?php */?>
        
		<? if($add_button_bar=='Mhafuz'){?>
		
		<div style="float:right; margin-top: -14px;">
		
			
		
				<a href="<?=$input_page?>" rel="gb_page_center[940, 600]"><button name="insert" accesskey="S" class="btn btn-primary" value="Add New" type="button">Add New</button></a>
		
				<button name="reset" class="btn btn-info" type="button" onClick="parent.location='<?=$page?>'" value="Clear">Refresh</button>
		
				</div>
		
				<? }?>
		</div>
		</div>
		
		
		<div class="sr-main-content-padding pt-4">
		<?php  
//		echo "Page: ".$page_verify.' '."Access: ".$access_level;
//		echo "</br>"."1st Page ok 1 and acess ok 1";
//		echo "</br>"."2nd Page not ok 0 and acess not ok 0";
//		echo "</br>"."3rd Page not ok 0 and acess ok 1";
//		echo "</br></br>"."Module Name: ".$mod_id;
		?>
		
		 <?=$main_content?>
		
			  <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
		<div class="container-fluid">
				  <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
					<span class="sr-only">Toggle navigation</span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
				  </button>
				</div>
			  </nav>
		
			
			</div>
		</div>
			</div>
		<?
		 } elseif ($page_verify == 1 && $access_level == 0) {
		 	session_destroy();
		 	header("Location:../../../views/auth/masters/index.php");
		    echo "Page ok 1 and acess not ok 0";
		 } else {
		 	session_destroy();
		 	header("Location:../../../views/auth/masters/index.php");
		 }
		 //page access code end
		 ?>
								




<?  }   ?>

				 
</div>
</div>
</div>
</div>




<!--   Core JS Files   -->
<!--  <script src="../../../dashboard_assets/js/core/jquery.min.js"></script>-->
  <script src="<?=SERVER_ROOT?>public/assets/dashboard_assets/js/core/popper.min.js"></script>
<!--<script src="../../../dashboard_assets/js/core/bootstrap-material-design.min.js"></script> -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
   <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/nouislider.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/arrive.min.js"></script>
  <!--  Google Maps Plugin    -->
 <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>-->
  <!-- Chartist JS -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
 <script src="<?=SERVER_ROOT?>public/dashboard_assets/js/material-dashboard-accounts.js?v=2.1.2" type="text/javascript"></script> 





<script>
    const currentLocation = location.href;
	var currentLocation2  = currentLocation.split("?");
    const menuItem = document.querySelectorAll('.dashboard1-nav-dropdown-menu a');

    const menuLength = menuItem.length
    var element = document.querySelector('.dashboard1-nav-dropdown');

    for (let i = 0; i < menuLength; i++) {
        // Split the href of each menuItem
        const menuItemHref = menuItem[i].href.split("?")[0];

        // Check if the menuItem's href matches the current URL
        if (menuItemHref === currentLocation2[0]) {
            menuItem[i].classList.add('active1')

            var parentDiv = menuItem[i].parentNode;
            var parentDiv2 = parentDiv.parentNode;
            parentDiv2.classList.add('show')
        }
    }
</script>


  <script language="javascript">
var clock = new Vue({
    el: '#clock',
    data: {
        time: '',
        date: ''
    }
});

var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
var week = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
var timerID = setInterval(updateTime, 1000);
updateTime();
function updateTime() {
    var cd = new Date();
    clock.time =  zeroPadding(cd.getHours(), 2) + ' : ' + zeroPadding(cd.getMinutes(), 2) + ' : ' + zeroPadding(cd.getSeconds(), 2);
/   
    clock.date = week[cd.getDay()] + ','+' '+ zeroPadding(cd.getDate(), 2)+'.' + ' ' + months[cd.getMonth()] + ' ' + zeroPadding(cd.getFullYear(), 4);
};

function zeroPadding(num, digit) {
    var zero = '';
    for(var i = 0; i < digit; i++) {
        zero += '0';
    }
    return (zero + num).slice(-digit);
}


</script>


</body>
</html>