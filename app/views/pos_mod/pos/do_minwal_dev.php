<?php

date_default_timezone_set('Asia/Dhaka');

require_once "../../../assets/template/layout.top.php";
$title='Sales Register';
do_calander('#est_date');
$page = 'do_minwal.php';
if($_POST['dealer']>0) 
$dealer_code = $_POST['dealer'];
$table_master='sale_pos_master';
$unique_master='pos_id';

$table_detail='sale_pos_details';
$unique_detail='id';

$company_name = find_a_field('company_info','company_name','id=20');

$$unique_master=$_REQUEST[$unique_master];
//if(prevent_multi_submit()){}
?>
<? include("../../../assets/css/New_them_css_custome.css")?>
<style>

.sidebar{
display:none;
}
.main_content{
width: 100% !important;
}


.ac_results{
width:170px!important;
}
*{
font-size: 12px;
	}
.item_section > th{
	text-align:center;
	}
.form-container_large{
padding:1%;
	}
input[type=text]{
width:70px;
	}
.sr-main-content-padding{
float:left;
width:100%;
	}
.all_s_sale{
	display:none;
	background-color:rgba(0, 0, 0, 0.7);
    position: fixed;
    width: 100%;
    height: 100%;
    right: 0%;
	top:0%;
	overflow:auto;
	z-index:1000;
	}
	.receipt{
	display:none;
	background-color:rgba(0, 0, 0, 0.7);
    position: fixed;
    width: 100%;
    height: 100%;
    right: 0%;
	top:0%;
	overflow:auto;
	z-index:1001;
	}

.receipt > #main{
	background-color: White;
	/*width:960px;*/
	width:303px;
	margin: auto;
	margin-top:2%;
	padding: 5px;
	color:black;
}

.receipt > #main table{
	margin: 0 auto;
}

.receipt >#main table tr:nth-child(odd){
	background-color: #fff !important;
}

.receipt > #main table, tr:nth-child(even){
	background-color:#fff !important;
}



.all_s_sale > table{
	background-color: black;
	width:70%;
	margin:0 auto;
	margin-top:5%;
	/*color:white;*/
	text-align:center;
	}
.all_s_sale > table , th{
/*border: 1px solid white;*/
	}
#close_button{
position: fixed;
top: 2%;
right: 10%;
}
ul > li{
list-style:none;
text-align:left;
	}
#p_m > li{
list-style:none;
text-align:left;
	}
#p_a > li{
list-style:none;
text-align:left;
	}
#action_p{
list-style:none;
text-align:left;
	}
#suspended_sales{
background-color:#3498db;
color:white;
border-radius:10px !important;
border: 0px;
box-shadow: 4px 4px 10px grey;
width: 98%;
float: right;

	}
#suspended_sales:active{
background-color:#0C6B6F;
color:white;
border-radius:10px !important;
border: 0px;
box-shadow: 4px 4px 10px;
}
#suspend_sales{
width: 98%;
background-color:#FCB714;
border-radius:10px !important;
border: 0px;
box-shadow: 4px 4px 10px grey;
	}
#suspend_sales:active{
background-color:#FCB714;
border-radius:10px !important;
border: 0px;
box-shadow: 4px 4px 10px;
	}
#cancel_sale{
width:98%;
background-color:#ED3D36;
color:white;
border-radius:10px !important;
border: 0px;
box-shadow: 4px 4px 10px grey;
float: right;
	}
#cancel_sale:active{
box-shadow: 4px 4px 10px;
	}
#payment_btn{
background-color:#0B5A9D;
color:white;
border-radius:10px !important;
border: 0px;
box-shadow: 4px 4px 10px grey;
	}
#payment_btn:active{
background-color:#0B5A9D;
color:white;
border-radius:10px !important;
border: 0px;
box-shadow: 4px 4px 10px;
	}
#payment_section{
background-color:#d4e9f7;
border-radius:20px !important;
padding:1%;
box-shadow:4px 4px 5px grey;
}

/*#item_details_info tr td,#item_details_info{*/
	/*border: 1px solid #333;*/
/*}*/



/*#item_details_info tr td,#item_details_info{*/
	/*border: 1px solid #333;*/
/*}*/



#final_comment{
background-color:white;width:98%;display:none
	}
