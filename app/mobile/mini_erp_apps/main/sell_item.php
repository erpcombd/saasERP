<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";

$title = "Sell Item";
$menu = 'home';
$page = "sell_item.php";

require_once '../assets/template/inc.header.php';
?>
    <style>
        /* Custom slide-up animation */
        .modal.fade .modal-dialog {
            transform: translateY(100%);
            transition: transform 0.4s ease-out;
        }
        .modal.show .modal-dialog {
            transform: translateY(0);
			/*transform: translateY(0);*/
        }
    </style>
	  <style>
	  	.ttt{
			background-color: #fce0df;	
			border: 2px solid red;
		}
		.ttf{
			background-color: #fce0df !important;	
		}
		.bbb{
			border:2px solid red;
			 
		}
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
				height:38px !important;
		}
		.ggg{
			border: 2px solid red;	
		}
		
		
	  </style> 


  <div class="container mt-5 pt-3">
        <!-- Header -->
        <h5 class="mb-3 text-danger">Select product to Sell</h5>

        <!-- Search Bar -->
        <div class="d-flex gap-2 mb-3">
            <div class="input-group input-group-search">
                <span class="input-group-text text-danger fff border-end-0">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Search...">
            </div>
          <a href="product_list.php"> <button class="btn btn-outline-danger fff px-3">
                <i class="fas fa-plus"></i>
            </button></a> 
        </div>

        <!-- Selected Item -->
        <div class="card">
            <div class="card-body ">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="bg-light text-danger p-2 rounded me-2">
                            <i class="fas fa-box"></i>
                        </div>
                        <span>ERP</span>
                    </div>
                    <button class="btn btn-danger btn-sm">ADD</button>
                </div>
            </div>
        </div>

        <!-- Item Details -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between text-danger  mb-3">
                    <div>ERP</div>
                    <button class="btn-close"></button>
                </div>
                <div class="bg-light text-danger p-2 rounded mb-3">
                    <small>Current Stock</small>
                </div>

                <div class="row g-3">
                    <div class="col-4">
                        <label class="form-label">Quantity<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" value="1">
                    </div>
                    <div class="col-4">
                        <label class="form-label">Unit Price<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" value="50">
                    </div>
                    <div class="col-4">
                        <label class="form-label">Total</label>
                        <input type="number" class="form-control" value="50" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Section -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between text-danger mb-2">
                    <span>Total</span>
                    <span>TK 50</span>
                </div>

                <!-- Discount -->
                <div class="row mb-2">
                <div class="col-6">
					 <label class="text-danger">Discount</label>
					 </div>
					  <div class="col-6">
                    <select class="form-select mb-2">
                        <option>Discount</option>
                    </select>
					</div>
					</div>
					 <div class="row mb-2">
                <div class="col-6">
                    <label class="text-danger">Delivery Charge</label>
                </div>
                <div class="col-6">
                    <input type="number" class="form-control">
                </div>
            </div>

                <div class="row mb-2">
                <div class="col-6">
                    <label class="text-danger">Grand Total</label>
                </div>
                <div class="col-6">
                    <input type="number" class="form-control">
                </div>
            </div>
            </div>
        </div>

        <!-- Bottom Buttons -->
        <div class="row g-2">
            <div class="col-6">
                <button class="btn btn-danger w-100 py-2" type="button" data-bs-toggle="modal" data-bs-target="#slideUpModal">
                Cash Receive
                    <i class="fas fa-arrow-right ms-1"></i>
                </button>
            </div>
            <div class="col-6">
                <button class="btn btn-danger w-100 py-2" type="button" data-bs-toggle="modal" data-bs-target="#due_payment">
Due
                    <i class="fas fa-arrow-right ms-1"></i>
                </button>
            </div>
        </div>
    </div>
	
<!-- ===========================================
================ MODEL CONFIRM PAYMENT START ===================
============================================ -->
<div class="modal fade" id="slideUpModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="modalLabel">Confirm Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                    <!-- Purchase Date -->
                    <div class="mb-3">
                        <label class="form-label">Purchase Date: </label>
                        <div class="input-group input-group-search">
                            <input type="text" class="form-control" value="February 16th, 2025" readonly>
                            <span class="input-group-text bg-white text-danger ggg">
                                <i class="far fa-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" class="form-control" value="50">
                    </div>

                    <!-- Comment -->
                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <textarea class="form-control" rows="3" placeholder="note"></textarea>
                    </div>

                    <!-- Supplier Name -->
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <div class="input-group input-group-search">
                            <input type="text" class="form-control" placeholder="Supplier Name">
                            <span class="input-group-text bg-white text-danger ggg">
                                <i class="far fa-user"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Supplier Mobile -->
                    <div class="mb-3">
                        <label class="form-label">Customer Mobiler Number</label>
                        <input type="tel" class="form-control" placeholder="Supplier Mobiler Number">
                    </div>

                    <!-- Message Toggle -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="messageToggle">
                            <label class="form-check-label" for="messageToggle">Send Message</label>
                        </div>
                        <small class="text-success">Available SMS </small>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-danger w-100 py-2 mt-3">To Pay</button>
                </form>
                </div>
<!--                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div-->
            </div>
        </div>
    </div>

<!-- ===========================================
================ MODEL Due Payment START ===================
============================================ -->
<div class="modal fade" id="due_payment" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="modalLabel">Due Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                    <!-- Purchase Date -->
                    <div class="mb-3">
                        <label class="form-label">Purchase Date: </label>
                        <div class="input-group input-group-search">
                            <input type="text" class="form-control" value="February 16th, 2025" readonly>
                            <span class="input-group-text bg-white text-danger ggg">
                                <i class="far fa-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="mb-3">
                        <label class="form-label">Total Amount</label>
                        <input type="number" class="form-control" value="50">
                    </div>

                    <!-- Comment -->
                    

                    <!-- Supplier Name -->
                    <div class="mb-3">
                        <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                        <div class="input-group input-group-search">
                            <input type="text" class="form-control" placeholder="Supplier Name" required>
                            <span class="input-group-text bg-white text-danger ggg">
                                <i class="far fa-user"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Supplier Mobile -->
                    <div class="mb-3">
                        <label class="form-label">Customer Mobiler Number  <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" placeholder="Supplier Mobiler Number" required>
                    </div>
					<div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" rows="3" placeholder="address"></textarea>
                    </div>
					 
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-danger w-100 py-2 mt-3">Confirm</button>
                </form>
                </div>
<!--                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div-->
            </div>
        </div>
    </div>



<!-- End of Page Content-->

<? require_once '../assets/template/inc.footer.php'; ?>
