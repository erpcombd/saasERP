<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Gift Hold List";
$page = "gift_unfinished";
$username	= $_SESSION['user']['username'];
$emp_code = $username;
require_once '../assets/template/inc.header.php';

?>


    
<!-- start of Page Content-->  
<div class="page-content header-clear-medium">
<? 
$sql='select  a.oi_no,a.oi_no as no,a.oi_date, a.shop_name as party
from ss_do_gift_master a
where a.status="MANUAL" and a.entry_by="'.$emp_code.'" 
'.$con.' 
group by a.oi_no order by a.oi_no desc';
$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>                            
   
                <a href="gift_entry.php?oi_no=<?=$data->oi_no?>">
					<div class="card card-style">
						<div class="content">
							<div class="d-flex pb-2">
								<div class="align-self-center pe-3">
									<img src="../assets/images/avatars/4s.png" width="38" class="rounded-xl">
								</div>
								<div class="align-self-center">
									<h2 class="font-700 mb-0">No: <?=$data->oi_no?>-<?=$data->party?></h2>
									<p class="mb-n2 mt-n1 font-700 font-11 text-uppercase color-highlight">Date: <?=$data->oi_date?></p>
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