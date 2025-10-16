<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";
include '../config/function.php';

$title='Shop Information';	
$today 			  = date('Y-m-d');
$company_id   = $_SESSION['company_id'];
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

    header('Location: shop_list.php');
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
<!--start here-->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
<!--            <h1 class="m-0">Shop Information</h1>           </div>
-->          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><button type="button" class="btn btn-success btn-lg"><a href="shop_list.php"><span style="color:#FFFFFF">Add New</span></a></button> </li>
            </ol>
          </div>

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>



<div class="container-fluid ">
  <div class="row">
    <div class="col-md-4 n-form1">
      <form action="" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
        <?php $rand=rand(); $_SESSION['rand']=$rand; ?>
        <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
        <div class="form-group row m-0 pl-3 pr-3 p-1">
          <label class="control-label col-md-4" for="group_name">Shop name<span class="required"></span></label>
          <div class="col-md-8">
            <input type="text" name="shop_name" required="required" value="<?=$show2->shop_name?>" class="form-control col-md-12" autocomplete="off">
          </div>
        </div>
        <div class="form-group row m-0 pl-3 pr-3 p-1">
          <label class="control-label col-md-4" for="group_name">Market name<span class="required"></span></label>
          <div class="col-md-8">
            <input type="text" name="shop_address" required="required" value="<?=$show2->shop_address?>" class="form-control col-md-12">
          </div>
        </div>
        <div class="form-group row m-0 pl-3 pr-3 p-1">
          <label class="control-label col-md-4" for="group_name">Owner Name<span class="required"></span></label>
          <div class="col-md-8">
            <input type="text" name="shop_owner_name" required="required" value="<?=$show2->shop_owner_name?>" class="form-control col-md-12" autocomplete="off">
          </div>
        </div>
        <div class="form-group row m-0 pl-3 pr-3 p-1">
          <label class="control-label col-md-4" for="group_name">Mobile<span class="required"></span></label>
          <div class="col-md-8">
            <input type="text" name="mobile" required="required" value="<?=$show2->mobile?$show2->mobile:8801?>" class="form-control col-md-12">
          </div>
        </div>
        <div class="form-group row m-0 pl-3 pr-3 p-1">
          <label class="control-label col-md-4" for="group_name">Zone<span class="required"></span></label>
          <div class="col-md-8">
            <select class="form-control col-md-12" name="region_id" required id="region" onchange="FetchZone(this.value)">
              <option value="<?=$show2->region_id?>">
              <?=find1("select BRANCH_NAME from branch where BRANCH_ID='".$show2->region_id."'");?>
              </option>
              <? optionlist('select BRANCH_ID,BRANCH_NAME from branch where 1 order by BRANCH_NAME');?>
            </select>
          </div>
        </div>
        <div class="form-group row m-0 pl-3 pr-3 p-1">
          <label class="control-label col-md-4" for="group_name">Division<span class="required"></span></label>
          <div class="col-md-8">
            <select class="form-control col-md-12" name="zone_id" required id="zone" onchange="FetchArea(this.value)">
              <option value="<?=$show2->zone_id?>">
              <?=find1("select ZONE_NAME from zon where ZONE_CODE='".$show2->zone_id."'");?>
              </option>
            </select>
          </div>
        </div>
        <div class="form-group row m-0 pl-3 pr-3 p-1">
          <label class="control-label col-md-4" for="group_name">Territory<span class="required"></span></label>
          <div class="col-md-8">
            <select class="form-control col-md-12" name="area_id" required id="area" onchange="FetchRoute(this.value)">
              <option value="<?=$show2->area_id?>">
              <?=find1("select AREA_NAME from area where AREA_CODE='".$show2->area_id."'");?>
              </option>
            </select>
          </div>
        </div>
        <div class="form-group row m-0 pl-3 pr-3 p-1">
          <label class="control-label col-md-4" for="group_name">Route<span class="required"></span></label>
          <div class="col-md-8">
            <select class="form-control col-md-12" name="route_id" required id="route">
              <option value="<?=$show2->route_id?>">
              <?=find1("select route_name from ss_route where route_id='".$show2->route_id."'");?>
              </option>
            </select>
          </div>
        </div>
        <div class="form-group row m-0 pl-3 pr-3 p-1">
          <label class="control-label col-md-4" for="group_name">Shop Type<span class="required"></span></label>
          <div class="col-md-8">
            <select class="form-control col-md-12" name="shop_type">
              <option>
              <?=$show2->shop_type?>
              </option>
              <option>Retailer</option>
              <option>WholeSale</option>
              <option>Semi WholeSaler</option>
            </select>
          </div>
        </div>
        <div class="form-group row m-0 pl-3 pr-3 p-1">
          <label class="control-label col-md-4" for="group_name">Shop Route Type<span class="required"></span></label>
          <div class="col-md-8">
            <select class="form-control col-md-12" name="shop_route_type">
              <option>
              <?=$show2->shop_route_type?>
              </option>
              <option>Bazar</option>
              <option>Outsite  Bazar</option>
            </select>
          </div>
        </div>
        <div class="form-group row m-0 pl-3 pr-3 p-1">
          <label class="control-label col-md-4" for="group_name">GPS Location<span class="required"></span></label>
          <div class="row col-md-8">
            <div class="col-md-6">
              <input type="text" name="latitude" value="<?=$show2->latitude?>" class="form-control col-md-12">
            </div>
            <div class="col-md-6">
              <input type="text" name="longitude" value="<?=$show2->longitude?>" class="form-control col-md-12">
            </div>
          </div>
        </div>
        <div class="form-group row m-0 pl-3 pr-3 p-1">
          <label class="control-label col-md-4" for="group_name">SO CODE<span class="required"></span></label>
          <div class="col-md-8">
            <input type="text" name="emp_code" required="required" value="<?=$show2->emp_code?>" class="form-control col-md-12" autocomplete="off">
          </div>
        </div>
        <div class="form-group row m-0 pl-3 pr-3 p-1">
          <label class="control-label col-md-4" for="group_name">Status<span class="required"></span></label>
          <div class="col-md-8">
            <select class="form-control col-md-6" name="status" required>
              <option value="<?=$show2->status?>">
              <? if($show2->status==1) echo 'Active'; else echo 'Inactive';?>
              </option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="n-form-btn-class">
            <? if($_GET['edit_id']>0){?>
            <button name="update" type="submit"  class="btn btn-success">Update</button>
            <? }else{ ?>
            <button name="new" type="submit"  class="btn btn-success">Create</button>
            <? } ?>
          </div>
        </div>
      </form>
    </div>
	
	
	 
    <div class="col-md-8">	
	<form action="" method="post">     
	<div class="row bg-form-titel">
        <div class="col-md-3 form-group">
          <label>Division</label>
          <select class="form-control col-md-12" name="zone_id" required id="zone2" onchange="FetchArea2(this.value)">
            <option value="<?=$_POST['zone_id'];?>">
            <?=$zone_info[$_POST['zone_id']];?>
            </option>
            <? optionlist("select ZONE_CODE,ZONE_NAME from zon where 1 order by REGION_ID,ZONE_NAME");?>
            </option>
          </select>
        </div>
        <div class="col-md-3 form-group">
          <label>Territory</label>
          <select class="form-control col-md-12" name="area_id"  id="area2" onchange="FetchRoute2(this.value)">
            <option value="<?=$_POST['area_id'];?>">
            <?=$area_info[$_POST['area_id']];?>
            </option>
            <? optionlist("select AREA_CODE,AREA_NAME from area where 1 order by ZONE_ID,AREA_NAME");?>
            </option>
          </select>
        </div>
        <div class="col-md-3 form-group">
          <label>Route</label>
          <select class="form-control col-md-12" name="route_id"  id="route2">
            <option value="<?=$_POST['route_id'];?>">
            <?=$route_info[$_POST['route_id']];?>
            </option>
            <? optionlist("select route_id,route_name from ss_route where 1 order by area_id,route_name");?>
            </option>
          </select>
        </div>
        <div class="col-md-3 form-group d-flex justify-content-center align-items-center">
          <button type="submit" name="view" id="view" class="btn btn-success">Search</button>
        </div>     
	      </div>
		   </form>

      <br />
      <br />
	  
      <div class="container n-form1">
        <div class="card-header n-form-titel1">
          <h4 align="center">Shop Information</h4>
        </div>
        <table class="table1  table-striped table-bordered table-hover table-sm">
          <thead class="thead1">
            <tr class="bgc-info">
              <th>Code</th>
              <th>Shop Name</th>
              <th>Mobile</th>
              <th>Area</th>
              <th>Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="tbody1">
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
              <td>SO CODE: <? echo $data->emp_code;?><br>
                <? echo $region_info[$data->region_id];?>-<? echo $zone_info[$data->zone_id];?>-<? echo $area_info[$data->area_id];?> </td>
              <td><? if($data->picture!=''){ ?>
                <a href="shop_pic_view.php?pic=<?=$data->picture?>" target="_blank">View</a>
                <? } ?>
                <br>
                <a href="shop_pic_update.php?id=<?=$data->dealer_code?>" target="_blank">Update</a> </td>
              <td><a href="shop_list.php?edit_id=<?=$data->dealer_code;?>" class="btn1 btn1-bg-update">Edit</a> || <a href="shop_list.php?delid=<?=$data->dealer_code;?>" onClick="return confirm('Do you want to delete')" class="btn1 btn1-bg-cancel">Delete</a> </td>
            </tr>
            <? } ?>
          </tbody>
        </table> 
      </div>
    </div>
  </div>
</div>
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
