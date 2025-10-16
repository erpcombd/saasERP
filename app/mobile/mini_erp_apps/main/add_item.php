<?php
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";

$title = "Add Item";
$menu = 'home';
$page = "add_item.php";

require_once '../assets/template/inc.header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
 
<style>
.do_entry_card{
	margin-top: 70px;
}

.text-dark{
	margin-left: 10px;
	margin-top:5px;
}
#total_item_amt{
	margin-right: 5px;
}

</style>
</head>
<body class="bg-light">
<!--<div class="page-content header-clear-small">
	<div class="content">
	    
	</div>
</div>-->

					<div class="content">
					<!-- Card Section with custom border size -->
					<div class="do_entry_card custom-card-border"> <!-- Added custom-card-border class -->
						<div class="card-body">
								<div>
								<p class="mb-1  text-dark">Bill No:</p>
								</div>
								<!--Shop Details -->
								<div class="mb-2">
									<p class="mb-1 text-dark"><strong>Supplier:</strong></p>
									<p class="mb-0 text text-dark"><strong style="color:green">Date:</strong> </p>
								</div>

								<!-- Amount -->
								<div class="text-end">
									<h4 class="mb-0">
									<span id="total_item_amt">0</span>
									</h4>
								</div>
							</div>
						</div>
					</div>
				





				<div class="content">

					<div class="row m-0 p-0 pb-3">
						<div class="col-6 pe-1 p-0">
							<!--<label for="form5" class="color-highlight">Category</label>-->
							<select name="category_id" id="category_id" onChange="FetchItemSubcategory(this.value)" class="form-select form-control">

								<option value="">Category</option>
								
							</select>
						</div>



						<div class="col-6 ps-1 p-0">
							<!--						<label for="form5" class="color-highlight">SubCategory</label>-->
							<select name="subcategory_id" id="subcategory_id" onChange="FetchAllItemList(this.value)" class="form-select form-control">
								<option value="">SubCategory</option>
								
							</select>
						</div>

					</div>



					<div class="" style="zoom: 78%;">
						<div id="allitem"> </div>
					</div>
					</div>
					<div class="content">
					  <label for="item_name">Item Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control validate-text" name="item_name" id="item_name" value="" required placeholder="">
				
				<div class="row mb-0">
                    <div class="col-6">
                        <label for="quantity">Quantity</label>
                        <select name="quantity" id="quantity" class="form-control">
                       
                        </select>
                    </div>


                    <div class="col-6">
                        <label for="unit_name">Unit Name <span class="text-danger">*</span></label>
                        <select name="unit_name" id="unit_name" required class="form-control" required>
                        </select>
                    </div>
                </div>
				<div class="row mb-0">
                    <div class="col-6">
                        <label for="unit_price">Unit Price</label>
                        <select name="unit_price" id="unit_price" class="form-control">
                       
                        </select>
                    </div>


                    <div class="col-6">
                        <label for="stock">Stock <span class="text-danger">*</span></label>
                        <select name="stock" id="stock" required class="form-control" required>
                        </select>
                    </div>
                </div>
				<label for="total_amt">Total Amount <span class="text-danger">*</span></label>
                <input type="text" class="form-control validate-text" name="total_amt" id="total_amt" value="" required placeholder="">
				</div>
<!-- End of Page Content-->

<? require_once '../assets/template/inc.footer.php'; ?>


    
</body>
</html>