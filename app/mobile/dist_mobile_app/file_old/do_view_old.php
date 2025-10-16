<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$page="reports";
$user_id = $_SESSION['user_id'];
$order_no=$_GET['do'];
$order = findall('select * from ss_do_master where do_no="'.$order_no.'"');
require_once '../assets/template/inc.header.php';
?>


















<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
				<div class="card card-style gradient-green">
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
		</div>
    <!-- End of Page Content--> 
    





<?php 
 require_once '../assets/template/inc.footer.php';
 ?>