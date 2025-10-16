<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = "Mis Management Dashboard";


 $today = date('Y-m-d');
 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
 $cur = '&#x9f3;';
?>
<!-- CSS Files -->
<link href="../../../../public/dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  



<div class="content">
        <div class="container-fluid">
		
		
		
		 <div class="row">
		  
		  <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info">
                  <div class="card-icon">
                    <i class="fab fa-avianex"></i>
                  </div>
                  <p class="card-category" style="color:#FFFFFF">TOTAL CUSTOMER</p>
                  <h3 class="card-title">766</h3>
                </div>
				
				
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>
			
			
			  <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger">
                  <div class="card-icon">
                    <i class="fas fa-donate"></i>
                  </div>
                  <p class="card-category" style="color:#FFFFFF">TOTAL USER</p>
                  <h3 class="card-title"><?=find_a_field('user_activity_management','count(user_id)','1 and status="In Service"')?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">local_offer</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>
			
			
			
			
			
			<div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-primary">
                  <div class="card-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                  </div>
                  <p class="card-category" style="color:#FFFFFF">TOTAL VENDOR</p>
                  <h3 class="card-title"><?=find_a_field('vendor','count(vendor_id)','1')?>
                    <small></small>
                  </h3>
                </div>
               <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">local_offer</i> Last 24 Hours
                  </div>
                </div>

              </div>
            </div>
			
			
			
			
			<div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success">
                  <div class="card-icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
                  <p class="card-category" style="color:#FFFFFF">TOTAL VAT</p>
                  <h3 class="card-title"></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>
			
			
			</div>
			
			
			
			
			
		
		
          
          <div class="row">
            <div class="col-md-4">
              <div class="card card-chart">
                <div class="card-header card-header-success">
                  <div class="ct-chart" id="dailySalesChart"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Daily Sales</h4>
                  <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> Last 7 Days
                  </div>
                </div>
              </div>
            </div>
			
			
			
			
            <div class="col-md-4">
              <div class="card card-chart">
                <div class="card-header card-header-warning">
                  <div class="ct-chart" id="websiteViewsChart"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Bill Collected</h4>
                 <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 40% </span> increase in Collection.</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> Last 7 Days
                  </div>
                </div>
              </div>
            </div>
			
			
			
            <div class="col-md-4">
              <div class="card card-chart">
                <div class="card-header card-header-danger">
                  <div class="ct-chart" id="completedTasksChart"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Sales Return</h4>
                  <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> Increase in Sales Return.</p>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">access_time</i> Last 7 Days
                  </div>
                </div>
              </div>
            </div>
			
			
          </div>
		  
		  
		  
		  
		  <div class="row">
		  
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="fas fa-file-export"></i>
                  </div>
                  <p class="card-category">Total DO Today</p>
                  <h3 class="card-title"><?=find_a_field('sale_do_master','count(do_no)','do_date="'.date('Y-m-d').'"');?>
                    <small></small>
                  </h3>
                </div>
               <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">store</i>
                  </div>
                  <p class="card-category">Total DO Value</p>
                  <h3 class="card-title"><?=find_a_field('sale_do_master','sum(total_amt)','do_date="'.date('Y-m-d').'"');?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">info_outline</i>
                  </div>
                  <p class="card-category">Today Sales Return</p>
                  <h3 class="card-title"><?=find_a_field('warehouse_other_receive','sum(total_amt)','or_date="'.date('Y-m-d').'" and receive_type="SalesReturn"');?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">local_offer</i> Tracked from Warehouse
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="fas fa-user"></i>
                  </div>
                  <p class="card-category">New Client</p>
                  <h3 class="card-title"><?=find_a_field('dealer_info','count(dealer_code)','app_date between ="'.$lastdays.'" and "'.$today.'"');?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i> Last 7 Days
                  </div>
                </div>
              </div>
            </div>
          </div>
		  
		  
		  
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-success">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title">Sales Activity:</span>
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            <i class="far fa-smile-beam"></i>  Confirmed(323)  
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#messages" data-toggle="tab">
                            <i class="fas fa-fighter-jet"></i> To Be Delivered
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#settings" data-toggle="tab">
                            <i class="far fa-edit"></i>  To Be Invoiced
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                      <table class="table">
                        <tbody>
						
						
						<?php 
						 $sql ="SELECT * FROM secondary_journal where checked='NO' order by id desc limit 5";
						 $result = db_query($sql);
						 while($row = mysqli_fetch_object($result)){
                         $vNAME = $row->tr_from;
                         $received_from = $row->received_from;
						 $ledgerID = $row->ledger_id;
						  
						
						
						
						?>
						
                          <tr>
                            <td><?php echo $vNAME ?> </td>
							<td><?php echo $received_from ?> </td>
							<td><?php echo $ledgerID ?> </td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              
                            </td>
                          </tr>
						  
						  
						   <?php    }   ?>  
						  
						  
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="messages">
                      <table class="table">
                        <tbody>
						
						
						<?php 
						 $sql ="SELECT * FROM secondary_journal where checked='NO' order by id desc limit 5";
						 $result = db_query($sql);
						 while($row = mysqli_fetch_object($result)){
                         $vNAME = $row->tr_from;
                         $received_from = $row->received_from;
						 $ledgerID = $row->ledger_id;
						  
						
						
						
						?>
						
                          <tr>
                            <td><?php echo $vNAME ?> </td>
							<td><?php echo $received_from ?> </td>
							<td><?php echo $ledgerID ?> </td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              
                            </td>
                          </tr>
						  
						  
						   <?php    }   ?>  
						  
						  
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="settings">
                      <table class="table">
                        <tbody>
						
						
						<?php 
						 $sql ="SELECT * FROM secondary_journal where checked='NO' order by id desc limit 5";
						 $result = db_query($sql);
						 while($row = mysqli_fetch_object($result)){
                         $vNAME = $row->tr_from;
                         $received_from = $row->received_from;
						 $ledgerID = $row->ledger_id;
						  
						
						
						
						?>
						
                          <tr>
                            <td><?php echo $vNAME ?> </td>
							<td><?php echo $received_from ?> </td>
							<td><?php echo $ledgerID ?> </td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              
                            </td>
                          </tr>
						  
						  
						   <?php    }   ?>  
						  
						  
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title">Last 5 Client Information</h4>
                  <p class="card-category">Just Updated</p>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-warning">
                      <th>Code</th>
                      <th>Name</th>
                      <th>Contact</th>
                      <th>Company</th>
                    </thead>
                    <tbody>
                        <?php
                          $sl = 'select * from dealer_info where 1 order by dealer_code desc limit 5';
                          $qr = db_query($sl);
                          while($dt=mysqli_fetch_object($qr)){
                        ?>
                      <tr>
                        <td><?=$dt->dealer_code?></td>
                        <td><?=$dt->dealer_name_e?></td>
                        <td><?=$dt->moile_no?></td>
                        <td><?=$dt->propritor_name_e?></td>
                      </tr>
                     <? } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>





<!--   Core JS Files   -->
  <script src="../../../dashboard_assets/js/core/jquery.min.js"></script>
  <script src="../../../dashboard_assets/js/core/popper.min.js"></script>
  <script src="../../../dashboard_assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="../../../dashboard_assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="../../../dashboard_assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="../../../dashboard_assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="../../../dashboard_assets/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="../../../dashboard_assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="../../../dashboard_assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="../../../dashboard_assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="../../../dashboard_assets/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="../../../dashboard_assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="../../../dashboard_assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="../../../dashboard_assets/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="../../../dashboard_assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../../../dashboard_assets/js/plugins/nouislider.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="../../../dashboard_assets/js/plugins/arrive.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chartist JS -->
  <script src="../../../dashboard_assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../../../dashboard_assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../../dashboard_assets/js/material-dashboard-mis.js?v=2.1.2" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }

        }

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();

    });
  </script>





   

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>