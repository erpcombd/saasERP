<?php
session_start ();
include ("config/access_admin.php");
include ("config/db.php");
include 'config/function.php';


$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Setup';
$sub_menu 		= 'admin_user';




if(isset($_REQUEST['new']) && $_POST['randcheck']==$_SESSION['rand']){
  $_POST['group_for']=$company_id;  
  $_POST['status']='Active'; 

  @insert('user_activity_management');
  $msg="New data insert successfully";
}


//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>1){	
//  $delid = $_REQUEST['delid'];
//  mysqli_query($conn, "delete from user_activity_management where user_id='".$delid."'");
//  $msg="Delete successfully";
//  redirect('admin_user.php');
//}
if (isset($_REQUEST['delid']) && $_REQUEST['delid'] > 1) {
    $delid = $_REQUEST['delid'];

    // Prepare a SQL statement
    $stmt = $conn->prepare("DELETE FROM user_activity_management WHERE user_id = ?");
    // Bind the parameter
    $stmt->bind_param("i", $delid);

    // Execute the statement
    if ($stmt->execute()) {
        $msg = "Deleted successfully";
    } else {
        $msg = "Error deleting record";
    }

    // Close the statement
    $stmt->close();

    // Redirect
    header('Location: admin_user.php');
    exit();
	
}


if(isset($_POST['update'])){
  unset($_POST['update']);
  unset($_POST['randcheck']);
  update('user_activity_management','user_id="'.$_GET['edit_id'].'"');
  $msg= "Update successfully";
  redirect('admin_user.php');
}

$ss="select * from user_activity_management where user_id='".$_GET['edit_id']."' ";
$show2 = findall($ss);
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
            <h1 class="m-0">User Admin</h1>
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
	<label class="control-label col-md-6 col-sm-6" for="first-name">User Login Name<span class="required"></span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input type="text" name="username" required="required" value="<?=$show2->username?>"
	class="form-control col-md-7 col-xs-12">
	</div>
</div>

<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="first-name">Password<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="password" required="required" value="<?=$show2->password?>" class="form-control col-md-7 col-xs-12">
</div>
</div>	

<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="first-name">
User Full Name<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="fname" required="required" value="<?=$show2->fname?>"
class="form-control col-md-7 col-xs-12">
</div>
</div>	


<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="region_id">Zone<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="region_id"  id="region" onchange="FetchZone(this.value)">
        <option value="<?=$show2->region_id?>"><?=find1("select BRANCH_NAME from branch where BRANCH_ID='".$show2->region_id."'");?></option>
<? optionlist('select BRANCH_ID,BRANCH_NAME from branch where 1 order by BRANCH_NAME');?>
    </select>
</div></div>

<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="zone_id">Division<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="zone_id"  id="zone" onchange="FetchArea(this.value)">
        <option value="<?=$show2->zone_id?>"><?=find1("select ZONE_NAME from zon where ZONE_CODE='".$show2->zone_id."'");?></option>
    </select>
</div></div>


<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="area_id">Territory<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="area_id"  id="area" onchange="FetchRoute(this.value)">
        <option value="<?=$show2->area_id?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$show2->area_id."'");?></option>
    </select>
</div></div>



<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="level">Level<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select name="level" class="form-control col-md-7 col-xs-12" required>
  <? if($_GET['edit_id']>0){ ?><option><?=$show2->level;?></option> <? } ?>
  <option value="1">1 Read</option>
  <option value="2">2 Entry</option>
  <option value="5">5 Super Admin</option>
  
  <option value="101">101 TSM</option>
  <option value="102">102 DSM</option>
  <option value="105">105 TSM</option>
</select>    
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




<input type="hidden" name="ss_mod" value="1">
</form>
</div>


</div>
</div>







     <div class="col-md-6">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Admin User List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th>Username</th>
                      <th>Full Name</th>
                      <th style="width: 40px">Label</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
<?php 
$sql = "select * from user_activity_management where user_id not between 10001 and 10010 and group_for='".$company_id."'";
$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>                  	
                    <tr>
                      <td><?=$data->user_id?></td>
                      <td><?=$data->username?></td>
                      <td><?=$data->fname?></td>
                      <td><span class="badge bg-danger"><?=$data->level?></span></td>
                      <td>
	<a href="admin_user.php?edit_id=<?=$data->user_id;?>">Edit</a> || 
	<a href="admin_user.php?delid=<?=$data->user_id;?>" onClick="return confirm('Do you want to delete')">Delete</a>
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

<script type="text/javascript">
  function FetchZone(id){
    $('#zone').html('');
    $('#area').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { region_id : id},
      success : function(data){
         $('#zone').html(data);
      }

    })
  }

  function FetchArea(id){
    $('#area').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { zone_id : id},
      success : function(data){
         $('#area').html(data);
      }

    })
  }


    function FetchRoute(id){
    $('#route').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { area_id : id},
      success : function(data){
         $('#route').html(data);
      }

    })
  }

</script>