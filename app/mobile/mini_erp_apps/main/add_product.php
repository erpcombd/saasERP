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
		.hhh {
			width: 100px !important;	
		}
		.ggg{
			width: 85px;	
		}

</style>

<div class="container-fluid py-3 mt-5 pt-3">
        <div class="card mx-auto" style="max-width: 700px;">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-danger">Add Product</h5>
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
            </div>
            
            <div class="card-body">
                <form>
                    <!-- Image Upload Section -->
                    <div class="border rounded-2 p-4 text-center mb-4">
                        <i class="fas fa-cloud-upload-alt fa-2x text-secondary mb-3"></i>
                        <p class="mb-1">Click to upload or drag & drop</p>
                        <small class="text-secondary">JPG, PNG Image files, up to 5MB (0/5 uploaded)</small>
                    </div>

                    <!-- First Product Details Section -->
                    <h6 class="mb-3 text-danger">PRODUCT DETAILS</h6>
                    <div class="mb-4">
                        <div class="mb-3">
                            <label class="form-label">
                                Product Name
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" placeholder="Product Name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Current Stock</label>
                            <input type="number" class="form-control" placeholder="Current Stock">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Purchase Price</label>
                                <input type="number" class="form-control" placeholder="Purchase Price">
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label">
                                    Sell Price
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control" placeholder="Sell Price" required>
                            </div>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input hhh" type="checkbox" id="onlineSell">
                            <label class="form-check-label " for="onlineSell">
                                Want to sell this product online?
                            </label>
                        </div>
                    </div>

                    <!-- Second Product Details Section -->
                    <h6 class="mb-3 text-danger">PRODUCT DETAILS</h6>
                    <div class="mb-4">
                        <label class="form-label">Units</label>
                        <select class="form-select">
                            <option selected disabled>Units</option>
                            <option>Pieces</option>
                            <option>Kilograms</option>
                            <option>Liters</option>
                        </select>
                    </div>
					<div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Category Name</label>
                            <select class="form-select">
                                <option selected disabled>Select Category</option>
                                <option>Category 1</option>
                                <option>Category 2</option>
                                <option>Category 3</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Sub-Category Name</label>
                            <select class="form-select">
                                <option selected disabled>Select Sub-Category</option>
                                <option>Sub-Category 1</option>
                                <option>Sub-Category 2</option>
                                <option>Sub-Category 3</option>
                            </select>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="mb-4">
                        <label class="form-label">Product Details</label>
                        <textarea 
                            class="form-control" 
                            rows="4" 
                            placeholder="Save details of your product"
                        ></textarea>
                    </div>

                    <!-- Others Section -->
                    <div class="mb-4">
                        <h6 class="mb-3 text-danger">OTHERS</h6>
						
						
						<!-- <div class="form-check form-switch">
                            <input class="form-check-input hhh" type="checkbox" id="onlineSell">
                            <label class="form-check-label " for="onlineSell">-->
                        
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <span>Want to sell this in bulk?</span>
                                        <div class="form-check form-switch ggg d-flex justify-content-end">
                                            <input class="form-check-input" type="checkbox"  id="bulkSell">
                                            <label class="form-check-label" for="bulkSell"></label>
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <span>Low stock alert</span>
                                        <div class="form-check form-switch ggg d-flex justify-content-end">
                                            <input class="form-check-input " type="checkbox" role="switch" id="stockAlert">
                                            <label class="form-check-label" for="stockAlert"></label>
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <span>Vat applicable</span>
                                        <div class="form-check form-switch ggg d-flex justify-content-end">
                                            <input class="form-check-input" type="checkbox" role="switch" id="vatApplicable">
                                            <label class="form-check-label" for="vatApplicable"></label>
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <span>Warranty</span>
                                        <div class="form-check form-switch ggg d-flex justify-content-end">
                                            <input class="form-check-input" type="checkbox" role="switch" id="warranty">
                                            <label class="form-check-label" for="warranty"></label>
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <span>Discount</span>
                                        <div class="form-check form-switch ggg d-flex justify-content-end">
                                            <input class="form-check-input" type="checkbox" role="switch" id="discount">
                                            <label class="form-check-label" for="discount"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
				
            </div>

            <div class="card-footer bg-white py-3 mt-4">
                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end">
                    <button type="button" class="btn btn-outline-danger">Cancel</button>
                    <button type="submit" class="btn btn-success">Add New Product</button>
                </div>
            </div>
        </div>
    </div>
<!-- End of Page Content-->

<? require_once '../assets/template/inc.footer.php'; ?>