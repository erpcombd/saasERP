<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";

$title = "ADD ITEM";
$menu = 'home';
$page = "new_add_item.php";

require_once '../assets/template/inc.header.php';
?>
<style>

.input-group-search {
   			flex-wrap: nowrap !important;
		}
		
		.input-group-search .btn{
			height: 37px !important;
			border: 0px;
			border-left: 2px solid #d8000d;
			border-top: 2px solid #d8000d;
			border-bottom: 2px solid #d8000d;
			border-radius: 5px 0px 0px 5px;
			background-color: #ffffff !important;
		}
		.input-group-search .input-search{
			border-left: 0px !important;
		}
		.tv{
			
			background-color: #FFFF00;
	
		}

</style>
<!--<div class="page-content header-clear-small">
	<div class="content">
	    
	</div>
</div>-->
<!-- End of Page Content-->



    <!-- Main Content -->
    <div class="container mt-3">
        <!-- Search Bar -->
        
		<div class="input-group input-group-search mb-3 pt-5">
		  <div class="input-group-prepend">
			<button class="btn btn-outline-secondary" type="button" id="button-addon1"><i class="fas fa-search text-secondary"></i></button>
		  </div>
		  <input type="text" class="form-control input-search" placeholder="Search Item">
		</div>

        <!-- Product Card -->
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
			<div class="row mb-0 mr-0 mt-0 ml-0 ">
               <!-- <div class="d-flex align-items-center col-lg-3 col-md-6 col-sm-12">-->
                    <div class=" tv col-3">
                        <i class="fas fa-tv text-white"></i>
                    </div>
                   
<!--                </div>
                <div class="row text-secondary">
-->				
                    <div class="col-3">
					 <p class="mb-0">tv</p>
                        <p class="mb-0">Stock Count</p>
                        <p class="mb-0 font-weight-bold">848</p>
                    </div>
                    <div class="col-3">
                        <p class="mb-0">Selling Price</p>
                        <p class="mb-0 font-weight-bold">800</p>
                    </div>
                    <div class="col-3">
                        <p class="mb-0">Buying Price</p>
                        <p class="mb-0 font-weight-bold">600</p>
                    </div>
                </div>
				</div>
            </div>
        

        <!-- Add Product Button -->
        <button class="btn btn-danger w-100 mb-5  py-2">
            Add Product
            <i class="fas fa-chevron-right ms-1"></i>
        </button>
    </div>

    <!-- Bottom Bar -->
    <div class="fixed-bottom bg-white border-top">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center p-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-shopping-bag text-danger me-2"></i>
                    <span>Product Selected: 0</span>
                </div>
                <button class="btn btn-danger px-4">
                    Buy Product
                    <i class="fas fa-chevron-right ms-1"></i>
                </button>
            </div>
        </div>
    </div>
<? require_once '../assets/template/inc.footer.php'; ?>