#final_confirm_button{
background-color:#0c6b6d;width:98%;display:none;color:white;border-radius:10px
	}
.moveTextToRight{
text-align:right;
	}
.moveTextToCenter{
text-align:center;
	}
</style>







	<div class="container-fluid">
		<form  action="<?=$page?>" method="post" name="codz2" id="codz2" autocomplete="off">
		<div class="row">
			<div class="col-sm-8" id='item_details_section'>

				<div class="container n-form1">
					<div class="n-form-btn-class">
						<input class="btn1 btn1-bg-update" name="suspended_sales" type="button" title="Click To See Suspended Sales" value="Suspended Sales" onClick="view_suspended_sales()">
						
						<input class="btn1 btn1-bg-submit" name="suspend_sales" type="button"  value="New Sales" onClick="suspend_order()">
						<input class="btn1 btn1-bg-cancel" name="cancel_sale" type="button" value="Cancel Sales" onClick="cancel_pos()">
						<input class="btn1 btn1-bg-submit" name="dashboard" type="button" value="Dashboard" onClick="window.location.href='../main/home.php'">
					</div>
					
					


					<div class="form-group row m-0 pl-3 pr-0">
						<label for="group_name" class="col-sm-2 pl-0 pr-0 col-form-label">	Order No :</label>
						<div class="col-sm-3 p-0">
							<input  name="pos_id" type="text" id="pos_id" value="<?=(find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>

						</div>
						<div class="col-sm-7 p-0">
							<div class="form-group row m-0 pl-3 pr-3">
								<label for="group_name" class="col-sm-5 pl-0 pr-0 col-form-label">Register Mode :</label>
								<div class="col-sm-7 p-0">
									<select name="register_mode" id="register_mode">
										<option value="">--Select One--</option>
										<option value="sale" selected>Sales</option>
										<option value="return">Return</option>
									</select>
								</div>
							</div>

						</div>

					</div>

					<div class="form-group row m-0 pl-3 pt-3 pr-3">
						<label for="group_name" class="col-sm-2 pl-0 pr-0 col-form-label">Product Info :</label>
						<?php
						auto_complete_from_db('item_info','concat(item_name,"#>",finish_goods_code)','finish_goods_code','product_nature="Salable"','item_id');
						?>
						<div class="col-sm-5 p-0">
							<input type="text" name="serial_no" id="serial_no" placeholder="Scan Serialized Product Barcode.."  onblur="insert_item_with_serial()">&nbsp;
						</div>
						
						<div class="col-sm-5 p-0">
							<input type="text" name="item_id" id="item_id" placeholder="Type Item Name or code Here"  onblur="insert_item()" style="height:50px;">
						</div>

					</div>
					
					

				</div>



				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th>Action</th>
						<th>SL</th>
						<th>Item Name</th>
						<th>Stock</th>
						<th>Price</th>
						<th>Qty</th>
						<th>Disc(%)</th>
						<th>Total</th>
					</tr>
					</thead>
					<tbody class="tbody1" id="item_below">
					<tr>
						<td colspan="8"><h3 align="center" >No Item Found</h3></td>
					</tr>
					</tbody>
				</table>



			</div>


			<div class="col-sm-4 n-form1">

					
                    
					
					   <div style="border: 2px solid #233f69;">
                       <legend style="background: #233f69; height:30px; text-align: left;color: #fff;font-weight: bold;">Old Customer</legend><div class="form-group row m-0 pl-3 pr-3">
						
						<input type="text" list="customer_list" id="customer_info" name="customer_info" >
						<datalist id="customer_list">
						<?php foreign_relation('dealer_pos',  'concat(dealer_name,"#",contact_no)','""',$customer_info, '1');?>
						</datalist>
						</div>
						</div>
						<br />
					
					
					<div style="border: 2px solid #233f69;">
                       <legend style="background: #233f69; height:30px;text-align: left;color: #fff;font-weight: bold;">New Customer</legend><div class="form-group row m-0 pl-3 pr-3">
						<span id="contact_check_msg" style="color:red; font-weight:bold;"></span>
						<input type="text" id="dealer_name" name="dealer_name" placeholder="Customer Name.." >
						<input type="text" id="contact_no" name="contact_no" placeholder="Contact No.." onkeyup="contact_check(this.value);">
						
					</div>
					</div><br />

					<div class="form-group row m-0 pl-3 pr-3">
						<p class="m-0"><strong class="bold">Item In Cart :</strong><span id="total_item_count">0</span> </p>
					</div>

					<div class="form-group row m-0 pl-3 pr-3">
						<p class="m-0"><strong class="bold">Total :</strong> <span id="total_amount">0</span> </p>
					</div>

					<h6 class="text-center mt-5 bg-titel bold pt-2 pb-2"> Payment History</h6>

					<table class="table1  table-striped table-bordered table-hover table-sm">
						<thead class="thead1">
						<tr class="bgc-info">
							<th>Payment Method</th>
							<th>Payment Amt</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody class="tbody1" id="payment_history">
						</tbody>
						<tr>
							<td class="bold">Amount Due: </td>
							<td id="total_due_amt" align="left" colspan="2">0</td>
						</tr>
					</table>



					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_name" class="col-sm-4 pl-0 pr-0 col-form-label">Add Payment</label>
						<div class="col-sm-8 p-0">
							<select name="payment_method" id="payment_method">
								<option value="">-Select One-</option>
								<option value="Cash" selected>Cash</option>
								<option value="Cheque">Cheque</option>
								<option value="Gift Card">Gift Card</option>
								<option value="Debit Card">Debit Card</option>
								<option value="Credit Card">Credit Card</option>
							</select>
						</div>
						
						<label for="group_name" class="col-sm-4 pl-0 pr-0 col-form-label">Paid Amount</label>
						<div class="col-sm-8 p-0">
							<input type="text" name="paid_amt" id="paid_amt" >
						</div>
						
					</div>


					<div class="n-form-btn-class">
						<input class="btn1 btn1-bg-update" type="button" name="payment_btn" value="Add Payment" onclick="add_payment()">

						<textarea name='final_comment' id='final_comment' placeholder='Write Comment Here'></textarea>

						<input name='final_confirm_button' id='final_confirm_button' value='Click To Confirm' type='button' onClick="confirm_sale()" style="height:40px; font-size:20px;"/>
					</div>

			</div>

		</div>
		</form>


		<div class="all_s_sale">
			<button type="button" onClick="close_s_sale()" id="close_button">&times;</button>
			<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
				<tr class="bgc-info">
					<th>Suspended Sale ID</th>
					<th>Date</th>
					<th>Customer</th>
					<th>Comments</th>
					<th>Unsuspend</th>
					<th>Sales Receipt</th>
					<th>Delete</th>
				</tr>
				</thead>
				<tbody class="tbody1" id="s_sales"></tbody>
			</table>
		</div>

		<div class="receipt pl-2 pr-2">
			<button type="button" onclick="close_receipt()" id="close_button">x</button>
			<div id="main">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<thead>
				<tr>
					<div align="center" id="pr">
						<br>
						<input type="button" style="text-align:center" value="Print" onclick="hide();window.print();"/>
					</div>

				</tr>

				<tr>
					<th id="company_name" style="text-align: center;"><h2><?=$_SESSION['company_name']?></h2></th>
					<input type="hidden" value="123456" id="tin_number">

				</tr>

				<tr>
