<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";

$title = "Product List";
$menu = 'home';
$page = "product_list.php";

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
				height:38px !important;
		}
		.aaa{
			background-color: #fff;	
			border: 1px solid red;
			width: 90px;
			height: 30px;
			
		
		}
		.page-link span{
			color: black;		
		}
		.page-item.active .page-link{
			background-color: red;
			border: none;	
		}
		.pagination .page-link {
			padding: 1px 12px 3px;
	
		}
		
</style>
 <div class="container-fluid py-3 mt-5 pt-3">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-danger">Product List</h4>
			<a href="add_product.php">
            <button class="btn btn-danger d-flex align-items-center">
                <i class="fas fa-plus me-2"></i> Add New Product  </button></a>
        </div>

        <!-- Search and Filter Section -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-8">
                <div class="input-group input-group-search">
                    <span class="input-group-text bg-white text-danger fff border-end-0">
                        <i class="fas fa-search text-secondary"></i>
                    </span>
                    <input type="text" 
                           class="form-control border-start-0" 
                           placeholder="Search by product name">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <select class="form-select">
                    <option selected>New to Old</option>
                    <option>Old to New</option>
                    <option>Price High to Low</option>
                    <option>Price Low to High</option>
                </select>
            </div>
        </div>

        <!-- Table Section -->
        <div class="card">
            <div class="table-responsive">
                <table class="table table-borderless text-center table-scroll">
                    <thead>
                        <tr>
                            <th scope="col">PRODUCT NAME</th>
                            <th scope="col">CURRENT STOCK</th>
                            <th scope="col">PRICE</th>
                            <th scope="col">SUB CATEGORY</th>
                            <th scope="col" class="text-end">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-secondary bg-opacity-10 p-2 rounded me-3">
                                        <i class="fas fa-cube text-secondary"></i>
                                    </div>
                                    sjr
                                </div>
                            </td>
                            <td>105</td>
                            <td>? 160</td>
                            <td></td>
                            <td class="text-end">
                                <button class="btn btn-link text-dark p-0">
                                    <i class="fas fa-ellipsis-vertical"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
         <nav class="d-flex justify-content-center mt-3">
            <ul class="pagination">
                <li class="page-item aaa">
                    <a class="page-link aaa" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo; Previous</span>
                    </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item aaa">
                    <a class="page-link aaa" href="#" aria-label="Next">
                        <span aria-hidden="true">Next &raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

<!-- End of Page Content-->

<? require_once '../assets/template/inc.footer.php'; ?>