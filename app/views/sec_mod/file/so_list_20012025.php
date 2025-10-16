<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

include '../config/function.php';


$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
$menu 			  = 'Setup';
$sub_menu 		= 'so_list';



if(isset($_REQUEST['new']) && $_POST['randcheck']==$_SESSION['rand']){
  $_POST['group_for']=$company_id;  
  $_POST['status']='Active'; 

  @insert('ss_user');
  $msg="New data insert successfully";
}


//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>0){	
//  $delid = $_REQUEST['delid'];
//  mysqli_query($conn, "delete from ss_user where user_id='".$delid."'");
//  $msg="Delete successfully";
//  redirect('so_list.php');
//}

if (isset($_REQUEST['delid']) && $_REQUEST['delid'] > 0) {
    $delid = $_REQUEST['delid'];

    $stmt = $conn->prepare("DELETE FROM ss_user WHERE user_id = ?");

    $stmt->bind_param("i", $delid); 

    if ($stmt->execute()) {
        $msg = "Delete successfully";
    } else {
        $msg = "Error deleting record: " . $stmt->error;
    }

    $stmt->close();

	redirect('so_list.php');
    exit();
}


if(isset($_POST['update'])){
  unset($_POST['update']);
  unset($_POST['randcheck']);

  update('ss_user','user_id="'.$_GET['edit_id'].'"');
  $msg= "Update successfully";
  redirect('so_list.php?edit_id='.$_GET['edit_id']);
}






if(isset($_POST['update_fo'])){

// shop
$sql="update ss_shop set emp_code='".$_POST['new_fo']."' where emp_code='".$_POST['old_fo']."' ";
mysqli_query($conn, $sql);

// do master
$sql="update ss_do_master set entry_by='".$_POST['new_fo']."' where entry_by='".$_POST['old_fo']."' ";
mysqli_query($conn, $sql);

// do details
$sql="update ss_do_details set entry_by='".$_POST['new_fo']."' where entry_by='".$_POST['old_fo']."' ";
mysqli_query($conn, $sql);

// do chalan
$sql="update ss_do_chalan set entry_by='".$_POST['new_fo']."' where entry_by='".$_POST['old_fo']."' ";
mysqli_query($conn, $sql);


$msg= "FO Link Update successfully";
  redirect('so_list.php');
}



if(isset($_POST['update_dealer_all'])){

// shop list
$sql="update ss_shop set master_dealer_code='".$_POST['new_party']."' where master_dealer_code='".$_POST['old_party']."' ";
mysqli_query($conn, $sql);

// emp list
$sql="update ss_user set dealer_code='".$_POST['new_party']."' where dealer_code='".$_POST['old_party']."' ";
mysqli_query($conn, $sql);


// do master
$sql="update ss_do_master set depot_id='".$_POST['new_party']."' where depot_id='".$_POST['old_party']."' ";
mysqli_query($conn, $sql);

// do details
$sql="update ss_do_details set depot_id='".$_POST['new_party']."' where depot_id='".$_POST['old_party']."' ";
mysqli_query($conn, $sql);

// do chalan
$sql="update ss_do_chalan set depot_id='".$_POST['new_party']."' where depot_id='".$_POST['old_party']."' ";
mysqli_query($conn, $sql);


$msg= "Dealer information and data Update successfully";
  redirect('so_list.php');
}






if($_GET['edit_id']){
$ss="select * from ss_user where user_id='".$_GET['edit_id']."' ";
$show2 = find_all_field('ss_user','','user_id="'.$_GET['edit_id'].'"');
//($ss);
}
?>





  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Field Force Information</h1>
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

<div class="row mb-10 form-group">
	<label class="control-label col-md-6 col-sm-6" for="first-name">Employee Code<span class="required"></span></label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input class="col-md-12" type="text" name="username" required="required" value="<?=$show2->username?>"
	class="form-control col-md-7 col-xs-12">
	</div>
</div>

<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="first-name">Password<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="password" required="required" value="<?=$show2->password?>" class="form-control col-md-12">
</div>
</div>	

<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="first-name">Full Name<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="fname" required="required" value="<?=$show2->fname?>" class="form-control col-md-12">
</div>
</div>
<?php /*?><div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="first-name">Incharge<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="fname" required="required" value="<?=$show2->fname?>" class="form-control col-md-12">
</div>
</div><?php */?>
<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="first-name">Joining Date<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="date" name="DOJ" id="DOJ" required="required" value="<?=$show2->DOJ?>" class="form-control col-md-12">
</div>
</div>


<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="first-name">Date of Birth<span ></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="date" name="dob" id="dob"  value="<?=$show2->dob?>" class="form-control col-md-12">
</div>
</div>

<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="">Mobile<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="mobile" required="required" value="<?=$show2->mobile?>" class="form-control col-md-12">
</div>
</div>




<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="region_id">Zone<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="region_id" required id="region" onchange="FetchZone(this.value)">
        <option value="<?=$show2->region_id?>"><?=find1("select BRANCH_NAME from branch where BRANCH_ID='".$show2->region_id."'");?></option>
       <? optionlist('select BRANCH_ID,BRANCH_NAME from branch where 1 order by BRANCH_NAME');?>
    </select>
</div>
</div>

<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="zone_id">Territory<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="zone_id" required id="zone" onchange="FetchArea(this.value)">
        <option value="<?=$show2->zone_id?>"><?=find1("select ZONE_NAME from zon where ZONE_CODE='".$show2->zone_id."'");?></option>
    </select>