<!--					<th id='company_logo' style="text-align: center;"><img src="../../../logo/demo7.png" alt="company_logo" style="width:100px"></th>-->
					<th id='company_logo' style="text-align: center;">Simple VAT Invoice</th>

				</tr>

				<tr>
					<th id="company_address" style="text-align: center;"><?=$_SESSION['company_address']?></th>
				</tr>

				<tr>
					<td id='sale_type' style="text-align: center;"></td>
				</tr>
				<tr>
					<td  style="text-align: center;"> Invoice Number: 000</td>
				</tr>


				<tr>
					<th colspan="6" style="font-size: 1.5625rem; text-align: center; padding-top: 10px; padding-bottom: 10px;">
						<span style="border: 1px solid #000;padding: 5px;padding-left: 10px;padding-right: 10px;">Order #<span  id="invoice_no"></span></span>
					</th>
				</tr>
				
				

				<tr>
					<td id='time_of_print' style="text-align: right;"><?=date('d-m-Y h:i:s a')?></td>
				</tr>

				<tr>
					<th style="font-weight: normal;">Cashier: <?=$_SESSION['user']['fname']?></th>
				</tr>


				<tr>
					<td>
						<table style="width:100%;">
							<tr style="border-bottom:1px solid #000">
								<th colspan="1" valign="middle" style="text-align: center; width: 10%;">Qty</th>
								<th colspan="4" valign="middle" style="text-align: left;  width: 80%;">Item Name</th>
								<th colspan="1" valign="middle" style="text-align: center; width: 10%;">Total</th>
							</tr>
							<tbody id="item_details_info">

							</tbody>
							<tfoot style="border-top:1px solid black">
							<tr class="bold">
								<td colspan="5" style="text-align:right;  border-top:1px solid #333; ">Total Amt :</td>
								<td colspan="1" id="tia" style="text-align: left;  border-top:1px solid #333; "></td>
							</tr>

							<tr class="bold">
								<td colspan="5" style="text-align:right;">VAT 15 :</td>
								<td colspan="1" id="vat_amount" style="text-align: left;"></td>
							</tr>
							<tr>
								<td colspan="6" style="text-align:center;">
									<p style="margin: 0px">Prices are VAT Inclusive</p>
									<p style="margin: 0px">(arabic language)</p>
								</td>
							</tr>


							<tr>
								<td colspan="6" style="text-align:center;">
									<p style="margin: 0px">Payment Method - </p>
									<p style="margin: 0px">(arabic language)</p>
								</td>
							</tr>

							<tr>
								<td colspan="6">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<th align="left" valign="middle" style="text-align: left"> </th>
											<th align="right" valign="middle" style="text-align: right"> </th>
										</tr>
										<tbody id="r_payment_history">

										</tbody>
									</table>
								</td>
							</tr>


							</tfoot>
						</table>
					</td>
				</tr>

				<tr>
					<td align="center">
						<img id="image_id" src="https://chart.googleapis.com/chart?chs=150x150&amp;cht=qr&amp;chl=Hello%20world&amp;choe=UTF-8" alt="QR code">
					</td>
				</tr>

				<tr>
					<td colspan="6" style="text-align:center;">-- End --</td>
				</tr>
				<tr>
					<td colspan="6" style="text-align:center;">Powerd by <?=$_SESSION['company_name']?></td>
				</tr>

				</thead>
				<tbody id="s_sales"></tbody>
			</table>

			</div>

		</div>


	</div>



	<script language="javascript">
		function hide()
		{
			document.getElementById('pr').style.display='none';
		}

	</script>


