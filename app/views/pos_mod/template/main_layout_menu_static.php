<?php

$master_user = find_a_field('user_activity_management', 'master_user', '1');

?>

<h1 style="background: #3498DB; width: 100%; color: white; text-align:center; font-size:18px; margin:0px; margin-bottom:1px; padding: 10px 0px;"><a href="../main/home.php">WR Name: <?=find_a_field('warehouse', 'warehouse_name', 'warehouse_id="'.$_SESSION['user']['depot'].'"')?></a></h1>





<div class="menu_bg">




 <div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span>Inventory Setup</span></a></div>



    <ul class="submenu">


       
        <li>   <a href="../setup/warehouse.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Warehouse</a></li>
        <li>   <a href="../setup/inventory_type.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Inventory Type</a></li>
       


    </ul>
    
    <div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span>Product Management</span></a></div>



    <ul class="submenu">


        <li>   <a href="../product_manage/unit_management.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span> Unit</a></li>
        <li>   <a href="../product_manage/item_category.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Item Category</a></li>
        <li>   <a href="../product_manage/item_group.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Item Group</a></li>
        <li>   <a href="../product_manage/item_sub_group.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Item Sub Group</a></li>
        <li>   <a href="../product_manage/item_info.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Item Info</a></li>



    </ul>




    

     <div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Item Opening</span></a></div>



    <ul class="submenu">


        <li>   <a href="../ob/opening_balance.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span> Opening Balance(Item)</a></li>

        <!--<li>   <a href="../ob/opening_balance_fg.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Opening Balance(Finish Goods)</a></li>-->

      

        <li>   <a href="../ob/monthly_consumption.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span> Adjustment of Opening</a></li>



    </ul>

    

    

    

     <div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Material Requisition</span></a></div>



    <ul class="submenu">



      <li>   <a href="../mr/mr_create.php?new=2"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span> Create MR</a></li>

        <li>   <a href="../mr/select_unfinished_mr.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Unfinished MR</a></li>

      

        <li>   <a href="../mr/select_unapproved_mr.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span> Unapproved MR</a></li>

        

          <li>   <a href="../mr/mr_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span> Factory Indent Status</a></li>



    </ul>







  <!--   <div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Black Tea Transection</span></a></div>



    <ul class="submenu">



      <li>   <a href="../raw_tea/black_tea_transection.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Black Tea Transection</a></li>

        <li>   <a href="../raw_tea/black_tea_transection_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Black Tea Transection Status</a></li>

      

          <li>   <a href="../raw_tea/stock_position_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Stock Position Status</a></li>



    </ul>
-->






  <!--<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Create Blend Sheet</span></a></div>



    <ul class="submenu">



      <li>   <a href="../blend_sheet/black_tea_transection.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Create New Blend Sheet</a></li>

        <li>  <a href="../blend_sheet/black_tea_transection_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Black Tea Transection Status</a></li>

      

          <li>   <a href="../blend_sheet/stock_position_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Stock Position Status</a></li>



    </ul>
