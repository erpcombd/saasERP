<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$title='Field Force Information';
include '../config/function.php';
do_datatable('do_datatable');

$today 			  = date('Y-m-d');
//$company_id   = $_SESSION['company_id'];
$company_id   = $_SESSION['user']['group'];
$menu 			  = 'Setup';
$sub_menu 		= 'so_list';



if(isset($_REQUEST['new']) && $_POST['randcheck']==$_SESSION['rand']){
  $_POST['group_for']=$company_id;  
  $_POST['status']='Active'; 
  
  //$_POST['fg_type'] = implode(',', $_POST['fg_types']);
  
  //unset($_POST['fg_types']);

  @insert('ss_user');
  $msg="New data insert successfully";
}


if(isset($_REQUEST['delid']) && $_REQUEST['delid']>0){	
  $delid = $_REQUEST['delid'];
  mysqli_query($conn, "delete from ss_user where user_id='".$delid."'");
  $msg="Delete successfully";
  redirect('so_list.php');
}

if(isset($_POST['update'])){
  
 //$_POST['fg_type'] = implode(',', $_POST['fg_types']);
  
  unset($_POST['update']);
  unset($_POST['randcheck']);
  //unset($_POST['fg_types']);
  

  update('ss_user','user_id="'.$_GET['edit_id'].'"');
  $msg= "Update successfully";
  redirect('so_list.php?edit_id='.$_GET['edit_id']);
}






if(isset($_POST['update_fo'])){

// shop
$sql="update ss_shop set emp_code='".$_POST['new_fo']."' where emp_code='".$_POST['old_fo']."' ";
mysqli_query($conn, $sql);

//bin card 


$msg= "FO Link Update successfully";
  redirect('so_list.php');
}



if(isset($_POST['update_fo_all'])){

// shop
$sql="update ss_shop set emp_code='".$_POST['new_fo']."' where emp_code='".$_POST['old_fo']."' ";
mysqli_query($conn, $sql);

// do master
//$sql="update ss_do_master set entry_by='".$_POST['new_fo']."' where entry_by='".$_POST['old_fo']."' ";
//mysqli_query($conn, $sql);

// do details
//$sql="update ss_do_details set entry_by='".$_POST['new_fo']."' where entry_by='".$_POST['old_fo']."' ";
//mysqli_query($conn, $sql);

// do chalan
//$sql="update ss_do_chalan set entry_by='".$_POST['new_fo']."' where entry_by='".$_POST['old_fo']."' ";
//mysqli_query($conn, $sql);

//bin card 


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


// bin card
$sql="update ss_journal_item set warehouse_id='".$_POST['new_party']."' where warehouse_id='".$_POST['old_party']."' ";
mysqli_query($conn, $sql);


$msg= "Dealer information and data Update successfully";
  redirect('so_list.php');
}






if($_GET['edit_id']){
$ss="select * from ss_user where user_id='".$_GET['edit_id']."' ";
$show2 = findall($ss);
}
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">



        <div class="row">
          <!-- left column -->
          <div class="col-md-4">
            <div class="card card-primary">
              <div class="card-header p-0">
                <h3 align="center" class="n-form-titel1 mb-2">Fill Up Below Information</h3>
              </div>
              <!-- /.card-header -->



<!-- form start -->
<div class="card-body">              
<form action="" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
<?php $rand=rand(); $_SESSION['rand']=$rand; ?>
<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />

<div class="row mb-10 form-group">
	<label class="control-label col-md-4 col-sm-6" for="first-name">Employee Code<span class="required"></span></label>
	<div class="col-md-8 col-sm-6 col-xs-12">
	<input type="text" name="username" required="required" value="<?=$show2->username?>" class="form-control col-md-12">
	</div>
</div>

<div class="row mb-10 form-group">
<label class="control-label col-md-4 col-sm-6" for="first-name">Password<span class="required"></span></label>
<div class="col-md-8 col-sm-6 col-xs-12">
<input type="text" name="password" required="required" value="<?=$show2->password?>" class="form-control col-md-12">
</div>
</div>	

<div class="row mb-10 form-group">
<label class="control-label col-md-4 col-sm-6" for="first-name">expire_date<span class="required"></span></label>
<div class="col-md-8 col-sm-6 col-xs-12">
<input type="date" name="expire_date" required="required" value="<?=$show2->expire_date?>" class="form-control col-md-12">
</div>
</div>	




