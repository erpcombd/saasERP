<?php
require_once "../../../controllers/routing/layout.top.php";
$current_page = "setup";
$title='Setup Entry';
// var_dump($_SESSION);
do_calander("#f_date");
do_calander("#t_date");
unset($_SESSION['rfq_no']);

echo $sql = "SELECT * FROM `user_role` WHERE `id` = '".$_SESSION['user']['level']."'";
$result = db_query($sql);
print_r($result);
?>
<? include 'ep_menu.php'; ?>
    <script type="text/javascript" src="../../../../public/assets/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../../../../public/assets/js/jquery-3.4.1.min.js"></script>

<style>
.nav-tabs .nav-item .nav-link, .nav-tabs .nav-item .nav-link:hover, .nav-tabs .nav-item .nav-link:focus {
    border: 0 !important;
    color: #007bff !important;
    font-weight: 500;
}
.sidebar, .sidemenu{
	display:none;
    width: 0% !important;
}

.main_content{
	width: 100% !important;
}

.tab-content>.active {
    display: block;
    border: 1px solid #f5f5f5;
	background-color: #fbfbfb9e;
}

.nav-tabs .nav-item .nav-link.active{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}
.nav-tabs .nav-item .nav-link:hover{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}
.d-flex-bg-color{
background-color:#333 !important;
}
.ep-bg-color{
	background-color:#f5f5f5 !important;
}
.btn1-bg-submit{
	margin:10px !important;
	background-color:#FFFFFF !important;
	color:#333 !important;
	font-weight:bold !important;	
}
.alerts-bg{
	background-color:#f0f0f0;
	padding:10px;
}
.bg-alerts-bg{
background-color:#FFFFFF !important;
}
.alerts-table{
	height:300px !important;
}
.sourcing-table{
	width:100%;
}

.sourcing-table tr:nth-child(odd), .sourcing-table tr:nth-child(even)  {
    background-color: #fff !important;
    color: #333!important;
	text-align:left;
}
.tab-pane{
height:292px;
background-color:#fff !important;
}
.nav-tabs {
    border-bottom: 1px solid #d9d9d9;
    background-color: #fffefe;
}

 .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 210px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
	left: 10px; 
	padding: 5px 0px;
	border-radius: 3px;
  }
  .dropdown-content a{
  	background-color:#fff !important;
	text-align:left;
	padding: 5px 0px 5px 10px;
  }
  .dropdown-content a:hover{
  color:#f37025;
  }
  
  
  
  .fs-8{font-size:8px !important;}.fs-9{font-size:9px !important;}.fs-10{font-size:10px !important;}.fs-11{font-size:11px !important;}.fs-12{font-size:12px !important;}.fs-13{font-size:13px !important;} .fs-14{font-size:14px !important;}  .fs-15{font-size:15px !important;}  .fs-16{font-size:16px !important;}  .fs-17{font-size:17px !important;}  .fs-18{font-size:18px !important;}  .fs-19{font-size:19px !important;}  .fs-20{font-size:20px !important;} .fs-21{font-size:21px !important;}.fs-22{font-size:22px !important;}
  
  
  
  .modal-dialog {
    max-width: 1000px;
	top: 10%;
   }
   .modal-header{
	   background-color:#333;
	   padding: 13px;
   }
    
   .modal-header .modal-title, .modal-header button i {
   		color:#fff;
   }

	.new-even{
		width: 100%;
		height: 250px;
		border: 1px solid #d5d4d4;
		border-radius: 10px;
		padding: 10px;
	}
	
	.even-ul,.even-ul .even-li{
		margin:0px;
		padding:0px;
		list-style:none;
		line-height:2;
	}
	.overflow-even{
		overflow-x: hidden !important;
		overflow: scroll;
		height: 160px;
		width: 100%;
	}
	.btn1-bg-cancel,.btn1-bg-cancel:hover {
    	background-color: #efefef;
    	color: #181818;
    	font-weight: bold !important;
	}
