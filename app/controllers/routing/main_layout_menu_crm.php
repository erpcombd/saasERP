<?php
$cid = explode('.', $_SERVER['HTTP_HOST'])[0];
?>

<style>
.sidebar, .sidemenu{
	display:none;
    width: 0% !important;
}

.main_content{
	width: 100% !important;
}
    .bold{
        font-weight: bold !important;
    }
    .bell-massage,.sing-out{
        font-size: 16px !important;
        background-color: whitesmoke;
        padding: 5px 8px !important;
    }
    
    #clock {
        position: relative !important;
        right: 0px !important;
        /*width: auto !important;*/
        padding-right: 0px !important;
        color: #333 !important;
    }
    
    .Profile-set{
        left: -50%;
        right: -50%;
        padding: 0px;
    }
    .Profile-set .d-flex{
        margin: 0px;
        padding: 10px;
    }
    
    .userimg {
        width: 50px;
        height: 50px;
        margin-right: 2px;
        pointer-events: none;
        border-radius: 25px;
        border: 1px solid green;
    }
    .post{
        width: 100%;
        padding: 0px 5px;
    }
    
    .sign_out{
        padding: 6px 8px;
        background-color: #f5f5f5;
        border-radius: 5px;
        cursor: pointer;
    }
    .sign_out a{
        color:#333;
    }
    
    .sign_out:hover{
         border: 1px solid #ff6200;
    }
    
    .sign_out:hover>a{
         color: #ff6200 !important;
         cursor: pointer;
    }
    
    .nav-item:hover>.nav-link{
        color: #ff6200 !important;
          border: 1px solid #ff6200;
    } 
    
    .nav-item:hover>.titel_x{
        border:0px !important;
    }
    
    .dropdown:hover>.dropdown-toggle{
        color: #ff6200 !important;
    }
    
    .dropdown:hover .dropdown-menu, .dropdown-toggle:hover .dropdown-menu{
        display: block;
        opacity: 1;
        transform: scale(1);
      
    }
    
    
    
    .zoom-menu .dropdown-menu .dropdown-item:hover, .zoom-menu .dropdown-menu .dropdown-item:focus, .zoom-menu .dropdown-menu a:hover, .zoom-menu .dropdown-menu a:focus, .zoom-menu .dropdown-menu a:active {
        box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(156, 39, 176, 0.4) !important;
        color: #333 !important;
        background-color: #fafafad1 !important;
    }
    
    .dropdown-menu .a{
        background-color: #f5f5f5 !important;
        box-shadow: none !important;
    }

   /* new css for crm*/
   .button-bar, .sidemenu{
   display:none;
   }
   .container-fluid .navbar-header{
   	margin-left: 0px !important;
   }
   .body_box .navbar-fixed-top{
   background-color:#FFFFFF !important;
   
   }
   .body_box .zoom-menu{
   margin-top:1px !important;
   margin-bottom: 1px !important;
   padding: 5px !important;
   background-color: #fff !important;
   }
   
   .notificationblock {
    	right: 175px !important;
	}
	.notificationblock a {
    font-size: 15px !important;
	}
	.userblock{
		    right: 295px !important;
	}
	
.userimg {
    width: 50px;
    height: 50px;
    margin-right: 2px;
    pointer-events: none;
    border-radius: 25px;
    border: 0px solid green;
}

</style>

<!--=============================================================================
---------------------------- Header start -----------------------------------------
==============================================================================-->


    












