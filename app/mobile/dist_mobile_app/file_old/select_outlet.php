<?php

session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Outlet Offer";
$page = "setup_opening.php";


require_once '../assets/template/inc.header.php';


$user_id		= $_SESSION['user_id'];
$emp_code		= $_SESSION['user']['username'];

$dealer_code	= $_SESSION['user']['warehouse_id'];
$dinfo = findall("select * from dealer_info where dealer_code='" . $dealer_code . "' ");


$dealer_code = $dinfo->dealer_code;
$dealer_name = $dinfo->dealer_name_e;



$page_for           = 'Select_outlate';
$table_master       = 'ss_receive_master';
$table_details      = 'ss_receive_details';
$unique = 'or_no';

$offer_name = 'Offer April-24';
$offer_no = 'Offer April-24';
$fdate = '2024-04-01';
$tdate = '2024-04-30';
?>
<script>
	function getXMLHTTP() { //fuction to return the xml http object

		var xmlhttp = false;

		try {

			xmlhttp = new XMLHttpRequest();

		} catch (e) {

			try {

				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {

				try {

					xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

				} catch (e1) {

					xmlhttp = false;

				}

			}

		}

		return xmlhttp;

	}





	function update_value2(id) {


		var shop_code = id;

		var f_date = (document.getElementById('f_date').value);
		var t_date = (document.getElementById('t_date').value);
		var flag = (document.getElementById('flag_' + id).value);

		var offer_name = (document.getElementById('offer_name').value);
		var gift_name = (document.getElementById('gift_' + id).value);


		var strURL = "ajax_select_offer.php?shop_code=" + shop_code + "&offer_name=" + offer_name + "&gift_name=" + gift_name + "&f_date=" + f_date + "&t_date=" + t_date + "&flag=" + flag;

		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {
						document.getElementById('divi_' + id).style.display = 'inline';
						document.getElementById('divi_' + id).innerHTML = req.responseText;
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}
			}
			req.open("GET", strURL, true);
			req.send(null);
		}

	}
</script>





