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
<?
 //$sql = "select m.do_no,s.*,sum(d.total_amt) as total_amt,m.do_date from ss_shop s,ss_do_master m,ss_do_details d where s.dealer_code=m.dealer_code and m.do_no=d.do_no and m.status='CHECKED'and m.entry_by='".$emp_code."' group by m.do_no order by m.do_no desc";

$sql = "SELECT * FROM ss_location_log WHERE status = 'UNAPPROVED' ORDER BY id DESC";

// $query=mysqli_query($conn, $sql);
 $query=db_query($sql);
while($data=mysqli_fetch_object($query)){
?>                            
   
                <a href="daily_attendance_approved.php?id=<?=$data->id?>">
					<div class="card card-style card-bg" >
						<div class="content m-3">
							<div class="d-flex pb-0">
								<div class="align-self-center pe-3 challan-i">
									<i class="fa-light fa-user-check"></i>
									<!--<img src="../assets/images/avatars/4s.png" width="38" class="rounded-xl">-->
								</div>
								<div class="align-self-center">
									<h2 class="font-700 mb-0 f-14"><span class="text-span">User Name:</span> <?=find1("select fname from ss_user where username='".$data->user_id."'");?></h2>
									<? if($data->shop_name != ''){?>
									<h2 class="font-700 mb-0 f-12"><span class="text-span">Schedule Shop:</span> <span style=" color: green;"><?=$data->shop_name;?></span> </h2>
									<? } ?>
									<? if($data->shop_name_unschedule != ''){?>
									<h2 class="font-700 mb-0 f-12"><span class="text-span">Unschedule Shop:</span> <span style="color:#0069b5;"><?=$data->shop_name_unschedule;?></span> </h2>
									<? } ?>
									<h2 class="font-700 mb-0 f-12"><span class="text-span">Attendance Date:</span> <span class="color-highlight"><?=$data->access_date;?></span></h2>
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