<!--=============================================================================
---------------------------- Manu start -----------------------------------------
==============================================================================-->
  <style>
    /* Custom styles for the dropdown */
    .sarwar-drop .dropdown-menu {
      background-color: #f9f9f9;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }

    .sarwar-drop .dropdown-submenu {
      position: relative;
    }

    .sarwar-drop .dropdown-submenu:hover .dropdown-menu {
      display: block;
      position: absolute;
      left: 100%;
      top: 0;
    }
    
    .dropdown-menu-two{
        position: absolute;
        display: none !important;
        top: 0px;
        left: 100%;
    }
    
    .dropdown-two:hover .dropdown-menu-two{
        display: block!important;
    }
    .dropdown-two{
        width:100%;
    }
    
    .dropdown-two .nav-link{
        text-align: left;
    }
    
    .dropdown-two .nav-link, .dropdown .nav-link{
        margin-left: 0px !important;
    }
    
    .dropdown-menu .nav-link{
        font-size: 11px !important;
        text-transform: capitalize !important;
    }
    
        /* width */
    ::-webkit-scrollbar {
      width: 5px;
    }
    
    /* Track */
    ::-webkit-scrollbar-track {
      background: #f1f1f1; 
    }
     
    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #888; 
    }
    
    /* Track */
    ::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px grey; 
      border-radius: 10px;
    }
     
    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #333; 
      border-radius: 10px;
    }
    
    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #555; 
    }
    
    .titel_x{
        padding: 10px 5px !important;
    }
    
    .nav-link{
        padding: 8px 10px !important;
        
    }


  </style>



<nav class="navbar navbar-expand-sm navbar-light bg-light m-0 p-0 zoom-menu" data-toggle="affix" id="menu-sr-2">
    <div class="mx-auto d-sm-flex d-block flex-sm-nowrap">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center" id="navbarsExample11">
            <ul class="navbar-nav">
                
                <li class="nav-item" style=" margin: 0px 0px 0px 10px; ">
                    <a class="nav-link" href="../home/home.php" style=" margin: 0px; padding: 4px; border: 1px solid #d0ced5;"><i class="fa-solid fa-house fa-lg"></i></a>

                </li>
				
<!--				<li class="nav-item dropdown text-center">
                    
                <a class="nav-link titel_x dropdown-toggle text-capitalize" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="d-none d-sm-inline px-1">Main Manu</span>      </a>

                    <div class="dropdown-menu m-0" aria-labelledby="navbarDropdown">
					 <a class="nav-link" href="#">Sub Manu</a>
					 <a class="nav-link" href="#">Sub menu 2</a>
                    </div>
                </li>-->
				
				
				<li class="nav-item dropdown text-center">
                    
                <a class="nav-link titel_x dropdown-toggle text-capitalize" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="d-none d-sm-inline px-1">Setup Panel</span>      </a>
                
                
                    <div class="dropdown-menu m-0" aria-labelledby="navbarDropdown">
					 <!--<a class="nav-link" href="../setup/type_of_lead.php">Type of Lead</a>-->
					 <a class="nav-link" href="../setup/status_of_lead.php">Status of Lead </a>
					<!-- <a class="nav-link" href="../service/service.php"> Service</a>-->
					 <a class="nav-link" href="../setup/type_of_company_category.php">Customer Category </a>
					 <a class="nav-link" href="../info_maker/country_management.php"> Country Management</a>
					 <a class="nav-link" href="../info_maker/zip_code_management.php"> Postal Code Management</a>
					 <a class="nav-link" href="../info_maker/lead_type_management.php">Lead Type </a>
					 <!--<a class="nav-link" href="../info_maker/task_purpose.php"> Task Purpose</a>-->
					 <a class="nav-link" href="../setup/company_products.php"> Product List</a>
					 <a class="nav-link" href="../setup/source_management.php"> Source Management</a>
					 <a class="nav-link" href="../setup/crm_company_activies.php"> Activity Management</a>
                     <a class="nav-link" href="../setup/crm_access_management.php"> Access Management</a>
                    </div>
                </li>
				
			
				
