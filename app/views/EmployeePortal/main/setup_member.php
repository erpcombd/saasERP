<?php
session_start();
include 'config/access.php';
include 'config/db.php';
include 'config/function.php';

$user_id	=$_SESSION['user_id'];

$page       ="setup_member";

include "inc/header.php";


if(isset($_GET['edit_id'])){ 
$edit_id = $_GET['edit_id'];
$ss="select * from ledger_head where id='".$edit_id."' ";
$show = findall($ss);
}

if(isset($_POST['update'])){
unset($_POST['update']);
update('ledger_head','id="'.$_GET['edit_id'].'"');
$msg= "Update successfully";

redirect2("setup_member.php?edit_id=".$edit_id);
}


if(isset($_REQUEST['new'])){
    
$_POST['company_id']	    =1; 
$_POST['ledger_group']	    =3; 
$_POST['ledger_group_name']	='Customers';  
$_POST['level']			    =1; 
$_POST['code']			    =find1('select max(code) from ledger_head where ledger_group=3')+1; 

$_POST['entry_by']			=$user_id;
$_POST['entry_at']			=date('Y-m-d H:i:s');
$_POST['status']			='Active'; 

@insert('ledger_head');
$msg="New data insert successfully";
}


if(isset($_REQUEST['delid']) && $_REQUEST['delid']>1){	
$delid = $_REQUEST['delid'];

    // Check transection
    $check = find1("select count(id) from journal where ledger_id='".$delid."'");
    if($check>0){ $emsg="<h3>Sorry! This Head has Transection.Please check</h3>"; }else{
    
    	db_query($conn, "delete from ledger_head where id='".$delid."' ");
    	$msg="Delete successfully";
    	}
}


?>
<!-- main page content -->
<div class="main-container container">
            

<div class="row text-center mb-3"><h3>Member Registration</h3></div>
<?php if(isset($_GET['edit_id'])){ ?> <a class="btn btn-primary" href="?" role="button">New Entry</a> <? } ?>
<?php if(isset($msg)){ ?><div class="alert alert-primary msg" role="alert"><?php echo @$msg; ?></div><?php } ?>
<?php if(isset($emsg)){ ?><div class="alert alert-danger emsg" role="alert"><?php echo @$emsg; ?></div><?php } ?>



<form action="" method="post" id="demo" data-parsley-validate class="form-horizontal form-label-left">					

<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="first-name">Member Full Name<span class="required"></span></label></div>
	<div class="col-7"><input type="text" name="name" required="required" autocomplete="off" value="<?=$show->name?>" class="form-control"></div>
</div>

<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="first-name">Username<span class="required"></span></label></div>
	<div class="col-7"><input type="text" name="username" required="required" autocomplete="off" value="<?=$show->username?>" class="form-control"></div>
</div>

<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="first-name">Password<span class="required"></span></label></div>
	<div class="col-7"><input type="text" name="password" required="required" autocomplete="off" value="<?=$show->password?>" class="form-control"></div>
</div>

<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="first-name">Mobile<span class="required"></span></label></div>
	<div class="col-7"><input type="text" name="mobile" required="required" autocomplete="off" value="<?=$show->mobile?>" class="form-control"></div>
</div>

<div class="row mb-10 mb-2">
	<div class="col-4"><label class="control-label" for="first-name">Address<span class="required"></span></label></div>
	<div class="col-7"><input type="text" name="address" required="required" autocomplete="off" value="<?=$show->address?>" class="form-control"></div>
</div>

			
											  
<div class="ln_solid mt-2"></div>
<div class="form-group">
    <div class="col-md-6 col-sm-6 col-md-offset-3">
    <?php if($_GET['edit_id']>0){ ?>
        <button name="update" type="submit"  class="btn btn-info">Update</button>
    <?php }else{ ?>
        <button name="new" type="submit"  class="btn btn-success">Create</button><?php } ?>
    </div>
</div>
</form>	



<!-- User list items  -->



<div class="row mt-5">
<div class="row text-center mb-2"><h4>Active Member List</h4></div>    
    

                        
                            
<? 
$sql = "select * from ledger_head where 1 and ledger_group=3 order by id";
$query=db_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>                            
                <div class="col-12">
                    <div class="card shadow-sm mb-2">        
                            <ul class="list-group list-group-flush bg-none">
                            <li class="list-group-item border-0">
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
                                        <p><?=$data->name?><br><small class="text-secondary"><?=$data->username?> , Mobile: <?=$data->mobile?></small></p>
                                    </div>
                                    <div class="col-auto text-end">
                                        <p>
                                            <!--<small class="text-secondary">Online <span class="avatar avatar-6 rounded-circle bg-success d-inline-block"></span></small>-->
                                            	<a href="?edit_id=<?=$data->id;?>">Edit</a> || 
	                                            <a href="?delid=<?=$data->id;?>" onClick="return confirm('Do you want to delete')">Delete</a>
                                        </p>
                                    </div>
                                </div>
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