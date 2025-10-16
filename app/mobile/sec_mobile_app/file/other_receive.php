<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Replace Return Entry";
$page = "other_rereive.php";

require_once '../assets/template/inc.header.php';

$user_id		=$_SESSION['user_id'];
 $emp_code		=$_SESSION['user']['username'];
$group_for 	    =$_SESSION['user']['company_id']=1;
$pg	            =$_SESSION['user']['product_group'];
$region_id	    =$_SESSION['user']['region_id'];
$zone_id	    =$_SESSION['user']['zone_id'];
$area_id	    =$_SESSION['user']['area_id'];
$dinfo=findall("select * from dealer_info where dealer_code='".$dealer_code."' ");

$dealer_code = $dinfo->dealer_code;
$dealer_name = $dinfo->dealer_name_e;
        
$page_for           ='Other Receive';
$table_master       ='ss_receive_master';
$table_details      ='ss_receive_details';
$unique='or_no';
if($_GET['pal']==2){
		unset($$unique);
		unset($_SESSION['or_no2']);
}

if($_GET['or_no']>0) $_SESSION['or_no2']=$_GET['or_no'];

if(isset($_POST['new'])){

		$crud   = new crud($table_master);

		if(!isset($_SESSION['or_no2'])) {
		$_POST['entry_by']	=$_SESSION['user']['username'];
		$_POST['entry_at']	=date('Y-m-d H:i:s');
		$_POST['edit_by']	=$_SESSION['user']['username'];
		$_POST['edit_at']	=date('Y-m-d H:i:s');
		$_POST['warehouse_id'] = find1('select master_dealer_code from ss_shop where dealer_code="'.$_POST['vendor_id'].'"');
		$_POST['vendor_name'] = find1('select shop_name from ss_shop where dealer_code="'.$_POST['vendor_id'].'"');
		
		$$unique=$_SESSION['or_no2']=$crud->insert();
		//unset($$unique);
		$type=1;
		$msg=$title.'  No Created. (No :-'.$_SESSION['or_no2'].')';	
		?><script>window.location.href = "other_receive.php?or_no=<?=$$unique;?>";</script><?
    	  
		} else {
		    
		$_POST['edit_by']	=$_SESSION['user']['username'];
		$_POST['edit_at']	=date('Y-m-d H:i:s');
		$_POST['or_no']		=$_SESSION['or_no2'];
		$_POST['warehouse_id'] = find1('select master_dealer_code from ss_shop where dealer_code="'.$_POST['vendor_id'].'"');
		$_POST['vendor_name']	=find1('select shop_name from ss_shop where dealer_code="'.$_POST['vendor_id'].'"');
		
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		}
} // end new

$$unique=$_SESSION['or_no2'];

if(isset($_POST['delete'])){

		$crud   = new crud($table_master);
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$$unique;		
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION['or_no2']);
		$type=1;
		$msg='Successfully Deleted.';
		?><script>window.location.href='other_receive.php?pal=2';</script><?php 
}

if(isset($_POST['hold'])){
		unset($$unique);
		unset($_SESSION['or_no2']);
		$type=1;
		$msg='Successfully Holded.';
		?><script>window.location.href='other_receive.php?pal=2';</script><?php 
}

