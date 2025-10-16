<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

include '../config/function.php';

$title='Field Force Information';	
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

    header('Location: so_list.php');
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
$show2 = findall($ss);
}
?>





  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
<!--            <h1 class="m-0">Field Force Information</h1>
-->          </div>
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
          <div class="col-md-4">
<form action="" method="post" id="demo-form2" data-parsley-validate class="n-form">
<?php $rand=rand(); $_SESSION['rand']=$rand; ?>
<input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
		  <h4 align="center" class="n-form-titel1 text-uppercase">Fill Up Below Information</h4>
		  

          <div class="form-group row m-0 pl-3 pr-3 p-1">
            <label class="col-sm-3 pl-0 pr-0 col-form-label" for="first-name">Employee Code</label>
            <div class="col-sm-9 p-0">
              <input type="text" name="username" required="required" value="<?=$show2->username?>"class="form-control">
            </div>
          </div>
		  
	<div class="form-group row m-0 pl-3 pr-3 p-1">
            <label class="col-sm-3 pl-0 pr-0 col-form-label" for="first-name">Passworde</label>
            <div class="col-sm-9 p-0">
			  <input type="text" name="password" required="required" value="<?=$show2->password?>" class="form-control">
            </div>
          </div>
		  
		  
	<div class="form-group row m-0 pl-3 pr-3 p-1">
            <label class="col-sm-3 pl-0 pr-0 col-form-label" for="first-name">Full Name</label>
            <div class="col-sm-9 p-0">
<input type="text" name="fname" required="required" value="<?=$show2->fname?>" class="form-control2">
            </div>
          </div>
		  
	<div class="form-group row m-0 pl-3 pr-3 p-1">
            <label class="col-sm-3 pl-0 pr-0 col-form-label" for="first-name">Mobile</label>
            <div class="col-sm-9 p-0">
<input type="text" name="mobile" required="required" value="<?=$show2->mobile?>" class="form-control">
            </div>
          </div>
		  
	<div class="form-group row m-0 pl-3 pr-3 p-1">
            <label class="col-sm-3 pl-0 pr-0 col-form-label" for="region_id">Region</label>
            <div class="col-sm-9 p-0">
    <select class="form-control" name="region_id" required id="region" onchange="FetchZone(this.value)">
        <option value="<?=$show2->region_id?>"><?=find1("select BRANCH_NAME from branch where BRANCH_ID='".$show2->region_id."'");?></option>
<? optionlist('select BRANCH_ID,BRANCH_NAME from branch where 1 order by BRANCH_NAME');?>
    </select>            
	</div>
          </div>

	<div class="form-group row m-0 pl-3 pr-3 p-1">
            <label class="col-sm-3 pl-0 pr-0 col-form-label" for="zone_id">Zone</label>
            <div class="col-sm-9 p-0">
<select class="form-control" name="zone_id" required id="zone" onchange="FetchArea(this.value)">
        <option value="<?=$show2->zone_id?>"><?=find1("select ZONE_NAME from zon where ZONE_CODE='".$show2->zone_id."'");?></option>
    </select>            </div>
          </div>		  
          

	<div class="form-group row m-0 pl-3 pr-3 p-1">
            <label class="col-sm-3 pl-0 pr-0 col-form-label" for="area_id">Area</label>
            <div class="col-sm-9 p-0">
 <select class="form-control" name="area_id" required id="area">
        <option value="<?=$show2->area_id?>"><?=find1("select AREA_NAME from area where AREA_CODE='".$show2->area_id."'");?></option>

    </select>
	          </div>
          </div>


	<div class="form-group row m-0 pl-3 pr-3 p-1">
            <label class="col-sm-3 pl-0 pr-0 col-form-label" for="">Dealer</label>
            <div class="col-sm-9 p-0">
<input type="number" name="dealer_code" required="required" value="<?=$show2->dealer_code?>" class="form-control">

	          </div>
          </div>




	<div class="form-group row m-0 pl-3 pr-3 p-1">
            <label class="col-sm-3 pl-0 pr-0 col-form-label" for="first-name">Status</label>
            <div class="col-sm-9 p-0">
    <select class="form-control" name="status" required>
        <option><?=$show2->status?$show2->status:'Active'?></option>
        <option>Active</option>
        <option>Inactive</option>
    </select>
	          </div>
          </div>



<div class="n-form-btn-class">
<? if($_GET['edit_id']>0){?>
<input name="update" type="submit" value="Update" class="btn1 btn1-bg-success">
<? }else{ ?>
<input name="new" type="submit" value="Create" class="btn1 btn1-bg-submit">
<? } ?>					                      
</div>


</form>

<br />


  <div>
		<form action="" method="post" data-parsley-validate class="n-form">			
<h4 align="center" class="n-form-titel1 text-uppercase">Update FO Link with Outlet</h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Old Employee Code</label>
                    <div class="col-sm-9 p-0">
					  <input type="text" name="old_fo" required="required" value=""	class="form-control">
                    </div>
                </div>
				
<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">New Employee Code</label>
                    <div class="col-sm-9 p-0">
  	<input type="text" name="old_fo" required="required" value="" class="form-control"> 
	                   </div>
                </div>


                <div class="n-form-btn-class">
				<input name="update_fo" type="submit" value="Update FO Link" class="btn1 btn1-bg-submit"> 					                      
                </div>
            </form>
        </div> 
		
<br />

<!--text-->


<div>
		<form action="" method="post" data-parsley-validate class="n-form">	
		
<h4 align="center" class="n-form-titel1 text-uppercase">Update Dealer old to new</h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="first-name" class="col-sm-3 pl-0 pr-0 col-form-label ">Old Party Code</label>
                    <div class="col-sm-9 p-0">
					  <input type="text" name="old_party" required="required" value=""	class="form-control">
                    </div>
                </div>
				
<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="first-name" class="col-sm-3 pl-0 pr-0 col-form-label">New Party Code</label>
                    <div class="col-sm-9 p-0">
<input  type="text" name="new_party" required="required" value="" 	class="form-control" />
			            </div>
                </div>


                <div class="n-form-btn-class">
				<input name="update_dealer_all" type="submit" value="Update Dealer" class="btn1 btn1-bg-submit"> 	
				                      
                </div>
            </form>
        </div>

                 
        
        
        
        
</div>




     <div class="col-md-8">
<div class="container"               
				<h4 align="center" class="n-form-titel1 text-uppercase">Information</h4>
				

              </div>

                <table class="table1 table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
                    <tr class="bgc-info">               
                      <th>ID</th>
                      <th>Username</th>
                      <th>Full Name</th>
                      <th>Area</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="tbody1">
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
	<a href="so_list.php?edit_id=<?=$data->user_id;?>" class="btn1 btn1-bg-update">Edit</a> || 
	<a href="so_list.php?delid=<?=$data->user_id;?>" onClick="return confirm('Do you want to delete')" class="btn1 btn1-bg-cancel">Delete</a>
					</td>
                    </tr>
<? } ?>                    
                  </tbody>
                </table>







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