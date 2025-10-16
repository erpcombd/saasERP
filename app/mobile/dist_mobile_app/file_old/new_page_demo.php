<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Order";
$page = 'order_list.php';

require_once '../assets/template/inc.header.php';

?>

<style>
/* Make select2 dropdown scrollable */
/* Force scrollable dropdown for select2 */
.select2-container .select2-results__options {
    max-height: 200px !important;    /* Force max height */
    overflow-y: auto !important;     /* Enable scrolling */
    -webkit-overflow-scrolling: touch !important;  /* Smooth scrolling on mobile */
    scroll-behavior: smooth !important; /* Ensure smooth scrolling */
}

/* Make sure the dropdown is fully visible on mobile */
@media only screen and (max-width: 600px) {
    .select2-container .select2-dropdown {
        position: relative !important;  /* Ensure proper positioning */
        width: 100% !important;         /* Ensure the dropdown is wide enough */
    }
}
}
/* Table scrolling and sticky th td end */
</style>

    

<!-- Start of Page Content-->  
   <div class="page-content header-clear-medium">
   
   

		
		

        
			

   </div>
<!-- End of Page Content--> 
    


<?php 
 require_once '../assets/template/inc.footer.php';
// selected_two("#");
// selected_two("#");
// selected_two("#");
 ?>
