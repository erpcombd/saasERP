<?php

$master_user = find_a_field('user_activity_management', 'master_user', '1');

?>

<h1 style="background: #3498DB; width: 100%; color: white; text-align:center; font-size:18px; margin:0px; margin-bottom:1px; padding: 10px 0px;">Sales Module</h1>

<div class="menu_bg">

<?php /*?><? if($level==5){?>

<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Price Setup</a></div>

<ul class="submenu">

<li>   <a href="../ido/item_price.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Item Price</a></li>

<!--<li>   <a href="../ob/opening_balance_fg.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Opening Balance(Finish Goods)</a></li>

<li>   <a href="../ido/item_price_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Super Shop Price Report</a></li>

<li>   <a href="../cdo/item_price.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Corporate Priceg</a></li>

<li>   <a href="../ido/item_price_outlet.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Outlet Wise Item Price</a></li>

<li>   <a href="../tdo/item_price.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> TradeFair Price</a></li>

<li>   <a href="../tdo/item_price_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> TradeFair Price Report</a></li>

<li>   <a href="../ido/item_price_bb.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Bulk Price Setup</a></li>
<li>   <a href="../ido/item_price_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Bulk Price Report</a></li>

<li>   <a href="../ido/item_staff_price.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Staff Price</a></li>-->
</ul>

<? }?><?php */?>



	  
<div class="silverheader"><a href="#"><i class="fas fa-cog" aria-hidden="true"></i> Configuration </a></div>

<ul class="submenu">

<li>   <a href="../setup/user_group.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 
Company Settings</a></li>

<li>   <a href="../setup/warehouse_info.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 
Warehouse Info</a></li>

<li>   <a href="../setup/sub_warehouse_info.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 
Sub Warehouse Info</a></li>

<li>   <a href="../setup/user_info.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 
User Manage</a></li>

<li>   <a href="../setup/cost_category.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 
Cost Category</a></li>

<li>   <a href="../setup/cost_center.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 
Cost Center</a></li>

</ul>


<? if($level==5||$level==6||$level==7){?>

<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Product Management</a></div>

<ul class="submenu">

<li> <a href="../item_info/item_group.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Product Group</a></li>

<li> <a href="../item_info/item_sub_group.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Product Category</a></li>

<li> <a href="../item_info/item_info.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Product Info</a></li>

<li> <a href="../item_info/product_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Product Report</a></li>

<li>   <a href="../ob/opening_balance_fg.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Opening Stock Entry</a></li>


</ul>


<? }?>


<!--<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Item Opening</a></div>

<ul class="submenu">

<li>   <a href="../ob/monthly_consumption.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Raw Material Opening</a></li>

<li>   <a href="../ob/opening_balance_fg.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Opening Balance(Finish Goods)</a></li>

<li>   <a href="../ob/monthly_consumption_fg.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Finish Goods Opening</a></li>

<li>   <a href="../ob/monthly_consumption_other.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Expense Item Opening</a></li>

<li>   <a href="../other_receive/opening_receive.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Lot Wise Item Opening</a></li>

<li>   <a href="../ob/opening_balance_adjustment.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Opening Balance (Minwal)</a></li>

<li>   <a href="../ob/opening_balance_adjustment_wojoud.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Opening Balance (Riyadh Wojoud)</a></li>

</ul>-->


<? if($level==5||$level==6||$level==7){?>

<div class="silverheader"><a href="#"><i class="far fa-address-book" aria-hidden="true"></i> Supplier Management</a></div>

<ul class="submenu">
<li> <a href="../vendor/vendor_category.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Supplier Category</a></li>

<li> <a href="../vendor/vendor_info.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Supplier Info</a></li>




</ul>


<? }?>


<? if($level==5||$level==6||$level==7){?>
<div class="silverheader"><a href="#"><i class="far fa-address-book" aria-hidden="true"></i> Customer Info  </a></div>

<ul class="submenu">

<li>  <a href="../dealer/dealer_info.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Customer Add</a></li>



</ul>

<? }?>




