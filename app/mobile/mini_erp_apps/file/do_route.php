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


//if($_GET['pal']==2) { unset($$unique); unset($_SESSION['do_no2']); $type=1;}

$dealer_code = $_SESSION['user']['warehouse_id'];
//do_calander('#est_date');

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



if (isset($_POST['new'])) {
				// $_POST['latitude']=$_POST['latitude_do'];
				// $_POST['longitude']=$_POST['longitude_do'];

				$crud   = new crud($table_master);
				$dealer = find_all_field('ss_shop', '', 'dealer_code=' . $_POST['dealer_code']);
				$_POST['status'] = 'MANUAL';
				//$_POST['do_date']=date('Y-m-d');
				$_POST['entry_at'] = date('Y-m-d H:s:i');
				$_POST['entry_by'] = $username;
				if ($_POST['shop_status'] == 'Get Order') {
					$_POST['memo'] = 1;
				} else {
					$_POST['memo'] = 0;
				}

				if ($_POST['flag'] == 0) {
					$_POST['do_no'] = find_a_field($table_master, 'max(do_no)', '1') + 1;
					$$unique_master = $crud->insert();
					unset($$unique);
					$type = 1;
					$msg = 'Work Order Initialized. (Demand Order No-' . $$unique_master . ')';
					
					//header("Location: do_entry.php?order_id=".$$unique_master);
					?><script>window.location.href = "do_entry.php?order_id=<?=$$unique_master?>"</script><?
				} 
				
				else {
					$crud->update($unique_master);
					$type = 1;
					$msg = 'Successfully Updated.';
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
	/* Force scrollable dropdown for select2 */
	.select2-container .select2-results__options {
		max-height: 200px !important;
		/* Force max height */
		overflow-y: auto !important;
		/* Enable scrolling */
		-webkit-overflow-scrolling: touch !important;
		/* Smooth scrolling on mobile */
		scroll-behavior: smooth !important;
		/* Ensure smooth scrolling */
	}

	/* Make sure the dropdown is fully visible on mobile */
	@media only screen and (max-width: 600px) {
		.select2-container .select2-dropdown {
			position: relative !important;
			/* Ensure proper positioning */
			width: 100% !important;
			/* Ensure the dropdown is wide enough */
		}
	}
	}
</style>



<!-- start of Page Content-->
<div class="page-content header-clear-medium">




	<div class="card card-style">
		<form action="" method="post" name="codz2" id="codz2">
			<input class="form-control" name="visit" type="hidden" id="visit" value="1" required readonly="readonly" />
			<div class="content m-0">
				<?
				if ($dealer_code == '') {  ?>
					<label for="route_id">Route</label>

					<select name="route_id" id="route_id" onchange="FetchShopList(this.value)">
						<? optionlist("select s.route_id,r.route_name from ss_route r, ss_shop s where s.route_id=r.route_id and s.emp_code='" . $_SESSION['user']['username'] . "' group by s.route_id order by route_name"); ?>
					</select>
				<? } ?>




				<label for="dealer_code">Shop</label>

				<select name="dealer_code" required="required" id="dealer_code" class="select2-container select2-results__options" style=" overflow-y: auto !important;">

					<? if ($_GET['party'] > 0) { ?>
						<option value="<?= $party ?>"><?= find1("select concat(dealer_code,'-',shop_name) from ss_shop where dealer_code='" . $party . "' "); ?></option>
					<? } else { ?>
						<option value="<?= $dealer_code ?>"><?= find1("select concat(dealer_code,'-',shop_name) from ss_shop where dealer_code='" . $dealer_code . "' "); ?></option>
					<? } ?>

					<?
					if ($_GET['party'] > 0) {
					} else {
						if ($dealer_code == '') {
							// optionlist('select s.dealer_code,concat(r.route_name,"-",s.shop_name) as shop_name 
							// from ss_shop s, ss_route r 
							// where s.route_id=r.route_id and s.status="1" and s.emp_code="'.$_SESSION['username'].'" 
							// order by r.route_id,s.shop_name');
						}
					}
					?>


				</select>



				 <div class="input-style input-style-always-active has-borders no-icon validate-field mb-4" style=" display: none; "> 
				<label for="do_no">SO</label>
				<input name="do_no" id="do_no" placeholder="do_no"
					value="<? if ($$unique_master > 0) echo $$unique_master;
							else echo (find_a_field($table_master, 'max(' . $unique_master . ')', '1') + 1); ?>" readonly="readonly">
					</div> 

<div class="row ms-0 p-0 me-0">
				<div class="col-6 pe-2 p-0"> 
				<label for="<?= $field ?>">DO Date</label>
				<? $field = 'do_date';
				if ($do_date == '') $do_date = date('Y-m-d'); ?>
				<input class="form-control validate-text" name="<?= $field ?>" type="date" id="<?= $field ?>" value="<?= $$field ?>" required <? if ($do_date != '') { ?> <? } ?> />
				</div>


				 <div class="col-6 ps-2 p-0"> 
				<label for="remarks">Note</label>
				<textarea name="remarks" id="remarks" placeholder="Note" value="<?= $remarks ?>" class="form-select form-control"></textarea>
				 </div> 
</div>

				 <div class="input-style input-style-always-active has-borders no-icon validate-field mb-4" style=" display: none; "> 
				<? $field = 'shop_status'; ?>
				<label for="<?= $field ?>">Status</label>
				<select class="form-control" name="<?= $field ?>" id="<?= $field ?>" required>

					<?
					if ($$field != '') { ?>
						<option><? echo $$field;
								$shop_status = $$field; ?></option>

						<? } else {
						if ($_GET['party'] > 0 && $_GET['new'] == '') { ?>

							<option>No Order</option>
							<option>Close</option>

						<? } else { ?>
							<option>Get Order</option>
						<? } ?>
					<? } ?>
				</select>
					</div> 


<div class="row m-0">
						<div class="col-4 p-0 pe-1">
							<? if($$unique_master>0) {?>
							  <input name="new" type="submit" value="Update" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s  border-blue-dark bg-blue-light w-100" />
							  <input name="flag" id="flag" type="hidden" value="1" />
					
							<? }else{?>
							  <input name="new" type="submit" value="Get Order" class=" b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" />
							  <input name="flag" id="flag" type="hidden" value="0" />
							<? }?>
						</div>
						<div class="col-4 p-0 pe-1">
							<input type="button" value="Close" class=" b-n btn btn-primary btn-3d btn-block  text-light w-100 py-3" />
						</div>
						<div class="col-4 p-0">
							<input name="new" type="submit" value="No Order" class=" b-n btn btn-danger btn-3d btn-block  text-light w-100 py-3" />
						</div>
					</div>
					
					
				<!--<div class="row mt-3">
					<div class="col-6">
						<a href="do_view.php?do=<?php echo $$unique_master; ?>"><input type="button" value="View" class="btn btn-3d btn-m btn-full mb-3 rounded-xs  font-900 shadow-s btn-success w-100"/></a>
					</div>
					<div class="col-6">
						<? if ($$unique_master > 0) { ?>
							<input name="new" type="submit" value="Update" class="btn btn-3d btn-m btn-full mb-3 rounded-xs  font-900 shadow-s  btn-primary w-100" />
							<input name="flag" id="flag" type="hidden" value="1" />

						<? } else { ?>
							<input name="new" type="submit" value="Initiate" class="btn btn-3d btn-m btn-full mb-3 rounded-xs  font-900 shadow-s btn-primary w-100" />
							<input name="flag" id="flag" type="hidden" value="0" />
						<? } ?>
					</div>
				</div>-->
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
			x.innerHTML = "Geolocation is not supported by this browser.";
		}
	}

	function showPosition(position) {

		var lat = position.coords.latitude;
		var long = position.coords.longitude;
		document.getElementById("latitude_do").value = lat;
		document.getElementById("longitude_do").value = long;
		document.getElementById("latitude").value = lat;
		document.getElementById("longitude").value = long;
	}
</script>

<script>
	window.onload = function() {
		getLocation();
	};
</script>




<script type="text/javascript">
	function FetchShopList(id) {
		$('#dealer_code').html('');
		$.ajax({
			type: 'post',
			url: 'get_data.php',
			data: {
				route_id: id
			},
			success: function(data) {
				$('#dealer_code').html(data);
			}

		})
	}

	$(document).ready(function() {
		$('#dealer_code').select2({
			placeholder: "Select", // Placeholder text
			allowClear: true, // Allow clearing the selection
			dropdownAutoWidth: true, // Auto width for dropdown
			width: '100%' // Full width for the dropdown
		});
	});
</script>