-->




	

	

	

	<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Purchased Receive </span></a></div>



    <ul class="submenu">



      <li>  <a href="../pr_packing_mat/select_upcoming_po.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Upcomming PO Receive</a></li>

        <li>  <a href="../pr_packing_mat/po_receive_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>PO Receive Report</a></li>

      		<li>  <a href="../pr_packing_mat/purchase_receive_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>PO Receive Status</a></li>

          <!--<li>   <a href="../pr_packing_mat/purchase_receive_status_gr.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>PO Receive Status(GR Wise)</a></li>

		      

        <li>  <a href="../pr_packing_mat/purchase_receive_status_party.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>PO Receive Status(Party Wise)</a></li>-->

    </ul>
    
    	<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Sales Return Receive </span></a></div>



    <ul class="submenu">



      <li>  <a href="../pr_packing_mat/select_upcoming_sr.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Upcomming SR Receive</a></li>

        <li>  <a href="../pr_packing_mat/sr_receive_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>SR Receive Report</a></li>

      	
          <!--<li>   <a href="../pr_packing_mat/purchase_receive_status_gr.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>PO Receive Status(GR Wise)</a></li>

		      

        <li>  <a href="../pr_packing_mat/purchase_receive_status_party.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>PO Receive Status(Party Wise)</a></li>-->

    </ul>
    
    	<!--<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Sales Return Receive </span></a></div>



    <ul class="submenu">



      <li>  <a href="../other_receive/sr_receive.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Upcomming Sales Return</a></li>

        

      		<li>  <a href="../other_receive/sr_receive_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>SR Receive Report</a></li>

          <!--<li>   <a href="../pr_packing_mat/purchase_receive_status_gr.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>PO Receive Status(GR Wise)</a></li>

		      

        <li>  <a href="../pr_packing_mat/purchase_receive_status_party.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>PO Receive Status(Party Wise)</a></li>

    </ul>-->





	

	<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Local Purchase</span></a></div>



    <ul class="submenu">



      <li>  <a href="../local_purchase/local_purchase.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Local Purchase</a></li>

        <li> <a href="../local_purchase/local_purchase_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Local Purchase Report</a></li>

      		

    </ul>









	<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Packing Materials Issues</span></a></div>



    <ul class="submenu">



      <li>  <a href="../production_issue/select_prodiction_line.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>New Packing Materials Issue</a></li>

        <li>  <a href="../production_issue/production_issue_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Packing Materials Issue Report</a></li>		

    </ul>





	<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Production Line Receive</span></a></div>



    <ul class="submenu">



      <li>  <a href="../production_receive/select_prodiction_line.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>New Production Receive (FG)</a></li>

        <li>  <a href="../production_receive/production_receive_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Production Line Receive Report</a></li>		

    </ul>

	

	

	

	

	<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Other Issue</span></a></div>



    <ul class="submenu">



      <li> <a href="../other_issue/sample_issue.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Sample Issue</a></li>

        <li>  <a href="../other_issue/gift_issue.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Gift Issue</a></li>		

     <li> <a href="../other_issue/entertainment_issue.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Entertainment Issue</a></li>

        <li>  <a href="../other_issue/other_issue.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Other Issue</a></li>	

		 <li> <a href="../other_issue/damage_issue.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Damage Issue</a></li>

        <li>  <a href="../other_issue/other_issue_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>All Issue Report</a></li>	

	</ul>

	







<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Depot Chalan</span></a></div>



    <ul class="submenu">



      <li> <a href="../do/select_dealer_chalan.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Delivery Order Chalan</a></li>

       

	</ul>

	



	

	<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Despatch Order Status (Factory)</span></a></div>



    <ul class="submenu">



      <li> <a href="../fr/mr_status.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Despatch Order Status</a></li>

       

	</ul>

	



	<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Depot Transfer</span></a></div>



    <ul class="submenu">



      <li> <a href="../depot_transfer/select_depot.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Depot Transfer Entry</a></li>

      <li> <a href="../depot_transfer/select_unfinished_depot_transfer.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Unfinished Depot Transfer</a></li>

	   <li> <a href="../depot_transfer/select_unapproved_depot_transfer.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Unapproved Depot Transfer </a></li>  

	</ul>

	

	

	

	<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Depot Transfer Report</span></a></div>



    <ul class="submenu">



      <li> <a href="../depot_transfer/fg_chalan_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>FG Send Report</a></li>

      <li> <a href="../depot_transfer/fg_receive_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>FG Receive Report</a></li>

	   <li> <a href="../report/advance_depot_transfer_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Advance Depot Transfer Report </a></li>  

	</ul>

	

<? if($level==5||$level==4||$level==1){?>

	<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Report</span></a></div>



    <ul class="submenu">



      <li> <a href="../report/work_order_report.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Warehouse Reports</a></li>

      

	</ul>

 <? }?>









<div class="silverheader"><a href="#"><i class="fa fa-cubes" aria-hidden="true"></i> <span> Inventory Journal</span></a></div>



    <ul class="submenu">



      <li> <a href="../inventory_journal/inventory_journal_create.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>Create Inventory Journal</a></li>

      

	</ul>





    <div class="silverheader"><a href="#" ><i class="fas fa-sign-in-alt"></i> <span> Exit Program</span></a></div>



    <ul class="submenu">

        <li>

            <a href="../main/logout.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span> Log Out</a>

        </li>

    </ul>



</div>





<div class="copyright">

    <img class="oe_logo_img" alt="SajeebERP: Open Source Business" src="../../../logo/logo.png" height="31px;" >

</div>











