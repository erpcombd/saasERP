<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = "Financial Accounting Dashboard";
require_once SERVER_CORE."routing/inc.notify.php";

 $today = date('Y-m-d');
 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
 
$header_add .='  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <script src="https://maps.googleapis.com/maps/api/js"></script>
  ';
  $cur = '&#x9f3;';
?>



<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


<?php 



$payment=find_a_field('journal','sum(dr_amt-cr_amt)','1 and  tr_from ="payment" and jv_date between "2019-01-01" AND "2020-12-31" ');

$IncomeOverall =find_a_field('journal','sum(dr_amt-cr_amt)','1 and ledger_id like "1086000100010000"');
$BillsOverall  =find_a_field('journal','sum(cr_amt)','1 ');




?>

<div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                  </div>
                  <p class="card-category">TOTAL REVENUE</p>
                  <h3 class="card-title"><?=$cur.number_format(find_a_field('journal','sum(dr_amt)','1 '),0);?>
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
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="fas fa-chart-pie"></i>
                  </div>
                  <p class="card-category">TOTAL EXPANSE</p>
                  <h3 class="card-title"><?=$cur.number_format(find_a_field('journal','sum(cr_amt)','1 '),0);?></h3>
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
                   <i class="fa fa-bank fa-5x"></i>
                  </div>
                  <p class="card-category">CURRENT CASH & BANK</p>
                  <h3 class="card-title"><?=$cur.number_format(find_a_field('journal','sum(dr_amt-cr_amt)','1 and ledger_id like "1086%"'),0);?></h3>
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
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="fas fa-donate"></i>
                  </div>
                  <p class="card-category">Total Cash in Hand</p>
                  <h3 class="card-title"><?=$cur.number_format(find_a_field('journal','sum(dr_amt-cr_amt)','1 and ledger_id like "1086000100010000"'),0);?></h3>
                </div>
				
				
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>
          </div>
		  
		  
		  
		  
		  
		  
          <div class="row">
		  
		  
            <div class="col-md-4">
			
			<div class="card card-chart">
                <div class="card-header card-header-warning">
                   <div id="myfirstchart" style="height: 250px;"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">REVENUE FLOW CHART</h4>
                 <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> increase. </p>
                </div>
                
              </div>
			
		
				
              
			  
            </div>
			
			
			
			
			<div class="col-md-4">
			
			<div class="card card-chart">
                <div class="card-header card-header-info">
                   <div id="myfirstchart2" style="height: 250px;"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Expenses vs Incomes </h4>
                 <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> increase. </p>
                </div>
                
              </div>
			
              
			  
            </div>
			
			
			
			
		
           
			
			
			<div class="col-md-4">
			
			<div class="card card-chart">
                <div class="card-header card-header-danger">
                   <div id="myfirstchart3" style="height: 250px;"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Sales Comparison Approach</h4>
                 <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> increase. </p>
                </div>
                
              </div>
			
              
			  
            </div>
			
			
			
	
          </div>
		  
		  <div class="row">
		  
		  <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info">
                  <div class="card-icon">
                    <i class="fab fa-avianex"></i>
                  </div>
                  <p class="card-category" style="color:#FFFFFF">Current Liabilities</p>
                  <h3 class="card-title"><?=$cur.number_format(find_a_field('journal','sum(dr_amt-cr_amt)','1 and ledger_id like "1086000100010000"'),0);?></h3>
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
                  <p class="card-category" style="color:#FFFFFF">Total Payment</p>
                  <h3 class="card-title"><?=$cur.number_format(find_a_field('journal','sum(dr_amt-cr_amt)','1 and ledger_id like "1086%"'),0);?></h3>
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
                  <p class="card-category" style="color:#FFFFFF">TOTAL RECEIVE</p>
                  <h3 class="card-title"><?=$cur.number_format(find_a_field('journal','sum(dr_amt)','1 '),0);?>
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
                  <p class="card-category" style="color:#FFFFFF">TOTAL ASSET</p>
                  <h3 class="card-title"><?=$cur.number_format(find_a_field('journal','sum(cr_amt)','1 '),0);?></h3>
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
		  <div class="col-md-12">
			
			<div class="card card-chart">
                <div class="card-header">
                   <div id="myfirstchart4" style="height: 250px;"></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">REVENUE FLOW CHART </h4>
                 <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 15% </span> increase. </p>
                </div>
                
              </div>
		    
            </div>  </div>
		  
		  
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title">Last 5 Task:</span>
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            <i class="material-icons">bug_report</i> Completed
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#messages" data-toggle="tab">
                            <i class="material-icons">code</i> Pending
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#settings" data-toggle="tab">
                            <i class="material-icons">cloud</i> Processing
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
						 $sql ="SELECT * FROM secondary_journal where checked='YES' order by id desc limit 5";
						 $result = db_query($sql);
						 while($row = mysqli_fetch_object($result)){
                         $vNAME = $row->tr_from;
                         $received_from = $row->received_from;
						 $ledgerID = $row->ledger_id;
						  
						
						
						
						?>
						
                          <tr>
                            <td>
				            <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="" checked>
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
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
					  <thead class="text-warning">
                      <th>Voucher type</th>
                      <th>Received from</th>
                      <th>Ledger id</th>
                     
                      </thead>
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
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="">
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="" checked>
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                            </td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" type="checkbox" value="" checked>
                                  <span class="form-check-sign">
                                    <span class="check"></span>
                                  </span>
                                </label>
                              </div>
                            </td>
                            <td>Sign contract for "What are conference organizers afraid of?"</td>
                            <td class="td-actions text-right">
                              <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </button>
                              <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </button>
                            </td>
                          </tr>
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
                  <h4 class="card-title">Last 5 Accounts Ledger</h4>
                  <p class="card-category">Just Updated</p>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-warning">
                      <th>Accounts Code</th>
                      <th>Leder name</th>
                      <th>opening_balance</th>
                     
                    </thead>
                    <tbody>
                        <?php
                          $sl = 'select * from accounts_ledger where 1 order by ledger_id desc limit 5';
                          $qr = db_query($sl);
                          while($dt=mysqli_fetch_object($qr)){
                        ?>
                      <tr>
                        <td><?=$dt->ledger_id?></td>
                        <td><?=$dt->ledger_name?></td>
                        <td><?=$dt->opening_balance?></td>
                       
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





 // <script>
//    $(document).ready(function() {
//      $().ready(function() {
//        $sidebar = $('.sidebar');
//
//        $sidebar_img_container = $sidebar.find('.sidebar-background');
//
//        $full_page = $('.full-page');
//
//        $sidebar_responsive = $('body > .navbar-collapse');
//
//        window_width = $(window).width();
//
//        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();
//
//        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
//          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
//            $('.fixed-plugin .dropdown').addClass('open');
//          }
//
//        }
//
//        $('.fixed-plugin a').click(function(event) {
//          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
//          if ($(this).hasClass('switch-trigger')) {
//            if (event.stopPropagation) {
//              event.stopPropagation();
//            } else if (window.event) {
//              window.event.cancelBubble = true;
//            }
//          }
//        });
//
//        $('.fixed-plugin .active-color span').click(function() {
//          $full_page_background = $('.full-page-background');
//
//          $(this).siblings().removeClass('active');
//          $(this).addClass('active');
//
//          var new_color = $(this).data('color');
//
//          if ($sidebar.length != 0) {
//            $sidebar.attr('data-color', new_color);
//          }
//
//          if ($full_page.length != 0) {
//            $full_page.attr('filter-color', new_color);
//          }
//
//          if ($sidebar_responsive.length != 0) {
//            $sidebar_responsive.attr('data-color', new_color);
//          }
//        });
//
//        $('.fixed-plugin .background-color .badge').click(function() {
//          $(this).siblings().removeClass('active');
//          $(this).addClass('active');
//
//          var new_color = $(this).data('background-color');
//
//          if ($sidebar.length != 0) {
//            $sidebar.attr('data-background-color', new_color);
//          }
//        });
//
//        $('.fixed-plugin .img-holder').click(function() {
//          $full_page_background = $('.full-page-background');
//
//          $(this).parent('li').siblings().removeClass('active');
//          $(this).parent('li').addClass('active');
//
//
//          var new_image = $(this).find("img").attr('src');
//
//          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
//            $sidebar_img_container.fadeOut('fast', function() {
//              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
//              $sidebar_img_container.fadeIn('fast');
//            });
//          }
//
//          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
//            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');
//
//            $full_page_background.fadeOut('fast', function() {
//              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
//              $full_page_background.fadeIn('fast');
//            });
//          }
//
//          if ($('.switch-sidebar-image input:checked').length == 0) {
//            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
//            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');
//
//            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
//            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
//          }
//
//          if ($sidebar_responsive.length != 0) {
//            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
//          }
//        });
//
//        $('.switch-sidebar-image input').change(function() {
//          $full_page_background = $('.full-page-background');
//
//          $input = $(this);
//
//          if ($input.is(':checked')) {
//            if ($sidebar_img_container.length != 0) {
//              $sidebar_img_container.fadeIn('fast');
//              $sidebar.attr('data-image', '#');
//            }
//
//            if ($full_page_background.length != 0) {
//              $full_page_background.fadeIn('fast');
//              $full_page.attr('data-image', '#');
//            }
//
//            background_image = true;
//          } else {
//            if ($sidebar_img_container.length != 0) {
//              $sidebar.removeAttr('data-image');
//              $sidebar_img_container.fadeOut('fast');
//            }
//
//            if ($full_page_background.length != 0) {
//              $full_page.removeAttr('data-image', '#');
//              $full_page_background.fadeOut('fast');
//            }
//
//            background_image = false;
//          }
//        });
//
//        $('.switch-sidebar-mini input').change(function() {
//          $body = $('body');
//
//          $input = $(this);
//
//          if (md.misc.sidebar_mini_active == true) {
//            $('body').removeClass('sidebar-mini');
//            md.misc.sidebar_mini_active = false;
//
//            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();
//
//          } else {
//
//            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');
//
//            setTimeout(function() {
//              $('body').addClass('sidebar-mini');
//
//              md.misc.sidebar_mini_active = true;
//            }, 300);
//          }
//
//          // we simulate the window Resize so the charts will get updated in realtime.
//          var simulateWindowResize = setInterval(function() {
//            window.dispatchEvent(new Event('resize'));
//          }, 180);
//
//          // we stop the simulation of Window Resize after the animations are completed
//          setTimeout(function() {
//            clearInterval(simulateWindowResize);
//          }, 1000);
//
//        });
//      });
//    });
//  </script>
//  <script>
//    $(document).ready(function() {
//      // Javascript method's body can be found in assets/js/demos.js
//      md.initDashboardPageCharts();
//
//    });
//  </script>


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
  <script src="../../../dashboard_assets/js/material-dashboard-accounts.js?v=2.1.2" type="text/javascript"></script>
  
  <!--///////////////////////////////////////////chart start values ////////////////////////////////////////////////////////////////-->
  
  <script>
  
  new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    { year: '2016', value:<?=find_a_field('journal','sum(dr_amt-cr_amt)','1 and ledger_id like "1086%"');?> },
    { year: '2017', value: <?=find_a_field('journal','sum(cr_amt)','1 '); ?> },
    { year: '2018', value: <?=find_a_field('journal','sum(dr_amt-cr_amt)','1 and ledger_id like "1086000100010000"'); ?> },
    { year: '2019', value: 5 },
    { year: '2020', value: 20 }
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Value']
});


<!--/////////////2nd chart//////////////////-->

 new Morris.Donut({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart2',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data:  [
			
			
            {
            label: "<?php echo Incomes .' '. Tk;?>",
            value: <?php echo $IncomeOverall;?>
            },
            {
            label: "<?php echo Expenses .' '. Tk;?>",
            value: <?php echo  $BillsOverall;?>
            },	
       ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Value']
});


<!--/////////////3rd chart//////////////////-->

 new Morris.Area({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart3',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    { year: '2016', value: <?php echo 500; ?> },
    { year: '2017', value: 300 },
    { year: '2018', value: 5 },
    { year: '2019', value: 5 },
    { year: '2020', value: 200 }
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Value']
});


<!--/////////////4TH chart//////////////////-->

 new Morris.Bar({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart4',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    { year: '2016', value: <?php echo 500; ?> },
    { year: '2017', value: 300 },
    { year: '2018', value: 523 },
    { year: '2019', value: 680 },
    { year: '2020', value: 201 }
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Value']
});



</script>




   
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>99