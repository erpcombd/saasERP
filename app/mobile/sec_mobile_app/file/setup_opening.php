<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Dealer Stock Opening";
$page = "setup_opening.php";


require_once '../assets/template/inc.header.php';


$user_id		= $_SESSION['user_id'];
$emp_code		= $_SESSION['user']['username'];

$dealer_code	= $_SESSION['user']['warehouse_id'];
$dinfo = findall("select * from dealer_info where dealer_code='" . $dealer_code . "' ");

$dealer_code = $dinfo->dealer_code;
$dealer_name = $dinfo->dealer_name_e;


$page_for           = 'Sales Return';
$table_master       = 'ss_receive_master';
$table_details      = 'ss_receive_details';
$unique = 'or_no';
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

	function update_value(id)

	{

		var item_id = id; // Rent

		//var orate=(document.getElementById('orate_'+id).value)*1;  
		var odate = (document.getElementById('odate').value);
		var flag = (document.getElementById('flag_' + id).value);

		var cqty = (document.getElementById('cqty_' + id).value) * 1;
		//var pqty=(document.getElementById('pqty_'+id).value)*1; 


		//var strURL="ajax_setup_opening.php?item_id="+item_id+"&cqty="+cqty+"&orate="+orate+"&pqty="+pqty+"&odate="+odate+"&flag="+flag;
		var strURL = "ajax_setup_opening.php?item_id=" + item_id + "&cqty=" + cqty + "&odate=" + odate + "&flag=" + flag;

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
				<input type="text" class="form-control validate-text" value="<?=$dealer_code; ?>-<?= $dealer_name; ?>" placeholder="Party" required>

				<!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div> -->


				<!-- <div class="input-style-new input-style-always-active has-borders no-icon mb-4"> -->
				<label for="odate">Date</label>
				<input class="form-control validate-text" name="odate" type="date" id="odate" value="<?= $_POST['odate'] ? $_POST['odate'] : date('Y-m-d'); ?>" />

				<label for="category_id">Category</label>
				<select name="category_id" id="category_id" onchange="FetchItemSubcategory(this.value)">
					<option></option>
				<!--	<option value="<?= $_SESSION['category_id']; ?>"><?= find1("select group_name from item_group where group_id='" . $_SESSION['category_id'] . "'"); ?></option>-->
					<?php optionlist("select group_id,group_name from item_group where 1 order by group_name"); ?>
				</select>

				<label for="subcategory_id">SubCategory</label>
				<select name="subcategory_id" id="subcategory_id" onchange="FetchItem(this.value)">
				<option></option>
					<!--<option value="<?= $_SESSION['subcategory_id']; ?>"><?= find1("select sub_group_name from item_sub_group where sub_group_id='" . $_SESSION['subcategory_id'] . "'"); ?></option>-->
					<?php
						if ($_SESSION['category_id'] > 0) {
									$cat_group = " and group_id='" . $_SESSION['category_id'] . "' ";
						}
						optionlist("select sub_group_id,sub_group_name from item_sub_group where 1 " . $cat_group . " order by sub_group_name");
					?>
					
				</select>

				<div class="d-flex justify-content-center row mt-3">
					<div class="col-6">

						<input class="btn btn-3d btn-m btn-full mb-3 rounded-xs font-900 b-n btn-success w-100" type="submit" name="submitit" id="submitit" value="Open Item" />


					</div>
				</div>
			</div>

		</div>



		<div class="content">

			<?
			if (isset($_POST['submitit'])) {

				if (isset($_POST['odate'])) {
					$odate = $_SESSION['odate'] = $_POST['odate'];
					$sodate = date('ymd', strtotime($odate));
				}

				if ($_POST['category_id'] != '') {
					$cat_con = ' and category_id="' . $_POST['category_id'] . '"';
				}
				if ($_POST['subcategory_id'] != '') {
					$subcat_con = ' and subcategory_id="' . $_POST['subcategory_id'] . '"';
				}

			?>


				<table class="table table-borderless text-center table-scroll" style="overflow: hidden;">
					<thead>
						<tr class="bg-night-light1">
							<th scope="col" class="color-white">Item Name</th>
							<th scope="col" class="color-white">Stock Qty</th>
							<th scope="col" class="color-white">Action</th>
						</tr>
					</thead>
					<tbody>

						<?

						$tr_from = 'Opening';
					$sql = "select item_price,j.item_in,j.item_ex,i.item_id 
from ss_journal_item j, item_info i 
where i.item_id=j.item_id 
and  j.warehouse_id='" . $dealer_code . "'  and j.tr_from='" . $tr_from . "' 
" . $cat_con . $subcat_con . "
and j.ji_date = '" . $_POST['odate'] . "'
group by i.item_id ";

						$query = mysqli_query($conn, $sql);
						while ($data = mysqli_fetch_object($query)) {
							$item_in[$data->item_id] = $data->item_in;
							$item_ex[$data->item_id] = $data->item_ex;
							$flag[$data->item_id] = 1;
						}


						$sql = "select * from item_info where 1
" . $cat_con . $subcat_con . "
order by item_name";
						$query = mysqli_query($conn, $sql);
						while ($data = mysqli_fetch_object($query)) {
							$i++;
						?>
							<tr bgcolor="<?= ($i % 2) ? '#E8F3FF' : '#fff'; ?>">
								<!--<td><?= $data->finish_goods_code ?></td>-->
								<td><?= $data->finish_goods_code ?><br><?= $data->item_name ?></td>
								<!--    <td><? //=$data->unit_name
											?></td>
    <td width="11%">
<input name="orate_<?= $data->item_id ?>" id="orate_<?= $data->item_id ?>" value="<?= $data->f_price ?>" style="width:40px;"/>
<input type="hidden" name="orate_<?= $data->item_id ?>2" id="orate_<?= $data->item_id ?>2" value="<?= ($pre_stock[$data->item_id]) ?>" style="width:70px;"/>
</td>-->


								<td width="10%"><input class="form-control" name="cqty_<?= $data->item_id ?>" id="cqty_<?= $data->item_id ?>" type="number"
										value="<? if ($item_in[$data->item_id] > 0) {
													echo (int)$item_in[$data->item_id];
												} ?>"
										style="width:100px;" /></td>

								<!--<td><input name="pqty_<?= $data->item_id ?>" id="pqty_<?= $data->item_id ?>" type="text" value="<?= (int)($item_ex[$data->item_id]) ?>" style="width:40px;" /><td width="0%"></td>
-->

								<td align="center"><span id="divi_<?= $data->item_id ?>">
										<? if ($flag[$data->item_id] > 0) { ?>
											<input name="flag_<?= $data->item_id ?>" type="hidden" id="flag_<?= $data->item_id ?>" value="1" />
											<input type="button" name="Button" value="Edit" onclick="update_value(<?= $data->item_id ?>)" class="btn btn-primary" /><?
																																								} else {
																																									?>
											<input name="flag_<?= $data->item_id ?>" type="hidden" id="flag_<?= $data->item_id ?>" value="0" />
											<input type="button" name="Button" value="Save" onclick="update_value(<?= $data->item_id ?>)" class="btn btn-success" /><? } ?>
									</span>&nbsp;</td>
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
				group_id: id
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
				item_sub_group: id
			},
			success: function(data) {
				$('#browsers').html(data);
			}

		})
	}
</script>