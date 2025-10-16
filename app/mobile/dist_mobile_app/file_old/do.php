<?php 
session_start();
ob_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "DO Entry";
$page = 'do.php';

require_once '../assets/template/inc.header.php';



$group_for 	    =$_SESSION['user']['company_id']=1;
$user_id	    =$_SESSION['user']['user_id'];
$username	    =$_SESSION['user']['username'];
$pg	            =$_SESSION['user']['product_group'];
$region_id	    =$_SESSION['user']['region_id'];
$zone_id	    =$_SESSION['user']['zone_id'];
$area_id	    =$_SESSION['user']['area_id'];

$dayName = date('l');
$sql_r = 'select * from ss_schedule where PBI_ID="' . $_SESSION['user']['username'] . '" and day_name="' .$dayName. '"';
$query_r = db_query($sql_r);
$row_r = mysqli_fetch_object($query_r);


//if($_GET['pal']==2) { unset($$unique); unset($_SESSION['do_no2']); $type=1;}

$dealer_code=$_SESSION['user']['warehouse_id'];
//do_calander('#est_date');

$table_master='ss_do_master';
$unique_master='do_no';
$table_detail='ss_do_details';
$unique_detail='id';


$dealer = find_all_field('ss_shop','','dealer_code='.$dealer_code);



if($_REQUEST['old_do_no']>0) $$unique_master=$_REQUEST['old_do_no'];
elseif(isset($_GET['del'])) {$$unique_master=find_a_field('ss_do_details','do_no','id='.$_GET['del']); $del = $_GET['del'];}
else
$$unique_master=$_REQUEST[$unique_master];

$do_status = find_a_field('ss_do_master','status','do_no="'.$$unique_master.'"');







