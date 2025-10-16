<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$today          = date('Y-m-d');
$company_id     = $_SESSION['company_id'];
$menu           = 'Setup';
$sub_menu       = 'new_user';

if(isset($_POST['update'])){
unset($_POST['update']);
update('admin_users','id="'.$_GET['edit_id'].'"');
$msg= "Update successfully";
}

$ss="select * from admin_users where id='".$_GET['edit_id']."' and company_id='".$company_id."'";
$show2 = findall($ss);
?>
        
<!--Top header	-->	
<?php include("inc/header.php");?>
<?php include("inc/header_top.php");?>
        

<section class="content-main">
<div class="content-header">
<h2 class="content-title">User Modify</h2>
<?php if(isset($msg)){  ?>
<div class="alert alert-primary" role="alert">
  <?php echo @$msg; ?>
</div>
<?php } ?>
</div>

<div class="card mb-4">
<div class="card-body">
<!--BODY Start	-->
				
<form action="" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
						
<div class="row mb-10 form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">User Login Name<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="username" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show2->username;?>">
</div></div>

<div class="row mb-10 form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
Password<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="password" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show2->password;?>">
</div></div>	

<!--<div class="row mb-10 form-group">-->
<!--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mobile<span class="required"></span></label>-->
<!--<div class="col-md-6 col-sm-6 col-xs-12">-->
<!--<input type="text" name="mobile" required="required" -->
<!--class="form-control col-md-7 col-xs-12" value="<?php echo $show2->mobile;?>">-->
<!--</div></div>-->

<div class="row mb-10 form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">User Level<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="role" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show2->role;?>">
</div></div>


<!--<div class="row mb-10 form-group">-->
<!--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Email<span class="required">*</span></label>-->
<!--<div class="col-md-6 col-sm-6 col-xs-12">-->
<!--<input type="text" name="email" required="required" -->
<!--class="form-control col-md-7 col-xs-12" value="<?php echo $show2->email;?>">-->
<!--</div></div>-->
		  

						
						
						
					  
<div class="ln_solid"></div>
<div class="form-group">
<div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-3">
<!--<button class="btn btn-primary" type="reset">Reset</button>-->
<button name="update" type="submit"  class="btn btn-success">Update</button>
</div>
</div>
</form>				

				

<!-- Body end -->
</section> 		

        
		
		
<?php include("inc/footer.php");?>