<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Hold";
$page = "do_unfinished.php";
$user_id	=$_SESSION['user']['user_id'];
$username	= $_SESSION['user']['username'];
$emp_code = $username;
$today = date('Y-m-d');
require_once '../assets/template/inc.header.php';

?>


    
<!-- start of Page Content-->  
<div class="page-content header-clear-medium">

<?
$sql = "select s.*,m.* from ss_shop s, ss_do_master m
where m.dealer_code=s.dealer_code
and m.entry_by='".$username."' and m.do_date='".$today."' and m.do_type=''
and m.status='MANUAL' order by m.do_no";

$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>                                    
   
                <a href="do.php?do_no=<?=$data->do_no?>">
					<div class="card card-style">
						<div class="content">
							<div class="d-flex pb-2">
								<div class="align-self-center pe-3">
									<img src="../assets/images/pictures/pending_booking.png" width="38" class="rounded-xl">
								</div>
								<div class="align-self-center">
									<h2 class="font-700 mb-0">Order No:  <?=$data->do_no?> <?=$data->shop_name?></h2>
									<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase color-highlight">Order Date:<?=$data->do_date?></p>
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