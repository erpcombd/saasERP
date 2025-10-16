  <!-- Main Sidebar Container -->

  

  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->

    <a href="home.php" class="brand-link">

      <!-- <img src="dist/img/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->

      <span class="brand-text font-weight-light">

        <!--<img src="dist/img/sglogo.png" alt="Logo" width="190px">-->secondary sales



      </span>

    </a>



    <!-- Sidebar -->

    <div class="sidebar">

      <!-- Sidebar user panel (optional) -->

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="image">

          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">

        </div>

        <div class="info">

          <a href="#" class="d-block">Admin</a>

        </div>

      </div>







      <!-- Sidebar Menu -->

      <nav class="mt-2">

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- Add icons to the links using the .nav-icon class

               with font-awesome or any other icon font library -->

          <li class="nav-item menu-open">

            <a href="home.php" class="nav-link <?php if($menu=="Home"){echo 'active';}?>">

              <i class="nav-icon fas fa-tachometer-alt"></i>

              <p>Dashboard</p>

            </a>

          </li>


<li class="nav-item <?php if($menu=="target"){echo 'menu-open';}?>">

            <a href="#" class="nav-link <?php if($menu=="target"){echo 'active';}?>">

              <i class="nav-icon fas fa-tree"></i>

              <p>Target Setup<i class="fas fa-angle-left right"></i></p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="target.php" class="nav-link <?php if($sub_menu=="target_setup"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Sales Target Setup (SR Wise)</p>

                </a>

              </li>

              


            </ul>

          </li>
		  
		  
		  
		  




