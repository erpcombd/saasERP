<?php
session_start ();
include "config/access_admin.php";
include "config/db.php";
include 'config/function.php';


$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Setup';
$sub_menu 		= 'dealer_info';



if(isset($_REQUEST['new']) && $_POST['randcheck']==$_SESSION['rand']){
  $_POST['group_for']=$company_id;  
  $_POST['status']			='Active';
  $_POST['dealer_type']		='Distributor';

  @insert('dealer_info');
  $msg="New data insert successfully";
}


//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>0){	
//  $delid = $_REQUEST['delid'];
//  mysqli_query($conn, "delete from dealer_info where dealer_code='".$delid."'");
//  $msg="Delete successfully";
//  redirect('so_list.php');
//}

if (isset($_REQUEST['delid']) && $_REQUEST['delid'] > 0) {
    $delid = $_REQUEST['delid'];

    // Prepare a SQL statement
    $stmt = $conn->prepare("DELETE FROM dealer_info WHERE dealer_code = ?");
    
    // Bind the parameter
    $stmt->bind_param("i", $delid); // Assuming dealer_code is a string. Use "i" for integer.
    
    // Execute the statement
    if ($stmt->execute()) {
        $msg = "Deleted successfully";
    } else {
        $msg = "Error deleting record: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();

    // Redirect
    header('Location: so_list.php');
    exit();
}


if(isset($_POST['update'])){
  unset($_POST['update']);
  unset($_POST['randcheck']);

  update('dealer_info','dealer_code="'.$_GET['edit_id'].'"');
  $msg= "Update successfully";
  redirect('dealer_info.php?edit_id='.$_POST['dealer_code']);
}

if($_GET['edit_id']){
$ss="select * from dealer_info where dealer_code='".$_GET['edit_id']."' ";
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
            <h1 class="m-0">Dealer Information</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><button type="button" class="btn btn-success btn-lg"><a href='dealer_info.php'><span style="color:#FFFFFF">Add New</span></a></button> </li>
            </ol>
          </div>

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">



        <div class="row">
          <!-- left column -->
          <div class="col-md-4">
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

<? if($_GET['edit_id']>0){ ?>
<input type="hidden" name="dealer_code" value="<?=$show2->dealer_code; ?>" />
<? } ?>

<div class="row mb-10 form-group">
	<label class="control-label col-md-6 col-sm-6" for="first-name">Dealer Code<span class="required"></span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input class="col-md-12" type="text" name="dealer_code2" required="required" class="form-control col-md-12" value="<?=$show2->dealer_code2;?>"
	class="form-control col-md-7 col-xs-12">
	</div>
</div>
	

<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="first-name">Dealer Name<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="dealer_name_e" required="required" value="<?=$show2->dealer_name_e?>" class="form-control col-md-12" autocomplete="off">
</div></div>

<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="first-name">Mobile<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="mobile_no" required="required" value="<?=$show2->mobile_no?$show2->mobile_no:8801?>" class="form-control col-md-12">
</div></div>



<!--<div class="row mb-10 form-group">-->
<!--  <label class="control-label col-md-6 col-sm-6" for="first-name">Product Group<span class="required"></span></label>-->
<!--  <div class="col-md-6 col-sm-6 col-xs-12">-->
<!--    <select class="form-control col-md-6" name="product_group">-->
<!--    <option><?=$show2->product_group?></option>-->
<!--    <?php optionlist("select group_name,group_name from product_group where 1 order by group_name"); ?>-->
<!--    </select>-->
<!--  </div>-->
<!--</div>-->



<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="address_e">Address<span class="required"></span></label>
<div class="col-md-8">
<input type="text" name="address_e" required="required" value="<?=$show2->address_e?>" class="form-control col-md-12">
</div></div>


<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="region_id">Region<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="region_id" required id="region" onchange="FetchZone(this.value)">
        <option value="<?=$show2->region_id?>"><?=find1("select BRANCH_NAME from branch where BRANCH_ID='".$show2->region_id."'");?></option>
<? optionlist('select BRANCH_ID,BRANCH_NAME from branch where 1 order by BRANCH_NAME');?>
    </select>
</div></div>

<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="zone_id">Zone<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="zone_id" required id="zone" onchange="FetchArea(this.value)">
        <option value="<?=$show2->zone_id?>"><?=find1("select ZONE_NAME from zon where ZONE_CODE='".$show2->zone_id."'");?></option>
    </select>
</div></div>


<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="area_id">Area<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="area_code" required id="area">
        <option value="<?=$show2->area_code?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$show2->area_code."'");?></option>

    </select>
</div></div>


	
<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="first-name">Status<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-6" name="canceled" required>
        <option value="<?=$show2->canceled?>"><? if($show2->canceled=='No'){ echo 'Yes';}else{ echo 'No';}?></option>
        <option value="No">Active</option>
        <option value="Yes">Inactive</option>
    </select>
</div></div>


 



					  
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




     <div class="col-md-8">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Dealer Information</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Code</th>
                      <th>Dealer Name</th>
                      <th>Mobile</th>
                      <th>Product Group</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
<?php 
// region list
$sql='select BRANCH_ID  as region_id,BRANCH_NAME as region_name from branch';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$region_info[$info->region_id] = $info->region_name;}

// zone list
$sql='select ZONE_CODE as zone_id,ZONE_NAME as zone_name from zon';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$zone_info[$info->zone_id] = $info->zone_name;}

// area list
$sql='select AREA_CODE as area_id,AREA_NAME as area_name from area';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$area_info[$info->area_id] = $info->area_name;}


$sql = "select * from dealer_info where group_for='".$company_id."'";
$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>                  	
                    <tr>
                      <td><?=$data->dealer_code?></td>
                      <td><?=$data->dealer_name_e?></td>
                      <td><?=$data->mobile_no?></td>
                      <td><?=$data->product_group?><br>
<? echo $region_info[$data->region_id];?>-<? echo $zone_info[$data->zone_id];?>-<? echo $area_info[$data->area_code];?>
                      </td>
                      <td>
	<a href="dealer_info.php?edit_id=<?=$data->dealer_code;?>">Edit</a> || 
	<a href="dealer_info.php?delid=<?=$data->dealer_code;?>" onClick="return confirm('Do you want to delete')">Delete</a>
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
</script>