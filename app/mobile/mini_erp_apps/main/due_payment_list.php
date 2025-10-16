<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";

$title = "Due Payment List";
$menu = 'home';
$page = "due_payment_list.php";

require_once '../assets/template/inc.header.php';
?>

<!--<div class="page-content header-clear-small">
	<div class="content">
	    
	</div>
</div>-->
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
		.fff{
			
				border: 2px solid red;
				
		}
</style>

 <div class="container-fluid py-3 mt-5 pt-3">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 text-danger">Due List</h4>
            <div class="d-flex gap-2">
                <button class="btn btn-danger d-flex align-items-center">
                    <i class="far fa-clock me-2"></i>
                    Due History
                </button>
                <a href="due_entry.php"><button class="btn btn-danger d-flex align-items-center">
                    <i class="fas fa-plus me-2"></i>
                    New Due
                </button></a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-12 col-lg-6">
                <!-- Tabs -->
                <ul class="nav nav-pills nav-fill mb-4" id="memberTabs">
                    <li class="nav-item">
                        <button class="nav-link active rounded-0" data-bs-toggle="pill" data-bs-target="#customer">
                            Customer
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-dark rounded-0" data-bs-toggle="pill" data-bs-target="#supplier">
                            Supplier
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-dark rounded-0" data-bs-toggle="pill" data-bs-target="#employee">
                            Employee
                        </button>
                    </li>
                </ul>

				 <div class="tab-content">
                        <div class="tab-pane fade show active" id="customer">
						     <div class="mb-4">
                    <div class="input-group input-group-search">
                        <span class="input-group-text bg-white border-end-0 fff text-danger">
                            <i class="fas fa-search text-secondary"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               placeholder="Search by name or phone number">
                    </div>
                </div>

                <!-- Empty State -->
                <div class="text-center py-5">
                    <p class="text-muted mb-3">You have no transactions</p>
                    <button class="btn btn-danger px-4">
                        Add New
                    </button>
                </div>
            

            <!-- Right Column -->
            <div class="col-12 col-lg-6">
                <div class="bg-white rounded p-4 h-100 d-flex align-items-center justify-content-center">
                    <p class="text-muted mb-0">No Contact Selected Yet</p>
                </div>
            </div>
                        </div>		




			<div class="tab-pane fade show active" id="supplier">
			
			 <div class="mb-4">
                    <div class="input-group input-group-search">
                        <span class="input-group-text bg-white border-end-0 fff text-danger">
                            <i class="fas fa-search text-secondary"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               placeholder="Search by name or phone number">
                    </div>
                </div>

                <!-- Empty State -->
                <div class="text-center py-5">
                    <p class="text-muted mb-3">You have no transactions</p>
                    <button class="btn btn-danger px-4">
                        Add New
                    </button>
                </div>
            

            <!-- Right Column -->
            <div class="col-12 col-lg-6">
                <div class="bg-white rounded p-4 h-100 d-flex align-items-center justify-content-center">
                    <p class="text-muted mb-0">No Contact Selected Yet</p>
                </div>
			
			</div>
			</div>

			<div class="tab-pane fade show active" id="employee">
				
			 <div class="mb-4">
                    <div class="input-group input-group-search">
                        <span class="input-group-text bg-white border-end-0 fff text-danger">
                            <i class="fas fa-search text-secondary"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               placeholder="Search by name or phone number">
                    </div>
                </div>

                <!-- Empty State -->
                <div class="text-center py-5">
                    <p class="text-muted mb-3">You have no transactions</p>
                    <button class="btn btn-danger px-4">
                        Add New
                    </button>
                </div>
            

            <!-- Right Column -->
            <div class="col-12 col-lg-6">
                <div class="bg-white rounded p-4 h-100 d-flex align-items-center justify-content-center">
                    <p class="text-muted mb-0">No Contact Selected Yet</p>
                </div>
			</div>

			</div>
						
						
						
                <!-- Search Bar -->
              <!--  <div class="mb-4">
                    <div class="input-group input-group-search">
                        <span class="input-group-text bg-white border-end-0 fff text-danger">
                            <i class="fas fa-search text-secondary"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-start-0" 
                               placeholder="Search by name or phone number">
                    </div>
                </div>

                <!-- Empty State -->
               <!-- <div class="text-center py-5">
                    <p class="text-muted mb-3">You have no transactions</p>
                    <button class="btn btn-danger px-4">
                        Add New
                    </button>
                </div>
            </div>-->

            <!-- Right Column -->
            <!--<div class="col-12 col-lg-6">
                <div class="bg-white rounded p-4 h-100 d-flex align-items-center justify-content-center">
                    <p class="text-muted mb-0">No Contact Selected Yet</p>
                </div>
            </div>-->
        
    </div>
    </div>
    </div>
 </div>
<!-- End of Page Content-->

<? require_once '../assets/template/inc.footer.php'; ?>