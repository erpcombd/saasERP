<?php
session_start ();
include ("config/access_admin.php");
include ("config/db.php");
include 'config/function.php';


$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Product';
$sub_menu 		= 'product_group';




if(isset($_REQUEST['new']) && $_POST['randcheck']==$_SESSION['rand']){

  @insert('product_group');
  $msg="New data insert successfully";
}


//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>1){	
//  $delid = $_REQUEST['delid'];
//  mysqli_query($conn, "delete from product_group where id='".$delid."'");
//  $msg="Delete successfully";
//  redirect('product_group.php');
//}
if (isset($_REQUEST['delid']) && $_REQUEST['delid'] > 1) {
    $delid = $_REQUEST['delid'];

    // Prepare a SQL statement
    $stmt = $conn->prepare("DELETE FROM product_group WHERE id = ?");
    
    // Bind the parameter
    $stmt->bind_param("i", $delid); 
    
    // Execute the statement
    if ($stmt->execute()) {
        $msg = "Delete successfully";
    } else {
        $msg = "Error deleting record: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();

    // Redirect
    header('Location: product_group.php');
    exit();
}


if(isset($_POST['update'])){
  unset($_POST['update']);
  unset($_POST['randcheck']);
  update('product_group','user_id="'.$_GET['edit_id'].'"');
  $msg= "Update successfully";
  redirect('product_group.php');
}

if($_GET['edit_id']>0){
$ss="select * from product_group where id='".$_GET['edit_id']."'";
$show2 = findall($ss);
}
?>



<?php
include 'inc/header.php';
include 'inc/sidebar.php';
?>  



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product Group</h1>
          </div>
<!--           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div> -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">



        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Fill Up Below Information</h3>
              </div>
              <!-- /.card-header -->



<!-- form start -->
<div class="card-body">              
<form action="" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
<?php $rand=rand(); $_SESSION['rand']=$rand; ?>
<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />

<div class="row mb-10 form-group">
	<label class="control-label col-md-6 col-sm-6" for="group_name">Product Group<span class="required"></span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input type="text" name="group_name" required="required" value="<?=$show2->group_name?>"
	class="form-control col-md-7 col-xs-12">
	</div>
</div>

			
						

					  
<div class="ln_solid mt-5"></div>
<div class="form-group">
<div class="col-md-6 col-sm-6 col-md-offset-3">
<!--<button class="btn btn-primary" type="reset">Reset</button>-->
<? if($_GET['edit_id']>0){?>
<button name="update" type="submit"  class="btn btn-success">Update</button>
<? }else{ ?>
<button name="new" type="submit"  class="btn btn-success">Create</button>
<? } ?>
</div>
</div>



</form>
</div>


</div>
</div>







     <div class="col-md-6">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th>Group Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
<?php 
$sql = "select * from product_group where 1";
$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>                  	
                    <tr>
                      <td><?=++$a;?></td>
                      <td><?=$data->group_name?></td>
                      <td>
	<a href="product_group.php?edit_id=<?=$data->id;?>">Edit</a> || 
	<a href="product_group.php?delid=<?=$data->id;?>" onClick="return confirm('Do you want to delete')">Delete</a>
					</td>
                    </tr>
<? } ?>                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>









          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->








      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 


<?php
include 'inc/footer.php';
?>  