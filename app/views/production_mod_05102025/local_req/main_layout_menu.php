<? session_start();

$user_level='level'.$_SESSION['user']['level'];
?>
<div class="menu_bg">
<table width="205" border="0" cellspacing="0" cellpadding="0" align="center" style="line-height:13px;">
								  <tr>
									<td>
					  <div class="smartmenu">
                      <? if($level==5||$level==20){?>
                     <div class="silverheader"><a href="#">Production Line Setup</a></div>
					 
					  <div class="submenu">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr><td><a href="../production_line/select_production_line2.php">Line Consumption RAW</a></td></tr>
                            <tr><td><a href="../production_line/select_production_line.php">Line Producing FG</a></td></tr>
                            <tr><td><a href="../production_line/select_finish_good.php">FG Ingrediants Formula</a></td></tr>
						  </table>
					  </div>
                      <? }?>
					 <? if($level==5){?>
                     <div class="silverheader"><a href="#">Batch</a></div>
					 
					  <div class="submenu">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr><td><a href="../recipe/select_prodiction_line.php">Create New Batch</a></td></tr>
						  </table>
					  </div>
                      <? }?>
					  <? if($level==5){?>
                     <div class="silverheader"><a href="#">Monthly Production Order</a></div>
					 
					  <div class="submenu">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr><td><a href="../po/monthly_production_order.php">Monthly Production Order</a></td></tr>
						  </table>
					  </div>
                      <? }?>
					 <? if($level==5||$level==2){?>
                     <div class="silverheader"><a href="#">Raw Material Consumption</a></div>
					  <div class="submenu">
						    <table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr><td><a href="../production_issue/select_production_line.php">New Raw Material Consumption</a></td></tr>
							<tr><td><a href="../production_issue/production_issue_status.php">Raw Material Consumption Report</a></td></tr>
							<tr><td><a href="../production_issue/production_issue_status_edit.php">PI Entry Edit</a></td></tr>
						  </table>
					  </div><? }?>


					  
					  <? if($level==5||$level==2){?>
                      <div class="silverheader"><a href="#">Finish Goods Production</a></div>
					  <div class="submenu">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr><td><a href="../production_receive/select_production_line_fg.php">New Finish Goods Production</a></td></tr>
							<tr><td><a href="../production_receive/production_receive_status.php">Finish Goods Production Report</a></td></tr>
							<tr>
							  <td><a href="../production_receive/production_issue_status_edit.php">PR Entry Edit</a></td>
							</tr>
						  </table>
					  </div><? }?>
					  
					  
<div class="silverheader"><a href="#">Purchase Requisition(Factory)</a></div>

<div class="submenu">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

<? if($user_id==10069 || $user_id==10048 || $user_id==10070 || $user_id==10096 || $user_id==10071 || $user_id==10073 || $user_id==10077 || $user_id==10078 || $user_id==10079 || $user_id==10080 || $user_id==10081 || $user_id==10091 || $user_id==10082 || $user_id==10052 || $user_id==10090 || $user_id==10097 ){ ?>

<tr>

<td><a href="../local_req/mr_create.php">Create PR</a></td>

</tr>

<tr>

<td><a href="../local_req/pr_receive_status.php">Previous Pending PR(Item Wise)</a></td>

</tr>

<tr>

<td><a href="../local_req/select_unfinished_mr.php">Unfinished PR

<? 

$tot_ua=find_a_field('requisition_master_local','count(req_no)',' status="MANUAL"');

if($tot_ua){

?>

<span style="font-weight:bold; font-size: 12px; color:red;">(<? echo $tot_ua; ?>)</span>

<? } ?>

</a></td>

</tr>

<? } ?>

<td><a href="../local_req/mr_status.php">PR by Status</a></td>

</tr>

<tr>

<td><a href="../local_req/mr_status_all.php">PR by Status(ALL)</a></td>

</tr>

<tr>

<td><a href="../local_req/work_order_report.php">PR Pending Summery</a></td>

</tr>

<tr>

<td><a href="../local_req/daily_summery.php">Daily PR Summery</a></td>

</tr>

</table>

