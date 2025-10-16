<?php
session_start();
include 'config/access.php';
include 'config/db.php';
include 'config/function.php';

$user_id	=$_SESSION['user_id'];

$page       ="setup_shop";

include "inc/header.php";


if(isset($_GET['edit_id'])){
$edit_id = $_GET['edit_id'];
$ss="select * from ss_shop where dealer_code='".$edit_id."' ";
$show = findall($ss);
}

if(isset($_POST['update'])){
unset($_POST['update']);
update('ss_shop','dealer_code="'.$_GET['edit_id'].'"');
$msg= "Update successfully";

redirect2("setup_shop.php?edit_id=".$edit_id);
}


if(isset($_REQUEST['new'])){
    
$_POST['entry_by']			=$user_id;
$_POST['entry_at']			=date('Y-m-d H:i:s');
$_POST['status']			='1'; 

@insert('ss_shop');
$msg="New Shop insert successfully";
redirect2("setup_shop.php");
}


//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>1){	
// $delid = $_REQUEST['delid'];

//     // Check transection
//     $check = find1("select count(id) from journal where ledger_id='".$delid."'");
//     if($check>0){ $emsg="<h3>Sorry! This Head has Transection.Please check</h3>"; }else{
    
//     	db_query($conn, "delete from ledger_head where id='".$delid."' ");
//     	$msg="Delete successfully";
//     	}
//}


?>
<!-- main page content -->
<div class="main-container container">
            

<div class="row text-center mb-3"><h3>Shop Registration</h3></div>
<?php if(isset($_GET['edit_id'])){ ?> <a class="btn btn-primary" href="?" role="button">New Entry</a> <? } ?>
<?php if(isset($msg)){ ?><div class="alert alert-primary msg" role="alert"><?php echo @$msg; ?></div><?php } ?>
<?php if(isset($emsg)){ ?><div class="alert alert-danger emsg" role="alert"><?php echo @$emsg; ?></div><?php } ?>



<form action="" method="post" id="demo" data-parsley-validate class="form-horizontal form-label-left">					


<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="market_id">Market Name<span class="required"></span></label></div>
	<div class="col-7"><select type="text" name="market_id" required="required" autocomplete="off" value="<?=$show->market_id?>" class="form-control">
	        <option value="<?=$show->market_id?>"><?=find1("select market_name from ss_market where market_id='".$show->market_id."'");?></option>
	        <? optionlist("select market_id,market_name from ss_market where 1 order by route_id,market_name");?>
	    </select></div>
</div>


<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="shop_name">Shop Name<span class="required"></span></label></div>
	<div class="col-7"><input type="text" name="shop_name" required="required" autocomplete="off" value="<?=$show->shop_name?>" class="form-control"></div>
</div>

<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="shop_owner_name">Owner Name<span class="required"></span></label></div>
	<div class="col-7"><input type="text" name="shop_owner_name" required="required" autocomplete="off" value="<?=$show->shop_owner_name?>" class="form-control"></div>
</div>


<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="mobile">Mobile<span class="required"></span></label></div>
	<div class="col-7"><input type="text" name="mobile" required="required" autocomplete="off" value="<?=$show->mobile?>" class="form-control"></div>
</div>

<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="shop_address">Address<span class="required"></span></label></div>
	<div class="col-7"><input type="text" name="shop_address" required="required" autocomplete="off" value="<?=$show->shop_address?>" class="form-control"></div>
</div>

			
											  
<div class="ln_solid mt-2"></div>
<div class="form-group">
    <div class="col-md-6 col-sm-6 col-md-offset-3">
    <?php if($_GET['edit_id']>0){ ?>
        <button name="update" type="submit"  class="btn btn-info">Update</button>
    <?php }else{ ?>
            <div class="col-11 col-sm-11 mt-auto mx-auto py-4">
                <div class="row ">
                    <div class="col-12 d-grid">
                        <button type="submit" name="new" class="btn btn-default btn-lg btn-rounded shadow-sm">Create</button>
                    </div>
                </div>
            </div>
        
        <?php } ?>
    </div>
</div>
</form>	






<!-- User list items  -->


           
           
           

</div>
<!-- main page content ends -->
</main>
<!-- Page ends-->


<?php include "inc/footer.php"; ?>