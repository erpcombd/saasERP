<?php
session_start();
include 'config/db.php';
include 'config/function.php';
include 'config/access.php';
$user_id	=$_SESSION['user_id'];

$page="home";

include "inc/header.php";

?>
<!-- main page content -->
<div class="main-container container">


            
<!-- User list items  -->
<div class="row">
<div class="row text-center mb-2"><h4>Demand Order List</h4></div>    
    

                        
                            
<? 
$sql = "select m.do_no,s.*,sum(d.total_amt) as total_amt 
from ss_shop s,ss_do_master m,ss_do_details d 
where s.dealer_code=m.dealer_code and m.do_no=d.do_no and m.status='CHECKED'
group by m.do_no order by m.do_no";

$query=db_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>                            
<div class="col-12">
    <div class="card shadow-sm mb-2">        
            <ul class="list-group list-group-flush bg-none">
            <li class="list-group-item border-0">
                <a href="do_chalan.php?do=<?=$data->do_no?>">
                <div class="row">
                    <div class="col-auto">
                        <div class="card">
                            <div class="card-body p-0">
                                <figure class="avatar avatar-50 rounded-15">
                                    <img src="assets/img/user1.jpg" alt="">
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col px-0">
                        <p class="mb-0">Order No: <?=$data->do_no?>  <?=$data->shop_name?><br><small class="text-secondary"><?=$data->shop_owner_name?> ,<?=$data->mobile?></small></p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-secondary text-muted size-10 mb-0">Order</p>
                        <p class="text-info">
                            <strong><?=$data->total_amt;?></strong>
                        </p>
                    </div>
                </div></a>
            </li>
    
        </ul>
         
    </div>
</div>
           <? } ?> 
           </div>           
            
            


        </div>
        <!-- main page content ends -->


    </main>
    <!-- Page ends-->

<?php include "inc/footer.php"; ?>