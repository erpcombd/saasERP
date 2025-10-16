<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Pending Delivery List";
$page = "do_list.php";
$username	= $_SESSION['user']['username'];
$emp_code = $username;
require_once '../assets/template/inc.header.php';

?>


    
<!-- start of Page Content-->  
<div class="page-content header-clear-medium">
<form action="" method="post" name="codz" id="codz">

<div class="card card-style">
<div class="content mt-0 ms-0 me-0">

<label for="fdate">Date Form</label>
<input type="date" class="form-control validate-text" name="fdate" id="fdate" value="<?= $_POST['fdate'] ? $_POST['fdate'] : date('Y-m-01') ?>" />

<label for="tdate">Date To</label>
<input type="date" class="form-control validate-text" name="tdate" id="tdate" value="<?= $_POST['tdate'] ? $_POST['tdate'] : date('Y-m-d') ?>" />

<div class="d-flex justify-content-center row m-0 mt-3">
	<div class="col-6">
		<input class="b-n btn btn-success btn-3d btn-block  text-light w-100 py-3" type="submit" name="submitit" id="submitit" value="View" />
	</div>
</div>
</div>
</div>
</form>







<?php
					
if(isset($_POST['submitit'])){
					
if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
						
 $sql = "select m.do_no,s.*,sum(d.total_amt) as total_amt,m.do_date 
from ss_shop s,ss_do_master m,ss_do_details d 
where s.dealer_code=m.dealer_code and m.do_no=d.do_no and m.status='CHECKED'
and m.entry_by='".$emp_code."' ".$con."
group by m.do_no order by m.do_no desc";

// $query=mysqli_query($conn, $sql);
 $query= db_query($sql);
while($data=mysqli_fetch_object($query)){
?>                            
   
                <a href="do_chalan.php?do=<?=$data->do_no?>">
					<div class="card card-style card-bg">
						
						<div class="content m-3">
							<div class="d-flex pb-0">
								<div class="align-self-center pe-3 challan-i">
									<i class="fa-thin fa-cart-circle-exclamation"></i>
									<!--<img src="../assets/images/avatars/4s.png" width="38" class="rounded-xl">-->
								</div>
								<div class="align-self-center">
									<h2 class="font-700 mb-0 f-14"><span class="text-span">Shop:</span> <?=$data->shop_name;?></h2>
									<h2 class="font-700 mb-0 f-14"><span class="text-span">Order No:</span>  <span style=" color: green; "><?=$data->do_no;?></span></h2>
									<h2 class="font-700 mb-0 f-12"><span class="text-span">Order Date:</span> <span class="color-highlight"><?=$data->do_date;?></span></h2>
								</div>
								<div class="align-self-center ms-auto">
									<p class="m-0 p-0"><?=$data->total_amt;?></p>
								</div>							
							</div>
						</div>
					</div>
					</a>		
			
	<? } }?> 	
			
        </div>
    <!-- End of Page Content--> 
 

<?php 
 require_once '../assets/template/inc.footer.php';
 ?>