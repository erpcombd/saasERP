<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Sales Return";
$page = 'return_list.php';

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
        .menu-icon {
            font-size: 1.5rem;
        }

        .order-card {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
			color: #0069b5;
    		font-weight: bold;
        }

        .order-card i {
            color: var(--primary-blue);
            font-size: 1.5rem;
        }
    </style>

    

<!-- Start of Page Content-->  
   <div class="page-content header-clear-medium">
   
			 <div class="content">
			 	<a href="invoice_so_return.php">
				<div class="order-card">
					<span>Invoice Wise Return</span>
					<i class="fa-thin fa-cart-flatbed"></i>
				</div>
				</a>
				<a href="return_sales.php?pal=2">
				<div class="order-card">
					<span>Manual Wise Return</span>
					<i class="fa-thin fa-cart-flatbed-boxes"></i>
				</div>
				</a>
				
				<a href="return_sales_rate.php?pal=2">
				<div class="order-card">
					<span>Current Rate Wise Return</span>
					<i class="fa-thin fa-cart-flatbed-boxes"></i>
				</div>
				</a>
				
				<a href="return_sales_unfinished.php">
				<div class="order-card">
					<span>Hold Return List</span>
					<i class="fa-thin fa-hand-holding-box"></i>
				</div>
				</a>
				
				<a href="return_sales_status.php">
				<div class="order-card">
					<span>Return Report</span>
					<i class="fa-thin fa-box-circle-check"></i>
				</div>
				</a>
			</div>

		
		

        
			

   </div>
<!-- End of Page Content--> 
    


<?php 
 require_once '../assets/template/inc.footer.php';
// selected_two("#");
// selected_two("#");
// selected_two("#");
 ?>