if(isset($_POST['confirmm'])){
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['username'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='CHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		
// bin card entry		
$sql = 'select a.id,a.item_id,a.qty,a.or_date,a.rate,a.or_no,a.warehouse_id
		from ss_receive_details a
		where a.or_no='.$$unique.' order by a.id';
		
		$query = mysqli_query($conn, $sql);
		while($data=mysqli_fetch_object($query)){

		// $check_old_item=find1("select item_id from ss_journal_item where item_id='".$data->item_id."' and sr_no='".$data->or_no."' and tr_from='Other Receive' ");

//if($check_old_item<1){
		journal_item_ss($data->item_id ,$data->warehouse_id,$data->or_date,$data->qty,0,$page_for,$data->id,$data->rate,'',$data->or_no);
//}

} // end bin card hit			

		unset($$unique);
		unset($_SESSION['or_no2']);
		$type=1;
		$msg='Successfully Forwarded.';

?><script>window.location.href='other_receive.php?pal=2';</script><?php  
} // End confirm

// Add this before the item adding section
if(isset($_POST['add_item']) && $_POST['or_no'] > 0) {
    $crud = new crud($table_details);
    
    // Get item info
    $item_info = db_fetch_object('item_info', 'item_id='.$_POST['item_id']);
    
    $_POST['or_no'] = $_SESSION['or_no2'];
    $_POST['unit_name'] = $item_info->unit_name;
    $_POST['entry_by'] = $_SESSION['username'];
    $_POST['entry_at'] = date('Y-m-d H:i:s');
    $_POST['warehouse_id'] = $_SESSION['warehouse_id'];
	 $_POST['rate']        = $_POST['nsp_price' . $itemID];
    
    if($_POST['item_id'] > 0 && $_POST['qty'] > 0 && $_POST['rate'] > 0) {
        // Check if item already exists
        $check_existing = find1("SELECT id FROM $table_details WHERE or_no='".$_SESSION['or_no2']."' AND item_id='".$_POST['item_id']."'");
        
        if($check_existing < 1) {
            unset($_POST['id']);
            $_POST['amount'] = $_POST['qty'] * $_POST['rate'];
            $xid = $crud->insert();
            $msg = 'Item added successfully.';
        } else {
            $msg = 'Item already exists!';
        }
    }
}

if (isset($_POST['addItems'])){
    $table = $table_details;
    $crud  = new crud($table);

    foreach ($_POST['item_ids'] as $itemID) {
        $_POST['item_id']     = $itemID;
        $_POST['rate']        = $_POST['rate_' . $itemID];
	//	$_POST['nsp_per'] = $_POST['nsp_per_' . $itemID];
        $_POST['qty']         = $_POST['qty_' . $itemID];
        $_POST['amount']      = $_POST['amount_' . $itemID];
        $_POST['unit_name']   = $_POST['unit_name_' . $itemID];

        if ($_POST['qty'] > 0 && $_POST['rate'] > 0) {
            $crud->insert();
        }
    }
	
    $msg='Items successfully inserted';
}


if($_GET['del']>0){

		$crud   = new crud($table_details);
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		$type=1;
		$msg='Successfully Deleted.';
		
}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
//		while (list($key, $value)=each($data))
//		{ $$key=$value; }
		foreach ((array) $data as $key => $value) {
			$$key = $value;
		}
		
}

if($$unique>0) $btn_name='Update'; else $btn_name='Start';

if($_SESSION['or_no2']<1)
$$unique=db_last_insert_id($table_master,$unique);

?>
<script language="javascript">
function focuson(id) {
  if(document.getElementById('id').value=='')
  document.getElementById('id').focus();
  else
  document.getElementById(id).focus();
}

window.onload = function() {
if(document.getElementById("warehouse_id").value>0)
  document.getElementById("id").focus();
  else
  document.getElementById("req_date").focus();
}
</script>

<script language="javascript">
function count(){
var num=((document.getElementById('qty').value)*1)*((document.getElementById('price').value)*1);
document.getElementById('amount').value = num.toFixed(2);	
}
</script>
<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
  		