</div>
					  
					  <? if($level==5||$level==2){?>
                      <div class="silverheader"><a href="#">Purchase Requisition(Purchase)</a></div>
					  <div class="submenu">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr><td><a href="../pr_req/mr_create.php">Create PR </a></td> <!--Pages Directory pr_req-->
                            </tr>
							<tr><td><a href="../pr_req/select_unfinished_mr.php">Unfinished PR </a></td>
							</tr>
							<tr>
							  <td><a href="../pr_req/mr_status.php"> PR Status</a></td>
							</tr>
							<tr>
							  <td><a href="../pr_req/work_order_report.php"> PR Pending Summery</a></td>
							</tr>
						  </table>
					  </div><? }?>
					  
					  <? if($level==5||$level==2){?>
                      <div class="silverheader"><a href="#">Daily Floor Requisition (DSTR)</a></div>
					  <div class="submenu">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr><td><a href="../mr/mr_create.php?new=2">Create New STR </a></td>
                            </tr>
							<tr><td><a href="../mr/select_unfinished_mr.php">Unfinished STR </a></td>
							</tr>
							<tr>
							  <td><a href="../mr/mr_status.php"> STR Status</a></td>
							</tr>
						  </table>
					  </div><? }?>
					  
					   
					  
					  <? if($level==5||$level==2){?>
                      <div class="silverheader"><a href="#">Daily Floor Requisition Recieve
					  
					  <? $tot_fr=find_a_field('production_issue_master','count(req_no)','status="COMPLETE"');

					if($tot_fr){?><span style="font-weight:bold; font-size: 12px; color:red;">(<? echo $tot_fr; ?>)</span>

					<? } ?>
					  
					  </a></div>
					  <div class="submenu">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr><td><a href="../store_recieve/select_unfinished_pi.php">Recieve Store Requisition </a></td>
                            </tr>
						  </table>
					  </div><? }?>
					  
					   <? if($level==5||$level==2){?>
                      <div class="silverheader"><a href="#">Floor Requisition(JOB)</a></div>
					  <div class="submenu">
						 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr><td><a href="../mr_req/mr_create.php?new=2">Create New STR </a></td>
                            </tr>
							<tr><td><a href="../mr_req/select_unfinished_mr.php">Unfinished STR </a></td>
							</tr>
							<tr>
							  <td><a href="../mr_req/mr_status.php"> STR Status</a></td>
							</tr>
						  
						  </table>
					  </div><? }?>
					  
					<?php /*?>   <? if($level==5||$level==2){?>
                      <div class="silverheader"><a href="#">Product Requisition(PR) </a></div>
					  <div class="submenu">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr><td><a href="../mrr/mr_create.php?new=2">Create New (PR)</a></td>
                            </tr>
							<tr><td><a href="../mrr/select_unfinished_mr.php">Unfinished (PR)</a></td>
							</tr>
							<tr>
							  <td><a href="#">PR</a><a href="../mrr/mr_status.php"> Status</a></td>
							</tr>
						  </table>
					  </div><? }?><?php */?>
					  
					  
					  
					  
					  
                   					  <? if($level==5||$level==2){?>
                      <div class="silverheader"><a href="#">Warehouse Stock</a></div>
					  <div class="submenu">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
						    <tr><td><a href="../report/work_order_report.php">Warehouse Reports</a></td></tr>
							<tr><td><a href="../ws/product_transection_report.php">Bin Card</a></td></tr>
                            <tr><td><a href="../ws/date_transection_report.php">Transection Report (Date)</a></td></tr>
							
						  </table>
					  </div><? }?>
                       <? if($level==5||$level==2){?>
					 <div class="silverheader"><a href="#" >Production Line Rceive</a></div>
					 
					 <div class="submenu">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							
							<tr><td><a href="../production_receive/select_prodiction_line.php">New Production Line Receive</a></td></tr>
							<tr><td><a href="../production_receive/select_unfinished_pr.php">Unfinished Production Receive 
							
							<? 


$tot_ua=find_a_field('production_floor_receive_master','count(pr_no)','status="MANUAL"');


if($tot_ua){


?>


<span style="font-weight:bold; font-size: 12px; color:red;">(<? echo $tot_ua; ?>)</span>


<? } ?>
							
							
							</a></td></tr>
							<tr><td><a href="../production_receive/production_receive_status.php">Production Line Receive Report</a></td></tr>
							
							
						</table>
					  </div>
					  
					  <? }?>
					  
					  
					  
					    <? if($level==5||$level==2){?>
					 <div class="silverheader"><a href="#" >Production Line Return</a></div>
					 
					 <div class="submenu">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							
							<tr><td><a href="../production_return/select_prodiction_line.php">New Production Line Receive</a></td></tr>
							<tr><td><a href="../production_return/select_unfinished_pr.php">Unfinished Production Receive 
							
							<? 


$tot_ua=find_a_field('production_floor_return_master','count(pr_no)','status="MANUAL"');


if($tot_ua){


?>


<span style="font-weight:bold; font-size: 12px; color:red;">(<? echo $tot_ua; ?>)</span>


<? } ?>
							
							
							</a></td></tr>
							<tr><td><a href="../production_return/production_receive_status.php">Production Line Receive Report</a></td></tr>
							
							
						</table>
					  </div>
					  
					  <? }?>
					  
					  
					   <? if($level==5||$level==2){?>
					  
					  <div class="silverheader"><a href="#" >Production Report</a></div>
					  <div class="submenu">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							
							<tr><td><a href="../report/work_order_report.php">Advance Production Reports</a></td></tr>
							<tr><td><a href="../production_issue/production_issue_status.php">Production Issue Report</a></td></tr>
							<tr><td><a href="../production_receive/production_receive_status.php">Finish Goods Receive Report</a></td></tr>
							
							
						</table>
					  </div>
					  
					  <? }?>
					   <? if($level==5||$level==2){?>
					  <div class="silverheader"><a href="#" >Exit Program</a></div>
					  <div class="submenu">
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							  <td><a href="../main/logout.php">Log Out</a></td>
						  </tr>
						  </table>
					  </div>
					  <? }?>
					  </div>                             
									</td>
								  </tr>
								</table>

							</div>
