<?php
session_start ();
include ("config/access_admin.php");
include ("config/db.php");
include 'config/function.php';


$today 			= date('Y-m-d');
$company_id   	= $_SESSION['company_id'];
$menu 			= 'Product';
$sub_menu 		= 'item_info';



$sub_group_id			='';
$finish_goods_code		='';
$item_name				='';
$unit_name				='';
$pack_size				='';
$item_brand				='';
$m_price				='';
$d_price				='';
$t_price				='';
$nsp_per				='';
$f_price				='';

$item_group		        ='';
$category_id		    ='';
$subcategory_id		    ='';

$consumable_type		='';
$product_nature			='';		
$status					='';

$msg='';
$image_required='required';


//if(isset($_GET['id']) && $_GET['id']!=''){
//	$image_required='';
//	$id=get_safe_value($conn,$_GET['id']);
//
//	$res=mysqli_query($conn,"select * from item_info where item_id='$id' ");
//	$check=mysqli_num_rows($res);
//
//if($check>0){
//$row=mysqli_fetch_assoc($res);
//
//$sub_group_id					=$row['sub_group_id'];
//$finish_goods_code		        =$row['finish_goods_code'];
//$item_name						=$row['item_name'];
//$unit_name						=$row['unit_name'];
//$pack_size						=$row['pack_size'];
//$item_brand						=$row['item_brand'];
//$m_price							=$row['m_price'];
//$d_price							=$row['d_price'];
//$t_price							=$row['t_price'];
//$nsp_per							=$row['nsp_per'];
//$f_price							=$row['f_price'];
//$item_group			            =$row['item_group'];
//$category_id			            =$row['category_id'];
//$subcategory_id			            =$row['subcategory_id'];
//
//$consumable_type			=$row['consumable_type'];
//$product_nature				=$row['product_nature'];		
//$status								=$row['status'];
//		
//		$image					=$row['image'];
///*		$image2=$row['image2'];
//		$image3=$row['image3'];
//		$image4=$row['image4'];*/
//	}else{
//?>
//<script>
//window.location.href = "item_info.php";
//</script>
//<?php
//		die();
//	}

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($conn, $_GET['id']);

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM item_info WHERE item_id = ?");
    // Bind the parameter
    $stmt->bind_param("i", $id); // Assuming item_id is an integer.
    // Execute the statement
    $stmt->execute();
    // Get the result
    $result = $stmt->get_result();
    $check = $result->num_rows;

    if ($check > 0) {
        $row = $result->fetch_assoc();

        $sub_group_id = $row['sub_group_id'];
        $finish_goods_code = $row['finish_goods_code'];
        $item_name = $row['item_name'];
        $unit_name = $row['unit_name'];
        $pack_size = $row['pack_size'];
        $item_brand = $row['item_brand'];
        $m_price = $row['m_price'];
        $d_price = $row['d_price'];
        $t_price = $row['t_price'];
        $nsp_per = $row['nsp_per'];
        $f_price = $row['f_price'];
        $item_group = $row['item_group'];
        $category_id = $row['category_id'];
        $subcategory_id = $row['subcategory_id'];
        $consumable_type = $row['consumable_type'];
        $product_nature = $row['product_nature'];
        $status = $row['status'];
        $image = $row['image'];
        // $image2 = $row['image2'];
        // $image3 = $row['image3'];
        // $image4 = $row['image4'];
    } else {
        ?>
        <script>
        window.location.href = "item_info.php";
        </script>
        <?php
        die();
    }

    // Close the statement
    $stmt->close();


}