<? if($_SESSION['level']<6){ ?>




<? if($_SESSION['level']==500){ ?>
          <li class="nav-item <?php if($menu=="Product"){echo 'menu-open';}?>">

            <a href="#" class="nav-link <?php if($menu=="Product"){echo 'active';}?>">

              <i class="nav-icon fas fa-tree"></i>

              <p>Product Manage<i class="fas fa-angle-left right"></i></p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="item_info.php" class="nav-link <?php if($sub_menu=="item_info"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Product List</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="product_group.php" class="nav-link <?php if($sub_menu=="product_group"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Product Group</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="product_brand.php" class="nav-link <?php if($sub_menu=="product_brand"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Product Brand</p>

                </a>

              </li>

              

              <li class="nav-item">

                <a href="gift_offer.php" class="nav-link <?php if($sub_menu=="gift_offer"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Gift Offer</p>

                </a>

              </li>              

              

            </ul>

          </li>
<? }?>


        <li class="nav-item <?php if($menu=="Setup Location"){echo 'menu-open';}?>">

        <a href="#" class="nav-link <?php if($menu=="Setup Location"){echo 'active';}?>">

          <i class="nav-icon far fa-plus-square"></i>

          <p>Item Assign<i class="fas fa-angle-left right"></i></p>

        </a>

        <ul class="nav nav-treeview">

          <li class="nav-item">

            <a href="item_assign.php" class="nav-link <?php if($sub_menu=="pending_orders"){echo 'active';}?>">

              <i class="far fa-circle nav-icon"></i>

              <p>Asssign Item</p>

            </a>

          </li>



        







        </ul>

        </li>



        <li class="nav-item <?php if($menu=="Setup Location"){echo 'menu-open';}?>">

            <a href="#" class="nav-link <?php if($menu=="Setup Location"){echo 'active';}?>">

              <i class="nav-icon far fa-plus-square"></i>

              <p>Order Manage<i class="fas fa-angle-left right"></i></p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pending_orders.php" class="nav-link <?php if($sub_menu=="pending_orders"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Pending Orders</p>

                </a>

              </li>

           

             







            </ul>

        </li>
        <li class="nav-item <?php if($menu=="Setup Location"){echo 'menu-open';}?>">

            <a href="#" class="nav-link <?php if($menu=="Setup Location"){echo 'active';}?>">

              <i class="nav-icon far fa-plus-square"></i>

              <p>Location Setup<i class="fas fa-angle-left right"></i></p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="setup_region.php" class="nav-link <?php if($sub_menu=="setup_region"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Region List</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="setup_zone.php" class="nav-link <?php if($sub_menu=="setup_zone"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Zone List</p>

                </a>

              </li>              

             

              <li class="nav-item">

                <a href="setup_area.php" class="nav-link <?php if($sub_menu=="setup_area"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Area List</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="setup_route.php" class="nav-link <?php if($sub_menu=="setup_route"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Route List</p>

                </a>

              </li>



            </ul>

        </li>









        <li class="nav-item <?php if($menu=="Setup"){echo 'menu-open';}?>">

            <a href="#" class="nav-link <?php if($menu=="Setup"){echo 'active';}?>">

              <i class="nav-icon far fa-plus-square"></i>

              <p>Setup<i class="fas fa-angle-left right"></i></p>

            </a>

            <ul class="nav nav-treeview">
<? if($_SESSION['username']=='faysal'){ ?>
              <li class="nav-item">
                <a href="admin_user.php" class="nav-link <?php if($sub_menu=="admin_user"){echo 'active';}?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Admin Users</p>
                </a>
              </li>
<? }?>

              <li class="nav-item">

                <a href="settings.php" class="nav-link <?php if($sub_menu=="settings"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>General Settings</p>

                </a>

              </li> 

              <!--<li class="nav-item">-->

              <!--  <a href="dealer_info.php" class="nav-link <?php if($sub_menu=="dealer_info"){echo 'active';}?>">-->

              <!--    <i class="far fa-circle nav-icon"></i>-->

              <!--    <p>Dealer Info</p>-->

              <!--  </a>-->

              <!--</li>               -->

              <li class="nav-item">

                <a href="shop_list.php" class="nav-link <?php if($sub_menu=="shop_list"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Shop Information</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="so_list.php" class="nav-link <?php if($sub_menu=="so_list"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Field Force Information</p>

                </a>

              </li>

              

            </ul>

        </li>




<!--
          <li class="nav-item <?php if($menu=="Target"){echo 'menu-open';}?>">

            <a href="#" class="nav-link <?php if($menu=="Target"){echo 'active';}?>">

              <i class="nav-icon fas fa-th"></i>

              <p>Target Manage<i class="fas fa-angle-left right"></i></p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="target_upload.php" class="nav-link <?php if($sub_menu=="target_upload"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Upload Target</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="target_upload_ratio.php" class="nav-link <?php if($sub_menu=="target_upload_ratio"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Upload Target Ratio</p>

                </a>

              </li>  

              <li class="nav-item">

                <a href="target_sync_so_target.php" class="nav-link <?php if($sub_menu=="target_sync_so_target"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Target Sync SO Target</p>

                </a>

              </li> 

              

            </ul>

          </li>
-->
          

 

<? } ?> 

          

          

          <li class="nav-item <?php if($menu=="Visit"){echo 'menu-open';}?>">

            <a href="#" class="nav-link <?php if($menu=="Visit"){echo 'active';}?>">

              <i class="nav-icon far fa-calendar-alt"></i>

              <p>Visit Manage<i class="fas fa-angle-left right"></i></p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="visit_plan.php" class="nav-link <?php if($sub_menu=="visit_plan"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Create Schedule</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="view_visit_schedule.php" class="nav-link <?php if($sub_menu=="view_visit_schedule"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>View Schedule Map</p>

                </a>

              </li>  

              

            </ul>

          </li>  

          

          

          <li class="nav-item <?php if($menu=="Tracking"){echo 'menu-open';}?>">

            <a href="#" class="nav-link <?php if($menu=="Tracking"){echo 'active';}?>">

              <i class="nav-icon fas fa-search"></i>

              <p>Tracking<i class="fas fa-angle-left right"></i></p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="track_last_location.php" class="nav-link <?php if($sub_menu=="track_last_location"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Show Last Movement</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="track_shop.php" class="nav-link <?php if($sub_menu=="track_shop"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Shop Position</p>

                </a>

              </li>  


<? if($_SESSION['level']!=103){ ?>
              <li class="nav-item">

                <a href="tracking_status_report.php" class="nav-link <?php if($sub_menu=="track_reportss"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Tracking Report</p>

                </a>

              </li>  

              <li class="nav-item">

                <a href="tracking_status_report_individuals.php" class="nav-link <?php if($sub_menu=="track_reportss_indi"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Tracking Individual</p>

                </a>

              </li> 
<? } ?>
              

            </ul>

          </li>           

          

          

          



<li class="nav-header"></li>


          <li class="nav-item <?php if($menu=="Report"){echo 'menu-open';}?>">

            <a href="#" class="nav-link <?php if($menu=="Report"){echo 'active';}?>">

              <i class="nav-icon fas fa-chart-pie"></i>

              <p>Report<i class="fas fa-angle-left right"></i></p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="report_list.php" class="nav-link <?php if($sub_menu=="report_list"){echo 'active';}?>">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Report List</p>

                </a>

              </li>

              

            </ul>

          </li>























































          <!-- <li class="nav-item">

            <a href="pages/widgets.html" class="nav-link">

              <i class="nav-icon fas fa-th"></i>

              <p>

                Widgets

                <span class="right badge badge-danger">New</span>

              </p>

            </a>

          </li>





          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-chart-pie"></i>

              <p>

                Charts

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/charts/chartjs.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>ChartJS</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/charts/flot.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Flot</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/charts/inline.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Inline</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/charts/uplot.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>uPlot</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-tree"></i>

              <p>

                UI Elements

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/UI/general.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>General</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/icons.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Icons</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/buttons.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Buttons</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/sliders.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Sliders</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/modals.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Modals & Alerts</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/navbar.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Navbar & Tabs</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/timeline.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Timeline</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/UI/ribbons.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Ribbons</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-edit"></i>

              <p>

                Forms

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/forms/general.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>General Elements</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/forms/advanced.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Advanced Elements</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/forms/editors.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Editors</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/forms/validation.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Validation</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-table"></i>

              <p>

                Tables

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/tables/simple.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Simple Tables</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/tables/data.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>DataTables</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/tables/jsgrid.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>jsGrid</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-header">EXAMPLES</li>

          <li class="nav-item">

            <a href="pages/calendar.html" class="nav-link">

              <i class="nav-icon far fa-calendar-alt"></i>

              <p>

                Calendar

                <span class="badge badge-info right">2</span>

              </p>

            </a>

          </li>

          <li class="nav-item">

            <a href="pages/gallery.html" class="nav-link">

              <i class="nav-icon far fa-image"></i>

              <p>

                Gallery

              </p>

            </a>

          </li>

          <li class="nav-item">

            <a href="pages/kanban.html" class="nav-link">

              <i class="nav-icon fas fa-columns"></i>

              <p>

                Kanban Board

              </p>

            </a>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon far fa-envelope"></i>

              <p>

                Mailbox

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/mailbox/mailbox.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Inbox</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/mailbox/compose.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Compose</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/mailbox/read-mail.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Read</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-book"></i>

              <p>

                Pages

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/examples/invoice.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Invoice</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/profile.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Profile</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/e-commerce.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>E-commerce</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/projects.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Projects</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/project-add.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Project Add</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/project-edit.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Project Edit</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/project-detail.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Project Detail</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/contacts.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Contacts</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/faq.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>FAQ</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/contact-us.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Contact us</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon far fa-plus-square"></i>

              <p>

                Extras

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="#" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>

                    Login & Register v1

                    <i class="fas fa-angle-left right"></i>

                  </p>

                </a>

                <ul class="nav nav-treeview">

                  <li class="nav-item">

                    <a href="pages/examples/login.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Login v1</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="pages/examples/register.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Register v1</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="pages/examples/forgot-password.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Forgot Password v1</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="pages/examples/recover-password.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Recover Password v1</p>

                    </a>

                  </li>

                </ul>

              </li>

              <li class="nav-item">

                <a href="#" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>

                    Login & Register v2

                    <i class="fas fa-angle-left right"></i>

                  </p>

                </a>

                <ul class="nav nav-treeview">

                  <li class="nav-item">

                    <a href="pages/examples/login-v2.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Login v2</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="pages/examples/register-v2.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Register v2</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="pages/examples/forgot-password-v2.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Forgot Password v2</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="pages/examples/recover-password-v2.html" class="nav-link">

                      <i class="far fa-circle nav-icon"></i>

                      <p>Recover Password v2</p>

                    </a>

                  </li>

                </ul>

              </li>

              <li class="nav-item">

                <a href="pages/examples/lockscreen.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Lockscreen</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/legacy-user-menu.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Legacy User Menu</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/language-menu.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Language Menu</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/404.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Error 404</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/500.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Error 500</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/pace.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Pace</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/examples/blank.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Blank Page</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="starter.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Starter Page</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-search"></i>

              <p>

                Search

                <i class="fas fa-angle-left right"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="pages/search/simple.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Simple Search</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="pages/search/enhanced.html" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Enhanced</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-header">MISCELLANEOUS</li>

          <li class="nav-item">

            <a href="iframe.html" class="nav-link">

              <i class="nav-icon fas fa-ellipsis-h"></i>

              <p>Tabbed IFrame Plugin</p>

            </a>

          </li>

          <li class="nav-item">

            <a href="https://adminlte.io/docs/3.1/" class="nav-link">

              <i class="nav-icon fas fa-file"></i>

              <p>Documentation</p>

            </a>

          </li>

          <li class="nav-header">MULTI LEVEL EXAMPLE</li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="fas fa-circle nav-icon"></i>

              <p>Level 1</p>

            </a>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="nav-icon fas fa-circle"></i>

              <p>

                Level 1

                <i class="right fas fa-angle-left"></i>

              </p>

            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">

                <a href="#" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Level 2</p>

                </a>

              </li>

              <li class="nav-item">

                <a href="#" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>

                    Level 2

                    <i class="right fas fa-angle-left"></i>

                  </p>

                </a>

                <ul class="nav nav-treeview">

                  <li class="nav-item">

                    <a href="#" class="nav-link">

                      <i class="far fa-dot-circle nav-icon"></i>

                      <p>Level 3</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="#" class="nav-link">

                      <i class="far fa-dot-circle nav-icon"></i>

                      <p>Level 3</p>

                    </a>

                  </li>

                  <li class="nav-item">

                    <a href="#" class="nav-link">

                      <i class="far fa-dot-circle nav-icon"></i>

                      <p>Level 3</p>

                    </a>

                  </li>

                </ul>

              </li>

              <li class="nav-item">

                <a href="#" class="nav-link">

                  <i class="far fa-circle nav-icon"></i>

                  <p>Level 2</p>

                </a>

              </li>

            </ul>

          </li>

          <li class="nav-item">

            <a href="#" class="nav-link">

              <i class="fas fa-circle nav-icon"></i>

              <p>Level 1</p>

            </a>

          </li> -->

          







      <!-- <li class="nav-header">------</li> -->



          <li class="nav-item">

            <a href="logout.php" class="nav-link">

              <i class="nav-icon far fa-circle text-warning"></i>

              <p>Logout</p>

            </a>

          </li>

        </ul>

      </nav>

      <!-- /.sidebar-menu -->

    </div>

    <!-- /.sidebar -->

  </aside>