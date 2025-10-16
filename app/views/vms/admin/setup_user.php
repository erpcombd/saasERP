<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$today = date('Y-m-d');
$company_id     = $_SESSION['company_id'];
$menu = 'Setup';
$sub_menu = 'new_user';

if(isset($_REQUEST['new'])){
$_POST['company_id']=$company_id;    
@insert('admin_users');
$msg="New data insert successfully";
}

if(isset($_REQUEST['delid']) && $_REQUEST['delid']>1){	
$delid = $_REQUEST['delid'];
mysqli_query($conn, "delete from admin_users where id='".$delid."'");
$msg="Delete successfully";
}
?>
        
<!--Top header	-->	
<?php include("inc/header.php");?>
<?php include("inc/header_top.php");?>
        

<section class="content-main">
<div class="content-header">
<h2 class="content-title">User Setup</h2>
<?php if(isset($msg)){  ?>
<div class="alert alert-primary" role="alert">
  <?php echo @$msg; ?>
</div>
<?php } ?>
</div>

<div class="card mb-4">
<div class="card-body">
<!--BODY Start	-->
				
<div class="row">
<div class="col-md-4 col-xs-12">
<div class="card mb-4"><div class="card-body">


<div class="x_panel">
<div class="x_content">
                     
<form action="" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">					
<div class="row mb-10 form-group">
	<label class="control-label col-md-6 col-sm-6" for="first-name">User Login Name<span class="required"></span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input type="text" name="username" required="required" 
	class="form-control col-md-7 col-xs-12">
	</div>
</div>

<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="first-name">
Password<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="password" name="password" required="required" 
class="form-control col-md-7 col-xs-12">
</div>
</div>	

<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="first-name">
User Full Name<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="full_name" required="required" 
class="form-control col-md-7 col-xs-12">
</div>
</div>	



<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="role">Level<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="role" required="required" value="1" 
class="form-control col-md-7 col-xs-12">
</div>
</div>				
						

					  
<div class="ln_solid mt-5"></div>
<div class="form-group">
<div class="col-md-6 col-sm-6 col-md-offset-3">
<!--<button class="btn btn-primary" type="reset">Reset</button>-->
<button name="new" type="submit"  class="btn btn-success">Create</button>
</div>
</div>
</form>	
<p>Level Rules</p>
<p>1 = Report</p>
<p>2 = Can modify</p>
<p>5 = Admin   </p>
</div>

<!-- /Body end -->
</div>
</div></div> <!--end card-->
</div> <!--end first column-->


<div class="col-md-1">
</div>

<!-- start  user list-->
<div class="col-md-7">
<div class="card mb-4"><div class="card-body">
<div class="x_panel">
<div class="x_title">
<h2>User List</h2>                   
<div class="clearfix"></div>
</div>
<div class="x_content">

<table class="table">
<thead>
        <tr>
          <th>ID</th>
          <th>User Name</th>
          <th>Mobile</th>
		  <th>Level</th>
		  <th>Action</th>
        </tr>
      </thead>
      <tbody>
<?php 
$sql = "select * from admin_users where 1 and company_id='".$company_id."'";
$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>
                        <tr>
                          <th scope="row"><?=$data->id;?></th>
                          <td><?=$data->username;?></td>
                          <td><?=$data->mobile;?></td> 
						  <td><?=$data->role;?></td>
						  <td>
	<a href="user_update.php?edit_id=<?=$data->id;?>">Edit</a> || 
	<a href="new_user.php?delid=<?=$data->id;?>" onClick="return confirm('Do you want to delete')">Delete</a>
						</td>
                        </tr>
<?php } ?>
                      </tbody>
</table>	
	

<div align="center"><br>
<br>
</div>
</div>
</div>
</div></div> <!--end card-->
</div>
<!-- end user list-->

</div>				

				

<!-- Body end -->
</section> 		

        
		
		
<?php include("inc/footer.php");?>