<?php
session_start ();
include ("config/access_admin.php");
include ("config/db.php");
include 'config/function.php';


$today 			= date('Y-m-d');
$company_id   	= $_SESSION['company_id'];
$menu 			= 'Product';
$sub_menu 		= 'item_info';




//if(isset($_REQUEST['delid']) && $_REQUEST['delid']>1){	
//  $delid = $_REQUEST['delid'];
//  mysqli_query($conn, "delete from item_info where item_id='".$delid."'");
//  $msg="Delete successfully";
//  redirect('item_info.php');
//}
if (isset($_REQUEST['delid']) && $_REQUEST['delid'] > 1) {
    $delid = $_REQUEST['delid'];

    // Prepare a SQL statement
    $stmt = $conn->prepare("DELETE FROM item_info WHERE item_id = ?");
    
    // Bind the parameter
    $stmt->bind_param("i", $delid); // Assuming item_id is an integer.
    
    // Execute the statement
    if ($stmt->execute()) {
        $msg = "Deleted successfully";
    } else {
        $msg = "Error deleting record: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();

    // Redirect
    header('Location: item_info.php');
    exit();
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
            <h1 class="m-0">Product List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><button type="button" class="btn btn-success btn-lg"><a href='item_manage.php'><span style="color:#FFFFFF">Add Product</span></a></button> </li>
            </ol>
          </div>

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


<!-- Main content -->
<section class="content">
<div class="container-fluid">




            
             

<div class="card mb-4">
<div class="card-body">


<form action="" method="post"> 
<div class="row">
    
<div class="col-md-4 form-group"><label>Group</label>
		<select class=" form-control border border-info" name="item_group" required id="item_group" onchange="FetchItemCategory(this.value)">
		<? if($_POST['item_group']>0){ ?>		    
				    <option value="<?php echo $_POST['item_group']?>"><?=find1("select group_name from product_group where id='".$_POST['item_group']."'");?></option>
		<? }else{ ?>		    
				    <option></option> 
		<? } ?>		  
				    <?php optionlist("select id,group_name from product_group where 1 order by group_name"); ?>
		</select>
</div>
    

<div class="col-md-2 form-group"><label>Category</label>
		<select class=" form-control border border-info" name="category_id" id="category_id" onchange="FetchItemSubcategory(this.value)">
		<? if($_POST['category_id']>0){ ?>		    
				    <option value="<?php echo $_POST['category_id']?>"><?=find1("select category_name from item_category where id='".$_POST['category_id']."'");?></option>
		<? }else{ ?>		    
				    <option></option>
		<? } ?>		  
				    <?php optionlist("select id,category_name from item_category where 1 order by category_name"); ?>
		</select>
</div>

<div class="col-md-2 form-group"><label>Sub Category</label>
		<select class=" form-control border border-info" name="subcategory_id" id="subcategory_id">
		<? if($_POST['subcategory_id']>0){ ?>		    
				    <option value="<?php echo $_POST['subcategory_id']?>"><?=find1("select subcategory_name from item_subcategory where id='".$_POST['subcategory_id']."'");?></option>
		<? }else{ ?>		    
				    <option></option>
		<? } ?>		  
				    <?php optionlist("select id,subcategory_name from item_subcategory where 1 order by subcategory_name"); ?>
		</select>
</div>

    
    <div class="col-md-2 form-group position-relative">
        <button type="submit" name="view" id="view" class="btn btn-success position-absolute top-50 end-0 translate-middle">Search</button>
    </div> 


</div><!--END ROW-->

</form>






<div class="row">
<div class="col-md-12 col-xs-12">
<div class="x_panel">
<div class="x_title"><div class="clearfix"></div></div>
<div class="x_content">
                     

<?php
$condition='';
$condition1='';
if($_SESSION['level']==1){
	$condition=" and product.added_by='".$_SESSION['username']."'";
	$condition1=" and added_by='".$_SESSION['username']."'";
}

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($conn,$_GET['type']);
	if($type=='status'){
		$operation=get_safe_value($conn,$_GET['operation']);
		$id=get_safe_value($conn,$_GET['id']);
		if($operation=='active'){
			$status='1';
		}else{
			$status='0';
		}
		$update_status_sql="update product set status='$status' $condition1 where id='$id'";
		mysqli_query($conn,$update_status_sql);
	}
	
	if($type=='delete'){
		$id=get_safe_value($conn,$_GET['id']);
		$delete_sql="delete from product where id='$id' $condition1";
		mysqli_query($conn,$delete_sql);
		// image delete pending
	}
}


$sql_cat="select id,categories from categories where 1";
$query=mysqli_query($conn,$sql_cat);
while($info=mysqli_fetch_object($query)){
    $cat_name[$info->id]=$info->categories;
}



if(isset($_POST['view'])){
    
    
if($_POST['item_group']!=''){ $item_group = $_POST['item_group'];
    $item_group_con=" and item_group='".$item_group."'";
}

if($_POST['category_id']!=''){ $category_id = $_POST['category_id'];
    $category_id_con=" and category_id='".$category_id."'";
}

if($_POST['subcategory_id']!=''){ $subcategory_id = $_POST['subcategory_id'];
    $subcategory_id_con=" and subcategory_id='".$subcategory_id."'";
}



$sql="select p.* from item_info p where 1 ".$item_group_con.$category_id_con.$subcategory_id_con." order by p.item_name";
}else{
$sql="select p.* from item_info p where 1 order by item_id desc limit 20";   
}

?>



<table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">
	  <thead>
							<tr>
							   <th>ID</th>
							   <th>Product Code</th>
							   <th>Name</th>
							   <th>MRP</th>
							   <th>T Price</th>
							   <th></th>
							</tr>
	  </thead>
	  <tbody>
			<?php 
			$i=1;
            $res=mysqli_query($conn,$sql);
			while($row=mysqli_fetch_assoc($res)){
			    
			?>
			<tr>
			   <td><?php echo $row['item_id']?></td>
			   <td><?php echo $row['finish_goods_code']?></td>
			   <td><?php echo $row['item_name']?></td>
			   <td><?php echo $row['m_price']?></td>
			   <td><?php echo $row['t_price']?></td>
<td>
    
    
<?php if($row['status']==1){ ?>

<!-- <span id="item_status_<?=$row['id']?>">
<input name="status" type="button" value="Active" class="btn btn-success"  onclick="update_itemstatus(<?=$row['id']?>)">
</span> -->

<? }else{ ?>
<!-- <span id="item_status_<?=$row['id']?>">
<input name="status" type="button" value="Deactive" class="btn btn-warning"  onclick="update_itemstatus(<?=$row['id']?>)">
</span> -->

<? } ?>
&nbsp;<a class="btn btn-round btn-info btn-sm" href='item_manage.php?id=<?php echo $row['item_id'];?>'>Edit</a>
&nbsp;<a class="btn btn-round btn-danger btn-sm" href='?type=delete&delid=<?php echo $row['item_id'];?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a>


</td>
</tr>
<?php } ?>
  </tbody>
</table>


</div></div></div></div>


</div></div>			
<!-- /end Body page -->
			
			








      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 


<?php
include 'inc/footer.php';
?>  

<script type="text/javascript">
  function FetchItemCategory(id){
    $('#category_id').html('');
    $('#subcategory_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { item_group : id},
      success : function(data){
         $('#category_id').html(data);
      }

    })
  }

  function FetchItemSubcategory(id){
    $('#subcategory_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { category_id : id},
      success : function(data){
         $('#subcategory_id').html(data);
      }

    })
  }

</script>