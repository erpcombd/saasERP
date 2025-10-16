<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

//$title = "DO_Route";
$title = "Un Route Wise Order";
$page = 'do.php';

require_once '../assets/template/inc.header.php';

$group_for 	    = $_SESSION['user']['company_id'] = 1;
$user_id	    = $_SESSION['user']['user_id'];
$username	    = $_SESSION['user']['username'];
$pg	            = $_SESSION['user']['product_group'];
$region_id	    = $_SESSION['user']['region_id'];
$zone_id	    = $_SESSION['user']['zone_id'];
$area_id	    = $_SESSION['user']['area_id'];

if ($_GET['party'] > 0) {
	$party = $_GET['party'];
} else {
	$party = '';
}

$dealer_code = $_SESSION['user']['warehouse_id'];

$table_master = 'ss_do_master';
$unique_master = 'do_no';
$table_detail = 'ss_do_details';
$unique_detail = 'id';

$dealer = find_all_field('ss_shop', '', 'dealer_code=' . $dealer_code);

if ($_REQUEST['old_do_no'] > 0) $$unique_master = $_REQUEST['old_do_no'];
elseif (isset($_GET['del'])) {
	$$unique_master = find_a_field('ss_do_details', 'do_no', 'id=' . $_GET['del']);
	$del = $_GET['del'];
} else
	$$unique_master = $_REQUEST[$unique_master];

$do_status = find_a_field('ss_do_master', 'status', 'do_no="' . $$unique_master . '"');

// Handle form submissions
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    // Common settings for all actions
    $crud = new crud($table_master);
    $dealer = find_all_field('ss_shop', '', 'dealer_code=' . $_POST['dealer_code']);
    $_POST['entry_at'] = date('Y-m-d H:s:i');
    $_POST['entry_by'] = $username;
    
    if ($action == 'get_order') {
        $_POST['status'] = 'MANUAL';
        $_POST['shop_status'] = 'Get Order';
        $_POST['memo'] = 1;
        
        if ($_POST['flag'] == 0) {
            $_POST['do_no'] = find_a_field($table_master, 'max(do_no)', '1') + 1;
            $$unique_master = $crud->insert();
            unset($$unique);
            $type = 1;
            $msg = 'Work Order Initialized. (Demand Order No-' . $$unique_master . ')';
            
            ?><script>window.location.href = "do_entry.php?order_id=<?=$$unique_master?>"</script><?php
        } else {
            $crud->update($unique_master);
            $type = 1;
            $msg = 'Successfully Updated.';
        }
    } 
    elseif ($action == 'no_order') {
        // Check if remarks field is filled
        if (empty($_POST['remarks'])) {
            echo "<script>alert('Please add a note before submitting No Order.'); history.back();</script>";
            exit;
        }
        
        $_POST['status'] = 'MANUAL';
        $_POST['shop_status'] = 'No Order';
        $_POST['memo'] = 0;
        
        if ($_POST['flag'] == 0) {
            $_POST['do_no'] = find_a_field($table_master, 'max(do_no)', '1') + 1;
            $$unique_master = $crud->insert();
            $msg = 'No Order Saved. (Demand Order No-' . $$unique_master . ')';
        } else {
            $crud->update($unique_master);
            $msg = 'No Order Status Updated.';
        }
        
        ?><script>window.location.href = "../main/home.php"</script><?php
    }
    elseif ($action == 'close') {
        // Check if remarks field is filled
        if (empty($_POST['remarks'])) {
            echo "<script>alert('Please add a note before closing the order.'); history.back();</script>";
            exit;
        }
        
        $_POST['status'] = 'MANUAL';
        $_POST['shop_status'] = 'Close';
        $_POST['memo'] = 0;
        
        if ($_POST['flag'] == 0) {
            $_POST['do_no'] = find_a_field($table_master, 'max(do_no)', '1') + 1;
            $$unique_master = $crud->insert();
            $msg = 'Order Closed. (Demand Order No-' . $$unique_master . ')';
        } else {
            $crud->update($unique_master);
            $msg = 'Order Status Updated to Close.';
        }
        
        ?><script>window.location.href = "../main/home.php"</script><?php
    }
}

if ($$unique_master > 0) {
    $condition = $unique_master . "=" . $$unique_master;
    $data = db_fetch_object($table_master, $condition);
    foreach ($data as $key => $value) {
        $$key = $value;
    }
}

$dealer = find_all_field('ss_shop', '', 'dealer_code=' . $dealer_code);
?>

<style>
	/* Make select2 dropdown scrollable */
	.select2-container .select2-results__options {
		max-height: 200px !important;
		overflow-y: auto !important;
		-webkit-overflow-scrolling: touch !important;
		scroll-behavior: smooth !important;
	}

	/* Make sure the dropdown is fully visible on mobile */
	@media only screen and (max-width: 600px) {
		.select2-container .select2-dropdown {
			position: relative !important;
			width: 100% !important;
		}
	}
	
	.btn-action {
	    width: 100%;
	    padding: 12px;
	    font-weight: bold;
	    text-transform: uppercase;
	}
</style>

