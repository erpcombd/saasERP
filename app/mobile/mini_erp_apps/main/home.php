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


	  <style>
	  .container{
	 	margin-top: 60px; 
	  }
	  .borderWH {

		background-color: #fce0df !important;
		border-radius: 10px !important;

	}
	  
	  </style> 

    
<!--<div class="page-content header-clear-small">
	<div class="content">-->
     <div class="container">
        <!-- Input Fields -->
        <!--<div class="row g-3 mb-5">-->
		
            <div class="row  g-3 mb-1 mt-1">

			<div class="col-6 pe-2">
				<div class="card borderWH card-style mx-0 mb-1">
					<div class="p-3">
						<h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2"> Today's Buy</h4>
						<h1 class="font-700 font-34 color-green-dark  mb-0">
						00
							<span class="textspan">  </span>
						</h1>
						<i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
					</div>
				</div>
			</div>
			<div class="col-6 ps-2 pe-2">
				<div class="card borderWH card-style mx-0 mb-1">
					<div class="p-3">
						<h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2"> Today's Sell</h4>
						<h1 class="font-700 font-34 color-blue-dark mb-0">
						00
							<span class="textspan"></span>
						</h1>
						<i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
					</div>
				</div>
			</div>
			<div class="col-6 pe-2">
				<div class="card borderWH card-style mx-0 mb-0">
					<div class="p-3">
						<h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2">Today's Expense</h4>
						<h1 class="font-700 font-34 color-yellow-dark mb-0">
						00
							<span class="textspan"></span>
						</h1>
						<i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
					</div>
				</div>
			</div>
			<div class="col-6 ps-2 pe-2">
				<div class="card borderWH card-style mx-0 mb-0">
					<div class="p-3">
						<h4 class="font-700 text-uppercase font-12 opacity-50 mt-n2">Today's Stock</h4>
						<h1 class="font-700 font-34 color-red-dark mb-0">
						00
							<span class="textspan"></span>
						</h1>
						<i class="fa fa-arrow-right float-end mt-n3 opacity-20"></i>
					</div>
				</div>
			</div>
		</div>
	

      <!--  </div>-->

        <!-- Action Buttons -->
        <div class="row g-3 mb-4 mt-0">
            <div class="col-6">
			<a href="buy_item.php">
                <button class="btn btn-danger w-100 py-2 rounded-3 fw-bold text-uppercase">
                    <i class="fas fa-shopping-cart me-2"></i>Buy
                </button>
			</a>
            </div>
            
            <!-- Sell Button -->
            <div class="col-6">
			<a href="sell_item.php">
                <button class="btn btn-danger w-100 py-2 rounded-3 fw-bold text-uppercase">
                    <i class="fas fa-store me-2"></i>Sell
                </button>
				</a>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="row g-4 mb-5 pb-5">
            <!-- Buy Book -->
            <div class="col-3">
			<a href="purchase_list.php">
                <div class="text-center">
                    <div class="bg-success bg-opacity-10 rounded-3 p-3 mb-2 mx-auto" style=" height: 79px;">
                       <img src="../assets/images/home/buyicon300px.png" style="width: 50px; height: 50px;"/>
                    </div>
                    <div class="small text-secondary">Purchase List</div>
                </div>
				</a>
            </div>

            <!-- Sell Book -->
            <div class="col-3">
			<a href="sales_list.php">
                <div class="text-center">
                    <div class="bg-danger bg-opacity-10 rounded-3 p-3 mb-2 mx-auto" style=" height: 79px;">
                      <img src="../assets/images/home/sellicon.png" style="width: 50px; height: 50px;"/>
                    </div>
                    <div class="small text-secondary">Sell List</div>
                </div>
				</a>
            </div>

            <!-- Due Book -->
            <div class="col-3">
			<a href="due_payment_list.php">
                <div class="text-center">
                    <div class="bg-warning bg-opacity-10 rounded-3 p-3 mb-2 mx-auto" style=" height: 79px;">
                      <img src="../assets/images/home/Duebook300px.png" style="width: 50px; height: 50px;"/>
                    </div>
                    <div class="small text-secondary">Due List</div>
                </div>
				</a>
            </div>

            <!-- Expense -->
            <div class="col-3">
			<a href="expense_list.php">
                <div class="text-center">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3 mb-2 mx-auto" style=" height: 79px;">
                        <img src="../assets/images/home/expense300px.png" style="width: 50px; height: 50px;"/>
                    </div>
                    <div class="small text-secondary">Expense</div>
                </div>
				</a>
            </div>

            <!-- Product -->
            <div class="col-3">
			<a href="product_list.php">
                <div class="text-center">
                    <div class="bg-danger bg-opacity-10 rounded-3 p-3 mb-2 mx-auto" style=" height: 79px;">
                      <img src="../assets/images/home/product300px.png" style="width: 50px; height: 50px;"/>
                    </div>
                    <div class="small text-secondary">Product List</div>
                </div>
				</a>
            </div>

            <!-- Stock List -->
            <div class="col-3">
			<a href="#">
                <div class="text-center">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3 mb-2 mx-auto" style=" height: 79px;">
                        <img src="../assets/images/home/stock300px.png" style="width: 50px; height: 50px;"/>
                    </div>
                    <div class="small text-secondary">Stock List</div>
                </div>
				</a>
            </div>

            <!-- Report -->
            <div class="col-3">
			<a href="#">
                <div class="text-center">
                    <div class="bg-warning bg-opacity-10 rounded-3 p-3 mb-2 mx-auto" style=" height: 79px;">
                       <img src="../assets/images/home/report300px.png" style="width: 50px; height: 50px;"/>
                    </div>
                    <div class="small text-secondary">Report</div>
                </div>
				</a>
            </div>
			

            <!-- Settings -->
            <div class="col-3">
				<a href="#">
                <div class="text-center">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-3 mb-2 mx-auto" style=" height: 79px;">
                        <img src="../assets/images/home/Settings300px.png" style="width: 50px; height: 50px;"/>
                    </div>
                    <div class="small text-secondary">Settings</div>
                </div>
				</a>
            </div>

            <!-- Online Shop -->
            <!--<div class="col-3">
                <div class="text-center">
                    <div class="bg-danger bg-opacity-10 rounded-3 p-3 mb-2 mx-auto" style="width: 50px; height: 50px;">
                        <i class="fas fa-shopping-bag text-danger"></i>
                    </div>
                    <div class="small text-secondary">Online Shop</div>
                </div>
            </div>-->
        </div>
    </div>
	</div>

   

    

<!-- End of Page Content-->

<? require_once '../assets/template/inc.footer.php'; ?>