<div class="row mb-10 form-group">
<label class="control-label col-md-4 col-sm-6" for="first-name">Full Name<span class="required"></span></label>
<div class="col-md-8 col-sm-6 col-xs-12">
<input type="text" name="fname" required="required" value="<?=$show2->fname?>" class="form-control col-md-12">
</div>
</div>


<div class="row mb-10 form-group">
<label class="control-label col-md-4 col-sm-6" for="">Mobile<span class="required"></span></label>
<div class="col-md-8 col-sm-6 col-xs-12">
<input type="text" name="mobile" required="required" value="<?=$show2->mobile?>" class="form-control col-md-12">
</div>
</div>


<!--<div class="row mb-10 form-group">-->
<!--<label class="control-label col-md-6 col-sm-6" for="first-name">Product Group<span class="required"></span></label>-->
<!--<div class="col-md-6 col-sm-6 col-xs-12">-->
<!--<select class="form-control col-md-6" name="product_group">-->
<!--<option><?=$show2->product_group?></option>-->
<!--<?php optionlist("select group_name,group_name from product_group where 1 order by group_name"); ?>-->
<!--</select>-->
<!--</div></div>-->

<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="region_id">Region<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="region_id" required id="region" onchange="FetchZone(this.value)">
        <option value="<?=$show2->region_id?>"><?=find1("select BRANCH_NAME from branch where BRANCH_ID='".$show2->region_id."'");?></option>
<? optionlist('select BRANCH_ID,BRANCH_NAME from branch where 1 order by BRANCH_NAME');?>
    </select>
</div>
</div>

<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="zone_id">Zone<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="zone_id" required id="zone" onchange="FetchArea(this.value)">
        <option value="<?=$show2->zone_id?>"><?=find1("select ZONE_NAME from zon where ZONE_CODE='".$show2->zone_id."'");?></option>
    </select>
</div>
</div>


<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="area_id">Area<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="area_id" required id="area">
        <option value="<?=$show2->area_id?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$show2->area_id."'");?></option>

    </select>
</div>
</div>

<div class="row mb-10 form-group">
<label class="control-label col-md-4 col-sm-6" for="">Dealer<span class="required"></span></label>
<div class="col-md-8 col-sm-6 col-xs-12">
<input type="text" name="dealer_code" required="required" value="<?=$show2->dealer_code?>" class="form-control col-md-12">
</div>
</div>


<!--<div class="row mb-10 form-group">-->
<!--<label class="control-label col-md-6 col-sm-6" for="">FG Type(Brand)<br>-->
<!--1 Acc,2 Cables,3 Esl,4 Poly,5 Fan-->
<!--<span class="required"></span></label>-->
<!--<div class="col-md-6 col-sm-6 col-xs-12">-->
<!--<input type="text" name="fg_type" value="<?=$show2->fg_type?>" class="form-control col-md-12">-->
<!--</div>-->
<!--</div>-->

<!--<div class="row mb-10 form-group">
    <label class="control-label col-md-6 col-sm-6" for="">FG Type(Brand)<span class="required"></span></label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <select name="fg_types[]" class="form-control col-md-12" multiple>
            <option value="1" <?php if(in_array(1, explode(',', $show2->fg_type))) echo 'selected'; ?>>Acc</option>
            <option value="2" <?php if(in_array(2, explode(',', $show2->fg_type))) echo 'selected'; ?>>Cables</option>
            <option value="3" <?php if(in_array(3, explode(',', $show2->fg_type))) echo 'selected'; ?>>Esl</option>
            <option value="4" <?php if(in_array(4, explode(',', $show2->fg_type))) echo 'selected'; ?>>Poly</option>
            <option value="5" <?php if(in_array(5, explode(',', $show2->fg_type))) echo 'selected'; ?>>Fan</option>
            <option value="6" <?php if(in_array(6, explode(',', $show2->fg_type))) echo 'selected'; ?>>Light</option>
        </select>
    </div>
</div>-->


<div class="row mb-10 form-group">
<label class="control-label col-md-4 col-sm-6" for="">Geo Lock(1=Yes, 0=No)<span class="required"></span></label>
<div class="col-md-8 col-sm-6 col-xs-12">
    <select class="form-control col-md-12" name="geo_lock" required>
        <option><?=$show2->geo_lock?$show2->geo_lock:'0'?></option>
        <option value="1">1</option>
        <option value="0">0</option>
    </select>
