<?php
session_start();
include 'config/db.php';
include 'config/function.php';
include 'config/access.php';
$user_id	=$_SESSION['user_id'];

$page="home";

include "inc/header.php";


if($_GET['v']>0){

$chalan_no = $_GET['v'];
$chalan_info    = findall("select * from ss_do_chalan where chalan_no='".$chalan_no."' limit 1"); 
$dealer_code    = $chalan_info->dealer_code;
$dealer         = findall("select * from ss_shop where dealer_code='".$dealer_code."'");

$chalan_amount = find1("select sum(total_amt) from ss_do_chalan where chalan_no='".$chalan_no."'");
}

?>

        <!-- main page content -->
        <div class="main-container container">
            <!-- Biling -->
            <div class="row mb-3">
                <div class="col align-self-center">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <div class="row">
                                <div class="col-auto">
                                    <h6 class="mb-1">Chalan No #<?php echo $chalan_no?></h6>
                                    <p>Order NO #<?php echo $chalan_info->do_no;?></p>
                                </div>
                                <div class="col text-end">
                                    <h6 class="mb-1"><i class="bi bi-check-circle"></i> Chalan Date</h6>
                                    <p><b><?php echo $chalan_info->chalan_date;?></b></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!--<div class="col-12 col-md-6 mb-4">-->
                                <!--    <p class="mb-2">Sold By:</p>-->
                                <!--    <p class="text-secondary">Z,-->
                                <!--        <br>full address,<br>Dhaka -1000-->
                                <!--    </p>-->
                                <!--</div>-->
                                <div class="col-12 col-md-6">
                                    <!--<p class="mb-2"></p>-->
                                    <p class="text-secondary">Code: <?php echo $dealer->dealer_code;?> - <?php echo $dealer->shop_name;?></p>
                                    <p class="text-secondary"><?php echo $dealer->shop_address;?></p>
                                    <p class="text-secondary">Mobile: <?php echo $dealer->mobile;?></p>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>

           
           
           
           
           
           
           
<!-- products -->
<div class="row mb-2">
                
<?php
$sql="select c.*,i.* from ss_do_chalan c,item_info i where i.item_id=c.item_id and  c.chalan_no='".$chalan_no."'   ";
$query=db_query($conn,$sql);
while($data=mysqli_fetch_object($query)){
?>                
                <div class="col-12 col-md-6 ">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <!--<div class="col-auto">-->
                                <!--    <figure class="avatar avatar-60 rounded-15 border">-->
                                <!--        <img src="assets/img/item.png" alt="" class="w-100">-->
                                <!--    </figure>-->
                                <!--</div>-->
                                <div class="col align-self-center">
                                    <p class="mb-0"><small class="text-primary size-12"><?php echo $data->item_name?></small></p>
                                    <h6>BDT <?php echo (int)$data->unit_price;?> <small class="text-secondary size-12">x <?php echo $data->total_unit;?> Qty</small></h6>
                                </div>
                                
                                
                                <div class="col-auto align-self-center ps-0">
                                    <!--<a href="track.php">Track <i class="bi bi-chevron-right"></i></a>-->
                                    TK: <?php echo (int)$data->total_amt;?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
<?php } ?>                
                
           
           
</div>

            <!-- pricing -->
            <!--<div class="row mb-4">
                <div class="col align-self-center">
                    <h6 class="title">Pricing</h6>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <p>Shipping Cost</p>
                </div>
                <div class="col-auto">$ 10.00</div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <p>Subtotal</p>
                </div>
                <div class="col-auto">$ 32.00</div>
            </div>

            <div class="row mb-3 text-success">
                <div class="col">
                    <p>Discount</p>
                </div>
                <div class="col-auto">$ 89.00</div>
            </div>-->

            <div class="row fw-bold mb-4">
                <div class="mb-3 col-12">
                    <div class="dashed-line"></div>
                </div>
                <div class="col">
                    <p>Total</p>
                </div>
                <div class="col-auto">BDT <?php echo number_format($chalan_amount,0);?></div>
            </div>
            <div class="row mb-4">
                <div class="col-12 mb-4">
                    <a href="#" class="btn btn-default shadow-sm btn-lg w-100 btn-rounded">Thank You<br>Company Name Here</a>
                </div>
            </div>
        </div>
        <!-- main page content ends -->


    </main>
    <!-- Page ends-->

<?php include "inc/footer.php"; ?>