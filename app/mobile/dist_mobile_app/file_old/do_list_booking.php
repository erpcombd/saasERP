<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Pending Booking List";
$page = "do_list_booking.php";
$username	= $_SESSION['user']['username'];
$emp_code = $username;
require_once '../assets/template/inc.header.php';

?>


    
<!-- start of Page Content-->  
<div class="page-content header-clear-medium">
<?
$sql = "select m.do_no,s.*,sum(d.total_amt) as total_amt,m.do_date 
from ss_shop s,ss_do_master m,ss_do_details d 
where s.dealer_code=m.dealer_code and m.do_no=d.do_no and m.status='CHECKED' and do_type='Booking'
and m.entry_by='".$emp_code."'
group by m.do_no order by m.do_no desc";


$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>                            
   
                <a href="do_chalan.php?do=<?=$data->do_no?>">
					<div class="card card-style">
						<div class="content">
							<div class="d-flex pb-2">
								<div class="align-self-center pe-3">
									<img src="../assets/images/pictures/pending_booking.png" width="38" class="rounded-xl">
								</div>
								<div class="align-self-center">
									<h2 class="font-700 mb-0">Order No:  <?=$data->do_no?>  <?=$data->shop_name?></h2>
									<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase color-highlight">Order Date:<?=$data->do_date?></p>
								</div>
								<div class="align-self-center ms-auto">
									<p class="m-0 p-0"><?=$data->total_amt;?></p>
								</div>							
							</div>
						</div>
					</div>
					</a>		
			
	<? } ?> 	
			
        </div>
    <!-- End of Page Content--> 
 

<?php 
 require_once '../assets/template/inc.footer.php';
 ?>