if(isset($_POST['submit'])){


$sub_group_id					=get_safe_value($conn,$_POST['sub_group_id']);
$finish_goods_code		        =get_safe_value($conn,$_POST['finish_goods_code']);
$item_name						=get_safe_value($conn,$_POST['item_name']);
$unit_name						=get_safe_value($conn,$_POST['unit_name']);
$pack_size						=get_safe_value($conn,$_POST['pack_size']);
$item_brand						=get_safe_value($conn,$_POST['item_brand']);
$m_price						=get_safe_value($conn,$_POST['m_price']);
$d_price						=get_safe_value($conn,$_POST['d_price']);
$t_price						=get_safe_value($conn,$_POST['t_price']);
$nsp_per						=get_safe_value($conn,$_POST['nsp_per']);
$f_price						=get_safe_value($conn,$_POST['f_price']);
$item_group			            =get_safe_value($conn,$_POST['item_group']);
$category_id			        =get_safe_value($conn,$_POST['category_id']);
$subcategory_id			        =get_safe_value($conn,$_POST['subcategory_id']);

$consumable_type			       ='Consumable';
$product_nature				       ='Salable';	
$status							=get_safe_value($conn,$_POST['status']);




//$res=mysqli_query($conn,"select * from item_info where item_name='".$item_name."' ");
//	$check=mysqli_num_rows($res);
//	if($check>0){
//		if(isset($_GET['id']) && $_GET['id']!=''){
//			$getData=mysqli_fetch_assoc($res);
//			if($id==$getData['item_id']){
//			
//			}else{
//				$msg="Product code exist";
//			}
//		}else{
//			$msg="Product code exist in Item Info";
//		}

// Assume $item_name is already sanitized
$item_name = get_safe_value($conn, $_POST['item_name']); // Or wherever $item_name is coming from

// Prepare the SQL statement
$stmt = $conn->prepare("SELECT * FROM item_info WHERE item_name = ?");
$stmt->bind_param("s", $item_name);
$stmt->execute();
$result = $stmt->get_result();
$check = $result->num_rows;

if ($check > 0) {
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $id = get_safe_value($conn, $_GET['id']); // Sanitize the id from GET parameter
        $getData = $result->fetch_assoc();
        if ($id != $getData['item_id']) {
            $msg = "Product code exists";
        }
    } else {
        $msg = "Product code exists in Item Info";
    }
}

// Close the statement
$stmt->close();

	
	
	// if(isset($_GET['id']) && $_GET['id']==0){
	// 	if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
	// 		$msg="Please select only png,jpg and jpeg image formate";
	// 	}elseif($_FILES['image2']['type']!='image/png' && $_FILES['image2']['type']!='image/jpg' && $_FILES['image2']['type']!='image/jpeg'){
	// 		$msg="Please select only png,jpg and jpeg image formate";
	// 	}elseif($_FILES['image3']['type']!='image/png' && $_FILES['image3']['type']!='image/jpg' && $_FILES['image3']['type']!='image/jpeg'){
	// 		$msg="Please select only png,jpg and jpeg image formate";
	// 	}elseif($_FILES['image4']['type']!='image/png' && $_FILES['image4']['type']!='image/jpg' && $_FILES['image4']['type']!='image/jpeg'){
	// 		$msg="Please select only png,jpg and jpeg image formate";
	// 	}
	// }
	
	if($msg==''){
		if(isset($_GET['id']) && $_GET['id']!=''){
			
			
// update			
// if($_FILES['image']['name']!=''){
// 	$image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
// 	move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
// 	$image_con=",image='$image'";
// }

/*if($_FILES['image2']['name']!=''){
	$image2=rand(111111111,999999999).'_'.$_FILES['image2']['name'];
	move_uploaded_file($_FILES['image2']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image2);
	$image_con.=",image2='$image2'";
}
if($_FILES['image3']['name']!=''){
	$image3=rand(111111111,999999999).'_'.$_FILES['image3']['name'];
	move_uploaded_file($_FILES['image3']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image3);
	$image_con.=",image3='$image3'";
}
if($_FILES['image4']['name']!=''){
	$image4=rand(111111111,999999999).'_'.$_FILES['image4']['name'];
	move_uploaded_file($_FILES['image4']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image4);
	$image_con.=",image4='$image4'";
}*/

				
$update_sql="update item_info set 
sub_group_id='$sub_group_id',
finish_goods_code='$finish_goods_code',
item_name='$item_name',
unit_name='$unit_name',
pack_size='$pack_size',
item_brand='$item_brand',
m_price='$m_price',
d_price='$d_price',
t_price='$t_price',
nsp_per='$nsp_per',
f_price='$f_price',
item_group='$item_group',
category_id='$category_id',
subcategory_id='$subcategory_id',
consumable_type='$consumable_type',
product_nature='$product_nature',
status='$status' 

where item_id='$id'";

mysqli_query($conn,$update_sql);

?>
<script>
window.location.href = "item_manage.php?id=<?php echo $id;?>";
</script>
<?php
// end update		
		
		}else{

// $image=''; 	$image2=''; $image3=''; $image4='';	
		
// if($_FILES['image']['name']!=''){
// 	$image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
// 	move_uploaded_file($_FILES['image']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image);
// 	$image_con=",image='$image'";
// }
	
/*if($_FILES['image2']['name']!=''){
	$image2=rand(111111111,999999999).'_'.$_FILES['image2']['name'];
	move_uploaded_file($_FILES['image2']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image2);
	$image_con.=",image2='$image2'";
}
if($_FILES['image3']['name']!=''){
	$image3=rand(111111111,999999999).'_'.$_FILES['image3']['name'];
	move_uploaded_file($_FILES['image3']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image3);
	$image_con.=",image3='$image3'";
}
if($_FILES['image4']['name']!=''){
	$image4=rand(111111111,999999999).'_'.$_FILES['image4']['name'];
	move_uploaded_file($_FILES['image4']['tmp_name'],PRODUCT_IMAGE_SERVER_PATH.$image4);
	$image_con.=",image4='$image4'";
}*/


//$min=number_format($sub_group_id + 1, 0, '.', '');
//$max=number_format($sub_group_id + 10000, 0, '.', '');
//$item_id=number_format(next_value('item_id','item_info','1',$min,$min,$max), 0, '.', '');

$sql_insert="insert ignore into item_info (
sub_group_id,finish_goods_code,item_name,category_id,subcategory_id,unit_name,pack_size,
item_brand,m_price,d_price,t_price,nsp_per,f_price,item_group,consumable_type,product_nature,status) 
values(
'$sub_group_id','$finish_goods_code','$item_name','$category_id','$subcategory_id','$unit_name','$pack_size',
'$item_brand','$m_price','$d_price','$t_price','$nsp_per','$f_price','$item_group','$consumable_type','$product_nature','$status')";
			
mysqli_query($conn,$sql_insert);
}