<? if($level==5||$level==6||$level==7){?>

<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Purchase Order</a></div>

<ul class="submenu">

<li> <a href="../pof/po_create.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> New Purchase</a></li>

<li> <a href="../pof/select_unapproved_po_fg.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Unapprove Purchase</a></li>

<li> <a href="../pof/po_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Approved Purchase</a></li>

<li> <a href="../pof/select_pr_for_bill_create.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Purchase Bill Create</a></li>


</ul>


<? }?>




	  
<!--<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Product Requisition  </a></div>

<ul class="submenu">

<li>   <a href="../fr/select_store.php?new=2"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 
New Requisition</a></li>

<li>   <a href="../fr/select_unfinished_mr.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Unfinished Requisition</a></li>

<li>  <a href="../fr/mr_precheck_list.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Unapproved Requisition</a></li>

<li> <a href="../fr/mr_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Approved Requisition</a></li>

<li><a href="../fr/select_despatch_no.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Despatch Re Order Entry</a></li>


</ul>-->




<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Warehouse Transfer</a></div>

<ul class="submenu">

<!--<li>  <a href="../wh_fr/pending_mr_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Pending Requisition</a></li>-->

<li>  <a href="../wh_transfer/select_depot.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Product Transfer</a></li>

<!--<li>  <a href="../wh_transfer/select_unfinished_depot_transfer.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Unfinished Warehouse Transfer</a></li>-->

<!--<li>  <a href="../wh_transfer/select_unapproved_depot_transfer.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Transfer Re-Check</a></li>-->

<li>  <a href="../wh_transfer/fg_chalan_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Product Send Status</a></li>

<li>  <a href="../wh_transfer/fg_receive_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Product Receive Status</a></li>


</ul>













		
					  
					  
<?php /*?><? if($level==5){?>

<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Super Admin</a></div>

<ul class="submenu">

<li>   <a href="../edit_wo/select_work_order.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Edit WO</a></li>

</ul>

 <? }?><?php */?>

<!--   <div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Black Tea Transection</a></div>

<ul class="submenu">

<li>   <a href="../raw_tea/black_tea_transection.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Black Tea Transection</a></li>

<li>   <a href="../raw_tea/black_tea_transection_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Black Tea Transection Status</a></li>

<li>   <a href="../raw_tea/stock_position_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Stock Position Status</a></li>

</ul>

-->

<!--<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Create Blend Sheet</a></div>

<ul class="submenu">

<li>   <a href="../blend_sheet/black_tea_transection.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Create New Blend Sheet</a></li>

<li>  <a href="../blend_sheet/black_tea_transection_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Black Tea Transection Status</a></li>

<li>   <a href="../blend_sheet/stock_position_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Stock Position Status</a></li>

</ul>

-->




<?php /*?>
<? if($level==5){?>
<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Dealer Info  </a></div>

<ul class="submenu">

<li>  <a href="../dealer/dealer_info.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Dealer Info</a></li>


<li>  <a href="../cdo/item_price.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Customer Price </a></li>
<li>  <a href="../ido/item_price_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Price Report</a></li>

<li>  <a href="../dealer/dealer_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Dealer Report</a></li>

</ul>

<? }?><?php */?>



<!--<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Dealer Area Setup  </a></div>

<ul class="submenu">

<li>  <a href="../dealer/setup_Region.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Setup Region</a></li>

<li>  <a href="../dealer/setup_Zone.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Setup Zone</a></li>

<li>  <a href="../dealer/setup_Territory.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Setup Area</a></li>
<li>  <a href="../dealer/area_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Area Setup Report</a></li>



</ul>-->