<form action="" method="post" class="sarwar">

        <div class="card card-style">
							<div class="content m-0">
				
					<? $field='or_no';?>	
					<label for="manager_name" >No</label>

					<input type="text" class="form-control validate-text"  name="<?=$field?>" id="<?=$field?>" value="<?=$$field?>" disabled="disabled">
		
						<? $field='or_date'; if($or_date=='') $or_date =date('Y-m-d'); ?>
						<label for="odate" >Date</label>

						<input  class="form-control validate-text" name="<?=$field?>" type="date" id="<?=$field?>" value="<?=$$field?>" required
						<? if($or_date!=''){?> readonly="readonly" <? } ?>
						/>
		
							<? $field='vendor_id';?>
						<label for="manager_name" >Party</label>

						<select class="form-control validate-text" name="<?=$field?>" id="<?=$field?>" required>
						<option value="<?=$$field?>"><?=find1("select concat(dealer_code,'-',shop_name) from ss_shop where dealer_code='".$$field."' ");?></option>
						<?php optionlist('select s.dealer_code,concat(r.route_name,"-",s.shop_name) as shop_name 
							from ss_shop s, ss_route r 
							where s.route_id=r.route_id and s.status="1" and s.emp_code="'.$_SESSION['user']['username'].'" 
							order by r.route_id,s.shop_name');?>
						</select>
						
					<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>  		
					
					<div class="d-flex justify-content-center row mt-3">
						<div class="col-6">
					
	<button name="new" type="submit" class="btn btn-3d btn-m btn-full mb-3 rounded-xs font-900 shadow-s btn-success w-100"><?=$btn_name?></button>

						</div>
					</div>
				</div>
            </div>
			</form>

<div class="content mt-0 sarwar1">
					<!-- Card Section with custom border size -->
					<div class="do_entry_card mt-2 custom-card-border"> <!-- Added custom-card-border class -->
						<div class="card-body">
							<!-- DO Number -->
							<div class="text-center">
								<button type="button" class="btn btn-outline-primary btn-sm"> REPLACE RETURN NO : <?=$or_no; ?> </button>
							</div>
							<div class="d-flex justify-content-between align-items-center">

								<!-- Shop Details -->
								<div class="mb-2">
									<p class="mb-1 text-dark"><strong>Party Name:</strong> <?=$vendor_name; ?></p>
									<p class="mb-0 text text-dark"><strong style="color:green">Return Date:</strong> <?=$or_date; ?></p>
								</div>

								<!-- Amount -->
								<div class="text-end">
									<h4 class="mb-0"> <span id="total_item_amt">0</span>

									</h4>
								</div>
							</div>
						</div>
					</div>
</div>

<style type="text/css"> .sarwar{ display:block!important;} .sarwar1{ display:none !important;}</style>
<?php 
//echo 'oi_no2='.$_SESSION['oi_no2'];
if($_SESSION['or_no2']>0){ ?>
<style type="text/css"> .sarwar{ display:none!important;} .sarwar1{ display:block !important;}</style>
        <div class="card card-style">
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
<input name="or_no" type="hidden"  id="or_no"  value="<?=$or_no?>"/>
<input name="or_date" type="hidden"  id="or_date"  value="<?=$or_date?>"/>
<?php $warehouse = find_all_field('ss_shop','*','dealer_code="'.$vendor_id.'"'); ?>
<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$warehouse->dealer_code?>"/>
<input  name="vendor_name" type="hidden" id="vendor_name" value="<?=$warehouse->shop_name?>"/>
<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"/>
<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse->master_dealer_code?>"/>

<div class="content m-0">
					<div class="row m-0 p-0 pb-3">
						<div class="col-6 ps-1 p-0">						  
								<select name="category_id" id="category_id" onchange="FetchItemSubcategory(this.value)">
									<option value="<?=$_SESSION['category_id'];?>"><?=find1("select group_name from item_group where group_id='".$_SESSION['category_id']."'");?></option>
									<?php optionlist("select group_id,group_name from item_group where 1 order by group_name"); ?>
								</select>
						</div>
						
						<div class="col-6 ps-1 p-0">
								<select class="form-control validate-text" name="subcategory_id" id="subcategory_id" onchange="FetchAllItemList(this.value)">
											<option value="<?=$_SESSION['subcategory_id'];?>"><?=find1("select sub_group_name from item_sub_group where sub_group_id='".$_SESSION['subcategory_id']."'");?></option>
										<?php 											
											if ($_SESSION['category_id'] > 0) {
												$cat_group = " and group_id='" . $_SESSION['category_id'] . "' ";
											}
											optionlist("select sub_group_id,sub_group_name from item_sub_group where 1 " . $cat_group . " order by sub_group_name"); 
											
											?>
								</select>
						</div>
					</div>

					<div class="" style="zoom: 78%;">
						<div id="allitem"> </div>
					</div>
					</div>

					<div class="content m-0">
				<div class=" pt-3" style="zoom: 78%;">

						<table class="table table-borderless text-center table-scroll">
							<thead>
								<tr class="bg-night-light1">
								<th scope="col" class="color-white"> Item Code</th>
									<th scope="col" class="color-white"> Item Name</th>
								<!--		<th scope="col" class="color-white"> Unit</th>
								<th scope="col" class="color-white"> Stock</th>
									<th scope="col" class="color-white"> TP</th>
									<th scope="col" class="color-white"> Offer%</th>
									<th scope="col" class="color-white"> NSP</th>-->
									<th scope="col" class="color-white"> Rate </th>
									<th scope="col" class="color-white"> Qty</th>
									<th scope="col" class="color-white"> Amt</th>
									<th scope="col" class="color-white"> </th>
								</tr>
							</thead>
							<tbody>

								<?
								
								$res='select a.id,i.finish_goods_code,i.item_name,a.rate,a.qty ,a.amount 
								from ss_receive_details a,item_info i 
								where i.item_id=a.item_id and a.or_no='.$$unique.' order by a.id desc';
								//echo link_report_add_del_auto($res,'',6,7);

								$query = mysqli_query($conn, $res);
								$sl = 1;
								while ($data = mysqli_fetch_object($query)) {
								?>
									<tr>
										<td colspan="6" align="left" class="sr-td-t1">
											<strong><?= $data->item_name ?></strong> <?= $data->finish_goods_code ?>
										</td>
									</tr>
									<tr class="sr-td-b1">
										<td><?= $data->finish_goods_code; ?></td>
										<td><?= $data->item_name; ?></td>
										<td><?= $data->nsp_price; ?></td>
										<td><?= $data->qty; ?></td>
										<td><?= $data->amount; ?></td>
										<td><a href="?del=<?= $data->id ?>" style=" color: red; ">&nbsp;<i class="fa-solid fa-trash"></i>&nbsp;</a></td>
									</tr>
								<? } ?>
								<tr class="sr-td-b1">
									<td colspan='3' align="left"><span style='text-align:right;'> Total: </span></td>
									<td colspan='1' class="text_br"><?= $gqty; ?></td>
									<td colspan='1' class="text_br"><?= $gamt; ?></td>
									<td colspan='1'></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
					</form>
			</div>
		
	<form action="" method="post" name="cz" id="cz">		
	<div class="content">					  
					  <div class="row">
						<div class="col-6">
							<button name="delete" type="submit" value="delete" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-danger w-100">Delete</button>
						</div>
<!--						<div class="col-4">
						<button name="hold" type="submit" value="hold" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-primary  w-100">Hold</button>
						</div>-->
						<div class="col-6">
							 <button name="confirmm" type="submit" value="CONFIRM" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-success  w-100">CONFIRM</button>
						</div>
					</div>
			</div>
		</form>
								<? } ?>
        </div>
    <!-- End of Page Content--> 

<?php 
 require_once '../assets/template/inc.footer.php';
	selected_two("#category_id", "Category");
	selected_two("#subcategory_id", "Sub Category");
	if($_SESSION['or_no2']<0){
	selected_two("#vendor_id");
	}
	//selected_two("#item_id");
 ?>
 
<script>
function getData(){
    
var id          = document.getElementById("item_id").value;
var vendor_id = document.getElementById("vendor_id").value;

		jQuery.ajax({
			url:'ajax_other_receive.php',
			type:'post',
			data: {id: id, vendor_id: vendor_id},
			success:function(result){
				var json_data=jQuery.parseJSON(result);

				jQuery('#unit').val(json_data.unit);
				jQuery('#price').val(json_data.price);

			}

		})
$( "#qty" ).focus();	
}
</script>  
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script>
jQuery('.party_list').chosen();
jQuery('.item_list').chosen();
</script>

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
				subcategory_id: id
			},
			success: function(data) {
				$('#item_id').html(data);
			}

		})
	}

	function update_qty_amt(id) {
		var rate = document.getElementById("rate_" + id).value * 1;
		var qty = document.getElementById("qty_" + id).value * 1;
		var total_amt = (rate * qty);
		document.getElementById("amount_" + id).value = total_amt;
	}

	//ajax item js (in this js comment are using of increment and decrement data) 
	var previousValues = {}; //This is the total item increse value set
	function update_nsp_amt(id) {

		var net_totalss = 0; //This is the totel defule vlue set

		var tp_amt = document.getElementById("unit_price2_" + id).value * 1;
		var nsp_per_amt = document.getElementById("nsp_per_" + id).value * 1;
		var total_amt = document.getElementById("pkt_unit_" + id).value * 1;

		//var final_amt =  tp_amt-((nsp_per_amt/100)*tp_amt);
		var final_amt = (tp_amt * (1 - (nsp_per_amt / 100))).toFixed(2); //this code for 0.00
		var final_total_amt = (total_amt * final_amt);

		document.getElementById("unit_price_" + id).value = final_amt;
		document.getElementById("total_amt_" + id).value = final_total_amt;

		var previousTotal = previousValues[id] || 0; //this is the set previous value with id
		net_totalss = parseFloat(document.getElementById("total_item_amt").innerText); // this code is set float data in id
		net_totalss = net_totalss - previousTotal + final_total_amt; // this is conduction 
		document.getElementById("total_item_amt").innerText = net_totalss.toFixed(2); // this code is print the data
		previousValues[id] = final_total_amt; // return the data in id 

	}

	//ajax item js (in this js comment are using of increment and decrement data) 
	function update_item_amt(id) {
		//var pkt_size = document.getElementById("pkt_size_" + id).value * 1;
		var unit_price = document.getElementById("unit_price_" + id).value * 1;
		var qty = document.getElementById("qty_" + id).value * 1;

		//var total_qty = (pkt_size * unit_price);

		document.getElementById("amount_" + id).value = qty * unit_price;
	}
	// Add this to your existing JavaScript
