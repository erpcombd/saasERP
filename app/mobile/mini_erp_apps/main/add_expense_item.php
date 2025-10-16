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
				/*height:38px !important;*/
		}


</style>

<div class="container-fluid py-3 mt-5 pt-3">
        <div class="card mx-auto" style="max-width: 500px;">
            <!-- Header -->
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-danger">Add Expense</h5>
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
            </div>
            
            <!-- Form Body -->
            <div class="card-body">
                <form>
                    <!-- Date of Expense -->
                    <div class="mb-3">
                        <label class="form-label">Date of Expense</label>
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

                    <!-- Category Name -->
                    <div class="mb-3">
                        <label class="form-label">
                            Category Name
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" required>
                            <option selected disabled>Category Name</option>
                            <option>Category 1</option>
                            <option>Category 2</option>
                            <option>Category 3</option>
                        </select>
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

                    <!-- Expense Reason -->
                    <div class="mb-3">
                        <label class="form-label">Expense Reason</label>
                        <input type="text" 
                               class="form-control" 
                               placeholder="Expense Reason">
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

            <!-- Footer -->
            <div class="card-footer bg-white py-3">
                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end">
                    <button type="button" class="btn btn-outline-danger">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>

<!-- End of Page Content-->

<? require_once '../assets/template/inc.footer.php'; ?>