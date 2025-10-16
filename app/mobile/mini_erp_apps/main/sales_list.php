<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";

$title = "Sales List";
$menu = 'home';
$page = "sales_list.php";

require_once '../assets/template/inc.header.php';
?>

<!--<div class="page-content header-clear-small">
	<div class="content">
	    
	</div>
</div>-->

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
		.aaa{
			background-color: #fff;	
			border: 1px solid red;
			width: 90px;
			height: 30px;
			
		
		}
		.page-link span{
			color: #fff;		
		}
		.page-item.active .page-link{
			background-color: red;
			border: none;	
		}
		.page-link span{
			color: black;		
		}
		
		.pagination .page-link {
			padding: 1px 12px 3px;
	
		}
	  </style> 

<div class="container-fluid py-3 mt-5 pt-3">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 text-danger">Sales List</h4>
            <div class="bg-white border rounded px-3 py-2">
                <i class="far fa-calendar me-2"></i>
                Feb 01, 2025 - Feb 28, 2025
            </div>
        </div>

        <!-- Search Section -->
        <div class="row g-2 mb-3">
            <div class="col-12 col-md-8 d-flex gap-2 mb-3">
                <div class="input-group input-group-search">
                    <span class="input-group-text text-danger fff border-end-0 ">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Search by Name or Mobile Number">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <button class="btn btn-danger w-100">Search</button>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-borderless text-center table-scroll">
                <thead>
                    <tr>
                        <th class="w-5">#</th>
                        <th class="w-5">Item</th>
                        <th class="w-5">Contact</th>
                        <th class="w-5">Amount</th>
                        <th class="w-5">Date</th>
                        <th class="w-5">Payment Status</th>
                        <th class="text-end">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="align-middle">
                        <td>2297036</td>
                        <td>1</td>
                        <td>Md Nizam Uddin</td>
                        <td>Tk50</td>
                        <td>16th February, 06:08 PM</td>
                        <td><span class="badge bg-danger-subtle text-danger">Due</span></td>
                        <td class="text-end">
                            <button class="btn btn-link text-dark p-0">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="align-middle">
                        <td>2295031</td>
                        <td>2</td>
                        <td>rtt</td>
                        <td>Tk50</td>
                        <td>16th February, 06:08 PM</td>
                        <td><span class="badge bg-danger-subtle text-danger">Due</span></td>
                        <td class="text-end">
                            <button class="btn btn-link text-dark p-0">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="align-middle">
                        <td>2295004</td>
                        <td>3</td>
                        <td></td>
                        <td>Tk50</td>
                        <td>16th February, 06:08 PM</td>
                        <td><span class="badge bg-success-subtle text-success">Cash</span></td>
                        <td class="text-end">
                            <button class="btn btn-link text-dark p-0">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
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