<!-- start of Page Content-->
<div class="page-content header-clear-medium">








	<form action="" method="post">

		<div class="card card-style">
			<div class="content">


				<!-- <div class="input-style input-style-always-active  has-borders no-icon validate-field mb-4">		 -->
				<label for="manager_name">Party</label>

				<input type="text" class="form-control validate-text" value=" <?= $dealer_code; ?>-<?= $dealer_name; ?>" placeholder="Party" required>
				<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div> -->


				<!-- <div class="input-style-new input-style-always-active has-borders no-icon mb-4"> -->
				<label for="odate">Date</label>


				<input class="form-control validate-text" name="f_date" type="date" id="f_date" value="<?= $fdate ?>" readonly />

				<!-- <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
						<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
					</div> -->

				<!-- <div class="input-style-new input-style-always-active has-borders no-icon mb-4"> -->
				<label for="odate">Date</label>


				<input class="form-control validate-text" name="t_date" type="date" id="t_date" value="<?= $tdate ?>" readonly />

				<!-- <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
						<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
					</div> -->






				<div class="d-flex justify-content-center row mt-3">
					<div class="col-6">

						<input class="btn btn-3d btn-m btn-full mb-3 rounded-xs font-900 b-n shadow-s btn-success w-100" type="submit" name="submitit" id="submitit" value="Open Shop" />


					</div>
				</div>
			</div>

		</div>



		<div class="content">

			<?
			// function: ss_gift_offer_monthly2

			function generateDropdown($itemList)
			{
				$items = explode("/", $itemList);
				foreach ($items as $item) {
					echo '<option value="' . $item . '">' . $item . '</option>';
				}
			}
			// end function

			if (isset($_POST['submitit'])) {


				$f_date         = $_POST['f_date'];
				$t_date         = $_POST['t_date'];



				$offer_item_list = find1("select item_list from ss_gift_offer_monthly2 where start_date='" . $f_date . "' limit 1");
				$offer_con = ' and i.item_id in (' . $offer_item_list . ')';

				// 2nd chalan amount outlet wise
				$sql_sales = 'select s.dealer_code,sum(c.total_amt) as amount
from item_info i, ss_do_chalan c, ss_shop s, ss_do_master m
where i.item_id=c.item_id and s.dealer_code=c.dealer_code and m.do_no=c.do_no
and c.chalan_date between "' . $f_date . '" and "' . $t_date . '" and c.entry_by="' . $emp_code . '" and m.gift_status=1
' . $offer_con . '
group by s.dealer_code order by s.dealer_code';

				$query2 = mysqli_query($conn, $sql_sales);
				while ($info = mysqli_fetch_object($query2)) {
					$sales_amt[$info->dealer_code] = $info->amount;
				}


				// old history find out
				// $sql_offer='select offer_name,shop_code,gift_name from ss_gift_delivery_list
				// where offer_name="'.$offer_name.'" and start_date = "'.$f_date.'" group by shop_code order by shop_code';

				// $query3 = mysqli_query($conn,$sql_offer);
				// while($info3=mysqli_fetch_object($query3)){

				//     $offer[$info3->shop_code]   = $info3->gift_name;
				//     $flag[$info3->shop_code]    = 1;
				// }


			?>

				<input name="offer_name" type="hidden" id="offer_name" value="<?= $offer_name; ?>" />



				<table class="table table-borderless text-center rounded-sm shadow-l table_new_border" style="overflow: hidden;">
					<thead>
						<tr class="bg-night-light">
							<th scope="col" class="color-white">Outlate List</th>
							<th scope="col" class="color-white">Offer Slab</th>
							<th scope="col" class="color-white">Offer</th>
							<th scope="col" class="color-white"></th>
						</tr>
					</thead>
					<tbody>

						<?

						$sql = "select s.* from ss_shop s
where s.emp_code='" . $emp_code . "'
order by dealer_code";

						$query = mysqli_query($conn, $sql);
						while ($data = mysqli_fetch_object($query)) {
							//if($sales_amt[$data->dealer_code]>4999){
							$i++;
						?>
							<tr bgcolor="<?= ($i % 2) ? '#E8F3FF' : '#fff'; ?>">

								<td><?= $data->dealer_code ?><br><?= $data->shop_name ?></td>
								<td><strong><?= $sales_amt[$data->dealer_code];
											$gsales += $sales_amt[$data->dealer_code]; ?></strong>
									<br>
									<? echo $gift_list = getCustomerOfferItem($sales_amt[$data->dealer_code]); ?>
								</td>
								<? if ($sales_amt[$data->dealer_code] > 4999) { ?>
									<td><? $do_ase = findall("select oi_no,status from ss_do_gift_master where shop_code='" . $data->dealer_code . "' and offer_no='" . $offer_no . "'");
										if ($do_ase->oi_no > 0) {
											echo $do_ase->status;
										} else {
										?>
											<a href="gift_entry.php?shop=<?= $data->dealer_code ?>">GET Offer</a>
										<? } ?>
									</td>
								<? } else { ?>
									<td>No Offer</td>
									<td></td>
								<? } ?>




							</tr>
						<? } ?>

					</tbody>
				</table>



			<? } ?>
		</div>




	</form>

</div>
<!-- End of Page Content-->













<?php
require_once '../assets/template/inc.footer.php';
?>


<script type="text/javascript">
	function FetchItemCategory(id) {
		$('#category_id').html('');
		$('#subcategory_id').html('');
		$.ajax({
			type: 'post',
			url: 'get_data.php',
			data: {
				item_group: id
			},
			success: function(data) {
				$('#category_id').html(data);
			}

		})
	}

	function FetchItemSubcategory(id) {
		$('#subcategory_id').html('');
		$('#item_id').html('');
		$.ajax({
			type: 'post',
			url: 'get_data.php',
			data: {
				category_id: id
			},
			success: function(data) {
				$('#subcategory_id').html(data);
			}

		})
	}


	function FetchItem(id) {
		$('#item_id').html('');
		$.ajax({
			type: 'post',
			url: 'get_data.php',
			data: {
				subcategory_id: id
			},
			success: function(data) {
				$('#browsers').html(data);
			}

		})
	}
</script>