function calculate_amount(item_id) {
    var qty = document.getElementById('qty_' + item_id).value * 1;
    var rate = document.getElementById('rate_' + item_id).value * 1;
    var amount = qty * rate;
    document.getElementById('amount_' + item_id).value = amount.toFixed(2);
}

function add_item(item_id) {
    var qty = document.getElementById('qty_' + item_id).value;
    var rate = document.getElementById('rate_' + item_id).value;
    
    if(qty <= 0) {
        alert('Please enter quantity');
        document.getElementById('qty_' + item_id).focus();
        return false;
    }
    
    if(rate <= 0) {
        alert('Please enter rate');
        document.getElementById('rate_' + item_id).focus();
        return false;
    }
    
    // Create form data
    var formData = new FormData();
    formData.append('add_item', '1');
    formData.append('or_no', <?=$_SESSION['or_no2']?>);
    formData.append('item_id', item_id);
    formData.append('qty', qty);
    formData.append('rate', rate);
    
    // Submit via AJAX
    fetch('other_receive.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Reload page to show updated list
        window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding item');
    });
}

// Fix the FetchAllItemList function
function FetchAllItemList(id) {
    $.ajax({
        type: 'post',
        url: 'other_item_ajax.php',
        data: {
            sub_group_id: id
        },
        success: function(data) {
            $('#allitem').html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            $('#allitem').html('<div class="alert alert-danger">Error loading items. Please try again.</div>');
        }
    });
}
</script>