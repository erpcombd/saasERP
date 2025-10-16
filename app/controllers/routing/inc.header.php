<?php
$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
$sql = "SELECT * FROM config_template WHERE status=1";
$template = db_query($sql);
$temp = mysqli_fetch_object($template);

if($temp->template_id==1){?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-1 navbar-fixed-top" style="height: 60px !important;" >
        <div class="button-bar ml-0"> <button type="button" id="collapse_sidebar" style="text-align:center" onclick="collapse_sidebar()"><i class="fa fa-caret-left fa-1x" style="line-height:2;"></i></button>
            <button type="button" id="extract_sidebar" style="text-align:center;display:none" onclick="extract_sidebar()"><i class="fa fa-caret-right fa-2x"></i></button></div>
        <div class="container-fluid">

            <div class="navbar-header">
                <!--<a class="navbar-brand" href="#"><?php var_dump($_SESSION); echo $_SESSION['company_name']; ?></a></div>-->
                <span style="font-weight:bold;"><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group']);//echo $_SESSION['company_name']; ?></span>

                <p class="company_name m-0">
                    <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);?>



                </p>

            </div>



            <!--<div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="../../../../sales_mod/pages/main/home.php">Home <span class="sr-only">(current)</span></a>
            </li>
          </ul>
        </div>-->

            <div class="clear"></div>

            <div class="userblock" style="right:248px!important;">

                <div id="avatar-upload" class="right circle">

                    <div class="image-overlay dz-message"></div>

           	
				       <? 
						     $find = find_a_field('user_activity_management','user_pic','user_id="'.$_SESSION['user']['id'].'"');
							 
							 if($find!=""){ ?>
							<img src="../../../../public/assets/images/user.png" class="userimg" alt=""/>
							
					        <? }else{ ?>
                           <img src="../../../../public/assets/images/user.png" class="userimg" alt=""/>
                            <? } ?>
                </div>



                <div id="user-settings-overlay" class="userdetail right vertical-centre">

                    <div class="username">

                        <?
                        $user_info = find_all_field('user_activity_management','fname','user_id='.$_SESSION['user']['id']);
                        echo $user_info->fname;
                        ?>            </div>

                    <div class="company_name">
                        <?=$user_info->designation;?>
                    </div>
                    <div class="company_name">
                        <?//=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);?>
                    </div>


                </div>

            </div>








            <div class="clear"></div>



            <div class="notificationblock" style="right:163px!important;">

                <a href="../../../views/auth/masters/logout.php" class="help_tooltip" data-toggle="tooltip" data-placement="bottom" data-original-title="Signout"><i class="fas fa-sign-out-alt"></i></a>
            </div>

<!--            <div id="clock" style="right:12px!important; width: 145px;">
                <span class="date" style="overflow: hidden!important;">{{ date }}</span>
                <span class="time" style="overflow: hidden!important;">{{ time }}</span>
                <span class="text" style="overflow: hidden!important;">IP: <?=$_SERVER['REMOTE_ADDR']?></span>
            </div>-->
			<div class="today-clock">
			  	<div id="today_date"></div>
			  	<div id="now_time"></div>
                <div class="text">IP: <?=$_SERVER['REMOTE_ADDR']?></div>
            </div>

            <!--<div class="helpblock">
                <div class="help-switch pointer vertical-centre">
                    <div class="on"><p>Help</p></div>
                </div>
            </div>-->



        </div>

    </nav>
<script>
    function updateTime() {
      try {
        const now = new Date();
        const dateElement = document.getElementById('today_date');
        const timeElement = document.getElementById('now_time');

        if (!dateElement || !timeElement) {
          throw new Error('Required elements not found.');
        }

        const options = { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' };
        const formattedDate = now.toLocaleDateString('en-US', options).replace(',', '.');

        const formattedTime = [
          String(now.getHours()).padStart(2, '0'),
          String(now.getMinutes()).padStart(2, '0'),
          String(now.getSeconds()).padStart(2, '0')
        ].join(':');

        dateElement.textContent = formattedDate;
        timeElement.textContent = formattedTime;
      } catch (error) {
        console.error('An error occurred while updating the time:', error);
      }
    }

    updateTime(); // Call immediately to avoid delay on first load
    setInterval(updateTime, 1000);
  </script>

    <?php
}