<script>
function us_func(pos_id){
$("#pos_id").val(pos_id);
close_s_sale();
get_all_info(pos_id);
}
function close_s_sale(){
$(".all_s_sale").hide();
}
function close_receipt(){
$(".receipt").hide();
}
function view_suspended_sales(){
$(".all_s_sale").show();
$.ajax({
url:"s_sales.php",
method:"get",
dataType:"json",
success:function(data){
$("#s_sales").html("<tr><td colspan='7'><h3 style='text-align:center;color:white;'>No Data Found</h3></td></tr>");
var text = "";
if(data!=""){
$.each(data, function(key, val){
text+="<tr><td>"+val.s_id+"</td><td>"+val.s_date+"</td><td>"+val.customer_name+"</td><td>"+val.comments+"</td><td>"+val.us_sale+"</td><td>"+val.s_receipt+"</td><td>"+val.s_delete+"</td></tr>";});
$("#s_sales").html(text);
}
}
});
}
function suspend_order(){
	var new_order_number = parseFloat($("#pos_id").val()); 
	var total_item_in_cart = parseFloat($("#total_item_count").html());
var verify = confirm('Are you sure you want to suspend order no:'+$("#pos_id").val()+"?");
if(verify==true){
if(total_item_in_cart==0){
alert("No Item Found IN Cart, Suspension Denied");
}else{
$("#pos_id").val(new_order_number+1);	
$("#item_below").html("");	
$("#total_item_count").html(0);
$("#total_amount").html(0);
$("#total_due_amt").html(0);	
$("#paid_amt").val(0);
$("#final_comment").hide();
$("#final_confirm_button").hide();	
}
}else{
alert("Order continues");
return false;
		}
}
function cancel_pos(){
	if(confirm('Are you sure?')==true){
var pos_id = $("#pos_id").val();
$.ajax({
url:"cancel_pos_ajax.php",
method:"post",
dataType:"json",
data:{
pos_id:pos_id
	},
success: function(data){
if(data['status']=="ok"){
$("#item_below").html("");	
$("#total_item_count").html(0);
$("#total_amount").html(0);
$("#total_due_amt").html(0);	
$("#paid_amt").val(0);
$("#final_comment").hide();
$("#final_confirm_button").hide();
select_payment();	
	}
	}
});		
}else{
	return false;		
}

}
function delete_s_func(pos_id){
if(confirm('Are you sure?')==true){
$.ajax({
url:"cancel_pos_ajax.php",
method:"post",
dataType:"json",
data:{
pos_id:pos_id
},
success: function(data){
if(data['status']=="ok"){
view_suspended_sales()
	}
	}
});		
}else{
return false;		
}

}
function confirm_sale(){
$.ajax({
url:"confirm_sale_ajax.php",
method:"POST",
dataType:"json",
data:{
comment: $("#final_comment").val(),
pos_id:$("#pos_id").val(),
register_mode:$("#register_mode").val(),
payment_method: $("#payment_method").val(),
customer_info: $("#customer_info").val(),
dealer_name: $("#dealer_name").val(),
contact_no: $("#contact_no").val()
},
success: function(result){
	var confirm_receipt = confirm("Do You Need Receipt?");
	if(confirm_receipt==true){
	receipt($("#pos_id").val());
	}
$("#pos_id").val(result['max_id']);
if(result['status']=="ok"){
$("#item_below").html("");	
$("#total_item_count").html(0);
$("#total_amount").html(0);
$("#total_due_amt").html(0);	
$("#paid_amt").val(0);
$("#final_comment").hide();
$("#final_confirm_button").hide();
select_payment();
}
}
});
}
function cal_again(details_id){
var pos_id = $("#pos_id").val();
var qty = parseFloat($("#item_qty_"+details_id).val());
var price = parseFloat($("#item_price_"+details_id).val());
var stock = parseFloat($("#stock_"+details_id).val());
if(qty>(stock+1)){
$("#item_qty_"+details_id).val('1');
alert('Stock Overflow');
//document.getElementById('item_qty_'+details_id).value = 1;

}else{
var item_total_amt = qty*price;

$("#total_item_amt_"+details_id).html(item_total_amt);
}
var disc  = parseFloat($("#item_discount_"+details_id).val());
if(disc>0){
var new_amt = item_total_amt-(item_total_amt*disc/100);	
$("#total_item_amt_"+details_id).html(new_amt);
}
$.ajax({
url:"update_item_details_ajax.php",
method:"post",
dataType:"json",
data:{
details_id:details_id,
i_qty:qty,
i_price:price,
i_disc:disc,
i_tot_amt:$("#total_item_amt_"+details_id).html()
},
success: function(data, msg){
if(data=="ok"){
get_all_info(pos_id);		
}

}
});

}
function select_payment(){
	var pos_id = $("#pos_id").val();
	var tot_amt = parseFloat($("#total_amount").html());
	$.ajax({
	url:"add_payment_ajax.php",
	method:"post",
	dataType:"json",
	data:{
	req_type:"select",
	pos_id:pos_id,
	},
	success:function(data, msg){
	var p_method = "";
	var p_amt = "";
	var action = "";
	var sum = 0;
	var left_amt = 0;
	if(data!="" && data[0]['result']!="remove"){
	$.each(data, function(key, val){
	var new_paid_amt = parseFloat(val.paid_amt);
	sum+=new_paid_amt;
	p_method+="<tr><td>"+val.payment_method+"</td><td>"+val.paid_amt+"</td><td><input style='width:30px;height:20px;font-size:9px;background-color:#3498db;border-radius:10% !important;color:white;' name='payment_action' id='payment_action_"+val.id+"' type='button' value='&times;' onclick='remove_payment("+val.id+")'></td></tr>";
	});
	left_amt = parseFloat(tot_amt-sum);
	if(left_amt==0){
	$("#paid_amt").val(0.00);
	$("#final_comment").show().val("");
	$("#final_confirm_button").show();
	$("#total_due_amt").html(left_amt);
	}
	if(left_amt>0){
	$("#paid_amt").val(left_amt);
	$("#final_comment").hide();
	$("#final_confirm_button").hide();
	$("#total_due_amt").html(left_amt);
	}
	if(left_amt<0){
	var new_left_amt = Math.abs(left_amt);
	$("#paid_amt").val(0);
	$("#final_comment").show().val("Return: "+new_left_amt);
	$("#final_confirm_button").show();
	$("#total_due_amt").html(0);	
	}
	$("#payment_history").html(p_method);
	
	}
	else if(data[0]['result']=="remove"){
	$("#paid_amt").val(tot_amt);
	$("#final_comment").hide();
	$("#final_confirm_button").hide();	
	$("#payment_history").html("");
	$("#total_due_amt").html(tot_amt);
	}
	}
	})	
	
		
	}