?>
<script>
//window.location.href = "item_manage.php?id=<?php echo mysqli_insert_id($conn);?>";
window.location.href = "item_manage.php";
</script>
<?php
		//die();
	}
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
<?
if($msg!=''){ echo $msg;}

?>

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


<!-- Main content -->
<section class="content">
<div class="container-fluid">




            
            
			
<div class="card mb-4">
<div class="card-body">


<div class="row">


<form method="post" enctype="multipart/form-data">

  <div class="row">

		<!--start 1st part-->
		<div class="col-md-12 col-xs-12">
		<div class="x_panel">
		<div class="x_content">
		
			
<div class="card-body card-block">



<style>
.form-control:focus {
  border-color: #FF0000;
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 1);
}
   
</style>


<div class="row">

	<div class="form-group col-md-4">
		<label for="" class=" form-control-label">Item Group</label>
		<select class=" form-control border border-info" name="item_group" required id="item_group" onchange="FetchItemCategory(this.value)">
		<? if($_GET['id']>0){ ?>		    
				    <option value="<?php echo $item_group?>"><?=find1("select group_name from product_group where id='".$item_group."'");?></option>
		<? }else{ ?>		    
				    <option></option> 
		<? } ?>		  
				    <?php optionlist("select id,group_name from product_group where 1 order by group_name"); ?>
		</select>
	</div>
	
	<div class="form-group col-md-4">
		<label for="" class=" form-control-label">Item Category</label>
		<select class=" form-control border border-info" name="category_id" id="category_id" onchange="FetchItemSubcategory(this.value)">
		<? if($_GET['id']>0){ ?>		    
				    <option value="<?php echo $category_id?>"><?=find1("select category_name from item_category where id='".$category_id."'");?></option>
		<? }else{ ?>		    
				    <option></option>
		<? } ?>		  
				    <?php optionlist("select id,category_name from item_category where 1 order by category_name"); ?>
		</select>
	</div>	
	
	
	<div class="form-group col-md-4">
		<label for="" class=" form-control-label">Item Sub Category</label>
		<select class=" form-control border border-info" name="subcategory_id" id="subcategory_id">
		<? if($_GET['id']>0){ ?>		    
				    <option value="<?php echo $subcategory_id?>"><?=find1("select subcategory_name from item_subcategory where id='".$subcategory_id."'");?></option>
		<? }else{ ?>		    
				    <option></option>
		<? } ?>		  
				    <?php optionlist("select id,subcategory_name from item_subcategory where 1 order by subcategory_name"); ?>
		</select>
	</div>	
	



</div>

<div class="row">	
	

	<div class="form-group col-md-4">
	<label for="categories" class="form-control-label">Code</label>
<input type="text" name="finish_goods_code" class="form-control border border-info" 
required autofocus value="<?php echo $finish_goods_code?>">
	</div>
				
	
	<div class="form-group col-md-8">
		<label for="categories" class="form-control-label">Item Name</label>
		<input type="text" name="item_name" class="form-control border border-info" required autofocus value="<?php echo $item_name?>">
	</div>					