</style>
<h1 class="container" style=" font-size: 30px !important; ">Setup</h1>
<div class="container pt-0 mt-5 p-0 ">

	<div class="container-fluid ep-bg-color  pt-2 pb-2 d-flex justify-content-between">
	
	
			<div class="eps-left">&nbsp;</div>
			<div class="search-ep d-flex align-items-center bold fs-13">
			Find it fast! Use this Filter
			  <form action="" class="form-inline ml-2 m-0" style=" background-color: white;   border-radius: 5px;">
					<input class="form-control ml-2 mt-1 mb-1 mr-0" type="search" placeholder="Search" aria-label="Search" style="border: none;">
					<button class="btn pl-0" type="submit">
						Search
					</button>
			  </form>
			
			</div>
	</div>
	
	<?php if($_SESSION['user']['level']==3){?>
	
	<div class="row m-0 pt-4 p-0">
	
	
		<div class="col-sm-4">
			<div style="background-color: #f8f8f8;">
				<h2 class="h2 m-0 p-2 fs-17 bold text-white bg-dark text-center">Product Setup</h2>
				
				
				<ul class="ul" style=" list-style: none; padding-left: 20px; ">
					<li class="li" style=" line-height: 2; "><a href="../setup/item_group.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; "> Create Product Group</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/item_sub_group.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; ">Create Product Category</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/item_info.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; ">Product Information Setup</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/unit_management.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; "> UOM Type Setup</a></li>
				</ul>
			</div>
		</div>
		
		
		
				<div class="col-sm-4">
			<div style="background-color: #f8f8f8;">
				<h2 class="h2 m-0 p-2 fs-17 bold text-white bg-dark text-center">Suppliers Setup</h2>
				
				
				<ul class="ul" style=" list-style: none; padding-left: 20px; ">
					<li class="li" style=" line-height: 2; "><a href="../setup/vendor_category.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; ">Suppliers Category</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/vendor_info.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; ">Suppliers Information</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/vendor_massage.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; "> Suppliers Massage</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/alternative_mail_setup.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; "> Alternative Email Setup</a></li>
					<li class="li" style=" line-height: 2; "><a href="#" class="fs-15" style=" color: #00bcd4; font-weight: 600; "> &nbsp;</a></li>
				</ul>
			</div>
		</div>
		
				<div class="col-sm-4">
			<div style="background-color: #f8f8f8;">
				<h2 class="h2 m-0 p-2 fs-17 bold text-white bg-dark text-center">Master Setup</h2>
				
				
				<ul class="ul" style=" list-style: none; padding-left: 20px; ">
				<?php if($_SESSION['user']['level']==3){?>
					<li class="li" style=" line-height: 2; "><a href="../setup/user_info.php?mhafuz=2" class="fs-15" style=" color: #00bcd4; font-weight: 600; ">User Information</a></li>
					<?php }else{?>
					<li class="li" style=" line-height: 2; "><a href="../setup/user_info_self.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; ">User Information</a></li>
					<?php } ?>
					<li class="li" style=" line-height: 2; "><a href="../setup/mail_template.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; ">Mail Template</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/company_info.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; "> Company Setup</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/mail_logs.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; ">Mail Logs</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/user_log.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; ">User Logs</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/user_role.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; ">Role Manage</a></li>
					<li class="li" style=" line-height: 2; "><a href="#" class="fs-15" style=" color: #00bcd4; font-weight: 600; "> &nbsp;</a></li>
					<li class="li" style=" line-height: 2; "><a href="#" class="fs-15" style=" color: #00bcd4; font-weight: 600; "> &nbsp;</a></li>
				</ul>
			</div>
		</div>
		
		
				
				<div class="col-sm-4">
			<div style="background-color: #f8f8f8;">
				<h2 class="h2 m-0 p-2 fs-17 bold text-white bg-dark text-center">Internal Event Setup</h2>
				
				
				<ul class="ul" style=" list-style: none; padding-left: 20px; ">
					<li class="li" style=" line-height: 2; "><a href="../setup/currency_info.php" class="fs-15" style=" color: #00bcd4; font-weight: 600;">Currency Information</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/event_commodity.php" class="fs-15" style=" color: #00bcd4; font-weight: 600;"> Event Commodity Information</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/event_sub_commodity.php" class="fs-15" style=" color: #00bcd4; font-weight: 600;">Event Sub Commodity Information</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/cost_avoidance.php" class="fs-15" style=" color: #00bcd4; font-weight: 600;">Savings Type</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/sourcing_type.php" class="fs-15" style=" color: #00bcd4; font-weight: 600;">Sourcing Type Information</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/group_create.php" class="fs-15" style=" color: #00bcd4; font-weight: 600;">Group Create</a></li>
					<li class="li" style=" line-height: 2; "><a href="../setup/user_division.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; ">User Division</a></li>	
				</ul>
			</div>
		</div>
		
		
		
		
	
	
	</div>
	
	<? }else{ ?>
	<div class="row m-0 pt-4 p-0">
	<div class="col-sm-4">
			<div style="background-color: #f8f8f8;">
				<h2 class="h2 m-0 p-2 fs-17 bold text-white bg-dark text-center">Master Setup</h2>
				
				
				<ul class="ul" style=" list-style: none; padding-left: 20px; ">
				<li class="li" style=" line-height: 2; "><a href="../setup/user_info_self.php" class="fs-15" style=" color: #00bcd4; font-weight: 600; ">User Information</a></li>
					
					
				</ul>
			</div>
		</div>
		</div>
	<? } ?>
	
</div>


<?
require_once "../../../controllers/routing/layout.bottom.php";
?>