function add_payment(){
	var pos_id = $("#pos_id").val();
	var item_in_cart = $("#total_item_count").html();
	var total_amt = $("#total_amount").html();
	var paid_amt = $("#paid_amt").val();
	var left_amt = total_amt-paid_amt;
	var payment_method = $("#payment_method").val();
	var render_pa="";
	var payment_result = "";
	if(item_in_cart == 0 && paid_amt>0){
	alert("No Item Found to Pay");	
	}
	else if(item_in_cart>0 && paid_amt>0){
	$.ajax({
	url:"add_payment_ajax.php",
	method:"post",
	dataType:"json",
	data:{
	req_type:"insert",
	pos_id:pos_id,
	total_item:item_in_cart,
	total_amt:total_amt,
	paid_amt:paid_amt,
	left_amt:left_amt,
	payment_method:payment_method
	},
	success:function(data, msg){
	if(data=="ok"){
	select_payment();
	}
	}
	})	
	}
	else if(item_in_cart>0 && paid_amt==0){
	alert("Invalid Payment amount")	;
	}
	}
function remove_payment(id){
$.ajax({
	url:"add_payment_ajax.php",
	method:"post",
	dataType:"json",
	data:{
	req_type:"delete",
	id:id
	},
	success:function(data, msg){
	if(data=="ok"){
	select_payment();		
	}
	}
	});	
	}