</div>
		

<div class="row">
	
	


	<div class="form-group col-md-2">
		<label for="unit_name" class=" form-control-label">Unit</label>
	<input type="text" name="unit_name" class="form-control border border-info" value="<?php echo $unit_name?$unit_name:'Pcs'?>">
	</div>
	
	
	<div class="form-group col-md-2">
			<label for="pack_size" class=" form-control-label">Pack Size</label>
			<input type="text" name="pack_size" class="form-control border border-info" value="<?php echo $pack_size?>">
	</div>					

	
	<!--<div class="form-group col-md-4">-->
	<!--	<label for="item_brand" class=" form-control-label">Item Brand</label>-->
	<!--	<select class=" form-control border border-info" name="item_brand">-->
	<!--	<? if($_GET['id']>0){ ?>		    -->
	<!--			    <option value="<?php echo $item_brand?>"><?php echo $item_brand;?></option>-->
	<!--	<? }else{ ?>		    -->
	<!--			    <option value="<?php echo $_SESSION['brand_name'];?>"><?=$_SESSION['brand_name'];?></option> -->
	<!--	<? } ?>		  -->
	<!--			    <?php optionlist("select brand_name,brand_name from item_brand where 1 order by brand_name"); ?>-->
	<!--	</select>-->
	<!--</div>-->
	
	
</div>
		
		
		
<div class="row">							

		
	<div class="form-group col-md-2">
			<label for="m_price" class=" form-control-label">MRP</label>
			<input type="text" name="m_price"  class="form-control border border-info" value="<?php echo $m_price?>">
	</div>	
	
	<div class="form-group col-md-2">
			<label for="d_price" class=" form-control-label">Trade Price(TP)</label>
			<input type="text" name="t_price" class="form-control border border-info" value="<?php echo $t_price?>">
	</div>
	
	<div class="form-group col-md-2">
			<label for="" class=" form-control-label">NSP %</label>
			<input type="text" name="nsp_per" class="form-control border border-info" value="<?php echo $nsp_per?>">
	</div>	
		


	<div class="form-group col-md-2">
		<label for="status" class=" form-control-label">Status</label>
		<select class="form-control border border-info" name="status" required>
				<option value="<?=$status?$status:'Active'?>"><?=$status?$status:'Active'?></option>
				<option>Active</option>
				<option>Inactive</option>
		</select>
	</div>
</div>
										
								
									
										
		</div>
		
		
		</div></div></div>
		<!--end 1st part-->



<!-------------------------start 2nd part-->
<!--<div class="col-md-4 col-xs-4">-->
<!--<div class="x_panel">-->
<!--<div class="x_content">-->

	
<!--<div class="card-body card-block">-->
							   
								
    <!--<div class="form-group">-->
    <!--<img class="product_md_view" src="<?php //echo $image;?>"/>-->
    <!--</div>	-->

						
			<!--<div class="form-group">-->
			<!--	<label for="categories" class=" form-control-label">Image 1</label>-->
			<!--	<input type="file" name="image" class="form-control" <?php echo  $image_required?>>-->
			<!--</div>-->
			

			
			<!--<div class="form-group">-->
			<!--	<label for="categories" class=" form-control-label">Short Description</label>-->
			<!--	<textarea name="short_desc" placeholder="Enter product short description" class="form-control"><?php echo $short_desc?></textarea>-->
			<!--</div>-->

								
								

<!--</div>-->


<!--</div></div></div>-->
<!--end 2nd part-->

  </div>
<div class="row">
<div class="col">

<!--<div class="col-md-12 col-sm-12 col-xs-12">-->
<!--              <div class="x_panel">-->
<!--                <div class="x_title">-->
<!--                  <h2>Product Description</h2>-->

<!--                  <div class="clearfix"></div>-->
<!--                </div>-->
<!--                <div class="x_content">-->
<!--                  <div id="alerts"></div>-->
<!--				  <textarea name="description" id="description"><?php echo $description?></textarea>-->
                  
<!--           </div>-->
<!--    </div>-->
<!--</div>-->




<?php if(isset($_GET['id']) && $_GET['id']!=''){
$submit_button = 'Update';}else{ $submit_button='Submit';}  ?>  

							   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount"><?php echo $submit_button;?></span>
							   </button>
							   
</div>
</div>  


</form>
</div>


</div></div>			








</div>
</section>
</div>
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