</div>
</div>


<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="area_id">Route Name<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="area_id" required id="area" onchange="Fetchroute(this.value)">
        <option value="<?=$show2->area_id?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$show2->area_id."'");?></option>

    </select>
</div>
</div>

<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="area_id">Route Points<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="route_points" required id="route_id" >
        <?php /*?><option value="<?=$show2->area_id?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$show2->area_id."'");?></option><?php */?>
		
        <option value="<?=$show2->area_id?>"><?=find1("select route_name from ss_route where area_id='".$show2->area_id."'");?></option>
		
    </select>
</div>
</div>

<!--<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="">Distributor/Retailer<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="number" name="dealer_code" required="required" value="<?=$show2->dealer_code?>" class="form-control col-md-12">
</div>
</div>-->
	
<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="first-name">Status<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-6" name="status" required>
        <option><?=$show2->status?$show2->status:'Active'?></option>
        <option>Active</option>
        <option>Inactive</option>
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



</form>
</div>


</div>
        
        
        <!--<div class="card card-primary">-->
        <!--      <div class="card-header">-->
        <!--        <h3 class="card-title">Update FO Link with Outlet</h3>-->
        <!--      </div>            -->
            
        <!--<form action="" method="post" data-parsley-validate class="mt-5 p-5 form-horizontal form-label-left">-->
           
        <!--<div class="row mb-10 form-group">-->
        <!--	<label class="control-label col-md-6 col-sm-6" for="first-name">Old Employee Code<span class="required"></span></label>-->
        <!--	<div class="col-md-6 col-sm-6 col-xs-12">-->
        <!--	<input type="text" name="old_fo" required="required" value=""-->
        <!--	class="form-control col-md-12 col-md-7 col-xs-12">-->
        <!--	</div>-->
        <!--</div> -->
        
        <!--<div class="row mb-10 form-group">-->
        <!--	<label class="control-label col-md-6 col-sm-6" for="first-name">New Employee Code<span class="required"></span></label>-->
        <!--	<div class="col-md-6 col-sm-6 col-xs-12">-->
        <!--	<input type="text" name="new_fo" required="required" value=""-->
        <!--	class="form-control col-md-12 col-md-7 col-xs-12">-->
        <!--	</div>-->
        <!--</div>        -->
           
        <!--<div class="ln_solid mt-5"></div>-->
        <!--<div class="form-group">-->
        <!--<div class="col-md-6 col-sm-6 col-md-offset-3">-->
        <!--<button name="update_fo" type="submit"  class="btn btn-success">Update FO Link</button>-->

        <!--</div>-->
        <!--</div>-->
        <!--</form>    -->
        <!--</div>-->
        
        
        <!--<div class="card card-primary">-->
        <!--      <div class="card-header">-->
        <!--        <h3 class="card-title">Update Dealer old to new</h3>-->
        <!--      </div>            -->
            
        <!--<form  action="" method="post" data-parsley-validate class="mt-5 p-5 form-horizontal form-label-left">-->
           
        <!--<div class="row mb-10 form-group">-->
        <!--	<label class="control-label col-md-6 col-sm-6" for="first-name">Old Party Code<span class="required"></span></label>-->
        <!--	<div class="col-md-6 col-sm-6 col-xs-12">-->
        <!--	<input type="text" name="old_party" required="required" value=""-->
        <!--	class="form-control col-md-12 col-md-7 col-xs-12">-->
        <!--	</div>-->
        <!--</div> -->
        
        <!--<div class="row mb-10 form-group">-->
        <!--	<label class="control-label col-md-6 col-sm-6" for="first-name">New Party Code<span class="required"></span></label>-->
        <!--	<div class="col-md-6 col-sm-6 col-xs-12">-->
        <!--	<input  type="text" name="new_party" required="required" value=""-->
        <!--	class="form-control col-md-12 col-md-7 col-xs-12">-->
        <!--	</div>-->
        <!--</div>        -->
           
        <!--<div class="ln_solid mt-5"></div>-->
        <!--<div class="form-group">-->
        <!--<div class="col-md-6 col-sm-6 col-md-offset-3">-->
        <!--<button name="update_dealer_all" type="submit"  class="btn btn-success">Update Dealer</button>-->

        <!--</div>-->
        <!--</div>-->
        <!--</form>    -->
        <!--</div>        -->
        
        
        
        
</div>




     <div class="col-md-8">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Information</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th>Username</th>
                      <th>Full Name</th>
                      <th>Area</th>
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


$sql = "select * from ss_user where 1 ";
$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>                  	
                    <tr>
                      <td><?=$data->user_id?></td>
                      <td><?=$data->username?></td>
                      <td><?=$data->fname?></td>
                      <td>Dealer: <?=$data->dealer_code?><br><? echo $region_info[$data->region_id];?>-<? echo $zone_info[$data->zone_id];?>-<? echo $area_info[$data->area_id];?>
                      </td>
                      <td>
	<a href="so_list.php?edit_id=<?=$data->user_id;?>">Edit</a> || 
	<a href="so_list.php?delid=<?=$data->user_id;?>" onClick="return confirm('Do you want to delete')">Delete</a>
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
require_once SERVER_CORE."routing/layout.bottom.php";
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
   function Fetchroute(id){ 
    $('#route_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { area_id : id},
      success : function(data){
         $('#route_id').html(data);
      }

    })
  }
</script>