<!--                <li class="nav-item dropdown text-center">
                    
                <a class="nav-link titel_x dropdown-toggle text-capitalize" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="d-none d-sm-inline px-1">Customer</span>      </a>
                
                
                    <div class="dropdown-menu m-0" aria-labelledby="navbarDropdown">
					 <a class="nav-link" href="../org/show_all_org.php">All Project List</a>
                    </div>
                </li>-->
				
				
				<li class="nav-item dropdown text-center">
                <a class="nav-link titel_x dropdown-toggle text-capitalize" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="d-none d-sm-inline px-1">Campaign Setup</span>      </a>
                
                
                    <div class="dropdown-menu m-0" aria-labelledby="navbarDropdown">
					 <a class="nav-link" href="../campaign_management/show_all_campaign.php">Campaign List</a>
                    </div>
                </li>
				
				
				
				<li class="nav-item dropdown text-center">
                    
                <a class="nav-link titel_x  text-capitalize" href="../home/leads.php" role="button"> <span class="d-none d-sm-inline px-1">Leads</span>      </a>

    
                </li>
				
				
								<li class="nav-item dropdown text-center">
                    
                <a class="nav-link titel_x  text-capitalize" href="../home/tasks.php" role="button"> <span class="d-none d-sm-inline px-1">Tasks</span>      </a>

    
                </li>
				
				
				
				<li class="nav-item dropdown text-center">
                    
                <a class="nav-link titel_x  text-capitalize" href="../home/deals.php" role="button"> <span class="d-none d-sm-inline px-1">Deals</span>      </a>

    
                </li>
				
				<li class="nav-item dropdown text-center">
                    
                <a class="nav-link titel_x dropdown-toggle text-capitalize" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="d-none d-sm-inline px-1">TA/DA Management</span>      </a>
                
                
                    <div class="dropdown-menu m-0" aria-labelledby="navbarDropdown">
					  	 <a class="nav-link" href="../home/od_entry.php" >TA/DA</a>
					  <a class="nav-link" href="../home/od_approval.php">OD Approval</a>
					  <a class="nav-link" href="../home/tada_approval.php">TA/DA Approval</a>					  
					   <a class="nav-link" href="../home/tada_status.php">TA/DA Status</a>
					  				
			
                    </div>
                </li>
				
				
				
				
				
			    <!--<li class="nav-item dropdown text-center">
                    
                <a class="nav-link titel_x dropdown-toggle text-capitalize" href="#" id="navbarDropdown" role="button" 
				data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="d-none d-sm-inline px-1">Report Panel</span>      </a>

                    <div class="dropdown-menu m-0" aria-labelledby="navbarDropdown">
					 <a class="nav-link" href="../report/crm_new_report.php">CRM Report</a>
                    </div>
					
					
					
					
                </li>-->
				
				
					<li class="nav-item dropdown text-center">
                    
                <a class="nav-link titel_x dropdown-toggle text-capitalize" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="d-none d-sm-inline px-1">Report Panel</span>      </a>
                
                
                    <div class="dropdown-menu m-0" aria-labelledby="navbarDropdown">
					  	 <a class="nav-link" href="../report/crm_new_report.php">CRM Report</a>
						  <a class="nav-link" href="../report/crm_new_report_tanim.php">CRM Report New</a>
					  <a class="nav-link" href="../report/post_mode_report.php">Post Mode Report</a>
					   <a class="nav-link" href="../home/od_report.php">OD & TA/DA Report</a>
					  				
			
                    </div>
                </li>
				
				
				
				
				
				
       
            </ul>
        </div>
    </div>
</nav>



<script>
    $(".dropdown-menu a.dropdown-menu").on('click',function(){ 
    if(!$(this).next() .hasClass('show')){
        $(this).parents(".dropdown-menu").first() .find("show").removeClass("show");
    }
    var $subMenu = $(this).next('.dropdown-menu');
    $subMenu.taggleClass("show");

    $(this).parents("li.nev-item.dropdown.show") .on ('hidden.bs.dropdown',function(e){
        $(".dropdown-submenu . show").removeClass("show");
    });
    return false;
});
 </script>