</div>
</div>


<div class="row mb-10 form-group">
<label class="control-label col-md-4 col-sm-6" for="">Geo Range(Meter)<span class="required"></span></label>
<div class="col-md-8 col-sm-6 col-xs-12">
<input type="number" name="geo_lock_meter" required="required" value="<?=$show2->geo_lock_meter?>" class="form-control col-md-12">
</div>
</div>




	
<div class="row mb-10 form-group">
<label class="control-label col-md-4 col-sm-6" for="first-name">Status<span class="required"></span></label>
<div class="col-md-8 col-sm-6 col-xs-12">
    <select class="form-control col-md-12" name="status" required>
        <option><?=$show2->status?$show2->status:'Active'?></option>
        <option>Active</option>
        <option>Inactive</option>
    </select>
</div>
</div>


 



					  

<div class="form-group">
<div class="col-md-6 col-sm-6 col-md-offset-3"  style=" margin-left: 75px;">
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
        
        
        <div class="card card-primary">
              <div class="card-header p-0">
                <h3 align="center" class="n-form-titel1 mb-0">Update FO Link with Outlet</h3>
				
              </div>            
            
        <form class="mt-2 p-2" action="" method="post" data-parsley-validate >
           
        <div class="row mt-2 form-group">
        	<label class="control-label col-md-6 col-sm-6" for="first-name">Old Employee Code<span class="required"></span></label>
        	<div class="col-md-6 col-sm-6 col-xs-12">
        	<input type="text" name="old_fo" required="required" value=""
        	class="form-control col-md-12 col-xs-12">
        	</div>
        </div> 
        
        <div class="row form-group">
        	<label class="control-label col-md-6 col-sm-6" for="first-name">New Employee Code<span class="required"></span></label>
        	<div class="col-md-6 col-sm-6 col-xs-12">
        	<input class="col-md-12" type="text" name="new_fo" required="required" value="">
        	</div>
        </div>        
           
        <div class="ln_solid mt-2"></div>
        <div class="form-group">
        <div class="col-md-6 col-sm-6 col-md-offset-3" style=" margin-left: 30px;">
        <button name="update_fo" type="submit"  class="btn btn-success">Update FO Shop Only</button>

        </div>
        </div>
        </form>    
        </div>
        
        
        <div class="card card-primary">
              <div class="card-header p-0">
                <h3 align="center" class="n-form-titel1 mb-0">Update Dealer old to new</h3>
              </div>            
            
        <form class="mt-2 p-2" action="" method="post" data-parsley-validate class="form-horizontal form-label-left">
           
        <div class="row mb-10 form-group">
        	<label class="control-label col-md-6 col-sm-6" for="first-name">Old Party Code<span class="required"></span></label>
        	<div class="col-md-6 col-sm-6 col-xs-12">
        	<input class="col-md-12" type="text" name="old_party" required="required" value=""
        	class="form-control col-md-7 col-xs-12">
        	</div>
        </div> 
        
        <div class="row mb-10 form-group">
        	<label class="control-label col-md-6 col-sm-6" for="first-name">New Party Code<span class="required"></span></label>
        	<div class="col-md-6 col-sm-6 col-xs-12">
        	<input class="col-md-12" type="text" name="new_party" required="required" value=""
        	class="form-control col-md-7 col-xs-12">
        	</div>
        </div>        
           
        <div class="ln_solid mt-2"></div>
        <div class="form-group">
        <div class="col-md-6 col-sm-6 col-md-offset-3"  style=" margin-left: 60px;">
        <button name="update_dealer_all" type="submit"  class="btn btn-success">Update Dealer</button>

        </div>
        </div>
        </form>    
        </div>        
        
        
        
        
</div>




     <div class="col-md-8">

            <div class="card">
              <!--<div class="card-header">
                <h3 class="card-title">Information</h3>
              </div>-->
              <!-- /.card-header -->
              <div class="card-body p-2">
                <table id="do_datatable" class="table table-striped table-bordered table-hover table-sm" >
                    <thead class="thead1">
                    <tr  style="background-color: #3792cf !important; color: white !important;">
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
</script>