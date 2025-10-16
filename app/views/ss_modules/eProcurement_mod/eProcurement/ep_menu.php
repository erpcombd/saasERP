<style>
    
    .menu-option {
      cursor: pointer;
	  font-weight: 600 !important;
      font-size: 14px !important;
      text-transform: capitalize !important;
	  padding: 5px 10px !important;
    }
    .menu-option:hover {
      border: 1px solid #ff9800!important;
      color: #ff9800 !important;
	  padding: 5px 10px !important;
      border-radius: 50px !important;
    }
    .ep_selected {
		color: #ff9800 !important;
		border-bottom: 2px solid #ff9800;
    	border-radius: 0px !important;
    }
	.ep-nav{
		
		    box-shadow: 0 0px 0px 0px rgb(0 0 0 / 0%), 0 6px 2px -6px rgba(0, 0, 0, 0.15);
    background-color: #f9f9f9 !important;
	    height: 43px !important;
	}
	.sr-main-content .sr-main-content-padding{
	padding-bottom: 0px 0px 10px 0px !important;
	}
	.sr-main-content-padding .sr-main-content-heading {
    padding: 10px 20px;
}
  </style>
  <nav class="navbar ep-nav navbar-expand-lg m-0 p-0 mb-3">
    <div class="container mt-0 mb-0 p-0">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
	  <?php
	 if($_SESSION['user']['level']==5 || $_SESSION['user']['level']==3 || $_SESSION['user']['level']==4){
	  ?>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link menu-option <?php if ($current_page == 'events') {echo 'ep_selected';} ?>" href="../eProcurement/eprocurement_entry.php">Event</a>
          </li>
		   <li class="nav-item">
            <a class="nav-link menu-option <?php if ($current_page == 'setup') {echo 'ep_selected';} ?>" href="../eProcurement/setup.php">Setup</a>
          </li>
		  <?php if($_SESSION['user']['level']==5 || $_SESSION['user']['level']==3){?>
          <li class="nav-item">
            <a class="nav-link menu-option <?php if ($current_page == 'response') {echo 'ep_selected';} ?>" href="../eProcurement/response.php">Response Items</a>
          </li>
         
		  <?php } ?>
        </ul>
		<?php } ?>
      </div>
    </div>
  </nav>