function remove_item(details_id){
	var pos_id = $("#pos_id").val();
	$.ajax({
	url:"delete_item_ajax.php"	,
	method:"get",
	dataType:"json",
	data:{
	details_id:details_id	
	},
	success: function(result){
	if(result=="yes"){
	get_all_info(pos_id);
	}
	}
	});
	}
function get_all_info(pos_id){
$("#item_below").html("<tr><td colspan='7'><p style='text-align:center;padding:2%'>Loading..........</p></td></tr>");
$.ajax({
url:"get_all_info.php",
method:"get",
dataType:"json",
data:{
pos_id : pos_id
},
success: function(result){
if(result['item_details']!=null){
var text = "";
var now_style="";
var total_count = 1;
var tot_amt = 0;
$.each(result['item_details'], function(key, val){
var prime_number_check = 0;
var tot_amt_details = parseFloat(val.total_amt);
tot_amt+=tot_amt_details;
prime_number_check = parseInt(key%2);
if(prime_number_check>0){
now_style="style='background-color:#f2f2f2'";
}
if(prime_number_check==0){
now_style="style='background-color:#a8d3f0'";
}
key++;
text+="<tr "+now_style+"><td><button title='Click here to remove this item' type='button' id='remove_item_"+val.id+"' title='Remove the item' onclick='remove_item("+val.id+")'>&times;</button></td><td>"+key+"</td><td style='width:200px'>"+val.item_name+"</td><td>"+val.stock+"<input type='hidden' style='width:70px' id='stock_"+val.id+"' name='stock_[]' value='"+val.stock+"' /></td><td><input style='width:70px' id='item_price_"+val.id+"' name='item_price[]' value='"+val.rate+"' onchange='cal_again("+val.id+")' /></td><td> <input style='width:70px' type='text' id='item_qty_"+val.id+"' name='item_qty[]' value='"+val.qty+"' onchange='cal_again("+val.id+")'> </td><td> <input style='width:70px' type='text' id='item_discount_"+val.id+"' name='item_discount[]' value='"+val.discount+"' onchange='cal_again("+val.id+")'></td><td id='total_item_amt_"+val.id+"'>"+val.total_amt+"</td>";
});
text+="</tr><tr><td colspan='8' style='background-color:#e6e6e6;padding:1%;border-radius:0px 0px 10px 10px;'>&nbsp;</td></tr>";
$("#item_below").html(text);
$("#total_item_count").html(result['total_item']);
$("#total_amount").html(tot_amt);
$("#total_due_amt").html(tot_amt);
$("#paid_amt").val(tot_amt);
select_payment();
}
else if(result['item_details']=="" || result['item_details']==null || result['item_details']=="null" ) {
text+="</tr><tr><td colspan='8' style='background-color:#e6e6e6;padding:1%;border-radius:0px 0px 10px 10px;'><h3 style='text-align:center'>No Item Found</h3></td></tr>";
$("#item_below").html(text);	
$("#total_item_count").html(0);
$("#total_amount").html(0);
$("#total_due_amt").html(0);	
$("#paid_amt").val(0);
}

}
});
}
function insert_item(){
var item_id = $("#item_id");
var pos_id = $("#pos_id").val();
if(item_id.val()!=""){
$.ajax({
url:"item_info_ajax.php",
method:"POST",
dataType:"JSON",
data:$("#codz2").serialize(),
success: function(result, msg){
var tt = result;
if(tt[0]=="No Stock Found"){
alert(tt[0]);
}
if(tt[0]=="Data Inserted"){
get_all_info(pos_id);
item_id.val("");
}
}
});	
}
}

