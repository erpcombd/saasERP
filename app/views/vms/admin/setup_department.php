<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$today = date('Y-m-d');
$company_id     = $_SESSION['company_id'];
$menu = 'Setup';
$sub_menu = 'department';

if(isset($_REQUEST['new'])){
$_POST['group_for']=$company_id;    
@insert('setup_department');
$msg="New data insert successfully";
}

if(isset($_REQUEST['delid']) && $_REQUEST['delid']>1){	
$delid = $_REQUEST['delid'];
mysqli_query($conn, "delete from setup_department where department_id='".$delid."' and group_for='".$company_id."'");
$msg="Delete successfully";
}
?>
        
<!--Top header	-->	
<?php include("inc/header.php");?>
<?php include("inc/header_top.php");?>
        

<section class="content-main">
<div class="content-header">
<h2 class="content-title">Department Setup</h2>
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
	<label class="control-label col-md-6 col-sm-6" for="department_name">Department<span class="required"></span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input type="text" name="department_name" required="required" 
	class="form-control col-md-7 col-xs-12">
	</div>
</div>


<div class="ln_solid mt-5"></div>
<div class="form-group">
<div class="col-md-6 col-sm-6 col-md-offset-3">

<button name="new" type="submit"  class="btn btn-success">Create</button>
</div>
</div>
</form>	

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
<h2>Department List</h2>                   
<div class="clearfix"></div>
</div>
<div class="x_content">

<table class="table">
<thead>
        <tr>
          <th>ID</th>
          <th>Department Name</th>
		  <th>Action</th>
        </tr>
      </thead>
      <tbody>
<?php 
$sql = "select * from setup_department where 1 and group_for='".$company_id."'";
$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>
                        <tr>
                          <th scope="row"><?=$data->department_id;?></th>
                          <td><?=$data->department_name;?></td>
						  <td>
	<a href="department_update.php?edit_id=<?=$data->department_id;?>">Edit</a> || 
	<a href="new_user.php?delid=<?=$data->department_id;?>" onClick="return confirm('Do you want to delete')">Delete</a>
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