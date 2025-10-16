<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE . "core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Reports";
$page = "report_list.php";
$menu = 'report';
$menu_active='active';

require_once '../assets/template/inc.header.php';

$user_id  = $_SESSION['user_id'];
$emp_code  = $_SESSION['user']['username'];
// $dealer_code = $_SESSION['warehouse_id'];
$dealer_code = $emp_code;
?>

<style type="text/css">
.icon-check label {
    margin: 0px !important;
}
</style>


<!-- start of Page Content-->
<div class="page-content header-clear-medium">
  <form action="report_view.php" method="post" id="demo" data-parsley-validate class="form-horizontal form-label-left">
    <div class="card card-style">



      <div class="content m-0">
<!--        <div><strong>Report Filter</strong></div>
        <br />-->
		<div class="row m-0 p-0">
		<div class="col-6 p-1">
			<label for="group_for">Company</label>
			<select class="form-control" name="group_for" id="group_for">
			  <option>Select a Company</option>
			  <? foreign_relation('user_group', 'id', 'company_name', $group_for, '1 order by company_name'); ?>
			</select>
		</div>
		
		<div class="col-6 p-1">
			<label for="item_group">Group</label>
			<select class="form-control" name="item_group" id="item_group" onchange="FetchItemCategory(this.value)">
			  <option>Select Group</option>
			  <? foreign_relation('user_group', 'id', 'group_name', $product_group, '1 order by group_name'); ?>
			</select>
		</div>

		<div class="col-6 p-1">
			<label for="category_id">Category</label>
			<select class="form-control" name="category_id" id="category_id" onchange="FetchItemSubcategory(this.value)">
			  <option>Select a Category</option>
			  <? foreign_relation('item_group', 'group_id', 'group_name', $category_name, '1 order by group_name'); ?>
			</select>
		</div>
		
		<div class="col-6 p-1">
			<label for="subcategory_id">SubCategory</label>
			<select class="form-control" name="subcategory_id" id="subcategory_id">
			  <option>Select a SubCategory</option>
			  <? foreign_relation('item_sub_group', 'group_id', 'sub_group_name', $subcategory_name, '1 order by sub_group_name'); ?>
			</select>
		</div>

		<div class="col-6 p-1">
			<label for="subcategory_id">Route</label>
			<select type="text" name="route_id" autocomplete="off" value="" class="form-control" onchange="FetchShop(this.value)">
			  <option></option>
			  <? optionlist("select s.route_id,concat(r.route_id,'-',r.route_name) from ss_route r, ss_shop s where s.route_id=r.route_id  group by s.route_id order by route_name");
			  ?>
			</select>
		</div>
		
		<div class="col-6 p-1">
			<label for="market_id">Shop</label>
			<select type="text" name="dealer_code" id="dealer_code" autocomplete="off" value="" class="form-control">
			  <option></option>
			  <? optionlist("select dealer_code,concat(dealer_code,'-',shop_name) from ss_shop 
										where region_id='".$_SESSION['user']['region_id']."' 
										and zone_id='".$_SESSION['user']['zone_id']."' 
										and area_id='".$_SESSION['user']['area_id']."' 
										order by region_id,zone_id,area_id,shop_name");
			  ?>
			</select>
		</div>
		
		
		<div class="col-6 p-1">
			<label for="shop_name">From Date:</label>
			<input type="date" name="f_date" required="required" autocomplete="off" value="<?= date('Y-m-01') ?>" class="form-control validate-text" />
		</div>

		<div class="col-6 p-1">
			<label for="shop_name">To Date:</label>
			<input type="date" name="t_date" required="required" autocomplete="off" value="<?= date('Y-m-d') ?>" class="form-control validate-text" />
		</div>
		
		<div class="col-6 p-1">
			<label for="shop_name">Field Officer:</label>
			<select type="text" name="so_code"class="form-control validate-text">
			       <option></option>
			       <? foreign_relation('ss_user', 'username', 'concat(username," ",fname)', $so_code, '1 and dealer_code="'.$dealer_code.'" and status="Active" order by username'); ?>
			</select>    
		</div>		
		
		
		</div>
      </div>
    </div>




    <div class="content">

      <div><strong>Primary Reports</strong></div>

      
      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="101" id="101">-->
      <!--  <label class="form-check-label" for="101">Target Vs Sales Report(101)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="102" id="102">-->
      <!--  <label class="form-check-label" for="102">Target/Pri DO Report (102)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="103" id="103">-->
      <!--  <label class="form-check-label" for="103">Target/Pri Chalan Report (103)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="104" id="104">-->
      <!--  <label class="form-check-label" for="104">Dealer Stock Report (104)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="105" id="105">-->
      <!--  <label class="form-check-label" for="105">Shop List (105)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="201" id="201">-->
      <!--  <label class="form-check-label" for="201">Opening Qty Entry Report (201)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="202" id="202">-->
      <!--  <label class="form-check-label" for="202">Product List (202)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="51" id="51">-->
      <!--  <label class="form-check-label" for="51">Order List (51)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="54" id="54">-->
      <!--  <label class="form-check-label" for="54">Party wise Order List (54)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="52" id="52">-->
      <!--  <label class="form-check-label" for="52">Delivery Report (52)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="55" id="55">-->
      <!--  <label class="form-check-label" for="55">Party wise Delivery Report (55)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="57" id="radio2">-->
      <!--  <label class="form-check-label" for="radio2">Pending Order List (57)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="53" id="53">-->
      <!--  <label class="form-check-label" for="53">Target Vs Order Vs Delivery(Item wise) (53)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="56" id="56">-->
      <!--  <label class="form-check-label" for="56">Monthly Product Group wise Report (56)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->

      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="58" id="58">-->
      <!--  <label class="form-check-label" for="58">Target Progress Status (58)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->
      
 
 
 <!--new report     -->
      
      <div class="form-check icon-check">
        <input class="form-check-input" type="radio" name="report" value="701" id="701">
        <label class="form-check-label" for="701">Sales Report Chalan wise(701)</label>
        <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>
        <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>
      </div>  
      
      <div class="form-check icon-check">
        <input class="form-check-input" type="radio" name="report" value="702" id="702">
        <label class="form-check-label" for="702">Sales Return List(702)</label>
        <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>
        <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>
      </div> 
      
      <div class="form-check icon-check">
        <input class="form-check-input" type="radio" name="report" value="703" id="703">
        <label class="form-check-label" for="703">Sales Return Details Report(703)</label>
        <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>
        <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>
      </div> 
      
      <div class="form-check icon-check">
        <input class="form-check-input" type="radio" name="report" value="704" id="704">
        <label class="form-check-label" for="704">Party Ledger Report(704)</label>
        <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>
        <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>
      </div> 
      
      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="705" id="705">-->
      <!--  <label class="form-check-label" for="705">Dealer Commission Report(705)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>-->
      
      <!--<div class="form-check icon-check">-->
      <!--  <input class="form-check-input" type="radio" name="report" value="706" id="706">-->
      <!--  <label class="form-check-label" for="706">Stock Report(706)</label>-->
      <!--  <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>-->
      <!--  <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>-->
      <!--</div>   -->
      
      <div class="form-check icon-check">
        <input class="form-check-input" type="radio" name="report" value="707" id="707">
        <label class="form-check-label" for="707">Order Vs. Delivery Report(707)</label>
        <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>
        <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>
      </div> 
      
      
      <div class="form-check icon-check">
        <input class="form-check-input" type="radio" name="report" value="708" id="708">
        <label class="form-check-label" for="708">Sales Order Report(708)</label>
        <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>
        <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>
      </div>      
      
      
      



      <div class="form-check icon-check">
            <br>
      </div>     
      
      
<!--2nd reports-->
      <div><strong>Secondary Reports</strong></div>
      
      <div class="form-check icon-check">
        <input class="form-check-input" type="radio" name="report" value="901" id="901">
        <label class="form-check-label" for="901">Item Wise Order/Sales -(901)</label>
        <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>
        <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>
      </div>  
      
      <div class="form-check icon-check">
        <input class="form-check-input" type="radio" name="report" value="902" id="902">
        <label class="form-check-label" for="902">NSP Report Chalan wise(902)</label>
        <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>
        <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>
      </div> 
      
            <div class="form-check icon-check">
        <input class="form-check-input" type="radio" name="report" value="903" id="903">
        <label class="form-check-label" for="903">NSP Report Outlet wise(903)</label>
        <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>
        <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>
      </div> 
      
            <div class="form-check icon-check">
        <input class="form-check-input" type="radio" name="report" value="904" id="904">
        <label class="form-check-label" for="904">Sale Return Report Details(904)</label>
        <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>
        <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>
      </div> 
      
            <div class="form-check icon-check">
        <input class="form-check-input" type="radio" name="report" value="905" id="905">
        <label class="form-check-label" for="905">Replace Report Details(905)</label>
        <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>
        <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>
      </div> 
      
            <div class="form-check icon-check">
        <input class="form-check-input" type="radio" name="report" value="906" id="906">
        <label class="form-check-label" for="906">Dealer Stock Report(906)</label>
        <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>
        <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>
      </div> 
      
            <div class="form-check icon-check">
        <input class="form-check-input" type="radio" name="report" value="907" id="907">
        <label class="form-check-label" for="907">Price List(907)</label>
        <i class="icon-check-1 fa fa-circle color-gray-dark font-16"></i>
        <i class="icon-check-2 fa fa-check-circle font-16 color-highlight"></i>
      </div> 
      
      
      
      
      

      <div class="d-flex justify-content-center row">
        <div class="col-6">
          <input class="btn btn-3d btn-m btn-full mb-3 rounded-xs b-n font-900 shadow-s btn-success w-100"
            type="submit" name="submit" id="submit" value="Report View" />
        </div>
      </div>


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
    $('#item_id').html('');
    $.ajax({
      type: 'post',
      url: 'get_data.php',
      data: {
        fg_group: id
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

  function FetchShop(id) {
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
</script>