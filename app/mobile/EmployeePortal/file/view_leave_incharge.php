<?php 
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

$title = "Leave Status";
$page = "view_leave_incharge.php";


require_once '../assets/template/inc.header.php';

$u_id= $_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);



$user_id	= $PBI_ID; //$_SESSION['user_id'];

if ($_GET['cancel_id']>0) {
 

    $update = "update hrm_leave_info set incharge_status='Cancel' where id='".$_GET['cancel_id']."'";
//$query=mysql_query($update);
$insert = $conn->query($update);

      if ($query) {
				echo "<script>
					$(document).ready(function() {
						swal({
							title: 'Amendment Successfully Disapproved.',
							text: 'You Follow The Right Step!',
							type: 'success',
							padding: '2em'
						});
					});
				</script>";
			}
}





	
if($_GET['asign_id']>0){

$update = "update hrm_leave_info set incharge_status='Approve' where id='".$_GET['asign_id']."'";

//$query=mysql_query($update);

$insert = $conn->query($update);

header('location:view_leave_incharge.php');


	
}






?>


    

<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
   
		
			
		<?php 
			
			$g_s_date=date('Y-01-01');
			$g_e_date=date('Y-12-31');
			
			 $sql_t = "select a.*,(select leave_type_name from hrm_leave_type where id=a.type) as leave_type from hrm_leave_info a 
			where s_date between '".$g_s_date."' and '".$g_e_date."' and incharge_status='Pending'  and PBI_IN_CHARGE='".$PBI_ID ."' order by PBI_ID";
			
			$query2=mysqli_query($conn, $sql_t);
			
			while($data2=mysqli_fetch_object($query2)){
			
			?> 
			
			<div class="card card-style">
			<div class="content">
				<div class="d-flex pb-2">
					<div class="align-self-center">
						<h2 class="font-700 mb-0">Leave Type: <?=$data2->leave_type?></h2>
						<p class="mb-n2 mt-n1 font-700 font-11  ">ID: <?=$data2->PBI_ID?></p>
						<p class="mb-n2 mt-n1 font-700 font-11  ">Name: <?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$data2->PBI_ID.'"');?></p>
						<p class="mb-n2 mt-n1 font-700 font-11  ">Leave Date: <?=$data2->leave_apply_date?></p>
						<p class="mb-n2 mt-n1 font-700 font-11  ">Start Date: <?=$data2->s_date?> -To- <?=$data2->e_date?></p>
						<p class="mb-n2 mt-n1 font-700 font-11  ">Total Days: <?=$data2->total_days?></p>
					</div>
					<div class="align-self-center ms-auto">
						<p class="m-0 p-0">Status: <?=$data2->incharge_status?></p>
					</div>
				
				</div>
				<div class="row m-0">
						<div class="col-6">
						
							<a href="view_leave_incharge.php?asign_id=<?=$data2->id;?>" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-yellow-dark bg-yellow-light">Approve</a>
						</div>
						<div class="col-6">
							
							<a href="view_leave_incharge.php?cancel_id=<?=$data2->id;?>"  class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-mint-dark bg-mint-dark">Disapprove</a>
						</div>
				</div>
			</div>
		</div>
				
			               <?php } ?>  
			
			
			
			
        </div>
    <!-- End of Page Content--> 
    
    











<?php 
 require_once '../assets/template/inc.footer.php';
 ?>