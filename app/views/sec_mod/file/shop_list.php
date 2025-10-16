<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";
include '../config/function.php';
do_datatable('do_datatable');
$title='Shop Information';	
$today 			  = date('Y-m-d');
$company_id   = $_SESSION['user']['company_id'];
$menu 			  = 'Setup';
$sub_menu 		= 'shop_list';



if(isset($_REQUEST['new']) && $_POST['randcheck']==$_SESSION['rand']){  

$_POST['master_dealer_code']= $_SESSION['warehouse_id']; 

  @insert('ss_shop');
  $msg="New data insert successfully";
}


//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>1){	
//  $delid = $_REQUEST['delid'];
//  mysqli_query($conn, "delete from ss_shop where dealer_code='".$delid."'");
//  $msg="Delete successfully";
//  redirect('shop_list.php');
//}
if (isset($_REQUEST['delid']) && $_REQUEST['delid'] > 1) {
    $delid = $_REQUEST['delid'];

    $stmt = $conn->prepare("DELETE FROM ss_shop WHERE dealer_code = ?");
    
    $stmt->bind_param("i", $delid);
    
    if ($stmt->execute()) {
        $msg = "Delete successfully";
    } else {
        $msg = "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
	redirect('shop_list.php');
    exit();
}


if(isset($_POST['update'])){
  unset($_POST['update']);
  unset($_POST['randcheck']);

  update('ss_shop','dealer_code="'.$_GET['edit_id'].'"');
  $msg= "Update successfully";
  redirect('shop_list.php?edit_id='.$_GET['edit_id']);
}

if($_GET['edit_id']){
$ss="select * from ss_shop where dealer_code='".$_GET['edit_id']."' ";
$show2 = findall($ss);
}
?>




  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-1">
          <!--<div class="col-sm-6">
            <h1 class="m-0">Shop</h1> <? if ($_SESSION['username']=='faruk'){?> <a href="shop_pic_compress.php" target="_blank">Pic Compress</a> <? } ?>
          </div>-->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><button type="button" class="btn btn-success btn-lg"><a href='shop_list.php'><span style="color:#FFFFFF">Add New</span></a></button> </li>
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
              <div class="card-header p-0">
              
					<h4 align="center" class="n-form-titel1 mb-0"> Fill Up Below Information</h4>
              </div>
              <!-- /.card-header -->



<!-- form start -->
<div class="card-body">              
<form action="" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
<?php $rand=rand(); $_SESSION['rand']=$rand; ?>
<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />

	

<div class="row mb-10 form-group">
<label class="control-label col-md-4 col-sm-6" for="first-name">Shop Name<span class="required"></span></label>
<div class="col-md-8 col-sm-6 col-xs-12">
<input type="text" name="shop_name" required="required" value="<?=$show2->shop_name?>" class="form-control col-md-12" autocomplete="off">
</div></div>

<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="address_e">Market name<span class="required"></span></label>
<div class="col-md-8">
<input type="text" name="shop_address" required="required" value="<?=$show2->shop_address?>" class="form-control col-md-12">
</div></div>

<div class="row mb-10 form-group">
<label class="control-label col-md-4 col-sm-6" for="first-name">Owner Name<span class="required"></span></label>
<div class="col-md-8 col-sm-6 col-xs-12">
<input type="text" name="shop_owner_name" required="required" value="<?=$show2->shop_owner_name?>" class="form-control col-md-12" autocomplete="off">
</div></div>

<div class="row mb-10 form-group">
<label class="control-label col-md-4 col-sm-6" for="first-name">Mobile<span class="required"></span></label>
<div class="col-md-8 col-sm-6 col-xs-12">
<input type="text" name="mobile" required="required" value="<?=$show2->mobile?$show2->mobile:8801?>" class="form-control col-md-12">
</div></div>

<!--<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="first-name">Manager Name<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="manager_name" required="required" value="<?=$show2->manager_name?>" class="form-control col-md-12" autocomplete="off">
</div></div>-->

<!--<div class="row mb-10 form-group">
<label class="control-label col-md-6 col-sm-6" for="first-name">Manager Mobile<span class="required"></span></label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" name="manager_mobile" required="required" value="<?=$show2->manager_mobile?$show2->manager_mobile:8801?>" class="form-control col-md-12">
</div></div>-->




<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="region_id">Zone<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="region_id" required id="region" onchange="FetchZone(this.value)">
        <option value="<?=$show2->region_id?>"><?=find1("select BRANCH_NAME from branch where BRANCH_ID='".$show2->region_id."'");?></option>
<? optionlist('select BRANCH_ID,BRANCH_NAME from branch where 1 order by BRANCH_NAME');?>
    </select>
</div></div>

<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="zone_id">Territory<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="zone_id" required id="zone" onchange="FetchArea(this.value)">
        <option value="<?=$show2->zone_id?>"><?=find1("select ZONE_NAME from zon where ZONE_CODE='".$show2->zone_id."'");?></option>
    </select>
</div></div>


<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="area_id">Route name<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="area_id" required id="area" onchange="FetchRoute(this.value)">
        <option value="<?=$show2->area_id?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$show2->area_id."'");?></option>
    </select>
</div></div>


<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="">Route Points<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="route_id" required id="route">
        <option value="<?=$show2->route_id?>"><?=find1("select route_name from ss_route where route_id='".$show2->route_id."'");?></option>
    </select>
</div></div>


<!--<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="">Shop Identity<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="shop_identity">
        <option><?=$show2->shop_identity?$show2->shop_identity:'Other'?></option>
        <option>MEP</option><option>Other</option>

    </select>
</div></div>-->


<!--<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="">Shop Class<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="shop_class">
        <option><?=$show2->shop_class?></option>
        <option>Gold 50000 to 100000</option>
        <option>Diamond 100000 to 150000</option>
        <option>Silver 25000 to 50000</option>
        <option>Platinum Plus 200000 to above</option>
        <option>Bronze 1 to 25000</option>
        <option>Platinum 150000 to 200000</option>
    </select>
</div></div>-->


<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="">Shop Type<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="shop_type">
        <option><?=$show2->shop_type?></option>
        <option>Retailer</option>
        <option>WholeSale</option>
        <option>Semi WholeSaler</option>
    </select>
</div></div>


<!--<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="">Shop Channel<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="shop_channel">
        <option><?=$show2->shop_channel?></option>
        <option>Electric</option>
        <option>Electronics</option>
        <option>Stationary</option>
        <option>Departmental Store</option>
        <option>Grosary </option>
        <option>Hardware</option>
        <option>Library</option>
        <option>Pharmacy</option>
    </select>
</div></div>-->


<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="">Shop Route Type<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="shop_route_type">
        <option><?=$show2->shop_route_type?></option>
        <option>Bazar</option>
        <option>Outsite  Bazar</option>
    </select>
</div></div>




<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="address_e">GPS Location</label>
<div class="col-md-4"><input type="text" name="latitude" value="<?=$show2->latitude?>" class="form-control col-md-12"></div>
<div class="col-md-4"><input type="text" name="longitude" value="<?=$show2->longitude?>" class="form-control col-md-12"></div>
</div>


<div class="row mb-10 form-group">
<label class="control-label col-md-4 col-sm-6" for="first-name">SP CODE<span class="required"></span></label>
<div class="col-md-8 col-sm-6 col-xs-12">
<input type="text" name="emp_code" required="required" value="<?=$show2->emp_code?>" class="form-control col-md-12" autocomplete="off">
</div></div>


	
<div class="row mb-10 form-group">
<label class="control-label col-md-4" for="first-name">Status<span class="required"></span></label>
<div class="col-md-8">
    <select class="form-control col-md-12" name="status" required>
        <option value="<?=$show2->status?>"><? if($show2->status==1) echo 'Active'; else echo 'Inactive';?></option>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select>
</div>
</div>


 



					  

<div class="form-group">
<div class="col-md-6 col-sm-6 " style=" margin-left: 75px;">
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





<?
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

// route list
$sql='select route_id,route_name from ss_route';
$query = mysqli_query($conn,$sql);
while($info = mysqli_fetch_object($query)){$route_info[$info->route_id] = $info->route_name;}




?>

<div class="col-md-8">
         
         
<!--<form action="" method="post"> 
<div class="row">
    
<div class="col-md-3 form-group"><label>Division</label>
    <select class="form-control col-md-12" name="zone_id" required id="zone2" onchange="FetchArea2(this.value)">
        <option value="<?=$_POST['zone_id'];?>"><?=$zone_info[$_POST['zone_id']];?></option>
        <? optionlist("select ZONE_CODE,ZONE_NAME from zon where 1 order by REGION_ID,ZONE_NAME");?></option>
    </select>
</div>
    

<div class="col-md-3 form-group"><label>Territory</label>
    <select class="form-control col-md-12" name="area_id"  id="area2" onchange="FetchRoute2(this.value)">
        <option value="<?=$_POST['area_id'];?>"><?=$area_info[$_POST['area_id']];?></option>
        <? optionlist("select AREA_CODE,AREA_NAME from area where 1 order by ZONE_ID,AREA_NAME");?></option>
    </select>
</div>

<div class="col-md-3 form-group"><label>Route</label>
    <select class="form-control col-md-12" name="route_id"  id="route2">
        <option value="<?=$_POST['route_id'];?>"><?=$route_info[$_POST['route_id']];?></option>
        <? optionlist("select route_id,route_name from ss_route where 1 order by area_id,route_name");?></option>
    </select>
</div>

    
    <div class="col-md-1 form-group position-relative">
        <button type="submit" name="view" id="view" class="btn btn-success position-absolute top-50 end-0 translate-middle" style="margin-top: 30px;">Search</button>
    </div> 


</div>

</form>-->         

            <div class="card">
              <!--<div class="card-header p-0">
                <h3 align="center" class="n-form-titel1 mb-0">Shop Information</h3>
				
              </div>-->
              <!-- /.card-header -->
              <div class="card-body p-2">
                <table class="table table-striped table-bordered table-hover table-sm" id="do_datatable">
                    <thead class="thead1">
                    <tr  style="background-color: #3792cf !important; color: white !important;">
                      <th>Code</th>
                      <th>Shop Name</th>
                      <th>Mobile</th>
                      <th>Area</th>
					  <!--<th>Image</th>-->
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
<?php 


$location='';
if($_POST['zone_id']!='') $location.=' and zone_id="'.$_POST['zone_id'].'"';
if($_POST['area_id']!='') $location.=' and area_id="'.$_POST['area_id'].'"';
if($_POST['route_id']!='') $location.=' and route_id="'.$_POST['route_id'].'"';



if(isset($_POST['view'])){
$sql = "select * from ss_shop where 1 ".$location." order by dealer_code";
}else{
$sql = "select * from ss_shop where 1 order by dealer_code desc limit 20";    
}
$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>                  	
                    <tr>
                      <td><?=$data->dealer_code?></td>
                      <td><?=$data->shop_name?></td>
                      <td><?=$data->mobile?></td>
                      <td>SO CODE: <? echo $data->emp_code;?><br><? echo $region_info[$data->region_id];?>-<? echo $zone_info[$data->zone_id];?>-<? echo $area_info[$data->area_id];?>
                      </td>
<?php /*?><td>
<? if($data->picture!=''){ ?>
<a href="shop_pic_view.php?pic=<?=$data->picture?>" target="_blank">View</a>
<? } ?>
<br>
<a href="shop_pic_update.php?id=<?=$data->dealer_code?>" target="_blank">Update</a>
</td><?php */?>
                      <td>
	<a href="shop_list.php?edit_id=<?=$data->dealer_code;?>">Edit</a> || 
	<a href="shop_list.php?delid=<?=$data->dealer_code;?>" onClick="return confirm('Do you want to delete')">Delete</a>
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
  
  
  function FetchArea2(id){
    $('#area2').html('');
    $('#route2').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { zone_id : id},
      success : function(data){
         $('#area2').html(data);
      }

    })
  }  
  
    function FetchRoute2(id){
    $('#route2').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { area_id : id},
      success : function(data){
         $('#route2').html(data);
      }

    })
  }  
  
  
  
  

</script>