<? if($level==5||$level==23||$level==25){?>

<!--<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Delivery Order  </a></div>

<ul class="submenu">

<li>  <a href="../cdo/select_dealer_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>New Demand Order</a></li>
<li>  <a href="../cdo/pos/index.php" target="_blank"><i class="fa fa-angle-double-right" aria-hidden="true"></i>POS Order</a></li>

<li>  <a href="../cdo/select_unfinished_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Unfinished Demand Order</a></li>

<li>  <a href="../cdo/item_price.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Customer Price Setup</a></li>
<li>  <a href="../ido/item_price_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Price Report</a></li>

<li>  <a href="../cdo/select_uncheck_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Unapproved DO List</a></li>



<li>  <a href="../ido/select_checked_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Approved Order</a></li>

<li>   <a href="../pr_packing_mat/purchase_receive_status_gr.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>PO Receive Status(GR Wise)</a></li>

<li>  <a href="../pr_packing_mat/purchase_receive_status_party.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>PO Receive Status(Party Wise)</a></li>

</ul>--><? }?>


<? if($level==5||$level==6||$level==7){?>

<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Sales Order</a></div>

<ul class="submenu">

<li><a href="../direct_sales/select_dealer_do.php?concern=<?=$_SESSION['user']['group']?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 
New Sales Invoice</a></li>

<!--<li><a href="../pos/do_minwal.php?concern=<?=$_SESSION['user']['group']?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 
POS Order</a></li>-->

<!--<li><a href="../direct_sales/select_dealer_do_order.php?concern=<?=$_SESSION['user']['group']?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 
New Sales Order</a></li>

<li>  <a href="../direct_sales/select_unfinished_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Unfinished SO</a></li>

<li><a href="../direct_sales/select_dealer_chalan_list_invoice_update.php?concern=<?=$_SESSION['user']['group']?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 
Sales Invoice Create</a></li>
-->
<li><a href="../direct_sales/work_chalan_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sales Report</a></li>


</ul>

<?php /*?>
<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Sales Return Process</a></div>

<ul class="submenu">

<!--<li><a href="../direct_sales/select_dealer_do.php?concern=<?=$_SESSION['user']['group']?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 
New Sales Invoice</a></li>-->

<li><a href="../sales_return/select_dealer_return_adjustment.php?concern=<?=$_SESSION['user']['group']?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> 
New Sales Return</a></li>

<li><a href="../sales_return/sales_return_status.php?concern=<?=$_SESSION['user']['group']?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i>
 Sales Return Status</a></li>




</ul><?php */?>

<? }?>

<?php /*?><? if($level==5){?>

<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> POS Order </a></div>

<ul class="submenu">

<li>  <a href="../pos/do_minwal.php" target="_blank"><i class="fa fa-angle-double-right" aria-hidden="true"></i>POS Order</a></li>

<li> <a href="../pos/pos_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sales Status</a></li>

</ul>

<? }?>
<?php */?>

 <?php /*?><? if($level==5 || $level==8|| $level==10|| $level==14|| $level==333333|| $level==111111){?>


	<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Pending Purchase Order</a></div>



    <ul class="submenu">



      <li>   <a href="../pof/po_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Pending Purchase Order List</a></li>

      		
    </ul><? }?><?php */?>



<?php /*?><? if($level==5||$level==23||$level==25){?>

<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Demand Order </a></div>

<ul class="submenu">

<li>  <a href="../wojoud_do/select_dealer_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> New Demand Order</a></li>

<li>  <a href="../wojoud_do/select_unfinished_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Unfinished Demand Order</a></li>

<!--<li>  <a href="../wojoud_do/item_price.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Customer Price Setup</a></li>
<li>  <a href="../ido/item_price_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Price Report</a></li>-->

<!--<li>  <a href="../wojoud_do/select_uncheck_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Unapproved DO List</a></li>



<li>  <a href="../wojoud_do/select_checked_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Approved Order</a></li>-->

<!--<li>   <a href="../pr_packing_mat/purchase_receive_status_gr.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>PO Receive Status(GR Wise)</a></li>

<li>  <a href="../pr_packing_mat/purchase_receive_status_party.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>PO Receive Status(Party Wise)</a></li>-->

</ul><? }?><?php */?>
			