if(isset($_POST['delete'])){

if($do_status=='MANUAL'){

		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		
		unset($$unique_master);
		unset($_POST[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
	} 	
}


if(isset($_POST['confirm'])){

if($do_status=='MANUAL'){

		$_POST[$unique_master]=$$unique_master;
		$_POST['checked_at']  =date('Y-m-d H:i:s');
		$_POST['checked_by']  =$_SESSION['user']['username'];
		$_POST['status']    ='CHECKED';
		$_POST['depot_id'] =$_SESSION['user']['warehouse_id'];
		
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		
		unset($$unique_master);
		unset($_POST[$unique_master]);
		unset($_POST);
		$type=1;
		$msg='Successfully Instructed to Depot.';
		?><script>window.location.href = "../main/home.php"</script><?
		}else{
		?><script>window.location.href = "../main/home.php"</script><?
		}
}


if(isset($_POST['new'])){
	// $_POST['latitude']=$_POST['latitude_do'];
	// $_POST['longitude']=$_POST['longitude_do'];

		$crud   = new crud($table_master);
		$dealer = find_all_field('ss_shop','','dealer_code='.$_POST['dealer_code']);
		$_POST['status']='MANUAL';
		//$_POST['do_date']=date('Y-m-d');
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['entry_by']= $username;
		if($_POST['shop_status']=='Get Order') { $_POST['memo']=1; }else{$_POST['memo']=0; }

		if($_POST['flag']==0){
		$_POST['do_no'] = find_a_field($table_master,'max(do_no)','1')+1;
		$$unique_master=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';
		//redirect2("do_entry.php?order_id=".$$unique_master);
		header("Location: do_entry.php?order_id=".$$unique_master);
		}
		else {
		$crud->update($unique_master);
		$type=1;
		$msg='Successfully Updated.';
		}
}



if(isset($_POST['addItems']) && $_POST[$unique_master]>0 && $_POST['randcheck']==$_SESSION['user']['rand']){     
		$table		=$table_detail;
		$crud      	=new crud($table);
	
	foreach($_POST['item_ids'] as $itemID){
		$_POST['pkt_unit'] = $_POST['pkt_unit_'.$itemID];
		$_POST['unit_price'] = $_POST['unit_price_'.$itemID];
		$_POST['nsp_per'] = $_POST['nsp_per_'.$itemID];
		$_POST['stock'] = $_POST['stock_'.$itemID];
		$_POST['item_id'] = $itemID;
		
		if($_POST['pkt_unit']>0){ // && $_POST['stock']>0
	
		$_POST['total_unit'] = $_POST['pkt_unit'];
		
		$_POST['total_amt'] = ($_POST['total_unit'] * $_POST['unit_price']);
		$item_info = find_all_field('item_info','*','item_id ='.$_POST['item_id']);
		
		$_POST['t_price'] = $item_info->t_price;
		$_POST['total_tp'] = ($_POST['t_price']*$_POST['total_unit']);
		$_POST['dp_price'] = $item_info->t_price;
		$_POST['fp_price'] = $item_info->f_price;

		$_POST['entry_by'] =$_SESSION['user']['username'];
		$_POST['depot_id'] =$_SESSION['user']['warehouse_id'];
		$_POST['gift_on_order'] = $crud->insert();
		//$do_date = date('Y-m-d');
		$_POST['gift_on_item'] = $_POST['item_id'];

		$total_unit = $_POST['total_unit'];

$_SESSION['category_id']=$_POST['category_id'];
$_SESSION['subcategory_id']=$_POST['subcategory_id'];

$sss = "select * from ss_gift_offer where item_id='".$_POST['item_id']."' 
and ((max_qty>='".$total_unit."' and  min_qty<='".$total_unit."') or (max_qty=0 and  min_qty=0)) and start_date<='".$do_date."' and end_date>='".$do_date."'  ";

		$qqq = mysqli_query($conn,$sss);

		while($gift=mysqli_fetch_object($qqq)){
		
		if($gift->item_qty>0)
		{
		$_POST['gift_id'] = $gift->id;
		$gift_item = find_all_field('item_info','','item_id="'.$gift->gift_id.'"');
		$_POST['item_id'] = $gift->gift_id;
			
		$_POST['dp_price'] = $gift_item->t_price;
		$_POST['fp_price'] = $gift_item->f_price;
			
			if($gift->gift_id == 1096000100010239)
			{
			$_POST['unit_price'] = (-1)*($gift->gift_qty);
			$_POST['total_amt']  = (((int)($total_unit/$gift->item_qty))*($_POST['unit_price']));
			$_POST['total_unit'] = (((int)($total_unit/$gift->item_qty)));
			
			$_POST['dist_unit'] = $_POST['total_unit'];
			$_POST['pkt_unit']  = '0.00';
			$_POST['pkt_size']  = '1.00';
			$_POST['t_price']   = '-1.00';
			$_POST['entry_by'] =$username;
			$crud->insert();
			}
			elseif($gift->gift_id== 1096000100010312)
			{
			$_POST['unit_price'] = (-1)*($gift->gift_qty);
			$_POST['total_amt']  = (((int)($total_unit/$gift->item_qty))*($_POST['unit_price']));
			$_POST['total_unit'] = (((int)($total_unit/$gift->item_qty)));
			
			$_POST['dist_unit'] = $_POST['total_unit'];
			$_POST['pkt_unit']  = '0.00';
			$_POST['pkt_size']  = '1.00';
			$_POST['t_price']   = '-1.00';
			$_POST['entry_by'] =$username;
			$crud->insert();
			}
			else
			{
			$_POST['unit_price'] = '0.00';
			$_POST['total_amt'] = '0.00';
			$_POST['total_unit'] = (((int)($total_unit/$gift->item_qty))*($gift->gift_qty));
			
			$_POST['dist_unit'] = ($_POST['total_unit']%$gift_item->pack_size);
			$_POST['pkt_unit'] = (int)($_POST['total_unit']/$gift_item->pack_size);
			$_POST['pkt_size'] = $gift_item->pack_size;
			$_POST['t_price'] = '0.00';
			if($_POST['unit_price']==0&&$_POST['total_unit']==0)
			{echo '';
			}
			else
			$_POST['entry_by'] =$username;
			$crud->insert();
			}//
//		unset($_POST['gift_id']);
//		unset($_POST['gift_on_order']);
//		unset($_POST['gift_on_item']);
		}
} // end if item id >0
}
}

}



if($del>0){	

		$main_del = find_a_field($table_detail,'gift_on_order','id = '.$del);
		$crud   = new crud($table_detail);
		if($del>0)
		{
			$condition=$unique_detail."=".$del;		
			$crud->delete_all($condition);
			
			$condition="gift_on_order=".$del;		
			$crud->delete_all($condition);
			
			if($main_del>0){
			$condition=$unique_detail."=".$main_del;		
			$crud->delete_all($condition);
			$condition="gift_on_order=".$main_del;		
			$crud->delete_all($condition);}
		}
		$type=1;
		$msg='Successfully Deleted.';
}


if($$unique_master>0)
{
		$condition=$unique_master."=".$$unique_master;
		$data=db_fetch_object($table_master,$condition);
		foreach($data as $key =>$value)
		{ $$key=$value;}
		
}



$dealer = find_all_field('ss_shop','','dealer_code='.$dealer_code);

auto_complete_from_db('item_info','concat(finish_goods_code,"#>",item_name)','finish_goods_code','product_nature="Salable" and status="Active" order by finish_goods_code','item');
?>



<script language="javascript">

function count(){

if(document.getElementById('pkt_unit').value!=''){
var pkt_unit = ((document.getElementById('pkt_unit').value)*1);
var dist_unit = ((document.getElementById('dist_unit').value)*1);
var pkt_size = ((document.getElementById('pkt_size').value)*1);
//var total_unit = (pkt_unit*pkt_size)+dist_unit;
var total_unit = pkt_unit;

var unit_price = ((document.getElementById('unit_price').value)*1);
var total_amt  = (total_unit*unit_price);
document.getElementById('total_unit').value=total_unit;
document.getElementById('total_amt').value	= total_amt.toFixed(2);
var do_total = ((document.getElementById('do_total').value)*1);
var do_ordering	= total_amt+do_total;
document.getElementById('do_ordering').value =do_ordering.toFixed(2);
}
else
document.getElementById('pkt_unit').focus();
}
</script>



<script language="javascript">
function focuson(id) {
  if(document.getElementById('item').value=='')
  document.getElementById('item').focus();
  else
  document.getElementById(id).focus();
}

window.onload = function() {
if(document.getElementById("flag").value=='0')
  document.getElementById("rcv_amt").focus();
  else
  document.getElementById("item_id").focus();
}
</script>

<style>
/* Make select2 dropdown scrollable */
/* Force scrollable dropdown for select2 */
.select2-container .select2-results__options {
    max-height: 200px !important;    /* Force max height */
    overflow-y: auto !important;     /* Enable scrolling */
    -webkit-overflow-scrolling: touch !important;  /* Smooth scrolling on mobile */
    scroll-behavior: smooth !important; /* Ensure smooth scrolling */
}

/* Make sure the dropdown is fully visible on mobile */
@media only screen and (max-width: 600px) {
    .select2-container .select2-dropdown {
        position: relative !important;  /* Ensure proper positioning */
        width: 100% !important;         /* Ensure the dropdown is wide enough */
    }
}
}


/* Table scrolling and sticky th td start */
.table-scroll {
    overflow-x: auto; /* Allows horizontal scrolling */
    position: relative;
    white-space: nowrap; /* Prevents content wrapping for consistent column behavior */
}

.table-scroll th:nth-child(1),
.table-scroll td:nth-child(1) {
    position: -webkit-sticky;
    position: sticky;
	background-color:#e7dbdb;
    left: 0;
    z-index: 2;
    width: 120px; /* Keep consistent width for alignment */
    box-shadow: 1px 0 0 rgba(0, 0, 0, 0.1);
}

thead th:nth-child(1) {
    z-index: 3; /* Higher z-index for header cell */
}

/* Table scrolling and sticky th td end */
</style>

    

<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   	

        <div class="card card-style m-0">
			<form action="" method="post" name="codz2" id="codz2">
			<input name="visit" type="hidden" id="visit" value="1" required readonly="readonly"/>
				<div class="content">
					<? if($dealer_code==''){  ?>
						<label for="route_id">Route Wise Route</label>						
							<select name="route_id" id="route_id" onchange="FetchShopList(this.value)">
								<? optionlist("select s.route_id,r.route_name from ss_route r, ss_shop s where s.route_id=r.route_id and s.emp_code='".$_SESSION['user']['username']."' group by s.route_id order by route_name");?>
							</select> 

					<? } ?> 


						<label for="dealer_code">Route Wise Shop <? //=$dealer_code?></label>
						<select name="dealer_code" required="required" id="dealer_code" class="select2-container select2-results__options" style=" overflow-y: auto !important; " onchange="FetchShopit(this.value)">
						<option></option>
						<? 
						optionlist('select s.dealer_code,concat(r.route_name,"-",s.shop_name) as shop_name 
						from ss_shop s, ss_route r 
						where s.route_id=r.route_id and s.status="1" and s.emp_code="'.$_SESSION['user']['username'].'" and s.route_id="'.$row_r->route_id.'"
						order by r.route_id,s.shop_name');
						 ?>
						</select>  

						<label for="do_no" style=" display:none !important;">SO</label>
						<input name="do_no" id="do_no" placeholder="do_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly" class="form-select form-control" style=" display:none !important;">

						<label for="order_distance">Distance Meter</label>					
						
						<div id="go_distance"><input type="text" value="" required class="form-control" readonly/></div>
<div class="row">
<div class="col-6">
					<label for="<?=$field?>">DO Date</label>
						<? $field='do_date'; if($do_date=='') $do_date =date('Y-m-d'); ?>
							<input name="<?=$field?>" type="date" id="<?=$field?>" value="<?=$$field?>" required <? if($do_date!=''){?>  <? } ?> class="form-select form-control"/>
</div>	
<div class="col-6" style=" display:none !important;">
						<? $field='shop_status';?>
						<label for="<?=$field?>" >Status</label>
							<select name="<?=$field?>" id="<?=$field?>" class="form-select form-control" required style=" display:none !important;">
								<option><? echo $$field?$$field:'Get Order'; $shop_status=$$field;?></option>
								<option>Get Order</option>
								<option>No Order</option>
								<option>Close</option>
							</select>
</div>
<div class="col-6">
					<label for="remarks" >Note</label>
						<textarea name="remarks" id="remarks" placeholder="Note" class="form-select form-control"><?=$remarks?></textarea>
</div>
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
				</div>
				<input type="hidden" name="latitude" id="latitude_do"  value="" readonly="">
				<input type="hidden" name="longitude" id="longitude_do"  value="" readonly=""> 
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
	
	var lat=position.coords.latitude;
	var long=position.coords.longitude;
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

<script>

//function update_nsp_amt(){
//
//
//var tp_id = document.getElementById("unit_price2").value;
//var nsp_per_id = document.getElementById("nsp_per").value; 
//
//
//var final_amt =  tp_id-((nsp_per_id/100)*tp_id);
//
//jQuery('#unit_price').val(final_amt);
//    
//}    

function getData(){
    
var id = document.getElementById("item_id").value;

		jQuery.ajax({
			url:'do_ajax.php',
			type:'post',
			data:'id='+id,
			success:function(result){
				var json_data=jQuery.parseJSON(result);

				//jQuery('#item_name').val(json_data.item_name);
				$("#item_dekhao").text(json_data.item_name);
				jQuery('#unit_price2').val(json_data.price);
				jQuery('#unit_name').val(json_data.unit);
				jQuery('#pkt_size').val(json_data.pkt_size);
				jQuery('#nsp_per').val(json_data.nsp_per);
				jQuery('#nsp_per2').val(json_data.nsp_per);
				jQuery('#unit_price').val(json_data.nsp_amt);
				jQuery('#nsp_per').attr('max',json_data.nsp_per );

			}

		})
	
}
</script> 


<script type="text/javascript">

  
//function FetchShopit(id){  
//    $('#go_distance').html('');
//    $.ajax({
//      type:'post',
//      url: 'get_data_go.php',
//      data : { dealer_code : id},
//      success : function(data){
//         $('#go_distance').html(data);
//      }
//    })
//}
navigator.geolocation.getCurrentPosition(function(position) {
    $('#latitude_do').val(position.coords.latitude);
    $('#longitude_do').val(position.coords.longitude);

    FetchShopit(dealerCode); // Pass the dealer code here
});

function FetchShopit(id) {
    $('#go_distance').html('');

    // Get the values of latitude and longitude
    const latitude = $('#latitude_do').val();
    const longitude = $('#longitude_do').val();
	
	console.log('Latitude:', latitude);
    console.log('Longitude:', longitude);

    $.ajax({
        type: 'post',
        url: 'get_data_go.php',
        data: { 
            dealer_code: id, 
            latitude: latitude, 
            longitude: longitude 
        },
        success: function(data) {
            $('#go_distance').html(data);
        }
    });
}



  
$(document).ready(function() {
    $('#dealer_code').select2({
        placeholder: "Select",          // Placeholder text
        allowClear: true,               // Allow clearing the selection
        dropdownAutoWidth: true,        // Auto width for dropdown
        width: '100%'                   // Full width for the dropdown
    });
});




	 function FetchAllItemList(id){
		//$('#subcategory_id').html('');
		
		$.ajax({
		  type:'post',
		  url: 'do_item_ajax.php',
		  data : {subcategory_id : id},
		  success : function(data){
			 $('#allitem').html(data);
		  }
	
		})
	  }
	  
  
	function update_nsp_amt(id){
	
	
	var tp_amt = document.getElementById("unit_price2_"+id).value*1;
	var nsp_per_amt = document.getElementById("nsp_per_"+id).value*1;
	var total_amt = document.getElementById("pkt_unit_"+id).value*1; 
	
	
	//var final_amt =  tp_amt-((nsp_per_amt/100)*tp_amt);
	var final_amt =  tp_amt*(1-(nsp_per_amt/100));
	var final_total_amt= total_amt*final_amt;
	
	document.getElementById("unit_price_"+id).value=final_amt;
	document.getElementById("total_amt_"+id).value=final_total_amt;
		
	} 
	
	//for table column sticky
	
	document.addEventListener('DOMContentLoaded', function () {
    const tableScroll = document.querySelector('.table-scroll');
    const stickyColumns = document.querySelectorAll('.sticky-column');

    tableScroll.addEventListener('scroll', function () {
        stickyColumns.forEach((column) => {
            column.style.transform = `translateX(${tableScroll.scrollLeft}px)`;
        });
    });
});


</script>