<!-- start of Page Content-->
<div class="page-content header-clear-medium">
    <div class="card card-style">
        <form action="" method="post" name="codz2" id="codz2">
            <input class="form-control" name="visit" type="hidden" id="visit" value="1" required readonly="readonly" />
            <div class="content m-0">
                <?php if ($dealer_code == '') { ?>
                    <label for="route_id">Route</label>
                    <select name="route_id" id="route_id" onchange="FetchShopList(this.value)" class="form-control mb-3">
                        <option value="">Select Route</option>
                        <?php optionlist("select s.route_id,r.route_name from ss_route r, ss_shop s where s.route_id=r.route_id and s.emp_code='" . $_SESSION['user']['username'] . "' group by s.route_id order by route_name"); ?>
                    </select>
                <?php } ?>

                <label for="dealer_code">Shop</label>
                <select name="dealer_code" required="required" id="dealer_code" class="form-control mb-3">
                    <?php if ($_GET['party'] > 0) { ?>
                        <option value="<?= $party ?>"><?= find1("select concat(dealer_code,'-',shop_name) from ss_shop where dealer_code='" . $party . "' "); ?></option>
                    <?php } else { ?>
                        <option value="<?= $dealer_code ?>"><?= find1("select concat(dealer_code,'-',shop_name) from ss_shop where dealer_code='" . $dealer_code . "' "); ?></option>
                    <?php } ?>
                    <?php
                    if ($_GET['party'] > 0) {
                    } else {
                        if ($dealer_code == '') {
                            // Shop options will be loaded via AJAX for empty dealer_code
                        }
                    }
                    ?>
                </select>

                <!-- Hidden DO Number field -->
                <input type="hidden" name="do_no" id="do_no" value="<?php 
                    if ($$unique_master > 0) 
                        echo $$unique_master;
                    else 
                        echo (find_a_field($table_master, 'max(' . $unique_master . ')', '1') + 1); 
                ?>">

                <div class="row mb-3">
                    <div class="col-6">
                        <label for="do_date">DO Date</label>
                        <?php $field = 'do_date';
                        if ($do_date == '') $do_date = date('Y-m-d'); ?>
                        <input class="form-control" name="<?= $field ?>" id="<?= $field ?>" value="<?= $$field ?>" required readonly/>
                    </div>

                    <div class="col-6">
                        <label for="remarks">Note <span class="text-danger">*</span></label>
                        <textarea name="remarks" id="remarks" placeholder="Note" class="form-control"><?= $remarks ?></textarea>
                    </div>
                </div>

                <!-- Hidden shop_status field -->
                <input type="hidden" name="shop_status" id="shop_status" value="<?= $shop_status ? $shop_status : 'Get Order' ?>">

                <div class="row m-0 mt-3">
                    <div class="col-4 p-0 pe-1">
                        <?php if($$unique_master > 0) { ?>
                            <button type="submit" name="action" value="get_order" class="btn btn-success btn-action">Update</button>
                            <input type="hidden" name="flag" id="flag" value="1" />
                        <?php } else { ?>
                            <button type="submit" name="action" value="get_order" class="btn btn-success btn-action">Get Order</button>
                            <input type="hidden" name="flag" id="flag" value="0" />
                        <?php } ?>
                    </div>
                    <div class="col-4 p-0 pe-1">
                        <button type="submit" name="action" value="close" id="closeBtn" class="btn btn-primary btn-action">Close</button>
                    </div>
                    <div class="col-4 p-0">
                        <button type="submit" name="action" value="no_order" id="noOrderBtn" class="btn btn-danger btn-action">No Order</button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="latitude" id="latitude_do" value="" readonly="">
            <input type="hidden" name="longitude" id="longitude_do" value="" readonly="">
        </form>
    </div>
</div>
<!-- End of Page Content-->

<?php
require_once '../assets/template/inc.footer.php';

//selected_two("#dealer_code");
selected_two("#category_id");
selected_two("#subcategory_id");
selected_two("#item_id");
?>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        document.getElementById("latitude_do").value = lat;
        document.getElementById("longitude_do").value = long;
        if (document.getElementById("latitude")) {
            document.getElementById("latitude").value = lat;
        }
        if (document.getElementById("longitude")) {
            document.getElementById("longitude").value = long;
        }
    }
</script>

<script>
    window.onload = function() {
        getLocation();
        
        // Add client-side validation for the note field
        document.getElementById('closeBtn').addEventListener('click', function(e) {
            var remarks = document.getElementById('remarks').value.trim();
            if (remarks === '') {
                e.preventDefault();
                alert('Please add a note before closing the order.');
            }
        });
        
        document.getElementById('noOrderBtn').addEventListener('click', function(e) {
            var remarks = document.getElementById('remarks').value.trim();
            if (remarks === '') {
                e.preventDefault();
                alert('Please add a note before submitting No Order.');
            }
        });
    };
</script>

<script type="text/javascript">
    function FetchShopList(id) {
        $('#dealer_code').html('<option value="">Select Shop</option>');
        if (id) {
            $.ajax({
                type: 'post',
                url: 'get_data.php',
                data: {
                    route_id: id
                },
                success: function(data) {
                    $('#dealer_code').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + error);
                }
            });
        }
    }

    $(document).ready(function() {
        $('#dealer_code').select2({
            placeholder: "Select", 
            allowClear: true,
            dropdownAutoWidth: true,
            width: '100%'
        });
    });
</script>