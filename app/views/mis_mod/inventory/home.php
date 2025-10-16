<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = "Mis Management Dashboard";


 $today = date('Y-m-d');
 $lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
 $cur = '&#x9f3;';
?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from designreset.com/cork/ltr/demo3/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 05 Mar 2020 08:10:15 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>  </title>
   <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

  <!-- CSS Files -->
  <link href="../../../../../public/dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />

  <style>
    .font-siz{
      font-size:20px;
      font-weight:bold;

    }

    @media(max-width: 1200px) {

    }

    @media(max-width: 1400px) {

    }

    @media(max-width: 1500px) {


    }
	@media (max-width: 768px) {
  .today-clock{
  display:none !important;  
  }
  }


  </style>

</head>



<div class="content">
        <div class="container-fluid">

          <div class="row">

            <div class="col-lg-3 col-md-3 col-sm-12">

              <div class="card card-stats" style="border: 1px solid orange;">

                <div class="card-header card-header-warning card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fab fa-avianex"></i>

                  </div>

                  <p class="card-category"> LifeTime</p>

                  <h3 class="card-title font-siz">00</h3>

                </div>

                <div class="card-footer" style="border-top:1px solid orange">

                  <div class="stats m-0">
                    <h5 class="m-0 font-weight-bold"> TOTAL USER</h5>

                  </div>

                </div>

              </div>

            </div>





            <div class="col-lg-3 col-md-3 col-sm-12">

              <div class="card card-stats" style="border: 1px solid green;">

                <div class="card-header card-header-success card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-donate"></i>

                  </div>

                  <p class="card-category">LifeTime </p>

                  <h3 class="card-title font-siz">00</h3>

                </div>

                <div class="card-footer" style="border-top:1px solid green">

                  <div class="stats m-0"><h5 class="m-0 font-weight-bold">ACTIVE USER</h5></div>

                </div>
              </div>
            </div>




            <div class="col-lg-3 col-md-3 col-sm-12">

              <div class="card card-stats" style="border: 1px solid red;">

                <div class="card-header card-header-danger card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-hand-holding-usd"></i>

                  </div>

                  <p class="card-category"> Last 7 Days </p>

                  <h3 class="card-title font-siz">00</h3>

                </div>

                <div class="card-footer" style="border-top:1px solid red">

                  <div class="stats m-0">
                    <h5 class="m-0 font-weight-bold">CHALLAN DELETE</h5>
                  </div>
                </div>
              </div>
            </div>





            <div class="col-lg-3 col-md-3 col-sm-12">

              <div class="card card-stats" style="border: 1px solid #1ec1d5;">

                <div class="card-header card-header-info card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-chart-pie"></i>

                  </div>

                  <p class="card-category">Last 7 Days</p>

                  <h3 class="card-title font-siz">00</h3>

                </div>

                <div class="card-footer" style="border-top:1px solid #1ec1d5">

                  <div class="stats m-0">
                    <h5 class="m-0 font-weight-bold"> DELETE VOUCHER</h5>

                  </div>
                </div>
              </div>
            </div>







            <div class="col-lg-3 col-md-3 col-sm-12">

              <div class="card card-stats" style="border: 1px solid green;">

                <div class="card-header card-header-success card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-donate"></i>

                  </div>

                  <p class="card-category">LifeTime </p>

                  <h3 class="card-title font-siz">00</h3>

                </div>

                <div class="card-footer" style="border-top:1px solid green">

                  <div class="stats m-0"><h5 class="m-0 font-weight-bold">SR DELETE</h5></div>

                </div>
              </div>
            </div>








            <div class="col-lg-3 col-md-3 col-sm-12">

              <div class="card card-stats" style="border: 1px solid red;">

                <div class="card-header card-header-danger card-header-icon">

                  <div class="card-icon p-0">

                    <i class="fas fa-hand-holding-usd"></i>

                  </div>

                  <p class="card-category"> Last 7 Days </p>

                  <h3 class="card-title font-siz">00</h3>

                </div>

                <div class="card-footer" style="border-top:1px solid red">

                  <div class="stats m-0">
                    <h5 class="m-0 font-weight-bold">MRR DELETE</h5>
                  </div>
                </div>
              </div>
            </div>









          </div>



        </div>
      </div>






 
  
  
  <!--<script>
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
  </script>-->
  
  
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();

    });
  </script>





   
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>