elseif($temp->template_id==2){?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light m-0 pl-0 navbar-fixed-top" style="height: 60px !important;" >
        <div class="button-bar ml-0"> <button type="button" id="collapse_sidebar" style="text-align:center" onclick="collapse_sidebar()"><i class="fa fa-caret-left fa-1x" style="line-height:2;"></i></button>
            <button type="button" id="extract_sidebar" style="text-align:center;display:none" onclick="extract_sidebar()"><i class="fa fa-caret-right fa-2x"></i></button></div>

        <div class="sidemenu ml-0">
			<i class="open fa-duotone fa-circle-chevron-left"></i>
			<i class=" close1 fa-solid fa-circle-chevron-right"></i>
           
       
        </div>

        <div class="container-fluid">
            <div class="navbar-header" style=" margin-left: 30px;">

                <!--<a class="navbar-brand" href="#"><?php var_dump($_SESSION); echo $_SESSION['company_name']; ?></a></div>-->
                <span  class="theme_color" style="font-weight:bold;"><?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group']);//echo $_SESSION['company_name']; ?></span>

                <p class="company_name theme_color m-0">
                    <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot']);?>
                </p>
            </div>


            <div class="clear"></div>
            <div class="userblock" style="right:300px">
                <div id="avatar-upload" class="right circle">
                    <div class="image-overlay dz-message"></div>
					
	
					
					       <? 
						     $find = find_a_field('user_activity_management','user_pic','user_id="'.$_SESSION['user']['id'].'"');
							 
							 if($find!=""){ ?>
                        
							<img src="../../../../public/assets/images/user.png" class="userimg" alt=""/>
							
					        <? }else{ ?>
                           <img src="../../../../public/assets/images/user.png" class="userimg" alt=""/>
                            <? } ?>
							
							
					
                </div>

                <div id="user-settings-overlay" class="userdetail right vertical-centre theme_color">

                    <p class="username m-0 p-0" style="font-size: 14px;">

                        <?
                        $user_info = find_all_field('user_activity_management','fname','user_id='.$_SESSION['user']['id']);
                        echo $user_info->fname;
                        ?>            </p>

                    <p class="company_name m-0 p-0" align="left">
                        <?=$user_info->designation;?>
                    </p>
                </div>
            </div>




            <div class="clear"></div>
			
<?php /*?><!--=================== Notification Star ===================-->
<style type="text/css">
    .notification_sr {
		position: absolute;
		display: inline-block;
		right: 222px;
		margin-top: -7px !important;
	  
    }
    .notification_sr .notification_toggle {
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 7px 7px;
    cursor: pointer;
    display: flex;
    align-items: center;
    }
    .notification_sr .notification_toggle i {
      font-size: 18px;
      margin-right: 2px;
    }
    .notification_sr .notification_toggle .badge {  
    background-color: #dc3545;
    color: white;
    font-size: 8px !important;
    border-radius: 50%;
    padding: 5px 6px;
    margin-top: -25px !important;
    margin-left: -18px !important;
	  
    }
    .notification_sr .notification_menu {
      display: none;
      position: absolute;
      right: 0;
      background-color: white;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      width: 300px;
      z-index: 1000;
    }
    .notification_sr .notification_menu.show {
      display: block;
    }
    .notification_sr .notification_header {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      font-weight: bold;
    }
    .notification_sr .notification_item {
      padding: 10px;
      display: flex;
      align-items: flex-start;
      text-decoration: none;
      color: #333;
    }
    .notification_sr .notification_item:hover {
      background-color: #f8f9fa;
    }
    .notification_sr .notification_item i {
      font-size: 20px;
      margin-right: 10px;
    }
    .notification_sr .notification_time {
      font-size: 12px;
      color: gray;
      margin-top: 5px;
    }
    .notification_sr .notification_divider {
      border-top: 1px solid #ddd;
      margin: 0;
    }
    .notification_sr .text_center {
      text-align: center;
      font-size: 14px;
      padding: 10px;
    }
</style>

	<div class="notification_sr" id="notification_sr">
      <div class="notification_toggle" id="notificationToggle">
        <i class="fas fa-bell"></i>
        <span class="badge">0</span>
      </div>
      <div class="notification_menu" id="notificationMenu">
        <h6 class="notification_header">Notifications</h6>
        <a href="#" class="notification_item">
          <i class="fas fa-envelope text-primary"></i>
          <div>
            <strong>New Message</strong>
            <div>You have 5 unread messages.</div>
            <div class="notification_time">2 mins ago</div>
          </div>
        </a>
        <a href="#" class="notification_item">
          <i class="fas fa-user text-success"></i>
          <div>
            <strong>New Friend Request</strong>
            <div>John Doe sent you a friend request.</div>
            <div class="notification_time">5 mins ago</div>
          </div>
        </a>
        <a href="#" class="notification_item">
          <i class="fas fa-check-circle text-warning"></i>
          <div>
            <strong>Task Completed</strong>
            <div>You completed your latest task.</div>
            <div class="notification_time">10 mins ago</div>
          </div>
        </a>
        <div class="notification_divider"></div>
        <a href="#" class="text_center">View all notifications</a>
      </div>
    </div>
	  <script>
    // JavaScript for dropdown functionality
    document.addEventListener("DOMContentLoaded", function () {
      const dropdown = document.querySelector(".notification_sr");
      const toggle = dropdown.querySelector(".notification_toggle");
      const menu = dropdown.querySelector(".notification_menu");

      // Toggle on click
      toggle.addEventListener("click", function (e) {
        e.stopPropagation();
        menu.classList.toggle("show");
      });

      // Show menu on hover
      dropdown.addEventListener("mouseenter", function () {
        menu.classList.add("show");
      });

      // Hide menu on mouse leave
      dropdown.addEventListener("mouseleave", function () {
        menu.classList.remove("show");
      });

      // Close the dropdown if clicked outside
      document.addEventListener("click", function () {
        menu.classList.remove("show");
      });
    });
  </script>
<!--=================== Notification End===================-->
	
<?php */?>	
	
	
							
<!--=================== Notification Star ===================-->
<style type="text/css">
    .notification_sr {
		position: absolute;
		display: inline-block;
		right: 222px;
		margin-top: 2px !important;
	  
    }
    .notification_sr .notification_toggle {
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 7px 7px;
    cursor: pointer;
    display: flex;
    align-items: center;
    }
    .notification_sr .notification_toggle i {
      font-size: 18px;
      margin-right: 2px;
    }
    .notification_sr .notification_toggle .badge {  
    background-color: #dc3545;
    color: white;
    font-size: 8px !important;
    border-radius: 50%;
    padding: 5px 6px;
    margin-top: -25px !important;
    margin-left: -18px !important;
	  
    }
    .notification_sr .notification_menu {
      display: none;
      position: absolute;
      /*right: 0;*/
	  right: -150px;
      background-color: white;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      width: 300px;
      z-index: 1000;
    }
    .notification_sr .notification_menu.show {
      display: block;
    }
    .notification_sr .notification_header {
    padding: 5px;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
    color: #0f742e;
    background-color: #f4f4f4;
    }
    .notification_sr .notification_item {
    padding: 1px;
    display: flex;
    align-items: flex-start;
    text-decoration: none;
    color: #333;
    background-color: #ffffff;
    }
    .notification_sr .notification_item:hover {
      background-color: #f8f9fa;
    }
    .notification_sr .notification_item i {
/*      font-size: 20px;
      margin-right: 10px;*/
		font-size: 16px;
		margin-right: 5px;
    }
    .notification_sr .notification_time {
      font-size: 12px;
      color: gray;
      margin-top: 5px;
    }
    .notification_sr .notification_divider {
      border-top: 1px solid #ddd;
      margin: 0;
    }
    .notification_sr .text_center {
      text-align: center;
      font-size: 14px;
      padding: 10px;
    }
	
	.notification_item_sub{
		width: 100% !important;
		display: flex !important;
		justify-content: center;
		align-items: center;
		padding: 4px;

	}
	.notification_item :hover .notification_item_sub{
			background-color: #fafafa;
	}
	
	.item_sub_left{
		width:10% !important;
	}
	
	.item_sub_right{
		width:90% !important;
	}
</style>

<?php 
$not_sql="SELECT a.page_id,p.page_name,p.folder_name, p.page_link FROM user_roll_activity a, user_page_manage p, user_feature_manage f, user_module_manage m WHERE a.user_id = '".$_SESSION['user']['id']."' AND a.access = 1 and m.id = '".$_SESSION['mod']."' and a.page_id=p.id and p.feature_id=f.id and f.module_id = m.id;";
                    $notifi_query = db_query($not_sql);
					$count = mysqli_num_rows($notifi_query);
					// Calculate total notifications
while ($data_notifi = mysqli_fetch_object($notifi_query)) {
    if (isset($_SESSION['notify'][$data_notifi->page_id]) && $_SESSION['notify'][$data_notifi->page_id] > 0) {
        $total_notifications += $_SESSION['notify'][$data_notifi->page_id]; // Count notifications
    }
}

// Reset pointer to reuse query results
mysqli_data_seek($notifi_query, 0);
?>

	<div class="notification_sr" id="notification_sr">
      <div class="notification_toggle" id="notificationToggle">
        <i class="fas fa-bell"></i>
        <span class="badge"><?= $total_notifications > 0 ? $total_notifications : '0' ?></span>
      </div>
      <div class="notification_menu" id="notificationMenu">
        <h6 class="notification_header">Notifications</h6>

					<?
                    while($data_notifi = mysqli_fetch_object($notifi_query)){
					if (isset($_SESSION['notify'][$data_notifi->page_id]) && $_SESSION['notify'][$data_notifi->page_id] > 0) {
					$total_notifications += $_SESSION['notify'][$data_notifi->page_id]; // Count notifications
					?>
							<a href="../<?=$data_notifi->folder_name;?>/<?=$data_notifi->page_link;?>" class="notification_item">
								<div class="notification_item_sub">
									<div class="item_sub_left"><i class="fas fa-check-circle text-warning"></i></div>
									  
									<div class="item_sub_right">
										<p class="p-0 m-0"><strong><?=$data_notifi->page_name;?> (<strong style=" color: #eb4215; "><?=$_SESSION['notify'][$data_notifi->page_id];?></strong></strong>)</p>
										<!--<div>You completed your latest task.</div>-->
										<!--<p class="notification_time p-0 m-0">Notifications Text <?=$_SESSION['mod'];?></p>-->
									</div>
								  </div>
							</a>			
					<? } } ?>
			
		
		
		
        <div class="notification_divider"></div>
        <a href="#" class="text_center ">View all notifications</a>
      </div>
    </div>
	
	<script>
    // JavaScript for dropdown functionality
    document.addEventListener("DOMContentLoaded", function () {
      const dropdown = document.querySelector(".notification_sr");
      const toggle = dropdown.querySelector(".notification_toggle");
      const menu = dropdown.querySelector(".notification_menu");

      // Toggle on click
      toggle.addEventListener("click", function (e) {
        e.stopPropagation();
        menu.classList.toggle("show");
      });

      // Show menu on hover
      dropdown.addEventListener("mouseenter", function () {
        menu.classList.add("show");
      });

      // Hide menu on mouse leave
      dropdown.addEventListener("mouseleave", function () {
        menu.classList.remove("show");
      });

      // Close the dropdown if clicked outside
      document.addEventListener("click", function () {
        menu.classList.remove("show");
      });
    });
  </script>
<!--=================== Notification End===================-->
	
	
            <div class="notificationblock" >
<!--                <a href="#" class="bell-massage" data-toggle="tooltip" data-placement="bottom" data-original-title="Notifications">
                    <span class="badge animated zoomIn"></span>
                    <i class="fas fa-bell"></i>
                </a>-->

                <a href="#" class="bell-massage" data-toggle="tooltip" data-placement="bottom" data-original-title="massage">
                    <span class="badge animated zoomIn"></span>
                    <i class="fas fa-envelope"></i>
                    <!-- <span class="badge badge-pill badge-danger">0</span>-->
                </a>

                <a href="../../../views/auth/masters/logout.php" class="sing-out" data-toggle="tooltip" data-placement="bottom" data-original-title="Signout">
                    <i class="fas fa-sign-out-alt"></i>
					
					<!--<i class="fas fa-power-off"></i>-->
                </a>


            </div>




			<div class="today-clock">
			  	<div id="today_date"></div>
			  	<div id="now_time"></div>
                <div class="text">IP: <?=$_SERVER['REMOTE_ADDR']?></div>
            </div>


        </div>
    </nav>

    <!--Side Menu hide and open js start-->
    <script>
        let menuToggle = document.querySelector('.sidemenu');
        let sidebar = document.querySelector('.sidebar');
        let main_content = document.querySelector('.main_content');
        let left1 = document.querySelector('.left1');
        menuToggle.onclick = function(){
            menuToggle.classList.toggle('active');
            sidebar.classList.toggle('active');
            main_content.classList.toggle('active');
            left1.classList.toggle('active');
        }
    </script>
  <script>
    function updateTime() {
      try {
        const now = new Date();
        const dateElement = document.getElementById('today_date');
        const timeElement = document.getElementById('now_time');

        if (!dateElement || !timeElement) {
          throw new Error('Required elements not found.');
        }

        const options = { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' };
        const formattedDate = now.toLocaleDateString('en-US', options).replace(',', '.');

        const formattedTime = [
          String(now.getHours()).padStart(2, '0'),
          String(now.getMinutes()).padStart(2, '0'),
          String(now.getSeconds()).padStart(2, '0')
        ].join(':');

        dateElement.textContent = formattedDate;
        timeElement.textContent = formattedTime;
      } catch (error) {
        console.error('An error occurred while updating the time:', error);
      }
    }

    updateTime(); // Call immediately to avoid delay on first load
    setInterval(updateTime, 1000);
  </script>


    <?php
}

else{

    echo "No records matching.";
}
?>


