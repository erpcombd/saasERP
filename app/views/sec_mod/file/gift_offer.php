<?php
session_start ();
include ("config/access_admin.php");
include ("config/db.php");
include 'config/function.php';


$today 			= date('Y-m-d');
$company_id     = $_SESSION['company_id'];
$menu 			= 'Product';
$sub_menu 		= 'gift_offer';




if(isset($_REQUEST['new']) && $_POST['randcheck']==$_SESSION['rand']){

  @insert('ss_gift_offer');
  $msg="New data insert successfully";
}


//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>0){	
//  $delid = $_REQUEST['delid'];
//  mysqli_query($conn, "delete from ss_gift_offer where id='".$delid."'");
//  $msg="Delete successfully";
//  redirect('gift_offer.php');
//}

if (isset($_REQUEST['delid']) && $_REQUEST['delid'] > 0) {
    $delid = $_REQUEST['delid'];

    // Prepare a SQL statement
    $stmt = $conn->prepare("DELETE FROM ss_gift_offer WHERE id = ?");
    
    // Bind the parameter
    $stmt->bind_param("i", $delid); // Assuming id is an integer.
    
    // Execute the statement
    if ($stmt->execute()) {
        $msg = "Deleted successfully";
    } else {
        $msg = "Error deleting record: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();

    // Redirect
    header('Location: gift_offer.php');
    exit();
}


if(isset($_POST['update'])){
  unset($_POST['update']);
  unset($_POST['randcheck']);
  update('ss_gift_offer','id="'.$_GET['edit_id'].'"');
  $msg= "Update successfully";
  redirect('gift_offer.php?edit_id='.$_GET['edit_id']);
}

if($_GET['edit_id']>0){
$ss="select * from ss_gift_offer where id='".$_GET['edit_id']."'";
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
            <h1 class="m-0">Gift Offer</h1>
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
          <div class="col-md-12">
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



<div class="row mb-2 form-group">
	
	
	<label class="control-label col-md-1" for="">Offer Name<span class="required"></span></label>
	<div class="col-md-2">
	<input class="form-control" type="text" name="offer_name" required="required" value="<?=$show2->offer_name?>" >
	</div>


<label class="control-label col-md-1" for="">Item<span class="required"></span></label>
	<div class="col-md-2">
        <input list="browsers" class="form-control" name="item_id" id="item_id" autocomplete="off" value="<?=$show2->item_id?>">
  <datalist id="browsers">
	<?php optionlist('select item_id,item_name from item_info where 1 and status=1 order by item_name');?>
  </datalist>
	</div>
	
<label class="control-label col-md-1" for="">Item Qty<span class="required"></span></label>
<div class="col-md-2"><input class="form-control" type="number" name="item_qty" required="required" value="<?=$show2->item_qty?>" ></div>

</div>


<div class="row mb-2 form-group">

<label class="control-label col-md-1" for="">MIN Qty<span class="required"></span></label>
<div class="col-md-2"><input class="form-control" type="number" name="min_qty" required="required" value="<?=$show2->min_qty?>" ></div>

<label class="control-label col-md-1" for="">MAX Qty<span class="required"></span></label>
<div class="col-md-2"><input class="form-control" type="number" name="max_qty" required="required" value="<?=$show2->max_qty?>" ></div>

</div>


<div class="row mb-2 form-group">

<label class="control-label col-md-1" for="">Gift Item<span class="required"></span></label>
	<div class="col-md-2">
        <input list="browsers2" class="form-control" name="gift_id" id="gift_id" autocomplete="off" value="<?=$show2->gift_id?>">
  <datalist id="browsers2">
	<?php optionlist('select item_id,item_name from item_info where 1 and status=1 order by item_name');?>
  </datalist>
	</div>
	
<label class="control-label col-md-1" for="">Gift Qty<span class="required"></span></label>
<div class="col-md-2"><input class="form-control" type="number" name="gift_qty" required="required" value="<?=$show2->gift_qty?>" ></div>    

 
<label class="control-label col-md-1" for="">Gift Calculation<span class="required"></span></label>
<div class="col-md-2">
    <select class="form-control" name="calculation" required="required">
        <option value="<?=$show2->calculation?>"><?=$show2->calculation?></option>
        <option>Auto</option>
        <option>Manual</option>
    </select>    
</div> 


<label class="control-label col-md-1" for="">Gift Type<span class="required"></span></label>
<div class="col-md-2">
    <select class="form-control" name="gift_type" required="required">
        <option value="<?=$show2->gift_type?>"><?=$show2->gift_type?></option>
        <option>Cash</option>
        <option>Non-Cash</option>
    </select>    
</div> 
  

</div>    
    			


<div class="row mb-2 form-group">

<label class="control-label col-md-1" for="">Start Date<span class="required"></span></label>
<div class="col-md-2"><input class="form-control" type="date" name="start_date" required="required" value="<?=$show2->start_date?>" ></div> 
	
<label class="control-label col-md-1" for="">End Date<span class="required"></span></label>
<div class="col-md-2"><input class="form-control" type="date" name="end_date" required="required" value="<?=$show2->end_date?>" ></div>    
    

<label class="control-label col-md-1" for="">Status<span class="required"></span></label>
<div class="col-md-2">
    <select class="form-control" name="status" required="required">
        <option value="<?=$show2->status?>"><?=$show2->status?></option>
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
</div>







     <div class="col-md-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
<!--offer_name,item_id,item_qty,min_qty,max_qty,gift_id,gift_qty,start_date,end_date,status,calculation,gift_type-->                    
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th>Offer Name</th>
                      <th>Item</th>
                      <th>Item Qty</th>
                      <th>Min Qty</th>
                      <th>Max Qty</th>
                      <th>Gift Item</th>
                      <th>Gift Qty</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Calculate</th>
                      <th>Gift Type</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      

<?php 
$sql = "select * from ss_gift_offer where 1 and status='Active'";
$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>                  	
                    <tr>
                      <td><?=++$a;?></td>
                      <td><?=$data->offer_name?></td>
                      <td><?=$data->item_id?></td>
                      <td><?=$data->item_qty?></td>
                      <td><?=$data->min_qty?></td>
                      <td><?=$data->max_qty?></td>
                      <td><?=$data->gift_id?></td>
                      <td><?=$data->gift_qty?></td>
                      <td><?=$data->start_date?></td>
                      <td><?=$data->end_date?></td>
                      <td><?=$data->calculation?></td>
                      <td><?=$data->gift_type?></td>
                      <td><?=$data->status?></td>
                      <td>
	<a href="gift_offer.php?edit_id=<?=$data->id;?>">Edit</a> || 
	<a href="gift_offer.php?delid=<?=$data->id;?>" onClick="return confirm('Do you want to delete')">Delete</a>
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