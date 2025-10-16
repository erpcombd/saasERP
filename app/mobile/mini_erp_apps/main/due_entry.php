<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";

$title = "home";
$menu = 'home';
$page = "home.php";

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
		.form-check .ppp{
			width: 20px !important;
			height: 20px !important;
			
		}
		
</style>
    <div class="container-fluid py-3 mt-5 pt-3">
        <div class="card mx-auto" style="max-width: 500px;">
            <!-- Header -->
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-danger">Add Money Given Entry</h5>
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
            </div>
            
            <!-- Form Body -->
            <div class="card-body">
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
				 
				 <form id="transactionForm" class="needs-validation" novalidate>
                    <!-- Date -->
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <div class="input-group input-group-search">
                            <input type="text" 
                                   class="form-control" 
                                   value="February 19th, 2025" 
                                   readonly>
                            <span class="input-group-text fff">
                                <i class="far fa-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Cash Options -->
                    <div class="mb-3">
                        <label class="form-label">Cash</label>
                        <div class="d-flex gap-3">
                            <div class="border rounded p-3 flex-grow-1">
                                <div class="form-check">
                                    <input class="form-check-input ppp" type="radio" name="cashOption" id="given" checked>
                                    <label class="form-check-label" for="given">
                                        <div>Given</div>
                                        <small class="text-muted">You give money</small>
                                    </label>
                                </div>
                            </div>
                            <div class="border rounded p-3 flex-grow-1">
                                <div class="form-check">
                                    <input class="form-check-input ppp" type="radio" name="cashOption" id="received">
                                    <label class="form-check-label" for="received">
                                        <div>Received</div>
                                        <small class="text-muted">You received money</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="mb-3">
                        <label class="form-label">
                            Amount
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" 
                               class="form-control" 
                               placeholder="Amount" 
                               required>
                    </div>

                    <!-- Customer Name -->
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <div class="input-group input-group-search">
                            <input type="text" class="form-control" placeholder="Customer Name">
                            <span class="input-group-text bg-white text-danger fff">
                                <i class="far fa-user"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Phone No -->
                    <div class="mb-3">
                        <label class="form-label">
                            Phone No
                            <span class="text-danger">*</span>
                        </label>
                        <input type="tel" 
                               class="form-control" 
                               placeholder="Phone NO" 
                               required>
                    </div>

                    <!-- Note -->
                     <div class="mb-3">
                        <label class="form-label">Note</label>
                        <div class="input-group input-group-search">
                            <input type="text" class="form-control" placeholder="Note Name">
                            <span class="input-group-text bg-white text-danger fff">
                               <i class="fas fa-paperclip"></i>
                            </span>
                        </div>
                    </div>
                </form>
				</div>
				
				 <div class="tab-pane fade show active" id="supplier">
				
				    <form id="transactionForm" class="needs-validation" novalidate>
                    <!-- Date -->
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <div class="input-group input-group-search">
                            <input type="text" 
                                   class="form-control" 
                                   value="February 19th, 2025" 
                                   readonly>
                            <span class="input-group-text fff">
                                <i class="far fa-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Cash Options -->
                    <div class="mb-3">
                        <label class="form-label">Cash</label>
                        <div class="d-flex gap-3">
                            <div class="border rounded p-3 flex-grow-1">
                                <div class="form-check">
                                    <input class="form-check-input ppp" type="radio" name="cashOption" id="given" checked>
                                    <label class="form-check-label" for="given">
                                        <div>Given</div>
                                        <small class="text-muted">You give money</small>
                                    </label>
                                </div>
                            </div>
                            <div class="border rounded p-3 flex-grow-1">
                                <div class="form-check">
                                    <input class="form-check-input ppp" type="radio" name="cashOption" id="received">
                                    <label class="form-check-label" for="received">
                                        <div>Received</div>
                                        <small class="text-muted">You received money</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="mb-3">
                        <label class="form-label">
                            Amount
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" 
                               class="form-control" 
                               placeholder="Amount" 
                               required>
                    </div>

                    <!-- Customer Name -->
                    <div class="mb-3">
                        <label class="form-label">Supplier Name</label>
                        <div class="input-group input-group-search">
                            <input type="text" class="form-control" placeholder="Supplier Name">
                            <span class="input-group-text bg-white text-danger fff">
                                <i class="far fa-user"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Phone No -->
                    <div class="mb-3">
                        <label class="form-label">
                            Phone No
                            <span class="text-danger">*</span>
                        </label>
                        <input type="tel" 
                               class="form-control" 
                               placeholder="Phone NO" 
                               required>
                    </div>

                    <!-- Note -->
                     <div class="mb-3">
                        <label class="form-label">Note</label>
                        <div class="input-group input-group-search">
                            <input type="text" class="form-control" placeholder="Note Name">
                            <span class="input-group-text bg-white text-danger fff">
                               <i class="fas fa-paperclip"></i>
                            </span>
                        </div>
                    </div>
                </form>
				
				</div>
				
				
				
				
				
				 <div class="tab-pane fade show active" id="employee">
				 
				    <form>
                    <!-- Date -->
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <div class="input-group input-group-search">
                            <input type="text" 
                                   class="form-control" 
                                   value="February 19th, 2025" 
                                   readonly>
                            <span class="input-group-text fff">
                                <i class="far fa-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Cash Options -->
                    <div class="mb-3">
                        <label class="form-label">Cash</label>
                        <div class="d-flex gap-3">
                            <div class="border rounded p-3 flex-grow-1">
                                <div class="form-check">
                                    <input class="form-check-input ppp" type="radio" name="cashOption" id="given" checked>
                                    <label class="form-check-label" for="given">
                                        <div>Given</div>
                                        <small class="text-muted">You give money</small>
                                    </label>
                                </div>
                            </div>
                            <div class="border rounded p-3 flex-grow-1">
                                <div class="form-check">
                                    <input class="form-check-input ppp" type="radio" name="cashOption" id="received">
                                    <label class="form-check-label" for="received">
                                        <div>Received</div>
                                        <small class="text-muted">You received money</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="mb-3">
                        <label class="form-label">
                            Amount
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" 
                               class="form-control" 
                               placeholder="Amount" 
                               required>
                    </div>

                    <!-- Customer Name -->
                    <div class="mb-3">
                        <label class="form-label">Employee Name</label>
                        <div class="input-group input-group-search">
                            <input type="text" class="form-control" placeholder="Employee Name">
                            <span class="input-group-text bg-white text-danger fff">
                                <i class="far fa-user"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Phone No -->
                    <div class="mb-3">
                        <label class="form-label">
                            Phone No
                            <span class="text-danger">*</span>
                        </label>
                        <input type="tel" 
                               class="form-control" 
                               placeholder="Phone NO" 
                               required>
                    </div>

                    <!-- Note -->
                     <div class="mb-3">
                        <label class="form-label">Note</label>
                        <div class="input-group input-group-search">
                            <input type="text" class="form-control" placeholder="Note Name">
                            <span class="input-group-text bg-white text-danger fff">
                               <i class="fas fa-paperclip"></i>
                            </span>
                        </div>
                    </div>
                </form>
				 </div>
				 
				 
				 
				 
				 
				</div>
             
            </div>

            <!-- Footer -->
            <div class="card-footer bg-white py-3">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="sendSMS">
                            <label class="form-check-label" for="sendSMS">Send SMS</label>
                        </div>
                        <small class="text-success">SMS Balance 30</small>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Save</button>
                </div>
            </div>





            
        </div>
    </div>

<!-- End of Page Content-->

<? require_once '../assets/template/inc.footer.php'; ?>