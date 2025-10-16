<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$page="reports";

require_once '../assets/template/inc.header.php';
?>
<?
$user_id = $_SESSION['user_id'];
$order_no=$_GET['do'];
//$order = findall('select * from ss_do_master where do_no="'.$order_no.'"');
$sql='SELECT a.shop_name,a.shop_address,a.mobile,b.* from ss_do_master b,ss_shop a where b.do_no="'.$order_no.'" and a.dealer_code=b.dealer_code';
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_object($result);


 ?>



<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
			<div class="d-flex justify-content-center row mt-0">
						<div class="col-6 ps-1 ">
						 <a href="#" class="btn btn-m btn-full mb-3 rounded-xl text-uppercase text-center font-900 border-mint-dark color-mint-dark  bg-theme">Invoice</a>
						</div>
			</div>
			<div class="card card-style">			
				<div class="content">				
	        <div class="card-header">
                            <div class="row">
                                <center><span style="font-size:20px;"></span></center>
                                
                                <div class="col-8 ">
                                    <p class="mb-1 text-dark"><span class="text-dark fw-bold">Shop Code:</span><?php echo $row->dealer_code?></p>
									<p class="mb-1 text-dark"><span class="text-dark fw-bold">Shop Name:</span><?php echo $row->shop_name?></p>
									<p class="mb-1 text-dark"><span class="text-dark fw-bold">Address:</span><?php echo $row->shop_address?></p>
									<p class="mb-1 text-dark"><span class="text-dark fw-bold">Mobile Number:</span><?php echo $row->mobile?></p>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4 col-12 text-end mt-2"> 									                            
                                    <p class="mb-1 text-sm-left" style=" text-align: left; ">Order No-<?php echo $row->do_no?></p>
									<p class="mb-1 text-sm-left" style=" text-align: left; ">Order Date:<?php echo $row->do_date?></p>
                                </div>
                            </div>
                        </div>		
						
			
		</div>
	</div>
<div class="table-responsive">
					
					<table class="table table-bordered text-center rounded-sm shadow-l" style="overflow: hidden;">
						<thead>
							<tr class="bg-night-light text-center">
							
								<th scope="col" class="color-white">SL</th>
								<th scope="col" class="color-white">Item Code</th>
								<th scope="col" class="color-white" >Item Name</th>
								<th scope="col" class="color-white">QTY</th>
								<th scope="col" class="color-white">TP</th>
								<th scope="col" class="color-white">NSP</th>
								<th scope="col" class="color-white">Offer %</th>
								<th scope="col" class="color-white">Total TP Amt</th>
								<th scope="col" class="color-white">Total NSP Amt</th>
							</tr>
						</thead>
						<tbody>
				
							
							<? $res='select a.id,b.finish_goods_code,b.item_name,b.unit_name, a.t_price as tp,a.nsp_per,a.stock,a.unit_price as rate,a.pkt_unit as pcs,a.total_amt  as amt ,a.total_tp from ss_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$order_no.' order by a.id';
							//echo link_report_add_del_auto($res,'',6,7);
							
							$query=mysqli_query($conn,$res);
							$sl=1;
							$sum_tp_amt=0;
							$sum_nsp_amt=0;
							while($data=mysqli_fetch_object($query)){
							?>
					
							<tr>
								<td><?=$sl++?></td>
								<td><?=$data->finish_goods_code?></td>
								<td ><p style="width:200px;" class="text-dark"><?=$data->item_name?></p></td>
								<td><?=$data->pcs; $gqty+=$data->pcs;?></td>
								<td><?=floatval($data->tp);?></td>
								<td><?=floatval($data->rate);?></td>
								<td><?=floatval($data->nsp_per);?></td>
								<td><?=floatval($data->total_tp); $sum_tp_amt+=$data->total_tp;?></td>
								<td><?=$data->amt; $sum_nsp_amt+=$data->amt; ?></td>
							</tr>
							<? } ?>    
							
						</tbody>
					</table>
					</div> 
			<div class="footer d-flex flex-row-reverse">
			<div style="width:45%;">
				<table class="footer-table table-bordered">
					<tr>
						<td class="fw-bold"><strong>Total TP Amount</strong></td>
						<td><?=number_format($sum_tp_amt+=$data->total_tp,2);?></td>
					</tr>
					<tr>
						<td><strong>Total Discount(-)</strong></td>
						<td><?=number_format($sum_dis_amt=$sum_tp_amt-$sum_nsp_amt,2);?></td>
					</tr>
					<tr>
						<td><strong>Total NSP Amount</strong></td>
						<td><?=number_format($sum_nsp_amt+=$data->amt,2); ?></td>
					</tr>
				</table>
				</div>
			</div>	
    
	   
   
				<?php /*?><div class="card card-style gradient-green">
					<div class="content">
						<h4 class="color-white">DO NO <?php echo $order_no;?> . Date # <?php echo $order->do_date;?></h4>
						<p class="color-white">
							Order Status: <?=$order->status;?>
						</p>
					</div>
				</div>
				
		<?php 
		$res=mysqli_query($conn,"select distinct(d.id) ,d.*,i.item_name 
		from ss_do_details d,item_info i,ss_do_master m
		where m.do_no=d.do_no and m.do_no='$order_no' and  d.item_id=i.item_id GROUP by d.id");
		$sl=1;
		while($row=mysqli_fetch_object($res)){
		?>


					<div class="card card-style">
						<div class="content">
							<div class="d-flex pb-2">
								<div class="align-self-center">
									<h2 class="font-700 mb-0"><?php echo $sl++?>. <?php echo $row->item_name?>p</h2>
									
									
									<table class="w-100">
										<tbody>
											<tr>
												<td>
													<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase"><strong class="color-highlight">TP:</strong> <?php echo $row->t_price?></p>
													<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase"><strong class="color-highlight">%:</strong> <?php echo $row->nsp_per?></p>
												</td>
												<td>
													<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase"><strong class="color-highlight">Rate:</strong> <?php echo $row->unit_price?></p>
													<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase"><strong class="color-highlight">Qty:</strong> <?php echo $row->total_unit?></p>
												</td>
											</tr>
										</tbody>
									</table>
									
								</div>
								<div class="align-self-center ms-auto">
									<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase">Total: <strong class="color-highlight"><?php $total = ($row->unit_price*$row->total_unit); echo $total; $final_amount +=$total;?></strong></p>
								</div>							
							</div>
						</div>
					</div>              
 <?php } ?>
 
					
				<div class="content">
				<p align="right"><strong>Total :<?php echo $final_amount?></strong></p>



 
				 <div class="row m-0 p-0">
				 <? if($order->status=='Manual'){?>  
					<div class="col-6">
						<a href="do.php?do_no=<?=$order_no?>" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light">Back to Order</a>
					</div>
					<? }else{ ?> 
					<div class="col-6">
						<a href="do_status.php" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light">Back to Order List</a>								 
					</div>
					 <? } ?>
				</div>
				
				</div>
		</div><?php */?>
    <!-- End of Page Content--> 
    





<?php 
 require_once '../assets/template/inc.footer.php';
 ?>