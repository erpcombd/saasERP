<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Attendance Status";
$page = "daily_attendance_status.php";
$username	= $_SESSION['user']['username'];
$emp_code = $username;
require_once '../assets/template/inc.header.php';

?>


    
<!-- start of Page Content-->  
<div class="page-content header-clear-medium">
        <div class="card card-style mb-0">
<div class="content m-0">
<div class="table-responsive pt-3" style="zoom: 70%;">
<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;">
						<thead>
							<tr class="bg-night-light1">
								<th scope="col" class="color-white"> User Name</th>
								<th scope="col" class="color-white"> Schedule Shop</th>
								<th scope="col" class="color-white"> Attendance Date</th>
								<th scope="col" class="color-white"> status</th>
								<th scope="col" class="color-white"> Approved Status</th>

							</tr>
						</thead>
						<tbody>
				
									
							<?
 //$sql = "select m.do_no,s.*,sum(d.total_amt) as total_amt,m.do_date from ss_shop s,ss_do_master m,ss_do_details d where s.dealer_code=m.dealer_code and m.do_no=d.do_no and m.status='CHECKED'and m.entry_by='".$emp_code."' group by m.do_no order by m.do_no desc";
$sql = "SELECT * FROM ss_location_log WHERE user_id = '".$_SESSION['user']['username']."' and access_date BETWEEN '".date("Y-m-01")."' AND '".date("Y-m-d")."' ORDER BY id DESC";

// $query=mysqli_query($conn, $sql);
 $query=db_query($sql);
while($data=mysqli_fetch_object($query)){
?>                            
   							<tr>
								<td align="left" style=" color: green; font-weight: bold;"> <strong style=" color: #0069b5 !important;"><?=$data->user_id;?></strong> - <?=find1("select fname from ss_user where username='".$data->user_id."'");?></td>
								<td align="left" style=" color: #0069b5; font-weight: bold;"><? if($data->shop_name != ''){?><?=$data->shop_name;?><? } ?>
									<? if($data->shop_name_unschedule != ''){?><?=$data->shop_name_unschedule;?><? } ?>
								</td>
								
								<td><?=$data->access_date;?></td>

								<td <? if($data->status == 'APPROVED'){?> style=" color: green; font-weight: bold;" <? }else{?> style=" color: #0069b5; font-weight: bold;"  <? } ?>><?=$data->status;?></td>
								<td <? if($data->approved_status == 'ALLOWED'){?> style=" color: green; font-weight: bold;" <? }elseif($data->approved_status == 'PENDING'){?> style=" color: #0069b5; font-weight: bold;" <? } else{?> style=" color: #ff0000; font-weight: bold;"  <? } ?>><?=$data->approved_status;?></td>
							</tr>	
			
	<? } ?> 	

							
							
							
							
							
							    
						</tbody>
					</table>
					</div>
</div>
</div>

			
        </div>
    <!-- End of Page Content--> 
 

<?php 
 require_once '../assets/template/inc.footer.php';
 ?>