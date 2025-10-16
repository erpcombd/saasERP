<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$today          = date('Y-m-d');
$company_id     = $_SESSION['company_id'];
$menu           = 'Setup';
$sub_menu       = 'department';

if(isset($_POST['update'])){
unset($_POST['update']);
update('setup_department','department_id="'.$_GET['edit_id'].'" and group_for="'.$company_id.'"');
$msg= "Update successfully";
}

$ss="select * from setup_department where department_id='".$_GET['edit_id']."' and group_for='".$company_id."'";
$show2 = findall($ss);
?>
        
<!--Top header	-->	
<?php include("inc/header.php");?>
<?php include("inc/header_top.php");?>
        

<section class="content-main">
<div class="content-header">
<h2 class="content-title">Department Modify</h2>
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
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="department_name">Department<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="department_name" required="required" 
class="form-control col-md-7 col-xs-12" value="<?php echo $show2->department_name;?>">
</div></div>

					  
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