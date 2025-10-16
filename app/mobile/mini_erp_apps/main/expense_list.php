<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";

$title = "Expense List";
$menu = 'home';
$page = "expense_list.php";

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
</style>

 <div class="container-fluid py-3  mt-5 pt-3">
        <!-- Header Section -->
        <div class="d-flex flex-wrap  justify-content-between align-items-center mb-4 gap-3">
            <h4 class="mb-0 text-danger">Expense Report</h4>
			<a href="add_expense_item.php"><button class="btn btn-danger d-flex align-items-center">
                    <i class="fas fa-plus me-2"></i>
                    New Expense
                </button>
				</a>
            <div class="d-flex flex-wrap  gap-2">
                <button class="btn btn-outline-secondary d-flex align-items-center">
                    <i class="far fa-calendar me-2"></i>
                    Feb 01, 2025 - Feb 28, 2025
                </button>
                <button class="btn btn-outline-secondary d-flex align-items-center">
                    <i class="fas fa-list me-2"></i>
                    Expense List
                </button>
                
            </div>
        </div>

        <!-- Table Section -->
        <div class="card">
            <div class="table-responsive">
                <table class="table table-borderless text-center table-scroll">
                    <thead>
                        <tr>
                            <th scope="col">TRANSACTION TYPE</th>
                            <th scope="col">AMOUNT</th>
                            <th scope="col">DATE&TIME</th>
                            <th scope="col">NOTES</th>
                            <th scope="col" class="text-end">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Empty state message -->
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                No transactions found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Table Footer -->
            <div class="card-footer bg-white border-top-0 text-center text-muted">
                Showing 10 of 100 Transactions
            </div>
        </div>
    </div>

<!-- End of Page Content-->

<? require_once '../assets/template/inc.footer.php'; ?>