<!--
<div class="silverheader"> <a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Demand Order Approval</a></div>

<ul class="submenu">

<li> <a href="../wojoud_do/select_uncheck_do_approved.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Unapproved Demand Order</a></li>

</ul>
-->
<? if($level==5){?>

<!--<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Promotional Offer</a></div>

<ul class="submenu">

<li>  <a href="../do/gift_offer.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Gift Offer</a></li>

<li>  <a href="../ido/gift_offer.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Gift Offer(SuperShop)</a></li>		

<li>  <a href="../cdo/gift_offer.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Gift Offer(Corporate)</a></li>

<li>  <a href="../do/gift_offer_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Gift Offer Report</a></li>	

</ul>-->

<? }?>
					  
				  <? if($level==5||$level==21){?> 

<!--<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Staff Sales(SS) Order</a></div>

<ul class="submenu">

<li>  <a href="../ss/select_dealer_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>New SS Order</a></li>

<li>  <a href="../ss/select_unfinished_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Unfinished SS Order</a></li>		
<li>  <a href="../ss/select_uncheck_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Unapproved SS Order</a></li>

<li>  <a href="../ss/select_checked_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Approved SS Order</a></li>	
</ul>-->

<? }?>
					  
					  					  
					  <? if($level==5||$level==21 ||$level==30){?>

<!--<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Other Sales(OS)Order</a></div>

<ul class="submenu">

<li><a href="../os/select_dealer_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>New OS Order</a></li>

<li> <a href="../os/select_unfinished_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Unfinished OS Order</a></li>		
<li><a href="../os/select_uncheck_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Unapproved OS Order</a></li>

<li> <a href="../os/select_checked_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Approved OS Order</a></li>	
</ul>-->

 <? }?>
					  <? if($level==5||$level==11){?>
<!--
<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Envelope Print</a></div>

<ul class="submenu">

<li> <a href="../report/work_order_report_envelop.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Envelope Print</a></li>

</ul>-->
<? }?>
					  
 <? if($level==5||$level==11){?>					  
					  
<?php /*?><div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Report</a></div>

<ul class="submenu">

<li><a href="../report/work_order_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Delivery Order Reports</a></li>

<li><a href="../report/work_chalan_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Delivery Chalan Reports</a></li>
<li><a href="../report/dealer_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Dealer Info</a></li>
<!--<li><a href="../report/sales_return_list.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Sales Return Reports</a></li>
<li><a href="../damage_report/damage_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Damage Reports</a></li>


<li><a href="../report/other_order_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Other Order Reports</a></li>
<li><a href="../report/other_chalan_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Other Chalan Reports</a></li>

<li><a href="../report/sales_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Store to Store Chalan Reports</a></li>


<li><a href="../dealer_report/dealer_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Dealer Account Record</a></li>
-->




</ul><?php */?>

	<? }?>  
					
<!--<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Management Report</a></div>

<ul class="submenu">

<li> <a href="../report/comparison_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Comparison Report</a></li>

</ul>

<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Management Report 2</a></div>

<ul class="submenu">

<li><a href="../report/advance_report_do.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Management Report 2</a></li>

</ul>
	-->				  
					 

<?php /*?> <? if($level==5||$level==11){?>

<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> Product Management</a></div>

<ul class="submenu">

<li> <a href="../product/product_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Product Advance Reports</a></li>


</ul>
<? }?>  <?php */?>

<div class="silverheader"><a href="#" ><i class="fas fa-sign-in-alt"></i> Exit Program</a></div>

<ul class="submenu">

<li>

<a href="../main/logout.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Log Out</a>

</li>

</ul>


</div>
<div class="copyright">

<img class="oe_logo_img" alt="SajeebERP: Open Source Business" src="<?=SERVER_ROOT?>public/uploads/logo/logo.png" height="31px;" >

</div>