function receipt(pos_id){

$.ajax({
url:"receipt_ajax.php",
method:"get",
dataType:"json",
data:{
pos_id:pos_id	
},
success:function(data, msg){
var pos_date = data.master_info.pos_date;
var sale_type = data.master_info.register_mode;
var item_details_info = "";
var payment_details = "";
var tot_amt = 0;
var tot_paid_amt = 0;
var left_amt = 0;
var r_payment_history = "";
$(".receipt").fadeIn(500);
$("#invoice_no").html(pos_id);
$("#invoice_date").html(pos_date);
$("#sale_type").html(sale_type+" receipt");
$.each(data.details_info, function(key,val){
tot_amt+=parseFloat(val.total_amt);
item_details_info+="<tr><td colspan='1' class='moveTextToCenter'>"+val.qty+"</td><td colspan='4'>"+val.item_name+"</td><td colspan='1' class='moveTextToCenter'>"+val.total_amt+"</td></tr>";
});
$.each(data.payment_history, function(key2, val2){
tot_paid_amt+=parseFloat(val2.paid_amt);
r_payment_history+="<tr><td>"+val2.payment_method+"</td><td class='moveTextToRight'>"+val2.paid_amt+"</td></tr>";
});
left_amt=tot_amt-tot_paid_amt;
if(left_amt>=0){
$("#tid").html(left_amt);
$("#cid").html(0);	
	}
if(left_amt<0){
$("#tid").html(0);
$("#cid").html(Math.abs(left_amt));	
}
$("#item_details_info").html(item_details_info);

	var vat= ((tot_amt*15)/100);

$("#vat_amount").html(vat);
$("#tia").html(tot_amt);
$("#r_payment_history").html(r_payment_history);

	var con= 'Company '+$("#company_name").text()+' TIN '+$("#tin_number").val()+' Date '+ pos_date+' '+' Total '+tot_amt+' VAT '+vat;
	// convert - to _
//	con = con.replace(/-/g, "-");
	// convert space to %20
//	con = con.replace(/ /g, "%20");
	document.getElementById("image_id").src='https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl='+con+'&choe=UTF-8';
//$("#image_id").src='https://chart.googleapis.com/chart?chs=150x150&amp;cht=qr&amp;chl='+con+'&amp;choe=UTF-8';

}
});


}

function contact_check(phone_no){
var contact_no = phone_no;
if(contact_no!=""){
$.ajax({
url:"contact_check_ajax.php",
method:"POST",
dataType:"JSON",
data:$("#codz2").serialize(),
success: function(result, msg){
var tt = result;

$("#contact_check_msg").html(tt[0]);

}
});	
}
}

</script>
<?
require_once "../../../assets/template/layout.bottom.php";
?>